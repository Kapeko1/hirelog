<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationCode extends Model
{
    protected $fillable = [
        'code',
        'is_used',
        'user_id',
        'used_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsUsed(int $userId): bool
    {
        return $this->update([
            'is_used' => true,
            'user_id' => $userId,
            'used_at' => now(),
        ]);
    }

    public function isAvailable(): bool
    {
        return ! $this->is_used;
    }

    public static function findByCode(string $code): ?self
    {
        return self::where('code', $code)->first();
    }
}
