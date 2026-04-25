<?php

namespace Modules\Quiz\Database\Seeders;

use App\Models\EmailTemplate;
use App\Models\NotificationTemplate;
use Illuminate\Database\Seeder;
use Larabuild\Optionbuilder\Facades\Settings;

class QuizDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->setEmailTemplates();
        $this->seedSettings();
    }

    
    private function seedSettings()
    {
        $settings = [
            '_quiz' => [
                'enable_ai'             => '1',
                'generate_quiz_prompt'  => 
                <<<TEXT
                    Generate a quiz based on the following input. Return the response as a valid json.

                    **Input**: 
                    1. Subject/Course: "{quizzable_title}" 
                    2. Quiz Summary: "{quiz_brief}" 
                    3. Question Breakdown: "{question_types}"

                    **Output**: 
                    - "title": string (Quiz title) 
                    - "description": string (Quiz description) 
                    - "questions": array of:
                    - "type": string (please use only these types mcq/true_false/fill_in_blanks/short_answer/open_ended_essay) 
                    - "question_title": string (The question text, remember for fill_in_blanks use [Blank] instead of _______) 
                    - "question_description": string (The question short description) 
                    - "options": array (for MCQs, e.g., {"A": "...", "B": "...", "C": "...", "D": "..."}) 
                    - "correct_answer": string (Answer text or key) not applicable for short answers & open ended/essay questions
                    - "explanation": string (Explanation for correct answers)
                    - "character_limit": integer value only incase of short answers & open ended/essay questions
                TEXT,
                'max_number_of_mcq_questions_by_ai'              => '5',
                'max_number_of_true_false_questions_by_ai'       => '5',
                'max_number_of_fill_in_blanks_questions_by_ai'   => '5',
                'max_number_of_short_answer_questions_by_ai'     => '5',
                'max_number_of_open_ended_essay_questions_by_ai' => '5',
                'quiz_start_banner' => [uploadObMedia('modules/quiz/demo-content/quiz-detail-bg.png')],
                'quiz_start_text' => 'You\'re About to Start Your Quiz',
                'quiz_instructions' => [
                    ['instruction' => 'Do not close or reload the page during the quiz.'],
                    ['instruction' => 'Ensure your internet connection is stable throughout the quiz.'],
                    ['instruction' => 'Unanswered questions will be marked as incorrect if not attempted before the time expires.'],
                    ['instruction' => 'The quiz will be automatically submitted when you attempt the last question.'],
                    ['instruction' => 'If an answer is required for a question, you will not be able to move to the next question until you provide an answer.'],
                    ['instruction' => 'Do not navigate away from the quiz page while taking it.'],
                    ['instruction' => 'If you encounter any technical issues, contact support immediately.'],
                    ['instruction' => 'Submit the quiz before the time limit expires.']
                ]
            ]
        ];

        foreach ($settings as $section => $values) {
            foreach($values as $key => $value) {
                Settings::set($section, $key, $value);
            }
        }
    }

    private function setEmailTemplates()
    {

        $emailTemplates = $this->getEmailTemplates();
        $notificationTemplates = $this->getNotificationTemplates();

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

        foreach ($notificationTemplates as $type => $template) {

            foreach (!empty($template['roles']) ? $template['roles'] : [] as $role => $data) {
                NotificationTemplate::updateOrCreate([
                    'type' => $type,
                    'title' => $template['title'],
                    'role' => $role,
                    'content' => ['info' => $data['fields']['info']['desc'], 'subject' => $data['fields']['subject']['default'], 'content' => $data['fields']['content']['default']]
                ]);
            }
        }
        
    }

    private function getEmailTemplates()
    {  
        EmailTemplate::whereIn('type', ['assignedQuiz', 'reviewedQuiz', 'generateQuizResult'])->forceDelete();
        return [
            'assignedQuiz' => [
                'version' => '1.0',
                'title' => __('quiz::quiz.assigned_quiz_notify'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('quiz::quiz.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('quiz::quiz.quiz_assigned_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('quiz::quiz.subject'),
                                'default' => __('quiz::quiz.quiz_assigned_email_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('quiz::quiz.greeting_text'),
                                'default' => __('quiz::quiz.quiz_assigned_email_greeting', ['studentName' => '{studentName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('quiz::quiz.email_content'),
                                'default' => __('quiz::quiz.quiz_assigned_email_content', [
                                    'studentName' => '{studentName}', 
                                    'tutorName' => '{tutorName}', 
                                    'quizName' => '{quizName}'
                                ]),
                            ],
                        ],
                    ],
                ],
            ],
            'reviewedQuiz' => [
                'version' => '1.0',
                'title' => __('quiz::quiz.reviewed_quiz_notify'),
                'roles' => [
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('quiz::quiz.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('quiz::quiz.quiz_in_review_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('quiz::quiz.subject'),
                                'default' => __('quiz::quiz.quiz_in_review_email_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('quiz::quiz.greeting_text'),
                                'default' => __('quiz::quiz.quiz_in_review_email_greeting', ['tutorName' => '{tutorName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('quiz::quiz.email_content'),
                                'default' => __('quiz::quiz.quiz_in_review_email_content', [
                                   'studentName' => '{studentName}',
                                    'tutorName' => '{tutorName}',
                                    'quizName' => '{quizName}',
                                ]),
                            ],
                        ],
                    ],
                ],
            ],
            'generateQuizResult' => [
                'version' => '1.0',
                'title' => __('quiz::quiz.quiz_result'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('quiz::quiz.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('quiz::quiz.quiz_result_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('quiz::quiz.subject'),
                                'default' => __('quiz::quiz.quiz_result_email_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('quiz::quiz.greeting_text'),
                                'default' => __('quiz::quiz.quiz_result_email_greeting', ['studentName' => '{studentName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('quiz::quiz.email_content'),
                                'default' => __('quiz::quiz.quiz_result_email_content', [
                                    'tutorName' => '{tutorName}',
                                    'quizName' => '{quizName}', 
                                ]),
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    private function getNotificationTemplates()
    {  
        NotificationTemplate::whereIn('type', ['assignedQuiz', 'reviewedQuiz', 'generateQuizResult'])->forceDelete();
        return [
            'assignedQuiz' => [
                'version' => '1.0',
                'title' => __('quiz::quiz.assigned_quiz_notify'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('quiz::quiz.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('quiz::quiz.assigned_quiz_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('quiz::quiz.subject'),
                                'default' => __('quiz::quiz.assigned_quiz_notify'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('quiz::quiz.greeting_text'),
                                'default' => __('quiz::quiz.assigned_email_greeting', ['studentName' => '{studentName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('quiz::quiz.email_content'),
                                'default' => __('quiz::quiz.assigned_quiz_link_text', [
                                    'studentName' => '{studentName}', 
                                    'tutorName' => '{tutorName}', 
                                    'quizName' => '{quizName}',
                                    'assignedQuizUrl' => '{assignedQuizUrl}'
                                ]),
                            ],
                        ],
                    ],
                ],
            ],
            'reviewedQuiz' => [
                'version' => '1.0',
                'title' => __('quiz::quiz.reviewed_quiz_notify'),
                'roles' => [
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('quiz::quiz.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('quiz::quiz.reviewed_quiz_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('quiz::quiz.subject'),
                                'default' => __('quiz::quiz.reviewed_quiz_notify'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('quiz::quiz.greeting_text'),
                                'default' => __('quiz::quiz.reviewed_quiz_email_greeting', ['tutorName' => '{tutorName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('quiz::quiz.email_content'),
                                'default' => __('quiz::quiz.reviewed_quiz_result_link_text', [
                                   'studentName' => '{studentName}',
                                    'tutorName' => '{tutorName}',
                                    'quizName' => '{quizName}',
                                ]),
                            ],
                        ],
                    ],
                ],
            ],
            'generateQuizResult' => [
                'version' => '1.0',
                'title' => __('quiz::quiz.quiz_result'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('quiz::quiz.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('quiz::quiz.quiz_result_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('quiz::quiz.subject'),
                                'default' => __('quiz::quiz.quiz_result_notify'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('quiz::quiz.greeting_text'),
                                'default' => __('quiz::quiz.quiz_result_variables', ['studentName' => '{studentName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('quiz::quiz.email_content'),
                                'default' => __('quiz::quiz.quiz_result_link_text', [
                                    'tutorName' => '{tutorName}',
                                    'quizName' => '{quizName}', 
                                    'quizResultUrl' => '{quizResultUrl}'
                                ]),
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

}