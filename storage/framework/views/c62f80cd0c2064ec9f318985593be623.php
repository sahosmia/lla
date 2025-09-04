<div class="am-profile-setting" wire:init="loadData">
    <?php echo $__env->make('livewire.pages.tutor.manage-sessions.tabs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!--[if BLOCK]><![endif]--><?php if($isLoading): ?>
        <div class="am-section-load">
            <p><?php echo e(__('general.loading')); ?></p>
        </div>
    <?php else: ?>
        <div class="am-section-load" wire:loading.flex wire:target="deleteSlot,loadData">
            <p><?php echo e(__('general.loading')); ?></p>
        </div>
        <div class="am-upcomming-bookings-wrapper" x-data="{
                sessionInfo: {},
                sessionData: <?php if ((object) ('form') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form'->value()); ?>')<?php echo e('form'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form'); ?>')<?php endif; ?>,
                rescheduleData: <?php if ((object) ('rescheduleForm') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('rescheduleForm'->value()); ?>')<?php echo e('rescheduleForm'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('rescheduleForm'); ?>')<?php endif; ?>,
                slotId: <?php if ((object) ('editableSlotId') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('editableSlotId'->value()); ?>')<?php echo e('editableSlotId'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('editableSlotId'); ?>')<?php endif; ?>,
                userSubjectGroupId: <?php if ((object) ('userSubjectGroupId') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('userSubjectGroupId'->value()); ?>')<?php echo e('userSubjectGroupId'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('userSubjectGroupId'); ?>')<?php endif; ?>,
                totalBooking: 0,
                }">
            <div class="am-calendar-task">
                <i class="am-icon-chevron-left"></i>
                <a href="<?php echo e(route('tutor.bookings.manage-sessions')); ?>" wire:navigate.remove>
                    <?php echo e(__('calendar.back_to_calendar')); ?>

                </a>
            </div>
            <div class="am-calendar-wrapper">
                <a href="<?php echo e(route('tutor.bookings.session-detail', ['date' => parseToUserTz($date->copy()->subDay())->toDateString()])); ?>" wire:navigate.remove wire:loading.attr="disabled">
                    <i class="am-icon-chevron-left"></i>
                </a>
                <div class="am-calendar-schedule">
                    <span>
                        <?php echo e(parseToUserTz($date->copy())->format('l')); ?>

                    </span>
                    <h6>
                        <?php echo e(parseToUserTz($date->copy())->format('F d, Y')); ?>

                        <i class="am-icon-calender-minus"></i>
                    </h6>
                </div>
                <a href="<?php echo e(route('tutor.bookings.session-detail', ['date' => parseToUserTz($date->copy()->addDay())->toDateString()])); ?>" wire:navigate.remove wire:loading.attr="disabled">
                    <i class="am-icon-chevron-right"></i>
                </a>
            </div>
            <!--[if BLOCK]><![endif]--><?php if(empty($sessionDetail)): ?>
                <?php if (isset($component)) { $__componentOriginal86cd4a276c2978c462f28bbb510e89a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-record','data' => ['image' => asset('images/session.png'),'title' => __('calendar.no_sessions'),'description' => __('calendar.no_session_desc')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(asset('images/session.png')),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('calendar.no_sessions')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('calendar.no_session_desc'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal86cd4a276c2978c462f28bbb510e89a0)): ?>
<?php $attributes = $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0; ?>
<?php unset($__attributesOriginal86cd4a276c2978c462f28bbb510e89a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal86cd4a276c2978c462f28bbb510e89a0)): ?>
<?php $component = $__componentOriginal86cd4a276c2978c462f28bbb510e89a0; ?>
<?php unset($__componentOriginal86cd4a276c2978c462f28bbb510e89a0); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if(!empty($sessionDetail) && count($sessionDetail) > 1): ?>
                <ul class="am-session-slots am-schooling-tabs" role="tablist">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sessionDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subjGroup => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <button class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active'=>$loop->first]); ?>" id="<?php echo e(\Str::slug($subjGroup)); ?>-btn" data-bs-toggle="tab" data-bs-target="#<?php echo e(\Str::slug($subjGroup)); ?>Tab" aria-selected="true"><?php echo e($subjGroup); ?></button>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php if(!empty($sessionDetail)): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sessionDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subjGroup => $sbjGroups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tab-content">
                        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['tab-pane','fade','show' => $loop->first, 'active' => $loop->first]); ?>" id="<?php echo e(\Str::slug($subjGroup)); ?>Tab">
                            <div class="am-calendar-content am-timecoursewrap">
                                <div class="am-subjects-content">
                                    <h5>
                                        <!--[if BLOCK]><![endif]--><?php if(count($sessionDetail) > 1): ?>
                                            <?php echo e(__('calendar.all_subjects')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('calendar.subjects_of_group',[ 'group' => array_key_first($sessionDetail) ])); ?>

                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </h5>
                                    <ul class="am-subjects-list" id="nav-tab" role="tablist">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sbjGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $slotsLeft = 0;
                                                $sessionInfo = [
                                                    'subject' => $subject['info']['subject'],
                                                    'date'    => parseToUserTz($date->copy())->format('F d, Y'),
                                                ];

                                                if (!empty($subject['info']['image']) && Storage::disk(getStorageDisk())->exists($subject['info']['image'])) {
                                                    $sessionInfo['image'] = resizedImage($subject['info']['image'], 40,40);
                                                } else {
                                                    $sessionInfo['image'] = resizedImage('placeholder.png', 40,40);
                                                }

                                                foreach ($subject['slots'] as $slot) {
                                                    $slotsLeft += $slot->spaces - $slot->total_booked;
                                                }

                                            ?>
                                            <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => $loop->first]); ?>" id="<?php echo e(\Str::slug($subject['info']['subject']) . '-' . \Str::slug($subjGroup)); ?>-btn" data-bs-toggle="tab" data-bs-target="#<?php echo e(\Str::slug($subject['info']['subject']) . '-' . \Str::slug($subjGroup)); ?>-tab" role="tab" aria-controls="<?php echo e(\Str::slug($subject['info']['subject']) . '-' . \Str::slug($subjGroup)); ?>-tab" aria-selected="false">
                                                <img src="<?php echo e($sessionInfo['image']); ?>" alt="<?php echo e($subject['info']['subject']); ?>" />
                                                <div class="am-subjects-description">
                                                    <h6>
                                                        <?php echo e($subject['info']['subject']); ?>

                                                    </h6>
                                                    <span>
                                                        <?php echo e(__('calendar.no_slots_left', ['count' => $slotsLeft])); ?>

                                                    </span>
                                                </div>
                                                <span @click="sessionInfo = <?php echo \Illuminate\Support\Js::from($sessionInfo)->toHtml() ?>;
                                                        userSubjectGroupId      = <?php echo \Illuminate\Support\Js::from($subject['info']['user_subject_id'])->toHtml() ?>;
                                                        sessionData.action      = 'add';
                                                        sessionData.session_fee = <?php echo \Illuminate\Support\Js::from($subject['info']['hour_rate'])->toHtml() ?>;
                                                        sessionData.allowed_for_subscriptions = 0;
                                                        sessionData.template_id = '';
                                                        sessionData.assign_quiz_certificate = '';

                                                        $nextTick(() => {
                                                            $wire.dispatch('toggleModel' ,{ id: 'edit-session', action:'show'});
                                                            $wire.dispatch('initSelect2', {target:'.am-select2'});
                                                            $wire.dispatch('initSummerNote', {target: '#edit-session-desc', wiremodel: 'form.description', conetent: '', componentId: window.Livewire.find('<?php echo e($_instance->getId()); ?>')});
                                                        })
                                                    ">
                                                    <i class="am-icon-plus-02"></i>
                                                </span>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </ul>
                                </div>
                                <div class="am-session-table am-payouthistory tab-content">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sbjGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-sessionstable','tab-pane','fade','show' => $loop->first, 'active' => $loop->first]); ?>" id="<?php echo e(\Str::slug($subject['info']['subject']) . '-' . \Str::slug($subjGroup)); ?>-tab" role="tabpanel" aria-labelledby="<?php echo e(\Str::slug($subject['info']['subject']) . '-' . \Str::slug($subjGroup)); ?>-btn"  tabindex="0">
                                        <table class="am-table">
                                            <thead>
                                                <tr>
                                                    <th><?php echo e(__('calendar.time')); ?></th>
                                                    <th><?php echo e(__('calendar.type')); ?></th>
                                                    <th><?php echo e(__('calendar.total_enrollment')); ?></th>
                                                    <th><!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?><?php echo e(__('calendar.session_fee')); ?><?php endif; ?><!--[if ENDBLOCK]><![endif]--></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subject['slots']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-session-completed' => parseToUTC($slot->start_time)->isPast()]); ?>">
                                                    <td data-label="Time">
                                                        <!--[if BLOCK]><![endif]--><?php if(setting('_lernen.time_format') == '12'): ?>
                                                            <?php echo e(parseToUserTz($slot->start_time)->format('h:i a')); ?> -
                                                            <?php echo e(parseToUserTz($slot->end_time)->format('h:i a')); ?>

                                                        <?php else: ?>
                                                            <?php echo e(parseToUserTz($slot->start_time)->format('H:i')); ?> -
                                                            <?php echo e(parseToUserTz($slot->end_time)->format('H:i')); ?>

                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </td>
                                                    <td data-label="Type">
                                                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-selection-tag', 'am-tag-puple' => $slot->spaces == 1]); ?>">
                                                            <?php echo e($slot->spaces > 1 ? __('calendar.group') : __('calendar.one')); ?>

                                                        </span>
                                                    </td>
                                                    <td data-label="Total Enrolment">
                                                        <!--[if BLOCK]><![endif]--><?php if($slot->total_booked > 0 && !empty($slot->students)): ?>
                                                            <div class="am-students-profile">
                                                                <ul>
                                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $slot->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <li>
                                                                            <!--[if BLOCK]><![endif]--><?php if(!empty($student->image) && Storage::disk(getStorageDisk())->exists($student->image)): ?>
                                                                                <img src="<?php echo e(resizedImage($student->image, 40, 40)); ?>" alt="profile-img">
                                                                            <?php else: ?>
                                                                                <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 40, 40)); ?>" alt="profile-img">
                                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                        </li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                                </ul>
                                                                <span><?php echo e(__('calendar.booked_students', ['count' => $slot->bookings_count])); ?></span>
                                                            </div>
                                                        <?php else: ?>
                                                            --
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </td>
                                                    <td data-label="Session Fare">
                                                        <div class="am-session-fare">
                                                            <!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?>
                                                                <?php echo e(formatAmount($slot->session_fee ?? 0)); ?>

                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            <!--[if BLOCK]><![endif]--><?php if(\Carbon\Carbon::parse($slot->start_time)->isFuture()): ?>
                                                                <div class="am-itemdropdown">
                                                                    <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="am-icon-ellipsis-horizontal-02"></i>
                                                                    </a>
                                                                    <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                        <li>
                                                                            <?php
                                                                                if(setting('_lernen.time_format') == '12') {
                                                                                    $sessionInfo = [
                                                                                        'subject' => $subject['info']['subject'],
                                                                                        'date'    => parseToUserTz($date->copy())->format('F d, Y'),
                                                                                        'start_time' => parseToUserTz($slot->start_time)->format('h:i a'),
                                                                                        'end_time' => parseToUserTz($slot->end_time)->format('h:i a'),
                                                                                    ];
                                                                                } else {
                                                                                    $sessionInfo = [
                                                                                        'subject' => $subject['info']['subject'],
                                                                                        'date'    => parseToUserTz($date->copy())->format('F d, Y'),
                                                                                        'start_time' => parseToUserTz($slot->start_time)->format('H:i'),
                                                                                        'end_time' => parseToUserTz($slot->end_time)->format('H:i'),
                                                                                    ];
                                                                                }   
                                                                                if (!empty($subject['info']['image']) && Storage::disk(getStorageDisk())->exists($subject['info']['image'])) {
                                                                                    $sessionInfo['image'] = resizedImage($subject['info']['image'], 40,40);
                                                                                } else {
                                                                                    $sessionInfo['image'] = resizedImage('placeholder.png', 40,40);
                                                                                }

                                                                            ?>
                                                                            <a href="#" @click=" sessionInfo = <?php echo \Illuminate\Support\Js::from($sessionInfo)->toHtml() ?>;
                                                                                                slotId                    = <?php echo \Illuminate\Support\Js::from($slot->id)->toHtml() ?>;
                                                                                                sessionData.spaces        = <?php echo \Illuminate\Support\Js::from($slot->spaces)->toHtml() ?>;
                                                                                                sessionData.session_fee   = <?php echo \Illuminate\Support\Js::from($slot->session_fee)->toHtml() ?>;
                                                                                                sessionData.description   = <?php echo \Illuminate\Support\Js::from($slot->description)->toHtml() ?>;
                                                                                                sessionData.meeting_link  = <?php echo \Illuminate\Support\Js::from($slot->meta_data['meeting_link'] ?? '')->toHtml() ?>;
                                                                                                totalBooking              = <?php echo \Illuminate\Support\Js::from($slot->total_booked)->toHtml() ?>;
                                                                                                sessionData.action        = 'edit';
                                                                                                sessionData.allowed_for_subscriptions = <?php echo \Illuminate\Support\Js::from($slot->meta_data['allowed_for_subscriptions'] ?? 0)->toHtml() ?>;
                                                                                                sessionData.template_id = <?php echo \Illuminate\Support\Js::from($slot->meta_data['template_id'] ?? '')->toHtml() ?>;
                                                                                                sessionData.assign_quiz_certificate = <?php echo \Illuminate\Support\Js::from($slot->meta_data['assign_quiz_certificate'] ?? '')->toHtml() ?>;
                                                                                                $nextTick(() => {
                                                                                                    $wire.dispatch('toggleModel' ,{ id: 'edit-session', action:'show', description:  sessionData.description});
                                                                                                    $wire.dispatch('initSummerNote', {target: '#edit-session-desc', wiremodel: 'form.description', conetent: <?php echo \Illuminate\Support\Js::from($slot->description)->toHtml() ?>, componentId: window.Livewire.find('<?php echo e($_instance->getId()); ?>')});
                                                                                                })
                                                                                                    $nextTick(() => {
                                                                                                    $wire.dispatch('initSelect2', {target:'.am-select2'});
                                                                                                })
                                                                                            ">
                                                                                <i class="am-icon-pencil-02"></i>
                                                                                <?php echo e(__('general.edit')); ?>

                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a x-data="{ linkToCopy: '<?php echo e(route('session-detail', ['id' => encrypt($slot?->id)])); ?>' }" 
                                                                                @click="navigator.clipboard.writeText(linkToCopy)">
                                                                                <i class="am-icon-copy-01"></i>
                                                                                <?php echo e(__('general.copy_link')); ?>

                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" wire:key="<?php echo e(time()); ?>"
                                                                                class="am-del-btn"
                                                                                <?php if($slot->total_booked > 0): ?>
                                                                                    @click=" totalBooking               = <?php echo \Illuminate\Support\Js::from($slot->total_booked)->toHtml() ?>;
                                                                                            sessionInfo                 = <?php echo \Illuminate\Support\Js::from($sessionInfo)->toHtml() ?>;
                                                                                            slotId                      = <?php echo \Illuminate\Support\Js::from($slot->id)->toHtml() ?>;
                                                                                            rescheduleData.description  = <?php echo \Illuminate\Support\Js::from($slot->description)->toHtml() ?>;
                                                                                            userSubjectGroupId          = <?php echo \Illuminate\Support\Js::from($subject['info']['user_subject_id'])->toHtml() ?>;
                                                                                            $nextTick(() => {
                                                                                                $wire.dispatch('toggleModel', { id : 'attention-popup', action : 'show' });
                                                                                                $wire.dispatch('initSummerNote', {target: '#session-desc', wiremodel: 'rescheduleForm.description', conetent: <?php echo \Illuminate\Support\Js::from($slot->description)->toHtml() ?>, componentId: window.Livewire.find('<?php echo e($_instance->getId()); ?>')});
                                                                                            })
                                                                                    "
                                                                                <?php else: ?>
                                                                                    @click="$wire.dispatch('showConfirm', { id : <?php echo \Illuminate\Support\Js::from($slot->id)->toHtml() ?>, action : 'delete-slot' })"
                                                                                <?php endif; ?>
                                                                                >
                                                                                <i class="am-icon-trash-02"></i>
                                                                                <?php echo e(__('general.delete')); ?>

                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            <?php else: ?> 
                                                                <span> <?php echo e(__('calendar.ended')); ?> </span>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!-- Attention popup -->
            <div class="modal fade am-attentionpopup" id="attention-popup" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="am-modal-body">
                            <span data-bs-dismiss="modal" class="am-closepopup">
                                <i class="am-icon-multiply-01"></i>
                            </span>
                            <div class="am-deletepopup_icon">
                                <span><i class="am-icon-exclamation-01"></i></span>
                            </div>
                            <div class="am-deletepopup_title">
                                <h3><?php echo e(__('calendar.pay_attention')); ?> <strong x-text="totalBooking + ' <?php echo e(__('calendar.enrollments')); ?>'"></strong></h3>
                                <p><?php echo e(__('calendar.reschedule_msg')); ?></p>
                                <span>
                                    <i class="am-icon-exclamation-01"></i>
                                    <?php echo e(__('calendar.reschedule_warning')); ?></span>
                            </div>
                            <div class="am-deletepopup_btns">
                                <a href="#" class="am-btn am-btn-del" data-bs-dismiss="modal" @click="
                                    $wire.dispatch('toggleModel' ,{ id: 'reschedule-popup', action:'show'});
                                    $wire.dispatch('initSelect2', {target:'.am-select2'});
                                    $wire.dispatch('initSummerNote', {target: '#reschedule-reason', wiremodel: 'rescheduleForm.reason', conetent: '', componentId: window.Livewire.find('<?php echo e($_instance->getId()); ?>')});
                                    "><?php echo e(__('calendar.reschedule_other_day')); ?></a>
                                <a href="#" class="am-btn am-btnsmall" data-bs-dismiss="modal"><?php echo e(__('calendar.change_of_mind')); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div wire:ignore.self class="modal am-modal am-reschedulepopup fade" id="reschedule-popup" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="am-modal-header">
                            <h2><?php echo e(__('calendar.reschedule_title')); ?></h2>
                            <span class="am-closepopup" data-bs-dismiss="modal" wire:loading.attr="disabled">
                                <i class="am-icon-multiply-01"></i>
                            </span>
                        </div>
                        <div class="am-modal-body">
                            <div class="am-reschedule">
                                <div class="am-reschedule_time">
                                    <p><?php echo e(__('calendar.current_date_time')); ?></p>
                                    <span x-html="sessionInfo.date + ' <time> ( ' + sessionInfo.start_time + ' - ' + sessionInfo.end_time + ')</time>'"></span>
                                </div>
                                <div class="am-reschedule_icon">
                                    <i class="am-icon-chevron-right"></i>
                                </div>
                                <div class="am-reschedule_time">
                                    <p><?php echo e(__('calendar.reschedule_date_time')); ?></p>
                                    <template x-if="rescheduleData.date">
                                        <span x-html="rescheduleData.date + ' <time> ( ' + rescheduleData.start_time + ' - ' + rescheduleData.end_time + ')</time>'"></span>
                                    </template>
                                    <template x-if="!rescheduleData.date">
                                        <span>--</span>
                                    </template>
                                </div>
                            </div>
                            <form class="am-themeform am-session-form" wire:submit="rescheduleSession">
                                <fieldset>
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'form-group-half', 'am-invalid' => $errors->has('rescheduleForm.date')]); ?>">
                                        <label class="am-label"><?php echo e(__('calendar.reschedule_date')); ?></label>
                                        <span class="am-select">
                                            <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['xModel' => 'rescheduleData.date','class' => 'flat-date','placeholder' => ''.e(__('calendar.start_end_date_placeholder')).'','dataModal' => 'true','dataMinDate' => 'today','dataFormat' => 'F d, Y','id' => 'session-date']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-model' => 'rescheduleData.date','class' => 'flat-date','placeholder' => ''.e(__('calendar.start_end_date_placeholder')).'','data-modal' => 'true','data-min-date' => 'today','data-format' => 'F d, Y','id' => 'session-date']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                        </span>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'rescheduleForm.date']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'rescheduleForm.date']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'form-group-half', 'am-invalid' => $errors->has('rescheduleForm.start_time') || $errors->has('rescheduleForm.end_time')]); ?>">
                                        <label class="am-label"><?php echo e(__('calendar.start_end_time')); ?></label>
                                        <div class="am-dropdown" x-data="{
                                                sessionTime: '',
                                                init(){
                                                    if(this.$refs.add_select_start_hour) {
                                                        this.updateValues()
                                                    }
                                                },
                                                updateValues() {
                                                    rescheduleData.start_time = $(this.$refs.select_start_hour).select2('val') + ':'+ $(this.$refs.select_start_min).select2('val')
                                                    rescheduleData.end_time   = $(this.$refs.select_end_hour).select2('val') + ':'+ $(this.$refs.select_end_min).select2('val')
                                                    this.sessionTime = rescheduleData.start_time != ':' && rescheduleData.end_time != ':' ? rescheduleData.start_time + ' to '+ rescheduleData.end_time : ''
                                                    $('.booking-time').dropdown('toggle');
                                                }
                                            }">
                                            <input type="text" x-model="sessionTime" data-bs-auto-close="outside" class="form-control am-input-field" placeholder="<?php echo e(__('calendar.time_placeholder')); ?>" data-bs-toggle="dropdown">
                                            <div class="dropdown-menu booking-time am-timemenu">
                                                <ul class="am-dropdownlist">
                                                    <li>
                                                        <label class="am-label"><?php echo e(__('calendar.start_time')); ?></label>
                                                        <span class="am-select" wire:ignore>
                                                            <select x-ref="select_start_hour" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="<?php echo e(__('calendar.hour_placeholder')); ?>">
                                                                <option label="<?php echo e(__('calendar.hour_placeholder')); ?>"></option>
                                                                <!--[if BLOCK]><![endif]--><?php for($i=0; $i < 24; $i++): ?>
                                                                    <option value="<?php echo e(sprintf("%02d", $i)); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                                                                <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                            </select>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span class="am-select" wire:ignore>
                                                            <select x-ref="select_start_min" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="<?php echo e(__('calendar.minute_placeholder')); ?>">
                                                                <option label="<?php echo e(__('calendar.minute_placeholder')); ?>"></option>
                                                                <!--[if BLOCK]><![endif]--><?php for($i=0; $i < 60; $i++): ?>
                                                                    <option value="<?php echo e(sprintf("%02d", $i)); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                                                                <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                            </select>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <label class="am-label"><?php echo e(__('calendar.end_time')); ?></label>
                                                        <span class="am-select" wire:ignore>
                                                            <select x-ref="select_end_hour" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="<?php echo e(__('calendar.hour_placeholder')); ?>">
                                                                <option label="<?php echo e(__('calendar.hour_placeholder')); ?>"></option>
                                                                <!--[if BLOCK]><![endif]--><?php for($i=0; $i < 24; $i++): ?>
                                                                    <option value="<?php echo e(sprintf("%02d", $i)); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                                                                <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                            </select>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span class="am-select" wire:ignore>
                                                            <select x-ref="select_end_min" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="<?php echo e(__('calendar.minute_placeholder')); ?>">
                                                                <option label="<?php echo e(__('calendar.minute_placeholder')); ?>"></option>
                                                                <!--[if BLOCK]><![endif]--><?php for($i=0; $i < 60; $i++): ?>
                                                                    <option value="<?php echo e(sprintf("%02d", $i)); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                                                                <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                            </select>
                                                        </span>
                                                    </li>
                                                </ul>
                                                <button type="button" x-on:click="updateValues()" class="am-btn"><?php echo e(__('calendar.add_time')); ?></button>
                                            </div>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if($errors->has('rescheduleForm.start_time')): ?>
                                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'rescheduleForm.start_time']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'rescheduleForm.start_time']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                        <?php else: ?>
                                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'rescheduleForm.end_time']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'rescheduleForm.end_time']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'am-invalid' => $errors->has('rescheduleForm.description')]); ?>">
                                        <div class="am-label-wrap">
                                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'session-desc','value' => __('calendar.session_description')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'session-desc','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('calendar.session_description'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                            <!--[if BLOCK]><![endif]--><?php if(setting('_ai_writer_settings.enable_on_resch_sessions_settings') == '1'): ?>
                                                <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal" data-prompt-type="reschedule_sessions" data-parent-model-id="reschedule-popup" data-target-selector="#session-desc" data-target-summernote="true">
                                                    <img src="<?php echo e(asset('images/ai-icon.svg')); ?>" alt="AI">
                                                    <?php echo e(__('general.write_with_ai')); ?>

                                                </button>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <div class="am-custom-editor" wire:ignore>
                                            <textarea id="session-desc" x-model="rescheduleData.description" class="form-control" placeholder="<?php echo e(__('calendar.add_session_description')); ?>"></textarea>
                                            <span class="total-characters">
                                                <div class='tu-input-counter'>
                                                    <span><?php echo e(__('general.char_left')); ?>:</span>
                                                    <b x-text=" <?php echo \Illuminate\Support\Js::from($MAX_SESSION_CHAR)->toHtml() ?> - rescheduleData.description"></b>
                                                    <em>/ <?php echo e($MAX_SESSION_CHAR); ?></em>
                                                </div>
                                            </span>
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'rescheduleForm.description']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'rescheduleForm.description']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'am-invalid' => $errors->has('rescheduleForm.reason')]); ?>">
                                        <div class="am-label-wrap">
                                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'reschedule-reason','value' => __('calendar.reschedule_reason_note')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'reschedule-reason','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('calendar.reschedule_reason_note'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                            <!--[if BLOCK]><![endif]--><?php if(setting('_ai_writer_settings.enable_on_resch_sessions_settings') == '1'): ?>
                                                <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal"  data-prompt-type="reschedule_sessions" data-parent-model-id="reschedule-popup" data-target-selector="#reschedule-reason" data-target-summernote="true">
                                                    <img src="<?php echo e(asset('images/ai-icon.svg')); ?>" alt="AI">
                                                    <?php echo e(__('general.write_with_ai')); ?>

                                                </button>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <div class="am-custom-editor" wire:ignore>
                                            <textarea id="reschedule-reason" x-model="rescheduleData.reason" class="form-control" placeholder="<?php echo e(__('calendar.add_reschedule_reason')); ?>"></textarea>
                                            <span class="total-characters">
                                                <div class='tu-input-counter'>
                                                    <span><?php echo e(__('general.char_left')); ?>:</span>
                                                    <b x-text=" <?php echo \Illuminate\Support\Js::from($MAX_SESSION_CHAR)->toHtml() ?> - rescheduleData.reason"></b>
                                                    <em>/ <?php echo e($MAX_SESSION_CHAR); ?></em>
                                                </div>
                                            </span>
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'rescheduleForm.reason']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'rescheduleForm.reason']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                    <div class="form-group am-form-btn-wrap">
                                        <button type="submit" class="am-btn" wire:loading.class="am-btn_disable"><?php echo e(__('calendar.reschedule_session')); ?></button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- add slot modal  -->
            <div class="modal am-modal am-addslotpopup fade" id="edit-session" wire:ignore.self data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="am-modal-header">
                            <template x-if="sessionData.action == 'edit'">
                                <h2><?php echo e(__('calendar.update_session_seats')); ?></h2>
                            </template>
                            <template x-if="sessionData.action == 'add'">
                                <h2><?php echo e(__('calendar.add_new_slot')); ?></h2>
                            </template>
                            <span class="am-closepopup" data-bs-dismiss="modal" wire:loading.attr="disabled">
                                <i class="am-icon-multiply-01"></i>
                            </span>
                        </div>
                        <div class="am-modal-body">
                            <div class="am-seatsinfocard">
                                <figure class="am-seatsinfocard_img">
                                    <img :src="sessionInfo?.image" alt="sessionInfo?.subject">
                                </figure>
                                <div class="am-seatsinfocard_details" >
                                    <p x-text="sessionInfo?.subject"></p>
                                    <span x-text="sessionInfo?.date"></span>
                                </div>
                            </div>
                            <form class="am-themeform am-session-form" wire:submit="setSession">
                                <fieldset>
                                    <template x-if="sessionData.action == 'add'">
                                        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.start_time') || $errors->has('form.end_time')]); ?>">
                                            <label class="am-label"><?php echo e(__('calendar.start_end_time')); ?></label>
                                            <div class="am-dropdown" x-data="{
                                                    sessionTime: '',
                                                    updateValues() {
                                                        sessionData.start_time = $(this.$refs.select_start_hour).select2('val') + ':'+ $(this.$refs.select_start_min).select2('val')
                                                        sessionData.end_time   = $(this.$refs.select_end_hour).select2('val') + ':'+ $(this.$refs.select_end_min).select2('val')
                                                        this.sessionTime = sessionData.start_time != ':' && sessionData.end_time != ':' ? sessionData.start_time + ' to '+ sessionData.end_time : ''
                                                        $('.booking-time').dropdown('toggle');
                                                    }
                                                }">
                                                <input type="text" x-model="sessionTime" data-bs-auto-close="outside" class="form-control am-input-field" placeholder="<?php echo e(__('calendar.time_placeholder')); ?>" data-bs-toggle="dropdown">
                                                <div class="dropdown-menu booking-time am-timemenu">
                                                    <ul class="am-dropdownlist">
                                                        <li>
                                                            <label class="am-label"><?php echo e(__('calendar.start_time')); ?></label>
                                                            <span class="am-select" wire:ignore>
                                                                <select x-ref="select_start_hour" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent="#edit-session .booking-time" data-searchable="true" data-placeholder="<?php echo e(__('calendar.hour_placeholder')); ?>">
                                                                    <option label="<?php echo e(__('calendar.hour_placeholder')); ?>"></option>
                                                                    <!--[if BLOCK]><![endif]--><?php for($i=0; $i < 24; $i++): ?>
                                                                        <option value="<?php echo e(sprintf("%02d", $i)); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                                                                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                                </select>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <span class="am-select" wire:ignore>
                                                                <select x-ref="select_start_min" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent="#edit-session .booking-time" data-searchable="true" data-placeholder="<?php echo e(__('calendar.minute_placeholder')); ?>">
                                                                    <option label="<?php echo e(__('calendar.minute_placeholder')); ?>"></option>
                                                                    <!--[if BLOCK]><![endif]--><?php for($i=0; $i < 60; $i++): ?>
                                                                        <option value="<?php echo e(sprintf("%02d", $i)); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                                                                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                                </select>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <label class="am-label"><?php echo e(__('calendar.end_time')); ?></label>
                                                            <span class="am-select" wire:ignore>
                                                                <select x-ref="select_end_hour" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent="#edit-session .booking-time" data-searchable="true" data-placeholder="<?php echo e(__('calendar.hour_placeholder')); ?>">
                                                                    <option label="<?php echo e(__('calendar.hour_placeholder')); ?>"></option>
                                                                    <!--[if BLOCK]><![endif]--><?php for($i=0; $i < 24; $i++): ?>
                                                                        <option value="<?php echo e(sprintf("%02d", $i)); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                                                                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                                </select>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <span class="am-select" wire:ignore>
                                                                <select x-ref="select_end_min" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent="#edit-session .booking-time" data-searchable="true" data-placeholder="<?php echo e(__('calendar.minute_placeholder')); ?>">
                                                                    <option label="<?php echo e(__('calendar.minute_placeholder')); ?>"></option>
                                                                    <!--[if BLOCK]><![endif]--><?php for($i=0; $i < 60; $i++): ?>
                                                                        <option value="<?php echo e(sprintf("%02d", $i)); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                                                                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                                </select>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                    <button type="button" x-on:click="updateValues()" class="am-btn"><?php echo e(__('calendar.add_time')); ?></button>
                                                </div>
                                            </div>
                                            <!--[if BLOCK]><![endif]--><?php if($errors->has('form.start_time')): ?>
                                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.start_time']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.start_time']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                            <?php else: ?>
                                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.end_time']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.end_time']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </template>
                                    <!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?>
                                        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.session_fee')]); ?>">
                                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'fee','value' => __('calendar.session_fee')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'fee','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('calendar.session_fee'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                            <div class="am-addfee">
                                                <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['xModel' => 'sessionData.session_fee','placeholder' => ''.e(__('calendar.session_fee_placeholder')).'','type' => 'text','autofocus' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-model' => 'sessionData.session_fee','placeholder' => ''.e(__('calendar.session_fee_placeholder')).'','type' => 'text','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                                <span class="am-addfee_icon"><?php echo e(getCurrencySymbol()); ?></span>
                                            </div>
                                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.session_fee']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.session_fee']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="form-group form-group-half">
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'sessionseats','value' => __('calendar.session_seats')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'sessionseats','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('calendar.session_seats'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                        <div class="am-session-field">
                                            <span class="am-decrement" @click="if(sessionData.spaces > 1) {sessionData.spaces --}">
                                                <i class="am-icon-minus-02"></i>
                                            </span>
                                            <input type="number" x-model="sessionData.spaces" class="form-control am-input-field" placeholder="01">
                                            <span class="am-increment" @click="sessionData.spaces++">
                                                <i class="am-icon-plus-02"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!--[if BLOCK]><![endif]--><?php if(\Nwidart\Modules\Facades\Module::has('upcertify') && \Nwidart\Modules\Facades\Module::isEnabled('upcertify')): ?>
                                        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-certificate-template', 'form-group', 'form-group-half', 'am-invalid' => $errors->has('form.template_id')]); ?>"
                                            x-init="
                                                $nextTick(() => {
                                                    const select = $refs.template_id;
                                                    $(select).on('change', () => {
                                                        sessionData.template_id = $(select).val();
                                                    });
                                                });"
                                            >
                                            <label class="am-label">
                                                <?php echo e(__('calendar.certificate_template')); ?>

                                                <a href="javascript:void(0);" class="am-custom-tooltip">
                                                    <i class="am-icon-exclamation-01"></i>
                                                    <span class="am-tooltip-text">
                                                        <?php echo e(__('calendar.certificate_info')); ?>

                                                    </span>
                                                </a>
                                            </label>
                                            <span class="am-select" wire:ignore>
                                                <select x-ref="template_id" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" x-model="sessionData.template_id" class="am-select2" data-parent=".am-certificate-template" data-searchable="true" data-placeholder="<?php echo e(__('calendar.certificate_template_placeholder')); ?>">
                                                    <option label="<?php echo e(__('calendar.certificate_template_placeholder')); ?>"></option>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($template->id); ?>"><?php echo e($template->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </select>
                                            </span>
                                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.template_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.template_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <!--[if BLOCK]><![endif]--><?php if(isActiveModule('upcertify') && isActiveModule('quiz')): ?>
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-certificate-quiz', 'form-group', 'form-group-half', 'am-invalid' => $errors->has('form.assign_quiz_certificate')]); ?>"
                                            x-init="
                                                $nextTick(() => {
                                                    const select = $refs.assign_quiz_certificate;
                                                    $(select).on('change', () => {
                                                        sessionData.assign_quiz_certificate = $(select).val();
                                                    });
                                                });"
                                            >
                                            <label class="am-label">
                                                <?php echo e(__('calendar.certificate_template')); ?>

                                                <a href="javascript:void(0);" class="am-custom-tooltip">
                                                    <i class="am-icon-exclamation-01"></i>
                                                    <span class="am-tooltip-text">
                                                        <?php echo e(__('calendar.certificate_info')); ?>

                                                    </span>
                                                </a>
                                            </label>
                                            <span class="am-select" wire:ignore>
                                                <select x-ref="assign_quiz_certificate" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" x-model="sessionData.assign_quiz_certificate" class="am-select2" data-parent=".am-certificate-quiz" data-searchable="true" data-placeholder="<?php echo e(__('calendar.certificate_template_placeholder')); ?>">
                                                    <option label="<?php echo e(__('calendar.certificate_template_placeholder')); ?>"></option>
                                                    <option value="any"><?php echo e(__('calendar.any_quizzes')); ?></option>
                                                    <option value="all"><?php echo e(__('calendar.all_quizzes')); ?></option>
                                                    <option value="none"><?php echo e(__('calendar.no_quizzes')); ?></option>
                                                </select>
                                            </span>
                                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.assign_quiz_certificate']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.assign_quiz_certificate']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <!--[if BLOCK]><![endif]--><?php if(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions') && setting('_lernen.subscription_sessions_allowed') == 'tutor'): ?>
                                    <div class="form-group form-group-half">
                                        <div class="am-switchbtn-box">
                                            <div class="am-switchbtn">
                                                <label for="allowed_for_subscriptions" class="cr-label"><?php echo e(__('subscriptions::subscription.allowed_for_subscriptions')); ?></label>
                                                <input type="checkbox" id="allowed_for_subscriptions" :checked="sessionData.allowed_for_subscriptions == 1" class="cr-toggle" x-model="sessionData.allowed_for_subscriptions" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'am-invalid' => $errors->has('form.description')]); ?>">
                                        <div class="am-label-wrap">
                                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'edit-session-desc','value' => __('calendar.session_description')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'edit-session-desc','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('calendar.session_description'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                            <!--[if BLOCK]><![endif]--><?php if(setting('_ai_writer_settings.enable_on_slots_settings') == '1'): ?>
                                                <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal" data-prompt-type="slots" data-parent-model-id="edit-session" data-target-selector="#edit-session-desc" data-target-summernote="true">
                                                    <img src="<?php echo e(asset('images/ai-icon.svg')); ?>" alt="AI">
                                                    <?php echo e(__('general.write_with_ai')); ?>

                                                </button>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <div class="am-custom-editor" wire:ignore>
                                            <textarea id="edit-session-desc" x-model="sessionData.description" class="form-control" placeholder="<?php echo e(__('calendar.add_session_description')); ?>"></textarea>
                                            <span class="total-characters">
                                                <div class='tu-input-counter'>
                                                    <span><?php echo e(__('general.char_left')); ?>:</span>
                                                    <b> <?php echo $MAX_SESSION_CHAR - Str::length($sessionData->description ?? ''); ?> </b>
                                                    <em>/ <?php echo e($MAX_SESSION_CHAR); ?></em>
                                                </div>
                                            </span>
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.description']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.description']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                    </div>
                                    <template x-if="sessionData.action == 'edit' && totalBooking > 0">
                                        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'am-invalid' => $errors->has('form.meeting_link')]); ?>">
                                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'fee','value' => __('calendar.meeting_link')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'fee','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('calendar.meeting_link'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                            <div class="am-addfee">
                                                <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['xModel' => 'sessionData.meeting_link','placeholder' => ''.e(__('calendar.meeting_link')).'','type' => 'text','autofocus' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-model' => 'sessionData.meeting_link','placeholder' => ''.e(__('calendar.meeting_link')).'','type' => 'text','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                                <span class="am-addfee_icon"><i class="am-icon-external-link-02"></i></span>
                                            </div>
                                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.meeting_link']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.meeting_link']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                        </div>
                                    </template>
                                    <div class="form-group am-form-btn-wrap">
                                        <button type="submit" class="am-btn" wire:loading.class="am-btn_disable"><?php echo e(__('general.save_update')); ?></button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/css/flatpicker.css',
        'public/summernote/summernote-lite.min.css'
    ]); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('summernote/summernote-lite.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/flatpicker.js')); ?>"></script>
<?php $__env->stopPush(); ?>
    <?php
        $__scriptKey = '48255717-0';
        ob_start();
    ?>
    <script>
        $('#session-desc').on('summernote.change', function(we, contents, $editable) {
            $wire.set("form.description", contents, false);
        });

        $wire.on('toggleModel', event => {
            clearFormErrors('form.am-session-form');
            if (event.id == 'edit-session') {
            } else if (event.id == 'reschedule-popup') {
                setTimeout(() => {
                    initializeDatePicker();
                }, 100);
            }
        })
        document.addEventListener('loadPageJs', (event)=>{
            setTimeout(() => {
                initializeDatePicker()
            }, 100);
        })
    </script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/tutor/manage-sessions/session-detail.blade.php ENDPATH**/ ?>