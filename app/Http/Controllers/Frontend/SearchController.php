<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Country;
use App\Services\SiteService;
use App\Services\SubjectService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function findTutors(Request $request)
    {
        $service            = new SubjectService(Auth::user());
        $subjectGroups      = $service->getSubjectGroups();
        $subjects           = $service->getSubjects();
        $helpContent        = setting('_tutor');
        $countries          = [];
        $languages          = (new SiteService)->getLanguages();
        $searchOnlyCities   = setting('_api.search_only_cities') ?? '0';
        $country            = Country::where('id', setting('_api.country_wise_restriction'))->first();
        $selectedCountry    = $country ? $country->short_code : null;
        if(empty(setting('_api.google_places_api_key'))){
            $countries = (new SiteService)->getCountries();

        }
        $filters = array();
        $filters['session_type'] = $request->get('session_type') ?? '';
        $filters['keyword']      = $request->get('keyword') ?? null;
        $filters['group_id']     = $request->get('group_id') ?? null;
        $filters['subject_id']   = array_filter(explode(',', $request->get('subject_id')), fn($value, $key) => $key !== 0 || $value !== '', ARRAY_FILTER_USE_BOTH);
        $filters['language_id']  = array_filter(explode(',', $request->get('language_id')), fn($value, $key) => $key !== 0 || $value !== '', ARRAY_FILTER_USE_BOTH);
        $filters['max_price']    = $request->get('max_price') ?? null;
        $filters['country']      = $request->get('country') ?? null;
        $filters['address']      = $request->get('address') ?? null;
        $filters['sort_by']      = $request->get('sort_by') ?? null;
        return view('frontend.find-tutors', compact('subjectGroups','subjects', 'helpContent', 'countries', 'languages', 'filters', 'searchOnlyCities', 'selectedCountry'));
    }

    public function tutorDetail(Request $request,$slug)
    {
        $siteService  = new SiteService();
        $tutor = $siteService->getTutorDetail($slug);
        if(empty($tutor)){
            abort('404');
        }

        $totalSlots = $tutor->subjects->flatMap(function ($subject) {
            return $subject->slots;
        })->count();
        $user = Auth::user();
        $userService = new UserService($user);
        $isFavourite = $userService->isFavouriteUser($tutor?->id ?? 0);
        $isAdmin = auth()?->user() && auth()?->user()?->hasRole('admin') ?? true;
        if($tutor?->profile?->verified_at || $isAdmin){
            $reviews       = Rating::where('tutor_id',$tutor->id)->count();
            $courses = [];
            if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses')){
                $courses = getFeaturedCourses($tutor->id);
            }
            $pageTitle = $tutor->profile?->full_name;
            $pageDescription = $tutor->profile?->description;
            $metaImage = $tutor->profile?->image;
            $pageKeywords = $tutor->subjects?->pluck('subject.name')->implode(', ') ? $tutor->subjects?->pluck('subject.name')->implode(', ') : $tutor->profile?->keywords;
            return view('frontend.tutor-detail', compact('tutor','reviews', 'isFavourite','totalSlots','courses','pageTitle','pageDescription','pageKeywords','metaImage'));
        }
        abort('404'); 
    }
        
    public function favouriteTutor(Request $request)
    {
        $userId = $request?->userId ?? '';
        if ( Auth::user()?->role == 'student'){
            $userService = new UserService(Auth::user());
            $isFavourite = $userService->isFavouriteUser($userId);
            if($isFavourite){
                $userService->removeFromFavourite($userId);
            } else {
                $userService->addToFavourite($userId);
            }
            return response()->json(['type' => 'success']);
        }
    }
}
