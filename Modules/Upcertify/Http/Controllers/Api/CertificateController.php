<?php

namespace Modules\Upcertify\Http\Controllers\Api;

use App\Traits\ApiResponser;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Modules\Upcertify\Http\Resources\CertificateCollection;
use Modules\Upcertify\Http\Resources\CertificateResource;
use Modules\Upcertify\Http\Resources\TemplateCollection;
use Modules\Upcertify\Models\Certificate;
use Modules\Upcertify\Models\Template;
use Symfony\Component\HttpFoundation\Response;

class CertificateController extends Controller
{
    use ApiResponser;


    public function certificateList(Request $request)
    {
        $certificates = Template::select('id', 'title', 'thumbnail_url')
            ->where('user_id', Auth::id())
            ->when(!empty($request->keyword), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->keyword . '%');
            })
            ->orderBy('id', 'desc')->paginate(setting('_general.per_page_record') ?? 10);

        return $this->success(data: new TemplateCollection($certificates),  code: Response::HTTP_OK);
    }

    public function studentCertificateList(Request $request)
    {
        $keyword = $request->keyword;

        $certificates = Certificate::select('id', 'template_id', 'modelable_id', 'wildcard_data', 'created_at', 'hash_id')
            ->withWhereHas('template', function ($query) use ($keyword) {
                $query->select('id', 'title', 'thumbnail_url')
                    ->when(!empty($keyword), fn() => $query->where('title', 'like', '%' . $keyword . '%'));
            })
            ->where('modelable_id', Auth::user()?->id)
            ->orderBy('id', 'desc')
            ->paginate(setting('_general.per_page_record') ?? 10);

        return $this->success(data: new CertificateCollection($certificates), code: Response::HTTP_OK);
    }

    public function deleteCertificate(Request $request)
    {
        if (isDemoSite()) {
            return $this->error(__('general.demosite_res_txt'), Response::HTTP_BAD_REQUEST);
        }

        $id = $request->id;
        if (empty($id) || !is_numeric($id)) {
            return $this->error(message: __('upcertify::upcertify.invalid_id'), code: Response::HTTP_BAD_REQUEST);
        }

        $template = Template::whereKey($id)->whereUserId(Auth::user()?->id)->first();

        if (empty($template)) {
            return $this->error(message: __('upcertify::upcertify.template_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        $certificatesCount = Certificate::where('template_id', $id)->count();

        if ($certificatesCount == 0) {
            $template->delete();
            return $this->success(message: __('upcertify::upcertify.template_deleted_successfully'), code: Response::HTTP_OK);
        } else {
            return $this->error(message: __('upcertify::upcertify.templace_cannot_be_deleted'), code: Response::HTTP_BAD_REQUEST);
        }
    }
}
