<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Party extends MainModel
{
    use HasFactory;

    protected $guarded = [];

    public function financial(): HasMany
    {
        return $this->hasMany(Financial::class);
    }

    public function sponsors(): HasManyThrough
    {
        return $this->hasManyThrough(Sponsor::class, PartySponsor::class);
    }
}
