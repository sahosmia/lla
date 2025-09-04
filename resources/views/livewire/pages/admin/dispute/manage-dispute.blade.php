<div class="am-dispute-container">
  <div class="am-dispute-wrapper">
    <button class="am-dispute-chat-toggle">
      <i class="icon-arrow-right"></i>
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

        <!-- Resolution Form -->
        <div class="am-dispute-resolution">
          <h4>{{ __('dispute.resolution') }}</h4>
          <div class="am-resolution-form">
            <div class="am-form-group">
              <label class="am-form-heading">{{  $dispute?->winner_id ? __('dispute.winning_party') : __('dispute.select_winning_party') }}</label>
              <div class="am-radio-group ">
                <div class="am-radio-item @if($dispute?->status == 'closed' && $dispute?->winner_id == $dispute?->creatorBy?->id) am-radio-group-disable @endif">
                  <label>{{ __('dispute.tutor') }}</label>
                  <label class="am-radio">
                    <input type="radio" wire:click="setWinningParty('{{ $dispute?->status !== 'closed' ? 'tutor' : 'not_show' }}')"  name="winner" @if($dispute?->status == 'closed' && $dispute?->winner_id == $dispute?->responsibleBy?->id) checked @endif >
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
                    <i class="am-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.52606 0.903961C4.80953 0.25 6.48969 0.25 9.85 0.25H12.15C15.5103 0.25 17.1905 0.25 18.4739 0.903962C19.6029 1.4792 20.5208 2.39709 21.096 3.52606C21.75 4.80953 21.75 6.48969 21.75 9.85V12.15C21.75 15.5103 21.75 17.1905 21.096 18.4739C20.5208 19.6029 19.6029 20.5208 18.4739 21.096C17.1905 21.75 15.5103 21.75 12.15 21.75H9.85C6.48969 21.75 4.80953 21.75 3.52606 21.096C2.39708 20.5208 1.4792 19.6029 0.903961 18.4739C0.25 17.1905 0.25 15.5103 0.25 12.15V9.85C0.25 6.48969 0.25 4.80953 0.903962 3.52606C1.4792 2.39708 2.39709 1.4792 3.52606 0.903961ZM16.5303 8.53033C16.8232 8.23744 16.8232 7.76256 16.5303 7.46967C16.2374 7.17678 15.7626 7.17678 15.4697 7.46967L10 12.9393L8.03033 10.9697C7.73744 10.6768 7.26256 10.6768 6.96967 10.9697C6.67678 11.2626 6.67678 11.7374 6.96967 12.0303L9.46967 14.5303C9.76256 14.8232 10.2374 14.8232 10.5303 14.5303L16.5303 8.53033Z" fill="#17B26A"/>
                      </svg>
                    </i>
                  </label>
                </div>
                <div class="am-radio-item @if($dispute?->status == 'closed' && $dispute?->winner_id == $dispute?->responsibleBy?->id) am-radio-group-disable @endif">
                  <label>{{ __('dispute.student') }}</label>
                  <label class="am-radio">
                      <input type="radio"  wire:click="setWinningParty('{{ $dispute?->status !== 'closed' ? 'student' : 'not_show' }}')" name="winner" @if($dispute?->status == 'closed' && $dispute?->winner_id == $dispute?->creatorBy?->id) checked @endif >
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
                    <i class="am-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.52606 0.903961C4.80953 0.25 6.48969 0.25 9.85 0.25H12.15C15.5103 0.25 17.1905 0.25 18.4739 0.903962C19.6029 1.4792 20.5208 2.39709 21.096 3.52606C21.75 4.80953 21.75 6.48969 21.75 9.85V12.15C21.75 15.5103 21.75 17.1905 21.096 18.4739C20.5208 19.6029 19.6029 20.5208 18.4739 21.096C17.1905 21.75 15.5103 21.75 12.15 21.75H9.85C6.48969 21.75 4.80953 21.75 3.52606 21.096C2.39708 20.5208 1.4792 19.6029 0.903961 18.4739C0.25 17.1905 0.25 15.5103 0.25 12.15V9.85C0.25 6.48969 0.25 4.80953 0.903962 3.52606C1.4792 2.39708 2.39709 1.4792 3.52606 0.903961ZM16.5303 8.53033C16.8232 8.23744 16.8232 7.76256 16.5303 7.46967C16.2374 7.17678 15.7626 7.17678 15.4697 7.46967L10 12.9393L8.03033 10.9697C7.73744 10.6768 7.26256 10.6768 6.96967 10.9697C6.67678 11.2626 6.67678 11.7374 6.96967 12.0303L9.46967 14.5303C9.76256 14.8232 10.2374 14.8232 10.5303 14.5303L16.5303 8.53033Z" fill="#17B26A"/>
                      </svg>
                    </i>
                  </label>
                </div>
              </div>
            </div>
            @if($winningParty == "student" || $winningParty == "tutor")  
            <div class="am-form-group @error('comment') @enderror">
                <label class="fw-important">{{ __('dispute.leave_comment') }} {{ $winningParty == 'student' ? 'student' : 'tutor' }} </label>
                <textarea wire:model.live="comment" class="form-control @error('comment') tk-invalid @enderror" placeholder="Write here..."></textarea>
                @error('comment')
                  <div class="tk-errormsg">
                      <span>{{$message}}</span>
                  </div>
                  @enderror
              </div>
              @endif
            </div>
          </div>
      </div>    
      @if($winningParty == "student" || $winningParty == "tutor")
      <button wire:click="resolveDispute({{ $dispute?->disputable_id }})" class="am-btn">{{ __('dispute.resolve_dispute') }}</button>
      @endif
    </div>

    <!-- Right Side - Chat Interface -->
    <div class="am-dispute-chat">
      <!-- Chat Header with Users -->
      <div class="am-user-profile">
        <!-- Left side single user -->
  
        @if($withChat=='student')
            <div class="am-user-card">
            <div class="am-user-avatar">
                @if (!empty($dispute?->creatorBy?->profile?->image) && Storage::disk(getStorageDisk())->exists($dispute?->creatorBy?->profile?->image))
                <img src="{{ resizedImage($dispute?->creatorBy?->profile?->image,34,34) }}" alt="{{$dispute?->creatorBy?->profile?->image}}" />
                @else
                    <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $userChat[0]->user?->profile?->image }}" />
                @endif
            </div>
            <div class="am-user-info">
                <h5 class="am-user-name">{{ $dispute?->creatorBy?->profile?->full_name }}</h5>
                <span class="am-user-role">{{ ucfirst($dispute?->creatorBy?->role) }}</span>
            </div>
            </div>
        @elseif($withChat=='tutor')
            <div class="am-user-card">
            <div class="am-user-avatar">
                @if (!empty($dispute?->responsibleBy?->profile?->image) && Storage::disk(getStorageDisk())->exists($dispute?->responsibleBy?->profile?->image))
                <img src="{{ resizedImage($dispute?->responsibleBy?->profile?->image,34,34) }}" alt="{{$dispute?->responsibleBy?->profile?->image}}" />
                @else
                    <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $userChat[0]->user?->profile?->image }}" />
                @endif
            </div>
            <div class="am-user-info">
                <h5 class="am-user-name">{{ $dispute?->responsibleBy?->profile?->full_name }}</h5>
                <span class="am-user-role">{{ ucfirst($dispute?->responsibleBy?->role) }}</span>
            </div>
            </div>
        @endif
        
        <!-- Right side multiple users -->
        <div class="am-user-list">
          <div wire:click="changeChat('student')" class="am-user-item {{ $withChat == 'student' ? 'active' : '' }}">
            <div class="am-user-avatar">
            @if (!empty($dispute?->creatorBy?->profile?->image) && Storage::disk(getStorageDisk())->exists($dispute?->creatorBy?->profile?->image))
              <img src="{{ resizedImage($dispute?->creatorBy?->profile?->image,34,34) }}" alt="{{$dispute?->creatorBy?->profile?->image}}" />
            @else
                <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $dispute?->creatorBy?->profile?->image }}" />
            @endif
            </div>
            <div class="am-user-info">      
              <h5 class="am-user-name">{{ $dispute?->creatorBy?->profile?->full_name }}</h5>
              <span class="am-user-role">{{ ucfirst($dispute?->creatorBy?->role) }}</span>
            </div>
          </div>
          <div wire:click="changeChat('tutor')" class="am-user-item {{ $withChat == 'tutor' ? 'active' : '' }}">
            <div class="am-user-avatar">
            @if (!empty($dispute?->responsibleBy?->profile?->image) && Storage::disk(getStorageDisk())->exists($dispute?->responsibleBy?->profile?->image))
              <img src="{{ resizedImage($dispute?->responsibleBy?->profile?->image,34,34) }}" alt="{{$dispute?->responsibleBy?->profile?->image}}" />
            @else
                <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $dispute?->responsibleBy?->profile?->image }}" />
            @endif
            </div>
            <div class="am-user-info">
              <h5 class="am-user-name">{{ $dispute?->responsibleBy?->profile?->full_name }}</h5>
              <span class="am-user-role">{{ ucfirst($dispute?->responsibleBy?->role) }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Chat Messages -->
      <div class="am-chat-messages am-custom-scrollbar-y">
        @if($withChat == 'tutor' && ($dispute?->status == 'pending' || $dispute?->status == 'under_review')) 
        <div class="am-page-error">
              <div class="am-norecord-wrap">
                  <figure><img src="{{ asset('images/dispute-empty-case.png') }}" alt="no record"></figure>
                  <h5>{{ __('dispute.no_messages_yet') }}</h5>
                  <span>{{ __('dispute.no_messages_detail') }}</span>
              </div>
          </div>
        @else
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

                  <span class="am-message-time"> 
                    @if(setting('_lernen.time_format') == '12') 
                        {{ \Carbon\Carbon::parse($chat->created_at)->format('h:i A') }}
                    @else
                        {{ \Carbon\Carbon::parse($chat->created_at)->format('H:i') }}
                    @endif
                  <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M14.8056 7.18866C15.0394 7.44267 15.0229 7.83806 14.7689 8.07178L10.0563 12.4079C9.17888 13.2152 7.82907 13.2148 6.95209 12.4071L5.23064 10.8216C4.97674 10.5877 4.96049 10.1923 5.19434 9.93843C5.42819 9.68451 5.82359 9.66826 6.07748 9.9021L7.79893 11.4877C8.19756 11.8548 8.81114 11.855 9.20997 11.488L13.9226 7.15192C14.1766 6.9182 14.572 6.93465 14.8056 7.18866Z" fill="#ACACAC"/>
                  </svg>
                </span>
              </div>
            </div>
            @endforeach
        @endif
      </div>

      <!-- Chat Input -->
      <div class="am-chat-input">
        <textarea wire:model="message" placeholder="{{ __('dispute.type_your_message_here') }}"></textarea>
        <div class="am-tooltip-wrap">
          <button wire:target="sendMessage" wire:loading.class="am-btn_loader" wire:click="sendMessage" class="am-tooltip am-btn @disabled($dispute?->status == 'closed' || trim($message) == '') @if($dispute?->status == 'closed' || trim($message) == '') am-btn_disable @endif" @disabled($dispute?->status == 'closed' || trim($message) == '')>{{ __('dispute.send') }}
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14" fill="none">
              <path d="M6.17509 8.32174L5.91218 11.5853C5.78764 13.1314 7.80483 13.8266 8.65925 12.5321L14.8735 3.11672C15.5543 2.08529 14.7656 0.719284 13.532 0.793123L2.28733 1.46618C0.73794 1.55892 0.332427 3.65569 1.73552 4.31944L4.68808 5.71616" stroke="#F7F7F8" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
              <path d="M8.20508 5.41766L10.6278 4.01891" stroke="#F7F7F8" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/>
            </svg>
          </button>
          @if($dispute?->status == 'closed')  
             <span class="am-tooltip-text">{{$closeDisputeMessage}}</span>
          @endIf
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
          } else if(disputeStatus !== 'closed') {
              sendMessageButton.disabled = false;
              sendMessageButton.classList.remove('am-btn_disable');
          }
      });
      messageTextarea.addEventListener('keydown', (e) => {
          if (e.key === 'Enter' && !e.shiftKey) {
              e.preventDefault();
              if(disputeStatus !== 'closed') {
                  sendMessageButton.click();
              }
          }
      });
  });
</script>
