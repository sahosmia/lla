<div class="am-resumebox_content am-favourites" wire:init="loadData">
    @slot('title')
        {{ __('sidebar.favourites') }}
    @endslot
    <div class="am-title_wrap">
        <div class="am-title">
            <h2>{{ __('profile.favourite_title') }}</h2>
            <p>{{ __('profile.description_text') }}</p>
        </div>
    </div>
    <div class="am-resumewrap">
        @if($isLoading)
            @include('skeletons.favourites')
        @else
             @if(!$favourites->isEmpty())
            <div class="am-resume">
                @foreach($favourites as $favourite)
                    <div class="am-resume_item am-resume_wrap">
                            @if (!empty($favourite->profile->image) && Storage::disk(getStorageDisk())->exists($favourite->profile->image))
                                <img src="{{ resizedImage($favourite->profile->image,50,50) }}" alt="{{$favourite->profile->image}}" />
                            @else
                                <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 50, 50) }}" alt="{{ $favourite->profile->image }}" />
                            @endif
                        <div class="am-resume_content">
                            <div class="am-resume_item_title">
                                <h3>{{$favourite->profile->full_name}}</h3>
                                <div class="am-itemdropdown">
                                    <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="am-icon-ellipsis-horizontal-02"></i>
                                    </a>
                                    <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li>
                                            <a href="{{ route('tutor-detail',['slug' => $favourite->profile->slug]) }}">
                                                <i class="am-icon-eye-open-01"></i>
                                                {{ __('profile.view_profile') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" @click="$wire.dispatch('showConfirm', { id : {{ $favourite->id }}, action : 'remove-favourite-user' })">
                                                <i class="am-icon-trash-02"></i>
                                                {{ __('profile.remove_from_list') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <ul class="am-resume_item_info">
                                <li>
                                    <span>
                                        <i class="am-icon-book-1"></i>
                                        {{ $favourite->profile->native_language }}
                                    </span>
                                </li>
                                @if ($favourite?->address?->country?->short_code)
                                <li>
                                    <span>
                                        <span class="flag flag-{{ strtolower($favourite?->address?->country?->short_code) }}"></span>
                                        {{ $favourite?->address?->country?->name}}
                                    </span>
                                </li>
                                @endif
                                <li>
                                    <span class="am-favrating">
                                        <i class="am-icon-star-filled"></i>
                                        <span class="am-uniqespace"><em>{{ number_format($favourite?->reviews_avg_rating, 1) }}</em>/5.0</span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
            <div class="am-page-error-wrap">
                <x-no-record :image="asset('images/fvt.png')" :title="__('general.no_record_title')" :description="__('general.no_record_desc')"/>
            </div>
            @endif
        @endif
    </div>
</div>

@push('styles')
@vite([
'public/css/flags.css'
])
@endpush
