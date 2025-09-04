<?php if(!empty(setting('_general.enable_multi_language'))): ?>
    <?php if(!empty(setting('_general.multi_language_list'))): ?>
        <?php
            $translatedLangs = getTranslatedLanguages();
            $selectedLang = app()->getLocale() ?? 'en';
        ?>
        <form class="am-switch-language am-multi-lang" action="<?php echo e(route('switch-lang')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div>
                <input type="hidden" name="am-locale">
                <div class="am-language-select">
                    <a href="javascript:void(0);" class="am-lang-anchor">
                        <img src="<?php echo e(getLangFlag($selectedLang)); ?>" alt="<?php echo e($selectedLang); ?>">
                        <?php echo e($translatedLangs[$selectedLang]); ?><i class="am-icon-chevron-down"></i>
                    </a>
                    <ul class="sub-menutwo locale-menu">
                        <?php $__currentLoopData = setting('_general.multi_language_list'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li data-lang="<?php echo e($lang); ?>" class="<?php echo e($selectedLang == $lang ? 'active' : ''); ?>">
                                <span><img src="<?php echo e(getLangFlag($lang)); ?>" alt="<?php echo e($lang); ?>"><?php echo e($translatedLangs[$lang] ?? $lang); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </form>
    <?php endif; ?>
<?php endif; ?><?php /**PATH D:\Sahos\Laravel\lla\resources\views/components/multi-lingual.blade.php ENDPATH**/ ?>