<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Extensions\Permission\Traits\HasGroup;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasGroup;

    protected $connection = 'hyze';
    protected $table = 'users';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nick'
    ];

    protected $visible = ['id', 'nick', 'is_super_admin', 'groups', 'highest_group'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['is_super_admin', 'groups', 'highest_group'];

    /**
     * Determine if the user is a super admin.
     *
     * @return bool
     */
    public function getIsSuperAdminAttribute(): bool
    {
        return in_array($this->id, config('forum.super_admins', []));
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin;
    }
}
