<?php
namespace App\Http\Controllers;
use Log;
use Illuminate\Http\Request;
use App\LoginModel;
use Illuminate\Support\Facades\Input;
use DB;
use App\Http\Controllers\SessionController;
use Session;
use App\Http\Controllers\Route;
class LoginController extends Controller
{
	public function index()
	{
		return view('index');
	}
    public function login(Request $req)
	{
		$tkn ='';
	    $datestart='';
		$dateend ='';
		$br_code=0;
		$brname='';
		$role = 0;
		$username='';
		$name='';
		$userpin='';
		$id='';
		
	   $username=$req->input('username');
	   $password = $req->input('password');
	   $checklogin = DB::table('mnwv2.user')->select('id')->where(['username'=>$username, 'password'=>$password])->get();
	  //$checklogin = DB::select('select * from mnw.user where username=$username');
      /* $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
	  $iv = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
	  $token = bin2hex($iv); */
	  $token = uniqid();
	 // echo $token;
	  if(count($checklogin) > 0)
	  {
	  	  Session::put('token', $token);
		  Session::put('username', $username);
		  DB::table('mnwv2.user')->where('username', $username)->update(['session_data' => $token]);
		  //return redirect('/active');
		  
		$value = $req->session()->get('username');
		$user_pin = DB::table('mnwv2.user')->select('user_pin','id','username','name')->where('username','=',$value)->get();
		$userpin = $user_pin[0]->user_pin;
		//$id = $user_pin[0]->id;
		$username = $user_pin[0]->username;
		$name = $user_pin[0]->name;
    	$var = Date('Y-m-d');
		
		//$code = DB::table('mnw.monitorevents')->select('id','monitor1_code','monitor2_code','datestart','dateend','branchcode')->get();
		//$code = $sec3sub3 = DB::select( DB::raw("select * from mnw.monitorevents where datestart <= '$var' and monitor1_code='$userpin' or monitor2_code='$userpin' order by id DESC limit 1"));
	     $code =  DB::select( DB::raw("select * from mnwv2.monitorevents where datestart <= '$var' and monitor1_code='$userpin' or datestart <= '$var' and monitor2_code='$userpin' order by id desc limit 1"));
		//$datestart='';
		//$dateend ='';
		//$br_code=$code[0]->branchcode;
		//$brname='';
		//$role = 0;
		$myArray = array();
		//$id = $code[0]->id;
		$id =0;
		foreach($code as $row)
		{
		   $m1= $row->monitor1_code;
		   $m2= $row->monitor2_code;
		   $ds = $row->datestart;
		   //echo $ds;
		   $de =$row->dateend;
		   if($m1==$userpin)
		   {
			   if($ds <=$var and $de >=$var)
			   {
				  $data = DB::table('mnwv2.monitorevents')->select('id','datestart','dateend','branchcode')->where('datestart','<=',$var)->where('dateend','>=',$var)->where('monitor1_code','=',$userpin)->get();
				  $datestart= $data[0]->datestart;
				  $dateend = $data[0]->dateend;
				  $br_code = $data[0]->branchcode;
				  $id = $data[0]->id;
				  $role=1; 
                  $br_name = DB::table('branch')->select('branch_name')->where('branch_id','=',$br_code)->get();
                  $brname= $br_name[0]->branch_name;
				  break;
			   }
			   else{
				   Log::useDailyFiles(storage_path().'/logs/debug.log');
		           Log::info('No Monitoring Event For Today.');
				   $ar = array("status"=>'error',"message"=>'No Monitoring Event for Today!');
				   $json = json_encode($ar);
				   echo $json;  
			   }
		   }
		   else if($m2==$userpin)
		   {
			   if($ds <=$var and $de >=$var)
			   {
			    $data = DB::table('mnwv2.monitorevents')->select('id','datestart','dateend','branchcode')->where('datestart','<=',$var)->where('dateend','>=',$var)->where('monitor2_code','=',$userpin)->get();
				$datestart= $data[0]->datestart;
				$dateend = $data[0]->dateend;
				$id = $data[0]->id;
				$role=2;
				$br_code = $data[0]->branchcode;
			    $br_name = DB::table('branch')->select('branch_name')->where('branch_id','=',$br_code)->get();
			    $brname= $br_name[0]->branch_name;
				//echo $brname;
				break;
			   }
			   else{
				   
				   Log::useDailyFiles(storage_path().'/logs/debug.log');
		           Log::info('No Monitoring Event For Today.');
				   $ar = array("status"=>'error',"message"=>'No Monitoring Event for Today!');
				   $json = json_encode($ar);
				   echo $json;
				   
			   }
		   }
		}
		
	    $checkrespondent =DB::table('mnwv2.respondents')->where('event_id',$id)->get();
		if($checkrespondent->isEmpty())
		{
			$changeroll = DB::table('mnwv2.monitorevents')->where('branchcode',$br_code)->where('changeroll',1)->get();
			if($changeroll->isEmpty())
			{
				$takn =DB::table('mnwv2.user')->select('session_data')->where('user_pin','=',$userpin)->get();
				$tkn = $takn[0]->session_data;
				$areacode =  DB::table('branch')->where('branch_id',$br_code)->where('program_id',1)->get();
				if($areacode->isEmpty())
				{
					
				}
				else
				{
					$areaname = $areacode[0]->area_name;
					$regionname = $areacode[0]->region_name;
					$division = $areacode[0]->division_name;
					$ar = array("status"=>'success',"message"=>'Login Successfull',"token"=>$tkn,"userid"=>$username,"username"=>$name,"userpin"=>$userpin,"eventid"=>$id,"datestart"=>$datestart,"dateend"=>$dateend,"branchcode"=>$br_code,"branchname"=>$brname,"eventrole"=>$role,"CanChangeRole"=>"NoData","areaname"=>$areaname,"regionname"=>$regionname,"divisionname"=>$division);
				    $json = json_encode($ar);
				    echo $json;
					Log::useDailyFiles(storage_path().'/logs/debug.log');
		            Log::info('Login Success '.$json);
				}
				
			}
			else
			{
				$takn =DB::table('mnwv2.user')->select('session_data')->where('user_pin','=',$userpin)->get();
				$tkn = $takn[0]->session_data;
				$areacode =  DB::table('branch')->where('branch_id',$br_code)->where('program_id',1)->get();
				if($areacode->isEmpty())
				{
					
				}
				else
				{
					$areaname = $areacode[0]->area_name;
					$regionname = $areacode[0]->region_name;
					$division = $areacode[0]->division_name;
					$ar = array("status"=>'success',"message"=>'Login Successfull',"token"=>$tkn,"userid"=>$username,"username"=>$name,"userpin"=>$userpin,"eventid"=>$id,"datestart"=>$datestart,"dateend"=>$dateend,"branchcode"=>$br_code,"branchname"=>$brname,"eventrole"=>$role,"CanChangeRole"=>"CannotChange","areaname"=>$areaname,"regionname"=>$regionname,"divisionname"=>$division);
				    $json = json_encode($ar);
				    echo $json;
					Log::useDailyFiles(storage_path().'/logs/debug.log');
		            Log::info('Login Success '.$json);
				}
				
			}
		}
		else
		{
			$takn =DB::table('mnwv2.user')->select('session_data')->where('user_pin','=',$userpin)->get();
			$tkn = $takn[0]->session_data;
			$areacode =  DB::table('branch')->where('branch_id',$br_code)->where('program_id',1)->get();
			if($areacode->isEmpty())
			{
				
			}
			else
			{
				$areaname = $areacode[0]->area_name;
				$regionname = $areacode[0]->region_name;
				$division = $areacode[0]->division_name;
				$ar = array("status"=>'success',"message"=>'Login Successfull',"token"=>$tkn,"userid"=>$username,"username"=>$name,"userpin"=>$userpin,"eventid"=>$id,"datestart"=>$datestart,"dateend"=>$dateend,"branchcode"=>$br_code,"branchname"=>$brname,"eventrole"=>$role,"CanChangeRole"=>"HasData","areaname"=>$areaname,"regionname"=>$regionname,"divisionname"=>$division);
			    $json = json_encode($ar);
			    echo $json;
				Log::useDailyFiles(storage_path().'/logs/debug.log');
		        log::info('Login Success '.$json);
			}
			
		}
       
	  }
	  else
	  {
		  //return redirect()->back()->with('error','Error!! Invalied Username & Password!!!');
		  $ar = array("status"=>'error',"message"=>'Login Failed!',"token"=>$tkn,"userid"=>$username,"username"=>$name,"userpin"=>$userpin,"eventid"=>$id,"datestart"=>$datestart,"dateend"=>$dateend,"branchcode"=>$br_code,"branchname"=>$brname,"eventrole"=>$role);
          $json = json_encode($ar);
		  echo $json;
		  Log::useDailyFiles(storage_path().'/logs/debug.log');
		  Log::info('Login Failed '. $json);
	  }
      //$json = json_encode($myArray);
     // echo $json;	  
	}
	public function server_login(Request $req)
	{
	   $tkn ='';
	   $datestart='';
	   $dateend ='';
	   $br_code=0;
	   $brname='';
	   $role = 0;
	   $username='';
	   $name='';
	   $userpin='';
	   $id='';
	   $apikey ='';
	   $Key ='dhaka1207#qsoft%net';
	   $username=$req->input('username');
	   $password = $req->input('password');
	   $apikey = $req->header('apikey');
	   $checklogin = DB::table('mnwv2.user')->select('id')->where(['username'=>$username, 'password'=>$password])->get();
	   //var_dump($checklogin);
	  //$checklogin = DB::select('select * from mnw.user where username=$username');
      /* $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
	  $iv = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
	  $token = bin2hex($iv); */
	  $token = uniqid();
	 // echo $token;
	    if($Key ==$apikey)
	    {
			
		   if(count($checklogin) > 0)
		   {
			  
			  Session::put('token', $token);
			  Session::put('username', $username);
			  DB::table('mnwv2.user')->where('username', $username)->update(['session_data' => $token]);
			  //return redirect('/active');
			  
			$value = $req->session()->get('username');
			$user_pin = DB::table('mnwv2.user')->select('user_pin','id','username','name')->where('username','=',$value)->get();
			$userpin = $user_pin[0]->user_pin;
			//$id = $user_pin[0]->id;
			$username = $user_pin[0]->username;
			$name = $user_pin[0]->name;
			$va = date('Y-m-d');
			$exp = explode('-',$va);
			$year = $exp[0];
			$mt = $exp[1];
			$day = $exp[2];
			$extendday = $day+2;
			//$var = $year."-".$mt."-".$extendday;
			$var = date('Y-m-d'); //date('Y-m-d', strtotime($va . " +4 days"));
			//$code = DB::table('mnw.monitorevents')->select('id','monitor1_code','monitor2_code','datestart','dateend','branchcode')->get();
			//$code = $sec3sub3 = DB::select( DB::raw("select * from mnw.monitorevents where datestart <= '$var' and monitor1_code='$userpin' or monitor2_code='$userpin' order by id DESC limit 1"));
			// $code =  DB::select( DB::raw("select * from mnwv2.monitorevents where datestart <= '$var' and monitor1_code='$userpin' or datestart <= '$var' and monitor2_code='$userpin' order by id desc limit 1"));
			$code =  DB::select( DB::raw("select * from mnwv2.monitorevents where datestart <= '$va' and dateend >='$var' and (monitor1_code='$userpin' or monitor2_code='$userpin')  order by id desc limit 1"));
			//var_dump($code);
			//$datestart='';
			//$dateend ='';
			//$br_code=$code[0]->branchcode;
			//$brname='';
			//$role = 0;
			$myArray = array();
			//$id = $code[0]->id;
			if(!empty($code))
			{
				$id =0;
				foreach($code as $row)
				{
				   $m1= $row->monitor1_code;
				   $m2= $row->monitor2_code;
				   $ds = $row->datestart;
				   $de =$row->dateend;
				   if($m1==$userpin)
				   {
					  // echo "Hud";
					   if($ds <=$va and $de >=$va)
					   {
						  $data = DB::table('mnwv2.monitorevents')->select('id','datestart','dateend','branchcode')->where('datestart','<=',$va)->where('dateend','>=',$va)->where('monitor1_code','=',$userpin)->get();
						  $datestart= $data[0]->datestart;
						  $dateend = $data[0]->dateend;
						  $br_code = $data[0]->branchcode;
						  $id = $data[0]->id;
						  $role=1; 
						  $br_name = DB::table('branch')->select('branch_name')->where('branch_id','=',$br_code)->get();
						  $brname= $br_name[0]->branch_name;
						  break;
					   }
					   else{
						  // Log::useDailyFiles(storage_path().'/logs/debug.log');
						   //Log::info('No Monitoring Event For Today.');
						   $ar = array("status"=>'error',"message"=>'No Monitoring Event for Today!');
						   $json = json_encode($ar);
						   echo $json;  
					   }
				   }
				   else if($m2==$userpin)
				   {
					   if($ds <=$va and $de >=$va)
					   {
						$data = DB::table('mnwv2.monitorevents')->select('id','datestart','dateend','branchcode')->where('datestart','<=',$va)->where('dateend','>=',$va)->where('monitor2_code','=',$userpin)->get();
						$datestart= $data[0]->datestart;
						$dateend = $data[0]->dateend;
						$id = $data[0]->id;
						$role=2;
						$br_code = $data[0]->branchcode;
						$br_name = DB::table('branch')->select('branch_name')->where('branch_id','=',$br_code)->get();
						$brname= $br_name[0]->branch_name;
						//echo $brname;
						break;
					   }
					   else{
						   
						   //Log::useDailyFiles(storage_path().'/logs/debug.log');
						   //Log::info('No Monitoring Event For Today.');
						   $ar = array("status"=>'error',"message"=>'No Monitoring Event for Today!');
						   $json = json_encode($ar);
						   echo $json;
						   
					   }
				   }
				}
				
				$checkrespondent =DB::table('mnwv2.respondents')->where('event_id',$id)->get();
				if($checkrespondent->isEmpty())
				{
					$changeroll = DB::table('mnwv2.monitorevents')->where('branchcode',$br_code)->where('changeroll',1)->get();
					if($changeroll->isEmpty())
					{
						$takn =DB::table('mnwv2.user')->select('session_data')->where('user_pin','=',$userpin)->get();
						$tkn = $takn[0]->session_data;
						$areacode =  DB::table('branch')->where('branch_id',$br_code)->where('program_id',1)->get();
						if($areacode->isEmpty())
						{
							
						}
						else
						{
							$areaname = $areacode[0]->area_name;
							$regionname = $areacode[0]->region_name;
							$division = $areacode[0]->division_name;
							$ar = array("status"=>'success',"message"=>'Login Successfull',"token"=>$tkn,"userid"=>$username,"username"=>$name,"userpin"=>$userpin,"eventid"=>$id,"datestart"=>$datestart,"dateend"=>$dateend,"branchcode"=>$br_code,"branchname"=>$brname,"eventrole"=>$role,"CanChangeRole"=>"NoData","areaname"=>$areaname,"regionname"=>$regionname,"divisionname"=>$division);
							$json = json_encode($ar);
							echo $json;
							//Log::useDailyFiles(storage_path().'/logs/debug.log');
							//Log::info('Login Success '.$json);
						}
						
					}
					else
					{
						$takn =DB::table('mnwv2.user')->select('session_data')->where('user_pin','=',$userpin)->get();
						$tkn = $takn[0]->session_data;
						$areacode =  DB::table('branch')->where('branch_id',$br_code)->where('program_id',1)->get();
						if($areacode->isEmpty())
						{
							
						}
						else
						{
							$areaname = $areacode[0]->area_name;
							$regionname = $areacode[0]->region_name;
							$division = $areacode[0]->division_name;
							$ar = array("status"=>'success',"message"=>'Login Successfull',"token"=>$tkn,"userid"=>$username,"username"=>$name,"userpin"=>$userpin,"eventid"=>$id,"datestart"=>$datestart,"dateend"=>$dateend,"branchcode"=>$br_code,"branchname"=>$brname,"eventrole"=>$role,"CanChangeRole"=>"CannotChange","areaname"=>$areaname,"regionname"=>$regionname,"divisionname"=>$division);
							$json = json_encode($ar);
							echo $json;
							//Log::useDailyFiles(storage_path().'/logs/debug.log');
							//Log::info('Login Success '.$json);
						}
						
					}
				}
				else
				{
					$takn =DB::table('mnwv2.user')->select('session_data')->where('user_pin','=',$userpin)->get();
					$tkn = $takn[0]->session_data;
					$areacode =  DB::table('branch')->where('branch_id',$br_code)->where('program_id',1)->get();
					if($areacode->isEmpty())
					{
						
					}
					else
					{
						$areaname = $areacode[0]->area_name;
						$regionname = $areacode[0]->region_name;
						$division = $areacode[0]->division_name;
						$ar = array("status"=>'success',"message"=>'Login Successfull',"token"=>$tkn,"userid"=>$username,"username"=>$name,"userpin"=>$userpin,"eventid"=>$id,"datestart"=>$datestart,"dateend"=>$dateend,"branchcode"=>$br_code,"branchname"=>$brname,"eventrole"=>$role,"CanChangeRole"=>"HasData","areaname"=>$areaname,"regionname"=>$regionname,"divisionname"=>$division);
						$json = json_encode($ar);
						echo $json;
						//Log::useDailyFiles(storage_path().'/logs/debug.log');
						//log::info('Login Success '.$json);
					}
					
				}
			}
			else
			{
				//Log::info('No Monitoring Event For Today.');
			    $ar = array("status"=>'error',"message"=>'No Monitoring Event for Today!');
			    $json = json_encode($ar);
			    echo $json;
			}
			
		   
		  }
		  else
		  {
			  //return redirect()->back()->with('error','Error!! Invalied Username & Password!!!');
			  $ar = array("status"=>'error',"message"=>'Login Failed!',"token"=>$tkn,"userid"=>$username,"username"=>$name,"userpin"=>$userpin,"eventid"=>$id,"datestart"=>$datestart,"dateend"=>$dateend,"branchcode"=>$br_code,"branchname"=>$brname,"eventrole"=>$role);
			  $json = json_encode($ar);
			  echo $json;
			  //Log::useDailyFiles(storage_path().'/logs/debug.log');
			  //Log::info('Login Failed '. $json);
		  }
	  }
	  else
	  {
		  $ar = array("status"=>'error',"message"=>'Login Failed!');
		  $json = json_encode($ar);
		  echo $json;
		  //Log::useDailyFiles(storage_path().'/logs/debug.log');
		  //Log::info('Login Failed '. $json);
	  }
	  
	}
	public function templogin(Request $req)
	{
	  $username=$req->input('username');
	  $password = $req->input('password');
	  $checklogin = DB::table('mnwv2.user')->select('id')->where(['username'=>$username, 'password'=>$password])->get();
	  $token = uniqid();
	  if(count($checklogin) > 0)
	  {
	  	  Session::put('token', $token);
		  Session::put('username', $username);
		  DB::table('mnwv2.user')->where('username', $username)->update(['session_data' => $token]);
		  return view('/home');
	  }
	  else
	  {
		  return redirect()->back()->with('error','Error!! Invalied Username & Password!!!');
	  } 
	}
	public function templog(Request $req)
	{
	  $roll=0;
	  $pin=$req->input('user_pin');
	  $roll = $req->input('roll_id');
	  $name = $req->input('name');
	  $user_id = $req->input('user_id');
	  $as_id = $req->input('as_id');
	//  echo $pin."/".$roll."/".$name."/".$user_id."/".$as_id;
	 // die();
	  //$checklogin = DB::table('mnw.user')->select('id')->where(['username'=>$username, 'password'=>$password])->get();
	  $token = uniqid();
	  //if(count($checklogin) > 0)
	 // {
	  	  Session::put('token', $token);
		  Session::put('username', $name);
		  Session::put('roll', $roll);
		  Session::put('asid', $as_id);
		  Session::put('user_pin', $pin);
		  //DB::table('mnw.user')->where('username', $username)->update(['session_data' => $token]);
		 // return view('/home');
		 if($roll =='1')
		 {
			return redirect('/BranchDashboard');
		 }
		 else if($roll =='2')
		 {
			 return redirect('/ADashboard');
		 }
		 else if($roll =='3')
		 {
			 return redirect('/RDashboard');
		 }
		 else if($roll =='4')
		 {
			 return redirect('/DDashboard');
		 }
		 else if ((($roll=='5' or $roll=='8') or ($roll=='9' or $roll=='10')) or ($roll=='11' or $roll=='12')) //else if(((($roll=='8') or ($roll=='9'))) or ((($roll=='10') or ($roll=='11')) or ($roll=='12')))
		 {
			return redirect('/NationalDashboard');
		 }
		 else if($roll=='16' or $roll=='7')
		 {
			 return redirect('/NationalDashboard');
		 }
		 else if($roll=='17')
		 {
			 return redirect('/ClDashboard');
		 }
		 else if($roll=='18')
		 {
			 return redirect('/ZonalDashboard');
		 }
		 else
		 {
			 return redirect('/');
		 }
		 
	 // }
	 // else
	  //{
		  //return redirect()->back()->with('error','Error!! Invalied Username & Password!!!');
	 // } 
	}
	public function lock(Request $req)
	{
	 if (Session::has('token')) {
      // echo Session::get('token'); 
	  } 
	  $password = $req->input('password');
	  $checklogin = DB::table('mnw.user')->where(['password'=>$password])->get();

	  if(count($checklogin) > 0)
	  {
		  return view('home');
	  }
	  else
	  {
		  return redirect()->back()->with('error','Error!! Invalied  Password!!!');
	  }
	}
	public function create()
	{
		$data = [
		   $name=Input::get('fname'),
		   $email=Input::get('email'),
		   $phone=Input::get('phone'),
		   $username=Input::get('username'),
		   $password=Input::get('password'),
		   $user_pin=Input::get('user_pin'),
		  ];
	    $check = DB::table('mnw.user')->where('user_pin',$user_pin)->get();
		if($check->isEmpty())
		{
			$response =DB::table('mnw.user')->insert(['name' =>$name,'email'=>$email,'phone' =>$phone,'username' =>$username,
				'password'=>$password,'user_pin'=>$user_pin]);
			if($response)
			{
				return redirect()->back()->with('success','Success!! Monitor Created!!');
			}
		}
		else
		{
			return redirect()->back()->with('Failed','Failed!! Userpin Already Exists!!');
		}
		
	}
	public function useredit(Request $request)
	{
		$id = Input::get('id');
		$data = DB::table('mnw.user')->where('id',$id)->get();
		return view('edituser', compact('data'));
		//$u = DB::table('mnw.user')->where('id',$id)->update(['name' =>$branchcode,
		//'email'=>$orgmemno,'phone'=>$admissiondate,'loanno'=>$loanno,'disbdate'=>$disbdate,'amnt'=>$amount]);
	}
	public function editcreate()
	{
		$data = [
		   $name=Input::get('fname'),
		   $email=Input::get('email'),
		   $phone=Input::get('phone'),
		   $username=Input::get('username'),
		   $user_pin=Input::get('user_pin'),
		   $id=Input::get('id'),
		  ];
	  
		$response =DB::table('mnw.user')->where('id',$id)->update(['name' =>$name,'email'=>$email,'phone' =>$phone,'username' =>$username,
				'user_pin'=>$user_pin]);
		if($response)
		{
			return redirect('/user')->with('success','Success!! User Updated!!');
		}
	}
	public function deleteuser(Request $request)
	{
		$id = Input::get('id');
		$delete = DB::table('mnw.user')->where('id',$id)->delete();
		if($delete)
		{
			return redirect('/user')->with('success','Success!! User Deleted!!');
		}
	}
	public function usershow()
	{
		$user = DB::table('mnw.user')->get();
		 return view('user', compact('user'));
	}
	public function changemonitor(Request $request)
	{
		$session_data = $request->get('token');
		$eventid  =$request->get('evenId');
		$role =$request->get('evenRoll');
		$brcode =$request->get('branchcode');
		$var = Date('Y-m-d');
		$checkuser = DB::table('mnwv2.user')->where('session_data',$session_data)->get();
		//var_dump($checkuser);
		if($checkuser->isEmpty())
		{
			$ar = array("status"=>'success',"message"=>'Token Mismatch!!');
			$json = json_encode($ar);
			echo $json;
		}
		else
		{
			$userpin = $checkuser[0]->user_pin;
			//$checkmonitor = DB::table('mnw.monitorevents')->where('branchcode',$brcode)->where('datestart','<',)->get();
			$checkmonitor = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brcode' and id=$eventid"));
			if(empty($checkmonitor))
			{
				$ar = array("status"=>'success',"message"=>'No found Data!');
                $json = json_encode($ar);
			    echo $json;
			}
			else
			{
				$m1 = $checkmonitor[0]->monitor1_code;
				
				$m2 = $checkmonitor[0]->monitor2_code;
				//echo $m1."/".$m2;
				/* $changeroll = DB::table('mnw.monitorevents')->where('branchcode',$brcode)->where('changeroll',1)->get();
				if($changeroll->isEmpty())
				{  */
					if($role =='1')
					{
						if($userpin==$m1)
						{
							//echo $m1."m1";
							$response =DB::table('mnwv2.monitorevents')->where('id',$eventid)->update(['monitor1_code' =>$m1,'monitor2_code'=>$m2,'changeroll'=>1]);
						}
						else if($userpin==$m2)
						{
							
							$response =DB::table('mnwv2.monitorevents')->where('id',$eventid)->update(['monitor1_code' =>$m2,'monitor2_code'=>$m1,'changeroll'=>1]);
						}
						else
						{
							$ar = array("status"=>'success',"message"=>'No found monitor!');
							$json = json_encode($ar);
							echo $json;
						}
						$ar = array("status"=>'success',"message"=>'Change Monitor successfull',"token"=>$session_data,"eventid"=>$eventid,"branchcode"=>$brcode,"eventrole"=>$role);
						$json = json_encode($ar);
						echo $json;
					}
					else if($role=='2')
					{
						//echo $userpin;
						if($userpin==$m1)
						{
							
							$response =DB::table('mnwv2.monitorevents')->where('id',$eventid)->update(['monitor1_code' =>$m2,'monitor2_code'=>$m1,'changeroll'=>1]);
						}
						else if($userpin==$m2)
						{
							
							$response =DB::table('mnwv2.monitorevents')->where('id',$eventid)->update(['monitor1_code' =>$m1,'monitor2_code'=>$m2,'changeroll'=>1]);
						}
						else
						{
							$ar = array("status"=>'success',"message"=>'No found monitor!');
							$json = json_encode($ar);
							echo $json;
						}
						$ar = array("status"=>'success',"message"=>'Change Monitor successfull',"token"=>$session_data,"eventid"=>$eventid,"branchcode"=>$brcode,"eventrole"=>$role);
						$json = json_encode($ar);
						echo $json;
					}
					else
					{
						$ar = array("status"=>'success',"message"=>'No found Role!');
						$json = json_encode($ar);
						echo $json;
					}
				/* }
				else
				{
					$ar = array("status"=>'cannot change',"message"=>'Cannot change this roll',"token"=>$session_data,"eventid"=>$eventid,"branchcode"=>$brcode,"eventrole"=>$role);
					$json = json_encode($ar);
					echo $json;
				} */
				
				
				
			}
		}
	}
	
}
