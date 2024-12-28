<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifications extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'title',
        'notification',
        'type',
        'is_read',
    ];

    public function sender() {
        return $this->hasOne(User::class, 'id','sender_id');
    }

    public function receiver() {
        return $this->hasOne(User::class, 'id','receiver_id');
    }
}
