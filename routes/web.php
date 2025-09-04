<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Impersonate;
use App\Http\Controllers\OpenAiController;
use App\Http\Controllers\SiteController;
use App\Livewire\Frontend\BlogDetails;
use App\Livewire\Frontend\Blogs;
use App\Livewire\Frontend\Checkout;
use App\Livewire\Frontend\ThankYou;
use App\Livewire\Pages\Common\Bookings\UserBooking;
use App\Livewire\Pages\Common\Dispute\Dispute;
use App\Livewire\Pages\Common\Dispute\ManageDispute;
use App\Livewire\Pages\Common\ProfileSettings\AccountSettings;
use App\Livewire\Pages\Common\ProfileSettings\IdentityVerification;
use App\Livewire\Pages\Common\ProfileSettings\PersonalDetails;
use App\Livewire\Pages\Common\ProfileSettings\Resume;
use App\Livewire\Pages\Student\BillingDetail\BillingDetail;
use App\Livewire\Pages\Student\CertificateList;
use App\Livewire\Pages\Student\Favourite\Favourites;
use App\Livewire\Pages\Student\Invoices;
use App\Livewire\Pages\Student\RescheduleSession;
use App\Livewire\Pages\Tutor\ManageAccount\ManageAccount;
use App\Livewire\Pages\Tutor\ManageSessions\ManageSubjects;
use App\Livewire\Pages\Tutor\ManageSessions\MyCalendar;
use App\Livewire\Pages\Tutor\ManageSessions\SessionDetail;
use App\Livewire\Payouts;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SslCommerzPaymentController;


Route::get('auth/{provider}', [SocialController::class, 'redirect'])->name('social.redirect');
Route::get('auth/{provider}/callback', [SocialController::class, 'callback'])->name('social.callback');
Route::view('language-translator', 'language-translator');

Route::middleware(['locale', 'maintenance'])->group(function () {
    Route::get('find-tutors', [SearchController::class, 'findTutors'])->name('find-tutors');
    Route::get('/blogs', Blogs::class)->name('blogs');
    Route::get('/blog/{slug}', BlogDetails::class)->name('blog-details');

    Route::middleware(['auth', 'verified', 'onlineUser'])->group(function () {
        Route::post('/openai/submit', [OpenAiController::class, 'submit'])->name('openai.submit');
        Route::post('favourite-tutor', [SearchController::class, 'favouriteTutor'])->name('favourite-tutor');
        Route::get('logout', [SiteController::class, 'logout'])->name('logout');
        Route::post('switch-role', [SiteController::class, 'switchRole'])->name('switch-role');
        Route::get('user/identity-confirmation/{id}', [PersonalDetails::class, 'confirmParentVerification'])->name('confirm-identity');
        Route::get('google/callback', [SiteController::class, 'getGoogleToken']);
        Route::middleware('role:tutor|student')->get('checkout', Checkout::class)->name('checkout');
        Route::middleware('role:tutor|student')->get('thank-you/{id}', ThankYou::class)->name('thank-you');

        Route::middleware('role:tutor')->prefix('tutor')->name('tutor.')->group(function () {
            Route::get('dashboard', ManageAccount::class)->name('dashboard');
            Route::get('payouts', Payouts::class)->name('payouts');
            Route::get('profile', fn() => redirect('tutor.profile.personal-details'))->name('profile');

            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('personal-details', PersonalDetails::class)->name('personal-details');
                Route::get('account-settings',  AccountSettings::class)->name('account-settings');
                Route::prefix('resume')->name('resume.')->group(function () {
                    Route::get('education', Resume::class)->name('education');
                    Route::get('experience', Resume::class)->name('experience');
                    Route::get('certificate', Resume::class)->name('certificate');
                });
                Route::get('identification', IdentityVerification::class)->name('identification');
            });
            Route::prefix('bookings')->name('bookings.')->group(function () {
                Route::get('manage-subjects',       ManageSubjects::class)->name('subjects');
                Route::get('manage-sessions',       MyCalendar::class)->name('manage-sessions');
                Route::get('session-detail/{date}', SessionDetail::class)->name('session-detail');
                Route::get('upcoming-bookings',     UserBooking::class)->name('upcoming-bookings');
            });
            Route::get('invoices', Invoices::class)->name('invoices');
            Route::get('disputes', Dispute::class)->name('disputes');
            Route::get('manage-dispute/{id}', ManageDispute::class)->name('manage-dispute');
        });

        Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
            Route::get('profile', fn() => redirect('tutor.profile.personal-details'))->name('profile');
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('personal-details', PersonalDetails::class)->name('personal-details');
                Route::get('account-settings',  AccountSettings::class)->name('account-settings');
                Route::get('identification', IdentityVerification::class)->name('identification');
            });
            Route::get('bookings', UserBooking::class)->name('bookings');
            Route::get('invoices', Invoices::class)->name('invoices');
            Route::get('billing-detail', BillingDetail::class)->name('billing-detail');
            Route::get('favourites', Favourites::class)->name('favourites');
            Route::get('reschedule-session/{id}', RescheduleSession::class)->name('reschedule-session');
            Route::get('complete-booking/{id}', [SiteController::class, 'completeBooking'])->name('complete-booking');
            Route::get('certificates', CertificateList::class)->name('certificate-list');
            Route::get('disputes', Dispute::class)->name('disputes');
            Route::get('manage-dispute/{id}', ManageDispute::class)->name('manage-dispute');
        });
    });



    // SSLCOMMERZ Start
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout'])->name('example2');

Route::post('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


    Route::post('/remove-cart', [SiteController::class, 'removeCart']);

    Route::get('tutor/{slug}', [SearchController::class, 'tutorDetail'])->name('tutor-detail');
    Route::get('{gateway}/process/payment', [SiteController::class, 'processPayment'])->name('payment.process');
    Route::get('checkout/cancel',            fn() => redirect()->route('invoices')->with('payment_cancel', __('general.payment_cancelled_desc')))->name('checkout.cancel');
    Route::post('payfast/webhook',          [SiteController::class, 'payfastWebhook'])->name('payfast.webhook');
    Route::post('payment/success',          [SiteController::class, 'paymentSuccess'])->name('post.success');
    Route::get('payment/success',           [SiteController::class, 'paymentSuccess'])->name('get.success');
    Route::post('switch-lang',              [SiteController::class, 'switchLang'])->name('switch-lang');
    Route::post('switch-currency',          [SiteController::class, 'switchCurrency'])->name('switch-currency');
    Route::get('exit-impersonate',          [Impersonate::class, 'exitImpersonate'])->name('exit-impersonate');
    Route::get('pay/{id}',                  [SiteController::class, 'preparePayment'])->name('pay');
    Route::get('session/{id}',              [SiteController::class, 'sessionDetail'])->name('session-detail');
    Route::post('book-session',             [SiteController::class, 'bookSession'])->name('book-session');

    require __DIR__ . '/auth.php';
    require __DIR__ . '/admin.php';
    require __DIR__ . '/optionbuilder.php';
    if (!request()->is('api/*')) {
        require __DIR__ . '/pagebuilder.php';
    }
});
