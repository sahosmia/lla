<!--[if BLOCK]><![endif]--><?php if($paginator->hasPages()): ?>
    <div class="tk-pagiantion-holder">
        <div class="tk-pagination">
            <ul>
                <!--[if BLOCK]><![endif]--><?php if($paginator->onFirstPage()): ?>    
                    <li class="d-none">
                        <span class="icon-chevron-left"></span>
                    </li>
                <?php else: ?>
                    <li class="tk-prevpage">
                        <a href="javascript:;" wire:click="previousPage('page')">
                            <i class="icon-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!--[if BLOCK]><![endif]--><?php if(is_string($element)): ?>
                        <li class="disabled"><span><?php echo e($element); ?></span></li>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if(is_array($element)): ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="<?php echo e(($paginator->currentPage() == $page) ? ' active' : ''); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($page == $paginator->currentPage()): ?>
                                <span wire:key="paginator-page-span-<?php echo e($page); ?>" wire:click="gotoPage(<?php echo e($page); ?>)"><?php echo e($page); ?></span>
                            <?php elseif($page >= $paginator->currentPage() - 2 && $page <= $paginator->currentPage() + 2): ?>
                                <a href="javascript:;" wire:key="paginator-page-link-<?php echo e($page); ?>" wire:click="gotoPage(<?php echo e($page); ?>)"><?php echo e($page); ?></a>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if($paginator->hasMorePages()): ?>    
                    <li class="tk-nextpage">
                        <a href="javascript:;" wire:click="nextPage('page')">
                            <i class="icon-chevron-right"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="d-none">
                        <span class="icon-chevron-right"></span>
                    </li>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </ul>
        </div>
    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagination/custom.blade.php ENDPATH**/ ?>