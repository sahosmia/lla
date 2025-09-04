<div class="am-profile-setting">
    @slot('title')
        {{ __('profile.account_settings') }}
    @endslot
    @include('livewire.pages.common.profile-settings.tabs')
    <div class="am-userperinfo">
        <div class="am-title_wrap">
            <div class="am-title">
                <h2>{{ __('passwords.change_password') }}</h2>
                <p>{{ __('passwords.change_password_detail') }}</p>
            </div>
        </div>
        <form  class="am-themeform am-accountsetting">
            <fieldset>
                <div class="form-group">
                    <x-input-label for="gender" class="am-important" :value="__('passwords.update_password')" />
                    <div class="form-group-two-wrap">
                        <div class="form-control_wrap @error('password') am-invalid @enderror">
                            <x-text-input wire:model="password"  placeholder="{{ __('passwords.password') }}" type="password"  autofocus autocomplete="name" />
                            <x-input-error field_name="password" />
                        </div>
                        <div class="form-control_wrap  @error('confirm') am-invalid @enderror">
                            <x-text-input wire:model="confirm" class="{{ $errors->get($confirm) ? 'am-invalid' : '' }}" placeholder="{{ __('passwords.re_type_password') }}" type="password"  autofocus autocomplete="name" />
                            <x-input-error field_name="confirm" />
                        </div>
                    </div>
                </div>
                <div class="form-group am-form-btns">
                    <span>{{ __('passwords.latest_changes_live') }}</span>
                    <button wire:click="updatePassword" wire:target="updatePassword" type="button" wire:loading.class="am-btn_disable" class="am-btn">{{ __('passwords.update_password') }}</button>
                </div>
            </fieldset>
        </form>
        <div class="am-title_wrap">
            <div class="am-title">
                <h2>{{ __('settings.update_time_zone') }}</h2>
                <p>{{ __('settings.time_zone_settings_easily') }}</p>
            </div>
        </div>
        <form  class="am-themeform am-accountsetting">
            <fieldset>
                <div class="form-group @error('timezone') tu-invalid @enderror">
                    <label class="am-label am-important">{{ __('settings.timezone') }}</label>
                    <div class="am-select @error('timezone') am-invalid @enderror" wire:ignore>
                        <select data-componentid="@this" class="am-select2" value={{  $timezone}} data-searchable="true" id="timezone" data-wiremodel="timezone" id="timezone"
                            data-placeholder="{{ __('settings.timezone_placeholder') }}"
                            data-placeholderinput="{{ __('settings.timezone_placeholder') }}"
                            >
                            <option value="" selected label="{{ __('settings.timezone_placeholder') }}"></option>
                            @foreach (timezone_identifiers_list() as $tz)
                                <option value="{{ $tz }}" {{ $timezone == $tz ? 'selected' : '' }} >{{ $tz }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <x-input-error field_name="timezone" />
                <div class="form-group am-form-btns">
                    <span>{{ __('passwords.latest_changes_live') }}</span>
                    <button wire:click="saveTimezone" wire:target="saveTimezone" type="button" wire:loading.class="am-btn_disable" class="am-btn">{{ __('settings.save_update') }}</button>
                </div>
            </fieldset>
        </form>
        <div class="am-title_wrap">
            <div class="am-title">
                <h2>{{ __('passwords.link_google_calendar') }}</h2>
                <p>{{ __('passwords.link__google_calendar_schedule') }}</p>
            </div>
        </div>
        <div class="am-linkaccount">
            @if(!empty($getAccountSetting['google_access_token']))
            <div class="am-linkaccount_option">
                <div class="am-linkaccount_option_title">
                    <span>{{ __('passwords.connected_account') }}</span>
                    @if(isset($getAccountSetting['google_calendar_info']['summary']))
                        <h4>{{ $getAccountSetting['google_calendar_info']['summary'] }}</h4>
                    @endif
                </div>
                <a wire:click.prevent="disconnectCalender" href="#" wire:target="disconnectCalender"  wire:loading.class="am-btn_disable" class="am-linkbtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><g clip-path="url(#clip0_689_18487)"><path d="M23.7663 12.2765C23.7663 11.4608 23.7001 10.6406 23.559 9.83813H12.2402V14.4591H18.722C18.453 15.9495 17.5888 17.2679 16.3233 18.1056V21.104H20.1903C22.4611 19.014 23.7663 15.9274 23.7663 12.2765Z" fill="#4285F4"/><path d="M12.2401 24.0008C15.4766 24.0008 18.2059 22.9382 20.1945 21.1039L16.3276 18.1055C15.2517 18.8375 13.8627 19.252 12.2445 19.252C9.11388 19.252 6.45946 17.1399 5.50705 14.3003H1.5166V17.3912C3.55371 21.4434 7.7029 24.0008 12.2401 24.0008Z" fill="#34A853"/><path d="M5.50277 14.3002C5.00011 12.8099 5.00011 11.196 5.50277 9.70569V6.61475H1.51674C-0.185266 10.0055 -0.185266 14.0004 1.51674 17.3912L5.50277 14.3002Z" fill="#FBBC04"/><path d="M12.2401 4.74966C13.9509 4.7232 15.6044 5.36697 16.8434 6.54867L20.2695 3.12262C18.1001 1.0855 15.2208 -0.034466 12.2401 0.000808666C7.7029 0.000808666 3.55371 2.55822 1.5166 6.61481L5.50264 9.70575C6.45064 6.86173 9.10947 4.74966 12.2401 4.74966Z" fill="#EA4335"/></g><defs><clipPath id="clip0_689_18487"><rect width="24" height="24" fill="white"/></clipPath></defs></svg>
                    {{ __('passwords.disconnect_google_calendar') }}
                </a>
            </div>
            @else
            <div class="am-linkaccount_option">
                <div class="am-linkaccount_option_title">
                    <span>{{ __('passwords.no_calendar_linked') }}</span>
                </div>
                <a wire:click.prevent="connectCalender" href="#" wire:target="connectCalender"  wire:loading.class="am-btn_disable" class="am-linkbtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><g clip-path="url(#clip0_689_18487)"><path d="M23.7663 12.2765C23.7663 11.4608 23.7001 10.6406 23.559 9.83813H12.2402V14.4591H18.722C18.453 15.9495 17.5888 17.2679 16.3233 18.1056V21.104H20.1903C22.4611 19.014 23.7663 15.9274 23.7663 12.2765Z" fill="#4285F4"/><path d="M12.2401 24.0008C15.4766 24.0008 18.2059 22.9382 20.1945 21.1039L16.3276 18.1055C15.2517 18.8375 13.8627 19.252 12.2445 19.252C9.11388 19.252 6.45946 17.1399 5.50705 14.3003H1.5166V17.3912C3.55371 21.4434 7.7029 24.0008 12.2401 24.0008Z" fill="#34A853"/><path d="M5.50277 14.3002C5.00011 12.8099 5.00011 11.196 5.50277 9.70569V6.61475H1.51674C-0.185266 10.0055 -0.185266 14.0004 1.51674 17.3912L5.50277 14.3002Z" fill="#FBBC04"/><path d="M12.2401 4.74966C13.9509 4.7232 15.6044 5.36697 16.8434 6.54867L20.2695 3.12262C18.1001 1.0855 15.2208 -0.034466 12.2401 0.000808666C7.7029 0.000808666 3.55371 2.55822 1.5166 6.61481L5.50264 9.70575C6.45064 6.86173 9.10947 4.74966 12.2401 4.74966Z" fill="#EA4335"/></g><defs><clipPath id="clip0_689_18487"><rect width="24" height="24" fill="white"/></clipPath></defs></svg>
                    {{ __('passwords.connect_google_calendar') }}
                </a>
            </div>
            @endif
            @if(!empty($getAccountSetting['google_access_token']))
            <div class="am-reminder">
                <div class="am-reminder_title">
                    <h3>{{ __('passwords.remind_me') }}</h3>
                    <p>{{ __('passwords.reminder_scheduled_lesson') }}</p>
                </div>
                <div class="am-reminder_option">
                    <div class="am-radio">
                        <input type="radio" wire:model="reminder" id="before1" value={{15}} name="reminder">
                        <label for="before1">{{ __('passwords.15_min_before_lesson') }}</label>
                    </div>
                    <div class="am-radio">
                        <input wire:model="reminder"  value={{30}} type="radio" id="nonoti" name="reminder">
                        <label for="nonoti">{{ __('passwords.30_min_before_lesson') }}</label>
                    </div>
                    <div class="am-radio">
                        <input wire:model="reminder" value={{60}} type="radio" id="before2" name="reminder">
                        <label for="before2">{{ __('passwords.60_min_before_lesson') }}</label>
                    </div>
                    <div class="am-radio">
                        <input type="radio" wire:model="reminder" value={{1440}} id="before3" name="reminder">
                        <label for="before3">{{ __('passwords.24_hours_before_lesson') }}</label>
                    </div>
                </div>
            </div>
            <div class="am-form-btns">
                <span>{{ __('passwords.update_changes_live') }}</span>
                <button  wire:click="saveReminder" wire:target="saveReminder" type="submit" wire:loading.class="am-btn_disable" type="button" class="am-btn">{{ __('passwords.Save_update') }}</button>
            </div>
            @endif
        </div>
        <div class="am-linkaccount">
            @if(!empty($getAccountSetting['google_access_token']))
            <div class="am-linkaccount_option">
                <div class="am-linkaccount_option_title">
                    <span>{{ __('passwords.connected_account') }}</span>
                    @if(isset($getAccountSetting['google_calendar_info']['summary']))
                        <h4>{{ $getAccountSetting['google_calendar_info']['summary'] }}</h4>
                    @endif
                </div>
                <a wire:click.prevent="disconnectCalender" href="#" wire:target="disconnectCalender"  wire:loading.class="am-btn_disable" class="am-linkbtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><g clip-path="url(#clip0_689_18487)"><path d="M23.7663 12.2765C23.7663 11.4608 23.7001 10.6406 23.559 9.83813H12.2402V14.4591H18.722C18.453 15.9495 17.5888 17.2679 16.3233 18.1056V21.104H20.1903C22.4611 19.014 23.7663 15.9274 23.7663 12.2765Z" fill="#4285F4"/><path d="M12.2401 24.0008C15.4766 24.0008 18.2059 22.9382 20.1945 21.1039L16.3276 18.1055C15.2517 18.8375 13.8627 19.252 12.2445 19.252C9.11388 19.252 6.45946 17.1399 5.50705 14.3003H1.5166V17.3912C3.55371 21.4434 7.7029 24.0008 12.2401 24.0008Z" fill="#34A853"/><path d="M5.50277 14.3002C5.00011 12.8099 5.00011 11.196 5.50277 9.70569V6.61475H1.51674C-0.185266 10.0055 -0.185266 14.0004 1.51674 17.3912L5.50277 14.3002Z" fill="#FBBC04"/><path d="M12.2401 4.74966C13.9509 4.7232 15.6044 5.36697 16.8434 6.54867L20.2695 3.12262C18.1001 1.0855 15.2208 -0.034466 12.2401 0.000808666C7.7029 0.000808666 3.55371 2.55822 1.5166 6.61481L5.50264 9.70575C6.45064 6.86173 9.10947 4.74966 12.2401 4.74966Z" fill="#EA4335"/></g><defs><clipPath id="clip0_689_18487"><rect width="24" height="24" fill="white"/></clipPath></defs></svg>
                    {{ __('passwords.disconnect_google_calendar') }}
                </a>
            </div>
            
            @endif
            
        </div>
        @if(setting('_api.active_conference') == 'zoom')
            <div class="am-title_wrap">
                <div class="am-title">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>{{ __('settings.link_zoom_account') }}</h2>
                    </div>
                    <p>{!! __('settings.link_zoom_account_msg') !!}</p>
                </div>
            </div>
            <form  class="am-themeform am-accountsetting am-zoomsetting">
                <fieldset>
                    <div class="form-group @error('zoom_account_id') tu-invalid @enderror">
                        <label class="am-label am-important">{{ __('settings.zoom_account_id') }}</label>
                        <div class="w-100">
                            <div class="form-control_wrap @error('zoom_account_id') am-invalid @enderror" wire:ignore>
                                <x-text-input wire:model="zoom_account_id"  placeholder="{{ __('settings.zoom_account_id_placeholder') }}" type="text"  autofocus autocomplete="name" />
                            </div>
                            <x-input-error field_name="zoom_account_id" />
                        </div>
                    </div>
                    <div class="form-group @error('zoom_client_id') tu-invalid @enderror">
                        <label class="am-label am-important">{{ __('settings.zoom_client_id') }}</label>
                        <div class="w-100">
                            <div class="form-control_wrap @error('zoom_client_id') am-invalid @enderror" wire:ignore>
                                <x-text-input wire:model="zoom_client_id"  placeholder="{{ __('settings.zoom_client_id_placeholder') }}" type="text"  autofocus autocomplete="name" />
                            </div>
                            <x-input-error field_name="zoom_client_id" />
                        </div>
                    </div>
                    <div class="form-group @error('zoom_client_secret') tu-invalid @enderror">
                        <label class="am-label am-important">{{ __('settings.zoom_client_secret') }}</label>
                        <div class="w-100">
                            <div class="form-control_wrap @error('zoom_client_secret') am-invalid @enderror" wire:ignore>
                            <x-text-input wire:model="zoom_client_secret"  placeholder="{{ __('settings.zoom_client_secret_placeholder') }}" type="text"  autofocus autocomplete="name" />
                        </div>
                        <x-input-error field_name="zoom_client_secret" />
                        </div>
                        
                    </div>
                    <div class="form-group am-form-btns">
                        @if(!$zoom_error  && (!empty($zoom_account_id) || !empty($zoom_client_id) || !empty($zoom_client_secret)))
                            <button @click="$wire.dispatch('showConfirm', { action: 'clear-zoom', content: `{{ __('settings.confirm_reset_zoom_credentials') }}` })" type="button" class="am-white-btn">{{ __('settings.reset') }}</button>
                        @endif
                        <span>{{ __('passwords.latest_changes_live') }}</span>
                        <button wire:click="saveZoomSettings" wire:target="saveZoomSettings" type="button" wire:loading.class="am-btn_disable" class="am-btn">{{ __('settings.save_update') }}</button>
                    </div>
                </fieldset>
            </form>
        @endif
        @if(session()->get('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Livewire.dispatch('showAlertMessage', {
                        type: 'error',
                        title: 'Failed Google Calendar',
                        message: "Failed to retrieve Google token. Please try again."
                    });
                });
            </script>
        @endif
        @if(session()->get('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Livewire.dispatch('showAlertMessage', {
                        type: 'success',
                        title: 'Connect Google Calendar',
                        message: "{{ __('passwords.connect_calender') }}"
                    });
                });
            </script>
        @endif
    </div>
</div>
