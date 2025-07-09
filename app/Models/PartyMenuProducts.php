<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartyMenuProducts extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $appends = [
        'menu_label',
        'party_name',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function menu()
    {
        return $this->belongsTo(PartyMenu::class, 'party_menu_id')->with('party');
    }

    public function getMenuLabelAttribute()
    {
        return $this->menu()->first()->label ?? '';
    }

    public function getPartyNameAttribute()
    {
        return $this->menu()->first()->party->name ?? '';
    }
}
