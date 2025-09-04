<div class="am-resumebox_content" wire:init="loadData">
    @slot('title')
        {{ __('education.title') }}
    @endslot
    <div class="am-resumewrap">
        @if($isLoading)
        @include('skeletons.education')
    @else 
        @if(!$educations->isEmpty())
        <!-- @include('skeletons.education') -->
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2>{{ __('education.education_details') }}</h2>
                    <p>{{ __('education.education_message') }}</p>
                </div>
                <button class="am-btn am-btnsmall" wire:click="addEducation" wire:loading.class="am-btn_disable">
                    {{ __('general.add_new') }}
                    <i class="am-icon-plus-02"></i>
                </button>
            </div>
            <div class="am-resume">
                @foreach($educations as $education)
                <div class="am-resume_item">
                    <div class="am-resume_item_title">
                        <h3>{{ $education->course_title }}</h3>
                        <div class="am-itemdropdown">
                            <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="am-icon-ellipsis-horizontal-02"></i>
                            </a>
                            <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li>
                                    <a href="#" wire:click="editEducation({{ $education }})">
                                        <i class="am-icon-pencil-02"></i>
                                        {{ __('general.edit') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);"
                                        class="am-del-btn"
                                        @click="$wire.dispatch('showConfirm', { id : {{ $education->id }}, action : 'delete-education' })">
                                        <i class="am-icon-trash-02"></i>
                                        {{ __('general.delete') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div id="education-model-{{ $education->id }}" class="modal am-educationpopup" tabindex="-1"
                            role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="am-modal-header">
                                        {{ __('education.education_description') }}
                                        <span data-bs-dismiss="modal" class="am-closepopup">
                                            <i class="am-icon-multiply-01"></i>
                                        </span>
                                    </div>
                                    <div class="am-modal-body">
                                        <p>{{ $education->description }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="am-btn"
                                            x-on:click="$('#education-model-{{ $education->id }}').modal('hide')">{{
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
                                {{ $education->institute_name }}
                            </span>
                        </li>
                        <li>
                            <span>
                                <i class="am-icon-location"></i>
                                {{ ucfirst($education->city) }}, {{ ucfirst($education?->country?->name) }}
                            </span>
                        </li>
                        <li>
                            <span>
                                <i class="am-icon-calender"></i>
                                {{ date('F Y', strtotime($education->start_date)) }} - {{ $education->ongoing ?
                                __('general.current') : date('F Y', strtotime($education->end_date)) }}
                            </span>
                        </li>
                    </ul>
                </div>
                @endforeach
    
            </div>
        @else
            <x-no-record :image="asset('images/education.png')" :title="__('general.no_record_title')"
                :description="__('general.no_record_desc')" :btn_text="__('education.add_new_education')"
                wire:click="addEducation" />
        @endif
    @endif       
        <div wire:ignore.self class="modal fade am-educationpopup" id="education-popup" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <h2>
                            @if ($updateMode)
                                {{ __('education.update_new_education') }}
                            @else
                                {{ __('education.add_new_education') }}
                            @endif
                        </h2>
                        <span data-bs-dismiss="modal" class="am-closepopup">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form wire:submit="storeEducation" class="am-themeform">
                            <fieldset>
                                <div class="form-group @error('form.course_title') am-invalid @enderror">
                                    <x-input-label for="name" class="am-important" :value="__('education.degree')" />
                                    <x-text-input wire:model="form.course_title" id="course_title" name="course_title"
                                        placeholder="{{ __('education.degree_placeholder') }}" type="text"
                                         />
                                    <x-input-error field_name="form.course_title" />
                                </div>
                                <div class="form-group @error('form.institute_name') am-invalid @enderror">
                                    <x-input-label for="name" class="am-important"
                                        :value="__('education.university')" />
                                    <x-text-input wire:model="form.institute_name" id="institute_name"
                                        name="institute_name" placeholder="{{ __('education.university_placeholder') }}"
                                        type="text"  />
                                    <x-input-error field_name="form.institute_name" />
                                </div>
                                <div class="form-group form-group-two-wrap">
                                    <div @class(['am-invalid'=> $errors->has('form.country')])>
                                        <x-input-label for="country" class="am-important"
                                            :value="__('education.country')" />
                                        <span class="am-select" wire:ignore>
                                            <select data-componentid="@this" wire:key="{{ time() }}"
                                                class="am-custom-select" data-parent="#education-popup"
                                                data-searchable="true" data-wiremodel="form.country">
                                            </select>
                                        </span>
                                        <x-input-error field_name="form.country" />
                                    </div>
                                    <div class="@error('form.city') am-invalid @enderror">
                                        <x-input-label class="am-important" for="country"
                                            :value="__('education.city')" />
                                        <x-text-input wire:model="form.city" id="city" name="city"
                                            placeholder="{{ __('education.city_placeholder') }}"
                                             />
                                        <x-input-error field_name="form.city" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <x-input-label for="name" class="am-important" :value="__('education.date')" />
                                    <div class="form-group-two-wrap">
                                        <div class="@error('form.start_date') am-invalid @enderror">
                                            <x-text-input wire:model="form.start_date" class="flat-date date"
                                                id="startdate" name="startdate"
                                                placeholder="{{ __('education.start_date_placeholder') }}"
                                                data-format="Y-m-d" type="text" id="datepicker" data-modal="true" 
                                                autofocus autocomplete="name" />
                                            <x-input-error field_name="form.start_date" />
                                        </div>
                                        <div class="@error('form.end_date') am-invalid @enderror">
                                            <x-text-input wire:model="form.end_date" class="flat-date date"
                                                id="end_date" name="end_date"
                                                placeholder="{{ __('education.end_date_placeholder') }}"
                                                data-format="Y-m-d" type="text" id="datepicker" data-modal="true"
                                                autofocus autocomplete="name" />
                                            <x-input-error field_name="form.end_date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="am-checkbox">
                                        <input wire:model="form.ongoing" type="checkbox" id="ongoing">
                                        <label for="ongoing">{{__('education.checkbox_title')}}</label>
                                        <x-input-error field_name="form.ongoing" />
                                    </div>
                                </div>
                                <div class="form-group @error('form.description') am-invalid @enderror">
                                    <div class="am-label-wrap">
                                        <x-input-label class="am-important" for="description"
                                            :value="__('education.description')" />
                                        @if(setting('_ai_writer_settings.enable_on_education_settings') == '1')
                                            <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal"  data-prompt-type="education" data-parent-model-id="education-popup" data-target-selector="#description" data-target-summernote="true">
                                                <img src="{{ asset('images/ai-icon.svg') }}" alt="AI">
                                                {{ __('general.write_with_ai') }}
                                            </button>
                                        @endif
                                    </div>
                                    <div class="am-custom-editor" wire:ignore>
                                        <textarea id="description" class="form-control" placeholder="{{ __('education.description_placeholder') }}">{!! $form->description !!}</textarea>
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
                                    <button type="submit" class="am-btn" wire:loading.class="am-btn_disable"
                                        wire:target="storeEducation">{{__('general.save_update')}}</button>
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
        $(document).on('show.bs.modal','#education-popup', function () {
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

        document.addEventListener('initSelectTwo', (evt) => {
            let element = jQuery(evt.detail.target);
            if(element.data('select2')){
                element.val(evt.detail.id ?? '').trigger('change');
            } else {
                jQuery(evt.detail.target).select2({
                    data: evt.detail.data,
                    dropdownParent: jQuery('#education-popup')
                });
            }
        });

        jQuery(document).on('change', '.am-custom-select', function(e){
            component.set('form.country', jQuery('.am-custom-select').select2("val"), false);
        })

        document.addEventListener('loadPageJs', (event) => {
            component.dispatch('initSelect2', {target:'.am-select2'});
            setTimeout(() => {
                $('#description').summernote('destroy');
                $('#description').summernote(summernoteConfigs('#description','.total-characters'));
                initializeDatePicker()
            }, 500);
        })
    })
</script>
@endpush
