@extends('layouts.master')

@section('title', 'ADMINISTRATOR')

@section('content')
	<style type="text/css">
		.div-text-center {
            text-align: center;
        }
	</style>

	<div class="text-center mb-5">
		<h3>Admin PAGE</h3>
	</div>
	<div class="div-text-center">
		<div class="row">
			<div class="col-md-4">
	             <a href="/backend/setting/cars" style="text-decoration: none;">
	                <div class="jumbotron jumbotron-fluid" style="background: #FFA500">
	                    <div class="container">
	                        <h4>จัดการรถยนต์</h4>
	                        <p class="display-1"><i class="fas fa-car-alt"></i></p>
	                    </div>
	                </div>
	            </a>
	        </div>
	        <div class="col-md-4">
	             <a href="/backend/setting/users" style="text-decoration: none; color: #4E4B4B;">
	                <div class="jumbotron jumbotron-fluid" style="background: #90EE90 !important">
	                    <div class="container">
	                        <h4>จัดการ Users</h4>
	                        <p class="display-1"><i class="fa fa-users"></i></p>
	                    </div>
	                </div>
	            </a>
	        </div>

	        
	    </div>
    </div>
@endsection