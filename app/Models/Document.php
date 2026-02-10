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

    public function documentable(): morphTo
    {
        return $this->morphTo();
    }

    /**
     * Boot the model and add model event listeners
     */
    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($document) {
            $disk = Storage::disk(config('documents.disk'));
            if ($document->file_path && $disk->exists($document->file_path)) {
                $disk->delete($document->file_path);
            }
        });
    }

    /**
     * @return string|null
     */
    public function getUrlAttribute()
    {
        if ($this->file_path) {
            return Storage::disk(config('documents.disk'))->url($this->file_path);
        }

        return null;
    }
}
