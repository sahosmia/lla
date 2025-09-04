<?php if($paginator->hasPages()): ?>
<nav class="pb-pagination_nav">
    <input type="hidden" name="current_page" id="current_page" value="<?php echo e($paginator->currentPage()); ?>" />
    <ul class="pb-pagination">
        <?php if($paginator->onFirstPage()): ?>
        <li class="pb-d-none">
            <span class="icon-chevron-left"></span>
        </li>
        <?php else: ?>
        <li class="pb-prevpage">
            <a href="javascript:;" data-page="<?php echo e($paginator->currentPage() - 1); ?>" class="goto-page">
                <i class="icon-chevron-left"></i>
            </a>
        </li>
        <?php endif; ?>

        <?php for($i = 1; $i <= $paginator->lastPage(); $i++): ?>
            <li class="<?php echo e(($paginator->currentPage() == $i) ? ' active' : ''); ?>">
                <?php if($paginator->currentPage() == $i): ?>
                <span class="goto-page" data-page="<?php echo e($i); ?>"><?php echo e($i); ?></span>
                <?php else: ?>
                <a href="javascript:;" class="goto-page" data-page="<?php echo e($i); ?>"><?php echo e($i); ?></a>
                <?php endif; ?>
            </li>
            <?php endfor; ?>

            <?php if($paginator->hasMorePages()): ?>
            <li class="pb-nextpage">
                <a href="javascript:;" data-page="<?php echo e($paginator->currentPage() + 1); ?>" class="goto-page">
                    <i class="icon-chevron-right"></i>
                </a>
            </li>
            <?php else: ?>
            <li class="pb-d-none">
                <span class="icon-chevron-right"></span>
            </li>
            <?php endif; ?>
    </ul>
</nav>
<?php endif; ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/vendor/larabuild/pagebuilder/src/../resources/views/pagination/pb-pagination.blade.php ENDPATH**/ ?>