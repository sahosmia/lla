<div class="tk-section am-terms-section">
    <div class="tk-section-frequently">
        <?php if(!empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?>
            <?php if(!empty(pagesetting('heading'))): ?>
                <div class="tk-section_title">
                    <h2><?php echo pagesetting('heading'); ?></h2>
                
                </div>
            <?php endif; ?>
            <?php if(!empty(pagesetting('paragraph'))): ?>
                <div class="tk-jobdescription"> 
                    <?php echo pagesetting('paragraph'); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>  
    </div>
</div>

<?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagebuilder/paragraph/view.blade.php ENDPATH**/ ?>