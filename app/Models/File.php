<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'file_name',
        'file_path',
        'raw_ai_response',
    ];

    // Best Practice: Automatically decode JSON from DB into a PHP array
    protected $casts = [
        'raw_ai_response' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Helper to get access to the summary easily
    // Usage: $file->summary
    public function getSummaryAttribute(): ?string
    {
        return $this->raw_ai_response['summary'] ?? null;
    }
}
