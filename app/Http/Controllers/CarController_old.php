<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\SettingCar;
use App\Car;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $events = [];
        $cars = Car::all();
        $data['settingcars'] = SettingCar::where('status', 'active')->get();
        $data['yes_cars'] = Car::where('start_date', '<=',date('Y-m-d', strtotime('-1 day')))->where('end_date', '>=', date('Y-m-d', strtotime('-1 day')))->get();
        $data['today_cars'] = Car::where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->get();
        $data['tom_cars'] = Car::where('start_date', '<=',date('Y-m-d', strtotime('+1 day')))->where('end_date', '>=', date('Y-m-d', strtotime('+1 day')))->get();

        foreach ($cars as $key => $car) {
            //dd($task->user);
            $events[] = Calendar::event(
                $car->settingcar->carname,
                true,
                new \DateTime($car->start_date),
                new \DateTime($car->end_date.' +1 day'),
                $car->id,
                [
                    'color' => $car->settingcar->carcolor,
                    'description' => $car->description,
                    'con_title' => $car->title,
                    'user_id' => $car->user_id,
                    'settingcar_id' => $car->settingcar_id
                ]
            );
        }
        $calendar = Calendar::addEvents($events);
        $calendar->setOptions([
            'locale' => 'th',
            'height' => 'parent',
            'header' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'month,agendaWeek,agendaDay,listMonth'
                //'right' => 'month,agendaWeek,agendaDay,listMonth'
            ]
        ]);

        $calendar->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => 'function(event) {
                onClickEvent(event, "controller");
            }',
            'eventRender' => 'function(event, jsEvent, view){
                onRenderEvent(event, jsEvent);
            }'
        ]);
        return view('frontend.cars.index', compact('calendar', 'data'));
    }

    
    public function store(Request $request)
    {
        //dd(request()->all());
        $attribute = $request->validate([
            'settingcar_id' => 'required',
            'title' => 'required|min:5|max:100',
            'description' => 'required|min:5|max:500',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        $car_id = request('settingcar_id');
        $start_date = request('start_date');
        $end_date = request('end_date');

        $check_car = Car::where('settingcar_id', $car_id)->get();

        foreach($check_car as $c){
            if($c->start_date >= $start_date || $c->end_date >= $end_date){
                dd('true');
            }else{
                dd('false');
            }
        } 

        Car::create($attribute + ['user_id' => auth()->id()]);
        return redirect('/frontend/cars-use');
    }

 
    public function update(Request $request, Car $car)
    {
        dd($car, request()->all());
        $attribute = $request->validate([
            'settingcar_id' => 'required',
            'title' => 'required|min:5|max:100',
            'description' => 'required|min:5|max:500',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        //$car = Car::findOrfail($id);
        //dd($attribute, $car);
        
        $car->update($attribute + [ 'user_id' => auth()->id() ]);
        return redirect('/frontend/cars-use');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        //dd($car);
        $car->delete();
        return back();
    }
}
