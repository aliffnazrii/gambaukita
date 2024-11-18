<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PackageImageController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\ClientMiddleware;


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// STOCK ROUTE (STORE, CREATE, EDIT, DESTROY, INDEX, SHOW)
Route::resource('packages', PackageController::class);
Route::resource('bookings', BookingController::class)->middleware('clientLogin');
Route::resource('payments', PaymentController::class)->middleware('clientLogin');
Route::resource('invoices', InvoiceController::class)->middleware('clientLogin');
Route::resource('package-images', PackageImageController::class);
Route::resource('schedules', ScheduleController::class)->middleware('CheckUserRole');
Route::resource('portfolios', PortfolioController::class);
Route::resource('users', UserController::class);



// CUSTOM CLIENT ROUTE

Route::get('/', function () {
    return view('client.home');
});
Route::get('/about', function () {
    return view('client.about');
});

#UPDATE PROFILE PICTURE
Route::put('/users/update-picture/{id}', [UserController::class, 'updateProfilePicture'])->middleware('clientLogin');


Route::post('/checkdate', [BookingController::class, 'checkdate'])->name('booking.checkdate')->middleware('clientLogin');
Route::get('/invoice/{id}', [BookingController::class, 'showInvoice'])->name('booking.showInvoice')->middleware('clientLogin');

#PAYMENT GATEWAYY
Route::get('/payment-success/{bookingId}', [BookingController::class, 'paymentSuccess'])->name('payment.success')->middleware('clientLogin');
Route::get('/booking/{booking_id}/payment', [PaymentController::class, 'processBookingPayment'])->name('booking.payment')->middleware('clientLogin');







// OWNER CUSTOM ROUTE

Route::get('/owner/dashboard', [UserController::class, 'dashboard'])->name('owner.dashboard')->middleware('ownerLogin');
Route::get('/owner/profile', [UserController::class, 'ownerProfile'])->name('owner.profile')->middleware('ownerLogin');
Route::get('/owner/schedule', [ScheduleController::class, 'ownerSchedule'])->name('owner.schedule')->middleware('ownerLogin');
Route::get('/owner/events', [ScheduleController::class, 'getEvents'])->name('owner.getEvents')->middleware('ownerLogin');

Route::post('/upload-package', [PackageController::class, 'uploadPackageImage'])->name('packages.uploadImage')->middleware('ownerLogin');

#portfolios management route
Route::get('/owner/portfolios', [PortfolioController::class, 'ownerPortfolio'])->name('owner.portfolio')->middleware('ownerLogin');
Route::delete('/owner/portfolios/delete/{id}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy')->middleware('ownerLogin');


#booking management route
Route::get('/owner/bookings', [BookingController::class, 'ownerindex'])->name('owner.booking')->middleware('ownerLogin');


#pakages management route

Route::get('/owner/packages', [PackageController::class, 'ownerPackage'])->name('owner.package')->middleware('ownerLogin');
Route::get('/owner/packages/open/{id}', [PackageController::class, 'ownerPackageView'])->name('package.view')->middleware('ownerLogin');



#EXPERIMENT ROUTE

Route::get('/datepicker', function () {
    return view('owner.datepicker');
})->name('packages.uploadImage');
Route::get('/cropper', function () {
    return view('client.crop');
});

// Route::get('/payment-test', function () {
//     return view('payment');
// })->name('payment.test');
