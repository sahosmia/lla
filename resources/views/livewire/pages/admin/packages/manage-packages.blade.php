<div class="tb-manage-addons">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cards">
                    <div class="cards_header">
                        <div class="cards_header_heading">
                            <h4>{{ __('admin/general.lernen_addons') }}</h4>
                            <p>{{ __('admin/general.lernen_addons_desc') }}</p>
                        </div>
                        <div class="cards_header_btns">
                            <button class="tb-btn" wire:click="addNewPackage">{{ __('admin/general.add_new') }}</button>
                        </div>
                    </div>
                    <div class="cards_wrap">
                        <ul>
                            @foreach ($packages as $package)
                            <li>
                                <div class="cards_item {{ $package['type'] == 'external' ? 'cards_item-purchase' : '' }}">
                                    <figure>
                                        <img src="{{ 'https://lernen.amentotech.com/addons/'. $package['image'] }}" alt="{{ $package['name'] }}">
                                    </figure>
                                    <div class="cards_item_content">
                                        <h5>
                                            {{ $package['name'] }} 
                                            <span>{{ ucfirst($package['type']) }}</span>
                                            @if($package['type'] == 'external' && !empty($package['demo_url']))
                                                <em>{{ $package['price'] }}</em>
                                            @endif
                                        </h5>
                                        <p>{{ $package['description'] }}</p>
                                        <div class="cards_item_btns">
                                            @if($package['type'] == 'core' && $package['status'] == 'active' && !empty($package['demo_url']))
                                                <a class="tb-btnvtwo" href="{{ $package['demo_url'] }}" target="_blank">{{ __('admin/general.preview') }}</a>
                                            @elseif($package['type'] == 'external' && $package['status'] == 'active' && $package['version'] == 'lite')
                                                <a class="tb-btnvtwo" href="{{ $package['demo_url'] }}" target="_blank">{{ __('admin/general.upgrade') }}</a>
                                            @elseif($package['type'] == 'external' && $package['status'] == 'inactive' && !empty($package['demo_url']))
                                                <a class="tb-btnvtwo" href="{{ $package['demo_url'] }}" target="_blank">{{ __('admin/general.buy_now') }}</a>
                                            @elseif($package['status'] == 'active' && !empty($package['demo_url']))
                                                <a class="tb-btnvtwo" href="{{ $package['demo_url'] }}" target="_blank">{{ __('admin/general.preview') }}</a>
                                            @elseif($package['status'] != 'active' && empty($package['demo_url']))
                                                <button class="tb-btnvtwo btn-coming-soon" disabled>{{ __('admin/general.coming_soon') }}</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade tb-fileupload-modal" data-bs-backdrop="static" id="addNewPackageModal" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h5 class="modal-title" id="fileUploadModalLabel">{{ __('admin/general.upload_package_file') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="icon-x"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="am-insights_notice">
                        {!! __('admin/general.add_update_addon_warning') !!}
                        </div>
                        <form method="post" id="addon-form" enctype="multipart/form-data">
                            @csrf
                            <div class="am-insights_content_inner" role="alert">
                                <div>
                                    <strong class="tb-block">{{ __('admin/general.server_requirements') }}</strong>
                                    <ul class="tb-warning-list">
                                        <li>
                                            post_max_size = 512M
                                        </li>
                                        <li>
                                            upload_max_filesize = 512M
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <strong class="tb-block">{{ __('admin/general.current_server_values') }}</strong>
                                    <ul class="tb-warning-list">
                                        <li @class([
                                            'tk-successmsg' => $isPostMaxSizeValid,
                                            'tk-errormsg' => !$isPostMaxSizeValid
                                        ])>
                                            <i @class([
                                                'icon-check-circle' => $isPostMaxSizeValid,
                                                'icon-x-circle' => !$isPostMaxSizeValid
                                            ])></i>
                                            post_max_size = {{ $postMaxSize }}
                                        </li>
                                        <li @class([
                                            'tk-successmsg' => $isUploadMaxFilesizeValid,
                                            'tk-errormsg' => !$isUploadMaxFilesizeValid
                                        ])>
                                            <i @class([
                                                'icon-check-circle' => $isUploadMaxFilesizeValid,
                                                'icon-x-circle' => !$isUploadMaxFilesizeValid
                                            ])></i>
                                            upload_max_filesize = {{ $uploadMaxFilesize }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="am-insights_content_uploadfile">
                                <h6>{{ __('admin/general.choose_file') }}</h6>
                                <label for="file" class="tb-label">
                                    <div class="am-insights_content_uploadfile_icon">
                                        <i class="icon-upload-cloud"></i>
                                        <input type="file" name="file" onchange="updateFileName();" class="form-control" id="file" accept=".zip">
                                    </div>
                                    <p>{{ __('admin/general.click_here_to_upload') }}</p>
                                    <div wire:loading wire:target="file" style="display: none" class="tb-uploading">
                                        <span>{{ __('settings.uploading') }}</span>
                                    </div>
                                </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="tb-btn upload-addon-btn @if(!$isPostMaxSizeValid || !$isUploadMaxFilesizeValid) tb-btn_disabled @endif" onclick="submitAddon()">{{ __('admin/general.install') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function updateFileName(){
        const fileInput = document.getElementById('file');
        const fileName = fileInput.files[0].name;
        const paragraph = fileInput.parentElement.parentElement.querySelector('p');
        paragraph.innerHTML =  `<strong>${fileName}</strong>`;
    }
    function submitAddon(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        const fileInput = document.getElementById('file');
        jQuery('.am-insights_content_uploadfile').find('.text-danger').remove();
        
        if (!fileInput.files.length > 0) {
            jQuery('.am-insights_content_uploadfile').append('<span class="text-danger">{{ __("admin/general.select_addon_file") }}</span>');
            return false;
        }
        
        const formData = new FormData();
        formData.append('file', fileInput.files[0]);
        $.ajax({
            url: "{{ route('admin.packages.upload') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                jQuery('.upload-addon-btn').addClass('am-btn_disable');
                jQuery('.tb-uploading').show();
            },
            complete: function(){
                jQuery('.upload-addon-btn').removeClass('am-btn_disable');
                jQuery('.tb-uploading').hide();
            },
            success: function(response){
                jQuery('#addNewPackageModal').modal('hide');
                if(response.success){
                    showAlert({
                        message: response.message,
                        type: 'success'
                    });
                    setTimeout(() => {
                        window.location.href = "{{ route('admin.packages.installed') }}";
                    }, 500);
               } else {
                    showAlert({
                        message: response.message,
                        type: 'error'
                    });
               }
            },
            error: function(xhr, status, error){
                let message = '';
                try{
                    let jsonResp = JSON.parse(xhr.responseText);
                    message = jsonResp?.message;
                }catch(e){
                    let jsonMatch = xhr.responseText.match(/{.*}/);
                    if(jsonMatch){
                        let jsonResp = JSON.parse(jsonMatch[0]);
                        message = jsonResp?.message;
                    } else {
                        message = '{{ __("admin/general.addon_file_upload_error") }}';
                    }
                }
                jQuery('.am-insights_content_uploadfile').append(`<span class="text-danger">${message}</span>`);
            }
        });
    }
</script>
@endpush
