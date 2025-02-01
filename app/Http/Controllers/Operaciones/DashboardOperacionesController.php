<?php

namespace sis5cs\Http\Controllers\Operaciones;

use Illuminate\Http\Request;
use sis5cs\Http\Controllers\Controller;

class DashboardOperacionesController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}
	public function index(Request $request)
	{		
	  return view('operaciones.dashboard.index');
	} 
}
