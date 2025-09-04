
    <div class="am-accountwrap" wire:init="loadData">
        @slot('title')
            {{ __('checkout.billing_details') }}
        @endslot
        <div class="am-title_wrap">
            <div class="am-title">
                <h2>{{ __('billing_info.heading') }}</h2>
                <p>{{ __('billing_info.description') }}</p>
            </div>
        </div>
        <form wire:submit="updateInfo"  class="am-themeform am-themeform_personalinfo">
            @if($isLoading)
                @include('skeletons.billing-detail')
            @else
                <fieldset>
                    <div class="form-group">
                        <x-input-label for="name" class="am-important" :value="__('billing_info.first_name_placeholder')" />
                       <div class="form-group-two-wrap">
                        <div @class(['form-group-half', 'am-invalid' => $errors->has('form.firstName')])>
                                <x-text-input wire:model="form.firstName" id="name" name="name" placeholder="{{ __('billing_info.first_name_placeholder') }}" type="text"  autofocus autocomplete="name" />
                                <x-input-error field_name="form.firstName" />

                            </div>
                            <div @class(['form-group-half', 'am-invalid' => $errors->has('form.lastName')])>
                                <x-text-input wire:model="form.lastName" id="name" name="name" placeholder="{{ __('billing_info.last_name_placeholder') }}" type="text"  autofocus autocomplete="name" />
                                <x-input-error field_name="form.lastName" />

                            </div>
                       </div>
                    </div>
                    <div class="form-group">
                        <x-input-label class="am-important" for="name" :value="__('billing_info.company_title')" />
                        <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.company')]) >
                            <x-text-input wire:model="form.company" id="company" name="company" placeholder="{{ __('billing_info.company_placeholder') }}" type="text"  autofocus autocomplete="name" />
                            <x-input-error field_name="form.company" />
                        </div>
                    </div>
                    <div class="form-group am-addressform">
                        <x-input-label for="Contact" class="am-important" :value="__('billing_info.contact')" />
                        <div class="form-group-two-wrap">
                            <div @class(['form-group-half', 'am-invalid' => $errors->has('form.email')])>
                                <x-input-label for="Email" :value="__('billing_info.email_address')" />
                                <x-text-input wire:model="form.email" id="Email" name="Email" placeholder="{{ __('billing_info.email_placeholder') }}" type="text"  autofocus autocomplete="name" />
                                <x-input-error field_name="form.email" />
                            </div>
                            <div @class(['form-group-half', 'am-invalid' => $errors->has('form.phone')])>
                                <x-input-label for="phone" :value="__('billing_info.phone_number')" />
                                <x-text-input wire:model="form.phone" id="number" name="number" placeholder="{{ __('billing_info.phone_placeholder') }}" type="text"  autofocus autocomplete="name" />
                                <x-input-error field_name="form.phone" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group am-addressform">
                        <x-input-label for="address" class="am-important" :value="__('profile.address')" />
                        <div class="am-user-location">
                            @if($enableGooglePlaces == '1')
                                <div class="form-group">
                                    <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.address')])>
                                        <x-text-input wire:ignore.self value="{{ $form->address }}"  id="tutor_location_field" placeholder="{{ __('billing_info.address_placeholder') }}" type="text"  autofocus autocomplete="name" />
                                        <x-input-error field_name="form.address" />
                                    </div>
                                </div>
                            @else
                                <div class="form-group-half" x-init="{ onFooChange(event) {}}">
                                    <x-input-label for="country" :value="__('profile.country')" />
                                    <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.country')])>
                                        <span class="am-select" wire:ignore>
                                            <select class="am-select2" data-componentid="@this" data-live="true" data-searchable="true" id="user_country" data-wiremodel="form.country">
                                                <option value="">{{ __('profile.select_a_country') }}</option>
                                                @foreach ($countries as $item)
                                                    <option value="{{ $item->id }}" {{ $item->id == $form->country ? 'selected' : '' }} >{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </span>
                                    </div>
                                    <x-input-error field_name="form.country" />
                                </div>
                                @if(!empty($form->country) && count($states) > 0)
                                    <div class="form-group-half">
                                        <x-input-label for="country_state" :value="__('profile.state')" />
                                        <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.state')])>
                                            <span class="am-select" wire:ignore>
                                                <select data-componentid="@this" class="am-select2"  data-searchable="true" id="country_state" data-wiremodel="form.state">
                                                    <option value="">{{ __('profile.select_a_state') }}</option>
                                                    @foreach ($states as $item)
                                                        <option value="{{ $item->id }}" {{ $item->id == $form->state ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                        </div>
                                        <x-input-error field_name="form.state" />
                                    </div>
                                @endif
                                    <div class="form-group-half">
                                        <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.city')])>
                                        <x-input-label for="city" :value="__('profile.city')" />
                                        <x-text-input wire:model="form.city" placeholder="{{ __('profile.city_placeholder') }}" type="text"  autofocus autocomplete="name" />
                                        <x-input-error field_name="form.city" />
                                    </div>
                                    </div>
                                <div class="form-group-half">
                                    <x-input-label for="Zip" :value="__('profile.zipcode')" />
                                    <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.zipcode')])>
                                    <x-text-input wire:model="form.zipcode" placeholder="{{ __('profile.zipcode_placeholder') }}" type="text"  autofocus autocomplete="name" />
                                    <x-input-error field_name="form.zipcode" />
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group am-form-btns">
                        <span>{{ __('profile.latest_changes_the_live') }}</span>
                        <x-primary-button wire:target="updateInfo" wire:loading.class="am-btn_disable" >{{ __('general.save_update') }}</x-primary-button>
                    </div>
                </fieldset>
            @endif
        </form>
    </div>
@push('scripts' )
@if($enableGooglePlaces == '1')
    <script async src="https://maps.googleapis.com/maps/api/js?key={{ $googleApiKey }}&libraries=places&loading=async&callback=initializePlaceApi"></script>
 @endif
@endpush
@push('scripts' )
    @if($enableGooglePlaces == '1')
    <script>
        function initializePlaceApi() {
            var tutorAddress = document.getElementById('tutor_location_field');
            if (!tutorAddress) {
                setTimeout(initializePlaceApi, 500); 
                return;
            }
            tutorAddress.addEventListener('input', function(e) {
                    if (e.target.value == '') {
                        @this.set('form.address', '');
                    }
            });
            if(typeof google != 'undefined' && typeof google.maps.places != 'undefined'){
                var autocompleteTutor = new google.maps.places.Autocomplete(tutorAddress);
                google.maps.event.addListener(autocompleteTutor, 'place_changed', function () {
                    var place = autocompleteTutor.getPlace();
                    var address = place.formatted_address;
                    var lat = place.geometry.location.lat()
                    var lng =place.geometry.location.lng()
                    place.address_components?.forEach((item) => {
                    if(item.types.includes('country')){
                        @this.set('form.countryName', item.short_name);
                    }
                    });
                    @this.set('form.address', address);
                    @this.set('form.lat', lat);
                    @this.set('form.lng', lng);
                });
            }
        }
        @if($enableGooglePlaces == '1')
             initializePlaceApi()
         @endif
    </script>
    @endif
    <script type="text/javascript" data-navigate-once>
        var component = '';
        document.addEventListener('livewire:navigated', function() {
                component = @this;
        },{ once: true });
        document.addEventListener('loadPageJs', (event) => {
            component.dispatch('initSelect2', {target:'.am-select2'});
            setTimeout(() => {
                @if($enableGooglePlaces == '1')
                    initializePlaceApi()
                @endif
            }, 500);

        })
    </script>
 @endpush

