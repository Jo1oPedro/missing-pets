<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PetPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pet_post_images(): HasMany
    {
        return $this->hasMany(PetPostImage::class);
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(function (string $value) {
            return new \DateTime($value);
        });
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(function (string $value) {
            return new \DateTime($value);
        });
    }
}
