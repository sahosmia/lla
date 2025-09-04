<?php
if (!isActiveModule('quiz')) {
    return [];
}


$images_size = (int) (setting('_general.max_image_size') ?? '5');

return [
    'section' => [
        'id'     => '_quiz',
        'label'  => __('quiz::quiz.quiz_setting'),
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'enable_ai',
            'type'          => 'switch',
            'class'         => '',
            'label_title'   => __('quiz::quiz.enable_ai'),
            'field_desc'    => __('quiz::quiz.enable_ai_desc'),
            'value'         => '1',
        ],
        [
            'id'            => 'generate_quiz_prompt',
            'type'          => 'textarea',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('quiz::quiz.generate_quiz_prompt'),
            'placeholder'   => __('quiz::quiz.generate_quiz_prompt_desc'),
        ],
        [
            'id'            => 'max_number_of_mcq_questions_by_ai',
            'type'          => 'number',
            'min'           => '0',
            'max'           => '100',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('quiz::quiz.max_number_of_mcqs_questions_by_ai'),
            'placeholder'   => __('quiz::quiz.max_number_of_mcqs_questions_by_ai_desc'),
            'hint'     => [
              'content' => __('quiz::quiz.max_questions_limit_tooltip'),
            ],
        ],
        [
            'id'            => 'max_number_of_true_false_questions_by_ai',
            'type'          => 'number',
            'min'           => '0',
            'max'           => '100',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('quiz::quiz.max_number_of_true_false_questions_by_ai'),
            'placeholder'   => __('quiz::quiz.max_number_of_true_false_questions_by_ai_desc'),
            'hint'     => [
              'content' => __('quiz::quiz.max_questions_limit_tooltip'),
            ],
        ],
        [
            'id'            => 'max_number_of_fill_in_blanks_questions_by_ai',
            'type'          => 'number',
            'min'           => '0',
            'max'           => '100',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('quiz::quiz.max_number_of_fill_in_blanks_questions_by_ai'),
            'placeholder'   => __('quiz::quiz.max_number_of_fill_in_blanks_questions_by_ai_desc'),
            'hint'     => [
              'content' => __('quiz::quiz.max_questions_limit_tooltip'),
            ],
        ],
        [
            'id'            => 'max_number_of_short_answer_questions_by_ai',
            'type'          => 'number',
            'min'           => '0',
            'max'           => '100',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('quiz::quiz.max_number_of_short_questions_by_ai'),
            'placeholder'   => __('quiz::quiz.max_number_of_short_questions_by_ai_desc'),
            'hint'     => [
              'content' => __('quiz::quiz.max_questions_limit_tooltip'),
            ],
        ],
        [
            'id'            => 'max_number_of_open_ended_essay_questions_by_ai',
            'type'          => 'number',
            'min'           => '0',
            'max'           => '100',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('quiz::quiz.max_number_of_open_ended_questions_by_ai'),
            'placeholder'   => __('quiz::quiz.max_number_of_open_ended_questions_by_ai_desc'),
            'hint'     => [
              'content' => __('quiz::quiz.max_questions_limit_tooltip'),
            ],
        ],
        [
            'id'            => 'quiz_start_banner',
            'type'          => 'file',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('quiz::quiz.quiz_start_banner'),
            'max_size'   => $images_size,
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ],
        ],
        [
            'id'            => 'quiz_start_text',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('quiz::quiz.quiz_start_heading'),
            'label_desc'    => __('quiz::quiz.quiz_start_heading_desc'),
            'placeholder'   => __('quiz::quiz.quiz_start_heading_desc'),
        ],
        [
            'id'                => 'quiz_instructions',
            'type'              => 'repeater',
            'label_title'       => __('quiz::quiz.quiz_instructions'),
            'label_desc'        => __('quiz::quiz.add_quiz_instructions'),
            'field'             => [
                'id'            => 'instruction',
                'type'          => 'text',
                'value'         => '',
                'class'         => '',
                'placeholder'   => __('quiz::quiz.quiz_instruction_placeholder'),
            ],
        ],
    
    ]
];
