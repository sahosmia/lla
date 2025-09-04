<?php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
?>
<!--[if BLOCK]><![endif]--><?php if($paginator->hasPages()): ?>
    <div class='am-pagination'>
        <div wire:ignore class="am-pagination-filter" x-init="$('#per_page').select2({minimumResultsForSearch :  Infinity})">
            <em><?php echo e(__('pagination.show')); ?></em>
            <span class="am-select" wire:ignore>
                <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" id="per_page" >
                    <!--[if BLOCK]><![endif]--><?php if(!empty($blog)): ?>
                        <option value="10">9</option>
                        <option value="20">18</option>
                        <option value="30">27</option>
                        <option value="50">56</option>
                        <option value="100">99</option>
                    <?php else: ?>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </span>
            <em><?php echo e(__('pagination.listing_per_page')); ?></em>
        </div>
        <ul>
            <!--[if BLOCK]><![endif]--><?php if($paginator->onFirstPage()): ?>
                <li class="am-prevpage disabled">
                    <a href="javascript:void(0);"><?php echo app('translator')->get('pagination.previous'); ?></a>
                </li>
            <?php else: ?>
                <li class="am-prevpage">
                    <a href="javascript:void(0);" dusk="previousPage<?php echo e($paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName()); ?>" wire:click="previousPage('<?php echo e($paginator->getPageName()); ?>')" x-on:click="<?php echo e($scrollIntoViewJsSnippet); ?>" wire:loading.attr="disabled" ><?php echo app('translator')->get('pagination.previous'); ?></a>
                </li>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!--[if BLOCK]><![endif]--><?php if(is_string($element)): ?>
                    <li>
                        <a href="javascript:void(0);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <g opacity="0.6">
                                    <path d="M2.62484 5.54199C1.82275 5.54199 1.1665 6.19824 1.1665 7.00033C1.1665 7.80241 1.82275 8.45866 2.62484 8.45866C3.42692 8.45866 4.08317 7.80241 4.08317 7.00033C4.08317 6.19824 3.42692 5.54199 2.62484 5.54199Z" fill="#585858"/>
                                    <path d="M11.3748 5.54199C10.5728 5.54199 9.9165 6.19824 9.9165 7.00033C9.9165 7.80241 10.5728 8.45866 11.3748 8.45866C12.1769 8.45866 12.8332 7.80241 12.8332 7.00033C12.8332 6.19824 12.1769 5.54199 11.3748 5.54199Z" fill="#585858"/>
                                    <path d="M5.5415 7.00033C5.5415 6.19824 6.19775 5.54199 6.99984 5.54199C7.80192 5.54199 8.45817 6.19824 8.45817 7.00033C8.45817 7.80241 7.80192 8.45866 6.99984 8.45866C6.19775 8.45866 5.5415 7.80241 5.5415 7.00033Z" fill="#585858"/>
                                </g>
                            </svg>
                        </a>
                    </li>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if( is_array($element) ): ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="<?php echo e($paginator->currentPage() == $page ? 'active': ''); ?>" wire:key="page-<?php echo e($page); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($page == $paginator->currentPage()): ?>
                                <span><?php echo e($page); ?></span>
                            <?php else: ?>
                                <a href="javascript:void(0);" wire:click="gotoPage(<?php echo e($page); ?>, '<?php echo e($paginator->getPageName()); ?>')" x-on:click="<?php echo e($scrollIntoViewJsSnippet); ?>"><?php echo e($page); ?></a>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if($paginator->hasMorePages()): ?>
                <li class="am-nextpage">
                    <a href="javascript:void(0);" dusk="nextPage<?php echo e($paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName()); ?>" wire:click="nextPage('<?php echo e($paginator->getPageName()); ?>')" x-on:click="<?php echo e($scrollIntoViewJsSnippet); ?>" wire:loading.attr="disabled" ><?php echo app('translator')->get('pagination.next'); ?></a>
                </li>
            <?php else: ?>
                <li class="am-nextpage disabled">
                    <a href="javascript:void(0);"><?php echo app('translator')->get('pagination.next'); ?></a>
                </li>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </ul>
    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

<?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagination/pagination.blade.php ENDPATH**/ ?>