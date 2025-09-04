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
<div class="op-tooltip">
    <input type="<?php echo e($type == 'editor' ? 'text' : $type); ?>" <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>"
        <?php endif; ?> data-id="<?php echo e($id ?? ''); ?>" name="<?php echo e($name); ?>" value="<?php echo e($value ?? ''); ?>"
        class="<?php echo e($type == 'editor' ? 'd-none' : ''); ?> op-input-field form-control <?php echo e($class ?? ''); ?> <?php echo e($type == 'editor' ? 'op-editor' : ''); ?>"
        placeholder="<?php echo e($placeholder ?? ''); ?>" 
        <?php if($type == 'number' && isset($min)): ?>
            min="<?php echo e($min ?? 0); ?>"
        <?php endif; ?>
        <?php if($type == 'number' && isset($max)): ?>
            max="<?php echo e($max ?? 0); ?>"
        <?php endif; ?>
      >
    <?php if( !empty($hint['content']) && $type != 'editor' ): ?>
    <a class="op-infotips icon-alert-circle" href="javascript:void(0);" data-tippy-content="<?php echo e($hint['content']); ?>"
        data-tippy-interactive="true" data-tippy-placement="top-start"></a>
    <?php endif; ?>
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
            <div class="op-tooltip">
                <?php if( !empty($hint['content']) && $type != 'editor' ): ?>
                <a class="op-infotips icon-alert-circle" href="javascript:void(0);"
                    data-tippy-content="<?php echo e($hint['content']); ?>" data-tippy-interactive="true"
                    data-tippy-placement="top-start"></a>
                <?php endif; ?>
                <input type="<?php echo e($type == 'editor' ? 'text' : $type); ?>" <?php if(!empty($parent_rep)): ?>
                    data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?> data-id="<?php echo e($id ?? ''); ?>" name="<?php echo e($name); ?>"
                    value="<?php echo e($value ?? ''); ?>"
                    class="op-input-field form-control <?php echo e($class ?? ''); ?> <?php echo e($type == 'editor' ? 'op-editor' : ''); ?> <?php echo e(!empty($put_env) ? 'put-to-env' : ''); ?>"
                    placeholder="<?php echo e($placeholder ?? ''); ?>" 
                    <?php if(isset($min) && $type == 'number'): ?>
                        min="<?php echo e($min ?? 0); ?>"
                    <?php endif; ?>
                    <?php if(isset($max) && $type == 'number'): ?>
                        max="<?php echo e($max ?? 0); ?>"
                    <?php endif; ?>
                    >
            </div>
            <?php if( !empty($field_desc) ): ?><span><?php echo $field_desc; ?></span> <?php endif; ?>
        </div>
    </div>
</li>
<?php endif; ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/vendor/larabuild/optionbuilder/src/../resources/views/components/input.blade.php ENDPATH**/ ?>