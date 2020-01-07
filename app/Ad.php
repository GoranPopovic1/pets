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
        'title', 'description', 'category_id', 'sex_id', 'user_id'
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

    /**
     * Get the category that the ad belongs to.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Get the sex that the ad belongs to.
     */
    public function sex()
    {
        return $this->belongsTo('App\Sex');
    }


    public function scopeFilter($query, $params)
    {
        if ( !empty($params['category']) ) {
            $query->where('category_id', $params['category']);
        }

        if ( !empty($params['sex']) ) {
            $query->where('sex_id', $params['sex']);
        }

        if ( !empty($params['search-term']) ) {
            $query->where('title', 'like', '%' . $params['search-term'] . '%');
            $query->orWhere('description', 'like', '%' . $params['search-term'] . '%');
        }

    }
}
