<main class="tb-main am-dispute-system am-courses-system">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4><?php echo e(__('courses::courses.all_courses') . ' (' . $courses->total() . ')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select" wire:ignore>
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="category-select"
                                            data-wiremodel="status">
                                            <option value="" ><?php echo e(__('courses::courses.all')); ?></option>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter_status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                               <option value="<?php echo e($filter_status); ?>" <?php echo e($status == $filter_status ? 'selected' : ''); ?>>
                                                   <?php echo e(__('courses::courses.' . $filter_status)); ?></option>
                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="filters.keyword"
                                        autocomplete="off" placeholder="<?php echo e(__('courses::courses.search_by_keyword')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    <!--[if BLOCK]><![endif]--><?php if(!$courses->isEmpty()): ?>
                        <table class="tb-table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('courses::courses.id')); ?></th>
                                    <th><?php echo e(__('courses::courses.title')); ?></th>
                                    <th><?php echo e(__('courses::courses.instructor')); ?></th>
                                    <th><?php echo e(__('courses::courses.category')); ?></th>
                                    <th><?php echo e(__('courses::courses.subcategory')); ?></th>
                                    <th><?php echo e(__('courses::courses.status')); ?></th>
                                    <th><?php echo e(__('courses::courses.actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('courses::courses.id')); ?>">
                                            <span><?php echo e($course->id); ?></span>
                                        </td>
                                        <td data-label="<?php echo e(__('courses::courses.title')); ?>">
                                            <span><?php echo e($course->title); ?></span>
                                        </td>
                                        <td data-label="<?php echo e(__('courses::courses.instructor')); ?>">
                                            <div class="am-instructor-column <?php echo e($course->instructor?->profile?->verified_at ? 'am-verified' : ''); ?>">
                                                <span><?php echo e($course->instructor?->profile?->full_name); ?></span>
                                                <div class="am-custom-tooltip">
                                                    <i class="icon-alert-circle"></i>
                                                    <span class="am-tooltip-text">
                                                        <span>
                                                            <?php echo e($course->instructor?->profile?->verified_at ? __('courses::courses.verified') : __('courses::courses.non_verified')); ?>

                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('courses::courses.category')); ?>">
                                            <span><?php echo e($course->category->name); ?></span>
                                        </td>
                                        <td data-label="<?php echo e(__('courses::courses.subcategory')); ?>">
                                            <span><?php echo e($course->subCategory->name); ?></span>
                                        </td>
                                        <td data-label="<?php echo e(__('courses::courses.status')); ?>">
                                            <div class="am-status-tag">
                                                <em class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                    'tk-project-tag',
                                                'tk-active' => $course->status == 'active',
                                                'tk-disabled' => $course->status == 'inactive',
                                                'tk-disabled' => $course->status == 'under_review',
                                            ]); ?>"><?php echo e(__('courses::courses.' . $course->status)); ?></em>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('courses::courses.actions')); ?>">
                                            <ul class="tb-action-icon">
                                                <!--[if BLOCK]><![endif]--><?php if($course->status == 'under_review'): ?>
                                                <li>
                                                    <div class="am-custom-tooltip">
                                                        <span class="am-tooltip-text"><?php echo e(__('courses::courses.approve_course')); ?></span>
                                                        <a href="javascript:void(0);"  wire:click="approveCourse(<?php echo e($course->id); ?>)">
                                                            <i class="icon-check"></i>
                                                        </a> 
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="am-custom-tooltip">
                                                        <span class="am-tooltip-text"><?php echo e(__('courses::courses.reject_course')); ?></span>
                                                        <a href="javascript:void(0);" wire:click="rejectCourse(<?php echo e($course->id); ?>)" >
                                                            <i class="icon-x"></i>
                                                        </a> 
                                                    </div>
                                                </li>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <li>
                                                    <div class="am-custom-tooltip">
                                                        <span class="am-tooltip-text"><?php echo e(__('courses::courses.view_details')); ?></span>
                                                        <a href="<?php echo e(route('courses.course-detail', ['slug' => $course->slug])); ?>" target="_blank">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="am-custom-tooltip">
                                                        <span class="am-tooltip-text"><?php echo e(__('courses::courses.remove_course')); ?></span>
                                                         <a href="javascript:void(0);" @click="$wire.dispatch('showConfirm', { id : <?php echo e($course->id); ?>, action : 'delete-course' })"  class="tb-delete"><i class="icon-trash-2"></i></a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    <?php else: ?>
                        <?php if (isset($component)) { $__componentOriginal86cd4a276c2978c462f28bbb510e89a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-record','data' => ['image' => asset('images/empty.png'),'title' => __('courses::courses.no_records_found')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(asset('images/empty.png')),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('courses::courses.no_records_found'))]); ?>
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
                <?php echo e($courses->links('pagination.custom')); ?>

            </div>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        document.addEventListener('livewire:initialized', function () {
            $(document).on('select2:select', '#category-select', function(e) {
                let selectedValue = e.params.data.id;
                window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('filters.status', selectedValue);
            });
            
        });
    </script>
<?php $__env->stopPush(); ?>

<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Courses/resources/views/livewire/admin/course-listing.blade.php ENDPATH**/ ?>