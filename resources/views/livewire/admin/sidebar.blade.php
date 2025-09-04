<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderService;
new class extends Component
{
    public $menuItems = [];
    public $activeRoute = [];
    public $totalCommission = 0;

    public function mount()
    {
        $this->totalCommission = (new OrderService())->getTotalCommission();
        $this->activeRoute = Route::currentRouteName(); 
        $this->menuItems = [
            [
                'title' => __('sidebar.insights'),
                'icon'  => 'icon-grid',
                'routes' => [
                    [
                        'route' => 'admin.insights',
                        'title' => __('sidebar.insights'),
                        'permission' => 'can-manage-insights',
                    ],
                ],
            ],
            [
                'title' => __('sidebar.site_management'),
                'icon'  => 'icon-layout',
                'routes' => [
                    [
                        'route' => 'admin.manage-menus',
                        'title' => __('sidebar.menu'),
                        'permission' => 'can-manage-menu',
                    ],
                    [
                        'route' => 'optionbuilder',
                        'title' => __('sidebar.settings'),
                        'permission' => 'can-manage-option-builder',
                    ],
                    [
                        'route' => 'pagebuilder',
                        'title' => __('sidebar.sitepages'),
                        'permission' => 'can-manage-pages',
                    ],
                    [
                        'route' => 'admin.email-settings',
                        'title' => __('sidebar.email_templates'),
                        'permission' => 'can-manage-email-settings',
                    ],
                    [
                        'route' => 'admin.notification-settings',
                        'title' => __('sidebar.notification_templates'),
                        'permission' => 'can-manage-notification-settings',
                    ],
                ],
            ],
            [
                'title' => __('sidebar.taxonomies'),
                'icon'  => 'icon-database',
                'routes' => [
                    [
                        'route' => 'admin.taxonomy.languages',
                        'title' => __('sidebar.languages'),
                        'permission' => 'can-manage-languages',
                    ],
                    [
                        'route' => 'admin.taxonomy.subjects',
                        'title' => __('sidebar.subjects'),
                        'permission' => 'can-manage-subjects',
                    ],
                    [
                        'route' => 'admin.taxonomy.subject-groups',
                        'title' => __('sidebar.subject_groups'),
                        'permission' => 'can-manage-subject-groups',
                    ],
                ],
            ],
            [
                'title' => __('general.language_translations'),
                'icon'  => 'icon-globe',
                'routes' => [
                    [
                        'route' => 'admin.language-translator',
                        'title' => __('sidebar.languages'),
                        'permission' => 'can-manage-language-translations',
                    ],
                ],
            ],
            [
                'title' => __('sidebar.manage_packages'),
                'icon'  => 'icon-folder-plus',
                'permission' => 'can-manage-addons',
                'routes' => [
                    [
                        'route' => 'admin.packages.index',
                        'title' => __('sidebar.add_new_package'),
                    ],
                    [
                        'route' => 'admin.packages.installed',
                        'title' => __('sidebar.installed_packages'),
                    ],
                ],
            ],
            [
                'title' => __('sidebar.upgrade'),
                'icon'  => 'icon-upload-cloud',
                'routes' => [
                    [
                        'route' => 'admin.upgrade',
                        'title' => __('sidebar.upgrade'),
                        'permission' => 'can-manage-upgrade',
                    ],
                ],
            ],
            [
                'title' => __('sidebar.users'),
                'icon'  => 'icon-users',
                'routes' => [
                    [
                        'route' => 'admin.manage-admin-users',
                        'title' => 'Manage Admins',
                        'permission' => 'can-manage-admin-users',
                    ],
                    [
                        'route' => 'admin.users',
                        'title' => __('sidebar.users'),
                        'permission' => 'can-manage-users',
                    ],
                ],
            ],
            [
                'title' => __('admin/general.identity_verification'),
                'icon'  => 'icon-user-check',
                'routes' => [
                    [
                        'route' => 'admin.identity-verification',
                        'title' => __('identity-verification'),
                        'permission' => 'can-manage-identity-verification',
                    ],
                ],
            ],
            [
                'title' => __('admin/sidebar.reviews'),
                'icon'  => 'icon-star',
                'routes' => [
                    [
                        'route' => 'admin.reviews',
                        'title' => __('reviews'),
                        'permission' => 'can-manage-reviews',
                    ],
                ],
            ],
            [
                'title' => __('admin/sidebar.invoices'),
                'icon'  => 'icon-dollar-sign',
                'routes' => [
                    [
                        'route' => 'admin.invoices',
                        'title' => __('invoices'),
                        'permission' => 'can-manage-invoices',
                    ],
                ],
            ],
            [
                'title' => __('admin/sidebar.bookings'),
                'icon'  => 'icon-file-text',
                'routes' => [
                    [
                        'route' => 'admin.bookings',
                        'title' => __('bookings'),
                        'permission' => 'can-manage-bookings',
                    ],
                ],
            ],
            [
                'title' => __('sidebar.transaction_payment'),
                'icon'  => 'icon-credit-card',
                'routes' => [
                    [
                        'route' => 'admin.withdraw-requests',
                        'title' => __('sidebar.withdraw_requests'),
                        'permission' => 'can-manage-withdraw-requests',
                    ],
                    [
                        'route' => 'admin.commission-settings',
                        'title' => __('sidebar.commission_settings'),
                        'permission' => 'can-manage-commission-settings',
                    ],
                    [
                        'route' => 'admin.payment-methods',
                        'title' => __('sidebar.payment_methods'),
                        'permission' => 'can-manage-payment-methods',
                    ],
                ],
            ]
        ];

        if (\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions')) {
            $this->menuItems[] = [
                'title' => __('sidebar.manage_subscriptions'),
                'icon'  => 'icon-repeat',
                'permission' => 'can-manage-subscriptions',
                'routes' => [
                    [
                        'route' => 'admin.subscriptions.index',
                        'title' => __('sidebar.subscriptions_list'),
                    ],
                    [
                        'route' => 'admin.subscriptions.purchased',
                        'title' => __('sidebar.purchased_subscriptions'),
                    ],
                ],
            ];
        }

        $this->menuItems[] = [
                'title' => __('blogs.manage_blogs'),
                'icon'  => 'icon-bold',
                'routes' => [
                    [
                        'route' => 'admin.create-blog',
                        'title' => __('blogs.create_blog'),
                        'permission' => 'can-manage-create-blogs',
                    ],
                    [
                        'route' => 'admin.blog-listing',
                        'title' => __('blogs.blog_listing'),
                        'permission' => 'can-manage-all-blogs',
                    ],
                    [
                        'route' => 'admin.blog-categories',
                        'title' => __('blogs.blog_categories'),
                        'permission' => 'can-manage-blog-categories',
                    ],
                ],
            ];


        if (\Nwidart\Modules\Facades\Module::has('forumwise') && \Nwidart\Modules\Facades\Module::isEnabled('forumwise')) {
            $this->menuItems[] = [
                'title' =>  __('sidebar.forums'),
                'icon'  => 'icon-message-square',
                'permission' => 'can-manage-forums',
                'routes' => [
                    [
                        'route' => 'categories',
                        'title' => __('sidebar.categories'),
                    ],
                    [
                        'route' => 'forums',
                        'title' => __('sidebar.forums'),
                    ],
                ],
            ];
        }
      
        if (\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses') && function_exists('courseMenuOptions')) {  
            $menu =  courseMenuOptions('admin');
            $processedMenu = array_map(function ($menuItem) {
                return [
                    'title' => $menuItem['title'],
                    'icon'  => $menuItem['icon'],
                    'permission' => 'can-manage-courses', 
                    'routes' => array_map(function ($route, $title) {
                        return [
                            'route' => $route,
                            'title' => $title,
                        ];
                    }, array_keys($menuItem['routes']), $menuItem['routes']),
                ];
            }, $menu);
            $this->menuItems = array_merge($this->menuItems, $processedMenu);
        }

        if (\Nwidart\Modules\Facades\Module::has('starup') && \Nwidart\Modules\Facades\Module::isEnabled('starup') && function_exists('badgeMenuOptions')) {  
            $menu =  badgeMenuOptions('admin'); 
            $processedMenu = array_map(function ($menuItem) {
                return [
                    'title' => $menuItem['title'],
                    'icon'  => $menuItem['icon'],
                    'permission' => 'can-manage-badges', 
                    'routes' => array_map(function ($route, $title) {
                        return [
                            'route' => $route,
                            'title' => $title,
                        ];
                    }, array_keys($menuItem['routes']), $menuItem['routes']),
                ];
            }, $menu);     
            $this->menuItems = array_merge($this->menuItems, $processedMenu);
        }

        if (\Nwidart\Modules\Facades\Module::has('ipmanager') && \Nwidart\Modules\Facades\Module::isEnabled('ipmanager') && function_exists('IPManagerMenuOptions')) {  
            $menu =  IPManagerMenuOptions('admin'); 
            $processedMenu = array_map(function ($menuItem) {   
                return [
                    'title' => $menuItem['title'],
                    'icon'  => $menuItem['icon'],
                    'permission' => 'can-manage-ipmanager', 
                    'routes' => array_map(function ($route, $title) {
                        return [
                            'route' => $route,
                            'title' => $title,
                        ];
                    }, array_keys($menuItem['routes']), $menuItem['routes']),
                ];
            }, $menu);     
            $this->menuItems = array_merge($this->menuItems, $processedMenu);
        }

    }




    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
            if (isActiveModule('ipmanager')) {
                $userLogService = app(\Modules\IPManager\Services\UserLogsService::class);
                $userLog = $userLogService->updateUserLog();
            }
        $logout();
        $this->redirect('/login', navigate: false);
    }
   
}; ?>
<div class="tb-sidebarwrapperholder">
    <aside id="tb-sidebarwrapper" class="tb-sidebarwrapper">
        <div id="tb-btnmenutoggle" class="tb-btnmenutoggle">
            <a href="javascript:void(0);"><i class="ti-pin2"></i></a>
        </div>
        <div class="tb-sidebartop">
            <strong class="am-logo">
                <x-application-logo />
            </strong>
            <a class="tb-icongray" href="javascript:void(0)"><i class="icon-layout"></i></a>
        </div>
        <nav id="tb-navdashboard" class="tb-navdashboard">
            <ul class="tb-siderbar-nav ">
                @foreach ($menuItems as $item)
                    @php
                        $hasParentPermission = !empty($item['permission']) ? auth()->user()->can($item['permission']) : false;    
                        $allowedRoutes = $hasParentPermission
                        ? $item['routes'] 
                        : array_values(array_filter($item['routes'], function ($route) {
                            return isset($route['permission']) &&!empty($route['permission']) && auth()->user()->can($route['permission']);
                        }));     
                    @endphp
                    @if (count($allowedRoutes) > 0) 
                        <li @class([ 
                            'menu-has-children' => count($allowedRoutes) > 1, 
                            'active' => in_array($activeRoute, array_column($allowedRoutes, 'route')), 
                            'tb-openmenu' => in_array($activeRoute, array_column($allowedRoutes, 'route')) && count($allowedRoutes) > 1 
                        ])>
                            <a href="{{ count($allowedRoutes) > 1 ? 'javascript:void(0);' : route($allowedRoutes[0]['route']) }}" class="tb-menuitm">
                                <i class="{{ $item['icon'] }}"></i>
                                <span class="tb-navdashboard__title">{{ $item['title'] }}</span>
                            </a>
                
                            @if(count($allowedRoutes) > 0 && count($item['routes']) > 1)
                                <ul class="sidebar-sub-menu" style="display:{{ in_array($activeRoute, array_column($allowedRoutes, 'route')) ? 'block' : '' }}">
                                    @foreach ($allowedRoutes as $route)
                                        <li class="{{ request()->routeIs($route['route']) ? 'active' : '' }}">
                                            <a href="{{ route($route['route']) }}">
                                                <span class="tb-navdashboard__title">{{ $route['title'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
                {{-- Disputes Menu --}}
                @if(auth()->user()->can('view_disputes')) 
                    <li class="{{ request()->routeIs('admin.disputes') || request()->routeIs('admin.manage-dispute') ? 'active' : '' }}">
                        <a href="{{ route('admin.disputes') }}" class="tb-menuitm">
                            <i class="icon-alert-triangle"></i>
                            <span class="tb-navdashboard__title">{{ __('sidebar.disputes') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
            <div class="admin-sidebar-footer">
                @if(auth()->user()->can('can-manage-insights'))
                    <div class="am-wallet">
                        <div class="am-wallet_title">
                            <span class="am-wallet_title_icon">
                                <i class="icon-dollar-sign"></i>
                            </span>
                            <div class="am-wallet_balance">
                                <strong>{!! formatAmount($totalCommission, true) !!}<span>{{ __('general.total_commission') }}</span></strong>
                            </div>
                        </div>
                    </div>
                @endIf
                <div class="am-signout">
                    <a href="javascript:void(0)" wire:click="logout" class="tb-haslogout tb-menuitm">
                        <i class="ti-power-off"></i><span class="tb-navdashboard__title"> {{ __('sidebar.logout') }}</span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:initialized', function() {
        document.addEventListener('update_image', (event) => {
            $('#adminImage img').attr('src', event.detail.image);
        });
     })
</script>
@endpush
