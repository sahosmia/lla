
<div class="uc-sidebar_wrap">
    <div class="uc-sidebar_inner">
        <div class="uc-sidebar_title">
            <h2>{{ __('upcertify::upcertify.general') }}</h2>
            <a href="javascript:void(0);" class="uc-sidebar-hidebtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16" fill="none">
                    <g>
                        <path d="M4 12L12 4M4 4L12 12" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
            </a>
        </div>
        <div class="uc-sidebar">
            <form class="uc-themeform uc-sidebar_form" wire:submit.prevent="createNow">
                <fieldset>
                    <div class="form-group">
                        <label for="title" class="uc-important">{{ __('upcertify::upcertify.title') }}</label>
                        <div class="form-group-wrap @error('title') uc-invalid @enderror">
                            <input id="title" class="form-control" type="text" placeholder="{{ __('upcertify::upcertify.enter_title') }}" required wire:model="title" wire:keyup.enter="createNow">
                            @error('title')
                                <span class="uc-error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group form-group-btn">
                        <button type="button" class="uc-btn" wire.click.enter="createNow" wire:click.prevent="createNow" wire:loading.class="uc-btn_disable" wire:loading.attr="disabled" wire:target="createNow">
                            {{ !empty($id) ? __('upcertify::upcertify.update') : __('upcertify::upcertify.create_now') }}
                        </button>
                    </div>
                </fieldset>
            </form>
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