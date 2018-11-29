<?php

namespace App\Http\Controllers;

use App\SettingCar;
use Illuminate\Http\Request;

class SettingCarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth') && $this->middleware('auth.admin');
    }

    public function index()
    {
        $cars = SettingCar::all();
        return view('backend.setting.cars.index', compact('cars'));
    }

    public function store()
    {
        //dd(request()->all());
        $attribute = request()->validate([
            'carname' => ['required', 'min:5', 'max:20'],
            'carcolor' => ['required'],
            'status' => ['required']
        ]);

        SettingCar::create($attribute);
        return redirect('/backend/setting/cars');

    }

    
    // public function edit($id)
    // {
    //     $car = SettingCar::findOrFail($id);
    //     return $car;
    // }

    public function edit(SettingCar $car)
    {
        //$car = SettingCar::findOrFail($id);
        return $car;
    }


    public function update(SettingCar $car)
    {
        //dd($request);
        $attribute = request()->validate([
            'carname' => ['required', 'min:5', 'max:20'],
            'carcolor' => ['required'],
            'status' => ['required']
        ]);
        //dd($attribute);
        $car->update($attribute);
        return back();
    }

    
    public function destroy(SettingCar $settingCar)
    {
        //
    }
}
