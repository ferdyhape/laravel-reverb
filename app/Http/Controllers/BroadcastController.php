<?php

namespace App\Http\Controllers;

use App\Events\AllNotification;
use App\Events\UserNotification;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BroadcastController extends Controller
{
    /**
     * Display broadcast page
     */
    public function index()
    {
        $roles = ['admin', 'manager', 'employee'];
        $users = User::orderBy('name')->get();

        return view('app.broadcast.index', compact('roles', 'users'));
    }

    public function send(Request $request)
    {
        // Data validation
        $validated = $request->validate([
            'type'    => 'required|in:user,role,all',
            'role'    => 'required_if:type,role|nullable|in:admin,manager,employee',
            'user_id' => 'required_if:type,user|nullable|exists:users,id',
            'title'   => 'required|string',
            'body'    => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // 1. Save Notification first
            $notification = Notification::create([
                'title'       => $validated['title'],
                'body'        => $validated['body'],
                'type'        => ($validated['type'] === 'all') ? 'all' : 'user',
                'target_role' => ($validated['type'] === 'role') ? $validated['role'] : null,
                'user_id'     => ($validated['type'] === 'user') ? $validated['user_id'] : null,
            ]);

            // 2. Dispatch Real-time Broadcast
            $this->dispatchBroadcast($validated, $notification);

            DB::commit();

            return back()->with('success', 'Notification broadcasted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Failed to send notification: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Helper to handle different broadcast strategies
     */
    protected function dispatchBroadcast(array $data, Notification $notification)
    {
        $payload = [
            'id'    => $notification->id,
            'title' => $notification->title,
            'body'  => $notification->body,
        ];

        switch ($data['type']) {
            case 'role':
                $users = User::where('role', $data['role'])->get();
                foreach ($users as $user) {
                    broadcast(new UserNotification(array_merge($payload, ['user_id' => $user->id])));
                }
                break;

            case 'user':
                broadcast(new UserNotification(array_merge($payload, ['user_id' => $data['user_id']])));
                break;

            case 'all':
                broadcast(new AllNotification($payload));
                break;
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        \App\Models\NotificationRead::updateOrCreate([
            'user_id'         => auth()->id(),
            'notification_id' => $id,
        ], [
            'read_at' => now(),
        ]);

        return response()->json([
            'status'       => 'success',
            'notification' => $notification
        ]);
    }
}
