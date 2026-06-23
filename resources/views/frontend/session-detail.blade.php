@extends('layouts.frontend-app')
@section('content')
<div class="am-session-detail-banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-searchdetail">
                    <div class="am-search-userdetail">
                        <div class="am-tutordetail_head">
                            <div class="am-session-grade">
                                @if(!empty($sessionSlot?->subjectGroupSubjects?->userSubjectGroup?->group?->name))
                                    <span><i class="am-icon-book-1"></i>{!! $sessionSlot?->subjectGroupSubjects?->userSubjectGroup?->group?->name !!}</span>
                                @endif
                                @if(!empty($sessionSlot?->subjectGroupSubjects?->subject?->name))  
                                    <h2>{!! $sessionSlot?->subjectGroupSubjects?->subject?->name !!}</h2>
                                @endif
                        </div>
                        @if(true)
                            <div class="am-tutordetail_fee">
                                <strong> {!! formatAmountV2($sessionSlot?->session_fee) !!}</strong>
                                <span>{{ __('calendar.session_fee') }}</span>
                            </div>
                        @endif
                    </div>  
                    <div class="am-tutordetail_user">
                        <figure class="am-tutorvone_img">
                            @if(!empty($sessionSlot?->subjectGroupSubjects?->userSubjectGroup?->tutorProfile?->image) && Storage::disk(getStorageDisk())->exists($sessionSlot?->subjectGroupSubjects?->userSubjectGroup?->tutorProfile?->image))
                                <img src="{{ resizedImage($sessionSlot?->subjectGroupSubjects?->userSubjectGroup?->tutorProfile?->image, 100, 100) }}" class="am-user_image" alt="{{$sessionSlot?->subjectGroupSubjects?->userSubjectGroup?->tutorProfile?->full_name}}" />
                            @else 
                                <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 100, 100) }}" alt="{{ $sessionSlot?->subjectGroupSubjects?->userSubjectGroup?->tutorProfile?->full_name }}" />
                            @endif
                            <span @class(['am-userstaus', 'am-userstaus_online' => $sessionSlot?->subjectGroupSubjects?->userSubjectGroup?->tutorProfile?->is_online])></span>
                        </figure>
                        @if(!empty($sessionSlot?->subjectGroupSubjects?->userSubjectGroup?->tutorProfile?->full_name || $sessionSlot?->subjectGroupSubjects?->userSubjectGroup?->tutorProfile?->tagline))
                            <div class="am-tutordetail_user_name">
                                <h5>{!! $sessionSlot?->subjectGroupSubjects?->userSubjectGroup?->tutorProfile?->full_name !!}</h5>
                                <span>{!! $sessionSlot?->subjectGroupSubjects?->userSubjectGroup?->tutorProfile?->tagline !!}</span>
                            </div>
                        @endif
                    </div>
                    <div class="am-tutordetail-reviews">
                        <ul class="am-tutorreviews-list">
                            <li>
                                <div class="am-tutorreview-item">
                                    <i class="am-icon-calender-day"></i>
                                    <em>{{ __('general.date') }}</em>
                                    <span class="am-uniqespace">{{ parseToUserTz($sessionSlot?->start_time)->format(setting('_general.date_format') ?? 'F j, Y') }}</span>
                                </div>
                            </li>
                            <li>
                                <div class="am-tutorreview-item">
                                    <i class="am-icon-user-group"></i>
                                    <em>{{ __('general.total_enrolment') }}</em>
                                    <span class="am-uniqespace">{{ $sessionSlot?->total_booked }} {{ __('general.students') }}</span>
                                </div>
                            </li>
                            <li>
                                <div class="am-tutorreview-item">
                                    <i class="am-icon-time"></i>
                                    <em>{{ __('calendar.time') }}</em>
                                    <span class="am-uniqespace">
                                        @if(setting('_lernen.time_format') == '12')
                                            {{ parseToUserTz($sessionSlot?->start_time)->format('h:i a') }} -
                                            {{ parseToUserTz($sessionSlot?->end_time)->format('h:i a') }}
                                        @else
                                            {{ parseToUserTz($sessionSlot?->start_time)->format('H:i') }} -
                                            {{ parseToUserTz($sessionSlot?->end_time)->format('H:i') }}
                                        @endif
                                    </span>
                                   
                                </div>
                            </li>
                            @if(auth()?->user()?->role == 'student' && $bookings?->first()?->student_id == auth()->id() && \Carbon\Carbon::parse($bookings?->first()?->start_time)->isFuture())
                                <li>
                                    <div class="am-sessionstart">
                                        <span class="am-sessionstart_icon"><i class="am-icon-megaphone-01"></i></span>
                                        <em>{{ __('calendar.session_start_at') }}</em>
                                        <div class="am-sessionstart_timer">
                                            <span>  {{ timeLeft($bookings?->first()?->start_time) }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            <li>
                                <div class="am-tutorreview-item">
                                    <i class="am-icon-layer-01"></i>
                                    <em>{{ __('calendar.type') }}</em>
                                    <span class="am-uniqespace">{{ $sessionSlot?->spaces > 1 ? __('calendar.group') : __('calendar.one') }}</span>
                                </div>
                            </li>
                        </ul>
                    </div> 
                    @if(auth()->check() && auth()->user()->role == 'student' && !empty($bookings) && !empty($sessionSlot?->meta_data['meeting_link']))
                        <div class="am-tutordetail-btns">
                            <a href="{{ $sessionSlot?->meta_data['meeting_link'] ?? '#' }}" class="am-btn">
                                {{ __('calendar.join_session') }}
                            </a>
                        </div>
                    @elseif(auth()->check() && auth()->user()->role == 'student')
                        <div class="am-tutordetail-btns">
                            <button type="button" class="am-btn book-session-btn" data-id="{{ $sessionSlot?->id }}">
                                {{ isPaidSystem() ? __('general.book_now') : __('general.get_session') }}
                            </button>
                        </div>
                    @elseif(empty($bookings))
                        <div class="am-tutordetail-btns">
                            <a href="{{ route('login', ['id' => $sessionSlot?->id])  }}" class="am-btn">
                                {{ __('general.book_now') }}
                            </a>
                        </div>
                    @endif
                    @if(auth()->check() && auth()->user()->role == 'tutor')
                        <div class="am-tutordetail-btns" x-data="{ linkToCopy: '{{ route('session-detail', ['id' => encrypt($sessionSlot?->id)]) }}', linkCopied: false }">
                            <button class="am-white-btn" @click="
                                navigator.clipboard.writeText(linkToCopy)
                                .then(() => {
                                    linkCopied = true;
                                    setTimeout(() => { linkCopied = false; }, 2000);
                                })">
                                <template x-if="!linkCopied">
                                    <div class="am-copy-link">
                                        {{ __('calendar.copy_session_link') }}
                                        <i class="am-icon-copy-01"></i>
                                    </div>
                                </template>
                                <template x-if="linkCopied">
                                    <span x-show="linkCopied" x-transition>{{ __('calendar.link_copied') }}</span>
                                </template>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="am-detailuser_video am-detailuser_image">
                    <figure>
                        @if(!empty($sessionSlot?->subjectGroupSubjects?->image) && Storage::disk(getStorageDisk())->exists($sessionSlot?->subjectGroupSubjects?->image))
                            <img src="{{ resizedImage($sessionSlot?->subjectGroupSubjects?->image, 700, 360) }}" alt="{{ $sessionSlot?->subjectGroupSubjects?->subject?->name }}">
                        @else
                            <img src="{{ resizedImage('placeholder-land.png', 700, 360) }}" alt="{{ $sessionSlot?->subjectGroupSubjects?->subject?->name }}">
                        @endif
                    </figure>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="am-aboutuser_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="am-aboutuser_tab">
                    <li class="active">
                        <a href="#" class="am-tabitem">{{ __('general.description') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="am-userinfo_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-userinfo_content">
                    @if(!empty($sessionSlot?->description))
                        <div class="am-toggle-text">
                            <div class="am-addmore">
                                <p class="short-description">
                                    {!! $sessionSlot?->description !!}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.book-session-btn').forEach(button => {
            button.addEventListener('click', function() {
                let sessionId = this.getAttribute('data-id');

                fetch("{{ route('book-session') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ session_id: sessionId })
                })
                .then(response => response.json())
                .then(data => {
                        if (data.success) {
                            if(data.type == 'free'){
                                Livewire.dispatch('showAlertMessage', { type: 'success', title: '{{ __('general.success_title') }}', message: '{{ __('general.book_success') }}' });
                                window.location.href = "{{ route('student.bookings') }}";
                            }
                            const event = new CustomEvent('cart-updated', {
                                detail: {
                                    cart_data: data.cart_data,
                                    total: data.total,
                                    subTotal: data.subTotal,
                                    discount: data.discount,
                                    toggle_cart: data.toggle_cart
                                }
                            });
                            window.dispatchEvent(event);
                        } else {
                            Livewire.dispatch('showAlertMessage', { type: 'error', title: '{{ __('general.error_title') }}', message: data.message });
                        }
                    })
                .catch(error => console.error("Error:", error));
            });
        });
    });
</script>
@endpush
