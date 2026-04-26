<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->hasPages()): ?>
<nav class="pb-pagination_nav">
    <input type="hidden" name="current_page" id="current_page" value="<?php echo e($paginator->currentPage()); ?>" />
    <ul class="pb-pagination">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->onFirstPage()): ?>
        <li class="pb-d-none">
            <span class="icon-chevron-left"></span>
        </li>
        <?php else: ?>
        <li class="pb-prevpage">
            <a href="javascript:;" data-page="<?php echo e($paginator->currentPage() - 1); ?>" class="goto-page">
                <i class="icon-chevron-left"></i>
            </a>
        </li>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= $paginator->lastPage(); $i++): ?>
            <li class="<?php echo e(($paginator->currentPage() == $i) ? ' active' : ''); ?>">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->currentPage() == $i): ?>
                <span class="goto-page" data-page="<?php echo e($i); ?>"><?php echo e($i); ?></span>
                <?php else: ?>
                <a href="javascript:;" class="goto-page" data-page="<?php echo e($i); ?>"><?php echo e($i); ?></a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </li>
            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->hasMorePages()): ?>
            <li class="pb-nextpage">
                <a href="javascript:;" data-page="<?php echo e($paginator->currentPage() + 1); ?>" class="goto-page">
                    <i class="icon-chevron-right"></i>
                </a>
            </li>
            <?php else: ?>
            <li class="pb-d-none">
                <span class="icon-chevron-right"></span>
            </li>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </ul>
</nav>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php /**PATH C:\Users\User\Desktop\well-known\vendor\larabuild\pagebuilder\src/../resources/views/pagination/pb-pagination.blade.php ENDPATH**/ ?>