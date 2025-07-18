<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public array $relationshipFields = [
        'typeId' => 'type.id'
    ];

}
