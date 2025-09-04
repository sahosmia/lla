<div class="am-profile-setting" wire:init="loadData" wire:key="@this">
    @slot('title')
        {{ __('subject.subject_title') }}
    @endslot
    @include('livewire.pages.tutor.manage-sessions.tabs')
    <div x-data="{search:'', sessionData: @entangle('form')}" class="am-userperinfo">
        @if($isLoading)
            @include('skeletons.manage-subject')
        @else
            @if($subjectGroups->isNotEmpty())
                <div class="am-title_wrap">
                    <div class="am-title">
                        <h2>{{ __('subject.subject_title') }}</h2>
                        <p>{{ __('subject.subject_title_desc') }}</p>
                    </div>
                    <button class="am-btn am-btnsmall" @click="search = ''; $nextTick(() => $wire.call('addNewSubjectGroup'))" wire:target="addNewSubjectGroup">
                        {{ __('general.add_new') }}
                        <i class="am-icon-plus-02"></i>
                    </button>
                </div>
                <div id="subjectList" wire:sortable="updateSubjectGroupOrder" wire:sortable-group="updateSubjectOrder" class="am-subjectlist">
                    @foreach ($subjectGroups as $index => $group)
                        <div class="am-subject" wire:sortable.item="{{ $group?->id }}" wire:key="subject-group-{{ $group?->id }}">
                            <div class="am-subject-heading">
                                <div class="am-sotingitem" wire:sortable.handle>
                                    <i class="am-icon-youtube-1"></i>
                                </div>
                                <div wire:ignore.self @class(['am-subject-title', 'collapsed' => $index != 0]) id="heading-{{ $group?->id }}" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $group?->id }}" aria-expanded="{{ $index == 0 ? 'true': 'false' }}">
                                    <h3>{{  $group->group->name }}</h3>
                                    <span class="am-subject-title-icon">
                                        <i class="am-icon-minus-02 am-subject-title-icon-open"></i>
                                        <i class="am-icon-plus-02 am-subject-title-icon-close"></i>
                                    </span>
                                </div>
                                <div class="am-itemdropdown">
                                    <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="am-icon-ellipsis-horizontal-02"></i>
                                    </a>
                                    <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li>
                                            <a href="javascript:void(0);" @click="search = ''; $nextTick(() => $wire.call('addNewSubjectGroup'))">
                                                <i class="am-icon-pencil-02"></i>
                                                {{ __('general.edit') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="am-del-btn" @click="$wire.dispatch('showConfirm', { groupId: {{ $group?->id }}, action : 'delete-user-subject-group' })">
                                                <i class="am-icon-trash-02"></i>
                                                {{ __('general.delete') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div wire:ignore.self id="collapse-{{ $group?->id }}" @class(['collapse', 'show' => $index == 0]) data-bs-parent="#subjectList">
                                <div class="am-subject-body">
                                    @if($group?->subjects->count() > 0)
                                        <ul class="am-subject-list" wire:sortable-group.item-group="{{ $group?->id }}">
                                            @foreach ($group?->subjects as $subject)
                                                <li wire:key="subject-{{ $subject?->pivot->id }}" wire:sortable-group.item="{{ $subject?->pivot->id }}">
                                                    <div class="am-sotingitemtwo" wire:sortable-group.handle>
                                                        <i class="am-icon-youtube-1"></i>
                                                    </div>
                                                    <div class="am-subject-list_content">
                                                        <figure>
                                                            @if(!empty($subject?->pivot?->image) && Storage::disk(getStorageDisk())->exists($subject?->pivot?->image))
                                                                <img src="{{ resizedImage($subject?->pivot?->image, 40, 40) }}" alt="{{ $subject?->name }}">
                                                            @else
                                                                <img src="{{ resizedImage('placeholder.png', 40, 40) }}" alt="{{ $subject?->name }}">
                                                            @endif
                                                        </figure>
                                                        <div class="am-subject-info">
                                                            <div class="am-subject-info_content">
                                                                <div class="am-subject-detail">
                                                                    <div class="am-subject_content">
                                                                        <div class="am-subject_title">
                                                                            <h3>{!! $subject?->name !!}</h3>
                                                                            @if (isPaidSystem())
                                                                                <span>{{ __('subject.hourly_rate') }} <em>{{ formatAmount($subject?->pivot?->hour_rate ?? 0) }} </em></span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="am-itemdropdown">
                                                                            <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <i class="am-icon-ellipsis-horizontal-02"></i>
                                                                            </a>
                                                                            <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                <li>
                                                                                    <a href="javascript:void(0);" @click="
                                                                                    sessionData.group_id    = @js($group?->id);
                                                                                    sessionData.edit_id     = @js($subject?->pivot?->id);
                                                                                    sessionData.subject_id  = @js($subject?->pivot->subject_id);
                                                                                    sessionData.hour_rate   = @js($subject?->pivot?->hour_rate);
                                                                                    sessionData.description = @js($subject?->pivot?->description);
                                                                                    sessionData.sort_order  = @js($subject?->pivot?->sort_order);
                                                                                    sessionData.image       = @js($subject?->pivot?->image);
                                                                                    $wire.call('addNewSubject', {{ $group?->id }});
                                                                                    $nextTick(() => {
                                                                                        $wire.dispatch('initSummerNote', {target: '#subject_desc', wiremodel: 'form.description', conetent: @js($subject?->pivot?->description), componentId: @this});
                                                                                        $('.am-select2').prop('disabled', true);
                                                                                        clearFormErrors('#subject_modal form');
                                                                                    })
                                                                                    ">
                                                                                        <i class="am-icon-pencil-02"></i>
                                                                                        {{ __('general.edit') }}
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="javascript:void(0);" class="am-del-btn" @click="$wire.dispatch('showConfirm', { groupId: {{ $group?->id }}, subjectId : {{ $subject?->pivot->id }}, action : 'delete-user-subject' })">
                                                                                        <i class="am-icon-trash-02"></i>
                                                                                        {{ __('general.delete') }}
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if(!empty($subject?->pivot?->description))
                                                                <p>{!! $subject?->pivot?->description !!}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif

                                    @if(!empty(array_diff_key($subjects, $this->getUserGroupSubject($group?->id))))
                                        <div class="am-addclasses-wrapper">
                                            <button
                                                class="am-add-class"
                                                @click="
                                                sessionData.edit_id = null;
                                                $wire.call('resetForm');
                                                $wire.call('addNewSubject', {{ $group?->id }});
                                                $nextTick(() => {
                                                    $wire.dispatch('initSummerNote', {target: '#subject_desc', wiremodel: 'form.description', componentId: @this})
                                                    $('.am-select2').prop('disabled', false);
                                                    clearFormErrors('#subject_modal form');
                                                })"
                                            >
                                                {{ __('subject.add_new_subject') }}
                                                <i class="am-icon-plus-01"></i>
                                                <svg><rect width="100%" height="100%" rx="10"></rect></svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-no-record :image="asset('images/subjects.png')" :title="__('general.no_record_title')" :description="__('general.no_record_desc')" :btn_text="__('subject.add_new_subject')" @click="search = ''; $nextTick(() => $wire.call('addNewSubjectGroup'))" wire:target="addNewSubjectGroup"/>
            @endif
        @endif
        <!-- Modals -->
        <div wire:ignore.self class="modal am-modal fade subject-group-modal" id="subject_group" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <h2>{{ __('subject.add_subject_group') }}</h2>
                        <span class="am-closepopup" data-bs-dismiss="modal">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form class="am-themeform am-subject-form">
                            <fieldset>
                                <div class="form-group" x-data="{
                                    groups: @entangle('groups'),
                                    selectedGroups: @entangle('selected_groups'),
                                    allSelected:false,
                                    updateSelectedGroups(evt) {
                                        this.allSelected = this.selectedGroups?.length == this.groups?.length;
                                    },
                                    toggleAll(isSelected) {
                                        this.selectedGroups = isSelected ? this.groups.map(group => group.id) : [];
                                    },
                                    removeGroup(id) {
                                        this.selectedGroups = this.selectedGroups.filter(item => item != id)
                                        this.allSelected = false;
                                    },
                                    get filteredGroups() {
                                        this.updateSelectedGroups();
                                        if(this.search){
                                            return this.groups.filter(group => group.name.toLowerCase().includes(this.search.toLowerCase()));
                                        } else {
                                            return this.groups;
                                        }
                                    }
                                }"
                                >
                                    <label class="am-label am-important">
                                        {{ __('subject.choose_subject_category') }}
                                    </label>
                                    <div class="am-select-days">
                                        <input type="text" class="form-control am-input-field" x-model="search" @input.debounce.300ms="$event.target.dispatchEvent(new Event('input'))" data-bs-auto-close="outside" placeholder="{{ __('calendar.select_from_list') }}" data-bs-toggle="dropdown">
                                        <div class="dropdown-menu">
                                            <template x-if="filteredGroups.length > 0">
                                                <div>
                                                    <div class="am-checkbox">
                                                        <input type="checkbox" x-model="allSelected" id="select-all" name="group" @change="toggleAll($event.target.checked)">
                                                        <label for="select-all">{{ __('subject.select_all_subject_groups') }}</label>
                                                    </div>

                                                    <template x-for="group in filteredGroups" :key="group.id">
                                                        <div class="am-checkbox">
                                                            <input type="checkbox" :id="'group-' + group.id" :value="group.id" x-model="selectedGroups" @change="updateSelectedGroups" />
                                                            <label :for="'group-' + group.id" x-text="group.name"></label>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="filteredGroups.length === 0">
                                                <li>{{ __('general.no_record_found') }}</li>
                                            </template>
                                        </div>
                                    </div>
                                    <template x-if="selectedGroups.length > 0">
                                        <ul class="am-subject-tag-list">
                                            <template x-for="id in selectedGroups">
                                                <li>
                                                    <a href="javascript:void(0)" class="am-subject-tag" @click="removeGroup(id)">
                                                        <span x-text="groups.find(item => item.id == id)?.['name']"></span>
                                                        <i class="am-icon-multiply-02"></i>
                                                    </a>
                                                </li>
                                            </template>
                                        </ul>
                                    </template>
                                    <x-input-error field_name="selected_groups" />
                                </div>
                                <div class="form-group am-mt-10 am-form-btn-wrap">
                                    <button wire:click.prevent="seveSubjectGroups" wire:click.prevent="seveSubjectGroups" wire:target="seveSubjectGroups" wire:loading.class="am-btn_disable" class="am-btn">{{ __('general.save_update') }}</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- education modal -->
        <div wire:ignore.self class="modal am-modal fade am-subject_modal" id="subject_modal" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <template x-if="sessionData.edit_id">
                            <h2>{{ __('subject.edit_subject') }}</h2>
                        </template>
                        <template x-if="sessionData.edit_id == ''">
                            <h2>{{ __('subject.add_subject') }}</h2>
                        </template>
                        <span class="am-closepopup" wire:target="saveNewSubject" data-bs-dismiss="modal" wire:loading.attr="disabled">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form class="am-themeform am-modal-form">
                            <fieldset>
                                <div @class(['form-group', 'am-invalid' => $errors->has('form.subject_id')])>
                                    <label class="am-label am-important" for="subjects">
                                        {{ __('subject.choose_subject') }}
                                    </label>
                                    <span class="am-select" wire:ignore>
                                        <select data-componentid="@this" class="am-select2" data-parent="#subject_modal" data-searchable="true" id="subjects" data-wiremodel="form.subject_id" data-placeholder="{{ __('subject.select_subject') }}"></select>
                                    </span>
                                    <x-input-error field_name="form.subject_id" />
                                </div>
                                @if(isPaidSystem())
                                    <div @class(['form-group', 'am-invalid' => $errors->has('form.hour_rate')])>
                                        <label class="am-label am-important">{{ __('subject.session_price') }}</label>
                                        <div class="am-inputfield">
                                            <x-text-input wire:model="form.hour_rate" placeholder="{{ getCurrencySymbol().'0.00' }}" type="number" />
                                            <span class="am-inputfield_icon">{{ getCurrencySymbol() }}</span>
                                        </div>
                                        <x-input-error field_name="form.hour_rate" />
                                    </div>
                                @endif
                                <div @class(['form-group', 'am-invalid' => $errors->has('form.description')])>
                                    <x-input-label class="am-important" for="introduction" :value="__('subject.breif_introduction')" />
                                    <div class="am-custom-editor" wire:ignore>
                                            <textarea id="subject_desc" class="form-control" placeholder="{{ __('subject.add_introduction') }}">{{ $form->description }}</textarea>
                                        <span class="characters-count"></span>
                                    </div>
                                    <x-input-error field_name="form.description" />
                                </div>
                                <div class="form-group">
                                    <x-input-label for="Profile1" :value="__('general.upload_image')" />
                                    <div class="am-uploadoption" x-data="{isUploading:false}" wire:key="uploading-profile-{{ time() }}">
                                        <div class="tk-draganddrop"
                                            x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading }"
                                            x-on:drop.prevent="isUploading = true; isDragging = false"
                                            wire:drop.prevent="$upload('form.image', $event.dataTransfer.files[0])">
                                            <x-text-input
                                                name="file"
                                                type="file"
                                                id="at_upload_cover_photo"
                                                x-ref="file_upload"
                                                accept="{{ !empty($allowImgFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*' }}"
                                                x-on:change="isUploading = true; $wire.upload('form.image', $refs.file_upload.files[0])"/>

                                            <label for="at_upload_cover_photo" class="am-uploadfile">
                                                <span class="am-dropfileshadow">
                                                    <svg class="am-border-svg "><rect width="100%" height="100%" rx="12"></rect></svg>
                                                    <i class="am-icon-plus-02"></i>
                                                    <span class="am-uploadiconanimation">
                                                        <i class="am-icon-upload-03"></i>
                                                    </span>
                                                    {{ __('general.drop_file_here') }}
                                                </span>
                                                <em>
                                                    <i class="am-icon-export-03"></i>
                                                </em>
                                                <span>{{ __('general.drop_file') }} <i>{{ __('general.click_here_file') }}</i> {{ __('general.to_upload') }} <em>{{ allowFileExt($allowImgFileExt)  }} ({{ __('general.max') .$allowImageSize.'MB' }})</em></span>
                                            </label>
                                        </div>
                                        @if(!empty($form->image))
                                            <div class="am-uploadedfile">
                                                @if( !empty($form->image) && method_exists($form->image,'temporaryUrl'))
                                                    <img src="{{ $form->image->temporaryUrl() }}">
                                                @elseif(!empty($form->image) && Storage::disk(getStorageDisk())->exists($form->image))
                                                    <img src="{{ Storage::url($form->image) }}">
                                                @else    
                                                    <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : url(Storage::url($form->image)) }}">
                                                @endif

                                                @if ( !empty($form->image) && method_exists($form->image,'getClientOriginalName'))
                                                    <span>{{ $form->image->getClientOriginalName() }}</span>
                                                @else
                                                    <span>{{ basename(parse_url(url(Storage::url($form->image)), PHP_URL_PATH)) }}</span>
                                                @endif

                                                <a href="#" wire:click.prevent="removeImage" class="am-delitem">
                                                    <i class="am-icon-trash-02"></i>
                                                </a>
                                            </div>
                                        @endif
                                        <x-input-error field_name="form.image" />
                                    </div>
                                </div>
                                <div class="form-group am-mt-10 am-form-btn-wrap">
                                    <button class="am-btn" wire:click.prevent="saveNewSubject" wire:target="saveNewSubject" wire:loading.class="am-btn_disable">{{ __('general.save_update') }}</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
    @vite([
        'public/summernote/summernote-lite.min.css',
    ])
@endpush
@push('scripts')
    <script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>
    <script defer src="{{ asset('js/livewire-sortable.js')}}"></script>
@endpush

