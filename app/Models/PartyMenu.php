<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PartyMenu extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $appends = [ 'party_name'];

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Products::class);
    }

    public function getPartyNameAttribute()
    {
        return $this->party()->first()->name;
    }

}
