<div class="am-dbbox am-dispute-system" wire:init="loadData">
    <div class="am-dbbox_content">
        <div class="am-dbbox_title">
            <h2><?php echo e(__('dispute.disputes_overview')); ?></h2>
            <div class="am-dbbox_title_sorting">
                <div class="am-inputicon">
                    <input type="text" placeholder="Search here" class="form-control" wire:model.live.debounce.500ms="keyword"  autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                    <a href="#"><i class="am-icon-search-02"></i></a>
                </div>
                <span class="am-select" wire:ignore>
                    <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" class="am-select2" id="status"
                        data-wiremodel="status">
                        <option value="" <?php echo e($status == '' ? 'selected' : ''); ?>><?php echo e(__('dispute.all')); ?></option>
                        <!--[if BLOCK]><![endif]--><?php if(auth()->user()->role == 'student'): ?>
                            <option value="pending" <?php echo e($status == 'pending' ? 'selected' : ''); ?>><?php echo e(__('dispute.pending')); ?></option>
                            <option value="under_review" <?php echo e($status == 'under_review' ? 'selected' : ''); ?>><?php echo e(__('dispute.under_review')); ?></option>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <option value="in_discussion" <?php echo e($status == 'in_discussion' ? 'selected' : ''); ?>><?php echo e(__('dispute.in_discussion')); ?></option>
                        <option value="closed" <?php echo e($status == 'closed' ? 'selected' : ''); ?>><?php echo e(__('dispute.closed')); ?></option>
                    </select>
                </span>
            </div>
        </div>
        <div class="am-disputelist_wrap">
            <div class="am-disputelist am-custom-scrollbar-y">
                <table class="am-table <?php if(setting('_general.table_responsive') == 'yes'): ?> am-table-responsive <?php endif; ?>">
                    <thead>
                        <tr>
                            <th><?php echo e(__('dispute.dispute')); ?></th>
                            <th><?php echo e(__('dispute.session')); ?></th>
                            <?php if(auth()->user()->role == 'tutor'): ?>
                                <th><?php echo e(__('dispute.student')); ?></th>
                            <?php elseif(auth()->user()->role == 'student'): ?>
                                <th><?php echo e(__('dispute.tutor')); ?></th>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <th><?php echo e(__('dispute.date_created')); ?></th>
                            <th>
                                <div class="am-status-action">
                                    <span><?php echo e(__('dispute.status')); ?></span>
                                    <span><?php echo e(__('dispute.action')); ?></span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <!--[if BLOCK]><![endif]--><?php if(!$isLoading): ?>
                        <tbody class="d-none" wire:loading.class.remove="d-none" wire:target="status,keyword">
                            <?php echo $__env->make('skeletons.dispute', ['perPage' => $perPage], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </tbody>
                        <tbody wire:loading.class="d-none" wire:target="status,keyword">
                            <!--[if BLOCK]><![endif]--><?php if(!$disputes->isEmpty()): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $disputes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dispute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td data-label="<?php echo e(__('dispute.dispute')); ?>">
                                        <span><?php echo e($dispute?->dispute_reason); ?>

                                            <small><?php echo e($dispute?->uuid); ?></small>
                                        </span>
                                    </td>
                                    <td data-label="<?php echo e(__('dispute.session' )); ?>">
                                        <div class="am-list-wrap">
                                            <figure class="am-img-rounded">
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($dispute?->booking?->slot?->subjectGroupSubjects?->image) && Storage::disk(getStorageDisk())->exists($dispute?->booking?->slot?->subjectGroupSubjects?->image)): ?>
                                                <img src="<?php echo e(resizedImage($dispute?->booking?->slot?->subjectGroupSubjects?->image,34,34)); ?>" alt="<?php echo e($dispute?->booking?->slot?->subjectGroupSubjects?->image); ?>" />
                                                <?php else: ?>
                                                    <img src="<?php echo e(resizedImage('placeholder.png',34,34)); ?>" alt="image" />
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </figure>
                                            <span><?php echo e($dispute?->booking?->slot?->subjectGroupSubjects?->subject?->name); ?>

                                                <small><?php echo e($dispute?->booking?->slot?->subjectGroupSubjects?->group?->name); ?> 
                                                    <!--[if BLOCK]><![endif]--><?php if(setting('_lernen.time_format') == '12'): ?> 
                                                        <?php echo e(\Carbon\Carbon::parse($dispute?->booking?->start_time)->format('h:i A')); ?> - <?php echo e(\Carbon\Carbon::parse($dispute?->booking?->end_time)->format('h:i A')); ?> 
                                                    <?php else: ?> 
                                                        <?php echo e(\Carbon\Carbon::parse($dispute?->booking?->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($dispute?->booking?->end_time)->format('H:i')); ?> 
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 
                                                </small>
                                            </span>
                                        </div>
                                    </td>
                                    <!--[if BLOCK]><![endif]--><?php if(auth()->user()->role == 'student'): ?>
                                        <td data-label="<?php echo e(__('dispute.tutor')); ?>">
                                            <div class="am-list-wrap ">
                                                <figure>
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($dispute?->responsibleBy?->profile?->image) && Storage::disk(getStorageDisk())->exists($dispute?->responsibleBy?->profile?->image)): ?>
                                                    <img src="<?php echo e(resizedImage($dispute?->responsibleBy?->profile?->image,34,34)); ?>" alt="<?php echo e($dispute?->responsibleBy?->profile?->image); ?>" />
                                                    <?php else: ?>
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($dispute?->responsibleBy?->profile?->image); ?>" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </figure>
                                                <span><?php echo e($dispute?->responsibleBy?->profile?->full_name); ?> 
                                                    <small><?php echo e($dispute?->responsibleBy?->email); ?></small>
                                                </span>
                                            </div>
                                        </td>
                                    <?php elseif(auth()->user()->role == 'tutor'): ?>
                                        <td data-label="<?php echo e(__('dispute.student')); ?>">
                                            <div class="am-list-wrap">
                                                <figure>
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($dispute?->creatorBy?->profile?->image) && Storage::disk(   'public')->exists($dispute?->creatorBy?->profile?->image)): ?>
                                                    <img src="<?php echo e(resizedImage($dispute?->creatorBy?->profile?->image,34,34)); ?>" alt="<?php echo e($dispute?->creatorBy?->profile?->image); ?>" />
                                                    <?php else: ?>
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($dispute?->creatorBy?->profile?->image); ?>" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </figure>
                                                <span><?php echo e($dispute?->creatorBy?->profile?->full_name); ?>

                                                    <small><?php echo e($dispute?->creatorBy?->email); ?></small>
                                                </span>
                                            </div>
                                        </td>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <td data-label="<?php echo e(__('Date Created')); ?>"><em><?php echo e(\Carbon\Carbon::parse($dispute?->created_at)->format('F j, Y, g:i A')); ?></em></td>
                                    <td data-label="<?php echo e(__('Status')); ?>">
                                        <div class="am-status-tag">
                                            <span class="tk-project-tag-two am-<?php echo e(str_replace('_', '-', $dispute?->status)); ?> <?php echo e($dispute?->status == 'pending' ? 'tk-hourly-tag' : 'tk-fixed-tag'); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $dispute?->status))); ?></span>
                                            <a href="javascript:void(0)" wire:click="viewDetail('<?php echo e($dispute?->uuid); ?>')" class="tk-project-tag-two am-view-btn"><?php echo e(__('dispute.view_detail')); ?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    <?php else: ?>
                        <tbody>
                            <?php echo $__env->make('skeletons.dispute', ['perPage' => $perPage], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </tbody>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </table>
                <!--[if BLOCK]><![endif]--><?php if($disputes->isEmpty() && !$isLoading): ?>
                    <div class="am-disputelist-empty" wire:loading.class="d-none" wire:target="status,keyword">
                        <?php if (isset($component)) { $__componentOriginal86cd4a276c2978c462f28bbb510e89a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-record','data' => ['image' => asset('images/payouts.png'),'title' => __('general.no_disputes'),'description' => __('general.no_disputes_desc')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(asset('images/payouts.png')),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.no_disputes')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.no_disputes_desc'))]); ?>
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
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <!--[if BLOCK]><![endif]--><?php if(!$disputes->isEmpty()): ?>
                    <?php echo e($disputes->links('pagination.pagination')); ?>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/common/dispute/dispute.blade.php ENDPATH**/ ?>