{{-- <div class="form-group">
    <div class="am-uploadoption">
        <div class="tk-draganddrop">
            <input class="form-control" name="file" type="file">
            <label for="at_upload_files" class="am-uploadfile">
                <span class="am-dropfileshadow">
                    <svg class="am-border-svg "><rect width="100%" height="100%" rx="12"></rect></svg>
                    <i class="am-icon-plus-02"></i>
                    <span class="am-uploadiconanimation">
                        <i class="am-icon-upload-03"></i>
                    </span>
                    Drop File Here
                </span>
                <em>
                    <i class="am-icon-export-03"></i>
                </em>
                <span>Drop file here or <i>click here</i> to upload <em>PNG, JPG (max. 800x400px)</em></span>
            </label>
        </div>
        <div class="am-uploadedfile">
            <img src='{{asset ("demo-content/quiz/demo.jpg")}}' alt="image">
            <span>Image name</span>
            <a href="#" class="am-delitem">
                <i class="am-icon-trash-02"></i>
            </a>
        </div>
    </div>
</div> --}}

<div class="form-group">
    <div class="am-uploadoption" x-data="{isUploading:false}" wire:key="uploading-media-{{ time() }}">
        <div class="tk-draganddrop"
            x-on:drop.prevent="isUploading = true; isDragging = false"
            wire:drop.prevent="$upload('questionMedia', $event.dataTransfer.files[0])">
            <x-text-input
                name="file"
                type="file"
                id="at_upload_media"
                x-ref="file_upload"
                accept="{{ join(',', array_map(function($ex){return('.'.$ex);}, array_merge($allowImgFileExt, $allowVideoExt))) }}"
                x-on:change="isUploading = true; $wire.upload('questionMedia', $refs.file_upload.files[0])"/>
            <label for="at_upload_media" class="am-uploadfile">
                <span class="am-dropfileshadow">
                    <i class="am-icon-plus-02"></i>
                    <span class="am-uploadiconanimation">
                        <i class="am-icon-upload-03"></i>
                    </span>
                    {{ __('general.drop_file_here') }}
                </span>
                <em>
                    <i class="am-icon-export-03"></i>
                </em>
                <span>{{ __('general.drop_file_here_or')}} <i> {{ __('general.click_here_file')}} </i> {{ __('general.to_upload') }} 
                    <em>{{ join(', ', $allowImgFileExt) }} (max. {{ $allowImageSize }} MB )</em>
                </span>
                <svg class="am-border-svg "><rect width="100%" height="100%" rx="12"></rect></svg>
            </label>
        </div>
    
        @if(!empty($questionMedia))
            <div class="am-uploadedfile" x-bind:class="{ 'am-dragfile' : isDragging, 'am-uploading' : isUploading }">
                @if($mediaType == 'image')
                    @if (method_exists($questionMedia,'temporaryUrl'))
                        <img src="{{ $questionMedia->temporaryUrl() }}">
                    @else
                        <img src="{{ url(Storage::url($questionMedia)) }}">
                    @endif
                @elseif($mediaType == 'video')
                    <a href="{{ url(Storage::url($questionMedia)) }}" data-vbtype="iframe" data-gall="gall" class="tu-themegallery tu-thumbnails_content">
                        <figure>
                            <img src="{{ asset('images/video.jpg') }}" alt="{{ __('profile.intro_video') }}">
                        </figure>
                        <i class="fas fa-play"></i>
                    </a>
                @endif
                @if (method_exists($questionMedia,'temporaryUrl'))
                    <span>{{ basename(parse_url($questionMedia->temporaryUrl(), PHP_URL_PATH)) }}</span>
    
                @else
                    <span>{{ basename(parse_url($questionMedia, PHP_URL_PATH)) }}</span>
                @endif
                <a href="#" wire:click.prevent="removeMedia('questionMedia')" class="am-delitem">
                    <i class="am-icon-trash-02"></i>
                </a>
            </div>
        @endif
        <x-quiz::input-error field_name='{{ $questionMedia }}' />
    </div>
</div>