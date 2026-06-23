<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notifications\NotificationCollection;
use App\Services\DbNotificationService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    use ApiResponser;
    /**
     * Get all notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        $notifications = (new DbNotificationService())->getUserNotificationsPaginated($request->user());
        return $this->success(data: new NotificationCollection($notifications) ,message: __('api.notifications_retrieved_successfully'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->whereKey($id)->first();
        if (empty($notification)) {
            return $this->error(message: __('api.not_found'), code: Response::HTTP_NOT_FOUND);
        }
        if (empty($notification->read_at)) {
            $notification->markAsRead();
            return $this->success(message: __('api.notification_marked_as_read'));
        }
        return $this->error(message: __('api.already_read_notification'), code: Response::HTTP_BAD_REQUEST);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        if ($request->user()->unreadNotifications->isEmpty()) {
            return $this->error(message: __('api.already_read_notification'), code: Response::HTTP_BAD_REQUEST);
        }

        $request->user()->unreadNotifications->markAsRead();
        return $this->success(message: __('api.all_notification_marked_as_read'));
    }
}
