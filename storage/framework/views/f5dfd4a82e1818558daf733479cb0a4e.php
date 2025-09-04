<li class="form-group-wrap op-textcontent">
    <?php if( !empty($label_title) ): ?>
        <div class="form-group-half">
            <div class="op-textcontent">
                <h6><?php echo $label_title; ?>

                <?php if( config('optionbuilder.developer_mode') == 'yes' ): ?>
                    <span class="op-alert">setting(‘<?php echo e($tab_key); ?>.<?php echo e($id); ?>’)</span>
                <?php endif; ?>
                </h6>
                <?php if( !empty( $label_desc) ): ?>
                    <em><?php echo $label_desc; ?></em>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="form-group-half">
        <div class="op-add-slot" data-id="<?php echo e($id ?? ''); ?>">
            <?php if( !empty($value) && is_array($value) ): ?>
                <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if( $field['type'] == 'switch'|| $field['type'] == 'checkbox' || $field['type'] == 'radio' ||  $field['type'] == 'file'): ?><div class="op-box-feild"><?php endif; ?> 

                        <div class="op-reapfeild op-single-repetitor">
                            <?php if( !empty($field) && is_array($field) ): ?>
                                <?php
                                    $field['repeater_type'] = 'single';
                                    $field['repeater_id']   = $id;
                                    $field['index']         = $i;
                                    if( $field['id'] == key($single) ){
                                        $field['value']     = $single[key($single)];
                                    }
                                    if( !empty($repeater_id) ){
                                        $field['parent_rep']   = "$repeater_id".'['.$index.']';
                                    }
                                ?>
                                <?php echo getField($field); ?>

                            <?php endif; ?>
                            <?php if(!isset($edit) || !empty($edit)): ?>
                            <a class="op-trashfeild op-trash-single-rep" href="javascript:;"  data-repeater_id="<?php echo e($id ?? ''); ?>"><i class="icon-trash-2"></i>
                            <?php if( $field['type'] == 'switch'|| $field['type'] == 'checkbox' || $field['type'] == 'radio' ||  $field['type'] == 'file'): ?>
                                <span><?php echo e(__('optionbuilder::option_builder.remove')); ?></span>
                            <?php endif; ?> 
                            </a>
                            <?php endif; ?>
                        </div>

                    <?php if( $field['type'] == 'switch'|| $field['type'] == 'checkbox' || $field['type'] == 'radio' ||  $field['type'] == 'file'): ?></div><?php endif; ?> 

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <?php if( $field['type'] == 'switch'|| $field['type'] == 'checkbox' || $field['type'] == 'radio' ||  $field['type'] == 'file'): ?><div class="op-box-feild"><?php endif; ?>
                    <div class="op-reapfeild op-single-repetitor">
                        <?php if( !empty($field) && is_array($field) ): ?>
                            <?php
                                $field['repeater_type'] = 'single';
                                $field['repeater_id']   = $id;
                                $field['index']         = rand(1,999).time();
                                if( !empty($repeater_id) ){
                                    $field['parent_rep']   = "$repeater_id".'['.$index.']';
                                } 
                            ?>
                            <?php echo getField($field); ?>

                        <?php endif; ?>
                        <?php if(!isset($edit) || !empty($edit)): ?>
                        <a class="op-trashfeild op-trash-single-rep" href="javascript:;"  data-repeater_id="<?php echo e($id ?? ''); ?>"><i class="icon-trash-2"></i>
                            <?php if( $field['type'] == 'switch'|| $field['type'] == 'checkbox' || $field['type'] == 'radio' ||  $field['type'] == 'file'): ?>
                                <span><?php echo e(__('optionbuilder::option_builder.remove')); ?></span>
                            <?php endif; ?> 
                        </a>
                        <?php endif; ?>
                    </div>    
                <?php if( $field['type'] == 'switch'|| $field['type'] == 'checkbox' || $field['type'] == 'radio' ||  $field['type'] == 'file'): ?></div><?php endif; ?>
            <?php endif; ?>
            <?php if(!isset($edit) || !empty($edit)): ?>
            <div class="op-add-dwonload more-single-rep" data-repeater="<?php echo e($id ?? ''); ?>">
                <a class="op-btn-two" href="javascript:;"><i class="fa fa-plus"></i><?php echo e(__('optionbuilder::option_builder.add_more')); ?></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</li>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/vendor/larabuild/optionbuilder/src/../resources/views/components/single-repeater.blade.php ENDPATH**/ ?>