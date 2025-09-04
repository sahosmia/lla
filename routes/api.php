<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BillingDetailController;
use App\Http\Controllers\Api\TaxonomiesController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CertificationController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\AccountSettingController;
use App\Http\Controllers\Api\FavouriteTutorController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\OptionBuilderController;
use App\Http\Controllers\Api\IdentityController;
use App\Http\Controllers\Api\CartController;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PayoutController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TutorController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login',                                            [AuthController::class,'login']);
Route::post('social-login',                                     [AuthController::class,'socialLogin']);
Route::post('social-profile',                                   [AuthController::class,'createSocialProfile']);
Route::post('register',                                         [AuthController::class,'register']);
Route::post('forget-password',                                  [AuthController::class,'resetEmailPassword']);
Route::get('recommended-tutors',                                [TutorController::class,'getRecommendedTutors']);
Route::get('find-tutors',                                       [TutorController::class,'findTutots']);
Route::get('tutor/{slug}',                                      [TutorController::class,'getTutorDetail']);
Route::get('student-reviews/{id}',                              [StudentController::class,'getStudentReviews']);
Route::get('tutor-available-slots',                             [TutorController::class,'getTutorAvailableSlots']);
Route::get('slot-detail/{id}',                                  [TutorController::class,'slotDetail']);

Route::apiResource('tutor-education',                           EducationController::class)->only(['show','store','update','destroy']);
Route::apiResource('tutor-experience',                          ExperienceController::class)->only(['show','store','update','destroy']);
Route::apiResource('tutor-certification',                       CertificationController::class)->only(['show','store','destroy']);

Route::get('countries',                                     [TaxonomiesController::class,'getCountries']);
Route::get('languages',                                     [TaxonomiesController::class,'getLanguages']);
Route::get('states',                                        [TaxonomiesController::class,'getStates']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('upcoming-bookings',                             [BookingController::class,'getUpComingBooking']);
    Route::post('tutor-certification/{id}',                     [CertificationController::class,'update']);
    Route::post('reset-password',                               [AuthController::class,'resetPassword']);
    Route::post('update-password/{id}',                         [AccountSettingController::class,'updatePassword']);
    Route::post('timezone/{id}',                                [AccountSettingController::class,'updateTimezone']);
    Route::get('timezone/{id}',                                 [AccountSettingController::class,'getTimezone']);
    Route::post('send-message/{recipientId}',                   [StudentController::class,'sendMessage']);
    Route::get('resend-email',                                  [AuthController::class,'resendEmail']);
    Route::post('logout',                                       [AuthController::class,'logout']);
    Route::apiResource('favourite-tutors',                      FavouriteTutorController::class)->only('index', 'update');
    Route::post('profile-settings/{id}',                        [ProfileController::class,'updateProfile']);
    Route::get('profile-settings/{id}',                         [ProfileController::class,'getProfile']);

    Route::apiResource('identity-verification',                 IdentityController::class)->only(['show','destroy','store']);
    Route::get('invoices',                                      [InvoiceController::class,'getInvoices']);
    Route::apiResource('billing-detail',                        BillingDetailController::class)->only(['show', 'update','store']);
    
    Route::get('tutor-payouts/{id}',                            [PayoutController::class,'getPayoutHistory']);
    Route::get('my-earning/{id}',                               [PayoutController::class,'getEarning']);
    Route::get('earning-detail',                                [PayoutController::class,'getEarningDetail']);
    Route::post('user-withdrawal',                              [PayoutController::class,'userWithdrawal']);
    Route::get('payout-status',                                 [PayoutController::class,'getPayoutStatus']);
    Route::post('payout-status',                                [PayoutController::class,'updateStatus']);
    Route::post('payout-method',                                [PayoutController::class,'addPayoutMethod']);
    Route::Delete('payout-method',                              [PayoutController::class,'removePayoutMethod']);
    Route::apiResource('booking-cart',                          CartController::class);
    Route::post('checkout',                                     [CheckoutController::class,'addCheckoutDetails']);

    Route::post('complete-booking/{id}',                        [BookingController::class, 'completeBooking']);
    Route::post('book-free-slot',                               [BookingController::class, 'bookFreeSlot']);
    Route::post('dispute/{id}',                                 [BookingController::class, 'createDispute']);
    Route::get('dispute-listing',                               [BookingController::class, 'getDisputes']);
    Route::get('dispute-detail/{id}',                           [BookingController::class, 'getDispute']);
    Route::get('dispute-discussion/{id}',                       [BookingController::class, 'getDisputeDiscussion']);
    Route::post('dispute-reply/{id}',                           [BookingController::class, 'addDisputeReply']);
    Route::post('review/{id}',                                  [BookingController::class, 'addReview']);

    Route::get('notifications',                                [NotificationController::class, 'index']);
    Route::post('notifications/{id}/read',                     [NotificationController::class, 'markAsRead']);
    Route::post('notifications/read-all',                      [NotificationController::class, 'markAllAsRead']);
});

Route::get('country-states',                                    [TutorController::class,'getStates']);
Route::get('subject-groups',                                   [BookingController::class,'getSubjectGroups']);
Route::get('subjects',                                         [BookingController::class,'getSubjects']);

Route::get('settings',                                         [OptionBuilderController::class, 'getOpSettings']);
Route::fallback(function () {
    return response()->json([
        'message' => __('general.api_url_not_found'),
    ], Response::HTTP_NOT_FOUND);
});
