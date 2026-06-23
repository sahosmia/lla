<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class AddressService {

    public $googleMapKey;
    public $user;

    public function __construct($userId) {
        $this->user = User::find($userId);
        $this->googleMapKey = setting('api.google_places_api_key');
    }
    function getGeoCodeInfo($postal_code = '', $region_name = '') {
        $geo_data = $geo_code_data = $response    = array();
        if (empty($this->googleMapKey)) {
            $response['type']             = 'error';
            $response['title']             = __('general.alert_error_title');
            $response['message']         = __('general.api_key_not_found');
        } else {
            $geo_zip_code   = $postal_code;
            $region_name    = $region_name;
            $geo_request     = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $geo_zip_code . '&region=' . $region_name . '&key=' . $this->googleMapKey;
            $geo_request    = Http::get($geo_request);
            if ($geo_request->failed()) {
                $response['type']             = 'error';
                $response['title']             = __('general.alert_error_title');
                $response['message']         = __('general.went_wrong');
            } elseif ($geo_request->status() == 200) {

                $body = json_decode($geo_request->body(), true);

                if ($body['status'] == 'OK') {

                    $geo_data = $body['results'][0];

                    for ($i = 0; $i < count($geo_data['address_components']); $i++) {
                        $addressType = $geo_data['address_components'][$i]['types'][0];

                        if ($addressType == "locality") {
                            $geo_code_data['locality']['long_name']     = $geo_data['address_components'][$i]['long_name'];
                            $geo_code_data['locality']['short_name']     = $geo_data['address_components'][$i]['short_name'];
                        }

                        if ($addressType == "country") {
                            $geo_code_data['country']['long_name']     = $geo_data['address_components'][$i]['long_name'];
                            $geo_code_data['country']['short_name']     = $geo_data['address_components'][$i]['short_name'];
                        }

                        if ($addressType == "administrative_area_level_1") {
                            $geo_code_data['administrative_area_level_1']['long_name']         = $geo_data['address_components'][$i]['long_name'];
                            $geo_code_data['administrative_area_level_1']['short_name']     = $geo_data['address_components'][$i]['short_name'];
                        }

                        if ($addressType == "administrative_area_level_2") {
                            $geo_code_data['administrative_area_level_1']['long_name']         = $geo_data['address_components'][$i]['long_name'];
                            $geo_code_data['administrative_area_level_1']['short_name']     = $geo_data['address_components'][$i]['short_name'];
                        }

                        $geo_code_data['address']     = $geo_data['formatted_address'];
                        $geo_code_data['lng']         = $geo_data['geometry']['location']['lng'];
                        $geo_code_data['lat']         = $geo_data['geometry']['location']['lat'];
                    }
                    $found_region    = !empty($geo_code_data['country']['short_name']) ? $geo_code_data['country']['short_name'] : '';
                    if (!empty($found_region) && $found_region != $region_name) {
                        $response['type']             = 'error';
                        $response['title']             = __('general.alert_error_title');
                        $response['message']         = __('general.zipcode_error');
                    } else {
                        $response['type']           = 'success';
                        $response['geo_data']   = $geo_code_data;
                    }
                } else {
                    $response['type']             = 'error';
                    $response['title']             = __('general.alert_error_title');
                    $response['message']         = __('general.zipcode_error');
                }
            }
        }
        return $response;
    }


    public function getAddress($addressable): Address | NULL {
        if ($addressable == 'App\Models\User')
            return $this->getUserAddress();
        elseif ($addressable == 'App\Models\TuitionSetting')
            return $this->getTuitionSettingAddress();
        elseif ($addressable == 'App\Models\BillingDetail')
            return $this->getBillingAddress();
        else
            return NULL;
    }

    public function getUserAddress(): Address | NULL {
        return $this->user->address()->first();
    }

    public function getTuitionSettingAddress(): Address | NULL {
        return $this->user->tuitionSetting()->first()?->address()->first();
    }

    public function getBillingAddress(): Address  | NULL {
        return $this->user->billingDetail()->first()?->address()->first();
    }
}
