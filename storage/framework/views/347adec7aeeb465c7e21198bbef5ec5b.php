<!-- Add pricing section start  -->
<div class="cr-course-box" wire:init="loadData" wire:key="window.Livewire.find('<?php echo e($_instance->getId()); ?>')">
    <div class="cr-content-box">
        <h2><?php echo e(__('courses::courses.add_pricing')); ?></h2>
        <p><?php echo e(__('courses::courses.pricing_description')); ?></p>
    </div>
    <form class="am-themeform" onsubmit="return false;">
        <fieldset>
            <div class="am-themeform__wrap">
                <div class="form-group-wrap">
                    <div class="form-group">
                        <div class="cr-free_course">
                            <div class="cr-free_discription">
                                <label for="cr-free-course-toggle"><?php echo e(__('courses::courses.free_course')); ?></label>
                                <p><?php echo e(__('courses::courses.free_course_description')); ?></p>
                            </div>
                            <input type="checkbox" wire:click='toggleIsFree' id="cr-free-course-toggle" class="cr-toggle" wire:model='isFree' wire:ignore>
                        </div>
                    </div>

                    <!--[if BLOCK]><![endif]--><?php if(!$isFree): ?>
                        <div class="form-group">
                            <label class="am-important" for="course-subtitle"><?php echo e(__('courses::courses.course_price')); ?></label>
                            <div class="form-group-two-wrap cr-discount-wrap">
                                <div class="at-form-group">
                                    <input type="number" wire:model.live.debounce.500ms="price" id="price" placeholder="70">
                                    <i><?php echo e(getCurrencySymbol()); ?></i>
                                </div>
                                <div class="cr-allow-discount">
                                    <label for="allow-discount" class="cr-label"><?php echo e(__('courses::courses.allow_discount')); ?> <span class="cr-optional">(<?php echo e(__('courses::courses.optional')); ?>)</span></label>
                                    <input type="checkbox" wire:click='toggleDiscountAllowed' id="allow-discount" class="cr-toggle" wire:model="discountAllowed">
                                </div>
                            </div>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'price']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'price']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($discountAllowed): ?>
                            <div class="form-group">
                                <div class="cr-choose_discount">
                                    <div class="cr-free_course">
                                        <div class="cr-free_discription">
                                            <label for="cr-free-course-toggle"><?php echo e(__('courses::courses.course_discount')); ?></label>
                                            <p><?php echo e(__('courses::courses.set_course_discount')); ?></p>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($final_price)): ?>
                                            <strong>
                                                <?php echo e(formatAmount($final_price)); ?>

                                                <span><?php echo e(__('courses::courses.purchase_price')); ?></span>
                                            </strong>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="cr-discount-table am-payouthistory">
                                        <table class="am-table">
                                            <thead>
                                            <tr>
                                                <th><?php echo e(__('courses::courses.discount_percentage')); ?></th>
                                                <th><?php echo e(__('courses::courses.discount_amount')); ?></th>
                                                <th><?php echo e(__('courses::courses.purchase_price')); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $discounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discountPercentage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td data-label="<?php echo e(__('courses::courses.discount_percentage')); ?>">
                                                        <div class="am-radio">
                                                            <input name="discount_percentage" <?php if($discountPercentage == $discount): ?>
                                                            checked
                                                            <?php endif; ?> wire:click="updateDiscount(<?php echo e($discountPercentage); ?>)" type="radio" id="discount-<?php echo e($discountPercentage); ?>" value="<?php echo e($discountPercentage); ?>">
                                                            <label for="discount-<?php echo e($discountPercentage); ?>"><?php echo e($discountPercentage); ?>%</label>
                                                        </div>
                                                    </td>
                                                    <td data-label="<?php echo e(__('courses::courses.discount_price')); ?>"><span><?php echo e(getCurrencySymbol()); ?><?php echo e(number_format(((float)$discountPercentage/100) * (float)$this->price, 2)); ?></span></td>
                                                    <td data-label="<?php echo e(__('courses::courses.purchase_price')); ?>"><span><?php echo e(getCurrencySymbol()); ?><?php echo e(number_format(((1 - ((float)$discountPercentage/100)) * (float)$this->price), 2)); ?></span></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            <tr>
                                                <td data-label="<?php echo e(__('courses::courses.discount_percentage')); ?>">
                                                    <div class="cr-input-wrap">
                                                        <div class="am-radio">
                                                            <input name="discount_percentage" <?php if($discount == $customDiscount): ?>
                                                            checked
                                                            <?php endif; ?> wire:click="updateCustomDiscount" type="radio" id="discount-6">
                                                            <label for="discount-6"></label>
                                                        </div>
                                                        <input wire:model.live.debounce.500ms='customDiscount' type="text" placeholder="33%">%
                                                    </div>
                                                </td>
                                                <td data-label="<?php echo e(__('courses::courses.discount_price')); ?>"><span><?php echo e(formatAmount(((integer)$customDiscount/100) * (float)$this->price)); ?></span></td>
                                                <td data-label="<?php echo e(__('courses::courses.purchase_price')); ?>"><span><?php echo e(formatAmount(((1 - ((integer)$customDiscount/100)) * (float)$this->price))); ?></span></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                </div>
            </div>

        </fieldset>

        <div class="am-themeform_footer">

            <a href="<?php echo e(route('courses.tutor.edit-course', ['tab' => 'media', 'id' => $courseId])); ?>" class="am-white-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M10.5 4.5L6 9L10.5 13.5" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
                <?php echo e(__('courses::courses.back')); ?>

            </a>

            <button wire:click="savePricing" class="am-btn" wire:loading.remove wire:target="savePricing"><?php echo e(__('courses::courses.save_continue')); ?></button>
            <button class="am-btn am-btn_disable" wire:loading.flex wire:target="savePricing"><?php echo e(__('courses::courses.save_continue')); ?></button>
        </div>
    </form>
</div>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('modules/courses/css/main.css')); ?>">
<?php $__env->stopPush(); ?>


<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Courses/resources/views/livewire/tutor/course-creation/components/course-pricing.blade.php ENDPATH**/ ?>