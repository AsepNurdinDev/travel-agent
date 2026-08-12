<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Handles the customer-facing profile fields that live on Customer
 * (phone/address/identity_number/date_of_birth). Name/email + password
 * for the underlying User account are still handled by the existing
 * Breeze ProfileController / PasswordController at /profile and
 * PUT /password — this controller intentionally does not duplicate that.
 */
class ProfileController extends Controller
{
    public function edit(): View
    {
        $customer = Auth::user()->customer;

        return view('account.profile', compact('customer'));
    }

    public function update(Request $request): RedirectResponse
    {
        $customer = Auth::user()->customer;

        abort_unless($customer, 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'identity_number' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
        ]);

        $customer->update($data);

        return back()->with('success', 'Your profile has been updated.');
    }

    public function password(): View
    {
        return view('account.password');
    }
}
