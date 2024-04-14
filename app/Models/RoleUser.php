<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

}
