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
class RegionController extends Controller
{
	public function RDashboard(Request $request)
	{
		$dataload =true;
		$cyear =date('Y');
		$cmonth =date('m');
		$count =0;
		$month =0;
		$eventyear ='';
		$eventquarter ='';
		$a_id =$request->session()->get('asid');
		$regiondata = DB::table('branch')->where('region_id',$a_id)->where('program_id',1)->get();
		$data = Input::get('event');

		if($data !='')
		{
			$exp = explode('-',$data);
			$eventyear = $exp[0];
			$eventquarter = $exp[1];
			$a_id = $exp[2];
			$regiondata = DB::table('branch')->where('region_id',$a_id)->where('program_id',1)->get();
		}
		return view('Region/RegionDashboard',compact('regiondata','a_id','eventyear','eventquarter','dataload'));
	}
	public function BranchWise(Request $request)
	{
		$areaid = Input::get('areaid');
		$exp = explode(',',$areaid);
		$sec = $exp[0];
		$a_id = $exp[1];
		$year = $exp[2];
		$quarter = $exp[3];
		$brancwisescore = DB::table('mnwv2.monitorevents')->where('area_id',$a_id)->where('year',$year)->where('quarterly',$quarter)->get();
		return view('Region/BranchwiseScore',compact('brancwisescore','sec','a_id'));
	}
	public function Region_Search(Request $request)
	{
		$a_id =$request->session()->get('asid');
		$regionsearch = DB::table('branch')->select('area_id')->where('region_id',$a_id)->where('program_id',1)->groupBy('area_id')->orderBy('area_id','ASC')->get();
		return view('Region/Region_Search',compact('regionsearch','a_id'));
	}
	public function Region_CurrentDashboard(Request $request)
	{
		$dataload =true;
		$cyear =date('Y');
		$cmonth =date('m');
		$count =0;
		$month =0;
		$eventyear ='';
		$eventquarter ='';
		$a_id =$request->session()->get('asid');
		$regiondata = DB::table('branch')->where('region_id',$a_id)->where('program_id',1)->get();
		$data = Input::get('event');

		if($data !='')
		{
			$exp = explode('-',$data);
			$eventyear = $exp[0];
			$eventquarter = $exp[1];
			$regiondata = DB::table('branch')->where('region_id',$a_id)->where('program_id',1)->get();
		}
		return view('Region/Region_CurrentDashboard',compact('regiondata','a_id','eventyear','eventquarter','dataload'));
	}
	public function Area_Wise(Request $request)
	{
		$data = Input::get('section');
		if($data !='')
		{
			$exp = explode(',',$data);
			$section = $exp[0];
			$year = $exp[1];
			$quarter = $exp[2];
			$month = $exp[3];
			$rid = $exp[4];
		}
		return view('Region/AreaWiseAcheivement',compact('section','year','quarter','month','rid'));
	}
	public function Branch(Request $request)
	{
	   $id =Input::get('id');
		$branch = DB::table('branch')->where('area_id',$id)->where('program_id',1)->get();
		echo json_encode($branch);
	}
}
