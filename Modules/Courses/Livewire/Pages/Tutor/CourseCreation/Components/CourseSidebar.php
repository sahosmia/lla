<?php


namespace Modules\Courses\Livewire\Pages\Tutor\CourseCreation\Components;

use Livewire\Component;
use Modules\Courses\Services\CourseService;

class CourseSidebar extends Component {
    public $activeTab;
    public $id;
    public $tabs;
    public $currentTabNumber;

    
    public function mount($tab = '', $id = '', $tabs = []) {
        $this->activeTab        = $tab;
        $this->id               = $id;
        $this->tabs             = $tabs;
        $this->currentTabNumber = array_search($tab, array_keys($tabs));
    }

    public function render() {
        return view('courses::livewire.tutor.course-creation.components.course-sidebar', ['activeTab' => $this->activeTab, 'tabs' => $this->tabs]);
    }

    public function navigateToRoute($tab) {
        if ($tab && $this->id) {
            return redirect()->route('courses.tutor.edit-course', ['id' => $this->id, 'tab' => $tab]);
        }
    }
}
