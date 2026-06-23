<?php

namespace App\Livewire\Pages\Admin\Taxonomy;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use App\Models\Scopes\ActiveScope;
use App\Models\SubjectGroup;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class SubjectGroups extends Component
{
    use WithPagination;

    public $name, $edit_id, $description, $status;
    public $editMode            = false;
    public $search              = '';
    public $sortby              = 'asc';
    public $perPage             = 10;
    public $per_page_opt        = [];
    public $selectedSubjectGroups   = [];
    public $selectAll           = false;
    protected $paginationTheme  = 'bootstrap';

    public function mount(){

        $this->per_page_opt = perPageOpt();
        $per_page_record    = setting('_general.per_page_record');
        $this->perPage     = !empty( $per_page_record ) ? $per_page_record : 10;
    }

    #[Layout('layouts.admin-app')]
    public function render(): View
    {
        $subjectGroups = $this->subjectGroups;

        return view('livewire.pages.admin.taxonomy.subject-groups', compact('subjectGroups'));
    }

    #[On('refresh-list')]
    public function refresh() {}

    #[Computed]
    public function subjectGroups(){
        $subjectGroups = SubjectGroup::withoutGlobalScope(ActiveScope::class);

        if( !empty($this->search) ){
            $subjectGroups = $subjectGroups->where(function($query){
                $query->whereFullText('name', $this->search);
                $query->orWhereFullText('description', $this->search);
            });
        }

        return $subjectGroups->orderBy('name', $this->sortby)->paginate($this->perPage);

    }

    public function updatedPage($page)
    {
        if($this->selectAll){
            $this->selectedSubjectGroups = $this->subjectGroups->pluck('id')->toArray();
        }
    }


    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value){
        if($value){
            $this->selectedSubjectGroups = $this->subjectGroups->pluck('id')->toArray();
        }else{
            $this->selectedSubjectGroups = [];
        }
    }

    public function updatedselectedSubjectGroups()
    {
        $this->selectAll = false;
    }

    private function resetInputfields()
    {
        $this->name                 = null;
        $this->status               = null;
        $this->description          = null;
        $this->selectedSubjectGroups    = [];
        $this->selectAll            = false;
        $this->edit_id              = false;
    }

    public function edit($id)
    {
        $record = SubjectGroup::findOrFail($id);
        $this->edit_id          = $id;
        $this->name             = $record->name;
        $this->description      = $record->description;
        $this->status           = $record->status;
        $this->editMode         = true;
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

        $insertRecord = SubjectGroup::updateOrCreate(['id'=> $this->edit_id],$validated_data);
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: $this->edit_id ? __('taxonomy.updated_msg') : __('taxonomy.added_msg'));
        $this->editMode = false;
        $this->reset();
    }

    #[On('delete-subject-group')]
    public function deleteSubjectGroup($params){

        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        $isDeleteRec = false;
        if(!empty($params['id'])){
            $record         = SubjectGroup::where('id', $params['id'] );
            $isDeleteRec    = $record->delete();

        } elseif(!empty($this->selectedSubjectGroups)){
            $record         = SubjectGroup::whereIn('id', $this->selectedSubjectGroups);
            $isDeleteRec    = $record->delete();

        }

        if($isDeleteRec){
            $this->dispatch(
                'showAlertMessage',
                type: 'success',
                title: __('general.success_title') ,
                message: __('general.delete_record')
            );
        }
        $this->reset();
    }
}
