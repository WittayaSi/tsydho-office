<?php

namespace App\Http\Controllers;

use App\SettingCar;
use App\CarUse;

class CustomerApiController extends Controller
{
	public function getAllCars()
	{
		$cars = SettingCar::all();
		return response()->json([
			'cars' => $cars
		]);
	}

	public function checkCar()
    {
        //dd(request()->all());
        //$start_date = request('start_date');
        //$end_date = request('end_date');
        //return request('car_id');
        $check_car = CarUse::where('settingcar_id', request('car_id'))
                            ->where('task_id', '<>', request('task_id'))
                            ->orWhere('task_id', "NULL")->get();
       //return $check_car;
        if(count($check_car) > 0){
            foreach($check_car as $c){
                if( ($c->start_date >= request('start_date')  && $c->start_date <= request('end_date')) || 
                        ($c->end_date >= request('start_date') && $c->end_date <= request('end_date')) 
                    ){
                    return response()->json([
                    	"status" => "err",
                    	"message" => $c->settingcar->carname." ระหว่างวันที่ ".$c->start_date." ถึง ".$c->end_date." มีคนใช้แล้ว!!!"
                    ]);
                }
            }
            return response()->json([
                "status" => 'ok1',
                "message" => ""
            ]);
        }else{
        	return response()->json([
            	"status" => 'ok2',
            	"message" => ""
            ]);
        }
    }
}