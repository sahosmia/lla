<?php

namespace Modules\Upcertify\Http\Controllers;

use Modules\Upcertify\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class CertificateController extends Controller
{
    public function __invoke(Request $request)
    {
        $id         = $request->id ?? null;
        $extends    = 'upcertify::layouts.app';
        $component  = 'create-certificate';
        $props      = ['record_id' => $id];
        $load_livewire_scripts  = true;
        $load_livewire_styles   = true;
        $load_jquery            = true;
        return view('upcertify::index', compact('props', 'extends', 'component', 'load_livewire_scripts', 'load_livewire_styles', 'load_jquery'));
    }

    public function certificateList()
    {
        $extends = !empty(config('upcertify.layout')) ?  config('upcertify.layout') : 'upcertify::layouts.app';
        $component = 'certificate-list';
        $load_livewire_scripts = config('upcertify.livewire_scripts') ?? false;
        $load_livewire_styles = config('upcertify.livewire_styles') ?? false;
        $load_jquery = config('upcertify.add_jquery') ?? false;
        return view('upcertify::index', compact('extends', 'component', 'load_livewire_scripts', 'load_livewire_styles', 'load_jquery'));
    }

    public function viewCertificate(Request $request, $uid)
    {

        $certificate = Certificate::whereHashId($uid)->with('template:id,body')->first();
        if (empty($certificate)) {
            return abort(404);
        }

        $wildcard_data = $certificate?->wildcard_data;
        $template_body = $certificate?->template?->body;

        if (!empty($template_body['elementsInfo'])) {
            foreach ($template_body['elementsInfo'] as $key => &$element) {
                $wildcardName = $element['wildcardName'];
                if (array_key_exists($wildcardName, $wildcard_data)) {
                    $element['wildcardName'] =  $wildcard_data[$wildcardName];
                }
            }
        }

        $body = $template_body;

        return view('upcertify::front-end.certificate', compact('body', 'uid'));
    }

    public function takeCertificateShort(Request $request, $uid)
    {
        $certificate = Certificate::whereHashId($uid)->with('template:id,body')->first();

        if (empty($certificate)) {
            return abort(404);
        }
        $wildcard_data = $certificate?->wildcard_data;
        $template_body = $certificate?->template?->body;

        if (!empty($template_body['elementsInfo'])) {
            foreach ($template_body['elementsInfo'] as $key => &$element) {
                $wildcardName = $element['wildcardName'];
                if (array_key_exists($wildcardName, $wildcard_data)) {
                    $element['wildcardName'] =  $wildcard_data[$wildcardName];
                }
            }
        }

        $body = $template_body;
        $page = 'template';

        return view('upcertify::front-end.download', compact('body'));
    }


    public function getCertificate(Request $request, $uid)
    {

        $certificate = Certificate::whereHashId($uid)->with('template:id,title')->first();
        if (empty($certificate)) {
            return abort(404);
        }

        try {
            $file = Browsershot::url(route('upcertify.certificate-short', ['uid' => $uid]))
                ->setOption('args', ['--disable-web-security'])
                ->format('Letter')
                ->margins(0, 0, 0, 0)
                ->pages('1')
                ->waitUntilNetworkIdle()
                ->showBackground()
                ->setChromePath(env('CHROME_PATH', '/usr/bin/google-chrome'))
                ->pdf();

            $filename = Str::slug($certificate?->template?->title) . '.pdf';
            $storagePath = sys_get_temp_dir();
            $filePath = $storagePath . '/' . $filename;
            file_put_contents($filePath, $file);

            return response()->download($filePath, $filename)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return abort(500);
        }
    }
}
