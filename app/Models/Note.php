<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_application_id',
        'content',
    ];

    public function workApplication(): BelongsTo
    {
        return $this->belongsTo(WorkApplication::class);
    }
}
