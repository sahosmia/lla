<?php


namespace Modules\Courses\Livewire\Pages\Tutor\CourseCreation;

use Modules\Courses\Models\Pricing;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateCourse extends Component
{
    public $tab;
    public $id;
    public $course;
    public $categories;
    public $tabs;

    public function mount($tab = 'details', $id = null)
    {
        $this->tab = $tab;
        $this->id = $id;
        $pricing = Pricing::whereCourseId($this->id)->first();
        $tabList = [
            'details' => [
                'title' => __('courses::courses.basic_details'),
                'icon' => '',
                'enable' => true,
                'required' => true
            ], 
            'media' => [
                'title' => __('courses::courses.media'),
                'icon' => 'am-icon-dashbard',
                'enable' => true,
                'required' => true
            ],
            'pricing' => [
                'title' => __('courses::courses.pricing'),
                'icon' => 'am-icon-dollar',
                'enable' => isPaidSystem(),
                'required' => true
            ], 
            'content' => [
                'title' => __('courses::courses.course_content'),
                'icon' => 'am-icon-list-01',
                'enable' => true,
                'required' => true
            ], 
            'faqs' => [
                'title' => __('courses::courses.prerequisites_and_faqs'),
                'icon' => 'am-icon-copy-01',
                'enable' => true,
                'required' => false
            ],
            'promotions' =>  [
                'title' => __('courses::courses.promotions'),
                'icon' => 'am-icon-tag-02',
                'enable' =>  !empty($pricing?->final_price) && $pricing?->final_price > 0 && \Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal'),
                'required' => false
            ],
            'noticeboard' => [
                'title' => __('courses::courses.noticeboard'),
                'icon' => 'am-icon-megaphone-01',
                'enable' => true,
                'required' => false
            ],
            'discussion-forum' => [
                'title' => __('courses::courses.discussion_forum'),
                'icon' => 'am-icon-chat-03',
                'enable' => \Nwidart\Modules\Facades\Module::has('forumwise') && \Nwidart\Modules\Facades\Module::isEnabled('forumwise'),
                'required' => false
            ],
            'publish' => [
                'title' => __('courses::courses.finish'),
                'icon' => 'am-icon-check-circle03',
                'enable' => true,
                'required' => false
            ]
        ];

        $step = 1;
        $this->tabs = array_map(function($tab) use (&$step) {
            if ($tab['enable']) {
                $tab['step'] = $step++;
            }
            return $tab;
        }, array_filter($tabList, fn($tab) => $tab['enable']));

        if (!array_key_exists($tab, $this->tabs)) {
            abort(404);
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('courses::livewire.tutor.course-creation.create-course', [
            'tab' => $this->tab,
            'id' => $this->id,
        ]);
    }
}
