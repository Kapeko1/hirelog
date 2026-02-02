<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationStatusHistory extends Model
{
    protected $fillable = [
        'work_application_id',
        'from_status',
        'to_status',
        'changed_at',
    ];

    protected $casts = [
        'from_status' => ApplicationStatus::class,
        'to_status' => ApplicationStatus::class,
        'changed_at' => 'datetime',
    ];

    public function workApplication(): BelongsTo
    {
        return $this->belongsTo(WorkApplication::class);
    }
}
