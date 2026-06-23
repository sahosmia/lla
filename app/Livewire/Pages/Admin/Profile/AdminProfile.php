<?php

namespace App\Livewire\Pages\Admin\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Profile;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AdminProfile extends Component {
    public $name, $old_image, $image, $first_name, $last_name, $email, $current_password, $new_password, $confirm_password;
    public $cropImageUrl    = '';
    public $allowImageSize;
    public $allowImageExt;

    #[Layout('layouts.admin-app')]
    public function render() {
        return view('livewire.pages/admin.profile.profile');
    }

    public function mount() {

        $user   = Auth::user();
        $this->email = $user->email;
        $image_file_ext          = setting('_general.allowed_image_extensions') ?? [];
        $image_file_size         = setting('_general.max_image_size');
        $this->allowImageSize    = (int) (!empty( $image_file_size ) ? $image_file_size : '3');
        $this->allowImageExt   = !empty( $image_file_ext ) ?  explode(',', $image_file_ext) : ['jpg', 'png'];
        $userProfile = Profile::where('user_id', $user->id)->select('first_name', 'last_name', 'image')->first();
        if (!empty($userProfile)) {
            $this->first_name   = $userProfile->first_name;
            $this->last_name    = $userProfile->last_name;
            $this->old_image    = $userProfile->image;
        }
    }

    public function update() {

        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        
        $this->validate([
            'first_name'            => 'required|string',
            'last_name'             => 'nullable|string',
            'email'                 => 'required|email|unique:users,email,' . Auth::user()->id,
            'new_password'          => 'sometimes|nullable|min:5|required_with:current_password',
            'confirm_password'      => 'sometimes|nullable|min:5|same:new_password|required_with:current_password',
        ], [
            'min'       => __('admin/general.minimum_lenght', ['length' => 5]),
            'required'  => __('admin/general.required_field'),
            'same'      => __('admin/general.same_error_msg'),
        ]);

        $user   = Auth::user();

        if (!empty($this->current_password) && !empty($this->new_password)) {
            $isSave = false;
            if (Hash::check($this->current_password, $user->password)) {
                $user->password = Hash::make($this->new_password);
            } else {
                $this->addError('current_password', __('admin/general.wrong_error_msg'));
                return;
            }
        }
        $user->email    = sanitizeTextField($this->email);
        $isSave         = $user->save();
        $data = array(
            'first_name'    => sanitizeTextField($this->first_name),
            'last_name'     => sanitizeTextField($this->last_name),
            'image'         => null,
        );

        $imageData = null;

        if (!empty($this->cropImageUrl)) {

            $bse64 = explode(',', $this->cropImageUrl);
            $bse64 = trim($bse64[1]);
            if (!base64_encode(base64_decode($bse64, true)) === $bse64 || !imagecreatefromstring(base64_decode($bse64))) {
                $this->dispatch('showAlertMessage', [
                    'type'      => 'error',
                    'title'     => __('admin/general.error_title'),
                    'message'   => __('admin/general.invalid_file_type', ['file_types' => join(',', $this->allowImageExt)])
                ]);
                return;
            }

            $imageData = uploadImage('profile_images', $this->cropImageUrl);
            if (!empty($imageData)) {
                $data['image'] = $imageData;
            }
        } elseif (!empty($this->old_image)) {
            $data['image'] = $this->old_image;
        }


        $updated                    = Profile::where('user_id', $user->id)->update($data);
        if(!empty($imageData)) {
            $this->dispatch('update_image', image: resizedImage($imageData, 36, 36));
        }
        $eventData['title']         = $updated ? __('admin/general.success_title') : __('admin/general.error_title');
        $eventData['type']          = $updated ? 'success' : 'error';
        $eventData['message']       = $updated ? __('admin/general.success_message') : __('admin/general.error_msg');

        $this->current_password = $this->new_password = $this->confirm_password = '';
        $this->dispatch('showAlertMessage', type:  $eventData['type'], title: $eventData['title'] , message:$eventData['message']);
    }

    public function removePhoto() {
        $this->cropImageUrl = $this->old_image = null;
    }
}
