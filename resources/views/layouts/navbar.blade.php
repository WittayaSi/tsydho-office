<style>
	.dropdown-item{
		font-size: 0.9rem;
	}
	.navbar{
		font-size: 0.9rem;
	}
</style>
<nav class="navbar navbar-expand-lg navbar-light @if(!Request::is('/')) bg-light @endif fixed-top">

    <div class="container">
    	@guest 
	    		<a class="navbar-brand" href="/"></a>
	    		<div class="navbar-nav justify-content-end">
		    		<li class="nav-item">
		                <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
		            </li>
		            {{-- <li class="nav-item">
		                @if (Route::has('register'))
		                    <a class="nav-link" href="{{ route('register') }}"><i class="fa fa-user-plus"></i> ลงทะเบียน</a>
		                @endif
		            </li> --}}
	            </div>
         @else
	        <a class="navbar-brand" href="/">@if(!Request::is('/'))<i class="fa fa-home fa-lg"></i>@endif</a>
			<ul class="navbar-nav justify-content-end">
		        <li class="nav-item dropdown">
			        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			          	<i class="fa fa-user"></i> &nbsp <span style="color: black;">คุณ{{ auth()->user()->name }}</span>
			        </a>
			        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			        	@if(auth()->user()->isAdmin())
			          		<a class="dropdown-item" href="/backend"><i class="fa fa-cogs"></i> จัดการระบบ</a>
			          	@endif
			          	<a class="dropdown-item" href="#" style="color: {{ auth()->user()->color_code }};"><i class="fa fa-user"></i> ข้อมูลผู้ใช้งานระบบ</a>
			          	<div class="dropdown-divider"></div>
			          	<a class="dropdown-item" href="{{ route('logout') }}"
							onclick="event.preventDefault();
	                        document.getElementById('logout-form').submit();"
			          	>
			          		<i class="fas fa-sign-out-alt"></i> ออกจากระบบ
			          	</a>
			          	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                        @csrf
	                    </form>
			        </div>
			     </li>
			 </ul>
		@endguest
		 	{{-- <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#addTask">
	    		เพิ่มรายการ
	    	</button> --}}
  		

        
    </div>
</nav>
