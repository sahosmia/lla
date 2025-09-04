<?php
    $name = '';
    $id = !empty($id) ? $id : '';

    if( !empty($repeater_id) ){
        if( !empty($parent_rep) ){
            $name = "$parent_rep".'['.$repeater_id.']['.$index.']['.$id.']';
        }else{
            $name = "$repeater_id".'['.$index.']['.$id.']';
        }
    }else{
        $name = $id;
    }
?>

<?php if( !empty($repeater_type) && $repeater_type == 'single' ): ?>
    <div class="op-colorpicker">
        <div class="op-inputbtn-wrapper colorPicker">
            <input  type="text" <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?>  data-id="<?php echo e($id ?? ''); ?>"  name="<?php echo e($name); ?>"  value="<?php echo e($value ?? ''); ?>" class="op-input-field form-control getcolor <?php echo e($class ?? ''); ?>" placeholder="<?php echo e($placeholder ?? ''); ?>">
            <span class="op-inputbtn"><span class="colorPicker--preview"></span></span>
        </div>
    </div>
<?php else: ?>
    <li class="form-group-wrap">
        <?php if( !empty($label_title) ): ?>
            <div class="form-group-half">
                <div class="op-textcontent">
                    <h6>
                        <?php echo $label_title; ?>

                        <?php if( empty($repeater_id) && config('optionbuilder.developer_mode') == 'yes' ): ?>
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
            <div class="op-textcontent">
                <div class="op-inputbtn-wrapper colorPicker">
                    <input  type="text" <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?>  data-id="<?php echo e($id ?? ''); ?>"  name="<?php echo e($name); ?>"  value="<?php echo e($value ?? ''); ?>" class="op-input-field form-control getcolor <?php echo e($class ?? ''); ?>" placeholder="<?php echo e($placeholder ?? ''); ?>">
                    <span class="op-inputbtn"><span class="colorPicker--preview"></span></span>
                </div>
                <?php if( !empty($field_desc) ): ?><span><?php echo $field_desc; ?></span> <?php endif; ?>           
            </div>
        </div>
    </li>
<?php endif; ?>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/vendor/larabuild/optionbuilder/src/../resources/views/components/colorpicker.blade.php ENDPATH**/ ?>