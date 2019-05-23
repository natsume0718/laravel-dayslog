<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Activity;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'twitter_id',
        'twitter_name',
        'twitter_nickname',
        'twitter_avatar_original'
    ];

    protected $dates = ['deleted_at'];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
