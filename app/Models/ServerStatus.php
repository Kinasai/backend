<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServerStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'server_id',
        'online_users',
        'wait_users',
        'lobby_users',
        'status',
        'congestion',
        'channel_data',
    ];
    
    protected $casts = [
        'channel_data' => 'array',
    ];
}
