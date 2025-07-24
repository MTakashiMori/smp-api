<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends MainModel
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $appends = [
        'menu_label',
        'group_name'
    ];

    public function menu()
    {
        return $this->belongsTo(PartyMenu::class, 'party_menu_id')->with('party');
    }

    public function group()
    {
        return $this->belongsTo(PartyMenuGroup::class, 'party_menu_group_id');
    }

    public function getMenuLabelAttribute()
    {
        return $this->menu()->first()->label ?? '';
    }

    public function getGroupNameAttribute()
    {
        return $this->group()->first()->name ?? '';
    }

}
