@extends('frontend.layouts.master')

@section('content')
	<li>
		user id : {{ $task->user_id }}<br/>
	</li>
	<li>
		task title : {{ $task->task }}<br/>
	</li>
	<li>
		task description : {{ $task->description }}<br/>
	</li>
@endsection