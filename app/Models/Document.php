<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

/**
 * @property string $documentable_type
 * @property-read WorkApplication|null $documentable
 */
class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'documentable_id',
        'documentable_type',
        'description',
        'file_path',
        'file_name',
    ];

    /**
     * @return MorphTo
     */
    public function documentable(): morphTo {
        return $this->morphTo();
    }

    /**
     * @return string|null
     */
    public function getUrlAttribute()
    {
        if ($this->file_path) {
            return Storage::url($this->file_path);
        }

        return null;
    }
}
