<?php

namespace App;

use App\Model\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'full_name', 'date_of_birth', 'gender',
        'country', 'location', 'avatar', 'description', 'last_login', 'ip', 'is_active', 'user_type', 'id'
    ];

    protected $table = 'users';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'deleted_at', 'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_socials()
    {
        return $this->hasMany('App\Model\UserSocial');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'user_categories');
    }
}
