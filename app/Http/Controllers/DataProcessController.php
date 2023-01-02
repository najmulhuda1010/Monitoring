<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use View;
use Illuminate\Support\Facades\Input;
use PHPExcel; 
use PHPExcel_IOFactory;
use Maatwebsite\Excel\Facades\Excel;
set_time_limit(60);
use Log;
class DataProcessController extends Controller
{
	public function BranchDataProcess(Request $request)
	{
		return view('DataProcessing.BranchDataProcessing');
	}
}