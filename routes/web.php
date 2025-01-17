<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PackageImageController;
use App\Http\Controllers\ScheduleController;
// use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\ClientMiddleware;

use App\Models\Package; 
use App\Models\PackageImage;


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// STOCK ROUTE (STORE, CREATE, EDIT, DESTROY, INDEX, SHOW)
Route::resource('packages', PackageController::class);
Route::resource('bookings', BookingController::class)->middleware('clientLogin');
Route::resource('payments', PaymentController::class)->middleware('clientLogin');
Route::resource('invoices', InvoiceController::class)->middleware('clientLogin');
Route::resource('package-images', PackageImageController::class)->middleware('ownerLogin');
Route::resource('schedules', ScheduleController::class)->middleware('ownerLogin');
// Route::resource('portfolios', PortfolioController::class);
Route::resource('users', UserController::class);



// CUSTOM CLIENT ROUTE

Route::get('/', function () {

    $packs = Package::with('images')->where('status', 'Active')->limit(3)->get();
    return view('client.home', compact('packs'));
    // return view('client.home');
});
Route::get('/about', function () {
    return view('client.about');
});
Route::put('/client/updatePassword/{user}', [UserController::class, 'updatePassword'])->name('client.updatePassword')->middleware('clientLogin');

Route::get('/packages/view/{id}',[PackageController::class, 'viewPackage'])->name('packages.view');




#UPDATE PROFILE PICTURE
Route::put('/users/update-picture/{id}', [UserController::class, 'updateProfilePicture'])->name('update.picture')->middleware('clientLogin');


Route::post('/checkdate', [BookingController::class, 'checkdate'])->name('booking.checkdate')->middleware('clientLogin');
Route::get('/invoice/{id}', [BookingController::class, 'showInvoice'])->name('booking.showInvoice')->middleware('clientLogin');
Route::get('/receipt/{id}', [BookingController::class, 'showReceipt'])->name('booking.showReceipt')->middleware('clientLogin');

#PAYMENT GATEWAYY
Route::get('/payment-success/{bookingId}', [BookingController::class, 'paymentSuccess'])->name('payment.success')->middleware('clientLogin');


Route::get('/booking/{booking_id}/payment', [PaymentController::class, 'processBookingPayment'])->name('booking.payment')->middleware('clientLogin');







// OWNER CUSTOM ROUTE

Route::get('/owner/dashboard', [UserController::class, 'dashboard'])->name('owner.dashboard')->middleware('ownerLogin');
Route::get('/owner/profile', [UserController::class, 'ownerProfile'])->name('owner.profile')->middleware('ownerLogin');
Route::get('/owner/schedule', [ScheduleController::class, 'ownerSchedule'])->name('owner.schedule')->middleware('ownerLogin');
Route::get('/owner/events', [ScheduleController::class, 'getEvents'])->name('owner.getEvents')->middleware('ownerLogin');
Route::put('/owner/updateProfile/{user}', [UserController::class, 'updateOwner'])->name('owner.update')->middleware('ownerLogin');
Route::put('/owner/updatePassword/{user}', [UserController::class, 'updatePassword'])->name('owner.updatePassword')->middleware('ownerLogin');

Route::post('/upload-package', [PackageController::class, 'uploadPackageImage'])->name('packages.uploadImage')->middleware('ownerLogin');

#portfolios management route
// Route::get('/owner/portfolios', [PortfolioController::class, 'ownerPortfolio'])->name('owner.portfolio')->middleware('ownerLogin');
// Route::delete('/owner/portfolios/delete/{id}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy')->middleware('ownerLogin');


#booking management route
Route::get('/owner/bookings', [BookingController::class, 'ownerindex'])->name('owner.booking')->middleware('ownerLogin');


#pakages management route

Route::get('/owner/packages', [PackageController::class, 'ownerPackage'])->name('owner.package')->middleware('ownerLogin');
Route::get('/owner/packages/open/{id}', [PackageController::class, 'ownerPackageView'])->name('package.view')->middleware('ownerLogin');

#view clients route
Route::get('owner/view-clients', [UserController::class, 'viewClients'])->name('owner.viewClients')->middleware('ownerLogin');


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
