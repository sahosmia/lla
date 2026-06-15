<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('trainer.profile')
            ->orderByRaw('sort_date IS NULL, sort_date ASC')
            ->get();
        return response()->json(['success' => true, 'data' => $events]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'date_time' => 'nullable|string|max:255',
            'sort_date' => 'nullable|date',
            'mode' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'banner_image' => 'nullable|image|max:1024',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $eventData = $request->except('banner_image');
        if ($request->hasFile('banner_image')) {
            $eventData['banner_image'] = $request->file('banner_image')->store('events', 'public');
        }

        $event = Event::create($eventData);
        return response()->json(['success' => true, 'data' => $event]);
    }

    public function show($id)
    {
        $event = Event::with(['trainer.profile', 'users.profile'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $event]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'date_time' => 'nullable|string|max:255',
            'sort_date' => 'nullable|date',
            'mode' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'banner_image' => 'nullable|image|max:1024',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $eventData = $request->except('banner_image');
        if ($request->hasFile('banner_image')) {
            if ($event->banner_image) {
                Storage::disk('public')->delete($event->banner_image);
            }
            $eventData['banner_image'] = $request->file('banner_image')->store('events', 'public');
        }

        $event->update($eventData);
        return response()->json(['success' => true, 'data' => $event]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if ($event->banner_image) {
            Storage::disk('public')->delete($event->banner_image);
        }
        $event->delete();
        return response()->json(['success' => true, 'message' => 'Training Calendar deleted successfully']);
    }
}
