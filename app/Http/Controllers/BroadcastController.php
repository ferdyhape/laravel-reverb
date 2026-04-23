<?php

namespace App\Http\Controllers;

use App\Events\AllNotification;
use App\Events\UserNotification;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    public function index()
    {
        $roles = [
            'admin',
            'manager',
            'employee',
        ];

        return view('app.broadcast.index', compact('roles'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'type'  => 'required|in:user,all',
            'role'  => 'required_if:type,user|nullable|in:admin,manager,employee',
            'title' => 'required|string',
            'body'  => 'required|string',
        ]);

        $title = $validated['title'];
        $body  = $validated['body'];
        $type  = $validated['type'];

        if ($type === 'user') {
            $users = User::where('role', $validated['role'])->get();

            foreach ($users as $user) {
                $notification = Notification::create([
                    'user_id'    => $user->id,
                    'title'      => $title,
                    'body'       => $body,
                    'type'       => $type,
                ]);

                broadcast(new UserNotification([
                    'id'      => $notification->id,
                    'user_id' => $user->id,
                    'title'   => $title,
                    'body'    => $body,
                ]));
            }
        } else {
            Notification::create([
                'title' => $title,
                'body'  => $body,
                'type'  => 'all',
            ]);

            broadcast(new AllNotification([
                'title' => $title,
                'body'  => $body,
            ]));
        }

        return back()
            ->with('success', 'Notification sent successfully!')
            ->withInput();
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->update([
            'read_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'notification' => $notification
        ]);
    }
}
