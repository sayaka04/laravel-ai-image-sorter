<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'album_name',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function uploadQueues(): HasMany
    {
        return $this->hasMany(UploadQueue::class);
    }

    // Best Practice: "Has Many Through" allows you to do $album->files 
    // to get all sorted files, even though they are inside categories.
    public function files(): HasManyThrough
    {
        return $this->hasManyThrough(File::class, Category::class);
    }
}
