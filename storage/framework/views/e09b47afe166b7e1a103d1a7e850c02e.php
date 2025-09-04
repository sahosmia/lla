<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use App\Services\UserService;
use App\Http\Requests\Student\Booking\SendMessageRequest;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Storage;

?>

<div x-data="{
    message: <?php if ((object) ('message') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('message'->value()); ?>')<?php echo e('message'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('message'); ?>')<?php endif; ?>,
    recepientId: <?php if ((object) ('recepientId') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('recepientId'->value()); ?>')<?php echo e('recepientId'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('recepientId'); ?>')<?php endif; ?>,
    tutorInfo: <?php if ((object) ('tutorInfo') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('tutorInfo'->value()); ?>')<?php echo e('tutorInfo'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('tutorInfo'); ?>')<?php endif; ?>,
    charLeft:500,
    init(){
        this.updateCharLeft();
    },
    updateCharLeft() {
        let maxLength = 500;
        let messageLength = this.message ? this.message.length : 0;
        if (messageLength ?? 0 > maxLength) {
            this.message = this.message.substring(0, maxLength);
        }
        this.charLeft = maxLength - messageLength ?? 0;
    }
}">

    <a href="<?php echo e($this->navigate ? route('tutor-detail',['slug' => $tutor->profile->slug]).'#availability' : '#availability'); ?>" class="am-btn"><?php echo e(__('tutor.book_session')); ?>  <i class="am-icon-calender-duration"></i> </a>
    <!--[if BLOCK]><![endif]--><?php if(auth()->check() && auth()->user()->role == 'student'): ?>
    <a href="javascript:void(0)" @click=" recepientId=<?php echo \Illuminate\Support\Js::from($tutor->id)->toHtml() ?>; threadId=''; $nextTick(() => $wire.dispatch('toggleModel', {id: 'message-model-'+<?php echo \Illuminate\Support\Js::from($tutor->id)->toHtml() ?>,action:'show'}) )" class="am-white-btn"> <?php echo e(__('tutor.send_message')); ?> <i class="am-icon-chat-03"></i></a>
    <a href="javascript:void(0);" wire:click="toggleFavourite(<?php echo e($tutor->id); ?>)"
        class="am-likebtn tutor-favourite-<?php echo e($tutor->id); ?> <?php echo e($this->isFavourite ? 'active' : ''); ?>">
        <i class="am-icon-heart-01"></i>
    </a>
    <?php else: ?>
    <a href="javascript:void(0);" onclick="Livewire.dispatch('showAlertMessage', {type: `error`, message: `<?php echo e(Auth::check() ?  __('general.not_allowed') : __('general.login_error')); ?>` })" class="am-white-btn">
        <?php echo e(__('tutor.send_message')); ?> <i class="am-icon-chat-03"></i></a>
    <a href="javascript:void(0);" onclick="Livewire.dispatch('showAlertMessage', {type: `error`, message: `<?php echo e(Auth::check() ?  __('general.not_allowed') : __('general.login_error')); ?>` })" class="am-likebtn"> 
       <i class="am-icon-heart-01"></i> 
    </a>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php echo $__env->make('livewire.pages.tutor.action.message' , array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('toggleFavIcon', (event) => {
            $(`#tutor-favourite-${event.detail.tutorId}`).toggleClass('active');
        })
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/tutor/action/action.blade.php ENDPATH**/ ?>