<?php

namespace Database\Seeders;
use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    protected $version = null;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($version = '1.0')
    {
        $this->version = $version;
        $this->setEmailTemplates();
    }

    public function setEmailTemplates(){

        if ($this->version == '1.0') {
            EmailTemplate::truncate();
        }

        $emailTemplates = $this->getEmailTemplates();
        $template_list  = [];

        foreach ($emailTemplates as $type => $template) {
            foreach ($template['roles'] as $role => $data) {
              
                EmailTemplate::firstOrCreate([
                    'type' => $type,
                    'title' => $template['title'],
                    'role' => $role,
                    'content' => ['info' => $data['fields']['info']['desc'],'subject' => $data['fields']['subject']['default'], 'greeting' => $data['fields']['greeting']['default'], 'content' => $data['fields']['content']['default']]
                ]);
            }
        }
        EmailTemplate::insert($template_list);
    }

    private function getEmailTemplates(){
        if($this->version == '2.1.1') {
            return [
                'welcome' => [ 
                    'version' => '1.0',
                    'title' => __('email_template.welcome_title'),
                    'roles' => [
                        'student' => [
                            'fields' => [
                                'info' => [
                                    'title' => __('email_template.variables_used'),
                                    'icon' => 'icon-info',
                                    'desc' => __('email_template.welcome_student_variables'),
                                ],
                                'subject' => [
                                    'id' => 'subject',
                                    'title' => __('email_template.subject'),
                                    'default' => __('email_template.welcome_student_subject'),
                                ],
                                'greeting' => [
                                    'id' => 'greeting',
                                    'title' => __('email_template.greeting_text'),
                                    'default' => __('email_template.greeting', ['userName' => '{userName}']),
                                ],
                                'content' => [
                                    'id' => 'content',
                                    'title' => __('email_template.email_content'),
                                    'default' => __('email_template.welcome_student_content'),
                                ],
                            ],
                        ],
                        'tutor' => [
                            'fields' => [
                                'info' => [
                                    'title' => __('email_template.variables_used'),
                                    'icon' => 'icon-info',
                                    'desc' => __('email_template.welcome_tutor_variables'),
                                ],
                                'subject' => [
                                    'id' => 'subject',
                                    'title' => __('email_template.subject'),
                                    'default' => __('email_template.welcome_tutor_subject'),
                                ],
                                'greeting' => [
                                    'id' => 'greeting',
                                    'title' => __('email_template.greeting_text'),
                                    'default' => __('email_template.greeting', ['userName' => '{userName}']),
                                ],
                                'content' => [
                                    'id' => 'content',
                                    'title' => __('email_template.email_content'),
                                    'default' => __('email_template.welcome_tutor_content'),
                                ],
                            ],
                        ],
                        'admin' => [
                            'fields' => [
                                'info' => [
                                    'title' => __('email_template.variables_used'),
                                    'icon' => 'icon-info',
                                    'desc' => __('email_template.registration_admin_variables'),
                                ],
                                'subject' => [
                                    'id' => 'subject',
                                    'title' => __('email_template.subject'),
                                    'default' => __('email_template.registration_admin_subject'),
                                ],
                                'greeting' => [
                                    'id' => 'greeting',
                                    'title' => __('email_template.greeting_text'),
                                    'default' => __('email_template.greeting_admin'),
                                ],
                                'content' => [
                                    'id' => 'content',
                                    'title' => __('email_template.email_content'),
                                    'default' => __('email_template.registration_admin_content', ['userName' => '{userName}', 'userEmail' => '{userEmail}']),
                                ],
                            ],
                        ],
                    ],
                ]
            ];
        }
        if ($this->version == '1.11') {
            return [
                'disputeReason' => [
                    'title' => __('email_template.dispute_title'),
                    'roles' => [
                        'admin' => [
                            'fields' => [
                                'info' => [
                                    'title' => __('email_template.variables_used'),
                                    'icon' => 'icon-info',
                                    'desc' => __('email_template.admin_dispute_tutor_variables'),
                                ],
                                'subject' => [
                                    'id' => 'subject',
                                    'title' => __('email_template.subject'),
                                    'default' => __('email_template.admin_dispute_tutor_subject', ['studentName' => '{studentName}', 'tutorName' => '{tutorName}']),
                                ],
                                'greeting' => [
                                    'id' => 'greeting',
                                    'title' => __('email_template.greeting_text'),
                                    'default' => __('email_template.greeting_admin'),
                                ],
                                'content' => [
                                    'id' => 'content',
                                    'title' => __('email_template.email_content'),
                                    'default' => __('email_template.admin_dispute_tutor_content', [
                                        'tutorName' => '{tutorName}',
                                        'studentName' => '{studentName}',
                                        'sessionDateTime' => '{sessionDateTime}',
                                        'disputeReason' => '{disputeReason}'
                                    ]),
                                ],
                            ],
                        ],
                    ],
                ],
                'disputeResolution' => [
                    'title' => __('email_template.dispute_resolution_title'),
                    'roles' => [
                        'student' => [
                            'fields' => [
                                'info' => [
                                    'title' => __('email_template.variables_used'),
                                    'icon' => 'icon-info',
                                    'desc' => __('email_template.dispute_resolve_student_variables'),
                                ],
                                'subject' => [
                                    'id' => 'subject',
                                    'title' => __('email_template.subject'),
                                    'default' => __('email_template.dispute_resolved_student_subject', ['tutorName' => '{tutorName}']),
                                ],
                                'greeting' => [
                                    'id' => 'greeting',
                                    'title' => __('email_template.greeting_text'),
                                    'default' => __('email_template.greeting', ['userName' => '{studentName}']),
                                ],
                                'content' => [
                                    'id' => 'content',
                                    'title' => __('email_template.email_content'),
                                    'default' => __('email_template.dispute_resolved_student_content', [
                                        'studentName' => '{studentName}',
                                        'tutorName' => '{tutorName}',
                                        'disputeReason' => '{disputeReason}',
                                        'refundAmount' => '{refundAmount}',
                                        'sessionDateTime' => '{sessionDateTime}'
                                    ]),
                                ],
                            ],
                        ],
                        'tutor' => [
                            'fields' => [
                                'info' => [
                                    'title' => __('email_template.variables_used'),
                                    'icon' => 'icon-info',
                                    'desc' => __('email_template.dispute_resolve_tutor_variables'),
                                ],
                                'subject' => [
                                    'id' => 'subject',
                                    'title' => __('email_template.subject'),
                                    'default' => __('email_template.dispute_resolved_tutor_subject', ['studentName' => '{studentName}']),
                                ],
                                'greeting' => [
                                    'id' => 'greeting',
                                    'title' => __('email_template.greeting_text'),
                                    'default' => __('email_template.greeting', ['userName' => '{tutorName}']),
                                ],
                                'content' => [
                                    'id' => 'content',
                                    'title' => __('email_template.email_content'),
                                    'default' => __('email_template.dispute_resolved_tutor_content', [
                                        'tutorName' => '{tutorName}',
                                        'studentName' => '{studentName}',
                                        'disputeReason' => '{disputeReason}',
                                        'sessionDateTime' => '{sessionDateTime}',
                                        'paymentAmount' => '{paymentAmount}'
                                    ]),
                                ],
                            ],
                        ],
                    ]
                ]
            ];
        }

       return
        [
            'welcome' => [ 
                'version' => '1.0',
                'title' => __('email_template.welcome_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.welcome_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.welcome_student_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.welcome_student_content'),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.welcome_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.welcome_tutor_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.welcome_tutor_content'),
                            ],
                        ],
                    ],
                    'admin' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.registration_admin_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.registration_admin_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting_admin'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.registration_admin_content', ['userName' => '{userName}', 'userEmail' => '{userEmail}']),
                            ],
                        ],
                    ],
                ],
            ],
            'registration' => [ 
                'version' => '1.0',
                'title' => __('email_template.registration_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.registration_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.registration_student_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.registration_student_content', ['userName' => '{userName}', 'verificationLink' => '{verificationLink}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.registration_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.registration_tutor_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.registration_tutor_content', ['userName' => '{userName}', 'verificationLink' => '{verificationLink}']),
                            ],
                        ],
                    ],
                    'admin' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.registration_admin_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.registration_admin_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting_admin'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.registration_admin_content', ['userName' => '{userName}', 'userEmail' => '{userEmail}']),
                            ],
                        ],
                    ],
                ],
            ],
            'emailVerification' => [ 
                'version' => '1.0',
                'title' => __('email_template.email_verification_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.email_verification_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.email_verification_subject', ['userName' => '{userName}']),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.email_verification_content', ['userName' => '{userName}', 'verificationLink' => '{verificationLink}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.email_verification_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.email_verification_subject', ['userName' => '{userName}']),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.email_verification_content', ['userName' => '{userName}', 'verificationLink' => '{verificationLink}']),
                            ],
                        ],
                    ],
                ],
            ],
            'passwordResetRequest' => [ 
                'version' => '1.0',
                'title' => __('email_template.password_reset_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.password_reset_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.password_reset_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.password_reset_content', ['userName' => '{userName}', 'resetLink' => '{resetLink}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.password_reset_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.password_reset_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.password_reset_content', ['userName' => '{userName}', 'resetLink' => '{resetLink}']),
                            ],
                        ],
                    ],
                ],
            ],
            'identityVerificationRequest' => [ 
                'version' => '1.0',
                'title' => __('email_template.identity_verification_request_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_request_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_request_content'),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_request_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_request_content'),
                            ],
                        ],
                    ],
                    'admin' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_request_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_request_admin_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting_admin'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_request_admin_content'),
                            ],
                        ],
                    ],
                ],
            ],
            'identityVerificationApproved' => [ 
                'version' => '1.0',
                'title' => __('email_template.identity_verification_approved_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_approved_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_approved_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_approved_content', ['userName' => '{userName}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_approved_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_approved_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_approved_content', ['userName' => '{userName}']),
                            ],
                        ],
                    ],
                ],
            ],
            'identityVerificationRejected' => [ 
                'version' => '1.0',
                'title' => __('email_template.identity_verification_rejected_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_rejected_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_rejected_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_rejected_content', ['userName' => '{userName}', 'rejectionReason' => '{rejectionReason}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.identity_verification_rejected_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.identity_verification_rejected_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.identity_verification_rejected_content', ['userName' => '{userName}', 'rejectionReason' => '{rejectionReason}']),
                            ],
                        ],
                    ],
                ],
            ],
            'sessionBooking' => [
                'version' => '1.0',
                'title' => __('email_template.session_booking_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.session_booking_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.session_booking_student_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{studentName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.session_booking_student_content', ['userName' => '{studentName}', 'tutorName' => '{tutorName}', 'sessionSubject' => '{sessionSubject}', 'sessionDate' => '{sessionTime}', 'bookingDetails' => '{bookingDetails}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.session_booking_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.session_booking_tutor_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{tutorName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.session_booking_tutor_content', ['userName' => '{tutorName}', 'studentName' => '{studentName}', 'sessionSubject' => '{sessionSubject}', 'sessionDate' => '{sessionTime}', 'bookingDetails' => '{bookingDetails}']),
                            ],
                        ],
                    ],
                ],
            ],
            'bookingRescheduled' => [//done&tested
                'version' => '1.0',
                'title' => __('email_template.booking_rescheduled_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.booking_rescheduled_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.booking_rescheduled_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.booking_rescheduled_content', ['userName' => '{userName}', 'tutorName' => '{tutorName}', 'newSessionDate' => '{newSessionDate}', 'reason' => '{reason}', 'viewLink' => '{viewLink}']),
                            ],
                        ],
                    ],
                ],
            ],
            'withdrawWalletAmountRequest' => [
                'version' => '1.0',
                'title' => __('email_template.withdraw_wallet_amount_request_title'),
                'roles' => [
                    'admin' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.withdraw_wallet_amount_request_admin_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.withdraw_wallet_amount_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting_admin'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.withdraw_wallet_amount_request_content', ['userName' => '{userName}', 'withdrawAmount' => '{withdrawAmount}']),
                            ],
                        ],
                    ],
                ],
            ],
            'acceptedWithdrawRequest' => [ 
                'version' => '1.0',
                'title' => __('email_template.accepted_withdraw_request_title'),
                'roles' => [
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.accepted_withdraw_request_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.accepted_withdraw_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.accepted_withdraw_request_content', ['userName' => '{userName}', 'withdrawAmount' => '{withdrawAmount}']),
                            ],
                        ],
                    ],
                ],
            ],
            'newMessage' => [ 
                'version' => '1.0',
                'title' => __('email_template.new_message_notification_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.new_message_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.new_message_subject', ['messageSender' => '{messageSender}']),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.new_message_content', ['userName' => '{userName}', 'messageSender' => '{messageSender}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.new_message_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.new_message_subject', ['messageSender' => '{messageSender}']),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.new_message_content', ['userName' => '{userName}', 'messageSender' => '{messageSender}']),
                            ],
                        ],
                    ],
                ],
            ],
            'bookingLinkGenerated' => [ 
                'version' => '1.1',
                'title' => __('email_template.booking_link_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.meeting_link_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.meeting_link_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.meeting_link_content'),
                            ],
                        ],
                    ],
                ]
            ],
            'bookingCompletionRequest' => [ 
                'version' => '1.5',
                'title' => __('email_template.booking_completion_request_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.booking_completion_request_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.booking_completion_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.booking_completion_request_content'),
                            ],
                        ],
                    ],
                ]
            ],
            'sessionRequest' => [ 
                'version' => '1.2',
                'title' => __('email_template.session_request_title'),
                'roles' => [
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.session_request_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.session_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{userName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.session_request_content', ['userName' => '{userName}', 'studentName' => '{studentName}', 'studentEmail' => '{studentEmail}', 'sessionType' => '{sessionType}', 'message' => '{message}']),
                            ],
                        ],
                    ],
                    'admin' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.session_request_admin_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.session_request_subject'),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting_admin'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.session_request_content_admin', ['userName' => '{userName}', 'studentName' => '{studentName}', 'studentEmail' => '{studentEmail}', 'sessionType' => '{sessionType}', 'message' => '{message}']),
                            ],
                        ],
                    ],
                ],
            ],
            'disputeReason' => [
                'title' => __('email_template.dispute_title'),
                'roles' => [
                    'admin' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.admin_dispute_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.admin_dispute_tutor_subject', ['studentName' => '{studentName}', 'tutorName' => '{tutorName}']),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting_admin'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.admin_dispute_tutor_content', [
                                    'tutorName' => '{tutorName}',
                                    'studentName' => '{studentName}',
                                    'sessionDateTime' => '{sessionDateTime}',
                                    'disputeReason' => '{disputeReason}'
                                ]),
                            ],
                        ],
                    ],
                ],
            ],
            'disputeResolution' => [
                'title' => __('email_template.dispute_resolution_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.dispute_resolve_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.dispute_resolved_student_subject', ['tutorName' => '{tutorName}']),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{studentName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.dispute_resolved_student_content', [
                                    'studentName' => '{studentName}', 
                                    'tutorName' => '{tutorName}', 
                                    'disputeReason' => '{disputeReason}',
                                    'refundAmount' => '{refundAmount}', 
                                    'sessionDateTime' => '{sessionDateTime}'
                                ]),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('email_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('email_template.dispute_resolve_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('email_template.subject'),
                                'default' => __('email_template.dispute_resolved_tutor_subject', ['studentName' => '{studentName}']),
                            ],
                            'greeting' => [
                                'id' => 'greeting',
                                'title' => __('email_template.greeting_text'),
                                'default' => __('email_template.greeting', ['userName' => '{tutorName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('email_template.email_content'),
                                'default' => __('email_template.dispute_resolved_tutor_content', [
                                    'tutorName' => '{tutorName}', 
                                    'studentName' => '{studentName}', 
                                    'disputeReason' => '{disputeReason}',
                                    'sessionDateTime' => '{sessionDateTime}', 
                                    'paymentAmount' => '{paymentAmount}'
                                ]),
                            ],
                        ],
                    ],
                ]    
            ],
        ];
    }
}
