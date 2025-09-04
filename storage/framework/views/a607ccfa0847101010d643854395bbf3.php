<div class="cr-course cr-create-course">
    <div class="container">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('courses::course-sidebar', ['tab' => $tab,'id' => $id,'tabs' => $tabs]);

$__html = app('livewire')->mount($__name, $__params, 'lw-3957592814-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('courses::course-'.$tab, ['tab' => $tab,'id' => $id]);

$__html = app('livewire')->mount($__name, $__params, 'lw-3957592814-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>
</div>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Courses/resources/views/livewire/tutor/course-creation/create-course.blade.php ENDPATH**/ ?>