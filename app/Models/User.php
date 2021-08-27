<?php

namespace App\Models;

use App\Traits\UserTraits;
use Exception;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable,
        UserTraits,
        HasApiTokens,
        SoftDeletes,
        HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'password', 'security_answer', 'security_question', 'remember_token', 'access_code', 'deleted_at', 'updated_at', 'email_verified_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isSuperAdmin()
    {
        return intval($this->role_id) === 1;
    }

    public function isBasicAdmin()
    {
        return intval($this->role_id) === 2;
    }

    public function isTrustee()
    {
        return intval($this->role_id) === 3;
    }

    public function isBasicUser()
    {
        return intval($this->role_id) === 4;
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function details()
    {
        return $this->hasOne(UserDetails::class);
    }

    public function myApplications()
    {
        return $this->hasMany(ProjectApplications::class);
    }

    public function projects() //created projects
    {
        return $this->hasMany(Project::class);
    }

    public function payments() //money you paid
    {
        return $this->hasMany(Payment::class);
    }

    public static function getUser($userId)
    {
        $user = self::where('id', $userId);
        return $user->count() ? $user : throw new Exception("Invalid user Id");
    }
}
