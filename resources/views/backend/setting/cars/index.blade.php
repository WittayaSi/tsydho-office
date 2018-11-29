@extends('layouts.master')

@section('title', 'ADMINISTRATOR-CARS')

@section('content')
	
<style type="text/css">
	.circle {
		height: 20px;
		width: 30px;
		border-radius: 50%;
	}
</style>
	
	<h2 class="mb-5">Setting Cars</h2>

	@include('backend.setting.cars._modal_add_form')
	@include('backend.setting.cars._modal_edit_form')

	<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addNewCar" 
		style="position: absolute; z-index: 2; margin-top: -1rem;">
        <i class="fa fa-plus"></i> เพิ่มรถยนต์
    </button>

	<table class="table table-bordered table-hover table-sm">
		<thead>
			<th class="text-center">เลขทะเบียน</th>
			<th class="text-center">Color</th>
			<th class="text-center">Status</th>
			<th class="text-center">Actions</th>
		</thead>
		<tbody style="font-size: 0.9rem;">
			@foreach($cars as $car)
				<tr>
					<td class="text-center">{{ $car->carname }}</td>
					<td><div class="circle" style="background-color: {{$car->carcolor}}; margin: auto;"></div></td>
					<td class="text-center"><span class="badge badge-{{ 
						$car->status == 'active' ? 'success' : 'danger'
					}}">{{ $car->status }}</span></td>
					<td style="text-align: center; white-space: nowrap;">
						<div class="btn-group btn-group-sm" role="group" aria-label="action group">
						  	<button type="button" class="btn btn-success" title="ดูข้อมูล"><i class="fa fa-search"></i></button>
						  	<button type="button" class="btn btn-warning" 
						  		title="แก้ไขข้อมูล" 
						  		{{-- data-toggle="modal" 
						  		data-target="#editUser" --}}
						  		onclick="onClickEditCar({{ $car->id }});" 
						  	><i class="fa fa-edit"></i></button>

						  	<button type="button" class="btn btn-danger" title="ลบข้อมูล" 
						  		onclick="confirmCarDelete({{ $car }});"
						  	><i class="fa fa-trash"></i></button>
						  	<form id="delete-car-form" method="POST" style="display: none;">
				                @method('DELETE')
				                @csrf
				            </form>

						</div>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@endsection

@push('scripts')
	<script src="{{ asset('js/car-index.js') }}"></script>
@endpush