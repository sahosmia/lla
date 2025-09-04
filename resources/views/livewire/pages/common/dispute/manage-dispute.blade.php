<div class="am-dispute-container">
  <div class="am-dispute-wrapper">
    <button class="am-dispute-chat-toggle">
      <i class="am-icon-arrow-right"></i>
    </button>
    <!-- Left Side - Dispute Details -->
    <div wire:ignore.self class="am-dispute-details">
      <!-- Header -->
      <div class="am-dispute-header">
        <div class="am-dispute-id">
          <h4>{{ __('dispute.dispute_id') }}: #{{ $dispute?->uuid }}</h4>
              <span class="am-status-badge am-{{str_replace('_', '-', $dispute?->status)}}">{{ ucfirst(str_replace('_', ' ', $dispute?->status)) }}</span>
        </div>
      </div>

      <!-- Content -->
    <div class="am-dispute-content am-custom-scrollbar-y">
        <!-- Info List -->
        <ul class="am-dispute-list">
          <li class="am-dispute-item">
            <span>{{ __('dispute.date_created') }}</span>
            <strong>{{ \Carbon\Carbon::parse($dispute?->created_at)->format('F j, Y, g:i A') }}</strong>
          </li>
          <li class="am-dispute-item">
            <span>{{ __('dispute.reason') }}</span>
            <strong>{{ $dispute?->dispute_reason }}</strong>
          </li>
          <li class="am-dispute-item">
            <span>{{ __('dispute.session') }}</span>
            <div>
            <strong>{{ $dispute?->booking?->subject?->slot?->subjectGroup?->subject?->name }}</strong>
              <span>{{ $dispute?->booking?->slot?->subjectGroup?->group->name }} {{ \Carbon\Carbon::parse($dispute?->booking?->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($dispute?->booking?->end_time)->format('g:i A') }}</span>
            </div>
          </li>
          <li class="am-dispute-item">
            <span>{{ __('dispute.tutor') }}</span>
            <div class="am-dispute-user">
              <figure>
                @if (!empty($dispute?->responsibleBy?->profile?->image) && Storage::disk(getStorageDisk())->exists($dispute?->responsibleBy?->profile?->image))
                <img src="{{ resizedImage($dispute?->responsibleBy?->profile?->image,34,34) }}" alt="{{$dispute?->responsibleBy?->profile?->image}}" />
                @else
                    <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $dispute?->responsibleBy?->profile?->image }}" />
                @endif
              </figure>
              <div>
                <strong>{{ $dispute?->responsibleBy?->profile?->full_name }}</strong>
                <em>{{ $dispute?->responsibleBy?->email }}</em>
              </div>
            </div>
          </li>
          <li class="am-dispute-item">
            <span>{{ __('dispute.student') }}</span>
            <div class="am-dispute-user">
              <figure>
                @if (!empty($dispute?->creatorBy?->profile?->image) && Storage::disk(getStorageDisk())->exists($dispute?->creatorBy?->profile?->image))
                <img src="{{ resizedImage($dispute?->creatorBy?->profile?->image,34,34) }}" alt="{{$dispute?->creatorBy?->profile?->image}}" />
                @else
                    <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $dispute?->creatorBy?->profile?->image }}" />
                @endif
              </figure>
              <div>
                <strong>{{ $dispute?->creatorBy?->profile?->full_name }}</strong>
                <em>{{ $dispute?->creatorBy?->email }}</em>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <!-- Right Side - Chat Interface -->
    <div class="am-dispute-chat">
      <!-- Chat Header with Users -->
      <div class="am-user-profile">
        <!-- Left side single user -->
        <div class="am-user-card">
          <div class="am-user-avatar">
            @if (!empty($admin?->profile?->image) && Storage::disk(getStorageDisk())->exists($admin?->profile?->image))
                <img src="{{ resizedImage($admin?->profile?->image,34,34) }}" alt="{{$admin?->profile?->image}}" />
            @else
                <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $admin?->profile?->image }}" />
            @endif
          </div>
          <div class="am-user-info">
            <h5 class="am-user-name">{{ $admin?->profile?->full_name }}</h5>
            <span class="am-user-role">{{ ucfirst($admin?->role) }}</span>
          </div>
        </div>
      </div>

      <!-- Chat Messages -->
      <div class="am-chat-messages am-custom-scrollbar-y">
        @if($userChat->count() > 0)
        @foreach($userChat as $chat)
        <div class="am-message {{ $chat->user_id == $user->id ? 'am-reply-message' : '' }}">
          <div class="am-message-avatar">
            @if (!empty($chat->user?->profile?->image) && Storage::disk(getStorageDisk())->exists($chat->user?->profile?->image))
                <img src="{{ resizedImage($chat->user?->profile?->image,34,34) }}" alt="{{$chat->user?->profile?->image}}" />
            @else
                <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $chat->user?->profile?->image }}" />
            @endif
          </div>
          <div class="am-message-content-wrapper">
            <div class="am-message-header">
              <span class="am-message-name">{{ $chat->user?->profile?->full_name }}</span>
            </div>
            <div class="am-message-content">
              <p>{{ $chat->message }}</p>
            </div>
            <div class="am-message-wrap">
              @if($dispute?->status == 'pending' && auth()->user()->role == 'student')
                 <p>{{ $pendingDisputeMessage }}</p>
              @endif
              <span class="am-message-time">
                @if(setting('_lernen.time_format') == '12') 
                    {{ \Carbon\Carbon::parse($chat->created_at)->format('h:i A') }}
                @else
                    {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                @endif
                <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M14.8056 7.18866C15.0394 7.44267 15.0229 7.83806 14.7689 8.07178L10.0563 12.4079C9.17888 13.2152 7.82907 13.2148 6.95209 12.4071L5.23064 10.8216C4.97674 10.5877 4.96049 10.1923 5.19434 9.93843C5.42819 9.68451 5.82359 9.66826 6.07748 9.9021L7.79893 11.4877C8.19756 11.8548 8.81114 11.855 9.20997 11.488L13.9226 7.15192C14.1766 6.9182 14.572 6.93465 14.8056 7.18866Z" fill="#ACACAC"/>
                </svg>
            </div>
            </span>
          </div>
        </div>
        @endforeach
        @elseif($dispute?->status == 'pending')
        <div class="am-page-error">
          <div class="am-norecord-wrap">
            <div class="am-message">
                <p>{{ __('dispute.no_dispute_request_message') }}</p>
              </div>
          </div>
        </div>
        @endif
      </div>

      <!-- Chat Input -->
      <div class="am-chat-input">
        <textarea wire:model="message" placeholder="{{ __('dispute.type_your_message_here') }}"></textarea>
          <div class="am-tooltip-wrap">
            <button wire:target="sendMessage" wire:loading.class="am-btn_loader" @if($dispute?->status == 'pending'|| $dispute?->status == 'closed' || trim($message) == '') disabled @endif wire:click="sendMessage" class="am-tooltip am-btn @if($dispute?->status == 'pending'|| $dispute?->status == 'closed' || trim($message) == '') am-btn_disable @endif">
              {{ __('dispute.send') }}  
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14" fill="none">
                <path d="M6.17509 8.32174L5.91218 11.5853C5.78764 13.1314 7.80483 13.8266 8.65925 12.5321L14.8735 3.11672C15.5543 2.08529 14.7656 0.719284 13.532 0.793123L2.28733 1.46618C0.73794 1.55892 0.332427 3.65569 1.73552 4.31944L4.68808 5.71616" stroke="#F7F7F8" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
                <path d="M8.20508 5.41766L10.6278 4.01891" stroke="#F7F7F8" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
              </svg>
            </button>
              @if($dispute?->status == 'closed' || $dispute?->status == 'pending' )  
                <span class="am-tooltip-text">{{$dispute?->status == 'pending' ? $pendingDisputeMessage : $closeDisputeMessage}}</span>
              @endif
          </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('livewire:initialized', () => {
      Livewire.on('messageSent', () => {
          setTimeout(() => {
              const chatMessages = document.querySelector('.am-chat-messages');
              chatMessages.scrollTop = chatMessages.scrollHeight;
          }, 0);
      });
  });

  document.addEventListener('DOMContentLoaded', () => {
      const disputeStatus = @json($dispute?->status);
      const sendMessageButton = document.querySelector('.am-chat-input button');
      const messageTextarea = document.querySelector('.am-chat-input textarea');
      messageTextarea.addEventListener('input', () => {
          if (messageTextarea.value.trim() === '') {
              sendMessageButton.disabled = true;
              sendMessageButton.classList.add('am-btn_disable');
          } else if(disputeStatus == 'under_review' || disputeStatus == 'in_discussion') {
              sendMessageButton.disabled = false;
              sendMessageButton.classList.remove('am-btn_disable');
          }
      });
      messageTextarea.addEventListener('keydown', (e) => {
          if (e.key === 'Enter' && !e.shiftKey) {
              e.preventDefault();              
              if(disputeStatus == 'under_review' || disputeStatus == 'in_discussion') {
                  sendMessageButton.click();
              }
          }
      });
  });
</script>