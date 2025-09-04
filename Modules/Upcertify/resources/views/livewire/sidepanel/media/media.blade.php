<div class="uc-sidebar_wrap" 
    x-data="{
        activeTab: @entangle('media_type'),
        backgrounds: @entangle('backgrounds'),
        attachments: @entangle('attachments'),
        toggleTab(tab) {
            if (this.activeTab === tab) {
                this.activeTab = '';
            } else {
                this.activeTab = tab;
            }
        },
    }" 
    x-init="
        $wire.$watch('backgrounds', () => closeModal());
        $wire.$watch('attachments', () => closeModal());
    "
>
    <div class="uc-sidebar_inner">
        <div class="uc-sidebar_title">
            <h2>{{ __('upcertify::upcertify.media') }}</h2>
            <a href="javascript:void(0);" class="uc-sidebar-hidebtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16" fill="none">
                    <g>
                        <path d="M4 12L12 4M4 4L12 12" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
            </a>
        </div>

        <div class="uc-sidebar-element">
            <form class="uc-themeform uc-sidebar_form">
                <fieldset>
                    <div class="form-group">
                        <div class="form-group-wrap">
                            <input type="search" wire:model.live.debounce.500ms="search" class="uc-search-wildcard form-control" placeholder="Search" >
                            <i class="uc-search-icon"><x-upcertify::icons.search /></i>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="uc-sidebar uc-sidebar_media">
            <div class="uc-elements  uc-content" id="background-content" style="display: block;">
                @if($loadingBackgrounds)
                    <ul class="uc-radio-section">
                        @for ($i = 0; $i < 12; $i++)
                            <li class="uc-skeleton">
                                <label for="bg_" class="uc-geomatric">
                                    <figure class="uc-geomatric-img"></figure>
                                    <div class="uc-media-title">
                                        <span></span>
                                        <i></i>
                                    </div>
                                </label>
                            </li>
                        @endfor
                    </ul>
                @elseif($backgrounds && $backgrounds->isNotEmpty())
                    <ul class="uc-radio-section">
                        <li data-target="#uc-addmediapopup" @click="customActiveTab('media', $event)" class="uc-upload-media">
                            <label for="upload-media">
                                <span class="uc-upload-media_icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                                        <path d="M14.5835 3.08496V5.38499C14.5835 6.5051 14.5835 7.06515 14.8015 7.49297C14.9932 7.8693 15.2992 8.17526 15.6755 8.367C16.1033 8.58499 16.6634 8.58499 17.7835 8.58499H20.0835M12.5835 17.585V11.585M12.5835 11.585L15.0835 14.085M12.5835 11.585L10.0835 14.085M20.5835 10.8987V14.585C20.5835 17.3852 20.5835 18.7854 20.0385 19.8549C19.5592 20.7957 18.7943 21.5606 17.8534 22.04C16.7839 22.585 15.3838 22.585 12.5835 22.585V22.585C9.78323 22.585 8.3831 22.585 7.31354 22.04C6.37273 21.5606 5.60783 20.7957 5.12846 19.8549C4.5835 18.7854 4.5835 17.3852 4.5835 14.585V10.3631C4.5835 7.77193 4.5835 6.47632 5.05209 5.47159C5.54886 4.40644 6.40497 3.55032 7.47012 3.05355C8.47486 2.58496 9.77046 2.58496 12.3617 2.58496V2.58496C13.494 2.58496 14.0601 2.58496 14.5948 2.70351C15.1641 2.82975 15.707 3.05461 16.1988 3.36792C16.6607 3.66217 17.061 4.06249 17.8617 4.86313L18.2404 5.24182C19.1051 6.10657 19.5375 6.53895 19.8467 7.04354C20.1208 7.4909 20.3229 7.97862 20.4453 8.4888C20.5835 9.06424 20.5835 9.67572 20.5835 10.8987Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <h6 class="uc-upload-media_title">Upload file</h6>
                            </label>
                        </li>
                        <li>
                            <input type="radio" id="no_bg" class="uc-background_option" name="uc-background" value="" data-url="">
                            <label for="no_bg" class="uc-geomatric uc-empty-bg">
                                <figure class="uc-geomatric-img"></figure>
                            </label>
                        </li>
                        @foreach($backgrounds as $background)
                            <li id="bg_list_{{ $background->id }}">
                                <input type="radio" id="bg_{{ $background->id }}" class="uc-background_option" name="uc-background" value="{{ $background->id }}" data-url="{{ Storage::url($background->path) }}">
                                <label for="bg_{{ $background->id }}" class="uc-geomatric uc-media-img">
                                    <figure class="uc-skeleton">
                                        <img src="{{ Storage::url($background->path) }}" alt="image" onload="this.parentElement.classList.remove('uc-skeleton')">
                                    </figure>
                                    <div class="uc-media-title">
                                        <i class="uc-trash" id="delete_bg_{{ $background->id }}" data-id="{{ $background->id }}">
                                            <x-upcertify::icons.trash />
                                        </i>
                                    </div>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                @else
                <ul class="uc-radio-section">
                    <li data-target="#uc-addmediapopup" @click="customActiveTab('media', $event)" class="uc-upload-media uc-emptycard">
                        <label for="upload-media">
                            <span class="uc-upload-media_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                                    <path d="M14.5835 3.08496V5.38499C14.5835 6.5051 14.5835 7.06515 14.8015 7.49297C14.9932 7.8693 15.2992 8.17526 15.6755 8.367C16.1033 8.58499 16.6634 8.58499 17.7835 8.58499H20.0835M12.5835 17.585V11.585M12.5835 11.585L15.0835 14.085M12.5835 11.585L10.0835 14.085M20.5835 10.8987V14.585C20.5835 17.3852 20.5835 18.7854 20.0385 19.8549C19.5592 20.7957 18.7943 21.5606 17.8534 22.04C16.7839 22.585 15.3838 22.585 12.5835 22.585V22.585C9.78323 22.585 8.3831 22.585 7.31354 22.04C6.37273 21.5606 5.60783 20.7957 5.12846 19.8549C4.5835 18.7854 4.5835 17.3852 4.5835 14.585V10.3631C4.5835 7.77193 4.5835 6.47632 5.05209 5.47159C5.54886 4.40644 6.40497 3.55032 7.47012 3.05355C8.47486 2.58496 9.77046 2.58496 12.3617 2.58496V2.58496C13.494 2.58496 14.0601 2.58496 14.5948 2.70351C15.1641 2.82975 15.707 3.05461 16.1988 3.36792C16.6607 3.66217 17.061 4.06249 17.8617 4.86313L18.2404 5.24182C19.1051 6.10657 19.5375 6.53895 19.8467 7.04354C20.1208 7.4909 20.3229 7.97862 20.4453 8.4888C20.5835 9.06424 20.5835 9.67572 20.5835 10.8987Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <h6 class="uc-upload-media_title">Upload file</h6>
                        </label>
                    </li>
                </ul>    
                @endif
            </div>
        </div>
    </div>
    <div class="uc-sidebar_toggler">
        <span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M14 6L8 12L14 18" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
    </div>
</div>
