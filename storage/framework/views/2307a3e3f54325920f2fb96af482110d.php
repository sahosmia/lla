<div class="am-profile-setting">
    <?php echo $__env->make('livewire.pages.common.profile-settings.tabs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="am-userperinfo">
        <div class="am-resumebox">
            <div class="am-resumebox_tab">
                <div class="am-resumebox_tab_title">
                    <span><?php echo e(__('profile.resume_highlights')); ?></span>
                </div>
                <ul class="am-resumebox_tab_list">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(["am-active"=> $activeRoute == $item['route']]); ?>">
                        <a href="<?php echo e(route($item['route'])); ?>" wire:navigate.remove>
                            <?php echo $item['icon']; ?>

                            <span><?php echo e($item['title']); ?></span>
                        </a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            </div>
            <!--[if BLOCK]><![endif]--><?php if(request()->routeIs('*.resume.experience')): ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages.common.profile-settings.resume.experience', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3532101598-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php elseif(request()->routeIs('*.resume.certificate')): ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages.common.profile-settings.resume.certificate', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3532101598-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php else: ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages.common.profile-settings.resume.education', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3532101598-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/common/profile-settings/resume.blade.php ENDPATH**/ ?>