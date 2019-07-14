<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Extensions\Permission\Traits\HasGroup;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
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

    protected $visible = ['id', 'nick', 'is_super_admin', 'groups_due', 'highest_group', 'email_verified_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['is_super_admin',  'is_banned_permanently', 'groups', 'highest_group'];

    /**
     * Determine if the user is a super admin.
     *
     * @return bool
     */
    public function getIsSuperAdminAttribute(): bool
    {
        return in_array($this->id, config('forum.super_admins', []));
    }

    public function getIsBannedPermanentlyAttribute(): bool {
        return DB::connection('hyze')
            ->table('user_punishments')
            ->where('user_id', $this->id)
            ->where('type', 'BAN')
            ->where('revoker_user_id', null)
            ->where('duration', '>', 5184000000)
            ->limit(1)
            ->count() != 0;
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin;
    }

    public function sendChangePasswordNotification()
    {
        $this->notify(new \App\Notifications\ChangePassword);
    }

    public function sendChangeEmailNotification()
    {
        $this->notify(new \App\Notifications\ChangeEmail);
    }
}
