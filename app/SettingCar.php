<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingCar extends Model
{
	//protected $table = 'setting_cars';

    protected $fillable = [
    	'carname', 'carcolor', 'status'
    ];



    // public function user()
    // {
    // 	return $this->belongsTo(User::class);
    // }
}
