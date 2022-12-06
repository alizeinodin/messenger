<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;

    protected const POSITION_LEFT = "left";
    protected const POSITION_RIGHT = "right";

    protected $fillable = [
        'content'
    ];

    protected $appends = [
        'position'
    ];

    /**
     * Get position of a message in the chat
     *
     * @return string
     */
    public function getPositionAttribute(): string
    {
        return $this->sender_id === Auth::user()->id ? $this::POSITION_LEFT : $this::POSITION_RIGHT;
    }

    /**
     * Get the Sender that owns the Messages
     *
     * @return BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    /**
     * Get the Receiver that owns the Messages
     *
     * @return BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
