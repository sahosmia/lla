<div class="cr-course-box" wire:init="loadData">
    <div class="cr-titlewrap">
        <div class="cr-content-box">
            <h2>{{__('courses::courses.promotions_title') }}</h2>
            <p>{{__('courses::courses.promotions_description') }}</p>
        </div>
        <span wire:click="openModal">{{__('courses::courses.plus_add_more') }}</span>
    </div>
    @if ($promotions->isEmpty())
        <div class="cr-no-record-container">
            <h6>{{ __('courses::courses.no_records_added_yet') }}</h6>
            <p>{{ __('courses::courses.no_records_available') }}</p>
            <button wire:click="openModal" class="am-btn">{{ __('courses::courses.create_promotion') }}</button>
        </div>
    @else
        <ul class="am-promoslist">
            @if (!empty($promotions))
                @foreach ($promotions as $item)
                    <li>
                        <div class="am-promoowrap">
                            <div class="am-discount" style="background: {{ $item->color }} ">
                                @if($item->discount_type == 'percentage')
                                     <span>{{ $item->discount_value }}<em>%</em></span>
                                @else
                                <span>
                                    {!! formatAmount($item->discount_value, true) !!}
                                </span>
                                @endif
                                <h6>{{__('courses::courses.discount') }}</h6>
                                <div class="am-coupon_shape" style="border-color: {{ $item->color }}">
                                </div>
                            </div>
                            @php 
                                $color = $item->color;
                                $rgba = '';
                                if (strpos($color, 'rgba') !== false) {
                                    $rgba = str_replace(['rgba(', ')'], '', $color);
                                    list($r, $g, $b, $a) = explode(',', $rgba);
                                    $rgba = "rgba($r,$g,$b,0.1)";
                                } else {
                                    $hex = ltrim($color, '#');
                                    $r = hexdec(substr($hex, 0, 2));
                                    $g = hexdec(substr($hex, 2, 2)); 
                                    $b = hexdec(substr($hex, 4, 2));
                                    $rgba = "rgba($r,$g,$b,0.06)";
                                }
                            @endphp
                            <div class="am-promodetail" style="background-color: {{ $rgba }}">
                                <div class="am-promoinfowrap">
                                    <div class="am-promodinfo">
                                        <h6>{{__('courses::courses.promo_code') }}</h6>
                                        <span>{{ $item->code }}</span>
                                    </div>
                                    <span>{{__('courses::courses.valid_until') }}: {{ \Carbon\Carbon::parse($item->expiry_date)->format('d M Y') }}</span>
                                </div>
                                <div class="am-itemdropdown">
                                    <a href="javascript:void(0);" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                <path d="M2.62484 5.54166C1.82275 5.54166 1.1665 6.19791 1.1665 6.99999C1.1665 7.80207 1.82275 8.45832 2.62484 8.45832C3.42692 8.45832 4.08317 7.80207 4.08317 6.99999C4.08317 6.19791 3.42692 5.54166 2.62484 5.54166Z" fill="#585858" />
                                                <path d="M11.3748 5.54166C10.5728 5.54166 9.9165 6.19791 9.9165 6.99999C9.9165 7.80207 10.5728 8.45832 11.3748 8.45832C12.1769 8.45832 12.8332 7.80207 12.8332 6.99999C12.8332 6.19791 12.1769 5.54166 11.3748 5.54166Z" fill="#585858" />
                                                <path d="M5.5415 6.99999C5.5415 6.19791 6.19775 5.54166 6.99984 5.54166C7.80192 5.54166 8.45817 6.19791 8.45817 6.99999C8.45817 7.80207 7.80192 8.45832 6.99984 8.45832C6.19775 8.45832 5.5415 7.80207 5.5415 6.99999Z" fill="#585858" />
                                            </svg>
                                        </i>
                                    </a>
                                    <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li>
                                            <a href="javascript:void(0);" wire:ignore wire:click="editCoupon({{ $item->id }})">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M16.6663 17.5H3.33301M13.333 3.33335C13.1247 4.79169 14.3747 6.04169 15.833 5.83335M5.83301 13.3334L6.23639 11.7198C6.39642 11.0797 6.47644 10.7596 6.60511 10.4612C6.71935 10.1963 6.86191 9.9445 7.03031 9.71024C7.22 9.44637 7.45328 9.21309 7.91985 8.74653L13.7498 2.91667C14.4401 2.22633 15.5594 2.22635 16.2498 2.91671V2.91671C16.9401 3.60706 16.9401 4.7263 16.2497 5.41663L10.4198 11.2465C9.95327 11.7131 9.71999 11.9464 9.45612 12.1361C9.22187 12.3045 8.97008 12.447 8.70515 12.5612C8.40675 12.6899 8.08669 12.7699 7.44657 12.93L5.83301 13.3334Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </i>
                                                {{__('courses::courses.edit') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="cr-delete-option" @click="$wire.dispatch('showConfirm', { id : {{ $item['id'] }}, action : 'delete-coupon' })">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path d="M3.33317 4.16669L3.82396 12.5101C3.9375 14.4402 3.99427 15.4053 4.37553 16.1521C4.79523 16.9742 5.48635 17.6259 6.3317 17.9966C7.09962 18.3334 8.06636 18.3334 9.99984 18.3334V18.3334C11.9333 18.3334 12.9001 18.3334 13.668 17.9966C14.5133 17.6259 15.2044 16.9742 15.6241 16.1521C16.0054 15.4053 16.0622 14.4402 16.1757 12.5101L16.6665 4.16669M3.33317 4.16669H1.6665M3.33317 4.16669H16.6665M16.6665 4.16669H18.3332M13.3332 4.16669L13.0469 3.30774C12.8502 2.71763 12.7518 2.42257 12.5694 2.20442C12.4083 2.01179 12.2014 1.86268 11.9677 1.77077C11.7031 1.66669 11.3921 1.66669 10.77 1.66669H9.22966C8.60762 1.66669 8.29661 1.66669 8.03197 1.77077C7.79828 1.86268 7.5914 2.01179 7.4303 2.20442C7.24788 2.42257 7.14952 2.71763 6.95282 3.30774L6.6665 4.16669M8.33317 8.33335V14.1667M11.6665 8.33335V11.6667" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </i>
                                                {{__('courses::courses.delete') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    @endif
    <div class="am-themeform_footer">
        <a href="{{ route('courses.tutor.edit-course', ['tab' => 'faqs', 'id' => $this->courseId]) }}">
            <button class="am-white-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M10.5 4.5L6 9L10.5 13.5" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                {{__('courses::courses.back') }}
            </button>
        </a>
        <button
            wire:click="save"
            type="button"
            class="am-btn"
            wire:loading.class="am-btn_disable"
            wire:loading.attr="disabled"
            wire:target="save"
        >
            {{ __('courses::courses.save_continue') }}
        </button>
    </div>
    @include('courses::livewire.tutor.course-creation.components.promotions.card')
</div>


@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/kupondeal/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/kupondeal/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/kupondeal/css/jquery.colorpicker.bygiro.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    @vite([
        'public/css/flatpicker.css',
        'public/css/flatpicker-month-year-plugin.css',
    ])
@endpush


@push('scripts')
    <script defer src="{{ asset('js/flatpicker.js') }}"></script>
    <script defer src="{{ asset('js/flatpicker-month-year-plugin.js') }}"></script>
    <script defer src="{{ asset('modules/kupondeal/js/jquery.colorpicker.bygiro.js') }}"></script>
    <script>
        window.addEventListener('onEditCoupon', (event) => {
            let { discount_type, discount_value, expiry_date, couponable_id, couponable_type, color, optionList } = event.detail;
            Livewire.dispatch('initSelect2', { target: '.am-select2', timeOut: 0 });
            initializeDatePicker();
            jQuery('#discount_type').val(discount_type).trigger('change');
            jQuery('#discount_value').val(discount_value);
            jQuery('#expiry_date').val(expiry_date);
            jQuery('.kd-colorpicker input').val(color);
            $('.myColorPicker-preview').css('background-color', color);
            jQuery('#couponable_id').attr('disabled', true);
            initColorPicker(color)
            $('#cr-create-coupon').modal('show');
        });

        window.addEventListener('createCoupon', (event) => {
            let { color = '#000000' } = event.detail;
            Livewire.dispatch('initSelect2', { target: '.am-select2', timeOut: 0 });
            jQuery('#discount_type').val(null).trigger('change');
            jQuery('#discount_value').val('');
            jQuery('#expiry_date').val('');
            initializeDatePicker();
            initColorPicker(color)
            $('#cr-create-coupon').modal('show');
        });

        function initColorPicker (color) {
            setTimeout(() => {
                let $colorPicker = $('.myColorPicker').colorPickerByGiro({
                    preview: '.myColorPicker-preview',
                    text: {
                        close: 'Confirm',
                        none: 'None',
                    },
                    options: {
                        defaultColor: color
                    },
                });

                $('.myColorPicker-preview').css('background-color', color);
                jQuery('.kd-colorpicker input').val(color).trigger('change');
                setTimeout(() => {
                    $('.myColorPicker').find('.colorPicker--preview').css('background-color', color);
                    $('.myColorPicker').find('.colorPicker input').val(color);
                }, 50);
            }, 100);
        }

        jQuery(document).on('click', '.colorPicker input, .colorPicker--preview', function(evt){
            let _this = $(this);
            jQuery('.cp-cont').find('.cpBG').not(_this.parents('.cp-cont').find('.cpBG')).removeClass('in').css('display','none');
        });

        jQuery(document).on('contextmenu', '.colorPicker input', function(evt){
            let _this = $(this);
            jQuery('.cp-cont').find('.cpBG').not(_this.parents('.cp-cont').find('.cpBG')).removeClass('in').css('display','none');
        });

        jQuery(document).on('change', '.kd-colorpicker input', function() {
            let getcolor =  jQuery(this).val();
            let setcolor = jQuery('.colorPicker--preview')
            jQuery(setcolor).css("background-color", getcolor);
            @this.set('form.color', getcolor);
            
        });

        jQuery(document).on('click', 'body', function (e) {
            if ($(e.target).closest('.cp-cont').length) {
                return;
            }
            jQuery('.cp-cont')
                .find('.cpBG')
                .removeClass('in')
                .css('display', 'none');
        });
    </script>
@endpush





