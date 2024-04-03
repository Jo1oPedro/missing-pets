<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetPostImage extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function pet_post(): BelongsTo
    {
        return $this->belongsTo(PetPost::class);
    }
}
