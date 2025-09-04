<?php

use Illuminate\Support\Facades\Route;
use Modules\Courses\Http\Controllers\Api\CartController;
use Modules\Courses\Http\Controllers\Api\CoursesController;

Route::get('courses',                     [CoursesController::class, 'getCourses']);
Route::get('categories',                  [CoursesController::class, 'getCategories']);
Route::get('languages',                   [CoursesController::class, 'getLanguages']);
Route::get('levels',                      [CoursesController::class, 'getLevels']);
Route::get('prices',                      [CoursesController::class, 'getPrices']);
Route::get('ratings',                     [CoursesController::class, 'getRatings']);
Route::get('duration-counts',             [CoursesController::class, 'getDurationCounts']);
Route::get('course-detail/{slug}',        [CoursesController::class, 'getCourseDetail'])->name('course-detail');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('like-course/{id}',           [CoursesController::class, 'likeCourse']);
    Route::post('course-cart',               [CartController::class, 'store']);
    Route::post('enroll-course',             [CoursesController::class, 'enrollFreeCourse']);
    Route::get('course-taking/{slug}',       [CoursesController::class, 'getCourseTaking'])->name('course-taking');
    Route::get('enrolled-courses',           [CoursesController::class, 'getCourseList']);
    Route::post('update-progress',           [CoursesController::class, 'updateProgress']);
});
