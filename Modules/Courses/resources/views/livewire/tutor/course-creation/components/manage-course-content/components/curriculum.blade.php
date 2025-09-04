<div>
    <div @if(count($curriculumItems) > 1) wire:sortable="updateCurriculumOrder" @endif class="cr-sortable">
        @foreach ($curriculumItems as $key => $curriculumItem)
            <div class="cr-curriculum-item" wire:key="{{ $curriculumItem->id . 'curriculum' }}" @if(count($curriculumItems) > 1) wire:sortable.item="{{ $curriculumItem->id }}" @endif>
                <div class="cr-contentbox-area">
                    <div class="cr-contentbox">
                        @if(count($curriculumItems) > 1)
                            <span wire:sortable.handle class="cr-drag">
                                <i class="am-icon-youtube-1"></i>
                            </span>
                        @endif
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16"
                                fill="none">
                                <path
                                    d="M5.3125 8.3125L6.875 9.875L10.3125 6.4375M13.75 8C13.75 11.4518 10.9518 14.25 7.5 14.25C4.04822 14.25 1.25 11.4518 1.25 8C1.25 4.54822 4.04822 1.75 7.5 1.75C10.9518 1.75 13.75 4.54822 13.75 8Z"
                                    stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="cr-contentbox_title">
                            {{ $curriculumItem->title }}
                        </span>
                        <div class="am-itemdropdown">
                            <a href="javascript:void(0);" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                                        fill="none">
                                        <path
                                            d="M2.62484 5.54166C1.82275 5.54166 1.1665 6.19791 1.1665 6.99999C1.1665 7.80207 1.82275 8.45832 2.62484 8.45832C3.42692 8.45832 4.08317 7.80207 4.08317 6.99999C4.08317 6.19791 3.42692 5.54166 2.62484 5.54166Z"
                                            fill="#585858" />
                                        <path
                                            d="M11.3748 5.54166C10.5728 5.54166 9.9165 6.19791 9.9165 6.99999C9.9165 7.80207 10.5728 8.45832 11.3748 8.45832C12.1769 8.45832 12.8332 7.80207 12.8332 6.99999C12.8332 6.19791 12.1769 5.54166 11.3748 5.54166Z"
                                            fill="#585858" />
                                        <path
                                            d="M5.5415 6.99999C5.5415 6.19791 6.19775 5.54166 6.99984 5.54166C7.80192 5.54166 8.45817 6.19791 8.45817 6.99999C8.45817 7.80207 7.80192 8.45832 6.99984 8.45832C6.19775 8.45832 5.5415 7.80207 5.5415 6.99999Z"
                                            fill="#585858" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li wire:click="editCurriculumModal({{ $curriculumItem }})">
                                    <a href="javascript:void(0);">
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path
                                                    d="M16.6663 17.5H3.33301M13.333 3.33335C13.1247 4.79169 14.3747 6.04169 15.833 5.83335M5.83301 13.3334L6.23639 11.7198C6.39642 11.0797 6.47644 10.7596 6.60511 10.4612C6.71935 10.1963 6.86191 9.9445 7.03031 9.71024C7.22 9.44637 7.45328 9.21309 7.91985 8.74653L13.7498 2.91667C14.4401 2.22633 15.5594 2.22635 16.2498 2.91671V2.91671C16.9401 3.60706 16.9401 4.7263 16.2497 5.41663L10.4198 11.2465C9.95327 11.7131 9.71999 11.9464 9.45612 12.1361C9.22187 12.3045 8.97008 12.447 8.70515 12.5612C8.40675 12.6899 8.08669 12.7699 7.44657 12.93L5.83301 13.3334Z"
                                                    stroke="#585858" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </i>
                                        {{ __('courses::courses.edit') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="cr-delete-curriculum" data-id="{{ $curriculumItem->id }}" data-component_id="@this">
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path
                                                    d="M3.33317 4.16669L3.82396 12.5101C3.9375 14.4402 3.99427 15.4053 4.37553 16.1521C4.79523 16.9742 5.48635 17.6259 6.3317 17.9966C7.09962 18.3334 8.06636 18.3334 9.99984 18.3334V18.3334C11.9333 18.3334 12.9001 18.3334 13.668 17.9966C14.5133 17.6259 15.2044 16.9742 15.6241 16.1521C16.0054 15.4053 16.0622 14.4402 16.1757 12.5101L16.6665 4.16669M3.33317 4.16669H1.6665M3.33317 4.16669H16.6665M16.6665 4.16669H18.3332M13.3332 4.16669L13.0469 3.30774C12.8502 2.71763 12.7518 2.42257 12.5694 2.20442C12.4083 2.01179 12.2014 1.86268 11.9677 1.77077C11.7031 1.66669 11.3921 1.66669 10.77 1.66669H9.22966C8.60762 1.66669 8.29661 1.66669 8.03197 1.77077C7.79828 1.86268 7.5914 2.01179 7.4303 2.20442C7.24788 2.42257 7.14952 2.71763 6.95282 3.30774L6.6665 4.16669M8.33317 8.33335V14.1667M11.6665 8.33335V11.6667"
                                                    stroke="#585858" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </i>
                                        {{ __('courses::courses.delete') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @if (empty($activeCurriculumItem) || $activeCurriculumItem['id'] !== $curriculumItem->id)
                        <div class="cr-actionbox">
                            <button wire:click="updateActiveCurriculumItem({{ $curriculumItem }})" type="submit" class="am-btn" wire:loading.attr="disabled" wire:target="updateActiveCurriculumItem({{ $curriculumItem }})" wire:loading.class="am-btn_disable">
                                <svg wire:loading.remove wire:target="updateActiveCurriculumItem({{ $curriculumItem }})" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                                    fill="none">
                                    <path
                                        d="M2.91602 6.99984H6.99935M11.0827 6.99984H6.99935M6.99935 6.99984V2.9165M6.99935 6.99984V11.0832"
                                        stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                {{ __('courses::courses.view_content') }}
                            </button>
                        </div>
                    @endif
                </div>
                @if(!empty($activeCurriculumItem) && $activeCurriculumItem['id'] === $curriculumItem->id)
                    <div class="cr-curriculum-content">
                        <p>{{ __('courses::courses.select_main_content_type') }}</p>
                        <ul>
                            <li wire:click="updateCurriculumType('video')" wire:target="updateCurriculumType('video')" wire:loading.class="am-btn_disable" class="{{ in_array($activeCurriculumItem['type'], ['video', 'yt_link', 'vm_link']) ? 'cr-active' : '' }}">
                                <div class="cr-curriculum-btnconten">
                                    <figure>
                                        <img src="{{ asset('modules/courses/images/video-icon.png') }}" alt="icon" />
                                    </figure>
                                    <span>{{ __('courses::courses.video') }}</span>
                                </div>
                            </li>
                            <li wire:click="updateCurriculumType('article')" wire:target="updateCurriculumType('article')" wire:loading.class="am-btn_disable" class="{{ $activeCurriculumItem['type'] === 'article' ? 'cr-active' : '' }}">
                                <div class="cr-curriculum-btnconten">
                                    <figure>
                                        <img src="{{ asset('modules/courses/images/document-icon.png') }}" alt="icon" />
                                    </figure>
                                    <span>{{ __('courses::courses.write_article') }}</span>
                                </div>
                            </li>
                            <li>
                                <div class="cr-curriculum-btnconten">
                                    <figure>
                                        <img src="{{ asset('modules/courses/images/live-icon.png') }}" alt="icon" />
                                    </figure>
                                    <span>{{ __('courses::courses.live') }}</span>
                                </div>
                                <span class="cr-tag">{{ __('courses::courses.coming_soon') }}</span>
                            </li>
                        </ul>
                        @if($activeCurriculumItem['type'] === 'article')
                            <div class="form-group @error('article_content') cr-invalid @enderror">
                                <div wire:ignore class="am-editor-wrapper">
                                    <div class="am-custom-editor am-custom-textarea">
                                        <textarea 
                                            id="article_content-{{ $activeCurriculumItem['id'] }}" 
                                            data-id="@this" data-model_id="article_content" 
                                            class="form-control cr-summernote"
                                            placeholder="{{ __('courses::courses.enter_content') }}"
                                            x-init="$nextTick(() => {
                                                $('#article_content-{{ $activeCurriculumItem['id'] }}').summernote(summernoteConfigs('#article_content-{{ $activeCurriculumItem['id'] }}', '.characters-count'));
                                                let content = `{{ $activeCurriculumItem['article_content'] }}`;
                                                var charLength = $('<div>').html(content)?.text()?.length;
                                                let charSelector = '.characters-count';
                                                charLeft(charLength, charSelector)
                                                $('#article_content-{{ $activeCurriculumItem['id'] }}').summernote('code', content);
                                            });"
                                            x-data="{}"></textarea>
                                        <span class="characters-count"></span>
                                    </div>
                                </div>
                                <x-input-error field_name='article_content' />
                            </div>
                        @elseif( in_array($activeCurriculumItem['type'], ['video', 'yt_link', 'vm_link']) )
                            <div class="am-upload-options" wire:key="media-options-{{ $section->id }}">
                                <h6 class="am-important">{{ __('courses::courses.video') }}</h6>
                                @if(!empty(setting('_course.allow_video_types')))
                                    @php
                                        $allowedTypes = (array) setting('_course.allow_video_types', []);
                                    @endphp
                                    @if (in_array('video_file', $allowedTypes))
                                    <div class="am-radio">
                                        <input type="radio" id="video-{{ $section->id }}" name="media_type" value="video" wire:model.live="activeCurriculumItem.type" />
                                        <label for="video-{{ $section->id }}">{{ __('courses::courses.video_file') }}</label>
                                    </div>
                                    @endif
                                    @if (in_array('youtube_link', $allowedTypes))
                                    <div class="am-radio">
                                        <input type="radio" id="yt_link-{{ $section->id }}" name="media_type" value="yt_link" wire:model.live="activeCurriculumItem.type" />
                                        <label for="yt_link-{{ $section->id }}">{{ __('courses::courses.youtube_link') }}</label>
                                    </div>
                                    @endif
                                    @if (in_array('vimeo_link', $allowedTypes))
                                    <div class="am-radio">
                                        <input type="radio" id="vimeo-link-{{ $section->id }}" name="media_type" value="vm_link" wire:model.live="activeCurriculumItem.type" />
                                        <label for="vimeo-link-{{ $section->id }}">{{ __('courses::courses.vimeo_link') }}</label>
                                    </div>
                                    @endif
                                @else
                                    <h6 class="cr-tag">
                                       {{ __('courses::courses.allow_video_type') }}
                                    </h6>
                                @endif
                            </div>

                            @if($activeCurriculumItem['type'] === 'video')
                                @if(empty($curriculumVideo) && (empty($curriculumItem->media_path) || empty(Storage::disk(getStorageDisk())->exists($curriculumItem->media_path))))
                                    <div wire:loading.remove wire:target="curriculumVideo" class="form-group" id="video-upload-section" wire:ignore.self>
                                        <label for="at_upload_video{{ $activeCurriculumItem['id'] }}" class="am-uploadfile">
                                            <svg class="am-border-svg ">
                                                <rect width="100%" height="100%"></rect>
                                            </svg>
                                            <input type="file" id="at_upload_video{{ $activeCurriculumItem['id'] }}" wire:model="curriculumVideo"
                                                accept="{{ !empty($allowVideoFileExt)? join(',',array_map(function ($ex) {return '.' . $ex;}, $allowVideoFileExt)): '*' }}">
                                            <span class="am-dropfileshadow">
                                                <span class="am-uploadiconanimation">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M18.5 10.98V12.98C18.5 15.1891 16.7091 16.98 14.5 16.98H8.5C6.29086 16.98 4.5 15.1891 4.5 12.98V10.98" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                                        <path d="M8.76953 9.23999L11.4995 6.49999L14.2295 9.23999" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M11.5 7.50998V12.98" stroke="#585858" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                                                    </svg>
                                                </span>
                                                {{ __('courses::courses.drop_image_here_or') }}
                                            </span>
                                            <em>
                                                <i class="am-icon-export-03"></i>
                                            </em>
                                            <span>{{ __('courses::courses.drop_video_file_here_or') }}
                                                <strong>{{ __('courses::courses.click_here') }} </strong>
                                                @if (!empty($allowVideoFileExt))
                                                    <span><em>{{ join(', ', array_map(function($ex){return('.'.$ex);}, $allowVideoFileExt)) }} (max. {{ $videoFileSize }} MB)</em></span>
                                                @endif
                                            </span>
                                        </label>
                                    </div>
                                    <div wire:loading wire:target="curriculumVideo" class="am-uploadedfile am-noborder">
                                        <figure>
                                        </figure>
                                    </div>
                                @elseif( 
                                    !empty($curriculumVideo) || 
                                    ( !empty($curriculumItem->media_path) && !empty(Storage::disk(getStorageDisk())->exists($curriculumItem->media_path))) 
                                    )
                                    <div class="am-uploadedfile">
                                        <figure>
                                            <div class="cr-expert-video cr-custom-video">
                                                <video class="video-js d-none" data-setup='{}' onloadeddata="let player = videojs(this); player.removeClass('d-none'); @this.set('duration', Math.round(this.duration), false);" preload="auto" id="video-{{ $section->id .'_'. $curriculumItem->id }}" width="320" height="240"
                                                    controls>
                                                    <source
                                                        src="{{ !empty($curriculumItem->media_path) ? Storage::url($curriculumItem->media_path) : (is_object($curriculumVideo) ? $curriculumVideo->temporaryUrl() : '') }}"
                                                        wire:key="profile-video-src-{{ $curriculumItem->id . time() }}"
                                                        type="video/mp4">
                                                </video>
                                            </div>
                                        </figure>
                                    </div>
                                @endif
                            @elseif($activeCurriculumItem['type'] === 'yt_link')
                                <div id="yt_link-input-section" class="form-group" 
                                    x-data="{
                                        onYouTubeIframeAPIReady(videoId){
                                            console.log('videoId: ' + videoId);
                                            const ytPlayer = new YT.Player(`yt-video-${videoId}`, {
                                            events: {
                                                    onReady: function (event) {
                                                        const ytVideoDuration = event.target.getDuration();
                                                        console.log('evt', ytVideoDuration, event);
                                                        @this.set('duration', Math.round(ytVideoDuration), false);
                                                    },
                                                },
                                        });
                                        },
                                    }">
                                    <input 
                                        type="text"
                                        class="form-control @error('yt_link') is-invalid @enderror" 
                                        placeholder="{{ __('courses::courses.enter_youtube_link') }}" 
                                        wire:model.live.debounce.500ms="yt_link">
                                    @error('yt_link') <span class="text-danger">{{ $message }}</span> @enderror

                                    @php
                                        $videoId = '';
                                        if (preg_match('/v=([^&]+)/', $yt_link, $matches)) {
                                            $videoId = $matches[1];
                                        }
                                    @endphp
                                    @if ($videoId)
                                        <iframe
                                            class="am-iframe-video"
                                            id="yt-video-{{ $curriculumItem->id }}"
                                            src="https://www.youtube.com/embed/{{ $videoId }}?enablejsapi=1"
                                            frameborder="0"
                                            allowfullscreen
                                            x-on:load="onYouTubeIframeAPIReady('{{ $curriculumItem->id }}')"
                                            wire:key="profile-video-src-{{ $curriculumItem->id . time() }}">
                                        </iframe>
                                    @endif
                                </div>
                            @elseif($activeCurriculumItem['type'] === 'vm_link')
                                <div id="vm_link-input-section" class="form-group" 
                                    x-data="{
                                        onVimeoIframeAPIReady(videoId){
                                            console.log('videoId: ' + videoId);
                                            if(jQuery('#vm-video-{{ $curriculumItem->id }}')?.length){
                                                const vimeoPlayer = new Vimeo.Player(`vm-video-{{ $curriculumItem->id }}`);
                                                vimeoPlayer.on('loaded', function() {
                                                    vimeoPlayer.getDuration().then(function(duration) {
                                                        console.log('evt', duration, videoId);
                                                        @this.set('duration', Math.round(duration), false);
                                                    }).catch(function(error) {
                                                        console.log('error', error);
                                                    });
                                                });
                                            }
                                        },
                                    }">
                                    <input 
                                        type="text" 
                                        class="form-control @error('vm_link') is-invalid @enderror" 
                                        placeholder="{{ __('courses::courses.enter_vimeo_link') }}" 
                                        wire:model.live.debounce.500ms="vm_link">
                                    @error('vm_link') <span class="text-danger">{{ $message }}</span> @enderror

                                    @php
                                        $videoId = '';
                                        if (preg_match('/vimeo\.com\/(\d+)/', $vm_link, $matches)) {
                                            $videoId = $matches[1];
                                        }
                                    @endphp
                                    @if ($videoId)
                                    <iframe
                                        id="vm-video-{{ $curriculumItem->id }}"
                                        class="am-iframe-video"
                                        src="https://player.vimeo.com/video/{{ $videoId }}?api=1&player_id=vm-video-{{ $curriculumItem->id }}"
                                        frameborder="0"
                                        x-on:load="onVimeoIframeAPIReady('{{ $curriculumItem->id }}')"
                                        allowfullscreen
                                        wire:key="profile-video-src-{{ $curriculumItem->id . time() }}"></iframe>
                                    @endif
                                </div>
                            @endif
                        @endif
                        @error('curriculumVideo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="cr-btns">
                            <div class="cr-preview">
                                <label for="preview" class="cr-label">{{ __('courses::courses.preview') }}</label>
                                <input type="checkbox" id="preview" class="cr-toggle" wire:model="activeCurriculumItem.is_preview">
                            </div>
                           @if( in_array($activeCurriculumItem['type'], ['audio', 'live', 'article']) || ($activeCurriculumItem['type'] === 'video' && !empty($curriculumVideo)) || ($activeCurriculumItem['type'] === 'yt_link' && !empty($yt_link)) || ($activeCurriculumItem['type'] === 'vm_link' && !empty($vm_link))) 
                                <button wire:click="updateActiveCurriculumItem" class="am-white-btn" wire:loading.attr="disabled" wire:target="updateActiveCurriculumItem" wire:loading.class="am-btn_disable">
                                    {{ __('courses::courses.skip') }}
                                </button>
                                <button wire:click="updateCurriculumContent({{ $curriculumItem }})" type="click"
                                    class="am-btn">
                                    <span wire:loading.remove wire:target="updateCurriculumContent">{{ __('courses::courses.save') }}</span>
                                    <span wire:loading wire:target="updateCurriculumContent">{{ __('courses::courses.saving') }}</span>
                                </button>
                           @endif
                           
                            @if (($activeCurriculumItem['type'] === 'video' && !empty($curriculumVideo)) || ($activeCurriculumItem['type'] === 'yt_link' && !empty($yt_link)) || ($activeCurriculumItem['type'] === 'vm_link' && !empty($vm_link)))
                                <button wire:click="removeCurriculumContent" wire:loading.attr="disabled" wire:target="removeCurriculumContent" wire:loading.class="am-btn_disable" type="click" class="am-btn am-remove-curriculum">
                                    <span wire:loading.remove wire:target="removeCurriculumContent">{{ __('courses::courses.remove') }}</span>
                                    <span wire:loading wire:target="removeCurriculumContent">{{ __('courses::courses.removing') }}</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    @if ($addCurriculumState)
        <div class="cr-curriculum-state">
            <div class="form-group">
                <label class="am-important" for="curriculum-title">{{ __('courses::courses.curriculum_title') }}</label>
                <input class="form-control @error('title') is-invalid @enderror" type="text" id="curriculum-title"
                    placeholder="{{ __('courses::courses.enter_curriculum_title') }}" wire:model="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group @error('description') cr-invalid @enderror">
                <label class="am-important" for="description">{{ __('courses::courses.description') }}</label>
                <div class="am-editor-wrapper">
                    <div wire:ignore class="am-custom-editor am-custom-textarea">
                        <textarea class="form-control cr-summernote" placeholder="{{ __('courses::courses.enter_description') }}"
                            id="curriculum_des_{{ $section->id }}" data-id="@this" data-model_id="description"></textarea>
                        <span class="characters-count"></span>
                    </div>
                </div>
                <x-input-error field_name='description' />
            </div>
            <div class="cr-btns">
                <button wire:click="updateCurriculumState(false)" wire:loading.class="am-btn_disable" wire:target="updateCurriculumState(false)" class="am-cancel-btn">{{ __('courses::courses.cancel') }}</button>
                <button type="button" class="am-btn" wire:click="addCurriculum">
                    <span wire:loading.remove
                        wire:target="addCurriculum">{{ __('courses::courses.add_curriculum') }}</span>
                    <span wire:loading wire:target="addCurriculum">{{ __('courses::courses.loading') }}</span>
                </button>
            </div>
        </div>
    @else
        <button class="cr-addbtn" wire:click="updateCurriculumState(true)" wire:loading.class="am-btn_disable" wire:target="updateCurriculumState(true)">
            <svg class="am-border-svg ">
                <rect width="100%" height="100%"></rect>
            </svg>
            {{ __('courses::courses.add_curriculum') }}
            <i class="am-icon-plus-02" wire:loading.remove wire:target="updateCurriculumState(true)"></i>
        </button>
    @endif

     <!-- edit model start -->
     <div wire:ignore.self class="modal fade cr-course-modal" id="edit-curriculum-{{ $section->id }}" tabindex="-1"
     aria-labelledby="edit-curriculumLabel-{{ $section->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-curriculumLabel-{{ $section->id }}">{{ __('courses::courses.edit_course_section') }}</h5>
                    <span class="cr-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <g opacity="0.7">
                                <path d="M4 12L12 4M4 4L12 12" stroke="#585858" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </g>
                        </svg>
                    </span>
                </div>
                <div class="modal-body">
                    <form class="am-themeform">
                        <fieldset>
                            <div class="form-group">
                                <label class="am-important"
                                    for="curriculum-title">{{ __('courses::courses.title') }}</label>
                                <input type="text" wire:model="title" id="curriculum-title"
                                    placeholder="{{ __('courses::courses.enter_title') }}"
                                    class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group @error('description') cr-invalid @enderror">
                                <div wire:ignore class="am-editor-wrapper">
                                    <div class="am-custom-editor am-custom-textarea">
                                        <textarea id="edit_curriculum_des_{{ $section->id }}" data-id="@this" data-model_id="description" class="form-control am-summernote_txt cr-summernote" placeholder="{{ __('courses::courses.enter_answer') }}"></textarea>
                                        <span class="characters-count"></span>
                                    </div>
                                </div>
                                <x-input-error field_name='description' />
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="am-white-btn" data-bs-dismiss="modal">{{ __('courses::courses.close') }}</button>
                    <button type="button" class="am-btn" wire:click="updateCurriculum" wire:loading.attr="disabled">
                        <span wire:loading.remove
                            wire:target="updateCurriculum">{{ __('courses::courses.save_changes') }}</span>
                        <span wire:loading wire:target="updateCurriculum">{{ __('courses::courses.saving') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>