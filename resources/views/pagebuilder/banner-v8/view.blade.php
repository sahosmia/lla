<div class="splide am-banner-slider banner-v8-slider" id="hero-slider">
  <div class="splide__track">
    @if(!empty(pagesetting('banner_repeater')))
      <ul class="splide__list">
          @foreach(pagesetting('banner_repeater') as $option)
            <li class="splide__slide">
              <div class="am-hero-container">
                <div class="am-hero-background">
                  @if(!empty($option['bg_image_one']))
                    <img src="{{ Storage::url($option['bg_image_one'][0]['path']) }}" alt="Banner slice first image" class="image slice slice1">
                  @endif
                  @if(!empty($option['bg_image_two']))
                    <img src="{{ Storage::url($option['bg_image_two'][0]['path']) }}" alt="Banner slice second image" class="image slice slice2">
                  @endif
                  @if(!empty($option['bg_image_three']))
                    <img src="{{ Storage::url($option['bg_image_three'][0]['path']) }}" alt="Banner slice third image" class="image slice slice3">
                  @endif
                </div>
                <div class="am-banner-content">
                  <div class="am-hero-content">
                    <div class="am-yellow-bar"></div>
                    @if(!empty($option['heading']))<h1 class="am-hero-title"> {!! $option['heading'] !!} </h1>@endif
                  </div>
                  <div class="am-hero-description-wrapper">
                    @if(!empty($option['paragraph']))<p class="am-hero-description"> {!! $option['paragraph'] !!} </p>@endif
                    <div class="am-partner-logos">
                      @if(!empty($option['companies_images']))
                        @foreach($option['companies_images'] as $image)
                          @if(!empty($image['path']))
                            <img src="{{ Storage::url($image['path']) }}" alt="Company image" class="am-partner-logo">
                          @endif
                        @endforeach
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </li>
          @endforeach
      </ul>
    @endif  
  </div>
</div>

@push('styles')
    @vite(['public/css/flags.css'])
@endpush

@pushOnce('scripts')
    <script src="{{ asset('js/splide.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        setTimeout(() => {
            bannerV8VideoJs();
            }, 500);
        }); 

        document.addEventListener('loadSectionJs', (event) => {
        if(event.detail.sectionId === 'banner-v8'){
            bannerV8VideoJs();
        }
    }); 

  function bannerV8VideoJs(){
      const splide = new Splide('.banner-v8-slider', {
        type: 'fade', 
        rewind: true,
        arrows: true,
        autoplay: true,
        interval: 5000,
        pagination: true,
      });

      splide.on('moved', (newIndex) => {

        const slides = document.querySelectorAll('.splide__slide');

        slides.forEach((slide) => {
          slide.classList.remove('animate-slices', 'animate-text');
        });

        const activeSlide = slides[newIndex];
        activeSlide.classList.add('animate-slices', 'animate-text');
      });
      document.querySelector('.splide__slide').classList.add('animate-slices', 'animate-text');

      splide.mount();
  }
 
    </script>
@endpushOnce


