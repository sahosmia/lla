<?php

namespace App\Livewire\Pages\Common;

use App\Jobs\SendNotificationJob;
use App\Livewire\Actions\Logout;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\PayoutService;
use Livewire\Attributes\On;
use App\Services\WalletService;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Navigation extends Component
{

    public $menuItems = [];
    public $activeRoute = [];
    public $user;
    public $amount;
    public $role;
    public $balance;
    public $userPayoutMethod;

    private ?PayoutService $payoutService   = null;
    private ?WalletService $walletService   = null;



    public function boot()
    { 
        $this->walletService   = new WalletService();
        $this->payoutService   = new PayoutService();
    }


    #[On('reload-balances')]
    public function reload() {}

    public function mount()
    {
        $billing_check = setting('_lernen.payment_enabled');
        $roleInfo = getUserRole();
        $this->user                     = Auth::user();
        $this->activeRoute              = Route::currentRouteName();
        $this->role                     = $roleInfo['roleName'];
        $this->menuItems    = [
            [
                'route' => 'tutor.dashboard',
                'tutorSortOrder' => 1,
                'onActiveRoute' => ['tutor.dashboard'],
                'title' => __('sidebar.dashboard'),
                'icon'  => '<i class="am-icon-menu-7"></i>',
                'accessibility' => ['tutor'],
            ],
            [
                'studentSortOrder' => 2,
                'route' => 'student.bookings',
                'onActiveRoute' => ['student.bookings', 'student.reschedule-session'],
                'title' => __('sidebar.bookings'),
                'icon'  => '<i class="am-icon-calender-day"></i>',
                'accessibility' => ['student'],
            ],
            [
                'tutorSortOrder' => 2,
                'studentSortOrder' => 1,
                'route' => $this->role . '.profile.personal-details',
                'onActiveRoute' => ['tutor.profile.resume', $this->role . '.profile.account-settings', 'tutor.profile.resume.education', 'tutor.profile.resume.experience', 'tutor.profile.resume.certificate', 'student.profile.contacts', $this->role . '.profile.personal-details', $this->role . '.profile.identification'],
                'title' => __('sidebar.profile_settings'),
                'icon'  => '<i class="am-icon-user-01"></i>',
                'accessibility' => ['tutor', 'student'],
            ],
            // [
            //     'route' => 'student.tuition-settings',
            //     'onActiveRoute' => ['student.tuition-settings'],
            //     'title' => __('sidebar.tuition_settings'),
            //     'icon'  => '<i class="am-navigation_icon">
            //                 <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            //                     <path d="M0.833334 0.833379L1.25 0.833328V0.833328C2.48316 0.833358 3.5669 1.65084 3.90567 2.83655L4.04762 3.33338M4.04762 3.33338L5.34044 7.85826C5.81584 9.52214 6.05353 10.3541 6.5388 10.9716C6.96711 11.5166 7.52972 11.941 8.17145 12.2031C8.89851 12.5 9.76374 12.5 11.4942 12.5H12.5096C13.5593 12.5 14.0842 12.5 14.5438 12.3899C15.6412 12.1268 16.5764 11.4125 17.1189 10.423C17.3462 10.0086 17.4843 9.50218 17.7605 8.48943V8.48943C18.0969 7.25573 18.2652 6.63888 18.2326 6.13842C18.154 4.93154 17.3584 3.88988 16.2147 3.4965C15.7404 3.33338 15.1011 3.33338 13.8223 3.33338H4.04762ZM10 16.6667C10 17.5871 9.25381 18.3333 8.33333 18.3333C7.41286 18.3333 6.66667 17.5871 6.66667 16.6667C6.66667 15.7462 7.41286 15 8.33333 15C9.25381 15 10 15.7462 10 16.6667ZM16.6667 16.6667C16.6667 17.5871 15.9205 18.3333 15 18.3333C14.0795 18.3333 13.3333 17.5871 13.3333 16.6667C13.3333 15.7462 14.0795 15 15 15C15.9205 15 16.6667 15.7462 16.6667 16.6667Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            //                 </svg>
            //             </i>',
            //     'accessibility' => ['student'],
            // ],
            [
                'tutorSortOrder' => 3,
                'route' => 'tutor.bookings.subjects',
                'onActiveRoute' => ['tutor.bookings', 'tutor.bookings.subjects', 'tutor.bookings.session-detail', 'tutor.bookings.manage-sessions', 'tutor.bookings.upcoming-bookings'],
                'title' => __('sidebar.manage_bookings'),
                'icon'  => '<i class="am-icon-calender-day"></i>',
                'accessibility' => ['tutor'],
            ],
            [
                'tutorSortOrder' => 9,
                'studentSortOrder' => 9,
                'route' => 'tutor.payouts',
                'onActiveRoute' => ['tutor.payouts'],
                'title' => __('Payouts'),
                'icon'  => '<i class="am-icon-dollar"></i>',
                'accessibility' => ['tutor'],
            ],
            [
                'studentSortOrder' => 10,
                'route' => 'student.billing-detail',
                'onActiveRoute' => ['student.billing-detail'],
                'title' => __('sidebar.billing_detail'),
                'icon'  => '<i class="am-icon-ongoing"></i>',
                'accessibility' => $billing_check == 'yes' ? ['student'] : [],
            ],
            [
                'studentSortOrder' => 9,
                'route' => 'student.favourites',
                'onActiveRoute' => ['student.favourites'],
                'title' => __('sidebar.favourites'),
                'icon'  => '<i class="am-icon-heart-01"></i>',
                'accessibility' => ['student'],
            ],

            [
                'studentSortOrder' => 4,
                'route' => 'find-tutors',
                'onActiveRoute' => ['find-tutors'],
                'title' => __('sidebar.find_tutors'),
                'icon'  => '<i class="am-icon-user-02"></i>',
                'accessibility' => ['student'],
                'disableNavigate' => true,
            ],
            [
                'tutorSortOrder' => 10,
                'studentSortOrder' => 11,
                'route' => $this->role . '.invoices',
                'onActiveRoute' => ['student.invoices', 'tutor.invoices', 'tutor.invoice.show', 'student.invoice.show'],
                'title' => __('sidebar.invoices'),
                'icon'  => '<i class="am-icon-invoices-01"></i>',
                'accessibility' => ['student', 'tutor'],
            ],
            [
                'tutorSortOrder' => 6,
                'studentSortOrder' => 6,
                'route' => 'laraguppy.messenger',
                'onActiveRoute' => ['laraguppy.messenger'],
                'title' => __('sidebar.messages'),
                'icon'  => '<i class="am-icon-chat-03"></i>',
                'accessibility' => ['student', 'tutor'],
                'disableNavigate' => true,
            ],
            [
                'tutorSortOrder' => 11,
                'studentSortOrder' => 12,
                'route' => $this->role . '.disputes',
                'onActiveRoute' => [$this->role . '.disputes', $this->role . '.manage-dispute'],
                'title' => __('sidebar.disputes'),
                'icon'  => '<i class="am-icon-dispute-1"></i>',
                'accessibility' => ['student', 'tutor'],
                'disableNavigate' => true,
            ]
        ];

        if (\Nwidart\Modules\Facades\Module::has('forumwise') && \Nwidart\Modules\Facades\Module::isEnabled('forumwise')) {
            $this->menuItems[] = [
                'tutorSortOrder' => 5,
                'studentSortOrder' => 7,
                'route' => 'forums',
                'onActiveRoute' => ['forums', 'forum-topics', 'topic'],
                'title' => __('sidebar.forums'),
                'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <g clip-path="url(#clip0_12237_67771)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.559326 1.73169C0.559326 1.00682 1.14695 0.419189 1.87183 0.419189C2.5967 0.419189 3.18433 1.00682 3.18433 1.73169C3.18433 2.45656 2.5967 3.04419 1.87183 3.04419C1.14695 3.04419 0.559326 2.45656 0.559326 1.73169ZM6.80105 3.69551C5.8804 4.03215 5.06484 4.56346 4.38961 5.23801C3.67516 5.97101 3.12689 6.84105 2.80941 7.81113C2.80056 7.83816 2.78971 7.86439 2.77697 7.88963C2.57444 8.51131 2.47127 9.18914 2.47127 9.8902C2.47127 12.3583 3.84118 14.5133 5.86034 15.6346C4.77234 14.5 4.10291 12.961 4.10291 11.2685C4.10291 10.6017 4.20134 9.94514 4.40208 9.33204C4.40532 9.31966 4.40909 9.3069 4.41345 9.29382C4.42214 9.26775 4.43307 9.24089 4.44658 9.21386C4.7579 8.29595 5.27928 7.48259 5.94112 6.80421L5.94597 6.79924L5.946 6.79927C6.59253 6.15274 7.37665 5.64098 8.26415 5.31669L8.26715 5.3156L8.26715 5.31561C8.93024 5.07758 9.6471 4.94065 10.3997 4.94065H10.4024V4.94066C12.107 4.94893 13.648 5.62079 14.7822 6.70861C13.6632 4.69052 11.5101 3.3179 9.01627 3.3053C8.23851 3.30547 7.49453 3.44675 6.80105 3.69551ZM16.7275 11.2438L16.7275 9.8902C16.7275 5.64892 13.297 2.20107 9.02037 2.18031V2.1803H9.01763C8.10112 2.1803 7.2278 2.34703 6.41943 2.63721L6.41943 2.6372L6.41644 2.6383C5.33523 3.03336 4.37975 3.65687 3.59167 4.44496L3.59163 4.44493L3.58679 4.4499C2.77701 5.27993 2.14069 6.27433 1.76209 7.39541C1.74644 7.42566 1.734 7.45572 1.72432 7.48477C1.71943 7.49943 1.71529 7.51368 1.71178 7.52744C1.46681 8.27408 1.34627 9.07514 1.34627 9.8902C1.34627 14.131 4.79614 17.5808 9.0369 17.5808L10.396 17.5808C10.4024 17.5809 10.4088 17.5809 10.4153 17.5809H16.1651C16.4757 17.5809 16.7276 17.329 16.7276 17.0184V11.2685C16.7276 11.2603 16.7276 11.252 16.7275 11.2438ZM15.6025 11.2461L15.6026 16.4559L10.3978 16.4558C7.54626 16.4464 5.22791 14.1222 5.22791 11.2685C5.22791 10.7164 5.30878 10.1837 5.46674 9.69591C5.4778 9.67311 5.48735 9.64952 5.49527 9.62529C5.74571 8.86009 6.17851 8.17258 6.74395 7.59231C7.27762 7.05933 7.92181 6.63978 8.64875 6.37391C9.19696 6.1773 9.7845 6.06581 10.3984 6.06565C13.2834 6.0804 15.5905 8.3978 15.6025 11.2461ZM15.5656 3.53784C15.5656 3.02007 15.9854 2.60034 16.5031 2.60034C17.0209 2.60034 17.4406 3.02007 17.4406 3.53784C17.4406 4.05561 17.0209 4.47534 16.5031 4.47534C15.9854 4.47534 15.5656 4.05561 15.5656 3.53784ZM6.4778 11.2607C6.4778 10.7429 6.89753 10.3232 7.4153 10.3232C7.93307 10.3232 8.3528 10.7429 8.3528 11.2607C8.3528 11.7785 7.93307 12.1982 7.4153 12.1982C6.89753 12.1982 6.4778 11.7785 6.4778 11.2607ZM9.4778 11.2607C9.4778 10.7429 9.89753 10.3232 10.4153 10.3232C10.9331 10.3232 11.3528 10.7429 11.3528 11.2607C11.3528 11.7785 10.9331 12.1982 10.4153 12.1982C9.89753 12.1982 9.4778 11.7785 9.4778 11.2607ZM12.4778 11.2607C12.4778 10.7429 12.8975 10.3232 13.4153 10.3232C13.9331 10.3232 14.3528 10.7429 14.3528 11.2607C14.3528 11.7785 13.9331 12.1982 13.4153 12.1982C12.8975 12.1982 12.4778 11.7785 12.4778 11.2607Z" fill="#585858"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_12237_67771">
                                <rect width="18" height="18" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>',
                'accessibility' => ['student', 'tutor'],
            ];
        }

        if (\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses') && function_exists('courseMenuOptions')) {
            $courseMenuOptions = courseMenuOptions($this->role);
            // $courseMenuOptions[0]['tutorSortOrder'] = 4;
            // $courseMenuOptions[0]['studentSortOrder'] = 10;

            // $courseMenuOptions[1]['studentSortOrder'] = 11;

            $this->menuItems = array_merge($this->menuItems, $courseMenuOptions);
        }

        if (isActiveModule('Quiz') && function_exists('quizMenuOptions')) {
            $quizMenuOptions = quizMenuOptions($this->role);
            $this->menuItems = array_merge($this->menuItems, $quizMenuOptions);
        }

        if(isActiveModule('coursebundles') && function_exists('bundleMenuOptions')) {
            $bundleMenuOptions = bundleMenuOptions($this->role);
            $this->menuItems = array_merge($this->menuItems, $bundleMenuOptions);
        }

        if (\Nwidart\Modules\Facades\Module::has('upcertify') && \Nwidart\Modules\Facades\Module::isEnabled('upcertify')) {
            if ($this->role == 'tutor') {
                $this->menuItems[] = [
                    'tutorSortOrder' => 8,
                    'route' => 'upcertify.certificate-list',
                    'onActiveRoute' => ['upcertify.update', 'upcertify.certificate-list'],
                    'title' => __('sidebar.certificates'),
                    'icon'  => '<i class="am-icon-certificate"> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.45455C6.38421 3.45455 3.45455 6.38421 3.45455 10C3.45455 13.6158 6.38421 16.5455 10 16.5455H15.5169L10.9953 12.0238C10.4954 12.3271 9.90884 12.5018 9.28145 12.5018C7.4547 12.5018 5.97382 11.0209 5.97382 9.19418C5.97382 7.36742 7.4547 5.88655 9.28145 5.88655C11.1082 5.88655 12.5891 7.36742 12.5891 9.19418C12.5891 9.86686 12.3883 10.4926 12.0434 11.0148L16.5455 15.5169V10C16.5455 6.38421 13.6158 3.45455 10 3.45455ZM2 10C2 5.58088 5.58088 2 10 2C14.4191 2 18 5.58088 18 10V18H10C5.58088 18 2 14.4191 2 10ZM9.28145 7.34109C8.25802 7.34109 7.42836 8.17075 7.42836 9.19418C7.42836 10.2176 8.25802 11.0473 9.28145 11.0473C10.3049 11.0473 11.1345 10.2176 11.1345 9.19418C11.1345 8.17075 10.3049 7.34109 9.28145 7.34109Z" fill="#585858"/></svg> </i>',
                    'accessibility' => ['tutor'],
                ];
            } else {
                $this->menuItems[] = [
                    'studentSortOrder' => 8,
                    'route' => 'student.certificate-list',
                    'onActiveRoute' => ['student.certificate-list'],
                    'title' => __('sidebar.my_certificates'),
                    'icon'  => '<i class="am-icon-certificate"> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.45455C6.38421 3.45455 3.45455 6.38421 3.45455 10C3.45455 13.6158 6.38421 16.5455 10 16.5455H15.5169L10.9953 12.0238C10.4954 12.3271 9.90884 12.5018 9.28145 12.5018C7.4547 12.5018 5.97382 11.0209 5.97382 9.19418C5.97382 7.36742 7.4547 5.88655 9.28145 5.88655C11.1082 5.88655 12.5891 7.36742 12.5891 9.19418C12.5891 9.86686 12.3883 10.4926 12.0434 11.0148L16.5455 15.5169V10C16.5455 6.38421 13.6158 3.45455 10 3.45455ZM2 10C2 5.58088 5.58088 2 10 2C14.4191 2 18 5.58088 18 10V18H10C5.58088 18 2 14.4191 2 10ZM9.28145 7.34109C8.25802 7.34109 7.42836 8.17075 7.42836 9.19418C7.42836 10.2176 8.25802 11.0473 9.28145 11.0473C10.3049 11.0473 11.1345 10.2176 11.1345 9.19418C11.1345 8.17075 10.3049 7.34109 9.28145 7.34109Z" fill="#585858"/></svg> </i>',
                    'accessibility' => ['student'],
                ];
            }
        }

        if (isActiveModule('assignments') && function_exists('assignmentMenuOptions')) {
            $assignmentMenuOptions = assignmentMenuOptions($this->role);
            $this->menuItems = array_merge($this->menuItems, $assignmentMenuOptions);
        }


        if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')) {
            if ($this->role == 'tutor') {
                $this->menuItems[] = [
                    'tutorSortOrder' => 7,
                    'studentSortOrder' => 7,
                    'route' => 'kupondeal.coupon-list',
                    'onActiveRoute' => ['kupondeal.coupon-list'],
                    'title' => __('sidebar.coupons'),
                    'icon'  => '<i class="am-icon-certificate"> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.90858 8.46862C8.90858 8.12344 8.62875 7.84361 8.28359 7.84361C7.93841 7.84361 7.65859 8.12344 7.65859 8.46862V11.5314C7.65859 11.8765 7.93841 12.1564 8.28359 12.1564C8.62875 12.1564 8.90858 11.8765 8.90858 11.5314V8.46862Z" fill="#585858"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.16666 3.12502C2.44077 3.12502 1.04166 4.52413 1.04166 6.25002V6.87501C1.04166 7.53159 1.56311 7.95963 2.06064 8.05994C2.96501 8.24229 3.64583 9.04232 3.64583 9.99999C3.64583 10.9577 2.96501 11.7577 2.06064 11.9401C1.56311 12.0404 1.04166 12.4685 1.04166 13.125V13.75C1.04166 15.4759 2.44077 16.875 4.16666 16.875H15.8333C17.5592 16.875 18.9583 15.4759 18.9583 13.75V13.125C18.9583 12.4685 18.4369 12.0404 17.9393 11.9401C17.035 11.7577 16.3542 10.9577 16.3542 9.99999C16.3542 9.04232 17.035 8.24229 17.9393 8.05994C18.4369 7.95963 18.9583 7.53158 18.9583 6.87501V6.25002C18.9583 4.52413 17.5592 3.12502 15.8333 3.12502H4.16666ZM2.29166 6.25002C2.29166 5.21448 3.13113 4.37502 4.16666 4.37502H7.65859V5.40192C7.65859 5.74711 7.93841 6.02692 8.28359 6.02692C8.62875 6.02692 8.90858 5.74711 8.90858 5.40192V4.37502H15.8333C16.8688 4.37502 17.7083 5.21448 17.7083 6.25002V6.8296C17.7032 6.83176 17.6978 6.83349 17.6923 6.8346C16.216 7.13226 15.1042 8.43557 15.1042 9.99999C15.1042 11.5644 16.216 12.8677 17.6923 13.1654C17.6978 13.1666 17.7032 13.1682 17.7083 13.1704V13.75C17.7083 14.7856 16.8688 15.625 15.8333 15.625H8.90858V14.5901C8.90858 14.2449 8.62875 13.9651 8.28359 13.9651C7.93841 13.9651 7.65859 14.2449 7.65859 14.5901V15.625H4.16666C3.13113 15.625 2.29166 14.7856 2.29166 13.75V13.1704C2.29672 13.1682 2.30218 13.1666 2.30771 13.1654C3.78397 12.8677 4.89583 11.5644 4.89583 9.99999C4.89583 8.43557 3.78397 7.13226 2.30771 6.8346C2.30218 6.83349 2.29672 6.83176 2.29166 6.8296V6.25002Z" fill="#585858"/>
                        </svg> </i>',
                    'accessibility' => ['tutor'],
                ];
            }
        }
        if ($this->role == 'tutor') {
            $this->menuItems = collect($this->menuItems)->sortBy('tutorSortOrder')->reject(function ($item) {
                return !isset($item['tutorSortOrder']);
            })->toArray();
        } else {
            $this->menuItems = collect($this->menuItems)->sortBy('studentSortOrder')->reject(function ($item) {
                return !isset($item['studentSortOrder']);
            })->toArray();
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->balance                  = $this->walletService->getWalletAmount($this->user->id);
        $this->userPayoutMethod         = $this->payoutService->activePayoutMethod($this->user->id);
        return view('livewire.pages.common.navigation');
    }

    public function addWithdarwals()
    {
        $min_withdraw_amount = setting('_lernen.withdraw_amount_limit') ?? '100';
        $rules = [
            'amount' => 'required|numeric|min:' . $min_withdraw_amount . '|max:' . $this->balance,
        ];

        $messages = [
            'amount.min' => 'The amount must be at least ' . formatAmount($min_withdraw_amount) . '.',
            'amount.max' => 'The amount may not be greater than ' . formatAmount($this->balance) . '.',
        ];

        $this->validate($rules, $messages);
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            $this->dispatch('toggleModel', id: 'amount', action: 'hide');
            return;
        }
        $withdrawalBalance    = $this->payoutService->updateWithDrawals($this->user->id, $this->amount);
        if ($withdrawalBalance) {
            $this->walletService->deductFunds($this->user->id, $this->amount, 'deduct_withdrawn');
            dispatch(new SendNotificationJob('withdrawWalletAmountRequest', User::admin(), ['name' => Auth::user()->profile->full_name, 'amount' => $this->amount,]));
            $this->dispatch('refresh-payouts');
        }
        $this->reset('amount');
        $this->dispatch('toggleModel', id: 'amount', action: 'hide');
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title'), message: __('general.success_withdrawal_message'));
    }

    public function openModel()
    {

        if (auth()->user()->role == 'student') {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.error_title'), message: __('general.student_error_message'));
            return;
        } elseif (empty($this->balance)) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.error_title'), message: __('general.empty_balance_message'));
            return;
        } elseif (empty($this->userPayoutMethod)) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.error_title'), message: __('general.payment_error_message'));
            return;
        }
        $this->reset('amount');
        $this->resetErrorBag();
        $this->dispatch('toggleModel', id: 'amount', action: 'show');
    }

    public function logout(Logout $logout): void
    {
        if (isActiveModule('ipmanager')) {
            $userLogService = app(\Modules\IPManager\Services\UserLogsService::class);
            $userLog = $userLogService->updateUserLog();
        }
        
        $logout();
        $this->redirect('/login');
    }
}
