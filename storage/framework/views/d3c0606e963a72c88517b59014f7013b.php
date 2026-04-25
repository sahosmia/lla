<li class="form-group-wrap op-textcontent">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( !empty($label_title) ): ?>
        <div class="form-group-half">
            <div class="op-textcontent">
                <h6><?php echo $label_title; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( config('optionbuilder.developer_mode') == 'yes' ): ?>
                    <span class="op-alert">setting(‘<?php echo e($tab_key); ?>.<?php echo e($id); ?>’)</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </h6>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( !empty( $label_desc) ): ?>
                    <em><?php echo $label_desc; ?></em>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    <div class="form-group-half">
        <div class="op-add-slot" data-id="<?php echo e($id ?? ''); ?>">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( !empty($value) && is_array($value) ): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( $field['type'] == 'switch'|| $field['type'] == 'checkbox' || $field['type'] == 'radio' ||  $field['type'] == 'file'): ?><div class="op-box-feild"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> 

                        <div class="op-reapfeild op-single-repetitor">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( !empty($field) && is_array($field) ): ?>
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

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!isset($edit) || !empty($edit)): ?>
                            <a class="op-trashfeild op-trash-single-rep" href="javascript:;"  data-repeater_id="<?php echo e($id ?? ''); ?>"><i class="icon-trash-2"></i>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( $field['type'] == 'switch'|| $field['type'] == 'checkbox' || $field['type'] == 'radio' ||  $field['type'] == 'file'): ?>
                                <span><?php echo e(__('optionbuilder::option_builder.remove')); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> 
                            </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( $field['type'] == 'switch'|| $field['type'] == 'checkbox' || $field['type'] == 'radio' ||  $field['type'] == 'file'): ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> 

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php else: ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( $field['type'] == 'switch'|| $field['type'] == 'checkbox' || $field['type'] == 'radio' ||  $field['type'] == 'file'): ?><div class="op-box-feild"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="op-reapfeild op-single-repetitor">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( !empty($field) && is_array($field) ): ?>
                            <?php
                                $field['repeater_type'] = 'single';
                                $field['repeater_id']   = $id;
                                $field['index']         = rand(1,999).time();
                                if( !empty($repeater_id) ){
                                    $field['parent_rep']   = "$repeater_id".'['.$index.']';
                                } 
                            ?>
                            <?php echo getField($field); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!isset($edit) || !empty($edit)): ?>
                        <a class="op-trashfeild op-trash-single-rep" href="javascript:;"  data-repeater_id="<?php echo e($id ?? ''); ?>"><i class="icon-trash-2"></i>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( $field['type'] == 'switch'|| $field['type'] == 'checkbox' || $field['type'] == 'radio' ||  $field['type'] == 'file'): ?>
                                <span><?php echo e(__('optionbuilder::option_builder.remove')); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> 
                        </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>    
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( $field['type'] == 'switch'|| $field['type'] == 'checkbox' || $field['type'] == 'radio' ||  $field['type'] == 'file'): ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!isset($edit) || !empty($edit)): ?>
            <div class="op-add-dwonload more-single-rep" data-repeater="<?php echo e($id ?? ''); ?>">
                <a class="op-btn-two" href="javascript:;"><i class="fa fa-plus"></i><?php echo e(__('optionbuilder::option_builder.add_more')); ?></a>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</li>
<?php /**PATH C:\Users\User\Desktop\well-known\vendor\larabuild\optionbuilder\src/../resources/views/components/single-repeater.blade.php ENDPATH**/ ?>