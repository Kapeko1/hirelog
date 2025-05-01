<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Note;
use App\Enums\ApplicationStatus;
class WorkApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_name',
        'company_name',
        'application_date',
        'status',
        'job_url',
        'location'
    ];

    protected $casts = [
        'application_date' => 'datetime',
        'status' => ApplicationStatus::class,
    ];

    public function user(): BelongsTo   {
        return $this->belongsTo(User::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function notes(): HasMany    {
        return $this->hasMany(Note::class);
    }
}
