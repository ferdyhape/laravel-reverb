<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'notification_id', 'read_at'])]
class NotificationRead extends Model
{
    //
}
