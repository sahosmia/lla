<?php

namespace App\Http\Controllers\Admin;

use ScssPhp\ScssPhp\Compiler;
use App\Http\Controllers\Controller;
use App\Models\Addon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Str;
class GeneralController extends Controller
{
    protected $envPath;
    protected $envExamplePath;

    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    public function updateSaas()
    {
        $writableResponse = $this->isWritable();

        if(!empty($writableResponse['success']) && Module::has('courses') && Module::isEnabled('courses')) {
           $writableResponse = $this->isWritable('courses');
        } elseif(!empty($writableResponse['message'])) {
            return response()->json(['success' => false, 'message' => $writableResponse['message']]);
        }
        
        if(!empty($writableResponse['success']) && Module::has('forumwise') && Module::isEnabled('forumwise')) {
            $writableResponse = $this->isWritable('forumwise');
        } elseif(!empty($writableResponse['message'])) {
            return response()->json(['success' => false, 'message' => $writableResponse['message']]);
        }
        
        if(!empty($writableResponse['success']) && Module::has('upcertify') && Module::isEnabled('upcertify')) {
            $writableResponse = $this->isWritable('upcertify');
        } elseif(!empty($writableResponse['message'])) {
            return response()->json(['success' => false, 'message' => $writableResponse['message']]);
        }

        if(!empty($writableResponse['success']) && Module::has('kupondeal') && Module::isEnabled('kupondeal')) {
            $writableResponse = $this->isWritable('kupondeal');
        } elseif(!empty($writableResponse['message'])) {
            return response()->json(['success' => false, 'message' => $writableResponse['message']]);
        }

        if(!empty($writableResponse['success']) && Module::has('subscriptions') && Module::isEnabled('subscriptions')) {
            $writableResponse = $this->isWritable('subscriptions');
        } elseif(!empty($writableResponse['message'])) {
            return response()->json(['success' => false, 'message' => $writableResponse['message']]);
        }

        if(!empty($writableResponse['message'])){
            return response()->json(['success' => false, 'message' => $writableResponse['message']]);
        }


    
        $theme_pri_color          = setting('_theme.theme_pri_color');
        $theme_sec_color          = setting('_theme.theme_sec_color');
        $theme_footer_bg          = setting('_theme.theme_footer_bg');
        $theme_footer_text_color  = setting('_theme.theme_footer_text_color');
        $text_light_color         = setting('_theme.text_light_color');
        $heading_color            = setting('_theme.heading_color');
        $auth_bg_color            = setting('_theme.auth_bg_color');
        $btn_white_color          = setting('_theme.btn_white_color');
        $btn_black_color          = setting('_theme.btn_black_color');
        $btn_color                = setting('_theme.btn_color');
        $btn_disable_color        = setting('_theme.btn_disable_color');
        $btn_secondary_color      = setting('_theme.btn_secondary_color');
        $body_font_color          = setting('_theme.body_font_color');


        try {

            $compiler = new Compiler();
            $compiler->setSourceMap(Compiler::SOURCE_MAP_FILE);
            $source_scss    = public_path('scss/main.scss');
            $import_path    = public_path('scss/');
            $scss_content   = file_get_contents($source_scss);
            $target_css     = public_path('css/main.css');
            $compiler->addImportPath($import_path);

            $variables  = array(
                '$theme-color'                  => !empty($theme_pri_color) ? $theme_pri_color                  : '#295C51',
                '$body-color'                   => !empty($theme_sec_color) ? $theme_sec_color                  : '#FAF8F5',
                '$text-light'                   => !empty($text_light_color) ? $text_light_color                : '#585858',
                '$heading-color'                => !empty($heading_color) ? $heading_color                      : '#000',
                '$footer-color'                 => !empty($theme_footer_bg) ? $theme_footer_bg                  : '#065A46',
                '$footer-text-color'            => !empty($theme_footer_text_color) ? $theme_footer_text_color  : '#fff',
                '$clr-white'                    => '#fff',
                '$dark-black'                   => '#000',
                '$input-br-hover'               => '#295C51',
                '$auth-bg'                      => !empty($auth_bg_color) ? $auth_bg_color                      : '#FBF9F4',
                '$btn-white'                    => !empty($btn_white_color) ? $btn_white_color                  : '#fff',
                '$btn-black'                    => !empty($btn_black_color) ? $btn_black_color                  : '#000',
                '$btn-color'                    => !empty($btn_color) ? $btn_color                              : '#295C51',
                '$btn-disable'                  => !empty($btn_disable_color) ? $btn_disable_color              : '#f7f7f8',
                '$btn-secondary'                => !empty($btn_secondary_color) ? $btn_secondary_color          : '#F55C2B',
                '$body-font-color'              => !empty($body_font_color) ? $body_font_color                  : '#585858',
            );
            $compiler->setSourceMapOptions([
                'sourceMapURL'      => 'main.css.map',
                'sourceMapFilename' => $target_css,
            ]);

            $compiler->addVariables($variables);
            $result  =  $compiler->compileString($scss_content);
            if (!empty($result->getCss())) {
                file_put_contents(public_path('css/main.css.map'), $result->getSourceMap());
                file_put_contents($target_css, $result->getCss());
            }
            if(Module::has('courses') && Module::isEnabled('courses')) {
                $this->updateModulesSaas('courses', $variables);
            }
            if(Module::has('upcertify') && Module::isEnabled('upcertify')) {
                $this->updateModulesSaas('upcertify',$variables);
            }

            if(Module::has('forumwise') && Module::isEnabled('forumwise')) {
                $this->updateModulesSaas('forumwise',$variables);
            }

            if(Module::has('kupondeal') && Module::isEnabled('kupondeal')) {
                $this->updateModulesSaas('kupondeal',$variables);
            }

            if(Module::has('subscriptions') && Module::isEnabled('subscriptions')) {
                $this->updateModulesSaas('subscriptions',$variables);
            }

            return response()->json(['success' => true, 'message' => __('admin/general.colors_update_successfully')]);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    protected function isWritable($module = null){

        if(empty($module)){
            $source_css_map = public_path('css/main.css.map');
            $target_css     = public_path('css/main.css');
        } else {
            $source_css_map = public_path('modules/'.$module.'/css/main.css.map');
            $target_css     = public_path('modules/'.$module.'/css/main.css');
        }

        if(!is_writable($source_css_map)) {
            return ['success' => false, 'message' => __('admin/general.not_writable',['path' => !empty($module) ? "modules/$module/css/main.css.map" : 'public/css/main.css.map'])];
        }
        if(!is_writable($target_css)) {
            return ['success' => false, 'message' => __('admin/general.css_not_writable', ['path' => !empty($module) ? "modules/$module/css/main.css" : 'public/css/main.css'])];
        }
        return ['success' => true];
    }

    protected function updateModulesSaas($name, $variables)
    {
        $compiler = new Compiler();
        $compiler->setSourceMap(Compiler::SOURCE_MAP_FILE);

        $source_scss    = public_path('modules/'.$name.'/scss/main.scss');
        $import_path    = public_path('modules/'.$name.'/scss/');
        $scss_content   = file_get_contents($source_scss);
        $target_css     = public_path('modules/'.$name.'/css/main.css');
        $compiler->addImportPath($import_path);

        $compiler->setSourceMapOptions([
            'sourceMapURL'      => 'main.css.map',
            'sourceMapFilename' => $target_css,
        ]);

        $compiler->addVariables($variables);
        $result  =  $compiler->compileString($scss_content);
        if (!empty($result->getCss())) {
            file_put_contents(public_path('modules/'.$name.'/css/main.css.map'), $result->getSourceMap());
            file_put_contents($target_css, $result->getCss());
        }
    }


    public function updateSocialLoginSettings()
    {
        $env                = $this->getEnvContent();

        $socialLoginSetting = [
            'GOOGLE_CLIENT_ID'          => setting('_api.social_google_client_id'),
            'GOOGLE_CLIENT_SECRET'      => setting('_api.social_google_client_secret') ?? null,
        ];

        $rows = explode("\n", $env);
        foreach ($rows as &$row) {
            foreach ($socialLoginSetting as $key => $value) {
                if (strpos($row, $key . '=') === 0) {
                        $row = $key . "={$value}";
                }
            }
        }
        unset($row);
        $env = implode("\n", $rows);

        try {

            file_put_contents($this->envPath, $env);

            return [
                'success' => true,
                'message' => __('admin/general.social_login_settings_success')
            ];
        } catch (\Exception $e) {
            Log::error("message: ".$e->getMessage());
            return [
                'success' => false,
                'message' => __('admin/general.social_login_settings_error')
            ];
        }
    }
    public function updateSMTPSettings()
    {
        $env                = $this->getEnvContent();

        $mailSetting = [
            'MAIL_MAILER'       => 'smtp',
            'MAIL_HOST'         => setting('_email.smtp_host') ?? null,
            'MAIL_USERNAME'     => setting('_email.smtp_username') ?? null,
            'MAIL_PASSWORD'     => setting('_email.smtp_password') ?? null,
            'MAIL_PORT'         => setting('_email.smtp_port') ?? null,
            'MAIL_ENCRYPTION'   => empty(setting('_email.smtp_encryption')) || setting('_email.smtp_encryption') == 'none' ? null : setting('_email.smtp_encryption'),
            'MAIL_FROM_ADDRESS' => setting('_email.smtp_from_email') ?? null,
            'MAIL_FROM_NAME'    => setting('_email.smtp_from_name') ?? null,
        ];

        $rows = explode("\n", $env);
        foreach ($rows as &$row) {
            foreach ($mailSetting as $key => $value) {
                if (strpos($row, $key . '=') === 0) {
                    if ($key == 'MAIL_USERNAME' || $key == 'MAIL_PASSWORD' || $key == 'MAIL_FROM_ADDRESS' || $key == 'MAIL_FROM_NAME') {
                        $row = $key . "='{$value}'";
                    } else {
                        $row = $key . "={$value}";
                    }
                }
            }
        }
        unset($row);
        $env = implode("\n", $rows);

        try {
            try {
                config([
                    'mail.default' => 'smtp',
                    'mail.mailers.smtp' => [
                        'transport'     => 'smtp',
                        'host'          => $mailSetting['MAIL_HOST'],
                        'port'          => (int)$mailSetting['MAIL_PORT'],
                        'encryption'    => $mailSetting['MAIL_ENCRYPTION'],
                        'username'      => $mailSetting['MAIL_USERNAME'],
                        'password'      => $mailSetting['MAIL_PASSWORD'],
                    ],
                    'mail.from' => [
                        'address'   => $mailSetting['MAIL_FROM_ADDRESS'],
                        'name'      => $mailSetting['MAIL_FROM_NAME'],
                    ],
                ]);

                $details = [
                    'title' => 'Test Email Title',
                    'body' => 'This is a test email body'
                ];

                Mail::raw($details['body'], function ($message) {
                    $message->to('test@test.com')
                        ->subject('Test Email');
                });

                file_put_contents($this->envPath, $env);

                return [
                    'success' => true,
                    'message' => __('admin/general.smtp_settings_correct')
                ];
            } catch (\Exception $e) {
                return [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => __('admin/general.smtp_settings_wrong')
            ];
        }
    }

    public function updateBroadcastingSettings()
    {
        $broadcastingDriver = setting('_broadcasting_setting.broadcasting_driver') ?? 'log';
        $env                = $this->getEnvContent();

        $rows = explode("\n", $env);
        foreach ($rows as &$row) {
            if (strpos($row, 'BROADCAST_CONNECTION=') === 0) {
                $row = 'BROADCAST_CONNECTION=' . $broadcastingDriver;
            }
        }
        unset($row);
        $env = implode("\n", $rows);

        try {
            file_put_contents($this->envPath, $env);

            return [
                'success' => true,
                'message' => __('admin/general.broadcasting_settings_success')
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('admin/general.broadcasting_settings_error')
            ];
        }
    }

    public function updatePusherSettings()
    {
        $env                = $this->getEnvContent();

        $pusherSetting = [
            'PUSHER_APP_ID'     => setting('_broadcasting_setting.pusher_app_id') ?? null,
            'PUSHER_APP_KEY'    => setting('_broadcasting_setting.pusher_app_key') ?? null,
            'PUSHER_APP_SECRET' => setting('_broadcasting_setting.pusher_app_secret') ?? null,
            'PUSHER_APP_CLUSTER'=> setting('_broadcasting_setting.pusher_app_cluster') ?? null,
        ];

        $rows = explode("\n", $env);
        foreach ($rows as &$row) {
            foreach ($pusherSetting as $key => $value) {
                if (strpos($row, $key . '=') === 0) {
                
                    $row = $key . "='{$value}'";
                }
            }
        }
        unset($row);
        $env = implode("\n", $rows);

        try {
            try {
                file_put_contents($this->envPath, $env);

                return [
                    'success' => true,
                    'message' => __('admin/general.pusher_settings_success')
                ];
            } catch (\Exception $e) {
                return [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => __('admin/general.pusher_settings_wrong')
            ];
        }
    }

    public function updateReverbSettings()
    {
        $env                = $this->getEnvContent();

        $reverbSetting = [
            'REVERB_APP_ID'     => setting('_broadcasting_setting.reverb_app_id') ?? null,
            'REVERB_APP_KEY'    => setting('_broadcasting_setting.reverb_app_key') ?? null,
            'REVERB_APP_SECRET' => setting('_broadcasting_setting.reverb_app_secret') ?? null,
            'REVERB_APP_CLUSTER'=> setting('_broadcasting_setting.reverb_app_host') ?? null,
            'REVERB_PORT'       => setting('_broadcasting_setting.reverb_app_port') ?? null,
            'REVERB_SCHEME'     => setting('_broadcasting_setting.reverb_app_scheme') ?? null,
        ];

        $rows = explode("\n", $env);
        foreach ($rows as &$row) {
            foreach ($reverbSetting as $key => $value) {
                if (strpos($row, $key . '=') === 0) {
                    $row = $key . "='{$value}'";
                }
            }
        }
        unset($row);
        $env = implode("\n", $rows);

        try {
            try {
                file_put_contents($this->envPath, $env);
                return [
                    'success' => true,
                    'message' => __('admin/general.reverb_settings_success')
                ];
            } catch (\Exception $e) {
                return [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => __('admin/general.reverb_settings_wrong')
            ];
        }
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    protected function getEnvContent()
    {
        if (!file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    public function getUpgradeLogs()
    {
        if (File::exists(storage_path('logs/upgrade.log'))) {
            return File::get(storage_path('logs/upgrade.log'));
        }
        return '';
    }

    /**
     * Clear the cache
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache()
    {
        Artisan::call('cache:clear');
        return redirect()->back()->with('success', __('admin/general.cache_cleared'));
    }

    /**
     * Upload addon
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadAddon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:zip',
        ],[
            'file'          => __('validation.file_too_large', ['max' => ini_get('upload_max_filesize')]),
            'file.required' => __('validation.required_field'),
            'file.file'     => __('validation.required_field'),
            'file.mimes'    => __('validation.invalid_file_type', ['file_types' => 'zip']),
        ]);

        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }
        
        $response = isDemoSite();
        if($response){
            return response()->json(['success' => false, 'message' => __('general.demosite_res_txt')]);
        }

        $addonName = pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME);
        
        $addons = getAddons();

        if(!empty($addons) && !array_key_exists(Str::lower($addonName), $addons)){
            return response()->json(['success' => false, 'message' => __('admin/general.addon_not_found')], 422);
        }

        if (!empty($addons) && array_key_exists(Str::lower($addonName), $addons) && !empty($addons[Str::lower($addonName)]['requires'])) {
            foreach($addons[Str::lower($addonName)]['requires'] as $require) {
                if (!isActiveModule($require)) {
                    return response()->json(['success' => false, 'message' => __('admin/general.addon_required_another_addon', ['addon' => $addons[$require]['name']])], 422);
                }
            }
        }

        $status = $this->replacePluginFile($request->file, $addons[Str::lower($addonName)]);

        if(!empty($status['status'])){
            return response()->json(['success' => true, 'message' => __('admin/general.addon_installed_successfully')]);
        } else {
            return response()->json(['success' => false, 'message' => $status['message'] ?? __('admin/general.addon_installing_error')]);
        }
    }

    /**
     * Replace plugin file
     *
     * @param  mixed $file
     * @return array
     */
    private function replacePluginFile($file, $addonJsonInfo)
    {
        try{
            $addonName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $uploadedAddonFile = Storage::drive('local')->putFile('/addons', $file);

            $getLatestUpdateFile = storage_path('app/' . $uploadedAddonFile);
            $zipArchive = new \ZipArchive();

            $zipArchive->open($getLatestUpdateFile);

            $updatedFileLocation = "addons/" . $addonName;

            $zipExtracted = $zipArchive->extractTo(storage_path('app/addons'));

            if ($zipExtracted) {
                $zipArchive->close();
                $updateFiles = Storage::drive('local')->allFiles($updatedFileLocation);
                if (!in_array("addons/" . $addonName . "/module.json", $updateFiles)) {
                    throw new Exception(__('admin/general.module_json_not_found'));
                }

                $addonInfo = json_decode(file_get_contents(storage_path("app/addons/" . $addonName . "/module.json")));
                if (!property_exists($addonInfo, "providers")) {
                    throw new Exception(__('admin/general.module_json_invalid'));
                }

                foreach ($updateFiles as $updateFile) {
                    $folderName = pathinfo($updateFile, PATHINFO_DIRNAME);
                    $fileName = pathinfo($updateFile, PATHINFO_FILENAME);
                    if (str_contains($folderName, '.vscode') || str_contains($folderName, '.idea') || str_contains($folderName, '.fleet') || str_contains($folderName, '.git')) {
                        continue;
                    }
                    if (str_contains($folderName, '_build') || str_contains($folderName, 'vue')) {
                        continue;
                    }
                    $file = new HttpFile(storage_path("app/" . $updateFile));
                    $skipFiles = ['.DS_Store', '.gitkeep'];
                    if (!in_array($fileName, $skipFiles)) {
                        $file->move(storage_path('../Modules/' . str_replace("addons/", "", $folderName)));
                    }
                    
                }

            }
            Artisan::call('module:clear-compiled');
            $addons = getAddons();
            Addon::updateOrCreate([
                'name' => $addonJsonInfo['name'] ?? $addonName,
                'slug' => Str::lower($addonName),
            ], [
                'description'   => $addons[Str::lower($addonName)]['description'] ?? null,
                'image'         => $addons[Str::lower($addonName)]['image'] ?? null,
                'status'        => Module::has($addonName) && Module::isEnabled($addonName) ? 'enabled' : 'disabled', 
                'meta_data'     => [
                    'latest_version'     => $addonInfo->version ?? '1.0',
                    'commands_installed' => Module::has($addonName) && Module::isEnabled($addonName) ? true : false
                ],
            ]);
            if(Module::has($addonName) && Module::isEnabled($addonName)) {
                Artisan::call('module:migrate', ['module' => $addonName, '--force' => true]);
                Artisan::call('module:publish', ['module' => $addonName]);
            }
            File::deleteDirectory(storage_path('app/addons/' . $addonName));
            return ['status' => true];
        } catch(Exception $ex) {
            @unlink(storage_path('app/' . $uploadedAddonFile));
            File::deleteDirectory(storage_path('app/addons/' . $addonName));
            Log::error($ex);
            return ['status' => false, 'message' => $ex->getMessage()];
        }
    }

    public function checkQueue()
    {
       
        if (isQueueHealthy()) {
            return response()->json([
                'success' => true,
                'message' => 'Queue is healthy. Job dispatched and processed successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Queue is not running. Job was not processed yet.'
            ]);
        }
    }
    
}
