<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sex extends Model
{
    /**
     * Disable Timestamps.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the ads that belong to a specific sex.
     */
    public function ads()
    {
        return $this->hasMany('App\Ad');
    }
}
