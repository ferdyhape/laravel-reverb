<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all applicable notifications (personal, role-based, and global)
     */
    public function getAllNotificationsQuery()
    {
        return Notification::where(function ($query) {
            $query->where('user_id', $this->id)
                ->orWhere('type', 'all')
                ->orWhere(function ($q) {
                    $q->where('type', 'user')->where('target_role', $this->role);
                });
        });
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadNotificationsCountAttribute()
    {
        $readIds = NotificationRead::where('user_id', $this->id)->pluck('notification_id');

        return $this->getAllNotificationsQuery()
            ->whereNotIn('id', $readIds)
            ->count();
    }

    /**
     * Get latest notifications with read status
     */
    public function getRecentNotificationsAttribute()
    {
        $readIds = NotificationRead::where('user_id', $this->id)->pluck('notification_id');

        return $this->getAllNotificationsQuery()
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) use ($readIds) {
                $notification->is_read = $readIds->contains($notification->id);
                return $notification;
            });
    }
}
