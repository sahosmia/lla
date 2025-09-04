<?php

use App\Http\Controllers\Admin\GeneralController;
use App\Livewire\Pages\Admin\Blogs\BlogCategories;
use App\Livewire\Pages\Admin\Blogs\Blogs;
use App\Livewire\Pages\Admin\Blogs\CreateBlog;
use App\Livewire\Pages\Admin\Blogs\UpdateBlog;
use App\Livewire\Pages\Admin\Bookings\Bookings;
use App\Livewire\Pages\Admin\Dispute\Dispute;
use App\Livewire\Pages\Admin\Dispute\ManageDispute;
use App\Livewire\Pages\Admin\EmailTemplates\EmailTemplates;
use App\Livewire\Pages\Admin\IdentityVerification\IdentityVerification;
use App\Livewire\Pages\Admin\Reviews\Reviews;
use App\Livewire\Pages\Admin\Insights\Insights;
use App\Http\Controllers\SiteController;
use App\Livewire\Pages\Admin\Invoices\Invoices;
use App\Livewire\Pages\Admin\ManageAdminUsers\ManageAdminUsers;
use App\Livewire\Pages\Admin\Menu\ManageMenu;
use App\Livewire\Pages\Admin\NotificationTemplates\NotificationTemplates;
use App\Livewire\Pages\Admin\Packages\ManagePackages;
use App\Livewire\Pages\Admin\Packages\InstalledPackages;
use App\Livewire\Pages\Admin\Payments\CommissionSettings;
use App\Livewire\Pages\Admin\Payments\PaymentMethods;
use App\Livewire\Pages\Admin\Payments\WithdrawRequest;
use App\Livewire\Pages\Admin\Profile\AdminProfile;
use App\Livewire\Pages\Admin\LanguageTranslator\LanguageTranslator;
use App\Livewire\Pages\Admin\Taxonomy\Languages;
use App\Livewire\Pages\Admin\Taxonomy\SubjectGroups;
use App\Livewire\Pages\Admin\Taxonomy\Subjects;
use App\Livewire\Pages\Admin\Upgrade\Upgrade;
use App\Livewire\Pages\Admin\Users\Users;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin|sub_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/insights', Insights::class)->name('insights')->middleware('permit-of:can-manage-insights');

    Route::get('/profile', AdminProfile::class)->name('profile');
    Route::get('/manage-menus', ManageMenu::class)->name('manage-menus')->middleware('permit-of:can-manage-menu');
    Route::get('/blogs', Blogs::class)->name('blog-listing')->middleware('permit-of:can-manage-all-blogs');
    Route::get('/blogs/create', CreateBlog::class)->name('create-blog')->middleware('permit-of:can-manage-create-blogs');
    Route::get('/blogs/update/{id}', UpdateBlog::class)->name('update-blog')->middleware('permit-of:can-manage-update-blogs');
    Route::get('/blog-categories', BlogCategories::class)->name('blog-categories')->middleware('permit-of:can-manage-blog-categories');
    Route::get('language-translator', LanguageTranslator::class)->name('language-translator')->middleware('permit-of:can-manage-language-translations');
    Route::prefix('taxonomies')->name('taxonomy.')->group(function () {
        Route::get('languages', Languages::class)->name('languages')->middleware('permit-of:can-manage-languages');
        Route::get('subjects', Subjects::class)->name('subjects')->middleware('permit-of:can-manage-subjects');
        Route::get('subject-groups', SubjectGroups::class)->name('subject-groups')->middleware('permit-of:can-manage-subject-groups');
    });
    Route::get('commission-settings',   CommissionSettings::class)->name('commission-settings')->middleware('permit-of:can-manage-commission-settings');
    Route::get('payment-methods',       PaymentMethods::class)->name('payment-methods')->middleware('permit-of:can-manage-payment-methods');
    Route::get('withdraw-requests',     WithdrawRequest::class)->name('withdraw-requests')->middleware('permit-of:can-manage-withdraw-requests');

    Route::get('manage-admin-users',          ManageAdminUsers::class)->name('manage-admin-users')->middleware('permit-of:can-manage-admin-users');
    Route::get('users',          Users::class)->name('users')->middleware('permit-of:can-manage-users');
    Route::get('identity-verification',          IdentityVerification::class)->name('identity-verification')->middleware('permit-of:can-manage-identity-verification');
    Route::get('reviews',           Reviews::class)->name('reviews')->middleware('permit-of:can-manage-reviews');
    Route::get('bookings',          Bookings::class)->name('bookings')->middleware('permit-of:can-manage-bookings');
    Route::get('invoices',          Invoices::class)->name('invoices')->middleware('permit-of:can-manage-invoices');
    Route::get('email-settings',    EmailTemplates::class)->name('email-settings')->middleware('permit-of:can-manage-email-settings');
    Route::get('notification-settings', NotificationTemplates::class)->name('notification-settings')->middleware('permit-of:can-manage-notification-settings');
    Route::get('upgrade', Upgrade::class)->name('upgrade')->middleware('permit-of:can-manage-upgrade');
    Route::post('update-sass-style',    [App\Http\Controllers\Admin\GeneralController::class, 'updateSaas'])->middleware('permit-of:can-manage-option-builder');
    Route::middleware('permit-of:can-manage-addons')->prefix('packages')->as('packages.')->group(function () {
        Route::get('/', ManagePackages::class)->name('index');
        Route::get('installed', InstalledPackages::class)->name('installed');
        Route::post('upload', [GeneralController::class, 'uploadAddon'])->name('upload');
    });
    Route::get('disputes', Dispute::class)->name('disputes')->middleware('permit-of:can-manage-disputes-list');
    Route::get('manage-dispute/{id}', ManageDispute::class)->name('manage-dispute')->middleware('permit-of:can-manage-dispute');
    Route::get('clear-cache', [GeneralController::class, 'clearCache'])->name('clear-cache');
    Route::get('check-queue', [GeneralController::class, 'checkQueue'])->name('check-queue');

    Route::post('update-smtp-settings', [GeneralController::class, 'updateSMTPSettings'])->name('update-smtp-settings')->middleware('permit-of:can-manage-option-builder');
    Route::post('update-broadcasting-settings', [GeneralController::class, 'updateBroadcastingSettings'])->name('update-broadcasting-settings')->middleware('permit-of:can-manage-option-builder');
    Route::post('update-pusher-settings', [GeneralController::class, 'updatePusherSettings'])->name('update-pusher-settings')->middleware('permit-of:can-manage-option-builder');
    Route::post('update-reverb-settings', [GeneralController::class, 'updateReverbSettings'])->name('update-reverb-settings')->middleware('permit-of:can-manage-option-builder');
    Route::post('update-social-login-settings', [GeneralController::class, 'updateSocialLoginSettings'])->name('update-social-login-settings')->middleware('permit-of:can-manage-option-builder');
});
Route::get('download-invoice/{id}', [SiteController::class, 'downloadPDF'])->name('download.invoice');

