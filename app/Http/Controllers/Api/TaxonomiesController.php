<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Http\Resources\CountryResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\StateResource;
use App\Services\SiteService;

class TaxonomiesController extends Controller
{
    use ApiResponser;

    public function getCountries()
    {
        $countries  = (new SiteService)->getCountries();
        return $this->success(data: CountryResource::collection($countries));
    }

    public function getLanguages()
    {
        $languages  = (new SiteService)->getLanguages();
        return $this->success(data: LanguageResource::collection($languages));
    }

    public function getStates()
    {
        $states  = (new SiteService)->getStates();
        return $this->success(data: StateResource::collection($states));
    }
}
