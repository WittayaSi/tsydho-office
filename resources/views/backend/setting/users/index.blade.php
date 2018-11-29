@extends('layouts.master')

@section('title', 'ADMINISTRATOR-USERS')

@section('content')
	
<style type="text/css">
	.circle {
		height: 20px;
		width: 30px;
		border-radius: 50%;
	}
</style>
	
	<h2 class="mb-5">Setting USERS</h2>

	@include('backend.setting.users._modal_form')

	<table class="table table-bordered table-hover table-sm">
		<thead>
			<th class="text-center">ชื่อ-สกุล</th>
			<th class="text-center">E-Mail</th>
			<th class="text-center">Color</th>
			<th class="text-center">Status</th>
			<th class="text-center">Actions</th>
		</thead>
		<tbody style="font-size: 0.9rem;">
			@foreach($users as $user)
				<tr>
					<td class="text-center">{{ $user->name }}</td>
					<td class="text-center">{{ $user->email }}</td>
					<td><div class="circle" style="background-color: {{$user->color_code}}; margin: auto;"></div></td>
					<td class="text-center"><span class="badge badge-{{ 
						$user->user_role == 'sadmin' ? 'warning' : 
						$user->user_role == 'admin' ? 'success' : 'info'
					}}">{{ $user->user_role }}</span></td>
					<td style="text-align: center; white-space: nowrap;">
						<div class="btn-group btn-group-sm" role="group" aria-label="action group">
						  	<button type="button" class="btn btn-success" title="ดูข้อมูล"><i class="fa fa-search"></i></button>
						  	<a href="#" type="button" class="btn btn-warning" 
						  		title="แก้ไขข้อมูล" 
						  		{{-- data-toggle="modal" 
						  		data-target="#editUser" --}}
						  		onclick="onClickEditUser({{ $user->id }})" 
						  	><i class="fa fa-edit"></i></a>

						  	<button type="button" class="btn btn-danger" title="ลบข้อมูล" 
						  		onclick="confirmUserDelete({{ $user }});"
						  	><i class="fa fa-trash"></i></button>
						  	<form id="delete-user-form" method="POST" style="display: none;">
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
	<script src="{{ asset('js/user-index.js') }}"></script>
@endpush