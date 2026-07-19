<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\EventRegistrationController;
use App\Http\Controllers\Client\EventController as ClientEventController;
use App\Http\Controllers\Client\FormController;
use App\Http\Controllers\Client\AffiliateController;
use App\Http\Controllers\Admin\AdminEventRegistrationController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\FormBuilderController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FormSubmissionController;
use App\Http\Controllers\Admin\AdminPackageController;
use App\Http\Controllers\Admin\PackageCategoryController;
use App\Http\Controllers\Admin\AdminPackageItineraryController;
use App\Http\Controllers\Admin\AdminPackageGalleryController;
use App\Http\Controllers\Admin\HomePageSlideController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Client\PaymentController as ClientPaymentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Client\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('client.home');
// });

Route::get('/',[HomeController::class, 'index']);
Route::get('/packages',[HomeController::class, 'packages'])->name('packages.index');
Route::get('/packages/{package}', [HomeController::class, 'show'])->name('packages.show');
Route::post('/packages/{package}/submit', [HomeController::class, 'submitPackage'])->name('packages.submit');
Route::get('/payments/{payment}', [ClientPaymentController::class, 'show'])->name('payments.show');
Route::post('/payments/{payment}/checkout', [ClientPaymentController::class, 'checkout'])->name('payments.checkout');
Route::match(['GET', 'POST'], '/payments/{payment}/success', [ClientPaymentController::class, 'success'])->name('payments.success');
Route::match(['GET', 'POST'], '/payments/{payment}/failure', [ClientPaymentController::class, 'failure'])->name('payments.failure');
Route::post('/payments/{payment}/cancel', [ClientPaymentController::class, 'cancel'])->name('payments.cancel');



Route::get('/admin', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});

Route::post('/enquiry', [ContactController::class, 'submit'])->name('enquiry.submit');


// Public
Route::get('/forms/{slug}', [FormController::class, 'show'])->name('forms.show');
Route::post('/forms/{slug}', [FormController::class, 'submit'])->name('forms.submit');

Route::get('/events/{slug}', [ClientEventController::class, 'show'])->name('events.show');
Route::post('/events/{slug}/submit', [ClientEventController::class, 'submit'])->name('events.submit');

Route::get('/events', [ClientEventController::class, 'index'])->name('events.index');
Route::get('/affiliation', [AffiliateController::class, 'index'])->name('affiliate-program');



//Admin Login Routes
Route::prefix('admin')->name('admin.')->group(function(){

    // Route::get('/login',[AdminAuthController::class,'showLoginForm'])->name('login');

    Route::get('/login', function () {
            if (Auth::guard('admin')->check()) {
                return redirect()->route('admin.dashboard');
            }
            return view('admin.login');
        })->name('login');



    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
      Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

});



//Authenticated Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {


    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    //Admin Logout Route
    // Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::resource('event-registrations', AdminEventRegistrationController::class)
        ->only(['index', 'show', 'edit', 'update', 'destroy']);

    Route::post('event-registrations/{event_registration}/confirm', 
        [AdminEventRegistrationController::class, 'confirm'])
        ->name('event-registrations.confirm');



    Route::resource('forms', FormBuilderController::class);

    // Preview route
    Route::get('forms/{form}/preview', [FormBuilderController::class, 'preview'])
        ->name('forms.preview');

    Route::post('/forms/{form}/clone', [FormBuilderController::class, 'clone'])
    ->name('forms.clone');


    Route::resource('events', EventController::class);
    Route::resource('home-page-slides', HomePageSlideController::class)->except(['show']);
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/settings', [AdminPaymentController::class, 'settings'])->name('payments.settings');
    Route::put('payments/settings', [AdminPaymentController::class, 'updateSettings'])->name('payments.settings.update');
    Route::get('payments/reports', [AdminPaymentController::class, 'reports'])->name('payments.reports');
    Route::post('events/editor-image', [EventController::class, 'uploadEditorImage'])
        ->name('events.editor-image');
    Route::post('/submissions/{submission}/confirm', [FormSubmissionController::class, 'confirm'])->name('submissions.confirm');
    Route::get('submissions/export/csv', [FormSubmissionController::class, 'exportCsv'])->name('submissions.export.csv');
    Route::get('submissions/export/excel', [FormSubmissionController::class, 'exportExcel'])->name('submissions.export.excel');

    Route::resource('submissions', FormSubmissionController::class)->only(['index','show','edit','update','destroy']);

    // packages
    Route::resource('packages', AdminPackageController::class);
    Route::resource('package-categories', PackageCategoryController::class)
        ->except(['show', 'create']);

    // Route::get('packages/{package}/itinerary', [AdminPackageItineraryController::class, 'index'])->name('packages.itinerary');
    // Route::post('packages/{package}/itinerary', [AdminPackageItineraryController::class, 'store']);

    Route::post('packages/{package}/gallery', [AdminPackageGalleryController::class, 'store']);
    Route::delete('packages/gallery/{gallery}', [AdminPackageGalleryController::class, 'destroy']);


});
