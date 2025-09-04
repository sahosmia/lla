<?php

namespace App\Livewire\Pages\Admin\ManageAdminUsers;

use App\Livewire\Forms\Admin\ManageAdmin\AdminUserForm;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ManageAdminUsers extends Component
{
    use WithPagination;

    public      AdminUserForm $form;
    public      $editMode           = false;
    public      $search             = '';
    public      $permissions       = [];
    public      $sortby             = 'desc';
    public      $selectedUsers      = [];
    public      $per_page_opt       = [];
    public      $roles;
    public      $role;
    public      $isEdit             = '';
    public      $user_id            = '';
    public      $per_page                        = '';
    public      $filterUser                      = '';


    #[Layout('layouts.admin-app')]
    public function render()
    {
        if ($this->getErrorBag()->any()) {
            $this->dispatch('loadPageJs');
        }
        $this->role =  request()->role;
        $users = User::select('id', 'email', 'created_at', 'status', 'email_verified_at',)
        ->with(
            [
                'roles',
                'identityVerification' => function ($query) {
                    $query->select('id', 'user_id', 'parent_verified_at');
                }
            ]
        )
        ->whereHas('roles', function ($query) {
            $query->where('name', 'sub_admin');
        })
        ->withWhereHas('profile', function ($query) {
            $query->select('id', 'user_id', 'first_name', 'last_name', 'slug', 'image', 'recommend_tutor', 'verified_at');
        });
    
        if (!empty($this->filterUser)) {
            $users = $this->filterUser === 'active' ? $users->active() : $users->inactive();
        }

        if (!empty($this->search)) {
            $users = $users->whereHas('profile', function ($query) {
                $query->where(function ($sub_query) {
                    $sub_query->where('first_name', 'like', '%' . $this->search . '%');
                    $sub_query->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            });
        }
        $users = $users->orderBy('id', $this->sortby)->paginate(setting('_general.per_page_opt') ?? 10);
        return view('livewire.pages.admin.manage-admin-users.manage-admin-users', compact('users'));
    }

    public function mount()
    {
        $protected_permissions = [
            'can-manage-admin-users', 
            'can-manage-upgrade',
            'can-manage-addons',
        ];

        $this->permissions = Permission::whereNotIn('name', $protected_permissions)
        ->get(['id', 'name'])?->pluck('name', 'id')?->toArray();

        $this->dispatch('initSelect2', target: '.am-select2');
    
        
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'filterUser', 'sortby'])) {
            $this->resetPage();
        }
    }

    public function loadData()
    {
        $this->dispatch('loadPageJs');
    }
    
    private function resetInputfields()
    {

        $this->form->first_name       = '';
        $this->form->last_name        = '';
        $this->form->email            = '';
        $this->form->password         = '';
    }

    #[On('update-status')]
    public function updateStatus($params = [])
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        if (!empty($params['id'])) {
            $adminExists = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->where('id', $params['id'])->exists();

            if ($adminExists) {
                $this->dispatch('showAlertMessage', type: 'error', title: __('admin/general.error_title'), message: __('admin/general.not_allowed'));
                return;
            } else {
                $status = $params['type'] == 'active' ? 'inactive' : 'active';
                $user = User::find($params['id']);
                $user->status = $status;
                $user->save();
                $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title'), message: __('settings.status_updated_record'));
            }
        }
    }

    public function openModel(){
        $this->dispatch('initSelect2', target: '.am-select2');

        $this->resetErrorBag();
        $this->form->adminId = '';
        $this->form->permissions = []; 
        $this->resetInputfields();
        $this->dispatch('toggleModel', id:'tb-add-user', action:'show');
    }

    public function editAdminUser($id){
        $this->dispatch('initSelect2', target: '.am-select2');
        $this->resetErrorBag(); 
        $user = User::find($id)->load(['profile']);
        $this->form->adminId          = $id;
        $this->form->first_name       = $user->profile->first_name;
        $this->form->last_name        = $user->profile->last_name;
        $this->form->email            = $user->email;
        $this->form->permissions      = $user->permissions->pluck('id')->toArray();
        $this->dispatch('toggleModel', id:'tb-add-user', action:'show');

    }

    #[On('delete-user')]
    public function deleteUser($params = [])
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        if (!empty($params['id'])) {
            $user = User::find($params['id']);
            if ($user) {
                $profile = $user->profile;
                $profile->forceDelete();
                $user->delete();
                $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title'), message: __('admin/general.delete_record'));
            }
        }
    }

    public function addUser()
    {
        $this->form->updateInfo();
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        $date = now();
        
        $permissions = $this->form->permissions;
        $userData = [
            'email'             => sanitizeTextField($this->form->email),
            'email_verified_at' => $date,
        ];
        if(empty($this->form->adminId)) {
            $userData['password'] = Hash::make($this->form->password);
        }
        $user = User::updateOrCreate(
            [
                'id' => $this->form->adminId
            ],
            $userData
        );
        $user->assignRole('sub_admin');
        $user->permissions()->sync($permissions);

        $first_name    = $this->form->first_name;
        $last_name     = $this->form->last_name;
        $slug          = $first_name . ' ' . $last_name;

        $profile = Profile::updateOrCreate([
            'user_id' => $user->id,
        ],[
            'first_name'    => sanitizeTextField($first_name),
            'last_name'     => sanitizeTextField($last_name),
            'slug'          => sanitizeTextField($slug),
            'user_id'       => $user->id,
        ]);
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title'), message: __('settings.updated_record'));
        $this->dispatch('toggleModel', id: 'tb-add-user', action: 'hide');
        $this->resetInputfields();
    }
}
