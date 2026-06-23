<?php

namespace App\Livewire\Pages\Common\ProfileSettings;

use App\Http\Requests\Common\AccountSetting\AccountSettingStoreRequest;
use App\Http\Requests\Common\AccountSetting\ZoomSettingStoreRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use Livewire\Attributes\Layout;
use App\Services\GoogleCalender;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

class AccountSettings extends Component
{
    public  $reminder               = 30;
    public  $timezone;
    private $userService            = null;
    public  string $password        = '';

    public $zoom_account_id              = null;
    public $zoom_client_id               = null;
    public $zoom_client_secret           = null;

    public $getAccountSetting       = null;
    public  string $confirm         = '';
    private $googleCalenderService  = null;
    public $activeRoute             = false;
    public $zoom_error            = false;

    #[Layout('layouts.app')]
    public function render()
    {
        $this->timezone            = $this->getAccountSetting['timezone'][0] ?? (setting('_general.timezone') ?? 'UTC');
        if (!empty($this->getAccountSetting['google_calendar_info'])) {
            $this->reminder = $this->getAccountSetting['google_calendar_info']['minutes'];
        }

        return view('livewire.pages.common.profile-settings.account-settings');
    }

    public function boot()
    {
        $this->googleCalenderService  = new GoogleCalender(Auth::user());
        $this->userService            = new UserService(Auth::user());
    }

    public function mount()
    {
        $this->getAccountSetting   = $this->userService->getAccountSetting();

        $this->activeRoute = Route::currentRouteName();
        $this->dispatch('initSelect2', target: '.am-select2');

        $this->zoom_account_id      = $this->getAccountSetting['zoom_settings']['zoom_account_id'] ?? null;
        $this->zoom_client_id       = $this->getAccountSetting['zoom_settings']['zoom_client_id'] ?? null;
        $this->zoom_client_secret   = $this->getAccountSetting['zoom_settings']['zoom_client_secret'] ?? null;
    }

    public function updatePassword()
    {
        $request    = new AccountSettingStoreRequest();
        $rules      = $request->rules();
        $data       = $this->validate($rules);

        $response   = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        if ($data) {
            $this->userService->setUserPassword($this->password);
            $this->reset('password', 'confirm');
        }

        $this->dispatch('showAlertMessage', type: 'success', title: __('passwords.success'), message: __('passwords.password_changed_successfully'));
    }

    public function saveTimezone()
    {

        $request    = new AccountSettingStoreRequest();
        $rules      = $request->rules(true);
        $data       = $this->validate($rules);
        $response   = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        if ($data) {
            $this->userService->setAccountSetting('timezone', [$this->timezone]);
            Cache::forget('userTimeZone_' . Auth::user()?->id);
            $this->reset('timezone');
        }
        $this->dispatch('showAlertMessage', type: 'success', title: __('passwords.success'), message: __('settings.save_time_zone_successfully'));
    }

    public function connectCalender()
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        $authUrlResponse = $this->googleCalenderService->getAuthUrl();
        if ($authUrlResponse['status'] == Response::HTTP_OK) {
            $this->redirect($authUrlResponse['url']);
        } else {
            $this->dispatch('showAlertMessage', type: 'error', message: $authUrlResponse['message']);
        }
    }

    public function saveZoomSettings()
    {
        if (isDemoSite()) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $request    = new ZoomSettingStoreRequest();
        $rules      = $request->rules();
        $data       = $this->validate($rules);
        try {

            $client = new Client([
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($data['zoom_client_id'] . ':' . $data['zoom_client_secret']),
                    'Host' => 'zoom.us',
                ],
            ]);

            $response = $client->request('POST', "https://zoom.us/oauth/token", [
                'form_params' => [
                    'grant_type' => 'account_credentials',
                    'account_id' => $data['zoom_account_id'],
                ],
            ]);

            if (!$response->getStatusCode() == 200) {
                $this->zoom_error = true;
                $this->dispatch('showAlertMessage', type: 'error', title: __('passwords.error'), message: __('settings.invalid_zoom_credentials'));
                return;
            }

            $this->zoom_error = false;

            $this->userService->setAccountSetting('zoom_settings', $data);

            $this->dispatch('showAlertMessage', type: 'success', title: __('passwords.success'), message: __('settings.save_zoom_settings_successfully'));
        } catch (\Exception $e) {
            Log::error('Zoom validation error: ' . $e->getMessage());
            $this->zoom_error = true;
            $this->dispatch('showAlertMessage', type: 'error', title: __('passwords.error'), message: __('settings.invalid_zoom_credentials'));
            return;
        }
    }

    #[On('clear-zoom')]
    public function clearZoomSettings()
    {
        try {
            $this->userService->removeAccountSettings('zoom_settings');
            $this->zoom_account_id = $this->zoom_client_id = $this->zoom_client_secret = null;
            $this->dispatch('showAlertMessage', type: 'success', title: __('password.success'), message: __('settings.clear_success_message'));
        } catch (\Throwable $th) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('settings.wrong_msg'), message: __('settings.wrong_msg'));
        }
    }

    public function disconnectCalender()
    {
        $this->userService->setAccountSetting(['google_access_token', 'google_calendar_info']);
        $this->dispatch('showAlertMessage', type: 'success', title: __('passwords.success'), message: __('passwords.disconnect_calender'));
    }

    public function saveReminder()
    {
        $userPrimaryCalendar  = $this->googleCalenderService->updateCalendarNotificationSettings($this->reminder);
        if ($userPrimaryCalendar['status'] == 200) {
            $calendarData               = $this->getAccountSetting['google_calendar_info'];
            $calendarData['minutes']    = $this->reminder;
            $this->userService->setAccountSetting('google_calendar_info',  $calendarData);
            $this->dispatch('showAlertMessage', type: 'success', title: __('passwords.success'), message: __('passwords.update_calendar_notification'));
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('passwords.update_reminder'), message: $userPrimaryCalendar['message']);
        }
    }
}
