<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Financial extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }
}
