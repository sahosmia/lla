<?php

namespace App\Services;

use Larabuild\Pagebuilder\Models\Page;

class PageBuilderService {

    public function uniqueId()
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, 10);
    }

    public function getBannerData($pageId)
    {
        return [
            'pre_heading'           => ['value' => '100% Brighter Learning Platform', 'is_array' => 0],
            'heading'               => ['value' => 'Empower Your Future: <strong>Learning Today for a Brighter Tomorrow</strong>', 'is_array' => 0],
            'paragraph'             => ['value' => 'Achieve your goals with personalized tutoring from top experts. Connect with dedicated tutors for success.', 'is_array' => 0],
            'search_placeholder'    => ['value' => 'Search for tutors by subject...', 'is_array' => 0],
            'image_heading'         => ['value' => 'EXPLORE & FIND THE BEST TUTOR.', 'is_array' => 0],
            'image_paragraph'       => ['value' => 'Begin your learning journey today and experience the transformative power of personalized education.', 'is_array' => 0],
            'tutors_image'          => ['value' => [uploadObMedia('demo-content/tutor-rating.png')], 'is_array' => '1'],
            'student_image'         => ['value' => [uploadObMedia('demo-content/home-page/talents-img.png')], 'is_array' => '1'],
            'video'                 => ['value' => [uploadObMedia('demo-content/home-page/banner-video.mp4')], 'is_array' => 0],
        ];
    }

    public function getBannerV2Data($pageId)
    {
        return [
            'pre_heading_image'  => ['value' => [uploadObMedia('demo-content/home-v2/banner/banner-tag.png')], 'is_array' => '1'],
            'pre_heading'        => ['value' => 'Enhance your learning experience', 'is_array' => 0],
            'heading'            => ['value' => 'Enhance Your Learning Experience with <span>Our Expert</span> Mentor', 'is_array' => 0],
            'paragraph'          => ['value' => 'Achieve your goals with personalized tutoring from top experts. Connect with dedicated tutors for success.', 'is_array' => 0],
            'all_tutor_btn_url'  => ['value' => route('find-tutors'), 'is_array' => 0],
            'all_tutor_btn_txt'  => ['value' => 'Explore all tutors', 'is_array' => 0],
            'see_demo_btn_url'   => ['value' => 'https://www.youtube.com/watch?v=9SNfQFeC0Is', 'is_array' => 0],
            'see_demo_btn_txt'   => ['value' => 'See demo', 'is_array' => 0],
            'image'              => ['value' => [uploadObMedia('demo-content/home-v2/banner/banner-image.png')], 'is_array' => '1'],
            'shape_img_one'      => ['value' => [uploadObMedia('demo-content/home-v2/banner/bg-left.png')], 'is_array' => '1'],
            'shape_img_two'      => ['value' => [uploadObMedia('demo-content/home-v2/banner/bg-right.png')], 'is_array' => '1'],
            'banner_repeater'    => ['value' => [
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-software-logo.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/dribbble-logo.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/livechat-logo.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/dropbox-logo.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/typeform-logo.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/squarespace-logo.png')],
                ],
            ], 'is_array' => '1'],
        ];
    }

    public function getBannerV3Data($pageId)
    {
        return [
            'pre_heading'        => ['value' => 'Enhance your learning experience', 'is_array' => 0],
            'heading'            => ['value' => 'Unleash Your Potential with Top Tutors', 'is_array' => 0],
            'paragraph'          => ['value' => 'Achieve your academic goals with personalized, one-on-one tutoring from top experts in the field', 'is_array' => 0],
            'all_tutor_btn_url'  => ['value' => route('find-tutors'), 'is_array' => 0],
            'all_tutor_btn_txt'  => ['value' => 'Explore all tutors', 'is_array' => 0],
            'see_demo_btn_url'   => ['value' => 'https://www.youtube.com/watch?v=9SNfQFeC0Is', 'is_array' => 0],
            'see_demo_btn_txt'   => ['value' => 'See demo', 'is_array' => 0],
            'left_image'         => ['value' => [uploadObMedia('demo-content/home-v2/banner/left_image.webp')], 'is_array' => '1'],
            'video'              => ['value' => [uploadObMedia('demo-content/videos/woman_home.mp4')], 'is_array' => '1'],
            'wright_image'       => ['value' => [uploadObMedia('demo-content/home-v2/banner/wright_image.webp')], 'is_array' => '1'],
            'allen_image'        => ['value' => [uploadObMedia('demo-content/home-v2/banner/image-05.webp')], 'is_array' => '1'],
            'banner_repeater'    => ['value' => [
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-01.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-02.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-03.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-04.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-05.png')],
                ],
            ], 'is_array' => '1'],
        ];
    }

    public function getBannerV4Data($pageId)
    {
        return [
            'heading'            => ['value' => 'Unleash Your Potential with Top Tutors', 'is_array' => 0],
            'paragraph'          => ['value' => 'Achieve your academic goals with personalized, one-on-one tutoring from top experts in the field. Achieve your academic goals with personalized', 'is_array' => 0],
            'primary_btn_url'    => ['value' => route('find-tutors'), 'is_array' => 0],
            'primary_btn_txt'    => ['value' => 'Explore all tutors', 'is_array' => 0],
            'secondary_btn_url'  => ['value' => 'https://www.youtube.com/watch?v=9SNfQFeC0Is', 'is_array' => 0],
            'secondary_btn_txt'  => ['value' => 'See demo', 'is_array' => 0],
            'bg_img_one'         => ['value' => [uploadObMedia('demo-content/home-v2/banner/banner-bgimage-01.png')], 'is_array' => '1'],
            'bg_img_two'         => ['value' => [uploadObMedia('demo-content/home-v2/banner/banner-bgimage-02.png')], 'is_array' => '1'],
            'bg_img_three'       => ['value' => [uploadObMedia('demo-content/home-v2/banner/banner-bgimage-03.png')], 'is_array' => '1'],
            'bg_img_four'        => ['value' => [uploadObMedia('demo-content/home-v2/banner/bg-boxs.png')], 'is_array' => '1'],
            'banner_repeater'    => ['value' => [
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-white-01.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-white-02.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-white-03.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-white-04.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-white-05.png')],
                ],
            ], 'is_array' => '1'],
        ];
    }

    public function getBannerV5Data($pageId)
    {
        return [
            'pre_heading_image'     => ['value' => [uploadObMedia('demo-content/home-v5/trophy.svg')], 'is_array' => '1'],
            'pre_heading'           => ['value' => 'Empower Your Education', 'is_array' => 0],
            'heading'               => ['value' => 'Connect, Learn, Succeed!', 'is_array' => 0],
            'paragraph'             => ['value' => 'Achieve your academic goals with personalized, one-on-one tutoring from top experts in the field.', 'is_array' => 0],
            'search_btn_txt'        => ['value' => 'Search', 'is_array' => 0],
            'search_placeholder'    => ['value' => 'Search by Keyword', 'is_array' => 0],
            'banner_first_image'    => ['value' => [uploadObMedia('demo-content/home-v5/banner-image-01.png')], 'is_array' => '1'],
            'banner_second_image'   => ['value' => [uploadObMedia('demo-content/home-v5/banner-image-02.png')], 'is_array' => '1'],
            'banner_third_image'    => ['value' => [uploadObMedia('demo-content/home-v5/banner-image-03.png')], 'is_array' => '1'],
            'banner_fourth_image'   => ['value' => [uploadObMedia('demo-content/home-v5/banner-image-04.png')], 'is_array' => '1'],
            'banner_fifth_image'    => ['value' => [uploadObMedia('demo-content/home-v5/banner-image-05.png')], 'is_array' => '1'],
            'bg_shape_img_one'      => ['value' => [uploadObMedia('demo-content/home-v5/banner-five-bgcricle.png')], 'is_array' => '1'],
            'bg_shape_img_two'      => ['value' => [uploadObMedia('demo-content/home-v5/banner-five-bgcricle.png')], 'is_array' => '1'],
            'first_shape_img'       => ['value' => [uploadObMedia('demo-content/home-v5/bg-image-01.png')], 'is_array' => '1'],
            'second_shape_img'      => ['value' => [uploadObMedia('demo-content/home-v5/bg-image-02.png')], 'is_array' => '1'],

        ];
    }

    public function getBannerV6Data($pageId)
    {
        return [
            'first_heading'                     => ['value' => 'Discover the', 'is_array' => 0],
            'second_heading'                    => ['value' => '<span>Perfect Mentor</span> to Learn and Grow', 'is_array' => 0],
            'paragraph'                         => ['value' => 'Reach your goals with tailored tutoring from top experts. Connect with dedicated tutors for your success.', 'is_array' => 0],
            'primary_btn_url'                   => ['value' => route('find-tutors'), 'is_array' => 0],
            'primary_btn_txt'                   => ['value' => 'Explore all tutors', 'is_array' => 0],
            'secondary_btn_url'                 => ['value' => 'https://www.youtube.com/watch?v=9SNfQFeC0Is', 'is_array' => 0],
            'secondary_btn_txt'                 => ['value' => 'See demo', 'is_array' => 0],
            'user_rating_text'                  => ['value' => 'More that 1000+ learners', 'is_array' => 0],
            'rating'                            => ['value' => '5/5', 'is_array' => 0],
            'rating_text'                       => ['value' => '1,243 Reviews On Google', 'is_array' => 0],
            'third_banner_image'                => ['value' => [uploadObMedia('demo-content/home-v6/banner-img-3.png')], 'is_array' => '1'],
            'banner_main_image'                 => ['value' => [uploadObMedia('demo-content/home-v6/banner-main-img.png')], 'is_array' => '1'],
            'animated_first_image'              => ['value' => [uploadObMedia('demo-content/home-v6/banner-img-4.png')], 'is_array' => '1'],
            'animated_second_image'             => ['value' => [uploadObMedia('demo-content/home-v6/banner-img-5.png')], 'is_array' => '1'],
            'background_animated_first_image'   => ['value' => [uploadObMedia('demo-content/home-v6/banner-img-1.png')], 'is_array' => '1'],
            'background_animated_second_image'  => ['value' => [uploadObMedia('demo-content/home-v6/banner-img-2.png')], 'is_array' => '1'],
            'image_repeater'                    => ['value' => [
                $this->uniqueId() => [
                    'user_review_img'   => [uploadObMedia('demo-content/home-v6/userimg-1.png')],
                ],
                $this->uniqueId() => [
                    'user_review_img'   => [uploadObMedia('demo-content/home-v6/userimg-2.png')],
                ],
                $this->uniqueId() => [
                    'user_review_img'   => [uploadObMedia('demo-content/home-v6/userimg-3.png')],
                ],
            ], 'is_array' => '1'],
            'rating_repeater'                    => ['value' => [
                $this->uniqueId() => [
                    'rating_icon'   => 'am-icon-star-filled',
                ],
                $this->uniqueId() => [
                    'rating_icon'   => 'am-icon-star-filled',
                ],
                $this->uniqueId() => [
                    'rating_icon'   => 'am-icon-star-filled',
                ],
                $this->uniqueId() => [
                    'rating_icon'   => 'am-icon-star-filled',
                ],
                $this->uniqueId() => [
                    'rating_icon'   => 'am-icon-star-filled',
                ],

            ], 'is_array' => '1'],
        ];
    }

    public function getBannerV7Data($pageId) 
    {
        return [
            'heading'            => ['value' => 'Unleash Your Potential with <span>Top Mentors</span>', 'is_array' => 0],
            'paragraph'          => ['value' => 'Reach your goals with tailored tutoring from top experts. Connect with dedicated tutors for your success.', 'is_array' => 0],
            'primary_btn_url'    => ['value' => route('find-tutors'), 'is_array' => 0],
            'primary_btn_txt'    => ['value' => 'Explore all tutors', 'is_array' => 0],
            'secondary_btn_url'  => ['value' => 'https://www.youtube.com/watch?v=9SNfQFeC0Is', 'is_array' => 0],
            'secondary_btn_txt'  => ['value' => 'See demo', 'is_array' => 0],
            'bg_img'             => ['value' => [uploadObMedia('demo-content/home-v7/banner-img.jpg')], 'is_array' => '1'],
            'banner_repeater'    => ['value' => [
                                    $this->uniqueId() => [
                                        'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-white-01.png')],
                                    ],
                                    $this->uniqueId() => [
                                        'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-white-02.png')],
                                    ],
                                    $this->uniqueId() => [
                                        'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-white-03.png')],
                                    ],
                                    $this->uniqueId() => [
                                        'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-white-04.png')],
                                    ],
                                    $this->uniqueId() => [
                                        'banner_image'   => [uploadObMedia('demo-content/home-v2/banner/jira-white-05.png')],
                                    ],
                                ], 'is_array' => '1'],
        ];
    }

    public function getBannerV8Data($pageId)
    {
        return [
            'banner_repeater'    => ['value' => [
                    $this->uniqueId() => [
                        'bg_image_one'   => [uploadObMedia('demo-content/home-v8/banner-bgimg.png')],
                        'bg_image_two'   => [uploadObMedia('demo-content/home-v8/banner-bgimg.png')],
                        'bg_image_three' => [uploadObMedia('demo-content/home-v8/banner-bgimg.png')],
                        'heading'        => '<span>Unleash Your</span> <span>Potential with</span> <span>Top Tutors</span>',
                        'paragraph'      => 'Achieve your goals with personalized tutoring from top experts, tailored to your learning needs. Connect with dedicated tutors committed to helping you succeed.',
                        'companies_images' => [
                            uploadObMedia('demo-content/home-v8/jira-software.png'),
                            uploadObMedia('demo-content/home-v8/dribbble.png'),
                            uploadObMedia('demo-content/home-v8/livechat.png'),
                            uploadObMedia('demo-content/home-v8/dropbox.png'),
                        ],
                    ],
                    $this->uniqueId() => [
                        'bg_image_one'   => [uploadObMedia('demo-content/home-v8/banner-bgimg-2.png')],
                        'bg_image_two'   => [uploadObMedia('demo-content/home-v8/banner-bgimg-2.png')],
                        'bg_image_three' => [uploadObMedia('demo-content/home-v8/banner-bgimg-2.png')],
                        'heading'        => '<span>Unleash Your</span> <span>Potential with</span> <span>Top Tutors</span>',
                        'paragraph'      => 'Achieve your goals with personalized tutoring from top experts, tailored to your learning needs. Connect with dedicated tutors committed to helping you succeed.',
                        'companies_images' => [
                            uploadObMedia('demo-content/home-v8/jira-software.png'),
                            uploadObMedia('demo-content/home-v8/dribbble.png'),
                            uploadObMedia('demo-content/home-v8/livechat.png'),
                            uploadObMedia('demo-content/home-v8/dropbox.png'),
                        ],
                    ],
                    $this->uniqueId() => [
                        'bg_image_one'   => [uploadObMedia('demo-content/home-v8/banner-bgimg-3.png')],
                        'bg_image_two'   => [uploadObMedia('demo-content/home-v8/banner-bgimg-3.png')],
                        'bg_image_three' => [uploadObMedia('demo-content/home-v8/banner-bgimg-3.png')],
                        'heading'        => '<span>Unleash Your</span> <span>Potential with</span> <span>Top Tutors</span>',
                        'paragraph'      => 'Achieve your goals with personalized tutoring from top experts, tailored to your learning needs. Connect with dedicated tutors committed to helping you succeed.',
                        'companies_images' => [
                            uploadObMedia('demo-content/home-v8/jira-software.png'),
                            uploadObMedia('demo-content/home-v8/dribbble.png'),
                            uploadObMedia('demo-content/home-v8/livechat.png'),
                            uploadObMedia('demo-content/home-v8/dropbox.png'),
                        ],
                    ]
                ], 'is_array' => '1']
        ];
    }

    public function getBannerV9Data($pageId, $encodeMedia = true)
    {
        return [
            'heading'            => ['value' => '<strong>Discover the Perfect Mentor to Learn and Grow easier</strong>', 'is_array' => 0],
            'paragraph'          => ['value' => 'Achieve your goals with personalized tutoring from top experts. Connect with dedicated tutors for success.', 'is_array' => 0],
            'all_tutor_btn_url'  => ['value' => route('find-tutors'), 'is_array' => 0],
            'all_tutor_btn_txt'  => ['value' => 'Explore all tutors', 'is_array' => 0],
            'brand_heading'      => ['value' => 'Trusted by popular brands', 'is_array' => 0],
            'image'              => ['value' => [uploadObMedia('demo-content/home-v9/banner-images/banner-image-nine.png')], 'is_array' => '1'],
            'banner_repeater'    => ['value' => [
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v9/brand-images/atlassian.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v9/brand-images/notion-logo.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v9/brand-images/booking-logo.png')],
                ],
                $this->uniqueId() => [
                    'banner_image'   => [uploadObMedia('demo-content/home-v9/brand-images/slack-logo.png')],
                ],
            ], 'is_array' => '1'],
        ];
    }

    public function getCoursesData($pageId, $sectionId = null)
    {
        $page           = Page::find($pageId);
        $selectVerient  = '';
        $shapeImages    = [];

        if($page->slug == 'home-three' || $page->slug == '/'){
            $selectVerient = 'am-courses-block-two';
        } elseif($page->slug == 'home-nine'){
            $selectVerient = 'am-courses-block-three';
        } else {
            $selectVerient = 'am-courses-block';
        }

        if($page->slug == 'home-two'){       
            $sectionTitleVariation = 'am-section_title_one';
        } elseif($page->slug == 'home-three' || $page->slug == 'home-nine'){
            $sectionTitleVariation = 'am-section_title_two';
        } else {
            $sectionTitleVariation = '';
        } 

        if ($page->slug == 'home-three') {
            $shapeImages['third_shape_image']  = ['value' => [uploadObMedia('demo-content/home-v2/guide-pattran.png')], 'is_array' => '1'];
        } elseif ($page->slug == '/') {
            $shapeImages['first_shape_image']  = ['value' => [uploadObMedia('demo-content/courses-block/bg-shape-1.png')], 'is_array' => '1'];
            $shapeImages['second_shape_image'] = ['value' => [uploadObMedia('demo-content/courses-block/bg-shape-2.png')], 'is_array' => '1'];
        }

        return array_merge([
            'select_verient'            => ['value' => $selectVerient, 'is_array' => 0],
            'courses_limit'             => ['value' => 6, 'is_array' => 0],
            'section_title_variation'   => ['value' => $sectionTitleVariation, 'is_array' => 0],
            'pre_heading'               => ['value' => 'Explore Our Courses', 'is_array' => 0],
            'heading'                   => ['value' => 'Achieve More with Expert-Guided Courses', 'is_array' => 0],
            'paragraph'                 => ['value' => 'Discover top-quality courses designed to enhance your skills, boost your career, and help you achieve your learning goals. Learn from industry experts at your own pace.', 'is_array' => 0],
        ], $shapeImages);
    }

    public function getCategoriesData($pageId, $sectionId = null)
    {
        $page = Page::find($pageId);
        
        if ($page->slug == 'home-five' && $sectionId == 'categories_1') {
            return $this->getCategoriesV1($page, $sectionId);
        } else if ($page->slug == 'home-five' && $sectionId == 'categories_2') {
            return $this->getCategoriesV2($page, $sectionId);
        } else if ($page->slug == 'home-six' || $page->slug == 'home-eight') {
            return $this->getCategoriesV2($page, $sectionId);
        } else {
            return $this->getCategoriesV1($page, $sectionId);
        }
    }

    public function getEasyStepsData($pageId)
    {
        $page = Page::find($pageId);

        $preHeading = $heading = $styleVariation = $sectionTitleVariation = '';
        if($page->slug == 'home-three' || $page->slug == 'home-four' || $page->slug == 'home-seven' || $page->slug == 'home-nine'){
            $preHeading  = 'Step-By-Step guide';
            $heading     = 'Unlock your learning potential in easy steps';
        } else{
            $preHeading  = 'Easy Steps';
            $heading     = 'Unlock Your Learning Potential with <span>Few Easy Steps</span>';
        }

        if ($page->slug == 'home-three') {
            $styleVariation = 'easy-steps-variation-one';
        } elseif ($page->slug == 'home-four') {
            $styleVariation = 'easy-steps-variation-two';
        } elseif($page->slug == 'home-seven' || $page->slug == 'home-nine'){
            $styleVariation = 'easy-steps-variation-three';
            // $styleVariation = 'easy-steps-variation-two';
        } else{
            $styleVariation = '';
        }

        if($page->slug == 'home-two'){       
            $sectionTitleVariation = 'am-section_title_one';
        } elseif($page->slug == 'home-three' || $page->slug == 'home-four'){
            $sectionTitleVariation = 'am-section_title_two';
        } elseif($page->slug == 'home-seven' || $page->slug == 'home-nine'){
            $sectionTitleVariation = 'am-section_title_two';
        } else {
            $sectionTitleVariation = '';
        }

        if ($page->slug == 'home-three' || $page->slug == 'home-four' || $page->slug == 'home-seven' || $page->slug == 'home-nine') {
            return [
                'section_title_variation' => ['value' => $sectionTitleVariation, 'is_array' => 0],
                'style_variation'   => ['value' => $styleVariation, 'is_array' => 0],
                'pre_heading'       => ['value' => $preHeading, 'is_array' => 0],
                'heading'           => ['value' => $heading, 'is_array' => 0],
                'paragraph'         => ['value' => 'Explore a wealth of articles, guides, tutophp arials, and more, curated by our experts to enhance your learning experience.', 'is_array' => 0],
                'shape_image'       => ['value' => [uploadObMedia('demo-content/home-v2/guide-pattran.png')], 'is_array' => '1'],
                'steps_repeater'    => ['value' => [
                    $this->uniqueId() => [
                        'step_image'            => '',
                        'scnd_step_image'       => [uploadObMedia('demo-content/home-v2/banner/image-07.webp')],
                        'image_verient'         => '',
                        'step_heading'          => 'Signup Lernen',
                        'step_paragraph'        => 'Easily create an account by providing basic details to unlock access to a world of learning opportunities.',
                        'learn_more_btn_url'    => route('register'),
                        'learn_more_btn_txt'    => 'Learn more'
                    ],
                    $this->uniqueId() => [
                        'step_image'            => '',
                        'scnd_step_image'       => [uploadObMedia('demo-content/home-v2/banner/image-08.webp')],
                        'image_verient'         => '',
                        'step_heading'          => 'Explore Vetted Tutors',
                        'step_paragraph'        => 'Browse a diverse selection of experienced tutors across various subjects. Use filters like expertise, ratings to find your perfect match.',
                        'learn_more_btn_url'    => route('find-tutors'),
                        'learn_more_btn_txt'    => 'Learn more'
                    ],
                    $this->uniqueId() => [
                        'step_image'            => '',
                        'scnd_step_image'       => [uploadObMedia('demo-content/home-v2/banner/image-09.webp')],
                        'image_verient'         => '',
                        'step_heading'          => 'Book Session & Enjoy learning',
                        'step_paragraph'        => 'Select your tutor, schedule a convenient time, and start your personalized learning journey with expert guidance.',
                        'learn_more_btn_url'    => route('tutor-detail', ['slug' => 'anthony-shao']),
                        'learn_more_btn_txt'    => 'Learn more'
                    ]
                ], 'is_array' => '1']
            ];
        } else{
            return [
                'section_title_variation' => ['value' => $sectionTitleVariation, 'is_array' => 0],
                'style_variation'   => ['value' => $styleVariation, 'is_array' => 0],
                'pre_heading'       => ['value' => $preHeading, 'is_array' => 0],
                'heading'           => ['value' => $heading, 'is_array' => 0],
                'paragraph'         => ['value' => 'Explore a wealth of articles, guides, tutorials, and more, curated by our experts to enhance your learning experience.', 'is_array' => 0],
                'steps_repeater'    => ['value' => [
                    $this->uniqueId() => [
                        'step_image'            => [uploadObMedia('demo-content/gif/signup.gif')],
                        'scnd_step_image'       => [uploadObMedia('demo-content/gif/signup.png')],
                        'image_verient'         => 'am-step-warning',
                        'step_heading'          => 'Signup Lernen at no cost & verify your account',
                        'step_paragraph'        => 'Sign up for Lernen free, verify your account, and unlock full access to start your learning journey.',
                        'learn_more_btn_url'    => route('register'),
                        'learn_more_btn_txt'    => 'Learn more'
                    ],
                    $this->uniqueId() => [
                        'step_image'            => [uploadObMedia('demo-content/gif/explore.gif')],
                        'scnd_step_image'       => [uploadObMedia('demo-content/gif/explore.png')],
                        'image_verient'         => 'am-step-primary',
                        'step_heading'          => 'Explore our vetted tutors & select your expertise',
                        'step_paragraph'        => 'Explore our carefully vetted tutors and discover their expertise to find the perfect match for your learning needs.',
                        'learn_more_btn_url'    => route('find-tutors'),
                        'learn_more_btn_txt'    => 'Learn more'
                    ],
                    $this->uniqueId() => [
                        'step_image'            => [uploadObMedia('demo-content/gif/easilybook.gif')],
                        'scnd_step_image'       => [uploadObMedia('demo-content/gif/easilybook.png')],
                        'image_verient'         => 'am-step-success',
                        'step_heading'          => 'Easily book sessions with the best tutors',
                        'step_paragraph'        => 'Easily book sessions with the perfect tutor tailored to your needs and start achieving your learning goals.',
                        'learn_more_btn_url'    => route('tutor-detail', ['slug' => 'anthony-shao']),
                        'learn_more_btn_txt'    => 'Learn more'
                    ],
                    $this->uniqueId() => [
                        'step_image'            => [uploadObMedia('demo-content/gif/learning.gif')],
                        'scnd_step_image'       => [uploadObMedia('demo-content/gif/learning.png')],
                        'image_verient'         => 'am-step_danger',
                        'step_heading'          => 'Enjoy learning & support tutors with a rating',
                        'step_paragraph'        => 'Enjoy your learning experience and support your tutors by leaving a rating to help others make informed choices.',
                        'learn_more_btn_url'    => route('login'),
                        'learn_more_btn_txt'    => 'Learn more'
                    ]
                ], 'is_array' => '1']
            ];
        }
    }

    public function getGuideStepsData($pageId)
    {
        return [
            'pre_heading'        => ['value' => 'Step-by-step guide', 'is_array' => 0],
            'heading'            => ['value' => 'Unlock your learning potential in easy steps', 'is_array' => 0],
            'paragraph'          => ['value' => 'Explore a wealth of articles, guides, tutorials, & more, curated by our experts to enhance your learning experience.', 'is_array' => 0],
            'primary_btn_url'    => ['value' => route('find-tutors'), 'is_array' => 0],
            'primary_btn_text'   => ['value' => 'Explore all tutors', 'is_array' => 0],
            'secondary_btn_url'  => ['value' => 'https://www.youtube.com/watch?v=9SNfQFeC0Is', 'is_array' => 0],
            'section_title_variation' => ['value' => 'am-section_title_two', 'is_array' => 0],
            'secondary_btn_text' => ['value' => 'See demo', 'is_array' => 0],
            'first_shape_image'  => ['value' => [uploadObMedia('demo-content/home-v6/stepbgimg-1.png')], 'is_array' => '1'],
            'second_shape_image' => ['value' => [uploadObMedia('demo-content/home-v6/stepbgimg-2.png')], 'is_array' => '1'],
            'main_image'         => ['value' => [uploadObMedia('demo-content/home-v6/stepguide-img.png')], 'is_array' => 0],
            'steps_data'     => ['value' => [
                $this->uniqueId() => [
                    'step_heading'   => 'Signup Lernen',
                    'step_paragraph' => 'Easily create an account by providing basic details to unlock access to a world of learning opportunities.',
                    'step_icon'      => 'am-icon-bar-chart-01',
                ],
                $this->uniqueId() => [
                    'step_heading'   => 'Explore Vetted Mentors',
                    'step_paragraph' => 'Browse a diverse selection of experienced tutors across various subjects. Use filters like expertise, ratings to find your match.',
                    'step_icon'      => 'am-icon-user-star',
                ],
                $this->uniqueId() => [
                    'step_heading'   => 'Book Session & Enjoy learning',
                    'step_paragraph' => 'Select your tutor, schedule a convenient time, and start your personalized learning journey with expert guidance.',
                    'step_icon'      => 'am-icon-thumbs-up-02',
                ],
            ], 'is_array' => '1']
        ];
    }

    public function getWhyChooseUsData($pageId)
    {
        return [
            'section_title_variation'   => ['value' => 'am-section_title_two', 'is_array' => 0],
            'pre_heading'       => ['value' => 'Why Choose Us', 'is_array' => 0],
            'heading'           => ['value' => 'Why Our Marketplace Stands Out', 'is_array' => 0],
            'paragraph'         => ['value' => 'Experience personalized learning with expert tutors who empower students to achieve their academic goals.', 'is_array' => 0],
            'btn_url'           => ['value' =>  route('login'), 'is_array' => 0],
            'btn_txt'           => ['value' => 'Get Started', 'is_array' => 0],
            'bg_shape_img'      => ['value' => [uploadObMedia('demo-content/home-v2/banner/pattran.png')], 'is_array' => '1'],
            'steps_repeater'    => ['value' => [
                $this->uniqueId() => [
                    'image'            => [uploadObMedia('demo-content/home-v2/why-choos-us/image-01.svg')],
                    'data_heading'     => '40+',
                    'data_description' => 'Active subjects',
                ],
                $this->uniqueId() => [
                    'image'            => [uploadObMedia('demo-content/home-v2/why-choos-us/image-02.svg')],
                    'data_heading'     => '124,234',
                    'data_description' => 'Students enrolled',
                ],
                $this->uniqueId() => [
                    'image'            => [uploadObMedia('demo-content/home-v2/why-choos-us/image-03.svg')],
                    'data_heading'     => '400+',
                    'data_description' => 'Tutors available',
                ],
                $this->uniqueId() => [
                    'image'            => [uploadObMedia('demo-content/home-v2/why-choos-us/image-04.svg')],
                    'data_heading'     => '2,674',
                    'data_description' => '5 star reviews',
                ]
            ], 'is_array' => '1']
        ];
    }

    public function getRevolutionizeData($pageId, $encodeMedia = true)
    {
        return [
            'section_title_variation'   => ['value' => 'am-section_title_one', 'is_array' => 0],
            'pre_heading'               => ['value' => 'Revolutionize Learning', 'is_array' => 0],
            'heading'                   => ['value' => 'Empower Your Learning: <em>Unlock Your Potential</em>', 'is_array' => 0],
            'paragraph'                 => ['value' => '<p>Explore a world of knowledge at your fingertips. Our online education marketplace connects you with top-tier tutors and a diverse range of courses, all tailored to your unique learning needs and goals. Our platform provides the resources and support you need to succeed.</p>
                                                        <p>Whether you\'re looking to master a new skill or deepen your understanding in a particular subject, we provide the resources and support to help you succeed. Start your learning journey today and unlock your full potential.</p>', 'is_array' => 0],
            'video'                     => ['value' => [uploadObMedia('demo-content/videos/woman-learning.mp4')], 'is_array' => '1'],
            'bg_image'                  => ['value' => [uploadObMedia('demo-content/revolutionize-bg.png')], 'is_array' => '1'],
            'revolutionize_repeater'    => ['value' => [
                $this->uniqueId() => [
                    'revolu_image'      => [$encodeMedia ? json_encode(uploadObMedia('demo-content/home-v2/comprehensive.png')) : uploadObMedia('demo-content/home-v2/comprehensive.png')],
                    'revolu_heading'    => 'Comprehensive',
                    'revolu_paragraph'  => 'Explore a wide range of subjects & courses in one place.'
                ],
                $this->uniqueId() => [
                    'revolu_image'      => [$encodeMedia ? json_encode(uploadObMedia('demo-content/home-v2/expert-led.png')) : uploadObMedia('demo-content/home-v2/expert-led.png')],
                    'revolu_heading'    => 'Expert-Led',
                    'revolu_paragraph'  => 'Learn from industry-leading professionals and experienced tutors.'
                ],
            ], 'is_array' => '1'],
        ];
    }

    public function getTrackData($pageId)
    {
        return [
            'pre_heading'               => ['value' => 'Track Learning', 'is_array' => 0],
            'heading'                   => ['value' => 'Monitor & Keep a Detailed Record of Your <em>Learning Activities</em>', 'is_array' => 0],
            'paragraph'                 => ['value' => 'Stay on top of your educational journey with our comprehensive tracking tools. Our platform allows you to monitor your study habits and progress.', 'is_array' => 0],
            'get_started_btn_url'       => ['value' => route('login'), 'is_array' => 0],
            'get_started_btn_txt'       => ['value' => 'Get Started', 'is_array' => 0],
            'explore_tutor_btn_url'     => ['value' => route('register'), 'is_array' => 0],
            'explore_tutor_btn_txt'     => ['value' => 'Learn more', 'is_array' => 0],
            'subject_image'             => ['value' => [uploadObMedia('demo-content/home-v2/subjects.png')], 'is_array' => '1'],
            'summary_image'             => ['value' => [uploadObMedia('demo-content/home-v2/summary.png')], 'is_array' => '1'],
            'student_image'             => ['value' => [uploadObMedia('demo-content/home-v2/student.png')], 'is_array' => '1'],
            'calander_image'            => ['value' => [uploadObMedia('demo-content/home-v2/calander-logo.png')], 'is_array' => '1'],
            'shape_img'                 => ['value' => [uploadObMedia('demo-content/home-v2/learning-bg.png')], 'is_array' => '1'],
            'steps_repeater'            => ['value' => [
                $this->uniqueId() => [
                    'step_heading'      => 'Track Your Progress',
                    'step_paragraph'    => 'View detailed reports on your completed lessons, assignments & milestones.',
                ],
                $this->uniqueId() => [
                    'step_heading'      => 'Set Learning Goals',
                    'step_paragraph'    => 'Define your objectives & monitor your progress toward achieving them.',
                ],
                $this->uniqueId() => [
                    'step_heading'      => 'Adjust your study plan',
                    'step_paragraph'    => 'Use insights from your activity records to optimize your learning strategy and improve outcomes.',
                ],
            ], 'is_array' => '1'],
        ];
    }

    public function getTuitionData($pageId)
    {
        $page = Page::find($pageId);
        $selectVerient = $sectionTitleVariation = '';
        if($page->slug == 'home-seven'){
            $sectionTitleVariation = 'am-section_title_two';
            $selectVerient = 'tuition-varient-one';
        } elseif($page->slug == 'home-eight'){
            $sectionTitleVariation = 'am-section_title_two';
            $selectVerient = 'am-tuition-varient-two';
        } elseif($page->slug == 'home-two'){
            $sectionTitleVariation = 'am-section_title_one';
            $selectVerient = '';
        } else{
            $selectVerient = '';
        }

        return [
            'section_title_variation'   => ['value' => $sectionTitleVariation, 'is_array' => 0],
            'select_verient'            => ['value' => $selectVerient, 'is_array' => 0],
            'pre_heading'               => ['value' => 'Online Tuition Theme', 'is_array' => 0],
            'heading'                   => ['value' => 'A Cutting-Edge Environment', 'is_array' => 0],
            'paragraph'                 => ['value' => 'Experience the future of education with our state-of-the-art platform designed to foster growth & success.', 'is_array' => 0],
            'become_student_heading'    => ['value' => 'Become a Part of Our Learning Community', 'is_array' => 0],
            'become_student_paragraph'  => ['value' => 'Unlock access to expert tutors and personalized learning experiences tailored to your goals. Whether you’re looking to improve your grades, learn a new skill, or explore your passions.', 'is_array' => 0],
            'become_student_btn_txt'    => ['value' => 'Get started', 'is_array' => 0],
            'become_student_btn_url'    => ['value' => route('register'), 'is_array' => 0],
            'become_student_image'      => ['value' => [uploadObMedia('demo-content/home-v2/become-student.png')], 'is_array' => '1'],
            'become_tutor_heading'      => ['value' => 'Join as a Tutor to Offer Educational Expertise', 'is_array' => 0],
            'become_tutor_paragraph'    => ['value' => 'Share your knowledge, connect with motivated students, and grow your teaching career on our platform. Offer your expertise in a variety of subjects and help shape the future of learning', 'is_array' => 0],
            'become_tutor_btn_txt'      => ['value' => 'Join as Tutor', 'is_array' => 0],
            'become_tutor_btn_url'      => ['value' => route('register'), 'is_array' => 0],
            'become_tutor_image'        => ['value' => [uploadObMedia('demo-content/home-v2/become-tutor.png')], 'is_array' => '1'],
            'shape_img_one'             => ['value' => [uploadObMedia('demo-content/home-v2/community-element1.png')], 'is_array' => '1'],
            'shape_img_two'             => ['value' => [uploadObMedia('demo-content/home-v2/community-element2.png')], 'is_array' => '1'],
        ];
    }

    public function getGetAppData($pageId)
    {
        $page = Page::find($pageId);
        $googleImage = $selectVerient = $appStoreImage = '';
        if($page->slug == 'home-three' || $page->slug == 'home-four' || $page->slug == 'home-six' || $page->slug == 'home-seven' || $page->slug == 'home-eight' || $page->slug == 'home-nine'){
            $googleImage = [uploadObMedia('demo-content/android.webp')];
            $appStoreImage = [uploadObMedia('demo-content/home-v2/ios-app.png')];
        } elseif ($page->slug == 'home-five') {
            $googleImage = [uploadObMedia('demo-content/home-v5/android-white.webp')];
            $appStoreImage = [uploadObMedia('demo-content/home-v5/ios-white.png')];
        } else{
            $googleImage = [uploadObMedia('demo-content/home-v2/android-app.png')];
            $appStoreImage = [uploadObMedia('demo-content/home-v2/ios-app.png')];
        }

        if ($page->slug == 'home-three' || $page->slug == 'home-four' || $page->slug == 'home-six') {
            $selectVerient = 'get-app-varient-two';
        } elseif($page->slug == 'home-five'){
            $selectVerient = 'get-app-varient-one';
        } elseif($page->slug == 'home-seven'){
            $selectVerient = 'get-app-varient-three';
        } elseif ($page->slug == 'home-eight' || $page->slug == 'home-nine') {
            $selectVerient = 'get-app-varient-five';
        } else {
            $selectVerient = '';
        }

        return [
            'select_verient'    => ['value' => $selectVerient, 'is_array' => 0],
            'pre_heading'       => ['value' => $page->slug == 'home-nine' ? '' : 'Coming Soon', 'is_array' => 0],
            'heading'           => ['value' => 'Lernen Mobile App <em>Available!</em>', 'is_array' => 0],
            'paragraph'         => ['value' => 'Take your learning on the go with the Lernen mobile app. Access all your courses, connect with tutors & track your progress.', 'is_array' => 0],
            'app_store_image'   => ['value' => $appStoreImage, 'is_array' => '1'],
            'apple_store_url'   => ['value' => '#', 'is_array' => 0],
            'google_image'      => ['value' => $googleImage, 'is_array' => '1'],
            'play_store_url'    => ['value' => '#', 'is_array' => 0],
            'mobile_image'      => ['value' => [uploadObMedia('demo-content/home-v2/mobile-app.png')], 'is_array' => '1'],
            'bg_image'          => ['value' => [uploadObMedia('demo-content/footer-vector-img.png')], 'is_array' => '1'],
            'shape_img_one'     => ['value' => [uploadObMedia('demo-content/home-v2/banner/bg-left.png')], 'is_array' => '1'],
        ];
    }

    public function getMarketplaceData($pageId)
    {
        return [
            'shape_image'               => ['value' => [uploadObMedia('demo-content/marketplace-shape.png')], 'is_array' => '1'],
            'icon'                      => ['value' => 'am-icon-calender-duration', 'is_array' => 0],
            'pre_heading'               => ['value' => 'Why Choose Us', 'is_array' => 0],
            'heading'                   => ['value' => 'Why Our Marketplace Stands Out', 'is_array' => 0],
            'paragraph'                 => ['value' => 'Explore a wealth of articles, guides, tutorials, and more, curated by our experts to enhance your learning experience.', 'is_array' => 0],
            'get_start_btn_url'         => ['value' =>  'login', 'is_array' => 0],
            'get_start_btn_text'        => ['value' => 'Get Started Now', 'is_array' => 0],
            'image'                     => ['value' => [uploadObMedia('demo-content/homepage-laptop.png')], 'is_array' => '1'],
            'list-data'                 => ['value' =>  [
                $this->uniqueId() => [
                    'list_item'       => 'Flexible Scheduling',
                ],
                $this->uniqueId() => [
                    'list_item'       => 'Expert Tutors',
                ],
                $this->uniqueId() => [
                    'list_item'       => 'Affordable Rates',
                ],
                $this->uniqueId() => [
                    'list_item'       => 'Personalized Learning Plans',
                ],
                $this->uniqueId() => [
                    'list_item'       => 'Wide Range of Subjects',
                ],
                $this->uniqueId() => [
                    'list_item'       => 'Learner’s community and access to infinite educational resources',
                ],
            ], 'is_array' => '1'],
        ];
    }

    public function getStepsData($pageId, $encodeMedia = true)
    {
        return [
            'pre_heading'               => ['value' => 'A Step-by-Step Guide', 'is_array' => 0],
            'heading'                   => ['value' => 'Unlock Your Potential with Easy Steps', 'is_array' => 0],
            'paragraph'                 => ['value' => 'Learn how our platform simplifies finding and booking top tutors to enhance  your skills and achieve your learning goals', 'is_array' => 0],
            'get_start_btn_url'         => ['value' =>  route('login'), 'is_array' => 0],
            'get_start_btn_text'        => ['value' => 'Get Started Now', 'is_array' => 0],
            'start_journ_heading'       => ['value' => 'Start Your Journey', 'is_array' => 0],
            'start_journ_description'   => ['value' => 'Begin your educational journey with us. Find a tutor and book your first session today!', 'is_array' => 0],
            'start_journ_icon'          => ['value' => 'am-icon-layer-01', 'is_array' => 0],
            'steps_data'                => ['value' =>  [
                $this->uniqueId() => [
                    'sub_heading'       => 'STEP 1',
                    'step_image'        => $encodeMedia ? [json_encode(uploadObMedia('demo-content/home-page/step-one.png'))] : [uploadObMedia('demo-content/home-page/step-one.png')],
                    'step_heading'      => 'Sign Up',
                    'step_paragraph'    => 'Create your account quickly to get started with our platform',
                    'btn_url'           => 'register',
                    'btn_text'          => 'Get Started',
                ],
                $this->uniqueId() => [
                    'sub_heading'       => 'STEP 2',
                    'step_image'        => $encodeMedia ? [json_encode(uploadObMedia('demo-content/home-page/step-two.png'))] : [uploadObMedia('demo-content/home-page/step-two.png'    )],
                    'step_heading'      => 'Find a Tutor',
                    'step_paragraph'    => 'Browse & select from qualified tutors based on your need',
                    'btn_url'           => 'find-tutors',
                    'btn_text'          => 'Search Now',
                ],
                $this->uniqueId() => [
                    'sub_heading'       => 'STEP 3',
                    'step_image'        => $encodeMedia ? [json_encode(uploadObMedia('demo-content/home-page/step-three.png'))] : [uploadObMedia('demo-content/home-page/step-three.png')],
                    'step_heading'      => 'Schedule a Lesson',
                    'step_paragraph'    => 'Book a convenient time for your lesson with ease',
                    'btn_url'           => 'login',
                    'btn_text'          => 'Let’s Begin',
                ],
            ], 'is_array' => '1'],
        ];
    }

    public function getUserGuideData($pageId)
    {
        return [
            'left_image'                => ['value' => [uploadObMedia('demo-content/support.png')], 'is_array' => '1'],
            'pre_heading'               => ['value' => '24/7 Support', 'is_array' => 0],
            'heading'                   => ['value' => 'Comprehensive Support at Every Step', 'is_array' => 0],
            'paragraph'                 => ['value' => '<p>From the moment you join, we offer onboarding assistance to ensure a smooth start on our platform. Our technical support team is always ready to troubleshoot and resolve any issues you may encounter.</p>
                                                        <p>Additionally, you\'ll have access to a comprehensive library of tutorials, guides, and FAQs to help you navigate and make the most of our services. Explore a wealth of articles, guides, tutorials, and more, curated by our experts to enhance your learning experience.</p>', 'is_array' => 0],
            'sub_heading'               => ['value' => 'User Guide', 'is_array' => 0],
            'second_heading'            => ['value' => 'Our Experts Will Guide You to Mastery', 'is_array' => 0],
            'second_paragraph'          => ['value' => '<p>Our expert tutors are committed to helping you achieve mastery in your chosen subjects. With extensive knowledge and experience, they provide personalized instruction tailored to your learning style and goals.</p>
                                                        <p>Whether you aim to improve grades, prepare for exams, or learn new skills, our tutors create customized learning plans that ensure comprehensive understanding and confidence. Experience the transformative power of expert guidance and reach your full potential with us</p>', 'is_array' => 0],
            'right_image'               => ['value' => [uploadObMedia('demo-content/user-guide.png')], 'is_array' => '1'],
        ];
    }

    public function getFeaturedTutorsData($pageId)
    {
        return [
            'shape_image'               => ['value' => [uploadObMedia('demo-content/section-shape.png')], 'is_array' => '1'],
            'pre_heading'               => ['value' => 'Feature Tutors', 'is_array' => 0],
            'heading'                   => ['value' => 'Explore Our Handpicked Tutors', 'is_array' => 0],
            'paragraph'                 => ['value' => 'Explore a wealth of articles, guides, tutorials, and more, curated by our experts to enhance your learning experience.', 'is_array' => 0],
            'view_tutor_btn_url'        => ['value' => 'find-tutors', 'is_array' => 0],
            'view_tutor_btn_text'       => ['value' => 'View All Tutors', 'is_array' => 0],
        ];
    }

    public function getFaqsData($pageId)
    {
        return [
            'student_btn_txt'      => ['value' => 'For student', 'is_array' => 0],
            'tutor_btn_txt'        => ['value' => 'For tutor', 'is_array' => 0],
            'btn_url'              => ['value' => '#', 'is_array' => 0],
            'students_faqs_data'   => ['value' =>  [
                $this->uniqueId() => [
                    'question'    => 'How do I find a tutor?',
                    'answer'      => 'Use the search bar and filters on the "Find a Tutor" page to search for tutors by subject, availability, rating, and more.',
                ],
                $this->uniqueId() => [
                    'question'    => 'How do I book a session?',
                    'answer'      => 'Once you find a tutor, view their profile and select an available time slot that suits you. Click "Book Now" and follow the prompts to confirm your session.',
                ],
                $this->uniqueId() => [
                    'question'    => 'What if I need to cancel or reschedule a session?',
                    'answer'      => 'You can cancel or reschedule a session up to 24 hours before the scheduled time without penalty. Cancellations within 24 hours may incur a fee.',
                ],
                $this->uniqueId() => [
                    'question'    => 'How do I pay for sessions?',
                    'answer'      => 'Payments are made through our secure payment gateway using credit/debit cards or other available payment methods.',
                ],
                $this->uniqueId() => [
                    'question'    => 'What should I do if my tutor doesn\'t show up?',
                    'answer'      => 'If your tutor does not show up for a scheduled session, please contact our support team immediately for assistance and to arrange a refund or reschedule.',
                ],
                $this->uniqueId() => [
                    'question'    => 'How do I leave feedback for my tutor?',
                    'answer'      => 'After your session, you will receive an email prompting you to rate your tutor and provide feedback. You can also do this from your account dashboard.',
                ],
            ], 'is_array' => '1'],
            'tutors_faqs_data'     => ['value' =>  [
                $this->uniqueId() => [
                    'question'    => 'How do I become a tutor?',
                    'answer'      => 'Click on the "Become a Tutor" link and follow the instructions to sign up, create your profile, and submit the necessary documentation for approval.',
                ],
                $this->uniqueId() => [
                    'question'    => 'What qualifications do I need to become a tutor?',
                    'answer'      => 'Tutors are required to have relevant educational qualifications and teaching experience. Specific requirements may vary by subject.',
                ],
                $this->uniqueId() => [
                    'question'    => 'How do I set my availability?',
                    'answer'      => 'Log in to your account, go to the "Availability" section, and update your calendar with your available time slots.',
                ],
                $this->uniqueId() => [
                    'question'    => 'How do I get paid?',
                    'answer'      => 'Payments for your tutoring sessions are processed through our platform and transferred to your designated bank account on a regular basis.',
                ],
                $this->uniqueId() => [
                    'question'    => 'What should I do if a student cancels a session?',
                    'answer'      => 'If a student cancels a session within 24 hours of the scheduled time, you may be entitled to a cancellation fee. Check the platform’s cancellation policy for details.',
                ],
            ], 'is_array' => '1'],
        ];
    }

    public function getFaqsWithoutBtnData($pageId)
    {
        $page = Page::find($pageId);
        $faqsVerient = $sectionTitleVariation = '';
        if ($page->slug == 'home-three' || $page->slug == 'home-six') {
            $faqsVerient = '';
            $sectionTitleVariation = 'am-section_title_two';
        } elseif ($page->slug == 'home-six') {
            $faqsVerient = 'am-faq-varient-one';
        }
        return [
            'section_title_variation' => ['value' => $sectionTitleVariation, 'is_array' => 0],
            'select_verient' => ['value' => $faqsVerient, 'is_array' => 0],
            'sub-heading'    => ['value' => 'FAQS', 'is_array' => 0],
            'heading'        => ['value' => 'Frequently Asked Questions', 'is_array' => 0],
            'paragraph'      => ['value' => 'It facilitate communication by answering common questions and equipping users with essential information.', 'is_array' => 0],
            'btn_txt'        => ['value' => 'Contact Our Team', 'is_array' => 0],
            'faqs_data'      => ['value' =>  [
                $this->uniqueId() => [
                    'question'    => 'How do I find a tutor?',
                    'answer'      => 'Use the search bar and filters on the "Find a Tutor" page to search for tutors by subject, availability, rating, and more.',
                ],
                $this->uniqueId() => [
                    'question'    => 'How do I book a session?',
                    'answer'      => 'Once you find a tutor, view their profile and select an available time slot that suits you. Click "Book Now" and follow the prompts to confirm your session.',
                ],
                $this->uniqueId() => [
                    'question'    => 'What if I need to cancel or reschedule a session?',
                    'answer'      => 'You can cancel or reschedule a session up to 24 hours before the scheduled time without penalty. Cancellations within 24 hours may incur a fee.',
                ],
                $this->uniqueId() => [
                    'question'    => 'How do I pay for sessions?',
                    'answer'      => 'Payments are made through our secure payment gateway using credit/debit cards or other available payment methods.',
                ],
                $this->uniqueId() => [
                    'question'    => 'What should I do if my tutor doesn\'t show up?',
                    'answer'      => 'If your tutor does not show up for a scheduled session, please contact our support team immediately for assistance and to arrange a refund or reschedule.',
                ],
                $this->uniqueId() => [
                    'question'    => 'How do I leave feedback for my tutor?',
                    'answer'      => 'After your session, you will receive an email prompting you to rate your tutor and provide feedback. You can also do this from your account dashboard.',
                ],
            ], 'is_array' => '1'],
        ];
    }

    public function getHowItWorksData($pageId, $encodeMedia = true)
    {
        return [
            'pre_heading'          => ['value' => 'A Step-by-Step Guide', 'is_array' => 0],
            'heading'              => ['value' => 'Empowering learners worldwide', 'is_array' => 0],
            'paragraph'            => ['value' => 'We are dedicated to providing personalized online tutoring experiences that unlock every learner\'s potential.', 'is_array' => 0],
            'student_btn_txt'      => ['value' => 'As a student', 'is_array' => 0],
            'tutor_btn_txt'        => ['value' => 'As a tutor', 'is_array' => 0],
            'student_repeater'     => ['value' =>  [
                $this->uniqueId() => [
                    'std_btn_icon'          => 'am-icon-user-cross-1',
                    'student_sub_heading'   => 'Sign Up',
                    'student_heading'       => 'Fill in your details and set your learning preferences.',
                    'student_paragraph'     => '<p>Provide your personal details and set your learning preferences to create a profile tailored to your educational needs. This will help match you with the most suitable tutors and optimize your learning experience..</p>',
                    'student_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/how-it-works-01.png')) : uploadObMedia('demo-content/how-it-works-01.png')],
                ],
                $this->uniqueId() => [
                    'std_btn_icon'          => 'am-icon-search-02',
                    'student_sub_heading'   => 'Find a Tutor',
                    'student_heading'       => 'Use filters to refine your search and view detailed tutor profiles.',
                    'student_paragraph'     => '<p>Use filters to narrow down your tutor search based on subject, level, pricing, location, and availability. This allows you to view detailed tutor profiles that best match your learning needs.</p>',
                    'student_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/how-it-works-02.png')) : uploadObMedia('demo-content/how-it-works-02.png')],
                ],
                $this->uniqueId() => [
                    'std_btn_icon'          => 'am-icon-calender-duration',
                    'student_sub_heading'   => 'Book a Lesson',
                    'student_heading'       => 'Choose a convenient time and book your lesson instantly.',
                    'student_paragraph'     => '<h5>Steps to Book a Tutoring Session</h5>
                                                                        <ul>
                                                                            <li>
                                                                                <p>Select an Available Time Slot</p>
                                                                            </li>
                                                                            <li>
                                                                                <p>Click on the Desired Slot</p>
                                                                            </li>
                                                                            <li>
                                                                                <p>Choose Session Type</p>
                                                                            </li>
                                                                            <li>
                                                                                <p>Confirm Booking Details</p>
                                                                            </li>
                                                                            <li>
                                                                                <p>Proceed to Payment</p>
                                                                            </li>
                                                                            <li>
                                                                                <p>Receive Confirmation</p>
                                                                            </li>
                                                                        </ul>',
                    'student_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/how-it-works-03.png')) : uploadObMedia('demo-content/how-it-works-03.png')],
                ],
                $this->uniqueId() => [
                    'std_btn_icon'          => 'am-icon-time',
                    'student_sub_heading'   => 'Attend the Lesson',
                    'student_heading'       => 'Log in at the scheduled time and start learning.',
                    'student_paragraph'     => '<p>Log in at your scheduled time and join the session to start learning. Connect with your tutor through zoom for an engaging and interactive lesson.</p>',
                    'student_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/how-it-works-04.png')) : uploadObMedia('demo-content/how-it-works-04.png')],
                ],
                $this->uniqueId() => [
                    'std_btn_icon'          => 'am-icon-star-01',
                    'student_sub_heading'   => 'Provide Feedback',
                    'student_heading'       => 'Complete a quick feedback form after your lesson.',
                    'student_paragraph'     => '<p>After your lesson, complete a quick feedback form to share your thoughts and rate your experience. Your feedback helps us improve and ensures the best learning environment for everyone.</p>',
                    'student_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/how-it-works-06.png')) : uploadObMedia('demo-content/how-it-works-06.png')],
                ],
            ], 'is_array' => '1'],
            'tutor_repeater'     => ['value' =>  [
                $this->uniqueId() => [
                    'tutor_btn_icon'      => 'am-icon-user-cross-1',
                    'tutor_sub_heading'   => 'Sign Up',
                    'tutor_heading'       => 'Create your profile and list your qualifications.',
                    'tutor_paragraph'     => '<p>Create your profile to showcase your qualifications, skills, and expertise. Highlight your experience, education, and the subjects you teach to attract potential students and build credibility on the platform.</p>',
                    'tutor_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/how-it-works-01.png')) : uploadObMedia('demo-content/how-it-works-01.png')],
                ],
                $this->uniqueId() => [
                    'tutor_btn_icon'      => 'am-icon-time ',
                    'tutor_sub_heading'   => 'Set Availability',
                    'tutor_heading'       => 'Manage your schedule to show when you’re available to teach.',
                    'tutor_paragraph'     => '<p>Easily manage your availability by updating your schedule with the times you’re open to teach. This helps students know when they can book sessions with you and keeps your teaching calendar organized.</p>',
                    'tutor_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/how-it-works-03.png')) : uploadObMedia('demo-content/how-it-works-03.png')],
                ],
                $this->uniqueId() => [
                    'tutor_btn_icon'      => 'am-icon-calender-duration',
                    'tutor_sub_heading'   => 'Accept Bookings',
                    'tutor_heading'       => 'Review student requests and accept bookings.',
                    'tutor_paragraph'     => '<p>Review incoming student requests and manage your bookings by accepting lessons that fit your availability. Confirm bookings to connect with students and start teaching as per the scheduled sessions.</p>',
                    'tutor_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/how-it-works-05.png')) : uploadObMedia('demo-content/how-it-works-05.png')],
                ],
                $this->uniqueId() => [
                    'tutor_btn_icon'      => 'am-icon-book-1',
                    'tutor_sub_heading'   => 'Teach the Lesson',
                    'tutor_heading'       => 'Conduct your lesson using Zoom.',
                    'tutor_paragraph'     => '<p>Log in at your scheduled time and start teaching your session. Use the platform\'s integrated video conferencing tool to connect with your students and deliver an engaging learning experience.</p>',
                    'tutor_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/how-it-works-04.png')) : uploadObMedia('demo-content/how-it-works-04.png')],
                ],
                $this->uniqueId() => [
                    'tutor_btn_icon'      => 'am-icon-dollar',
                    'tutor_sub_heading'   => 'Get Paid',
                    'tutor_heading'       => 'Receive payments for your lessons directly to your account.',
                    'tutor_paragraph'     => '<p>Receive payments for your lessons directly to your account.Monitor your earnings from completed lessons and keep track of your income. Withdraw your funds easily whenever needed, directly from your tutor dashboard.</p>',
                    'tutor_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/how-it-works-06.png')) : uploadObMedia('demo-content/how-it-works-06.png')],
                ],
            ], 'is_array' => '1'],
        ];
    }

    public function getParagraphData($pageId)
    {
        $page = Page::find($pageId);
        if ($page->slug == 'terms-condition') {
            return [
                'paragraph' =>  [
                    'value' =>  '<div><p>By accessing or using our platform, you agree to comply with and be bound by these Terms and Conditions. Please read them carefully. If you do not agree with these terms, you must not use our services.</p></div>
                                            <div><h4>1. User Accounts</h4>
                                                <p>You must provide accurate, complete, and current information during registration. Failure to do so may result in suspension or termination of your account.
                                                    You are responsible for maintaining the confidentiality of your account information and password. You must notify us immediately of any unauthorized use of your account.</p></div>
                                            <div><h4>2. User Conduct</h4>
                                                <p>Users agree not to engage in the following activities:</p>
                                                <ul>
                                                    <li>Harassment or abuse of other users</li>
                                                    <li>Fraudulent activities or impersonation.</li>
                                                    <li>Uploading inappropriate, offensive, or illegal content.</li>
                                                    <li>Disrupting the platform\'s functionality.</li>
                                                </ul></div>
                                            <div><h4>3. Pricing Changes</h4>
                                                    <p>We reserve the right to change pricing at any time. Users will be notified of any changes in advance.</p></div>
                                            <div><h4>4. Payments and Refunds</h4>
                                                <strong>Payment Terms:</strong>
                                                <ul>
                                                    <li>Payments for tutoring sessions must be made through our platform. Accepted payment methods include bank cards and [Stripe, Paypal, Razorpay, Paystack, Paytm, Flutterwave, Payfast].</li>
                                                </ul>
                                                <strong>Refund Policy:</strong>
                                                <ul>
                                                    <li>The tutor cancels the session.</li>
                                                    <li>The session did not occur due to technical issues on the platform.</li>
                                                </ul>
                                                <strong>Rescheduling:</strong>
                                                <ul>
                                                    <li>Sessions can be rescheduled up to 24 hours in advance through the platform.</li>
                                                </ul>
                                            </div>
                                            <div><h4>5. Tutor Responsibilities</h4>
                                                <strong>Profile Accuracy:</strong>
                                                <ul>
                                                    <li>Tutors must provide accurate and up-to-date information in their profiles. Misrepresentation may result in account suspension.</li>
                                                </ul>
                                                <strong>Session Delivery:</strong>
                                                <ul>
                                                    <li>Tutors are expected to deliver sessions professionally and punctually.</li>
                                                </ul>
                                                <strong>Compliance with Laws:</strong>
                                                <ul>
                                                    <li>Tutors must comply with all relevant educational and legal requirements in their region.</li>
                                                </ul>
                                            </div>
                                            <div><h4>6. Student Responsibilities</h4>
                                                <strong>Participation:</strong>
                                                <ul>
                                                    <li>Students are expected to attend sessions on time and actively participate.</li>
                                                </ul>
                                                <strong>Feedback:</strong>
                                                <ul>
                                                    <li>Students are encouraged to provide constructive feedback and rate their tutors after each session.</li>
                                                </ul>
                                            </div>
                                            <div><h3 id="cancellation_policy"><a href="terms-condition#cancellation_policy">7. Cancellation Policy</a></h3>
                                                <h5>Student Cancellations</h5>
                                                <strong>Up to 24 Hours Before the Scheduled Session:</strong>
                                                <ul>
                                                    <li>Students can cancel or reschedule a session without any penalty if done up to 24 hours before the scheduled session start time. No charges will be applied.</li>
                                                </ul>
                                                <strong>Within 24 Hours of the Scheduled Session:</strong>
                                                <ul>
                                                    <li>Cancellations made within 24 hours of the scheduled session will incur a cancellation fee of [specified amount]. This fee compensates the tutor for the short notice and lost opportunity to fill the time slot.</li>
                                                </ul>
                                            </div>
                                            <div><h5>Tutor Cancellations</h5>
                                            <strong>Tutor-Initiated Cancellations:</strong>
                                                 <ul>
                                                    <li>Tutors are expected to maintain their schedules accurately. If a tutor needs to cancel a session, they must notify the student as soon as possible. Tutors who frequently cancel sessions may face penalties, including suspension or removal from the platform.</li>
                                                 </ul>
                                            </div>
                                                <div><h5>No-Shows</h5>
                                                <strong>Student absence:</strong>
                                                 <ul>
                                                    <li>If a student does not show up for a session without prior notice, the session fee will still be charged, and the tutor will be paid for their time.</li>
                                                </ul>
                                                <strong>Tutor absence:</strong>
                                                <ul>
                                                    <li>If a tutor does not show up for a session without prior notice, the student will be fully refunded, and the tutor may face penalties, including suspension or removal from the platform.</li>
                                                </ul></div>
                                            <div><h4>8. Rescheduling policy</h4>
                                                <p>Students and tutors can reschedule a session up to 24 hours before the scheduled time without any penalty. Rescheduling within 24 hours of the session may be treated as a cancellation, and the respective fees may apply.</p></div>
                                            <div><h4>9. Refund policy</h4>
                                                <strong>Refund Eligibility:</strong>
                                                    <ul>
                                                        <li>Refunds are issued in the following situations:
                                                            <ul>
                                                                <li>Tutor cancels a session.</li>
                                                                <li>Session did not occur due to technical issues on the platform.</li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                    <strong>Refund Process:</strong>
                                                    <ul>
                                                    <li>Refund requests must be submitted within [specified timeframe] after the scheduled session. The platform will review and process eligible refunds within [specified timeframe].</li>
                                                </ul></div>
                                            <div><h4>10. Policy Changes</h4>
                                            <strong>Right to Modify:</strong>
                                                <ul>
                                                    <li>The platform reserves the right to modify the cancellation policy at any time. Users will be notified of any changes in advance. Continued use of the platform after any such changes constitutes acceptance of the new terms.</li>
                                                </ul></div>',
                    'is_array' => 0
                ]
            ];
        } elseif ($page->slug == 'privacy-policy') {
            return [
                'paragraph' =>  [
                    'value' => '
                                <div><p>We are committed to protecting your privacy. This Privacy Policy explains how we collect, use, and share your personal data when you use our website and services.</p></div>
                                <div><h4>1. Information We Collect</h4>
                                <ul>
                                    <li><strong>Personal Information:</strong> Name, email address, phone number, date of birth, and payment details.</li>
                                    <li><strong>Profile Information:</strong> Tutors’ qualifications, experience, subjects taught, hourly rates, and availability.</li>
                                    <li><strong>Usage Information:</strong> Browsing history, search queries, session bookings, and page visits.</li>
                                    <li><strong>Technical Information:</strong> IP address, browser type, device information, and operating system.</li>
                                    <li><strong>Communication Information:</strong> Customer support inquiries, feedback forms, and chat messages.</li>
                                </ul></div>
                                <div><h4>2. How We Use Your Information</h4>
                                <ul>
                                    <li><strong>Provide Services:</strong> Operate and maintain our platform, process transactions, manage accounts, and facilitate tutoring sessions.</li>
                                    <li><strong>Personalization:</strong> Recommend tutors and content based on interests and learning goals.</li>
                                    <li><strong>Communication:</strong> Notify you about account updates, session reminders, and policy changes.</li>
                                    <li><strong>Marketing:</strong> Send promotional materials and newsletters with your consent.</li>
                                    <li><strong>Analytics:</strong> Monitor performance and improve functionality and user experience.</li>
                                    <li><strong>Security:</strong> Protect against fraud and unauthorized access.</li>
                                </ul></div>
                                <div><h4>3. How We Share Your Information</h4>
                                <ul>
                                    <li><strong>With Tutors:</strong> Share students contact details and learning goals to facilitate sessions.</li>
                                    <li><strong>With Students:</strong> Share tutors profiles to help students choose suitable tutors.</li>
                                    <li>We do not store credit card information on our site.</li>
                                </ul></div>
                                <div><h4>4. Your Rights</h4>
                                <ul>
                                    <li><strong>Access and Correction:</strong> Update your personal information through account settings.</li>
                                    <li><strong>Deletion:</strong> Request deletion of your data, subject to legal exceptions.</li>
                                    <li><strong>Opt-Out:</strong> Unsubscribe from marketing communications.</li>
                                    <li><strong>Data Portability:</strong> Request a copy of your data in a machine-readable format.</li>
                                </ul></div>
                                <div><h4>5. Cookies and Tracking Technologies</h4>
                                <p>We use cookies to enhance your experience. Manage your cookie preferences through browser settings.</p></div>
                                <div><h4>6. Third-Party Links</h4>
                                <p>We are not responsible for the privacy practices of third-party websites linked from our platform. Review their privacy policies before sharing information.</p></div>
                                <div><h4>7. Changes to This Privacy Policy</h4>
                                <p>We may update this policy. Significant changes will be posted on our website.</p></div>',
                    'is_array' => 0
                ]
            ];
        }
    }

    public function getContentBannerData($pageId)
    {
        $page = Page::find($pageId);
        $preHeading = $heading = $paragraph = $studentBtnTxt = $tutorBtnTxt = $studentBtnUrl = $tutorBtnUrl = '';
        if ($page->slug == 'about-us') {
            $preHeading = 'About Us';
            $heading    = 'Empowering learners worldwide';
            $paragraph  = 'We are dedicated to providing personalized online tutoring experiences that unlock every learner\'s potential.';
        } elseif ($page->slug == 'terms-condition') {
            $preHeading = 'Terms and Conditions';
            $heading    = 'Empowering learners worldwide';
            $paragraph  = 'We are dedicated to providing personalized online tutoring experiences that unlock every learner\'s potential.';
        } elseif ($page->slug == 'privacy-policy') {
            $preHeading = 'Privacy Policy';
            $heading    = 'Empowering learners worldwide';
            $paragraph  = 'We are dedicated to providing personalized online tutoring experiences that unlock every learner\'s potential.';
        } elseif ($page->slug == 'how-it-works') {
            $preHeading     = 'We guarantee quality process';
            $heading        = 'Let’s join our community today';
            $paragraph      = 'Join our community to either share your expertise as an tutor or enhance your skills as a student. Connect, learn, and grow with us today.';
            $studentBtnTxt  = 'Join as student';
            $studentBtnUrl  = 'register';
            $tutorBtnTxt    = 'Join as tutor';
            $tutorBtnUrl    = 'register';
        } elseif ($page->slug == 'faq') {
            $preHeading = 'Find Your Answer';
            $heading    = 'Empowering learners worldwide';
            $paragraph  = 'We are dedicated to providing personalized online tutoring experiences that unlock every learner\'s potential.';
        } elseif ($page->slug == 'student-subscriptions' || $page->slug == 'tutor-subscriptions') {
            $preHeading = 'Frequently Asked Questions';
            $heading    = 'Unlock Your eLearning Potential!';
            $paragraph  = 'Discover Common Solutions and Access Official Guidance';
        }
        if ($page->section_id == 'content-banner_4') {
            return [
                'pre_heading'           => ['value' => $preHeading, 'is_array' => 0],
                'heading'               => ['value' => $heading, 'is_array' => 0],
                'paragraph'             => ['value' => $paragraph, 'is_array' => 0],
                'student_btn_url'       => ['value' => $studentBtnUrl, 'is_array' => 0],
                'student_btn_txt'       => ['value' => $studentBtnTxt, 'is_array' => 0],
                'tutor_btn_url'         => ['value' => $tutorBtnUrl, 'is_array' => 0],
                'tutor_btn_txt'         => ['value' => $tutorBtnTxt, 'is_array' => 0],
            ];
        }
        return [
            'pre_heading'           => ['value' => $preHeading, 'is_array' => 0],
            'heading'               => ['value' => $heading, 'is_array' => 0],
            'paragraph'             => ['value' => $paragraph, 'is_array' => 0],
        ];
    }

    public function getMissionData($pageId)
    {
        $page = Page::find($pageId);

        return [
            'button_enabled'        => ['value' => $page->slug == 'home-eight' ? 'yes' : 'no', 'is_array' => 0],
            'button_text'           => ['value' => 'Discover More', 'is_array' => 0],
            'button_url'            => ['value' => 'register', 'is_array' => 0],
            'style_variation'       => ['value' => $page->slug == 'home-eight' ? 'am-mission-variation-one' : '', 'is_array' => 0],
            'select_title_verient'  => ['value' => $page->slug == 'home-eight' ? 'am-title-varient-one' : '', 'is_array' => 0],
            'pre_heading'           => ['value' => 'Mission', 'is_array' => 0],
            'heading'               => ['value' => 'Our Commitment: Empowering Learners', 'is_array' => 0],
            'paragraph'             => ['value' => 'To empower learners of all ages and backgrounds by connecting them with expert tutors worldwide, fostering personalized and effective learning experiences that inspire growth, confidence, and lifelong success.', 'is_array' => 0],
            'mission_frame_image'   => ['value' => [uploadObMedia('demo-content/aboutus/mission-frame.png')], 'is_array' => '1'],
            'user_one_image'        => ['value' => [uploadObMedia('demo-content/aboutus/mission-user-one.png')], 'is_array' => '1'],
            'handshake_image'       => ['value' => [uploadObMedia('demo-content/aboutus/handshake.svg')], 'is_array' => '1'],
            'user_two_image'        => ['value' => [uploadObMedia('demo-content/aboutus/mission-user-two.png')], 'is_array' => '1'],
            'image_heading'         => ['value' => 'World\'s Largest Online Learning Platform', 'is_array' => 0],
            'courses_text'          => ['value' => '<strong>40+</strong>Active Courses', 'is_array' => 0],
            'list_data'             => ['value' =>  [
                $this->uniqueId() => [
                    'item_heading'   => 'Global Reach and Inclusivity',
                    'list_item'      => 'Connecting learners with expert tutors for equal education access.',
                ],
                $this->uniqueId() => [
                    'item_heading'   => 'Personalized Learning Journeys',
                    'list_item'     => 'Creating customized learning experiences tailored to each student\'s needs.',
                ],
                $this->uniqueId() => [
                    'item_heading'   => 'Building a Community of Excellence',
                    'list_item'      => 'Fostering a vibrant community of learners and educators for lifelong growth.',
                ],
            ], 'is_array' => '1']
        ];
    }

    public function getVisionData($pageId)
    {
        return [
            'video'                 => ['value' => [uploadObMedia('demo-content/aboutus/vision.mp4')], 'is_array' => '1'],
            'pre_heading'           => ['value' => 'Vision', 'is_array' => 0],
            'heading'               => ['value' => 'Our Vision. Drive Learning Growth', 'is_array' => 0],
            'paragraph'             => ['value' => 'To be the leading global platform for personalized education, where every student has access to the highest quality tutoring and every tutor can reach and impact learners across the globe, creating a future where education is tailored, accessible, and transformative for all.', 'is_array' => 0],
            'discover_more_btn_url' => ['value' => 'register', 'is_array' => 0],
            'discover_more_btn_text' => ['value' => 'Discover More', 'is_array' => 0],
            'list_data'             => ['value' =>  [
                $this->uniqueId() => [
                    'item_heading'   => 'Accessible Education for All',
                    'list_item'      => 'Empowering students to learn from the best, anywhere.',
                ],
                $this->uniqueId() => [
                    'item_heading'   => 'Empowering Tutors Globally',
                    'list_item'     => 'Enabling tutors to reach and inspire students across the globe.',
                ],
                $this->uniqueId() => [
                    'item_heading'   => 'Transformative Learning Experiences',
                    'list_item'      => 'Shaping a future of personalized, impactful education for all.',
                ],
            ], 'is_array' => '1']
        ];
    }

    public function getExperiencedTutorsData($pageId)
    {
        $page = Page::find($pageId);
        // $preHeading = $heading = $paragraph = $selectVerient = $shapeImage = $secondShapeImage = '';
        // if($page->slug == 'home-three' || $page->slug == 'home-four'){
        //     $preHeading     = 'Feature Tutors';
        //     $heading        = 'Explore Our Handpicked Tutors';
        //     $paragraph      = 'Discover a wealth of articles, guides, and tutorials curated by our experts to enhance your learning.';
        //     $shapeImage     = [uploadObMedia('demo-content/home-v2/shape.png')];
        //     $secondShapeImage = [uploadObMedia('demo-content/featureshape.png')];
        // } elseif($page->slug == 'home-two'){
        //     $preHeading     = 'Feature Tutors';
        //     $heading        = 'Explore Our Handpicked Tutors';
        //     $paragraph      = 'Discover a wealth of articles, guides, and tutorials curated by our experts to enhance your learning.';

        // } elseif($page->slug == '/') {
        //     $preHeading     = 'Experienced tutors';
        //     $heading        = 'Meet Our Top Educators';
        //     $paragraph      = 'Discover how Lernen is making a difference in the lives of students and educational institutions. Hear from our satisfied users:';
        // }
        if ($page->slug == 'home-four') {
            return [
                'section_title_variation' => ['value' => 'am-section_title_two', 'is_array' => 0],
                'select_tutor'          => ['value' => 8, 'is_array' => 0],
                'pre_heading'           => ['value' => 'Feature Tutors', 'is_array' => 0],
                'heading'               => ['value' => 'Explore Our Handpicked Tutors', 'is_array' => 0],
                'paragraph'             => ['value' => 'Discover a wealth of articles, guides, and tutorials curated by our experts to enhance your learning.', 'is_array' => 0],
                '1st_shape_image'       => ['value' => [uploadObMedia('demo-content/bgshape.png')], 'is_array' => '1'],
                'view_tutor_btn_url'    => ['value' => 'find-tutors', 'is_array' => 0],
                'view_tutor_btn_text'   => ['value' => 'View profile', 'is_array' => 0],
                'select_verient'        => ['value' => 'am-tutors-varient-one', 'is_array' => 0],
            ];
        } elseif ($page->slug == 'home-three' || $page->slug == 'home-five') {
            return [
                'section_title_variation'   => ['value' => $page->slug == 'home-three' ? 'am-section_title_two' : 'am-section_title_three', 'is_array' => 0],
                'select_tutor'          => ['value' => 8, 'is_array' => 0],
                'pre_heading'           => ['value' => 'Feature Tutors', 'is_array' => 0],
                'heading'               => ['value' => 'Explore Our Handpicked Tutors', 'is_array' => 0],
                'paragraph'             => ['value' => 'Discover a wealth of articles, guides, and tutorials curated by our experts to enhance your learning.', 'is_array' => 0],
                '1st_shape_image'       => ['value' => [uploadObMedia('demo-content/home-v2/shape.png')], 'is_array' => '1'],
                '2nd_shape_image'       => ['value' => [uploadObMedia('demo-content/featureshape.png')], 'is_array' => '1'],
                'view_tutor_btn_url'    => ['value' => 'find-tutors', 'is_array' => 0],
                'view_tutor_btn_text'   => ['value' => 'View profile', 'is_array' => 0],
                'select_verient'        => ['value' => 'am-tutors-varient-two', 'is_array' => 0],
                'style_verient'         => ['value' => $page->slug == 'home-three' ? 'style-varient' : '', 'is_array' => 0],
            ];
        } elseif ($page->slug == 'home-two') {  
            return [
                'section_title_variation'   => ['value' => 'am-section_title_one', 'is_array' => 0],
                'select_tutor'          => ['value' => 5, 'is_array' => 0],
                'pre_heading'           => ['value' => 'Feature Tutors', 'is_array' => 0],
                'heading'               => ['value' => 'Explore Our Handpicked Tutors', 'is_array' => 0],
                'paragraph'             => ['value' => 'Discover a wealth of articles, guides, and tutorials curated by our experts to enhance your learning.', 'is_array' => 0],
                'view_tutor_btn_url'    => ['value' => 'find-tutors', 'is_array' => 0],
                'view_tutor_btn_text'   => ['value' => 'View profile', 'is_array' => 0],
                'select_verient'        => ['value' => 'am-tutors-varient-two', 'is_array' => 0],
            ];
        } else {
            return [
                'section_title_variation'   => ['value' => '', 'is_array' => 0],
                'select_tutor'          => ['value' => 4, 'is_array' => 0],
                'pre_heading'           => ['value' => 'Experienced tutors', 'is_array' => 0],
                'heading'               => ['value' => 'Meet Our Top Educators', 'is_array' => 0],
                'paragraph'             => ['value' => 'Discover how Lernen is making a difference in the lives of students and educational institutions. Hear from our satisfied users:', 'is_array' => 0],
                'view_tutor_btn_url'    => ['value' => 'find-tutors', 'is_array' => 0],
                'view_tutor_btn_text'   => ['value' => 'View profile', 'is_array' => 0],
                'select_verient'        => ['value' => 'am-tutors-varient-one', 'is_array' => 0],
            ];
        }
    }

    public function getFeaturedMentorsData($pageId, $sectionId = null)
    {
        $bgColorVerient = '';

        $page = Page::find($pageId);
        $heading = '';
        if($page->slug == 'home-seven' || $page->slug == 'home-eight'){
            $heading = 'Top Notch Mentors by Grades';
        } else{
            $heading = 'Our Handpicked Mentors';
        }
    

        if($page->slug == 'home-eight'){
            return [
                'section_title_variation'   => ['value' => 'am-section_title_two', 'is_array' => 0],
                'bg_color_verient'          => ['value' => '', 'is_array' => 0],
                'select_verient'            => ['value' => 'am-tutors-varient-four', 'is_array' => 0],
                'right_shape_image'         => ['value' => [uploadObMedia('demo-content/bgshape.png')], 'is_array' => '1'],
                'pre_heading'               => ['value' => 'Featured Mentors', 'is_array' => 0],
                'heading'                   => ['value' => $heading, 'is_array' => 0],
                'paragraph'                 => ['value' => 'Access articles, guides, and tutorials curated by experts to enhance your learning.', 'is_array' => 0],
                'view_tutor_btn_url'        => ['value' => 'find-tutors', 'is_array' => 0],
                'view_tutor_btn_text'       => ['value' => 'View All Tutors', 'is_array' => 0],
                'explore_mentors_btn_url'   => ['value' => 'find-tutors', 'is_array' => 0],
                'explore_mentors_btn_text'  => ['value' => 'Explore Mentors', 'is_array' => 0],
            ];
        }elseif($sectionId == 'featured-mentors_3' || $page->slug == 'home-seven'){
            return [
                'section_title_variation'   => ['value' => $page->slug == 'home-seven' ? 'am-section_title_two' : 'am-section_title_three', 'is_array' => 0],
                'bg_color_verient'          => ['value' => '', 'is_array' => 0],
                'select_verient'            => ['value' => 'am-tutors-varient-two', 'is_array' => 0],
                'pre_heading'               => ['value' => 'Featured Mentors', 'is_array' => 0],
                'heading'                   => ['value' => $heading, 'is_array' => 0],
                'paragraph'                 => ['value' => 'Access articles, guides, and tutorials curated by experts to enhance your learning.', 'is_array' => 0],
                'view_tutor_btn_url'        => ['value' => 'find-tutors', 'is_array' => 0],
                'view_tutor_btn_text'       => ['value' => 'View All Tutors', 'is_array' => 0],
                'explore_mentors_btn_url'   => ['value' => 'find-tutors', 'is_array' => 0],
                'explore_mentors_btn_text'  => ['value' => 'Explore Mentors', 'is_array' => 0],
            ];
        } elseif ($sectionId == 'featured-mentors_4') {
            return [
                'section_title_variation'   => ['value' => 'am-section_title_three', 'is_array' => 0],
                'bg_color_verient'          => ['value' => 'am-featured-mentors-two', 'is_array' => 0],
                'select_verient'            => ['value' => 'am-tutors-varient-two', 'is_array' => 0],
                'left_shape_image'          => ['value' => [uploadObMedia('demo-content/home-v5/bg-image-03.png')], 'is_array' => '1'],
                'right_shape_image'         => ['value' => [uploadObMedia('demo-content/home-v5/bg-image-04.png')], 'is_array' => '1'],
                'pre_heading'               => ['value' => 'Featured Mentors', 'is_array' => 0],
                'heading'                   => ['value' => $heading, 'is_array' => 0],
                'paragraph'                 => ['value' => 'Access articles, guides, and tutorials curated by experts to enhance your learning.', 'is_array' => 0],
                'view_tutor_btn_url'        => ['value' => 'find-tutors', 'is_array' => 0],
                'view_tutor_btn_text'       => ['value' => 'View All Tutors', 'is_array' => 0],
                'explore_mentors_btn_url'   => ['value' => 'find-tutors', 'is_array' => 0],
                'explore_mentors_btn_text'  => ['value' => 'Explore Mentors', 'is_array' => 0],
            ];
        } else{
            return [ 
                'section_title_variation'   => ['value' => $page->slug == 'home-nine' ? 'am-section_title_two' : 'am-section_title_three', 'is_array' => 0],
                'bg_color_verient'          => ['value' => $page->slug == 'home-nine' ? '' : 'am-featured-mentors-two', 'is_array' => 0],
                'select_verient'            => ['value' => $page->slug == 'home-nine' ? 'am-tutors-varient-five' : 'am-tutors-varient-two', 'is_array' => 0],
                'left_shape_image'          => ['value' => $page->slug == 'home-nine' ? [uploadObMedia('demo-content/home-v9/bg-img-03.png')] : [uploadObMedia('demo-content/home-v5/bg-image-03.png')], 'is_array' => '1'],
                'right_shape_image'         => ['value' => $page->slug == 'home-nine' ? [uploadObMedia('demo-content/home-v9/bg-img-04.png')] : [uploadObMedia('demo-content/home-v5/bg-image-04.png')], 'is_array' => '1'],
                'pre_heading'               => ['value' => 'Featured Mentors', 'is_array' => 0],
                'heading'                   => ['value' => $heading, 'is_array' => 0],
                'paragraph'                 => ['value' => 'Access articles, guides, and tutorials curated by experts to enhance your learning.', 'is_array' => 0],
                'view_tutor_btn_url'        => ['value' => 'find-tutors', 'is_array' => 0],
                'view_tutor_btn_text'       => ['value' => 'View All Tutors', 'is_array' => 0],
                'explore_mentors_btn_url'   => ['value' => 'find-tutors', 'is_array' => 0],
                'explore_mentors_btn_text'  => ['value' => 'Explore Mentors', 'is_array' => 0],
            ];
        }
    }

    public function getAchievementsData($pageId)
    {
        return [
            'shape_image'           => ['value' => [uploadObMedia('demo-content/section-shape.png')], 'is_array' => '1'],
            'shape_second_image'    => ['value' => [uploadObMedia('demo-content/aboutus/placeholder-achievements.svg')], 'is_array' => '1'],
            'pre_heading'           => ['value' => 'Key Achievements', 'is_array' => 0],
            'heading'               => ['value' => 'Our Commitment to Excellence', 'is_array' => 0],
            'paragraph'             => ['value' => 'These figures highlight our ongoing efforts to maintain high standards and continuous improvement in all we do.', 'is_array' => 0],
            'repeater_data'         => ['value' =>  [
                $this->uniqueId() => [
                    'icon'          => 'am-icon-book-1',
                    'sub_heading'   => '40+ <span>Active subjects</span>',
                ],
                $this->uniqueId() => [
                    'icon'          => 'am-icon-user-cross-1',
                    'sub_heading'   => '124,234 <span>Students enrolled</span>',
                ],
                $this->uniqueId() => [
                    'icon'          => 'am-icon-user-contact',
                    'sub_heading'   => '500+ <span>Tutors available</span>',
                ],
                $this->uniqueId() => [
                    'icon'          => 'am-icon-star-01',
                    'sub_heading'   => '56,234 <span>5 star reviews</span>',
                ],
            ], 'is_array' => '1']
        ];
    }
    
    public function getClientsFeedbackData($pageId, $encodeMedia = true)
    {
        $page = Page::find($pageId);
        $preHeading = $paragraph = $feedbackVerient = $sectionTitleVariation = '';
        if ($page->slug == 'home-eight' || $page->slug == 'home-six' || $page->slug == 'home-five' || $page->slug == 'home-four') {
            $preHeading = 'Testimonials';
            $paragraph  =  'Learn how Lernen impacts students and educational institutions through testimonials from our satisfied users';
        } elseif($page->slug == 'home-nine'){
            $preHeading = 'Testimonials';
            $paragraph  = 'Discover how Lernen is making a difference in the lives of students and educational institutions.';
        } else{
            $preHeading = 'Real Feedback from Our Clients';
            $paragraph  = 'Discover how Lernen is making a difference in the lives of students and educational institutions. Hear from our satisfied users';
        }

        if ($page->slug == 'home-four') {
            $feedbackVerient = 'feedback-verient-one';
        } elseif ($page->slug == 'home-five') {
            $feedbackVerient = 'feedback-verient-two';
        } elseif ($page->slug == 'home-six') {
            $feedbackVerient = 'am-feedback-verient-three';
        } else{
            $feedbackVerient = '';
        }
        if($page->slug == 'home-two'){
            $sectionTitleVariation = 'am-section_title_one';
        } elseif($page->slug == 'home-four'){
            $sectionTitleVariation = 'am-section_title_two';
        } elseif($page->slug == 'home-five'){
            $sectionTitleVariation = 'am-section_title_three';
        } elseif($page->slug == 'home-eight' || $page->slug == 'home-nine' || $page->slug == 'home-six'){
            $sectionTitleVariation = 'am-section_title_two';
        } else {
            $sectionTitleVariation = '';
        }

        return [
            'section_title_variation'  => ['value' => $sectionTitleVariation, 'is_array' => 0],
            'verient'                  => ['value' => $feedbackVerient, 'is_array' => 0],
            'pre_heading'              => ['value' => $preHeading, 'is_array' => 0],
            'heading'                  => ['value' => 'What Our Users Are Saying', 'is_array' => 0],
            'paragraph'                => ['value' => $paragraph, 'is_array' => 0],
            'student_btn_txt'          => ['value' => 'As a student', 'is_array' => 0],
            'tutor_btn_txt'            => ['value' => 'As a tutor', 'is_array' => 0],
            'enable_slider'            => ['value' => in_array($page->slug, ['home-two', 'home-four', 'home-five', 'home-six']) ? 'yes' : 'no', 'is_array' => 0],
            'feedback_repeater'    => ['value' =>  [
                $this->uniqueId() => [
                    'feedback_paragraph'    => 'We have tried several tutoring platforms, but none compare to Lernen. The tutors are top-notch, and the booking process is incredibly.',
                    'tutor_rating'          => 4,
                    'tutor_image'           => [$encodeMedia ? json_encode(uploadObMedia('demo-content/home-page/customer-01.png')) : uploadObMedia('demo-content/home-page/customer-01.png')],
                    'tutor_name'            => 'Arlene M',
                    'tutor_tagline'         => 'Agile District',
                    'student_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/feedback-user/logo-1.png')) : uploadObMedia('demo-content/feedback-user/logo-1.png')],
                ],
                $this->uniqueId() => [
                    'feedback_paragraph'    => 'Lernen is a dependable and effective tool for our agency, offering knowledgeable and dedicated tutors.',
                    'tutor_rating'          => 4,
                    'tutor_image'           => [$encodeMedia ? json_encode(uploadObMedia('demo-content/home-page/customer-02.png')) : uploadObMedia('demo-content/home-page/customer-02.png')],
                    'tutor_name'            => 'Ronald R',
                    'tutor_tagline'         => 'Educational Consultant',
                    'student_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/feedback-user/logo-2.png')) : uploadObMedia('demo-content/feedback-user/logo-2.png')],
                ],
                $this->uniqueId() => [
                    'feedback_paragraph'    => "Lernen has been a game-changer for our students. The variety of tutors and the ease of booking  sessions make it a breeze for parents and students alike. Our students' grades have improved Our students' grades have improved significantly since we started using this platform.",
                    'tutor_rating'          => 5,
                    'tutor_image'           => [$encodeMedia ? json_encode(uploadObMedia('demo-content/home-page/customer-03.png')) : uploadObMedia('demo-content/home-page/customer-03.png')],
                    'tutor_name'            => 'Marvin M',
                    'tutor_tagline'         => 'Tutoring Specialist',
                    'student_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/feedback-user/logo-3.png')) : uploadObMedia('demo-content/feedback-user/logo-3.png')],
                ],
                $this->uniqueId() => [
                    'feedback_paragraph'    => 'We’re delighted with Lernen its top-notch tutors and user-friendly platform have greatly boosted our students.',
                    'tutor_rating'          => 5,
                    'tutor_image'           => [$encodeMedia ? json_encode(uploadObMedia('demo-content/home-page/customer-01.png')) : uploadObMedia('demo-content/home-page/customer-01.png')],
                    'tutor_name'            => 'Courtney H',
                    'tutor_tagline'         => 'School Counselor',
                    'student_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/feedback-user/logo-4.png')) : uploadObMedia('demo-content/feedback-user/logo-4.png')],
                ],
                $this->uniqueId() => [
                    'feedback_paragraph'    => 'Lernen is a fantastic resource for our students. The diverse range of tutors ensures that we can find the perfect match for each student\'s.',
                    'tutor_rating'          => 4,
                    'tutor_image'           => [$encodeMedia ? json_encode(uploadObMedia('demo-content/home-page/customer-02.png')) : uploadObMedia('demo-content/home-page/customer-02.png')],
                    'tutor_name'            => 'Devon L',
                    'tutor_tagline'         => 'Classroom Teacher',
                    'student_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/feedback-user/logo-5.png')) : uploadObMedia('demo-content/feedback-user/logo-5.png')],
                ],
                $this->uniqueId() => [
                    'feedback_paragraph'    => 'Our experience with Lernen has been outstanding. The platform is user-friendly, & the tutors are highly qualified.',
                    'tutor_rating'          => 5,
                    'tutor_image'           => [$encodeMedia ? json_encode(uploadObMedia('demo-content/home-page/customer-03.png')) : uploadObMedia('demo-content/home-page/customer-03.png')],
                    'tutor_name'            => 'Darlene R',
                    'tutor_tagline'         => 'Academic Advisor',
                    'student_image'         => [$encodeMedia ? json_encode(uploadObMedia('demo-content/feedback-user/logo-6.png')) : uploadObMedia('demo-content/feedback-user/logo-6.png')],
                ],
            ], 'is_array' => '1'],
        ];
    }

    public function getUniqueFeaturesData($pageId)
    {
        $page = Page::find($pageId);
        $sectionThreeThirdImage = $selectVerient =  $paragraph = $sectionTitleVariation = '';
        if ($page->slug == 'home-five') {
            $sectionThreeThirdImage = [uploadObMedia('demo-content/home-v2/tutor-img-green.png')];
        } else{
            $sectionThreeThirdImage = [uploadObMedia('demo-content/home-v2/tutor-img-4.png')];
        }

        if($page->slug == 'home-nine'){
            $paragraph = 'Explore a wealth of articles, guides, tutorials, and more, curated by our experts to enhance your learning experience.';
        } else{
            $paragraph = 'With advanced customization & powerful features, everything you need is in one place.';
        }

        if ($page->slug == 'home-three' || $page->slug == 'home-nine') {
            $sectionTitleVariation = 'am-section_title_two';
            $selectVerient = 'unique-features-varient-three';
        } elseif ($page->slug == 'home-four') {
            $sectionTitleVariation = 'am-section_title_two';
            $selectVerient = 'unique-features-varient-two';
        } elseif ($page->slug == 'home-five') {
            $sectionTitleVariation = 'am-section_title_three';
            $selectVerient = 'unique-features-varient-one';
        } else{
            $sectionTitleVariation = '';
            $selectVerient         = '';
        }

        return [
            'section_title_variation'   => ['value' => $sectionTitleVariation, 'is_array' => 0],
            'select_verient'            => ['value' => $selectVerient, 'is_array' => 0],
            'pre_heading'               => ['value' => 'Unique Features', 'is_array' => 0],
            'heading'                   => ['value' => 'Unlimited Features & Boundless Opportunities', 'is_array' => 0],
            'paragraph'                 => ['value' => $paragraph, 'is_array' => 0],
            'section1_heading'          => ['value' => 'Effortless scheduling for seamless learning', 'is_array' => 0],
            'section1_image'            => ['value' => [uploadObMedia('demo-content/home-v2/feature-image.png')], 'is_array' => '1'],
            'section1_2nd_image'        => ['value' => [uploadObMedia('demo-content/home-v2/bell-img.png')], 'is_array' => '1'], 

            'section2_heading'          => ['value' => 'Track and record your detailed learning progress', 'is_array' => 0],
            'section2_image'            => ['value' => [uploadObMedia('demo-content/home-v2/progress-img1.svg')], 'is_array' => '1'],
            'section2_2nd_image'        => ['value' => [uploadObMedia('demo-content/home-v2/progress-img2.png')], 'is_array' => '1'],
            'section2_3rd_image'        => ['value' => [uploadObMedia('demo-content/home-v2/progress-img3.png')], 'is_array' => '1'],
            'section2_4th_image'        => ['value' => [uploadObMedia('demo-content/home-v2/progress-pattran-img.png')], 'is_array' => '1'],

            'section3_heading'          => ['value' => 'Enhance learning with our vetted tutors', 'is_array' => 0],
            'section3_image'            => ['value' => [uploadObMedia('demo-content/home-v2/tutor-img-3.png')], 'is_array' => '1'],
            'section3_2nd_image'        => ['value' => [uploadObMedia('demo-content/home-v2/tutor-img-2.png')], 'is_array' => '1'],
            'section3_3rd_image'        => ['value' => $sectionThreeThirdImage, 'is_array' => '1'],

            'section4_heading'          => ['value' => 'Personalize learning: your time, your way', 'is_array' => 0],
            'section4_image'            => ['value' => [uploadObMedia('demo-content/home-v2/tutor-img-1.png')], 'is_array' => '1'],
            'section4_2nd_image'        => ['value' => [uploadObMedia('demo-content/home-v2/tutor-img.png')], 'is_array' => '1'],

            'bg_shape_img'              => ['value' => [uploadObMedia('demo-content/home-v2/feature-border-image.svg')], 'is_array' => '1'],
            'shape_img'                 => ['value' => [uploadObMedia('demo-content/home-v5/placeholder-features-varient-one.png')], 'is_array' => '1'],
        ];
    }

    public function getMarketplaceStandsOutData($pageId)
    {
        $page = Page::find($pageId);
        $selectVerient =  $sectionTitleVariation = $shapeImage = '';

        if($page->slug == 'home-seven'){
            $selectVerient = 'marketplace-stands-out-varient-one';
        } elseif($page->slug == 'home-eight'){
            $selectVerient = 'marketplace-stands-out-varient-two';
        } else{
            $selectVerient = '';
        }

        if($page->slug == 'home-six' || $page->slug == 'home-seven' || $page->slug == 'home-eight'){
            $sectionTitleVariation = 'am-section_title_two';
        } else{
            $sectionTitleVariation = '';
        }

        return [
            'section_title_variation'   => ['value' => $sectionTitleVariation, 'is_array' => 0],
            'select_verient'            => ['value' => $selectVerient, 'is_array' => 0],
            'pre_heading'               => ['value' => 'Why Choose Us', 'is_array' => 0],
            'heading'                   => ['value' => 'Why Our Marketplace Stands Out', 'is_array' => 0],
            'paragraph'                 => ['value' => 'Explore a wealth of articles, guides, tutorials, and more, curated by our experts to enhance your learning experience.', 'is_array' => 0],
            'section1_heading'          => ['value' => '15K+ Highly Qualified & Experienced Tutors', 'is_array' => 0],
            'section1_paragraph'        => ['value' => 'Discover expert-curated articles, guides, and tutorials to boost your learning.', 'is_array' => 0],
            'section1_video'            => ['value' => [uploadObMedia('demo-content/videos/woman_home.mp4')], 'is_array' => '1'],

            'section2_heading'          => ['value' => 'Effortless scheduling for seamless learning', 'is_array' => 0],
            'section2_paragraph'        => ['value' => 'Plan your sessions with ease and focus on learning. Our streamlined scheduling ensures you never miss a lesson.', 'is_array' => 0],
            'section2_image'            => ['value' => [uploadObMedia('demo-content/home-v6/chooseus-img01.jpg')], 'is_array' => '1'],

            'section3_heading'          => ['value' => '24 hours Support', 'is_array' => 0],
            'section3_paragraph'        => ['value' => 'Access dedicated support for your online tutoring experience. We\'re here to assist you every step of the way.', 'is_array' => 0],
            'section3_image'            => ['value' => [uploadObMedia('demo-content/home-v6/chooseus-img02.jpg')], 'is_array' => '1'],

            'bg_shape_img'              => ['value' => [uploadObMedia('demo-content/home-v6/bg-img.svg')], 'is_array' => '1'],
        ];
    }

    public function getSpacerData($pageId)
    {
        return [];
    }

    public function getCategoriesV1($page, $sectionId)
    {
        return [
            'section_title_variation'   => ['value' => $page->slug == 'home-five' ? 'am-section_title_three' : 'am-section_title_two', 'is_array' => 0],
            'categories_verient'        => ['value' => 'verient-one', 'is_array' => 0],
            'pre_heading'               => ['value' => 'Categories', 'is_array' => 0],
            'heading'                   => ['value' => 'Explore Mentorship Categories', 'is_array' => 0],
            'paragraph'                 => ['value' => 'Discover categories designed to help you excel in your professional and personal growth.', 'is_array' => 0],
            'all_category_heading'      => ['value' => 'Discover All Categories', 'is_array' => 0],
            'all_category_paragraph'    => ['value' => 'Build responsive websites with expert guidance.', 'is_array' => 0],
            'view_category_btn_url'     => ['value' => 'find-tutors', 'is_array' => 0],
            'view_category_btn_txt'     => ['value' => 'View Categories', 'is_array' => 0],
            'categories_repeater'       => ['value' => [
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img01.png')],
                    'category_heading'     => 'Web Development',
                    'category_paragraph'   => 'Build responsive websites with expert guidance.',
                    'explore_more_btn_url' => url('find-tutors?subject_id=1'),
                    'explore_more_btn_txt' => 'Explore more'
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img02.png')],
                    'category_heading'     => 'Software Design',
                    'category_paragraph'   => 'Build responsive websites with expert guidance.',
                    'explore_more_btn_url' => url('find-tutors?subject_id=4'),
                    'explore_more_btn_txt' => 'Explore more'
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img03.png')],
                    'category_heading'     => 'Content Writing',
                    'category_paragraph'   => 'Build responsive websites with expert guidance.',
                    'explore_more_btn_url' => url('find-tutors'),
                    'explore_more_btn_txt' => 'Explore more'
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img04.png')],
                    'category_heading'     => 'Social Studies',
                    'category_paragraph'   => 'Build responsive websites with expert guidance.',
                    'explore_more_btn_url' => url('find-tutors?subject_id=8'),
                    'explore_more_btn_txt' => 'Explore more'
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img05.png')],
                    'category_heading'     => 'Physical Education',
                    'category_paragraph'   => 'Build responsive websites with expert guidance.',
                    'explore_more_btn_url' => url('find-tutors?subject_id=11'),
                    'explore_more_btn_txt' => 'Explore more'
                ]
            ], 'is_array' => '1']
        ];
    }

    public function getCategoriesV2($page, $sectionId)
    {
       
        $variation =  $sectionTitleVariation = '';
        if ($page->slug == 'home-five' && $sectionId == 'categories_2') {
            $variation = 'verient-two';
        } else {
            $variation = 'am-verient-three';
        }   

        if($page->slug == 'home-eight' || $page->slug == 'home-six'){
            $sectionTitleVariation = 'am-section_title_two';
        } elseif($page->slug == 'home-five'){
            $sectionTitleVariation = 'am-section_title_three';
        } else{
            $sectionTitleVariation = '';
        }

        return [
            'section_title_variation'   => ['value' => $sectionTitleVariation, 'is_array' => 0],
            'categories_verient'        => ['value' => $variation, 'is_array' => 0],
            'pre_heading'               => ['value' => 'Categories', 'is_array' => 0],
            'heading'                   => ['value' => 'Explore Mentorship Categories', 'is_array' => 0],
            'paragraph'                 => ['value' => 'Discover categories designed to help you excel in your professional and personal growth.', 'is_array' => 0],
            'view_category_btn_url'     => ['value' => 'find-tutors', 'is_array' => 0],
            'view_category_btn_txt'     => ['value' => 'View Categories', 'is_array' => 0],
            'categories_repeater'       => ['value' => [
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img06.png')],
                    'category_heading'     => 'Web Development',
                    'explore_more_btn_url' => url('find-tutors?subject_id=1'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img02.png')],
                    'category_heading'     => 'Software Design',
                    'explore_more_btn_url' => url('find-tutors?subject_id=4'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img05.png')],
                    'category_heading'     => 'Physical Education',
                    'explore_more_btn_url' => url('find-tutors?subject_id=11'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img04.png')],
                    'category_heading'     => 'Social Studies',
                    'explore_more_btn_url' => url('find-tutors?subject_id=8'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img03.png')],
                    'category_heading'     => 'Content Writing',
                    'explore_more_btn_url' => url('find-tutors'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img07.png')],
                    'category_heading'     => 'Finance',
                    'explore_more_btn_url' => url('find-tutors'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img08.png')],
                    'category_heading'     => 'Science',
                    'explore_more_btn_url' => url('find-tutors?subject_id=10'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img09.png')],
                    'category_heading'     => 'English',
                    'explore_more_btn_url' => url('find-tutors?subject_id=6'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img10.png')],
                    'category_heading'     => 'Communication',
                    'explore_more_btn_url' => url('find-tutors'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img11.png')],
                    'category_heading'     => 'Blogging',
                    'explore_more_btn_url' => url('blogs'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img12.png')],
                    'category_heading'     => 'Graphic Design',
                    'explore_more_btn_url' => url('find-tutors'),
                ]
            ], 'is_array' => '1']
        ];
    }

    public function getLimitlessFeaturesData($pageId)
    {
        return [
            'heading'               => ['value' => 'Limitless features and endless possibilities', 'is_array' => 0],
            'paragraph'             => ['value' => 'Explore endless and  limitless opportunities to enhance your skills, connect with mentors, and achieve your learning goals.', 'is_array' => 0],
            'btn_txt'               => ['value' => 'Get Started', 'is_array' => 0],
            'btn_url'               => ['value' => 'login', 'is_array' => 0],
            'image'                 => ['value' => [uploadObMedia('demo-content/home-v5/limitless-img.png')], 'is_array' => '1'],
            'shape_image'           => ['value' => [uploadObMedia('demo-content/home-v5/feature-border-img.svg')], 'is_array' => '1'],
            'second_shape_image'    => ['value' => [uploadObMedia('demo-content/home-v5/feature-border-img02.png')], 'is_array' => '1'],
            'left_shape_image'      => ['value' => [uploadObMedia('demo-content/home-v5/feature-img03.png')], 'is_array' => '1'],
            'right_shape_image'     => ['value' => [uploadObMedia('demo-content/bgshape.png')], 'is_array' => '1'],
        ];
    }

    public function getSubscriptionBannerData($pageId)
    {
        $page = Page::find($pageId);
        return [
            'heading'           => ['value' => '<span>Premium Features </span>and tools for an enhanced eLearning experience.', 'is_array' => 0],
            'paragraph'         => ['value' => 'Access advanced tools, personalized support, and exclusive features for a smoother eLearning experience.', 'is_array' => 0],
            'student_btn_url'   => ['value' => url('student-subscriptions'), 'is_array' => 0],
            'student_btn_txt'   => ['value' => 'Student Packages', 'is_array' => 0],
            'tutor_btn_url'     => ['value' => url('tutor-subscriptions'), 'is_array' => 0],
            'tutor_btn_txt'     => ['value' => 'Tutor Packages', 'is_array' => 0],
            'active_banner_btn' => ['value' => $page?->slug  ==  'student-subscriptions' ? 'student' : 'tutor', 'is_array' => 0],
            'banner_image'      => ['value' => [uploadObMedia('modules/subscriptions/demo-content/'.($page?->slug == 'student-subscriptions' ? 'student' : 'tutor').'-banner.png')], 'is_array' => '1'],
            'cursor_image'      => ['value' => [uploadObMedia('modules/subscriptions/demo-content/cursor.png')], 'is_array' => '1'],
        ];
    }

    public function getSubscriptionStepsData($pageId)
    {
        $page = Page::find($pageId);
        return [
            'pre_heading'       => ['value' => 'How it works', 'is_array' => 0],
            'heading'           => ['value' => 'Upgrade for a better eLearning experience.', 'is_array' => 0],
            'paragraph'         => ['value' => 'Upgrade your subscription to unlock advanced eLearning features and resources.', 'is_array' => 0],
            'btn_url'           => ['value' => 'register', 'is_array' => 0],
            'btn_txt'           => ['value' => $page->slug == 'student-subscriptions' ? 'Join as a Student' : 'Join as a Tutor', 'is_array' => 0],
            'shape_img'         => ['value' => [uploadObMedia('modules/subscriptions/demo-content/shape.png')], 'is_array' => '1'],
            'steps_data'        => ['value' => [
                $this->uniqueId() => [
                    'sub_heading'   => 'STEP 1',
                    'step_image' => [uploadObMedia('modules/subscriptions/demo-content/howitwork-img01.png')],
                    'step_heading' => 'Choose Plans',
                    'step_paragraph' => 'Explore a range of options designed to suit your needs and goals.',
                ],
                $this->uniqueId() => [
                    'sub_heading' => 'STEP 2',
                    'step_image' => [uploadObMedia('modules/subscriptions/demo-content/howitwork-img02.png')],
                    'step_heading' => 'Choose your payment method',
                    'step_paragraph' => 'Select your preferred payment option for a seamless subscription experience.',
                ],
                $this->uniqueId() => [
                    'sub_heading' => 'STEP 3',
                    'step_image' => [uploadObMedia('modules/subscriptions/demo-content/howitwork-img03.png')],
                    'step_heading' => 'Join Live Calls with Zoom Integration',
                    'step_paragraph' => 'Join live interactive sessions seamlessly with Zoom integration for a personalized learning.',
                ],
            ], 'is_array' => '1']
        ];
    }

    public function getSubscriptionsData($pageId)
    {
        $page = Page::find($pageId);
        return [
            'pre_heading'       => ['value' => 'Premium Features Unlocked', 'is_array' => 0],
            'heading'           => ['value' => 'Achieve more with '. ($page->slug == 'student-subscriptions' ? 'Student' : 'Tutor') . ' Plans' , 'is_array' => 0],
            'paragraph'         => ['value' => 'Upgrade to a plan that matches your learning goals!', 'is_array' => 0],
            'subscriptions_for' => ['value' => $page->slug == 'student-subscriptions' ? 'student' : 'tutor', 'is_array' => 0],
        ];
    }

    public function getSubscriptionFaqsData($pageId)
    {
        $page = Page::find($pageId);
        if($page->slug == 'student-subscriptions'){
            return [
                'sub_heading'   => ['value' => 'Frequently Asked Questions', 'is_array' => 0],
                'heading'       => ['value' => 'Unlock Your eLearning Potential!', 'is_array' => 0],
                'paragraph'     => ['value' => 'Discover Common Solutions and Access Official Guidance', 'is_array' => 0],
                'faqs_data'     => ['value' =>  [
                    $this->uniqueId() => [
                    'question'    => 'How do I find a tutor?',
                    'answer'      => 'Use the search bar and filters on the "Find a Tutor" page to search for tutors by subject, availability, rating, and more.',
                ],
                $this->uniqueId() => [
                    'question'    => 'How do I book a session?',
                    'answer'      => 'Once you find a tutor, view their profile and select an available time slot that suits you. Click "Book Now" and follow the prompts to confirm your session.',
                ],
                $this->uniqueId() => [
                    'question'    => 'What if I need to cancel or reschedule a session?',
                    'answer'      => 'You can cancel or reschedule a session up to 24 hours before the scheduled time without penalty. Cancellations within 24 hours may incur a fee.',
                ],
                $this->uniqueId() => [
                    'question'    => 'How do I pay for sessions?',
                    'answer'      => 'Payments are made through our secure payment gateway using credit/debit cards or other available payment methods.',
                ],
                $this->uniqueId() => [
                    'question'    => 'What should I do if my tutor doesn\'t show up?',
                    'answer'      => 'If your tutor does not show up for a scheduled session, please contact our support team immediately for assistance and to arrange a refund or reschedule.',
                ]
            ], 'is_array' => '1']
        ];
        } else if($page->slug == 'tutor-subscriptions'){
            return [
                'sub_heading'   => ['value' => 'Frequently Asked Questions', 'is_array' => 0],
                'heading'       => ['value' => 'Unlock Your eLearning Potential!', 'is_array' => 0],
                'paragraph'     => ['value' => 'Discover Common Solutions and Access Official Guidance', 'is_array' => 0],
                'faqs_data'     => ['value' =>  [
                    $this->uniqueId() => [
                        'question'    => 'How do I become a tutor?',
                        'answer'      => 'Click on the "Become a Tutor" link and follow the instructions to sign up, create your profile, and submit the necessary documentation for approval.',
                    ],
                    $this->uniqueId() => [
                        'question'    => 'What qualifications do I need to become a tutor?',
                        'answer'      => 'Tutors are required to have relevant educational qualifications and teaching experience. Specific requirements may vary by subject.',
                    ],
                    $this->uniqueId() => [
                        'question'    => 'How do I set my availability?',
                        'answer'      => 'Log in to your account, go to the "Availability" section, and update your calendar with your available time slots.',
                    ],
                    $this->uniqueId() => [
                        'question'    => 'How do I get paid?',
                        'answer'      => 'Payments for your tutoring sessions are processed through our platform and transferred to your designated bank account on a regular basis.',
                    ],
                    $this->uniqueId() => [
                        'question'    => 'What should I do if a student cancels a session?',
                        'answer'      => 'If a student cancels a session within 24 hours of the scheduled time, you may be entitled to a cancellation fee. Check the platform’s cancellation policy for details.',
                    ],
                ], 'is_array' => '1'],
            ];
        }
    }

}
