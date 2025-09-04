<?php $__env->startPush(config('pagebuilder.site_style_var')); ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/pagebuilder/css/larabuild-iframe.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection(config('pagebuilder.site_section')); ?>
    <div id="grids">
        <?php if(!empty($page->settings['grids'])): ?>
            <?php $__currentLoopData = $page->settings['grids']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                setGridId($grid['grid_id']);
                ?>
                <?php $__env->startComponent('pagebuilder::components.grid-placeholder',[
                    'sectionsData'=>$page->settings['section_data'] ?? [],
                    'data'=>$grid['data']??[],
                    'grid'=>$grid['grid'],
                    'grid_id'=>$grid['grid_id'],
                    'columns'=>getColumnInfo($grid['grid'])
                    ]); ?>
        
                <?php echo $__env->renderComponent(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>

    <div class="pb-addgrid-system">
        <div class="container-fluid">
            <?php $__env->startComponent('pagebuilder::components.add-grid'); ?> <?php echo $__env->renderComponent(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php $__env->startPush(config('pagebuilder.site_script_var')); ?>
<?php if( config('pagebuilder.add_jquery') === 'no' ): ?>
    <script src="<?php echo e(asset('vendor/optionbuilder/js/jquery.min.js')); ?>"></script>
<?php endif; ?>
<script>   
    function insertGrid(grid_name) {
        let uniqId = window.parent.getUniqueId();
        let componentTemp = $(window.parent.gridTemplates[grid_name]);
        componentTemp.attr("id", uniqId);
        $('#grids').append(componentTemp);
    }

    window.onload = (event) => {
        jQuery(document).ready(function() {

            window.parent.disableAnchors($('body'));
            
            $(document).on('mouseover', '.sectionable', function() {
                $('.pb-tooltip.row').addClass('pb-hidetooltip');
            });

            $(document).on('mouseleave', '.sectionable', function() {
                $('.pb-tooltip.row').removeClass('pb-hidetooltip');
            });

            $(document).on('click', '.sectionable', function(e) {
                $('.sectionable').removeClass('active-section');
                $(this).addClass('active-section');
                window.parent.disableAnchors($(this));
                let sectionId = $(this).attr('id');
                parent.$(parent.document).trigger('getSectionSettings',[sectionId] );   
            
            });

            $(document).on('click', '.deleteSection', function() {
                let grid_id = $(this).closest('.griddable').attr('id');

                if ($(this).closest('.sectionable').length > 0) {

                    let sectionable = $(this).parents('.sectionable');
                    if (sectionable.siblings().length == 0) {
                        $(window.parent.plusTemplate).insertAfter(sectionable);
                        $(this).closest('.pb-tooltip.row').removeClass('pb-hidetooltip');
                    }

                    let id = sectionable.attr('id');
                    if (window.parent.sectionData[id]) {
                        delete window.parent.sectionData[id];
                    }
                    sectionable.remove();
                    window.parent.$('#current-section-id').val('');
                }

                window.parent.$('#section-settings-wrapper').html('<span class="at-empty-settings"><?php echo e(__("pagebuilder::pagebuilder.select_any_element")); ?></span>');
                window.parent.$('#elements-btn').tab('show');
                window.parent.$('#advanced-settings-wrapper').html('<span class="at-empty-settings"> <?php echo e(__("pagebuilder::pagebuilder.select_any_element")); ?></span>');
                window.parent.unsavedChanges = true;
            });

            $(document).on('click', '.insertGrid',  function(){
                let uniqueId = window.parent.getUniqueId();
                let grid_name = $(this).prev().parents('.griddable').data('grid-name');
                $(window.parent.gridTemplates[grid_name]).insertBefore($(this).prev().parents('.griddable')).removeAttr('id').attr('id',uniqueId);
                window.parent.unsavedChanges=true;
                window.parent.initBuilderJs();
                });

            $(document).on('click', '.deleteGrid', function() {
                let griddable = $(this).closest('.griddable');
                let grid_id = griddable.attr('id');
                griddable.find('.sectionable').each(function(index, item) {
                    let id = item.id;
                    if (window.parent.sectionData[id]) {
                        delete window.parent.sectionData[id];
                    }

                });

                delete window.parent.sectionData[grid_id];
                griddable.remove();

                window.parent.$('#section-settings-wrapper').html('<span class="at-empty-settings"><?php echo e(__("pagebuilder::pagebuilder.select_any_element")); ?></span>');
                window.parent.$('#elements-btn').tab('show');
                window.parent.$('#advanced-settings-wrapper').html('<span class="at-empty-settings"> <?php echo e(__("pagebuilder::pagebuilder.select_any_element")); ?></span>');
                window.parent.$('#current-section-id').val('');
                window.parent.$('#current-grid-id').val('');

                window.parent.unsavedChanges = true;
            });

            $(document).on('click', '.copySection', function() {
                let id = $(this).parents('.sectionable').attr('id');
                let uniqueId = window.parent.getUniqueId();
                if (id) {
                    let sectionId = $('#' + id).attr('data-section');
                    window.parent.$('#template_' + sectionId).clone(true).detach().css({}).insertAfter($('#' + id)).removeClass('d-none').removeAttr('id').attr('id', uniqueId);
                }
                parent.$(parent.document).trigger('getSectionSettings',[uniqueId] );   
            });
            $(document).on('click', '.add-grid', function() {
                insertGrid($(this).data('grid-name'));
                parent.$(parent.document).trigger('initBuilderJs');   
            });
        });
    }
    function dipatchSectionJs(section){
        const event = new CustomEvent('loadSectionJs', { detail: { sectionId: section } });
        document.dispatchEvent(event);
    }
    window.addEventListener("DOMContentLoaded", function(){
        parent.$(parent.document).trigger('initBuilderJs');   
    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make(config('pagebuilder.site_layout'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/vendor/larabuild/pagebuilder/src/../resources/views/pagebuilder-iframe.blade.php ENDPATH**/ ?>