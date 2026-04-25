<div class="tk-section am-terms-section">
    <div class="tk-section-frequently">
        @if(!empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
            @if(!empty(pagesetting('heading')))
                <div class="tk-section_title">
                    <h2>{!! pagesetting('heading') !!}</h2>
                
                </div>
            @endif
            @if(!empty(pagesetting('paragraph')))
                <div class="tk-jobdescription"> 
                    {!! pagesetting('paragraph') !!}
                </div>
            @endif
        @endif  
    </div>
</div>

