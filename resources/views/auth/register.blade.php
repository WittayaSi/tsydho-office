@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><h4>{{ __('ลงทะเบียนผู้ใช้งานระบบ') }}</h4></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ชื่อ - สกุล</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="ชื่อ - นามสกุล">

                                {{-- @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif --}}
                                <div class="invalid-tooltip small-tooltip">
                                    ต้องไม่เป็นค่าว่าง
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="example@example.com">

                                <div class="invalid-tooltip small-tooltip">
                                    ต้องไม่เป็นค่าว่าง
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">รหัสผ่าน</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="รหัสผ่าน">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                                {{ __('ยืนยันรหัสผ่าน') }}
                            </label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                                placeholder="ยืนยันรหัสผ่าน">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="color_code" class="col-md-4 col-form-label text-md-right">สีประจำตัว</label>
                            <div class="col-md-6">
                                <div class="input-group" id="color_code">
                                    <input type="text" class="form-control" 
                                        name="color_code"
                                        value="{{ old('color_code') ? old('color_code') : '#'.dechex(rand(0,10000000)) }}"
                                    >
                                    <span class="input-group-append">
                                        <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-3 offset-md-4">
                                <button type="submit" class="btn btn-success btn-block">
                                    {{ __('ลงทะเบียน') }}
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="reset" class="btn btn-warning btn-block">
                                    {{ __('ล้างข้อมูล') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

$(function () {
    $('#color_code').colorpicker({
        format: 'auto'
    });
});

(
    function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    }
)();
</script>

@endpush
