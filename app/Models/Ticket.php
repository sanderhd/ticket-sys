<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model 
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'priority',
        'labels',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}