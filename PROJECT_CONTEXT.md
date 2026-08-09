Project: Travel Agent CMS

Framework:
- Laravel 13
- PHP
- MySQL
- Blade
- Tailwind CSS
- Filament
- Spatie Laravel Permission

Architecture:
- Eloquent ORM
- Service Layer
- Policy-based authorization
- Payment abstraction (PaymentGatewayInterface -> MidtransGateway placeholder, not yet connected to the live API)

Business rules baked into the schema/services:
- Tour package pricing is tiered: adult / child / infant.
- Payments support partial/deposit flows (multiple Payment rows per Booking); Booking.amount_paid
  is the running total, maintained only by PaymentService.
- Currency is single-currency (IDR) throughout; no currency column.

Current progress (as of this review):
- Migrations: fully implemented — all 24 custom tables have real columns, foreign keys,
  indexes, decimal money columns, enum statuses, soft deletes where appropriate.
- Models: fully implemented — fillable, casts, relationships, scopes.
- Factories: fully implemented for all 24 models.
- Seeders: fully implemented, dependency-ordered in DatabaseSeeder (Users/roles -> Destinations
  -> TourPackages (+images/itineraries/inclusions/exclusions/addons/availabilities) -> Hotels
  (+rooms) -> Vehicles -> Customers -> Promotions -> Bookings (via BookingService, also creates
  invoices) -> Payments (via PaymentService) -> Reviews -> Blog -> Galleries -> Inquiries).
- Policies: fully implemented, permission-based (Spatie), with super_admin bypass via
  Gate::before in AppServiceProvider. Booking/Payment/Invoice policies additionally encode
  business rules (e.g. payments can never be deleted, only refunded).
- Services: fully implemented —
  - Booking\BookingPricingService: the ONLY place a booking total is calculated (bcmath,
    server-side, ignores any price sent from a form/frontend).
  - Booking\BookingAvailabilityService: row-locked seat reservation/release.
  - Booking\BookingService: orchestrates pricing + availability + invoice creation in a
    DB transaction.
  - Payment\PaymentService: records manual/deposit payments against the outstanding balance,
    handles refunds. This is the only class allowed to mutate Payment.status/amount/paid_at
    or Booking.amount_paid.
  - Payment\PaymentWebhookService + Gateways\MidtransGateway: scaffolded per the intended
    architecture but NOT wired to a live payment gateway (explicitly out of scope).
  - Invoice\InvoiceService, Customer\CustomerService, Notification\NotificationService,
    Tour\TourPackageService: implemented.
- Filament Admin CMS: fully implemented for all 14 resources (forms, tables, filters,
  relation managers, navigation grouping into Master Data / Transactions / Content / System).
  Payment and Invoice resources are deliberately restricted (no free-form create/edit of
  financial fields) — see their Resource/Policy classes for why.
  Dashboard widgets (StatsOverview, BookingChart, RevenueChart, RecentBookings, UpcomingTrips)
  and the Settings page (key/value store via the Setting model) are implemented.

Verification performed in this pass:
- `php -l` syntax-checked on every PHP file in app/ and database/ (all pass).
- PSR-4 namespace/path consistency checked programmatically (all pass).
- Every `App\...` `use` import checked against actual class files (all resolve).
- NOT executed: `composer install`, `php artisan migrate:fresh --seed`, `php artisan test`.
  This review environment has no Composer/Packagist network access, so these must be run
  locally before deploying.

Known follow-ups (see final report for full list):
- Public website, Midtrans live integration, payment webhook handling, production
  email/WhatsApp notifications, and deployment remain out of scope, as instructed.
- Editing a confirmed booking's participants/addons (which would require re-pricing and
  seat re-allocation) is intentionally not supported yet — only status/notes are editable
  after creation. Cancelling and rebooking is the current supported path.


Role	Email	Password
Super Admin	superadmin@travelagent.test	password
Admin	admin@travelagent.test	password
Sales Staff	sales@travelagent.test	password
Finance Staff	finance@travelagent.test	password
Content Manager	content@travelagent.test	password