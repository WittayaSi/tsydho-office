@extends('layouts.master')

@section('title', 'INdex')

@section('content')
<style>
  html, body {
      background-color: #fff;
      color: #636b6f;
      font-family: 'Nunito', sans-serif;
      font-weight: 200;
      height: 80vh;
      margin: 0;
      /*background-image: url('images/woodbg3.jpg');*/
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      background-repeat: no-repeat;
  }

  .full-height {
      height: 80vh;
  }

  .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
  }

  .position-ref {
      position: relative;
  }

  .top-right {
      position: absolute;
      right: 10px;
      top: 18px;
  }

  .content {
      text-align: center;
      width: 80%;
  }

  .title {
      font-size: 50px;
  }

  .links > a {
      color: #636b6f;
      padding: 0 25px;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .1rem;
      text-decoration: none;
      text-transform: uppercase;
  }

  .m-b-md {
      margin-bottom: 30px;
  }
</style>
  <div class="flex-center position-ref full-height">
            {{-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/') }}" style="text-decoration: none;">{{ auth()->user()->name }}</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" style="text-decoration: none;"><i class="fa fa-user-plus"></i> ลงทะเบียน</a>
                        @endif
                    @endauth
                </div>
            @endif --}}

            {{-- @auth
                <div class="top-right links">
                    <a href="{{ route('logout') }}" style="text-decoration: none;"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"
                    ><i class="fa fa-user"></i> คุณ{{ auth()->user()->name }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            @endauth --}}

            <div class="content">
                <div class="title m-b-md" style="color: #4E4B4B;">
                    โปรแกรม สำนักงาน
                </div>
                <div class="row">
                    <div class="col-md-5">
                         <a href="/frontend/tasks" style="text-decoration: none; color: #4E4B4B;">
                            <div class="jumbotron jumbotron-fluid" style="background: #90EE90 !important">
                                <div class="container">
                                    <h4>แผนปฏิบัติงาน</h4>
                                    <p class="display-1"><i class="fa fa-calendar-alt"></i></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-7">
                         <a href="/frontend/car-uses" style="text-decoration: none; color: #4E4B4B;">
                            <div class="jumbotron jumbotron-fluid" style="background: #FFA500 !important">
                                <div class="container">
                                    <h4>แผนการใช้รถยนต์ราชการ</h4>
                                    <p class="display-1"><i class="fas fa-car-alt"></i></p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
@endsection