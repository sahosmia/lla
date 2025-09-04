<?php

namespace App\Services;

use App\Casts\BookingStatus;
use App\Casts\UserStatusCast;
use App\Models\Country;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Rating;
use App\Models\Setting;
use App\Models\CountryState;
use App\Models\MenuItem;
use App\Models\SlotBooking;
use App\Models\User;
use App\Models\UserSubjectSlot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SiteService
{

    public function getTutors($data = array())
    {
        $preciseLocationSearch = setting('_api.precise_location_search') ?? '0';
        $instructors = User::select('users.id', 'users.status')
            ->where('status', array_search('active', (new UserStatusCast)->getStatus()))
            ->whereHas('roles', fn($query)  => $query->whereName('tutor'));
        $instructors->with(['subjects' => function ($query) {
            $query->withCount(['slots as sessions' => fn($query) => $query->where('end_time', '>=', now())]);
            $query->with('subject:id,name');
        }, 'languages:id,name', 'address']);
        if (!empty($data['language_id'])) {
            $instructors->whereHas('languages', function ($query) use ($data) {
                $query->whereIn('language_id', $data['language_id']);
            });
        }
        if (!empty($data['session_type'])) {
            $instructors->whereHas('subjects.slots', function ($slot) use ($data) {
                $slot->where(function ($slot) use ($data) {
                    if ($data['session_type'] == 'one') {
                        $slot->where('spaces', '=', 1);
                    } else {
                        $slot->where('spaces', '>', 1);
                    }
                });
            });
        }

        if (!empty($data['max_price']) || !empty($data['subject_id'])) {
            $instructors->whereHas('subjects', function ($query) use ($data) {
                if (!empty($data['max_price']))
                    $query->where('hour_rate', '=', $data['max_price']);
                if (!empty($data['subject_id'])) {
                    $query->whereIn('subject_id', $data['subject_id']);
                }
            });
        }

        if (!empty($data['group_id'])) {
            $instructors->whereHas('groups', function ($query) use ($data) {
                $query->whereSubjectGroupId($data['group_id']);
            });
        }

        $instructors->withWhereHas('profile', function ($query) use ($data) {
            $query->whereNotNull('verified_at');
            $query->select('id', 'verified_at', 'user_id', 'first_name', 'last_name', 'image', 'gender', 'tagline', 'description', 'slug', 'intro_video');
        });

        if (!empty($data['keyword'])) {
            $keyword = '%' . $data['keyword'] . '%';

            $instructors->where(function ($query) use ($keyword) {
                $query->whereHas('profile', function ($q) use ($keyword) {
                    $q->where('first_name', 'like', $keyword)
                        ->orWhere('last_name', 'like', $keyword);
                });

                $query->orWhereHas('subjects.subject', function ($q) use ($keyword) {
                    $q->where('name', 'like', $keyword);
                });

                $query->orWhereHas('groups.group', function ($q) use ($keyword) {
                    $q->where('name', 'like', $keyword);
                });
            });
        }

        if (!empty($data['address']) && $preciseLocationSearch) {
            $instructors->whereHas('address', function ($query) use ($data) {                
                if (!empty($data['address'])) {
                    $query->where('address', 'like', '%' . $data['address'] . '%');
                }
            });
      
        } else if (!empty($data['country'])) {
            $instructors->whereHas('address.country', function ($address) use ($data) {
                $address->where('name', 'like', '%' . $data['country'] . '%');
                $address->orWhere('id', $data['country']);
            });
        }

        if (!empty($data['rating'])) {
            $instructors->whereHas('reviews', function ($query) use ($data) {
                $query->select('user_id');
                $query->groupBy('user_id');
                $query->havingRaw('avg(rating) >= ?', (array)$data['rating']);
            });
        }

        $instructors->withMin('subjects as min_price', 'hour_rate')
            ->withAvg('reviews as avg_rating', 'rating')
            ->withCount('reviews as total_reviews')
            ->withCount('bookingSlots as active_students');

        if (!empty($data['sort_by'])) {
            if ($data['sort_by'] == 'newest') {
                $instructors->orderBy('created_at', 'desc');
            } else if ($data['sort_by'] == 'oldest') {
                $instructors->orderBy('created_at', 'asc');
            } else if (!empty($data['sort_by'])) {
                if ($data['sort_by'] == 'asc') {
                    $instructors->join('profiles', 'profiles.user_id', '=', 'users.id')->orderBy('first_name', 'asc');
                } else if ($data['sort_by'] == 'desc') {
                    $instructors->join('profiles', 'profiles.user_id', '=', 'users.id')->orderBy('first_name', 'desc');
                }
            }
        } else {
            $instructors->orderBy('avg_rating', 'desc');
            $instructors->orderBy('created_at', 'desc');
        }
        return $instructors->paginate(!empty($data['per_page']) ? $data['per_page'] : (setting('_general.per_page_opt') ?? 10));
    }

    public function getRecommendedTutors($filters = [])
    {
        $tutors = User::select('id')->role('tutor');
        $tutors->with(['subjects' => function ($query) {
            $query->withCount(['slots as sessions' => fn($query) => $query->where('end_time', '>=', now())]);
            $query->with('subject:id,name');
        }, 'languages:id,name']);

        $tutors->with(['address' => function ($query) {
            $query->select('id', 'addressable_id', 'addressable_type', 'country_id')
                ->with(['country' => function ($countryQuery) {
                    $countryQuery->select('id', 'name', 'short_code');
                }]);
        }]);

        $tutors->withMin('subjects as min_price', 'hour_rate')
            ->withAvg('reviews as avg_rating', 'rating')
            ->withCount('reviews as total_reviews')
            ->withCount(['bookingSlots as active_students' => function ($query) {
                $query->whereStatus(BookingStatus::$statuses['active']);
            }]);
        $tutors->withWhereHas('profile', function ($query) {
            $query->whereNotNull('verified_at');
            $query->whereNotNull('intro_video');
            $query->select('id', 'user_id', 'first_name', 'last_name', 'image', 'slug', 'verified_at');
        });

        if (!empty($filters['order_by']) && $filters['order_by'] == 'ratings') {
            $tutors->orderBy('avg_rating', 'desc');
        }

        return $tutors->get()->take(!empty($filters['total']) ? $filters['total'] : 10);
    }

    // public function getActiveUsers($slug) {
    //     $slots = UserSubjectSlot::select('id','start_time','spaces','total_booked')
    //     ->whereHas('subjectGroupSubjects', function($groupSubjects) {
    //         $groupSubjects->select('id','user_subject_group_id');
    //         $groupSubjects->whereHas('userSubjectGroup', fn($query)=>$query->select('id','user_id')->whereUserId($this->user->id));
    //     })->get();
    // }

    public function getUserRole($slug)
    {
        return User::whereHas('profile', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->firstOrFail()->roles->pluck('name')->first();
    }

    public function getTutorDetail($slug): User|null
    {

        $isNotAdmin  = !auth()?->user()?->hasRole('admin') ?? true;
        return User::with([
            'languages:id,name',
            'subjects.subject:id,name',
        ])
            ->when(\Nwidart\Modules\Facades\Module::has('starup') && \Nwidart\Modules\Facades\Module::isEnabled('starup'), function ($query) {
                $query->with('badges:id,name,image');
            })
            ->with('subjects', function ($query) {
                $query->withCount(['slots as sessions' => fn($query) => $query->where('end_time', '>=', now())]);
            })
            ->with(['address' => function ($query) {
                $query->select('id', 'addressable_id', 'addressable_type', 'country_id')
                    ->with(['country' => function ($countryQuery) {
                        $countryQuery->select('id', 'name', 'short_code');
                    }]);
            }])
            ->withMin('subjects as min_price', 'hour_rate')
            ->withWhereHas('profile', function ($query) use ($slug, $isNotAdmin) {
                if ($isNotAdmin) {
                    $query->whereNotNull('verified_at');
                }
                $query->whereSlug($slug);
                $query->select('id', 'user_id', 'verified_at', 'first_name', 'tagline', 'keywords', 'last_name', 'slug', 'image', 'intro_video', 'description', 'native_language');
            })
            ->withAvg('reviews as avg_rating', 'rating')
            ->withCount('reviews as total_reviews')
            ->withCount('bookingSlots as active_students')
            ->with('socialProfiles')
            ->first();
    }


    public function getStudentProfile($slug): User
    {
        return User::whereHas(
            'profile',
            function ($query) use ($slug) {
                $query->whereSlug($slug);
            }
        )->with('languages', 'contacts')->firstOrFail();
    }

    public function getRelatedInstructors($user)
    {
        return User::select('id')
            ->whereHas('groups', function ($query) use ($user) {
                $query->whereIn('subject_group_id', $user->groups->pluck('subject_group_id'));
            })->whereHas('subjects', function ($query) use ($user) {
                $query->whereIn('subject_id', $user->subjects->pluck('subject_id'));
            })->with(['contacts', 'profile' => function ($query) {
                $query->select('id', 'user_id', 'verified_at', 'feature_expired_at', 'first_name', 'last_name', 'slug', 'image');
            }])
            ->with('educations')
            ->withAvg('reviews as avg_rating', 'rating')
            ->withCount('reviews as total_reviews')
            ->where('id', '<>', $user->id)
            ->withMin('subjects as min_price', 'hour_rate')->withMax('subjects as max_price', 'hour_rate')->role('instructor')->limit(3)->get();
    }

    public function getUserReviews($userId)
    {
        return User::find($userId)->select('id')->with([
            'profile' => function ($query) {
                $query->select('id', 'user_id', 'verified_at', 'first_name', 'last_name');
            },
            'reviews'
        ])->get();
    }

    public function getCountries()
    {
        return Country::get(['id', 'name']);
    }

    public function getLanguages()
    {
        return  Language::get(['id', 'name']);
    }

    public function getStates()
    {
        return CountryState::get(['id', 'name']);
    }

    public function getState($id)
    {
        return CountryState::where('id', $id)->get(['id', 'name'])->first();
    }

    /**
     * Get site menu
     * @param void
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSiteMenu($location, $name = null)
    {
        $header_menu = collect();
        $menu = Cache::rememberForever('menu-' . $location . '-' . $name, function () use ($location, $name) {
            return Menu::select('id', 'name')
                ->where('location', $location)
                ->when(!empty($name), function ($query) use ($name) {
                    $query->where('name', $name);
                })
                ->latest()
                ->first();
        });

        if (!empty($menu)) {
            $header_menu = Cache::rememberForever('menu-items-' . $menu->id, function () use ($menu) {
                return MenuItem::where('menu_id', $menu->id)
                    ->orderBy('sort', 'asc')
                    ->tree()
                    ->get()
                    ->toTree();
            });
        }
        return $header_menu;
    }

    public function getMatchingInstructors($user)
    {
        $userSubjects = $user?->subjects->pluck('subject_id')->toArray();
        $withRelations = [
            'address' => function ($query) {
                $query->with('country');
            },
            'languages',
            'educations',
            'subjects.subject',
        ];

        if (Auth::check()) {
            $withRelations['favouriteByUsers'] = function ($query) {
                $query->where('user_id', Auth::user()?->id);
            };
        }

        return User::withWhereHas('profile', function ($query) {
            $query->whereNotNull('verified_at');
        })
            ->with($withRelations)
            ->withMin('subjects as min_price', 'hour_rate')
            ->whereHas('subjects', function ($query) use ($userSubjects) {
                $query->whereIn('subject_id', $userSubjects);
            })
            ->where('id', '!=', $user->id)
            ->withAvg('reviews as avg_rating', 'rating')
            ->withCount('reviews as total_reviews')
            ->withCount(['bookingSlots as active_students' => function ($query) {
                $query->whereStatus(BookingStatus::$statuses['active']);
            }])
            ->where('status', 1)
            ->get()->take(4);
    }

    public function featuredTutors()
    {
        $featuredTutors = User::select('id')->role('tutor')
            ->withWhereHas(
                'profile',
                function ($query) {
                    $query->select('id', 'user_id', 'slug', 'tagline', 'verified_at', 'first_name', 'last_name', 'image', 'intro_video', 'description');
                    $query->whereNotNull('verified_at');
                }
            )
            ->with([
                'address' => function ($query) {
                    $query->with('state', 'country');
                },
                'educations',
                'subjects.subject',
            ])->withCount(['bookingSlots as active_students' => function ($query) {
                $query->whereStatus(BookingStatus::$statuses['active']);
            }])
            ->withMin('subjects as min_price', 'hour_rate')
            ->withAvg('reviews as avg_rating', 'rating')
            ->withCount('reviews as total_reviews')
            // ->take(10)
            ->inRandomOrder()
            ->whereStatus(1)
            ->get();
        return $featuredTutors;
    }

    public function clientsFeedback()
    {
        $user = Auth::user();
        $allRatings = range(1, 5);
        $allTutorRatings = Rating::with('profile')->get();
        return $allTutorRatings;
    }
}
