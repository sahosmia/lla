<main class="tb-main am-dispute-system" wire:init="loadData">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading ">
                <h4> <?php echo e(__('dispute.all_disputes') .' ('. $disputes->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control" data-searchable="false" data-live='true' id="status" data-wiremodel="status" >
                                            <option value="" <?php echo e($status == '' ? 'selected' : ''); ?>><?php echo e(__('dispute.all')); ?></option>
                                            <option value="pending" <?php echo e($status == 'pending' ? 'selected' : ''); ?>><?php echo e(__('dispute.pending')); ?></option>
                                            <option value="under_review" <?php echo e($status == 'under_review' ? 'selected' : ''); ?>><?php echo e(__('dispute.under_review')); ?></option>
                                            <option value="in_discussion" <?php echo e($status == 'in_discussion' ? 'selected' : ''); ?>><?php echo e(__('dispute.in_discussion')); ?></option>
                                            <option value="closed" <?php echo e($status == 'closed' ? 'selected' : ''); ?>><?php echo e(__('dispute.closed')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control" data-searchable="false" data-live='true' id="sort_by" data-wiremodel="sortby" >
                                            <option value="asc" <?php echo e($sortby == 'asc' ? 'selected' : ''); ?> ><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc" <?php echo e($sortby == 'desc' ? 'selected' : ''); ?> ><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="keyword"  autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    <table class="tb-table <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
                        <thead>
                            <tr>
                                <th><?php echo e(__('dispute.dispute')); ?></th>
                                <th><?php echo e(__('dispute.session')); ?></th>
                                <th><?php echo e(__('dispute.student')); ?></th>
                                <th><?php echo e(__('dispute.tutor')); ?></th>
                                <th><?php echo e(__('dispute.date_created')); ?></th>
                                <th><?php echo e(__('dispute.status')); ?></th>
                                <th class="am-dispute-action">Action</th>
                            </tr>
                        </thead>
                        <!--[if BLOCK]><![endif]--><?php if(!$isLoading): ?>
                            <tbody class="d-none" wire:loading.class.remove="d-none" wire:target="status,sortby,keyword">
                                <?php echo $__env->make('skeletons.admin-dispute', ['perPage' => $perPage], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </tbody>
                            <tbody wire:loading.class="d-none" wire:target="status,keyword,sortby">
                                <!--[if BLOCK]><![endif]--><?php if( !$disputes->isEmpty() ): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $disputes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dispute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td data-label="<?php echo e(__('dispute.dispute')); ?>"><span><?php echo e($dispute?->dispute_reason); ?> <small><?php echo e($dispute?->uuid); ?></small></span></td>
                                            <td data-label="<?php echo e(__('dispute.session')); ?>">
                                                <div class="am-list-wrap">
                                                    <figure class="am-img-rounded">
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($dispute?->booking?->slot?->subjectGroupSubjects?->image) && Storage::disk(getStorageDisk())->exists($dispute?->booking?->slot?->subjectGroupSubjects?->image)): ?>
                                                        <img src="<?php echo e(resizedImage($dispute?->booking?->slot?->subjectGroupSubjects?->image,34,34)); ?>" alt="<?php echo e($dispute?->booking?->slot?->subjectGroupSubjects?->image); ?>" />
                                                        <?php else: ?> 
                                                            <img src="<?php echo e(setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png',34,34)); ?>" alt="<?php echo e($dispute?->booking?->slot?->subjectGroupSubjects?->image); ?>" />
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </figure>
                                                    <span><?php echo e($dispute?->booking?->slot?->subjectGroupSubjects?->subject?->name); ?><br>
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
                                            <td data-label="<?php echo e(__('dispute.student' )); ?>">
                                                <div class="am-list-wrap">
                                                    <figure>
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($dispute?->booking?->student?->image) && Storage::disk(getStorageDisk())->exists($dispute?->booking?->student?->image)): ?>
                                                        <img src="<?php echo e(resizedImage($dispute?->booking?->student?->image,34,34)); ?>" alt="<?php echo e($dispute?->booking?->student?->image); ?>" />
                                                        <?php else: ?>
                                                            <img src="<?php echo e(setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($dispute?->booking?->student?->image); ?>" />
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </figure>
                                                    <span>
                                                        <span>
                                                            <?php echo e($dispute?->creatorBy?->profile?->full_name); ?> 
                                                            <!--[if BLOCK]><![endif]--><?php if($dispute?->winner_id == $dispute?->creatorBy?->id): ?>
                                                            <div class="am-custom-tooltip">
                                                                <span class="am-tooltip-text">
                                                                    <span><?php echo e(__('general.winning_party')); ?></span>
                                                                </span>
                                                                <i class="icon-check-circle"></i>
                                                            </div>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </span> 
                                                        <small><?php echo e($dispute?->creatorBy?->email); ?></small>
                                                    </span>
                                                </div>
                                            </td>
                                            <td data-label="<?php echo e(__('dispute.tutor' )); ?>">
                                                <div class="am-list-wrap">
                                                    <figure>
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($dispute?->booking?->tutor?->image) && Storage::disk(getStorageDisk())->exists($dispute?->booking?->tutor?->image)): ?>
                                                        <img src="<?php echo e(resizedImage($dispute?->booking?->tutor?->image,34,34)); ?>" alt="<?php echo e($dispute?->booking?->tutor?->image); ?>" />
                                                        <?php else: ?> 
                                                            <img src="<?php echo e(setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png',34,34)); ?>" alt="<?php echo e($dispute?->booking?->tutor?->image); ?>" />
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </figure>
                                                    <span>
                                                        <span>
                                                            <?php echo e($dispute?->responsibleBy?->profile?->full_name); ?> 
                                                            <!--[if BLOCK]><![endif]--><?php if($dispute?->winner_id == $dispute?->responsibleBy?->id): ?>
                                                            <div class="am-custom-tooltip">
                                                                <span class="am-tooltip-text">
                                                                    <span><?php echo e(__('general.winning_party')); ?></span>
                                                                </span>
                                                                <i class="icon-check-circle"></i>
                                                            </div>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </span>
                                                        <small><?php echo e($dispute?->responsibleBy?->email); ?></small>
                                                    </span>
                                                </div>
                                            </td>
                                            <td data-label="<?php echo e(__('dispute.date_created')); ?>">
                                                <em><?php echo e(\Carbon\Carbon::parse($dispute?->created_at)->format('d M Y')); ?></em>
                                            </td>
                                            <td data-label="<?php echo e(__('dispute.status' )); ?>">
                                                <div class="am-status-tag">
                                                    <span class="tk-project-tag am-<?php echo e(str_replace('_', '-', $dispute?->status)); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $dispute?->status))); ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <a wire:click="viewDetail('<?php echo e($dispute?->uuid); ?>')" class="tk-project-tag-two am-view-btn">View Detail</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        <?php else: ?>
                            <tbody>
                                <?php echo $__env->make('skeletons.admin-dispute', ['perPage' => $perPage], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </tbody>
                         <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </table>
                    <!--[if BLOCK]><![endif]--><?php if($disputes->isEmpty() && !$isLoading): ?>
                        <div class="am-disputelist-empty" wire:loading.class="d-none" wire:target="status,keyword,sortby">
                            <?php if (isset($component)) { $__componentOriginal86cd4a276c2978c462f28bbb510e89a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-record','data' => ['image' => asset('images/empty.png'),'title' => __('dispute.no_record_title')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(asset('images/empty.png')),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('dispute.no_record_title'))]); ?>
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
                <!--[if BLOCK]><![endif]--><?php if(!$disputes->isEmpty() && !$isLoading): ?>
                    <?php echo e($disputes->links('pagination.custom')); ?>

                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            </div>
        </div>
    </div>
</main><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/admin/dispute/dispute.blade.php ENDPATH**/ ?>