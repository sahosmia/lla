<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use App\Services\UserService;
use App\Http\Requests\Student\Booking\SendMessageRequest;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.app')] class extends Component
{
    public $tutor;
    public $message;
    public $threadId;
    public $recepientId;
    private $userService;
    public $tutorInfo;
    public $isFavourite;
    public $navigate;

    /**
     * Handle an incoming authentication request.
     */

    public function boot() {
        $user = Auth::user();
        $this->userService = new UserService($user);
    }

    public function toggleFavourite($userId)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $isFavourite = $this->userService->isFavouriteUser($userId);
        if($isFavourite){
            $this->userService->removeFromFavourite($userId);
            $this->isFavourite = false;
        } else {
            $this->userService->addToFavourite($userId);
            $this->isFavourite = true;
        }
        $this->dispatch('toggleFavIcon', tutorId: $userId);
    }

    public function mount($tutor,$isFavourite,$navigate = true)
    {
        $this->navigate = $navigate;
        $this->isFavourite = $isFavourite;
        $this->tutor = $tutor;
        $this->tutorInfo['name'] = $tutor->profile->full_name;
        $this->tutorInfo['tagline'] = $tutor->profile->tagline;
        $this->tutorInfo['id'] = $tutor?->id;
        if (!empty($tutor->profile->image) && Storage::disk(getStorageDisk())->exists($tutor->profile->image)) {
            $this->tutorInfo['image'] = resizedImage($tutor->profile->image, 36, 36);
        } else {
            // $this->tutorInfo['image'] = resizedImage('placeholder.png', 36, 36);
            $this->tutorInfo['image'] = setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 36, 36);
        }
    }

    public function sendMessage()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $messageReq = new SendMessageRequest();
        $this->validate($messageReq->rules(), $messageReq->messages());
        $threadInfo = sendMessage($this->recepientId, Auth::user()->id, $this->message);
        $this->threadId = $threadInfo->getData(true)['data']['message']['threadId'] ?? null;
        $this->reset('message');
    }

}; ?>

<div x-data="{
    message: @entangle('message'),
    recepientId: @entangle('recepientId'),
    tutorInfo: @entangle('tutorInfo'),
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

    <a href="{{ $this->navigate ? route('tutor-detail',['slug' => $tutor->profile->slug]).'#availability' : '#availability' }}" class="am-btn">{{ __('tutor.book_session') }}  <i class="am-icon-calender-duration"></i> </a>
    @if(auth()->check() && auth()->user()->role == 'student')
    <a href="javascript:void(0)" @click=" recepientId=@js($tutor->id); threadId=''; $nextTick(() => $wire.dispatch('toggleModel', {id: 'message-model-'+@js($tutor->id),action:'show'}) )" class="am-white-btn"> {{ __('tutor.send_message') }} <i class="am-icon-chat-03"></i></a>
    <a href="javascript:void(0);" wire:click="toggleFavourite({{ $tutor->id }})"
        class="am-likebtn tutor-favourite-{{ $tutor->id }} {{ $this->isFavourite ? 'active' : '' }}">
        <i class="am-icon-heart-01"></i>
    </a>
    @else
    <a href="javascript:void(0);" onclick="Livewire.dispatch('showAlertMessage', {type: `error`, message: `{{ Auth::check() ?  __('general.not_allowed') : __('general.login_error') }}` })" class="am-white-btn">
        {{ __('tutor.send_message') }} <i class="am-icon-chat-03"></i></a>
    <a href="javascript:void(0);" onclick="Livewire.dispatch('showAlertMessage', {type: `error`, message: `{{ Auth::check() ?  __('general.not_allowed') : __('general.login_error') }}` })" class="am-likebtn"> 
       <i class="am-icon-heart-01"></i> 
    </a>
    @endif
    @include('livewire.pages.tutor.action.message' )
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('toggleFavIcon', (event) => {
            $(`#tutor-favourite-${event.detail.tutorId}`).toggleClass('active');
        })
    });
</script>
@endpush
