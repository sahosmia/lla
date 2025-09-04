<?php if( !$pages->isEmpty() ): ?>
<div class="tb-table-wrap">
    <table class="table tb-table tb-dbholder tb-inner-table <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
        <thead>
            <tr>
                <th></th>
                <th><?php echo e(__('pagebuilder::pagebuilder.name')); ?></th>
                <th><?php echo e(__('pagebuilder::pagebuilder.url')); ?></th>
                <th><?php echo e(__('pagebuilder::pagebuilder.status')); ?></th>
                <th><?php echo e(__('pagebuilder::pagebuilder.actions')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td data-label=""><span><?php echo e($page->id); ?></span></td>
                <td data-label="<?php echo e(__('pagebuilder::pagebuilder.name')); ?>"><span><?php echo $page->name; ?></span></td>
                <td data-label="<?php echo e(__('pagebuilder::pagebuilder.url')); ?>"><span><?php echo e(url(
                        !empty($page->slug)?$page->slug:'/' )); ?></span></td>
                <td data-label="<?php echo e(__('pagebuilder::pagebuilder.status')); ?>">
                    <div class="am-status-tag">
                        <em class="tk-project-tag <?php echo e($page->status == 'published' ? 'tk-success-tag' : 'tk-project-tag'); ?>"><?php echo e($page->status
                        == 'draft' ? __('pagebuilder::pagebuilder.draft'):__('pagebuilder::pagebuilder.published')); ?></em>
                    </div>
                </td>
                <td data-label="<?php echo e(__('pagebuilder::pagebuilder.actions')); ?>">
                    <ul class="tb-action-icon">
                        <li> <a id="page_edit_btn" href="javascript:void(0)" data-page-id=<?php echo e($page->id); ?>><i
                                    class="icon-edit-3 edit"></i></a>
                        </li>
                        <li> <a href="<?php echo e(route('pagebuilder.build', ['id' => $page->id])); ?>" target="_blank"><i
                                    class="icon-settings"></i></a> </li>
                        <li <?php echo ($page->status != 'published'? 'class="eye-disabled"': ''); ?>>
                            <a href="<?php echo e(url( !empty($page->slug) ? $page->slug : '/' )); ?>" target="_blank"><i
                                    class="icon-eye"></i></a>
                        </li>
                        <li> <a href="javascript:void(0);" data-page-id="<?php echo e($page->id); ?>" class="tb-delete deletePage"><i
                                    class="icon-trash-2"></i></a> </li>
                    </ul>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php echo $pages->links('pagebuilder::pagination.pb-pagination'); ?>

<?php else: ?>
<?php $__env->startComponent('pagebuilder::components.no-record'); ?><?php echo $__env->renderComponent(); ?>
<?php endif; ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/vendor/larabuild/pagebuilder/src/../resources/views/components/pages-list.blade.php ENDPATH**/ ?>