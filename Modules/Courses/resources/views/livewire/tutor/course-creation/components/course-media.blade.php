<div class="cr-course-box" wire:init="loadData" wire:key="@this">
    <div class="cr-content-box">
        <h2>{{ __('courses::courses.media') }}</h2>
        <p>{{ __('courses::courses.select_category_upload') }}</p>
    </div>
    <form class="am-themeform">
        <fieldset>
            <div class="form-group">
                <x-input-label class="am-important" :value="__('courses::courses.add_course_thumbnail')" />
                <div class="am-uploadoption" x-data="{isUploading:false}" wire:key="uploading-thumbnail-{{ time() }}">
                    <div class="tk-draganddrop" wire:loading.class="am-uploading" wire:target="thumbnail" x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading }" x-on:drop.prevent="isUploading = true; isDragging = false" wire:drop.prevent="$dispatch('file-dropped', $event)">
                        <x-text-input name="file" type="file" id="at_upload_thumbnail" accept="{{ !empty($allowImgFileExt) ? join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*' }}" x-on:change="isUploading = true; $wire.dispatch('file-dropped', {'dataTransfer' : { files :  $event.target.files}})" />
                        <label for="at_upload_thumbnail" class="am-uploadfile">
                            <svg class="am-border-svg ">
                                <rect width="100%" height="100%"></rect>
                            </svg>
                            <span class="am-dropfileshadow">
                                <svg class="am-border-svg ">
                                    <rect width="100%" height="100%"></rect>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M3.33337 8.00016H8.00004M12.6667 8.00016H8.00004M8.00004 8.00016V3.3335M8.00004 8.00016V12.6668" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="am-uploadiconanimation">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M18.5 10.98V12.98C18.5 15.1891 16.7091 16.98 14.5 16.98H8.5C6.29086 16.98 4.5 15.1891 4.5 12.98V10.98" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                        <path d="M8.76953 9.23999L11.4995 6.49999L14.2295 9.23999" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M11.5 7.50998V12.98" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                {{ __('courses::courses.drop_image_here') }}
                            </span>
                            <em>
                                <i class="am-icon-export-03"></i>
                            </em>
                            <span>{{ __('courses::courses.drop_image_here_or') }} <i>{{ __('courses::courses.click_here') }}</i> {{ __('courses::courses.to_upload') }} 
                                @if (!empty($imageExtensions)) <em>{{ $imageExtensions }} (max. {{ round($imageSize/1000) }} MB)</em>@endif
                            </span>
                        </label>
                    </div>

                    @if (!empty($thumbnail))
                        <div class="cr-uploaded-status">
                            <div class="am-uploadedfile">
                                <a class="venobox tu-themegallery" data-gall="thumbnail" href="{{ Storage::url($thumbnail) }}" title="Thumbnail Preview">
                                    <img src="{{ $isBase64 ? $thumbnail : Storage::url($thumbnail) }}" alt="Thumbnail Preview">
                                </a>
                                @if( $isBase64 )
                                    <span>
                                        {{ $imageName.'.png' }}
                                        @if( !empty($uploadedThumbnailSize))
                                        <em>{{ $uploadedThumbnailSize }} KB</em>
                                        @endif
                                    </span>
                                    
                                @else
                                    <span>
                                        {{ basename(parse_url(Storage::url($thumbnail), PHP_URL_PATH)) }}
                                        @if( !empty($thumbnailSize))
                                        <em>{{ $thumbnailSize }}KB</em>
                                        @endif
                                    </span>
                                @endif
                                <a href="javascript:void(0);" wire:click.prevent="removeMedia('thumbnail')" class="am-delitem">
                                    <i class="am-icon-trash-02"></i>
                                </a>
                                <span class="am-uploadedfile-progess"></span>
                            </div>
                        </div>
                    @endif
                    <x-input-error field_name="thumbnail" />
                    
                    @if ($thumbnailError)
                        <span class="am-error-msg">{{ $thumbnailErrorMessage }}</span>
                    @endif
                </div>
            </div>

            <!-- Promotional Video Upload Section -->
            <div class="form-group">
                <x-input-label class="am-important" :value="__('courses::courses.add_promotional_video')" />
                <div class="am-uploadoption" x-data="{isUploading:false}" wire:key="uploading-video-{{ time() }}">
                    <div class="tk-draganddrop" x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading }" x-on:drop.prevent="isDragging = false; isUploading = true" wire:drop.prevent="$upload('promotionalVideo', $event.dataTransfer.files[0])">
                        <x-text-input name="file" type="file" id="at_upload_video" x-ref="file_upload" accept="{{ !empty($allowVideoFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowVideoFileExt)) : '*' }}" x-on:change="isUploading=true; $wire.upload('promotionalVideo', $refs.file_upload.files[0])" />
                        <label for="at_upload_video" class="am-uploadfile">
                            <svg class="am-border-svg ">
                                <rect width="100%" height="100%"></rect>
                            </svg>
                            <span class="am-dropfileshadow">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M3.33337 8.00016H8.00004M12.6667 8.00016H8.00004M8.00004 8.00016V3.3335M8.00004 8.00016V12.6668" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="am-uploadiconanimation">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M18.5 10.98V12.98C18.5 15.1891 16.7091 16.98 14.5 16.98H8.5C6.29086 16.98 4.5 15.1891 4.5 12.98V10.98" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                        <path d="M8.76953 9.23999L11.4995 6.49999L14.2295 9.23999" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M11.5 7.50998V12.98" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                {{ __('courses::courses.drop_video_here') }}
                            </span>
                            <em>
                                <i class="am-icon-export-03"></i>
                            </em>
                            <span>{{ __('courses::courses.drop_video_here_or') }} <i>{{ __('courses::courses.click_here') }}</i> {{ __('courses::courses.to_upload') }} 
                                @if (!empty($videoExtensions)) <em>{{ $videoExtensions }} (max. {{ round($videoSize/1000) }} MB)</em>@endif
                            </span>
                        </label>

                    </div>
                    @if (!empty($coursePromotionalVideo))
                        <div class="cr-uploaded-status">
                            <div class="am-uploadedfile">
                                <a href="{{ Storage::url($coursePromotionalVideo->path)  }}" data-gall="gall" data-vbtype="iframe" class="tu-themegallery tu-thumbnails_content">
                                    <figure>
                                        <img src="{{ asset('images/video.jpg') }}" alt="{{ __('courses::courses.promotional_video') }}">
                                    </figure>
                                    <i class="am-icon-play-filled"></i>
                                </a>
                                <span>
                                    {{ basename($coursePromotionalVideo->path) }}
                                    <em>{{ $promotionalVideoSize }} MB</em>
                                </span>
                                <a href="javascript:void(0);" wire:click.prevent="removeMedia('video')" class="am-delitem">
                                    <i class="am-icon-trash-02"></i>
                                </a>
                                <span class="am-uploadedfile-progess"></span>
                            </div>
                        </div>
                    @elseif(!empty($promotionalVideo))

                    <div class="am-uploadedfile">
                        {{-- <a href="javascript:void(0);" data-vbtype="iframe" class="tu-thumbnails_content">
                            <figure>
                                <img src="{{ asset('images/video.jpg') }}" alt="{{ __('courses::courses.promotional_video') }}">
                            </figure>
                            <i class="am-icon-play-filled"></i>
                        </a> --}}
                        <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M10.9636 1.33331H8.00065C6.26368 1.33331 5.39519 1.33331 4.6906 1.55547C3.19701 2.0264 2.02707 3.19634 1.55614 4.68992C1.33398 5.39452 1.33398 6.26301 1.33398 7.99998V7.99998C1.33398 9.73695 1.33398 10.6054 1.55614 11.31C2.02707 12.8036 3.19701 13.9736 4.6906 14.4445C5.39519 14.6666 6.26368 14.6666 8.00065 14.6666V14.6666C9.73762 14.6666 10.6061 14.6666 11.3107 14.4445C12.8043 13.9736 13.9742 12.8036 14.4452 11.31C14.6673 10.6054 14.6673 9.73695 14.6673 7.99998V7.25924M6.00065 7.33331L8.00065 9.33331L14.6673 2.66665" stroke="#079455" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        <span>{{ basename($promotionalVideo->getClientOriginalName()) }}</span>
                        <a href="javascript:void(0);" wire:click.prevent="removeMedia('video')" class="am-delitem">
                            <i class="am-icon-trash-02"></i>
                        </a>

                    </div>
                    @endif
                    <x-input-error field_name="promotionalVideo" />
                </div>
            </div>

        </fieldset>

        <div class="am-themeform_footer">
            <a href="{{ route('courses.tutor.edit-course', ['id' => $courseId, 'tab' => 'details']) }}" class="am-white-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M10.5 4.5L6 9L10.5 13.5" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                {{ __('courses::courses.back') }}
            </a>
            <button wire:click="store" type="button" class="am-btn" wire:loading.remove wire:target="store">{{ __('courses::courses.save_continue') }}</button>
            <button class="am-btn am-btn_disable" wire:loading.flex disable wire:target="store" this.form.submit();>{{ __('courses::courses.save_continue') }}</button>
        </div>

    </form>
    <div wire:ignore class="modal fade am-uploadimg_popup" id="cropedImage" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="am-modal-header">
                    <h2>{{ __('courses::courses.upload_thumbnail') }}</h2>
                    <span class="am-closepopup" data-bs-dismiss="modal">
                        <i class="am-icon-multiply-01"></i>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="am-white-btn" id="skipCropping">{{ __('courses::courses.skip') }}</button>
                    <button type="button" class="am-btn" id="croppedImage">{{ __('courses::courses.save') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    @vite([
        'public/css/croppie.css',
        'public/css/venobox.min.css'
    ])
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
@endpush

@push('scripts')
    <script defer src="{{ asset('js/croppie.min.js')}}"></script>
    <script defer src="{{ asset('js/venobox.min.js')}}"></script>

    <script type="text/javascript" data-navigate-once>
        var image_crop = '';
        var image_name = '';
        var component = '';
        var venoBox = '';
        var withoutCropImage = null;
        document.addEventListener('livewire:navigated', function() {
            component = @this;
        });
        window.onload = (event) => {
            jQuery(document).ready(function() {
                setTimeout(() => {
                    // VenoBox Video Popup
                    let venoBox = jQuery(".tu-themegallery").venobox({
                        spinner: 'cube-grid',
                    });
                }, 100);
            });
        }

        function croppedImageSize(base64){
            const byteString = atob(base64.split(',')[1]);
            const mimeString = base64.split(',')[0].split(':')[1].split(';')[0];
            const ab = new ArrayBuffer(byteString.length);
            const ia = new Uint8Array(ab);
            
            for (let i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }

            const blob = new Blob([ab], { type: mimeString });

            // Get file size in kilobytes (KB)
            const fileSizeInKB = (blob.size / 1000).toFixed(2);
            return fileSizeInKB;
        }

        document.addEventListener('livewire:initialized', function() {
            Livewire.on('file-dropped', (event) => {
                image_crop = image_name = '';
                if (event.dataTransfer.files.length > 0) {
                    const files = event.dataTransfer.files;
                    image_name = files[0].name.split('.');
                    let fileExt = files[0].name.split('.').pop();
                    fileExt = fileExt ? fileExt.toLowerCase() : '';
                    let fileSize = files[0].size / 1024;
                    let allowFileSize = Number("{{$imageSize}}");
                    
                    let fileExtJson = @json($imageExtensions);
                    let allowFileExt = fileExtJson.split(',');

                    if (allowFileExt.includes(fileExt) && fileSize <= allowFileSize) {
                        withoutCropImage = files[0];
                        var reader, file, url;
                        if (!image_crop) {
                            jQuery('#crop_img_area').croppie('destroy');
                            jQuery('#cropedImage').modal('show');
                            jQuery('#crop_img_area .preloader-outer').css({
                                display: 'block'
                                , position: 'absolute'
                                , background: 'rgb(255 255 255 / 98%)'
                            });
                            image_crop = jQuery('#crop_img_area').croppie({
                                viewport: {
                                    width: 500
                                    , height: 500
                                    , type: 'square'
                                }
                                , boundary: {
                                    width: 1000
                                    , height: 500
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
                                        jQuery('#crop_img_area .preloader-outer').css({
                                            display: 'none'
                                        });
                                    }, 100);
                                }, 200);
                            }
                            reader.readAsDataURL(file);
                            component.set('thumbnailError', false);
                            component.set('thumbnailErrorMessage', '');
                            
                            // Update the file size in the DOM
                            // document.getElementById('thumbnail-size').innerText = Math.round(file.size / 1024) + ' KB';
                        }
                    } else {
                        component.clearValidationErrors('thumbnail');
                        component.set('thumbnailError', true);
                        if (!allowFileExt.includes(fileExt)) {
                            component.set('thumbnailErrorMessage', "{{ __('courses::courses.invalid_file_type', ['file_types' => join(',', array_map(function($ext){return('.'.$ext);},explode(',', $imageExtensions))) ])}}");
                        } else if (fileSize >= allowFileSize) {
                            component.set('thumbnailErrorMessage', "{{ __('courses::courses.max_course_thumbnail_size_error', [ 'file_size' => (round($imageSize/1000)) ])}}");
                        }
                        Alpine.nextTick(() => {
                            $(document).find('.tk-draganddrop').removeClass('am-uploading');
                            $('#at_upload_thumbnail').val('');
                        });
                        
                        Alpine.nextTick(() => {
                            $(document).find('.tk-draganddrop').removeClass('am-uploading');
                            $('#at_upload_thumbnail').val('');
                        });
                    }
                }
            });

            $(document).on("click", ".am-closeimagepopup", function(e) {
                jQuery('#cropedImage').modal('hide');
                setTimeout(() => {
                    $(document).find('.tk-draganddrop').removeClass('am-uploading');
                    $('#at_upload_files').val('');
                    image_crop.croppie('destroy');
                }, 100);
            });

            $(document).on("click", "#skipCropping", function(e) {
                e.preventDefault();
                let reader = new FileReader();
                reader.readAsDataURL(withoutCropImage); 
                reader.onload = function () {
                    base64 = reader.result;
                    component.set("thumbnail", base64, false);
                    component.set("isBase64", true, false);
                    component.set("imageName", image_name);
                    let fileName = image_name.slice(0, -1).join('.');
                    component.set('imageName', fileName);
                    console.log(base64, image_name, fileName, croppedImageSize(base64));
                    component.set('uploadedThumbnailSize', croppedImageSize(base64));
                };
                jQuery('#cropedImage').modal('hide');
                setTimeout(() => {
                    image_crop.croppie('destroy');
                }, 100);
            });
            $(document).on("click", "#croppedImage", function(e) {
                e.preventDefault();
                image_crop.croppie('result', {
                    type: 'base64',
                    format: 'jpg'
                }).then(function(base64) {
                    component.set("thumbnail", base64, false);
                    component.set("isBase64", true, false);
                    component.set("imageName", image_name);
                    let fileName = image_name.slice(0, -1).join('.');
                    component.set('imageName', fileName);

                    component.set('uploadedThumbnailSize', croppedImageSize(base64));
                });
                jQuery('#cropedImage').modal('hide');
                setTimeout(() => {
                    image_crop.croppie('destroy');
                }, 100);
            });

            document.addEventListener('profile-img-updated', (event) => {
                $('.userImg img').attr('src', event.detail.image);
            });
        });
    </script>
@endpush
