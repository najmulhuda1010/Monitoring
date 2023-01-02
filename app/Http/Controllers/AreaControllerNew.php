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
class AreaControllerNew extends Controller
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
		if(isset($_GET['areaid']))
		{
			$a_id =$_GET['areaid'];
		}
		else
		{
			$a_id =$request->session()->get('asid');
		}
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
		$brcode='';
		$brnchname='';
		$name =array();
		$tscore =array();
		$findbranch = DB::select(DB::raw("select * from mnwv2.monitorevents where id='$eventid'"));
		if(!empty($findbranch))
		{
			$brcode = $findbranch[0]->branchcode;
			$brname = DB::select(DB::raw("select * from branch where branch_id='$brcode'"));
			if(!empty($brname))
			{
			$brnchname = $brname[0]->branch_name;
			}
		}
		$sectioname = DB::select(DB::raw("select * from mnwv2.def_sections where sec_no='$section'"));
		if(!empty($sectioname))
		{
			$secname =  $sectioname[0]->sec_name;
		}
		else
		{
		$secname ='';
		}

        $p=0;
        $qp =0;
        $detailsdata = DB::select(DB::raw("select * from mnwv2.cal_section_point where event_id='$eventid' and section='$section' order by sub_id ASC"));
		//var_dump($detailsdata);
        foreach ($detailsdata as $row) 
        {
          $subid= $row->sub_id;
		  //echo $subid."/";
          $p = $row->point;
          $qp = $row->question_point;
          if($p !=0)
          {
            $tscore[] = round(($p/$qp*100),2);
          }
          else
          {
            $tscore[]=0;
          }
		  if($section=='1')
		  {
			  $questionname = DB::select(DB::raw("select * from mnwv2.def_questions where sec_no='$section' and qno='$subid'"));
		  }
		  else
		  {
			  $questionname = DB::select(DB::raw("select * from mnwv2.def_questions where sec_no='$section' and sub_sec_no='$subid' and qno='0'"));
		  }
          
		 // var_dump($questionname);
          if(!empty($questionname))
          {
            $name[] = $questionname[0]->qdesc;
		  }
		}  
		$data['branchname']=$brnchname;
		$data['serials']=$detailsdata;
		$data['questions']=$name;
		$data['scores']=$tscore;

		$myJSON = json_encode($data);
		
		echo $myJSON;
		// return view('Area/SectionDetails',compact('section','eventid'));
	}
	public function monthlySectionDetails(Request $request)
	{
		$details = Input::get('section');
		$exp = explode(",", $details);
		$section = $exp[0];
		$eventid = $exp[1];
		$month = $exp[2];
		if(strlen($month)==1){
			$month='0'.$exp[2];
		}
		$brcode='';
		$brnchname='';
		$name =array();
		$tscore =array();
		$findbranch = DB::select(DB::raw("select * from mnwv2.monitorevents where id='$eventid' and month='$month'"));
		if(!empty($findbranch))
		{
			$brcode = $findbranch[0]->branchcode;
			$brname = DB::select(DB::raw("select * from branch where branch_id='$brcode'"));
			if(!empty($brname))
			{
			$brnchname = $brname[0]->branch_name;
			}
		}
		$sectioname = DB::select(DB::raw("select * from mnwv2.def_sections where sec_no='$section'"));
		if(!empty($sectioname))
		{
			$secname =  $sectioname[0]->sec_name;
		}
		else
		{
		$secname ='';
		}

        $p=0;
        $qp =0;
        $detailsdata = DB::select(DB::raw("select * from mnwv2.cal_section_point where event_id='$eventid' and section='$section' order by sub_id ASC"));
		//var_dump($detailsdata);
        foreach ($detailsdata as $row) 
        {
          $subid= $row->sub_id;
		  //echo $subid."/";
          $p = $row->point;
          $qp = $row->question_point;
          if($p !=0)
          {
            $tscore[] = round(($p/$qp*100),2);
          }
          else
          {
            $tscore[]=0;
          }
		  if($section=='1')
		  {
			  $questionname = DB::select(DB::raw("select * from mnwv2.def_questions where sec_no='$section' and qno='$subid'"));
		  }
		  else
		  {
			  $questionname = DB::select(DB::raw("select * from mnwv2.def_questions where sec_no='$section' and sub_sec_no='$subid' and qno='0'"));
		  }
          
		 // var_dump($questionname);
          if(!empty($questionname))
          {
            $name[] = $questionname[0]->qdesc;
		  }
		}  
		$data['branchname']=$brnchname;
		$data['serials']=$detailsdata;
		$data['questions']=$name;
		$data['scores']=$tscore;

		$myJSON = json_encode($data);
		
		echo $myJSON;
		// return view('Area/SectionDetails',compact('section','eventid'));
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
	public function AreaAllPreviousView(Request $request)
	{
		$area_id =$request->session()->get('asid');
		$allyear = DB::table('mnwv2.monitorevents')->select('year')->where('area_id',$area_id)->groupBy('year')->get();
		return view('Area/AreaAllPreviousView',compact('allyear'));
	}
	public function quarter(Request $request)
	{
		$year = Input::get('id');
		$asid =$request->session()->get('asid');
		$roll =$request->session()->get('roll');
		if($roll=='2')
		{
			$dataset =  DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('year',$year)->where('area_id',$asid)->groupBy('year','quarterly')->get();
		}
		else if($roll=='3')
		{
			$dataset =  DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('year',$year)->where('region_id',$asid)->groupBy('year','quarterly')->get();
		}
		else if($roll=='4')
		{
			$dataset =  DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('year',$year)->where('division_id',$asid)->groupBy('year','quarterly')->get();
		}
		else if(($roll=='7' or $roll=='16'or $roll=='5' or $roll=='17' or $roll=='18'))
		{
			$dataset =  DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('year',$year)->groupBy('year','quarterly')->get();
		}
		else
		{
			echo "Not Found Roll";
		}
		echo json_encode($dataset);
	}
	public function PreviousData(Request $request)
	{
		$year='';
		$quarter ='';
		$yr ='';
		$q='';
		$area_id =$request->session()->get('asid');
		$year = Input::get('year');
		$quarter = Input::get('quarter');
		if($year !='--select--' and $quarter=='')
		{
			$alldata = DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('year',$year)->where('area_id',$area_id)->groupBy('year','quarterly')->get();

		}
		else if($year !='--select--' and $quarter !='')
		{
			$exp = explode("-", $quarter);
			$yr=$exp[0];
			$q = $exp[1];
			$alldata = DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('year',$year)->where('area_id',$area_id)->where('quarterly',$q)->groupBy('year','quarterly')->get();
		}
		return view('Area/AreaAllPreviousData',compact('alldata','area_id','yr','q'));
	}
}
?>