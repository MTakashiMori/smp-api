<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionsType extends MainModel
{
    use HasFactory;

    protected $table = 'transaction_types';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];
}
