<?php

namespace App\Models;

use App\Enums\UploadStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UploadQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'file_path',
        'original_filename',
        'status',
    ];

    // Best Practice: Cast the string status to the PHP Enum
    protected $casts = [
        'status' => UploadStatus::class,
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
