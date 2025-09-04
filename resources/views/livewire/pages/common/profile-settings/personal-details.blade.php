
<div class="am-profile-setting" wire:init="loadData" wire:key="@this">
    @slot('title')
        {{ __('profile.personal_details') }}
    @endslot
    @include('livewire.pages.common.profile-settings.tabs')
    <div class="am-userperinfo">
        <div class="am-title_wrap">
            <div class="am-title">
                <h2>{{ __('profile.personal_details') }}</h2>
                <p>{{ __('profile.personal_detail_desc') }}</p>
            </div>
        </div>
        <form wire:submit="updateInfo" class="am-themeform am-themeform_personalinfo">
            @if($isLoading)
                @include('skeletons.personal-details')
            @else
                <fieldset>
                    <div class="form-group">
                        <x-input-label for="name" class="am-important" :value="__('profile.full_name')" />
                        <div class="form-group-two-wrap">
                            <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.first_name')])>
                                <x-text-input wire:model="form.first_name" placeholder="{{ __('profile.first_name') }}" type="text"  autofocus autocomplete="name" />
                                <x-input-error field_name="form.first_name" />
                            </div>
                            <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.last_name')])>
                                <x-text-input wire:model="form.last_name" name="last_name" placeholder="{{ __('profile.last_name') }}" type="text"  autofocus autocomplete="name" />
                                <x-input-error field_name="form.last_name" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group @error('form.email') am-invalid @enderror">
                        <x-input-label for="email" class="am-important" :value="__('general.email')" />
                        <x-text-input wire:model="form.email" disabled id="email" name="email" type="email" class="block w-full mt-1"  autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                    <div class="form-group @error('form.phone_number') am-invalid @enderror">
                        <x-input-label for="phone_number" :value="__('general.phone_number')" :class="$isProfilePhoneMendatory ? 'am-important' : ''" />
                        <div class="form-control_wrap">
                            <x-text-input wire:model="form.phone_number" id="phone_number" placeholder="{{ __('general.enter_phone_number') }}" name="phone_number" type="text" class="block w-full mt-1"  autocomplete="phone_number" />
                            <x-input-error field_name="form.phone_number" />
                        </div>
                    </div>
                    <div class="form-group @error('form.gender') am-invalid @enderror">
                        <x-input-label for="gender" class="am-important" :value="__('profile.gender')" />
                        <div class="am-radiowrap">
                            <div class="am-radio">
                                <input wire:model="form.gender" type="radio" id="male" name="gender" value="male">
                                <label for="male">{{ __('profile.male') }}</label>
                            </div>
                            <div class="am-radio">
                                <input wire:model="form.gender" type="radio" id="female" name="gender" value="female">
                                <label for="female">{{__('profile.female')}}</label>
                            </div>
                            <div class="am-radio">
                                <input wire:model="form.gender" type="radio" id="not_specified" name="gender" value="not_specified">
                                <label for="not_specified">{{__('profile.not_specified')}}</label>
                            </div>
                        </div>
                        <x-input-error field_name="form.gender" />
                    </div>
                    @if(auth()->user()->role == 'tutor')
                        <div class="form-group">
                            <x-input-label for="tagline" class="am-important" :value="__('profile.tagline')" />
                            <div class="form-group-two-wrap">
                                <div @class(['am-invalid' => $errors->has('form.tagline'), 'form-control_wrap'])>
                                    <x-text-input wire:model="form.tagline" placeholder="{{ __('profile.tagline_placeholder') }}" type="text" />
                                    <x-input-error field_name="form.tagline" />
                                </div>
                            </div>
                        </div>
                        @if($isProfileKeywordsMendatory)
                            <div class="form-group">
                                <x-input-label for="keywords" :value="__('profile.meta_keywords')" />
                                <div class="form-group-two-wrap">
                                    <div @class(['am-invalid' => $errors->has('form.keywords'), 'form-control_wrap'])>
                                        <x-text-input wire:model="form.keywords" placeholder="{{ __('profile.meta_keywords_placeholder') }}" type="text" />
                                        <x-input-error field_name="form.keywords" />
                                    </div>  
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="form-group am-addressform">
                        <x-input-label for="address" class="am-important" :value="__('profile.address')" />
                        <div class="am-user-location form-group-two-wrap">
                            @if($enableGooglePlaces == '1')
                                <span class="form-control_wrap" @class(['am-invalid' => $errors->has('form.address')]) >
                                    <x-text-input wire:ignore.self value="{{ $form->address }}" id="user_address" placeholder="{{ __('profile.search_your_address') }}" type="text"  autofocus autocomplete="name" />
                                    <x-input-error field_name="form.address" />
                                </span>
                            @else
                                <div class="form-group-half @error('form.country') am-invalid @enderror">
                                    <x-input-label for="country" :value="__('profile.country')" />
                                    <span class="am-select" wire:ignore>
                                        <select class="am-select2" data-componentid="@this" data-live="true" data-searchable="true" id="user_country" data-wiremodel="form.country">
                                            <option value="">{{ __('profile.select_a_country') }}</option>
                                            @foreach ($countries as $country)
                                                <option  value={{ $country->id }} {{ $country->id == $form->country ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                    <x-input-error field_name="form.country" />
                                </div>
                                @if(!empty($form->country) && $states?->isNotEmpty())
                                    <div class="form-group-half @error('form.state') am-invalid @enderror">
                                        <x-input-label for="country_state" :value="__('profile.state')" />
                                        <span class="am-select">
                                            <select data-componentid="@this" class="am-select2" data-searchable="true" id="country_state" data-wiremodel="form.state">
                                                <option value="">{{ __('profile.select_a_state') }}</option>
                                                @foreach ($states as $state)
                                                    <option  value="{{ $state->id }}" {{ $state->id == $form->state ? 'selected' : '' }} >{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </span>
                                        <x-input-error field_name="form.state" />
                                    </div>
                                @endif
                                    <div class="form-group-half @error('form.city') am-invalid @enderror">
                                        <x-input-label for="city" :value="__('profile.city')" />
                                        <x-text-input wire:model="form.city" placeholder="{{ __('profile.city_placeholder') }}" type="text"  autofocus autocomplete="name" />
                                        <x-input-error field_name="form.city" />
                                    </div>
                                <div class="form-group-half @error('form.zipcode') am-invalid @enderror">
                                    <x-input-label for="Zip" :value="__('profile.zipcode')" />
                                    <x-text-input wire:model="form.zipcode" placeholder="{{ __('profile.zipcode_placeholder') }}" type="text"  autofocus autocomplete="name" />
                                    <x-input-error field_name="form.zipcode" />
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group @error('form.native_language') am-invalid @enderror">
                        <x-input-label for="language" class="am-important" :value="__('profile.native_language')" />
                        <div class="form-group-two-wrap am-nativelang">
                            <span class="am-select" wire:ignore>
                                <select data-componentid="@this" class="am-select2" data-searchable="true" id="native_language" data-wiremodel="form.native_language">
                                    <option value="">{{ __('profile.select_a_native_language') }}</option>
                                    @foreach ($languages as $language)
                                        <option  value="{{ $language }}" {{ $language == $form->native_language ? 'selected' : '' }} >{{ $language }}</option>
                                    @endforeach
                                </select>
                            </span>
                            <x-input-error field_name="form.native_language" />
                        </div>
                    </div>
                    <div class="form-group am-knowlanguages @error('form.user_languages') am-invalid @enderror">
                        <x-input-label for="Languages" class="am-important" :value="__('profile.language')" />
                        <div class="form-group-two-wrap am-nativelang">
                            <div id="user_lang" wire:ignore>
                                <span class="am-select am-multiple-select">
                                    <select data-componentid="@this" data-disable_onchange="true" class="languages am-select2" data-searchable="true" id="user_languages" data-wiremodel="form.user_languages" multiple >
                                        <option value="" disabled >{{ __('profile.language_placeholder') }}</option>
                                        @foreach ( $languages as $id => $language)
                                            <option value="{{ $id }}" @if( in_array( $id, $form->user_languages) ) selected @endif>{{ $language }}</option>
                                        @endforeach
                                    </select>
                                    <div class="languageList">
                                        @if (!empty( $form->user_languages))
                                            <ul class="tu-labels">
                                                @foreach ( $form->user_languages as $language_id )
                                                    <li><span>{{ $languages[$language_id] }} <a href="javascript:void(0);" class="removeSelectedLang" data-id="{{ $language_id }}"><i class="am-icon-multiply-02"></i></a></span></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </span>
                            </div>
                            <x-input-error field_name="form.user_languages" />
                        </div>
                    </div>
                    @if(setting('_ai_writer_settings.enable_on_profile_settings') == '1')
                        <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal" data-prompt-type="profile" data-parent-model-id="profile-popup" data-target-selector="#profile_desc" data-target-summernote="true">
                            <img src="{{ asset('images/ai-icon.svg') }}" alt="AI">
                            {{ __('general.write_with_ai') }}
                        </button>
                    @endif
                    <div class="form-group @error('form.description') am-invalid @enderror">
                        <x-input-label for="introduction" class="am-important" :value="__('profile.description')" />
                        <div class="am-editor-wrapper">
                            <div class="am-custom-editor am-custom-textarea" wire:ignore>
                                <textarea id="profile_desc" class="form-control" placeholder="{{ __('profile.description_placeholder') }}" data-textarea="profile_desc">{{ $form->description }}</textarea>
                                <span class="characters-count"></span>
                            </div>
                            <x-input-error field_name="form.description" />
                        </div>
                    </div>
                    <div class="form-group">
                        <x-input-label class="am-important" :value="__('profile.profile_photo')" />
                        <div class="am-uploadoption" x-data="{isUploading:false}" wire:key="uploading-img-{{ time() }}">
                            <div class="tk-draganddrop"
                                x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading }"
                                x-on:drop.prevent="isUploading = true;isDragging = false"
                                wire:drop.prevent="$dispatch('file-dropped', $event)">
                                <x-text-input
                                    name="file"
                                    type="file"
                                    id="at_upload_files"
                                    accept="{{ !empty($allowImgFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*' }}"
                                    x-on:change="isUploading = true; $wire.dispatch('file-dropped', {'dataTransfer' : { files :  $event.target.files}})"/>
                                <label for="at_upload_files" class="am-uploadfile">
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
                                    <span>{{ __('general.drop_file_here_or')}} <i>{{ __('general.click_here_file')}}</i> {{ __('general.to_upload') }} @if (!empty($fileExt))  <em>{{ $fileExt }} (max. {{ $imageFileSize }} mb)</em>@endif</span>
                                </label>

                            </div>
                            @if(!empty($form->image))
                                <div class="am-uploadedfile">
                                    <img src="{{ $form->isBase64 ? $form->image :  url(Storage::url($form->image )) }}" alt="{{ $form->imageName }}">
                                    @if( $form->isBase64 )
                                        <span>{{ $form->imageName }}</span>
                                    @else
                                        <span>{{ basename(parse_url(url(Storage::url($form->image)), PHP_URL_PATH)) }}</span>
                                    @endif
                                    <a href="#" wire:click.prevent="removeMedia('photo')" class="am-delitem">
                                        <i class="am-icon-trash-02"></i>
                                    </a>
                                </div>
                            @endif
                            <x-input-error field_name="form.image" />
                        </div>
                    </div>
                    @if(auth()->user()->role == 'tutor')
                        <div class="form-group">
                            <x-input-label :class="$isProfileVideoMendatory ? 'am-important' : ''" for="covervideo" :value="__('profile.intro_video')" />
                            <div class="am-uploadoption profile-img-alpine" x-data="{isUploading:false}" wire:key="uploading-video-{{ time() }}">
                                <div class="tk-draganddrop"
                                    x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading }"
                                    x-on:drop.prevent="isDragging = false; isUploading = true"
                                    wire:drop.prevent="$upload('introVideo', $event.dataTransfer.files[0])">
                                    <x-text-input
                                        name="file"
                                        type="file"
                                        id="at_upload_video"
                                        x-ref="file_upload"
                                        accept="{{ !empty($allowVideoFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowVideoFileExt)) : '*' }}"
                                        x-on:change="isUploading=true; $wire.upload('introVideo', $refs.file_upload.files[0])"/>
                                    <label for="at_upload_video" class="am-uploadfile">
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
                                        <span>{{ __('general.drop_file_here_or')}} <i>{{ __('general.click_here_file')}} </i> {{ __('general.to_upload') }} @if (!empty($vedioExt))  <em>{{ $vedioExt }} (max. {{ $videoFileSize }} mb)</em>@endif</span>
                                    </label>
                                </div>
                                @if(!empty($form->intro_video) || !empty($introVideo))
                                    @php
                                        $videoUrl = !$errors->has('introVideo') && !empty($introVideo) && method_exists($introVideo,'temporaryUrl') ? $introVideo->temporaryUrl() : url(Storage::url($form->intro_video));
                                    @endphp
                                    @if(!empty($videoUrl))
                                        <div class="am-uploadedfile">
                                            @if(!empty($form->intro_video))
                                                <a href="{{ url(Storage::url($form->intro_video)) }}" data-vbtype="iframe" data-gall="gall" class="tu-themegallery tu-thumbnails_content">
                                                    <figure>
                                                        <img src="{{ asset('images/video.jpg') }}" alt="{{ __('profile.intro_video') }}">
                                                    </figure>
                                                    <i class="fas fa-play"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0);" class="tu-thumbnails_content">
                                                    <figure>
                                                        <img src="{{ asset('images/video.jpg') }}" alt="{{ __('profile.intro_video') }}">
                                                    </figure>
                                                    <i class="fas fa-play"></i>
                                                </a>
                                            @endif
                                            <span>{{ basename($videoUrl, PHP_URL_PATH) }}</span>
                                            <a href="javascript:void(0);" wire:click.prevent="removeMedia('video')" class="am-delitem">
                                                <i class="am-icon-trash-02"></i>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                                <x-input-error field_name="form.intro_video" />
                                <x-input-error field_name="introVideo" />
                            </div>
                        </div>
                        @if (!empty(setting('_social.platforms')))
                            @foreach (setting('_social.platforms') as $platform)
                                <div class="form-group">    
                                    <x-input-label :value="$platform. ($platform == 'WhatsApp' ? ' number' : ' URL')" />
                                    <div class="form-control_wrap">
                                        <x-text-input wire:model="form.social_profiles.{{ $platform }}" placeholder="{{ __('profile.social_profile_placeholder', ['profile_name' => $platform, 'type' => $platform == 'WhatsApp' ? 'number' : 'URL']) }}" type="text"  autofocus autocomplete="name" />
                                        <x-input-error field_name="form.social_profiles.{{ $platform }}" />
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif
                    <div class="form-group am-form-btns">
                        <span>{{ __('profile.latest_changes_the_live') }}</span>
                        <x-primary-button wire:loading.class="am-btn_disable" wire:target="updateInfo">{{ __('general.save_update') }}</x-primary-button>
                    </div>
                </fieldset>
            @endif
        </form>
    </div>
    <div wire:ignore class="modal fade am-uploadimg_popup" id="cropedImage" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="am-modal-header">
                    <h2>{{ __('profile.profile_photo') }}</h2>
                    <span class="am-closeimagepopup">
                        <i class="am-icon-multiply-02"></i>
                    </span>
                </div>
                <div class="am-modal-body">
                    <div id="crop_img_area">
                        <div class="preloader-outer">
                            <div class="tk-preloader">
                                <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                            </div>
                        </div>
                    </div>
                    <div class="am-croppedimg_btns">
                        <button type="button" class="am-btn" id="croppedImage">{{ __('general.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
    @vite([
        'public/css/croppie.css',
        'public/summernote/summernote-lite.min.css',
        'public/css/venobox.min.css',
    ])
@endpush
@push('scripts')
@if($enableGooglePlaces == '1')
    <script async src="https://maps.googleapis.com/maps/api/js?key={{ $googleApiKey }}&libraries=places&loading=async&callback=initializePlaceApi"></script>
@endif
@endpush
@push('scripts')
    <script defer src="{{ asset('js/croppie.min.js')}}"></script>
    <script defer src="{{ asset('js/venobox.min.js')}}"></script>
    <script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>
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
                        var lat = place.geometry.location.lat()
                        var lng =place.geometry.location.lng()
                        place.address_components?.forEach((item) => {
                            if(item.types.includes('country')){
                                @this.set('form.countryName', item.long_name);
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
    <script type="text/javascript" data-navigate-once>
        var image_crop = '';
        var image_name = '';
        var component = '';
        var venoBox = '';
        document.addEventListener('livewire:navigated', function() {
            component = @this;
        });
        document.addEventListener('livewire:initialized', function() {
            Livewire.on('file-dropped', (event) => {
                image_crop = image_name = '';
                if (event.dataTransfer.files.length > 0) {
                    const files = event.dataTransfer.files;
                    image_name = files[0].name;
                    let fileExt         =  files[0].name.split('.').pop();
                        fileExt         = fileExt ? fileExt.toLowerCase() : '';
                    let fileSize        = files[0].size/1024;
                    let allowFileSize   = Number("{{$allowImageSize}}")*1024;
                    let allowFileExt    = @json($allowImgFileExt);

                    if( allowFileExt.includes(fileExt) && fileSize <= allowFileSize){
                        var reader,file,url;
                        if(!image_crop){
                            jQuery('#crop_img_area').croppie('destroy');
                            jQuery('#cropedImage').modal('show');
                            jQuery('#crop_img_area .preloader-outer').css({
                                display: 'block',
                                position: 'absolute',
                                background: 'rgb(255 255 255 / 98%)'
                            });
                            image_crop = jQuery('#crop_img_area').croppie({
                                viewport: {
                                    width: 300,
                                    height: 300,
                                    type:'square'
                                },
                                boundary:{
                                    width: 500,
                                    height: 300
                                }
                            });
                        }

                        if (files && files.length > 0) {
                            file = files[0];

                            var reader = new FileReader();

                            reader.onload = e => {
                                setTimeout(() => {
                                    image_crop.croppie('bind', {
                                        url: e.target.result
                                    });
                                    setTimeout(() => {
                                        jQuery('#crop_img_area .preloader-outer').css({ display: 'none'});
                                    }, 100);
                                }, 500);

                            }
                            reader.readAsDataURL(file);
                        }
                    } else {
                        let error_message = '';
                        if(!allowFileExt.includes(fileExt)){
                            error_message = "{{ __('validation.invalid_file_type', ['file_types' => join(',', array_map(function($ext){return('.'.$ext);},$allowImgFileExt)) ])}}";
                        }
                        else if(fileSize >= allowFileSize){
                            error_message = "{{ __('validation.max_file_size_err', [ 'file_size' => $allowImageSize.'MB' ])}}";
                        }
                        Alpine.nextTick(() => {
                            $(document).find('.tk-draganddrop').removeClass('am-uploading');
                        });
                        showAlert({
                            message     : error_message,
                            type        : 'error',
                            title       : "{{__('general.error_title')}}" ,
                            autoclose   : 1000,
                            redirectUrl : ''
                        });
                    }
                }
            });

            $(document).on("click", ".am-closeimagepopup", function(e){
                jQuery('#cropedImage').modal('hide');
                setTimeout(() => {
                    $(document).find('.tk-draganddrop').removeClass('am-uploading');
                    $('#at_upload_files').val('');
                    image_crop.croppie('destroy');
                }, 100);
            });

            $(document).on("click", "#croppedImage", function(e){
                e.preventDefault();
                image_crop.croppie('result', {type: 'base64', format: 'jpg'}).then(function(base64) {
                    component.set("form.image", base64, false);
                    component.set("form.isBase64", true, false);
                    component.set("form.imageName", image_name);
                });
                jQuery('#cropedImage').modal('hide');
                setTimeout(() => {
                    image_crop.croppie('destroy');
                }, 100);
            });

            $(document).on('summernote.change', '#profile_desc', function(we, contents, $editable) {
                component.set("form.description",contents, false);
            });

            document.addEventListener('profile-img-updated', (event) => {
                $('.userImg img').attr('src', event.detail.image);
            });

            document.addEventListener('loadPageJs', (event) => {
                component.dispatch('initSelect2', {target:'.am-select2'});
                setTimeout(() => {
                    @if($enableGooglePlaces == '1')
                        initializePlaceApi()
                    @endif
                    $('#profile_desc').summernote('destroy');
                    $('#profile_desc').summernote(summernoteConfigs('#profile_desc','.characters-count'));
                    venoBox = initVenobox();
                }, 500);
            })

            $(document).on("change", ".languages", function(e){
                component.set('form.user_languages', $(this).select2("val"), false);
                populateLanguageList();
            });

            $( "body" ).delegate( ".removeSelectedLang", "click", function() {
                let id = $(this).attr('data-id');
                var newArray = [];
                new_data = $.grep($('.languages').select2('data'), function (value) {
                    if(value['id'] != id)
                        newArray.push(value['id']);
                });
                $('.languages').val(newArray).trigger('change');
                populateLanguageList();
            });

            function populateLanguageList(){
                let languages = $('.languages').select2('data');
                var lang_html = '<ul class="tu-labels">';
                $.each(languages,function(index,elem){
                        lang_html += `<li><span>${elem.text} <a href="javascript:void(0);" class="removeSelectedLang" data-id="${elem.id}"><i class="am-icon-multiply-02"></i></a></span></li>`;
                });
                lang_html += '</ul>';
                $('.languageList').html(lang_html);
            }
        });
    </script>
@endpush
