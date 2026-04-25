
<div class="uc-sidebar_wrap">
    <div class="uc-sidebar_inner">
        <div class="uc-sidebar_title">
            <h2>{{ __('upcertify::upcertify.library_title') }}</h2>
            <a href="javascript:void(0);" class="uc-sidebar-hidebtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16" fill="none">
                    <g>
                        <path d="M4 12L12 4M4 4L12 12" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
            </a>
        </div>
        <div class="uc-sidebar">
            <div class="uc-elements uc-shaps">
                <h3>Shaps</h3>
                <ul class="uc-elements-items">
                    @foreach ($shapeIcons as $shape => $svgContent)
                        <li id="shape_{{ $shape }}"  class="uc-attachment-item " data-color="#d9d9d9" data-type="svg" data-svg='{{ $svgContent }}'>
                            {!! $svgContent !!}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="uc-elements uc-badge">
                <h3>Badge</h3>
                <ul class="uc-elements-items">
                    @foreach ($badeIcons as $badge => $svgContent)
                        <li id="badge-{{ $badge }}" class="uc-attachment-item badge-item" data-type="svg" data-svg='{{ $svgContent }}'>
                            {!! $svgContent !!}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="uc-elements uc-border-grid" id="attachments" style="display: block;">
                <h3>Broder</h3>
                <ul class="uc-radio-section uc-wrap-single">
                        @foreach ($attachments as $attachment => $svgContent)
                        <li id="attachment-{{ $attachment }}" class="uc-attachment-item" data-color="#d9d9d9" data-type="svg" data-svg='{{ $svgContent }}'>
                            <div class="uc-geomatric uc-border-box">
                                {!! $svgContent !!}
                            </div>
                        </li>
                    @endforeach         
                </ul>
            </div>
            <div class="uc-elements uc-border-grid uc-frames" id="frames" style="display: block;">
                <h3>Frames</h3>
                <ul class="uc-radio-section">
                @foreach ($frames as $frame => $contents)
                    <li id="frames-{{ $frame }}" class="uc-attachment-item" data-type="svg-frame" 
                        data-svg='{{ $contents["icon"] }}'>
                        <div class="uc-geomatric">
                            {!! $contents["thumbnail"] !!}
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="uc-sidebar_toggler">
        <span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M14 6L8 12L14 18" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
    </div>
</div>