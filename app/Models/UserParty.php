<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserParty extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    public $appends = [
        'party_name'
    ];

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function getPartyNameAttribute(): string
    {
        return $this->party()->first()->name;
    }

}
