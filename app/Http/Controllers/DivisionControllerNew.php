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
class DivisionControllerNew extends Controller
{
	public function DDashboard(Request $request)
	{
		$dataload =true;
		$cyear =date('Y');
		$cmonth =date('m');
		$count =0;
		$month =0;
		$eventyear ='';
		$eventquarter ='';
		if(isset($_GET['divid']))
		{
           $a_id =$_GET['divid'];
		}
		else
		{
			$a_id =$request->session()->get('asid');
		}
		$divisiondata = DB::table('branch')->where('division_id',$a_id)->where('program_id',1)->get();
		$data = Input::get('event');

		if($data !='')
		{
			$exp = explode('-',$data);
			$eventyear = $exp[0];
			$eventquarter = $exp[1];
			$a_id = $exp[2];
			$divisiondata = DB::table('branch')->where('division_id',$a_id)->where('program_id',1)->get();
		}
		return view('Division/DivisionDashboard',compact('divisiondata','a_id','eventyear','eventquarter','dataload'));
	}
	public function RegionWise(Request $request)
	{
		$section = '';
		$year ='';
		$quarter ='';
		$division ='';
		$data = Input::get('region');
		if($data !='')
		{
			$exp =  explode(",", $data);
			$section = $exp[0];
			$year = $exp[1];
			$quarter = $exp[2];
			$division = $exp[3];

		}
		return view('Division/RegionWise',compact('division','quarter','year','section'));
	}
	public function MonthWiseRegion(Request $request)
	{
		$data = Input::get('month');
		if($data !='')
		{
			$exp =  explode(",", $data);
			$section = $exp[0];
			$month = $exp[1];
			$year = $exp[2];
			$quarter = $exp[3];
			$division = $exp[4];

		}
		return view('Division/monthWiseRegion',compact('division','quarter','year','month','section'));
	}
	public function BranchWise(Request $request)
	{
		$areaid = Input::get('areaid');
		$exp = explode(',',$areaid);
		$sec = $exp[0];
		$a_id = $exp[1];
		$year = $exp[2];
		$quarter = $exp[3];
		$month = $exp[4];
		$brancwisescore = DB::table('mnwv2.monitorevents')->where('area_id',$a_id)->where('year',$year)->where('quarterly',$quarter)->where('month',$month)->get();
		return view('Division/BranchwiseScore',compact('brancwisescore','sec','a_id'));
	}
	public function Division_Current_Dashboard(Request $request)
	{
		$dataload =true;
		$cyear =date('Y');
		$cmonth =date('m');
		$count =0;
		$month =0;
		$eventyear ='';
		$eventquarter ='';
		$a_id =$request->session()->get('asid');
		$divisiondata = DB::table('branch')->where('division_id',$a_id)->where('program_id',1)->get();
		$data = Input::get('event');

		if($data !='')
		{
			$exp = explode('-',$data);
			$eventyear = $exp[0];
			$eventquarter = $exp[1];
			$a_id = $exp[2];
			$divisiondata = DB::table('branch')->where('division_id',$a_id)->where('program_id',1)->get();
		}
		return view('Division/DivisionCurrentDashboard',compact('divisiondata','a_id','eventyear','eventquarter','dataload'));
	}
	public function RegionWiseAcheivement(Request $request)
	{
		$data = Input::get('section');
		if($data !='')
		{
			$exp = explode(',',$data);
			$section = $exp[0];
			$year = $exp[1];
			$quarter = $exp[2];
			$month = $exp[3];
			$did = $exp[4];
		}
		return view('Division/RegionWiseAcheivement',compact('section','year','quarter','month','did'));
	}
	public function Division_Search(Request $request)
	{
		$a_id =$request->session()->get('asid');
		$divisionsearch = DB::table('branch')->select('region_id')->where('division_id',$a_id)->where('program_id',1)->groupBy('region_id')->orderBy('region_id','ASC')->get();
		return view('Division/Division_Search',compact('divisionsearch','a_id'));
	}
	public function Region(Request $request)
	{
	   $id =Input::get('id');
		$region = DB::table('branch')->where('region_id',$id)->where('program_id',1)->get();
		echo json_encode($region);
	}
	public function DivisionAllPreviousView(Request $request)
	{
		$division_id =$request->session()->get('asid');

		$allyear = DB::table('mnwv2.monitorevents')->select('year')->where('division_id',$division_id)->groupBy('year')->get();
		return view('Division/DivisionAllPreviousView',compact('allyear'));
	}
	public function DivisionPreviousData(Request $request)
	{
		$year='';
		$quarter ='';
		$yr ='';
		$q='';
		$alldata='';
		$allgroup='';
		$asid =$request->session()->get('asid');

		$year = Input::get('year');

		$quarter = Input::get('quarter');

		if($year !='--select--' and $quarter=='')
		{
			$yr = $year;
			$allgroup = DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('year',$year)->where('division_id',$asid)->where('areacompletestatus',1)->groupBy('year','quarterly')->get();
			//dd($allgroup);
		}
		else if($year !='--select--' and $quarter !='')
		{
			$exp = explode("-", $quarter);
			$yr=$exp[0];
			$q = $exp[1];
			$alldata = DB::table('mnwv2.monitorevents')->where('year',$year)->where('division_id',$asid)->where('quarterly',$q)->where('areacompletestatus',1)->get();
			//dd($alldata);
		}
		return view('Division/DivisionAllPreviousData',compact('alldata','asid','yr','q','allgroup'));
	}
	
}
?>