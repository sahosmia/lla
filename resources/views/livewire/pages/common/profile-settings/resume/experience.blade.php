<div class="am-resumebox_content" wire:init="loadData">
    @slot('title')
        {{ __('experience.title') }}
    @endslot
    <div class="am-resumewrap">
        @if($isLoading)
        @include('skeletons.experiences')
        @else
            @if(!$experiences->isEmpty())
                <div class="am-title_wrap">
                    <div class="am-title">
                        <h2>{{ __('experience.experience_details') }}</h2>
                        <p>{{ __('experience.experience_message') }}</p>
                    </div>
                    <button class="am-btn am-btnsmall" wire:click="addExperience" wire:loading.class="am-btn_disable">
                        {{ __('general.add_new') }}
                        <i class="am-icon-plus-02"></i>
                    </button>
                </div>
                @php
                $types = [
                    ''              => __('general.select_type'),
                    'full_time'     => __('experience.full_time'),
                    'part_time'     => __('experience.part_time'),
                    'self_employed' => __('experience.self_employed'),
                    'contract'      => __('experience.contract'),
                ]
                @endphp
                <div class="am-resume">
                    @foreach($experiences as $experience)
                    <div class="am-resume_item">
                        <div class="am-resume_item_title">
                            <h3>{{ $experience->title }}</h3>
                            <div class="am-itemdropdown">
                                <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="am-icon-ellipsis-horizontal-02"></i>
                                </a>
                                <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li>
                                        <a href="#" wire:click="editExperience({{ $experience }})">
                                            <i class="am-icon-pencil-02"></i>
                                            {{ __('general.edit') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"
                                            class="am-del-btn"
                                            @click="$wire.dispatch('showConfirm', { id : {{ $experience->id }}, action : 'delete-experience' })">
                                            <i class="am-icon-trash-02"></i>
                                            {{ __('general.delete') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div id="experience-model-{{ $experience->id }}" class="modal am-educationpopup" tabindex="-1"
                                role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="am-modal-header">
                                            {{ __('experience.experience_description') }}
                                            <span data-bs-dismiss="modal" class="am-closepopup">
                                                <i class="am-icon-multiply-01"></i>
                                            </span>
                                        </div>
                                        <div class="am-modal-body">
                                            <p>{{ $experience->description }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="am-btn"
                                                x-on:click="$('#experience-model-{{ $experience->id }}').modal('hide')">{{
                                                __('general.close_btn') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="am-resume_item_info">
                            <li>
                                <span>
                                    <i class="am-icon-book-1"></i>
                                    {{ $experience->company }}
                                </span>
                            </li>
                            @if (!empty($types[$experience->employment_type]))
                            <li>
                                <span>
                                    <i class="am-icon-briefcase-02"></i>
                                    {{ $types[$experience->employment_type] }}
                                </span>
                            </li>
                            @endif
                            <li>
                                <span>
                                    <i class="am-icon-location"></i>
                                    {{ ucfirst($experience->location) }}
                                </span>
                            </li>
                            @if($experience->location == 'onsite')
                            <li>
                                <span>
                                    <i class="am-icon-location"></i>
                                    {{ ucfirst($experience->city) }}, {{ ucfirst($experience?->country?->name) }}
                                </span>
                            </li>
                            @endif
                            <li>
                                <span>
                                    <i class="am-icon-calender-day"></i>
                                    {{ date('F Y', strtotime($experience->start_date)) }} - {{ $experience->is_current ?
                                    __('general.current') : date('F Y', strtotime($experience->end_date)) }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    @endforeach
                </div>
            @else
            <x-no-record :image="asset('images/experience.png')" :title="__('general.no_record_title')"
                :description="__('general.no_record_desc')" :btn_text="__('experience.add_new_experience')"
                wire:click="addExperience" />
            @endif
        @endif
        <div wire:ignore.self class="modal fade am-educationpopup" id="experience-popup" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <h2>
                            @if ($updateMode)
                                {{ __('experience.update_new_experience') }}
                            @else
                                {{ __('experience.add_new_experience') }}
                            @endif
                        </h2>    
                        <span data-bs-dismiss="modal" class="am-closepopup">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form wire:submit="storeExperience" class="am-themeform">
                            <fieldset>
                                <div class="form-group @error('form.title') am-invalid @enderror">
                                    <x-input-label for="title" class="am-important"
                                        :value="__('experience.job_title')" />
                                    <x-text-input wire:model="form.title" id="title" name="title"
                                        placeholder="{{ __('experience.job_title_placeholder') }}" type="text" autofocus
                                        autocomplete="name" />
                                    <x-input-error field_name="form.title" />
                                </div>
                                <div class="form-group @error('form.employment_type') am-invalid @enderror">
                                    <x-input-label for="employment_type" class="am-important"
                                        :value="__('experience.employment_type')" />
                                    <span class="am-select" wire:ignore>
                                        <select wire:key="{{ time().'-types' }}" id="types"
                                            class="am-custom-select"></select>
                                    </span>
                                    <x-input-error field_name="form.employment_type" />
                                </div>
                                <div class="form-group @error('form.company') am-invalid @enderror">
                                    <x-input-label for="name" class="am-important" :value="__('experience.company')" />
                                    <x-text-input wire:model="form.company" id="company" name="company"
                                        placeholder="{{ __('experience.company_placeholder') }}" type="text" autofocus
                                        autocomplete="name" />
                                    <x-input-error field_name="form.company" />
                                </div>
                                <div class="form-group @error('form.location') am-invalid @enderror">
                                    <x-input-label for="location" class="am-important"
                                        :value="__('experience.location')" />
                                    <span class="am-select" wire:ignore>
                                        <select wire:key="{{ time().'-location' }}" id="locations"
                                            class="am-custom-select"></select>
                                    </span>
                                    <x-input-error field_name="form.location" />
                                </div>
                                <div class="form-group form-group-two-wrap">
                                    <div class="@error('form.country') am-invalid @enderror">
                                        <x-input-label class="am-important" for="country"
                                            :value="__('experience.country')" />
                                        <span class="am-select" wire:ignore>
                                            <select wire:key="{{ time().'-country' }}" id="countries"
                                                class="am-custom-select" data-parent="#experience-popup"></select>
                                        </span>
                                        <x-input-error field_name="form.country" />
                                    </div>
                                    <div class="@error('form.city') am-invalid @enderror">
                                        <x-input-label class="am-important" for="country"
                                            :value="__('experience.city')" />
                                        <x-text-input wire:model="form.city" id="city" name="city"
                                            placeholder="{{ __('experience.city_placeholder') }}" autofocus
                                            autocomplete="name" />
                                        <x-input-error field_name="form.city" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <x-input-label for="date" class="am-important" :value="__('experience.date')" />
                                    <div class="form-group-two-wrap">
                                        <div class="@error('form.start_date') am-invalid @enderror">
                                            <x-text-input wire:model="form.start_date" class="flat-date" id="startdate"
                                                name="startdate"
                                                placeholder="{{ __('experience.start_date_placeholder') }}"
                                                data-format="Y-m-d" type="text" id="datepicker" data-modal="true" 
                                                autofocus autocomplete="name" />
                                            <x-input-error field_name="form.start_date" />
                                        </div>
                                        <div class="@error('form.end_date') am-invalid @enderror">
                                            <x-text-input wire:model="form.end_date" class="flat-date" id="end_date"
                                                name="end_date"
                                                placeholder="{{ __('experience.end_date_placeholder') }}"
                                                data-format="Y-m-d" type="text" id="datepicker" data-modal="true" 
                                                autofocus autocomplete="name" />
                                            <x-input-error field_name="form.end_date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="am-checkbox">
                                        <input wire:model="form.is_current" type="checkbox" id="is_current">
                                        <label for="is_current">{{__('experience.checkbox_title')}}</label>
                                        <x-input-error field_name="form.is_current" />
                                    </div>
                                </div>
                                <div class="form-group @error('form.description') am-invalid @enderror">
                                    <div class="am-label-wrap">
                                        <x-input-label class="am-important" for="description"
                                            :value="__('experience.description')" />
                                        @if(setting('_ai_writer_settings.enable_on_experience_settings') == '1')
                                            <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal"  data-prompt-type="experience" data-parent-model-id="experience-popup" data-target-selector="#description" data-target-summernote="true">
                                                <img src="{{ asset('images/ai-icon.svg') }}" alt="AI">
                                                {{ __('general.write_with_ai') }}
                                            </button>
                                        @endif
                                    </div>
                                    <div class="am-custom-editor" wire:ignore>
                                        <textarea id="description" class="form-control"
                                            placeholder="{{ __('experience.description_placeholder') }}">{!! $form->description !!}</textarea>
                                        <span class="total-characters">
                                            <div class='tu-input-counter'>
                                                <span>{{ __('general.char_left') }}:</span>
                                                <b>
                                                    {!! $MAX_PROFILE_CHAR - Str::length($form->description) !!}
                                                </b> <em>/ {{ $MAX_PROFILE_CHAR }}</em>
                                            </div>
                                        </span>
                                    </div>
                                    <x-input-error field_name="form.description" />
                                </div>
                                <div class="form-group am-form-btns">
                                    <button type="submit" class="am-btn" wire:target="storeExperience" wire:loading.class="am-btn_disable">
                                        {{__('general.save_update')}}
                                    </button>
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
'public/css/flatpicker.css',
'public/summernote/summernote-lite.min.css',
'public/css/flatpicker-month-year-plugin.css'
])
@endpush
@push('scripts')
<script defer src="{{ asset('js/flatpicker.js') }}"></script>
<script defer src="{{ asset('js/flatpicker-month-year-plugin.js') }}"></script>
<script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>

<script type="text/javascript" data-navigate-once>
    var component = '';
    document.addEventListener('livewire:navigated', function() {
        component = @this;
    });
    document.addEventListener('livewire:initialized', function() {
        $(document).on('show.bs.modal','#experience-popup', function () {
            setTimeout(() => {
                initializeDatePicker()
            }, 100);
            var initialContent = component.get('form.description');
            $('#description').summernote('destroy');
            $('#description').summernote(summernoteConfigs('#description', '.total-characters'));
            $('#description').summernote('code', initialContent);

            $(document).on('summernote.change', '#description', function(we, contents, $editable) {
                component.set("form.description",contents, false);
                updateCharacterCounter();
            });
            updateCharacterCounter();
        });

        function updateCharacterCounter() {
            let contentLength = $('#description').summernote('code').replace(/(<([^>]+)>)/gi, "").length;
            let maxChars = {!! $MAX_PROFILE_CHAR !!};
            let charsLeft = maxChars - contentLength;

            $('.total-characters b').text(charsLeft);
        }

        document.addEventListener('initMutliDropDown', (evt) => {
            for (const [key, value] of Object.entries( evt.detail.data)) {
                let element = jQuery(`#${key}`);
                if(element.data('select2')){
                    element.val(evt.detail[key+'_id'] ?? '').trigger('change');
                } else {
                    element.select2({
                        data: value,
                        dropdownParent: jQuery('#experience-popup')
                    });
                }
            }
        });

        document.addEventListener('loadPageJs', (event) => {
            component.dispatch('initSelect2', {target:'.am-select2'});
            setTimeout(() => {
                $('#description').summernote('destroy');
                $('#description').summernote(summernoteConfigs('#description','.total-characters'));
                initializeDatePicker()
            }, 500);

        })

        jQuery(document).on('change', '#types', function(e){
            component.set('form.employment_type', jQuery('#types').select2("val"), false);
        });

        jQuery(document).on('change', '#locations', function(e){
            component.set('form.location', jQuery('#locations').select2("val"), false);
        });

        jQuery(document).on('change', '#countries', function(e){
            component.set('form.country', jQuery('#countries').select2("val"), false);
        });
    })
</script>
@endpush
