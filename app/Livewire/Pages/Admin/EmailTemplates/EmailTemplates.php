<?php

namespace App\Livewire\Pages\Admin\EmailTemplates;


use App\Models\EmailTemplate;
use App\Models\Scopes\ActiveScope;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;



class EmailTemplates extends Component
{
    use WithPagination;

    public $email_type                      = '';
    public $delete_id                       = '';
    public $sortby                          = 'desc';
    public $edit_id                         = 0;
    public $search                          = '';
    public $date_format                     = '';
    public $per_page                        = '10';
    public $status                          = 'active';
    public $per_page_opt                    = [];
    public $user_id                         = null;
    public $id                         = null;
    public $selected_template               = [];
    public $template_key                    = '';
    public $validated_fields                = [];
    protected $paginationTheme              = 'bootstrap';
    public $templates = [];
    public $emailTemplates = [];

    protected $listeners = ['deleteConfirmRecord' => 'deleteTemplate'];

    #[Layout('layouts.admin-app')]
    public function render(){
        $exclude_templates          = array();
        $this->emailTemplates = EmailTemplate::select('id','title','type','role','content','status')->withTrashed()->withoutGlobalScope(ActiveScope::class)->get()->toArray();
        foreach ($this->emailTemplates as &$template) {
            $template['content']['info'] = [
                'title' => __('email_template.email_setting_variable'),
                'icon' => 'icon-info',
                'desc' => $template['content']['info'],
            ];
            $template['content']['subject'] = [
                'id' => 'subject',
                'title' => __('email_template.subject'),
                'default' => $template['content']['subject'],
            ];
            $template['content']['greeting'] = [
                'id' => 'greeting',
                'title' => __('email_template.greeting_text'),
                'default' => $template['content']['greeting'],
            ];
            $template['content']['content'] = [
                'id' => 'content',
                'title' =>  __('email_template.email_content'),
                'default' => $template['content']['content'],
            ];
        }
        $listed_templated           = new EmailTemplate;
        if(!empty($this->search) ){
            $listed_templated = $listed_templated->whereFullText('title', $this->search);
        }
        $listed_templated           = $listed_templated->orderBy('id', $this->sortby)->withoutGlobalScope(ActiveScope::class)->paginate( $this->per_page );
        $templates                  = EmailTemplate::select('type', 'role')->withoutGlobalScope(ActiveScope::class)->get();
        if( !empty($templates) ){
            foreach( $templates as $single ){
                $exclude_templates[] =  $single['type'].'-'.$single['role'];
            }
        }
        $this->dispatch('initSelect2', target: '.am-select2' );

        return view('livewire.pages.admin.email-templates.email-templates', compact('listed_templated', 'exclude_templates'));
    }


    public function mount(){
        $this->per_page_opt     = perPageOpt();
        $date_format            = setting('_general.date_format');
        $per_page_record        = setting('_general.per_page_record');
        $this->per_page         = !empty( $per_page_record )   ? $per_page_record : 10;
        $this->date_format      = !empty($date_format)    ? $date_format : 'm d, Y';
    }

    public function updatedSearch(){
        $this->resetPage();
    }


    public function updatedtemplateKey( $id ){
        if( !empty($id) ){
            $this->id = $id;
            $this->selected_template = [];
                $this->selected_template = collect($this->emailTemplates)->where('id',$id)->first();
                foreach( $this->selected_template['content']  as $key => $single ){

                    if( !empty($single['id']) ){
                        $this->validated_fields[$single['id']] =  str_ireplace('<br>', "\r\n", $single['default']);
                    }
                }
                $this->status = $this->selected_template['status'] == 'active' ? true : false;
        }
    }



    #[On('delete-template')]
    public function deleteTemplate( $params = []){
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        if( !empty($params['id']) ){
            $record = EmailTemplate::withoutGlobalScope(ActiveScope::class)->where('id', $params['id']);
            $record->delete();
            $this->edit_id = 0;
            $this->status = 'active';
            $this->selected_template    = [];
            $this->validated_fields     = [];
        }
    }

    public function edit( $id ){

        $this->selected_template = collect($this->emailTemplates)->where('id',$id)->first();
        $this->validated_fields = [];
        $this->edit_id = $id;
        $this->email_type = $this->selected_template['type'];
        foreach($this->selected_template['content'] as $key => &$single){
            if( !empty($single['id'])){
                if(isset($fields[$single['id']]) ){
                    $single['default'] = $fields[$single['id']];
                }
                $this->validated_fields[$single['id']] =  $single['default'];
            }
        }
        $this->status = $this->selected_template['status'] == 'active' ? true : false;
    }

    public function saveEmailTemplate()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        if (!empty($this->validated_fields)) {
            $fields = [];
            foreach ($this->validated_fields as $key => $single) {
                $fields['validated_fields.' . $key] = 'required';
            }
            $this->validate($fields, ['required' => __('general.required_field')]);
            if ($this->edit_id) {
                $template = collect($this->emailTemplates)->where('id',$this->edit_id)->first();
                $data = [
                    'content' => $this->prepareContent($template['content'], $this->validated_fields),
                    'status'  => $this->status ? 'active' :'inactive',
                ];
                EmailTemplate::withoutGlobalScope(ActiveScope::class)->updateOrCreate(['id' => $this->edit_id], $data);
            } else {
                $template = collect($this->emailTemplates)->where('id',$this->id)->first();
                $data = [
                    'status'  => $this->status ? 'active' :'inactive',
                    'content' => $this->prepareContent($template['content'], $this->validated_fields),
                ];
                EmailTemplate::withTrashed()->withoutGlobalScope(ActiveScope::class)->where('id', $this->id)->restore();
                EmailTemplate::withoutGlobalScope(ActiveScope::class)->updateOrCreate(['id' => $this->id], $data);
            }
            $this->edit_id = 0;
            $this->id = null;
            $this->status = 'active';
            $this->selected_template = [];
            $this->validated_fields = [];
        }
    }

    private function prepareContent($content, $validatedFields)
    {
        foreach ($content as $key => &$item) {
            if (isset($item['id']) && isset($validatedFields[$item['id']])) {
                $item['default'] = $validatedFields[$item['id']];
            }
            if ($key === 'info') {
                $item = $item['desc'];
            } else {
                $item = $item['default'];
            }
        }
        return $content;
    }
}
