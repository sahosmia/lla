<?php
   $name = '';
    $id         = !empty($id) ? $id : '';
    
    if( !empty($repeater_id) ){
        if( !empty($parent_rep) ){
            $name = "$parent_rep".'['.$repeater_id.']['.$index.']['.$id.'][]';
        }else{
            $name = "$repeater_id".'['.$index.']['.$id.'][]';
            $repeater_id = "$repeater_id".'['.$index.']';
        }
    }else{

        $name = !empty($id) ? $id.'[]' : '';
    }
   
?>
<?php if( !empty($repeater_type) && $repeater_type == 'single' ): ?>
    <ul class="op-upload-img">
        <li class="op-upload-img-info">
            <div class="op-uploads-img-data">
                <label> <em><i class="icon-plus"></i></em>
                    <input type="file" data-id="<?php echo e($id ?? ''); ?>"  <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?> <?php if( !empty($repeater_id) ): ?> data-repeater_id="<?php echo e($repeater_id); ?>" <?php endif; ?> data-max_size="<?php echo e($max_size ?? 1); ?>" data-ext="<?php echo e(!empty($ext) ? json_encode($ext) : '*'); ?>" accept="<?php echo e(!empty($ext) ?  join(',', array_map(function($ex){return('.'.$ex);}, $ext))  : '*'); ?>"  <?php if( !empty($multi) &&  $multi): ?> data-multi_items="true" multiple <?php else: ?> data-multi_items="false"  <?php endif; ?> >
                </label>
            </div>
        </li>
        <li class="op-upload-img-info op-img-thumbnail d-none">
            <div class="op-upload-data">
                <figure>
                    <img src="#" >
                </figure>
                <div class="op-overlay-icon op-remove-file"><i class="icon-trash-2"></i></div>
                <input type="hidden" />
            </div>
        </li>
        <?php if( !empty($value) ): ?>
            <?php if( is_array($value) ): ?>
                <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="op-upload-img-info op-img-thumbnail">
                        <div class="op-upload-data">
                            <figure>
                                <?php
                                    $path = asset('vendor/optionbuilder/images/file-preview.png');
                                    if( !empty($single['path']) ){
                                        $path = url(Storage::url($single['path']));
                                        if($single['type'] == 'file'){
                                            $path = asset('vendor/optionbuilder/images/file-preview.png');
                                        }
                                    }
                                ?>
                                <img src="<?php echo e($path); ?>" >
                            </figure>
                            <div class="op-overlay-icon op-remove-file"><i class="icon-trash-2"></i></div>
                            <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e(json_encode($single)); ?>" />
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endif; ?>
    </ul>
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
                <ul class="op-upload-img">
                    <li class="op-upload-img-info">
                        <div class="op-uploads-img-data">
                            <label> <em><i class="icon-plus"></i></em>
                                <input type="file" data-id="<?php echo e($id ?? ''); ?>" <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?> <?php if( !empty($repeater_id) ): ?> data-repeater_id="<?php echo e($repeater_id); ?>"  <?php endif; ?> data-max_size="<?php echo e($max_size ?? 1); ?>" data-ext="<?php echo e(!empty($ext) ? json_encode($ext) : '*'); ?>" accept="<?php echo e(!empty($ext) ?  join(',', array_map(function($ex){return('.'.$ex);}, $ext))  : '*'); ?>"  <?php if( !empty($multi) &&  $multi): ?> data-multi_items="true" multiple <?php else: ?> data-multi_items="false"  <?php endif; ?> >
                            </label>
                        </div>
                    </li>
                    <li class="op-upload-img-info op-img-thumbnail d-none">
                        <div class="op-upload-data">
                            <figure>
                                <img src="#" >
                            </figure>
                            <div class="op-overlay-icon op-remove-file"><i class="icon-trash-2"></i></div>
                            <input type="hidden" />
                        </div>
                    </li>
                    <?php if( !empty($value) ): ?>
                        <?php if( is_array($value) ): ?>
                            <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="op-upload-img-info op-img-thumbnail">
                                    <div class="op-upload-data">
                                        <figure>
                                            <?php
                                                $path = asset('vendor/optionbuilder/images/file-preview.png');
                                                if( !empty($single['path']) ){
                                                    $path = url(Storage::url($single['path']));
                                                    if($single['type'] == 'file'){
                                                        $path = asset('vendor/optionbuilder/images/file-preview.png');
                                                    }
                                                }
                                            ?>
                                            <img src="<?php echo e($path); ?>" >
                                        </figure>
                                        <div class="op-overlay-icon op-remove-file"><i class="icon-trash-2"></i></div>
                                        <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e(json_encode($single)); ?>" />
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <?php if( !empty($field_desc) ): ?><span><?php echo $field_desc; ?></span> <?php endif; ?>           
            </div>
        </div>
    </li>
<?php endif; ?>

<?php /**PATH D:\Sahos\Laravel\lla\vendor\larabuild\optionbuilder\src/../resources/views/components/file.blade.php ENDPATH**/ ?>