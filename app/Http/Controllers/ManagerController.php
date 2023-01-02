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
class ManagerController extends Controller
{
	public function ManagerDashboard(Request $request)
	{
		$dataload =true;
		$br ='';
		$brnch ='';
		$area ='';
		$div='';
		$reg='';
		$rollid='';
		$evnt ='';
		$userpin='';
		$div = Input::get('division');
		$reg = Input::get('region');
		$area = Input::get('area');
		$brnch = Input::get('branch');
		$evnt = Input::get('eventid');
		// dd($evnt);
		$rollid =$request->session()->get('roll');
		$userpin =$request->session()->get('user_pin');
		if($div !='' and $reg !='' and $area !='' and $brnch !='' )
		{
			$cnt = strlen($brnch);
			if($cnt =='3')
			{
				$brnch ='0'.$brnch;
			}
			$br = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnch' order by id DESC limit 2"));
		}
		else if($div !='' and $reg !='' and $area !='')
		{
           
           ?>
			 <script type="text/javascript">
			 	window.location.href="ADashboard?areaid=<?php echo $area; ?>";
			 </script>>
			<?php
		}
		else if ($div !='' and $reg !='') 
		{
			
			?>
			 <script type="text/javascript">
			 	window.location.href="RDashboard?regid=<?php echo $reg; ?>";
			 </script>>
			<?php
		}
		else if($div !='')
		{
			?>
			 <script type="text/javascript">
			 	window.location.href="DDashboard?divid=<?php echo $div; ?>";
			 </script>>
			<?php
		}
		else
		{
			$division = DB::select( DB::raw("select  division_name,division_id from branch  where program_id='1' group by division_name,division_id order by division_id"));
		}
		$division = DB::select( DB::raw("select  division_name,division_id from branch  where program_id='1' group by division_name,division_id order by division_id"));
		if($rollid =='17')
		{
         $division = DB::select( DB::raw("select division_name,division_id from branch where branch_id in (select cast(branch_code as INT) from mnwv2.cluster where c_associate_id='$userpin') and program_id=1 group by division_id,division_name order by division_id ASC"));
		}
		else if($rollid =='18')
		{
         $division = DB::select( DB::raw("select division_name,division_id from branch where branch_id in (select cast(branch_code as INT) from mnwv2.cluster where z_associate_id='$userpin') and program_id=1 group by division_id,division_name order by division_id ASC"));
		}
		return view('Manager/ManagerDashboard',compact('br','division','dataload','brnch','div','reg','area','evnt','rollid','userpin'));
	}
	public function Region_Data(Request $request)
	{
		$div_id = Input::get('id');
		$regiondata = DB::select( DB::raw("select  region_name,region_id from branch  where division_id='$div_id' and program_id='1' group by region_name,region_id order by region_id"));
		echo json_encode($regiondata);
	}
	public function Area_Data(Request $request)
	{
		$region_id = Input::get('id');
		$areadata = DB::select( DB::raw("select  area_name,area_id from branch  where region_id='$region_id' and program_id='1' group by area_name,area_id order by area_id"));
		echo json_encode($areadata);
	}
	public function Branch_Data(Request $request)
	{
		$area_id = Input::get('id');
		$branchdata = DB::select( DB::raw("select branch_name,branch_id from branch  where area_id='$area_id' and program_id='1' group by branch_name,branch_id order by branch_id"));
		echo json_encode($branchdata);
	}
	public function SectionDetails(Request $request)
	{
		$data = Input::get('data');
		$exp = explode(",", $data);
		$sec = $exp[0];
		$subsec = $exp[1];
		$event = $exp[2];
		if($sec==1)
		{
			$survey_data = DB::select( DB::raw("select * from mnwv2.survey_data where event_id='$event' and sec_no='$sec' and question='$subsec'"));
		}
		else{
			$survey_data = DB::select( DB::raw("select * from mnwv2.survey_data where event_id='$event' and sec_no='$sec' and sub_sec_id='$subsec'"));
		}
		
		//var_dump($survey_data);
		return view('Manager/SectionDetails',compact('survey_data','sec','subsec','event'));
	}
	public function Remarks(Request $request)
	{
		$area = Input::get('area');
		$branch = Input::get('branch');
		$branch1 = strlen($branch);
		if($branch1=='3')
		{
			$branch ='0'.$branch;
		}
		$eventid= DB::select( DB::raw("select * from mnwv2.monitorevents where area_id='$area' and branchcode='$branch' order by id DESC"));
		if(!empty($eventid))
		{
			$event_id = $eventid[0]->id;
			$datestart = $eventid[0]->datestart;
			$dateend = $eventid[0]->dateend;
		}
		else
		{
			$event_id =0;
			$datestart='';
			$dateend='';
		}
		$remarks = DB::select( DB::raw("select event_id,sec_no,question,sub_id from mnwv2.survey_data where event_id='$event_id' and remarks !='' group by event_id,sec_no,question,sub_id order by sec_no ASC"));
		return view('Manager/AllRemarks',compact('remarks','area','branch','datestart','dateend'));
		
	}

}