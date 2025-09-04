<div wire:ignore.self class="modal fade cr-course-modal cr-coupon-modal " id="cr-create-coupon" tabindex="-1" aria-labelledby="create-couponLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create-promotionLabel">{{__('courses::courses.create_promotion') }}</h5>
                <span class="cr-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <g opacity="0.7">
                            <path d="M4 12L12 4M4 4L12 12" stroke="#585858" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                    </svg>
                </span>
            </div>			
            <div class="modal-body">
                <form class="am-themeform">
                    <fieldset>
                        <div class="am-themeform__wrap">
                            <div class="form-group @error('form.code')cr-invalid @enderror">
                                <label class="am-important" for="code">{{__('courses::courses.promo_code') }}</label>
                                <x-text-input type="text" wire:model="form.code" id="code" placeholder="#LEARN" />
                                <x-input-error field_name='form.code' />
                            </div>
                            <div class="form-group @error('form.discount_type') am-invalid @enderror">
                                <x-input-label class="am-important" for="discount_type">{{ __('kupondeal::kupondeal.discount_type') }}</x-input-label>
                                <span class="am-select" wire:ignore>
                                    <select class="am-select2" data-componentid="@this" id="discount_type" data-live="true" data-wiremodel="form.discount_type" data-placeholder="{{ __('kupondeal::kupondeal.select_discount_type') }}">
                                        <option value="">{{ __('kupondeal::kupondeal.select_discount_type') }}</option>
                                        <option value="fixed" @if($form['discount_type'] == 'fixed') selected @endif>{{ __('kupondeal::kupondeal.fixed_price') }}</option>
                                        <option value="percentage" @if($form['discount_type'] == 'percentage') selected @endif>{{ __('kupondeal::kupondeal.percentage') }}</option>
                                    </select>
                                </span>
                                <x-kupondeal::input-error field_name='form.discount_type' />
                            </div>
                            <div class="form-group @error('form.discount_value')cr-invalid @enderror">
                                <label class="am-important" for="discount_percentage">{{ $form['discount_type'] == 'percentage' ? __('courses::courses.discount_percentage') : __('courses::courses.discount_amount') }}</label>
                                <x-text-input type="number" wire:model="form.discount_value" id="discount_percentage" placeholder="Enter discount value" />
                                <x-input-error field_name='form.discount_value' />
                            </div>
                            <div class="form-group @error('form.expiry_date')cr-invalid @enderror">
                                <label class="am-important" for="expiry_date">{{__('courses::courses.expiry_date') }}</label>
                                <div class="am-booking-calander-date flatpicker" wire:ignore>
                                    <x-text-input class="flat-date am-important" wire:model="form.expiry_date" id="expiry_date" data-min-date="today" data-format="Y-m-d" placeholder="{{__('courses::courses.expiry_date') }}" type="text" id="datepicker"  autofocus autocomplete="name" />
                                </div>
                                <x-input-error field_name='form.expiry_date' />
                            </div>
                            <div class="kd-colorpicker_wrap form-group">
                                <div wire:ignore>
                                    <div class="kd-colorpicker myColorPicker">
                                        <span class="input-group-addon kd-colordemo myColorPicker-preview">&nbsp;</span>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <x-input-error field_name='form.color' />
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="am-white-btn" data-bs-dismiss="modal">{{__('courses::courses.close') }}</button>
                <button wire wire:click="addCoupon" type="button" class="am-btn" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="addCoupon">{{ __('courses::courses.save_changes') }}</span>
                    <span wire:loading wire:target="addCoupon">{{ __('courses::courses.saving') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>