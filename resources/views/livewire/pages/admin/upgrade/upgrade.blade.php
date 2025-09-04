<div class="am-insights am-upgradewrapper" x-data="{ uploading: false, progress: 0, fileName: '' }">
    <div class="am-insights_section am-revenue">
        <div class="am-insights_header">
            <div class="am-insights_title">
                <h2>{{ __('admin/general.lernen_upgrade') }}</h2>
                <p>{{ __('admin/general.lernen_upgrade_desc') }}</p>
            </div>
            <div class="am-insights_actions">
                <em>{{ __('admin/general.current_version') }}:</em>
                <span>
                    {{ $currentVersion }}
                </span>
            </div>
        </div>
        <div class="am-insights_notice">
            <p><strong>{!! __('admin/general.note') !!}</strong> <i class="text-warning">{!! __('admin/general.upgrade_warning', ['addons' => '<strong><a href="/admin/packages" class="text-danger">Manage Addons</a></strong>']) !!}</i></p>
        </div>
        <div class="am-insights_content am-upgrade">
            <form>
                <div class="am-insights_content_inner" role="alert">
                    <div>
                        <strong class="tb-block">{{ __('admin/general.server_requirements') }}</strong>
                        <ul class="tb-warning-list">
                            <li>post_max_size = 512M</li>
                            <li>upload_max_filesize = 512M</li>
                            <li>{{ __('admin/general.should_be_writable', ['path' => base_path()]) }}</li>
                            <li>{{ __('admin/general.should_be_writable', ['path' => base_path('vendor')]) }}</li>
                            <li>{{ __('admin/general.symlink_should_be_enabled') }}</li>
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
                            <li @class([
                                'tk-successmsg' => is_writable(base_path()),
                                'tk-errormsg' => !is_writable(base_path())
                            ])>
                                <i @class([
                                    'icon-check-circle' => is_writable(base_path()),
                                    'icon-x-circle' => !is_writable(base_path())
                                ])></i>
                                {{ __('admin/general.should_be_writable', ['path' => base_path()]) }}
                            </li>
                            <li @class([
                                'tk-successmsg' => is_writable(base_path('vendor')),
                                'tk-errormsg' => !is_writable(base_path('vendor'))
                            ])>
                                <i @class([
                                    'icon-check-circle' => is_writable(base_path('vendor')),
                                    'icon-x-circle' => !is_writable(base_path('vendor'))
                                ])></i>
                                {{ __('admin/general.should_be_writable', ['path' => base_path('vendor')]) }}
                            </li>
                            <li @class([
                                'tk-successmsg' => $symlinkAllowed,
                                'tk-errormsg'   => !$symlinkAllowed
                            ])>
                                <i @class([
                                    'icon-check-circle' => $symlinkAllowed,
                                    'icon-x-circle' => !$symlinkAllowed
                                ])></i>
                                {{ __('admin/general.symlink_enabled') }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="am-insights_content_uploadfile"
                    x-on:livewire-upload-start="uploading = true"
                    x-on:livewire-upload-cancel="uploading = false"
                    x-on:livewire-upload-error="uploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress;"
                >
                    <h6>{{ __('admin/general.choose_file') }}</h6>
                    <label for="file" class="tb-label">
                        <div class="am-insights_content_uploadfile_icon">
                            <i class="icon-upload-cloud"></i>
                            <input type="file" class="form-control" id="file" wire:model="file" accept=".zip" x-on:change="fileName = $el.files[0].name">
                        </div>
                        <p>{{ __('admin/general.upload_upgrade_file') }}</p>
                    </label>
                    <div class="am-uploadedfile" x-cloak x-show="uploading"> 
                        @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                        <div class="uploadbar-wrap">
                            <span x-text="fileName" class="uploaded-zip"></span>
                            <div class="uploadbar progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style="{width: progress + '%'}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-text="progress + '%'"></div>
                                <button type="button" wire:click="$cancelUpload('file')"><i class="fa fa-times"></i></button>  
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="tb-btn am-insights_btn @empty($file) tb-btn_disabled @endempty @if(!$isPostMaxSizeValid || !$isUploadMaxFilesizeValid || !$symlinkAllowed || !is_writable(base_path())) tb-btn_disabled @endif" wire:loading.class="tb-btn_disable" wire:click="upgradeLernen">{{ __('admin/general.upgrade') }}</button>
            </form>
            @if($validationErrors)
            <div class="error-messages">
                <ul>
                    @foreach($validationErrors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
