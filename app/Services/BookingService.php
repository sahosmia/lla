<?php

namespace App\Services;

use App\Casts\BookingStatus;
use App\Jobs\CompleteBookingJob;
use App\Jobs\CompleteFreePurchaseJob;
use App\Jobs\CreateGoogleCalendarEventJob;
use App\Jobs\RemoveBookingReservationJob;
use App\Jobs\SendDbNotificationJob;
use App\Jobs\SendNotificationJob;
use App\Models\OrderItem;
use App\Models\SlotBooking;
use App\Models\User;
use App\Models\UserSubjectGroupSubject;
use App\Models\UserSubjectSlot;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Google\Service\Calendar\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Modules\CourseBundles\Models\Bundle;
use Modules\CourseBundles\Services\BundleService;
use Modules\Courses\Models\Course;
use Modules\Courses\Services\CourseService;

class BookingService
{

    public $user;

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    public function getAvailableSlots($subjectGroupIds, $date)
    {
        $myData = array();
        $slots = UserSubjectSlot::select('id', 'start_time', 'spaces', 'total_booked')
            ->whereHas('subjectGroupSubjects', function ($groupSubjects) use ($subjectGroupIds) {
                $groupSubjects->select('id', 'user_subject_group_id');
                $groupSubjects->whereHas('userSubjectGroup', fn($query) => $query->select('id', 'user_id')->whereUserId($this->user->id));
                if ($subjectGroupIds) {
                    $groupSubjects->whereIn('id', $subjectGroupIds);
                }
            })
            ->where('start_time', '>=', $date->copy()->firstOfMonth()->toDateString())
            ->where('end_time', '<=', $date->copy()->lastOfMonth()->toDateString())
            ->orderBy('start_time')->get();
        if ($slots->isNotEmpty()) {
            foreach ($slots as $slot) {
                $date = parseToUserTz($slot->start_time)->toDateString();
                if (array_key_exists($date, $myData)) {
                    $myData[$date]['all_slots'] += $slot->spaces;
                    $myData[$date]['booked_slots'] += $slot->total_booked;
                } else {
                    $myData[$date]['all_slots'] = $slot->spaces;
                    $myData[$date]['booked_slots'] = $slot->total_booked;
                }
            }
        }
        return $myData;
    }

    /**
     * Get available slots for a given subject group subject.
     *
     * @param mixed $subjectGroupSubjects
     * @param string $dateFormat
     * @param string $timeFormat
     * @return array
     */

    public function getAvailableSubjectSlots($subjectGroupSubjects, $dateFormat = "F j Y", $timeFormat = "h:i a", $status = null)
    {

        $userTimeZone = getUserTimezone() ?? 'UTC';
        return UserSubjectSlot::where('user_subject_group_subject_id', $subjectGroupSubjects)
            ->orderBy('start_time')
            ->select('start_time', 'end_time', 'id')
            ->get()
            ->reject(function ($slotData) use ($status) {
                if ($status !== 'published') {
                    return Carbon::parse($slotData->start_time)->isPast();
                }
                return false;
            })
            ->map(function ($slot) use ($dateFormat, $timeFormat, $userTimeZone) {
                $timeFormat = $timeFormat == "12" ? "h:i a" :  "H:i";
                $startTime = parseToUserTz($slot->start_time, $userTimeZone);
                $endTime = parseToUserTz($slot->end_time, $userTimeZone);

                return [
                    'id' => $slot->id,
                    'text' => $startTime->format("$dateFormat ($timeFormat") . ' - ' . $endTime->format("$timeFormat)"),
                ];
            })
            ->toArray();
    }


    public function getTutorAvailableSlots($userId, $userTimeZone, $date, $filter = [])
    {
        $myData = array();
        $slots = UserSubjectSlot::withWhereHas('subjectGroupSubjects', function ($query) use ($userId, $filter) {
            $query->select('id', 'user_subject_group_id', 'subject_id', 'hour_rate', 'image');
            $query->withWhereHas('userSubjectGroup', function ($subjectGroup) use ($userId, $filter) {
                $subjectGroup->with('group:id,name');
                $subjectGroup->select('id', 'user_id', 'subject_group_id')->where('user_id', $userId);
            });

            if (!empty($filter['subject_group_ids'])) {
                $query->whereIn('id', $filter['subject_group_ids']);
            }

            $query->with('subject:id,name');
            if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')) {
                $query->with(
                    'coupons',
                    fn($query) => $query->select('id', 'couponable_id', 'couponable_type', 'code', 'discount_type', 'discount_value')
                        ->where('status', \Modules\KuponDeal\Casts\StatusCast::$statuses['active'])->where('expiry_date', '>=', now())
                        ->where('auto_apply', 1)
                        ->oldest()
                        ->limit(1)
                );
            }
        });

        if (auth()->check() && auth()->user()->role == 'student') {
            $slots->with(['bookings' => fn($booking) => $booking->select('id', 'user_subject_slot_id')->where('student_id', auth()->user()->id)]);
        }

        if (!empty($filter['type']) && $filter['type'] != '*') {
            if ($filter['type'] == 'one') {
                $slots = $slots->where('spaces', '=', 1);
            } else {
                $slots = $slots->where('spaces', '>', 1);
            }
        }

        $slots = $slots->when($date, function ($slots) use ($date) {
            $slots->where('start_time', '>=', $date['start_date']);
            $slots->where('end_time', '<=', $date['end_date']);
        })->orderBy('start_time', 'asc')->get();

        if ($slots->isNotEmpty()) {
            foreach ($slots as $slot) {
                $start_time = Carbon::parse($slot->start_time)->setTimezone($userTimeZone);
                if ($start_time->isPast()) {
                    continue;
                }
                $myData[$start_time->toDateString()][] = $slot;
            }
        }
        return $myData;
    }

    public function getSlotDetail($id, $relations = true)
    {
        return UserSubjectSlot::when(!empty($relations), function ($relations) {
            $relations->with(['subjectGroupSubjects' => function ($query) {
                $query->select('id', 'user_subject_group_id', 'subject_id', 'hour_rate', 'image');
                $query->withWhereHas('userSubjectGroup', function ($subjectGroup) {
                    $subjectGroup->with('group:id,name');
                    $subjectGroup->select('id', 'user_id', 'subject_group_id');
                });
                $query->with('subject:id,name');
            }]);
        })->find($id);
    }

    public function getSessionSlots()
    {
        $userId = $this->user->id;
        $myData = [];

        $slots = UserSubjectSlot::with(['subjectGroupSubjects' => function ($query) use ($userId) {
            $query->withWhereHas('userSubjectGroup', function ($subjectGroup) use ($userId) {
                $subjectGroup->where('user_id', $userId);
            });
            $query->with('subject');
        }])->get();

        foreach ($slots as $slot) {
            $subject = $slot->subjectGroupSubjects?->subject?->name;
            $date = parseToUserTz($slot->date)->format('Y-m-d');

            if (!isset($myData[$date])) {
                $myData[$date] = [
                    'slots' => 0,
                    'subjects' => []
                ];
            }

            $myData[$date]['slots']++;

            if (!isset($myData[$date]['subjects'][$subject])) {
                $myData[$date]['subjects'][$subject] = 0;
            }

            $myData[$date]['subjects'][$subject]++;
        }

        return $myData;
    }

    public function getUserSubjectGroupSubjects($userSubjectGroupId): Collection
    {
        return $this->user->subjects()->whereUserSubjectGroupId($userSubjectGroupId)->get();
    }

    public function getUserSubjectSlots($date = null)
    {
        $slotsData = array();
        $slots = UserSubjectSlot::select('id', 'user_subject_group_subject_id', 'start_time', 'end_time', 'spaces', 'session_fee', 'total_booked', 'description', 'meta_data')
            ->withCount('bookings')
            ->with('students', fn($query) => $query->select('profiles.id', 'profiles.user_id', 'profiles.image')->limit(5))
            ->withWhereHas('subjectGroupSubjects', function ($query) {
                $query->select('id', 'user_subject_group_id', 'subject_id', 'hour_rate', 'image');
                $query->withWhereHas('userSubjectGroup', function ($subjectGroup) {
                    $subjectGroup->with('group:id,name');
                    $subjectGroup->select('id', 'user_id', 'subject_group_id')->where('user_id', $this->user->id);
                });
                $query->with('subject:id,name');
            })
            ->when($date, function ($slots) use ($date) {
                $slots->where('start_time', '>=', $date['start_date']);
                $slots->where('end_time', '<=', $date['end_date']);
            })
            ->orderBy('start_time')
            ->get();
        if ($slots->isNotEmpty()) {
            foreach ($slots as $item) {
                $group = $item->subjectGroupSubjects?->userSubjectGroup?->group?->name;
                $subject  = $item?->subjectGroupSubjects?->subject;
                $slotsData[$group][$subject?->name]['slots'][] = $item;
                $slotsData[$group][$subject?->name]['info'] = [
                    'user_subject_id'       => $item?->subjectGroupSubjects?->id,
                    'user_subject_group_id' => $item?->subjectGroupSubjects?->user_subject_group_id,
                    'subject_id'            => $item?->subjectGroupSubjects?->subject_id,
                    'subject'               => $subject?->name,
                    'hour_rate'             => $item?->subjectGroupSubjects?->hour_rate,
                    'image'                 => $item?->subjectGroupSubjects?->image,
                ];
            }
        }
        return $slotsData;
    }

    public function getUserBookings($date, $showBy = 'daily', $filters = [])
    {
        $bookingData = array();
        $bookings = SlotBooking::select('id', 'tutor_id', 'student_id', 'user_subject_slot_id', 'session_fee', 'start_time', 'end_time', 'status')
            ->with('tutor:profiles.id,profiles.user_id,first_name,last_name,image')
            ->withExists('rating')
            ->with('dispute')
            ->withWhereHas('slot', function ($slot) use ($date, $filters) {
                $slot->withCount('bookings')
                    ->with('students', fn($query) => $query->select('profiles.id', 'profiles.user_id', 'profiles.image', 'profiles.first_name', 'profiles.last_name')->limit(5))
                    ->withWhereHas('subjectGroupSubjects', function ($query) use ($filters) {
                        $query->with('subject:subjects.id,subjects.name', 'group:subject_groups.id,subject_groups.name');
                        if (!empty($filters['subject_group_ids'])) {
                            $query->whereIn('id', $filters['subject_group_ids']);
                        }
                    });
                if (!empty($filters['type']) && $filters['type'] == 'one') {
                    $slot->where('spaces', 1);
                }
                if (!empty($filters['type']) && $filters['type'] == 'group') {
                    $slot->where('spaces', '>', 1);
                }
                if ($this->user->role == 'tutor') {
                    $slot->where('start_time', '>=', $date['start_date']);
                    $slot->where('end_time', '<=', $date['end_date']);
                }
                if (!empty($filters['keyword'])) {
                    $slot->where(function ($query) use ($filters) {
                        $query->whereHas('students', function ($studentQuery) use ($filters) {
                            $studentQuery->where(function ($studentNameQuery) use ($filters) {
                                $studentNameQuery->where('profiles.first_name', 'like', "%{$filters['keyword']}%")
                                    ->orWhere('profiles.last_name', 'like', "%{$filters['keyword']}%")
                                    ->orWhereRaw("CONCAT(profiles.first_name, ' ', profiles.last_name) LIKE ?", ["%{$filters['keyword']}%"]);
                            });
                        })
                            ->orWhereHas('subjectGroupSubjects.subject', function ($subjectQuery) use ($filters) {
                                $subjectQuery->where('name', 'like', "%{$filters['keyword']}%");
                            })
                            ->orWhereHas('subjectGroupSubjects.group', function ($userSubjectGroupQuery) use ($filters) {
                                $userSubjectGroupQuery->where('subject_groups.name', 'like', "%{$filters['keyword']}%");
                            });
                    });
                }
            })
            ->when($this->user->role == 'tutor', fn($query) => $query->whereTutorId($this->user->id)->whereIn('status', [BookingStatus::$statuses['active']]))
            ->when($this->user->role == 'student', function ($query) use ($date) {
                $query->whereStudentId($this->user->id);
                $query->where('start_time', '>=', $date['start_date']);
                $query->where('end_time', '<=', $date['end_date']);
                $query->whereIn('status', [BookingStatus::$statuses['active'], BookingStatus::$statuses['rescheduled'], BookingStatus::$statuses['completed'], BookingStatus::$statuses['disputed']]);
            })
            ->get();

        if ($bookings->isEmpty()) {
            return [];
        }
        if ($showBy == 'daily') {
            foreach ($bookings as $booking) {
                if ($this->user->role == 'tutor' && $booking->slot->end_time->isPast()) {
                    continue;
                }
                $bookingTime = $this->user->role == 'tutor' ? parseToUserTz($booking->slot->start_time) : parseToUserTz($booking->start_time);
                $bookingData[$bookingTime->minute(0)->second(0)->format('h:i a')][] = $booking;
            }
        } else {
            foreach ($bookings as $booking) {
                if ($this->user->role == 'tutor' && $booking->slot->end_time->isPast()) {
                    continue;
                }
                $bookingTime = $this->user->role == 'tutor' ? parseToUserTz($booking->slot->start_time) : parseToUserTz($booking->start_time);
                $bookingData[$bookingTime->toDateString()][] = $booking;
            }
        }
        return $bookingData;
    }

    public function getBookingDetail($id)
    {
        return SlotBooking::select('id', 'tutor_id', 'student_id', 'user_subject_slot_id', 'session_fee', 'start_time', 'end_time', 'status', 'meta_data')
            ->with('tutor:profiles.id,profiles.user_id,first_name,last_name,image')
            ->withWhereHas('slot', function ($slot) {
                $slot->withCount('bookings')
                    ->withWhereHas('subjectGroupSubjects', function ($query) {
                        $query->with('subject:subjects.id,subjects.name', 'group:subject_groups.id,subject_groups.name');
                    });
            })
            ->when($this->user->role == 'tutor', fn($query) => $query->whereTutorId($this->user->id))
            ->when($this->user->role == 'student', fn($query) => $query->whereStudentId($this->user->id))
            ->whereKey($id)
            ->first();
    }

    public function addBookingReview($bookingId, $ratingData)
    {
        $booking = SlotBooking::whereDoesntHave('rating')->whereKey($bookingId)->whereStudentId($this->user->id)->whereStatus(BookingStatus::$statuses['completed'])->first();
        if ($booking) {
            return $booking->rating()->create([
                'student_id' => $this->user->id,
                'tutor_id'   => $booking->tutor_id,
                'rating'     => $ratingData['rating'],
                'comment'     => $ratingData['comment'],
            ]);
        }
        return false;
    }

    public function getGroupSubjectName($id): UserSubjectGroupSubject
    {
        return UserSubjectGroupSubject::select('id', 'user_subject_group_id', 'subject_id')->whereId($id)->with(['subject' => function ($subject) {
            $subject->select('id', 'name');
        }, 'userSubjectGroup.group' => function ($group) {
            $group->select('id', 'name');
        }])->first();
    }

    public function addUserSubjectGroupSessions($slots = array())
    {
        $dates = explode(" to ", $slots['date_range']);
        if (!empty($dates[0]))
            $slots['start_date'] = $dates[0];
        if (!empty($dates[1]))
            $slots['end_date'] = $dates[1];
        else
            $slots['end_date'] = $slots['start_date'];

        $period = CarbonPeriod::create(parseToUTC($slots['start_date'] . " " . $slots['start_time']), parseToUTC($slots['end_date'] . " " . $slots['end_time']));
        $dbSlots = UserSubjectGroupSubject::select('id', 'user_subject_group_id')->find($slots['subject_group_id'])->slots()->select('id', 'user_subject_group_subject_id');
        foreach ($period as $date) {
            if (!empty($slots['recurring_days']) && !in_array($date->format('l'), (array) $slots['recurring_days'])) {
                continue;
            }
            $this->addTimeSlots($date, $slots, $dbSlots);
        }
    }

    public function addTimeSlots($date, $slots, $dbSlots)
    {
        $startTime = $endTime = $date;
        $daySlotDuration = Carbon::parse($slots['start_time'])->diffInMinutes(Carbon::parse($slots['end_time']));
        $slots['end_time'] = $date->copy()->addMinutes($daySlotDuration);
        $totalMinutes = $date->copy()->diffInMinutes($slots['end_time']);
        $totalSlots = $totalMinutes / ($slots['duration'] + $slots['break']);
        $newSlots = [];
        for ($i = 1; $i <= (int) $totalSlots; $i++) {
            if ($i > 1) {
                $startTime = $startTime->copy()->addMinutes($slots['duration'] + $slots['break']);
            }
            $endTime    = $startTime->copy()->addMinutes((int) $slots['duration']);

            $slotExists = $dbSlots->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<=', $startTime)
                        ->where('end_time', '>=', $startTime);
                })
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $endTime)
                            ->where('end_time', '>=', $endTime);
                    })
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '>=', $startTime)
                            ->where('end_time', '<=', $endTime);
                    });
            })->exists();

            $metaData = !empty($slots['template_id']) ? ['template_id' => $slots['template_id']] : null;

            if (isActiveModule('upcertify') && isActiveModule('quiz') && isset($slots['assign_quiz_certificate'])) {
                $metaData['assign_quiz_certificate'] = $slots['assign_quiz_certificate'];
            }

            if (Module::has('subscriptions') && Module::isEnabled('subscriptions') && !empty($slots['allowed_for_subscriptions'])) {
                $metaData['allowed_for_subscriptions'] = 1;
            }

            if (!$slotExists) {
                $newSlots[] = [
                    'start_time'                    => $startTime,
                    'end_time'                      => $endTime,
                    'spaces'                        => $slots['spaces'],
                    'duration'                      => $slots['duration'],
                    'session_fee'                   => $slots['session_fee'],
                    'description'                   => $slots['description'],
                    'meta_data'                     => $metaData
                ];
            }
        }

        if (!empty($newSlots)) {
            $dbSlots->createMany($newSlots);
        }
    }

    public function addSessionSlot($date, $slotData)
    {
        $date      = parseToUserTz($date);
        $startTime = parseToUTC($date->toDateString() . " " . $slotData['start_time']);
        $endTime   = parseToUTC($date->toDateString() . " " . $slotData['end_time']);
        if ($startTime->isPast()) {
            return false;
        }
        $dbSlots   = UserSubjectGroupSubject::select('id', 'user_subject_group_id')->find($slotData['subject_group_id'])->slots()->select('id', 'user_subject_group_subject_id');
        $slotExists = $dbSlots->where(function ($query) use ($startTime, $endTime) {
            $query->where(function ($query) use ($startTime) {
                $query->where('start_time', '<=', $startTime)
                    ->where('end_time', '>=', $startTime);
            })
                ->orWhere(function ($query) use ($endTime) {
                    $query->where('start_time', '<=', $endTime)
                        ->where('end_time', '>=', $endTime);
                })
                ->orWhere(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '>=', $startTime)
                        ->where('end_time', '<=', $endTime);
                });
        })->exists();

        if (!$slotExists) {
            return $dbSlots->create([
                'start_time'                    => $startTime,
                'end_time'                      => $endTime,
                'spaces'                        => $slotData['spaces'],
                'duration'                      => $startTime->diffInMinutes($endTime),
                'session_fee'                   => $slotData['session_fee'],
                'description'                   => $slotData['description'],
                'total_booked'                  => $slotData['total_booked'] ?? 0,
                'meta_data'                     => $slotData['meta_data'] ?? []
            ]);
        }
        return false;
    }

    public function rescheduleSession($slotId, $sessionData)
    {
        try {
            $slot = $this->getUserSessionSlot($slotId, ['bookings']);
            $metaData = $slot['meta_data'] ?? [];
            $metaData['reason'] = $sessionData['reason'];
            DB::beginTransaction();
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            if (!empty($slot) && $slot->total_booked > 0) {
                $slotInfo = $this->addSessionSlot(parseToUTC($sessionData['date']), [
                    'start_time'         => $sessionData['start_time'],
                    'end_time'           => $sessionData['end_time'],
                    'spaces'             => $slot->spaces,
                    'session_fee'        => $slot->session_fee,
                    'description'        => $sessionData['description'],
                    'subject_group_id'   => $sessionData['subject_group_id'],
                    'total_booked'       => 0,
                    'meta_data'          => $metaData
                ]);
                $oldBookingIds = [];
                if (!empty($slotInfo)) {
                    $newBooking = $slot->bookings->map(function ($booking) use ($slot) {
                        return [
                            'student_id'    => $booking->student_id,
                            'tutor_id'      => $this->user->id,
                            'session_fee'   => $booking->session_fee,
                            'booked_at'     => $booking->booked_at,
                            'start_time'    => $slot->start_time,
                            'end_time'      => $slot->end_time,
                            'status'        => 'rescheduled'
                        ];
                    })->toArray();
                    $oldBookingIds = $slot->bookings->pluck('id')->toArray();
                    $newBookingsCollection = collect();
                    foreach ($newBooking as $bookingData) {
                        $newBooking = $slotInfo->bookings()->create($bookingData);
                        $newBookingsCollection->push($newBooking);
                        $rescheduleEmailData = $this->getRescheduleEmailData($newBooking);
                        $rescheduleEmailData['reason'] = $metaData['reason'];
                        dispatch(new SendNotificationJob('bookingRescheduled', $newBooking->booker, $rescheduleEmailData));
                        dispatch(new SendDbNotificationJob('bookingRescheduled', $newBooking->booker, $rescheduleEmailData));
                    }

                    $orderItems = OrderItem::whereIn('orderable_id', $oldBookingIds)
                        ->where('orderable_type', SlotBooking::class)
                        ->get();

                    foreach ($orderItems as $orderItem) {
                        $correspondingNewBooking = $newBookingsCollection->firstWhere('student_id', $orderItem->orders?->user_id);
                        if ($correspondingNewBooking) {
                            $orderItem->update([
                                'orderable_id' => $correspondingNewBooking['id']
                            ]);
                        }
                    }

                    $slotInfo->bookings->map(function ($booking) {
                        $this->addBookingLog($booking, [
                            'activityable_id'   => $booking->tutor_id,
                            'activityable_type' => User::class,
                            'type'              => 'rescheduled'
                        ]);
                    });
                    $slot->delete();
                    $slot->bookings()->delete();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1');
                    DB::commit();
                    return $slotInfo;
                }
            }
            return false;
        } catch (Exception $ex) {
            Log::info($ex);
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            DB::rollBack();
            return false;
        }
    }

    public function deleteSlotsMeta($id)
    {
        $slot = $this->getUserSessionSlot($id);
        if (!empty($slot) && empty($slot->total_booked)) {
            return $slot->delete();
        }
        return false;
    }

    public function updateSessionSlotById($slotId, $updatedData)
    {
        $slot = $this->getUserSessionSlot($slotId);
        if ($slot) {
            $updatedArray = Arr::only($updatedData, ['session_fee', 'spaces', 'description']);
            $updatedArray['meta_data'] = $slot->meta_data;
            $updatedArray['meta_data']['meeting_link'] = $updatedData['meeting_link'];
            if (Module::has('subscriptions') && Module::isEnabled('subscriptions') && setting('_lernen.subscription_sessions_allowed') == 'tutor') {
                $updatedArray['meta_data']['allowed_for_subscriptions'] = $updatedData['allowed_for_subscriptions'] ? 1 : 0;
            }
            if (isActiveModule('upcertify') && isActiveModule('quiz')) {
                $updatedArray['meta_data']['assign_quiz_certificate'] = $updatedData['assign_quiz_certificate'];
            }
            $existingLink = $slot->meta_data['meeting_link'] ?? '';
            $slotUpdated = $slot->update($updatedArray);
            if (!empty($updatedArray['meta_data']['meeting_link']) && $existingLink != $updatedArray['meta_data']['meeting_link']) {
                if (!empty($slot->bookings)) {
                    foreach ($slot->bookings as $booking) {
                        $updatedBookingMeta = $booking->meta_data;
                        $updatedBookingMeta['meeting_link'] = $updatedData['meeting_link'];
                        $this->updateBooking($booking, ['meta_data' => $updatedBookingMeta]);
                        dispatch(new SendNotificationJob('bookingLinkGenerated', $booking->booker, [
                            'userName'       => $booking->student?->full_name,
                            'tutorName'      => $booking->tutor?->full_name,
                            'sessionDate'    => $this->getBookingTime($booking, 'booker'),
                            'sessionSubject' => $booking->orderItem?->options['subject_group'] . ' > ' . $booking->orderItem?->options['subject'],
                            'meetingLink'    => $updatedData['meeting_link']
                        ]));
                        dispatch(new SendDbNotificationJob('bookingLinkGenerated', $booking->booker, [
                            'tutorName'      => $booking->tutor?->full_name,
                            'sessionDate'    => $this->getBookingTime($booking, 'booker'),
                            'sessionSubject' => $booking->orderItem?->options['subject_group'] . ' > ' . $booking->orderItem?->options['subject'],
                            'meetingLink'    => $updatedData['meeting_link']
                        ]));
                    }
                }
            }
            return $slotUpdated;
        }
        return false;
    }

    public function markUnavailableDays($unavailableDays)
    {
        $dates = explode(',', $unavailableDays);
        if (!empty($dates)) {
            foreach ($dates as $date) {
                $date = parseToUTC($date);
                $this->user->unavailableDates()->updateOrCreate(['user_id' => $this->user->id, 'date' => $date], ['date' => $date, 'user_id' => $this->user->id]);
            }
        }
    }

    public function deleteUnavailableDay($id)
    {
        $this->user->unavailableDates()->whereId($id)->delete();
    }

    public function updateBooking($booking, $newDetails)
    {
        if ($booking->update($newDetails)) {
            return $booking;
        }
        return false;
    }

    public function addBookingLog($booking, $logInfo)
    {
        return $booking->bookingLog()->create($logInfo);
    }

    public function deleteBooking($booking)
    {
        if ($booking->delete()) {
            return true;
        }
        return false;
    }

    public function updateSessionSlot($slot, $newDetails)
    {
        if ($slot->update($newDetails)) {
            return $slot;
        }
        return false;
    }

    public function reservedBookingSlot($slot, $user)
    {
        $this->updateBooking($slot, ['total_booked' => $slot->total_booked + 1]);
        $slotBooking = $slot->bookings()->create([
            'student_id'    => Auth::user()->id,
            'tutor_id'      => $user->id,
            'session_fee'   => $slot->session_fee,
            'booked_at'     => parseToUTC(now()),
            'start_time'    => $slot->start_time,
            'end_time'      => $slot->end_time,
            'status'        => 'reserved'
        ]);
        $reservedUpto = (int) (setting('_lernen.booking_reserved_time') ?? 30);

        dispatch(new RemoveBookingReservationJob($slotBooking->id))->delay(now()->addMinutes($reservedUpto));
        return $slotBooking;
    }

    public function confirmRescheduledBooking($booking)
    {
        if ($this->updateBooking($booking, ['status' => 'active', 'start_time' => $booking->slot->start_time, 'end_time' => $booking->slot->end_time])) {
            $booking->slot->update(['total_booked' => $booking->slot->total_bookings + 1]);
            $this->addBookingLog($booking, [
                'activityable_id'   => $this->user->id,
                'activityable_type' => User::class,
                'type'              => 'active'
            ]);
            dispatch(new CreateGoogleCalendarEventJob($booking));
            return $booking;
        }
        return false;
    }

    public function getBookingById($id)
    {
        return SlotBooking::find($id);
    }

    protected function getUserSessionSlot($id, $relations = [])
    {
        return UserSubjectSlot::when(!empty($relations), fn($query) => $query->with($relations))
            ->whereHas('subjectGroupSubjects', fn($query) => $query->select('id')
                ->whereHas('userSubjectGroup', fn($query) => $query->select('id')
                    ->whereUserId($this->user->id)))->whereKey($id)->first();
    }

    protected function getRescheduleEmailData($booking)
    {
        return [
            'userName'          => $booking->student->full_name,
            'tutorName'         => $booking->tutor->full_name,
            // 'previous_date'     => Carbon::parse($booking->start_time, $studentTz)->format('F d, Y'),
            // 'previous_time'     => Carbon::parse($booking->start_time, $studentTz)->format('h:i a') . " - " . Carbon::parse($booking->end_time, $studentTz)->format('h:i a'),
            'newSessionDate'    => $this->getBookingTime($booking, 'booker'),
            'reason'            => $booking->slot->metadata['reason'] ?? '',
            'viewLink'          => route('student.reschedule-session', ['id' => $booking->id])
        ];
    }

    public function getBookingTime($booking, $type, $includeBr = false)
    {
        $user = $type == 'booker' ? $booking->booker : $booking->bookee;
        $bookingDate = Carbon::parse($booking->start_time)->setTimezone(getUserTimezone($user))->format(setting('_general.date_format') ?? 'F j, Y');
        $startTime   = Carbon::parse($booking->start_time)->setTimezone(getUserTimezone($user))->format('h:i a');
        $endTime     = Carbon::parse($booking->end_time)->setTimezone(getUserTimezone($user))->format('h:i a');
        if ($includeBr) {
            return (string) "$bookingDate <br /> $startTime - $endTime";
        }
        return (string) "$bookingDate $startTime - $endTime";
    }

    public function removeReservedBooking($bookingId)
    {

        $booking = $this->getBookingById($bookingId);
        if (!empty($booking) && $booking?->status == 'reserved') {
            $this->updateSessionSlot($booking->slot, ['total_booked' => $booking->slot->total_booked - 1]);
            $this->deleteBooking($booking);
        }
    }

    public function createBookingEventGoogleCalendar($booking)
    {
        $eventResponse = (new GoogleCalender($booking->booker))->createEvent([
            'title'         => $booking->orderItem->title . " " . $booking->tutor->full_name,
            'description'   => $booking->slot->description,
            'start_time'    => Carbon::parse($booking->start_time)->setTimezone(getUserTimezone($booking->booker))->toIso8601String(),
            'end_time'      => Carbon::parse($booking->end_time)->setTimezone(getUserTimezone($booking->booker))->toIso8601String(),
            'timezone'      =>  getUserTimezone($booking->booker)
        ]);
        if (is_array($eventResponse) && $eventResponse['status'] == Response::HTTP_OK && $eventResponse['data'] instanceof Event) {
            $bookingMeta             = $booking->meta_data;
            $bookingMeta['event_id'] = $eventResponse['data']['id'] ?? null;
            $this->updateBooking($booking, ['meta_data' => $bookingMeta]);
            return true;
        }
        return false;
    }

    public function createSlotEventGoogleCalendar($booking, $updateMeetingLink = false)
    {
        if (empty($booking->slot['meta_data']['event_id'])) {
            $eventResponse = (new GoogleCalender($booking->bookee))->createEvent([
                'title'         => (($booking->orderItem->options['subject_group'] ?? null) . " " ?? '') . $booking->orderItem->title,
                'description'   => $booking->slot->description,
                'start_time'    => Carbon::parse($booking->start_time)->setTimezone(getUserTimezone($booking->bookee))->toIso8601String(),
                'end_time'      => Carbon::parse($booking->end_time)->setTimezone(getUserTimezone($booking->bookee))->toIso8601String(),
                'timezone'      =>  getUserTimezone($booking->bookee)
            ]);
            if (is_array($eventResponse) && $eventResponse['status'] == Response::HTTP_OK && $eventResponse['data'] instanceof Event) {
                $slotMeta               = $booking->slot->meta_data;
                $slotMeta['event_id']   = $eventResponse['data']['id'] ?? null;
                $this->updateSessionSlot($booking->slot, ['meta_data' => $slotMeta]);
                if ($updateMeetingLink && !empty($booking->slot['meta_data']['meeting_link'])) {
                    $this->createSessionMeetingLink($booking, $booking->slot['meta_data']['meeting_link']);
                }
                return true;
            }
        }
        return false;
    }

    public function createMeetingLink($booking)
    {
        if (empty($booking->slot['meta_data']['meeting_link'])) {
            $meeingLink = $this->createSessionMeetingLink($booking);
        }

        if (
            setting('_api.active_conference') == 'google_meet' &&
            !empty($booking['meta_data']['event_id'])
        ) {
            $meetingData = [];
            $meetingData['booking_event_id']     = $booking['meta_data']['event_id'];
            $bookerAccSettings                   = (new UserService($booking->booker))->getAccountSetting();
            $meetingData['booking_calendar_id']  = $bookerAccSettings['google_calendar_info']['id'];
            $meetingData['meeting_link']         = $meeingLink ?? $booking->slot['meta_data']['meeting_link'];
            $meetingData['booking_access_token'] = $bookerAccSettings['google_access_token'];

            $tutorId = $booking->tutor_id;
            $tutor = User::find($tutorId);
            getMeetingObject($tutor)->createMeeting($meetingData);
        }
    }

    protected function createSessionMeetingLink($booking, $meeingLink = null)
    {
        $meetingData = [
            // 'host_email'    => $booking->bookee->email,
            'topic'         => $booking->orderItem->title . '(' . $booking->tutor->full_name . ')',
            'agenda'        => $booking->slot->description,
            'duration'      => $booking->slot->duration,
            'timezone'      =>  'UTC',
            'start_time'    => Carbon::parse($booking->start_time)->setTimezone('UTC')->toIso8601String(),
        ];
        if (
            setting('_api.active_conference') == 'google_meet' &&
            !empty($booking->slot['meta_data']['event_id'])
        ) {
            $meetingData['event_id']     = $booking->slot['meta_data']['event_id'];
            $bookeeAccSettings           = (new UserService($booking->bookee))->getAccountSetting();
            $meetingData['calendar_id']  = $bookeeAccSettings['google_calendar_info']['id'];
            $meetingData['access_token'] = $bookeeAccSettings['google_access_token'];
            if (!empty($meeingLink)) {
                $meetingData['meeting_link'] = $meeingLink;
            }
        }

        $tutorId = $booking->tutor_id;
        $tutor = User::find($tutorId);
        $meetingResponse = getMeetingObject($tutor)->createMeeting($meetingData);

        if (!empty($meetingResponse) && !empty($meetingResponse['data']['link'])) {
            $meeingLink = $meetingResponse['data']['link'] ?? null;
            $slotMeta                       = $booking->slot->meta_data;
            $slotMeta['meeting_link']       = $meetingResponse['data']['link'] ?? null;
            $slotMeta['meeting_type']       = setting('_api.active_conference') ?? 'zoom';
            $this->updateSessionSlot($booking->slot, ['meta_data' => $slotMeta]);
        }

        return $meeingLink;
    }

    public function getBookingSlot($sessionSlotId, $status = null)
    {

        $bookings = SlotBooking::select('id', 'tutor_id', 'student_id', 'user_subject_slot_id', 'session_fee', 'start_time', 'end_time', 'status')
            ->where('user_subject_slot_id', $sessionSlotId)
            ->when(!empty($status), fn($query) => $query->where('status', $status))
            ->when(auth()->user()->role == 'student', function ($query) {
                return $query->where('student_id', auth()->user()->id);
            })
            ->when(auth()->user()->role == 'tutor', function ($query) {
                return $query->where('tutor_id', auth()->user()->id);
            })
            ->get();
        return $bookings;
    }



    public function createFreeBookingSlot($slot, $user)
    {
        try {
            DB::beginTransaction();

            $this->updateBooking($slot, ['total_booked' => $slot->total_booked + 1]);

            $slotBooking = $slot->bookings()->create([
                'student_id'    => Auth::user()->id,
                'tutor_id'      => $user->id,
                'session_fee'   => $slot->session_fee,
                'booked_at'     => parseToUTC(now()),
                'start_time'    => $slot->start_time,
                'end_time'      => $slot->end_time,
                'status'        => 'active'
            ]);

            $this->addBookingLog($slotBooking, [
                'activityable_id'   => $slotBooking->student_id,
                'activityable_type' => User::class,
                'type'              => 'active'
            ]);

            $order = $this->createOrder();

            $orderItems = [
                [
                    'order_id'       => $order->id,
                    'title'          => $slot->subjectGroupSubjects?->subject->name,
                    'quantity'       => 1,
                    'options'        => [
                        'id'                => $slotBooking->id,
                        'image'             => $slot->subjectGroupSubjects?->image ?? null,
                        'price'             => '<sup>' . setting('_general.currency_symbol') . '</sup>0.00',
                        'slot_id'           => $slot->id,
                        'subject'           => $slot->subjectGroupSubjects?->subject->name,
                        'tutor_id'          => $user->id,
                        'tutor_name'        => $user->profile?->full_name,
                        'session_time'      => parseToUserTz($slotBooking->start_time)->format('g:ia') . ' - ' . parseToUserTz($slotBooking->end_time)->format('g:ia'),
                        'tutor_payout'      => 0,
                        'subject_group'     => $slot->subjectGroupSubjects?->userSubjectGroup?->group?->name,
                        'currency_symbol'   => setting('_general.currency_symbol'),
                    ],
                    'price'          => 0,
                    'total'          => 0,
                    'orderable_id'   => $slotBooking->id,
                    'orderable_type' => SlotBooking::class,
                ]
            ];

            (new OrderService())->storeOrderItems($order->id, $orderItems);

            DB::commit();

            $endTime = $slotBooking?->end_time;
            $delay = now()->diffInSeconds($endTime, false);

            if ($delay > 0) {
                dispatch(new SendNotificationJob('bookingCompletionRequest', $slotBooking?->booker, [
                    'tutorName'           => $slotBooking?->tutor?->full_name,
                    'userName'            => $slotBooking?->student?->full_name,
                    'sessionDateTime'     => $this->getBookingTime($slotBooking, 'booker'),
                    'completeBookingLink' => route('student.complete-booking', $slotBooking?->id),
                    'days'                => setting('_lernen.complete_booking_after_days') ?? 3
                ]))->delay($delay);
                dispatch(new SendDbNotificationJob('bookingCompletionRequest', $slotBooking?->booker, [
                    'tutorName'           => $slotBooking?->tutor?->full_name,
                    'sessionDateTime'     => $this->getBookingTime($slotBooking, 'booker'),
                    'completeBookingLink' => route('student.complete-booking', $slotBooking?->id),
                    'days'                => setting('_lernen.complete_booking_after_days') ?? 3
                ]))->delay($delay);
            }

            $completeBookingDelay = Carbon::parse($endTime)->addDays((int)setting('_lernen.complete_booking_after_days') ?? 3);
            dispatch(new CompleteBookingJob($slotBooking))->delay($completeBookingDelay);
            dispatch(new CompleteFreePurchaseJob($order));



            $this->createBookingEventGoogleCalendar($slotBooking);
            $this->createSlotEventGoogleCalendar($slotBooking);
            $this->createMeetingLink($slotBooking);
            return [
                'success'   => true,
                'message'   => __('general.booking_completed'),
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);

            return [
                'success'   => false,
                'message'   => __('general.went_wrong'),
            ];
        }
    }

    public function enrollFreeCourse($resourceId)
    {
        if (empty($resourceId)) {
            return [
                'success' => false,
                'message' => __('courses::courses.course_not_found')
            ];
        }

        $course = (new CourseService())->getCourse($resourceId);

        if (empty($course)) {
            return [
                'success' => false,
                'message' => __('courses::courses.course_not_found')
            ];
        }

        try {

            DB::beginTransaction();

            $order = $this->createOrder();

            $orderItems = [
                [
                    'order_id'       => $order->id,
                    'title'          => $course->title,
                    'quantity'       => 1,
                    'options'        => [
                        'id'                => $course->id,
                        'title'            => $course->title,
                        'sub_category'      => $course->subCategory?->name,
                        'category'          => $course->category?->name,
                        'image'             => $course->thumbnail?->path,
                        'price'             => 0,
                        'tutor_id'          => $course->instructor_id,
                        'currency_symbol'   => setting('_general.currency') ?? '',
                    ],
                    'price'          => 0,
                    'total'          => 0,
                    'orderable_id'   => $course->id,
                    'orderable_type' => Course::class,
                ]
            ];

            (new OrderService())->storeOrderItems($order->id, $orderItems);

            $courseData = [
                'student_id'        => Auth::user()->id,
                'course_id'         => $course->id,
                'tutor_id'          => $course->instructor_id,
                'course_price'      => 0,
                'course_discount'   => 0,
                'status'            => 'active',
            ];

            (new \Modules\Courses\Services\CourseService())->addStudentCourse($courseData);

            DB::commit();

            dispatch(new CompleteFreePurchaseJob($order));

            return [
                'success' => true,
                'message' => _('courses::courses.course_enrolled_successfully'),
                'order'   => $order
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            // Log::error($th->getMessage());

            return [
                'success' => false,
                'message' => __('general.went_wrong')
            ];
        }
    }

    public function getFreeBundle($bundleId)
    {
        if (empty($bundleId)) {
            return [
                'success' => false,
                'message' => __('coursebundles::bundles.bundle_not_found')
            ];
        }

        $bundle = (new BundleService())->getBundle(
            bundleId: $bundleId,
            relations: ['courses:id,instructor_id,title,slug,status']
        );

        if (empty($bundle)) {
            return [
                'success' => false,
                'message' => __('courses::courses.bundle_not_found')
            ];
        }

        try {

            DB::beginTransaction();

            $order = $this->createOrder();

            $orderItems = [
                [
                    'order_id'       => $order->id,
                    'title'          => $bundle->title,
                    'quantity'       => 1,
                    'options'        => [
                        'id'                => $bundle->id,
                        'title'            => $bundle->title,
                        'image'             => $bundle->thumbnail?->path,
                        'price'             => 0,
                        'tutor_id'          => $bundle->instructor_id,
                        'currency_symbol'   => setting('_general.currency') ?? '',
                    ],
                    'price'          => 0,
                    'total'          => 0,
                    'orderable_id'   => $bundle->id,
                    'orderable_type' => Bundle::class,
                ]
            ];

            (new OrderService())->storeOrderItems($order->id, $orderItems);

            (new BundleService())->addBundlePurchase([
                'student_id'        => $order->user_id,
                'tutor_id'          => $bundle->instructor_id,
                'bundle_id'         => $bundle->id,
                'purchased_price'   => 0
            ]);

            $courseData = [
                'student_id'        => Auth::user()->id,
                'course_id'         => $bundle->id,
                'tutor_id'          => $bundle->instructor_id,
                'course_price'      => 0,
                'course_discount'   => 0,
                'status'            => 'active',
            ];

            if (!empty($bundle->courses)) {
                foreach ($bundle->courses as $course) {
                    $alreadyHaveCourse = (new \Modules\Courses\Services\CourseService())->getStudentCourse(
                        courseId: $course->id,
                        studentId: $order->user_id,
                        tutorId: $course->instructor_id
                    );
                    if ($alreadyHaveCourse) {
                        continue;
                    }
                    $courseData = [
                        'student_id'        => $order->user_id,
                        'course_id'         => $course->id,
                        'tutor_id'          => $course->instructor_id,
                        'course_price'      => $course->pricing?->price,
                        'course_discount'   => $course?->pricing?->discount,
                        'status'            => 'active',
                    ];
                    (new \Modules\Courses\Services\CourseService())->addStudentCourse($courseData);
                }
            }

            DB::commit();

            dispatch(new CompleteFreePurchaseJob($order));

            return [
                'success' => true,
                'message' => _('courses::courses.course_enrolled_successfully'),
                'order'   => $order
            ];
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error($th);

            return [
                'success' => false,
                'message' => __('general.went_wrong')
            ];
        }
    }

    private function createOrder()
    {
        $billingDetail = [
            'user_id'                   => Auth::user()->id,
            'first_name'                => Auth::user()->profile?->first_name,
            'unique_payment_id'         => Str::uuid(),
            'amount'                    => 0,
            'currency'                  => setting('_general.currency') ?? '',
            'used_wallet_amt'           => 0,
            'last_name'                 => Auth::user()->profile?->last_name,
            'email'                     => Auth::user()->email,
            'phone'                     => Auth::user()->profile?->phone_number ?? '',
            'country'                   => Auth::user()->address?->country?->name,
            'state'                     => Auth::user()->address?->state?->name ?? '',
            'city'                      => Auth::user()->address?->city,
            'postal_code'               => Auth::user()->address?->zipcode,
            'company'                   => '',
            'payment_method'            => 'free',
            'status'                    => 'complete',
        ];

        $order = (new OrderService())->createOrder($billingDetail);

        return $order;
    }

    public function getSlotByDetail($id, $relations = true)
    {
        return UserSubjectSlot::when(!empty($relations), function ($relations) {
            $relations->with(['subjectGroupSubjects' => function ($query) {
                $query->select('id', 'user_subject_group_id', 'subject_id', 'hour_rate', 'image');
                $query->withWhereHas('userSubjectGroup', function ($subjectGroup) {
                    $subjectGroup->with('group:id,name', 'tutorProfile');
                    $subjectGroup->select('id', 'user_id', 'subject_group_id');
                });
                $query->with('subject:id,name', 'bookings');
            }]);
        })->find($id);
    }
}
