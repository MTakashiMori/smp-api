<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Party extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;


    protected $guarded = [];

    protected $appends = ['date'];

    public function financial(): HasMany
    {
        return $this->hasMany(Financial::class);
    }

    public function sponsors(): HasManyThrough
    {
        return $this->hasManyThrough(Sponsor::class, PartySponsor::class);
    }

    public function partyMenu()
    {
        return $this->hasMany(PartyMenu::class);
    }

    public function getDateAttribute()
    {
        return [$this->start_date, $this->end_date];
    }
}
