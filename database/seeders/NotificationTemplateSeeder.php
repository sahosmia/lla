<?php

namespace Database\Seeders;
use App\Models\NotificationTemplate;
use Illuminate\Database\Seeder;

class NotificationTemplateSeeder extends Seeder
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
            NotificationTemplate::truncate();
        }

        $emailTemplates = $this->getEmailTemplates();
        $template_list  = [];

        foreach ($emailTemplates as $type => $template) {
            foreach ($template['roles'] as $role => $data) {
                NotificationTemplate::firstOrCreate([
                    'type' => $type,
                    'title' => $template['title'],
                    'role' => $role,
                    'content' => ['info' => $data['fields']['info']['desc'],'subject' => $data['fields']['subject']['default'], 'content' => $data['fields']['content']['default']]
                ]);
            }
        }
        NotificationTemplate::insert($template_list);
    }

    private function getEmailTemplates(){

       return
        [
            'identityVerificationApproved' => [
                'version' => '2.1.6',
                'title' => __('notification_template.identity_verification_approved_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.identity_verification_approved_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.identity_verification_approved_subject'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.identity_verification_approved_content', ['userName' => '{userName}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.identity_verification_approved_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.identity_verification_approved_subject'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.identity_verification_approved_content', ['userName' => '{userName}']),
                            ],
                        ],
                    ],
                ],
            ],
            'identityVerificationRejected' => [ 
                'version' => '2.1.6',
                'title' => __('notification_template.identity_verification_rejected_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.identity_verification_rejected_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.identity_verification_rejected_subject'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.identity_verification_rejected_content', ['userName' => '{userName}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.identity_verification_rejected_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.identity_verification_rejected_subject'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.identity_verification_rejected_content', ['userName' => '{userName}']),
                            ],
                        ],
                    ],
                ],
            ],
            'sessionBooking' => [
                'version' => '2.1.6',
                'title' => __('notification_template.session_booking_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.session_booking_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.session_booking_student_subject'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.session_booking_student_content', ['bookingLink' => '{bookingLink}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.session_booking_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.session_booking_tutor_subject'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.session_booking_tutor_content', ['bookingLink' => '{bookingLink}']),
                            ],
                        ],
                    ],
                ],
            ],
            'bookingRescheduled' => [
                'version' => '2.1.6',
                'title' => __('notification_template.booking_rescheduled_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.booking_rescheduled_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.booking_rescheduled_subject'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.booking_rescheduled_content', ['tutorName' => '{tutorName}', 'newSessionDate' => '{newSessionDate}', 'reason' => '{reason}', 'viewLink' => '{viewLink}']),
                            ],
                        ],
                    ],
                ],
            ],
            'acceptedWithdrawRequest' => [ 
                'version' => '2.1.6',
                'title' => __('notification_template.accepted_withdraw_request_title'),
                'roles' => [
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.accepted_withdraw_request_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.accepted_withdraw_request_subject'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.accepted_withdraw_request_content', ['withdrawAmount' => '{withdrawAmount}']),
                            ],
                        ],
                    ],
                ],
            ],
            'newMessage' => [ 
                'version' => '2.1.6',
                'title' => __('notification_template.new_message_notification_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.new_message_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.new_message_subject', ['messageSender' => '{messageSender}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.new_message_content', ['messageSender' => '{messageSender}']),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.new_message_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.new_message_subject', ['messageSender' => '{messageSender}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.new_message_content', ['messageSender' => '{messageSender}']),
                            ],
                        ],
                    ],
                ],
            ],
            'bookingLinkGenerated' => [
                'version' => '2.1.6',
                'title' => __('notification_template.booking_link_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.meeting_link_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.meeting_link_subject'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.meeting_link_content', ['tutorName' => '{tutorName}', 'sessionSubject' => '{sessionSubject}', 'sessionDate' => '{sessionDate}', 'meetingLink' => '{meetingLink}']),
                            ],
                        ],
                    ],
                ]
            ],
            'bookingCompletionRequest' => [ 
                'version' => '2.1.6',
                'title' => __('notification_template.booking_completion_request_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.booking_completion_request_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.booking_completion_request_subject'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.booking_completion_request_content', ['tutorName' => '{tutorName}', 'sessionDateTime' => '{sessionDateTime}', 'days' => '{days}', 'completeBookingLink' => '{completeBookingLink}']),
                            ],
                        ],
                    ],
                ]
            ],
            'sessionRequest' => [ 
                'version' => '2.1.6',
                'title' => __('notification_template.session_request_title'),
                'roles' => [
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.session_request_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.session_request_subject'),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.session_request_content', ['studentName' => '{studentName}', 'studentEmail' => '{studentEmail}', 'sessionType' => '{sessionType}', 'message' => '{message}']),
                            ],
                        ],
                    ]
                ],
            ],
            'disputeResolution' => [
                'title' => __('notification_template.dispute_resolution_title'),
                'roles' => [
                    'student' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.dispute_resolve_student_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.dispute_resolved_student_subject', ['tutorName' => '{tutorName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.dispute_resolved_student_content', [
                                    'tutorName' => '{tutorName}', 
                                    'refundAmount' => '{refundAmount}', 
                                ]),
                            ],
                        ],
                    ],
                    'tutor' => [
                        'fields' => [
                            'info' => [
                                'title' => __('notification_template.variables_used'),
                                'icon' => 'icon-info',
                                'desc' => __('notification_template.dispute_resolve_tutor_variables'),
                            ],
                            'subject' => [
                                'id' => 'subject',
                                'title' => __('notification_template.subject'),
                                'default' => __('notification_template.dispute_resolved_tutor_subject', ['studentName' => '{studentName}']),
                            ],
                            'content' => [
                                'id' => 'content',
                                'title' => __('notification_template.email_content'),
                                'default' => __('notification_template.dispute_resolved_tutor_content', [
                                    'studentName' => '{studentName}', 
                                ]),
                            ],
                        ],
                    ],
                ]    
            ]
        ];
    }
}
