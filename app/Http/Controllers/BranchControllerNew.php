<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use View;
use Redirect;
use Illuminate\Support\Facades\Input;
use PHPExcel; 
use PHPExcel_IOFactory;
use Maatwebsite\Excel\Facades\Excel;
set_time_limit(60);
use Log;
class BranchControllerNew extends Controller
{
	public function Branch_DashBoard(Request $request)
	{
		$br_monevents ='';
		$calculation =0;
        $lastevid =0;
		$eventid =0;
		$ev ='';
		$eventid ="";
		$eve ='';
		$bcode='';
		$dataload =false;
		$rollid =$request->session()->get('roll');
		$userpin =$request->session()->get('user_pin');
		$bcode = Input::get('branch');
		$areaid = Input::get('areaid');
		$regionid = Input::get('regionid');
		if($areaid!='' and $bcode==''){
			Session::flash('message', "Please Select Branch");
			return Redirect::back();
		}elseif($regionid !='' and $areaid =='' and $bcode==''){
			Session::flash('message', "Please Select Branch");
			return Redirect::back();
		}
		// dd($bcode);

		if($bcode !='')
		{
			$title='Branch Wise Report';
            $branchcode =$bcode;
		}
		else
		{
			$title='Branch Dashboard';
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

		$currentDate =date('Y-m-d');
		$brnch2 = DB::table('mnwv2.monitorevents')->where('branchcode',$brcode)->orderBy('id', 'desc')->limit(2)->get();
		if(!$brnch2->isEmpty())
		{
			$limit =0;
			$offset = 0;
			foreach($brnch2 as $row)
			{
				$datestart = $row->datestart;
				$dateend = $row->dateend;
				//echo $datestart."<=".$currentDate."-".$dateend.">=".$currentDate;
				//if($currentDate >='$datestart' and $dateend >='$currentDate')
				if($datestart <=$currentDate and $dateend >=$currentDate)
				{
					$offset ++;
				}
				else
				{
					
					$limit ++;
					
					//$br_monevents = DB::table('mnwv2.monitorevents')->where('branchcode',$brcode)->orderBy('id', 'desc')->limit(2)->get();
					// $br_monevents = DB::table('mnwv2.monitorevents')->where('branchcode',$brcode)->where('areacompletestatus',1)->orderBy('id', 'desc')->offset($offset)->limit(2)->get();
					if($rollid==1){
						$br_monevents = DB::table('mnwv2.monitorevents')->where('branchcode',$brcode)->orderBy('id', 'desc')->offset($offset)->limit(2)->get();

					}else{
						$br_monevents = DB::table('mnwv2.monitorevents')->where('branchcode',$brcode)->where('areacompletestatus',1)->orderBy('id', 'desc')->offset($offset)->limit(2)->get();

					}
					// dd($br_monevents);
					
					if($eventid =="")
					{
						//$br_maxevent = DB::select( DB::raw("select max(id) as evntid,branchcode from mnwv2.monitorevents where branchcode='$brcode' group by branchcode"));
						$br_maxevent = DB::table('mnwv2.monitorevents')->where('branchcode',$brcode)->where('areacompletestatus',1)->orderBy('id', 'desc')->offset($offset)->limit(1)->get();
						// dd($br_maxevent);
						if($rollid==1){
							$br_maxevent = DB::table('mnwv2.monitorevents')->where('branchcode',$brcode)->orderBy('id', 'desc')->offset($offset)->limit(1)->get();
	
						}else{
							$br_maxevent = DB::table('mnwv2.monitorevents')->where('branchcode',$brcode)->where('areacompletestatus',1)->orderBy('id', 'desc')->offset($offset)->limit(1)->get();
	
						}

						if($br_maxevent->isEmpty())
						{
							$lastevid =0;
						}
						else
						{
							$lastevid = $br_maxevent[0]->id;
							$calculation =1;
							$dataload = "true";
							
						}

						
					}
					else
					{
					$ev = $eventid;
					}
					$offset ++;
					
				}
				

			}
		}
		$dataload =true;
		$div=$division_id;
		$reg=$region_id;
		$area=$area_id;
		$are=$area_id;
		$brnch=$brcode;
		$division = DB::select( DB::raw("select  division_name,division_id from branch  where program_id='1' group by division_name,division_id order by division_id"));
		$evnt='';
		$evnt = Input::get('eventid');
		$br = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brcode' order by id DESC limit 2"));
		// dd($bcode);

		if($bcode ==null){

			return view('Branch/BranchDashBoard',compact('branch_name','area_name','region_name','division_name','br_monevents','ev','brcode','lastevid','calculation','dataload','branch_id','area_id','region_id','division_id','title'));
		}else{
			return view('Manager/ManagerDashboard',compact('branch_name','area_name','region_name','division_name','br_monevents','ev','brcode','lastevid','calculation','dataload','brnch','area','reg','div','division','br','are','evnt','dataload','rollid','userpin'));

		}
	}

	public function BranchDataProcess(Request $request)
	{
		$branchcode = $request->session()->get('asid');
		return view('DataProcessing/BranchDataProcessing');
	}
	public function All_PreviousDataView(Request $request)
	{
		$branchcode =$request->session()->get('asid');
		$cnt = strlen($branchcode);
		if($cnt=='3')
		{
			$branchcode ="0".$branchcode;
		}

		$allyear = DB::table('mnwv2.monitorevents')->select('year')->where('branchcode',$branchcode)->groupBy('year')->get();
		$allperiod = DB::table('mnwv2.monitorevents')->select('datestart','dateend')->where('branchcode',$branchcode)->groupBy('datestart','dateend')->orderBy('datestart','desc')->get();
		return view('Branch/AllPreviousView',compact('allyear','allperiod'));
	}
	public function AllPrevious(Request $request)
	{
		$evid ='';
		$evcycle ='';
		$period ='';
		$year='';
		$datestart='';
		$dateend ='';
		$branchcode =$request->session()->get('asid');
		if(strlen($branchcode)=='3')
		{
			$branchcode ='0'.$branchcode;
		}
		//dd($branchcode);
		$year = $request->get('year');
		$period = $request->get('period');
		if($year !='--select--' and $period =='')
		{
			$alldata = DB::table('mnwv2.monitorevents')->where('branchcode',$branchcode)->where('year',$year)->get();

			$getlastid = DB::table('mnwv2.monitorevents')->where('branchcode',$branchcode)->where('year',$year)->orderBy('id','desc')->limit(1)->get();

			if(!$getlastid->isEmpty())
			{
				$evcycle = $getlastid[0]->event_cycle;
				$evid = $getlastid[0]->id;
				
			}
		}
		else if($year !='--select--' and $period !='--select--')
		{
			$exp = explode("to", $period);
			$datestart = $exp[0];
			$dateend = $exp[1];
			//dd($datestart."/".$dateend);
			$alldata = DB::table('mnwv2.monitorevents')->where('branchcode',$branchcode)->where('year',$year)->where('datestart','>=',$datestart)->where('dateend','<=',$dateend)->get();
			if(!$alldata->isEmpty())
			{
				$evcycle = $alldata[0]->event_cycle;
				$evid = $alldata[0]->id;
				//dd($evid);
			}
		}
		
		return view('Branch/AllPreviousData',compact('alldata','evid','evcycle'));
	}
	public function Period(Request $request)
	{
		$year ='';
		$year =Input::get('id');
		$branchcode =$request->session()->get('asid');
		if(strlen($branchcode)=='3')
		{
			$branchcode ='0'.$branchcode;
		}
		$data = DB::table('mnwv2.monitorevents')->where('branchcode',$branchcode)->where('year',$year)->get();
		echo json_encode($data);
	}
		
}
?>