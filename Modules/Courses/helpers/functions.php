<?php

use Modules\Courses\Services\CourseService;
use Illuminate\Support\Facades\Storage;


/**
 * Upload base64 image into custom storage folder.
 *
 * @param string $dirName   Required. Directory name
 * @param string $imageUrl  Required. Base64 image string
 * @return array The process of array record
 */
if (! function_exists('uploadBase64Image')) {

    function uploadBase64Image($dirName, $name, $imageUrl)
    {

        $file_ext = ".png";
        $imageName = $name;
    
        // Get the storage disk dynamically
        $disk = getStorageDisk();
    
        // Check if the file already exists and generate a unique name if necessary
        $i = 0;
        while (Storage::disk($disk)->exists($dirName . '/' . $imageName . $file_ext)) {
            $i++;
            $imageName = preg_replace('/\(\d+\)$/', '', $name) . '(' . $i . ')';
        }
    
        $fileName = $imageName . $file_ext;
        $filePath = $dirName . '/' . $fileName;
    
        // Decode the base64 image
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageUrl));
        if ($image === false) {
            throw new \Exception("Failed to decode base64 image");
        }
    
        // Save the image file to the specified disk
        $storeFile = Storage::disk($disk)->put($filePath, $image);
        if ($storeFile === false) {
            throw new \Exception("Failed to save image file to disk: $filePath");
        }
    
        if ($storeFile) {
            return $filePath; // Return the full path to the saved file
        }
    
        return '';
    }
}


/**
*return pagination select options
*
* @return response()
*/
if (!function_exists('perPageOpt')) {

    function perPageOpt()
    {

        return [10, 20, 30, 50, 100, 200];
    }
}

/**
 * Get course duration in hours and minutes 
 * @param int $contentLength
 * @return string
 */
if (!function_exists('getCourseDuration')) {
    function getCourseDuration($contentLength)
    {
        if ($contentLength == 0) {
            return '';
        }

        $hours = floor($contentLength / 3600);
        $minutes = floor(($contentLength % 3600) / 60);
        $seconds = $contentLength % 60;

        $duration = '';

        if ($hours > 0) {
            $duration .= $hours . ' ' . ($hours > 1 ? __('courses::courses.hrs') : __('courses::courses.hr'));
        }

        if ($minutes > 0) {
            $duration .= ($duration ? ' : ' : '') . $minutes . ' ' . ($minutes > 1 ? __('courses::courses.mins') : __('courses::courses.min'));
        }

        if ($seconds > 0) {
            $duration .= ($duration ? ' : ' : '') . $seconds . ' ' . __('courses::courses.sec');
        }

        return $duration;
    }
}

/**
 * Get course duration in hours and minutes 
 * @param int $contentLength
 * @return string
 */
if (!function_exists('getCourseDurationWithoutSecond')) {
    function getCourseDurationWithoutSecond($contentLength)
    {
        if ($contentLength == 0) {
            return '';
        }

        $hours      = floor($contentLength / 3600);
        $minutes    = floor(($contentLength % 3600) / 60);
        $duration   = '';

        if ($hours > 0) {
            $duration .= $hours . ' ' . __('courses::courses.h');
        }

        if ($minutes > 0) {
            $duration .= $minutes . ' ' . __('courses::courses.m');
        }

        return $duration;
    }
}

if(!function_exists('courseMenuOptions')) {
    function courseMenuOptions($role)
    {
        switch ($role) {
            case 'tutor':
                return [
                    [
                        'tutorSortOrder' => 4,
                        'route' => 'courses.tutor.courses',
                        'onActiveRoute' => ['courses.tutor.courses', 'courses.tutor.edit-course', 'courses.tutor.create-course'],
                        'title' => __('courses::courses.manage_courses'),
                        'icon'  => '<i class="am-icon-book-1"></i>',
                        'accessibility' => ['tutor'],
                        'disableNavigate' => true,
                    ]
                ];
                break;
            case 'student':
                return [
                    [
                        'route' => 'courses.course-list',
                        'studentSortOrder' => 3,
                        'onActiveRoute' => ['courses.course-list'],
                        'title' => __('courses::courses.my_learning'),
                        'icon'  => '<i class="am-icon-book-1"></i>',
                        'accessibility' => ['student'],
                        'disableNavigate' => true,
                    ],
                    [
                        'route' => 'courses.search-courses',
                        'studentSortOrder' => 5,
                        'onActiveRoute' => ['courses.search-courses'],
                        'title' => __('courses::courses.find_courses'),
                        'icon'  => '<i class="am-icon-book"></i>',
                        'accessibility' => ['student'],
                        'disableNavigate' => true,
                    ],
                ];
                break;
            case 'admin':

            $routes =  [
                'courses.admin.courses' => __('courses::courses.all_courses'),
                'courses.admin.categories' => __('courses::courses.categories'),
                'courses.admin.course-enrollments' => __('courses::courses.course_enrollments'),
            ];

            if ((function_exists('isPaidSystem') && isPaidSystem()) || !function_exists('isPaidSystem')) {
                $routes['courses.admin.commission-setting'] =  __('courses::courses.commission_settings');
            }
            return [
                [
                    'title' =>  __('courses::courses.manage_courses'),
                    'icon'  => 'icon-book-open',
                    'routes' => $routes,
                ]
            ];
            break;
            default:
                return [];
        }
    }
}

if(!function_exists('getFeaturedCourses')) {
    function getFeaturedCourses($userId = null)
    {
        return (new CourseService())->getFeaturedCourses($userId);
    }
}
if (!function_exists('getVideoUrl')) {
    function getVideoUrl($curriculum) {
        if ($curriculum->type === 'yt_link') {
            // Extract YouTube video ID
            $videoId = '';
            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $curriculum->media_path, $matches);
            if(isset($matches[1])) {
                $videoId = $matches[1];
            }
            return isset($videoId) ? 'https://www.youtube.com/embed/' . $videoId : '';
        } elseif ($curriculum->type === 'vm_link') {
            // Extract Vimeo video ID
            $videoId = '';
            preg_match('/vimeo\.com\/(\d+)/', $curriculum->media_path, $matches);
            if(isset($matches[1])) {
                $videoId = $matches[1];
            }
            return isset($videoId) ? 'https://player.vimeo.com/video/' . $videoId : '';
        } else {
            // MP4 file

            return Storage::url($curriculum->media_path);
        }
   }
}
