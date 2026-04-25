<li class="cr-comment_item">
    <div class="cr-villy-about">
        <figure class="cr-villy-img">
            @if ($comment?->creator?->profile?->image)
                <img src="{{ url(Storage::url($comment?->creator?->profile?->image)) }}" alt="{{ __('courses::courses.profile_image') }}" />
            @elseif($comment?->creator?->image)
                <img src="{{ url(Storage::url($comment?->creator?->image)) }}" alt="{{ __('courses::courses.profile_image') }}" />
            @else
                <img src="{{ asset('modules\courses\images\placeholder.png') }}" alt="{{ __('courses::courses.profile_image') }}" />  
            @endif
        </figure>
        <div class="cr-villy-about-content">
            <div class="cr-david-villy-content">
                <div class="cr-david-villy">
                    @if($comment?->creator?->profile)
                        <span>{{ $comment?->creator?->profile?->first_name }} {{ $comment?->creator?->profile?->last_name }}</span>
                    @else
                        <span>{{ $comment?->creator?->first_name }} {{ $comment?->creator?->last_name }}</span>
                    @endif
                </div>
                <em>{{ $comment?->created_at->diffForHumans() }}</em>
            </div>
            <div class="cr-villy-paragraph">
                {!! $comment?->description !!}
            </div>
            <div class="cr-villy-stats">
                <div class="cr-villy-stats_info">
                    <a href="javascript:void(0)"
                    @class([
                        "cr-active-villy",
                        "cr-stats_info-like",
                        "cr-active" => $comment?->likes->count() > 0
                    ])
                   wire:click="likeComment({{ $comment?->id }})">
                        <i class="am-icon-heart-01"></i>
                        <span class="cr-villy-count">
                            @if ($comment?->likes_count > 0)
                                <span>{{ $comment?->likes_count }}</span>
                            @endif
                            <em>{{ __('courses::courses.like') }}</em>
                        </span>
                    </a>
                </div>
                @if(empty($level) || $level <= 2)
                    <div class="cr-villy-stats_info">
                        <a href="javascript:void(0)" onclick="toggleReplySection({{ $comment?->id }})" class="cr-stats_info-reply">
                            <i class="am-icon-chat-03"></i>
                            <span class="cr-villy-count">
                                @if ($comment?->replies_count > 0)
                                    <span class="cr-countreply">{{ $comment?->replies_count }}</span>
                                @endif
                                <em id="reply-count-{{ $comment?->id }}">{{ $comment?->replies_count > 1 ? __('courses::courses.replies') : __('courses::courses.reply') }}</em>
                            </span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if ($comment?->replies->isNotEmpty())
        @if (!isset($level))
            @php $level = 1; @endphp
        @endif
        @if ($level <= 4)
            <ul class="cr-comment">
                @foreach ($comment?->replies as $reply)
                   @include('courses::livewire.discussion-forum.comments', ['comment' => $reply, 'level' => $level + 1])
                @endforeach
            </ul>
        @endif
    @endif
    <!-- <div class="cr-loadmore-btn">
        <button class="cr-bookmark">{{ __('courses::courses.load_more') }}</button>
    </div> -->
</li>