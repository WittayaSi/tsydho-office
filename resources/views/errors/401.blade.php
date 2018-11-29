@extends('errors.errors-layout')

@section('code', 401)
@section('message')   
	{{ $exception->getMessage() }}
@endsection                                        
                    