<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSocial extends Model
{
    use SoftDeletes;
    //
    protected $table = 'social_users';
    protected $fillable = ['user_id', 'social_type','sns_access_token', 'email', 'link', 'platform_id', 'username', 'avatar'];
    protected $hidden = [
        'deleted_at', 'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
