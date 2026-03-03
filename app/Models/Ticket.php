<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model 
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'closure_requested',
        'closed_reason',
        'priority',
        'labels',
    ];

    protected $casts = [
        'closure_requested' => 'boolean',
    ];

    /**
     * Reason provided when a ticket is closed by an admin.
     */
    protected $attributes = [
        'closed_reason' => null,
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