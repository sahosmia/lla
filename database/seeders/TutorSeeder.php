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
use Illuminate\Support\Facades\Schema;


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
        Schema::disableForeignKeyConstraints();

        UserSubjectSlot::truncate();
        UserEducation::truncate();
        UserExperience::truncate();
        UserCertificate::truncate();
        Schema::enableForeignKeyConstraints();

        $users = [
            'admin' => [
                [
                    'email' => 'admin@gmail.com',
                    'password' => '12345678',
                    'first_name' => 'Admin',
                    'last_name' => 'Admin',
                    'image' => 'admin-image.jpg',
                ]
            ],
            'tutor' => [
                [ // 2 M
                    'email' => 'tutor@gmail.com',
                    'password' => '12345678',
                    'first_name' => 'Steven',
                    'last_name' => 'Ford',
                    'gender' => 'male',
                    'tagline' => 'Empowring Success through Customized Learning Strategies',
                    'description' => '<p>Hi! I am Steven Ford, a passionate and experienced tutor dedicated to helping students unlock their full potential. With a strong academic background and years of hands-on teaching experience, I have developed a deep understanding of various learning styles and strategies to cater to each student\'s unique needs. I believe that education is not just about memorizing facts but about fostering critical thinking, creativity, and a genuine love for learning. Whether you are struggling with a specific subject or looking to excel beyond your current level, I am here to guide you every step of the way. My approach is student-centered, focusing on building confidence, enhancing understanding, and developing the skills necessary for academic success. I strive to create a supportive and engaging learning environment where students feel comfortable asking questions and exploring new ideas.</p>
                                        <p>I specialize in a wide range of subjects, including mathematics, science, and English, with a particular emphasis on helping students prepare for exams and standardized tests. Over the years, I have worked with students from various age groups and educational backgrounds, from elementary school to college level. My teaching methods are tailored to each student\'s individual learning pace, ensuring that they grasp the concepts fully before moving on. I incorporate a variety of teaching tools and techniques, such as interactive exercises, real-life examples, and personalized study plans, to make learning both effective and enjoyable. My goal is to help students achieve academic success and inspire them to become lifelong learners.</p>
                                        <p>In addition to subject-specific tutoring, I also offer support in study skills, time management, and test-taking strategies. I understand that every student has their strengths and challenges, and I work diligently to identify and address any barriers to learning. My tutoring sessions are designed to be flexible and accommodating, allowing students to learn at their own pace while keeping them motivated and on track. I am committed to making a positive impact on my students\' academic journeys, and I take great pride in their achievements. Whether you need help with a challenging topic or want to boost your overall academic performance, I am here to help you succeed. Let\'s work together to achieve your educational goals!</p>',
                    'image' => 'tutor-1.jpg',
                    'intro_video' => 'tutor-video-1.mp4',
                    'phone_number' => '07123456789',
                    'verified_at' => now(),
                    'languages' => [2, 3],
                    'native_language' => 'Bengali',
                    'experience' => [
                        [
                            'title' => 'Elementary School Teacher',
                            'user_id' => 2,
                            'employment_type' => '2',
                            'company' => 'Algiers International School',
                            'location' => 'onsite',
                            'country_id' => 3,
                            'city' => 'Algiers',
                            'start_date' => '2010-09-01',
                            'end_date' => '2016-06-30',
                            'description' => 'Taught all core subjects to students in grades 1-4, and organized extracurricular activities focused on arts and sports.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Education Consultant',
                            'user_id' => 2,
                            'employment_type' => '2',
                            'company' => 'Angola Education Development',
                            'location' => 'remote',
                            'country_id' => 4,
                            'city' => 'Luanda',
                            'start_date' => '2017-01-01',
                            'end_date' => '2021-12-31',
                            'description' => 'Provided consultancy services to schools and educational institutions, focusing on curriculum development and teacher training.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Curriculum Developer',
                            'user_id' => 2,
                            'employment_type' => '1',
                            'company' => 'Global Education Solutions',
                            'location' => 'hybrid',
                            'country_id' => 5,
                            'city' => 'Cairo',
                            'start_date' => '2022-02-01',
                            'end_date' => '2023-08-31',
                            'description' => 'Developed and revised curriculum content for K-12 schools, balancing remote and onsite work environments.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'School Administrator',
                            'user_id' => 2,
                            'employment_type' => '3',
                            'company' => 'Nairobi International School',
                            'location' => 'onsite',
                            'country_id' => 6,
                            'city' => 'Nairobi',
                            'start_date' => '2024-01-01',
                            'end_date' => null,
                            'description' => 'Oversee day-to-day operations of the school, manage staff, and implement educational programs.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                    ],
                    'certificate' => [
                        [
                            'user_id' => 2,
                            'title' => 'Certified Web Development Instructor',
                            'image' => 'certificate-1.png',
                            'institute_name' => 'Tech Academy',
                            'issue_date' => '2015-09-01',
                            'expiry_date' => '2017-09-01',
                            'description' => 'Certification for teaching full-stack web development, including HTML, CSS, JavaScript, and React.',
                            'created_at' => '2018-09-01',
                            'updated_at' => '2023-09-01',
                        ],
                        [
                            'user_id' => 2,
                            'title' => 'Certified Web Design Instructor',
                            'image' => 'certificate-2.png',
                            'institute_name' => 'Creative Design School',
                            'issue_date' => '2018-01-01',
                            'expiry_date' => '2020-01-01',
                            'description' => 'Certification for teaching web design principles, UI/UX, and tools like Adobe XD and Figma.',
                            'created_at' => '2015-01-01',
                            'updated_at' => '2021-01-01',
                        ],
                        [
                            'user_id' => 2,
                            'title' => 'Certified Software Development Lecturer',
                            'image' => 'certificate-3.png',
                            'institute_name' => 'Kuwait IT Institute',
                            'issue_date' => '2021-03-01',
                            'expiry_date' => '2023-03-01',
                            'description' => 'Certification for teaching software development, including object-oriented programming and software life cycles.',
                            'created_at' => '2017-03-01',
                            'updated_at' => '2022-03-01',
                        ],
                        [
                            'user_id' => 2,
                            'title' => 'Certified Data Science Professional',
                            'image' => 'certificate-4.png',
                            'institute_name' => 'Data Science Institute',
                            'issue_date' => '2023-06-01',
                            'expiry_date' => '2025-06-01',
                            'description' => 'Certification for advanced data science and analytics skills, including machine learning and big data technologies.',
                            'created_at' => '2023-06-01',
                            'updated_at' => '2024-08-01',
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

                    'address' => [
                        'country_id' => 1,
                        'state_id' => 2,
                        'city' => 'Kabul',
                        'address' => '123 Main St',
                        'zipcode' => '10001',
                        'lat' => 40.712776,
                        'long' => -74.005974
                    ],
                    'subjects' => [
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
                        '2' => [
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
                [ // 3 M
                    'email' => 'anthony@gmail.com',
                    'password' => '12345678',
                    'first_name' => 'Anthony',
                    'last_name' => 'Shao',
                    'gender' => 'male',
                    'image' => 'tutor-2.jpg',
                    'intro_video' => 'tutor-video-2.mp4',
                    'phone_number' => '07123456789',
                    'tagline' => 'Inspiring Achievement Through Tailored Educational Support',
                    'description' => '<p>Hello! I’m Anthony Shao, a committed and enthusiastic tutor with a passion for empowering students to reach their academic goals. My approach to tutoring is centered on the belief that every student has the potential to excel when given the right guidance and support. I bring a diverse skill set to my tutoring sessions, with expertise in subjects ranging from mathematics and science to English. My aim is to make learning an enjoyable and rewarding experience by breaking down complex concepts into manageable and understandable parts. I take pride in creating a welcoming and encouraging environment where students feel comfortable expressing their difficulties and asking questions.</p>
                                        <p>Throughout my tutoring career, I have had the privilege of working with students across various age groups and educational stages, helping them overcome obstacles and achieve success. My teaching style is highly adaptable, as I understand that each student learns differently. Whether it’s through hands-on problem-solving, interactive discussions, or real-world applications, I tailor my lessons to match the learning style of each individual. My sessions are not just about getting the right answers but about building a deep understanding and fostering critical thinking skills that will benefit students in all areas of their education.</p>
                                        <p>In addition to subject-specific tutoring, I also focus on strengthening essential academic skills, such as effective studying techniques, time management, and exam preparation strategies. I recognize that the path to academic success is unique for each student, and I am dedicated to helping them navigate it with confidence. My goal is to instill a sense of achievement in my students, motivating them to take on new challenges and succeed in their educational endeavors. Whether you’re looking for help in a particular subject or need guidance to improve your overall academic performance, I am here to support you on your journey. Together, we can achieve your academic goals and build a strong foundation for future success.</p>',
                    'verified_at' => now(),
                    'languages' => [4, 5],
                    'native_language' => 'Bengali',
                    'experience' => [
                        [
                            'title' => 'University Lecturer',
                            'user_id' => 3,
                            'employment_type' => '2',
                            'company' => 'University of Tirana',
                            'location' => 'hybrid',
                            'country_id' => 2,
                            'city' => 'Tirana',
                            'start_date' => '2012-10-01',
                            'end_date' => '2018-07-31',
                            'description' => 'Lectured in Political Science, conducted research, and published academic papers in international journals.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'University Professor',
                            'user_id' => 3,
                            'employment_type' => '2',
                            'company' => 'Australian National University',
                            'location' => 'hybrid',
                            'country_id' => 7,
                            'city' => 'Canberra',
                            'start_date' => '2019-01-01',
                            'end_date' => '2024-12-31',
                            'description' => 'Taught courses in Environmental Science, supervised PhD students, and published research on climate change.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Visiting Scholar',
                            'user_id' => 3,
                            'employment_type' => '3',
                            'company' => 'Harvard University',
                            'location' => 'onsite',
                            'country_id' => 8,
                            'city' => 'Cambridge',
                            'start_date' => '2018-09-01',
                            'end_date' => '2019-05-31',
                            'description' => 'Collaborated with faculty on research projects related to international relations and delivered guest lectures.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Research Scientist',
                            'user_id' => 3,
                            'employment_type' => '1',
                            'company' => 'Max Planck Institute for Meteorology',
                            'location' => 'remote',
                            'country_id' => 9,
                            'city' => 'Hamburg',
                            'start_date' => '2020-03-01',
                            'end_date' => '2024-08-31',
                            'description' => 'Conducted research on climate models, wrote scientific papers, and participated in international conferences.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                    ],
                    'certificate' => [
                        [
                            'user_id' => 3,
                            'title' => 'Certified UI/UX Design Instructor',
                            'image' => 'certificate-1.png',
                            'institute_name' => 'Design Hub',
                            'issue_date' => '2016-02-01',
                            'expiry_date' => '2021-02-01',
                            'description' => 'Certification for teaching UI/UX design, including wireframing, prototyping, and user research.',
                            'created_at' => '2016-02-01',
                            'updated_at' => '2021-02-01',
                        ],
                        [
                            'user_id' => 3,
                            'title' => 'Certified English Teacher',
                            'image' => 'certificate-2.png',
                            'institute_name' => 'International School',
                            'issue_date' => '2014-09-01',
                            'expiry_date' => '2020-09-01',
                            'description' => 'Certification for teaching English language and literature to high school students.',
                            'created_at' => '2014-09-01',
                            'updated_at' => '2020-09-01',
                        ],
                        [
                            'user_id' => 3,
                            'title' => 'Certified Mathematics Teacher',
                            'image' => 'certificate-3.png',
                            'institute_name' => 'Al Ain School',
                            'issue_date' => '2012-03-01',
                            'expiry_date' => '2018-03-01',
                            'description' => 'Certification for teaching mathematics, including algebra, geometry, calculus, and statistics.',
                            'created_at' => '2012-03-01',
                            'updated_at' => '2018-03-01',
                        ],
                        [
                            'user_id' => 3,
                            'title' => 'Certified Data Analysis Specialist',
                            'image' => 'certificate-4.png',
                            'institute_name' => 'Analytics Academy',
                            'issue_date' => '2022-01-01',
                            'expiry_date' => '2025-01-01',
                            'description' => 'Certification for advanced skills in data analysis, including statistical analysis, data visualization, and predictive modeling.',
                            'created_at' => '2022-01-01',
                            'updated_at' => '2024-08-01',
                        ],
                    ],

                    'education' => [
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

                    'address' => [
                        'country_id' => 7,
                        'state_id' => 3,
                        'city' => 'Jomala',
                        'address' => '456 Broadway',
                        'zipcode' => '10012',
                        'lat' => 40.712776,
                        'long' => -74.005974
                    ],
                    'subjects' => [
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
                    'email' => 'antony@gmail.com',
                    'password' => '12345678',
                    'first_name' => 'Antony',
                    'last_name' => 'Clara',
                    'gender' => 'male',
                    'image' => 'tutor-3.jpg',
                    'intro_video' => 'tutor-video-3.mp4',
                    'phone_number' => '07123456789',
                    'tagline' => 'Unlocking Potential Through Customized Academic Guidance',
                    'description' => '<p>Hello! My name is Antony Clara, and I’m a passionate tutor dedicated to helping students unlock their full academic potential. With a strong focus on creating personalized learning experiences, I aim to meet each student\'s unique needs and learning style. I have a diverse background in tutoring, covering subjects such as math, science, and English, and I strive to make every session engaging and effective. I believe that education is more than just mastering content—it’s about building confidence and developing critical thinking skills that will serve students well throughout their lives. My goal is to inspire a love for learning and to help students not only achieve their academic targets but also exceed them.</p>
                                        <p>Throughout my tutoring journey, I’ve had the opportunity to work with a wide range of students, from young learners to those preparing for college. Each student brings a different set of strengths and challenges, and I take pride in adapting my teaching methods to ensure that every student can thrive. My sessions are dynamic and interactive, often incorporating practical examples and real-world applications to make the material more relatable. I understand the pressures and difficulties that students face, and I am here to provide the support and encouragement they need to succeed. My teaching philosophy is rooted in patience, understanding, and a commitment to helping students grow both academically and personally.</p>
                                        <p>In addition to covering specific subjects, I also focus on teaching students essential skills like effective study habits, time management, and test preparation techniques. I believe that these skills are just as important as academic knowledge in helping students navigate their educational paths successfully. I am committed to providing a supportive and motivating environment where students can feel comfortable exploring new ideas and tackling challenges. Whether you need help with a particular subject or are looking for strategies to improve your overall academic performance, I am here to guide you every step of the way. Let’s work together to achieve your educational goals and build a strong foundation for your future success.</p>',
                    'verified_at' => now(),
                    'languages' => [8, 9],
                    'native_language' => 'Bengali',
                    'experience' => [
                        [
                            'title' => 'Educational Program Coordinator',
                            'user_id' => 4,
                            'employment_type' => '2',
                            'company' => 'Vienna International School',
                            'location' => 'hybrid',
                            'country_id' => 8,
                            'city' => 'Vienna',
                            'start_date' => '2010-02-01',
                            'end_date' => '2016-06-30',
                            'description' => 'Coordinated international educational programs, organized student exchanges, and managed partnerships with schools abroad.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Educational Program Coordinator',
                            'user_id' => 4,
                            'employment_type' => '2',
                            'company' => 'Baku University',
                            'location' => 'onsite',
                            'country_id' => 9,
                            'city' => 'Baku',
                            'start_date' => '2017-09-01',
                            'end_date' => '2019-06-30',
                            'description' => 'Taught World and Azerbaijani history to high standards, prepared students for national exams, and organized history-related field trips.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Project Manager - Education Initiatives',
                            'user_id' => 4,
                            'employment_type' => '1',
                            'company' => 'UNESCO',
                            'location' => 'remote',
                            'country_id' => 10,
                            'city' => 'Paris',
                            'start_date' => '2020-01-01',
                            'end_date' => '2023-12-31',
                            'description' => 'Led projects focused on promoting education in underprivileged regions, developed strategies, and coordinated with international teams.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Director of Educational Programs',
                            'user_id' => 4,
                            'employment_type' => '3',
                            'company' => 'Global Education Foundation',
                            'location' => 'hybrid',
                            'country_id' => 11,
                            'city' => 'New York',
                            'start_date' => '2024-01-01',
                            'end_date' => null,
                            'description' => 'Oversee educational programs, manage a global team, and implement innovative strategies for improving access to quality education.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                    ],

                    'certificate' => [
                        [
                            'user_id' => 4,
                            'title' => 'Certified Urdu Language Teacher',
                            'image' => 'certificate-1.png',
                            'institute_name' => 'Pakistani School',
                            'issue_date' => '2011-09-01',
                            'expiry_date' => '2019-09-01',
                            'description' => 'Certification for teaching Urdu language and literature, including poetry, prose, and grammar.',
                            'created_at' => '2011-09-01',
                            'updated_at' => '2019-09-01',
                        ],
                        [
                            'user_id' => 4,
                            'title' => 'Certified General Knowledge Teacher',
                            'image' => 'certificate-2.png',
                            'institute_name' => 'Knowledge Academy',
                            'issue_date' => '2016-01-01',
                            'expiry_date' => '2021-01-01',
                            'description' => 'Certification for teaching general knowledge subjects including history, geography, and current affairs.',
                            'created_at' => '2016-01-01',
                            'updated_at' => '2021-01-01',
                        ],
                        [
                            'user_id' => 4,
                            'title' => 'Certified Science Teacher',
                            'image' => 'certificate-3.png',
                            'institute_name' => 'Modern School',
                            'issue_date' => '2013-09-01',
                            'expiry_date' => '2020-09-01',
                            'description' => 'Certification for teaching general science, including biology, chemistry, and physics.',
                            'created_at' => '2013-09-01',
                            'updated_at' => '2020-09-01',
                        ],
                        [
                            'user_id' => 4,
                            'title' => 'Certified Environmental Science Educator',
                            'image' => 'certificate-4.png',
                            'institute_name' => 'Eco Education Center',
                            'issue_date' => '2022-05-01',
                            'expiry_date' => '2025-05-01',
                            'description' => 'Certification for teaching environmental science, including climate change, ecology, and sustainability.',
                            'created_at' => '2022-05-01',
                            'updated_at' => '2024-08-01',
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

                    'address' => [
                        'country_id' => 3,
                        'state_id' => 1,
                        'city' => 'Berat',
                        'address' => '789 Oxford St',
                        'zipcode' => 'W1D 1BS',
                        'lat' => 51.507351,
                        'long' => -0.127758
                    ],
                    'subjects' => [
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
                        '4' => [
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
                    'email' => 'arianne@gmail.com',
                    'password' => '12345678',
                    'first_name' => 'Arianne',
                    'last_name' => 'Kearns',
                    'gender' => 'female',
                    'image' => 'tutor-4.jpg',
                    'intro_video' => 'tutor-video-4.mp4',
                    'phone_number' => '07123456789',
                    'tagline' => 'Building Confidence Through Personalized Learning Experiences',
                    'description' => '<p>Hi there! I\'m Arianne Kearns, a dedicated tutor with a passion for guiding students toward academic success. My teaching philosophy revolves around the idea that learning should be both engaging and empowering. I aim to create an environment where students feel confident in their abilities and excited to tackle new challenges. With a background in various subjects, including mathematics, science, and English, I offer a well-rounded approach to tutoring that caters to the unique needs of each student. I focus not only on helping students understand the material but also on building the skills they need to think critically and solve problems independently.</p>
                                        <p>Over the years, I’ve had the pleasure of working with students from different age groups and educational backgrounds. I believe that every student learns differently, so I take the time to tailor my lessons to match their individual learning style. Whether it’s through interactive discussions, hands-on exercises, or practical examples, I strive to make each session as effective and enjoyable as possible. My goal is to help students not just improve their grades but also develop a genuine love for learning that will last a lifetime.</p>                    
                                        <p>In addition to subject-specific tutoring, I place a strong emphasis on teaching essential study skills, such as time management, organization, and test preparation strategies. I understand that academic success is about more than just understanding the material—it’s about having the right tools and mindset to approach challenges with confidence. I am committed to helping my students develop these skills, ensuring they are well-equipped to achieve their academic goals and succeed in their future endeavors. Whether you’re looking for support in a particular subject or need guidance in improving your overall academic performance, I am here to help you every step of the way. Together, we can build a strong foundation for your academic journey and beyond.</p>',
                    'verified_at' => now(),
                    'languages' => [6, 7],
                    'native_language' => 'Bengali',
                    'experience' => [
                        [
                            'title' => 'Curriculum Developer',
                            'user_id' => 5,
                            'employment_type' => '2',
                            'company' => 'Bahamas Education Authority',
                            'location' => 'remote',
                            'country_id' => 10,
                            'city' => 'Nassau',
                            'start_date' => '2016-01-01',
                            'end_date' => '2020-12-31',
                            'description' => 'Developed and revised curriculum for primary and secondary schools, incorporating modern teaching methods and technology.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Science Teacher',
                            'user_id' => 5,
                            'employment_type' => '2',
                            'company' => 'Dhaka International School',
                            'location' => 'onsite',
                            'country_id' => 11,
                            'city' => 'Dhaka',
                            'start_date' => '2017-09-01',
                            'end_date' => '2021-06-30',
                            'description' => 'Taught Biology, Chemistry, and Physics to students in grades 6-12, organized science fairs, and mentored students in science Olympiads.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Educational Consultant',
                            'user_id' => 5,
                            'employment_type' => '3',
                            'company' => 'Global Education Consultancy',
                            'location' => 'hybrid',
                            'country_id' => 12,
                            'city' => 'London',
                            'start_date' => '2022-01-01',
                            'end_date' => '2023-12-31',
                            'description' => 'Provided consultancy services for educational institutions, focusing on curriculum development and teacher training.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Director of Science Education',
                            'user_id' => 5,
                            'employment_type' => '1',
                            'company' => 'Asia-Pacific Education Network',
                            'location' => 'remote',
                            'country_id' => 13,
                            'city' => 'Singapore',
                            'start_date' => '2024-01-01',
                            'end_date' => null,
                            'description' => 'Leading initiatives to enhance science education across the Asia-Pacific region, developing new teaching materials, and training educators.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                    ],

                    'certificate' => [
                        [
                            'user_id' => 5,
                            'title' => 'Certified Islamiyat Teacher',
                            'image' => 'certificate-1.png',
                            'institute_name' => 'Islamic School',
                            'issue_date' => '2014-03-01',
                            'expiry_date' => '2021-03-01',
                            'description' => 'Certification for teaching Islamic studies, including Quran, Hadith, Fiqh, and Islamic history.',
                            'created_at' => '2014-03-01',
                            'updated_at' => '2021-03-01',
                        ],
                        [
                            'user_id' => 5,
                            'title' => 'Certified Physics Lecturer',
                            'image' => 'certificate-2.png',
                            'institute_name' => 'Government College',
                            'issue_date' => '2010-09-01',
                            'expiry_date' => '2018-09-01',
                            'description' => 'Certification for teaching physics, including mechanics, electromagnetism, and thermodynamics.',
                            'created_at' => '2010-09-01',
                            'updated_at' => '2018-09-01',
                        ],
                        [
                            'user_id' => 5,
                            'title' => 'Certified Computer Science Instructor',
                            'image' => 'certificate-3.png',
                            'institute_name' => 'National Institute of Computer Science',
                            'issue_date' => '2011-01-01',
                            'expiry_date' => '2017-01-01',
                            'description' => 'Certification for teaching computer science subjects, including programming, data structures, and algorithms.',
                            'created_at' => '2011-01-01',
                            'updated_at' => '2017-01-01',
                        ],
                        [
                            'user_id' => 5,
                            'title' => 'Certified Mathematics Tutor',
                            'image' => 'certificate-4.png',
                            'institute_name' => 'Mathematics Institute',
                            'issue_date' => '2022-08-01',
                            'expiry_date' => '2025-08-01',
                            'description' => 'Certification for tutoring mathematics, including calculus, algebra, and statistics.',
                            'created_at' => '2022-08-01',
                            'updated_at' => '2024-08-01',
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

                    'address' => [
                        'country_id' => 4,
                        'state_id' => 2,
                        'city' => 'Annaba',
                        'address' => '101 George St',
                        'zipcode' => '2000',
                        'lat' => -33.868820,
                        'long' => 151.209296
                    ],
                    'subjects' => [
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
               
               
                
                [ // 16 F
                    'email' => 'alexa@gmail.com',
                    'password' => '12345678',
                    'first_name' => 'Alexa',
                    'last_name' => 'Milan',
                    'gender' => 'male',
                    'image' => 'tutor-15.jpg',
                    'intro_video' => 'tutor-video-6.mp4',
                    'phone_number' => '07123456789',
                    'tagline' => 'Empowering Learning Through Personalized Tutoring Solutions',
                    'description' => '<p>Hi! I am Alexa Milan, a dedicated tutor committed to guiding students toward academic excellence and personal growth. With a broad expertise in various subjects, including mathematics, science, and English, I bring a tailored approach to each tutoring session, ensuring that every student receives the support they need to succeed. My teaching philosophy revolves around creating an engaging and supportive learning environment where students feel empowered to explore new ideas, tackle challenging concepts, and build confidence in their abilities.</p>
                                        <p>Throughout my career, I have worked with students across different educational levels, from elementary school to college, adapting my methods to fit each student’s unique learning style and goals. I employ a variety of teaching techniques, including interactive exercises, real-world applications, and problem-solving activities, to make learning both effective and enjoyable. My focus is not only on improving academic performance but also on fostering a genuine love for learning and critical thinking.</p>
                                        <p>Beyond subject-specific tutoring, I emphasize the importance of developing essential academic skills, such as effective study strategies, time management, and test-taking techniques. These skills are crucial for achieving long-term academic success and personal growth. My goal is to support each student in reaching their full potential and to provide guidance and encouragement throughout their educational journey. Whether you need help with particular subjects or want to enhance your overall academic performance, I am here to assist you every step of the way.</p>',
                    'verified_at' => now(),
                    'languages' => [19, 17],
                    'native_language' => 'Asturian',
                    'experience' => [
                        [
                            'title' => 'Urdu Language Teacher',
                            'user_id' => 11,
                            'employment_type' => '1',
                            'company' => 'Pakistani School',
                            'location' => 'hybrid',
                            'country_id' => 6,
                            'city' => 'Manama',
                            'start_date' => '2011-09-01',
                            'end_date' => '2019-06-30',
                            'description' => 'Taught Urdu language and literature, including poetry, prose, and grammar. Organized literary events and prepared students for language proficiency exams.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Islamiyat Teacher',
                            'user_id' => 11,
                            'employment_type' => '1',
                            'company' => 'Islamic School',
                            'location' => 'hybrid',
                            'country_id' => 2,
                            'city' => 'Riyadh',
                            'start_date' => '2020-03-01',
                            'end_date' => '2023-12-31',
                            'description' => 'Taught Islamic studies including Quran, Hadith, Fiqh, and Islamic history. Organized religious events and mentored students in understanding Islamic principles.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Language Arts Coordinator',
                            'user_id' => 11,
                            'employment_type' => '1',
                            'company' => 'International Language Academy',
                            'location' => 'onsite',
                            'country_id' => 6,
                            'city' => 'Manama',
                            'start_date' => '2008-01-01',
                            'end_date' => '2011-08-31',
                            'description' => 'Coordinated language arts curriculum, supervised language teachers, and organized language-related events and workshops.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                        [
                            'title' => 'Islamic Studies Professor',
                            'user_id' => 11,
                            'employment_type' => '2',
                            'company' => 'Islamic University',
                            'location' => 'remote',
                            'country_id' => 2,
                            'city' => 'Riyadh',
                            'start_date' => '2024-01-01',
                            'end_date' => null,
                            'description' => 'Lectured on advanced Islamic studies topics, supervised research projects, and contributed to academic publications in Islamic studies.',
                            'created_at' => null,
                            'updated_at' => null,
                        ],
                    ],

                    'certificate' => [
                        [
                            'user_id' => 11,
                            'title' => 'Certified Chemistry Educator',
                            'image' => 'certificate-1.png',
                            'institute_name' => 'Chemistry Training Institute',
                            'issue_date' => '2016-11-01',
                            'expiry_date' => '2021-11-01',
                            'description' => 'Certification for teaching chemistry, including laboratory techniques and chemical theory.',
                            'created_at' => '2016-11-01',
                            'updated_at' => '2021-11-01',
                        ],
                        [
                            'user_id' => 11,
                            'title' => 'Certified Web Development Trainer',
                            'image' => 'certificate-2.png',
                            'institute_name' => 'Digital Skills Academy',
                            'issue_date' => '2018-04-01',
                            'expiry_date' => '2023-04-01',
                            'description' => 'Certification for training in web development technologies, including front-end and back-end development.',
                            'created_at' => '2018-04-01',
                            'updated_at' => '2023-04-01',
                        ],
                        [
                            'user_id' => 11,
                            'title' => 'Certified Web Design Specialist',
                            'image' => 'certificate-3.png',
                            'institute_name' => 'Design Excellence Center',
                            'issue_date' => '2019-06-01',
                            'expiry_date' => '2024-06-01',
                            'description' => 'Certification for specialization in web design, focusing on aesthetics, usability, and client communication.',
                            'created_at' => '2019-06-01',
                            'updated_at' => '2024-06-01',
                        ],
                        [
                            'user_id' => 11,
                            'title' => 'Certified Full-Stack Developer',
                            'image' => 'certificate-4.png',
                            'institute_name' => 'Tech Innovators Academy',
                            'issue_date' => '2020-02-01',
                            'expiry_date' => '2025-02-01',
                            'description' => 'Certification for full-stack development skills, including both front-end and back-end technologies.',
                            'created_at' => '2020-02-01',
                            'updated_at' => '2024-08-01',
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
                    'address' => [
                        'country_id' => 10,
                        'state_id' => 3,
                        'city' => 'Liberta',
                        'address' => '707 Marine Drive',
                        'zipcode' => '400002',
                        'lat' => 19.076090,
                        'long' => 72.877426
                    ],
                    'subjects' => [
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

                if (!isDemoSite() && $userData['email'] == 'ava@gmail.com') {
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
                        'first_name' => $userData['first_name'],
                        'last_name' => $userData['last_name'],
                        'gender' => $userData['gender'] ?? null,
                        // 'slug'              => Str::slug($userData['first_name'] . ' ' . $userData['last_name'] . ' ' . $user->id),
                        'tagline' => $userData['tagline'] ?? '',
                        'description' => $userData['description'] ?? '',
                        'intro_video' => !empty($userData['intro_video']) ? 'profile_videos/' . $userData['intro_video'] : null,
                        'phone_number' => $userData['phone_number'] ?? '',
                        'native_language' => $userData['native_language'] ?? null,
                        'verified_at' => $userData['verified_at'] ?? null,
                        'image' => $profileImage
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
                'country_id' => $addressData['country_id'] ?? null,
                'state_id' => $addressData['state_id'] ?? null,
                'city' => $addressData['city'] ?? '',
                'address' => $addressData['address'] ?? '',
                'zipcode' => $addressData['zipcode'] ?? '',
                'lat' => $addressData['lat'] ?? 0,
                'long' => $addressData['long'] ?? 0
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
                    'title' => $experience['title'],
                    'user_id' => $user->id,
                    'employment_type' => $experience['employment_type'],
                    'company' => $experience['company'],
                    'location' => $experience['location'],
                    'country_id' => $experience['country_id'],
                    'city' => $experience['city'],
                    'start_date' => $experience['start_date'],
                    'end_date' => $experience['end_date'],
                    'description' => $experience['description'],
                    'created_at' => $experience['created_at'] ?? null,
                    'updated_at' => $experience['updated_at'] ?? null,
                ]);
            }
        }
    }

    public function seedCertificate($user, $certificateData)
    {
        if (!empty($certificateData)) {
            foreach ($certificateData as $certificate) {
                $user->certificates()->create([
                    'user_id' => $user->id,
                    'title' => $certificate['title'],
                    'image' => $this->storeCertificateImage($certificate),
                    'institute_name' => $certificate['institute_name'],
                    'issue_date' => $certificate['issue_date'],
                    'expiry_date' => $certificate['expiry_date'],
                    'description' => $certificate['description'],
                    'created_at' => $certificate['created_at'] ?? null,
                    'updated_at' => $certificate['updated_at'] ?? null,
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
                        'subject_id' => $subjectData['id']
                    ],
                    [
                        'hour_rate' => $subjectData['hour_rate'] ?? 0,
                        'description' => $subjectData['description'] ?? null,
                        'image' => $subjectImage,
                        'sort_order' => $subjectData['sort_order'] ?? 0
                    ]
                );

                $slotsData = [
                    'subject_group_id' => $userSubject->id,
                    'date_range' => now()->toDateString() . " to " . now()->addMonths(2)->toDateString(),
                    'session_fee' => $subjectData['hour_rate'],
                    'description' => '<strong>Overview</strong><br>
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
