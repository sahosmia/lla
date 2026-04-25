<?php

namespace Modules\Courses\Livewire\Pages\Course;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Modules\Courses\Models\ClassroomTrainingSubmission;
use Modules\Courses\Services\CourseService;

class ClassroomTrainingSubmissionForm extends Component
{
    public $course_id;
    public $name;
    public $address;
    public $phone;
    public $profession;
    public $organization;
    public $reason;

    public function mount($course_id)
    {
        $this->course_id = $course_id;
        if (Auth::check()) {
            $user = Auth::user();
            $this->name = $user->name; // Pre-fill name if logged in
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'profession' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'reason' => 'required|string',
        ];
    }

    public function submit()
    {
        if (!Auth::check()) {
            $this->dispatch(
                'showAlertMessage',
                type: 'error',
                message: __('courses::courses.login_required')
            );
            return;
        }

        $validatedData = $this->validate();

        $validatedData['course_id'] = $this->course_id;
        $validatedData['user_id'] = Auth::id();

        ClassroomTrainingSubmission::create($validatedData);
        
        // Now enroll the student
        (new CourseService())->addStudentCourse(Auth::id(), $this->course_id);

        // Close the modal and show a success message, then reload the page
        $this->dispatch('showAlertMessage', type: 'success', message: __('courses::courses.application_submitted_successfully'));
        $this->dispatch('close-modal-and-reload');
    }

    public function render()
    {
        return view('courses::livewire.course.classroom-training-submission-form');
    }
}