<?php

namespace Modules\Courses\Livewire\Components\DiscussionForum;

use Illuminate\Support\Facades\Auth;
use Modules\Courses\Services\CourseService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class DiscussionForum extends Component
{
    use WithPagination;

    public $topicId;
    public $parentId = null;
    public $description;

    public function mount($topicId = null)
    {
        $this->topicId = $topicId;
        if(!\Nwidart\Modules\Facades\Module::has('forumwise') || !\Nwidart\Modules\Facades\Module::isEnabled('forumwise')){
            return abort(404);
        }
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $comments = (new CourseService())->getCommentsByCourseId($this->topicId);
        return view('courses::livewire.discussion-forum.discussion-forum', compact('comments'));
    }

    public function addComment()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $this->validate([
            'description' => 'required',
        ]);

        $isCreated = (new CourseService())->addCommentToForum([
            'course_id' => $this->topicId,
            'parent_id' => $this->parentId,
            'description' => $this->description,
            'created_by' => Auth::user()->id,
        ]);
        
        if($isCreated) {
            $this->dispatch('commentAdded');
        }
        $this->reset('description', 'parentId');
    }

    public function likeComment($commentId)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        (new CourseService())->updateLikeComment($commentId);
    }
}
