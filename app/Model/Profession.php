<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 4/6/2019
 * Time: 10:08 AM
 */

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use Illuminate\Notifications\Notifiable;

class Profession extends Model
{
    use SoftDeletes;
    use Notifiable;
    protected $table = 'profession';
    protected $fillable = ['id', 'profession_name','description'];
    protected $hidden = [
        'created_at', 'updated_at', 'pivot', 'deleted_at'
    ];
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_profession');
    }
}