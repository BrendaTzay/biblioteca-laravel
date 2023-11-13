<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification; 

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return view('notifications.index', compact('notifications'));
    }

    // Cambia la firma del método para incluir Request $request
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->read = true;
        $notification->save();

        return response()->json(['success' => true]);
    }

    // Cambia la firma del método para incluir Request $request
    public function delete(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(['success' => true]);
    }

}
