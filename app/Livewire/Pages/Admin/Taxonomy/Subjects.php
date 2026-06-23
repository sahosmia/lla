<?php

namespace App\Livewire\Pages\Admin\Taxonomy;

use App\Models\Scopes\ActiveScope;
use App\Models\Subject;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Subjects extends Component
{

    use WithPagination;

    public $name, $edit_id, $description, $status;
    public $editMode            = false;
    public $search              = '';
    public $sortby              = 'asc';
    public $perPage             = 10;
    public $per_page_opt        = [];
    public $selectedSubjects    = [];
    public $selectAll           = false;
    protected $paginationTheme  = 'bootstrap';

    public function mount(){

        $this->per_page_opt = perPageOpt();
        $per_page_record    = setting('_general.per_page_record');
        $this->perPage      = !empty( $per_page_record ) ? $per_page_record : 10;
    }

    #[Layout('layouts.admin-app')]
    public function render(): View
    {
        $subjects = $this->subjects;

        return view('livewire.pages.admin.taxonomy.subjects', compact('subjects'));
    }

    #[On('refresh-list')]
    public function refresh() {}

    #[Computed]
    public function subjects(){
        $subjects = Subject::withoutGlobalScope(ActiveScope::class);

        if( !empty($this->search) ){
            $subjects = $subjects->where(function($query){
                $query->whereFullText('name', $this->search);
                $query->orWhereFullText('description', $this->search);
            });
        }

        return $subjects->orderBy('name', $this->sortby)->paginate($this->perPage);

    }

    public function updatedPage($page)
    {
        if($this->selectAll){
            $this->selectedSubjects = $this->subjects->pluck('id')->toArray();
        }
    }


    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value){
        if($value){
            $this->selectedSubjects = $this->subjects->pluck('id')->toArray();
        }else{
            $this->selectedSubjects = [];
        }
    }

    public function updatedSelectedSubjects()
    {
        $this->selectAll = false;
    }

    private function resetInputfields()
    {
        $this->name                 = null;
        $this->status               = null;
        $this->description          = null;
        $this->selectedSubjects    = [];
        $this->selectAll            = false;
        $this->edit_id              = false;
    }

    public function edit($id)
    {
        $record = Subject::findOrFail($id);
        $this->edit_id          = $id;
        $this->name             = $record->name;
        $this->description      = $record->description;
        $this->status           = $record->status;
        $this->editMode         = true;
    }

    public function updateStatus($isChecked)
    {
        $this->status = $isChecked ? 'active' : 'inactive';
    }

    public function update(){

        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        
        $validated_data = $this->validate([
            'name'      => 'required|min:3',
        ]);

        $validated_data['name'] = sanitizeTextField($this->name);
        $validated_data['description']  = sanitizeTextField($this->description, true);

        if( !is_null($this->status) && in_array( $this->status, ['active', 'deactive'])){
            $validated_data['status']       = $this->status;
        }

        $insertRecord = Subject::updateOrCreate(['id'=> $this->edit_id],$validated_data);
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: $this->edit_id ? __('taxonomy.updated_msg') : __('taxonomy.added_msg'));
        $this->editMode = false;
        $this->reset();
    }

    #[On('delete-subject')]
    public function deleteLanguage($params){

        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        $isDeleteRec = false;
        $subjectId  = $params['id'] ?? null;
        if ($subjectId) {
            $subject = Subject::whereId($subjectId)->with(['subjectGroups' => function ($query) {
                $query->with('slots');
            }])->first();
            if ($subject && $subject->subjectGroups()->whereHas('slots')->exists()) {
                $this->dispatch('showAlertMessage', type: 'error', message: __('general.unable_to_delete_subject'));
                return;
            }
            $isDeleteRec = $subject ? $subject->delete() : false;
        } elseif (!empty($this->selectedSubjects)) {
            $subjects = Subject::whereIn('id', $this->selectedSubjects)->get();
            foreach ($subjects as $subject) {
                if ($subject->subjectGroups()->whereHas('slots')->exists()) {
                    $this->dispatch('showAlertMessage', type: 'error', message: __('general.unable_to_delete_subject'));
                    return;
                }
            }
            $isDeleteRec = Subject::whereIn('id', $this->selectedSubjects)->delete();
        }
        if ($isDeleteRec) {
            $this->dispatch(
                'showAlertMessage',
                type: 'success',
                title: __('general.success_title'),
                message: __('general.delete_record')
            );
        } else {
            $this->dispatch('showAlertMessage', type: 'error', message: __('general.unable_to_delete_subject'));
        }
        $this->reset();
    }
}
