
<div class="am-profile-setting" wire:init="loadData">
    @slot('title')
        {{ __('identity.title') }}
    @endslot
    @include('livewire.pages.common.profile-settings.tabs')
    <div class="am-userperinfo">
        @if(empty($identity))
            <div class="am-userid">
                <div class="am-title_wrap">
                    <div class="am-title">
                        <h2>{{ __('profile.identity_verification') }}</h2>
                        <p>{{ __('profile.identity_detail_desc') }}</p>
                    </div>
                </div>
                <form wire:submit="updateInfo" class="am-themeform am-themeform_personalinfo">
                    @if($isLoading)
                    @include('skeletons.identity-verification')
                @else
                    <fieldset>
                        <div class="form-group">
                            <x-input-label for="name" class="am-important" :value="__('profile.full_name')" />
                            <div class="form-group-two-wrap">
                                <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.name')])>
                                    <x-text-input wire:model="form.name" placeholder="{{ __('profile.full_name') }}" type="text"  autofocus autocomplete="name" />
                                    <x-input-error field_name="form.name" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <x-input-label for="name" class="am-important" :value="__('profile.date_of_birth')" />
                            <div class="form-group-two-wrap">
                                <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.dateOfBirth')])>
                                    <x-text-input class="flat-date" id="dof" data-format="F-d-Y" wire:model="form.dateOfBirth" placeholder="{{ __('profile.date_of_birth') }}" type="text" id="datepicker"  autofocus autocomplete="name" />
                                    <x-input-error field_name="form.dateOfBirth" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group am-addressform">
                            <x-input-label for="address" class="am-important" :value="__('profile.address')" />
                            <div class="am-user-location">
                                @if($enableGooglePlaces == '1')
                                    <div class="form-group">
                                        <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.address')])>
                                            <x-text-input wire:ignore.self id="user_address" placeholder="{{ __('profile.address_placeholder') }}" type="text"  autofocus autocomplete="name" />
                                            <x-input-error field_name="form.address" />
                                        </div>
                                    </div>
                                @else
                                @if (!empty($countries))
                                    <div class="form-group-half" x-init="{ onFooChange(event) {}}">
                                        <x-input-label for="country" :value="__('profile.country')" />
                                        <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.country')])>
                                            <span class="am-select" wire:ignore>
                                                <select class="am-select2" data-componentid="@this" data-live="true" data-searchable="true" id="user_country" data-wiremodel="form.country">
                                                    <option value="">{{ __('profile.select_a_country') }}</option>
                                                    @foreach ($countries as $country)
                                                        <option value={{ $country?->id }}>{{ $country?->name }}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                        </div>
                                        <x-input-error field_name="form.country" />
                                    </div>
                                @endif
                                    @if(!empty($form->country) && count($states) > 0)
                                        <div class="form-group-half">
                                            <x-input-label for="country" :value="__('profile.state')" />
                                            <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.state')])>
                                                <span class="am-select">
                                                    <select data-componentid="@this" class="am-select2" data-searchable="true" id="country_state" data-wiremodel="form.state">
                                                        <option value="">{{ __('profile.select_a_state') }}</option>
                                                        @foreach ($states as $state)
                                                            <option value={{ $state?->id }}>{{ $state?->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </span>
                                            </div>
                                            <x-input-error field_name="form.state" />
                                        </div>
                                    @endif
                                    <div class="form-group-half">
                                        <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.city')])>
                                        <x-input-label for="city" :value="__('profile.city')" />
                                        <x-text-input wire:model="form.city" placeholder="{{ __('profile.city_placeholder') }}" type="text"  autofocus autocomplete="name" />
                                        <x-input-error field_name="form.city" />
                                    </div>
                                    </div>
                                    <div class="form-group-half">
                                        <x-input-label for="Zip" :value="__('profile.zipcode')" />
                                        <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.zipcode')])>
                                        <x-text-input wire:model="form.zipcode" placeholder="{{ __('profile.zipcode_placeholder') }}" type="text"  autofocus autocomplete="name" />
                                        <x-input-error field_name="form.zipcode" />
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <x-input-label class="am-important" for="profile_photo" :value="__('profile.personal_photo')" />
                            <div class="am-uploadoption" x-data="{isUploading:false}" wire:key="uploading-profile-photo-{{ time() }}" >
                                <div class="tk-draganddrop"
                                    x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading }"
                                    x-on:drop.prevent="isUploading = true; isDragging = false"
                                    wire:drop.prevent="$upload('form.image', $event.dataTransfer.files[0])">
                                <x-text-input
                                    name="file"
                                    type="file"
                                    id="at_upload_photo"
                                    x-ref="file_upload_image"
                                    accept="{{ !empty($allowImgFileExt) ? join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*' }}"
                                    x-on:change="isUploading = true; $wire.upload('form.image', $refs.file_upload_image.files[0])" />

                                    <label for="at_upload_photo" class="am-uploadfile">
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
                                        <span>{{ __('general.drop_file_here_or') }} <i>{{ __('general.click_here_file') }}</i> {{ __('general.to_upload') }} <em>{{ $fileExt }} (max. {{ $allowImageSize }} MB)</em></span>
                                    </label>
                                </div>
                                @if(!empty($form->image))
                                    <div class="am-uploadedfile">
                                        @if (method_exists($form?->image,'temporaryUrl'))
                                            <img src="{{ $form?->image->temporaryUrl() }}">
                                        @else
                                            <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : url(Storage::url($form?->image)) }}" />
                                            <!-- <img src="{{ url(Storage::url($form?->image)) }}"> -->
                                        @endif
                                        @if (method_exists($form->image,'temporaryUrl'))
                                            <span>{{ basename(parse_url($form?->image->temporaryUrl(), PHP_URL_PATH)) }}</span>
                                        @endif
                                        <a href="#" wire:click.prevent="removeMedia('personal_photo')" class="am-delitem">
                                            <i class="am-icon-trash-02"></i>
                                        </a>
                                    </div>
                                @endif
                                <x-input-error field_name="form.image" />
                            </div>
                        </div>
                            @if($user->role == 'tutor')
                            <div class="form-group">
                                <x-input-label for="coverphoto1" class="am-important" :value="__('profile.identification_card')" />
                                <div class="am-uploadoption" x-data="{isUploading:false}" wire:key="uploading-identification-card-{{ time() }}">
                                    <div class="tk-draganddrop"
                                        x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading }"
                                        x-on:drop.prevent="isUploading = true; isDragging = false"
                                        wire:drop.prevent="$upload('form.identificationCard', $event.dataTransfer.files[0])">
                                        <x-text-input
                                            name="file"
                                            type="file"
                                            id="at_upload_identification_card"
                                            x-ref="file_upload"
                                            accept="{{ !empty($allowImgFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*' }}"
                                            x-on:change="isUploading = true; $wire.upload('form.identificationCard', $refs.file_upload.files[0])"/>
                                        <label for="at_upload_identification_card" class="am-uploadfile">
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
                                            <span>{{ __('general.drop_file_here_or')}} <i> {{ __('general.click_here_file')}} </i> {{ __('general.to_upload') }} <em>{{ $fileExt }} (max. {{ $allowImageSize }} MB)</em></span>
                                        </label>
                                    </div>
                                    @if(!empty($form->identificationCard))
                                        <div class="am-uploadedfile">
                                            @if (method_exists($form->identificationCard,'temporaryUrl'))
                                                <img src="{{ $form->identificationCard->temporaryUrl() }}">
                                            @else
                                                <img src="{{ url(Storage::url($form->identificationCard)) }}">
                                            @endif

                                            @if (method_exists($form->identificationCard,'temporaryUrl'))
                                                <span>{{ basename(parse_url($form->identificationCard->temporaryUrl(), PHP_URL_PATH)) }}</span>
                                            @endif
                                            <a href="#" wire:click.prevent="removeMedia('identificationCard')" class="am-delitem">
                                                <i class="am-icon-trash-02"></i>
                                            </a>
                                        </div>
                                        @endif
                                        <x-input-error field_name="form.identificationCard" />
                                </div>
                            </div>
                            @endif
                        @if($user->role == 'student')
                            <div class="form-group">
                                <x-input-label for="name" class="am-important" :value="__('profile.school_enrollment_id')" />
                                <div class="form-group-two-wrap">
                                    <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.schoolId')])>
                                        <x-text-input wire:model="form.schoolId" placeholder="{{ __('profile.school_enrollment_id') }}" type="text"  autofocus autocomplete="name" />
                                        <x-input-error field_name="form.schoolId" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <x-input-label for="name" class="am-important" :value="__('profile.school_name')" />
                                <div class="form-group-two-wrap">
                                    <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.schoolName')])>
                                        <x-text-input wire:model="form.schoolName" placeholder="{{ __('profile.school_name') }}" type="text"  autofocus autocomplete="name" />
                                        <x-input-error field_name="form.schoolName" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <x-input-label class="am-important" for="coverphoto1" :value="__('profile.identification_card')" />
                                <div class="am-uploadoption" x-data="{isUploading:false}" wire:key="uploading-transcript-{{ time() }}">
                                    <div class="tk-draganddrop"
                                        x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading }"
                                        x-on:drop.prevent="isUploading = true; isDragging = false"
                                        wire:drop.prevent="$upload('form.transcript', $event.dataTransfer.files[0])">
                                        <x-text-input
                                            name="file"
                                            type="file"
                                            id="at_upload_transcript"
                                            x-ref="file_upload"
                                            accept="{{ !empty($allowImgFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*' }}"
                                            x-on:change=" isUploading = true; $wire.upload('form.transcript', $refs.file_upload.files[0])"/>

                                        <label for="at_upload_transcript" class="am-uploadfile">
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
                                            <span>{{ __('general.drop_file_here_or')}} <i>{{ __('general.click_here_file')}}</i> {{ __('general.to_upload') }}<em>{{ $fileExt }} (max. {{ $allowImageSize }} MB)</em></span>
                                        </label>
                                    </div>
                                    @if(!empty($form->transcript))
                                        <div class="am-uploadedfile">
                                            @if (method_exists($form->transcript,'temporaryUrl'))
                                                <img src="{{ $form->transcript->temporaryUrl() }}">
                                            @else
                                                <img src="{{ url(Storage::url($form->transcript)) }}">
                                            @endif

                                            @if (method_exists($form->transcript,'temporaryUrl'))
                                                <span>{{ basename(parse_url($form->transcript->temporaryUrl(), PHP_URL_PATH)) }}</span>
                                            @endif
                                            <a href="#" wire:click.prevent="removeMedia('transcript')" class="am-delitem">
                                                <i class="am-icon-trash-02"></i>
                                            </a>
                                        </div>
                                        @endif
                                        <x-input-error field_name="form.transcript" />
                                </div>
                            </div>
                            <div class="form-group">
                                <x-input-label for="name" class="am-important" :value="__('profile.parent_name')" />
                                <div class="form-group-two-wrap">
                                    <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.parentName')])>
                                        <x-text-input wire:model="form.parentName" placeholder="{{ __('profile.parent_name') }}" type="text"  autofocus autocomplete="name" />
                                        <x-input-error field_name="form.parentName" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <x-input-label for="name" class="am-important" :value="__('profile.parent_email')" />
                                <div class="form-group-two-wrap">
                                    <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.parentEmail')])>
                                        <x-text-input wire:model="form.parentEmail" placeholder="{{ __('profile.parent_email') }}" type="text"  autofocus autocomplete="name" />
                                        <x-input-error field_name="form.parentEmail" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <x-input-label for="name" class="am-important" :value="__('profile.parent_phone')" />
                                <div class="form-group-two-wrap">
                                    <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.parentPhone')])>
                                        <x-text-input wire:model="form.parentPhone" placeholder="{{ __('profile.parent_phone') }}" type="text"  autofocus autocomplete="name" />
                                        <x-input-error field_name="form.parentPhone" />
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group am-form-btns">
                            <span>{{ __('profile.latest_changes_the_live') }}</span>
                            <x-primary-button wire:target="updateInfo" wire:loading.class="am-btn_disable" >{{ __('profile.save_update') }}</x-primary-button>
                        </div>
                    </fieldset>
                </form>
                @endif
            </div>
        @elseif(!empty($profile->verified_at))
            <div class="am-successmsg-wrap">
                <div class="am-success-msg">
                    <h5>{{ __('identity.hurray') }}</h5>
                    <p>{{ __('identity.complete_verification') }}</p>
                </div>
            </div>
        @else
            <div class="am-submitsmsg-wrap">
                <div class="am-success-msg">
                    <h5>{{ __('identity.woohoo') }}</h5>
                    <p>{{ __('identity.pending_submit_doc') }}</p>
                    <a href="javascript:void(0);" @click="$wire.dispatch('showConfirm', { content: `{{ __('identity.action_warning') }}`,  icon: 'warning', action : `cancel-identity` })">{{ __('identity.cancel_reupload') }}</a>
                </div>
            </div>
        @endif
    </div>
</div>
@push('scripts')
@if($enableGooglePlaces == '1')
<script async src="https://maps.googleapis.com/maps/api/js?key={{ $googleApiKey }}&libraries=places&loading=async&callback=initializePlaceApi"></script>
@endif
@endpush
@push('scripts')
    <script defer src="{{ asset('js/flatpicker.js') }}"></script>
    <script defer src="{{ asset('js/flatpicker-month-year-plugin.js') }}"></script>
    @if($enableGooglePlaces == '1')
        <script>
            var selectedCountry     = @json($selectedCountry);
            var searchOnlyCities    = @json($searchOnlyCities);

            function initializePlaceApi() {
                var tutorAddress = document.getElementById('user_address');
                if (!tutorAddress) {
                    setTimeout(initializePlaceApi, 500); 
                    return;
                }
                tutorAddress.addEventListener('input', function(e) {
                        if (e.target.value == '') {
                            @this.set('form.address', '');
                        }
                    });
                if(typeof google != 'undefined' && typeof google.maps.places != 'undefined'){

                    var options = {};
                    if (selectedCountry) {
                        options.componentRestrictions = { country: selectedCountry };
                    }
                    
                    if (searchOnlyCities == '1') {
                        options.types = ['(cities)'];
                    }

                    var autocompleteTutor = new google.maps.places.Autocomplete(tutorAddress, options);
                    google.maps.event.addListener(autocompleteTutor, 'place_changed', function () {
                        var place = autocompleteTutor.getPlace();
                        var address = place.formatted_address;
                        var lat = place.geometry.location.lat();
                        var lng = place.geometry.location.lng();
                        place.address_components?.forEach((item) => {
                            if (item.types.includes('country')) {
                                @this.set('form.countryName', item.short_name);
                            }
                        });
                        @this.set('form.address', address);
                        @this.set('form.lat', lat);
                        @this.set('form.lng', lng);
                    });
                }
            }
            initializePlaceApi();
        </script>
    @endif

    <script type="text/javascript">
        var component = '';
        document.addEventListener('livewire:navigated', function() {
                component = @this;
        },{ once: true });
        document.addEventListener('loadPageJs', (event) => {
                component.dispatch('initSelect2', {target:'.am-select2'});
                setTimeout(() => {
                    initializeDatePicker()
                    @if($enableGooglePlaces == '1')
                        initializePlaceApi()
                    @endif
                }, 500);

            })
    </script>
@endpush

@push('styles')
    @vite([
        'public/css/flatpicker.css',
        'public/css/flatpicker-month-year-plugin.css'
    ])
@endpush


