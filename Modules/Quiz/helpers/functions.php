<?php

use Illuminate\Support\Str;
use Modules\Quiz\Models\Question;

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

if (!function_exists('quizMenuOptions')) {
    function quizMenuOptions($role)
    {
        $route = 'quiz.' . auth()->user()->role . '.';
        switch ($role) {
            case 'tutor':
                return [
                    [
                        'tutorSortOrder' => 5,
                        'onActiveRoute' => [
                            $route . 'quizzes',
                            $route . 'create-quiz',
                            $route . 'quiz-settings',
                            $route . 'quiz-details',
                            $route . 'create-question',
                            $route . 'question-manager',
                            $route . 'quiz-attempts',
                        ],
                        'route' => 'quiz.tutor.quizzes',
                        'title' => __('quiz::quiz.manage_quizzes'),
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M13.3332 17.9167V16.5333C13.3332 15.4132 13.3332 14.8531 13.5512 14.4253C13.7429 14.049 14.0489 13.743 14.4252 13.5513C14.853 13.3333 15.4131 13.3333 16.5332 13.3333H17.9165M5.83317 5.83332H12.4998M5.83317 9.16666H10.8332M5.83317 12.5H7.49984M13.0116 18.3333H6.4665C4.78635 18.3333 3.94627 18.3333 3.30453 18.0063C2.74005 17.7187 2.2811 17.2598 1.99348 16.6953C1.6665 16.0536 1.6665 15.2135 1.6665 13.5333V6.46666C1.6665 4.7865 1.6665 3.94642 1.99348 3.30468C2.2811 2.7402 2.74005 2.28126 3.30453 1.99364C3.94627 1.66666 4.78635 1.66666 6.4665 1.66666H13.5332C15.2133 1.66666 16.0534 1.66666 16.6951 1.99364C17.2596 2.28126 17.7186 2.7402 18.0062 3.30468C18.3332 3.94642 18.3332 4.7865 18.3332 6.46666V13.0118C18.3332 13.7455 18.3332 14.1124 18.2503 14.4577C18.1768 14.7638 18.0556 15.0564 17.8911 15.3248C17.7056 15.6276 17.4461 15.887 16.9273 16.4059L16.4057 16.9274C15.8869 17.4463 15.6274 17.7057 15.3247 17.8912C15.0563 18.0557 14.7636 18.1769 14.4575 18.2504C14.1123 18.3333 13.7454 18.3333 13.0116 18.3333Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>',
                        'accessibility' => ['tutor'],
                        'disableNavigate' => true,
                    ]
                ];
                break;
            case 'student':
                return [
                    [
                        'studentSortOrder' => 4,
                        'onActiveRoute' => [
                            $route . 'quizzes',
                            $route . 'quiz-details',
                            $route . 'attempt-quiz',
                            $route . 'quiz-result',

                        ],
                        'route' => 'quiz.student.quizzes',
                        'title' => __('quiz::quiz.my_quizzes'),
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M13.3332 17.9167V16.5333C13.3332 15.4132 13.3332 14.8531 13.5512 14.4253C13.7429 14.049 14.0489 13.743 14.4252 13.5513C14.853 13.3333 15.4131 13.3333 16.5332 13.3333H17.9165M5.83317 5.83332H12.4998M5.83317 9.16666H10.8332M5.83317 12.5H7.49984M13.0116 18.3333H6.4665C4.78635 18.3333 3.94627 18.3333 3.30453 18.0063C2.74005 17.7187 2.2811 17.2598 1.99348 16.6953C1.6665 16.0536 1.6665 15.2135 1.6665 13.5333V6.46666C1.6665 4.7865 1.6665 3.94642 1.99348 3.30468C2.2811 2.7402 2.74005 2.28126 3.30453 1.99364C3.94627 1.66666 4.78635 1.66666 6.4665 1.66666H13.5332C15.2133 1.66666 16.0534 1.66666 16.6951 1.99364C17.2596 2.28126 17.7186 2.7402 18.0062 3.30468C18.3332 3.94642 18.3332 4.7865 18.3332 6.46666V13.0118C18.3332 13.7455 18.3332 14.1124 18.2503 14.4577C18.1768 14.7638 18.0556 15.0564 17.8911 15.3248C17.7056 15.6276 17.4461 15.887 16.9273 16.4059L16.4057 16.9274C15.8869 17.4463 15.6274 17.7057 15.3247 17.8912C15.0563 18.0557 14.7636 18.1769 14.4575 18.2504C14.1123 18.3333 13.7454 18.3333 13.0116 18.3333Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>',
                        'accessibility' => ['student'],
                        'disableNavigate' => true,
                    ]
                ];
                break;
            case 'admin':
                return [
                    //
                ];
                break;
            default:
                return [];
        }
    }

    if (!function_exists('getQuizDuration')) {
        function getDurationString($time)
        {
            if (empty($time) || !is_string($time)) {
                return null;
            }

            list($number, $unit) = explode(":", $time);

            return [
                'time'      => $number,
                'unit'      => $unit,
            ];
        }
    }
}

if (!function_exists('setQuizMedia')) {

    function setQuizMedia($questionMedia = null, $mediaType = null, $allowImgFileExt = null, $allowVideoExt = null)
    {
        $questionMediaPath  = null;
        if (!empty($questionMedia) && $questionMedia instanceof \Illuminate\Http\UploadedFile) {
            $fileExtension = strtolower($questionMedia->getClientOriginalExtension());
            $mediaName = time() . '_' . $questionMedia->getClientOriginalName();
            if (in_array($fileExtension, $allowImgFileExt)) {

                $questionMediaPath = $questionMedia->storeAs('quiz/questions', $mediaName, getStorageDisk());
                $mediaType = 'image';
            } elseif (in_array($fileExtension, $allowVideoExt)) {

                $questionMediaPath = $questionMedia->storeAs('quiz/questions', $mediaName, getStorageDisk());
                $mediaType = 'video';
            }
        } elseif (is_string($questionMedia)) {
            $questionMediaPath = $questionMedia;
        }
        return [
            'type' => $mediaType,
            'path' => $questionMediaPath
        ];
    }
}

if (!function_exists('getSocialClass')) {

    function getSocialClass($platform)
    {
        if ($platform == 'X/Twitter') {
            return 'am-icon-twitter-02';
        }

        return 'am-icon-' . Str::lower($platform);
    }
}

if (!function_exists('getFillInBlanksText')) {

    function getFillInBlanksText($text)
    {
        return Str::replace('[Blank]', '_______', $text);
    }
}

if (!function_exists('getStudentFillInBlanksText')) {

    function getStudentFillInBlanksText($text)
    {
        $blanks = [];
        $textParts = explode('[Blank]', $text);
        foreach ($textParts as $index => $textPart) {
            if ($index > 0) {
                $blanks[] = '<input wire:model.live="blanks.' . ($index - 1) . '" type="text" class="form-control fill-in-blanks" />';
            }
            $blanks[] = $textPart;
        }
        return implode('', $blanks);
    }
}

if (!function_exists('getDurationInSeconds')) {

    function getDurationInSeconds($duration)
    {
        if (empty($duration) || !is_string($duration)) {
            return 0;
        }

        list($hours, $minutes) = explode(':', $duration);
        return ($hours * 3600) + ($minutes * 60);
    }
}

if (!function_exists('getDurationFormatted')) {

    function getDurationFormatted($duration)
    {
        if (empty($duration) || !is_int($duration)) {
            return '00:00:00';
        }
        $seconds = $duration % 60;
        $minutes = floor($duration / 60) % 60;
        $hours = floor($duration / 3600);

        if (!empty($hours)) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}
if (!function_exists('getQuestionTitle')) {

    function getQuestionTitle($question, $answer = null)
    {
        if (empty($question)) {
            return null;
        }

        if ($question->type != Question::TYPE_FILL_IN_BLANKS) {
            return $question->title;
        }

        $attemptedAnswer = $question->attemptedQuestions?->first()?->answer;
        if (!empty($attemptedAnswer)) {
            $answers = explode('|', $attemptedAnswer);
            $options = $question->options->pluck('option_text')->toArray();
            $title = $question->title;
            foreach ($answers as $key => $answer) {
                if (Str::lower(Str::trim($options[$key])) === Str::lower(Str::trim($answer))) {
                    $title = Str::replaceFirst('[Blank]', '<span style="color:green;">' . $answer . '</span>', $title);
                } else {
                    $title = Str::replaceFirst('[Blank]', '<span style="color:red;">' . $answer . '</span>', $title);
                }
            }
            return $title;
        }


        return getFillInBlanksText($question->title);
    }
}
