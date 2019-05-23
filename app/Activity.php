<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use SoftDeletes;

    protected $table = 'activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    protected $dates = ['deleted_at'];

    public function belongsTo()
    {

    }
}
