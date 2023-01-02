<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use View;
use Illuminate\Support\Facades\Input;
use PHPExcel; 
use PHPExcel_IOFactory;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
set_time_limit(60);
use Log;
class MainControllerNew extends Controller
{
    public function ongoing()
    {
    	$count =0;
    	$total=0;
        $var = Date('Y-m-d');
		$ongoing=  DB::table('mnwv2.monitorevents')
		->where('datestart','<=',$var)
		->where('dateend','>=',$var)
		->paginate(5);

		$count = DB::select(DB::raw("select  count(*) as ct from mnwv2.monitorevents where datestart <='$var' and dateend >='$var'"));
		if(!empty($count))
		{
			
			$total= $count[0]->ct;
		}
		//echo $total;
		return view('Reports.Ongoing', compact('ongoing','total'));
    }
    public function EventCreate()
    {
    	$data =DB::table('branch')->where('program_id',1)->orderBy('branch_id','ASC')->get();
    	$datas =DB::table('mnwv2.user')->select('user_pin')->get();

    	return view('Reports.Event_Create_Page', compact('data','datas'));
    }
    public function ClosedEvents()
    {
    	$var = Date('Y-m-d');
		$ClosedEvent =  DB::table('mnwv2.monitorevents')->where('dateend','<',$var)->orderBy('id','DESC')->paginate(10);

		return view('Reports.Closed',compact('ClosedEvent'));
    }
    public function UpcomingEvents()
    {
    	$var = Date('Y-m-d');
		$upcoming =  DB::table('mnwv2.monitorevents')->where('datestart','>',$var)->paginate(10);

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
	  //$response =DB::table('mnwv2.monitorevents')->insert(['branchcode' =>$branchcode,'datestart'=>$datestart,'dateend'=>$dateend,'monitor1_code'=>$monitor1_code,'monitor2_code'=>$monitor2_code,'processing_date'=>$curdate,'event_cycle'=>$cycle]);	 //Monitorevent::create($data);
	   $checkIfExist=DB::table('mnwv2.monitorevents')->where('branchcode',$branchcode)->where('datestart',$datestart)->where('dateend',$dateend)->where('monitor1_code',$monitor1_code)->where('monitor2_code',$monitor2_code)->get();

		if($checkIfExist->isEmpty()){
			$response = DB::table('mnwv2.monitorevents')->insert(['branchcode' =>$branchcode,'datestart'=>$datestart,'dateend' =>$dateend,'monitor1_code' =>$monitor1_code,'monitor2_code'=>$monitor2_code,'processing_date'=>$curdate,'event_cycle'=>$cycle,'year'=>$year,'month'=>$month,'quarterly'=>$quarter,'area_id'=>$area_id,'rcycle'=>$rc,'region_id'=>$region_id,'division_id'=>$division_id]);

			return redirect()->back()->with('success','Success!! Monitor Event Created!!');
		}else{
			return redirect()->back()->with('success','Error!! Monitor Event Already Exist!!');
		}
    }
	public function UserCreateStore(Request $request)
	{
	   $name=Input::get('name');
	   $email = Input::get('email');
	   $phone=Input::get('phone');
	   $username = Input::get('username');
	   $password = Input::get('password');
	   $curdate = date('Y-m-d');
	   $userpin = Input::get('userpin');
	   $deviceid = Input::get('deviceid');
	  
	  $response =DB::table('mnwv2.user')->insert(['name' =>$name,'email'=>$email,'phone'=>$phone,'username'=>$username,'password'=>$password,'user_pin'=>$userpin,'device_id'=>$deviceid]);	 //Monitorevent::create($data);

	  if($response)
	  {
		  return redirect()->back()->with('success','Success!! Monitor User Created!!');
	  }
	}
	public function UserDelete($id)
	{
		$delete = DB::table('mnwv2.user')->where('id',$id)->delete();
		if($delete)
		{
			return redirect('/UserList')->with('success','Success!! User Deleted!!');
		}
	}
	public function UserEdit(Request $request)
	{
		$id = Input::get('id');
		$edit = DB::table('mnwv2.user')->where('id',$id)->get();
		return view('Reports.Event_Edit_Page', compact('edit'));
		
	}
	public function UserEditStore(Request $request)
	{
		   $name=Input::get('name');
		   $email = Input::get('email');
		   $phone=Input::get('phone');
		   $username = Input::get('username');
		   $password = Input::get('password');
		   $curdate = date('Y-m-d');
		   $userpin = Input::get('userpin');
		   $deviceid = Input::get('deviceid');
		   $id = Input::get('id');
		   $response =DB::table('mnwv2.user')->where('id',$id)->update(['name' =>$name,'email'=>$email,'phone'=>$phone,'username'=>$username,'password'=>$password,'user_pin'=>$userpin,'device_id'=>$deviceid]);	 //Monitorevent::create($data);

		   if($response)
		   {
			  return redirect('/UserList')->with('success','Success!! Monitor User Updated!!');;
		   }
	}

    public function excel_upload(Request $request)
    {
    	$data = $request->input('excel_file');
		$photo = $request->file('excel_file')->getClientOriginalName();
		$destination = base_path() . '/jsonfile/';
		$request->file('excel_file')->move($destination, $photo);
		$html = "<table style="."font-size:13"."border='1'>";
		$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load('../jsonfile/'.$photo);
		//echo $objPHPExcel;
		$objPHPExcel->setActiveSheetIndex(0);

		foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
		{
			$heighestRow = $worksheet->getHighestRow();
			// echo $heighestRow;
			// dd($heighestRow);

			for($row=2; $row<$heighestRow; $row++)
			{
				$branchcode= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
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
						$branchcode = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						$cnt =strlen($branchcode);
						if($cnt==3)
						{
							$branchcode = '0'.$branchcode;
						}
						if($branchcode =='')
						{
							continue;
						}
						$datestart =  $worksheet->getCellByColumnAndRow(2, $row)->getValue();
						$dateend =$worksheet->getCellByColumnAndRow(3, $row)->getValue();
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
				
						$monitor1_code =$worksheet->getCellByColumnAndRow(4, $row)->getValue();
						
						$monitor2_code =$worksheet->getCellByColumnAndRow(5, $row)->getValue();
						
						$cycle =$worksheet->getCellByColumnAndRow(6, $row)->getValue();
						//echo $cycle;
						
						$checkIfExist=DB::table('mnwv2.monitorevents')->where('branchcode',$branchcode)->where('datestart',$datst)->where('dateend',$datee)->where('monitor1_code',$monitor1_code)->where('monitor2_code',$monitor2_code)->get();

						if($checkIfExist->isEmpty()){

							$excel = DB::table('mnwv2.monitorevents')->insert(['branchcode' =>$branchcode,'datestart'=>$datst,'dateend' =>$datee,'monitor1_code' =>$monitor1_code,'monitor2_code'=>$monitor2_code,'processing_date'=>$datst,'event_cycle'=>$cycle,'year'=>$year,'month'=>$month,'quarterly'=>$quarter,'area_id'=>$area_id,'rcycle'=>$rc,'region_id'=>$region_id,'division_id'=>$division_id]);
							
						}
					}
				}			
				
			}
		}
		return redirect()->back()->with('success','Success!! Event Create Insert Success!!');
    }
	public function UserExcel(Request $request)
	{
		$data = $request->input('excel_file');
		$photo = $request->file('excel_file')->getClientOriginalName();
		$destination = base_path() . '/jsonfile/';
		$request->file('excel_file')->move($destination, $photo);
		$html = "<table style="."font-size:13"."border='1'>";
		$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load('../jsonfile/'.$photo);
		//echo $objPHPExcel;
		$objPHPExcel->setActiveSheetIndex(0);

		foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
		{
			$heighestRow = $worksheet->getHighestRow();
			//echo $heighestRow;
			for($row=1; $row<=$heighestRow; $row++)
			{
				$name= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				
				if($name =='')
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
						$name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						$email =  $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						$phone =$worksheet->getCellByColumnAndRow(2, $row)->getValue();
						$username =$worksheet->getCellByColumnAndRow(3, $row)->getValue();
						$password =$worksheet->getCellByColumnAndRow(4, $row)->getValue();
						$userpin =$worksheet->getCellByColumnAndRow(5, $row)->getValue();
						$deviceid =$worksheet->getCellByColumnAndRow(6, $row)->getValue();

						$excel = DB::table('mnwv2.user')->insert(['name' =>$name,'email'=>$email,'phone' =>$phone,'username' =>$username,'password'=>$password,'user_pin'=>$userpin,'device_id'=>$deviceid]);
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
		return redirect()->back()->with('success','Success!! Users Create Success!!');
	}
    public function UserList(Request $request)
	{
		$total=0;
		$userlsit=  DB::table('mnwv2.user')->paginate(10);
		$count = DB::select(DB::raw("select  count(*) as ct from mnwv2.user"));
		if(!empty($count))
		{
			
			$total= $count[0]->ct;
		}
		return view('Reports.UserList', compact('userlsit','total'));
	}
	public function User_search(Request $request)
	{
		$id = Input::get('id');
		if($id !='')
		{
			$sql = DB::select(DB::raw("select * from mnwv2.user where name LIKE '%$id%' or username LIKE '%$id%' or user_pin LIKE '%$id%' "));
		    echo json_encode($sql);
		}
		else
		{
			$sql1 = DB::table('mnwv2.user')->paginate(10);
		    echo json_encode($sql1);
		}
		
	}
    public function edit($id)
    {
    	$editOngoing = DB::table('mnwv2.monitorevents')
    	// ->join('mnw.cal_section_point','mnw.monitorevents.id','=','mnw.cal_section_point.event_id')
    	->find($id);
    	// $allbranchid = DB::table('branch')->get();
        // $alluserpin  = DB::table('mnw.user')->get();
        return view('Reports.editOngoing', compact('editOngoing'));    
    }
    
    public function storeUpdate(Request $request,$id)
    {
       // dd($request->all());
       $branchcode=Input::get('branchcode');
	   $datestart = Input::get('datestart');
	   $dateend=Input::get('dateend');
	   $monitor1_code = Input::get('monitor1_code');
	   $monitor2_code = Input::get('monitor2_code');

	  $response = DB::table('mnwv2.monitorevents')->where('id', '=', $id)->update(
	     [
	    'branchcode' =>$branchcode,'datestart'=>$datestart,'dateend'=>$dateend,'monitor1_code'=>
	      $monitor1_code,'monitor2_code'=>$monitor2_code
	    ]);
        
	  if($response)
	  {
	  	 // $id=$response->id;
	  	 $name = Input::get('name');
         // dd($name);
	  	 $value = DB::table('mnwv2.user')->where('id', '=', $id)->update(
		    [
		    'name' =>$name
		    ]);

	  }
    }
    
    function fetch(Request $request)
    {
     $value = $request->get('value');
 
     $data = DB::table('mnw.user')
       ->where('user_pin',$value)
       ->get();
      // dd($data);
    
     foreach($data as $row)
     {
      $output=$row->name;
      // dd($output);

     }
      
     echo $output;
    }
    
     function m2fetch(Request $request)
    {
     $value = $request->get('value');
     $datas = DB::table('mnw.user')
       ->where('user_pin',$value)
       // ->groupBy($dependent)
       ->get();
     // dd($datas);
      
      foreach($datas as $row)
     {
      $resault=$row->name;
      // dd($resault);
          
     }   
	  echo $resault;  
    }

     public function delete($id)
    {
        // return $id;
        $query = DB::table('mnwv2.monitorevents')->where('id', '=', $id)->delete();
    	// $deleteOngoing = DB::table('mnwv2.monitorevents')->find($id)->delete();
        //$deleteOngoing->delete();
        // alert($mz);

        return redirect()->back()->with('success','Success!! Data deleted successfully!!');

    }
	public function Logout(Request $request)
	{
		$request->session()->forget('username');
		$request->session()->forget('token');
		return redirect('https://trendx.brac.net/');
	}
	public function UserView(Request $request)
	{
		return view('Reports.UserCreate');
	}
	public function Survey_Excel(Request $request)
	{
		return view('Reports/SurveyExcel');
	}
	public function excel_surveydata_upload(Request $request)
    {
		
		// $path=$request->all();

		// $data= PHPExcel_IOFactory::load($path)->get();
		$surveydata=[];
		$data = $request->input('excel_file');
		$photo = $request->file('excel_file')->getClientOriginalName();
		$destination = base_path() . '/jsonfile/survey_data/';
		$request->file('excel_file')->move($destination, $photo);
		$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load('../jsonfile/survey_data/'.$photo);
		//echo $objPHPExcel;
		$objPHPExcel->setActiveSheetIndex(0);

		foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
		{
			$heighestRow = $worksheet->getHighestRow();

			for($row=0; $row<=$heighestRow-2; $row++)
			{
				$branchcode= $worksheet->getCellByColumnAndRow(1, $row+2)->getValue();
				$sec_no= $worksheet->getCellByColumnAndRow(2, $row+2)->getValue();
				$sub_sec_id= $worksheet->getCellByColumnAndRow(3, $row+2)->getValue();
				$question= $worksheet->getCellByColumnAndRow(4, $row+2)->getValue();
				$answer= $worksheet->getCellByColumnAndRow(5, $row+2)->getValue();
				$score= $worksheet->getCellByColumnAndRow(6, $row+2)->getValue();
				$orgno= $worksheet->getCellByColumnAndRow(7, $row+2)->getValue();
				$orgmemno= $worksheet->getCellByColumnAndRow(8, $row+2)->getValue();
				$monitorno= $worksheet->getCellByColumnAndRow(9, $row+2)->getValue();

				$verified=1;
				$submit=1;
				$orgmeno = str_pad($orgmemno,6,"0",STR_PAD_LEFT);
				if(strlen($branchcode)==3){
					$branchcode='0'.$branchcode;
				}
				// dd(strlen($branchcode));
				$eventdata=DB::select(DB::raw("select max(id) from mnwv2.monitorevents where branchcode='$branchcode'"));
				$eventid=$eventdata[0]->max;

				$surveydata=DB::select(DB::raw("select * from mnwv2.survey_data where event_id=$eventid and sec_no=$sec_no and sub_id=$sub_sec_id and orgno='$orgno' and orgmemno='$orgmeno' and question=$question and monitorno=$monitorno"));
				// dd($surveydata);

				if(empty($surveydata))
				{
					DB::table('mnwv2.survey_data')->insert(['event_id' =>$eventid,'sec_no'=>$sec_no,'question' =>$question,'answer' =>$answer,'score'=>$score,'orgno'=>$orgno,'orgmemno'=>$orgmeno,'sub_sec_id'=>$sub_sec_id,'monitorno'=>$monitorno,'verified'=>$verified,'sub_id'=>$sub_sec_id,'submitted_by'=>$submit]);
				}

			}

		}
		
		return redirect()->back()->with('success','Success!! Survey Data Insert Successfully!!');

	}

	public function excel_addressdata_upload(Request $request)
    {
		// $data= PHPExcel_IOFactory::load($path)->get();
		$surveydata=[];
		$data = $request->input('excel_file');
		$photo = $request->file('excel_file')->getClientOriginalName();
		$destination = base_path() . '/jsonfile/survey_data/';
		$request->file('excel_file')->move($destination, $photo);
		$objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load('../jsonfile/survey_data/'.$photo);
		//echo $objPHPExcel;
		$objPHPExcel->setActiveSheetIndex(0);

		foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
		{
			$heighestRow = $worksheet->getHighestRow();

			for($row=0; $row<=$heighestRow-2; $row++)
			{
				$division= $worksheet->getCellByColumnAndRow(2, $row+2)->getValue();
				if($division!=null){
					$division_ary = explode(' ',$division);
					$division_id_full=$division_ary[0]; 
					$division_id = substr($division_id_full, 1, -1);
					$division_name=$division_ary[1];  
				}

				$district= $worksheet->getCellByColumnAndRow(4, $row+2)->getValue();
				if($district!=null){
					$district_ary = explode(' ',$district);
					$district_id_full=$district_ary[0]; 
					$district_id = substr($district_id_full, 1, -1);
					$district_name=$district_ary[1]; 
				}

				$thana= $worksheet->getCellByColumnAndRow(6, $row+2)->getValue();
				if($thana!=null){
					$thana_ary = explode(' ',$thana);
					$thana_id_full=$thana_ary[0]; 
					$thana_id = substr($thana_id_full, 1, -1);
					$thana_name=$thana_ary[1];   
				}

				$office= $worksheet->getCellByColumnAndRow(8, $row+2)->getValue();
				if($office!=null){
					$office_ary = explode(' ',$office);
					$office_id_full=$office_ary[0]; 
					$office_id = substr($office_id_full, 1, -1);
					$office_name=$office_ary[1];  
				}


					DB::table('dcs.office_mapping')->insert(['division_id' =>$division_id,'division_name'=>$division_name,'district_id' =>$district_id,'district_name' =>$district_name,'thana_id'=>$thana_id,'thana_name'=>$thana_name,'office_id'=>$office_id,'office_name'=>$office_name]);

			}

		}
		
		return redirect()->back()->with('success','Success!! Survey Data Insert Successfully!!');

	}
	public function EditUpcoming(Request $request)
	{
		$id = Input::get('id');
		$edit = DB::table('mnwv2.monitorevents')->where('id', '=', $id)->get();
		return view('Reports/editUpcoming', compact('edit'));
	}
	public function StoreUpcoming(Request $request)
	{
		//$brcode = Input::get('branch_code');
		//$brname = Input::get('branch_name');
		//$event_id = Input::get('eventid');
		$id = Input::get('id');
		$datestart = Input::get('datestart');
		$dateend = Input::get('dateend');
		$m1 = Input::get('monitor1_code');
		$m2 = Input::get('monitor2_code');
		$update = DB::table('mnwv2.monitorevents')->where('id',$id)->update(['datestart'=>$datestart,'dateend'=>$dateend,'monitor1_code'=>$m1,'monitor2_code'=>$m2]);
		return redirect('/Upcoming')->with('success','Success!! Data Updated successfully!!');
	}
	public function upcomingdelete($id)
	{
		$query = DB::table('mnwv2.monitorevents')->where('id', '=', $id)->delete();
		return redirect()->back()->with('success','Success!! Data deleted successfully!!');
	}
	//siam	
	public function Upload_json()
	{
		return view('Reports/UploadJson');
	}
	//siam
	public function BackupJsonStore(Request $request)
	{
		$data=$request->all();
		// dd($data['json_file']);

		$json_file=$data['json_file'];
		$jsonfile=file_get_contents($json_file);
		$json = json_decode($jsonfile, true);

		$respondents=$json['data'][1]['data'];
		$survey_datas=$json['data'][2]['data'];

		// dd($respondents);
		foreach($respondents as $row){
			$backup_id=$row['Id'];
			$event_id=intval($row['EventId']);

			$branch_code=DB::table('mnwv2.monitorevents')->select('branchcode')->where('id',$event_id)->get();
			
			$branchcode=$branch_code[0]->branchcode;
			$orgno=$row['OrgNo'];
			$sec_no=intval($row['SectionId']);
			$orgmemno=$row['OrgMemNo'];
			if($orgmemno==""){
				$orgmemno="";
			}
			$admission_date=$row['AdmissionDate'];
			$loanno=$row['LoanNo'];
			$disbdate=$row['DisbDate'];
			$amnt=$row['Amount'];
			$time=$row['Id'];
			$MemberName=$row['MemberName'];
			$cono=$row['CONo'];
			$coname=$row['COName'];
			$monitorno=intval($row['MonitorNo']);
			$sub_sec_id=$row['SubSectionId'];
			$sub_id=$row['SubSectionId'];
			$Updated_At=$row['Updated_At'];
			$status=$row['Status'];
			$submitted_by=1;

			// $data=DB::table('mnwv2.respondents')->where('event_id',$event_id)->where('monitorno',$monitorno)->where('orgno',$orgno)->where('orgmemno',$orgmemno)->where('sec_no',$sec_no)->where('sub_sec_id',$sub_sec_id)->where('cono',$cono)->get();
			$data=DB::select(DB::raw("select * from mnwv2.respondents where event_id=$event_id and sec_no=$sec_no and sub_sec_id='$sub_sec_id' and orgno='$orgno' and orgmemno='$orgmemno'"));
			// dd($data);
			// var_dump($data);
			// echo "<pre>";
			if(empty($data)){
				// die();
				// dd('empty');
				DB::table('mnwv2.respondents')->insert(['branchcode'=>$branchcode,
				'orgno' =>$orgno,
				'event_id' =>$event_id,
				'sec_no'=>$sec_no,
				'orgmemno'=>$orgmemno,
				'admission_date'=>$admission_date,'loanno'=>intval($loanno),'disbdate'=>$disbdate,'amnt'=>intval($amnt),'MemberName'=>$MemberName,'cono'=>$cono,'coname'=>$cono,'monitorno'=>$monitorno,'sub_sec_id'=>$sub_sec_id,'sub_id'=>intval($sub_id),'submitted_by'=> $submitted_by]);	
			}
			
			
			// $data=DB::table('mnwv2.respondents_backup')->where('backup_id',$backup_id)->get();
			
			// if($data->isEmpty()){
			// 	DB::table('mnwv2.respondents_backup')->insert(['branchcode'=>$branchcode,
			// 	'orgno' =>$orgno,
			// 	'event_id' =>intval($event_id),
			// 	'sec_no'=>intval($sec_no),
			// 	'orgmemno'=>$orgmemno,
			// 	'admission_date'=>$admission_date,'loanno'=>intval($loanno),'disbdate'=>$disbdate,'amnt'=>intval($amnt),'MemberName'=>$MemberName,'cono'=>$cono,'coname'=>$cono,'monitorno'=>intval($monitorno),'sub_sec_id'=>$sub_sec_id,'sub_id'=>intval($sub_id),'backup_id'=>$backup_id,'update_date'=>$Updated_At,'status'=>$status]);	
			// }
		}

		foreach($survey_datas as $row){
			$backup_id=$row['Id'];
			$event_id=intval($row['EventId']);
			$sec_no=intval($row['SectionId']);
			$question=intval($row['Question']);
			$answer=intval($row['Answer']);
			$score=intval($row['Score']);
			$orgno=$row['OrgNo'];
			$orgmemno=$row['OrgMemNo'];
			$sub_sec_id=$row['SubSectionId'];
			$monitorno=intval($row['MonitorNo']);
			$remarks=$row['Remarks'];
			$longi=$row['Longi'];
			$lati=$row['Lati'];
			$Updated_At=$row['Updated_At'];
			$verified=$row['Verified'];
			$sub_id=intval($row['SubSectionId']);
			$submitted_by=1;
			$status=$row['Status'];

			$data=DB::table('mnwv2.survey_data')->where('event_id',$event_id)->where('monitorno',$monitorno)->where('orgno',$orgno)->where('orgmemno',$orgmemno)->where('sec_no',$sec_no)->where('sub_sec_id',$sub_sec_id)->where('question',$question)->get();

			if($data->isEmpty()){
				DB::table('mnwv2.survey_data')->insert(['event_id' =>$event_id,'sec_no'=>$sec_no,'question'=>$question,'answer'=>$answer,'score'=>$score,'orgno' =>$orgno,'orgmemno'=>$orgmemno,'sub_sec_id'=>$sub_sec_id,'monitorno'=>$monitorno,'remarks'=>$remarks,'longi'=>$longi,'lati'=>$lati,'verified'=>$verified,'sub_id'=>$sub_id,'submitted_by'=> $submitted_by]);
			}

			// $data=DB::table('mnwv2.survey_data_backup')->where('backup_id',$backup_id)->get();
			
			// if($data->isEmpty()){
			// 	DB::table('mnwv2.survey_data_backup')->insert(['event_id' =>$event_id,'sec_no'=>$sec_no,'question'=>$question,'answer'=>$answer,'score'=>$score,'orgno' =>$orgno,'orgmemno'=>$orgmemno,'sub_sec_id'=>$sub_sec_id,'monitorno'=>$monitorno,'remarks'=>$remarks,'longi'=>$longi,'lati'=>$lati,'verified'=>$verified,'sub_id'=>$sub_id,'submitted_by'=> $submitted_by,'backup_id'=>$backup_id,'update_date'=>$Updated_At,'status'=>$status]);
			// }	
		}
		

		return redirect()->back()->with('success','Success!! Data Inserted successfully!!');
	}

	//siam	
	public function BackupDataApi(Request $request)
	{

		$event_id =Input::get('EventId');
		// $event_id ='662';
		$ary=array();

		$respondents_backups=DB::table('mnwv2.respondents_backup')->where('event_id',$event_id)->get();
		$survey_data_backups=DB::table('mnwv2.survey_data_backup')->where('event_id',$event_id)->get();

		foreach($respondents_backups as $row){
			$ary['respondents_backups']['data'][]=$row;
		}

		foreach($survey_data_backups as $row){
			$ary['survey_data_backups']['data'][]=$row;
		}

		$json_ary = json_encode($ary);
		echo $json_ary;
	}
}
?>