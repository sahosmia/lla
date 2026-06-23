<?php

namespace App\Livewire\Pages\Admin\Packages;

use App\Models\Addon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Nwidart\Modules\Facades\Module;

class InstalledPackages extends Component
{
    use WithPagination;

    public $filters = ['sortby' => 'asc', 'per_page' => 10, 'name' => ''];
    public $coreModules = ['LaraPayease', 'MeetFusion'];

    public function mount()
    {
        $this->filters['per_page'] = setting('_general.per_page_record') ?? 10;
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $packages = $this->filterPackages();
        return view('livewire.pages.admin.packages.installed-packages', compact('packages'));
    }

    public function filterPackages()
    {
        $packages = Addon::select('name','slug','image','description','meta_data','status');
        
        if ($this->filters['name'] != '') {
            $packages->where(function ($sub_query) {
                $sub_query->where('name', 'like', '%' . $this->filters['name'] . '%');
                $sub_query->orWhere('description', 'like', '%' .$this->filters['name'] . '%');
            });
        }

        if ($this->filters['sortby'] == 'asc') {
            $packages->orderBy('name', $this->filters['sortby']);
        }

        return $packages->paginate($this->filters['per_page']);
    }

    #[On('update-status')]
    public function updateStatus($params)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        $module = Module::find($params['id']);
        if(empty($module)){
            $this->dispatch('showAlertMessage', message: __('admin/general.addon_not_found'), type: 'error');
            return;
        }
        if(in_array($module->getName(), $this->coreModules) && $params['type'] == 'active'){
            $this->dispatch('showAlertMessage', message: __('admin/general.core_module_not_deactivate'), type: 'error');
            return;
        }
        $addons = getAddons();
        if ($params['type'] == 'active' && !empty($addons) && array_key_exists($module->getLowerName(), $addons) && !empty($addons[$module->getLowerName()]['depends'])) {
            foreach($addons[$module->getLowerName()]['depends'] as $depends) {
                if (isActiveModule($depends)) {
                    $this->dispatch('showAlertMessage', message:  __('admin/general.addon_depends_on_another_addon', ['addon' => $addons[$depends]['name']]), type: 'error');
                    return ;
                }
            }
        }


        if($params['type'] == 'active'){
            Module::disable($module->getName());
        }else{
            Module::enable($module->getName());
            $addon = Addon::whereSlug($module->getLowerName())->first();
            if ($addon && empty($addon->meta_data['commands_installed'])) {
                $this->runPostInstallCommands($module->getName());
                $addon->update(['meta_data' => array_merge($addon->meta_data, ['commands_installed' => true])]);
            }
        }
        Artisan::call('module:clear-compiled');
        Artisan::call('optimize:clear');
        $this->dispatch('showAlertMessage', message: __('admin/general.addon_updated'), type: 'success');
        return $this->redirect(route('admin.packages.installed'));
    }

    #[On('delete-addon')]
    public function deleteAddon($params)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        $module = Module::find($params['id']);
        if(empty($module)){
            $this->dispatch('showAlertMessage', message: __('admin/general.addon_not_found'), type: 'error');
            return;
        }

        if(in_array($module->getName(), $this->coreModules)){
            $this->dispatch('showAlertMessage', message: __('admin/general.core_module_not_delete'), type: 'error');
            return;
        }

        $addons = getAddons();
        if (!empty($addons) && array_key_exists($module->getLowerName(), $addons) && !empty($addons[$module->getLowerName()]['depends'])) {
            foreach($addons[$module->getLowerName()]['depends'] as $depends) {
                if (isActiveModule($depends)) {
                    $this->dispatch('showAlertMessage', message:  __('admin/general.addon_depends_on_another_addon', ['addon' => $addons[$depends]['name']]), type: 'error');
                    return ;
                }
            }
        }

        Module::enable($module->getName());
        Artisan::call('module:migrate-rollback', ['module' => $module->getName(), '--force' => true]);
        Cache::forget('first_install_'.$module->getName());
        Module::delete($module->getName());
        if (File::exists(public_path('modules/'.$params['id']))){
            File::deleteDirectory(public_path('modules/'.$params['id']));
        }
        Artisan::call('module:clear-compiled');
        $this->dispatch('showAlertMessage', message: __('admin/general.addon_deleted'), type: 'success');
        Artisan::call('optimize:clear');
        sleep(5);
        return $this->redirect(route('admin.packages.installed'));
    }

    private function runPostInstallCommands($module)
    {
        Module::boot();
        Module::register();
        Artisan::call('module:migrate', ['module' => $module, '--force' => true]);
        Artisan::call('module:publish', ['module' => $module]);
        Artisan::call('module:seeder', ['module' => $module, '--force' => true]);
        Artisan::call('module:clear-compiled');
    }
}
