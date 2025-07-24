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

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function sponsors(): HasManyThrough
    {
        return $this->hasManyThrough(Sponsor::class, PartySponsor::class);
    }

    public function partyMenu()
    {
        return $this->hasMany(PartyMenu::class);
    }

    public function currentPartyMenu()
    {
        return $this->hasOne(PartyMenu::class)->where('active', 1);
    }

    public function getDateAttribute()
    {
        return [$this->start_date, $this->end_date];
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, UserParty::class, 'party_id', 'id', 'id', 'user_id');
    }
}
