<ul class="am-userperinfo_tab">
    <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-active'=> $activeRoute == auth()->user()->role.'.profile.personal-details']); ?>">
        <a href="<?php echo e(route(auth()->user()->role.'.profile.personal-details')); ?>" wire:navigate.remove>
            <?php echo e(__('profile.personal_details')); ?>

        </a>
    </li>
    <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-active'=> $activeRoute == auth()->user()->role.'.profile.account-settings']); ?>">
        <a href="<?php echo e(route(auth()->user()->role.'.profile.account-settings')); ?>" wire:navigate.remove>
            <?php echo e(__('profile.account_settings')); ?>

        </a>
    </li>
    <!--[if BLOCK]><![endif]--><?php if(auth()->user()->role == 'tutor'): ?>
        <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-active'=> in_array($activeRoute , [auth()->user()->role.'.profile.resume.education', auth()->user()->role.'.profile.resume.experience', auth()->user()->role.'.profile.resume.certificate'])]); ?>">
            <a href="<?php echo e(route('tutor.profile.resume.education')); ?>"
                wire:navigate.remove><?php echo e(__('profile.resume_highlights')); ?>

            </a>
        </li>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    
    <?php
        $isIdentity = setting('_lernen.identity_verification_for_role') ?? "both";
    ?>

    <?php if(auth()->user()->role == 'tutor' || $isIdentity == 'both'): ?>
        <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-active'=> $activeRoute == auth()->user()->role.'.profile.identification']); ?>">
            <a href="<?php echo e(route(auth()->user()->role.'.profile.identification')); ?>" wire:navigate.remove>
                <?php echo e(__('profile.identity_verification')); ?>

            </a>
        </li>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</ul><?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/pages/common/profile-settings/tabs.blade.php ENDPATH**/ ?>