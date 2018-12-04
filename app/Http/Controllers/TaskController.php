<?php

namespace App\Http\Controllers;

use App\Task;
use App\SettingCar;
use App\CarUse;
use Illuminate\Http\Request;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $events = [];
        $tasks = Task::all();
        $data['settingcars'] = SettingCar::where('status', 'active')->get();
        $data['yes_tasks'] = Task::where('start_date', '<=',date('Y-m-d', strtotime('-1 day')))->where('end_date', '>=', date('Y-m-d', strtotime('-1 day')))->get();
        $data['today_tasks'] = Task::where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->get();
        $data['tom_tasks'] = Task::where('start_date', '<=',date('Y-m-d', strtotime('+1 day')))->where('end_date', '>=', date('Y-m-d', strtotime('+1 day')))->get();

        foreach ($tasks as $key => $task) {
            //dd($task->user);
            $events[] = Calendar::event(
                $task->task,
                true,
                new \DateTime($task->start_date),
                new \DateTime($task->end_date.' +1 day'),
                $task->id,
                [
                    'color' => $task->user->color_code,
                    'description' => $task->description,
                    'user_id' => $task->user_id,
                    'settingcar_id' => $task->settingcar_id
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
            ],
            'eventTextColor' => '#FFFFFF'
        ]);

        $calendar->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => 'function(event) {
                onClickEvent(event, "controller");
            }',
            'eventRender' => 'function(event, jsEvent, view){
                onRenderEvent(event, jsEvent)
            }'
        ]);


        return view('frontend.tasks.index',compact('calendar','data'));
    }

    public function store()
    {
        $attribute = request()->validate([
            'task' => 'required|min:5|max:100',
            'description' => 'required|min:5|max:500',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        //validate car is already used
        $car_id = request('settingcar_id');
        $start_date = request('start_date');
        $end_date = request('end_date');

       //unset($attribute['task']);
        //dd( $attribute );
        
        if($car_id != null){
            // save to database
            try{
                DB::beginTransaction();
                $task = Task::create($attribute + ['user_id' => auth()->id()] + ['settingcar_id' => $car_id]);
                unset($attribute['task']);
                CarUse::create($attribute + ['user_id' => auth()->id()] + ['title' => request('task')] + ['settingcar_id' => $car_id] 
                    + ['task_id' => $task->id]
                );
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                return back()->withErrors( [ 
                    'store_errors' =>  'มีปัญหาเรื่องการบันทึกข้อมุล ' . $e
                ] )->withInput($attribute + ['task' => request('task')] + ['settingcar_id' => $car_id]);
            }
            
        }else{
            // save to database
            Task::create($attribute + ['user_id' => auth()->id()]);
        }
        return redirect('/frontend/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $this->authorize('update', $task);
        return view('frontend.tasks.show', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        //dd($task, request()->all());
        $attribute = request()->validate([
            'task' => 'required|min:5|max:100',
            'description' => 'required|min:5|max:500',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        //push uri to session
        session(['uri' => $request->getRequestUri()]);

        //validate car is already used
        $car_id = request('settingcar_id');
        $start_date = request('start_date');
        $end_date = request('end_date');

        if($car_id != null){
            try{
                DB::beginTransaction();
                $task->update($attribute  + ['user_id' => auth()->id()] + ['settingcar_id' => $car_id]);
                $caruse = CarUse::findOrfail($task->id);
                if($caruse){
                    unset($attribute['task']);
                    $caruse->update($attribute + ['user_id' => auth()->id()] + ['title' => request('task')] + ['settingcar_id' => $car_id] 
                        + ['task_id' => $task->id]
                    );
                }else{
                    unset($attribute['task']);
                    CarUse::create($attribute + ['user_id' => auth()->id()] + ['title' => request('task')] + ['settingcar_id' => $car_id] 
                        + ['task_id' => $task->id]
                    );
                }
                
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                return back()->withErrors( [ 
                    'update_errors' =>  'มีปัญหาเรื่องการบันทึกข้อมุล ' . $e
                ] )->withInput($attribute + ['task' => request('task')] + ['settingcar_id' => $car_id]);
            }
        }else{
            $task->update($attribute  + ['user_id' => auth()->id()]);
        }
        
        
        return redirect('/frontend/tasks');
    }

    public function destroy(Task $task)
    {
        //dd('delete');
        $task->delete();
        return back();
    }
}
