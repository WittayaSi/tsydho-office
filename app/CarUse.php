<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarUse extends Model
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

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
