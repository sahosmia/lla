<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class OptionBuilderService
{

    protected $publicTabKeys    = array();

    public function __construct()
    {
        $this->publicTabKeys = [
            '_general' => [
                "allowed_file_extensions",
                "allowed_image_extensions",
                "allowed_video_extensions",
                "max_file_size",
                "max_image_size",
                "max_video_size",

                "default_language",
                "enable_multi_language",
                "multi_language_list",
                "enable_rtl",
                "date_format",
                "per_page_record",
                "currency",
                "currency_position",
                'thousand_separator',
                'decimal_separator',
                'number_of_decimals',
                'table_responsive',
                "default_avatar_for_user",
            ],
            '_api' => [
                'enable_google_places',
                'enable_social_login',
                'social_google_client_id',
                'social_google_client_id_android',
                'social_google_client_id_ios',
            ],
            '_dispute_setting' => '*',
            '_lernen' =>  [
                "profile_phone_number",
                "student_display_name",
                "tutor_display_name",
                "profile_video",
                "identity_verification_for_role",
                "phone_number_on_signup",
                "payment_enabled",
            ],
            '_app' => [
                'app_logo',
                'app_splash',
                'app_bg_color',
                'app_pri_color',
                'app_sec_color',
                'app_card_bg_color',
            ],
            '_assignments' => [
                'attempt_assignment_heading',
                'assignment_banner_image',
            ],
            '_quiz' => [
                'quiz_start_banner',
                'quiz_start_text',
            ],
        ];
    }

    private function isPublicKey($tab, $key = null): bool
    {
        if (!empty($this->publicTabKeys[$tab])) {
            if ($this->publicTabKeys[$tab] == '*')
                return true;
            elseif (!empty($key) && in_array($key, $this->publicTabKeys[$tab]))
                return true;
            else
                return false;
        }
        return false;
    }



    public function getPublicKeys()
    {
        $settings   = $this->getSettings();
        $allSettings = [];
        if (!empty($settings)) {
            foreach ($settings as $section => $fields) {
                foreach ($fields as $settingKey => $value) {
                    if ($this->isPublicKey($section, $settingKey)) {
                        $allSettings[$section][$settingKey] = $this->decodeValue($value);
                    }
                }
            }
        }
        return $allSettings;
    }

    private function decodeValue($settingValue)
    {

        $value = @unserialize($settingValue);
        if ($value == 'b:0;' || $value !== false) {
            $temp = [];
            foreach ($value as $key => $data) {
                if (is_array($data)) {
                    $temp[$key] = self::jsonDecodedArr($data);
                } else {
                    if (self::isJSON($data)) {
                        $temp[$key] = json_decode($data, true);
                    } else {
                        $temp[$key] = $data;
                    }
                }
            }
            return $temp;
        } else {
            if (self::isJSON($settingValue)) {
                return (json_decode($settingValue, true));
            } else {
                return $settingValue;
            }
        }
    }

    /**
     * get json_decoded array
     * @param $arr Array
     * @param mixed String $value
     * @return Void
     */
    private function jsonDecodedArr(&$arr)
    {

        foreach ($arr as $key => &$el) {

            if (is_array($el)) {
                self::jsonDecodedArr($el);
            } else {
                if (self::isJSON($el)) {
                    $el = json_decode($el, true);
                }
            }
        }
        return  $arr;
    }
    /**
     * check string is json or not
     * @param $string String
     * @param mixed String $value
     * @return Void
     */
    private function isJSON($string)
    {

        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    public function getSettings()
    {

        if (config('cache', true)) {
            return Cache::rememberForever('optionbuilder__settings', function () {
                return $this->fetchSettings();
            });
        } else {
            return $this->fetchSettings();
        }
    }


    /**
     * fetch From DB
     * @return array
     */
    private function fetchSettings()
    {

        $sections = [];
        $settings =  DB::table('optionbuilder__settings')->get();
        if (!empty($settings)) {
            foreach ($settings as $single) {
                $sections[$single->section][$single->key] = $single->value;
            }
        }
        DB::disconnect();
        return $sections;
    }
}
