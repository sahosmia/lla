<div class="splide am-banner-slider banner-v8-slider" id="hero-slider">
  <div class="splide__track">
    <?php if(!empty(pagesetting('banner_repeater'))): ?>
      <ul class="splide__list">
          <?php $__currentLoopData = pagesetting('banner_repeater'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="splide__slide">
              <div class="am-hero-container">
                <div class="am-hero-background">
                  <?php if(!empty($option['bg_image_one'])): ?>
                    <img src="<?php echo e(Storage::url($option['bg_image_one'][0]['path'])); ?>" alt="Banner slice first image" class="image slice slice1">
                  <?php endif; ?>
                  <?php if(!empty($option['bg_image_two'])): ?>
                    <img src="<?php echo e(Storage::url($option['bg_image_two'][0]['path'])); ?>" alt="Banner slice second image" class="image slice slice2">
                  <?php endif; ?>
                  <?php if(!empty($option['bg_image_three'])): ?>
                    <img src="<?php echo e(Storage::url($option['bg_image_three'][0]['path'])); ?>" alt="Banner slice third image" class="image slice slice3">
                  <?php endif; ?>
                </div>
                <div class="am-banner-content">
                  <div class="am-hero-content">
                    <div class="am-yellow-bar"></div>
                    <?php if(!empty($option['heading'])): ?><h1 class="am-hero-title"> <?php echo $option['heading']; ?> </h1><?php endif; ?>
                  </div>
                  <div class="am-hero-description-wrapper">
                    <?php if(!empty($option['paragraph'])): ?><p class="am-hero-description"> <?php echo $option['paragraph']; ?> </p><?php endif; ?>
                    <div class="am-partner-logos">
                      <?php if(!empty($option['companies_images'])): ?>
                        <?php $__currentLoopData = $option['companies_images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php if(!empty($image['path'])): ?>
                            <img src="<?php echo e(Storage::url($image['path'])); ?>" alt="Company image" class="am-partner-logo">
                          <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    <?php endif; ?>  
  </div>
</div>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['public/css/flags.css']); ?>
<?php $__env->stopPush(); ?>

<?php if (! $__env->hasRenderedOnce('549f173e-b5a4-4026-9727-1381f6651d43')): $__env->markAsRenderedOnce('549f173e-b5a4-4026-9727-1381f6651d43');
$__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/splide.min.js')); ?>"></script>
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
<?php $__env->stopPush(); endif; ?>


<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/banner-v8/view.blade.php ENDPATH**/ ?>