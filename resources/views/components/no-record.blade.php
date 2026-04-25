@props(['image', 'title', 'description', 'btn_text'])
<div class="am-page-error">
    <div class="am-norecord-wrap">
        @if(!empty($image))
            <figure>
                <img src="{{ $image }}">
            </figure>
        @endif
        @if(!empty($title))
            <h3>{{ $title }}</h3>
        @endif
        @if(!empty($description))
            <p>{!! $description !!}</p>
        @endif
        @if(!empty($btn_text))
            <button {!! $attributes->merge(['class' => 'am-btn']) !!} wire:loading.class="am-btn_disable">
               {!! $btn_text !!}
                <i class="am-icon-plus-01"></i>
            </button>
        @endif
    </div>
</div>

