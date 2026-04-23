<?php

namespace App\Models;

use Database\Factories\UserNotificationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'title', 'body', 'type', 'read_at'])]
#[UseFactory(UserNotificationFactory::class)]
class Notification extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead(): bool
    {
        if ($this->read_at !== null) {
            return false;
        }
        return $this->update(['read_at' => now()]);
    }

    public function markAsUnread(): bool
    {
        if ($this->read_at === null) {
            return false;
        }
        return $this->update(['read_at' => null]);
    }
}
