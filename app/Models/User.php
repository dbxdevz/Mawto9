<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'checkUser'
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
    ];

    public function roles()
	{
		return $this->belongsToMany(Role::class);
	}

    public function permissions()
	{
		return $this->roles->map->permissions
			->flatten()
			->pluck('name')
			->unique();
	}

    public function menuName()
	{
		return $this->roles->map->permissions
			->flatten()
			->pluck('table_name')
			->unique();
	}

    public function deliveryInfo()
    {
        return $this->hasOne(DeliveryMan::class);
    }
}
