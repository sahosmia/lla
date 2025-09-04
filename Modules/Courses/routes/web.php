<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Courses\Livewire\Pages\Admin\CommissionSettings;
use Illuminate\Support\Facades\Response;
use Modules\Courses\Livewire\Pages\Admin\CourseEnrollments;
use Modules\Courses\Livewire\Pages\Admin\CourseListing as AdminCourseListing;
use Modules\Courses\Livewire\Pages\Course\CourseDetails;
use Modules\Courses\Livewire\Pages\Search\SearchCourses;
use Modules\Courses\Livewire\Pages\Student\CourseList\CourseList;
use Modules\Courses\Livewire\Pages\Student\CourseTaking\CourseTaking;
use Modules\Courses\Livewire\Pages\Tutor\CourseCreation\CreateCourse;
use Modules\Courses\Livewire\Pages\Tutor\CourseListing\CourseListing;
use Modules\Courses\Livewire\Pages\Admin\Categories;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Modules\Courses\Http\Controllers\VideoController;
use Symfony\Component\HttpFoundation\StreamedResponse;

Route::middleware(['locale', 'maintenance', 'enabled:courses'])->as('courses.')->prefix(config('courses.url_prefix'))->group(function () {
    Route::get('/search-courses', SearchCourses::class)->name('search-courses');
    Route::get('/course/{slug}', CourseDetails::class)->name('course-detail');

    Route::middleware(['auth', 'verified', 'onlineUser', 'role:tutor'])->name('tutor.')->group(function () {
        Route::get('/create-course', CreateCourse::class)->name('create-course');
        Route::get('/courses', CourseListing::class)->name('courses');
        Route::get('/course/edit/{tab}/{id}', CreateCourse::class)->name('edit-course');
    });

    $middleware = ['auth', 'verified', 'role:admin|sub_admin'];
    if(class_exists('App\Http\Middleware\PermitOfMiddleware')){
        $middleware[] = 'permit-of:can-manage-courses';
    }
    Route::middleware($middleware)->name('admin.')->group(function () {
        Route::get('/admin/courses', AdminCourseListing::class)->name('courses');
        Route::get('/admin/course-enrollments', CourseEnrollments::class)->name('course-enrollments');
        Route::get('/admin/categories', Categories::class)->name('categories');
        Route::get('/admin/commission-setting', CommissionSettings::class)->name('commission-setting');
    });

    Route::get('/course-taking/{slug}', CourseTaking::class)->middleware(['auth', 'verified'])->name('course-taking');
    Route::get('/course-list', CourseList::class)->middleware(['auth', 'verified', 'role:student'])->name('course-list');

    Route::get('secure-video/{path}', [VideoController::class, 'play'])->middleware('auth')->name('secure.video'); 
});
