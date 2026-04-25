<div class="am-resumebox_content" wire:init="loadData">
    @slot('title')
        {{ __('certificate.certificate_details') }}
    @endslot
    <div class="am-resumewrap">
        @if($isLoading)
        @include('skeletons.certificate')
    @else
        @if(!$certificates->isEmpty())
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2>{{ __('certificate.certificate_details') }}</h2>
                    <p>{{ __('certificate.certificate_message') }}</p>
                </div>
                <button class="am-btn am-btnsmall" wire:click="addCertificate" wire:loading.class="am-btn_disable">
                    {{ __('general.add_new') }}
                    <i class="am-icon-plus-02"></i>
                </button>
            </div>
            <div class="am-resume">
                @foreach($certificates as $certificate)
                <div class="am-resume_item am-resume_wrap">
                    @if(!empty($certificate->image))
                    <img src="{{ url(Storage::url($certificate->image)) }}" alt="image">
                    @endif
                    <div class="am-resume_content">
                        <div class="am-resume_item_title">
                            <h3>{{ $certificate->title }}</h3>
                            <div class="am-itemdropdown">
                                <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="am-icon-ellipsis-horizontal-02"></i>
                                </a>
                                <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li>
                                        <a href="#" wire:click="editCertificate({{ $certificate }})">
                                            <i class="am-icon-pencil-02"></i>
                                            {{ __('certificate.edit_certificate') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="am-del-btn" @click="$wire.dispatch('showConfirm', { id : {{ $certificate->id }}, action : 'delete-certificate' })">
                                            <i class="am-icon-trash-02"></i>
                                            {{ __('certificate.delete_certificate') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div id="certificate-model-{{ $certificate->id }}" class="modal am-educationpopup" tabindex="-1"
                                role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="am-modal-header">
                                            {{ __('certificate.certificate_description') }}
                                            <span data-bs-dismiss="modal" class="am-closepopup">
                                                <i class="am-icon-multiply-01"></i>
                                            </span>
                                        </div>
                                        <div class="am-modal-body">
                                            <p>{{ $certificate->description }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="am-btn"
                                                x-on:click="$('#certificate-model-{{ $certificate->id }}').modal('hide')">{{
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
                                    {{ $certificate->institute_name }}
                                </span>
                            </li>
                            <li>
                                <span>
                                    <i class="am-icon-calender-minus"></i>
                                    {{ __('certificate.issued') }} {{ date('M d, Y', strtotime($certificate->issue_date)) }}
                                </span>
                            </li>
                            <li>
                                <span>
                                    <i class="am-icon-calender-xmark"></i>
                                    {{ __('certificate.expiry') }} {{ date('M d, Y', strtotime($certificate->expiry_date))
                                    }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <x-no-record :image="asset('images/certificate.png')" :title="__('general.no_record_title')"
                :description="__('general.no_record_desc')" :btn_text="__('certificate.add_new_certificate')"
                wire:click="addCertificate" />
        @endif
    @endif
        <div wire:ignore.self class="modal fade am-educationpopup" id="certificate-popup" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <h2>
                            @if ($updateMode)
                            {{ __('certificate.update_new_certificate') }}
                            @else
                            {{ __('certificate.add_new_certificate') }}
                            @endif
                        </h2>
                        <span data-bs-dismiss="modal" class="am-closepopup">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form wire:submit="storeCertificate" class="am-themeform">
                            <fieldset>
                                <div class="form-group">
                                    <x-input-label for="image" class="am-important"
                                        :value="__('certificate.image_title')" />
                                    <div class="am-uploadoption" x-data="{isUploading:false}" wire:key="uploading-profile-{{ time() }}">
                                        <div class="tk-draganddrop"
                                            x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading  }"
                                            x-on:drop.prevent="isUploading = true;isDragging = false"
                                            wire:drop.prevent="$upload('form.image', $event.dataTransfer.files[0])">
                                            <x-text-input
                                                name="file"
                                                type="file"
                                                id="at_upload_photo"
                                                x-ref="file_upload"
                                                accept="{{ !empty($allowImgFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*' }}"
                                                x-on:change=" isUploading = true; $wire.upload('form.image', $refs.file_upload.files[0])"/>
                                            <label for="at_upload_photo" class="am-uploadfile">
                                                <span class="am-dropfileshadow">
                                                    <svg class="am-border-svg "><rect width="100%" height="100%" rx="12"></rect></svg>
                                                    <i class="am-icon-plus-02"></i>
                                                    <span class="am-uploadiconanimation">
                                                        <i class="am-icon-upload-01"></i>
                                                    </span>
                                                    {{ __('general.drop_file_here') }}
                                                </span>
                                                <em>
                                                    <i class="am-icon-export-03"></i>
                                                </em>
                                                <span>{{ __('general.drop_file_here_or')}} <i> {{ __('general.click_here_file')}} </i> {{ __('general.to_upload') }} <em>{{ $fileExt }} (max. {{ $allowImageSize }} MB)</em></span>
                                            </label>
                                        </div>
                                        @if(!empty($form->image))
                                        <div class="am-uploadedfile">
                                            @if (method_exists($form->image,'temporaryUrl'))
                                            <img src="{{ $form->image->temporaryUrl() }}">
                                            @else
                                            <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : url(Storage::url($form->image)) }}">
                                            @endif

                                            @if (method_exists($form->image,'temporaryUrl'))
                                            <span>{{ basename(parse_url($form->image->temporaryUrl(), PHP_URL_PATH))
                                                }}</span>
                                            @endif
                                            <a href="#" wire:click.prevent="removePhoto()" class="am-delitem">
                                                <i class="am-icon-trash-02"></i>
                                            </a>
                                        </div>
                                        @endif
                                        <x-input-error field_name="form.image" />
                                    </div>
                                </div>
                                <div class="form-group @error('form.title') am-invalid @enderror">
                                    <x-input-label for="title" class="am-important"
                                        :value="__('certificate.certificate_title')" />
                                    <x-text-input wire:model="form.title" id="title" name="title"
                                        placeholder="{{ __('certificate.title_placeholder') }}" type="text" autofocus
                                        autocomplete="name" />
                                    <x-input-error field_name="form.title" />
                                </div>
                                <div class="form-group @error('form.institute_name') am-invalid @enderror">
                                    <x-input-label for="institute_name" class="am-important"
                                        :value="__('certificate.university')" />
                                    <x-text-input wire:model="form.institute_name" id="institute_name"
                                        name="institute_name"
                                        placeholder="{{ __('certificate.university_placeholder') }}" type="text"
                                        autofocus autocomplete="name" />
                                    <x-input-error field_name="form.institute_name" />
                                </div>
                                <div class="form-group form-group-two-wrap">
                                    <div class="@error('form.issue_date') am-invalid @enderror">
                                        <x-input-label for="issue_date" class="am-important"
                                            :value="__('certificate.issue_date')" />
                                        <x-text-input wire:model="form.issue_date" class="flat-date" id="issue_date"
                                            name="issue_date"
                                            placeholder="{{ __('certificate.issue_date_placeholder') }}"
                                            data-format="Y-m-d" type="text" id="datepicker" data-modal="true" 
                                            autofocus autocomplete="name" />
                                        <x-input-error field_name="form.issue_date" />
                                    </div>
                                    <div class="@error('form.expiry_date') am-invalid @enderror">
                                        <x-input-label for="expiry_date" class="am-important"
                                            :value="__('certificate.expiry_date')" />
                                        <x-text-input wire:model="form.expiry_date" class="flat-date" id="expiry_date"
                                            name="expiry_date"
                                            placeholder="{{ __('certificate.expiry_date_placeholder') }}"
                                            data-format="Y-m-d" type="text" id="datepicker" data-modal="true" 
                                            autofocus autocomplete="name" />
                                        <x-input-error field_name="form.expiry_date" />
                                    </div>
                                </div>
                                <div class="form-group @error('form.description') am-invalid @enderror">
                                    <div class="am-label-wrap">
                                        <x-input-label for="description" :value="__('certificate.description')" />
                                        @if(setting('_ai_writer_settings.enable_on_awards_settings') == '1')
                                            <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal"  data-prompt-type="awards" data-parent-model-id="certificate-popup" data-target-selector="#description" data-target-summernote="true">
                                                <img src="{{ asset('images/ai-icon.svg') }}" alt="AI">
                                                {{ __('general.write_with_ai') }}
                                            </button>
                                        @endif
                                    </div>
                                    <div class="am-custom-editor" wire:ignore>
                                        <textarea id="description" class="form-control"
                                            placeholder="{{ __('certificate.description_placeholder') }}"></textarea>
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
                                    <button type="submit" class="am-btn" wire:loading.class="am-btn_disable">{{__('general.save_update')}}</button>
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
        $(document).on('show.bs.modal','#certificate-popup', function () {
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
