<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Activity;

class Tweet extends Model
{
    protected $table = 'tweets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tweet_id',
        'body',
    ];

    protected $dates = ['deleted_at'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

}
