<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public $appends = [
        'userRoles'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'parties' => []
        ];
    }

    /**
     * Scope a query to only include popular users.
     */
    public function scopeWhereModelLike(Builder $query, $data): void
    {
        foreach ($data as $column => $item) {

            if(is_int($item) || $column == 'id') {
                $query->orWhere($column, '=', $item);
            }

            if(is_array($item)) {
                $query->orWhereIn($column, $item);
            }

            if(is_string($item)) {
                $query->orWhere($column, 'LIKE', ('%' . $item .'%'));
            }

        }
    }

    //RELATIONSHIPS

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id')
            ->withPivot('party_id')
            ->with('permissions');
    }

    public function permissions()
    {
        return $this->roles()->with('permissions');
    }

    public function parties()
    {
        return $this->belongsToMany(Party::class, 'user_parties', 'user_id', 'party_id');
    }

    public function rolesForParty(?string $partyId = null)
    {
        $query = $this->roles();

        if ($partyId) {
            $query->where(function ($query) use ($partyId) {
                $query->where('role_users.party_id', $partyId)
                    ->orWhereNull('role_users.party_id');
            });
        }

        return $query;
    }

    public function roleNames(?string $partyId = null): array
    {
        if (!$partyId && $this->relationLoaded('roles')) {
            return $this->roles->pluck('name')->unique()->values()->toArray();
        }

        return $this->rolesForParty($partyId)->pluck('name')->unique()->values()->toArray();
    }

    public function permissionNames(?string $partyId = null): array
    {
        $roles = (!$partyId && $this->relationLoaded('roles'))
            ? $this->roles
            : $this->rolesForParty($partyId)->with('permissions')->get();

        return $roles->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        })->unique()->values()->toArray();
    }

    public function hasRole(string|array $roles, ?string $partyId = null): bool
    {
        return collect((array) $roles)->intersect($this->roleNames($partyId))->isNotEmpty();
    }

    public function hasPermission(string|array $permissions, ?string $partyId = null): bool
    {
        return collect((array) $permissions)->intersect($this->permissionNames($partyId))->isNotEmpty();
    }

    public function aclByParty(): array
    {
        $parties = $this->parties()->get();

        return $parties->map(function ($party) {
            return [
                'id' => $party->id,
                'name' => $party->name,
                'roles' => $this->roleNames($party->id),
                'permissions' => $this->permissionNames($party->id),
            ];
        })->values()->toArray();
    }

    public function getUserRolesAttribute()
    {
        return $this->roleNames();
    }
}
