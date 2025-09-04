<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['multiLang' => true]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['multiLang' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<?php
    if(!empty(auth()?->user()?->profile->image) && Storage::disk(getStorageDisk())->exists(auth()?->user()?->profile?->image)) {
        $userImage = resizedImage(auth()?->user()?->profile?->image, 36, 36);
    } else {
        $userImage = setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 36, 36);
    }
    $userRole = getUserRole();
    $userRole = $userRole['roleName'];
?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['showCart' => true, 'showMessage' => true]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['showCart' => true, 'showMessage' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<div class="am-header_user">
    <?php if($multiLang): ?>
        <?php if (isset($component)) { $__componentOriginalf058f939673b28ed69913a9622e5fd75 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf058f939673b28ed69913a9622e5fd75 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.multi-currency','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('multi-currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf058f939673b28ed69913a9622e5fd75)): ?>
<?php $attributes = $__attributesOriginalf058f939673b28ed69913a9622e5fd75; ?>
<?php unset($__attributesOriginalf058f939673b28ed69913a9622e5fd75); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf058f939673b28ed69913a9622e5fd75)): ?>
<?php $component = $__componentOriginalf058f939673b28ed69913a9622e5fd75; ?>
<?php unset($__componentOriginalf058f939673b28ed69913a9622e5fd75); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalfa4bf5cb1572938e537fa690884d8b6f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.multi-lingual','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('multi-lingual'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f)): ?>
<?php $attributes = $__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f; ?>
<?php unset($__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa4bf5cb1572938e537fa690884d8b6f)): ?>
<?php $component = $__componentOriginalfa4bf5cb1572938e537fa690884d8b6f; ?>
<?php unset($__componentOriginalfa4bf5cb1572938e537fa690884d8b6f); ?>
<?php endif; ?>
    <?php endif; ?>
    <?php if($showCart): ?>
        <?php
            if(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions')) {
                $cartRole = 'student|tutor';    
            } else {
                $cartRole = 'student';
            }
        ?>
        <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', $cartRole)): ?>
            <div
                class="am-orderwrap"
                x-data="{
                    showCart: false,

                    cartData: <?php echo \Illuminate\Support\Js::from(App\Facades\Cart::content())->toHtml() ?>,
                    total: <?php echo \Illuminate\Support\Js::from(formatAmount(App\Facades\Cart::total(), true))->toHtml() ?>,
                    subTotal: <?php echo \Illuminate\Support\Js::from(formatAmount(App\Facades\Cart::subtotal(), true))->toHtml() ?>,
                    discount: <?php echo \Illuminate\Support\Js::from(formatAmount(App\Facades\Cart::discount(), true))->toHtml() ?>,
                    removeItem(index, cartable_id, cartable_type){
                        this.cartData.splice(index, 1);
                        jQuery('.am-ordersummary').addClass('am-bookcartopen')
                        Livewire.dispatch('remove-cart', { params: {index, cartable_id, cartable_type}})
                        setTimeout(() => {
                            Livewire.dispatch('remove-course-cart', { params: {index, cartable_id, cartable_type}})
                        }, 1000);
                    }
                }"
                x-on:cart-updated.window="
                    cartData = $event.detail.cart_data;
                    total = $event.detail.total;
                    subTotal = $event.detail.subTotal;
                    discount = $event.detail.discount;
                    let menue = jQuery('.am-ordersummary');
                    jQuery('.am-ordersummary').addClass('am-bookcartopen')
                    jQuery('.am-ordersummary').slideDown();
                    if($event.detail.toggle_cart == 'open'){
                        menue.slideDown();
                    } else {
                        menue.slideUp();
                    }
                ">
                <a href="javascript:void(0);" class="am-header_user_noti cart-bag" >
                    <template x-if="cartData.length > 0">
                        <em x-text="cartData.length"></em>
                    </template>
                    <i class="am-icon-shopping-basket-04"></i>
                </a>
                <div class="am-ordersummary" :class="{
                    'am-emptyorder': cartData.length == 0,
                    }">
                    <template x-if="cartData.length > 0">
                        <div class="am-ordersummary_title">
                            <h3><?php echo e(__('tutor.order_summary')); ?></h3>
                            <a href="javascript:void(0);" class="am-ordersummary_close" @click="jQuery('.am-ordersummary').removeClass('am-bookcartopen');">
                                <i class="am-icon-multiply-02"></i>
                            </a>
                        </div>
                    </template>
                    <template x-if="cartData.length > 0">
                        <div class="am-ordersummary_content">
                            <ul class="am-ordersummary_list">
                                <template x-for="(item, index) in cartData">
                                    <li>
                                        <div class="am-ordersummary_list_title">
                                            <template x-if="item.cartable_type == 'App\\Models\\SlotBooking'">
                                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-ordersummary_list_info','am-w-full' => (!\Nwidart\Modules\Facades\Module::has('kupondeal') || \Nwidart\Modules\Facades\Module::isDisabled('kupondeal'))]); ?>">
                                                    <span x-text="item.options.session_time"></span>
                                                    <h3><a href="#" x-text="item.options.subject"></a></h3>
                                                    <span x-text="item.options.subject_group"></span>
                                                </div>
                                            </template>
                                            <?php if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses')): ?>
                                                <template x-if="item.cartable_type == 'Modules\\Courses\\Models\\Course'">
                                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-ordersummary_list_info','am-w-full' => (!\Nwidart\Modules\Facades\Module::has('kupondeal') || \Nwidart\Modules\Facades\Module::isDisabled('kupondeal'))]); ?>">
                                                        <span x-text="item.options.sub_category"></span>
                                                        <h3><a :href="`<?php echo e(route('courses.course-detail', '')); ?>/${item.options.slug}`" x-text="item.name"></a></h3>
                                                    </div>
                                                </template>
                                            <?php endif; ?>
                                            <?php if(\Nwidart\Modules\Facades\Module::has('CourseBundles') && \Nwidart\Modules\Facades\Module::isEnabled('CourseBundles')): ?>
                                                <template x-if="item.cartable_type == 'Modules\\CourseBundles\\Models\\Bundle'">
                                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-ordersummary_list_info','am-w-full' => (!\Nwidart\Modules\Facades\Module::has('kupondeal') || \Nwidart\Modules\Facades\Module::isDisabled('kupondeal'))]); ?>">
                                                        <span><?php echo e(__('coursebundles::bundles.course_bundle')); ?></span>
                                                        <h3><a :href="`<?php echo e(route('coursebundles.bundle-details', '')); ?>/${item.options.slug}`" x-text="item.name"></a></h3>
                                                    </div>
                                                </template>
                                            <?php endif; ?>
                                            <?php if(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions')): ?>  
                                                <template x-if="item.cartable_type == 'Modules\\Subscriptions\\Models\\Subscription'">
                                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-ordersummary_list_info','am-w-full' => (!\Nwidart\Modules\Facades\Module::has('kupondeal') || \Nwidart\Modules\Facades\Module::isDisabled('kupondeal'))]); ?>">
                                                        <span x-text="item.options.period"></span>
                                                        <h3 x-text="item.name"></h3>
                                                    </div>
                                                </template>
                                            <?php endif; ?>
                                            <div class="am-ordersummary_list_action">
                                                <strong>
                                                    <template x-if="1 === <?php echo e(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') ? 1 : 0); ?> && item?.discounted_total != ''">
                                                        <div class="am-ordersummary-discount">
                                                            <strike x-html="item.options.price"></strike>
                                                            <span x-html="item.discounted_total" class="am-cardprice"></span>
                                                        </div>
                                                    </template>
                                                    <template x-if="0 === <?php echo e(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') ? 1 : 0); ?> || item?.discounted_total == ''">
                                                        <div class="am-ordersummary-discount">
                                                        <span x-html="item.options.price" class="am-cardprice"></span>
                                                        </div>
                                                    </template>
                                                    <template x-if="item.cartable_type == 'App\\Models\\SlotBooking'">
                                                        <span><?php echo e(__('tutor.per_session')); ?></span>
                                                    </template>
                                                    <template x-if="item.cartable_type == 'Modules\\Courses\\Models\\Course'">
                                                        <span><?php echo e(__('tutor.per_course')); ?></span>
                                                    </template>
                                                    <template x-if="item.cartable_type == 'Modules\\CourseBundles\\Models\\Bundle'">
                                                        <span><?php echo e(__('coursebundles::bundles.per_bundle')); ?></span>
                                                    </template>
                                                </strong>
                                                <a href="javascript:void(0);" @click.prevent="removeItem(index, item.cartable_id, item.cartable_type)">
                                                    <?php echo e(__('general.remove')); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                            <ul class="am-ordersummary_price">
                                <li>
                                    <span><?php echo e(__('general.subtotal')); ?></span>
                                    <strong><span x-html="subTotal"></span></strong>
                                </li>
                                <?php if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')): ?>
                                    <template x-if="!/\b0\.00\b/.test(discount)">
                                        <li>
                                            <span><?php echo e(__('general.discount')); ?></span>
                                            <strong><span x-html="discount"></span></strong>
                                        </li>
                                    </template>
                                <?php endif; ?>
                                <li class="am-ordersummary_price_total">
                                    <span><?php echo e(__('general.grand_total')); ?></span>
                                    <strong><span x-html="total"></span></strong>
                                </li>
                            </ul>
                            <div class="am-checkoutorder">
                                <a href="<?php echo e(route('checkout')); ?>" wire:navigate.remove class="am-btn" ><?php echo e(__('general.proceed_order')); ?></a>
                                <div class="am-checkout_perinfo">
                                    <span> <i class="am-icon-lock-close"></i> </span>
                                    <p><?php echo e(__('general.proceed_order_desc')); ?></p>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template x-if="cartData.length == 0">
                        <div class="am-emptyview_cart">
                            <a href="javascript:void(0);" class="am-ordersummary_close" @click="jQuery('.am-ordersummary').removeClass('am-bookcartopen');">
                                <i class="am-icon-multiply-01"></i>
                            </a>
                            <h5><?php echo e(__('general.cart_empty')); ?></h5>
                            <span><?php echo e(__('general.cart_empty_desc')); ?></span>
                        </div>
                    </template>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if($userRole == 'tutor' || $userRole == 'student'): ?>
        <div class="am-notifywrap" 
            x-data="{ userNotificationCount: <?php echo \Illuminate\Support\Js::from(auth()->user()->unreadNotifications()->count())->toHtml() ?> }"
            x-on:notifications-count-updated.window="
                userNotificationCount = $event.detail.count;
            ">
            <a href="#" class="am-header_user_notify">
                <i class="am-icon-notification-ring-bell-01"></i>
                <template x-if="userNotificationCount > 0">
                    <span x-text="userNotificationCount"></span>
                </template>
            </a>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages.common.notifications', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1275744418-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>
    <?php endif; ?>
    <?php if($showMessage): ?>
        <?php if($userRole == 'tutor' || $userRole == 'student'): ?>
            <a href="<?php echo e(route('laraguppy.messenger')); ?>" class="am-header_user_chat">
                <i class="am-icon-chat-03"></i>
                <?php
                    $message = getUnreadMsgsCount();
                ?>
                <?php if($message > 0): ?>
                    <span><?php echo e($message); ?></span>
                <?php endif; ?>
            </a>
        <?php endif; ?>
    <?php endif; ?>
    <div class="am-header_user_menu">
        <a href="javascript:void(0);">
            <figure class="am-shimmer userImg">
                <img x-cloak src="<?php echo e($userImage); ?>" alt="<?php echo e(auth()?->user()?->profile?->full_name); ?>">
            </figure>
        </a>
        <div class="am-usermenu-dropdown <?php echo e($userRole == 'admin' ? 'am-dropdown_admin' : ''); ?>">
            <div class="am-user_info">
                <figure>
                    <?php if(auth()->user()->role == 'tutor'): ?>
                        <a href=<?php echo e(route('tutor.dashboard')); ?>><img src="<?php echo e($userImage); ?>" alt="<?php echo e(auth()?->user()?->profile?->full_name); ?>"></a>
                    <?php elseif(auth()->user()->role == 'student'): ?>
                        <a href="<?php echo e(route('student.bookings')); ?>"><img src="<?php echo e($userImage); ?>" alt="<?php echo e(auth()?->user()?->profile?->full_name); ?>"></a>
                    <?php else: ?>
                        <a href="<?php echo e(auth()->user()->redirect_after_login); ?>"><img src="<?php echo e($userImage); ?>" alt="<?php echo e(auth()?->user()?->profile?->full_name); ?>"></a>
                    <?php endif; ?>
                </figure>
                <div class="am-user_name">
                    <h6>
                        <a href=<?php echo e(url(auth()->user()->redirect_after_login)); ?>><?php echo e(auth()?->user()?->profile?->full_name); ?></a>
                        <?php if(auth()->user()->role == 'tutor'): ?>
                            <a href="<?php echo e(route('tutor-detail',['slug' => auth()?->user()?->profile?->slug])); ?>" class="am-custom-tooltip">
                                <span class="am-tooltip-text">
                                    <span><?php echo e(__('general.visit_profile')); ?></span>
                                </span>
                                <i class="am-icon-external-link-02"></i>
                            </a>
                        <?php endif; ?>
                    </h6>
                    <span><?php echo e(auth()?->user()?->email); ?></span>
                </div>
            </div>
            <?php if(setting('_lernen.allow_role_switching') == 'yes'): ?>
                <?php if(auth()->user()->role == 'student' || auth()->user()->role == 'tutor'): ?>
                    <div class="am-account-switch">
                        <div class="am-switch-title">Switch to <?php echo e($userRole == 'tutor' ? 'student' : 'tutor'); ?> account</div>
                        <div class="am-switch-description">You can switch back to <?php echo e($userRole); ?> account anytime with one click</div>
                        <button type="button" onclick="switchUserRole()" class="am-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M3.49996 1.16669L1.16663 3.50002M1.16663 3.50002L3.49996 5.83335M1.16663 3.50002H9.33329M10.5 8.16669L12.8333 10.5M12.8333 10.5L10.5 12.8334M12.8333 10.5H4.66663" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            Switch user role
                        </button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <ul>
                <?php if($userRole == 'student'): ?>
                    <li>
                        <a href="<?php echo e(route('student.profile.personal-details')); ?>">
                            <i class="am-icon-user-01"></i>
                            <?php echo e(__('sidebar.profile_settings')); ?>

                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('student.bookings')); ?>">
                            <i class="am-icon-calender-day"></i>
                            <?php echo e(__('sidebar.bookings')); ?>

                        </a>
                    </li>
                    <?php if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses') && function_exists('courseMenuOptions')): ?>
                        <?php
                            $courseMenuOptions = courseMenuOptions('student');
                        ?>
                        <li>
                            <a href="<?php echo e(route($courseMenuOptions[0]['route'])); ?>">
                                <?php echo $courseMenuOptions[0]['icon']; ?>

                                <?php echo e($courseMenuOptions[0]['title']); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?php echo e(route('student.billing-detail')); ?>">
                            <svg class="am-svg-fill" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M16.4336 13.7498C16.4336 14.394 17.1102 15.0201 17.8296 15.0201C18.6889 15.0201 19.385 14.5165 19.4239 13.7453C19.5405 11.4225 16.4336 12.8606 16.4258 10.7193C16.4219 9.94812 16.9702 9.42188 17.8257 9.42188C18.5373 9.42188 19.4239 9.83017 19.4239 10.7284" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                <path d="M17.8301 15.7237V15.0205" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                <path d="M17.8301 9.42227V8.72363" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                <path d="M17.8364 17.9648V18C17.8364 19.6569 16.4933 21 14.8364 21H7.57324C5.91639 21 4.57324 19.6569 4.57324 18V6C4.57324 4.34315 5.91639 3 7.57324 3H11.2048H14.5206C16.3519 3 17.8364 4.48453 17.8364 6.31579V6.31579" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7.64844 8.83896L8.51252 9.59971L11.2591 6.84766" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7.64844 13.3896H12.6484" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                <path d="M7.64844 17.082H12.6484" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                            </svg>
                            <?php echo e(__('sidebar.billing_detail')); ?>

                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('student.favourites')); ?>">
                            <i class="am-icon-heart-01"></i>
                            <?php echo e(__('sidebar.favourites')); ?>

                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('find-tutors')); ?>" >
                            <i class="am-icon-user-02"></i>
                            <?php echo e(__('sidebar.find_tutors')); ?>

                        </a>
                    </li>
                    <?php if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses')): ?>
                        <li>
                            <a href="<?php echo e(route('courses.search-courses')); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.5 3.96429C2.5 1.78814 4.23508 0 6.40478 0H17.5952C19.7649 0 21.5 1.78815 21.5 3.96429V18.8214C21.5 19.0468 21.4006 19.2489 21.2433 19.3864C21.2263 19.4019 21.2083 19.4169 21.1893 19.4313L21.1893 19.4313L21.049 19.5377C20.0672 20.2825 20.0669 21.7897 21.0484 22.5349C21.6452 22.9879 21.3683 24 20.5566 24H6.20458C4.14603 24 2.50319 22.2999 2.51013 20.2372L2.5144 18.9684C2.50495 18.9209 2.5 18.8717 2.5 18.8214V3.96429ZM4.01238 19.5714L4.01012 20.2422C4.00589 21.5012 5.00286 22.5 6.20458 22.5H19.1401C18.703 21.5789 18.7032 20.4923 19.1409 19.5714H4.01238ZM20 18.0714H4V3.96429C4 2.59003 5.08981 1.5 6.40478 1.5H17.5952C18.9102 1.5 20 2.59002 20 3.96429V18.0714ZM11.6403 5.04127C9.28792 5.04127 7.35712 6.98815 7.35712 9.41939C7.35712 11.8506 9.28792 13.7975 11.6403 13.7975C13.9927 13.7975 15.9235 11.8506 15.9235 9.41939C15.9235 6.98815 13.9927 5.04127 11.6403 5.04127ZM5.85712 9.41939C5.85712 6.18627 8.4332 3.54127 11.6403 3.54127C14.8474 3.54127 17.4235 6.18627 17.4235 9.41939C17.4235 10.7695 16.9743 12.017 16.2175 13.0123L17.9277 14.7548C18.2179 15.0504 18.2135 15.5252 17.9178 15.8154C17.6222 16.1055 17.1474 16.1011 16.8572 15.8055L15.1645 14.0808C14.1905 14.8431 12.9696 15.2975 11.6403 15.2975C8.4332 15.2975 5.85712 12.6525 5.85712 9.41939Z" fill="#585858"></path>
                                </svg>
                                <?php echo e(__('courses::courses.find_courses')); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                <?php elseif($userRole == 'tutor'): ?>
                    <li>
                        <a href="<?php echo e(route('tutor.dashboard')); ?>">
                            <i class="am-icon-layer-01"></i>
                            <?php echo e(__('sidebar.dashboard')); ?>

                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('tutor.profile.personal-details')); ?>"><i class="am-icon-user-01"></i><?php echo e(__('sidebar.profile_settings')); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('tutor.bookings.subjects')); ?>">
                            <i class="am-icon-calender-day"></i>
                            <?php echo e(__('sidebar.bookings')); ?>

                        </a>
                    </li>
                    <?php if(\Nwidart\Modules\Facades\Module::has('forumwise') && \Nwidart\Modules\Facades\Module::isEnabled('forumwise')): ?>
                        <li>
                            <a href="<?php echo e(route('forums')); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                    <g clip-path="url(#clip0_12237_67771)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.559326 1.73169C0.559326 1.00682 1.14695 0.419189 1.87183 0.419189C2.5967 0.419189 3.18433 1.00682 3.18433 1.73169C3.18433 2.45656 2.5967 3.04419 1.87183 3.04419C1.14695 3.04419 0.559326 2.45656 0.559326 1.73169ZM6.80105 3.69551C5.8804 4.03215 5.06484 4.56346 4.38961 5.23801C3.67516 5.97101 3.12689 6.84105 2.80941 7.81113C2.80056 7.83816 2.78971 7.86439 2.77697 7.88963C2.57444 8.51131 2.47127 9.18914 2.47127 9.8902C2.47127 12.3583 3.84118 14.5133 5.86034 15.6346C4.77234 14.5 4.10291 12.961 4.10291 11.2685C4.10291 10.6017 4.20134 9.94514 4.40208 9.33204C4.40532 9.31966 4.40909 9.3069 4.41345 9.29382C4.42214 9.26775 4.43307 9.24089 4.44658 9.21386C4.7579 8.29595 5.27928 7.48259 5.94112 6.80421L5.94597 6.79924L5.946 6.79927C6.59253 6.15274 7.37665 5.64098 8.26415 5.31669L8.26715 5.3156L8.26715 5.31561C8.93024 5.07758 9.6471 4.94065 10.3997 4.94065H10.4024V4.94066C12.107 4.94893 13.648 5.62079 14.7822 6.70861C13.6632 4.69052 11.5101 3.3179 9.01627 3.3053C8.23851 3.30547 7.49453 3.44675 6.80105 3.69551ZM16.7275 11.2438L16.7275 9.8902C16.7275 5.64892 13.297 2.20107 9.02037 2.18031V2.1803H9.01763C8.10112 2.1803 7.2278 2.34703 6.41943 2.63721L6.41943 2.6372L6.41644 2.6383C5.33523 3.03336 4.37975 3.65687 3.59167 4.44496L3.59163 4.44493L3.58679 4.4499C2.77701 5.27993 2.14069 6.27433 1.76209 7.39541C1.74644 7.42566 1.734 7.45572 1.72432 7.48477C1.71943 7.49943 1.71529 7.51368 1.71178 7.52744C1.46681 8.27408 1.34627 9.07514 1.34627 9.8902C1.34627 14.131 4.79614 17.5808 9.0369 17.5808L10.396 17.5808C10.4024 17.5809 10.4088 17.5809 10.4153 17.5809H16.1651C16.4757 17.5809 16.7276 17.329 16.7276 17.0184V11.2685C16.7276 11.2603 16.7276 11.252 16.7275 11.2438ZM15.6025 11.2461L15.6026 16.4559L10.3978 16.4558C7.54626 16.4464 5.22791 14.1222 5.22791 11.2685C5.22791 10.7164 5.30878 10.1837 5.46674 9.69591C5.4778 9.67311 5.48735 9.64952 5.49527 9.62529C5.74571 8.86009 6.17851 8.17258 6.74395 7.59231C7.27762 7.05933 7.92181 6.63978 8.64875 6.37391C9.19696 6.1773 9.7845 6.06581 10.3984 6.06565C13.2834 6.0804 15.5905 8.3978 15.6025 11.2461ZM15.5656 3.53784C15.5656 3.02007 15.9854 2.60034 16.5031 2.60034C17.0209 2.60034 17.4406 3.02007 17.4406 3.53784C17.4406 4.05561 17.0209 4.47534 16.5031 4.47534C15.9854 4.47534 15.5656 4.05561 15.5656 3.53784ZM6.4778 11.2607C6.4778 10.7429 6.89753 10.3232 7.4153 10.3232C7.93307 10.3232 8.3528 10.7429 8.3528 11.2607C8.3528 11.7785 7.93307 12.1982 7.4153 12.1982C6.89753 12.1982 6.4778 11.7785 6.4778 11.2607ZM9.4778 11.2607C9.4778 10.7429 9.89753 10.3232 10.4153 10.3232C10.9331 10.3232 11.3528 10.7429 11.3528 11.2607C11.3528 11.7785 10.9331 12.1982 10.4153 12.1982C9.89753 12.1982 9.4778 11.7785 9.4778 11.2607ZM12.4778 11.2607C12.4778 10.7429 12.8975 10.3232 13.4153 10.3232C13.9331 10.3232 14.3528 10.7429 14.3528 11.2607C14.3528 11.7785 13.9331 12.1982 13.4153 12.1982C12.8975 12.1982 12.4778 11.7785 12.4778 11.2607Z" fill="#585858"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_12237_67771">
                                    <rect width="18" height="18" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                                <?php echo e(__('sidebar.forums')); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(\Nwidart\Modules\Facades\Module::has('upcertify') && \Nwidart\Modules\Facades\Module::isEnabled('upcertify')): ?>
                        <li>
                            <a href="<?php echo e(route('upcertify.certificate-list')); ?>">
                            <i class="am-icon-certificate"> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.45455C6.38421 3.45455 3.45455 6.38421 3.45455 10C3.45455 13.6158 6.38421 16.5455 10 16.5455H15.5169L10.9953 12.0238C10.4954 12.3271 9.90884 12.5018 9.28145 12.5018C7.4547 12.5018 5.97382 11.0209 5.97382 9.19418C5.97382 7.36742 7.4547 5.88655 9.28145 5.88655C11.1082 5.88655 12.5891 7.36742 12.5891 9.19418C12.5891 9.86686 12.3883 10.4926 12.0434 11.0148L16.5455 15.5169V10C16.5455 6.38421 13.6158 3.45455 10 3.45455ZM2 10C2 5.58088 5.58088 2 10 2C14.4191 2 18 5.58088 18 10V18H10C5.58088 18 2 14.4191 2 10ZM9.28145 7.34109C8.25802 7.34109 7.42836 8.17075 7.42836 9.19418C7.42836 10.2176 8.25802 11.0473 9.28145 11.0473C10.3049 11.0473 11.1345 10.2176 11.1345 9.19418C11.1345 8.17075 10.3049 7.34109 9.28145 7.34109Z" fill="#585858"/></svg> </i>
                                <?php echo e(__('sidebar.certificates')); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')): ?>
                        <li>
                            <a href="<?php echo e(route('kupondeal.coupon-list')); ?>">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.90858 8.46862C8.90858 8.12344 8.62875 7.84361 8.28359 7.84361C7.93841 7.84361 7.65859 8.12344 7.65859 8.46862V11.5314C7.65859 11.8765 7.93841 12.1564 8.28359 12.1564C8.62875 12.1564 8.90858 11.8765 8.90858 11.5314V8.46862Z" fill="#585858"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.16666 3.12502C2.44077 3.12502 1.04166 4.52413 1.04166 6.25002V6.87501C1.04166 7.53159 1.56311 7.95963 2.06064 8.05994C2.96501 8.24229 3.64583 9.04232 3.64583 9.99999C3.64583 10.9577 2.96501 11.7577 2.06064 11.9401C1.56311 12.0404 1.04166 12.4685 1.04166 13.125V13.75C1.04166 15.4759 2.44077 16.875 4.16666 16.875H15.8333C17.5592 16.875 18.9583 15.4759 18.9583 13.75V13.125C18.9583 12.4685 18.4369 12.0404 17.9393 11.9401C17.035 11.7577 16.3542 10.9577 16.3542 9.99999C16.3542 9.04232 17.035 8.24229 17.9393 8.05994C18.4369 7.95963 18.9583 7.53158 18.9583 6.87501V6.25002C18.9583 4.52413 17.5592 3.12502 15.8333 3.12502H4.16666ZM2.29166 6.25002C2.29166 5.21448 3.13113 4.37502 4.16666 4.37502H7.65859V5.40192C7.65859 5.74711 7.93841 6.02692 8.28359 6.02692C8.62875 6.02692 8.90858 5.74711 8.90858 5.40192V4.37502H15.8333C16.8688 4.37502 17.7083 5.21448 17.7083 6.25002V6.8296C17.7032 6.83176 17.6978 6.83349 17.6923 6.8346C16.216 7.13226 15.1042 8.43557 15.1042 9.99999C15.1042 11.5644 16.216 12.8677 17.6923 13.1654C17.6978 13.1666 17.7032 13.1682 17.7083 13.1704V13.75C17.7083 14.7856 16.8688 15.625 15.8333 15.625H8.90858V14.5901C8.90858 14.2449 8.62875 13.9651 8.28359 13.9651C7.93841 13.9651 7.65859 14.2449 7.65859 14.5901V15.625H4.16666C3.13113 15.625 2.29166 14.7856 2.29166 13.75V13.1704C2.29672 13.1682 2.30218 13.1666 2.30771 13.1654C3.78397 12.8677 4.89583 11.5644 4.89583 9.99999C4.89583 8.43557 3.78397 7.13226 2.30771 6.8346C2.30218 6.83349 2.29672 6.83176 2.29166 6.8296V6.25002Z" fill="#585858"/>
                            </svg> 
                                <?php echo e(__('sidebar.coupons')); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?php echo e(route('tutor.invoices')); ?>">
                            <i class="am-icon-invoices-01"></i>
                            <?php echo e(__('sidebar.invoices')); ?>

                        </a>
                    </li>       
                <?php endif; ?>     
                <?php if($userRole == 'tutor' || $userRole == 'student'): ?>
                    <li>
                        <a href="<?php echo e(route('laraguppy.messenger')); ?>">
                            <i class="am-icon-chat-03"></i>
                            <?php echo e(__('sidebar.messages')); ?></a>
                    </li>
                    <?php if(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions')): ?>
                        <li>
                            <a href="<?php echo e(url(auth()->user()->role.'-subscriptions')); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 25" fill="none">
                                    <path d="M2 6.66144H6.37753M6.37753 6.66144L6.33722 11.0498M6.37753 6.66144C-1.15378 10.2721 2.26347 22.8923 11.9996 22.9671M22 19.2685H17.6225M17.6225 19.2685L17.6628 14.8802M17.6225 19.2685C25.1538 15.6578 21.7365 3.03768 12.0004 2.96289M10.0087 14.7096C10.0087 15.4459 10.9108 16.1613 11.87 16.1613M11.87 16.1613C13.0158 16.1613 13.9439 15.5858 13.9957 14.7044C14.1513 12.0499 10.0087 13.6934 9.99832 11.2462C9.99314 10.3648 10.7242 9.76342 11.8648 9.76342M11.87 16.1613V16.965M11.8648 9.76342C12.8136 9.76342 13.9957 10.23 13.9957 11.2566M11.8648 9.76342L11.87 8.96497" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <?php echo e(__('subscriptions::subscription.subscription_title')); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if($userRole == 'admin'): ?>
                    <li>
                        <a href="<?php echo e(auth()->user()->redirect_after_login); ?>">
                            <i class="am-icon-layer-01"></i>
                            <?php echo e(__('sidebar.insights')); ?>

                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.profile')); ?>"><i class="am-icon-user-01"></i><?php echo e(__('sidebar.profile_settings')); ?></a>
                    </li>
                <?php endif; ?>
                <li class="am-header_user_signout">
                    <a href="<?php echo e(route('logout')); ?>">
                        <i class="am-icon-sign-out-02"></i>
                        <?php echo e(__('general.sign_out')); ?></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
function switchUserRole() {
    fetch("<?php echo e(route('switch-role')); ?>", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let newRole = data.newRole.charAt(0).toUpperCase() + data.newRole.slice(1);
            Livewire.dispatch('showAlertMessage', { type: 'success', title: '<?php echo e(__('general.success_title')); ?>', message: 'You have successfully switched to the ' + newRole + ' role.' });
            location.reload();
            if(data.newRole == 'tutor'){
                window.location.href = "<?php echo e(route('tutor.dashboard')); ?>";
            }else{
                window.location.href = "<?php echo e(route('student.bookings')); ?>";
            }
        }
    })
    .catch(error => {
        console.error("Error switching role:", error);
    });
}
</script><?php /**PATH D:\Sahos\Laravel\lla\resources\views/components/frontend/user-menu.blade.php ENDPATH**/ ?>