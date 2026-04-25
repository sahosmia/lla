<div class="uc-navigation_wrap">
    @if(config('upcertify.show_logo') && !empty(config('upcertify.logo_url')))
        <strong class="uc-navigation_logo">
            <a href="{{ route('tutor.dashboard') }}">
                <img src="{{config('upcertify.logo_url')}}" height="43" width="43" alt="img">
            </a>
        </strong>
    @else
        <strong class="uc-navigation_logo">
            <a href="{{ route('tutor.dashboard') }}">
                <img src="{{asset('modules/upcertify/images/logo.png')}}" height="43" width="43" alt="img">
            </a>
        </strong>    
    @endif
    <div class="uc-navigation">
        <nav>
            <ul>
                <li>
                    <a href="javascript:void(0)" wire:target="updateTab('general')" wire:loading.class="uc-btn_disable" @class(['uc-active' => $tab == 'general']) wire:click.prevent="updateTab('general')">
                        <i class="uc-navigation_icon"><x-upcertify::icons.layers /></i>
                        <span>{{ __('upcertify::upcertify.general') }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" wire:target="updateTab('templates')" wire:loading.class="uc-btn_disable" @class(['uc-active' => $tab == 'templates', 'uc-disabled' => empty($isEdit)]) wire:click.prevent="updateTab('templates')">
                        <i class="uc-navigation_icon"><x-upcertify::icons.template /></i>
                        <span>{{ __('upcertify::upcertify.templates') }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" wire:target="updateTab('media')" wire:loading.class="uc-btn_disable" @class(['uc-active' => $tab == 'media', 'uc-disabled' => empty($isEdit)]) wire:click.prevent="updateTab('media')">
                        <i class="uc-navigation_icon"><x-upcertify::icons.media /></i>
                        <span>{{ __('upcertify::upcertify.media') }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" wire:target="updateTab('elements')" wire:loading.class="uc-btn_disable" @class(['uc-active' => $tab == 'elements', 'uc-disabled' => empty($isEdit)]) wire:click.prevent="updateTab('elements')">
                        <i class="uc-navigation_icon"><x-upcertify::icons.elements /></i>
                        <span>{{ __('upcertify::upcertify.elements') }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" wire:target="updateTab('library')" wire:loading.class="uc-btn_disable" @class(['uc-active' => $tab == 'library', 'uc-disabled' => empty($isEdit)]) wire:click.prevent="updateTab('library')">
                        <!-- <i class="uc-navigation_icon"><x-upcertify::icons.elements /></i> -->
                         <i>
                             <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                 <g opacity="0.7">
                                     <path fill-rule="evenodd" clip-rule="evenodd" d="M8.58875 0.948242C8.78284 0.948242 8.96257 1.05055 9.06167 1.21745L12.4288 6.88848C12.5298 7.05847 12.5317 7.26955 12.4339 7.44136C12.3361 7.61317 12.1536 7.71928 11.9559 7.71928H5.22157C5.02387 7.71928 4.84138 7.61317 4.74358 7.44136C4.64578 7.26955 4.64772 7.05847 4.74865 6.88848L8.11583 1.21745C8.21492 1.05055 8.39465 0.948242 8.58875 0.948242ZM6.18777 6.61928H10.9897L8.58875 2.57554L6.18777 6.61928ZM0.949951 10.8286C0.949951 10.5248 1.19619 10.2786 1.49995 10.2786H7.17099C7.47474 10.2786 7.72099 10.5248 7.72099 10.8286V16.4996C7.72099 16.8034 7.47474 17.0496 7.17099 17.0496H1.49995C1.19619 17.0496 0.949951 16.8034 0.949951 16.4996V10.8286ZM2.04995 11.3786V15.9496H6.62099V11.3786H2.04995ZM13.6644 11.3786C12.4022 11.3786 11.3789 12.4019 11.3789 13.6641C11.3789 14.9264 12.4022 15.9496 13.6644 15.9496C14.9267 15.9496 15.95 14.9264 15.95 13.6641C15.95 12.4019 14.9267 11.3786 13.6644 11.3786ZM10.2789 13.6641C10.2789 11.7943 11.7947 10.2786 13.6644 10.2786C15.5342 10.2786 17.05 11.7943 17.05 13.6641C17.05 15.5339 15.5342 17.0496 13.6644 17.0496C11.7947 17.0496 10.2789 15.5339 10.2789 13.6641Z" fill="white"/>
                                 </g>
                             </svg>
                         </i>
                        <span>{{ __('upcertify::upcertify.library') }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" wire:target="updateTab('background')" wire:loading.class="uc-btn_disable" @class(['uc-active' => $tab == 'background', 'uc-disabled' => empty($isEdit)]) wire:click.prevent="updateTab('background')">
                        <!-- <i class="uc-navigation_icon"><x-upcertify::icons.elements /></i> -->
                        <i>
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <g opacity="0.7">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.93185 1.93161C2.10759 1.75587 2.39251 1.75587 2.56825 1.93161L16.0682 15.4316C16.244 15.6073 16.244 15.8923 16.0682 16.068C15.8925 16.2437 15.6076 16.2437 15.4319 16.068L1.93185 2.568C1.75611 2.39227 1.75611 2.10734 1.93185 1.93161ZM6.21436 1.93161C6.39009 1.75587 6.67502 1.75587 6.85075 1.93161L16.0682 11.1491C16.244 11.3248 16.244 11.6098 16.0682 11.7855C15.8925 11.9612 15.6076 11.9612 15.4319 11.7855L6.21436 2.568C6.03862 2.39227 6.03862 2.10734 6.21436 1.93161ZM10.4965 1.93161C10.6722 1.75587 10.9572 1.75587 11.1329 1.93161L16.0682 6.86695C16.244 7.04268 16.244 7.32761 16.0682 7.50334C15.8925 7.67908 15.6076 7.67908 15.4319 7.50334L10.4965 2.568C10.3208 2.39227 10.3208 2.10734 10.4965 1.93161ZM14.7787 1.93161C14.9544 1.75587 15.2393 1.75587 15.4151 1.93161L16.0682 2.5848C16.244 2.76053 16.244 3.04546 16.0682 3.22119C15.8925 3.39693 15.6076 3.39693 15.4319 3.22119L14.7787 2.568C14.6029 2.39227 14.6029 2.10734 14.7787 1.93161ZM1.93185 6.21358C2.10759 6.03784 2.39251 6.03784 2.56825 6.21358L11.7863 15.4316C11.962 15.6073 11.962 15.8923 11.7863 16.068C11.6105 16.2437 11.3256 16.2437 11.1499 16.068L1.93185 6.84997C1.75611 6.67424 1.75611 6.38931 1.93185 6.21358ZM1.93185 10.4956C2.10759 10.3198 2.39251 10.3198 2.56825 10.4956L7.5043 15.4316C7.68004 15.6073 7.68004 15.8923 7.5043 16.068C7.32857 16.2437 7.04364 16.2437 6.86791 16.068L1.93185 11.1319C1.75611 10.9562 1.75611 10.6713 1.93185 10.4956ZM1.93185 14.7777C2.10759 14.602 2.39251 14.602 2.56825 14.7777L3.22215 15.4316C3.39789 15.6073 3.39789 15.8923 3.22215 16.068C3.04642 16.2437 2.76149 16.2437 2.58576 16.068L1.93185 15.4141C1.75611 15.2384 1.75611 14.9534 1.93185 14.7777Z" fill="white"/>
                                </g>
                            </svg>
                        </i>
                        <span>{{ __('upcertify::upcertify.background_menu') }}</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="uc-navigation_goback">
        <a href="{{ route('upcertify.certificate-list') }}">
            <i class="uc-navigation_icon"><x-upcertify::icons.chevron-right /></i>
            <span>{{ __('upcertify::upcertify.go_back') }}</span>
        </a>
    </div>
</div>