<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Promotion;
use App\Models\TourPackageAvailability;
use App\Services\Booking\BookingPricingService;
use App\Services\Booking\BookingService;
use App\Services\Customer\CustomerService;
use App\Services\Payment\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RuntimeException;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingPricingService $pricingService,
        private readonly BookingService $bookingService,
        private readonly PaymentService $paymentService,
        private readonly CustomerService $customerService,
    ) {
    }

    /**
     * Step 1-5: the booking builder (trip, participants, customer, add-ons, review).
     */
    public function create(TourPackageAvailability $availability): View
    {
        $availability->load(['tourPackage.destination', 'tourPackage.addons' => fn ($q) => $q->where('is_active', true)]);

        abort_unless($availability->tourPackage->is_active, 404);
        abort_if($availability->status !== 'open', 404, 'This departure is no longer open for booking.');

        $customer = $this->currentCustomer();

        return view('booking.index', [
            'availability' => $availability,
            'tourPackage' => $availability->tourPackage,
            'customer' => $customer,
        ]);
    }

    /**
     * AJAX: live price estimate. Always recomputed server-side via
     * BookingPricingService — the frontend never calculates a total itself.
     */
    public function estimate(Request $request): JsonResponse
    {
        $data = $request->validate([
            'availability_id' => ['required', 'integer', 'exists:tour_package_availabilities,id'],
            'adult_count' => ['required', 'integer', 'min:0'],
            'child_count' => ['required', 'integer', 'min:0'],
            'infant_count' => ['required', 'integer', 'min:0'],
            'addons' => ['array'],
            'addons.*.addon_id' => ['required', 'integer'],
            'addons.*.quantity' => ['required', 'integer', 'min:1'],
            'promo_code' => ['nullable', 'string'],
        ]);

        $availability = TourPackageAvailability::query()->with('tourPackage')->findOrFail($data['availability_id']);

        $promotion = null;
        $promoMessage = null;

        if (! empty($data['promo_code'])) {
            $promotion = Promotion::query()->where('code', $data['promo_code'])->first();

            if (! $promotion) {
                $promoMessage = ['type' => 'invalid', 'text' => 'Promo code not found.'];
            } elseif (! $promotion->isCurrentlyValid()) {
                $promoMessage = ['type' => 'expired', 'text' => 'This promo code is no longer valid.'];
                $promotion = null;
            }
        }

        try {
            $pricing = $this->pricingService->calculate(
                $availability,
                (int) $data['adult_count'],
                (int) $data['child_count'],
                (int) $data['infant_count'],
                $data['addons'] ?? [],
                $promotion,
            );
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        if ($promotion && $pricing['discount_amount'] === '0.00' && $promotion->min_purchase) {
            $promoMessage = [
                'type' => 'invalid',
                'text' => 'This promo requires a minimum purchase of Rp '.number_format((float) $promotion->min_purchase, 0, ',', '.').'.',
            ];
        } elseif ($promotion && $pricing['discount_amount'] !== '0.00') {
            $promoMessage = ['type' => 'applied', 'text' => 'Promo applied — you saved Rp '.number_format((float) $pricing['discount_amount'], 0, ',', '.').'!'];
        }

        return response()->json([
            'pricing' => $pricing,
            'remaining_quota' => $availability->remaining_quota,
            'promo' => $promoMessage,
        ]);
    }

    /**
     * Step 6: create the booking. Pricing, availability and promotion are
     * all re-validated server-side inside BookingService — nothing here is
     * trusted from the client except *selections* (who/what/how many).
     */
    public function store(Request $request, TourPackageAvailability $availability): RedirectResponse
    {
        $data = $request->validate([
            'adult_count' => ['required', 'integer', 'min:0'],
            'child_count' => ['required', 'integer', 'min:0'],
            'infant_count' => ['required', 'integer', 'min:0'],
            'addons' => ['array'],
            'addons.*.addon_id' => ['required', 'integer'],
            'addons.*.quantity' => ['required', 'integer', 'min:1'],
            'promo_code' => ['nullable', 'string'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'identity_number' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'terms' => ['accepted'],
        ]);

        if (($data['adult_count'] + $data['child_count'] + $data['infant_count']) < 1) {
            throw ValidationException::withMessages(['adult_count' => 'Please select at least one participant.']);
        }

        $promotion = null;
        if (! empty($data['promo_code'])) {
            $promotion = Promotion::query()->where('code', $data['promo_code'])->first();
            if (! $promotion || ! $promotion->isCurrentlyValid()) {
                $promotion = null;
            }
        }

        // Keep the customer profile in sync with whatever they typed on this form.
        $customer = $this->customerService->findOrCreateByEmail([
            'name' => $data['name'],
            'email' => Auth::user()->email,
            'phone' => $data['phone'],
            'address' => $data['address'] ?? null,
            'identity_number' => $data['identity_number'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'user_id' => Auth::id(),
        ]);

        $customer->fill([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'] ?? $customer->address,
            'identity_number' => $data['identity_number'] ?? $customer->identity_number,
            'date_of_birth' => $data['date_of_birth'] ?? $customer->date_of_birth,
        ])->save();

        try {
            $booking = $this->bookingService->createBooking(
                customer: $customer,
                availability: $availability,
                adultCount: (int) $data['adult_count'],
                childCount: (int) $data['child_count'],
                infantCount: (int) $data['infant_count'],
                addons: $data['addons'] ?? [],
                promotion: $promotion,
                notes: $data['notes'] ?? null,
                createdBy: Auth::id(),
            );
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('booking.checkout', $booking)
            ->with('success', 'Booking created! Complete your payment to confirm your seat.');
    }

    public function checkout(Booking $booking): View
    {
        $this->authorizeOwnership($booking);

        $booking->load(['tourPackage.destination', 'availability', 'items', 'payments', 'invoice']);

        return view('booking.checkout', compact('booking'));
    }

    /**
     * Record a payment against the booking.
     *
     * NOTE — Midtrans integration point: per project scope, this does not
     * call a live payment gateway. It records the payment the same way
     * finance staff would confirm a manual bank transfer, via the existing
     * authoritative PaymentService (amount is always validated against the
     * real outstanding balance server-side — see PaymentService::recordManualPayment).
     * When Midtrans is wired up, this action should instead create a
     * pending Payment + redirect to the gateway, and PaymentWebhookService
     * would call PaymentService on the callback.
     */
    public function pay(Request $request, Booking $booking): RedirectResponse
    {
        $this->authorizeOwnership($booking);

        $data = $request->validate([
            'payment_type' => ['required', 'in:deposit,full'],
            'method' => ['required', 'in:bank_transfer,credit_card,e_wallet'],
        ]);

        $balanceDue = (float) $booking->balance_due;

        if ($balanceDue <= 0) {
            return redirect()->route('booking.success', $booking);
        }

        $amount = $data['payment_type'] === 'full'
            ? $balanceDue
            : round(max($balanceDue * 0.3, min($balanceDue, 100000)), 2);

        try {
            $this->paymentService->recordManualPayment(
                booking: $booking,
                amount: $amount,
                method: $data['method'],
            );
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('booking.success', $booking->fresh());
    }

    public function success(Booking $booking): View
    {
        $this->authorizeOwnership($booking);

        $booking->load(['tourPackage.destination', 'availability', 'payments', 'invoice']);

        return view('booking.success', compact('booking'));
    }

    private function currentCustomer()
    {
        return Auth::user()->customer;
    }

    private function authorizeOwnership(Booking $booking): void
    {
        $customer = $this->currentCustomer();

        abort_if(! $customer || $booking->customer_id !== $customer->id, 403);
    }
}
