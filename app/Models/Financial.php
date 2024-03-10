<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Financial extends MainModel
{
    use HasFactory;

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }
}
