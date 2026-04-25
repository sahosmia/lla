<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserCertificate;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserSubjectGroup;
use App\Models\UserSubjectGroupSubject;
use App\Models\UserSubjectSlot;
use App\Services\BookingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        UserSubjectSlot::truncate();
        UserEducation::truncate();
        UserExperience::truncate();
        UserCertificate::truncate();
        $users = [
            'admin' => [
                [
                    'email'         => 'admin@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Admin',
                    'last_name'     => 'Admin',
                    'image'         => 'admin-image.jpg',
                ]
            ],
            'tutor' => [
                [ // 2 M
                    'email'         => 'tutor@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Steven',
                    'last_name'     => 'Ford',
                    'gender'        => 'male',
                    'tagline'       => 'Empowring Success through Customized Learning Strategies',
                    'description'   => '<p>Hi! I am Steven Ford, a passionate and experienced tutor dedicated to helping students unlock their full potential. With a strong academic background and years of hands-on teaching experience, I have developed a deep understanding of various learning styles and strategies to cater to each student\'s unique needs. I believe that education is not just about memorizing facts but about fostering critical thinking, creativity, and a genuine love for learning. Whether you are struggling with a specific subject or looking to excel beyond your current level, I am here to guide you every step of the way. My approach is student-centered, focusing on building confidence, enhancing understanding, and developing the skills necessary for academic success. I strive to create a supportive and engaging learning environment where students feel comfortable asking questions and exploring new ideas.</p>
                                        <p>I specialize in a wide range of subjects, including mathematics, science, and English, with a particular emphasis on helping students prepare for exams and standardized tests. Over the years, I have worked with students from various age groups and educational backgrounds, from elementary school to college level. My teaching methods are tailored to each student\'s individual learning pace, ensuring that they grasp the concepts fully before moving on. I incorporate a variety of teaching tools and techniques, such as interactive exercises, real-life examples, and personalized study plans, to make learning both effective and enjoyable. My goal is to help students achieve academic success and inspire them to become lifelong learners.</p>
                                        <p>In addition to subject-specific tutoring, I also offer support in study skills, time management, and test-taking strategies. I understand that every student has their strengths and challenges, and I work diligently to identify and address any barriers to learning. My tutoring sessions are designed to be flexible and accommodating, allowing students to learn at their own pace while keeping them motivated and on track. I am committed to making a positive impact on my students\' academic journeys, and I take great pride in their achievements. Whether you need help with a challenging topic or want to boost your overall academic performance, I am here to help you succeed. Let\'s work together to achieve your educational goals!</p>',
                    'image'         => 'tutor-1.jpg',
                    'intro_video'   => 'tutor-video-1.mp4',
                    'phone_number'  => '07123456789',
                    'verified_at'   =>  now(),
                    'languages'     => [2, 3],
                    'native_language' => 'Arabic',
                    'experience'    => [
                        [
                            'title'             => 'Elementary School Teacher',
                            'user_id'           => 2,
                            'employment_type'   => '2',
                            'company'           => 'Algiers International School',
                            'location'          => 'onsite',
                            'country_id'        => 3,
                            'city'              => 'Algiers',
                            'start_date'        => '2010-09-01',
                            'end_date'          => '2016-06-30',
                            'description'       => 'Taught all core subjects to students in grades 1-4, and organized extracurricular activities focused on arts and sports.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Education Consultant',
                            'user_id'           => 2,
                            'employment_type'   => '2',
                            'company'           => 'Angola Education Development',
                            'location'          => 'remote',
                            'country_id'        => 4,
                            'city'              => 'Luanda',
                            'start_date'        => '2017-01-01',
                            'end_date'          => '2021-12-31',
                            'description'       => 'Provided consultancy services to schools and educational institutions, focusing on curriculum development and teacher training.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Curriculum Developer',
                            'user_id'           => 2,
                            'employment_type'   => '1',
                            'company'           => 'Global Education Solutions',
                            'location'          => 'hybrid',
                            'country_id'        => 5,
                            'city'              => 'Cairo',
                            'start_date'        => '2022-02-01',
                            'end_date'          => '2023-08-31',
                            'description'       => 'Developed and revised curriculum content for K-12 schools, balancing remote and onsite work environments.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'School Administrator',
                            'user_id'           => 2,
                            'employment_type'   => '3',
                            'company'           => 'Nairobi International School',
                            'location'          => 'onsite',
                            'country_id'        => 6,
                            'city'              => 'Nairobi',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Oversee day-to-day operations of the school, manage staff, and implement educational programs.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],
                    'certificate'   => [
                        [
                            'user_id'           => 2,
                            'title'             => 'Certified Web Development Instructor',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Tech Academy',
                            'issue_date'        => '2015-09-01',
                            'expiry_date'       => '2017-09-01',
                            'description'       => 'Certification for teaching full-stack web development, including HTML, CSS, JavaScript, and React.',
                            'created_at'        => '2018-09-01',
                            'updated_at'        => '2023-09-01',
                        ],
                        [
                            'user_id'           => 2,
                            'title'             => 'Certified Web Design Instructor',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Creative Design School',
                            'issue_date'        => '2018-01-01',
                            'expiry_date'       => '2020-01-01',
                            'description'       => 'Certification for teaching web design principles, UI/UX, and tools like Adobe XD and Figma.',
                            'created_at'        => '2015-01-01',
                            'updated_at'        => '2021-01-01',
                        ],
                        [
                            'user_id'           => 2,
                            'title'             => 'Certified Software Development Lecturer',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'Kuwait IT Institute',
                            'issue_date'        => '2021-03-01',
                            'expiry_date'       => '2023-03-01',
                            'description'       => 'Certification for teaching software development, including object-oriented programming and software life cycles.',
                            'created_at'        => '2017-03-01',
                            'updated_at'        => '2022-03-01',
                        ],
                        [
                            'user_id'           => 2,
                            'title'             => 'Certified Data Science Professional',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Data Science Institute',
                            'issue_date'        => '2023-06-01',
                            'expiry_date'       => '2025-06-01',
                            'description'       => 'Certification for advanced data science and analytics skills, including machine learning and big data technologies.',
                            'created_at'        => '2023-06-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],
                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'Azam University',
                            'country_id' => 1,
                            'city' => 'Kabul',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Specializing in software development and cybersecurity, I provide expertise in creating secure applications and safeguarding systems from cyber threats, ensuring robust and reliable technology solutions.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'Numl Institute',
                            'country_id' => 2,
                            'city' => 'SJomala',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I offer expertise in optimizing technology infrastructure, managing complex IT systems, and deriving actionable insights from data.',
                        ],
                        [
                            'course_title' => 'Diploma in Web Development',
                            'institute_name' => 'Tech Academy',
                            'country_id' => 3,
                            'city' => 'London',
                            'start_date' => '2018-01-01',
                            'end_date' => '2018-12-31',
                            'ongoing' => 0,
                            'description' => 'Covered modern web technologies and full-stack development, I build dynamic, scalable web applications and integrate front-end and back-end solutions to deliver seamless user experiences.',
                        ],
                        [
                            'course_title' => 'Certification in Data Science',
                            'institute_name' => 'Data Science Hub',
                            'country_id' => 4,
                            'city' => 'New York',
                            'start_date' => '2023-02-01',
                            'end_date' => '2023-08-01',
                            'ongoing' => 1,
                            'description' => 'Focused on data analysis, machine learning, and statistical methods, I apply advanced techniques to uncover insights, develop predictive models, and drive data-driven decision-making.',
                        ],
                    ],

                    'address'       => [
                        'country_id'   => 1,
                        'state_id'     => 2,
                        'city'         => 'Kabul',
                        'address'      => '123 Main St',
                        'zipcode'      => '10001',
                        'lat'          => 40.712776,
                        'long'         => -74.005974
                    ],
                    'subjects'      => [
                        '1' =>  [
                            [
                                'id' => 1,
                                'image' => 'web_development.png',
                                'hour_rate' => 20,
                                'description' => 'Web development involves the creation and maintenance of websites and web applications, encompassing both front-end and back-end technologies. It includes designing user interfaces, implementing functionality, and ensuring optimal performance and security.',
                            ],
                            [
                                'id' => 2,
                                'image' => 'web_designing.png',
                                'hour_rate' => 30,
                                'description' => 'Web designing focuses on creating visually appealing and user-friendly interfaces for websites. It involves designing layouts, graphics, and interactive elements to enhance user experience and engagement.',
                            ],
                            [
                                'id' => 3,
                                'image' => 'software_development.png',
                                'hour_rate' => 40,
                                'description' => 'Software development is the process of designing, coding, testing, and maintaining software applications. It involves translating user needs into functional and efficient software solutions through various programming languages and methodologies.',
                            ]
                        ],
                        '2' =>  [
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 8,
                                'image' => 'urdu.png',
                                'hour_rate' => 90,
                                'description' => 'Urdu is a South Asian language spoken primarily in Pakistan and India, known for its rich literary heritage and use of the Perso-Arabic script. It serves as a key medium for communication, literature, and cultural expression in the region.',
                            ],
                            [
                                'id' => 9,
                                'image' => 'gk.png',
                                'hour_rate' => 100,
                                'description' => 'General knowledge encompasses a broad range of information about various subjects, including history, geography, culture, current events, and more. It involves understanding fundamental concepts and facts that provide a well-rounded awareness of the world.',
                            ]
                        ],
                        '3' =>  [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 13,
                                'image' => 'computer.png',
                                'hour_rate' => 70,
                                'description' => 'Computer science is the study of computers and computational systems, encompassing their theory, design, development, and application. It involves programming, algorithms, data structures, and the development of software and hardware to solve problems and create technological solutions.',
                            ],
                        ]


                    ],
                    'social_profiles' => [
                        [
                            'type' => 'Facebook',
                            'url' => 'https://www.facebook.com/',
                        ],
                        [
                            'type' => 'X/Twitter',
                            'url' => 'https://x.com/',
                        ],
                        [
                            'type' => 'LinkedIn',
                            'url' => 'https://www.linkedin.com/',
                        ],
                        [
                            'type' => 'Instagram',
                            'url' => 'https://www.instagram.com/',
                        ],
                        [
                            'type' => 'Pinterest',
                            'url' => 'https://www.pinterest.com/',
                        ],
                        [
                            'type' => 'YouTube',
                            'url' => 'https://www.youtube.com/',
                        ],
                        [
                            'type' => 'TikTok',
                            'url' => 'https://www.tiktok.com/',
                        ],
                    ],
                ],
                [ // 3 M
                    'email'         => 'anthony@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Anthony',
                    'last_name'     => 'Shao',
                    'gender'        => 'male',
                    'image'         => 'tutor-2.jpg',
                    'intro_video'   => 'tutor-video-2.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Inspiring Achievement Through Tailored Educational Support',
                    'description'   => '<p>Hello! I’m Anthony Shao, a committed and enthusiastic tutor with a passion for empowering students to reach their academic goals. My approach to tutoring is centered on the belief that every student has the potential to excel when given the right guidance and support. I bring a diverse skill set to my tutoring sessions, with expertise in subjects ranging from mathematics and science to English. My aim is to make learning an enjoyable and rewarding experience by breaking down complex concepts into manageable and understandable parts. I take pride in creating a welcoming and encouraging environment where students feel comfortable expressing their difficulties and asking questions.</p>
                                        <p>Throughout my tutoring career, I have had the privilege of working with students across various age groups and educational stages, helping them overcome obstacles and achieve success. My teaching style is highly adaptable, as I understand that each student learns differently. Whether it’s through hands-on problem-solving, interactive discussions, or real-world applications, I tailor my lessons to match the learning style of each individual. My sessions are not just about getting the right answers but about building a deep understanding and fostering critical thinking skills that will benefit students in all areas of their education.</p>
                                        <p>In addition to subject-specific tutoring, I also focus on strengthening essential academic skills, such as effective studying techniques, time management, and exam preparation strategies. I recognize that the path to academic success is unique for each student, and I am dedicated to helping them navigate it with confidence. My goal is to instill a sense of achievement in my students, motivating them to take on new challenges and succeed in their educational endeavors. Whether you’re looking for help in a particular subject or need guidance to improve your overall academic performance, I am here to support you on your journey. Together, we can achieve your academic goals and build a strong foundation for future success.</p>',
                    'verified_at'   =>  now(),
                    'languages'     => [4, 5],
                    'native_language' => 'Albanian',
                    'experience' => [
                        [
                            'title'             => 'University Lecturer',
                            'user_id'           => 3,
                            'employment_type'   => '2',
                            'company'           => 'University of Tirana',
                            'location'          => 'hybrid',
                            'country_id'        => 2,
                            'city'              => 'Tirana',
                            'start_date'        => '2012-10-01',
                            'end_date'          => '2018-07-31',
                            'description'       => 'Lectured in Political Science, conducted research, and published academic papers in international journals.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'University Professor',
                            'user_id'           => 3,
                            'employment_type'   => '2',
                            'company'           => 'Australian National University',
                            'location'          => 'hybrid',
                            'country_id'        => 7,
                            'city'              => 'Canberra',
                            'start_date'        => '2019-01-01',
                            'end_date'          => '2024-12-31',
                            'description'       => 'Taught courses in Environmental Science, supervised PhD students, and published research on climate change.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Visiting Scholar',
                            'user_id'           => 3,
                            'employment_type'   => '3',
                            'company'           => 'Harvard University',
                            'location'          => 'onsite',
                            'country_id'        => 8,
                            'city'              => 'Cambridge',
                            'start_date'        => '2018-09-01',
                            'end_date'          => '2019-05-31',
                            'description'       => 'Collaborated with faculty on research projects related to international relations and delivered guest lectures.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Research Scientist',
                            'user_id'           => 3,
                            'employment_type'   => '1',
                            'company'           => 'Max Planck Institute for Meteorology',
                            'location'          => 'remote',
                            'country_id'        => 9,
                            'city'              => 'Hamburg',
                            'start_date'        => '2020-03-01',
                            'end_date'          => '2024-08-31',
                            'description'       => 'Conducted research on climate models, wrote scientific papers, and participated in international conferences.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],
                    'certificate'   => [
                        [
                            'user_id'           => 3,
                            'title'             => 'Certified UI/UX Design Instructor',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Design Hub',
                            'issue_date'        => '2016-02-01',
                            'expiry_date'       => '2021-02-01',
                            'description'       => 'Certification for teaching UI/UX design, including wireframing, prototyping, and user research.',
                            'created_at'        => '2016-02-01',
                            'updated_at'        => '2021-02-01',
                        ],
                        [
                            'user_id'           => 3,
                            'title'             => 'Certified English Teacher',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'International School',
                            'issue_date'        => '2014-09-01',
                            'expiry_date'       => '2020-09-01',
                            'description'       => 'Certification for teaching English language and literature to high school students.',
                            'created_at'        => '2014-09-01',
                            'updated_at'        => '2020-09-01',
                        ],
                        [
                            'user_id'           => 3,
                            'title'             => 'Certified Mathematics Teacher',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'Al Ain School',
                            'issue_date'        => '2012-03-01',
                            'expiry_date'       => '2018-03-01',
                            'description'       => 'Certification for teaching mathematics, including algebra, geometry, calculus, and statistics.',
                            'created_at'        => '2012-03-01',
                            'updated_at'        => '2018-03-01',
                        ],
                        [
                            'user_id'           => 3,
                            'title'             => 'Certified Data Analysis Specialist',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Analytics Academy',
                            'issue_date'        => '2022-01-01',
                            'expiry_date'       => '2025-01-01',
                            'description'       => 'Certification for advanced skills in data analysis, including statistical analysis, data visualization, and predictive modeling.',
                            'created_at'        => '2022-01-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education'  => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 3,
                            'city' => 'Berat',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I offer expertise in crafting secure software solutions, protecting systems from cyber threats, and ensuring robust technological defenses.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 4,
                            'city' => 'Annaba',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I excel in optimizing IT operations, managing complex systems, and extracting valuable insights from data to drive strategic decisions.',
                        ],
                        [
                            'course_title' => 'Diploma in Graphic Design',
                            'institute_name' => 'Creative College',
                            'country_id' => 5,
                            'city' => 'Madrid',
                            'start_date' => '2017-03-01',
                            'end_date' => '2018-11-01',
                            'ongoing' => 0,
                            'description' => 'Covered graphic design principles and multimedia tools, I utilize design fundamentals and various software to create visually compelling graphics and multimedia content for diverse applications.',
                        ],
                        [
                            'course_title' => 'Certification in Project Management',
                            'institute_name' => 'Management Institute',
                            'country_id' => 6,
                            'city' => 'Toronto',
                            'start_date' => '2022-05-01',
                            'end_date' => '2023-01-01',
                            'ongoing' => 0,
                            'description' => 'Focused on project planning, execution, and management skills, I oversee project lifecycles from initial planning through execution, ensuring timely delivery and effective management of resources and tasks.',
                        ],
                    ],

                    'address'    => [
                        'country_id'   => 7,
                        'state_id'     => 3,
                        'city'         => 'Jomala',
                        'address'      => '456 Broadway',
                        'zipcode'      => '10012',
                        'lat'          => 40.712776,
                        'long'         => -74.005974
                    ],
                    'subjects'    => [
                        '1' => [
                            [
                                'id' => 4,
                                'image' => 'software_design.png',
                                'hour_rate' => 50,
                                'description' => 'Software design involves defining the architecture, components, and interfaces of a software system to meet specific requirements. It focuses on creating a blueprint that ensures the software is efficient, scalable, and maintainable.',
                            ],
                            [
                                'id' => 5,
                                'image' => 'uxui.png',
                                'hour_rate' => 60,
                                'description' => 'UI/UX design focuses on creating intuitive and engaging user interfaces and experiences for applications and websites. UI (User Interface) design emphasizes the look and layout, while UX (User Experience) design ensures the overall usability and satisfaction of the user journey.',
                            ],
                            [
                                'id' => 6,
                                'image' => 'english.png',
                                'hour_rate' => 70,
                                'description' => 'English is a widely spoken and written language used for communication across various contexts, including literature, business, and education. It serves as a global lingua franca, facilitating interactions between people from diverse linguistic backgrounds.',
                            ]
                        ],
                        '2' => [
                            [
                                'id' => 11,
                                'image' => 'islamiyat.png',
                                'hour_rate' => 75,
                                'description' => 'Islamiyat is the study of Islamic religion, including its beliefs, practices, history, and cultural impact. It covers various aspects of Islamic teachings, including the Quran, Hadith, jurisprudence, and the life of the Prophet Muhammad(P.B.U.H).',
                            ],
                            [
                                'id' => 8,
                                'image' => 'urdu.png',
                                'hour_rate' => 90,
                                'description' => 'Urdu is a South Asian language spoken primarily in Pakistan and India, known for its rich literary heritage and use of the Perso-Arabic script. It serves as a key medium for communication, literature, and cultural expression in the region.',
                            ],
                            [
                                'id' => 9,
                                'image' => 'gk.png',
                                'hour_rate' => 100,
                                'description' => 'General knowledge encompasses a broad range of information about various subjects, including history, geography, culture, current events, and more. It involves understanding fundamental concepts and facts that provide a well-rounded awareness of the world.',
                            ]
                        ],
                        '3' => [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 13,
                                'image' => 'computer.png',
                                'hour_rate' => 70,
                                'description' => 'Computer science is the study of computers and computational systems, encompassing their theory, design, development, and application. It involves programming, algorithms, data structures, and the development of software and hardware to solve problems and create technological solutions.',
                            ],
                        ]

                    ],
                    'social_profiles' => [
                        [
                            'type' => 'Facebook',
                            'url' => 'https://www.facebook.com/',
                        ],
                        [
                            'type' => 'X/Twitter',
                            'url' => 'https://x.com/',
                        ],
                        [
                            'type' => 'LinkedIn',
                            'url' => 'https://www.linkedin.com/',
                        ],
                        [
                            'type' => 'Instagram',
                            'url' => 'https://www.instagram.com/',
                        ],
                        [
                            'type' => 'Pinterest',
                            'url' => 'https://www.pinterest.com/',
                        ],
                        [
                            'type' => 'YouTube',
                            'url' => 'https://www.youtube.com/',
                        ],
                        [
                            'type' => 'TikTok',
                            'url' => 'https://www.tiktok.com/',
                        ],
                    ],
                ],
                [ // 4 M
                    'email'         => 'antony@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Antony',
                    'last_name'     => 'Clara',
                    'gender'        => 'male',
                    'image'         => 'tutor-3.jpg',
                    'intro_video'   => 'tutor-video-3.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Unlocking Potential Through Customized Academic Guidance',
                    'description'   => '<p>Hello! My name is Antony Clara, and I’m a passionate tutor dedicated to helping students unlock their full academic potential. With a strong focus on creating personalized learning experiences, I aim to meet each student\'s unique needs and learning style. I have a diverse background in tutoring, covering subjects such as math, science, and English, and I strive to make every session engaging and effective. I believe that education is more than just mastering content—it’s about building confidence and developing critical thinking skills that will serve students well throughout their lives. My goal is to inspire a love for learning and to help students not only achieve their academic targets but also exceed them.</p>
                                        <p>Throughout my tutoring journey, I’ve had the opportunity to work with a wide range of students, from young learners to those preparing for college. Each student brings a different set of strengths and challenges, and I take pride in adapting my teaching methods to ensure that every student can thrive. My sessions are dynamic and interactive, often incorporating practical examples and real-world applications to make the material more relatable. I understand the pressures and difficulties that students face, and I am here to provide the support and encouragement they need to succeed. My teaching philosophy is rooted in patience, understanding, and a commitment to helping students grow both academically and personally.</p>
                                        <p>In addition to covering specific subjects, I also focus on teaching students essential skills like effective study habits, time management, and test preparation techniques. I believe that these skills are just as important as academic knowledge in helping students navigate their educational paths successfully. I am committed to providing a supportive and motivating environment where students can feel comfortable exploring new ideas and tackling challenges. Whether you need help with a particular subject or are looking for strategies to improve your overall academic performance, I am here to guide you every step of the way. Let’s work together to achieve your educational goals and build a strong foundation for your future success.</p>',
                    'verified_at'   =>  now(),
                    'languages'     => [8, 9],
                    'native_language' => 'Galician',
                    'experience'  => [
                        [
                            'title'             => 'Educational Program Coordinator',
                            'user_id'           => 4,
                            'employment_type'   => '2',
                            'company'           => 'Vienna International School',
                            'location'          => 'hybrid',
                            'country_id'        => 8,
                            'city'              => 'Vienna',
                            'start_date'        => '2010-02-01',
                            'end_date'          => '2016-06-30',
                            'description'       => 'Coordinated international educational programs, organized student exchanges, and managed partnerships with schools abroad.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Educational Program Coordinator',
                            'user_id'           => 4,
                            'employment_type'   => '2',
                            'company'           => 'Baku University',
                            'location'          => 'onsite',
                            'country_id'        => 9,
                            'city'              => 'Baku',
                            'start_date'        => '2017-09-01',
                            'end_date'          => '2019-06-30',
                            'description'       => 'Taught World and Azerbaijani history to high standards, prepared students for national exams, and organized history-related field trips.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Project Manager - Education Initiatives',
                            'user_id'           => 4,
                            'employment_type'   => '1',
                            'company'           => 'UNESCO',
                            'location'          => 'remote',
                            'country_id'        => 10,
                            'city'              => 'Paris',
                            'start_date'        => '2020-01-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Led projects focused on promoting education in underprivileged regions, developed strategies, and coordinated with international teams.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Director of Educational Programs',
                            'user_id'           => 4,
                            'employment_type'   => '3',
                            'company'           => 'Global Education Foundation',
                            'location'          => 'hybrid',
                            'country_id'        => 11,
                            'city'              => 'New York',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Oversee educational programs, manage a global team, and implement innovative strategies for improving access to quality education.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],

                    'certificate' => [
                        [
                            'user_id'           => 4,
                            'title'             => 'Certified Urdu Language Teacher',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Pakistani School',
                            'issue_date'        => '2011-09-01',
                            'expiry_date'       => '2019-09-01',
                            'description'       => 'Certification for teaching Urdu language and literature, including poetry, prose, and grammar.',
                            'created_at'        => '2011-09-01',
                            'updated_at'        => '2019-09-01',
                        ],
                        [
                            'user_id'           => 4,
                            'title'             => 'Certified General Knowledge Teacher',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Knowledge Academy',
                            'issue_date'        => '2016-01-01',
                            'expiry_date'       => '2021-01-01',
                            'description'       => 'Certification for teaching general knowledge subjects including history, geography, and current affairs.',
                            'created_at'        => '2016-01-01',
                            'updated_at'        => '2021-01-01',
                        ],
                        [
                            'user_id'           => 4,
                            'title'             => 'Certified Science Teacher',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'Modern School',
                            'issue_date'        => '2013-09-01',
                            'expiry_date'       => '2020-09-01',
                            'description'       => 'Certification for teaching general science, including biology, chemistry, and physics.',
                            'created_at'        => '2013-09-01',
                            'updated_at'        => '2020-09-01',
                        ],
                        [
                            'user_id'           => 4,
                            'title'             => 'Certified Environmental Science Educator',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Eco Education Center',
                            'issue_date'        => '2022-05-01',
                            'expiry_date'       => '2025-05-01',
                            'description'       => 'Certification for teaching environmental science, including climate change, ecology, and sustainability.',
                            'created_at'        => '2022-05-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 5,
                            'city' => 'Annaba',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I specialize in creating innovative software solutions and implementing strong security measures to protect against cyber threats and vulnerabilities.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 6,
                            'city' => 'Canillo',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I excel in enhancing IT infrastructure, managing sophisticated systems, and analyzing data to inform strategic decision-making.',
                        ],
                        [
                            'course_title' => 'Diploma in Digital Marketing',
                            'institute_name' => 'Marketing Academy',
                            'country_id' => 7,
                            'city' => 'Berlin',
                            'start_date' => '2018-01-01',
                            'end_date' => '2018-12-31',
                            'ongoing' => 0,
                            'description' => 'Covered SEO, SEM, and content marketing strategies, I enhance online visibility, drive targeted traffic, and develop effective content plans to improve engagement and achieve business goals.',
                        ],
                        [
                            'course_title' => 'Certification in Cybersecurity',
                            'institute_name' => 'Cyber Defense Center',
                            'country_id' => 8,
                            'city' => 'Tokyo',
                            'start_date' => '2023-03-01',
                            'end_date' => '2023-09-01',
                            'ongoing' => 0,
                            'description' => 'Focused on network security, threat analysis, and incident response, I protect systems from cyber threats, analyze security risks, and develop effective strategies for incident management and recovery.',
                        ],
                    ],

                    'address'       => [
                        'country_id'   => 3,
                        'state_id'     => 1,
                        'city'         => 'Berat',
                        'address'      => '789 Oxford St',
                        'zipcode'      => 'W1D 1BS',
                        'lat'          => 51.507351,
                        'long'         => -0.127758
                    ],
                    'subjects'      => [
                        '1' => [
                            [
                                'id' => 1,
                                'image' => 'web_development.png',
                                'hour_rate' => 20,
                                'description' => 'Web development involves the creation and maintenance of websites and web applications, encompassing both front-end and back-end technologies. It includes designing user interfaces, implementing functionality, and ensuring optimal performance and security.',
                            ],
                            [
                                'id' => 2,
                                'image' => 'web_designing.png',
                                'hour_rate' => 30,
                                'description' => 'Web designing focuses on creating visually appealing and user-friendly interfaces for websites. It involves designing layouts, graphics, and interactive elements to enhance user experience and engagement.',
                            ],
                            [
                                'id' => 3,
                                'image' => 'software_development.png',
                                'hour_rate' => 40,
                                'description' => 'Software development is the process of designing, coding, testing, and maintaining software applications. It involves translating user needs into functional and efficient software solutions through various programming languages and methodologies.',
                            ]
                        ],
                        '4' =>  [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 13,
                                'image' => 'computer.png',
                                'hour_rate' => 70,
                                'description' => 'Computer science is the study of computers and computational systems, encompassing their theory, design, development, and application. It involves programming, algorithms, data structures, and the development of software and hardware to solve problems and create technological solutions.',
                            ],
                        ]

                    ],
                    'social_profiles' => [
                        [
                            'type' => 'Facebook',
                            'url' => 'https://www.facebook.com/',
                        ],
                        [
                            'type' => 'X/Twitter',
                            'url' => 'https://x.com/',
                        ],
                        [
                            'type' => 'LinkedIn',
                            'url' => 'https://www.linkedin.com/',
                        ],
                        [
                            'type' => 'Instagram',
                            'url' => 'https://www.instagram.com/',
                        ],
                        [
                            'type' => 'Pinterest',
                            'url' => 'https://www.pinterest.com/',
                        ],
                        [
                            'type' => 'YouTube',
                            'url' => 'https://www.youtube.com/',
                        ],
                        [
                            'type' => 'TikTok',
                            'url' => 'https://www.tiktok.com/',
                        ],
                    ],
                ],
                [ // 5 F
                    'email'         => 'arianne@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Arianne',
                    'last_name'     => 'Kearns',
                    'gender'        => 'female',
                    'image'         => 'tutor-4.jpg',
                    'intro_video'   => 'tutor-video-4.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Building Confidence Through Personalized Learning Experiences',
                    'description'   => '<p>Hi there! I\'m Arianne Kearns, a dedicated tutor with a passion for guiding students toward academic success. My teaching philosophy revolves around the idea that learning should be both engaging and empowering. I aim to create an environment where students feel confident in their abilities and excited to tackle new challenges. With a background in various subjects, including mathematics, science, and English, I offer a well-rounded approach to tutoring that caters to the unique needs of each student. I focus not only on helping students understand the material but also on building the skills they need to think critically and solve problems independently.</p>
                                        <p>Over the years, I’ve had the pleasure of working with students from different age groups and educational backgrounds. I believe that every student learns differently, so I take the time to tailor my lessons to match their individual learning style. Whether it’s through interactive discussions, hands-on exercises, or practical examples, I strive to make each session as effective and enjoyable as possible. My goal is to help students not just improve their grades but also develop a genuine love for learning that will last a lifetime.</p>                    
                                        <p>In addition to subject-specific tutoring, I place a strong emphasis on teaching essential study skills, such as time management, organization, and test preparation strategies. I understand that academic success is about more than just understanding the material—it’s about having the right tools and mindset to approach challenges with confidence. I am committed to helping my students develop these skills, ensuring they are well-equipped to achieve their academic goals and succeed in their future endeavors. Whether you’re looking for support in a particular subject or need guidance in improving your overall academic performance, I am here to help you every step of the way. Together, we can build a strong foundation for your academic journey and beyond.</p>',
                    'verified_at'   =>  now(),
                    'languages'     => [6, 7],
                    'native_language' => 'French',
                    'experience' => [
                        [
                            'title'             => 'Curriculum Developer',
                            'user_id'           => 5,
                            'employment_type'   => '2',
                            'company'           => 'Bahamas Education Authority',
                            'location'          => 'remote',
                            'country_id'        => 10,
                            'city'              => 'Nassau',
                            'start_date'        => '2016-01-01',
                            'end_date'          => '2020-12-31',
                            'description'       => 'Developed and revised curriculum for primary and secondary schools, incorporating modern teaching methods and technology.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Science Teacher',
                            'user_id'           => 5,
                            'employment_type'   => '2',
                            'company'           => 'Dhaka International School',
                            'location'          => 'onsite',
                            'country_id'        => 11,
                            'city'              => 'Dhaka',
                            'start_date'        => '2017-09-01',
                            'end_date'          => '2021-06-30',
                            'description'       => 'Taught Biology, Chemistry, and Physics to students in grades 6-12, organized science fairs, and mentored students in science Olympiads.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Educational Consultant',
                            'user_id'           => 5,
                            'employment_type'   => '3',
                            'company'           => 'Global Education Consultancy',
                            'location'          => 'hybrid',
                            'country_id'        => 12,
                            'city'              => 'London',
                            'start_date'        => '2022-01-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Provided consultancy services for educational institutions, focusing on curriculum development and teacher training.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Director of Science Education',
                            'user_id'           => 5,
                            'employment_type'   => '1',
                            'company'           => 'Asia-Pacific Education Network',
                            'location'          => 'remote',
                            'country_id'        => 13,
                            'city'              => 'Singapore',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Leading initiatives to enhance science education across the Asia-Pacific region, developing new teaching materials, and training educators.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],

                    'certificate' => [
                        [
                            'user_id'           => 5,
                            'title'             => 'Certified Islamiyat Teacher',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Islamic School',
                            'issue_date'        => '2014-03-01',
                            'expiry_date'       => '2021-03-01',
                            'description'       => 'Certification for teaching Islamic studies, including Quran, Hadith, Fiqh, and Islamic history.',
                            'created_at'        => '2014-03-01',
                            'updated_at'        => '2021-03-01',
                        ],
                        [
                            'user_id'           => 5,
                            'title'             => 'Certified Physics Lecturer',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Government College',
                            'issue_date'        => '2010-09-01',
                            'expiry_date'       => '2018-09-01',
                            'description'       => 'Certification for teaching physics, including mechanics, electromagnetism, and thermodynamics.',
                            'created_at'        => '2010-09-01',
                            'updated_at'        => '2018-09-01',
                        ],
                        [
                            'user_id'           => 5,
                            'title'             => 'Certified Computer Science Instructor',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'National Institute of Computer Science',
                            'issue_date'        => '2011-01-01',
                            'expiry_date'       => '2017-01-01',
                            'description'       => 'Certification for teaching computer science subjects, including programming, data structures, and algorithms.',
                            'created_at'        => '2011-01-01',
                            'updated_at'        => '2017-01-01',
                        ],
                        [
                            'user_id'           => 5,
                            'title'             => 'Certified Mathematics Tutor',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Mathematics Institute',
                            'issue_date'        => '2022-08-01',
                            'expiry_date'       => '2025-08-01',
                            'description'       => 'Certification for tutoring mathematics, including calculus, algebra, and statistics.',
                            'created_at'        => '2022-08-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 7,
                            'city' => 'Cacuaco',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I design and build secure software solutions while implementing robust cybersecurity measures to safeguard against emerging threats and vulnerabilities.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 8,
                            'city' => 'West End',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I manage complex IT environments and leverage data to drive strategic insights and improve organizational efficiency.',
                        ],
                        [
                            'course_title' => 'Diploma in Data Analytics',
                            'institute_name' => 'Data Academy',
                            'country_id' => 9,
                            'city' => 'Montreal',
                            'start_date' => '2017-05-01',
                            'end_date' => '2018-11-01',
                            'ongoing' => 0,
                            'description' => 'Covered data visualization, statistical analysis, and predictive modeling, I transform complex data into clear visual insights, apply statistical methods, and develop models to forecast trends and inform decisions.',
                        ],
                        [
                            'course_title' => 'Certification in Cloud Computing',
                            'institute_name' => 'Cloud Tech Institute',
                            'country_id' => 10,
                            'city' => 'Sydney',
                            'start_date' => '2022-06-01',
                            'end_date' => '2023-02-01',
                            'ongoing' => 0,
                            'description' => 'Focused on cloud infrastructure, services, and deployment strategies, I design and implement scalable cloud solutions, optimize resource management, and ensure efficient deployment practices for enhanced performance.',
                        ],
                    ],

                    'address'       => [
                        'country_id'   => 4,
                        'state_id'     => 2,
                        'city'         => 'Annaba',
                        'address'      => '101 George St',
                        'zipcode'      => '2000',
                        'lat'          => -33.868820,
                        'long'         => 151.209296
                    ],
                    'subjects'      => [
                        '1' => [
                            [
                                'id' => 4,
                                'image' => 'software_design.png',
                                'hour_rate' => 50,
                                'description' => 'Software design involves defining the architecture, components, and interfaces of a software system to meet specific requirements. It focuses on creating a blueprint that ensures the software is efficient, scalable, and maintainable.',
                            ],
                            [
                                'id' => 5,
                                'image' => 'uxui.png',
                                'hour_rate' => 60,
                                'description' => 'UI/UX design focuses on creating intuitive and engaging user interfaces and experiences for applications and websites. UI (User Interface) design emphasizes the look and layout, while UX (User Experience) design ensures the overall usability and satisfaction of the user journey.',
                            ],
                            [
                                'id' => 6,
                                'image' => 'english.png',
                                'hour_rate' => 70,
                                'description' => 'English is a widely spoken and written language used for communication across various contexts, including literature, business, and education. It serves as a global lingua franca, facilitating interactions between people from diverse linguistic backgrounds.',
                            ]
                        ],
                        '2' => [
                            [
                                'id' => 11,
                                'image' => 'islamiyat.png',
                                'hour_rate' => 75,
                                'description' => 'Islamiyat is the study of Islamic religion, including its beliefs, practices, history, and cultural impact. It covers various aspects of Islamic teachings, including the Quran, Hadith, jurisprudence, and the life of the Prophet Muhammad(P.B.U.H).',
                            ],
                            [
                                'id' => 8,
                                'image' => 'urdu.png',
                                'hour_rate' => 90,
                                'description' => 'Urdu is a South Asian language spoken primarily in Pakistan and India, known for its rich literary heritage and use of the Perso-Arabic script. It serves as a key medium for communication, literature, and cultural expression in the region.',
                            ],
                            [
                                'id' => 9,
                                'image' => 'gk.png',
                                'hour_rate' => 100,
                                'description' => 'General knowledge encompasses a broad range of information about various subjects, including history, geography, culture, current events, and more. It involves understanding fundamental concepts and facts that provide a well-rounded awareness of the world.',
                            ]
                        ],
                        '3' => [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 13,
                                'image' => 'computer.png',
                                'hour_rate' => 70,
                                'description' => 'Computer science is the study of computers and computational systems, encompassing their theory, design, development, and application. It involves programming, algorithms, data structures, and the development of software and hardware to solve problems and create technological solutions.',
                            ],
                        ]

                    ],
                    'social_profiles' => [
                        [
                            'type' => 'Facebook',
                            'url' => 'https://www.facebook.com/',
                        ],
                        [
                            'type' => 'X/Twitter',
                            'url' => 'https://x.com/',
                        ],
                        [
                            'type' => 'LinkedIn',
                            'url' => 'https://www.linkedin.com/',
                        ],
                        [
                            'type' => 'Instagram',
                            'url' => 'https://www.instagram.com/',
                        ],
                        [
                            'type' => 'Pinterest',
                            'url' => 'https://www.pinterest.com/',
                        ],
                        [
                            'type' => 'YouTube',
                            'url' => 'https://www.youtube.com/',
                        ],
                        [
                            'type' => 'TikTok',
                            'url' => 'https://www.tiktok.com/',
                        ],
                    ],

                ],
                [ // 6 F
                    'email'         => 'ava@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Ava',
                    'last_name'     => 'Nguyen',
                    'gender'        => 'female',
                    'image'         => 'tutor-5.jpg',
                    'intro_video'   => 'tutor-video-8.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Tailored Learning for Lasting Academic Success',
                    'description'   => '<p>Hello! I\'m Ava Nguyen, a passionate and experienced tutor who is dedicated to helping students excel in their studies. My approach to teaching is centered around creating a supportive and engaging learning environment where students can thrive. I believe that every student has the potential to succeed, and my goal is to help them discover their strengths and build confidence in their abilities. With expertise in subjects like math, science, and English, I tailor my lessons to meet the unique needs of each student, ensuring that they gain a deep understanding of the material and develop critical thinking skills that will benefit them in all areas of life.</p>
                                        <p>Throughout my tutoring career, I have worked with students of all ages and academic levels, from elementary school to high school and beyond. I understand that each student has their own learning style and pace, so I take the time to get to know them and adjust my teaching methods accordingly. Whether it\'s through interactive lessons, personalized practice problems, or real-world applications of the concepts, I strive to make learning both enjoyable and effective. My sessions are designed to help students not only improve their grades but also to foster a love for learning that will stay with them throughout their educational journey.</p>
                                        <p>In addition to helping students with specific subjects, I also focus on teaching essential study skills, such as effective time management, note-taking strategies, and exam preparation techniques. I believe that these skills are crucial for academic success and are valuable tools that students can carry with them into their future endeavors. I am committed to providing the guidance and support that each student needs to overcome challenges and achieve their goals. Whether you\'re struggling with a particular subject or looking to enhance your overall academic performance, I am here to assist you every step of the way. Together, we can work towards reaching your full potential and achieving lasting success in your studies.</p>',
                    'verified_at'   =>  now(),
                    'languages'     => [11, 12],
                    'native_language' => 'English',
                    'experience' => [
                        [
                            'title'             => 'History Teacher',
                            'user_id'           => 6,
                            'employment_type'   => '1',
                            'company'           => 'Bridgetown Academy',
                            'location'          => 'remote',
                            'country_id'        => 12,
                            'city'              => 'Bridgetown',
                            'start_date'        => '2015-01-01',
                            'end_date'          => '2020-12-31',
                            'description'       => 'Taught history, organized field trips, and developed educational materials for a diverse student body.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Historian',
                            'user_id'           => 6,
                            'employment_type'   => '1',
                            'company'           => 'Minsk History School',
                            'location'          => 'remote',
                            'country_id'        => 13,
                            'city'              => 'Minsk',
                            'start_date'        => '2021-09-01',
                            'end_date'          => '2024-06-30',
                            'description'       => 'Instructed students in various history projects and organized exhibitions to showcase student work.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Cultural Affairs Coordinator',
                            'user_id'           => 6,
                            'employment_type'   => '2',
                            'company'           => 'International History Society',
                            'location'          => 'hybrid',
                            'country_id'        => 14,
                            'city'              => 'Rome',
                            'start_date'        => '2020-01-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Managed cultural exchange programs, organized historical conferences, and facilitated collaborative research projects.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Historical Research Analyst',
                            'user_id'           => 6,
                            'employment_type'   => '3',
                            'company'           => 'European History Research Institute',
                            'location'          => 'onsite',
                            'country_id'        => 15,
                            'city'              => 'Berlin',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Conducting historical research, analyzing historical data, and publishing findings in academic journals.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],

                    'certificate'   => [
                        [
                            'user_id'           => 6,
                            'title'             => 'Certified Web Development Specialist',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Global Tech Institute',
                            'issue_date'        => '2019-05-01',
                            'expiry_date'       => '2024-05-01',
                            'description'       => 'Certification for advanced web development skills, including server-side technologies and databases.',
                            'created_at'        => '2019-05-01',
                            'updated_at'        => '2024-05-01',
                        ],
                        [
                            'user_id'           => 6,
                            'title'             => 'Certified Advanced Web Designer',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Visual Arts Academy',
                            'issue_date'        => '2018-08-01',
                            'expiry_date'       => '2023-08-01',
                            'description'       => 'Certification for advanced web design, focusing on responsive design and user-centric interfaces.',
                            'created_at'        => '2018-08-01',
                            'updated_at'        => '2023-08-01',
                        ],
                        [
                            'user_id'           => 6,
                            'title'             => 'Certified Front-End Framework Expert',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'Frontend Experts Academy',
                            'issue_date'        => '2022-02-01',
                            'expiry_date'       => '2025-02-01',
                            'description'       => 'Certification for expertise in front-end frameworks, including React, Angular, and Vue.js.',
                            'created_at'        => '2022-02-01',
                            'updated_at'        => '2024-08-01',
                        ],
                        [
                            'user_id'           => 6,
                            'title'             => 'Certified Full-Stack Developer',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Tech Development Hub',
                            'issue_date'        => '2023-01-01',
                            'expiry_date'       => '2026-01-01',
                            'description'       => 'Certification for full-stack development, covering both front-end and back-end technologies, including Node.js and MongoDB.',
                            'created_at'        => '2023-01-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 9,
                            'city' => 'Davis Station',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I develop innovative software solutions and implement advanced security protocols to protect systems from threats and ensure robust performance.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 10,
                            'city' => 'Liberta',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I optimize IT operations and leverage data insights to enhance organizational efficiency and drive informed decision-making.',
                        ],
                        [
                            'course_title' => 'Diploma in Software Engineering',
                            'institute_name' => 'Tech Institute',
                            'country_id' => 11,
                            'city' => 'San Francisco',
                            'start_date' => '2018-01-01',
                            'end_date' => '2019-12-31',
                            'ongoing' => 0,
                            'description' => 'Focused on software design, development, and testing, I create intuitive software solutions, ensure robust functionality through rigorous testing, and refine designs to meet user needs and project goals.',
                        ],
                        [
                            'course_title' => 'Certification in Artificial Intelligence',
                            'institute_name' => 'AI Academy',
                            'country_id' => 12,
                            'city' => 'Singapore',
                            'start_date' => '2022-07-01',
                            'end_date' => '2023-04-01',
                            'ongoing' => 0,
                            'description' => 'Covered machine learning, deep learning, and neural networks, I apply advanced techniques to develop intelligent systems, train models with complex data, and create neural network architectures for sophisticated data analysis.',
                        ],
                    ],

                    'address'       =>  [
                        'country_id'   => 5,
                        'state_id'     => 6,
                        'city'         => 'Annaba',
                        'address'      => '202 Shibuya',
                        'zipcode'      => '150-0001',
                        'lat'          => 35.689487,
                        'long'         => 139.691711
                    ],
                    'subjects'      => [
                        '1' =>      [
                            [
                                'id' => 1,
                                'image' => 'web_development.png',
                                'hour_rate' => 20,
                                'description' => 'Web development involves the creation and maintenance of websites and web applications, encompassing both front-end and back-end technologies. It includes designing user interfaces, implementing functionality, and ensuring optimal performance and security.',
                            ],
                            [
                                'id' => 2,
                                'image' => 'web_designing.png',
                                'hour_rate' => 30,
                                'description' => 'Web designing focuses on creating visually appealing and user-friendly interfaces for websites. It involves designing layouts, graphics, and interactive elements to enhance user experience and engagement.',
                            ],
                            [
                                'id' => 3,
                                'image' => 'software_development.png',
                                'hour_rate' => 40,
                                'description' => 'Software development is the process of designing, coding, testing, and maintaining software applications. It involves translating user needs into functional and efficient software solutions through various programming languages and methodologies.',
                            ]
                        ],
                        '2' =>      [
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 8,
                                'image' => 'urdu.png',
                                'hour_rate' => 90,
                                'description' => 'Urdu is a South Asian language spoken primarily in Pakistan and India, known for its rich literary heritage and use of the Perso-Arabic script. It serves as a key medium for communication, literature, and cultural expression in the region.',
                            ],
                            [
                                'id' => 9,
                                'image' => 'gk.png',
                                'hour_rate' => 100,
                                'description' => 'General knowledge encompasses a broad range of information about various subjects, including history, geography, culture, current events, and more. It involves understanding fundamental concepts and facts that provide a well-rounded awareness of the world.',
                            ]
                        ]
                    ]
                ],
                [ // 7 F
                    'email'         => 'baker@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Georgia',
                    'last_name'     => 'Baker',
                    'gender'        => 'female',
                    'image'         => 'tutor-6.jpg',
                    'intro_video'   => 'tutor-video-9.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Customized Learning for Lasting Academic Success',
                    'description'   => '<p>Hello! My name is Georgia Baker, and I’m an enthusiastic tutor with a strong commitment to helping students reach their academic goals. I believe that learning should be a rewarding experience, where students feel empowered and motivated to explore new concepts. My approach to tutoring is to create a personalized learning experience that aligns with each student’s unique needs and abilities. Whether it’s math, science, or English, I’m dedicated to making challenging subjects more accessible and enjoyable. My focus is on helping students develop a solid understanding of the material while also encouraging them to think critically and creatively.</p>        
                                        <p>I’ve had the pleasure of working with a diverse range of students, from young learners to those preparing for college, each with their own set of strengths and challenges. I take pride in adapting my teaching style to suit the learning preferences of each student, ensuring that they are fully engaged and making progress at their own pace. My sessions are interactive and dynamic, often incorporating practical examples and real-life applications to make the material more relatable. I aim to create an environment where students feel comfortable tackling difficult topics and confident in their ability to succeed.</p>
                                        <p>In addition to helping students master specific subjects, I also place a strong emphasis on developing key study skills, such as organization, time management, and effective exam strategies. I understand that these skills are crucial for long-term academic success and aim to equip my students with the tools they need to thrive in any academic setting. My ultimate goal is to help students build confidence in their abilities and foster a lifelong love for learning. Whether you’re aiming to improve in a particular subject or looking to enhance your overall academic performance, I’m here to provide the support and guidance you need. Together, we can achieve your educational goals and set the stage for future success.</p>',
                    'verified_at'   =>  now(),
                    'languages'     => [13, 15],
                    'native_language' => 'Dutch',
                    'experience' => [
                        [
                            'title'             => 'Educational Psychologist',
                            'user_id'           => 7,
                            'employment_type'   => '2',
                            'company'           => 'Belgium Ministry of Education',
                            'location'          => 'onsite',
                            'country_id'        => 14,
                            'city'              => 'Brussels',
                            'start_date'        => '2014-04-01',
                            'end_date'          => '2018-03-31',
                            'description'       => 'Provided psychological assessments and support for students, developed intervention programs, and collaborated with teachers on special education needs.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Web Development Instructor',
                            'user_id'           => 7,
                            'employment_type'   => '2',
                            'company'           => 'Gaborone Technical College',
                            'location'          => 'onsite',
                            'country_id'        => 15,
                            'city'              => 'Gaborone',
                            'start_date'        => '2019-02-01',
                            'end_date'          => '2021-12-31',
                            'description'       => 'Taught full-stack web development including HTML, CSS, JavaScript, and frameworks like React and Node.js. Supervised student projects and conducted code reviews.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Technology Integration Specialist',
                            'user_id'           => 7,
                            'employment_type'   => '3',
                            'company'           => 'European Educational Technology Center',
                            'location'          => 'hybrid',
                            'country_id'        => 16,
                            'city'              => 'Amsterdam',
                            'start_date'        => '2022-01-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Facilitated the integration of educational technology into classroom environments, provided training for educators, and developed technology adoption strategies.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Lead Instructor - Advanced Web Development',
                            'user_id'           => 7,
                            'employment_type'   => '1',
                            'company'           => 'Tech Academy',
                            'location'          => 'remote',
                            'country_id'        => 17,
                            'city'              => 'San Francisco',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Lead advanced web development courses focusing on modern frameworks and best practices. Conducted virtual workshops and mentored students through complex projects.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],

                    'certificate'   => [
                        [
                            'user_id'           => 7,
                            'title'             => 'Certified Software Engineer',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Engineering University',
                            'issue_date'        => '2017-07-01',
                            'expiry_date'       => '2022-07-01',
                            'description'       => 'Certification for software engineering principles, including system design and development methodologies.',
                            'created_at'        => '2017-07-01',
                            'updated_at'        => '2022-07-01',
                        ],
                        [
                            'user_id'           => 7,
                            'title'             => 'Certified UI/UX Specialist',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'UX Design Institute',
                            'issue_date'        => '2019-11-01',
                            'expiry_date'       => '2024-11-01',
                            'description'       => 'Certification for UI/UX specialization, covering user research, wireframes, and interactive prototypes.',
                            'created_at'        => '2019-11-01',
                            'updated_at'        => '2024-11-01',
                        ],
                        [
                            'user_id'           => 7,
                            'title'             => 'Certified Cloud Solutions Architect',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'Cloud Academy',
                            'issue_date'        => '2021-04-01',
                            'expiry_date'       => '2024-04-01',
                            'description'       => 'Certification for designing and implementing cloud solutions, including AWS, Azure, and Google Cloud Platform.',
                            'created_at'        => '2021-04-01',
                            'updated_at'        => '2024-08-01',
                        ],
                        [
                            'user_id'           => 7,
                            'title'             => 'Certified DevOps Engineer',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'DevOps Institute',
                            'issue_date'        => '2022-06-01',
                            'expiry_date'       => '2025-06-01',
                            'description'       => 'Certification for DevOps practices, including continuous integration, continuous deployment, and infrastructure automation.',
                            'created_at'        => '2022-06-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 11,
                            'city' => 'La Plata',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I create cutting-edge software solutions and implement effective security measures to safeguard systems against threats and vulnerabilities.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 12,
                            'city' => 'Kapan',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I enhance IT infrastructure and utilize data insights to optimize performance and support strategic business decisions',
                        ],
                        [
                            'course_title' => 'Diploma in Network Security',
                            'institute_name' => 'Network Academy',
                            'country_id' => 13,
                            'city' => 'Gothenburg',
                            'start_date' => '2018-03-01',
                            'end_date' => '2019-11-01',
                            'ongoing' => 0,
                            'description' => 'Covered network protection, firewalls, and intrusion detection systems, I implement robust security measures to safeguard networks, configure firewalls, and deploy detection systems to identify and respond to potential threats.',
                        ],
                        [
                            'course_title' => 'Certification in Machine Learning',
                            'institute_name' => 'ML Institute',
                            'country_id' => 14,
                            'city' => 'Austin',
                            'start_date' => '2022-08-01',
                            'end_date' => '2023-03-01',
                            'ongoing' => 0,
                            'description' => 'Focused on machine learning algorithms, data modeling, and predictive analytics, I develop and apply advanced algorithms, create data models, and use predictive techniques to generate actionable insights and forecasts.',
                        ],
                    ],

                    'address'       =>  [
                        'country_id'   => 6,
                        'state_id'     => 3,
                        'city'         => 'Canillo',
                        'address'      => '303 Champs-Élysées',
                        'zipcode'      => '75008',
                        'lat'          => 48.856614,
                        'long'         => 2.352222
                    ],
                    'subjects'      => [
                        '1' => [
                            [
                                'id' => 1,
                                'image' => 'web_development.png',
                                'hour_rate' => 20,
                                'description' => 'Web development involves the creation and maintenance of websites and web applications, encompassing both front-end and back-end technologies. It includes designing user interfaces, implementing functionality, and ensuring optimal performance and security.',
                            ],
                            [
                                'id' => 2,
                                'image' => 'web_designing.png',
                                'hour_rate' => 30,
                                'description' => 'Web designing focuses on creating visually appealing and user-friendly interfaces for websites. It involves designing layouts, graphics, and interactive elements to enhance user experience and engagement.',
                            ],
                            [
                                'id' => 3,
                                'image' => 'software_development.png',
                                'hour_rate' => 40,
                                'description' => 'Software development is the process of designing, coding, testing, and maintaining software applications. It involves translating user needs into functional and efficient software solutions through various programming languages and methodologies.',
                            ]
                        ],
                        '4' =>  [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 13,
                                'image' => 'computer.png',
                                'hour_rate' => 70,
                                'description' => 'Computer science is the study of computers and computational systems, encompassing their theory, design, development, and application. It involves programming, algorithms, data structures, and the development of software and hardware to solve problems and create technological solutions.',
                            ],
                        ],
                        '5' =>  [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 14,
                                'image' => 'chemistry.png',
                                'hour_rate' => 70,
                                'description' => 'Chemistry is the science of matter and its interactions, focusing on the composition, properties, and reactions of substances. It explores how atoms and molecules combine and transform to form different materials and energy, providing insights into both everyday phenomena and industrial processes.',
                            ],
                        ]

                    ]
                ],
                [ // 8 M
                    'email'         => 'beau@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Beau',
                    'last_name'     => 'Simard',
                    'gender'        => 'male',
                    'image'         => 'tutor-7.jpg',
                    'intro_video'   => 'tutor-video-3.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Personalized Guidance for Academic Success and Growth',
                    'description'   => '<P>Greetings! I’m Beau Simard, a dedicated tutor focused on empowering students to achieve their academic potential. My approach is grounded in the belief that every student has unique strengths and learning styles, and my goal is to tailor my teaching methods to meet these individual needs. I specialize in a variety of subjects, including mathematics, science, and English, and am committed to making each lesson engaging and productive. By fostering an environment of curiosity and critical thinking, I help students not only grasp difficult concepts but also develop a deeper understanding of the material.</P>
                                        <P>With extensive experience working with students of all ages, I understand the diverse challenges that learners face and strive to address them with patience and creativity. I emphasize interactive and hands-on learning, incorporating practical examples and real-world scenarios to make the material more relevant and interesting. My aim is to build a solid foundation in each subject while also encouraging students to develop strong problem-solving and analytical skills. I take pride in seeing my students gain confidence and excel academically as a result of our work together.</P>
                                        <P>Beyond subject matter expertise, I also focus on helping students enhance their overall academic skills, such as effective study techniques, time management, and test preparation. I believe that mastering these skills is essential for long-term success and academic growth. My commitment is to provide personalized support that aligns with each student\'s goals and learning preferences. Whether you’re seeking to improve your performance in a specific area or aiming to boost your overall academic abilities, I’m here to guide you on your journey. Let’s work together to unlock your full potential and achieve your educational aspirations.</P>',
                    'verified_at'   =>  now(),
                    'languages'     => [2, 10],
                    'native_language' => 'Faroese',
                    'experience' => [
                        [
                            'title'             => 'Web Development Instructor',
                            'user_id'           => 8,
                            'employment_type'   => '1',
                            'company'           => 'Tech Academy',
                            'location'          => 'onsite',
                            'country_id'        => 1,
                            'city'              => 'Doha',
                            'start_date'        => '2015-09-01',
                            'end_date'          => '2020-06-30',
                            'description'       => 'Taught full-stack web development including HTML, CSS, JavaScript, and frameworks like React and Node.js. Supervised student projects and conducted code reviews.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Web Design Instructor',
                            'user_id'           => 8,
                            'employment_type'   => '1',
                            'company'           => 'Creative Design School',
                            'location'          => 'remote',
                            'country_id'        => 2,
                            'city'              => 'Riyadh',
                            'start_date'        => '2021-01-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Instructed students in web design principles, UI/UX, responsive design, and tools such as Adobe XD and Figma. Guided students through practical design projects.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Front-End Development Specialist',
                            'user_id'           => 8,
                            'employment_type'   => '2',
                            'company'           => 'Innovative Web Solutions',
                            'location'          => 'hybrid',
                            'country_id'        => 3,
                            'city'              => 'Dubai',
                            'start_date'        => '2020-07-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Focused on front-end development projects, optimized user interfaces, and collaborated with design teams to create engaging web experiences.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Senior UX/UI Designer',
                            'user_id'           => 8,
                            'employment_type'   => '3',
                            'company'           => 'Global Design Agency',
                            'location'          => 'remote',
                            'country_id'        => 4,
                            'city'              => 'London',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Leading UX/UI design projects, conducting user research, and creating wireframes and prototypes for global clients.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],

                    'certificate'   => [
                        [
                            'user_id'           => 8,
                            'title'             => 'Certified English Language Educator',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Language Learning Center',
                            'issue_date'        => '2016-06-01',
                            'expiry_date'       => '2021-06-01',
                            'description'       => 'Certification for advanced English language teaching, including ESL and academic writing.',
                            'created_at'        => '2016-06-01',
                            'updated_at'        => '2021-06-01',
                        ],
                        [
                            'user_id'           => 8,
                            'title'             => 'Certified Advanced Mathematics Instructor',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Math Institute',
                            'issue_date'        => '2013-05-01',
                            'expiry_date'       => '2018-05-01',
                            'description'       => 'Certification for teaching advanced mathematics topics, including linear algebra and differential equations.',
                            'created_at'        => '2013-05-01',
                            'updated_at'        => '2018-05-01',
                        ],
                        [
                            'user_id'           => 8,
                            'title'             => 'Certified Urdu Literature Teacher',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'Urdu Academy',
                            'issue_date'        => '2015-01-01',
                            'expiry_date'       => '2020-01-01',
                            'description'       => 'Certification for teaching Urdu literature, including classical and modern works.',
                            'created_at'        => '2015-01-01',
                            'updated_at'        => '2020-01-01',
                        ],
                        [
                            'user_id'           => 8,
                            'title'             => 'Certified Data Science Instructor',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Data Science Academy',
                            'issue_date'        => '2022-03-01',
                            'expiry_date'       => '2025-03-01',
                            'description'       => 'Certification for teaching data science, including machine learning, statistical analysis, and data visualization.',
                            'created_at'        => '2022-03-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 13,
                            'city' => 'Malmok',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I deliver secure, high-quality software solutions and protect systems against cyber threats with robust security practices.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 14,
                            'city' => 'Sydney',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I streamline IT operations and harness data insights to drive strategic improvements and enhance organizational effectiveness.',
                        ],
                        [
                            'course_title' => 'Diploma in Cybersecurity',
                            'institute_name' => 'Security Academy',
                            'country_id' => 15,
                            'city' => 'Zurich',
                            'start_date' => '2018-06-01',
                            'end_date' => '2019-12-01',
                            'ongoing' => 0,
                            'description' => 'Focused on network security, cryptography, and ethical hacking, I safeguard systems through advanced security measures, implement encryption techniques, and conduct ethical hacking to identify and address vulnerabilities.',
                        ],
                        [
                            'course_title' => 'Certification in Cloud Technologies',
                            'institute_name' => 'Cloud Academy',
                            'country_id' => 16,
                            'city' => 'San Francisco',
                            'start_date' => '2022-04-01',
                            'end_date' => '2023-01-01',
                            'ongoing' => 0,
                            'description' => 'Covered cloud architecture, services, and deployment strategies, I design scalable cloud solutions, manage cloud services, and implement effective deployment practices to optimize performance and resource utilization.',
                        ],
                    ],

                    'address'       =>  [
                        'country_id'   => 7,
                        'state_id'     => 1,
                        'city'         => 'Cacuaco',
                        'address'      => '404 Alexanderplatz',
                        'zipcode'      => '10178',
                        'lat'          => 52.520008,
                        'long'         => 13.404954
                    ],
                    'subjects'      => [
                        '1' => [
                            [
                                'id' => 1,
                                'image' => 'web_development.png',
                                'hour_rate' => 20,
                                'description' => 'Web development involves the creation and maintenance of websites and web applications, encompassing both front-end and back-end technologies. It includes designing user interfaces, implementing functionality, and ensuring optimal performance and security.',
                            ],
                            [
                                'id' => 2,
                                'image' => 'web_designing.png',
                                'hour_rate' => 30,
                                'description' => 'Web designing focuses on creating visually appealing and user-friendly interfaces for websites. It involves designing layouts, graphics, and interactive elements to enhance user experience and engagement.',
                            ],
                            [
                                'id' => 3,
                                'image' => 'software_development.png',
                                'hour_rate' => 40,
                                'description' => 'Software development is the process of designing, coding, testing, and maintaining software applications. It involves translating user needs into functional and efficient software solutions through various programming languages and methodologies.',
                            ]
                        ],
                        '4' =>  [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 13,
                                'image' => 'computer.png',
                                'hour_rate' => 70,
                                'description' => 'Computer science is the study of computers and computational systems, encompassing their theory, design, development, and application. It involves programming, algorithms, data structures, and the development of software and hardware to solve problems and create technological solutions.',
                            ],
                        ]
                    ]
                ],
                [ // 9 F
                    'email'         => 'beverlee@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Beverlee',
                    'last_name'     => 'Bark',
                    'gender'        => 'female',
                    'image'         => 'tutor-8.jpg',
                    'intro_video'   => 'tutor-video-4.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Customized Learning for Lifelong Academic Success',
                    'description'   => '<p>Hello! I’m Beverlee Bark, and I’m thrilled to offer my tutoring services to students seeking to enhance their academic skills and knowledge. My tutoring philosophy is centered on creating a positive and encouraging environment where students feel inspired to learn and grow. With a strong background in subjects such as math, science, and language arts, I am adept at making complex topics more approachable and engaging. My goal is to help students build a solid understanding of their coursework while also fostering a sense of confidence and curiosity about learning.</P>
                                        <p>Throughout my career, I have worked with a diverse range of students, from those just starting their academic journey to those preparing for higher education. I take a personalized approach to tutoring, taking the time to understand each student’s unique learning style and challenges. My sessions are designed to be interactive and motivating, incorporating various teaching methods and resources to suit individual needs. By focusing on both academic content and essential study skills, I aim to equip students with the tools they need to excel in their studies and beyond.</P>
                                        <p>In addition to helping students with their immediate academic needs, I am also dedicated to supporting their overall educational development. This includes teaching effective study habits, time management, and test-taking strategies that are crucial for long-term success. I believe that every student has the potential to achieve greatness, and I am here to provide the guidance and support necessary to help them reach their goals. Whether you’re looking to improve in a particular subject or enhance your general academic performance, I am committed to working with you to achieve success. Let’s embark on this educational journey together and unlock your full potential.</P>',
                    'verified_at'   =>  now(),
                    'languages'     => [11, 22],
                    'native_language' => 'Danish',
                    'experience' => [
                        [
                            'title'             => 'Software Development Lecturer',
                            'user_id'           => 9,
                            'employment_type'   => '2',
                            'company'           => 'Kuwait IT Institute',
                            'location'          => 'hybrid',
                            'country_id'        => 3,
                            'city'              => 'Kuwait City',
                            'start_date'        => '2017-03-01',
                            'end_date'          => '2020-12-31',
                            'description'       => 'Delivered lectures on software engineering principles, object-oriented programming, and software development life cycles. Assisted students with coding assignments in Java and C#.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'UI/UX Design Instructor',
                            'user_id'           => 9,
                            'employment_type'   => '2',
                            'company'           => 'Design Hub',
                            'location'          => 'remote',
                            'country_id'        => 4,
                            'city'              => 'Muscat',
                            'start_date'        => '2021-02-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Taught UI/UX design principles, wireframing, prototyping, and user research. Led workshops and critiqued student portfolios to prepare them for industry roles.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Senior Software Engineer',
                            'user_id'           => 9,
                            'employment_type'   => '1',
                            'company'           => 'Tech Innovations Ltd.',
                            'location'          => 'onsite',
                            'country_id'        => 5,
                            'city'              => 'Dubai',
                            'start_date'        => '2021-01-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Led software development projects, managed a team of developers, and designed scalable software solutions for various clients.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Lead UI/UX Designer',
                            'user_id'           => 9,
                            'employment_type'   => '3',
                            'company'           => 'Global Design Solutions',
                            'location'          => 'remote',
                            'country_id'        => 6,
                            'city'              => 'London',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Oversaw UI/UX design projects, collaborated with product managers and developers, and ensured high-quality user experiences across digital platforms.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],

                    'certificate'   => [
                        [
                            'user_id'           => 9,
                            'title'             => 'Certified General Knowledge Expert',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Knowledge Hub',
                            'issue_date'        => '2017-10-01',
                            'expiry_date'       => '2022-10-01',
                            'description'       => 'Certification for teaching general knowledge, including history, geography, and cultural studies.',
                            'created_at'        => '2017-10-01',
                            'updated_at'        => '2022-10-01',
                        ],
                        [
                            'user_id'           => 9,
                            'title'             => 'Certified Science Educator',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Science Education Center',
                            'issue_date'        => '2012-04-01',
                            'expiry_date'       => '2018-04-01',
                            'description'       => 'Certification for teaching general science, focusing on practical experiments and theoretical concepts.',
                            'created_at'        => '2012-04-01',
                            'updated_at'        => '2018-04-01',
                        ],
                        [
                            'user_id'           => 9,
                            'title'             => 'Certified Islamiyat Studies Instructor',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'Islamic Studies Institute',
                            'issue_date'        => '2018-02-01',
                            'expiry_date'       => '2023-02-01',
                            'description'       => 'Certification for advanced teaching of Islamiyat, including deep theological and historical aspects.',
                            'created_at'        => '2018-02-01',
                            'updated_at'        => '2023-02-01',
                        ],
                        [
                            'user_id'           => 9,
                            'title'             => 'Certified Advanced History Educator',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Historical Studies Academy',
                            'issue_date'        => '2020-11-01',
                            'expiry_date'       => '2025-11-01',
                            'description'       => 'Certification for advanced teaching of history, including ancient, medieval, and modern historical contexts.',
                            'created_at'        => '2020-11-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 15,
                            'city' => 'Graz',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I build innovative software and implement security strategies to protect systems from threats and ensure reliable performance.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 16,
                            'city' => 'Baku',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I excel in optimizing IT systems and leveraging data to drive strategic decisions and enhance organizational performance.',
                        ],
                        [
                            'course_title' => 'Diploma in Data Science',
                            'institute_name' => 'Data Science Academy',
                            'country_id' => 17,
                            'city' => 'Copenhagen',
                            'start_date' => '2018-04-01',
                            'end_date' => '2019-11-01',
                            'ongoing' => 0,
                            'description' => 'Covered statistical analysis, data visualization, and machine learning, I analyze data trends, create informative visual representations, and apply machine learning techniques to develop predictive models and insights.',
                        ],
                        [
                            'course_title' => 'Certification in Software Engineering',
                            'institute_name' => 'Engineering Institute',
                            'country_id' => 18,
                            'city' => 'Barcelona',
                            'start_date' => '2022-09-01',
                            'end_date' => '2023-05-01',
                            'ongoing' => 0,
                            'description' => 'Focused on the software development life cycle, testing, and project management, I oversee the end-to-end process of software creation, ensure rigorous quality assurance, and manage projects for successful delivery.',
                        ],
                    ],

                    'address'       =>  [
                        'country_id'   => 8,
                        'state_id'     => 2,
                        'city'         => 'West End',
                        'address'      => '505 Red Square',
                        'zipcode'      => '109012',
                        'lat'          => 55.755825,
                        'long'         => 37.617298
                    ],
                    'subjects'      => [
                        '1' => [
                            [
                                'id' => 4,
                                'image' => 'software_design.png',
                                'hour_rate' => 50,
                                'description' => 'Software design involves defining the architecture, components, and interfaces of a software system to meet specific requirements. It focuses on creating a blueprint that ensures the software is efficient, scalable, and maintainable.',
                            ],
                            [
                                'id' => 5,
                                'image' => 'uxui.png',
                                'hour_rate' => 60,
                                'description' => 'UI/UX design focuses on creating intuitive and engaging user interfaces and experiences for applications and websites. UI (User Interface) design emphasizes the look and layout, while UX (User Experience) design ensures the overall usability and satisfaction of the user journey.',
                            ],
                            [
                                'id' => 6,
                                'image' => 'english.png',
                                'hour_rate' => 70,
                                'description' => 'English is a widely spoken and written language used for communication across various contexts, including literature, business, and education. It serves as a global lingua franca, facilitating interactions between people from diverse linguistic backgrounds.',
                            ]
                        ],
                        '2' => [
                            [
                                'id' => 11,
                                'image' => 'islamiyat.png',
                                'hour_rate' => 75,
                                'description' => 'Islamiyat is the study of Islamic religion, including its beliefs, practices, history, and cultural impact. It covers various aspects of Islamic teachings, including the Quran, Hadith, jurisprudence, and the life of the Prophet Muhammad(P.B.U.H).',
                            ],
                            [
                                'id' => 8,
                                'image' => 'urdu.png',
                                'hour_rate' => 90,
                                'description' => 'Urdu is a South Asian language spoken primarily in Pakistan and India, known for its rich literary heritage and use of the Perso-Arabic script. It serves as a key medium for communication, literature, and cultural expression in the region.',
                            ],
                            [
                                'id' => 9,
                                'image' => 'gk.png',
                                'hour_rate' => 100,
                                'description' => 'General knowledge encompasses a broad range of information about various subjects, including history, geography, culture, current events, and more. It involves understanding fundamental concepts and facts that provide a well-rounded awareness of the world.',
                            ]
                        ],
                        '3' => [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 13,
                                'image' => 'computer.png',
                                'hour_rate' => 70,
                                'description' => 'Computer science is the study of computers and computational systems, encompassing their theory, design, development, and application. It involves programming, algorithms, data structures, and the development of software and hardware to solve problems and create technological solutions.',
                            ],
                        ]

                    ]
                ],
                [ // 10 F
                    'email'         => 'chan@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Brooklyn',
                    'last_name'     => 'Chan',
                    'gender'        => 'female',
                    'image'         => 'tutor-9.jpg',
                    'intro_video'   => 'tutor-video-9.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'AEmpowering Learning with Customized Academic Guidance',
                    'description'   => '<p>Hi! I’m Brooklyn Chan, and I’m excited to support you in your academic journey. As a dedicated tutor, I believe that learning should be an empowering and enjoyable experience. I specialize in a wide array of subjects, including mathematics, science, and literature, and I focus on making each lesson engaging and tailored to your unique needs. My teaching approach is centered around understanding your personal learning style and challenges, which allows me to provide customized support that truly resonates with you.</p>
                                        <p>I have experience working with students from various educational backgrounds and age groups, which has equipped me with the skills to address diverse learning needs effectively. My tutoring sessions are designed to be interactive and dynamic, using a mix of instructional techniques and practical applications to ensure that the material is both accessible and relevant. My aim is to help you not only grasp the concepts but also develop a genuine interest and confidence in your studies.</p>
                                        <p>Beyond subject-specific tutoring, I place a strong emphasis on developing essential academic skills such as critical thinking, problem-solving, and efficient study habits. I understand that academic success extends beyond understanding the content, and I am here to help you build a robust set of skills that will benefit you throughout your educational career. Whether you need help with a particular subject or want to improve your overall academic performance, I am committed to providing the support and encouragement you need to achieve your goals. Let’s work together to make learning a fulfilling and successful experience for you.</p>',
                    'verified_at'   =>  now(),
                    'languages'     => [14, 16],
                    'native_language' => 'Bengali',
                    'experience' => [
                        [
                            'title'             => 'English Teacher',
                            'user_id'           => 10,
                            'employment_type'   => '1',
                            'company'           => 'International School',
                            'location'          => 'hybrid',
                            'country_id'        => 5,
                            'city'              => 'Dubai',
                            'start_date'        => '2014-09-01',
                            'end_date'          => '2017-06-30',
                            'description'       => 'Taught English language and literature to high school students. Developed lesson plans, conducted reading and writing workshops, and prepared students for national exams.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Mathematics Teacher',
                            'user_id'           => 10,
                            'employment_type'   => '1',
                            'company'           => 'Al Ain School',
                            'location'          => 'hybrid',
                            'country_id'        => 5,
                            'city'              => 'Al Ain',
                            'start_date'        => '2017-03-01',
                            'end_date'          => '2024-12-31',
                            'description'       => 'Instructed students in algebra, geometry, calculus, and statistics. Developed problem-solving workshops and supported students with exam preparation.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Science Teacher',
                            'user_id'           => 10,
                            'employment_type'   => '1',
                            'company'           => 'Modern Academy',
                            'location'          => 'onsite',
                            'country_id'        => 5,
                            'city'              => 'Dubai',
                            'start_date'        => '2012-01-01',
                            'end_date'          => '2014-08-31',
                            'description'       => 'Taught physical and biological sciences to high school students. Organized science fairs and conducted practical experiments to enhance learning.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Literature Professor',
                            'user_id'           => 10,
                            'employment_type'   => '2',
                            'company'           => 'Dubai University',
                            'location'          => 'remote',
                            'country_id'        => 5,
                            'city'              => 'Dubai',
                            'start_date'        => '2025-01-01',
                            'end_date'          => null,
                            'description'       => 'Lectured on English literature, conducted seminars, and published research papers on contemporary literary criticism.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],
                    'certificate' => [
                        [
                            'user_id'           => 10,
                            'title'             => 'Certified Physics Educator',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Physics Learning Center',
                            'issue_date'        => '2014-08-01',
                            'expiry_date'       => '2020-08-01',
                            'description'       => 'Certification for teaching physics with a focus on experimental and theoretical approaches.',
                            'created_at'        => '2014-08-01',
                            'updated_at'        => '2020-08-01',
                        ],
                        [
                            'user_id'           => 10,
                            'title'             => 'Certified Computer Science Teacher',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Techno Academy',
                            'issue_date'        => '2015-07-01',
                            'expiry_date'       => '2021-07-01',
                            'description'       => 'Certification for teaching computer science, including programming languages and software development methodologies.',
                            'created_at'        => '2015-07-01',
                            'updated_at'        => '2021-07-01',
                        ],
                        [
                            'user_id'           => 10,
                            'title'             => 'Certified Data Structures Instructor',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'Data Science Institute',
                            'issue_date'        => '2018-04-01',
                            'expiry_date'       => '2023-04-01',
                            'description'       => 'Certification for teaching data structures, including arrays, linked lists, and trees.',
                            'created_at'        => '2018-04-01',
                            'updated_at'        => '2023-04-01',
                        ],
                        [
                            'user_id'           => 10,
                            'title'             => 'Certified Web Development Instructor',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Web Dev Academy',
                            'issue_date'        => '2019-06-01',
                            'expiry_date'       => '2024-06-01',
                            'description'       => 'Certification for advanced web development, including modern frameworks and web technologies.',
                            'created_at'        => '2019-06-01',
                            'updated_at'        => '2024-06-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 17,
                            'city' => 'Nassau',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I design and develop secure software solutions while implementing cutting-edge security measures to protect against evolving cyber threats.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 18,
                            'city' => 'Sitra',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I enhance IT operations and utilize data-driven insights to improve efficiency and support strategic organizational goals.',
                        ],
                        [
                            'course_title' => 'Diploma in Web Development',
                            'institute_name' => 'Tech Academy',
                            'country_id' => 19,
                            'city' => 'Toronto',
                            'start_date' => '2018-03-01',
                            'end_date' => '2019-03-01',
                            'ongoing' => 0,
                            'description' => 'Training in modern web technologies and frameworks, I develop expertise in the latest tools and methodologies to create dynamic, responsive web applications and enhance user experiences.',
                        ],
                        [
                            'course_title' => 'Certificate in Cybersecurity',
                            'institute_name' => 'Cyber Security Institute',
                            'country_id' => 20,
                            'city' => 'San Francisco',
                            'start_date' => '2022-01-01',
                            'end_date' => '2022-06-01',
                            'ongoing' => 0,
                            'description' => 'Certification in ethical hacking and network security, I possess expertise in identifying vulnerabilities, securing systems, and implementing best practices to protect networks from cyber threats.',
                        ],
                    ],

                    'address'       => [
                        'country_id'   => 9,
                        'state_id'     => 2,
                        'city'         => 'Davis Station',
                        'address'      => '606 Sheikh Zayed Rd',
                        'zipcode'      => '00000',
                        'lat'          => 25.204849,
                        'long'         => 55.270782
                    ],
                    'subjects'      => [
                        '1' => [
                            [
                                'id' => 1,
                                'image' => 'web_development.png',
                                'hour_rate' => 20,
                                'description' => 'Web development involves the creation and maintenance of websites and web applications, encompassing both front-end and back-end technologies. It includes designing user interfaces, implementing functionality, and ensuring optimal performance and security.',
                            ],
                            [
                                'id' => 2,
                                'image' => 'web_designing.png',
                                'hour_rate' => 30,
                                'description' => 'Web designing focuses on creating visually appealing and user-friendly interfaces for websites. It involves designing layouts, graphics, and interactive elements to enhance user experience and engagement.',
                            ],
                            [
                                'id' => 3,
                                'image' => 'software_development.png',
                                'hour_rate' => 40,
                                'description' => 'Software development is the process of designing, coding, testing, and maintaining software applications. It involves translating user needs into functional and efficient software solutions through various programming languages and methodologies.',
                            ]
                        ],
                        '4' =>  [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 13,
                                'image' => 'computer.png',
                                'hour_rate' => 70,
                                'description' => 'Computer science is the study of computers and computational systems, encompassing their theory, design, development, and application. It involves programming, algorithms, data structures, and the development of software and hardware to solve problems and create technological solutions.',
                            ],
                        ]

                    ]
                ],
                [ // 11 M
                    'email'         => 'dewayne@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Dewayne',
                    'last_name'     => 'Beaudreau',
                    'gender'        => 'male',
                    'image'         => 'tutor-10.jpg',
                    'intro_video'   => 'tutor-video-11.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Guiding Success with Personalized Learning Strategies',
                    'description'   => '<p>Hello! I’m Dewayne Beaudreau, and I’m here to offer my expertise and support to help you achieve your academic goals. With a solid background in a variety of subjects, including mathematics, science, and English, I am dedicated to providing personalized and effective tutoring that meets your individual needs. My approach focuses on creating a supportive and engaging learning environment where students can feel comfortable exploring new concepts and tackling challenging material. I believe in a hands-on, interactive approach that makes learning both enjoyable and impactful.</p>
                                        <p>Having worked with students across different educational levels and backgrounds, I understand the diverse needs that each student brings to the table. I tailor my teaching strategies to align with your unique learning style, ensuring that each session is both productive and motivating. By incorporating practical examples and real-world applications, I strive to make complex topics more relatable and easier to understand. My goal is not just to improve your academic performance but to foster a deeper appreciation for learning and critical thinking.</p>
                                        <p>In addition to focusing on subject matter, I also emphasize the development of essential study skills and strategies that contribute to long-term success. From effective time management to advanced test-taking techniques, I aim to equip you with the tools needed to excel in your studies and beyond. I am committed to helping you build confidence and achieve your academic aspirations. Whether you’re seeking help with specific coursework or aiming to enhance your overall study habits, I am here to guide you every step of the way. Together, we can work towards reaching your full potential and ensuring your success in all your academic endeavors.</p>',
                    'verified_at'   =>  now(),
                    'languages'     => [19, 17],
                    'native_language' => 'Asturian',
                    'experience' => [
                        [
                            'title'             => 'Urdu Language Teacher',
                            'user_id'           => 11,
                            'employment_type'   => '1',
                            'company'           => 'Pakistani School',
                            'location'          => 'hybrid',
                            'country_id'        => 6,
                            'city'              => 'Manama',
                            'start_date'        => '2011-09-01',
                            'end_date'          => '2019-06-30',
                            'description'       => 'Taught Urdu language and literature, including poetry, prose, and grammar. Organized literary events and prepared students for language proficiency exams.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Islamiyat Teacher',
                            'user_id'           => 11,
                            'employment_type'   => '1',
                            'company'           => 'Islamic School',
                            'location'          => 'hybrid',
                            'country_id'        => 2,
                            'city'              => 'Riyadh',
                            'start_date'        => '2020-03-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Taught Islamic studies including Quran, Hadith, Fiqh, and Islamic history. Organized religious events and mentored students in understanding Islamic principles.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Language Arts Coordinator',
                            'user_id'           => 11,
                            'employment_type'   => '1',
                            'company'           => 'International Language Academy',
                            'location'          => 'onsite',
                            'country_id'        => 6,
                            'city'              => 'Manama',
                            'start_date'        => '2008-01-01',
                            'end_date'          => '2011-08-31',
                            'description'       => 'Coordinated language arts curriculum, supervised language teachers, and organized language-related events and workshops.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Islamic Studies Professor',
                            'user_id'           => 11,
                            'employment_type'   => '2',
                            'company'           => 'Islamic University',
                            'location'          => 'remote',
                            'country_id'        => 2,
                            'city'              => 'Riyadh',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Lectured on advanced Islamic studies topics, supervised research projects, and contributed to academic publications in Islamic studies.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],

                    'certificate'   => [
                        [
                            'user_id'           => 11,
                            'title'             => 'Certified Chemistry Educator',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Chemistry Training Institute',
                            'issue_date'        => '2016-11-01',
                            'expiry_date'       => '2021-11-01',
                            'description'       => 'Certification for teaching chemistry, including laboratory techniques and chemical theory.',
                            'created_at'        => '2016-11-01',
                            'updated_at'        => '2021-11-01',
                        ],
                        [
                            'user_id'           => 11,
                            'title'             => 'Certified Web Development Trainer',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Digital Skills Academy',
                            'issue_date'        => '2018-04-01',
                            'expiry_date'       => '2023-04-01',
                            'description'       => 'Certification for training in web development technologies, including front-end and back-end development.',
                            'created_at'        => '2018-04-01',
                            'updated_at'        => '2023-04-01',
                        ],
                        [
                            'user_id'           => 11,
                            'title'             => 'Certified Web Design Specialist',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'Design Excellence Center',
                            'issue_date'        => '2019-06-01',
                            'expiry_date'       => '2024-06-01',
                            'description'       => 'Certification for specialization in web design, focusing on aesthetics, usability, and client communication.',
                            'created_at'        => '2019-06-01',
                            'updated_at'        => '2024-06-01',
                        ],
                        [
                            'user_id'           => 11,
                            'title'             => 'Certified Full-Stack Developer',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Tech Innovators Academy',
                            'issue_date'        => '2020-02-01',
                            'expiry_date'       => '2025-02-01',
                            'description'       => 'Certification for full-stack development skills, including both front-end and back-end technologies.',
                            'created_at'        => '2020-02-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 19,
                            'city' => 'Dhaka',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I create secure, high-performance software solutions and implement robust measures to protect systems from cyber threats and vulnerabilities.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 20,
                            'city' => 'Holetown',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I optimize complex IT systems and analyze data to drive strategic improvements and enhance operational efficiency.',
                        ],
                        [
                            'course_title' => 'Diploma in Data Science',
                            'institute_name' => 'Data Institute',
                            'country_id' => 21,
                            'city' => 'London',
                            'start_date' => '2018-06-01',
                            'end_date' => '2019-12-01',
                            'ongoing' => 0,
                            'description' => 'Training in data analysis and machine learning, I develop skills in interpreting complex data, building predictive models, and applying machine learning algorithms to solve real-world problems.',
                        ],
                        [
                            'course_title' => 'Certificate in Cloud Computing',
                            'institute_name' => 'Cloud Academy',
                            'country_id' => 22,
                            'city' => 'Sydney',
                            'start_date' => '2021-01-01',
                            'end_date' => '2021-06-01',
                            'ongoing' => 0,
                            'description' => 'Certification in cloud infrastructure and services, I possess expertise in designing, deploying, and managing cloud solutions to optimize scalability, performance, and cost-efficiency for organizations.',
                        ],
                    ],
                    'address'       =>  [
                        'country_id'   => 10,
                        'state_id'     => 3,
                        'city'         => 'Liberta',
                        'address'      => '707 Marine Drive',
                        'zipcode'      => '400002',
                        'lat'          => 19.076090,
                        'long'         => 72.877426
                    ],
                    'subjects'      => [
                        '1' => [
                            [
                                'id' => 4,
                                'image' => 'software_design.png',
                                'hour_rate' => 50,
                                'description' => 'Software design involves defining the architecture, components, and interfaces of a software system to meet specific requirements. It focuses on creating a blueprint that ensures the software is efficient, scalable, and maintainable.',
                            ],
                            [
                                'id' => 5,
                                'image' => 'uxui.png',
                                'hour_rate' => 60,
                                'description' => 'UI/UX design focuses on creating intuitive and engaging user interfaces and experiences for applications and websites. UI (User Interface) design emphasizes the look and layout, while UX (User Experience) design ensures the overall usability and satisfaction of the user journey.',
                            ],
                            [
                                'id' => 6,
                                'image' => 'english.png',
                                'hour_rate' => 70,
                                'description' => 'English is a widely spoken and written language used for communication across various contexts, including literature, business, and education. It serves as a global lingua franca, facilitating interactions between people from diverse linguistic backgrounds.',
                            ]
                        ],
                        '2' => [
                            [
                                'id' => 11,
                                'image' => 'islamiyat.png',
                                'hour_rate' => 75,
                                'description' => 'Islamiyat is the study of Islamic religion, including its beliefs, practices, history, and cultural impact. It covers various aspects of Islamic teachings, including the Quran, Hadith, jurisprudence, and the life of the Prophet Muhammad(P.B.U.H).',
                            ],
                            [
                                'id' => 8,
                                'image' => 'urdu.png',
                                'hour_rate' => 90,
                                'description' => 'Urdu is a South Asian language spoken primarily in Pakistan and India, known for its rich literary heritage and use of the Perso-Arabic script. It serves as a key medium for communication, literature, and cultural expression in the region.',
                            ],
                            [
                                'id' => 9,
                                'image' => 'gk.png',
                                'hour_rate' => 100,
                                'description' => 'General knowledge encompasses a broad range of information about various subjects, including history, geography, culture, current events, and more. It involves understanding fundamental concepts and facts that provide a well-rounded awareness of the world.',
                            ]
                        ],
                        '3' => [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 12,
                                'image' => 'physics.png',
                                'hour_rate' => 70,
                                'description' => 'Physics is a fundamental science that studies the principles of matter, energy, and their interactions. It helps to understand and describe natural phenomena and the laws governing the workings of the universe.',
                            ],
                        ]

                    ]

                ],
                [ // 12 M
                    'email'         => 'adolfo@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Swinney',
                    'last_name'     => 'Swinney',
                    'gender'        => 'male',
                    'image'         => 'tutor-11.jpg',
                    'intro_video'   => 'tutor-video-2.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Empowering Learning Through Personalized Tutoring Approach',
                    'description'   => '<p>Hi! I’m Swinney Swinney, and I’m dedicated to providing exceptional tutoring support to help students achieve their academic goals. With a strong background in a wide range of subjects, including mathematics, science, and literature, I offer a comprehensive approach to learning that is both engaging and effective. My teaching philosophy centers around creating a personalized learning experience that caters to each student’s unique needs and learning style. I believe that education should be a journey of discovery, where students feel encouraged to explore new concepts and develop a deep understanding of the material.</p>
                                        <p>In my tutoring sessions, I focus on building a solid foundation in core subjects while also emphasizing critical thinking and problem-solving skills. I have experience working with students of various ages and academic levels, from elementary school to college. My methods include interactive exercises, real-world examples, and tailored lesson plans that align with each student’s specific goals. I strive to make learning enjoyable and accessible, ensuring that students not only grasp the content but also develop a genuine interest in their studies.</p>
                                        <p>Beyond academic tutoring, I also provide guidance on essential study skills, time management, and test preparation. I understand that these skills are crucial for long-term success and aim to equip students with the tools they need to excel both in their current studies and future academic pursuits. My goal is to support students in reaching their full potential and to foster a positive attitude toward learning. Whether you need help with a challenging subject or want to enhance your overall academic performance, I’m here to assist you every step of the way. Let’s work together to achieve your educational goals and unlock your potential.</p>',
                    'verified_at'   =>  now(),
                    'languages'     => [19, 17],
                    'native_language' => 'Asturian',
                    'experience' => [
                        [
                            'title'             => 'Urdu Language Teacher',
                            'user_id'           => 11,
                            'employment_type'   => '1',
                            'company'           => 'Pakistani School',
                            'location'          => 'hybrid',
                            'country_id'        => 6,
                            'city'              => 'Manama',
                            'start_date'        => '2011-09-01',
                            'end_date'          => '2019-06-30',
                            'description'       => 'Taught Urdu language and literature, including poetry, prose, and grammar. Organized literary events and prepared students for language proficiency exams.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Islamiyat Teacher',
                            'user_id'           => 11,
                            'employment_type'   => '1',
                            'company'           => 'Islamic School',
                            'location'          => 'hybrid',
                            'country_id'        => 2,
                            'city'              => 'Riyadh',
                            'start_date'        => '2020-03-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Taught Islamic studies including Quran, Hadith, Fiqh, and Islamic history. Organized religious events and mentored students in understanding Islamic principles.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Language Arts Coordinator',
                            'user_id'           => 11,
                            'employment_type'   => '1',
                            'company'           => 'International Language Academy',
                            'location'          => 'onsite',
                            'country_id'        => 6,
                            'city'              => 'Manama',
                            'start_date'        => '2008-01-01',
                            'end_date'          => '2011-08-31',
                            'description'       => 'Coordinated language arts curriculum, supervised language teachers, and organized language-related events and workshops.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Islamic Studies Professor',
                            'user_id'           => 11,
                            'employment_type'   => '2',
                            'company'           => 'Islamic University',
                            'location'          => 'remote',
                            'country_id'        => 2,
                            'city'              => 'Riyadh',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Lectured on advanced Islamic studies topics, supervised research projects, and contributed to academic publications in Islamic studies.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],

                    'certificate'   => [
                        [
                            'user_id'           => 11,
                            'title'             => 'Certified Chemistry Educator',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Chemistry Training Institute',
                            'issue_date'        => '2016-11-01',
                            'expiry_date'       => '2021-11-01',
                            'description'       => 'Certification for teaching chemistry, including laboratory techniques and chemical theory.',
                            'created_at'        => '2016-11-01',
                            'updated_at'        => '2021-11-01',
                        ],
                        [
                            'user_id'           => 11,
                            'title'             => 'Certified Web Development Trainer',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Digital Skills Academy',
                            'issue_date'        => '2018-04-01',
                            'expiry_date'       => '2023-04-01',
                            'description'       => 'Certification for training in web development technologies, including front-end and back-end development.',
                            'created_at'        => '2018-04-01',
                            'updated_at'        => '2023-04-01',
                        ],
                        [
                            'user_id'           => 11,
                            'title'             => 'Certified Web Design Specialist',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'Design Excellence Center',
                            'issue_date'        => '2019-06-01',
                            'expiry_date'       => '2024-06-01',
                            'description'       => 'Certification for specialization in web design, focusing on aesthetics, usability, and client communication.',
                            'created_at'        => '2019-06-01',
                            'updated_at'        => '2024-06-01',
                        ],
                        [
                            'user_id'           => 11,
                            'title'             => 'Certified Full-Stack Developer',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Tech Innovators Academy',
                            'issue_date'        => '2020-02-01',
                            'expiry_date'       => '2025-02-01',
                            'description'       => 'Certification for full-stack development skills, including both front-end and back-end technologies.',
                            'created_at'        => '2020-02-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 19,
                            'city' => 'Dhaka',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I build innovative software solutions and implement comprehensive security measures to safeguard systems from potential cyber threats.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 20,
                            'city' => 'Holetown',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I manage complex IT infrastructures and use data insights to enhance performance and support strategic business objectives.',
                        ],
                        [
                            'course_title' => 'Diploma in Data Science',
                            'institute_name' => 'Data Institute',
                            'country_id' => 21,
                            'city' => 'London',
                            'start_date' => '2018-06-01',
                            'end_date' => '2019-12-01',
                            'ongoing' => 0,
                            'description' => 'Training in data analysis and machine learning, I develop skills in interpreting complex data, building predictive models, and applying machine learning algorithms to solve real-world problems.',
                        ],
                        [
                            'course_title' => 'Certificate in Cloud Computing',
                            'institute_name' => 'Cloud Academy',
                            'country_id' => 22,
                            'city' => 'Sydney',
                            'start_date' => '2021-01-01',
                            'end_date' => '2021-06-01',
                            'ongoing' => 0,
                            'description' => 'Certification in cloud infrastructure and services, I possess expertise in designing, deploying, and managing cloud solutions to optimize scalability, performance, and cost-efficiency for organizations.',
                        ],
                    ],
                    'address'       =>  [
                        'country_id'   => 10,
                        'state_id'     => 3,
                        'city'         => 'Liberta',
                        'address'      => '707 Marine Drive',
                        'zipcode'      => '400002',
                        'lat'          => 19.076090,
                        'long'         => 72.877426
                    ],
                    'subjects'      => [
                        '1' => [
                            [
                                'id' => 4,
                                'image' => 'software_design.png',
                                'hour_rate' => 50,
                                'description' => 'Software design involves defining the architecture, components, and interfaces of a software system to meet specific requirements. It focuses on creating a blueprint that ensures the software is efficient, scalable, and maintainable.',
                            ],
                            [
                                'id' => 5,
                                'image' => 'uxui.png',
                                'hour_rate' => 60,
                                'description' => 'UI/UX design focuses on creating intuitive and engaging user interfaces and experiences for applications and websites. UI (User Interface) design emphasizes the look and layout, while UX (User Experience) design ensures the overall usability and satisfaction of the user journey.',
                            ],
                            [
                                'id' => 6,
                                'image' => 'english.png',
                                'hour_rate' => 70,
                                'description' => 'English is a widely spoken and written language used for communication across various contexts, including literature, business, and education. It serves as a global lingua franca, facilitating interactions between people from diverse linguistic backgrounds.',
                            ]
                        ],
                        '2' => [
                            [
                                'id' => 11,
                                'image' => 'islamiyat.png',
                                'hour_rate' => 75,
                                'description' => 'Islamiyat is the study of Islamic religion, including its beliefs, practices, history, and cultural impact. It covers various aspects of Islamic teachings, including the Quran, Hadith, jurisprudence, and the life of the Prophet Muhammad(P.B.U.H).',
                            ],
                            [
                                'id' => 8,
                                'image' => 'urdu.png',
                                'hour_rate' => 90,
                                'description' => 'Urdu is a South Asian language spoken primarily in Pakistan and India, known for its rich literary heritage and use of the Perso-Arabic script. It serves as a key medium for communication, literature, and cultural expression in the region.',
                            ],
                            [
                                'id' => 9,
                                'image' => 'gk.png',
                                'hour_rate' => 100,
                                'description' => 'General knowledge encompasses a broad range of information about various subjects, including history, geography, culture, current events, and more. It involves understanding fundamental concepts and facts that provide a well-rounded awareness of the world.',
                            ]
                        ],
                        '3' => [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 12,
                                'image' => 'physics.png',
                                'hour_rate' => 70,
                                'description' => 'Physics is a fundamental science that studies the principles of matter, energy, and their interactions. It helps to understand and describe natural phenomena and the laws governing the workings of the universe.',
                            ],
                        ]

                    ]

                ],
                [ // 13 M
                    'email'         => 'chapman@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Simonth',
                    'last_name'     => 'chapman',
                    'gender'        => 'male',
                    'image'         => 'tutor-12.jpg',
                    'intro_video'   => 'tutor-video-3.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Guiding Success Through Personalized Learning Solutions',
                    'description'   => '<p>Hi! I am Simonth Chapman, an enthusiastic and dedicated tutor committed to guiding students towards academic excellence. With extensive experience in various subjects, including mathematics, science, and English, I offer a well-rounded approach to tutoring. My teaching philosophy emphasizes understanding each student’s individual needs and learning styles, allowing me to tailor my methods for optimal effectiveness. I believe that education should be an inspiring and empowering experience, and I strive to create a supportive environment where students are encouraged to ask questions, engage deeply with the material, and build their confidence.</p>
                                        <p>Throughout my career, I have worked with students of all ages, from elementary school through college, helping them overcome academic challenges and reach their full potential. My tutoring sessions are designed to be interactive and engaging, incorporating a mix of direct instruction, practical examples, and problem-solving activities to ensure a thorough understanding of the subject matter. I am passionate about helping students not only improve their grades but also develop a lifelong love for learning and critical thinking.</p>
                                        <p>Beyond subject-specific tutoring, I also focus on developing essential academic skills, such as effective study techniques, time management, and test-taking strategies. I believe that these skills are crucial for academic success and personal growth. My goal is to support students in achieving their educational goals while fostering a positive and motivating learning experience. Whether you need help with a challenging topic or want to enhance your overall academic performance, I am here to provide the guidance and encouragement you need to succeed.</p>',
                    'verified_at'   =>  now(),
                    'languages'     => [8, 9],
                    'native_language' => 'Galician',
                    'experience' => [
                        [
                            'title'             => 'Educational Program Coordinator',
                            'user_id'           => 4,
                            'employment_type'   => '2',
                            'company'           => 'Vienna International School',
                            'location'          => 'hybrid',
                            'country_id'        => 8,
                            'city'              => 'Vienna',
                            'start_date'        => '2010-02-01',
                            'end_date'          => '2016-06-30',
                            'description'       => 'Coordinated international educational programs, organized student exchanges, and managed partnerships with schools abroad.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Educational Program Coordinator',
                            'user_id'           => 4,
                            'employment_type'   => '2',
                            'company'           => 'Baku University',
                            'location'          => 'onsite',
                            'country_id'        => 9,
                            'city'              => 'Baku',
                            'start_date'        => '2017-09-01',
                            'end_date'          => '2019-06-30',
                            'description'       => 'Taught World and Azerbaijani history to high standards, prepared students for national exams, and organized history-related field trips.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Project Manager - Education Initiatives',
                            'user_id'           => 4,
                            'employment_type'   => '1',
                            'company'           => 'UNESCO',
                            'location'          => 'remote',
                            'country_id'        => 10,
                            'city'              => 'Paris',
                            'start_date'        => '2020-01-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Led projects focused on promoting education in underprivileged regions, developed strategies, and coordinated with international teams.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Director of Educational Programs',
                            'user_id'           => 4,
                            'employment_type'   => '3',
                            'company'           => 'Global Education Foundation',
                            'location'          => 'hybrid',
                            'country_id'        => 11,
                            'city'              => 'New York',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Oversee educational programs, manage a global team, and implement innovative strategies for improving access to quality education.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],

                    'certificate'   => [
                        [
                            'user_id'           => 4,
                            'title'             => 'Certified Urdu Language Teacher',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Pakistani School',
                            'issue_date'        => '2011-09-01',
                            'expiry_date'       => '2019-09-01',
                            'description'       => 'Certification for teaching Urdu language and literature, including poetry, prose, and grammar.',
                            'created_at'        => '2011-09-01',
                            'updated_at'        => '2019-09-01',
                        ],
                        [
                            'user_id'           => 4,
                            'title'             => 'Certified General Knowledge Teacher',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Knowledge Academy',
                            'issue_date'        => '2016-01-01',
                            'expiry_date'       => '2021-01-01',
                            'description'       => 'Certification for teaching general knowledge subjects including history, geography, and current affairs.',
                            'created_at'        => '2016-01-01',
                            'updated_at'        => '2021-01-01',
                        ],
                        [
                            'user_id'           => 4,
                            'title'             => 'Certified Science Teacher',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'Modern School',
                            'issue_date'        => '2013-09-01',
                            'expiry_date'       => '2020-09-01',
                            'description'       => 'Certification for teaching general science, including biology, chemistry, and physics.',
                            'created_at'        => '2013-09-01',
                            'updated_at'        => '2020-09-01',
                        ],
                        [
                            'user_id'           => 4,
                            'title'             => 'Certified Environmental Science Educator',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Eco Education Center',
                            'issue_date'        => '2022-05-01',
                            'expiry_date'       => '2025-05-01',
                            'description'       => 'Certification for teaching environmental science, including climate change, ecology, and sustainability.',
                            'created_at'        => '2022-05-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 5,
                            'city' => 'Annaba',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I build innovative software solutions and implement comprehensive security measures to safeguard systems from potential cyber threats.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 6,
                            'city' => 'Canillo',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I manage complex IT infrastructures and use data insights to enhance performance and support strategic business objectives.',
                        ],
                        [
                            'course_title' => 'Diploma in Digital Marketing',
                            'institute_name' => 'Marketing Academy',
                            'country_id' => 7,
                            'city' => 'Berlin',
                            'start_date' => '2018-01-01',
                            'end_date' => '2018-12-31',
                            'ongoing' => 0,
                            'description' => 'Covered SEO, SEM, and content marketing strategies, I enhance online visibility, drive targeted traffic, and develop effective content plans to improve engagement and achieve business goals.',
                        ],
                        [
                            'course_title' => 'Certification in Cybersecurity',
                            'institute_name' => 'Cyber Defense Center',
                            'country_id' => 8,
                            'city' => 'Tokyo',
                            'start_date' => '2023-03-01',
                            'end_date' => '2023-09-01',
                            'ongoing' => 0,
                            'description' => 'Focused on network security, threat analysis, and incident response, I protect systems from cyber threats, analyze security risks, and develop effective strategies for incident management and recovery.',
                        ],
                    ],

                    'address'       => [
                        'country_id'   => 3,
                        'state_id'     => 1,
                        'city'         => 'Berat',
                        'address'      => '789 Oxford St',
                        'zipcode'      => 'W1D 1BS',
                        'lat'          => 51.507351,
                        'long'         => -0.127758
                    ],
                    'subjects'      => [
                        '1' => [
                            [
                                'id' => 1,
                                'image' => 'web_development.png',
                                'hour_rate' => 20,
                                'description' => 'Web development involves the creation and maintenance of websites and web applications, encompassing both front-end and back-end technologies. It includes designing user interfaces, implementing functionality, and ensuring optimal performance and security.',
                            ],
                            [
                                'id' => 2,
                                'image' => 'web_designing.png',
                                'hour_rate' => 30,
                                'description' => 'Web designing focuses on creating visually appealing and user-friendly interfaces for websites. It involves designing layouts, graphics, and interactive elements to enhance user experience and engagement.',
                            ],
                            [
                                'id' => 3,
                                'image' => 'software_development.png',
                                'hour_rate' => 40,
                                'description' => 'Software development is the process of designing, coding, testing, and maintaining software applications. It involves translating user needs into functional and efficient software solutions through various programming languages and methodologies.',
                            ]
                        ],
                        '4' =>  [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 13,
                                'image' => 'computer.png',
                                'hour_rate' => 70,
                                'description' => 'Computer science is the study of computers and computational systems, encompassing their theory, design, development, and application. It involves programming, algorithms, data structures, and the development of software and hardware to solve problems and create technological solutions.',
                            ],
                        ]

                    ]
                ],
                [ // 14 F
                    'email'         => 'hunter@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Cynthia',
                    'last_name'     => 'Hunter',
                    'gender'        => 'female',
                    'image'         => 'tutor-13.jpg',
                    'intro_video'   => 'tutor-video-5.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Empowering Students with Customized Learning Support',
                    'description'   => '<p>Hi! I am Cynthia Hunter, a dedicated and experienced tutor with a passion for helping students excel in their academic pursuits. With expertise across a variety of subjects, including mathematics, science, and language arts, I offer a personalized approach to tutoring that addresses each student’s unique learning needs. My teaching philosophy is centered on fostering a supportive and engaging learning environment where students feel encouraged to explore, ask questions, and develop a strong understanding of the material.</p>
                                        <p>Over the years, I have had the privilege of working with students from diverse backgrounds and educational levels, from elementary school through college. My approach involves using interactive and practical teaching methods that make complex concepts more accessible and relatable. I am committed to not only improving academic performance but also building confidence and instilling a genuine love for learning. By tailoring my sessions to align with each student’s individual goals and learning style, I aim to make every lesson both effective and enjoyable.</p>
                                        <p>In addition to subject-specific tutoring, I emphasize the development of key academic skills, such as effective study habits, time management, and test-taking strategies. These skills are essential for long-term success and personal growth. My goal is to provide comprehensive support that empowers students to achieve their full potential and excel in their studies. Whether you need help with specific coursework or want to enhance your overall academic performance, I am here to guide you every step of the way.</p>',
                    'verified_at'   =>  now(),
                    'languages'     => [6, 7],
                    'native_language' => 'French',
                    'experience' => [
                        [
                            'title'             => 'Curriculum Developer',
                            'user_id'           => 5,
                            'employment_type'   => '2',
                            'company'           => 'Bahamas Education Authority',
                            'location'          => 'remote',
                            'country_id'        => 10,
                            'city'              => 'Nassau',
                            'start_date'        => '2016-01-01',
                            'end_date'          => '2020-12-31',
                            'description'       => 'Developed and revised curriculum for primary and secondary schools, incorporating modern teaching methods and technology.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Science Teacher',
                            'user_id'           => 5,
                            'employment_type'   => '2',
                            'company'           => 'Dhaka International School',
                            'location'          => 'onsite',
                            'country_id'        => 11,
                            'city'              => 'Dhaka',
                            'start_date'        => '2017-09-01',
                            'end_date'          => '2021-06-30',
                            'description'       => 'Taught Biology, Chemistry, and Physics to students in grades 6-12, organized science fairs, and mentored students in science Olympiads.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Educational Consultant',
                            'user_id'           => 5,
                            'employment_type'   => '3',
                            'company'           => 'Global Education Consultancy',
                            'location'          => 'hybrid',
                            'country_id'        => 12,
                            'city'              => 'London',
                            'start_date'        => '2022-01-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Provided consultancy services for educational institutions, focusing on curriculum development and teacher training.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Director of Science Education',
                            'user_id'           => 5,
                            'employment_type'   => '1',
                            'company'           => 'Asia-Pacific Education Network',
                            'location'          => 'remote',
                            'country_id'        => 13,
                            'city'              => 'Singapore',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Leading initiatives to enhance science education across the Asia-Pacific region, developing new teaching materials, and training educators.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],

                    'certificate'   => [
                        [
                            'user_id'           => 5,
                            'title'             => 'Certified Islamiyat Teacher',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Islamic School',
                            'issue_date'        => '2014-03-01',
                            'expiry_date'       => '2021-03-01',
                            'description'       => 'Certification for teaching Islamic studies, including Quran, Hadith, Fiqh, and Islamic history.',
                            'created_at'        => '2014-03-01',
                            'updated_at'        => '2021-03-01',
                        ],
                        [
                            'user_id'           => 5,
                            'title'             => 'Certified Physics Lecturer',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Government College',
                            'issue_date'        => '2010-09-01',
                            'expiry_date'       => '2018-09-01',
                            'description'       => 'Certification for teaching physics, including mechanics, electromagnetism, and thermodynamics.',
                            'created_at'        => '2010-09-01',
                            'updated_at'        => '2018-09-01',
                        ],
                        [
                            'user_id'           => 5,
                            'title'             => 'Certified Computer Science Instructor',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'National Institute of Computer Science',
                            'issue_date'        => '2011-01-01',
                            'expiry_date'       => '2017-01-01',
                            'description'       => 'Certification for teaching computer science subjects, including programming, data structures, and algorithms.',
                            'created_at'        => '2011-01-01',
                            'updated_at'        => '2017-01-01',
                        ],
                        [
                            'user_id'           => 5,
                            'title'             => 'Certified Mathematics Tutor',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Mathematics Institute',
                            'issue_date'        => '2022-08-01',
                            'expiry_date'       => '2025-08-01',
                            'description'       => 'Certification for tutoring mathematics, including calculus, algebra, and statistics.',
                            'created_at'        => '2022-08-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 7,
                            'city' => 'Cacuaco',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I build innovative software solutions and implement comprehensive security measures to safeguard systems from potential cyber threats.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 8,
                            'city' => 'West End',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I manage complex IT infrastructures and use data insights to enhance performance and support strategic business objectives.',
                        ],
                        [
                            'course_title' => 'Diploma in Data Analytics',
                            'institute_name' => 'Data Academy',
                            'country_id' => 9,
                            'city' => 'Montreal',
                            'start_date' => '2017-05-01',
                            'end_date' => '2018-11-01',
                            'ongoing' => 0,
                            'description' => 'Covered data visualization, statistical analysis, and predictive modeling, I transform complex data into clear visual insights, apply statistical methods, and develop models to forecast trends and inform decisions.',
                        ],
                        [
                            'course_title' => 'Certification in Cloud Computing',
                            'institute_name' => 'Cloud Tech Institute',
                            'country_id' => 10,
                            'city' => 'Sydney',
                            'start_date' => '2022-06-01',
                            'end_date' => '2023-02-01',
                            'ongoing' => 0,
                            'description' => 'Focused on cloud infrastructure, services, and deployment strategies, I design and implement scalable cloud solutions, optimize resource management, and ensure efficient deployment practices for enhanced performance.',
                        ],
                    ],

                    'address'       => [
                        'country_id'   => 4,
                        'state_id'     => 2,
                        'city'         => 'Annaba',
                        'address'      => '101 George St',
                        'zipcode'      => '2000',
                        'lat'          => -33.868820,
                        'long'         => 151.209296
                    ],
                    'subjects'      => [
                        '1' => [
                            [
                                'id' => 4,
                                'image' => 'software_design.png',
                                'hour_rate' => 50,
                                'description' => 'Software design involves defining the architecture, components, and interfaces of a software system to meet specific requirements. It focuses on creating a blueprint that ensures the software is efficient, scalable, and maintainable.',
                            ],
                            [
                                'id' => 5,
                                'image' => 'uxui.png',
                                'hour_rate' => 60,
                                'description' => 'UI/UX design focuses on creating intuitive and engaging user interfaces and experiences for applications and websites. UI (User Interface) design emphasizes the look and layout, while UX (User Experience) design ensures the overall usability and satisfaction of the user journey.',
                            ],
                            [
                                'id' => 6,
                                'image' => 'english.png',
                                'hour_rate' => 70,
                                'description' => 'English is a widely spoken and written language used for communication across various contexts, including literature, business, and education. It serves as a global lingua franca, facilitating interactions between people from diverse linguistic backgrounds.',
                            ]
                        ],
                        '2' => [
                            [
                                'id' => 11,
                                'image' => 'islamiyat.png',
                                'hour_rate' => 75,
                                'description' => 'Islamiyat is the study of Islamic religion, including its beliefs, practices, history, and cultural impact. It covers various aspects of Islamic teachings, including the Quran, Hadith, jurisprudence, and the life of the Prophet Muhammad(P.B.U.H).',
                            ],
                            [
                                'id' => 8,
                                'image' => 'urdu.png',
                                'hour_rate' => 90,
                                'description' => 'Urdu is a South Asian language spoken primarily in Pakistan and India, known for its rich literary heritage and use of the Perso-Arabic script. It serves as a key medium for communication, literature, and cultural expression in the region.',
                            ],
                            [
                                'id' => 9,
                                'image' => 'gk.png',
                                'hour_rate' => 100,
                                'description' => 'General knowledge encompasses a broad range of information about various subjects, including history, geography, culture, current events, and more. It involves understanding fundamental concepts and facts that provide a well-rounded awareness of the world.',
                            ]
                        ],
                        '3' => [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 13,
                                'image' => 'computer.png',
                                'hour_rate' => 70,
                                'description' => 'Computer science is the study of computers and computational systems, encompassing their theory, design, development, and application. It involves programming, algorithms, data structures, and the development of software and hardware to solve problems and create technological solutions.',
                            ],
                        ]

                    ]
                ],
                [ // 15 F
                    'email'         => 'Inocencia@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Inocencia',
                    'last_name'     => 'Langenfeld',
                    'gender'        => 'female',
                    'image'         => 'tutor-14.jpg',
                    'intro_video'   => 'tutor-video-4.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Guiding Success Through Personalized Educational Support',
                    'description'   => '<p>Hi! I am Inocencia Langenfeld, a dedicated tutor with a deep commitment to fostering academic growth and success. With a robust background in a range of subjects, including mathematics, science, and language arts, I offer a personalized approach to education that caters to each student’s unique needs and learning style. My teaching philosophy centers around creating a nurturing and engaging environment where students feel confident to explore new concepts, ask questions, and achieve their full potential.</p>
                                        <p>Memory updated Hi! I am Inocencia Langenfeld, a dedicated tutor with a deep commitment to fostering academic growth and success. With a robust background in a range of subjects, including mathematics, science, and language arts, I offer a personalized approach to education that caters to each student’s unique needs and learning style. My teaching philosophy centers around creating a nurturing and engaging environment where students feel confident to explore new concepts, ask questions, and achieve their full potential. Throughout my career, I have worked with students of all ages, from elementary through college, providing tailored support that addresses individual challenges and goals. My methods include interactive and practical exercises designed to make learning both enjoyable and effective. I am passionate about helping students not only improve their grades but also develop a lasting enthusiasm for learning and critical thinking.</p
                                        <p>In addition to academic tutoring, I focus on helping students build essential skills such as effective study techniques, time management, and test preparation. These skills are crucial for long-term academic success and personal development. My aim is to provide comprehensive support that empowers students to excel in their studies and beyond. Whether you’re seeking assistance with specific subjects or aiming to enhance your overall academic abilities, I am here to support you every step of the way.</p>',
                    'verified_at'   =>  now(),
                    'languages'     => [6, 7],
                    'native_language' => 'French',
                    'experience' => [
                        [
                            'title'             => 'Curriculum Developer',
                            'user_id'           => 5,
                            'employment_type'   => '2',
                            'company'           => 'Bahamas Education Authority',
                            'location'          => 'remote',
                            'country_id'        => 10,
                            'city'              => 'Nassau',
                            'start_date'        => '2016-01-01',
                            'end_date'          => '2020-12-31',
                            'description'       => 'Developed and revised curriculum for primary and secondary schools, incorporating modern teaching methods and technology.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Science Teacher',
                            'user_id'           => 5,
                            'employment_type'   => '2',
                            'company'           => 'Dhaka International School',
                            'location'          => 'onsite',
                            'country_id'        => 11,
                            'city'              => 'Dhaka',
                            'start_date'        => '2017-09-01',
                            'end_date'          => '2021-06-30',
                            'description'       => 'Taught Biology, Chemistry, and Physics to students in grades 6-12, organized science fairs, and mentored students in science Olympiads.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Educational Consultant',
                            'user_id'           => 5,
                            'employment_type'   => '3',
                            'company'           => 'Global Education Consultancy',
                            'location'          => 'hybrid',
                            'country_id'        => 12,
                            'city'              => 'London',
                            'start_date'        => '2022-01-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Provided consultancy services for educational institutions, focusing on curriculum development and teacher training.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Director of Science Education',
                            'user_id'           => 5,
                            'employment_type'   => '1',
                            'company'           => 'Asia-Pacific Education Network',
                            'location'          => 'remote',
                            'country_id'        => 13,
                            'city'              => 'Singapore',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Leading initiatives to enhance science education across the Asia-Pacific region, developing new teaching materials, and training educators.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],

                    'certificate'   => [
                        [
                            'user_id'           => 5,
                            'title'             => 'Certified Islamiyat Teacher',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Islamic School',
                            'issue_date'        => '2014-03-01',
                            'expiry_date'       => '2021-03-01',
                            'description'       => 'Certification for teaching Islamic studies, including Quran, Hadith, Fiqh, and Islamic history.',
                            'created_at'        => '2014-03-01',
                            'updated_at'        => '2021-03-01',
                        ],
                        [
                            'user_id'           => 5,
                            'title'             => 'Certified Physics Lecturer',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Government College',
                            'issue_date'        => '2010-09-01',
                            'expiry_date'       => '2018-09-01',
                            'description'       => 'Certification for teaching physics, including mechanics, electromagnetism, and thermodynamics.',
                            'created_at'        => '2010-09-01',
                            'updated_at'        => '2018-09-01',
                        ],
                        [
                            'user_id'           => 5,
                            'title'             => 'Certified Computer Science Instructor',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'National Institute of Computer Science',
                            'issue_date'        => '2011-01-01',
                            'expiry_date'       => '2017-01-01',
                            'description'       => 'Certification for teaching computer science subjects, including programming, data structures, and algorithms.',
                            'created_at'        => '2011-01-01',
                            'updated_at'        => '2017-01-01',
                        ],
                        [
                            'user_id'           => 5,
                            'title'             => 'Certified Mathematics Tutor',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Mathematics Institute',
                            'issue_date'        => '2022-08-01',
                            'expiry_date'       => '2025-08-01',
                            'description'       => 'Certification for tutoring mathematics, including calculus, algebra, and statistics.',
                            'created_at'        => '2022-08-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 7,
                            'city' => 'Cacuaco',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I build innovative software solutions and implement comprehensive security measures to safeguard systems from potential cyber threats.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 8,
                            'city' => 'West End',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I manage complex IT infrastructures and use data insights to enhance performance and support strategic business objectives.',
                        ],
                        [
                            'course_title' => 'Diploma in Data Analytics',
                            'institute_name' => 'Data Academy',
                            'country_id' => 9,
                            'city' => 'Montreal',
                            'start_date' => '2017-05-01',
                            'end_date' => '2018-11-01',
                            'ongoing' => 0,
                            'description' => 'Covered data visualization, statistical analysis, and predictive modeling, I transform complex data into clear visual insights, apply statistical methods, and develop models to forecast trends and inform decisions.',
                        ],
                        [
                            'course_title' => 'Certification in Cloud Computing',
                            'institute_name' => 'Cloud Tech Institute',
                            'country_id' => 10,
                            'city' => 'Sydney',
                            'start_date' => '2022-06-01',
                            'end_date' => '2023-02-01',
                            'ongoing' => 0,
                            'description' => 'Focused on cloud infrastructure, services, and deployment strategies, I design and implement scalable cloud solutions, optimize resource management, and ensure efficient deployment practices for enhanced performance.',
                        ],
                    ],

                    'address'       => [
                        'country_id'   => 4,
                        'state_id'     => 2,
                        'city'         => 'Annaba',
                        'address'      => '101 George St',
                        'zipcode'      => '2000',
                        'lat'          => -33.868820,
                        'long'         => 151.209296
                    ],
                    'subjects'      => [
                        '1' => [
                            [
                                'id' => 4,
                                'image' => 'software_design.png',
                                'hour_rate' => 50,
                                'description' => 'Software design involves defining the architecture, components, and interfaces of a software system to meet specific requirements. It focuses on creating a blueprint that ensures the software is efficient, scalable, and maintainable.',
                            ],
                            [
                                'id' => 5,
                                'image' => 'uxui.png',
                                'hour_rate' => 60,
                                'description' => 'UI/UX design focuses on creating intuitive and engaging user interfaces and experiences for applications and websites. UI (User Interface) design emphasizes the look and layout, while UX (User Experience) design ensures the overall usability and satisfaction of the user journey.',
                            ],
                            [
                                'id' => 6,
                                'image' => 'english.png',
                                'hour_rate' => 70,
                                'description' => 'English is a widely spoken and written language used for communication across various contexts, including literature, business, and education. It serves as a global lingua franca, facilitating interactions between people from diverse linguistic backgrounds.',
                            ]
                        ],
                        '2' => [
                            [
                                'id' => 11,
                                'image' => 'islamiyat.png',
                                'hour_rate' => 75,
                                'description' => 'Islamiyat is the study of Islamic religion, including its beliefs, practices, history, and cultural impact. It covers various aspects of Islamic teachings, including the Quran, Hadith, jurisprudence, and the life of the Prophet Muhammad(P.B.U.H).',
                            ],
                            [
                                'id' => 8,
                                'image' => 'urdu.png',
                                'hour_rate' => 90,
                                'description' => 'Urdu is a South Asian language spoken primarily in Pakistan and India, known for its rich literary heritage and use of the Perso-Arabic script. It serves as a key medium for communication, literature, and cultural expression in the region.',
                            ],
                            [
                                'id' => 9,
                                'image' => 'gk.png',
                                'hour_rate' => 100,
                                'description' => 'General knowledge encompasses a broad range of information about various subjects, including history, geography, culture, current events, and more. It involves understanding fundamental concepts and facts that provide a well-rounded awareness of the world.',
                            ]
                        ],
                        '3' => [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 13,
                                'image' => 'computer.png',
                                'hour_rate' => 70,
                                'description' => 'Computer science is the study of computers and computational systems, encompassing their theory, design, development, and application. It involves programming, algorithms, data structures, and the development of software and hardware to solve problems and create technological solutions.',
                            ],
                        ]

                    ]
                ],
                [ // 16 F
                    'email'         => 'alexa@amentotech.com',
                    'password'      => 'google',
                    'first_name'    => 'Alexa',
                    'last_name'     => 'Milan',
                    'gender'        => 'male',
                    'image'         => 'tutor-15.jpg',
                    'intro_video'   => 'tutor-video-6.mp4',
                    'phone_number'  => '07123456789',
                    'tagline'       => 'Empowering Learning Through Personalized Tutoring Solutions',
                    'description'   => '<p>Hi! I am Alexa Milan, a dedicated tutor committed to guiding students toward academic excellence and personal growth. With a broad expertise in various subjects, including mathematics, science, and English, I bring a tailored approach to each tutoring session, ensuring that every student receives the support they need to succeed. My teaching philosophy revolves around creating an engaging and supportive learning environment where students feel empowered to explore new ideas, tackle challenging concepts, and build confidence in their abilities.</p>
                                        <p>Throughout my career, I have worked with students across different educational levels, from elementary school to college, adapting my methods to fit each student’s unique learning style and goals. I employ a variety of teaching techniques, including interactive exercises, real-world applications, and problem-solving activities, to make learning both effective and enjoyable. My focus is not only on improving academic performance but also on fostering a genuine love for learning and critical thinking.</p>
                                        <p>Beyond subject-specific tutoring, I emphasize the importance of developing essential academic skills, such as effective study strategies, time management, and test-taking techniques. These skills are crucial for achieving long-term academic success and personal growth. My goal is to support each student in reaching their full potential and to provide guidance and encouragement throughout their educational journey. Whether you need help with particular subjects or want to enhance your overall academic performance, I am here to assist you every step of the way.</p>',
                    'verified_at'   =>  now(),
                    'languages'     => [19, 17],
                    'native_language' => 'Asturian',
                    'experience' => [
                        [
                            'title'             => 'Urdu Language Teacher',
                            'user_id'           => 11,
                            'employment_type'   => '1',
                            'company'           => 'Pakistani School',
                            'location'          => 'hybrid',
                            'country_id'        => 6,
                            'city'              => 'Manama',
                            'start_date'        => '2011-09-01',
                            'end_date'          => '2019-06-30',
                            'description'       => 'Taught Urdu language and literature, including poetry, prose, and grammar. Organized literary events and prepared students for language proficiency exams.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Islamiyat Teacher',
                            'user_id'           => 11,
                            'employment_type'   => '1',
                            'company'           => 'Islamic School',
                            'location'          => 'hybrid',
                            'country_id'        => 2,
                            'city'              => 'Riyadh',
                            'start_date'        => '2020-03-01',
                            'end_date'          => '2023-12-31',
                            'description'       => 'Taught Islamic studies including Quran, Hadith, Fiqh, and Islamic history. Organized religious events and mentored students in understanding Islamic principles.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Language Arts Coordinator',
                            'user_id'           => 11,
                            'employment_type'   => '1',
                            'company'           => 'International Language Academy',
                            'location'          => 'onsite',
                            'country_id'        => 6,
                            'city'              => 'Manama',
                            'start_date'        => '2008-01-01',
                            'end_date'          => '2011-08-31',
                            'description'       => 'Coordinated language arts curriculum, supervised language teachers, and organized language-related events and workshops.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                        [
                            'title'             => 'Islamic Studies Professor',
                            'user_id'           => 11,
                            'employment_type'   => '2',
                            'company'           => 'Islamic University',
                            'location'          => 'remote',
                            'country_id'        => 2,
                            'city'              => 'Riyadh',
                            'start_date'        => '2024-01-01',
                            'end_date'          => null,
                            'description'       => 'Lectured on advanced Islamic studies topics, supervised research projects, and contributed to academic publications in Islamic studies.',
                            'created_at'        => null,
                            'updated_at'        => null,
                        ],
                    ],

                    'certificate'   => [
                        [
                            'user_id'           => 11,
                            'title'             => 'Certified Chemistry Educator',
                            'image'             => 'certificate-1.png',
                            'institute_name'    => 'Chemistry Training Institute',
                            'issue_date'        => '2016-11-01',
                            'expiry_date'       => '2021-11-01',
                            'description'       => 'Certification for teaching chemistry, including laboratory techniques and chemical theory.',
                            'created_at'        => '2016-11-01',
                            'updated_at'        => '2021-11-01',
                        ],
                        [
                            'user_id'           => 11,
                            'title'             => 'Certified Web Development Trainer',
                            'image'             => 'certificate-2.png',
                            'institute_name'    => 'Digital Skills Academy',
                            'issue_date'        => '2018-04-01',
                            'expiry_date'       => '2023-04-01',
                            'description'       => 'Certification for training in web development technologies, including front-end and back-end development.',
                            'created_at'        => '2018-04-01',
                            'updated_at'        => '2023-04-01',
                        ],
                        [
                            'user_id'           => 11,
                            'title'             => 'Certified Web Design Specialist',
                            'image'             => 'certificate-3.png',
                            'institute_name'    => 'Design Excellence Center',
                            'issue_date'        => '2019-06-01',
                            'expiry_date'       => '2024-06-01',
                            'description'       => 'Certification for specialization in web design, focusing on aesthetics, usability, and client communication.',
                            'created_at'        => '2019-06-01',
                            'updated_at'        => '2024-06-01',
                        ],
                        [
                            'user_id'           => 11,
                            'title'             => 'Certified Full-Stack Developer',
                            'image'             => 'certificate-4.png',
                            'institute_name'    => 'Tech Innovators Academy',
                            'issue_date'        => '2020-02-01',
                            'expiry_date'       => '2025-02-01',
                            'description'       => 'Certification for full-stack development skills, including both front-end and back-end technologies.',
                            'created_at'        => '2020-02-01',
                            'updated_at'        => '2024-08-01',
                        ],
                    ],

                    'education' => [
                        [
                            'course_title' => 'Bachelor of Computer Science',
                            'institute_name' => 'ABC University',
                            'country_id' => 19,
                            'city' => 'Dhaka',
                            'start_date' => '2015-09-01',
                            'end_date' => '2019-06-01',
                            'ongoing' => 0,
                            'description' => 'Focused on software development and cybersecurity, I build innovative software solutions and implement comprehensive security measures to safeguard systems from potential cyber threats.',
                        ],
                        [
                            'course_title' => 'Master of Information Technology',
                            'institute_name' => 'XYZ Institute',
                            'country_id' => 20,
                            'city' => 'Holetown',
                            'start_date' => '2020-01-01',
                            'end_date' => '2022-12-01',
                            'ongoing' => 0,
                            'description' => 'Specialized in advanced IT management and data analysis, I manage complex IT infrastructures and use data insights to enhance performance and support strategic business objectives.',
                        ],
                        [
                            'course_title' => 'Diploma in Data Science',
                            'institute_name' => 'Data Institute',
                            'country_id' => 21,
                            'city' => 'London',
                            'start_date' => '2018-06-01',
                            'end_date' => '2019-12-01',
                            'ongoing' => 0,
                            'description' => 'Training in data analysis and machine learning, I develop skills in interpreting complex data, building predictive models, and applying machine learning algorithms to solve real-world problems.',
                        ],
                        [
                            'course_title' => 'Certificate in Cloud Computing',
                            'institute_name' => 'Cloud Academy',
                            'country_id' => 22,
                            'city' => 'Sydney',
                            'start_date' => '2021-01-01',
                            'end_date' => '2021-06-01',
                            'ongoing' => 0,
                            'description' => 'Certification in cloud infrastructure and services, I possess expertise in designing, deploying, and managing cloud solutions to optimize scalability, performance, and cost-efficiency for organizations.',
                        ],
                    ],
                    'address'       =>  [
                        'country_id'   => 10,
                        'state_id'     => 3,
                        'city'         => 'Liberta',
                        'address'      => '707 Marine Drive',
                        'zipcode'      => '400002',
                        'lat'          => 19.076090,
                        'long'         => 72.877426
                    ],
                    'subjects'      => [
                        '1' => [
                            [
                                'id' => 4,
                                'image' => 'software_design.png',
                                'hour_rate' => 50,
                                'description' => 'Software design involves defining the architecture, components, and interfaces of a software system to meet specific requirements. It focuses on creating a blueprint that ensures the software is efficient, scalable, and maintainable.',
                            ],
                            [
                                'id' => 5,
                                'image' => 'uxui.png',
                                'hour_rate' => 60,
                                'description' => 'UI/UX design focuses on creating intuitive and engaging user interfaces and experiences for applications and websites. UI (User Interface) design emphasizes the look and layout, while UX (User Experience) design ensures the overall usability and satisfaction of the user journey.',
                            ],
                            [
                                'id' => 6,
                                'image' => 'english.png',
                                'hour_rate' => 70,
                                'description' => 'English is a widely spoken and written language used for communication across various contexts, including literature, business, and education. It serves as a global lingua franca, facilitating interactions between people from diverse linguistic backgrounds.',
                            ]
                        ],
                        '2' => [
                            [
                                'id' => 11,
                                'image' => 'islamiyat.png',
                                'hour_rate' => 75,
                                'description' => 'Islamiyat is the study of Islamic religion, including its beliefs, practices, history, and cultural impact. It covers various aspects of Islamic teachings, including the Quran, Hadith, jurisprudence, and the life of the Prophet Muhammad(P.B.U.H).',
                            ],
                            [
                                'id' => 8,
                                'image' => 'urdu.png',
                                'hour_rate' => 90,
                                'description' => 'Urdu is a South Asian language spoken primarily in Pakistan and India, known for its rich literary heritage and use of the Perso-Arabic script. It serves as a key medium for communication, literature, and cultural expression in the region.',
                            ],
                            [
                                'id' => 9,
                                'image' => 'gk.png',
                                'hour_rate' => 100,
                                'description' => 'General knowledge encompasses a broad range of information about various subjects, including history, geography, culture, current events, and more. It involves understanding fundamental concepts and facts that provide a well-rounded awareness of the world.',
                            ]
                        ],
                        '3' => [
                            [
                                'id' => 10,
                                'image' => 'science.png',
                                'hour_rate' => 40,
                                'description' => 'Science is the systematic study of the natural world through observation, experimentation, and analysis. It aims to understand and explain phenomena, uncovering fundamental principles and advancing knowledge across various disciplines.',
                            ],
                            [
                                'id' => 7,
                                'image' => 'maths.png',
                                'hour_rate' => 80,
                                'description' => 'Mathematics is the study of numbers, quantities, shapes, and patterns, and their relationships through abstract reasoning and logical deduction. It includes various branches such as algebra, geometry, calculus, and statistics, used to solve problems and model real-world phenomena.',
                            ],
                            [
                                'id' => 12,
                                'image' => 'physics.png',
                                'hour_rate' => 70,
                                'description' => 'Physics is a fundamental science that studies the principles of matter, energy, and their interactions. It helps to understand and describe natural phenomena and the laws governing the workings of the universe.',
                            ],
                        ]

                    ]
                ],
            ]

        ];

        foreach ($users as $role => $roleUsers) {
            foreach ($roleUsers as $userData) {
                if (!isset($userData['email'], $userData['password'], $userData['first_name'], $userData['last_name'])) {
                    continue;
                }

                if (!isDemoSite() && $userData['email'] == 'ava@amentotech.com') {
                    break;
                }

                $user = User::updateOrCreate(
                    ['email' => $userData['email']],
                    [
                        'password' => Hash::make($userData['password']),
                        'default_role' => $role,
                        'email_verified_at' => now()
                    ]
                );

                $profileImage = $this->storeProfileImage($userData);
                if (!empty($userData['intro_video'])) {
                    Storage::disk(getStorageDisk())->putFileAs('profile_videos', public_path('demo-content/videos/' . $userData['intro_video']), $userData['intro_video']);
                }
                $user->profile()->updateOrCreate(
                    [
                        'user_id' => $user->id
                    ],
                    [
                        'first_name'        => $userData['first_name'],
                        'last_name'         => $userData['last_name'],
                        'gender'            => $userData['gender'] ?? null,
                        // 'slug'              => Str::slug($userData['first_name'] . ' ' . $userData['last_name'] . ' ' . $user->id),
                        'tagline'           => $userData['tagline'] ?? '',
                        'description'       => $userData['description'] ?? '',
                        'intro_video'       => !empty($userData['intro_video']) ? 'profile_videos/' . $userData['intro_video'] : null,
                        'phone_number'      => $userData['phone_number'] ?? '',
                        'native_language'   => $userData['native_language'] ?? null,
                        'verified_at'       => $userData['verified_at'] ?? null,
                        'image'             => $profileImage
                    ]
                );

                if (!empty($userData['languages'])) {
                    $user->languages()->detach();
                    $languages = [];
                    foreach ($userData['languages'] as $langId) {
                        $languages[] = $langId;
                    }
                    $user->languages()->attach($languages);
                }

                if (isset($userData['address'])) {
                    $this->seedAddress($user, $userData['address']);
                }

                if (isset($userData['education'])) {
                    $this->seedEducation($user, $userData['education']);
                }

                // Adding Experience
                if (isset($userData['experience'])) {
                    $this->seedExperience($user, $userData['experience']);
                }

                // Adding Certificate
                if (isset($userData['certificate'])) {
                    $this->seedCertificate($user, $userData['certificate']);
                }

                $user->assignRole($role);
                $user->profile()->update(['updated_at' => now()->addHour()]);

                if ($role === 'tutor' && isset($userData['subjects'])) {
                    $this->seedSubjects($user, $userData['subjects']);
                }

                if (isset($userData['social_profiles'])) {
                    $this->setSocialProfiles($user, $userData['social_profiles']);
                }
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function storeProfileImage($userData)
    {
        $imageFileName = $userData['image'] ?? '';
        $profileImage = 'profile_images/' . Str::slug($userData['first_name'] . ' ' . $userData['last_name']) . '.jpg';
        $imagePath = public_path('demo-content/tutor/' . $imageFileName);

        if (!empty($userData['image']) && file_exists($imagePath)) {
            Storage::disk(getStorageDisk())->put(
                $profileImage,
                file_get_contents($imagePath)
            );
        } else {
            Storage::disk(getStorageDisk())->put(
                $profileImage,
                file_get_contents(public_path('demo-content/placeholders/placeholder.png'))
            );
        }

        return $profileImage;
    }

    private function storeSubjectImage($subjectData)
    {
        $imageFileName = $subjectData['image'] ?? 'placeholder.png';
        $subjectImage = 'subject_images/' . $imageFileName;
        $imagePath = public_path('demo-content/subjects/' . $imageFileName);

        if (file_exists($imagePath)) {
            Storage::disk(getStorageDisk())->put(
                $subjectImage,
                file_get_contents($imagePath)
            );
        } else {
            Storage::disk(getStorageDisk())->put(
                $subjectImage,
                file_get_contents(public_path('demo-content/placeholders/placeholder-land.png'))
            );
        }

        return $subjectImage;
    }

    public function seedAddress($user, $addressData)
    {
        if (!empty($addressData)) {
            $user->address()->create([
                'country_id'   => $addressData['country_id'] ?? null,
                'state_id'     => $addressData['state_id'] ?? null,
                'city'         => $addressData['city'] ?? '',
                'address'      => $addressData['address'] ?? '',
                'zipcode'      => $addressData['zipcode'] ?? '',
                'lat'          => $addressData['lat'] ?? 0,
                'long'         => $addressData['long'] ?? 0
            ]);
        }
    }

    public function seedEducation($user, $educationData)
    {
        if (!empty($educationData)) {
            foreach ($educationData as $education) {
                $user->educations()->create([
                    'course_title' => $education['course_title'],
                    'institute_name' => $education['institute_name'],
                    'country_id' => $education['country_id'],
                    'city' => $education['city'],
                    'start_date' => $education['start_date'],
                    'end_date' => $education['end_date'],
                    'ongoing' => $education['ongoing'],
                    'description' => $education['description'],
                ]);
            }
        }
    }

    public function setSocialProfiles($user, $socialProfilesData)
    {
        if (!empty($socialProfilesData)) {
            $user->socialProfiles()->createMany($socialProfilesData);
        }
    }

    public function seedExperience($user, $experienceData)
    {
        if (!empty($experienceData)) {
            foreach ($experienceData as $experience) {
                $user->experiences()->create([
                    'title'             => $experience['title'],
                    'user_id'           => $user->id,
                    'employment_type'   => $experience['employment_type'],
                    'company'           => $experience['company'],
                    'location'          => $experience['location'],
                    'country_id'        => $experience['country_id'],
                    'city'              => $experience['city'],
                    'start_date'        => $experience['start_date'],
                    'end_date'          => $experience['end_date'],
                    'description'       => $experience['description'],
                    'created_at'        => $experience['created_at'] ?? null,
                    'updated_at'        => $experience['updated_at'] ?? null,
                ]);
            }
        }
    }

    public function seedCertificate($user, $certificateData)
    {
        if (!empty($certificateData)) {
            foreach ($certificateData as $certificate) {
                $user->certificates()->create([
                    'user_id'           => $user->id,
                    'title'             => $certificate['title'],
                    'image'             => $this->storeCertificateImage($certificate),
                    'institute_name'    => $certificate['institute_name'],
                    'issue_date'        => $certificate['issue_date'],
                    'expiry_date'       => $certificate['expiry_date'],
                    'description'       => $certificate['description'],
                    'created_at'        => $certificate['created_at'] ?? null,
                    'updated_at'        => $certificate['updated_at'] ?? null,
                ]);
            }
        }
    }

    private function storeCertificateImage($certificateData)
    {
        $imageFileName = $certificateData['image'] ?? 'placeholder.png';
        $certificateImage = 'certificates/' . $imageFileName;
        $imagePath = public_path('demo-content/certificates/' . $imageFileName);
        if (file_exists($imagePath)) {
            Storage::disk(getStorageDisk())->put(
                $certificateImage,
                file_get_contents($imagePath)
            );
        } else {
            Storage::disk(getStorageDisk())->put(
                $certificateImage,
                file_get_contents(public_path('demo-content/placeholders/placeholder-land.png'))
            );
        }

        return $certificateImage;
    }

    private function seedSubjects($user, $subjects)
    {
        foreach ($subjects as $subjectGroupId => $subjectDataArray) {
            foreach ($subjectDataArray as $subjectData) {
                $subjectImage = $this->storeSubjectImage($subjectData);

                $subjectGroup = UserSubjectGroup::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'subject_group_id' => $subjectGroupId
                    ],
                    [
                        'sort_order' => $subjectData['sort_order'] ?? 0
                    ]
                );

                $userSubject = UserSubjectGroupSubject::updateOrCreate(
                    [
                        'user_subject_group_id' => $subjectGroup->id,
                        'subject_id'    => $subjectData['id']
                    ],
                    [
                        'hour_rate'     => $subjectData['hour_rate'] ?? 0,
                        'description'   => $subjectData['description'] ?? null,
                        'image'         => $subjectImage,
                        'sort_order'    => $subjectData['sort_order'] ?? 0
                    ]
                );

                $slotsData = [
                    'subject_group_id' => $userSubject->id,
                    'date_range'       => now()->toDateString() . " to " . now()->addMonths(2)->toDateString(),
                    'session_fee'      =>  $subjectData['hour_rate'],
                    'description'      => '<strong>Overview</strong><br>
                                        This session will introduce students to the foundational principles of web design, focusing on creating visually appealing and user-friendly websites. Participants will gain hands-on experience in using industry-standard tools and techniques to develop responsive and accessible web pages.<br><br>
                                        <strong>What will be covered</strong><br>
                                        <ul>
                                            <li><strong>HTML & CSS Basics:</strong> Understanding the building blocks of web pages, including structure, styling, and layout.</li>
                                            <li><strong>Responsive Design:</strong> Learning how to create websites that adapt seamlessly to different screen sizes and devices.</li>
                                            <li><strong>Typography & Color Theory:</strong> Exploring the impact of typography and color choices on user experience and design aesthetics.</li>
                                            <li><strong>Web Design Tools:</strong> Introduction to popular tools like Adobe XD, Figma, or Sketch for designing website prototypes.</li>
                                            <li><strong>Accessibility:</strong> Ensuring websites are accessible to all users, including those with disabilities.</li>
                                            <li><strong>Introduction to JavaScript:</strong> Adding interactivity to web pages with basic JavaScript.</li>
                                            <li><strong>Best Practices:</strong> Understanding the best practices for modern web design, including SEO and performance optimization.</li>
                                        </ul>'
                ];

                $slotsData['start_time'] = $this->randomTime('09:00', '16:00');
                $totalSessionTime = mt_rand(60, 120);

                $slotsData['duration'] = mt_rand(30, $totalSessionTime - 10);
                $slotsData['break'] = $totalSessionTime - $slotsData['duration'];

                $slotsData['spaces'] = mt_rand(1, 10);

                $startTime = strtotime($slotsData['start_time']);
                $endTime = $startTime + ($slotsData['duration'] + $slotsData['break']) * 60;
                $slotsData['end_time'] = date('H:i', $endTime);
                if (isDemoSite()) {
                    (new BookingService($user))->addUserSubjectGroupSessions($slotsData);
                }
            }
        }
    }

    function randomTime($start, $end)
    {
        $startTimestamp = strtotime($start);
        $endTimestamp = strtotime($end);
        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);
        return date('H:i', $randomTimestamp);
    }
}
