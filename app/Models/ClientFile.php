<?php

namespace App\Models;

use App\Traits\ImageHandler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Spatie\Browsershot\Browsershot;
class ClientFile extends Model
{
    use ImageHandler;
    protected $fillable = [
        'client_id',
        'attachment_type_id',
        'file_name',
        'file_path',
        'notes',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function attachmentType(): BelongsTo
    {
        return $this->belongsTo(AttachmentType::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if ($model->file_path) {
                $model->deleteImage($model->file_path, 'clients');
            }
        });
    }
    public function deleteFileIfExists(): void
    {
        $fileName = $this->attributes['file_path'] ?? null;
        $exists = $fileName && $this->existsFile($fileName, 'clients');
        if ($exists) {
            $this->deleteFile($fileName, 'clients');
        }
    }
    public function scopeSearch(Builder $query, string|null $search): Builder
    {
        return empty($search) ? $query : $query->where(function ($query) use ($search) {
            $query->where('file_name', 'like', "%{$search}%")
                ->orWhereHas('attachmentType', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        });
    }
    public function downloadFileIfExists(): ?StreamedResponse
    {
        $fileName = $this->attributes['file_path'] ?? null;
        $exists = $fileName && $this->existsFile($fileName, 'clients');
        if ($exists) {
            return $this->downloadFile($fileName, 'clients');
        }
        return null;
    }
}
