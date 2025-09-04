<?php

namespace Modules\Courses\database\Seeders;

use Modules\Courses\Models\Category;
use Modules\Courses\Models\Course;
use Modules\Courses\Models\Curriculum;
use Modules\Courses\Models\Enrollment;
use Modules\Courses\Models\Faq;
use Modules\Courses\Models\Like;
use Modules\Courses\Models\Media;
use Modules\Courses\Models\Noticeboard;
use Modules\Courses\Models\Pricing;
use Modules\Courses\Models\Promotion;
use Modules\Courses\Models\Section;
use Modules\Courses\Models\Watchtime;
use Modules\Courses\Services\CourseService;
use App\Models\EmailTemplate;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Rating;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Larabuild\Optionbuilder\Facades\Settings;

class CoursesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $disk = getStorageDisk();
        $files = Storage::disk($disk)->allFiles('courses');
        Storage::disk($disk)->delete($files);
        $storagePath = storage_path('app/public/courses/');

        if (file_exists($storagePath)) {
            $files = glob($storagePath . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }


        Schema::disableForeignKeyConstraints();
        Media::truncate();
        Watchtime::truncate();
        Like::truncate();
        Enrollment::truncate();
        Category::truncate();
        Course::truncate();
        Pricing::truncate();
        Section::truncate();
        Curriculum::truncate();
        Promotion::truncate();
        Faq::truncate();
        Rating::where('ratingable_type', 'Amentotech\\Courses\\Models\\Course')->delete();

        EmailTemplate::whereIn('type', ['courseBooking', 'courseApproved', 'courseRejected'])->forceDelete();
        
        $this->seedCategories();
        $this->seedSettings();
        $this->seedCourses();
        $this->setEmailTemplates();
        $this->addCourseMenu();
        Schema::enableForeignKeyConstraints();
    }

    private function seedSettings()
    {
        $settings = [
            'allow_video_types' => ['video_file', 'youtube_link', 'vimeo_link'],
        ];

        foreach ($settings as $key => $value) {
            Settings::set('_course', $key, $value);
        }
        Artisan::call('cache:clear');
    }

    private function seedCourses()
    {
        $courses = [
            // Course 2
            [
                'title' => 'Goal Setting Masterclass: Achieve Your Dreams',
                'category' => 'Productivity',
                'sub_category' => 'Goal Setting',
                'subtitle' => 'Achieve Your Long-Term and Short-Term Goals with Proven Techniques',
                'description' => '<p>Unlock the secret to setting and achieving your goals with proven strategies designed to push you forward. Learn the psychological techniques behind goal-setting, how to stay motivated, and how to overcome obstacles.</p><p>This course guides you through the process of identifying your personal and professional goals, breaking them down into actionable steps, and creating a roadmap to success. With practical exercises and real-life examples, you will develop the skills needed to turn your dreams into reality.</p>',
                'learning_objectives' => [
                    'Identify Your Life Goals',
                    'Break Down Goals into Actionable Steps',
                    'Set SMART Goals',
                    'Master Time-Management for Goal Achievement',
                    'Overcome Obstacles and Stay Motivated',
                ],
                'prerequisites' => '<p>To structure your course for maximum student engagement, start by breaking your content into clear, manageable modules that build upon each other. Begin with an introduction that outlines learning objectives, then progressively delve into more complex topics.</p><ul><li>Covering all fundamental topics with practical applications</li><li>Learn from industry professionals with years of experience</li><li>Access to a peer network and instructor feedback for enhanced learning</li></ul><p>Explore the core principles of design and discover how to apply them effectively, unlocking your full creative potential. Learn from industry professionals with years of experience. Gain practical knowledge you can immediately apply in your career or studies.</p>',
                'sections' => [
                    [
                        'title' => 'Understanding Goals and Why They Matter',
                        'description' => 'A comprehensive guide to understanding the significance of goal setting and how it impacts your success.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'The Importance of Goal Setting',
                                'is_preview' => 1,
                                'content_length' => 80,
                                'description' => 'Explore why setting goals is crucial for personal and professional growth.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Types of Goals',
                                'content_length' => 45,
                                'description' => 'Learn about short-term, medium-term, and long-term goals.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Creating a Vision Board',
                                'content_length' => 50,
                                'description' => 'Visualize your goals by creating a personal vision board.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Setting and Achieving Your Goals',
                        'description' => 'Learn practical strategies to set realistic goals and create an action plan to achieve them.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'SMART Goals Framework',
                                'content_length' => 70,
                                'description' => 'Learn how to set Specific, Measurable, Achievable, Relevant, and Time-bound goals.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Breaking Down Goals into Tasks',
                                'content_length' => 60,
                                'description' => 'Understand how to deconstruct goals into manageable tasks.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Creating an Action Plan',
                                'content_length' => 55,
                                'description' => 'Develop a step-by-step plan to achieve your goals.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Staying Motivated and Overcoming Obstacles',
                        'description' => 'Explore techniques to maintain motivation and navigate challenges that may arise.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Maintaining Motivation',
                                'content_length' => 65,
                                'description' => 'Learn strategies to stay motivated throughout your journey.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Dealing with Setbacks',
                                'content_length' => 50,
                                'description' => 'Understand how to overcome obstacles and setbacks.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Reviewing and Adjusting Goals',
                                'content_length' => 45,
                                'description' => 'Learn how to regularly review and adjust your goals as needed.',
                            ],
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'How do I stay motivated when I encounter obstacles?',
                        'answer' => 'Setbacks are a part of the journey. Revisit your goals, remind yourself of your why, and adjust your action plan if necessary.',
                    ],
                    [
                        'question' => 'How do I adjust my goals if circumstances change?',
                        'answer' => 'Be flexible and willing to adapt your goals to align with new circumstances while keeping your end objective in mind.',
                    ],
                    [
                        'question' => 'Can I set multiple goals at once?',
                        'answer' => 'Yes, but prioritize them to ensure you can allocate appropriate time and resources to each.',
                    ],
                    [
                        'question' => 'How often should I review my goals?',
                        'answer' => 'Regularly review your goals, at least monthly, to track progress and make necessary adjustments.',
                    ],
                ],
                'noticeboards' => [
                    'Goal-setting worksheet available for download.',
                    'Join our goal-setting webinar next week.',
                    'New tool added to help you track your goals.',
                    'Success stories: Read how others achieved their goals.',
                    'Reminder: Complete your goal-setting assignment.',
                    'Live coaching session scheduled for Friday.',
                    'Check out the new podcast episode on staying motivated.',
                    'Updated resources on overcoming common obstacles.',
                    'Participate in the goal-sharing forum to stay accountable.',
                    'Exclusive interview with a goal achievement expert.',
                    'New article: The psychology behind goal setting.',
                    'Congratulations to students who achieved their first milestone!',
                ],
            ],
            // Course 3
            [
                'title' => 'Focus and Concentration Boost: Achieve More',
                'category' => 'Productivity',
                'sub_category' => 'Focus and Concentration',
                'subtitle' => 'Boost Your Focus and Achieve More in Less Time',
                'description' => '<p>Learn the techniques and exercises that can help you boost your concentration and productivity. This course will teach you how to eliminate distractions, improve mental clarity, and enhance your ability to focus on tasks.</p><p>Through practical exercises and scientifically proven methods, you will learn how to train your brain to stay focused and increase your efficiency in both personal and professional tasks.</p>',
                'learning_objectives' => [
                    'Master Focus Techniques',
                    'Practice Mindfulness and Meditation',
                    'Remove Distractions',
                    'Improve Cognitive Function',
                    'Develop Sustainable Concentration Habits',
                ],
                'prerequisites' => '<p>To structure your course for maximum student engagement, start by breaking your content into clear, manageable modules that build upon each other. Begin with an introduction that outlines learning objectives, then progressively delve into more complex topics.</p><ul><li>Covering all fundamental topics with practical applications</li><li>Learn from industry professionals with years of experience</li><li>Access to a peer network and instructor feedback for enhanced learning</li></ul><p>Explore the core principles of design and discover how to apply them effectively, unlocking your full creative potential. Learn from industry professionals with years of experience. Gain practical knowledge you can immediately apply in your career or studies.</p>',
                'sections' => [
                    [
                        'title' => 'Techniques for Improving Focus',
                        'description' => 'Discover proven techniques to improve your focus and block out distractions.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Deep Work Concept',
                                'is_preview' => 1,
                                'content_length' => 85,
                                'description' => 'Explore the power of deep work and how to master it.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Mindfulness Exercises for Focus',
                                'content_length' => 60,
                                'description' => 'Incorporate mindfulness into your routine to enhance focus.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Using the Pomodoro Technique',
                                'content_length' => 75,
                                'description' => 'How Pomodoro can enhance your productivity and focus.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Overcoming Distractions and Staying Focused',
                        'description' => 'Learn how to handle distractions and maintain focus on critical tasks.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Identifying Distractions',
                                'content_length' => 80,
                                'description' => 'Recognize and manage distractions effectively.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Time Blocking for Maximum Focus',
                                'content_length' => 95,
                                'description' => 'Using time-blocking strategies to increase focus.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Work Environment Optimization',
                                'content_length' => 70,
                                'description' => 'Optimizing your workspace for better focus.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Enhancing Cognitive Function',
                        'description' => 'Explore methods to improve your cognitive abilities for better concentration.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Brain Training Exercises',
                                'content_length' => 60,
                                'description' => 'Exercises to enhance brain function and focus.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Nutrition for Cognitive Health',
                                'content_length' => 55,
                                'description' => 'Learn about foods that boost brain health.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Importance of Sleep',
                                'content_length' => 50,
                                'description' => 'Understand how sleep affects focus and productivity.',
                            ],
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'What if I have too many distractions at home?',
                        'answer' => 'Create a dedicated workspace and establish boundaries with others during focus times.',
                    ],
                    [
                        'question' => 'How can I improve my focus over time?',
                        'answer' => 'Regular practice of focus techniques and mindfulness can gradually enhance your concentration.',
                    ],
                    [
                        'question' => 'Does multitasking affect focus?',
                        'answer' => 'Yes, multitasking can reduce efficiency and focus. It’s better to concentrate on one task at a time.',
                    ],
                    [
                        'question' => 'Can diet affect my concentration?',
                        'answer' => 'Absolutely. A balanced diet rich in brain-healthy nutrients can improve cognitive function.',
                    ],
                ],
                'noticeboards' => [
                    'Reminder: Join our live meditation session this Saturday.',
                    'Complete your mindfulness exercise this week to unlock a new tool!',
                    'New article on optimizing your workspace.',
                    'Participate in the focus challenge to win a prize.',
                    'Live webinar on nutrition and brain health scheduled.',
                    'Check out the new podcast on overcoming digital distractions.',
                    'Updated course materials with additional exercises.',
                    'Share your progress in the discussion forum.',
                    'Don’t miss the Q&A session with cognitive experts.',
                    'New resource: Guide to effective time blocking.',
                    'Submit your questions for the upcoming live session.',
                    'Congratulations to those who completed the focus boot camp!',
                ],
            ],
            // Course 4
            [
                'title' => 'Mastering Motivation: Stay Driven Towards Success',
                'category' => 'Productivity',
                'sub_category' => 'Motivation',
                'subtitle' => 'Learn How to Stay Motivated and Achieve Your Goals',
                'description' => '<p>Discover the secrets to staying motivated even when the going gets tough. This course provides practical strategies and psychological insights to help you maintain high levels of motivation in all areas of your life.</p><p>You will learn how to set inspiring goals, overcome obstacles, and develop a resilient mindset. Through interactive exercises and real-life examples, you will gain the tools needed to stay driven and achieve success.</p>',
                'learning_objectives' => [
                    'Understand the Psychology of Motivation',
                    'Develop Intrinsic Motivation',
                    'Overcome Procrastination',
                    'Set and Achieve Personal Milestones',
                    'Build Resilience and Persistence',
                ],
                'prerequisites' => '<p>To structure your course for maximum student engagement, start by breaking your content into clear, manageable modules that build upon each other. Begin with an introduction that outlines learning objectives, then progressively delve into more complex topics.</p><ul><li>Covering all fundamental topics with practical applications</li><li>Learn from industry professionals with years of experience</li><li>Access to a peer network and instructor feedback for enhanced learning</li></ul><p>Explore the core principles of design and discover how to apply them effectively, unlocking your full creative potential. Learn from industry professionals with years of experience. Gain practical knowledge you can immediately apply in your career or studies.</p>',
                'sections' => [
                    [
                        'title' => 'Understanding Motivation',
                        'description' => 'Explore the psychological aspects of motivation and how it influences behavior.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Intrinsic vs Extrinsic Motivation',
                                'is_preview' => 1,
                                'content_length' => 70,
                                'description' => 'Learn the differences and how to harness both types of motivation.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'The Science Behind Motivation',
                                'content_length' => 80,
                                'description' => 'Understand how motivation works in the brain.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Building a Motivational Mindset',
                                'content_length' => 65,
                                'description' => 'Techniques to develop a mindset that fosters motivation.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Overcoming Obstacles to Motivation',
                        'description' => 'Identify common barriers to motivation and learn strategies to overcome them.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Dealing with Procrastination',
                                'content_length' => 75,
                                'description' => 'Understand why we procrastinate and how to stop.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Managing Stress and Burnout',
                                'content_length' => 60,
                                'description' => 'Learn how stress affects motivation and ways to manage it.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Staying Motivated Long-Term',
                                'content_length' => 55,
                                'description' => 'Strategies for maintaining motivation over extended periods.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Achieving Success through Motivation',
                        'description' => 'Apply motivational techniques to achieve your personal and professional goals.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Setting Inspiring Goals',
                                'content_length' => 65,
                                'description' => 'Learn how to set goals that motivate you.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Tracking Progress and Celebrating Wins',
                                'content_length' => 50,
                                'description' => 'Understand the importance of tracking and rewarding progress.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Building a Support System',
                                'content_length' => 55,
                                'description' => 'Learn how to create a network that supports your motivation.',
                            ],
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'How do I stay motivated over the long term?',
                        'answer' => 'Set short-term goals and celebrate small wins to maintain momentum. Regularly revisit your reasons for pursuing your goals.',
                    ],
                    [
                        'question' => 'What can I do when I feel demotivated?',
                        'answer' => 'Take a break, revisit your goals, engage in activities that inspire you, and consider seeking support from others.',
                    ],
                    [
                        'question' => 'How does stress affect motivation?',
                        'answer' => 'High stress levels can negatively impact motivation. Managing stress through healthy habits is crucial for maintaining motivation.',
                    ],
                    [
                        'question' => 'Can motivation techniques help in professional life?',
                        'answer' => 'Yes, the strategies learned in this course can enhance motivation in both personal and professional settings.',
                    ],
                ],
                'noticeboards' => [
                    'New inspirational videos added to the course.',
                    'Live session on overcoming procrastination scheduled for next week.',
                    'Motivation journal template available for download.',
                    'Share your motivational quotes in the forum.',
                    'Updated resources on managing stress and burnout.',
                    'Participate in the 7-day motivation challenge.',
                    'Reminder: Complete your motivation action plan.',
                    'Listen to the latest podcast on building resilience.',
                    'Join the live Q&A with motivational speakers.',
                    'New article: The role of mindset in motivation.',
                    'Submit your success stories to inspire others.',
                    'Congratulations to students who completed the challenge!',
                ],
            ],
            // Course 5
            [
                'title' => 'Effective Networking: Build Meaningful Connections',
                'category' => 'Productivity',
                'sub_category' => 'Networking',
                'subtitle' => 'Learn How to Network Effectively and Expand Your Professional Circle',
                'description' => '<p>Discover the strategies to build and maintain professional relationships that can advance your career. This course teaches you how to network with confidence, both in-person and online.</p><p>You will learn how to approach new contacts, nurture existing relationships, and leverage social media platforms for networking. Real-life examples and interactive activities will help you develop skills to create meaningful connections.</p>',
                'learning_objectives' => [
                    'Understand Networking Principles',
                    'Develop Communication Skills',
                    'Build a Professional Network',
                    'Leverage Social Media for Networking',
                    'Maintain Long-Term Relationships',
                ],
                'prerequisites' => '<p>To structure your course for maximum student engagement, start by breaking your content into clear, manageable modules that build upon each other. Begin with an introduction that outlines learning objectives, then progressively delve into more complex topics.</p><ul><li>Covering all fundamental topics with practical applications</li><li>Learn from industry professionals with years of experience</li><li>Access to a peer network and instructor feedback for enhanced learning</li></ul><p>Explore the core principles of design and discover how to apply them effectively, unlocking your full creative potential. Learn from industry professionals with years of experience. Gain practical knowledge you can immediately apply in your career or studies.</p>',
                'sections' => [
                    [
                        'title' => 'Networking Fundamentals',
                        'description' => 'Learn the basics of networking and its importance in professional growth.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Why Networking Matters',
                                'is_preview' => 1,
                                'content_length' => 70,
                                'description' => 'Explore the impact of networking on career advancement.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Building Confidence in Networking',
                                'content_length' => 60,
                                'description' => 'Techniques to overcome networking anxiety.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Effective Communication Skills',
                                'content_length' => 65,
                                'description' => 'Learn how to communicate effectively with new contacts.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Networking Strategies',
                        'description' => 'Discover practical strategies to build and expand your network.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'In-Person Networking Events',
                                'content_length' => 75,
                                'description' => 'Maximize opportunities at networking events.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Online Networking Techniques',
                                'content_length' => 80,
                                'description' => 'Leverage online platforms for networking.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Follow-Up and Relationship Building',
                                'content_length' => 55,
                                'description' => 'Learn how to maintain and nurture professional relationships.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Leveraging Social Media',
                        'description' => 'Use social media platforms effectively for professional networking.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Optimizing Your LinkedIn Profile',
                                'content_length' => 60,
                                'description' => 'Create a compelling LinkedIn profile to attract connections.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Engaging with Online Communities',
                                'content_length' => 50,
                                'description' => 'Participate in groups and forums to expand your network.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Personal Branding on Social Media',
                                'content_length' => 65,
                                'description' => 'Build a strong personal brand online.',
                            ],
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'How do I approach someone I want to connect with?',
                        'answer' => 'Start with a friendly introduction and find common ground or mutual interests to initiate the conversation.',
                    ],
                    [
                        'question' => 'What if I’m introverted and find networking challenging?',
                        'answer' => 'Focus on one-on-one conversations and prepare topics or questions in advance to ease anxiety.',
                    ],
                    [
                        'question' => 'How can I effectively use LinkedIn for networking?',
                        'answer' => 'Optimize your profile, engage with content, and reach out to professionals in your field with personalized messages.',
                    ],
                    [
                        'question' => 'How often should I follow up with new contacts?',
                        'answer' => 'Follow up within a few days after meeting and keep in touch periodically to maintain the relationship.',
                    ],
                ],
                'noticeboards' => [
                    'Networking event calendar updated for next month.',
                    'Download the new eBook on effective networking strategies.',
                    'Live webinar on personal branding scheduled for Thursday.',
                    'Join the networking challenge to expand your connections.',
                    'New article: Overcoming networking anxiety.',
                    'Reminder: Update your LinkedIn profile with recent achievements.',
                    'Participate in the online networking forum.',
                    'Live Q&A session with networking experts next week.',
                    'Check out the latest podcast on building professional relationships.',
                    'Congratulations to students who completed the networking assignment!',
                ],
            ],
            // Course 6
            [
                'title' => 'Continuous Learning: Embrace Lifelong Education',
                'category' => 'Productivity',
                'sub_category' => 'Continuous Learning',
                'subtitle' => 'Cultivate a Growth Mindset and Never Stop Learning',
                'description' => '<p>In a rapidly changing world, continuous learning is essential for personal and professional growth. This course helps you develop a growth mindset and provides strategies to integrate lifelong learning into your daily routine.</p><p>You will explore different learning methods, set personal development goals, and discover resources to support your educational journey. Embrace the joy of learning and stay ahead in your field.</p>',
                'learning_objectives' => [
                    'Understand the Importance of Lifelong Learning',
                    'Develop a Growth Mindset',
                    'Set Personal Learning Goals',
                    'Identify Effective Learning Strategies',
                    'Create a Personal Development Plan',
                ],
                'prerequisites' => '<p>To structure your course for maximum student engagement, start by breaking your content into clear, manageable modules that build upon each other. Begin with an introduction that outlines learning objectives, then progressively delve into more complex topics.</p><ul><li>Covering all fundamental topics with practical applications</li><li>Learn from industry professionals with years of experience</li><li>Access to a peer network and instructor feedback for enhanced learning</li></ul><p>Explore the core principles of design and discover how to apply them effectively, unlocking your full creative potential. Learn from industry professionals with years of experience. Gain practical knowledge you can immediately apply in your career or studies.</p>',
                'sections' => [
                    [
                        'title' => 'The Value of Lifelong Learning',
                        'description' => 'Discover why continuous learning is vital in today’s world.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Embracing a Growth Mindset',
                                'is_preview' => 1,
                                'content_length' => 75,
                                'description' => 'Learn how a growth mindset fosters continuous learning.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Overcoming Learning Barriers',
                                'content_length' => 65,
                                'description' => 'Identify and overcome obstacles to learning.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Benefits of Lifelong Learning',
                                'content_length' => 60,
                                'description' => 'Explore the personal and professional advantages of continuous education.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Developing Your Learning Plan',
                        'description' => 'Create a personalized plan to guide your learning journey.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Setting Learning Goals',
                                'content_length' => 70,
                                'description' => 'Learn how to define clear and achievable learning objectives.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Choosing Learning Resources',
                                'content_length' => 55,
                                'description' => 'Discover various resources and platforms for learning.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Time Management for Learning',
                                'content_length' => 60,
                                'description' => 'Integrate learning into your busy schedule effectively.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Effective Learning Strategies',
                        'description' => 'Explore techniques to enhance your learning experience.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Active Learning Techniques',
                                'content_length' => 65,
                                'description' => 'Engage with material through active participation.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Reflective Practice',
                                'content_length' => 55,
                                'description' => 'Use reflection to deepen understanding and retention.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Collaborative Learning',
                                'content_length' => 60,
                                'description' => 'Learn with others to enhance the educational experience.',
                            ],
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'How do I stay motivated to continue learning?',
                        'answer' => 'Set clear goals, track your progress, and choose topics that genuinely interest you.',
                    ],
                    [
                        'question' => 'What resources are available for continuous learning?',
                        'answer' => 'Online courses, books, workshops, webinars, and podcasts are excellent resources.',
                    ],
                    [
                        'question' => 'How can I balance learning with a busy schedule?',
                        'answer' => 'Incorporate micro-learning sessions into your day and prioritize learning activities.',
                    ],
                    [
                        'question' => 'Is continuous learning necessary in all professions?',
                        'answer' => 'Yes, staying updated with new developments is beneficial in any field.',
                    ],
                ],
                'noticeboards' => [
                    'New list of recommended books added.',
                    'Join the live webinar on effective learning strategies.',
                    'Download the personal development plan template.',
                    'Participate in the learning challenge this month.',
                    'Updated resources on active learning techniques.',
                    'Reminder: Set your learning goals for the upcoming quarter.',
                    'Check out the new podcast on cultivating a growth mindset.',
                    'Share your learning journey in the discussion forum.',
                    'Live Q&A session with education experts next week.',
                    'Congratulations to students who completed their learning plans!',
                ],
            ],
            // Course 7
            [
                'title' => 'Innovation and Creativity: Think Outside the Box',
                'category' => 'Productivity',
                'sub_category' => 'Innovation and Creativity',
                'subtitle' => 'Unleash Your Creative Potential and Drive Innovation',
                'description' => '<p>Unlock your creative potential and learn how to generate innovative ideas. This course provides techniques to enhance creativity, foster innovation, and apply creative thinking to solve problems.</p><p>Through interactive exercises and real-world examples, you will learn how to think outside the box, challenge assumptions, and develop innovative solutions in personal and professional contexts.</p>',
                'learning_objectives' => [
                    'Understand the Creative Process',
                    'Develop Creative Thinking Skills',
                    'Apply Innovation Techniques',
                    'Overcome Creative Blocks',
                    'Implement Creative Solutions',
                ],
                'prerequisites' => '<p>To structure your course for maximum student engagement, start by breaking your content into clear, manageable modules that build upon each other. Begin with an introduction that outlines learning objectives, then progressively delve into more complex topics.</p><ul><li>Covering all fundamental topics with practical applications</li><li>Learn from industry professionals with years of experience</li><li>Access to a peer network and instructor feedback for enhanced learning</li></ul><p>Explore the core principles of design and discover how to apply them effectively, unlocking your full creative potential. Learn from industry professionals with years of experience. Gain practical knowledge you can immediately apply in your career or studies.</p>',
                'sections' => [
                    [
                        'title' => 'Foundations of Creativity',
                        'description' => 'Explore the nature of creativity and how to cultivate it.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Understanding Creativity',
                                'is_preview' => 1,
                                'content_length' => 70,
                                'description' => 'Define creativity and its importance in various fields.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'The Creative Process',
                                'content_length' => 65,
                                'description' => 'Learn about the stages of the creative process.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Mindset for Creativity',
                                'content_length' => 60,
                                'description' => 'Develop a mindset that fosters creativity.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Techniques to Enhance Creativity',
                        'description' => 'Learn practical methods to boost creative thinking.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Brainstorming Methods',
                                'content_length' => 75,
                                'description' => 'Explore effective brainstorming techniques.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Mind Mapping',
                                'content_length' => 55,
                                'description' => 'Use mind maps to generate and organize ideas.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Lateral Thinking',
                                'content_length' => 60,
                                'description' => 'Apply lateral thinking to approach problems differently.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Applying Creativity for Innovation',
                        'description' => 'Discover how to turn creative ideas into innovative solutions.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'From Ideas to Innovation',
                                'content_length' => 65,
                                'description' => 'Transform creative ideas into practical innovations.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Overcoming Creative Blocks',
                                'content_length' => 50,
                                'description' => 'Learn strategies to overcome obstacles to creativity.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Implementing Creative Solutions',
                                'content_length' => 55,
                                'description' => 'Steps to put your innovative ideas into action.',
                            ],
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'Can creativity be learned or improved?',
                        'answer' => 'Yes, creativity is a skill that can be developed with practice and the right techniques.',
                    ],
                    [
                        'question' => 'How do I overcome a creative block?',
                        'answer' => 'Try changing your environment, taking breaks, or using creative exercises to stimulate new ideas.',
                    ],
                    [
                        'question' => 'What if I don’t consider myself a creative person?',
                        'answer' => 'Everyone has creative potential. This course will help you unlock and enhance your creativity.',
                    ],
                    [
                        'question' => 'How can I apply creativity in my job?',
                        'answer' => 'Use creative thinking to solve problems, improve processes, and develop innovative products or services.',
                    ],
                ],
                'noticeboards' => [
                    'New creativity exercises added to the course.',
                    'Participate in the creative challenge this week.',
                    'Live workshop on mind mapping scheduled for Monday.',
                    'Download the brainstorming toolkit.',
                    'Updated resources on lateral thinking techniques.',
                    'Share your creative projects in the forum.',
                    'Reminder: Complete your creative journal entries.',
                    'Listen to the latest podcast on innovation in business.',
                    'Join the live Q&A with creative industry leaders.',
                    'Congratulations to students who showcased innovative ideas!',
                ],
            ],
            // Course 8
            [
                'title' => 'Leadership Essentials: Inspire and Influence',
                'category' => 'Productivity',
                'sub_category' => 'Leadership',
                'subtitle' => 'Develop the Skills to Lead Teams Effectively',
                'description' => '<p>Enhance your leadership abilities and learn how to inspire and motivate others. This course provides practical tools and techniques to become an effective leader in any environment.</p><p>You will explore different leadership styles, communication strategies, and team management skills. Through interactive sessions and real-world examples, you will learn how to lead with confidence and achieve organizational goals.</p>',
                'learning_objectives' => [
                    'Understand Different Leadership Styles',
                    'Improve Communication Skills',
                    'Motivate and Inspire Teams',
                    'Manage Conflict Effectively',
                    'Develop Strategic Thinking',
                ],
                'prerequisites' => '<p>To structure your course for maximum student engagement, start by breaking your content into clear, manageable modules that build upon each other. Begin with an introduction that outlines learning objectives, then progressively delve into more complex topics.</p><ul><li>Covering all fundamental topics with practical applications</li><li>Learn from industry professionals with years of experience</li><li>Access to a peer network and instructor feedback for enhanced learning</li></ul><p>Explore the core principles of design and discover how to apply them effectively, unlocking your full creative potential. Learn from industry professionals with years of experience. Gain practical knowledge you can immediately apply in your career or studies.</p>',
                'sections' => [
                    [
                        'title' => 'Fundamentals of Leadership',
                        'description' => 'Learn the core principles and qualities of effective leadership.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'What Makes a Great Leader',
                                'is_preview' => 1,
                                'content_length' => 80,
                                'description' => 'Explore the essential traits of successful leaders.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Leadership Styles and Theories',
                                'content_length' => 70,
                                'description' => 'Understand different leadership styles and when to apply them.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Emotional Intelligence in Leadership',
                                'content_length' => 65,
                                'description' => 'Learn how emotional intelligence impacts leadership effectiveness.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Leading Teams Effectively',
                        'description' => 'Develop skills to manage and inspire teams toward common goals.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Effective Communication',
                                'content_length' => 75,
                                'description' => 'Enhance your communication skills for better team collaboration.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Motivating Your Team',
                                'content_length' => 60,
                                'description' => 'Learn techniques to motivate and engage team members.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Conflict Resolution',
                                'content_length' => 55,
                                'description' => 'Manage and resolve conflicts within your team effectively.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Strategic Leadership',
                        'description' => 'Develop strategic thinking skills to lead organizations successfully.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Strategic Planning',
                                'content_length' => 65,
                                'description' => 'Learn how to create and implement strategic plans.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Decision-Making Skills',
                                'content_length' => 50,
                                'description' => 'Enhance your ability to make informed decisions.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Leading Change',
                                'content_length' => 55,
                                'description' => 'Manage change effectively within your organization.',
                            ],
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'How can I adapt my leadership style to different situations?',
                        'answer' => 'By understanding the needs of your team and the demands of the situation, you can adjust your approach to be more effective.',
                    ],
                    [
                        'question' => 'What if I’m new to a leadership role?',
                        'answer' => 'This course provides foundational skills and strategies to help you lead confidently, even if you’re new to leadership.',
                    ],
                    [
                        'question' => 'How important is emotional intelligence in leadership?',
                        'answer' => 'Emotional intelligence is crucial for understanding and managing your emotions and those of others, leading to better team dynamics.',
                    ],
                    [
                        'question' => 'Can these leadership skills be applied in any industry?',
                        'answer' => 'Yes, the principles taught in this course are applicable across various industries and organizational structures.',
                    ],
                ],
                'noticeboards' => [
                    'New case study on transformational leadership added.',
                    'Live webinar on strategic planning scheduled for Wednesday.',
                    'Download the leadership self-assessment tool.',
                    'Join the leadership book club discussion this month.',
                    'Updated resources on emotional intelligence.',
                    'Reminder: Complete the team management assignment.',
                    'Participate in the leadership simulation exercise.',
                    'Listen to the latest podcast on leading through change.',
                    'Live Q&A session with industry leaders next week.',
                    'Congratulations to students who completed the leadership challenge!',
                ],
            ],
            // Course 9
            [
                'title' => 'Work-Life Balance: Achieve Harmony and Well-being',
                'category' => 'Productivity',
                'sub_category' => 'Work-Life Balance',
                'subtitle' => 'Learn Strategies to Balance Professional and Personal Life',
                'description' => '<p>Discover how to achieve a healthy balance between work and personal life. This course provides practical strategies to manage time, reduce stress, and enhance overall well-being.</p><p>You will learn how to set boundaries, prioritize self-care, and create routines that support a balanced lifestyle. Through reflective exercises and expert insights, you will develop a personalized plan to achieve harmony in your life.</p>',
                'learning_objectives' => [
                    'Understand Work-Life Balance Concepts',
                    'Manage Time Effectively',
                    'Set Healthy Boundaries',
                    'Reduce Stress and Prevent Burnout',
                    'Enhance Personal Well-being',
                ],
                'prerequisites' => '<p>To structure your course for maximum student engagement, start by breaking your content into clear, manageable modules that build upon each other. Begin with an introduction that outlines learning objectives, then progressively delve into more complex topics.</p><ul><li>Covering all fundamental topics with practical applications</li><li>Learn from industry professionals with years of experience</li><li>Access to a peer network and instructor feedback for enhanced learning</li></ul><p>Explore the core principles of design and discover how to apply them effectively, unlocking your full creative potential. Learn from industry professionals with years of experience. Gain practical knowledge you can immediately apply in your career or studies.</p>',
                'sections' => [
                    [
                        'title' => 'The Importance of Work-Life Balance',
                        'description' => 'Explore the impact of work-life balance on health and productivity.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Defining Work-Life Balance',
                                'is_preview' => 1,
                                'content_length' => 70,
                                'description' => 'Understand what work-life balance means and why it matters.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Assessing Your Current Balance',
                                'content_length' => 60,
                                'description' => 'Evaluate your current work-life situation.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Impact on Health and Relationships',
                                'content_length' => 65,
                                'description' => 'Learn how imbalance affects various aspects of life.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Strategies for Achieving Balance',
                        'description' => 'Learn practical methods to balance professional responsibilities and personal life.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Time Management Techniques',
                                'content_length' => 75,
                                'description' => 'Manage your time to accommodate work and personal activities.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Setting Boundaries',
                                'content_length' => 60,
                                'description' => 'Establish limits to protect personal time.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Prioritizing Self-Care',
                                'content_length' => 55,
                                'description' => 'Incorporate self-care practices into your routine.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Maintaining Balance Long-Term',
                        'description' => 'Develop habits and routines to sustain a balanced lifestyle.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Creating a Balanced Schedule',
                                'content_length' => 65,
                                'description' => 'Design a schedule that aligns with your priorities.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Mindfulness and Stress Reduction',
                                'content_length' => 50,
                                'description' => 'Practice mindfulness to reduce stress.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Building Support Systems',
                                'content_length' => 55,
                                'description' => 'Leverage relationships to support your balance goals.',
                            ],
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'How do I set boundaries at work?',
                        'answer' => 'Communicate your limits clearly and assertively, and prioritize your tasks effectively.',
                    ],
                    [
                        'question' => 'What if my job demands excessive hours?',
                        'answer' => 'Discuss workload concerns with your employer and explore flexible arrangements if possible.',
                    ],
                    [
                        'question' => 'How can I make time for self-care?',
                        'answer' => 'Schedule self-care activities as non-negotiable appointments in your calendar.',
                    ],
                    [
                        'question' => 'Can work-life balance improve my productivity?',
                        'answer' => 'Yes, achieving balance can lead to increased energy, focus, and overall productivity.',
                    ],
                ],
                'noticeboards' => [
                    'New meditation and relaxation exercises added.',
                    'Live workshop on stress management scheduled for Friday.',
                    'Download the work-life balance assessment tool.',
                    'Join the well-being challenge this month.',
                    'Updated resources on setting boundaries.',
                    'Reminder: Complete your personal balance plan.',
                    'Participate in the mindfulness session next week.',
                    'Listen to the latest podcast on self-care strategies.',
                    'Live Q&A with wellness experts coming up.',
                    'Congratulations to students who achieved their balance goals!',
                ],
            ],
            // Course 10
            [
                'title' => 'Effective Communication Skills: Connect and Influence',
                'category' => 'Productivity',
                'sub_category' => 'Communication',
                'subtitle' => 'Enhance Your Communication Skills for Personal and Professional Success',
                'description' => '<p>Improve your ability to communicate effectively in various settings. This course covers verbal and non-verbal communication, active listening, and strategies to convey your message clearly.</p><p>You will learn how to adapt your communication style to different audiences, handle difficult conversations, and influence others positively. Interactive exercises will help you practice and refine your skills.</p>',
                'learning_objectives' => [
                    'Master Verbal and Non-Verbal Communication',
                    'Develop Active Listening Skills',
                    'Adapt Communication Style',
                    'Handle Difficult Conversations',
                    'Influence and Persuade Effectively',
                ],
                'prerequisites' => '<p>To structure your course for maximum student engagement, start by breaking your content into clear, manageable modules that build upon each other. Begin with an introduction that outlines learning objectives, then progressively delve into more complex topics.</p><ul><li>Covering all fundamental topics with practical applications</li><li>Learn from industry professionals with years of experience</li><li>Access to a peer network and instructor feedback for enhanced learning</li></ul><p>Explore the core principles of design and discover how to apply them effectively, unlocking your full creative potential. Learn from industry professionals with years of experience. Gain practical knowledge you can immediately apply in your career or studies.</p>',
                'sections' => [
                    [
                        'title' => 'Communication Fundamentals',
                        'description' => 'Understand the basics of effective communication.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'The Communication Process',
                                'is_preview' => 1,
                                'content_length' => 70,
                                'description' => 'Learn how communication works and common barriers.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Verbal Communication Skills',
                                'content_length' => 65,
                                'description' => 'Improve clarity and effectiveness in spoken communication.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Non-Verbal Communication',
                                'content_length' => 60,
                                'description' => 'Understand body language and its impact.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Advanced Communication Techniques',
                        'description' => 'Enhance your ability to connect and influence others.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Active Listening',
                                'content_length' => 75,
                                'description' => 'Develop skills to listen effectively and empathetically.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Adapting to Your Audience',
                                'content_length' => 60,
                                'description' => 'Tailor your communication style for different audiences.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Persuasion and Influence',
                                'content_length' => 55,
                                'description' => 'Learn techniques to influence others positively.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Handling Challenging Conversations',
                        'description' => 'Learn strategies to navigate difficult communication scenarios.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Managing Conflict',
                                'content_length' => 65,
                                'description' => 'Resolve conflicts through effective communication.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Delivering Feedback',
                                'content_length' => 50,
                                'description' => 'Provide constructive feedback appropriately.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Communicating Under Pressure',
                                'content_length' => 55,
                                'description' => 'Maintain composure and clarity in stressful situations.',
                            ],
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'How can I become a better listener?',
                        'answer' => 'Practice active listening by fully focusing on the speaker, avoiding interruptions, and reflecting back what you hear.',
                    ],
                    [
                        'question' => 'What if I struggle with public speaking?',
                        'answer' => 'Start by practicing in small groups, prepare thoroughly, and consider joining a speaking club for support.',
                    ],
                    [
                        'question' => 'How do I handle misunderstandings?',
                        'answer' => 'Clarify your message, ask questions, and ensure mutual understanding to resolve misunderstandings.',
                    ],
                    [
                        'question' => 'Can these skills help in personal relationships?',
                        'answer' => 'Yes, effective communication is essential in all types of relationships.',
                    ],
                ],
                'noticeboards' => [
                    'New role-play exercises added to practice communication skills.',
                    'Live workshop on active listening scheduled for Tuesday.',
                    'Download the communication style assessment tool.',
                    'Participate in the communication skills challenge.',
                    'Updated resources on handling difficult conversations.',
                    'Reminder: Complete your communication skills self-evaluation.',
                    'Join the live Q&A with communication experts.',
                    'Listen to the latest podcast on persuasive communication.',
                    'Congratulations to students who completed the communication challenge!',
                ],
            ],
            // Course 11
            [
                'title' => 'Stress Management: Achieve Inner Peace',
                'category' => 'Productivity',
                'sub_category' => 'Motivation',
                'subtitle' => 'Learn Techniques to Manage Stress and Improve Well-being',
                'description' => '<p>Discover how to identify stressors and apply effective strategies to manage stress. This course provides tools to reduce anxiety, enhance resilience, and promote a healthier lifestyle.</p><p>You will learn relaxation techniques, mindfulness practices, and lifestyle changes that contribute to stress reduction. Through guided exercises, you will develop a personalized stress management plan.</p>',
                'learning_objectives' => [
                    'Identify Sources of Stress',
                    'Understand the Impact of Stress',
                    'Apply Relaxation Techniques',
                    'Practice Mindfulness and Meditation',
                    'Develop Resilience and Coping Skills',
                ],
                'prerequisites' => '<p>To structure your course for maximum student engagement, start by breaking your content into clear, manageable modules that build upon each other. Begin with an introduction that outlines learning objectives, then progressively delve into more complex topics.</p><ul><li>Covering all fundamental topics with practical applications</li><li>Learn from industry professionals with years of experience</li><li>Access to a peer network and instructor feedback for enhanced learning</li></ul><p>Explore the core principles of design and discover how to apply them effectively, unlocking your full creative potential. Learn from industry professionals with years of experience. Gain practical knowledge you can immediately apply in your career or studies.</p>',
                'sections' => [
                    [
                        'title' => 'Understanding Stress',
                        'description' => 'Explore the nature of stress and its effects on the body and mind.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'What is Stress?',
                                'is_preview' => 1,
                                'content_length' => 70,
                                'description' => 'Define stress and understand its physiological impact.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Identifying Stressors',
                                'content_length' => 60,
                                'description' => 'Recognize common sources of stress in your life.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'The Stress Response',
                                'content_length' => 65,
                                'description' => 'Learn how the body reacts to stress.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Strategies for Managing Stress',
                        'description' => 'Learn practical techniques to reduce and manage stress.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Relaxation Techniques',
                                'content_length' => 75,
                                'description' => 'Practice methods like deep breathing and progressive muscle relaxation.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Mindfulness and Meditation',
                                'content_length' => 60,
                                'description' => 'Incorporate mindfulness practices into daily life.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Healthy Lifestyle Choices',
                                'content_length' => 55,
                                'description' => 'Understand the role of diet, exercise, and sleep in stress management.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Building Resilience',
                        'description' => 'Develop skills to cope with stress and bounce back from challenges.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Cognitive Restructuring',
                                'content_length' => 65,
                                'description' => 'Change negative thought patterns to reduce stress.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Emotional Regulation',
                                'content_length' => 50,
                                'description' => 'Manage emotions effectively during stressful times.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Developing a Support Network',
                                'content_length' => 55,
                                'description' => 'Leverage relationships to enhance resilience.',
                            ],
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'How quickly can I see results from stress management techniques?',
                        'answer' => 'Results vary, but consistent practice of techniques can lead to noticeable improvements over time.',
                    ],
                    [
                        'question' => 'What if I feel overwhelmed and unable to manage stress?',
                        'answer' => 'Consider seeking professional help from a counselor or therapist.',
                    ],
                    [
                        'question' => 'Can mindfulness really help reduce stress?',
                        'answer' => 'Yes, mindfulness has been shown to reduce stress and improve overall well-being.',
                    ],
                    [
                        'question' => 'How does exercise impact stress levels?',
                        'answer' => 'Regular physical activity can reduce stress hormones and promote relaxation.',
                    ],
                ],
                'noticeboards' => [
                    'New guided meditation sessions added.',
                    'Live webinar on building resilience scheduled for Thursday.',
                    'Download the stress management workbook.',
                    'Participate in the 21-day stress reduction challenge.',
                    'Updated resources on cognitive restructuring techniques.',
                    'Reminder: Complete your stress assessment survey.',
                    'Join the live Q&A with mental health professionals.',
                    'Listen to the latest podcast on mindfulness practices.',
                    'Congratulations to students who completed the stress management program!',
                ],
            ],
            // Course 12
            [
                'title' => 'Decision-Making Mastery: Make Better Choices',
                'category' => 'Productivity',
                'sub_category' => 'Leadership',
                'subtitle' => 'Enhance Your Decision-Making Skills for Success',
                'description' => '<p>Develop the ability to make informed and effective decisions. This course covers decision-making models, critical thinking, and problem-solving techniques to improve personal and professional outcomes.</p><p>You will learn how to analyze situations, weigh options, and anticipate consequences. Interactive exercises will help you apply these skills in real-world scenarios.</p>',
                'learning_objectives' => [
                    'Understand Decision-Making Processes',
                    'Apply Critical Thinking',
                    'Use Problem-Solving Techniques',
                    'Assess Risks and Benefits',
                    'Make Confident Decisions',
                ],
                'prerequisites' => '<p>To structure your course for maximum student engagement, start by breaking your content into clear, manageable modules that build upon each other. Begin with an introduction that outlines learning objectives, then progressively delve into more complex topics.</p><ul><li>Covering all fundamental topics with practical applications</li><li>Learn from industry professionals with years of experience</li><li>Access to a peer network and instructor feedback for enhanced learning</li></ul><p>Explore the core principles of design and discover how to apply them effectively, unlocking your full creative potential. Learn from industry professionals with years of experience. Gain practical knowledge you can immediately apply in your career or studies.</p>',
                'sections' => [
                    [
                        'title' => 'Foundations of Decision-Making',
                        'description' => 'Explore the principles and processes involved in making decisions.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'The Decision-Making Process',
                                'is_preview' => 1,
                                'content_length' => 70,
                                'description' => 'Learn the steps involved in effective decision-making.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Types of Decisions',
                                'content_length' => 60,
                                'description' => 'Understand different decision categories and contexts.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Common Pitfalls and Biases',
                                'content_length' => 65,
                                'description' => 'Identify and avoid common errors in decision-making.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Enhancing Decision-Making Skills',
                        'description' => 'Develop techniques to improve the quality of your decisions.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Critical Thinking Skills',
                                'content_length' => 75,
                                'description' => 'Apply logical reasoning to analyze situations.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Problem-Solving Methods',
                                'content_length' => 60,
                                'description' => 'Use structured approaches to solve complex problems.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Assessing Risks and Uncertainty',
                                'content_length' => 55,
                                'description' => 'Evaluate potential outcomes and uncertainties.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Making Confident Decisions',
                        'description' => 'Learn how to make and implement decisions with confidence.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Decision Implementation',
                                'content_length' => 65,
                                'description' => 'Plan and execute decisions effectively.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Learning from Decisions',
                                'content_length' => 50,
                                'description' => 'Reflect on outcomes to improve future decisions.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Ethical Considerations',
                                'content_length' => 55,
                                'description' => 'Incorporate ethics into the decision-making process.',
                            ],
                        ],
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'How can I reduce indecision?',
                        'answer' => 'Gather sufficient information, set deadlines, and trust your judgment to overcome indecision.',
                    ],
                    [
                        'question' => 'What if I make a wrong decision?',
                        'answer' => 'View it as a learning opportunity, analyze what went wrong, and apply those lessons moving forward.',
                    ],
                    [
                        'question' => 'How do emotions affect decision-making?',
                        'answer' => 'Emotions can bias decisions; practicing emotional awareness helps in making more rational choices.',
                    ],
                    [
                        'question' => 'Can these skills help in group decision-making?',
                        'answer' => 'Yes, applying these techniques can enhance collaboration and outcomes in team settings.',
                    ],
                ],
                'noticeboards' => [
                    'New decision-making case studies added.',
                    'Live webinar on critical thinking scheduled for Monday.',
                    'Download the decision-making toolkit.',
                    'Participate in the decision-making simulation exercise.',
                    'Updated resources on problem-solving methods.',
                    'Reminder: Complete your decision-making self-assessment.',
                    'Join the live Q&A with industry experts.',
                    'Listen to the latest podcast on overcoming decision paralysis.',
                    'Congratulations to students who completed the decision-making challenge!',
                ],
            ],
            // Course 1
            [
                'title'             => 'Time Management Mastery: Boost Your Productivity',
                'category'          => 'Productivity',
                'sub_category'      => 'Time Management',
                'subtitle'          => 'Master the Art of Time Management to Maximize Productivity and Achieve Your Goals',
                'description'       => '<p>In today\'s demanding world, mastering time management is a critical skill that can greatly enhance both your personal and professional life. This course equips you with essential tools and techniques to maximize productivity, manage time effectively, and stay focused on what truly matters.</p><p>You will learn how to prioritize tasks, set achievable goals, and create effective schedules that align with your personal and professional objectives. The course covers a wide range of topics, including time-saving tools, techniques for enhancing focus and concentration, and strategies for overcoming procrastination.</p><p>You will also explore the importance of work-life balance and how to maintain it in a fast-paced environment. Through a combination of video lectures, practical exercises, and real-world examples, you will gain the skills and knowledge needed to take control of your time and achieve your goals.</p><p>Whether you are a student, professional, or entrepreneur, this course will provide you with the insights and strategies needed to boost your productivity and make the most of your time.</p>',
                'learning_objectives' => [
                    'Prepare for Industry Certification Exam',
                    'Hours and Hours of Video Instruction',
                    'Over 25 Engaging Lab Exercises',
                    'Server Side Development with PHP',
                    'Leverage Time-Saving Tools',
                    'Learn Database Development with mySQL',
                    'Set and Achieve Goals',
                    'Enhance Focus and Concentration',
                    'Prepare for Industry Certification Exam',
                    'All Free Tools',
                    'Create Effective Schedules',
                    'Earn Certification that is Proof of your Competence',
                ],
                'prerequisites' => '<p>To structure your course for maximum student engagement, start by breaking your content into clear, manageable modules that build upon each other. Begin with an introduction that outlines learning objectives, then progressively delve into more complex topics.</p><ul><li>Covering all fundamental topics with practical applications</li><li>Learn from industry professionals with years of experience</li><li>Access to a peer network and instructor feedback for enhanced learning</li></ul><p>Explore the core principles of design and discover how to apply them effectively, unlocking your full creative potential. Learn from industry professionals with years of experience. Gain practical knowledge you can immediately apply in your career or studies.</p>',
                'sections'          => [
                    [
                        'title' => 'Introduction to Design',
                        'description' => 'Delve into the key principles of design and learn how to apply them in real-world projects, enhancing your creative skills and transforming ideas into impactful visuals.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Welcome to the Design Class',
                                'is_preview'    => 1,
                                'content_length' => 90,
                                'description' => 'Learn the fundamentals of design and unlock your creative potential.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Tools Introduction',
                                'content_length' => 15,
                                'description' => 'An overview of essential design tools.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'HTML5 Certification',
                                'content_length' => 1,
                                'description' => 'Prepare for your HTML5 certification with this comprehensive guide.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Certified HTML5 Foundations 2023/2024',
                        'description' => 'Master the essentials of HTML5 and build a strong foundation for web development.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'HTML5 Basics',
                                'content_length' => 70,
                                'description' => 'Learn the fundamental concepts of HTML5.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Advanced HTML5 Techniques',
                                'content_length' => 120,
                                'description' => 'Explore advanced techniques and best practices in HTML5.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'HTML5 Forms and Validation',
                                'content_length' => 85,
                                'description' => 'Learn how to create and validate forms using HTML5.',
                            ],

                        ],
                    ],
                    [
                        'title' => 'Your Development Toolbox',
                        'description' => 'Discover essential tools and resources for effective development.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Tool Selection',
                                'content_length' => 45,
                                'description' => 'Learn how to choose the right tools for your projects.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Version Control Systems',
                                'content_length' => 60,
                                'description' => 'Understand the importance of version control systems and how to use them.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Debugging Techniques',
                                'content_length' => 50,
                                'description' => 'Learn effective debugging techniques to troubleshoot your code.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Program Information 2023/2024 Edition',
                        'description' => 'Get updated with the latest program information and curriculum changes.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Program Overview',
                                'content_length' => 48,
                                'description' => 'An overview of the program structure and updates.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Curriculum Changes',
                                'content_length' => 55,
                                'description' => 'Detailed explanation of the latest curriculum changes.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Program Highlights',
                                'content_length' => 40,
                                'description' => 'Highlights of the key features and benefits of the program.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'The Python Input Function',
                        'description' => 'Understand the Python input function and how to use it effectively.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Input Function Basics',
                                'content_length' => 65,
                                'description' => 'Learn how to use the input function in Python.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Advanced Input Techniques',
                                'content_length' => 70,
                                'description' => 'Explore advanced techniques for using the input function in Python.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Input Function Best Practices',
                                'content_length' => 55,
                                'description' => 'Learn best practices for using the input function effectively in your Python programs.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'String Manipulation and Code Intelligence',
                        'description' => 'Enhance your skills in string manipulation and code intelligence.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'String Basics',
                                'content_length' => 87,
                                'description' => 'Learn the basics of string manipulation in programming.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Advanced String Techniques',
                                'content_length' => 75,
                                'description' => 'Explore advanced techniques for string manipulation.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'String Manipulation Best Practices',
                                'content_length' => 60,
                                'description' => 'Learn best practices for effective string manipulation in your programs.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'JavaScript Specialist',
                        'description' => 'Become a specialist in JavaScript with advanced techniques and practices.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'JavaScript Essentials',
                                'content_length' => 20,
                                'description' => 'Master the essential concepts of JavaScript.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Advanced JavaScript Techniques',
                                'content_length' => 45,
                                'description' => 'Explore advanced techniques and features in JavaScript.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'JavaScript Best Practices',
                                'content_length' => 30,
                                'description' => 'Learn best practices for writing clean and efficient JavaScript code.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'What we will make by the end of the day',
                        'description' => 'Explore the projects and skills you will develop by the end of the course.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Project Overview',
                                'content_length' => 35,
                                'description' => 'An overview of the projects you will complete.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Project Planning',
                                'content_length' => 45,
                                'description' => 'Detailed planning of the projects you will work on.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Project Execution',
                                'content_length' => 50,
                                'description' => 'Step-by-step execution of the projects.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Day 1 Project: Band Name Generator',
                        'description' => 'Create a fun and interactive band name generator as your first project.',
                        'curriculums' => [
                            [
                                'type' => 'video',
                                'title' => 'Project Introduction',
                                'content_length' => 40,
                                'description' => 'Introduction to the Band Name Generator project.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Setting Up the Environment',
                                'content_length' => 30,
                                'description' => 'Guide to setting up the development environment for the project.',
                            ],
                            [
                                'type' => 'video',
                                'title' => 'Coding the Generator',
                                'content_length' => 50,
                                'description' => 'Step-by-step coding of the Band Name Generator.',
                            ],
                        ],
                    ],
                ],
                'faqs' => [
                    ['question' => 'How can I locate a tutor who specializes in the particular subject I need help with?', 'answer' => 'To locate a tutor, simply utilize the site\'s search feature, where you can filter by subject, educational level, and location. This allows you to narrow down your options and connect with tutors who have expertise in the specific area you need help with, ensuring that you find a suitable match to meet your educational goals effectively.'],
                    ['question' => 'What should I do if my tutor doesn\'t show up?', 'answer' => 'If your tutor doesn\'t show up, first try to contact them directly through the platform\'s messaging system. If you are unable to reach them, report the issue to the support team, who will assist you in rescheduling the session or finding an alternative tutor to ensure your learning is not disrupted.'],
                    ['question' => 'How can I update my profile, contact details, or profile picture?', 'answer' => 'To update your profile, contact details, or profile picture, navigate to the account settings section of the platform. Here, you can edit your personal information, upload a new profile picture, and save the changes to keep your profile up-to-date and accurate.'],
                    ['question' => 'How can I locate a tutor who specializes?', 'answer' => 'To locate a tutor who specializes, use the platform\'s advanced search filters. You can specify the subject, educational level, and other criteria to find tutors with the expertise you need. This ensures you connect with the right tutor to meet your specific learning requirements.'],
                    ['question' => 'How can I locate a tutor who specializes in the particular?', 'answer' => 'To locate a tutor who specializes in the particular area you need help with, use the search feature on the platform. Filter by subject, educational level, and other relevant criteria to find tutors with the necessary expertise, ensuring you receive the best possible guidance and support.'],
                    ['question' => 'How can I locate a tutor who specializes in the particular subject ?', 'answer' => 'To locate a tutor who specializes in the particular subject, use the platform\'s search functionality. Apply filters for subject, educational level, and location to narrow down your options and connect with tutors who have the specific knowledge and skills you need to achieve your learning goals.'],
                ],
                'noticeboards' => [
                    'New design tutorial added on color theory.',
                    'Updated design guide with latest best practices.',
                    'Live Q&A session scheduled for next week.',
                    'Additional practice exercises added to the curriculum.',
                    'New video content on productivity tools coming soon.',
                    'Join our upcoming workshop on effective communication.',
                    'Important update: Course materials have been revised.',
                    'Check out our new blog post on time management tips.',
                    'Reminder: Complete the pre-course survey for feedback.',
                    'Exciting news: Guest speaker session announced!',
                    'New feature: Track your progress with our dashboard.',
                    'Upcoming event: Networking session for course participants.',
                ],
            ],
        ];

        $tutors = User::whereHas('roles', function ($query) {
            $query->where('name', 'tutor');
        })->take(3)->get();

        if ($tutors->isEmpty()) {
            return;
        }

        foreach ($courses as $key => $courseData) {
            //Create course
            $course = Course::create([
                'instructor_id'                     => $this->getInstructorId($tutors, $key),
                'title'                             => $courseData['title'],
                'subtitle'                          => $courseData['subtitle'],
                'description'                       => $courseData['description'],
                'category_id'                       => Category::where('name', $courseData['category'])->first()->id,
                'sub_category_id'                   => Category::where('name', $courseData['sub_category'])->first()->id,
                'tags'                              => [$courseData['category'], $courseData['sub_category']],
                'type'                              => 'video',
                'level'                             => ['beginner', 'intermediate', 'expert', 'all'][array_rand(['beginner', 'intermediate', 'expert', 'all'])],
                'discussion_forum'                  => (bool)random_int(0, 1),
                'language_id'                       => 23,
                'learning_objectives'               => $courseData['learning_objectives'],
                'prerequisites'                     => $courseData['prerequisites'],
                'status'                            => 'active',
                'content_length'                    => collect($courseData['sections'])->flatMap(function ($section) {
                    return collect($section['curriculums'])->sum('content_length');
                })->sum(),
                'views_count'                       => rand(100, 1000),
                'created_at'                        => Carbon::now(),
                'updated_at'                        => Carbon::now(),
            ]);

            $noticeboards = $courseData['noticeboards'];
            if (!empty($noticeboards)) {
                foreach ($noticeboards as $noticeboard) {
                    Noticeboard::create([
                        'course_id'   => $course->id,
                        'content' => $noticeboard,
                    ]);
                }
            }

            $students = User::whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })->get();

            $ratings = [
                [
                    'ratingable_type'     => Course::class,
                    'ratingable_id'       => $course->id,
                    'tutor_id'            => 2,
                    'rating'              => 5,
                    'comment'             => 'Steven is an outstanding tutor! His expertise and passion for teaching are evident in every session. He breaks down complex topics into understandable segments, making learning enjoyable. My grades have improved significantly since we started with Steven. Highly recommend!',
                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                ],
                [
                    'ratingable_type'     => Course::class,
                    'ratingable_id'       => $course->id,
                    'tutor_id'            => 2,
                    'rating'              => 5,
                    'comment'             => 'Steven is an exceptional tutor! His teaching methods are clear and effective, making complex subjects easy to understand. I look forward to every session and has shown remarkable improvement in my studies. Highly recommend Steven for anyone seeking a knowledgeable and patient tutor!',
                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                ],
                [
                    'ratingable_type'     => Course::class,
                    'ratingable_id'       => $course->id,
                    'tutor_id'            => 2,
                    'rating'              => 5,
                    'comment'             => 'Steven is an amazing tutor! His knowledge and enthusiasm for teaching shine through in every lesson. He simplifies complex topics, making them easy to grasp. My child\'s understanding and grades have improved greatly since we began with Steven. Highly recommend!',
                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                ],
            ];

            if (!empty($students)) {
                foreach ($students as $index => $student) {
                    if (!empty($ratings[$index])) {
                        $ratings[$index]['student_id'] = $student->id;
                        Rating::insert($ratings[$index]);
                    }
                }
            }

            $thumbnailPath = $this->addImage($course->id);
            if ($thumbnailPath) {
                (new CourseService)->addCourseMedia($course, [
                    'mediable_id'       => $course->id,
                    'mediable_type'     => 'course',
                    'type'              => 'thumbnail',
                ], [
                    'path'              => $thumbnailPath,
                ]);
            }


            $promotionalVideoPath = $this->addVideo($course->id);
            if ($promotionalVideoPath) {
                (new CourseService)->addCourseMedia($course, [
                    'mediable_id'       => $course->id,
                    'mediable_type'     => 'course',
                    'type'              => 'promotional_video',
                ], [
                    'path'              => $promotionalVideoPath,
                ]);
            }

            $price = rand(100, 500);
            $discount = rand(10, 50) * ($course->id % 2);
            $final_price = $price - ($price * $discount / 100);

            Pricing::create([
                'course_id'                         => $course->id,
                'price'                             => $price,
                'discount'                          => $discount,
                'final_price'                       => $final_price,
            ]);


            // Create course sections
            foreach ($courseData['sections'] as $sectionData) {
                $section = Section::create([
                    'course_id'                     => $course->id,
                    'title'                         => $sectionData['title'],
                    'description'                   => $sectionData['description'],
                    'created_at'                    => Carbon::now(),
                    'updated_at'                    => Carbon::now(),
                ]);

                // Create section curriculums
                $sort_order = 0;
                foreach ($sectionData['curriculums'] as $curriculumData) {
                    Curriculum::create([
                        'section_id'                => $section->id,
                        'type'                      => $curriculumData['type'],
                        'title'                     => $curriculumData['title'],
                        'content_length'            => $curriculumData['content_length'],
                        'description'               => $curriculumData['description'],
                        'media_path'                => $curriculumData['type'] == 'video' ? $this->addVideo($course->id) : null,
                        'article_content'           => $curriculumData['type'] == 'article' ? $curriculumData['article_content'] : null,
                        'is_preview'                => $curriculumData['is_preview'] ?? 0,
                        'sort_order'                => $sort_order++,
                        'created_at'                => Carbon::now(),
                        'updated_at'                => Carbon::now(),
                    ]);
                }
            }

            (new CourseService())->updateCourseContentLength($course);

            // Create course FAQs
            $courseData['faqs'] =  [
                ['question' => 'How can I locate a tutor who specializes in the particular subject I need help with?', 'answer' => 'To locate a tutor, simply utilize the site\'s search feature, where you can filter by subject, educational level, and location. This allows you to narrow down your options and connect with tutors who have expertise in the specific area you need help with, ensuring that you find a suitable match to meet your educational goals effectively.'],
                ['question' => 'What should I do if my tutor doesn\'t show up?', 'answer' => 'If your tutor doesn\'t show up, first try to contact them directly through the platform\'s messaging system. If you are unable to reach them, report the issue to the support team, who will assist you in rescheduling the session or finding an alternative tutor to ensure your learning is not disrupted.'],
                ['question' => 'How can I update my profile, contact details, or profile picture?', 'answer' => 'To update your profile, contact details, or profile picture, navigate to the account settings section of the platform. Here, you can edit your personal information, upload a new profile picture, and save the changes to keep your profile up-to-date and accurate.'],
                ['question' => 'How can I locate a tutor who specializes?', 'answer' => 'To locate a tutor who specializes, use the platform\'s advanced search filters. You can specify the subject, educational level, and other criteria to find tutors with the expertise you need. This ensures you connect with the right tutor to meet your specific learning requirements.'],
                ['question' => 'How can I locate a tutor who specializes in the particular?', 'answer' => 'To locate a tutor who specializes in the particular area you need help with, use the search feature on the platform. Filter by subject, educational level, and other relevant criteria to find tutors with the necessary expertise, ensuring you receive the best possible guidance and support.'],
                ['question' => 'How can I locate a tutor who specializes in the particular subject ?', 'answer' => 'To locate a tutor who specializes in the particular subject, use the platform\'s search functionality. Apply filters for subject, educational level, and location to narrow down your options and connect with tutors who have the specific knowledge and skills you need to achieve your learning goals.'],
            ];

            foreach ($courseData['faqs'] as $faqData) {
                FAQ::create([
                    'course_id'                     => $course->id,
                    'question'                      => $faqData['question'],
                    'answer'                        => $faqData['answer'],
                    'created_at'                    => Carbon::now(),
                    'updated_at'                    => Carbon::now(),
                ]);
            }
        }
    }

    private function seedCategories()
    {
        $categories = [
            'Productivity' => [
                'Time Management',
                'Goal Setting',
                'Focus and Concentration',
                'Motivation',
                'Leadership',
                'Networking',
                'Continuous Learning',
                'Innovation and Creativity',
                'Communication',
                'Work-Life Balance'
            ],
            'Web Development' => [
                'HTML & CSS',
                'WordPress Theme',
                'Bootstrap',
            ],
            'Graphic Design' => [
                'Photoshop',
                'Adobe Illustrator',
                'Drawing',
                'Color Theory',
            ],
            '3D & Animation' => [
                'Blender',
                'Motion Graphics',
            ],
            'Fashion & Textile' => [
                'Sewing',
                'Fashion Design Basics',
            ],
            'Mobile Development & Design' => [
                'Mobile App Design',
                'UX/UI for Mobile',
            ],
            'Digital Art & Illustration' => [
                'Drawing',
                'Color Theory',
                'Adobe Illustrator',
            ],
            'Creative Software Tools' => [
                'Photoshop',
                'Blender',
                'Adobe Illustrator',
            ],
            'Interior & Lighting Design' => [
                'Lighting Design',
                'Interior Design Basics',
            ],
            'Handicraft & DIY' => [
                'Sewing',
                'Crafting Basics',
            ],
            'Media & Visual Arts' => [
                'Motion Graphics',
                'Drawing',
                'Lighting Design',
            ],
        ];


        if (!empty($categories)) {

            foreach ($categories as $category => $subcategories) {
                $category = Category::create([
                    'parent_id' => null,
                    'name' => $category,
                    'image' => null,
                    'slug' => Str::slug($category),
                    'description' => null,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if (!empty($subcategories)) {
                    foreach ($subcategories as $subcategory) {
                        Category::create([
                            'parent_id' => $category->id,
                            'name' => $subcategory,
                            'image' => null,
                            'slug' => Str::slug($subcategory),
                            'description' => null,
                            'status' => 'active',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }

    private function addImage($courseId)
    {
        $assetNumber = $courseId;
        $imageName = Str::random(30) . '.png';

        if (!File::exists(storage_path('app/public/courses'))) {
            File::makeDirectory(storage_path('app/public/courses'), 0755, true, true);
        }

        Storage::disk(getStorageDisk())->putFileAs('courses', public_path('modules/courses/demo-content/images/' . $assetNumber . '.png'), $imageName);

        return 'courses/' . $imageName;
    }

    private function addVideo($courseId)
    {
        $assetNumber = $courseId % 3 > 0 ? ($courseId % 3) : 3;

        $videoName = Str::random(30) . '.mp4';

        if (!File::exists(storage_path('app/public/courses'))) {
            File::makeDirectory(storage_path('app/public/courses'), 0755, true, true);
        }

        Storage::disk(getStorageDisk())->putFileAs('courses', public_path('modules/courses/demo-content/videos/' . $assetNumber . '.mp4'), $videoName);

        return 'courses/' . $videoName;
    }

    private function setEmailTemplates()
    {
        $emailTemplates = $this->getEmailTemplates();

        foreach ($emailTemplates as $type => $template) {

            foreach (!empty($template['roles']) ? $template['roles'] : [] as $role => $data) {
                EmailTemplate::updateOrCreate([
                    'type' => $type,
                    'title' => $template['title'],
                    'role' => $role,
                    'content' => ['info' => $data['fields']['info']['desc'], 'subject' => $data['fields']['subject']['default'], 'greeting' => $data['fields']['greeting']['default'], 'content' => $data['fields']['content']['default']]
                ]);
            }
        }
    }

    private function getEmailTemplates()
    {
        return
            [
                'sessionBooking' => [
                    'version' => '1.0',
                    'title' => __('courses::courses.session_booking_title'),
                    'roles' => [
                        'student' => [
                            'fields' => [
                                'info' => [
                                    'title' => __('courses::courses.variables_used'),
                                    'icon' => 'icon-info',
                                    'desc' => __('courses::courses.course_purchase_student_variables'),
                                ],
                                'subject' => [
                                    'id' => 'subject',
                                    'title' => __('courses::courses.subject'),
                                    'default' => __('courses::courses.course_purchase'),
                                ],
                                'greeting' => [
                                    'id' => 'greeting',
                                    'title' => __('courses::courses.greeting_text'),
                                    'default' => __('courses::courses.greeting', ['userName' => '{studentName}']),
                                ],
                                'content' => [
                                    'id' => 'content',
                                    'title' => __('courses::courses.email_content'),
                                    'default' => __('courses::courses.course_purchase_msg', ['userName' => '{studentName}', 'tutorName' => '{tutorName}', 'sessionSubject' => '{sessionSubject}', 'sessionDate' => '{sessionTime}', 'bookingDetails' => '{bookingDetails}']),
                                ],
                            ],
                        ],
                        'tutor' => [
                            'fields' => [
                                'info' => [
                                    'title' => __('courses::courses.variables_used'),
                                    'icon' => 'icon-info',
                                    'desc' => __('courses::courses.course_purchase_tutor_variables'),
                                ],
                                'subject' => [
                                    'id' => 'subject',
                                    'title' => __('courses::courses.subject'),
                                    'default' => __('courses::courses.course_purchase_tutor_subject'),
                                ],
                                'greeting' => [
                                    'id' => 'greeting',
                                    'title' => __('courses::courses.greeting_text'),
                                    'default' => __('courses::courses.greeting', ['userName' => '{tutorName}']),
                                ],
                                'content' => [
                                    'id' => 'content',
                                    'title' => __('courses::courses.email_content'),
                                    'default' => __('courses::courses.course_buy_tutor_content', ['userName' => '{tutorName}', 'studentName' => '{studentName}', 'sessionSubject' => '{sessionSubject}', 'sessionDate' => '{sessionTime}', 'bookingDetails' => '{bookingDetails}']),
                                ],
                            ],
                        ],
                    ],
                ],
                'courseApproved' => [
                    'title' => __('courses::courses.course_approved_email_title'),
                    'roles' => [
                        'tutor' => [
                            'fields' => [
                                'info' => [
                                    'title' => __('courses::courses.course_approved_email_subject'),
                                    'icon' => 'icon-info',
                                    'desc' => __('courses::courses.course_approved_email_content', ['course_title' => '{courseTitle}']),
                                ],
                                'subject' => [
                                    'id' => 'subject',
                                    'title' => __('courses::courses.course_approved_email_subject'),
                                    'default' => __('courses::courses.course_approved_email_subject'),
                                ],
                                'greeting' => [
                                    'id' => 'greeting',
                                    'title' => __('email_template.greeting_text'),
                                    'default' => __('courses::courses.course_approved_email_greeting', ['userName' => '{userName}']),
                                ],
                                'content' => [
                                    'id' => 'content',
                                    'title' => __('courses::courses.course_approved_email_subject'),
                                    'default' => __('courses::courses.course_approved_email_content', ['course_title' => '{courseTitle}']),
                                ],
                            ],
                        ],
                    ],
                ],
                'courseRejected' => [
                    'title' => __('courses::courses.course_rejected_email_title'),
                    'roles' => [
                        'tutor' => [
                            'fields' => [
                                'info' => [
                                    'title' => __('courses::courses.course_rejected_email_subject'),
                                    'icon' => 'icon-info',
                                    'desc' => __('courses::courses.course_rejected_email_content', ['course_title' => '{courseTitle}']),
                                ],
                                'subject' => [
                                    'id' => 'subject',
                                    'title' => __('courses::courses.course_rejected_email_subject'),
                                    'default' => __('courses::courses.course_approved_email_subject'),
                                ],
                                'greeting' => [
                                    'id' => 'greeting',
                                    'title' => __('email_template.greeting_text'),
                                    'default' => __('courses::courses.course_rejected_email_greeting', ['userName' => '{userName}']),
                                ],
                                'content' => [
                                    'id' => 'content',
                                    'title' => __('courses::courses.course_approved_email_subject'),
                                    'default' => __('courses::courses.course_rejected_email_subject', ['course_title' => '{courseTitle}']),
                                ],
                            ],
                        ],
                    ],
                ],
            ];
    }

    public function addCourseMenu()
    {
        $coursesMenu = MenuItem::where('label', 'Courses')->delete();

        $menus = Menu::whereLocation('header')->select('id')->get();

        if ($menus->count() > 0) {
            foreach ($menus as $menu) {
                MenuItem::create([
                    'menu_id'   => $menu->id,
                    'parent_id' => null,
                    'label'     => 'Courses',
                    'route'     => url('search-courses'),
                    'type'      => 'page',
                    'sort'      => '2',
                    'class'     => '',
                ]);
            }
        }

        Artisan::call('cache:clear');
    }

    private function getInstructorId($tutors, $key)
    {
        if ($key < 4) {
            return $tutors[0]->id;
        } elseif ($key < 8) {
            return $tutors[1]->id ??  $tutors[0]->id;
        } elseif ($key < 12) {
            return $tutors[2]->id ?? $tutors[1]->id ?? $tutors[0]->id;
        }
    }
}
