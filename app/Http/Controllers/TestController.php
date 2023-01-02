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
class TestController extends Controller
{
	public function Branch_DashBoard(Request $request)
	{

        $lastevid =0;
		$eventid =0;
		$ev ='';
		$eventid ="";
		$eve ='';
		$bcode='';
		$dataload =false;
		$bcode = Input::get('brnch');
		if($bcode !='')
		{
            $branchcode =$bcode;
		}
		else
		{
			$branchcode =$request->session()->get('asid');
		}
		
		$cnt = strlen($branchcode);
		if($cnt=='3')
		{
			$brcode = '0'.$branchcode;
		}
		else
		{
			$brcode = $branchcode;
		}
		$eve = $request->get('evid');
		if($eve !='')
		{
			$data = explode(",",$eve);
			$eventid = $data[0];
			$dataload = $data[1];
			$brcode = $data[2];
		}
		
		$br_info = DB::table('branch')->where('branch_id',$brcode)->where('program_id',1)->get();
		if($br_info->isEmpty())
		{
			$branch_name ='';
			$area_name='';
			$region_name='';
			$division_name='';
			$branch_id ='';
			$area_id='';
			$region_id='';
			$division_id='';
		}
		else
		{
			$branch_name =$br_info[0]->branch_name;
			$area_name=$br_info[0]->area_name;
			$region_name=$br_info[0]->region_name;
			$division_name=$br_info[0]->division_name;
			$branch_id = $br_info[0]->branch_id;
			$area_id = $br_info[0]->area_id;
			$region_id=$br_info[0]->region_id;
			$division_id=$br_info[0]->division_id;
		}
		$br_monevents = DB::table('mnwv2.monitorevents')->where('branchcode',$brcode)->orderBy('id', 'desc')->limit(2)->get();
		
		if($eventid =="")
		{
			$br_maxevent = DB::select( DB::raw("select max(id) as evntid,branchcode from mnwv2.monitorevents where branchcode='$brcode' group by branchcode"));
			if(empty($br_maxevent))
			{
				$lastevid =0;
			}
			else
			{
				$lastevid = $br_maxevent[0]->evntid;
				$calculation =1;
				$dataload = "true";
				
			}
			
		}
		else
		{
		   $ev = $eventid;
		}
		return view('Branch/BranchDashBoard',compact('branch_name','area_name','region_name','division_name','br_monevents','ev','brcode','lastevid','calculation','dataload','branch_id','area_id','region_id','division_id'));
	}
}