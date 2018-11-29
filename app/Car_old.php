<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $guarded = [];

    //protected $table = 'cars';

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function settingcar()
    {
    	return $this->belongsTo(SettingCar::class);
    }
}
