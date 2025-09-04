<?php

namespace Amentotech\LaraGuppy\Http\Controllers;

use App\Http\Controllers\Controller;
use Amentotech\LaraGuppy\Http\Requests\ProfileStoreRequest;
use Amentotech\LaraGuppy\Http\Resources\GuppyContactsResource;
use Amentotech\LaraGuppy\Http\Resources\GuppySettingsResource;
use Amentotech\LaraGuppy\Http\Resources\GuppyUserResource;
use Amentotech\LaraGuppy\Models\GpUser;
use Amentotech\LaraGuppy\Services\ChatService;
use Amentotech\LaraGuppy\Traits\ApiResponser;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ApiResponser;
    /**
     * Get user profile
     */
    public function index(Request $request) {
        $model = get_class($request->user());
        $request->request->add(['model_class' => $model]);
        return response()->json(['type' => 'success', 'user' => new GuppyUserResource($request->user())]);
    }

    /**
     * Edit user profile
     */
    public function store(ProfileStoreRequest $request) {
        $values = $request->only(['name', 'email', 'phone']);
        $data = array_filter($values);
        if($request->hasFile('photo')){
            $file_path      = $request->file('photo')->store('laraguppy/profile', getStorageDisk());
            $file_path      = str_replace('public/', '', $file_path);
            $data['photo']  = $file_path;
        }

        GpUser::updateOrCreate(['user_id' => auth()->user()->id], $data);

        return $this->success(new GuppyUserResource($request->user()), __('laraguppy::chatapp.profile_updated'));
    }

    /**
     * Get LaraGuppy Settings
     */
    public function settings(Request $request) {
        return $this->success(new GuppySettingsResource($request), );
    }

    /**
    * Display a listing of the contacts.
    */
    public function contacts()
    {
        $contacts = [];

        $contacts  = (new ChatService)->getContacts();

        return response()->json(['type' => 'success', 'data' => new GuppyContactsResource($contacts)]);
    }


    /**
    * Display a listing of the contacts.
    */
    public function reportUser(Request $request)
    {

    }
}
