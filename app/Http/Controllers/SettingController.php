<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth') && $this->middleware('auth.admin');
	}

    public function index()
    {
    	return view('backend.index');
    }
}
