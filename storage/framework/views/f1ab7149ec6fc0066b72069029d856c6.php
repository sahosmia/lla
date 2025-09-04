<main class="tb-main am-dispute-system am-review-system">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('general.all_reviews') .' ('. $allTutorReviews->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="sort_by" data-wiremodel="sortby">
                                            <option value="asc" <?php echo e($sortby=='asc' ? 'selected' : ''); ?>><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc" <?php echo e($sortby=='desc' ? 'selected' : ''); ?>><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search"
                                        autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    <!--[if BLOCK]><![endif]--><?php if( !$allTutorReviews->isEmpty() ): ?>
                    <table class="tb-table <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
                        <thead>
                            <tr>
                                <th><?php echo e(__('#' )); ?></th>
                                <th><?php echo e(__('general.reviewer' )); ?></th>
                                <th><?php echo e(__('general.review_date' )); ?></th>
                                <th><?php echo e(__('general.review_or_text')); ?></th>
                                <th><?php echo e(__('general.tutor')); ?></th>
                                <th><?php echo e(__('general.reviewed_on')); ?></th>
                                <th><?php echo e(__('general.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allTutorReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td data-label="<?php echo e(__('#' )); ?>"><span><?php echo e($single->id); ?></span></td>
                                <td data-label="<?php echo e(__('general.reviewer' )); ?>">
                                    <div class="tb-varification_userinfo">
                                        <strong class="tb-adminhead__img">
                                            <!--[if BLOCK]><![endif]--><?php if(!empty($single?->profile?->image) && Storage::disk(getStorageDisk())->exists($single?->profile?->image)): ?>
                                                <img src="<?php echo e(resizedImage($single?->profile?->image,34,34)); ?>" alt="<?php echo e($single?->profile?->image); ?>" />
                                            <?php else: ?>
                                                <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($single?->profile?->image); ?>" />
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </strong>
                                        <span><?php echo e($single?->profile?->full_name); ?></span>
                                    </div>
                                </td>
                                <td data-label="<?php echo e(__('general.created_date' )); ?>"><span><?php echo e($single?->created_at?->format('F d, Y')); ?></span></td>
                                <td data-label="<?php echo e(__('general.review_or_text')); ?>">
                                    <div class="am-review-msg">
                                        <span><i class="icon-star"></i> <?php echo e(number_format($single?->rating, 1)); ?>/5.0</span>
                                        <div class="am-custom-tooltip">
                                            <span class="am-tooltip-text am-tooltip-review">
                                                <span><?php echo e($single?->comment); ?></span>
                                            </span>
                                            <p><?php echo e($single?->comment); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="<?php echo e(__('general.tutor')); ?>">
                                    <div class="tb-varification_userinfo">
                                        <strong class="tb-adminhead__img">
                                            <!--[if BLOCK]><![endif]--><?php if(!empty($single?->tutor?->profile?->image) && Storage::disk(getStorageDisk())->exists($single?->tutor?->profile?->image)): ?>
                                                <img src="<?php echo e(resizedImage($single?->tutor?->profile?->image,34,34)); ?>" alt="<?php echo e($single?->tutor?->profile?->image); ?>" />
                                            <?php else: ?>
                                                <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($single?->tutor?->profile?->image); ?>" />
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </strong>
                                        <span><?php echo e($single?->tutor?->profile?->full_name); ?></span>
                                    </div>
                                </td>
                                <!--[if BLOCK]><![endif]--><?php if($single?->ratingable_type == 'Modules\Courses\Models\Course'): ?>
                                    <td data-label="<?php echo e(__('general.reviewed_on')); ?>">
                                        <div class="tb-varification_userinfo">
                                            <strong class="tb-adminhead__img">
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($single?->ratingable?->media?->path) && Storage::disk(getStorageDisk())->exists($single?->ratingable?->media?->path)): ?>
                                                    <img src="<?php echo e(resizedImage($single?->ratingable?->media?->path,34,34)); ?>" alt="Course Image" />
                                                <?php else: ?>
                                                    <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($single?->ratingable?->media?->path); ?>" />
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </strong>
                                            <span><?php echo e($single?->ratingable?->title); ?></span>
                                        </div>
                                    </td>
                                <?php else: ?>
                                    <td data-label="<?php echo e(__('general.reviewed_on')); ?>">
                                        <div class="tb-varification_userinfo">
                                            <strong class="tb-adminhead__img">
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($single?->ratingable?->slot?->subjectGroupSubjects?->image) && Storage::disk(getStorageDisk())->exists($single?->ratingable?->slot?->subjectGroupSubjects?->image)): ?>
                                                    <img src="<?php echo e(resizedImage($single?->ratingable?->slot?->subjectGroupSubjects?->image,34,34)); ?>" alt="Subject Image" />
                                                <?php else: ?>
                                                    <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($single?->ratingable?->slot?->subjectGroupSubjects?->image); ?>" />
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </strong>
                                            <span><?php echo e($single?->ratingable?->slot?->subjectGroupSubjects?->subject?->name); ?></span>
                                        </div>
                                    </td`>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <td data-label="<?php echo e(__('general.actions')); ?>">
                                    <div class="am-custom-tooltip">
                                        <span class="am-tooltip-text am-tooltip-textimp">
                                            <span><?php echo e(__('general.remove_review')); ?></span>
                                        </span>
                                        <i @click="$wire.dispatch('showConfirm', { id : <?php echo e($single->id); ?>, action : 'delete-review', title: '<?php echo e(__('general.delete_review')); ?>', 
                                            content: '<?php echo e(__('general.delete_review_content')); ?>', icon: 'delete' })" class="icon-trash-2"></i>
                                    </div> 
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                    <?php echo e($allTutorReviews->links('pagination.custom')); ?>

                    <?php else: ?>
                        <?php if (isset($component)) { $__componentOriginal86cd4a276c2978c462f28bbb510e89a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-record','data' => ['image' => asset('images/empty.png'),'title' => __('general.no_record_title')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(asset('images/empty.png')),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.no_record_title'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal86cd4a276c2978c462f28bbb510e89a0)): ?>
<?php $attributes = $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0; ?>
<?php unset($__attributesOriginal86cd4a276c2978c462f28bbb510e89a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal86cd4a276c2978c462f28bbb510e89a0)): ?>
<?php $component = $__componentOriginal86cd4a276c2978c462f28bbb510e89a0; ?>
<?php unset($__componentOriginal86cd4a276c2978c462f28bbb510e89a0); ?>
<?php endif; ?>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>
</main><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/admin/reviews/reviews.blade.php ENDPATH**/ ?>