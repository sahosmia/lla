<div class="am-profile-setting" wire:init="loadData">
    @include('livewire.pages.tutor.manage-sessions.tabs')
    @if($isLoading)
        <div class="am-section-load">
            <p>{{ __('general.loading') }}</p>
        </div>
    @else
        <div class="am-section-load" wire:loading.flex wire:target="deleteSlot,loadData">
            <p>{{ __('general.loading') }}</p>
        </div>
        <div class="am-upcomming-bookings-wrapper" x-data="{
                sessionInfo: {},
                sessionData: @entangle('form'),
                rescheduleData: @entangle('rescheduleForm'),
                slotId: @entangle('editableSlotId'),
                userSubjectGroupId: @entangle('userSubjectGroupId'),
                totalBooking: 0,
                }">
            <div class="am-calendar-task">
                <i class="am-icon-chevron-left"></i>
                <a href="{{ route('tutor.bookings.manage-sessions') }}" wire:navigate.remove>
                    {{ __('calendar.back_to_calendar') }}
                </a>
            </div>
            <div class="am-calendar-wrapper">
                <a href="{{ route('tutor.bookings.session-detail', ['date' => parseToUserTz($date->copy()->subDay())->toDateString()]) }}" wire:navigate.remove wire:loading.attr="disabled">
                    <i class="am-icon-chevron-left"></i>
                </a>
                <div class="am-calendar-schedule">
                    <span>
                        {{ parseToUserTz($date->copy())->format('l') }}
                    </span>
                    <h6>
                        {{ parseToUserTz($date->copy())->format('F d, Y') }}
                        <i class="am-icon-calender-minus"></i>
                    </h6>
                </div>
                <a href="{{ route('tutor.bookings.session-detail', ['date' => parseToUserTz($date->copy()->addDay())->toDateString()]) }}" wire:navigate.remove wire:loading.attr="disabled">
                    <i class="am-icon-chevron-right"></i>
                </a>
            </div>
            @empty($sessionDetail)
                <x-no-record :image="asset('images/session.png')" :title="__('calendar.no_sessions')" :description="__('calendar.no_session_desc')" />
            @endif
            @if(!empty($sessionDetail) && count($sessionDetail) > 1)
                <ul class="am-session-slots am-schooling-tabs" role="tablist">
                    @foreach ($sessionDetail as $subjGroup => $detail)
                        <li>
                            <button @class(['active'=>$loop->first]) id="{{ \Str::slug($subjGroup) }}-btn" data-bs-toggle="tab" data-bs-target="#{{ \Str::slug($subjGroup) }}Tab" aria-selected="true">{{ $subjGroup }}</button>
                        </li>
                    @endforeach
                </ul>
            @endif
            @if(!empty($sessionDetail))
                @foreach ($sessionDetail as $subjGroup => $sbjGroups)
                    <div class="tab-content">
                        <div @class(['tab-pane','fade','show' => $loop->first, 'active' => $loop->first]) id="{{ \Str::slug($subjGroup) }}Tab">
                            <div class="am-calendar-content am-timecoursewrap">
                                <div class="am-subjects-content">
                                    <h5>
                                        @if(count($sessionDetail) > 1)
                                            {{ __('calendar.all_subjects') }}
                                        @else
                                            {{ __('calendar.subjects_of_group',[ 'group' => array_key_first($sessionDetail) ]) }}
                                        @endif
                                    </h5>
                                    <ul class="am-subjects-list" id="nav-tab" role="tablist">
                                        @foreach ($sbjGroups as $subject)
                                            @php
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

                                            @endphp
                                            <li @class(['active' => $loop->first]) id="{{ \Str::slug($subject['info']['subject']) . '-' . \Str::slug($subjGroup) }}-btn" data-bs-toggle="tab" data-bs-target="#{{ \Str::slug($subject['info']['subject']) . '-' . \Str::slug($subjGroup) }}-tab" role="tab" aria-controls="{{ \Str::slug($subject['info']['subject']) . '-' . \Str::slug($subjGroup) }}-tab" aria-selected="false">
                                                <img src="{{ $sessionInfo['image'] }}" alt="{{ $subject['info']['subject'] }}" />
                                                <div class="am-subjects-description">
                                                    <h6>
                                                        {{ $subject['info']['subject'] }}
                                                    </h6>
                                                    <span>
                                                        {{ __('calendar.no_slots_left', ['count' => $slotsLeft]) }}
                                                    </span>
                                                </div>
                                                <span @click="sessionInfo = @js($sessionInfo);
                                                        userSubjectGroupId      = @js($subject['info']['user_subject_id']);
                                                        sessionData.action      = 'add';
                                                        sessionData.session_fee = @js($subject['info']['hour_rate']);
                                                        sessionData.allowed_for_subscriptions = 0;
                                                        sessionData.template_id = '';
                                                        sessionData.assign_quiz_certificate = '';

                                                        $nextTick(() => {
                                                            $wire.dispatch('toggleModel' ,{ id: 'edit-session', action:'show'});
                                                            $wire.dispatch('initSelect2', {target:'.am-select2'});
                                                            $wire.dispatch('initSummerNote', {target: '#edit-session-desc', wiremodel: 'form.description', conetent: '', componentId: @this});
                                                        })
                                                    ">
                                                    <i class="am-icon-plus-02"></i>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="am-session-table am-payouthistory tab-content">
                                    @foreach ($sbjGroups as $subject)
                                    <div @class(['am-sessionstable','tab-pane','fade','show' => $loop->first, 'active' => $loop->first]) id="{{ \Str::slug($subject['info']['subject']) . '-' . \Str::slug($subjGroup) }}-tab" role="tabpanel" aria-labelledby="{{ \Str::slug($subject['info']['subject']) . '-' . \Str::slug($subjGroup) }}-btn"  tabindex="0">
                                        <table class="am-table">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('calendar.time') }}</th>
                                                    <th>{{ __('calendar.type') }}</th>
                                                    <th>{{ __('calendar.total_enrollment') }}</th>
                                                    <th>@if(isPaidSystem()){{ __('calendar.session_fee') }}@endif</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subject['slots'] as $slot)
                                                <tr @class(['am-session-completed' => parseToUTC($slot->start_time)->isPast()])>
                                                    <td data-label="Time">
                                                        @if(setting('_lernen.time_format') == '12')
                                                            {{ parseToUserTz($slot->start_time)->format('h:i a') }} -
                                                            {{ parseToUserTz($slot->end_time)->format('h:i a') }}
                                                        @else
                                                            {{ parseToUserTz($slot->start_time)->format('H:i') }} -
                                                            {{ parseToUserTz($slot->end_time)->format('H:i') }}
                                                        @endif
                                                    </td>
                                                    <td data-label="Type">
                                                        <span @class(['am-selection-tag', 'am-tag-puple' => $slot->spaces == 1])>
                                                            {{ $slot->spaces > 1 ? __('calendar.group') : __('calendar.one') }}
                                                        </span>
                                                    </td>
                                                    <td data-label="Total Enrolment">
                                                        @if ($slot->total_booked > 0 && !empty($slot->students))
                                                            <div class="am-students-profile">
                                                                <ul>
                                                                    @foreach ($slot->students as $student)
                                                                        <li>
                                                                            @if (!empty($student->image) && Storage::disk(getStorageDisk())->exists($student->image))
                                                                                <img src="{{ resizedImage($student->image, 40, 40) }}" alt="profile-img">
                                                                            @else
                                                                                <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 40, 40) }}" alt="profile-img">
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <span>{{ __('calendar.booked_students', ['count' => $slot->bookings_count]) }}</span>
                                                            </div>
                                                        @else
                                                            --
                                                        @endif
                                                    </td>
                                                    <td data-label="Session Fare">
                                                        <div class="am-session-fare">
                                                            @if (isPaidSystem())
                                                                {{ formatAmount($slot->session_fee ?? 0) }}
                                                            @endif
                                                            @if(\Carbon\Carbon::parse($slot->start_time)->isFuture())
                                                                <div class="am-itemdropdown">
                                                                    <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="am-icon-ellipsis-horizontal-02"></i>
                                                                    </a>
                                                                    <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                        <li>
                                                                            @php
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

                                                                            @endphp
                                                                            <a href="#" @click=" sessionInfo = @js($sessionInfo);
                                                                                                slotId                    = @js($slot->id);
                                                                                                sessionData.spaces        = @js($slot->spaces);
                                                                                                sessionData.session_fee   = @js($slot->session_fee);
                                                                                                sessionData.description   = @js($slot->description);
                                                                                                sessionData.meeting_link  = @js($slot->meta_data['meeting_link'] ?? '');
                                                                                                totalBooking              = @js($slot->total_booked);
                                                                                                sessionData.action        = 'edit';
                                                                                                sessionData.allowed_for_subscriptions = @js($slot->meta_data['allowed_for_subscriptions'] ?? 0);
                                                                                                sessionData.template_id = @js($slot->meta_data['template_id'] ?? '');
                                                                                                sessionData.assign_quiz_certificate = @js($slot->meta_data['assign_quiz_certificate'] ?? '');
                                                                                                $nextTick(() => {
                                                                                                    $wire.dispatch('toggleModel' ,{ id: 'edit-session', action:'show', description:  sessionData.description});
                                                                                                    $wire.dispatch('initSummerNote', {target: '#edit-session-desc', wiremodel: 'form.description', conetent: @js($slot->description), componentId: @this});
                                                                                                })
                                                                                                    $nextTick(() => {
                                                                                                    $wire.dispatch('initSelect2', {target:'.am-select2'});
                                                                                                })
                                                                                            ">
                                                                                <i class="am-icon-pencil-02"></i>
                                                                                {{ __('general.edit') }}
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a x-data="{ linkToCopy: '{{ route('session-detail', ['id' => encrypt($slot?->id)]) }}' }" 
                                                                                @click="navigator.clipboard.writeText(linkToCopy)">
                                                                                <i class="am-icon-copy-01"></i>
                                                                                {{ __('general.copy_link') }}
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" wire:key="{{ time() }}"
                                                                                class="am-del-btn"
                                                                                @if($slot->total_booked > 0)
                                                                                    @click=" totalBooking               = @js($slot->total_booked);
                                                                                            sessionInfo                 = @js($sessionInfo);
                                                                                            slotId                      = @js($slot->id);
                                                                                            rescheduleData.description  = @js($slot->description);
                                                                                            userSubjectGroupId          = @js($subject['info']['user_subject_id']);
                                                                                            $nextTick(() => {
                                                                                                $wire.dispatch('toggleModel', { id : 'attention-popup', action : 'show' });
                                                                                                $wire.dispatch('initSummerNote', {target: '#session-desc', wiremodel: 'rescheduleForm.description', conetent: @js($slot->description), componentId: @this});
                                                                                            })
                                                                                    "
                                                                                @else
                                                                                    @click="$wire.dispatch('showConfirm', { id : @js($slot->id), action : 'delete-slot' })"
                                                                                @endif
                                                                                >
                                                                                <i class="am-icon-trash-02"></i>
                                                                                {{ __('general.delete') }}
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @else 
                                                                <span> {{ __('calendar.ended') }} </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
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
                                <h3>{{ __('calendar.pay_attention') }} <strong x-text="totalBooking + ' {{ __('calendar.enrollments') }}'"></strong></h3>
                                <p>{{ __('calendar.reschedule_msg') }}</p>
                                <span>
                                    <i class="am-icon-exclamation-01"></i>
                                    {{ __('calendar.reschedule_warning') }}</span>
                            </div>
                            <div class="am-deletepopup_btns">
                                <a href="#" class="am-btn am-btn-del" data-bs-dismiss="modal" @click="
                                    $wire.dispatch('toggleModel' ,{ id: 'reschedule-popup', action:'show'});
                                    $wire.dispatch('initSelect2', {target:'.am-select2'});
                                    $wire.dispatch('initSummerNote', {target: '#reschedule-reason', wiremodel: 'rescheduleForm.reason', conetent: '', componentId: @this});
                                    ">{{ __('calendar.reschedule_other_day') }}</a>
                                <a href="#" class="am-btn am-btnsmall" data-bs-dismiss="modal">{{ __('calendar.change_of_mind') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div wire:ignore.self class="modal am-modal am-reschedulepopup fade" id="reschedule-popup" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="am-modal-header">
                            <h2>{{ __('calendar.reschedule_title') }}</h2>
                            <span class="am-closepopup" data-bs-dismiss="modal" wire:loading.attr="disabled">
                                <i class="am-icon-multiply-01"></i>
                            </span>
                        </div>
                        <div class="am-modal-body">
                            <div class="am-reschedule">
                                <div class="am-reschedule_time">
                                    <p>{{ __('calendar.current_date_time') }}</p>
                                    <span x-html="sessionInfo.date + ' <time> ( ' + sessionInfo.start_time + ' - ' + sessionInfo.end_time + ')</time>'"></span>
                                </div>
                                <div class="am-reschedule_icon">
                                    <i class="am-icon-chevron-right"></i>
                                </div>
                                <div class="am-reschedule_time">
                                    <p>{{ __('calendar.reschedule_date_time') }}</p>
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
                                    <div @class(['form-group', 'form-group-half', 'am-invalid' => $errors->has('rescheduleForm.date')])>
                                        <label class="am-label">{{ __('calendar.reschedule_date') }}</label>
                                        <span class="am-select">
                                            <x-text-input x-model="rescheduleData.date" class="flat-date" placeholder="{{ __('calendar.start_end_date_placeholder') }}" data-modal="true" data-min-date="today" data-format="F d, Y" id="session-date" />
                                        </span>
                                        <x-input-error field_name="rescheduleForm.date" />
                                    </div>
                                    <div @class(['form-group', 'form-group-half', 'am-invalid' => $errors->has('rescheduleForm.start_time') || $errors->has('rescheduleForm.end_time')])>
                                        <label class="am-label">{{ __('calendar.start_end_time') }}</label>
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
                                            <input type="text" x-model="sessionTime" data-bs-auto-close="outside" class="form-control am-input-field" placeholder="{{ __('calendar.time_placeholder') }}" data-bs-toggle="dropdown">
                                            <div class="dropdown-menu booking-time am-timemenu">
                                                <ul class="am-dropdownlist">
                                                    <li>
                                                        <label class="am-label">{{ __('calendar.start_time') }}</label>
                                                        <span class="am-select" wire:ignore>
                                                            <select x-ref="select_start_hour" data-componentid="@this" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="{{ __('calendar.hour_placeholder') }}">
                                                                <option label="{{ __('calendar.hour_placeholder') }}"></option>
                                                                @for ($i=0; $i < 24; $i++)
                                                                    <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                                @endfor
                                                            </select>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span class="am-select" wire:ignore>
                                                            <select x-ref="select_start_min" data-componentid="@this" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="{{ __('calendar.minute_placeholder') }}">
                                                                <option label="{{ __('calendar.minute_placeholder') }}"></option>
                                                                @for ($i=0; $i < 60; $i++)
                                                                    <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                                @endfor
                                                            </select>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <label class="am-label">{{ __('calendar.end_time') }}</label>
                                                        <span class="am-select" wire:ignore>
                                                            <select x-ref="select_end_hour" data-componentid="@this" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="{{ __('calendar.hour_placeholder') }}">
                                                                <option label="{{ __('calendar.hour_placeholder') }}"></option>
                                                                @for ($i=0; $i < 24; $i++)
                                                                    <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                                @endfor
                                                            </select>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span class="am-select" wire:ignore>
                                                            <select x-ref="select_end_min" data-componentid="@this" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="{{ __('calendar.minute_placeholder') }}">
                                                                <option label="{{ __('calendar.minute_placeholder') }}"></option>
                                                                @for ($i=0; $i < 60; $i++)
                                                                    <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                                @endfor
                                                            </select>
                                                        </span>
                                                    </li>
                                                </ul>
                                                <button type="button" x-on:click="updateValues()" class="am-btn">{{ __('calendar.add_time') }}</button>
                                            </div>
                                        </div>
                                        @if($errors->has('rescheduleForm.start_time'))
                                            <x-input-error field_name="rescheduleForm.start_time" />
                                        @else
                                            <x-input-error field_name="rescheduleForm.end_time" />
                                        @endif
                                    </div>
                                    <div @class(['form-group', 'am-invalid' => $errors->has('rescheduleForm.description')])>
                                        <div class="am-label-wrap">
                                            <x-input-label for="session-desc" :value="__('calendar.session_description')" />
                                            @if(setting('_ai_writer_settings.enable_on_resch_sessions_settings') == '1')
                                                <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal" data-prompt-type="reschedule_sessions" data-parent-model-id="reschedule-popup" data-target-selector="#session-desc" data-target-summernote="true">
                                                    <img src="{{ asset('images/ai-icon.svg') }}" alt="AI">
                                                    {{ __('general.write_with_ai') }}
                                                </button>
                                            @endif
                                        </div>
                                        <div class="am-custom-editor" wire:ignore>
                                            <textarea id="session-desc" x-model="rescheduleData.description" class="form-control" placeholder="{{ __('calendar.add_session_description') }}"></textarea>
                                            <span class="total-characters">
                                                <div class='tu-input-counter'>
                                                    <span>{{ __('general.char_left') }}:</span>
                                                    <b x-text=" @js($MAX_SESSION_CHAR) - rescheduleData.description"></b>
                                                    <em>/ {{ $MAX_SESSION_CHAR }}</em>
                                                </div>
                                            </span>
                                        </div>
                                        <x-input-error field_name="rescheduleForm.description" />
                                    </div>
                                    <div @class(['form-group', 'am-invalid' => $errors->has('rescheduleForm.reason')])>
                                        <div class="am-label-wrap">
                                            <x-input-label for="reschedule-reason" :value="__('calendar.reschedule_reason_note')" />
                                            @if(setting('_ai_writer_settings.enable_on_resch_sessions_settings') == '1')
                                                <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal"  data-prompt-type="reschedule_sessions" data-parent-model-id="reschedule-popup" data-target-selector="#reschedule-reason" data-target-summernote="true">
                                                    <img src="{{ asset('images/ai-icon.svg') }}" alt="AI">
                                                    {{ __('general.write_with_ai') }}
                                                </button>
                                            @endif
                                        </div>
                                        <div class="am-custom-editor" wire:ignore>
                                            <textarea id="reschedule-reason" x-model="rescheduleData.reason" class="form-control" placeholder="{{ __('calendar.add_reschedule_reason') }}"></textarea>
                                            <span class="total-characters">
                                                <div class='tu-input-counter'>
                                                    <span>{{ __('general.char_left') }}:</span>
                                                    <b x-text=" @js($MAX_SESSION_CHAR) - rescheduleData.reason"></b>
                                                    <em>/ {{ $MAX_SESSION_CHAR }}</em>
                                                </div>
                                            </span>
                                        </div>
                                        <x-input-error field_name="rescheduleForm.reason" />
                                    </div>
                                    <div class="form-group am-form-btn-wrap">
                                        <button type="submit" class="am-btn" wire:loading.class="am-btn_disable">{{ __('calendar.reschedule_session') }}</button>
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
                                <h2>{{ __('calendar.update_session_seats') }}</h2>
                            </template>
                            <template x-if="sessionData.action == 'add'">
                                <h2>{{ __('calendar.add_new_slot') }}</h2>
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
                                        <div @class(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.start_time') || $errors->has('form.end_time')])>
                                            <label class="am-label">{{ __('calendar.start_end_time') }}</label>
                                            <div class="am-dropdown" x-data="{
                                                    sessionTime: '',
                                                    updateValues() {
                                                        sessionData.start_time = $(this.$refs.select_start_hour).select2('val') + ':'+ $(this.$refs.select_start_min).select2('val')
                                                        sessionData.end_time   = $(this.$refs.select_end_hour).select2('val') + ':'+ $(this.$refs.select_end_min).select2('val')
                                                        this.sessionTime = sessionData.start_time != ':' && sessionData.end_time != ':' ? sessionData.start_time + ' to '+ sessionData.end_time : ''
                                                        $('.booking-time').dropdown('toggle');
                                                    }
                                                }">
                                                <input type="text" x-model="sessionTime" data-bs-auto-close="outside" class="form-control am-input-field" placeholder="{{ __('calendar.time_placeholder') }}" data-bs-toggle="dropdown">
                                                <div class="dropdown-menu booking-time am-timemenu">
                                                    <ul class="am-dropdownlist">
                                                        <li>
                                                            <label class="am-label">{{ __('calendar.start_time') }}</label>
                                                            <span class="am-select" wire:ignore>
                                                                <select x-ref="select_start_hour" data-componentid="@this" class="am-select2" data-parent="#edit-session .booking-time" data-searchable="true" data-placeholder="{{ __('calendar.hour_placeholder') }}">
                                                                    <option label="{{ __('calendar.hour_placeholder') }}"></option>
                                                                    @for ($i=0; $i < 24; $i++)
                                                                        <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                                    @endfor
                                                                </select>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <span class="am-select" wire:ignore>
                                                                <select x-ref="select_start_min" data-componentid="@this" class="am-select2" data-parent="#edit-session .booking-time" data-searchable="true" data-placeholder="{{ __('calendar.minute_placeholder') }}">
                                                                    <option label="{{ __('calendar.minute_placeholder') }}"></option>
                                                                    @for ($i=0; $i < 60; $i++)
                                                                        <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                                    @endfor
                                                                </select>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <label class="am-label">{{ __('calendar.end_time') }}</label>
                                                            <span class="am-select" wire:ignore>
                                                                <select x-ref="select_end_hour" data-componentid="@this" class="am-select2" data-parent="#edit-session .booking-time" data-searchable="true" data-placeholder="{{ __('calendar.hour_placeholder') }}">
                                                                    <option label="{{ __('calendar.hour_placeholder') }}"></option>
                                                                    @for ($i=0; $i < 24; $i++)
                                                                        <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                                    @endfor
                                                                </select>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <span class="am-select" wire:ignore>
                                                                <select x-ref="select_end_min" data-componentid="@this" class="am-select2" data-parent="#edit-session .booking-time" data-searchable="true" data-placeholder="{{ __('calendar.minute_placeholder') }}">
                                                                    <option label="{{ __('calendar.minute_placeholder') }}"></option>
                                                                    @for ($i=0; $i < 60; $i++)
                                                                        <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                                    @endfor
                                                                </select>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                    <button type="button" x-on:click="updateValues()" class="am-btn">{{ __('calendar.add_time') }}</button>
                                                </div>
                                            </div>
                                            @if($errors->has('form.start_time'))
                                                <x-input-error field_name="form.start_time" />
                                            @else
                                                <x-input-error field_name="form.end_time" />
                                            @endif
                                        </div>
                                    </template>
                                    @if(isPaidSystem())
                                        <div @class(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.session_fee')])>
                                            <x-input-label for="fee" :value="__('calendar.session_fee')" />
                                            <div class="am-addfee">
                                                <x-text-input x-model="sessionData.session_fee" placeholder="{{ __('calendar.session_fee_placeholder') }}" type="text" autofocus />
                                                <span class="am-addfee_icon">{{ getCurrencySymbol() }}</span>
                                            </div>
                                            <x-input-error field_name="form.session_fee" />
                                        </div>
                                    @endif
                                    <div class="form-group form-group-half">
                                        <x-input-label for="sessionseats" :value="__('calendar.session_seats')" />
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

                                    @if(\Nwidart\Modules\Facades\Module::has('upcertify') && \Nwidart\Modules\Facades\Module::isEnabled('upcertify'))
                                        <div @class(['am-certificate-template', 'form-group', 'form-group-half', 'am-invalid' => $errors->has('form.template_id')])
                                            x-init="
                                                $nextTick(() => {
                                                    const select = $refs.template_id;
                                                    $(select).on('change', () => {
                                                        sessionData.template_id = $(select).val();
                                                    });
                                                });"
                                            >
                                            <label class="am-label">
                                                {{ __('calendar.certificate_template') }}
                                                <a href="javascript:void(0);" class="am-custom-tooltip">
                                                    <i class="am-icon-exclamation-01"></i>
                                                    <span class="am-tooltip-text">
                                                        {{ __('calendar.certificate_info') }}
                                                    </span>
                                                </a>
                                            </label>
                                            <span class="am-select" wire:ignore>
                                                <select x-ref="template_id" data-componentid="@this" x-model="sessionData.template_id" class="am-select2" data-parent=".am-certificate-template" data-searchable="true" data-placeholder="{{ __('calendar.certificate_template_placeholder') }}">
                                                    <option label="{{ __('calendar.certificate_template_placeholder') }}"></option>
                                                    @foreach ($templates as $template)
                                                        <option value="{{ $template->id }}">{{ $template->title }}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                            <x-input-error field_name="form.template_id" />
                                        </div>
                                    @endif

                                    @if(isActiveModule('upcertify') && isActiveModule('quiz'))
                                    <div @class(['am-certificate-quiz', 'form-group', 'form-group-half', 'am-invalid' => $errors->has('form.assign_quiz_certificate')])
                                            x-init="
                                                $nextTick(() => {
                                                    const select = $refs.assign_quiz_certificate;
                                                    $(select).on('change', () => {
                                                        sessionData.assign_quiz_certificate = $(select).val();
                                                    });
                                                });"
                                            >
                                            <label class="am-label">
                                                {{ __('calendar.certificate_template') }}
                                                <a href="javascript:void(0);" class="am-custom-tooltip">
                                                    <i class="am-icon-exclamation-01"></i>
                                                    <span class="am-tooltip-text">
                                                        {{ __('calendar.certificate_info') }}
                                                    </span>
                                                </a>
                                            </label>
                                            <span class="am-select" wire:ignore>
                                                <select x-ref="assign_quiz_certificate" data-componentid="@this" x-model="sessionData.assign_quiz_certificate" class="am-select2" data-parent=".am-certificate-quiz" data-searchable="true" data-placeholder="{{ __('calendar.certificate_template_placeholder') }}">
                                                    <option label="{{ __('calendar.certificate_template_placeholder') }}"></option>
                                                    <option value="any">{{ __('calendar.any_quizzes') }}</option>
                                                    <option value="all">{{ __('calendar.all_quizzes') }}</option>
                                                    <option value="none">{{ __('calendar.no_quizzes') }}</option>
                                                </select>
                                            </span>
                                            <x-input-error field_name="form.assign_quiz_certificate" />
                                        </div>
                                    @endif

                                    @if(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions') && setting('_lernen.subscription_sessions_allowed') == 'tutor')
                                    <div class="form-group form-group-half">
                                        <div class="am-switchbtn-box">
                                            <div class="am-switchbtn">
                                                <label for="allowed_for_subscriptions" class="cr-label">{{ __('subscriptions::subscription.allowed_for_subscriptions') }}</label>
                                                <input type="checkbox" id="allowed_for_subscriptions" :checked="sessionData.allowed_for_subscriptions == 1" class="cr-toggle" x-model="sessionData.allowed_for_subscriptions" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div @class(['form-group', 'am-invalid' => $errors->has('form.description')])>
                                        <div class="am-label-wrap">
                                            <x-input-label for="edit-session-desc" :value="__('calendar.session_description')" />
                                            @if(setting('_ai_writer_settings.enable_on_slots_settings') == '1')
                                                <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal" data-prompt-type="slots" data-parent-model-id="edit-session" data-target-selector="#edit-session-desc" data-target-summernote="true">
                                                    <img src="{{ asset('images/ai-icon.svg') }}" alt="AI">
                                                    {{ __('general.write_with_ai') }}
                                                </button>
                                            @endif
                                        </div>
                                        <div class="am-custom-editor" wire:ignore>
                                            <textarea id="edit-session-desc" x-model="sessionData.description" class="form-control" placeholder="{{ __('calendar.add_session_description') }}"></textarea>
                                            <span class="total-characters">
                                                <div class='tu-input-counter'>
                                                    <span>{{ __('general.char_left') }}:</span>
                                                    <b> {!! $MAX_SESSION_CHAR - Str::length($sessionData->description ?? '') !!} </b>
                                                    <em>/ {{ $MAX_SESSION_CHAR }}</em>
                                                </div>
                                            </span>
                                        </div>
                                        <x-input-error field_name="form.description" />
                                    </div>
                                    <template x-if="sessionData.action == 'edit' && totalBooking > 0">
                                        <div @class(['form-group', 'am-invalid' => $errors->has('form.meeting_link')])>
                                            <x-input-label for="fee" :value="__('calendar.meeting_link')" />
                                            <div class="am-addfee">
                                                <x-text-input x-model="sessionData.meeting_link" placeholder="{{ __('calendar.meeting_link') }}" type="text" autofocus />
                                                <span class="am-addfee_icon"><i class="am-icon-external-link-02"></i></span>
                                            </div>
                                            <x-input-error field_name="form.meeting_link" />
                                        </div>
                                    </template>
                                    <div class="form-group am-form-btn-wrap">
                                        <button type="submit" class="am-btn" wire:loading.class="am-btn_disable">{{ __('general.save_update') }}</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@push('styles')
    @vite([
        'public/css/flatpicker.css',
        'public/summernote/summernote-lite.min.css'
    ])
@endpush
@push('scripts')
    <script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>
    <script defer src="{{ asset('js/flatpicker.js') }}"></script>
@endpush
@script()
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
@endscript
