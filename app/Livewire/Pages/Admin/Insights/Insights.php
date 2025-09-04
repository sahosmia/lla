<?php

namespace App\Livewire\Pages\Admin\Insights;

use App\Services\InsightsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Insights extends Component
{

    public $user;

    public $platformEarnings;
    public $tutorEarnings;
    public $platformCommission;
    public $tutorPendingEarnings;
    public $totalSessions;
    public $completedSessions;
    public $cancelledSessions;
    public $users;
    public $usersCount;
    public $tutors;
    public $tutorsCount;
    public $students;
    public $studentsCount;
    public $currentMonthUsers;
    public $lastMonthUsers;
    public $difference;

    public $revenueStartDate   = null;
    public $revenueEndDate     = null;

    public $sessionStartDate   = null;
    public $sessionEndDate     = null;
    public $tutor_name = '';
    public $student_name = '';

    private ?InsightsService  $insightsService = null;


    public function boot()
    {
        $this->user                 = Auth::user();
        $this->insightsService      = new InsightsService();
    }

    public function mount()
    {
        $this->tutor_name   = Str::plural(!empty(setting('_lernen.tutor_display_name')) ? setting('_lernen.tutor_display_name') : __('general.tutor')) ;
        $this->student_name = Str::plural(!empty(setting('_lernen.student_display_name')) ? setting('_lernen.student_display_name') : __('general.student'));
        $this->revenueStartDate         = now()->startOfMonth()->format('Y-m-d');
        $this->revenueEndDate           = now()->endOfMonth()->format('Y-m-d');

        $this->sessionStartDate         = now()->startOfMonth()->format('Y-m-d');
        $this->sessionEndDate           = now()->endOfMonth()->format('Y-m-d');

        $users                              = $this->insightsService->getUsers(roles: ['tutor', 'student']);
        $this->usersCount                   = $users->count();
        $this->users                        = $users->take(3);

        $tutors                             = $this->insightsService->getUsers(roles: ['tutor']);
        $this->tutorsCount                  = $tutors->count();
        $this->tutors                       = $tutors->take(6);

        $students                           = $this->insightsService->getUsers(roles: ['student']);
        $this->studentsCount                = $students->count();
        $this->students                     = $students->take(6);

        $this->currentMonthUsers            = $this->insightsService->getUsers(roles: ['tutor', 'student'], dateRange: 'current_month')->count();
        $this->lastMonthUsers               = $this->insightsService->getUsers(roles: ['tutor', 'student'], dateRange: 'last_month')->count();

        if ($this->currentMonthUsers == 0 && $this->lastMonthUsers == 0) {
            $percentageChange = 0;
        } elseif ($this->lastMonthUsers == 0) {
            $percentageChange = 100;
        } else {
            $percentageChange = (($this->currentMonthUsers - $this->lastMonthUsers) / abs($this->lastMonthUsers)) * 100;
        }

        $this->difference                   = number_format($percentageChange);
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $this->platformEarnings             = $this->insightsService->getPlatformEarnings(revenueStartDate: $this->revenueStartDate, revenueEndDate: $this->revenueEndDate);
        $this->tutorEarnings                = $this->insightsService->getTutorEarnings(type: 'add', revenueStartDate: $this->revenueStartDate, revenueEndDate: $this->revenueEndDate);
        $this->tutorPendingEarnings         = $this->insightsService->getTutorEarnings(type: 'pending_available', revenueStartDate: $this->revenueStartDate, revenueEndDate: $this->revenueEndDate);
        $this->platformCommission           = $this->insightsService->getPlatformCommission(revenueStartDate: $this->revenueStartDate, revenueEndDate: $this->revenueEndDate);

        $this->totalSessions                = $this->insightsService->getSessions(statuses: ['active', 'completed'], sessionStartDate: $this->sessionStartDate, sessionEndDate: $this->sessionEndDate);
        $this->completedSessions            = $this->insightsService->getSessions(statuses: ['completed'], sessionStartDate: $this->sessionStartDate, sessionEndDate: $this->sessionEndDate);
        $this->cancelledSessions            = $this->insightsService->getSessions(statuses: ['rescheduled'], sessionStartDate: $this->sessionStartDate, sessionEndDate: $this->sessionEndDate);

        return view('livewire.pages.admin.insights.insights');
    }

    public function clearRevenue()
    {
        $this->revenueStartDate = null;
        $this->revenueEndDate = null;
    }

    public function clearSession()
    {
        $this->sessionStartDate = null;
        $this->sessionEndDate = null;
    }
}
