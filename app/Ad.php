<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'category', 'sex', 'user_id'
    ];

    /**
     * Get the images for the ad.
     */
    public function images()
    {
        return $this->hasMany('App\AdImage');
    }

    /**
     * Get the user that owns the ads.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
