<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Services\OptionBuilderService;
use Illuminate\Support\Facades\Lang;
use Nwidart\Modules\Facades\Module;

use PDO;

class OptionBuilderController extends Controller
{
    use ApiResponser;

    public function getOpSettings(Request $request) {
        $methods            = [];
        $settings           = [];
        $installedAddons    = [];
        $settings           = (new OptionBuilderService)->getPublicKeys();

        $settings['_lernen']['payment_enabled']           = $settings['_lernen']['payment_enabled'] ?? 'yes';

        $defaultLang        = setting('_general.default_language') ?? 'en';
        app()->setLocale($defaultLang);
        $selectedLang       = getTranslatedLanguages(app()->getLocale());
        if(!empty($selectedLang->rtl)){
            $settings['_general']['enable_rtl'] = '1';
        }

        $module = Module::all();
        $addons = getAddons();
        foreach($module as $mod){
            $installedAddons[$addons[$mod->getLowerName()]['name'] ?? $mod->getName()] = $mod->isEnabled() ? true : false;
        }

        $settings['translations'] = Lang::get('app');
        $methods            = setting('admin_settings.payment_method') ?? [];
        $defaultMethod      = setting('admin_settings.default_payment_method');
        $paymentMethods = [];
    
        foreach ($methods as $method => $details) {
            if ($details['status'] === 'on') {
                $imagePath = asset('images/payment_methods/' . strtolower($method) . '.png');
                $paymentMethods[] = [
                    'name'          => ucfirst($method),
                    'slug'          => $method,
                    'image'         => $imagePath,
                    'is_selected'   => $method === $defaultMethod,
                ];
            }
        }
        $settings['payment_methods'] = $paymentMethods;
        $settings['installed_addons'] = $installedAddons;
        foreach($settings as $key => $value){
            if($key == '_app'){
                $settings[$key]['app_logo']             = $value['app_logo'] ?? null;
                $settings[$key]['app_splash']           = $value['app_splash'] ?? null;
                $settings[$key]['app_bg_color']         = $this->convertColor($value['app_bg_color'] ?? null);
                $settings[$key]['app_pri_color']        = $this->convertColor($value['app_pri_color'] ?? null);
                $settings[$key]['app_sec_color']        = $this->convertColor($value['app_sec_color'] ?? null);
                $settings[$key]['app_card_bg_color']    = $this->convertColor($value['app_card_bg_color'] ?? null);
            }
        }
        $settings['broadcasting'] = config('broadcasting.connections.'.config('broadcasting.default'));
        return $this->success(data: $settings, message: __('api.settings_retrieved_successfully'));
    }
    
    public function rearrangeArray($array) {
        return array_map(function($details) {
            if (isset($details['keys'])) {
                $details = array_merge($details, $details['keys']);
                unset($details['keys']);
            }
            if (isset($details['ipn_url_type'])) {
                unset($details['ipn_url_type']);
            }
            return $details;
        }, $array);
    }

    protected function convertColor($color) {
        if (preg_match('/^#([a-fA-F0-9]{6})([a-fA-F0-9]{2})?$/', $color, $matches)) {
            $hex = strtoupper($matches[1]);
            $alpha = isset($matches[2]) ? strtoupper($matches[2]) : 'FF';
            return "0x{$alpha}{$hex}";
        } elseif (preg_match('/^rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})(?:\s*,\s*(0|0?\.\d+|1(\.0+)?))?\s*\)$/', $color, $matches)) {
            $r = intval($matches[1]);
            $g = intval($matches[2]);
            $b = intval($matches[3]);
            
            if ($r >= 0 && $r <= 255 && $g >= 0 && $g <= 255 && $b >= 0 && $b <= 255) {
                $alpha = isset($matches[4]) ? sprintf('%02X', intval(floatval($matches[4]) * 255)) : 'FF';
                $hex = sprintf('%02X%02X%02X', $r, $g, $b);
                return "0x{$alpha}{$hex}";
            }
        } else {
            return '0xFF000000';
        }
    }
}
