<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;

class UnitController extends Controller
{
	public function unit()
    {
		return view('site.admin.siteStatePage');
    }
	public function unitSubmit(Request $request)
    {
		$newUnit = new \App\Unit();
		$newUnit->unit	= $request->unit;
		$newUnit->name 	= $request->name;
		
		$newUnit->save();
		
		return view('site.admin.siteStatePage');
    }
	
}
