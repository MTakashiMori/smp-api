<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

}
