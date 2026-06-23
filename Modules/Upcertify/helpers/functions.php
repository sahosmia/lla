<?php

use Modules\Upcertify\Models\Certificate;
use Modules\Upcertify\Models\Template;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


if (!function_exists('get_templates')) {
    function get_templates($id = null) {
        if(!empty($id)) {
            return Template::where('user_id', Auth::id())->find($id);
        }
        return  Template::where('user_id', Auth::id())->get();
    }
}

if (!function_exists('get_certificates')) {
    function get_certificates($filter = null) {
        $certificates = new Certificate();

        if(!empty($filter)){
            $certificates = $certificates->where($filter);
        }

        return $certificates->with('template')->get();
    }
}

if (!function_exists('generate_certificate')) {
    function generate_certificate($template_id, $generated_for_type, $generated_for_id, $wildcard_data = []) {

        if (empty($template_id) || !is_string($generated_for_type) || empty($generated_for_id) || !is_array($wildcard_data)) {
            throw new InvalidArgumentException('Invalid input parameters');
        }

        $hashId = Str::uuid()->toString();

        while (Certificate::where('hash_id', $hashId)->exists()) {
            $hashId = Str::uuid()->toString();
        }

        $certificate = Certificate::create([
            'hash_id' => $hashId,
            'modelable_type' => $generated_for_type,
            'modelable_id' => $generated_for_id,
            'template_id' => $template_id,
            'wildcard_data' => $wildcard_data,
        ]);

        return $certificate;
    }
}

