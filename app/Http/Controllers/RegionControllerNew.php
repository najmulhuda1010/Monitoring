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
class RegionControllerNew extends Controller
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
		if(isset($_GET['regid']))
		{
           $a_id = $_GET['regid'];
		}
		else
		{
			$a_id =$request->session()->get('asid');
		}
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
		$brname =array();

		$areadata = DB::select(DB::raw("select * from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and area_id='$a_id'"));
		// var_dump($areadata);
		$d = count($areadata);
		$c = round($d/2);
		
		// $sec = $sect;
		
		foreach($areadata as $row)
		{
			$sp =0;
			$qsp=0;
			$brcode = $row->branchcode;
			//echo $brcode."/";
			$cnt = strlen($brcode);
			if($cnt ==3)
			{
				$brcode = '0'.$brcode;
			}
			$mnth = $row->month;
			//echo $mnth;
			$year = $row->year;
			$quar= $row->quarterly;
			$event_id = $row->id;
			$eventidary[] = $row->id;
			//echo $event_id."/";
			$data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$event_id' and section='$sec'"));
			
			if(!empty($data))
			{
			$sp =$data[0]->sp;
			$qsp =$data[0]->qsp;
			}
			$score =0;
			if($sp !=0)
			{
			$score =round((($sp*100)/$qsp),2);
			$scoreary[] =round((($sp*100)/$qsp),2);
			}
			//echo $event_id."-".$sp."/".$score."*";
			//die();
			$name ='';
			$arean='';
			$branchname = DB::select( DB::raw("select * from branch where branch_id='$brcode'"));
			if(!empty($branchname))
			{
			$brname[] = $branchname[0]->branch_name;
			}
		
		}
		$json['serial']=$exp[0];
		$json['year']=$exp[2];
		$json['quarter']=$exp[3];
		$json['eventid']=$eventidary;
		$json['branchname']=$brname;
		$json['score']=$scoreary;

		$myJSON = json_encode($json);
		
		echo $myJSON;

		// $brancwisescore = DB::table('mnwv2.monitorevents')->where('area_id',$a_id)->where('year',$year)->where('quarterly',$quarter)->get();
		// return view('Region/BranchwiseScore',compact('brancwisescore','sec','a_id'));
	}
	public function monthlyBranchWise(Request $request)
	{
		$areaid = Input::get('areaid');
		$exp = explode(',',$areaid);
		$sec = $exp[0];
		$a_id = $exp[1];
		$year = $exp[2];
		$quarter = $exp[3];
		$month = $exp[4];
		if(strlen($month)==1){
			$month='0'.$exp[4];
		}
		$brname =array();
		$eventidary =array();
		$scoreary =array();

		$areadata = DB::select(DB::raw("select * from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and area_id='$a_id' and month='$month'"));
		// dd($month);
		// var_dump($areadata);
		$d = count($areadata);
		$c = round($d/2);
		
		// $sec = $sect;
		
		foreach($areadata as $row)
		{
			$sp =0;
			$qsp=0;
			$brcode = $row->branchcode;
			//echo $brcode."/";
			$cnt = strlen($brcode);
			if($cnt ==3)
			{
				$brcode = '0'.$brcode;
			}
			$mnth = $row->month;
			//echo $mnth;
			$year = $row->year;
			$quar= $row->quarterly;
			$event_id = $row->id;
			$eventidary[] = $row->id;
			// dd($eventidary);
			//echo $event_id."/";
			$data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$event_id' and section='$sec'"));
			
			if(!empty($data))
			{
			$sp =$data[0]->sp;
			$qsp =$data[0]->qsp;
			}
			$score =0;
			if($sp !=0)
			{
			$score =round((($sp*100)/$qsp),2);
			$scoreary[] =round((($sp*100)/$qsp),2);
			}
			//echo $event_id."-".$sp."/".$score."*";
			//die();
			$name ='';
			$arean='';
			$branchname = DB::select( DB::raw("select * from branch where branch_id='$brcode'"));
			if(!empty($branchname))
			{
			$brname[] = $branchname[0]->branch_name;
			}
		
		}
		$json['serial']=$exp[0];
		$json['year']=$exp[2];
		$json['quarter']=$exp[3];
		$json['eventid']=$eventidary;
		$json['branchname']=$brname;
		$json['score']=$scoreary;

		$myJSON = json_encode($json);
		
		echo $myJSON;

		// $brancwisescore = DB::table('mnwv2.monitorevents')->where('area_id',$a_id)->where('year',$year)->where('quarterly',$quarter)->get();
		// return view('Region/BranchwiseScore',compact('brancwisescore','sec','a_id'));
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
	public function RegionAllPreviousView(Request $request)
	{
		$region_id =$request->session()->get('asid');

		$allyear = DB::table('mnwv2.monitorevents')->select('year')->where('region_id',$region_id)->groupBy('year')->get();
		return view('Region/RegionAllPreviousView',compact('allyear'));
	}
	public function RegionPreviousData(Request $request)
	{
		$year='';
		$quarter ='';
		$yr ='';
		$q='';
		$asid =$request->session()->get('asid');
		$alldata='';
		$allgroup='';
		$year = Input::get('year');

		$quarter = Input::get('quarter');

		if($year !='' and $quarter=='')
		{
			$yr = $year;
			$allgroup = DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('year',$year)->where('region_id',$asid)->groupBy('year','quarterly')->get();
		}
		else if($year !='' and $quarter !='')
		{
			$exp = explode("-", $quarter);
			$yr=$exp[0];
			$q = $exp[1];
			$alldata = DB::table('mnwv2.monitorevents')->where('year',$year)->where('region_id',$asid)->where('quarterly',$q)->get();
			// dd($alldata);
		}
		return view('Region/RegionAllPreviousData',compact('alldata','asid','yr','q','allgroup'));
	}
}
?>