<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $primaryKey = 'id';
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'nik',
        'name',
        'password',
        'roles', // Add 'roles' to the $fillable array
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
     * Check if the user has a specific role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        // Assuming roles is a comma-separated string (e.g., "Admin,inspector")
        $roles = explode(',', $this->roles);

        return in_array($role, $roles);
    }

    /**
     * Get the possible roles.
     *
     * @return array
     */
    public static function getPossibleRoles()
    {
        return ['Admin', 'inspector']; // Add other roles as needed
    }
}