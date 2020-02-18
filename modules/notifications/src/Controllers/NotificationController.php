<?php
namespace Modules\Notifications\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get all unread notifications for authenticated user
     *
     * @return mixed
     */
    public function unread()
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * Mark all unread notifications or specific notification as read
     *
     * @param Request $request
     * @return Response
     */
    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }
}