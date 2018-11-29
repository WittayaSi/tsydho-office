<?php

namespace App\Http\Controllers;

use App\CarUse;
use App\SettingCar;
use Illuminate\Http\Request;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class CarUseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $events = [];
        $cars = CarUse::all();
        $data['settingcars'] = SettingCar::where('status', 'active')->get();
        $data['yes_cars'] = CarUse::where('start_date', '<=',date('Y-m-d', strtotime('-1 day')))->where('end_date', '>=', date('Y-m-d', strtotime('-1 day')))->get();
        $data['today_cars'] = CarUse::where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->get();
        $data['tom_cars'] = CarUse::where('start_date', '<=',date('Y-m-d', strtotime('+1 day')))->where('end_date', '>=', date('Y-m-d', strtotime('+1 day')))->get();

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
                    'user_name' => $car->user->name,
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
        return view('frontend.car-uses.index', compact('calendar', 'data'));
    }


    public function store(Request $request)
    {
        ///validate input
        $attribute = $request->validate([
            'settingcar_id' => 'required',
            'title' => 'required|min:5|max:100',
            'description' => 'required|min:5|max:500',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        //validate car is already used
        $car_id = request('settingcar_id');
        $start_date = request('start_date');
        $end_date = request('end_date');
        $check_car = CarUse::where('settingcar_id', $car_id)->get();
        if($check_car){
            foreach($check_car as $c){
                if( (
                        $c->start_date >= $start_date  && $c->start_date <= $start_date) || 
                        ($c->end_date >= $start_date && $c->end_date <= $end_date) 
                    ){
                    return back()->withErrors( [ 
                        'store_errors' =>  $c->settingcar->carname." ระหว่างวันที่ ".$c->start_date." ถึง ".$c->end_date." มีคนใช้แล้ว!!!"
                    ] )->withInput($attribute);
                }
            }
        }
        //create new car use
        CarUse::create($attribute + ['user_id' => auth()->id()]);
        return redirect('/frontend/car-uses');
    }


    public function update(Request $request, CarUse $carUse, $id)
    {
        //dd($carUse, $request->getRequestUri());
        session(['uri' => $request->getRequestUri()]);
        $attribute = $request->validate([
            'settingcar_id' => 'required',
            'title' => 'required|min:5|max:100',
            'description' => 'required|min:5|max:500',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        //validate car is already used
        $car_id = request('settingcar_id');
        $start_date = request('start_date');
        $end_date = request('end_date');
        $check_car = CarUse::where('settingcar_id', $car_id)
                            ->where('id', '<>', $id)->get();

        if($check_car){
            foreach($check_car as $c){
                if( (
                        $c->start_date >= $start_date  && $c->start_date <= $start_date) || 
                        ($c->end_date >= $start_date && $c->end_date <= $end_date) 
                    ){
                    return back()->withErrors([
                        'update_errors' => $c->settingcar->carname." ระหว่างวันที่ ".$c->start_date." ถึง ".$c->end_date." มีคนใช้แล้ว!!!"
                    ])->withInput($attribute + ['user_id' => request('user_id')]);
                }
            }
        }

        $car = CarUse::findOrfail($id);
        $car->update($attribute + [ 'user_id' => auth()->id() ]);
        return redirect('/frontend/car-uses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CarUse  $carUse
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarUse $carUse, $id)
    {
        $car = CarUse::findOrfail($id)->delete();
        return back();
    }
}
