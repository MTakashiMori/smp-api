<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Sponsor extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public function sponsoredParties(): HasManyThrough
    {
        return $this->hasManyThrough(Party::class, PartySponsor::class, 'sponsor_id', 'id', 'id', 'party_id');
    }
}
