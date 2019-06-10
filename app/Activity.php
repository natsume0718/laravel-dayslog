<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Tweet;

class Activity extends Model
{
    use SoftDeletes;

    protected $table = 'activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'task_id',
        'hour',
        'continuation_days',
        'days_of_activity'
    ];

    /**
     * 日付を変形する属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }
}
