<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

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
                    'user_id' => $task->user_id
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
        //dd(request()->all());
        //$daterange = explode(" - ", request('daterange'));
        //dd($daterange);
        //$start_date = date('Y-m-d', strtotime($daterange[0]));
        //$end_date = date('Y-m-d', strtotime($daterange[1]));
        ///dd($start_date,$end_date);

        // validate input 
        $attribute = request()->validate([
            'task' => 'required|min:5|max:100',
            'description' => 'required|min:5|max:500',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        // save to database
        Task::create($attribute + ['user_id' => auth()->id()]);
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
        dd($task, request()->all());
        $attribute = request()->validate([
            'task' => 'required|min:5|max:100',
            'description' => 'required|min:5|max:500',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        $task->update($attribute);
        return redirect('/frontend/tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //dd('delete');
        $task->delete();
        return back();
    }
}
