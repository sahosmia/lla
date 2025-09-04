<div class="modal fade" :id="'message-model-'+recepientId" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="am-review-detail am-sendmassage-modal">
            <div class="am-review-session">
                <div class="am-modal-header">
                    <h3>{{ __('tutor.send_a_message') }}</h3>
                    <span class="am-closepopup" data-bs-dismiss="modal">
                        <i class="am-icon-multiply-01"></i>
                    </span>
                </div>
                <div id="new-button-container"></div>
                <div class="am-review-user">
                    <a href="#" class="am-review-user-detail">
                        <img :src="tutorInfo?.image ?? ''" :alt="tutorInfo?.name ?? ''">
                        <div class="am-review-user-title">
                            <span x-text="tutorInfo?.name ?? ''"></span>
                            <em x-text="tutorInfo?.tagline ?? ''"></em>
                        </div>
                    </a>
                </div>
                <div class="am-review-details @error('message') am-invalid @enderror">
                    <textarea placeholder="{{ __('tutor.type_message') }}" x-model="message" x-on:input="updateCharLeft"></textarea>
                    @if(!empty($threadId))
                        <span>{{ __('general.char_left') }} 500</span>
                    @else
                        <span x-text="' {{ __('general.char_left') }}' + charLeft"></span>
                    @endif
                    <x-input-error field_name="message" />
                </div>
                <div class="am-sendmassage-modal_btns" wire:key="buttons-{{ $tutor?->id ?? '' }}">
                    <a href="javascript:;" class="am-btn send-message-btn" wire:click="sendMessage" wire:loading.class="am-btn_disable">{{ __('tutor.send_message') }}</a>
                    @if(!empty($threadId))
                        <a href="{{ route('laraguppy.messenger', ['thread_id' => $threadId ]) }}"  class="am-openchat am-custom-tooltip">
                            <span class="am-tooltip-text">
                                <span>{{ __('general.open_chat') }}</span>
                            </span>
                            <i class="am-icon-external-link-02"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
