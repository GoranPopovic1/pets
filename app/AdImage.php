<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_path', 'ad_id'
    ];

    /**
     * Get the ad that owns the images.
     */
    public function ad()
    {
        return $this->belongsTo('App\Ad');
    }
}
