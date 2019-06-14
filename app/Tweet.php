<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Activity;
use Carbon\Carbon;

class Tweet extends Model
{
    use SoftDeletes;

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
        'hour'
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

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function scopeCreatedBeforeToday($query)
    {
        return $query->where('created_at', '<', new Carbon('today', 'Asia/Tokyo'));
    }

    public function scopeCreatedToday($query)
    {
        return $query->where('created_at', '>', new Carbon('today', 'Asia/Tokyo'))
            ->where('created_at', '<', new Carbon('tomorrow', 'Asia/Tokyo'));
    }

    public function scopeExitActivityHour($query)
    {
        return $query->where('hour', '>', 0);
    }

}
