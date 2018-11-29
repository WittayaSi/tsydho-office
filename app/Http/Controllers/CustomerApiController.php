<?php

namespace App\Http\Controllers;

use App\SettingCar;

class CustomerApiController extends Controller
{
	public function getAllCars()
	{
		$cars = SettingCar::all();
		return response()->json([
			'cars' => $cars
		]);
	}
}