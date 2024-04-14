<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

}
