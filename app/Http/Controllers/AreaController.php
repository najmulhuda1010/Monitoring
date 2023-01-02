<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use View;
use Illuminate\Support\Facades\Input;
use PHPExcel; 
use PHPExcel_IOFactory;
use Maatwebsite\Excel\Facades\Excel;
set_time_limit(120);
use Log;
class AreaController extends Controller
{
	public function Area_Dashboard(Request $request)
	{
		$dataload =true;
		$cyear =date('Y');
		$cmonth =date('m');
		$count =0;
		$month =0;
		$eventyear ='';
		$eventquarter ='';
		$a_id =$request->session()->get('asid');
		$areadata = DB::table('branch')->where('area_id',$a_id)->where('program_id',1)->get();
		$data = Input::get('event');
		if($data !='')
		{
			$exp = explode('-',$data);
			$eventyear = $exp[0];
			$eventquarter = $exp[1];
			$a_id = $exp[2];
			$areadata = DB::table('branch')->where('area_id',$a_id)->where('program_id',1)->get();
		}
		//die();
		return view('Area/AreaDashboard',compact('areadata','a_id','eventyear','eventquarter','dataload'));
	}
	public function Current_Dashboard(Request $request)
	{
		$dataload =true;
		$cyear =date('Y');
		$cmonth =date('m');
		$count =0;
		$month =0;
		$eventyear ='';
		$eventquarter ='';
		$a_id =$request->session()->get('asid');
		//echo $a_id;
		$areadata = DB::table('branch')->where('area_id',$a_id)->where('program_id',1)->get();
		$data = Input::get('event');
		if($data !='')
		{
			$exp = explode('-',$data);
			$eventyear = $exp[0];
			$eventquarter = $exp[1];
		}
		//die();
		//echo $a_id;
		return view('Area/Current_Dashboard',compact('areadata','a_id','eventyear','eventquarter','dataload'));
	}
	public function sectionwisedata(Request $request)
	{
		$a_id =$request->session()->get('asid');
		$section =Input::get('section');
		$exp = explode(',',$section);
		$sect = $exp[0];
		$evyear = $exp[1];
		$quat = $exp[2];
		$mnth = $exp[3];
		//echo $a_id;
		if($a_id ==0)
		{
			$a_id = $exp[4];
		}
		return view('Area/Section',compact('a_id','sect','evyear','quat','mnth'));
	}
	public function ADashboard(Request $request)
	{
		$dataload =true;
		$cyear =date('Y');
		$cmonth =date('m');
		$count =0;
		$month =0;
		$eventyear ='';
		$eventquarter ='';
		$a_id =$request->session()->get('asid');
		$areadata = DB::table('branch')->where('area_id',$a_id)->where('program_id',1)->get();
		$data = Input::get('event');

		if($data !='')
		{
			$exp = explode('-',$data);
			$eventyear = $exp[0];
			$eventquarter = $exp[1];
			$a_id = $exp[2];
			$areadata = DB::table('branch')->where('area_id',$a_id)->where('program_id',1)->get();
		}
		//die();
		return view('Area/ADashboard',compact('areadata','a_id','eventyear','eventquarter','dataload'));
	}
	public function SectionDetails(Request $request)
	{
		$details = Input::get('section');
		$exp = explode(",", $details);
		$section = $exp[0];
		$eventid = $exp[1];
		return view('Area/SectionDetails',compact('section','eventid'));
	}
	public function Area_Search(Request $request)
	{
		$a_id =$request->session()->get('asid');
		$branchsearch = DB::table('branch')->where('area_id',$a_id)->where('program_id',1)->get();
		return view('Area/Area_Search',compact('branchsearch','a_id'));
	}
	public function DataAreaProcess(Request $request)
	{
		return view('DataProcessing/AreaDataProcessing');
	}
}