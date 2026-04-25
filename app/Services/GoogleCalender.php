<?php

namespace App\Services;

use Exception;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Exception as GoogleServiceException;
use Google_Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GoogleCalender {

    protected $clientCredentials;
    protected $userAccountSettings = null;
    protected $userService;

    public function __construct($user = null) {
        $this->clientCredentials = [
            'client_id'     => setting('_api.google_client_id'),
            'client_secret' => setting('_api.google_client_secret'),
            'redirect_uri'  => config('services.google.redirect_uri'),
            'scopes'        => [Calendar::CALENDAR]
        ];
        $this->userService = new UserService($user);
        $this->userAccountSettings = $this->userService->getAccountSetting();
    }

    public function getAuthUrl() {
        try {
            if (empty($this->clientCredentials['client_id']) || empty($this->clientCredentials['client_secret'])) {
                return ['status' => Response::HTTP_BAD_REQUEST, 'message' => __('passwords.keys_missing')];
            }        
            $client = new Client($this->clientCredentials);
            $client->setAccessType('offline');
            $client->setPrompt('consent');
            $auth_url = $client->createAuthUrl();
            return ['status' => Response::HTTP_OK, 'url' => $auth_url];
        } catch (Exception $ex) {
            return ['status' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    }

    public function getAccessTokenInfo($code) {
        $client = new Client($this->clientCredentials);
        return $client->fetchAccessTokenWithAuthCode($code);
    }

    protected function verifyToken() {
        $isTokenExpired  = $this->isTokenExpired($this->userAccountSettings['google_access_token']);
        if($isTokenExpired){
            $this->userAccountSettings['google_access_token'] = $this->refreshAccessToken($this->userAccountSettings['google_access_token']['refresh_token']);
            $this->userService->setAccountSetting('google_access_token',$this->userAccountSettings['google_access_token']);
        }
    }

    public function refreshAccessToken($refreshToken) {
        $client = new Client($this->clientCredentials);
        return $client->fetchAccessTokenWithRefreshToken($refreshToken);
    }

    public function isTokenExpired($tokenArray) {
        $client = new Google_Client();
        $client->setAccessToken($tokenArray);
        return $client->isAccessTokenExpired();
    }

    public function getUserPrimaryCalendar($token) {
        try {
            $client = new Google_Client();
            $client->setAccessToken($token);
            $service = new Calendar($client);
            $primaryCalendar = array();
            $calendar = $service->calendars->get('primary');
            $primaryCalendar = [
                'id'            =>  $calendar->getId(),
                'summary'       =>  $calendar->getSummary(),
                'description'   =>  $calendar->getDescription(),
                'timezone'      =>  $calendar->getTimeZone(),
            ];
            return ['status' => Response::HTTP_OK, 'data' => $primaryCalendar];
        } catch (GoogleServiceException $ex) {
            Log::info($ex);
            return ['status' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    }

    public function updateCalendarNotificationSettings($minutes) {
        try {
            $this->verifyToken();
            $client = new Google_Client();
            $client->setAccessToken($this->userAccountSettings['google_access_token']);
            $service = new Calendar($client);
            $calendars = $service->calendarList->listCalendarList();
            $updatedCalendar = null;
            foreach ($calendars as $calendar) {
                if ($calendar->getPrimary()) {
                    if (!empty($minutes)) {
                        $calendar->setDefaultReminders([
                            ['method' => 'email', 'minutes' => $minutes],
                            ['method' => 'popup', 'minutes' => $minutes],
                        ]);
                    } else {
                        $calendar->setDefaultReminders([]);
                    }
                    $updatedCalendar = $service->calendarList->update($calendar->getId(), $calendar);
                    break;
                }
            }
            return ['status' => Response::HTTP_OK, 'data' => $updatedCalendar];
        } catch (GoogleServiceException $ex) {
            Log::info($ex);
            return ['status' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    }
    /**
     * Create Event Function
     * @param array $eventData[
     *      'title',
     *      'description',
     *      'start_time',
     *      'end_time',
     *      'timezone'
     * ]
     */
    public function createEvent($eventData) {
        try {
            if (!empty($this->userAccountSettings['google_calendar_info']['id'])) {
                $this->verifyToken();
                $client = new Google_Client();
                $client->setAccessToken($this->userAccountSettings['google_access_token']);
                $service = new Calendar($client);
                $event  = new Event([
                    'summary'     => $eventData['title'],
                    'description' => $eventData['description'],
                    'start'  => [
                        'dateTime' => $eventData['start_time'],
                        'timeZone' => $eventData['timezone']
                    ],
                    'end'  => [
                        'dateTime' => $eventData['end_time'],
                        'timeZone' => $eventData['timezone']
                    ]
                ]);
                $event = $service->events->insert($this->userAccountSettings['google_calendar_info']['id'], $event);
                return ['status' => Response::HTTP_OK, 'data' => $event];
            }
            return ['status' => Response::HTTP_BAD_REQUEST, 'message' => __('passwords.no_calendar')];
        } catch (Exception $ex) {
            Log::info($ex);
            return ['status' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    }

    /**
     * Delete Event
     * @param string $eventId
     */

    public function deleteEvent($eventId) {
        try {
            if (!empty($this->userAccountSettings['google_calendar_info']['id'])) {
                $this->verifyToken();
                $client = new Google_Client();
                $client->setAccessToken($this->userAccountSettings['google_access_token']);
                $service = new Calendar($client);
                $service->events->delete($this->userAccountSettings['google_calendar_info']['id'], $eventId);
                return ['status' => Response::HTTP_OK, 'message' => __('passwords.event_deleted')];
            }
            return ['status' => Response::HTTP_BAD_REQUEST, 'message' => __('passwords.no_calendar')];
        } catch (Exception $ex) {
            Log::info($ex);
            return ['status' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    } 
}
