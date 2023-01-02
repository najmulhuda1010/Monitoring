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
class MainController extends Controller
{
    public function ongoing(Request $request)
    {
    	$count =0;
    	$total=0;
        $var = Date('Y-m-d');
		$ongoing=  DB::table('mnwv2.monitorevents')->where('datestart','<=',$var)->where('dateend','>=',$var)->get();
		$count = DB::select(DB::raw("select  count(*) as ct from mnwv2.monitorevents where datestart <='$var' and dateend >='$var'"));
		if(!empty($count))
		{
			
			$total= $count[0]->ct;
		}
		//echo $total;
		return view('Reports.Ongoing', compact('ongoing','total'));
    }
    public function EventCreate(Request $request)
    {
    	$data =DB::table('branch')->where('program_id',1)->orderBy('branch_id','ASC')->get();
    	$datas = DB::table('mnwv2.user')->select('user_pin')->get();
    	return view('Reports.Event_Create_Page', compact('data','datas'));
    }
    public function ClosedEvents(Request $request)
    {
    	$var = Date('Y-m-d');
		$closed =  DB::table('mnwv2.monitorevents')->where('dateend','<',$var)->get();
		return view('Reports.Closed',compact('closed'));
    }
    public function UpcomingEvents(Request $request)
    {
    	$var = Date('Y-m-d');
		$upcoming =  DB::table('mnwv2.monitorevents')->where('datestart','>',$var)->get();
         return view('Reports.Upcoming', compact('upcoming'));
    }
    public function Store(Request $request)
    {
       $branchcode=Input::get('branchcode');
	   $datestart = Input::get('datestart');
	   $dateend=Input::get('dateend');
	   $monitor1_code = Input::get('monitor1');
	   $monitor2_code = Input::get('monitor2');
	   $curdate = date('Y-m-d');
	   $cycle = Input::get('cycle');
	    $exp = explode('-',$datestart);
		$year = $exp[0];
		$month = $exp[1];
		if($month >='01' and $month <='03')
		{
			$quarter = '1st';
		}
		else if($month >='04' and $month <='06')
		{
			$quarter = '2nd';
		}
		else if($month >='07' and $month <='09')
		{
			$quarter = '3rd';
		}
		else if($month >='10' and $month <='12')
		{
			$quarter = '4th';
		}
		
		$branch = DB::table('branch')->where('branch_id',$branchcode)->where('program_id',1)->get();
		if($branch ->isEmpty())
		{
			
		}
		else
		{
			$area_id = $branch[0]->area_id;
			$region_id = $branch[0]->region_id;
			$division_id = $branch[0]->division_id;
		}
		$exp = explode('-',$datestart);
		$year = $exp[0];
		$mnth = $exp[1];
		//echo $year."/".$mnth."-";
		if($mnth >='01' and $mnth <='03')
		{
			$quarter = '1st';
		}
		else if($mnth >='04' and $mnth <='06')
		{
			$quarter = '2nd';
		}
		else if($mnth >='07' and $mnth <='09')
		{
			$quarter = '3rd';
		}
		else if($mnth >='10' and $mnth <='12')
		{
			$quarter = '4th';
		}
		if($mnth <='03' || $mnth >=10)
		{
			$rc = 1;
		}
		else if($mnth >='04' and $mnth <='09')
		{
			$rc = 2;
		}
	 // $response =DB::table('mnwv2.monitorevents')->insert(['branchcode' =>$branchcode,'datestart'=>$datestart,'dateend'=>$dateend,'monitor1_code'=>$monitor1_code,'monitor2_code'=>$monitor2_code,'processing_date'=>$curdate,'event_cycle'=>$cycle]);	 //Monitorevent::create($data);
	  $response =DB::table('mnwv2.monitorevents')->insert(['branchcode' =>$branchcode,'datestart'=>$datestart,'dateend' =>$dateend,'monitor1_code' =>$monitor1_code,'monitor2_code'=>$monitor2_code,'processing_date'=>$curdate,'event_cycle'=>$cycle,'year'=>$year,'month'=>$month,'quarterly'=>$quarter,'area_id'=>$area_id,'rcycle'=>$rc,'region_id'=>$region_id,'division_id'=>$division_id]);	 //Monitorevent::create($data);
	  if($response)
	  {
		  return redirect()->back()->with('success','Success!! Monitor Event Created!!');;
	  }
    }
    public function excel_upload(Request $request)
    {
    	$data = $request->input('excel_file');
		$photo = $request->file('excel_file')->getClientOriginalName();
		$destination = base_path() . '/jsonfile/';
		$request->file('excel_file')->move($destination, $photo);
		$html = "<table style="text-align: center;font-size:13" border='1'>";
		$objPHPExcel = PHPExcel_IOFactory::load('../jsonfile/'.$photo);
		//echo $objPHPExcel;
		$objPHPExcel->setActiveSheetIndex(0);
		foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
		{
			$heighestRow = $worksheet->getHighestRow();
			//echo $heighestRow;
			for($row=1; $row<=$heighestRow; $row++)
			{
				$branchcode= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				$cnt =strlen($branchcode);
				if($cnt==3)
				{
					$branchcode = $branchcode;
				}
				if($branchcode =='')
				{
					$row++;
				}
				else
				{
					if($row=='1')
					{
						$row = 2;
					}
					else{
						$row =$row;
						//echo $row;
					}
					for($row=$row; $row<=$heighestRow; $row++)
					{
						
						//$eventid= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						$branchcode = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						$cnt =strlen($branchcode);
						if($cnt==3)
						{
							$branchcode = '0'.$branchcode;
						}
						if($branchcode =='')
						{
							continue;
						}
						$datestart =  $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						$dateend =$worksheet->getCellByColumnAndRow(2, $row)->getValue();
						//$UNIX_DATE = ($datestart - 25569) * 86400;
                        //$datestart=  gmdate("d-m-Y", $UNIX_DATE);
						$excel_date = $datestart; //here is that value 41621 or 41631
						$unix_date = ($excel_date - 25569) * 86400;
						$excel_date = 25569 + ($unix_date / 86400);
						$unix_date = intval(($excel_date - 25569) * 86400);
						$datst =  gmdate("Y-m-d", $unix_date);
						
						$exp = explode('-',$datst);
						$year = $exp[0];
						$month = $exp[1];
						if($month >='01' and $month <='03')
						{
							$quarter = '1st';
						}
						else if($month >='04' and $month <='06')
						{
							$quarter = '2nd';
						}
						else if($month >='07' and $month <='09')
						{
							$quarter = '3rd';
						}
						else if($month >='10' and $month <='12')
						{
							$quarter = '4th';
						}
						
						$branch = DB::table('branch')->where('branch_id',$branchcode)->where('program_id',1)->get();
						if($branch ->isEmpty())
						{
							
						}
						else
						{
							$area_id = $branch[0]->area_id;
							$region_id = $branch[0]->region_id;
							$division_id = $branch[0]->division_id;
						}
						$exp = explode('-',$datst);
						$year = $exp[0];
						$mnth = $exp[1];
						//echo $year."/".$mnth."-";
						if($mnth >='01' and $mnth <='03')
						{
							$quarter = '1st';
						}
						else if($mnth >='04' and $mnth <='06')
						{
							$quarter = '2nd';
						}
						else if($mnth >='07' and $mnth <='09')
						{
							$quarter = '3rd';
						}
						else if($mnth >='10' and $mnth <='12')
						{
							$quarter = '4th';
						}
						if($mnth <='03' || $mnth >=10)
						{
							$rc = 1;
						}
						else if($mnth >='04' and $mnth <='09')
						{
							$rc = 2;
						}
						
						$excel_date = $dateend; //here is that value 41621 or 41631
						$unix_date = ($excel_date - 25569) * 86400;
						$excel_date = 25569 + ($unix_date / 86400);
						$unix_date = intval(($excel_date - 25569) * 86400);
						$datee =  gmdate("Y-m-d", $unix_date);
				
						$monitor1_code =$worksheet->getCellByColumnAndRow(3, $row)->getValue();
						
						$monitor2_code =$worksheet->getCellByColumnAndRow(4, $row)->getValue();
						
						$cycle =$worksheet->getCellByColumnAndRow(5, $row)->getValue();
						//echo $cycle;
					
						$excel = DB::table('mnwv2.monitorevents')->insert(['branchcode' =>$branchcode,'datestart'=>$datst,'dateend' =>$datee,'monitor1_code' =>$monitor1_code,'monitor2_code'=>$monitor2_code,'processing_date'=>$datst,'event_cycle'=>$cycle,'year'=>$year,'month'=>$month,'quarterly'=>$quarter,'area_id'=>$area_id,'rcycle'=>$rc,'region_id'=>$region_id,'division_id'=>$division_id]);
						if($excel)
						{
							 //return redirect()->back()->with('success','Success!! Event Create Insert Success!!');
						}
						else
						{
							 //return redirect()->back()->with('failed','Failed!! Event Create Failed!!');;
						}
					}
				}			
				
			}
		}
		return redirect()->back()->with('success','Success!! Event Create Insert Success!!');;
    }
	public function UserList(Request $request)
	{
		$total=0;
		$userlsit=  DB::table('mnwv2.user')->get();
		$count = DB::select(DB::raw("select  count(*) as ct from mnwv2.user"));
		if(!empty($count))
		{
			
			$total= $count[0]->ct;
		}
		return view('Reports.UserList', compact('userlsit','total'));
	}
	public function UserView(Request $request)
	{
		return view('Reports.UserCreate');
	}
	public function Logout(Request $request)
	{
		$request->session()->forget('username');
		$request->session()->forget('token');
		return redirect('https://trendx.brac.net/');
	}
}
