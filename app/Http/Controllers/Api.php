<?php

namespace App\Http\Controllers;
use Log;
use view;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Http\Requests;

class Api extends Controller
{
    public function respondent(Request $request)
	{
		
		 $data =Input::get('req');
		 $de = json_decode($data);
		 $f = $de->token;
	     $var2 = $de->data;
		 
		 //print_r($var2);
		// die();
        // $vr = array($var2);	if start {}	 and [{}]  this is crroct
		 $myArray = array();
		 $id =0;
		 $arr = '';
    	 foreach ($var2 as $v) {
			$branchcode = $v->branchcode;
			//$token = $v->token;
			$sec_id = $v->sec_id;
			$eventid = $v->eventid;
			$orgno = $v->orgno;
			$orgmemno = $v->orgmemno;
			$admissiondate = $v->admissiondate;
			$loanno = $v->loanno;
			$disbdate = $v->disbdate;
			$amount = $v->amount;
			$status =$v->status;
			$memname = $v->membername;
			$cono = trim($v->cono);
			$coname = $v->coname;
			$monitorno =$v->monitorno;
			$sub_sec_no = $v->sub_sec_id;
			if($sub_sec_no =='')
			{
				$sub_sec_no =0;
			}
			$check = DB::table('mnwv2.monitorevents')->where('id',$eventid)->get();
			if(!$check->isEmpty())
			{
				$dst = $check[0]->datestart;
				$dend = $check[0]->dateend;
				$c_date = Date('Y-m-d');
				if($dst <= $c_date and $dend >=$c_date)
				{
					if($status=='N')
					{
						
						$check= DB::table('mnwv2.respondents')->where('event_id',$eventid)->where('sec_no',$sec_id)->where('orgno',$orgno)->where('orgmemno',$orgmemno)->where('sub_sec_id',$sub_sec_no)->get();
						
						if($check->isEmpty())
						{
							$s = DB::table('mnwv2.respondents')->insert(['branchcode' =>$branchcode,'orgno'=>$orgno,'event_id' =>$eventid,'sec_no' =>$sec_id,
							'orgmemno'=>$orgmemno,'admission_date'=>$admissiondate,'loanno'=>$loanno,'disbdate'=>$disbdate,'amnt'=>$amount,'MemberName'=>$memname,'cono'=>$cono,'coname'=>$coname,'monitorno'=>$monitorno,'sub_sec_id'=>$sub_sec_no,'sub_id'=>$sub_sec_no]);
							if($s)
							{
								$id = DB::table('mnwv2.respondents')->find(DB::table('mnwv2.respondents')->max('id'));
							
								
								//$r_data = DB::table('mnwv2.respondents')->select('id','event_id','sec_no','orgno','orgmemno')->get();
								$ids = $id->id;
								$event_id = $id->event_id;
								$sec_id = $id->sec_no;
								$orgno = $id->orgno;
								$orgmemno = $id->orgmemno;
								if($sub_sec_no=='0')
								{
									$sub_sec_no ='';
								}
								$ar = array("status"=>"S","message"=>"Insert Successfull","id"=>$ids,"eventid"=>$event_id,"sec_id"=>$sec_id,"orgno"=>$orgno,"orgmemno"=>$orgmemno,"sub_sec_id"=>$sub_sec_no,"monitorno"=>$monitorno);
								$arr ='S';
								$myArray[] = $ar;
								$this->sendDataChanged($eventid,$monitorno);
							}
							else{
								$ar = array("status"=>"F","message"=>"Insert Failed","id"=>0,"eventid"=>$eventid,"sec_id"=>$sec_id,"orgno"=>$orgno,"orgmemno"=>$orgmemno,"sub_sec_id"=>$sub_sec_no,"monitorno"=>$monitorno);
								$arr ='S';
								
							   $myArray[] = $ar;
							}
						}
						else
						{
							$id  = $check[0]->id;
							$mno = $check[0]->monitorno;
								$ar = array("status"=>"S","message"=>"Data Alreay Exists","id"=>$id,"eventid"=>$eventid,"sec_id"=>$sec_id,"orgno"=>$orgno,"orgmemno"=>$orgmemno,"sub_sec_id"=>$sub_sec_no,"monitorno"=>$mno);
								$arr ='S';
								
							   $myArray[] = $ar;
						
						}
					}
					else if($status=='U')
					{
						$id=$v->id;
						$u = DB::table('mnwv2.respondents')->where('id',$id)->where('event_id',$eventid)->where('sec_no',$sec_id)->update(['branchcode' =>$branchcode,'orgno'=>$orgno,'event_id' =>$eventid,'sec_no' =>$sec_id,
							'orgmemno'=>$orgmemno,'admission_date'=>$admissiondate,'loanno'=>$loanno,'disbdate'=>$disbdate,'amnt'=>$amount,'MemberName'=>$memname,'cono'=>$cono,'coname'=>$coname,'MonitorNo'=>$monitorno,'sub_sec_id'=>$sub_sec_no,'sub_id'=>$sub_sec_no]);
						if($u)
						{
							if($sub_sec_no=='0')
							{
								$sub_sec_no ='';
							}

							$ar = array("status"=>"S", "message"=>"Update Successfull","id"=>$id,"eventid"=>$eventid,"sec_id"=>$sec_id,"orgno"=>$orgno,"orgmemno"=>$orgmemno,"sub_sec_id"=>$sub_sec_no,"monitorno"=>$monitorno);
							$arr ='S';
							$myArray[] = $ar;
							$this->sendDataChanged($eventid,$monitorno);
						}
						else
						{
							$ar = array("status"=>"S","message"=>"Update Failed","id"=>$id,"eventid"=>$eventid,"sec_id"=>$sec_id,"orgno"=>$orgno,"orgmemno"=>$orgmemno,"sub_sec_id"=>$sub_sec_no,"monitorno"=>$monitorno);
							$arr ='S';
							$myArray[] = $ar;
						}
						
					}
					else if($status=='D')
					{
						$id=$v->id;
						$s = DB::table('mnwv2.delete_respondents')->insert(['branchcode' =>$branchcode,'orgno'=>$orgno,'event_id' =>$eventid,'sec_no' =>$sec_id,
							'orgmemno'=>$orgmemno,'admission_date'=>$admissiondate,'loanno'=>$loanno,'disbdate'=>$disbdate,'amnt'=>$amount,'MemberName'=>$memname,'cono'=>$cono,'coname'=>$coname,'monitorno'=>$monitorno,'sub_sec_id'=>$sub_sec_no,'deleteid'=>$id]);
							
						$d = DB::table('mnwv2.respondents')->where('event_id',$eventid)->where('id',$id)->where('orgno',$orgno)->where('sec_no',$sec_id)->where('orgmemno',$orgmemno)->delete();
						if($d)
						{
							if($sub_sec_no=='0')
							{
								$sub_sec_no ='';
							}

							$ar = array("status"=>"S","message"=>"Delete Successfull","id"=>$id,"eventid"=>$eventid,"sec_id"=>$sec_id,"orgno"=>$orgno,"orgmemno"=>$orgmemno,"sub_sec_id"=>$sub_sec_no,"monitorno"=>$monitorno);
							$arr ='S';
							$this->sendDataChanged($eventid,$monitorno);
							$myArray[] = $ar;
							
						}
						else
						{
							$ar = array("status"=>"S","message"=>"No Record Found","id"=>$id,"eventid"=>$eventid,"sec_id"=>$sec_id,"orgno"=>$orgno,"orgmemno"=>$orgmemno,"sub_sec_id"=>$sub_sec_no,"monitorno"=>$monitorno);
							$arr ='S';
							$myArray[] = $ar;
						}
						
						
					}
				}
				else
				{
					$status = array("status"=>"Failed","message"=>"Event date closed!!!");
		            $json2 = json_encode($status);
		            echo $json2;
				}
			}
			else
			{
				$status = array("status"=>"Failed","message"=>"This event id not found!");
		        $json2 = json_encode($status);
		        echo $json2;
			}
			
		 }
		 $status = array("status"=>$arr,"data"=>$myArray);
		 $json2 = json_encode($status);
		 echo $json2;
		

	}
	public function survey_data(Request $r)
	{
		$data =Input::get('req');
		$de = json_decode($data);
		$survay_token = $de->token;
		$survay_data = $de->data;
		$takn =DB::table('mnwv2.user')->select('session_data','user_pin')->where('session_data','=',$survay_token)->get();
		if(!$takn->isEmpty())
		{
		 $totalanswer=0;
		 $id =0;
		 $arr=0;
		 $cheking=0;
		 $id=0;
		 $monitorno=0;
		 $sub_sec_no='';
	     $myArray = array();
		 $sub_sec_no = '';
		 foreach ($survay_data as $s) {
			$eventid = $s->eventid;
			$secid = $s->sec_id;
			//$respondent_id = $s->respondent_id;
			$question = $s->question;
			$answer = $s->answer;
			$number = $s->score;
			$orgno = $s->orgno;
			$orgmemno = $s->orgmemno;
			$sub_sec_no = $s->sub_sec_id;
			if($sub_sec_no=='')
			{
				$sub_sec_no=0;
			}
			$monitorno = $s->monitorno;
			$remarks = $s->remarks;
			$status = $s->status;
			$longi = $s->longi;
			$lati = $s->lati;
			$verified = $s->verified;
			/* if($tkn == $survay_token)
			{ */
				//$sur=DB::table('mnwv2.survey_data')->get();
				$datas = DB::table('mnwv2.monitorevents')->where('id',$eventid)->get();
				if(!$datas->isEmpty())
				{
					
					$dst = $datas[0]->datestart;
					$dend = $datas[0]->dateend;
					$c_date = Date('Y-m-d');
					if($dst <= $c_date and $dend >=$c_date)
					{

						if($status=='N')
						{
							$cheking = DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('question',$question)->where('orgno',$orgno)->where('orgmemno',$orgmemno)->where('sub_sec_id',$sub_sec_no)->get();
							
							if($cheking->isEmpty())
							{
								$survay_data = DB::table('mnwv2.survey_data')->insert(['event_id' =>$eventid,'sec_no'=>$secid,'question' =>$question,
								'answer'=>$answer,'score'=>$number,'orgno'=>$orgno,'orgmemno'=>$orgmemno,'sub_sec_id'=>$sub_sec_no,'monitorno'=>$monitorno,'remarks'=>$remarks,'longi'=>$longi,'lati'=>$lati,'verified'=>$verified,'sub_id'=>$sub_sec_no]);
								if($survay_data)
								{
									
									$sur = DB::table('mnwv2.survey_data')->find(DB::table('mnwv2.survey_data')->max('id'));
									$id = $sur->id;
									$eventids = $sur->event_id;
									$secids = $sur->sec_no;
									//$respondent_ids = $sur->respondent_id;
									$questions = $sur->question;
									$answers = $sur->answer;
									$numbers = $sur->score;
									$orgnos = $sur->orgno;
									$orgmemnos =$sur->orgmemno;
									$monitorno= $sur->monitorno;
									$remarks = $sur->remarks;
									$sub_sec_id =  $sur->sub_sec_id;
									if($sub_sec_id =='0')
									{
										$sub_sec_id='';
									}
									$verified = $sur->verified;
									$ar = array("status"=>"S","message"=>"Insert Successfull","id"=>$id,'eventid' =>$eventids,'sec_id'=>$secids,'question' =>$questions,
									'answer'=>$answers,'score'=>$numbers,'orgno'=>$orgnos,'orgmemno'=>$orgmemnos,'monitorno'=>$monitorno,'remarks'=>$remarks,'sub_sec_id'=>$sub_sec_id,'verified'=>$verified);
									$arr ='S';
									$myArray[] = $ar;
									
								}
								else
								{
									if($sub_sec_no =='0')
									{
										$sub_sec_id='';
									}
									$ar = array('status'=>'S',"message"=>"Insert Failed",'id'=>0,'eventid' =>$eventid,'sec_id'=>$secid,'question' =>$question,
									'answer'=>$answer,'score'=>$number,'orgno'=>$orgno,'orgmemno'=>$orgmemno,'monitorno'=>$monitorno,'remarks'=>$remarks,'sub_sec_id'=>$sub_sec_id,'verified'=>$verified);
									$arr ='F';
									$myArray[] = $ar;
									
								}
							}
							else
							{
								$id= $cheking[0]->id;
								if($sub_sec_no =='0')
								{
									$sub_sec_no='';
								}
								$ar = array("status"=>"S","message"=>"Data Alreay Exists","id"=>$id,"eventid"=>$eventid,"sec_id"=>$secid,"orgno"=>$orgno,"orgmemno"=>$orgmemno,"question"=>$question,'monitorno'=>$monitorno,'remarks'=>$remarks,'sub_sec_id'=>$sub_sec_no,'verified'=>$verified);
								$arr ='S';
							    $myArray[] = $ar;
								
							}
						}
						else if($status=='U')
						{
							$id = $s->id;
						
							$survay_data_update = DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('orgno',$orgno)->where('orgmemno',$orgmemno)->where('question',$question)->where('id',$id)->update(['event_id' =>$eventid,'sec_no'=>$secid,'question' =>$question,
							'answer'=>$answer,'score'=>$number,'orgno'=>$orgno,'orgmemno'=>$orgmemno,'remarks'=>$remarks,'longi'=>$longi,'lati'=>$lati,'verified'=>$verified,'sub_id'=>$sub_sec_no]);
							if($survay_data_update)
							{
								if($sub_sec_no =='0')
								{
									$sub_sec_no='';
								}
								$ar = array('status'=>'S',"message"=>"Update Successfull","id"=>$id,'eventid' =>$eventid,'sec_id'=>$secid,'question' =>$question,
								'answer'=>$answer,'score'=>$number,'orgno'=>$orgno,'orgmemno'=>$orgmemno,'monitorno'=>$monitorno,'remarks'=>$remarks,'sub_sec_id'=>$sub_sec_no,'verified'=>$verified);
								$arr ='S';
					            $myArray[] = $ar;
								
							}
							else
							{
								if($sub_sec_no =='0')
								{
									$sub_sec_no='';
								}
								$ar = array('status'=>'S',"message"=>"Update Failed",'id'=>$id,'eventid' =>$eventid,'sec_id'=>$secid,'question' =>$question,
								'answer'=>$answer,'score'=>$number,'orgno'=>$orgno,'orgmemno'=>$orgmemno,'monitorno'=>$monitorno,'remarks'=>$remarks,'sub_sec_id'=>$sub_sec_no,'verified'=>$verified);
								$arr ='S';
					            $myArray[] = $ar;
								
							}
						}
						else if($status=='D')
						{
							$id = $s->id;
							$survay_data_delete = DB::table('mnwv2.survey_data')->where('event_id', $eventid)->where('sec_no',$secid)->where('orgno',$orgno)->where('orgmemno',$orgmemno)->where('id',$id)->delete();
							if($survay_data_delete)
							{
								if($sub_sec_no =='0')
								{
									$sub_sec_no='';
								}
								$ar = array('status'=>'S',"message"=>"Delete Successfull","id"=>$id,'eventid' =>$eventid,'sec_id'=>$secid,'question' =>$question,
								'answer'=>$answer,'score'=>$number,'orgno'=>$orgno,'orgmemno'=>$orgmemno,'monitorno'=>$monitorno,'remarks'=>$remarks,'sub_sec_id'=>$sub_sec_no,'verified'=>$verified);
								$arr ='S';
					            $myArray[] = $ar;
								
							}
							else
							{
								if($sub_sec_no =='0')
								{
									$sub_sec_no='';
								}
								$ar = array('status'=>'S',"message"=>"No Record Found",'id'=>$id,'eventid' =>$eventid,'sec_id'=>$secid,'question' =>$question,
								'answer'=>$answer,'score'=>$number,'orgno'=>$orgno,'orgmemno'=>$orgmemno,'monitorno'=>$monitorno,'remarks'=>$remarks,'sub_sec_id'=>$sub_sec_no,'verified'=>$verified);
								$arr ='S';
					            $myArray[] = $ar;
								
							}
						}
						
						
					}
					else
					{
						echo "Active Date Not Found";
					}
				}
				else
				{
					echo "Event Id Not found";
				}
		 
		    

		 }
		 $status = array("status"=>$arr,"data"=>$myArray);
		 $json2 = json_encode($status);
		 echo $json2;
		}
		else{
			$arr = array("status"=>"F","message"=>"Token Mismatch");
			$json = json_encode($arr);
			echo $json;
		}
			     
			     
				
	}
	public function changepassword(Request $request)
	{
		$userpin =$request->get('userPin');
		$token =$request->get('token');
		$newpassword =$request->get('newPass');
		$oldpassword = $request->get('oldPass');
		$sql = DB::table('mnwv2.user')->where('user_pin',$userpin)->where('session_data',$token)->get();
		if($sql->isEmpty())
		{
			 $status = array("status"=>"Failed","message"=>"No found userpin!!");
		     $json2 = json_encode($status);
		     echo $json2;
		}
		else
		{
			$pass = $sql[0]->password;
			if($pass ==$oldpassword)
			{
				$passchange = DB::table('mnwv2.user')->where('user_pin',$userpin)->where('session_data',$token)->update(['password' =>$newpassword]);
				$status = array("status"=>"success","message"=>"Password Change Successfully!!");
				$json2 = json_encode($status);
				echo $json2;
			}
			else
			{
				$status = array("status"=>"Failed","message"=>"Password Not Match! Please Try Again!!");
		        $json2 = json_encode($status);
		        echo $json2;
			}
			
			
		}
	}
	public function Download_data(Request $request)
	{
		$eventid='';
		$mno='';
		$secid=0;
		$callerid=0;
		$eventid = $request->get('eventid');
		$lasttime= $request->get('lastDownload');
		$token  = $request->get('token');
		$mno = $request->get('monitorNo');
		$secid = $request->get('sectionNo');
		$callerid = $request->get('caller');
		$data = array();
		$data1=array();
		if($mno =='')
		{
			
			$event = DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('monitorno',$callerid)->get(); 
			$data['servey_data'] = $event;
		}
		if(empty($event))
		{
			
			$data['servey_data']=[];
		}
		$date = DB::select( DB::raw("select now() as time") );
		if(empty($date))
		{
			$date = "";
		}
		else{
			$date = $date[0]->time;
		}
		if($mno =='')
		{
			//echo $mno;
			$respondent = DB::select( DB::raw("select * from mnwv2.respondents where event_id='$eventid'") );
			//var_dump($respondent);
			$data['respondents'] = $respondent;
			
		}
		else if($mno !='' and $callerid !=$mno)
		{
			$respondent = DB::select( DB::raw("select * from mnwv2.respondents where event_id='$eventid' and monitorno='$mno' and time > '$lasttime'") );
			$data['respondents'] = $respondent;
			
		}
		if(empty($respondent))
		{
		
			$data['respondents'] =[];
		}
		if($callerid !=0)
		{
			//echo $callerid;
			$deleterespondent = DB::select( DB::raw("select event_id,monitorno,deleteid from mnwv2.delete_respondents where event_id='$eventid' and monitorno !='$callerid'") );
			$data['delete_respondents'] = $deleterespondent;
			
			$deleterespondent1 = DB::select( DB::raw("delete from mnwv2.delete_respondents where event_id='$eventid' and monitorno !='$callerid'") );
		}
		if(empty($deleterespondent))
		{
			$data['delete_respondents'] =[];
		}
		$status = array("status"=>"success","lastDownloadTime"=>$date,"data"=>$data);
		$json2 = json_encode($status);
		echo $json2;
		
	}
	public function sendDataChanged($eventId, $monitorNo)
	{
		$res = array();
			$res['eventid'] = $eventId;
			$res['monitorno'] = $monitorNo;
			$res['command'] = "dataReceived";
			$res['timestamp'] = date('Y-m-d H:i:s');
			$data['data'] = $res;
			$topic = "EVNT".$eventId;
			$this->sendToTopic($topic,$data);
	}
	public function sendToTopic($to, $message) {
        $fields = array(
            'to' => '/topics/'.$to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }
    public function sendPushNotification($fields) {
		//define('FIREBASE_API_KEY', 'AAAAAehTCwo:APA91bHE2R70FRVrx_WsEbEnal_AGn8MtyFhfxyyv51bh_9xm85eANaV8OoBPdeA0QUVl9umLY-gfILnAFu6GLSMeB6zTHY2v5aUbo2iXzkX6nnaRD1lqTAPjOCVvZwHZ9MP7wyDUere');
		//var_dump($fields);
            // Set POST variables
		$FIREBASE_API_KEY = 'AAAAAehTCwo:APA91bHE2R70FRVrx_WsEbEnal_AGn8MtyFhfxyyv51bh_9xm85eANaV8OoBPdeA0QUVl9umLY-gfILnAFu6GLSMeB6zTHY2v5aUbo2iXzkX6nnaRD1lqTAPjOCVvZwHZ9MP7wyDUere';
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        $headers = array(
            'Authorization: key=' . $FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
		//echo $result;
        return $result;
    }
}
