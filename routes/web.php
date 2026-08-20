<?php

use App\Http\Controllers\Account\BookingController as AccountBookingController;
use App\Http\Controllers\Account\DashboardController as AccountDashboardController;
use App\Http\Controllers\Account\InvoiceController;
use App\Http\Controllers\Account\ProfileController as AccountProfileController;
use App\Http\Controllers\Account\ReviewController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourPackageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)->name('home');

// Tour Packages
Route::get('/tours', [TourPackageController::class, 'index'])->name('tours.index');
Route::get('/tours/{tourPackage}', [TourPackageController::class, 'show'])->name('tours.show');

// Destinations
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blogPost}', [BlogController::class, 'show'])->name('blog.show');

// Gallery & About
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/about', AboutController::class)->name('about');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/contact-page', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

// Route yang HANYA butuh login (tanpa wajib verifikasi email terlebih dahulu)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('account.dashboard');
    })->name('dashboard');

    Route::get('/profile', [AccountProfileController::class, 'edit'])->name('profile.edit');
});

// Route yang WAJIB Login DAN Terverifikasi Email (auth + verified)
Route::middleware(['auth', 'verified'])->group(function () {

    // Booking Process
    Route::get('/booking/{availability}/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/estimate', [BookingController::class, 'estimate'])->name('booking.estimate');
    Route::post('/booking/{availability}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::post('/booking/{booking}/payment', [BookingController::class, 'pay'])->name('booking.pay');
    Route::get('/booking/{booking}/success', [BookingController::class, 'success'])->name('booking.success');

    /*
    |--------------------------------------------------------------------------
    | Customer Account Area
    |--------------------------------------------------------------------------
    */
    Route::prefix('account')
        ->name('account.')
        ->group(function () {

            // Dashboard
            Route::get('/', AccountDashboardController::class)->name('dashboard');

            // Bookings
            Route::get('/bookings', [AccountBookingController::class, 'index'])->name('bookings');
            Route::get('/bookings-list', [AccountBookingController::class, 'index'])->name('bookings.index');
            Route::get('/bookings/{booking}', [AccountBookingController::class, 'show'])->name('bookings.show');
            Route::post('/bookings/{booking}/cancel', [AccountBookingController::class, 'cancel'])->name('bookings.cancel');

            // Invoices
            Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
            Route::get('/invoices-list', [InvoiceController::class, 'index'])->name('invoices.index');
            Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');

            // Profile
            Route::get('/profile', [AccountProfileController::class, 'edit'])->name('profile');
            Route::get('/profile/edit', [AccountProfileController::class, 'edit'])->name('profile.edit');
            
            // DUKUNG METHOD PUT DAN PATCH AGAR FORM PROFILE TIDAK ERROR 405
            Route::match(['put', 'patch'], '/profile', [AccountProfileController::class, 'update'])->name('profile.update');

            // Password
            Route::get('/password', [AccountProfileController::class, 'password'])->name('password');

            // Reviews
            Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
            Route::get('/reviews-list', [ReviewController::class, 'index'])->name('reviews.index');
            Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        });
});

/*
|--------------------------------------------------------------------------
| Breeze Authentication
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';