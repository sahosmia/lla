<div class="am-allnotifications" wire:ignore.self>
    <div class="am-allnotifications_content">
        <div class="am-allnotifications_title">
            <h2>{{ __('general.notifications') }}</h2>
            @if(auth()->user()->unreadNotifications->isNotEmpty())
                <span wire:click="markAllAsRead"> <i class="am-icon-check-circle02"></i> {{ __('general.mark_all_as_read') }}</span>
            @endif
        </div>
        @if($notifications->isNotEmpty())
            <ul class="am-notificationslist">
                @foreach($notifications as $notification)
                    <li>
                        <div class="am-notificationslist_item @if(!empty($notification->read_at)) am-seen @endif">
                            <div class="am-notify-msg">
                                @if(!empty(setting('_general.notification_image')))
                                    <figure>
                                        <img src="{{ url(Storage::url(setting('_general.notification_image')[0]['path'])) }}" alt="icon">
                                    </figure>
                                @endif
                                <div class="am-notifyuser-detail">
                                    <h5>{{ $notification->data['subject'] ?? '' }}</h5>
                                    <p>{!! $notification->data['content'] ?? '' !!}</p>
                                    @if(!empty($notification->data['has_link']) && !empty($notification->data['link_target']) && !empty($notification->data['link_text']))
                                        <a href="javascript:;" wire:click.prevent="markAsRead('{{ $notification->id }}', '{{ $notification->data['link_target'] }}')" class="am-btn">{{ $notification->data['link_text'] }}</a>
                                    @endif
                                </div>
                                <span>{{ parseToUserTz($notification->created_at)->shortAbsoluteDiffForHumans() }}</span>
                            </div>
                            @empty($notification->read_at)
                                <div class="am-checkbox am-custom-tooltip" wire:click.prevent="markAsRead('{{ $notification->id }}')">
                                    <input type="checkbox" id="notification-mark" name="notification">
                                    <label for="notification-mark"></label>
                                    <span class="am-tooltip-text">{{ __('general.mark_as_read') }}</span>
                                </div>
                            @endempty
                        </div>
                    </li>
                @endforeach
            </ul>
            @if(auth()->user()->notifications()->count() > $perPage)
                <div class="am-loadmore" wire:loading.class="am-loadmore_loading">
                    <button class="am-btn" wire:click="loadMore" wire:loading.attr="disabled" wire:loading.class="am-btn_disable">{{ __('general.load_more') }}</button>
                </div>
            @endif
            @else
                <div class="am-notify-caughtup">
                    <h4>{{ __('general.all_caught_up') }}</h4>
                    <span>{{ __('general.no_notification_desc') }}</span>
                </div>
         @endif   
    </div>
</div>