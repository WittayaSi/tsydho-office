@extends('layouts.master')
@section('title', 'แผนปฏิบัติงาน')
@section('content')
<style type="text/css">
.calendar-container {
    height: 80vh;
    font-size: 0.9rem;
}
.card-header-label{
	font-size: 0.9rem;
}
.col-padding{
	padding-left: 1px;
	padding-right: 1px;
}

</style>

	@include('frontend.tasks.add_task_modal')
	@include('frontend.tasks.detail_task_modal')
	@include('layouts.errors')
	
	<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addTask" 
		style="position: absolute; z-index: 2; margin-top: -1rem;">
        <i class="fa fa-plus"></i> เพิ่มแผนปฏิบัติงาน
    </button>

	<div id="accordion">
		<div class="card mb-2">
			<div class="card-header text-center alert-success" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				<button class="btn btn-link" style="text-decoration: none; color: black;">
					<h4>แผนปฏิบัติงาน</h4>
				</button>
			</div>
			<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
				<div class="card-body">
					<div class="row">
						<div class="col col-padding">
							<div class="card border-success mb-3">
								<div class="card-header text-center card-header-label">เมื่อวาน</div>
								<div class="card-body" style="font-size: 0.8rem;">
									@if(count($data['yes_tasks']) < 1)
										<center style="color: red;">ไม่มีข้อมูล</center>
									@else
										@foreach($data['yes_tasks'] as $task)
											<a href="#" style="text-decoration: none; color: white;" 
												onclick="onClickEvent({{$task}}, 'view')"
											>
												<li style="background-color: {{ $task->user->color_code }}; margin-bottom: 0.1rem;" class="rounded">{{ $task->task }}</li>
											</a>
										@endforeach
									@endif
								 </div>
							</div>
						</div>
						<div class="col col-padding">
							<div class="card border-success mb-3">
								<div class="card-header text-center card-header-label">วันนี้</div>
								<div class="card-body" style="font-size: 0.8rem;">
									@if(count($data['today_tasks']) < 1)
										<center style="color: red;">ไม่มีข้อมูล</center>
									@else
									    @foreach($data['today_tasks'] as $task)
											<a href="#" style="text-decoration: none; color: white;" 
												onclick="onClickEvent({{$task}}, 'view')"
											>
												<li style="background-color: {{ $task->user->color_code }}; margin-bottom: 0.1rem;" class="rounded">{{ $task->task }}</li>
											</a>
										@endforeach
									@endif
								 </div>
							</div>
						</div>
						<div class="col col-padding">
							<div class="card border-success mb-3">
								<div class="card-header text-center card-header-label">พรุ่งนี้</div>
								<div class="card-body" style="font-size: 0.8rem;">
									@if(count($data['tom_tasks']) < 1)
										<center style="color: red;">ไม่มีข้อมูล</center>
									@else
									    @foreach($data['tom_tasks'] as $task)
									    	<a href="#" style="text-decoration: none; color: white;" 
												onclick="onClickEvent({{$task}}, 'view')"
											>
												<li style="background-color: {{ $task->user->color_code }}; margin-bottom: 0.1rem;" class="rounded">{{ $task->task }}</li>
											</a>
										@endforeach
									@endif
								 </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 calendar-container">
			{!! $calendar->calendar() !!}
			{!! $calendar->script() !!}
		</div>
	</div>
@endsection

@push('scripts')
<script type="text/javascript">
	@if ($errors->any())
		@foreach($errors->all() as $key=>$error)
			@if($key != 'admin_errors')
	    		$('#addTask').modal('show');
	    	@endif
	    @endforeach
	@endif
</script>

<script src="{{ asset('js/task-index.js') }}"></script>
@endpush
