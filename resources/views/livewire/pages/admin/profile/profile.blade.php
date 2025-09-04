<main class="tb-main">
    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="la-payment-methods">
                <div class="la-adminp-title">
                    <h6>{{ __('admin/general.profile_title') }}</h6>
                </div>
                <div class="la-admin-profile">
                    <div class="la-admin-imgarea la-image-sec">
                        @if (!empty($cropImageUrl))
                            <img src="{{ $cropImageUrl }}">
                        @elseif(!empty($old_image))
                            <img src="{{ url(Storage::url($old_image))  }}" alt="">
                        @else
                            <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 132, 132) }}" alt="">
                        @endif
                        <div class="tb-adminprofo">
                            <h4>{{ __('admin/general.upload_profile_photo') }}</h4>
                            <p>{{ __('admin/general.profile_image_size_err', ['file_size' => $allowImageSize . 'MB', 'file_types' => implode(', ', $allowImageExt)]) }}</p>
                            <div wire:ignore class="la-delete-img">
                                <input id="upload_image" type="file" accept="{{ join(',', array_map(function($ext){return('.'.$ext);},$allowImageExt)) }}" >
                                <label for="upload_image">{{ __('admin/general.upload_photo') }}</label>
                                <a href="javascript:void(0)" wire:click.prevent="removePhoto" ><i class="icon-trash-2 lb-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="la-admin-infomation">
                        <form class="la-themeform">
                            <div class="form-group-wrap">
                                <div class="form-group form-group-3half">
                                    <label class="la-titleinput">{{ __('admin/general.first_name') }}</label>
                                    <input type="text" wire:model.defer="first_name" class="form-control @error('first_name') lb-invalid @enderror" placeholder="{{ __('admin/general.name_placeholder') }}">
                                    @error('first_name')
                                        <div class="lb-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-3half">
                                    <label class="la-titleinput">{{ __('admin/general.last_name') }}</label>
                                    <input type="text" wire:model.defer="last_name" class="form-control @error('last_name') lb-invalid @enderror" placeholder="{{ __('admin/general.lastname_placeholder') }}">
                                    @error('last_name')
                                        <div class="lb-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-3half ">
                                    <label class="la-titleinput">{{ __('admin/general.email') }}</label>
                                    <input type="email" wire:model.defer="email" class="form-control @error('email') lb-invalid @enderror" placeholder="{{ __('admin/general.email_placeholder') }}">
                                    @error('email')
                                        <div class="lb-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-3half ">
                                    <label class="la-titleinput">{{ __('admin/general.current_password') }}</label>
                                    <input type="password" wire:model.defer="current_password" class="form-control @error('current_password') lb-invalid @enderror" placeholder="{{ __('admin/general.current_password_placeholder') }}">
                                    @error('current_password')
                                        <div class="lb-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-3half ">
                                    <label class="la-titleinput">{{ __('admin/general.password') }}</label>
                                    <input type="password" wire:model.defer="new_password" class="form-control @error('new_password') lb-invalid @enderror" placeholder="{{ __('admin/general.password_placeholder') }}">
                                    @error('new_password')
                                        <div class="lb-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-3half ">
                                    <label class="la-titleinput">{{ __('admin/general.confirm_password') }}</label>
                                    <input type="password" wire:model.defer="confirm_password" class="form-control @error('confirm_password') lb-invalid @enderror" placeholder="{{ __('admin/general.confirm_password') }}">
                                    @error('confirm_password')
                                        <div class="lb-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="la-updatesave-btn">
                                        <a href="javascript:void(0);" wire:click.prevent="update" class="la-btn-lg">{{ __('admin/general.setting_save') }}</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade lb-uploadprofile" id="la_phrofile_photo" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered lb-modaldialog" role="document">
                <div class="modal-content">
                    <div class="lb-popuptitle">
                        <h4> {{ __('admin/general.crop_profile_photo') }} </h4>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body" id="tk_add_education_frm">
                        <div id="crop_img_area">
                            <div class="preloader-outer">
                                <div class="lb-preloader">
                                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                                </div>
                            </div>
                        </div>
                        <div class="lb-form-btn">
                            <div class="lb-savebtn lb-dhbbtnarea ">
                                <a href="javascript:void(0);" id="croppedImage" class="tb-btn">{{__('admin/general.save_update')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade lb-addonpopup" id="la_phrofile_photo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered lb-modaldialog" role="document">
            <div class="modal-content">
                <div class="lb-popuptitle">
                    <h4> {{ __('admin/general.crop_profile_photo') }} </h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body" id="tk_add_education_frm">
                    <div id="crop_img_area">
                        <div class="preloader-outer">
                            <div class="lb-preloader">
                                <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('styles')
    @vite([
        'public/css/croppie.css',
    ])
@endpush

@push('scripts')
<script defer src="{{ asset('js/croppie.min.js')}}"></script>
<script>
    var image_crop = '';
    $(document).on("change", "#upload_image", function(e) {
        var files = e.target.files;

        let fileExt = files[0].name.split('.').pop();
        fileExt = fileExt ? fileExt.toLowerCase() : '';
        let fileSize = files[0].size / 1024;
        let allowFileSize = Number("{{$allowImageSize}}") * 1024;
        let allowFileExt = `${{!! !empty($allowImageExt) ? json_encode($allowImageExt) : '' !!}}`;
        allowFileExt = allowFileExt.split(',');

        if (allowFileExt.includes(fileExt) && fileSize <= allowFileSize) {

            $('#la_phrofile_photo').modal('show');
                jQuery('#la_phrofile_photo .modal-body .preloader-outer').css({
                    display: 'block',
                    position: 'absolute',
                    background: 'rgb(255 255 255 / 98%)'
                });

                var reader, file, url;

                if (!image_crop) {
                    image_crop = jQuery('#crop_img_area').croppie({
                        viewport: {
                            width: 300,
                            height: 300,
                            type: 'square'
                        },
                        boundary: {
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
                                jQuery('#la_phrofile_photo .modal-body .preloader-outer').css({
                                    display: 'none'
                                });
                            }, 100);

                        }, 500);

                    }
                    reader.readAsDataURL(file);
                }
            } else {
                let error_message = '';
                if (!allowFileExt.includes(fileExt)) {
                    error_message = "{{ __('general.invalid_file_type', ['file_types' => join(', ', array_map(function($ext){return('.'.$ext);},$allowImageExt)) ])}}";
                } else if (fileSize >= allowFileSize) {
                    error_message = "{{ __('general.max_file_size_err', [ 'file_size' => $allowImageSize.'MB' ])}}";
                }
                showAlert({
                    message: error_message,
                    type: 'error',
                    title: "{{__('general.error_title')}}",
                    autoclose: 1000,
                    redirectUrl: ''
                });
            }
            e.target.value = '';
        });
        $(document).on("click", "#croppedImage", function(e) {
            image_crop.croppie('result', {
                type: 'base64',
                format: 'jpg'
            }).then(function(base64) {
                @this.set('cropImageUrl', base64);
            });

            jQuery('#la_phrofile_photo').modal('hide');
        });
</script>
@endpush

