<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;
class User extends Authenticatable // implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, LaravelPermissionToVueJS;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',  'locations','cashAccounts',
'cardAccounts',
'onlineAccounts',
'gpayAccounts',
'phonepeAccounts',
'amazonpayAccounts',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'locations' => 'array',
        'cashAccounts' => 'array',
        'cardAccounts' => 'array',
        'onlineAccounts' => 'array',
        'gpayAccounts' => 'array',
        'phonepeAccounts' => 'array',
        'amazonpayAccounts' => 'array',

    ];

     /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getPhotoAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '.jpg?s=200&d=mm';
    }

    /*public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assigning User role
     *
     * @param \App\Models\Role $role
     */
  /*  public function assignRole(Role $role)
    {
        return $this->roles()->save($role);
    }

    public function isAdmin()
    {
        return $this->roles()->where('name', 'Admin')->exists();
    }

    public function isUser()
    {
        return $this->roles()->where('name', 'User')->exists();
    }*/

    public function registers()
  {
    return $this->hasmany(Register::class);
  }

}
