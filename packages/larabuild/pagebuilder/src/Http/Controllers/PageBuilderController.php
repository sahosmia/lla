<?php


namespace Larabuild\Pagebuilder\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PageBuilderService;
use Larabuild\Pagebuilder\Models\Page;
use Larabuild\Optionbuilder\Facades\Settings;
use Larabuild\Pagebuilder\Facades\PageSettings;
use Illuminate\Support\Str;
class PageBuilderController extends Controller {
    public function build($pageId, Request $request) {
        $page = PageSettings::getPage($pageId);

        if (!$page)
            abort(404);

        $grid_templates =   [];
        foreach (getGrids() as $grid) {
            $columns = getColumnInfo($grid);
            $grid_templates[$grid] = view('pagebuilder::components.add-grid-placeholder', compact('columns', 'grid'))->render();
        }

        $components = $componentDirectories = $tempaltes = $componentTabs = [];

        if (file_exists(resource_path('views/pagebuilder')))
            $componentDirectories = array_diff(scandir(resource_path('views/pagebuilder')), array('..', '.'));

        foreach ($componentDirectories as $directory) {

            if (file_exists(resource_path('views/pagebuilder/' . $directory . '/settings.php'))) {
                $currentSettings = include resource_path('views/pagebuilder/' . $directory . '/settings.php');

                if (!empty($currentSettings['id']) && $directory == $currentSettings['id']) {

                    setCurrentDirectory($currentSettings['id']);


                    $components[$currentSettings['id']] = array(
                        'directory' => $directory,
                        'settings' => $currentSettings,
                        'template' => view()->exists('pagebuilder.' . $directory . '.view') ? view('pagebuilder.' . $directory . '.view', ['edit' => true])->render() : view('pagebuilder::components.no-view')->render(),
                    );


                    $componentTabs[$currentSettings['tab']][$currentSettings['id']] = $currentSettings['id'];
                }
            }
        }


        setCurrentPageId($page->id);

        return view('pagebuilder::pagebuilder', compact('grid_templates', 'components', 'page', 'componentTabs'));
    }
    public function iframe($pageId, Request $request) {
        $page = PageSettings::getPage($pageId);
        $edit = true;
        if (!$page)
            abort(404);

        $grid_templates =   [];
        foreach (getGrids() as $grid) {
            $columns = getColumnInfo($grid);
            $grid_templates[$grid] = view('pagebuilder::components.add-grid-placeholder', compact('columns', 'grid'))->render();
        }

        $components = $componentDirectories = $tempaltes = $componentTabs = [];

        if (file_exists(resource_path('views/pagebuilder')))
            $componentDirectories = array_diff(scandir(resource_path('views/pagebuilder')), array('..', '.'));

        foreach ($componentDirectories as $directory) {

            if (file_exists(resource_path('views/pagebuilder/' . $directory . '/settings.php'))) {
                $currentSettings = include resource_path('views/pagebuilder/' . $directory . '/settings.php');

                if (!empty($currentSettings['id']) && $directory == $currentSettings['id']) {

                    setCurrentDirectory($currentSettings['id']);


                    $components[$currentSettings['id']] = array(
                        'directory' => $directory,
                        'settings' => $currentSettings,
                        'template' => view()->exists('pagebuilder.' . $directory . '.view') ? view('pagebuilder.' . $directory . '.view', compact('page', 'edit'))->render() : view('pagebuilder::components.no-view', compact('page', 'edit'))->render(),
                    );


                    $componentTabs[$currentSettings['tab']][$currentSettings['id']] = $currentSettings['id'];
                }
            }
        }


        setCurrentPageId($page->id);
        
        return view('pagebuilder::pagebuilder-iframe', compact('grid_templates', 'components', 'page', 'componentTabs', 'edit'));
    }

    public function renderPage($pageSlug) {
        $page = Page::select('id', 'name', 'title', 'description', 'slug', 'settings', 'status')
            ->whereSlug($pageSlug)
            ->when(empty(request()->get('preview')), function ($q) {
                return $q->whereStatus('published');
            })
            ->firstOrFail();

        $pageSections = view('pagebuilder::components.page-components', compact('page'));
        setCurrentPageId($page->id);
        return view('pagebuilder::page', compact('page', 'pageSections'));
    }

    public function getSettings(Request $request) {
        $pageId = $request->input('page_id');
        $directory = $request->input('directory');
        $sectionId = $request->input('id');
        $gridId = $request->input('grid_id');
        $getDemoSettings = $request->input('get_demo_settings');
        if (file_exists(resource_path('views/pagebuilder/' . $directory . '/settings.php')))
            $settings = include resource_path('views/pagebuilder/' . $directory . '/settings.php');
        if (!empty($settings['fields'])) {
            $settingsHtml = $this->getPageSectionSettings($pageId, $sectionId, $settings['fields'], ['is_demo' => $getDemoSettings, 'directory' => $directory]);
        }

        $styles = $this->getSectionStyles($pageId, $gridId);

        $json = ['type' => 'success', 'section_data' => PageSettings::getPageSettings($pageId) ?? [], 'settings' => $settingsHtml ?? '', 'styles' => $styles];

        return response(json_encode($json), 200);
    }

    public function setPageSettings(Request $request) {
        if (isDemoSite())
            return response()->json(['success' => false]);
        $settings = $sectionId = null;
        if (!empty($request->get('settings')))
            $settings = $request->get('settings');
        if (!empty($request->get('current_section_data'))) {
            parse_str($request->get('current_section_data'), $form_data);
            parse_str($request->get('current_advanced_settings'), $advanced_form_data);
            $sectionId = $form_data['section_id'];
            unset($form_data['_method']);
            unset($form_data['_token']);
            unset($form_data['section_id']);
            $settings['section_data'][$sectionId]['settings'] = [];
            foreach ($form_data as $key => $value) {
                $isArray = 0;
                if (is_array($value))
                    $isArray = 1;
                $settings['section_data'][$sectionId]['settings'][$key]['value'] = $value;
                $settings['section_data'][$sectionId]['settings'][$key]['is_array'] = $isArray;
            }

            $grid_id = $advanced_form_data['grid_id'] ?? null;
            unset($advanced_form_data['grid_id']);
            $settings['section_data'][$grid_id]['styles'] = [];
            foreach ($advanced_form_data as $key => $value) {
                if ($value != 'rgba(0,0,0,0)') {
                    $settings['section_data'][$grid_id]['styles'][$key] = $value;
                }
            }

            if (empty($settings['section_data'][$grid_id]['styles']['content_width']) || (!empty($settings['section_data'][$grid_id]['styles']['content_width']) && $settings['section_data'][$grid_id]['styles']['content_width'] == 'full_width'))
                unset($settings['section_data'][$grid_id]['styles']['boxed_slider_input']);
        }

        PageSettings::setPageSettings($request->input('page_id'), $settings);
        if (!empty($sectionId)) {
            setCurrentPageId($request->input('page_id'));
            $sectionHtml = $this->getSectionHtml($sectionId, $request->input('directory'));
        }
        return response()->json(
            [
                'success' => [
                    'type'          => 'success',
                    'title'         => __('Congratulations'),
                    'message'       => __('Page settings updated successfully'),
                ],
                'html' => $sectionHtml ?? '',
                'css' => !empty($grid_id) ? getComponentStyles($grid_id) : '',
                'custom_attributes' => !empty($grid_id) ? getCustomAttributes($grid_id) : '',
                'bgOverlay' => !empty($grid_id) ? getBgOverlay($grid_id) : '',
                'classes' => !empty($grid_id) ? getClasses($grid_id) : '',
                'sectionData' =>  $settings['section_data'] ?? []
            ]
        );
    }

    public function getSectionHtml($sectionId, $directory = null) {
        $html = '';
        if ($sectionId && $directory) {
            $edit = true;
            setSectionId($sectionId);
            $html = view()->exists('pagebuilder.' . $directory . '.view') ?  view('pagebuilder.' . $directory . '.view', compact('edit'))->render() : __('pagebuilder::pagebuilder.no_view', ["block" => $directory]);
        }
        return $html;
    }

    public function getPageSectionSettings($pageId, $sectionId, $fields, $demoParams = []) {
        $html = $db_value = '';
        $sectionDemoData = $params = [];
        
        if(!empty($demoParams['is_demo'])){
            $functionName = Str::ucfirst(Str::camel($demoParams['directory']));
            if(method_exists(PageBuilderService::class, "get{$functionName}Data")) {
                $sectionDemoData = (new PageBuilderService())->{"get{$functionName}Data"}($pageId, false) ?? [];
            }
        }

        if (is_array($fields) && !empty($fields)) {

            $tab_key = !empty($params['tab_key']) ? $params['tab_key'] :  '';
            $html = '<ul class="op-themeform__wrap">';
            foreach ($fields as $field) {

                $field['tab_key']       = $tab_key;
                if (empty($params['repeater_id'])) {
                    $id = !empty($field['id']) ? $field['id'] : '';
                    if(!empty($demoParams['is_demo'])){
                        if(!empty($sectionDemoData[$id])){
                            $db_value = $sectionDemoData[$id]['value'] ?? '';
                        }
                    }else{
                        $db_value = PageSettings::getPageSectionSettings($pageId, $sectionId, $id);
                    }
                    $field['db_value']   = $db_value;
                    if (!empty($db_value)) {
                        $field['value']   = $db_value;
                    }
                } else {
                    $field['repeater_id']   = !empty($params['repeater_id']) ? $params['repeater_id'] :  '';
                    $field['index']         = !empty($params['repeater_id']) ? $params['index'] :  '';
                }
                $html .= Settings::getField($field);
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function getPageSectionSettingsArray($pageId, $sectionId, $fields, $directory) {

        $settings = [];
        if (is_array($fields) && !empty($fields)) {
            foreach ($fields as $field) {
                $id = !empty($field['id']) ? $field['id'] : '';
                $db_value = PageSettings::getPageSectionSettings($pageId, $sectionId, $id);

                if (empty($db_value))
                    $db_value =  getDefaultValues($directory, $id);

                $settings[$id]   = $db_value;
            }
        }
        return $settings;
    }

    public function getSectionStyles($pageId, $sectionId) {
        $page = PageSettings::getPage($pageId);
        $styles = $page->settings['section_data'][$sectionId]['styles'] ?? [];
        return view('pagebuilder::components.styles', ['styles' => $styles])->render();
    }
}
