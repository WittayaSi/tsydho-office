@extends('layouts.master')
@section('title', 'แผนการใช้รถยนต์ราชการ')
@section('content')
<style type="text/css">
.calendar-container {
    height: 80vh;
    font-size: 0.9rem;
}
.card-header-label{
	font-size: 0.9rem;
}
.small-label {
    font-size: .8rem;
}

.small-tooltip {
    font-size: .6rem;
    margin-top: -0.9rem;
}

input[type=date]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    display: none;
}

input::placeholder,
textarea::placeholder,
option,
.select-style {
    font-size: 0.8rem;
}

</style>

	@include('frontend.car-uses.add_car_use_modal')
	@include('frontend.car-uses.detail_car_use_modal')

	<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addCarUse" 
		style="position: absolute; z-index: 2; margin-top: -1rem;">
        <i class="fa fa-plus"></i> เพิ่มแผนการใช้รถยนต์
    </button>

	<div id="accordion">
		<div class="card mb-2">
			<div class="card-header text-center alert-info" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				<button class="btn btn-link" style="text-decoration: none; color: black;">
					<h4>แผนการใช้รถยนต์ราชการ</h4>
				</button>
			</div>
			<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
				<div class="card-body">
					<div class="row">
						<div class="col">
							<div class="card border-success mb-3">
								<div class="card-header text-center card-header-label">เมื่อวาน</div>
								<div class="card-body" style="font-size: 0.8rem;">
									@if(count($data['yes_cars']) < 1)
										<center style="color: red;">ไม่มีข้อมูล</center>
									@else
										@foreach($data['yes_cars'] as $car)
											<a href="#" style="text-decoration: none; color: white;" 
												onclick="onClickEvent({{$car}}, 'view')"
											>
												<li style="background-color: {{ $car->settingcar->carcolor }}; margin-bottom: 0.1rem;" class="rounded">{{ $car->settingcar->carname }}</li>
											</a>
										@endforeach
									@endif
								 </div>
							</div>
						</div>
						<div class="col">
							<div class="card border-success mb-3">
								<div class="card-header text-center card-header-label">วันนี้</div>
								<div class="card-body" style="font-size: 0.8rem;">
									@if(count($data['today_cars']) < 1)
										<center style="color: red;">ไม่มีข้อมูล</center>
									@else
									    @foreach($data['today_cars'] as $car)
											<a href="#" style="text-decoration: none; color: white;" 
												onclick="onClickEvent({{$car}}, 'view')"
											>
												<li style="background-color: {{ $car->settingcar->carcolor }}; margin-bottom: 0.1rem;" class="rounded">{{ $car->settingcar->carname }}</li>
											</a>
										@endforeach
									@endif
								 </div>
							</div>
						</div>
						<div class="col">
							<div class="card border-success mb-3">
								<div class="card-header text-center card-header-label">พรุ่งนี้</div>
								<div class="card-body" style="font-size: 0.8rem;">
									@if(count($data['tom_cars']) < 1)
										<center style="color: red;">ไม่มีข้อมูล</center>
									@else
									    @foreach($data['tom_cars'] as $car)
									    	<a href="#" style="text-decoration: none; color: white;" 
												onclick="onClickEvent({{$car}}, 'view')"
											>
												<li style="background-color: {{ $car->settingcar->carcolor }}; margin-bottom: 0.1rem;" class="rounded">{{ $car->settingcar->carname }}</li>
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
	{{-- <script type="text/javascript">
		@if (count($errors) > 0)
		    $('#addCarUse').modal('show');
		@endif
	</script> --}}

	<script type="text/javascript">
		// let setFormEn = ()=>{
		// 	document.querySelector('#user_id').value = {{ old('user_id') }}
		// 	document.querySelector('#editCarUseForm').action =  {{ request()->getRequestUri() }}
		// }
		@if ($errors->any())
			@if($errors->has('store_errors'))
				$('#addCarUse').modal('show');
				console.log({{ old('settingcar_id') }})
			@endif
			@if($errors->has('update_errors'))
				//setFormEn();
				$('#detailCarUse').modal('show');
				document.querySelector('#editCarUseForm').action =  "{{ session('uri') }}"
			@endif
		@endif
	</script>
	<script src="{{ asset('js/car-use-index.js') }}"></script>
@endpush
