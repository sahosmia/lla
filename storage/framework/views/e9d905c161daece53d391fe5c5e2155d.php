<?php if($grid_id): ?>
	<?php
		setGridId( $grid_id );
		$css = getCss();
		if(!empty(getBgOverlay()))
		$css = 'position:relative;'.$css;
	?>
<?php endif; ?>

<section class="pb-themesection griddable <?php echo e(getClasses()); ?>" data-grid-name="<?php echo e($grid); ?>" data-cols=<?php echo json_encode($columns); ?> id="<?php echo e($grid_id); ?>" <?php echo !empty($css)? 'style="' .$css.'"':''; ?>>
	<?php echo getBgOverlay(); ?>

	<div <?php echo getContainerStyles(); ?>>

		<div class="row pb-tooltip">
			<?php if(!empty($data)): ?>
				<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column => $components): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="<?php echo e(!empty($columns[$column]) ? $columns[$column] : ''); ?> droppable nested-sortable">
						<?php if(!empty($css['background-overlay-color'])): ?>
						<div style="background-color: <?php echo e($css['background-overlay-color']); ?>;
							position: absolute;
							left: 0;
							top: 0;
							width: 100%;
							height: 100%;">
						</div>
						<?php endif; ?>
						<?php $__currentLoopData = $components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
							setSectionId($component['id']);
							?>

							<?php if(view()->exists('pagebuilder.' . $component['section_id'] . '.view')): ?>
								<?php $__env->startComponent('pagebuilder::components.grid',
									[	
										'template_id' => $component['section_id'],
										'droppable'   => false,
										'id'          => $component['id']
									]
								); ?>

									<div class="pb-section-content section-data-<?php echo e($component['section_id']); ?> w-100">
										<?php echo view('pagebuilder.' . $component['section_id']. '.view')->render(); ?>

									</div>
							
								<?php echo $__env->renderComponent(); ?>
								
							<?php else: ?>
								<?php $__env->startComponent('pagebuilder::components.grid', 
									[	
										'template_id' =>null,
										'droppable'   => true,
										'id'          => null,
									]
								); ?>
									<div class="pb-addsection-info">
										<svg class="pb-svg-border">
											<rect width="100%" height="100%"></rect>
										</svg>
										<a href="javascript:;" class="iconPlus">
											<i class="icon-plus"></i>
										</a>
									</div>
								<?php echo $__env->renderComponent(); ?>
								
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			<?php else: ?>
				<?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				
					<div class="<?php echo e($item); ?> droppable nested-sortable">
						<?php $__env->startComponent('pagebuilder::components.grid',['class'=>'','template_id'=>null,'id'=>'','droppable'=>true]); ?> <?php echo $__env->renderComponent(); ?>
					</div>

				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>

			<?php $__env->startComponent('pagebuilder::components.grid-actions',['class'=>'','template_id'=>null,'id'=>'','droppable'=>false]); ?> <?php echo $__env->renderComponent(); ?>
		</div>
	</div>
	<div class="grid-placeholder">
        <a href="javascript:void(0)" class="pb-elementcontent">
            <i class="icon-grid"></i>
            <span><?php echo e($grid); ?></span>
        </a>
    </div>
</section><?php /**PATH D:\Sahos\Laravel\lla\vendor\larabuild\pagebuilder\src/../resources/views/components/grid-placeholder.blade.php ENDPATH**/ ?>