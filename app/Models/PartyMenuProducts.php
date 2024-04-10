<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartyMenuProducts extends MainModel
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
