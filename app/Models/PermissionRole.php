<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionRole extends MainModel
{
    use HasFactory;

    protected $guarded = [];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
