<?php

error_reporting(0);
set_time_limit(600);
$roll=0;
if(Session::has('roll'))
{
	$roll = Session::get('roll');
}

if($roll=='1')
{
	// echo $roll;
	// die;
	$br = 0;
	if(Session::has('asid'))
	{
		$br = Session::get('asid');
	}
	MainLoop($br);
}
else if($roll=='2')
{
	if(Session::has('asid'))
	{
		$areaid = Session::get('asid');
	}
	GetDataFromArea($areaid);
}
else if($roll=='3')
{
	if(Session::has('asid'))
	{
		$regionid = Session::get('asid');
	}
	GetDataFromRegion($regionid);
}
else if($roll=='4')
{
	if(Session::has('asid'))
	{
		$divisionid = Session::get('asid');
	}
	GetDataFromDivision($divisionid);
}
else
{
	GetDataFromAdmin();
}

function GetDataFromArea($areaid)
{
	$getarea = DB::table('mnwv2.monitorevents')->where('area_id',$areaid)->get();

	if($getarea->isEmpty())
	{

	}
	else
	{
		foreach ($getarea as $row) {
			$br = $row->branchcode;
			if($brcount=strlen($br)=='3')
			{
				$br = '0'.$br;
			}
			MainLoop($br);
		}
	}
}
function GetDataFromRegion($regionid)
{
	$getregion = DB::table('mnwv2.monitorevents')->select('area_id')->where('region_id',$regionid)->groupBy('area_id')->get();
	if($getregion->isEmpty())
	{

	}
	else
	{
		foreach ($getregion as $row) {
			$areaid = $row->area_id;
			GetDataFromArea($areaid);
		}
	}
}
function GetDataFromDivision($divisionid)
{
	$getdivision = DB::table('mnwv2.monitorevents')->select('region_id')->where('division_id',$divisionid)->groupBy('region_id')->get();
	if($getdivision->isEmpty())
	{

	}
	else
	{
		foreach ($getdivision as $row) {
			$regionid = $row->region_id;
			GetDataFromRegion($regionid);
		}
	}
}
function GetDataFromAdmin()
{
	$getadmin = DB::table('mnwv2.monitorevents')->select('division_id')->groupBy('division_id')->get();
	if($getadmin->isEmpty())
	{

	}
	else
	{
		foreach ($getadmin as $row) {
			$divisionid = $row->division_id;
			GetDataFromDivision($divisionid);
		}
	}
}
function MainLoop($br)
{
	$cur_date = date('Y-m-d');
	$checkclosed =DB::table('mnwv2.monitorevents')->where('branchcode',$br)->where('dateend','<',$cur_date)->get();
	
	if($checkclosed->isEmpty())
	{
		
	}
	else
	{
		foreach ($checkclosed as $closed) {
			$processdate =$closed->processing_date;
			$event_id = $closed->id;
			$brcode = $closed->branchcode;

			$checksurveydate = DB::select( DB::raw("select * from mnwv2.survey_data where event_id='$event_id' and cast(time as date) >= cast('$processdate' as date)")); // if survey date time > monitorevents table of processing date 

			if(empty($checksurveydate))
			{
				
			}
			else
			{
				foreach ($checksurveydate as $row) 
				{
				    $eventid = $row->event_id;
					$secid= $row->sec_no;
					$score = $row->score;
					$question = $row->question;
					$sub_sec_id= $row->sub_sec_id;
					$orgno= $row->orgno;
					$monitorno = $row->monitorno;
					if($secid=='1')
					{
						SectionOne($eventid,$secid,$question,$sub_sec_id,$orgno,$monitorno,$brcode);
					}
					else if($secid=='2')
					{
						SectionTwo($eventid,$secid,$question,$sub_sec_id,$orgno,$monitorno,$brcode);
					}
					else if($secid=='3')
					{
						SectionThree($eventid,$secid,$question,$sub_sec_id,$orgno,$monitorno,$brcode);
					}
					else if($secid=='4')
					{
						SectionFour($eventid,$secid,$question,$sub_sec_id,$orgno,$monitorno,$brcode);
					}
					else if($secid=='5')
					{
						SectionFive($eventid,$secid,$question,$sub_sec_id,$orgno,$monitorno,$brcode);
					}

				}
				UpdateScoreDatabase($brcode,$event_id);	
			}	
		}
	}
}
function UpdateScoreDatabase($brcode,$event_id)
{

	//$allpoint = DB::select( DB::raw("select * from mnwv2.cal_section_point where branchcode='$brcode' and event_id='$event_id'"));
	$allpoint = DB::table('mnwv2.cal_section_point')->where('event_id',$event_id)->where('branchcode',$brcode)->get();		

	if($allpoint->isEmpty())
	{

	}
	else
	{
		$tpoint=0;
		$time = date('Y-m-d');
		foreach ($allpoint as $data) 
		{
			$event = $data->event_id;
			$sec = $data->section;
			$brnch = $data->branchcode;
			/*if($sec==1)
			{*/
				//$checkscorepoint =DB::select( DB::raw("select * from mnwv2.cal_sections_score where branchcode='$brnch' and event_id='$event' and sec_no='$sec'"));

				$checkscorepoint = DB::table('mnwv2.cal_sections_score')->where('event_id',$event)->where('branchcode',$brnch)->where('sec_no',$sec)->get();

			    if($checkscorepoint->isEmpty())
			    {

					//$countsectionpoint =DB::select( DB::raw("select sum(point) as point,sum(question_point) as fullscore from mnwv2.cal_section_point where branchcode='$brnch' and event_id='$event' and section='$sec'"));
					
					$countsectionpoint =DB::table('mnwv2.cal_section_point')->selectRaw('sum(point) as point,sum(question_point) as fullscore')->where('event_id',$event)->where('section',$sec)->where('branchcode',$brnch)->get();

			    	if($countsectionpoint->isEmpty())
			    	{

			    	}
			    	else
			    	{
			    		
			    		$totalpoint = $countsectionpoint[0]->point;
			    		$fullscore = $countsectionpoint[0]->fullscore;
						//$sec1scoring = DB::select( DB::raw("select * from mnwv2.def_scoring where sec_no='$sec'"));

						$sec1scoring =DB::table('mnwv2.def_scoring')->where('sec_no',$sec)->get();

						 if($sec1scoring->isEmpty())
						 {
							 //echo "No Found Data";
						 }
						 else
						 {
							 //$fullscore = $sec1scoring[0]->fullscore;
							 $weight = $sec1scoring[0]->weight;
						 }
						 if($fullscore > 0)
						 {
                            $sec1point = ($totalpoint/$fullscore)*$weight;
						 }
						 else
						 {
                            $sec1point =0;
						 }
						 
		    		     $sec1calsection = DB::table('mnwv2.cal_sections_score')->insert(['branchcode' =>$brnch,'sec_no'=>$sec,'total'=>$totalpoint,'score'=>$sec1point,'event_id'=>$event]);
		    		    
			    	}
			    }
			    else
			    {

			    	$id=$checkscorepoint[0]->id;
			    	$time = date('Y-m-d');
			    	$fullscore=0;
					//$countsectionpoint =DB::select( DB::raw("select sum(point) as point,sum(question_point) as fullscore from mnwv2.cal_section_point where branchcode='$brnch' and event_id='$event' and section='$sec'"));
					
					$countsectionpoint =DB::table('mnwv2.cal_section_point')->selectRaw('sum(point) as point,sum(question_point) as fullscore')->where('event_id',$event)->where('section',$sec)->where('branchcode',$brnch)->get();
			    	if($countsectionpoint->isEmpty())
			    	{

			    	}
			    	else
			    	{
			    		//$tpoint=0;
			    		$totalpoint = $countsectionpoint[0]->point;
			    		$fullscore = $countsectionpoint[0]->fullscore;
						//$sec1scoring = DB::select( DB::raw("select * from mnwv2.def_scoring where sec_no='$sec'"));

						$sec1scoring =DB::table('mnwv2.def_scoring')->where('sec_no',$sec)->get();

						 if($sec1scoring->isEmpty())
						 {
							 //echo "No Found Data";
						 }
						 else
						 {
							 //$fullscore = $sec1scoring[0]->fullscore;
							 $weight = $sec1scoring[0]->weight;
						 }
						 if($fullscore >0)
						 {
						 	$sec1point = ($totalpoint/$fullscore)*$weight;
						 }
						 else
						 {
						 	$sec1point=0;
						 }
						 

		    		     $sec1calsection = DB::table('mnwv2.cal_sections_score')->where('id',$id)->update(['branchcode' =>$brnch,'sec_no'=>$sec,'total'=>$totalpoint,'score'=>$sec1point,'event_id'=>$event]);
			    	}
			    }
			//}
		}
		//$allscorecount =DB::select( DB::raw("select * from mnwv2.cal_sections_score where branchcode='$brnch' and event_id='$event'"));
		
		$allscorecount =DB::table('mnwv2.cal_sections_score')->where('branchcode',$brnch)->where('event_id',$event)->get();
		
		if($allscorecount->isEmpty())
		{

		}
		else
		{
			foreach ($allscorecount as $key) 
			{
				$tpoint += $key->score;
			}
			$time = date('Y-m-d');
			//$point = $allscorecount[0]->tpoint;
			$updatemonitorevents = DB::table('mnwv2.monitorevents')->where('id',$event)->update(['processing_date'=>$time,'score'=>$tpoint]);
		}
	}
}
function SectionOne($eventid,$secid,$question,$sub_sec_id,$orgno,$monitorno,$brcode)
{
	$score =0;
	$sec1 =DB::table('mnwv2.cal_section_point')->where('branchcode',$brcode)->where('event_id',$eventid)->where('section',$secid)->where('qno',$question)->get();
	if($sec1->isEmpty())
	{
		$sec1_survey =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('question',$question)->where('sec_no',$secid)->get();
		
		if(!empty($sec1_survey))
		{
			$score = $sec1_survey[0]->score;
			if($question == 1)
			{
				if($score >='4')
				{
					$p = 6;
				}
				else if($score =='3')
				{
					$p = 4;
				}
				else if($score =='2')
				{
					$p = 2;
				}
				else
				{
					$p =0;
				}
			}
			else{
				if($score >='3')
				{
					$p = 6;
				}
				else if($score =='2')
				{
					$p = 4;
				}
				else if($score =='1')
				{
					$p = 2;
				}
				else
				{
					$p =0;
				}
			}
			$question_point = 6;

			$sec1_insert = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$question,'sub_id'=>$question,'question_point'=>$question_point]);
		}	
	}
	else
	{
		$id = $sec1[0]->id;

		$update_sec1_survey =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('question',$question)->where('sec_no',$secid)->get();
		if(!$update_sec1_survey->isEmpty())
		{
			$update_score = $update_sec1_survey[0]->score;
			if($question == 1)
			{
				if($update_score >='4')
				{
					$p = 6;
				}
				else if($update_score =='3')
				{
					$p = 4;
				}
				else if($update_score =='2')
				{
					$p = 2;
				}
				else
				{
					$p =0;
				}
			}
			else{
				if($update_score >='3')
				{
					$p = 6;
				}
				else if($update_score =='2')
				{
					$p = 4;
				}
				else if($update_score =='1')
				{
					$p = 2;
				}
				else
				{
					$p =0;
				}
			}
			$question_point = 6;

			$update_sec1_insert = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$question,'question_point'=>$question_point,'sub_id'=>$question]);
		}
	}
}
function SectionTwo($eventid,$secid,$question,$sub_sec_id,$orgno,$monitorno,$brcode)
{
	$sec2 =DB::table('mnwv2.cal_section_point')->where('branchcode',$brcode)->where('event_id',$eventid)->where('section',$secid)->where('sub_sec_id',$sub_sec_id)->get();
	if($sec2->isEmpty())
	{
		if($sub_sec_id =='1')
		{
			
			$sec2_survey1 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,orgmemno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgmemno')->get();
			if(!$sec2_survey1->isEmpty())
			{
				$value =0;
				foreach ($sec2_survey1 as $row) {
					$score = $row->score;
					if($score >='3')
					{
						$value +=1; 
					}
				}
				if($value >='3')
				{
					$p =6;
				}
				else if($value =='2')
				{
					$p = 4;

				}
				else if($value=='1')
				{
					$p = 2;
				}
				else
				{
					$p= 0;
				}
				$question_point = 6;

			    $sec1_insert = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id =='2')
		{
			$sec2_survey2 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,orgmemno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgmemno')->get();
			if(!$sec2_survey2->isEmpty())
			{
				$value =0;
				foreach ($sec2_survey2 as $row) {
					$score = $row->score;
					if($score >='2')
					{
						$value +=1; 
					}
				}
				if($value >='3')
				{
					$p =6;
				}
				else if($value =='2')
				{
					$p = 4;

				}
				else if($value=='1')
				{
					$p = 2;
				}
				else
				{
					$p= 0;
				}
				$question_point = 6;

			    $sec1_insert = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='3')
		{
		
			$sec2_survey3 =DB::table('mnwv2.survey_data')->selectRaw('count(*) as cnt, sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec2_survey3->isEmpty())
			{
				$cnt = $sec2_survey3[0]->cnt;
				$score = $sec2_survey3[0]->score;
				if($cnt==$score)
				{
					$p=12;
				}
				else
				{
					$p=0;
				}
				$question_point = 12;
			    $sec1_insert = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if(($sub_sec_id=='4') or ($sub_sec_id='5'))
		{
			$sec2_survey4 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,orgmemno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgmemno')->get();
			if(!$sec2_survey4->isEmpty())
			{
				//$score = $sec2_survey4[0]->score;
				$value =0;
				foreach ($sec2_survey4 as $row) {
					$score = $row->score;
					if($score >='2')
					{
						$value +=1; 
					}	
				}
				if($value >='12')
				{
					$p = 6;
				}
				else if($value >='8' and $value <='11')
				{
					$p = 4;
				}
				else if($value >='6' and $value <='7')
				{
					$p = 2;
				}
				else
				{
					$p = 0;
				}
				$question_point = 6;

			    $sec1_insert = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
	}
	else
	{
		$id = $sec2[0]->id;
		if($sub_sec_id =='1')
		{
			$sec2_survey1 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,orgmemno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgmemno')->get();
			if(!$sec2_survey1->isEmpty())
			{
				$value =0;
				foreach ($sec2_survey1 as $row) {
					$score = $row->score;
					if($score >='3')
					{
						$value +=1; 
					}
				}
				if($value >='3')
				{
					$p =6;
				}
				else if($value =='2')
				{
					$p = 4;

				}
				else if($value=='1')
				{
					$p = 2;
				}
				else
				{
					$p= 0;
				}
				$question_point = 6;

			    $sec1_insert = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id =='2')
		{
			$sec2_survey2 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,orgmemno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgmemno')->get();

			if(!$sec2_survey2->isEmpty())
			{
				$value =0;
				foreach ($sec2_survey2 as $row) {
					$score = $row->score;
					if($score >='2')
					{
						$value +=1; 
					}
				}
				if($value >='3')
				{
					$p =6;
				}
				else if($value =='2')
				{
					$p = 4;

				}
				else if($value=='1')
				{
					$p = 2;
				}
				else
				{
					$p= 0;
				}
				$question_point = 6;

			    $sec1_insert = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='3')
		{
		
			$sec2_survey3 =DB::table('mnwv2.survey_data')->selectRaw('count(*) as cnt,sum(score) as score,orgmemno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgmemno')->get();
			if(!$sec2_survey3->isEmpty())
			{
				$cnt = $sec2_survey3[0]->cnt;
				$score = $sec2_survey3[0]->score;
				if($cnt==$score)
				{
					$p=12;
				}
				else
				{
					$p=0;
				}
				$question_point = 12;

			    $sec1_insert = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if(($sub_sec_id=='4') or ($sub_sec_id='5'))
		{
			$sec2_survey4 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,orgmemno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgmemno')->get();
			if(!$sec2_survey4->isEmpty())
			{
				//$score = $sec2_survey4[0]->score;
				$value =0;
				foreach ($sec2_survey4 as $row) {
					$score = $row->score;
					if($score >='2')
					{
						$value +=1; 
					}	
				}
				if($value >='12')
				{
					$p = 6;
				}
				else if($value >='8' and $value <='11')
				{
					$p = 4;
				}
				else if($value >='6' and $value <='7')
				{
					$p = 2;
				}
				else
				{
					$p = 0;
				}
				$question_point = 6;

			    $sec1_insert = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
	}
}
function SectionThree($eventid,$secid,$question,$sub_sec_id,$orgno,$monitorno,$brcode)
{
	$tscore =0;
	$sec3 =DB::table('mnwv2.cal_section_point')->where('branchcode',$brcode)->where('event_id',$eventid)->where('section',$secid)->where('sub_sec_id',$sub_sec_id)->get();
	if($sec3->isEmpty())
	{
		if(($sub_sec_id=='1') or ($sub_sec_id=='6'))
		{
			
			$sec3_survey1 =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec3_survey1->isEmpty())
			{
				$fst = 0;
				$snd =0;
				$tscore =0;
				foreach ($sec3_survey1 as $r) 
				{
					$question = $r->question;
					if($question == '1')
					{
						$fst = $r->score;
					}
					else if($question=='2')
					{
						$snd = $r->score;
					}
				}
				if($fst > 0)
				{
					$tscore = ($snd*100)/$fst;
					
				}

				if($tscore >='80')
				{
					$p = 6;
				}
				else if($tscore>='60' and $tscore <='79')
				{
					$p = 4;
				}
				else
				{
					$p =2;
				}
				$question_point = 6;

			    $sec3_insert1 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='2')
		{
			$score =0;
			$sec3_survey2 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sub_sec_id',$sub_sec_id)->where('sec_no',$secid)->get();
			if(!$sec3_survey2->isEmpty())
			{
				$score = $sec3_survey2[0]->score;
				if($score =='3')
				{
					$p = 6;
				}
				else if($score =='2')
				{
					$p = 4;
				}
				else if($score=='1')
				{
					$p = 2;
				}
				else
				{
					$p = 0;
				}
				$question_point = 6;

			    $sec3_insert2 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='3')
		{
	
			$sec3_survey3 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,orgmemno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgmemno')->get();
			if(!$sec3_survey3->isEmpty())
			{
				$value=0;
				foreach ($sec3_survey3 as $r) 
				{
					$cnt = $r->score;
					if($cnt=='3')
					{
						$value +=1;
					}
				}
				if($value >='3')
				{
					$p=6;
				}
				else if($value=='2')
				{
					$p=4;
				}
				else if($value=='1')
				{
					$p =2;
				}
				else
				{
					$p =0;
				}
				$question_point = 6;

			    $sec3_insert3 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}

		}
		else if($sub_sec_id=='4')
		{
		
			$sec3_survey4 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sub_sec_id',$sub_sec_id)->where('sec_no',$secid)->get();
			if(!$sec3_survey4->isEmpty())
			{
				$value=0;
				$value = $sec3_survey4[0]->score;
				if($value >='3')
				{
					$p=6;
				}
				else if($value=='2')
				{
					$p=4;
				}
				else if($value=='1')
				{
					$p =2;
				}
				else
				{
					$p =0;
				}
				$question_point = 6;

			    $sec3_insert4 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='5')
		{
			$sec3_survey5 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sub_sec_id',$sub_sec_id)->where('sec_no',$secid)->get();
			if(!$sec3_survey5->isEmpty())
			{
				$value=0;
				$value = $sec3_survey5[0]->score;
				if($value >='3')
				{
					$p=9;
				}
				else if($value=='2')
				{
					$p=6;
				}
				else if($value=='1')
				{
					$p =3;
				}
				else
				{
					$p =0;
				}
				$question_point = 9;

			    $sec3_insert5 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='8')
		{

			$sec3_survey8 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sub_sec_id',$sub_sec_id)->where('sec_no',$secid)->get();
			if(!$sec3_survey8->isEmpty())
			{
				$value=0;
				$value = $sec3_survey8[0]->score;
				if($value >='4')
				{
					$p=6;
				}
				else if($value=='3')
				{
					$p=4;
				}
				else if($value=='2')
				{
					$p =2;
				}
				else
				{
					$p =0;
				}
				$question_point = 6;

			    $sec3_insert8 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='9')
		{
			$sec3_survey9 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sub_sec_id',$sub_sec_id)->where('sec_no',$secid)->get();
			if(!$sec3_survey9->isEmpty())
			{
				$value=0;
				$value = $sec3_survey9[0]->score;
				if($value >='3')
				{
					$p=6;
				}
				else if($value=='2')
				{
					$p=4;
				}
				else if($value=='1')
				{
					$p =2;
				}
				else
				{
					$p =0;
				}
				$question_point = 6;

			    $sec3_insert8 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
	} //if condition 3 end
	else
	{
		$id = $sec3[0]->id;

		if(($sub_sec_id=='1') or ($sub_sec_id=='6'))
		{
	
			$sec3_survey1 =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sub_sec_id',$sub_sec_id)->where('sec_no',$secid)->get();

			if(!$sec3_survey1->isEmpty())
			{
				$fst = 0;
				$snd =0;
				$tscore =0;
				foreach ($sec3_survey1 as $r) 
				{
					$question = $r->question;
					if($question == '1')
					{
						$fst = $r->score;
					}
					else if($question=='2')
					{
						$snd = $r->score;
					}
				}
				if($fst > 0 and $snd > 0)
				{
					$tscore = ($snd*100)/$fst;
				}
				if($tscore >='80')
				{
					$p = 6;
				}
				else if($tscore>='60' and $tscore <='79')
				{
					$p = 4;
				}
				else
				{
					$p =2;
				}
				$question_point = 6;

			    $sec3_insert1 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='2')
		{
			$score =0;
			//$sec3_survey2 = DB::select( DB::raw("select sum(score) as score from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));

			$sec3_survey2 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec3_survey2->isEmpty())
			{
				$score = $sec3_survey2[0]->score;
				if($score =='3')
				{
					$p = 6;
				}
				else if($score =='2')
				{
					$p = 4;
				}
				else if($score=='1')
				{
					$p = 2;
				}
				else
				{
					$p = 0;
				}
				$question_point = 6;

			    $sec3_insert2 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='3')
		{
			

			$sec3_survey3 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,orgmemno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgmemno')->get();
			if(!$sec3_survey3->isEmpty())
			{
				$value=0;
				foreach ($sec3_survey3 as $r) 
				{
					$cnt = $r->score;
					if($cnt=='3')
					{
						$value +=1;
					}
				}
				if($value >='3')
				{
					$p=6;
				}
				else if($value=='2')
				{
					$p=4;
				}
				else if($value=='1')
				{
					$p =2;
				}
				else
				{
					$p =0;
				}
				$question_point = 6;

			    $sec3_insert3 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}

		}
		else if($sub_sec_id=='4')
		{
		
			$sec3_survey4 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();

			if(!$sec3_survey4->isEmpty())
			{
				$value=0;
				$value = $sec3_survey4[0]->score;
				if($value >='3')
				{
					$p=6;
				}
				else if($value=='2')
				{
					$p=4;
				}
				else if($value=='1')
				{
					$p =2;
				}
				else
				{
					$p =0;
				}
				$question_point = 6;

			    $sec3_insert4 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='5')
		{
		
			$sec3_survey5 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec3_survey5->isEmpty())
			{
				$value=0;
				$value = $sec3_survey5[0]->score;
				if($value >='3')
				{
					$p=9;
				}
				else if($value=='2')
				{
					$p=6;
				}
				else if($value=='1')
				{
					$p =3;
				}
				else
				{
					$p =0;
				}
				$question_point = 9;

			    $sec3_insert5 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='8')
		{
		
			$sec3_survey8 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec3_survey8->isEmpty())
			{
				$value=0;
				$value = $sec3_survey8[0]->score;
				if($value >='4')
				{
					$p=6;
				}
				else if($value=='3')
				{
					$p=4;
				}
				else if($value=='2')
				{
					$p =2;
				}
				else
				{
					$p =0;
				}
				$question_point = 6;

			    $sec3_insert8 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='9')
		{
		
			$sec3_survey9 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec3_survey9->isEmpty())
			{
				$value=0;
				$value = $sec3_survey9[0]->score;
				if($value >='3')
				{
					$p=6;
				}
				else if($value=='2')
				{
					$p=4;
				}
				else if($value=='1')
				{
					$p =2;
				}
				else
				{
					$p =0;
				}
				$question_point = 6;

			    $sec3_insert9 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
	}
}
function SectionFour($eventid,$secid,$question,$sub_sec_id,$orgno,$monitorno,$brcode)
{
	$sec4 =DB::table('mnwv2.cal_section_point')->where('branchcode',$brcode)->where('event_id',$eventid)->where('section',$secid)->where('sub_sec_id',$sub_sec_id)->get();
	if($sec4->isEmpty())
	{
		if($sub_sec_id=='1')
		{
		
			$sec4_survey1 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec4_survey1->isEmpty())
			{
				$value=0;
				$value = $sec4_survey1[0]->score;
				if($value >='3')
				{
					$p=6;
				}
				else if($value=='2')
				{
					$p=4;
				}
				else if($value=='1')
				{
					$p =2;
				}
				else
				{
					$p =0;
				}
				$question_point = 6;
			    $sec4_insert1 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='2')
		{
		
			$sec4_survey2 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,orgno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgno')->get();
			if(!$sec4_survey2->isEmpty())
			{
				$value=0;
				$torg =0;
				foreach ($sec4_survey2 as $rows) 
				{
					$score = $rows->score;
					if($score >='4')
					{
						$value +=1;
					}
					$torg +=1;
				}
				if($torg >=4)
				{
					if($value >='4')
					{
						$p=9;
					}
					else 
					{
						$p=0;
					}
				}
				else if($torg==3)
				{
					if($value=='3')
					{
						$p=6;
					}
					else 
					{
						$p=0;
					}
				}
				else if($torg=='2')
				{
					if($value=='2')
					{
						$p =3;
					}
					else 
					{
						$p=0;
					}
				}
				else
				{
					$p =0;
				}
				$question_point = 9;

			    $sec4_insert2 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='3')
		{
			$sec4_survey3 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,orgno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgno')->get();

			if(!$sec4_survey3->isEmpty())
			{
				$value=0;
				$torg =0;
				foreach ($sec4_survey3 as $rows) 
				{
					$score = $rows->score;
					if($score >='3')
					{
						$value +=1;
					}
					$torg +=1;
				}
				if($torg >=4)
				{
					if($value >='4')
					{
						$p=6;
					}
					else 
					{
						$p=0;
					}
				}
				else if($torg==3)
				{
					if($value=='3')
					{
						$p=4;
					}
					else 
					{
						$p=0;
					}
				}
				else if($torg=='2')
				{
					if($value=='2')
					{
						$p =2;
					}
					else 
					{
						$p=0;
					}
				}
				else
				{
					$p =0;
				}
				$question_point = 6;
			    $sec4_insert3 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='4')
		{
			$sec4_survey4 =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec4_survey4->isEmpty())
			{
				$fst = 0;
				$snd =0;
				$tscore =0;
				foreach ($sec4_survey4 as $r) 
				{
					$question = $r->question;
					if($question == '1')
					{
						$fst = $r->score;
					}
					else if($question=='2')
					{
						$snd = $r->score;
					}
				}
				if($snd > 0)
				{
					$tscore = ($snd*100)/$fst;
				}
				//echo $tscore."/";
				if($tscore >='95')
				{
					$p = 9;
				}
				else if($tscore >='90' and $tscore < '95')
				{
					$p = 6;
				}
				else if($tscore >='85' and $tscore < '90')
				{
					$p = 3;
				}
				else
				{
					$p =0;
				}
				$question_point = 9;

			    $sec4_insert4 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='5')
		{
			$org=0;
			$val4=0;
			$q1=0;
			$tround=0;
			$tround2=0;
			$tround3=0;
			$tround5=0;
			$totalvaluem1 =0;
			$val =0;
			$val2 =0;
			$val3 =0;
			$val4 =0;
			$sec4_survey5 =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id','4')->where('monitorno','1')->orderBy('orgno')->get();
			if($sec4_survey5->isEmpty())
			{

			}
			else
			{
				foreach ($sec4_survey5 as $r) 
				{
					$qno = $r->question;
					if($qno=='2')
					{
						$scors = $r->score;
						$org = $r->orgno;
						$sec4b =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id','5')->where('orgno',$org)->get();
						if($sec4b->isEmpty())
						{

						}
						else
						{
							foreach ($sec4b as $k) 
							{
								$qn = $k->question;
								if($qn=='1')
								{
									$q1 = $k->score;
								}
								else if($qn=='2')
								{
									$q2 = $k->score;
									if($q1 >0)
									{
										$top1=$q2*100.0/$q1;
										$tround = round($top1,2);
										//echo $tround.'-';
										if($tround >=100)
										{
											$val = 1;
										}
										else
										{
											$val = 0;
										}
										//echo $val.'-';
									}
								}
								else if($qn=='3')
								{
									$q3 = $k->score;
									if($scors >0)
									{
										$top2 = $q3*100/$scors;
										$tround2 = round($top2,2);
										//echo $tround2.'-';
										if($tround2 >=100)
										{
											$val2 = 1;
										}
										else
										{
											$val2 = 0;
										}
										//echo $val2.'-';
									}
								}
								else if($qn=='4')
								{
									$q4 = $k->score;
									if($q1 >0)
									{
										$top3 = $q4*100/$q1;
										$tround3 = round($top3,2);
										//echo $tround3.'-';
										if($tround3 >=80)
										{
											$val3 = 1;
										}
										else
										{
											$val3 = 0;
										}
										//echo $val3.'-';
									}
								}
								else if($qn=='5')
								{
									$q5 = $k->score;
									if($q1 >0)
									{
										$top4 = $q5*100/$q1;
										$tround5 = round($top4,2);
										//echo $tround5.'-';
										if($tround5 >=80)
										{
											$val4 = 1;
										}
										else
										{
											$val4 = 0;
										}
										//echo $val4.'/';
									}
								}

							}
						}
					}

				}
				$totalvaluem1 =  $val+$val2+$val3+$val4;
				//echo $totalvaluem1."-";
			}
			$org=0;
			$toVO=0;
			$val5=0;
			$val6=0;
			$val7=0;
			$val8=0;
			$totalvaluem2 =0;
			$totl=0;

			$sec4_survey4b2 =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id','4')->where('monitorno','2')->orderBy('orgno')->get();

			if($sec4_survey4b2->isEmpty())
			{

			}
			else
			{
				foreach ($sec4_survey4b2 as $r) 
				{
					$qno = $r->question;
					if($qno=='2')
					{
						$scors = $r->score;
						$org = $r->orgno;
						$toVO++;
					
						$sec4bc =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id','5')->where('orgno',$orgno)->get();

						if($sec4bc->isEmpty())
						{

						}
						else
						{
							foreach ($sec4bc as $k) 
							{
								$qn = $k->question;
								if($qn=='1')
								{
									$q1 = $k->score;
								}
								else if($qn=='2')
								{
									$q2 = $k->score;
									if($q1 >0)
									{
										$top1=$q2*100.0/$q1;
										$tround = round($top1,2);
										//echo $tround.'-';
										if($tround >=100)
										{
											$val5 += 1;
										}
										else
										{
											$val5 = 0;
										}
										//echo $val5.'-'.$org.'-';
									}
								}
								else if($qn=='3')
								{
									$q3 = $k->score;
									if($scors >0)
									{
										$top2 = $q3*100/$scors;
										$tround2 = round($top2,2);
										//echo $tround2.'-';
										if($tround2 >=100)
										{
											$val6 += 1;
										}
										else
										{
											$val6 = 0;
										}
										//echo $val6.'-'.$org.'-';
									}
								}
								else if($qn=='4')
								{
									$q4 = $k->score;
									if($q1 >0)
									{
										$top3 = $q4*100/$q1;
										$tround3 = round($top3,2);
										//echo $tround3.'-';
										if($tround3 >=80)
										{
											$val7 += 1;
										}
										else
										{
											$val7 = 0;
										}
										//echo $val7.'-'.$org.'-';
									}
								}
								else if($qn=='5')
								{
									$q5 = $k->score;
									if($q1 >0)
									{
										$top4 = $q5*100/$q1;
										$tround5 = round($top4,2);
										//echo $tround5.'-';
										if($tround5 >=80)
										{
											$val8 += 1;
										}
										else
										{
											$val8 = 0;
										}
										//echo $val8.'-'.$org.'/';
									}
								}

							}
						}
				    }
				}
				$totalvaluem2 =  $val5+$val6+$val7+$val8;
				//$tom2 = $totalvaluem2/$toVO;
				//echo $totalvaluem2."*";
				$allvalue= $totalvaluem1+$totalvaluem2;
	            $totl = round($allvalue,2);
	            //echo $totl;
	            if($totl >='6')
	            {
	            	$p = 12;
	            } 
	            else if($totl >='5' and $totl < 6)
	            {
	            	$p = 8;
	            }
	            else if($totl=='4' and $totl < 5)
	            {
	            	$p=4;
	            }
	            else
	            {
	            	$p=0;
	            }
	            //echo $status;
	            $question_point = 12;

				$datacheck =DB::table('mnwv2.cal_section_point')->where('event_id',$eventid)->where('branchcode',$brcode)->where('section',$secid)->where('sub_sec_id',$sub_sec_id)->get();

				if($datacheck->isEmpty())
				{

			        $sec4_insert4 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
				}
				else
				{
					
					$id = $datacheck[0]->id;
					 $sec4_insert4 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
				}
			}
		}
		else if((($sub_sec_id=='6') or ($sub_sec_id=='7')) or (($sub_sec_id=='8') or ($sub_sec_id=='9')) or ($sub_sec_id=='10'))
		{
			
			$sec4_survey6 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec4_survey6->isEmpty())
			{
				$menno =0;
				$score =0;
				foreach($sec4_survey6 as $row)
				{
					$sc = $row->score;
					$score +=$sc;
					$menno +=1;
				}
				//$score = $sec4_survey6[0]->score;
				if($menno == $score)
				{
					$p =12;
				}
				else
				{
					$p=0;
				}
				$question_point = 12;
			    $sec4_insert4 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='11')
		{

			$sec4_survey11 =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();

			if(!$sec4_survey11->isEmpty())
			{
				$FinalMis=0;
				$Process =0;
				foreach ($sec4_survey11 as $r) 
				{
					$q1 = $r->question;
					if($q1=='1')
					{
						$FinalMis +=1;
					}
					else if($q1=='2')
					{
						$Process +=1;
					}
				}
				if($FinalMis >='5' and $Process >='4')
				{
					$p =12;
				}
				else if($FinalMis >='5' and $Process =='3')
				{
					$p =8;
				}
				else if($FinalMis >='5' and $Process =='2')
				{
					$p = 4;
				}
				else
				{
					$p =0;
				}
				$question_point = 12;
			    $sec4_insert4 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}	
	}
	else
	{
		$id = $sec4[0]->id;
		if($sub_sec_id=='1')
		{
			
			$sec4_survey1 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec4_survey1->isEmpty())
			{
				$value=0;
				$value = $sec4_survey1[0]->score;
				if($value >='3')
				{
					$p=6;
				}
				else if($value=='2')
				{
					$p=4;
				}
				else if($value=='1')
				{
					$p =2;
				}
				else
				{
					$p =0;
				}
				$question_point = 6;
			    $sec4_insert1 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='2')
		{
		
			$sec4_survey2 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,orgno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgno')->get();
			if(!$sec4_survey2->isEmpty())
			{
				$value=0;
				$torg =0;
				foreach ($sec4_survey2 as $rows) 
				{
					$score = $rows->score;
					if($score >='4')
					{
						$value +=1;
					}
					$torg +=1;
				}
				if($torg >=4)
				{
					if($value >='4')
					{
						$p=9;
					}
					else 
					{
						$p=0;
					}
				}
				else if($torg==3)
				{
					if($value=='3')
					{
						$p=6;
					}
					else 
					{
						$p=0;
					}
				}
				else if($torg=='2')
				{
					if($value=='2')
					{
						$p =3;
					}
					else 
					{
						$p=0;
					}
				}
				else
				{
					$p =0;
				}
				$question_point = 9;
			    $sec4_insert2 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='3')
		{
		
			$sec4_survey3 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,orgno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('orgno')->get();
			if(!$sec4_survey3->isEmpty())
			{
				$value=0;
				$torg =0;
				foreach ($sec4_survey3 as $rows) 
				{
					$score = $rows->score;
					if($score >='3')
					{
						$value +=1;
					}
					$torg +=1;
				}
				if($torg >=4)
				{
					if($value >='4')
					{
						$p=6;
					}
					else 
					{
						$p=0;
					}
				}
				else if($torg==3)
				{
					if($value=='3')
					{
						$p=4;
					}
					else 
					{
						$p=0;
					}
				}
				else if($torg=='2')
				{
					if($value=='2')
					{
						$p =2;
					}
					else 
					{
						$p=0;
					}
				}
				else
				{
					$p =0;
				}
				$question_point = 6;
			    $sec4_insert3 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='4')
		{
		
			$sec4_survey4 =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();

			if(!$sec4_survey4->isEmpty())
			{
				$fst = 0;
				$snd =0;
				$tscore =0;
				foreach ($sec4_survey4 as $r) 
				{
					$question = $r->question;
					if($question == '1')
					{
						$fst = $r->score;
					}
					else if($question=='2')
					{
						$snd = $r->score;
					}
				}
				if($snd > 0)
				{
					$tscore = ($snd*100)/$fst;
				}
			   // $tscore =89.09;
				if($tscore >='95')
				{
					$p = 9;
					//echo "Najmul";
				}
				else if($tscore >='90' and $tscore < '95')
				{
					$p = 6;
				}
				else if($tscore >='85' and $tscore < '90')
				{
					$p = 3;
					
				}
				else
				{
					$p =0;
				}
				$question_point = 9;
			    $sec4_insert4 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='5')
		{
			$org=0;
			$val4=0;
			$q1=0;
			$tround=0;
			$tround2=0;
			$tround3=0;
			$tround5=0;
			$totalvaluem1 =0;
			$val =0;
			$val2 =0;
			$val3 =0;
			$val4 =0;
			
			$sec4_survey5 =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id','4')->where('monitorno','1')->orderBy('orgno')->get();
			if($sec4_survey5->isEmpty())
			{

			}
			else
			{
				foreach ($sec4_survey5 as $r) 
				{
					$qno = $r->question;
					if($qno=='2')
					{
						$scors = $r->score;
						$org = $r->orgno;
					
						//$sec4b = DB::select( DB::raw("select * from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='5' and orgno='$org'"));

						$sec4b =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id','5')->where('orgno',$org)->get();
						if(empty($sec4b))
						{

						}
						else
						{
							foreach ($sec4b as $k) 
							{
								$qn = $k->question;
								if($qn=='1')
								{
									$q1 = $k->score;
									//echo $q1;
								}
								else if($qn=='2')
								{
									$q2 = $k->score;
									//echo $q2;
									if($q1 >0)
									{
										$top1=$q2*100.0/$q1;
										$tround = round($top1,2);
										//echo $tround.'-';
										if($tround >=100)
										{
											$val = 1;
										}
										else
										{
											$val = 0;
										}
										//echo $val.'-';
									}
								}
								else if($qn=='3')
								{
									$q3 = $k->score;
									if($scors >0)
									{
										$top2 = $q3*100/$scors;
										$tround2 = round($top2,2);
										//echo $tround2.'-';
										if($tround2 >=100)
										{
											$val2 = 1;
										}
										else
										{
											$val2 = 0;
										}
									    //echo $val2.'-';
									}
								}
								else if($qn=='4')
								{
									$q4 = $k->score;
									if($q1 >0)
									{
										$top3 = $q4*100/$q1;
										$tround3 = round($top3,2);
										//echo $tround3.'-';
										if($tround3 >=80)
										{
											$val3 = 1;
										}
										else
										{
											$val3 = 0;
										}
										//echo $val3.'-';
									}
								}
								else if($qn=='5')
								{
									$q5 = $k->score;
									if($q1 >0)
									{
										$top4 = $q5*100/$q1;
										$tround5 = round($top4,2);
										//echo $tround5.'-';
										if($tround5 >=80)
										{
											$val4 = 1;
										}
										else
										{
											$val4 = 0;
										}
										//echo $val4.'/';
									}
								}

							}
						}
					}

				}
				$totalvaluem1 =  $val+$val2+$val3+$val4;
				//echo $totalvaluem1;
			}
			$org=0;
			$toVO=0;
			$val5=0;
			$val6=0;
			$val7=0;
			$val8=0;
			$totalvaluem2 =0;
			$totl=0;
			
			$sec4_survey4b2 =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id','4')->where('monitorno','2')->orderBy('orgno')->get();
			if($sec4_survey4b2->isEmpty())
			{

			}
			else
			{
				foreach ($sec4_survey4b2 as $r) 
				{
					$qno = $r->question;
					if($qno=='2')
					{
						$scors = $r->score;
						$org = $r->orgno;
						$toVO++;
					

						//$sec4bc = DB::select( DB::raw("select * from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='5' and orgno='$org'"));

						$sec4bc = DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id','5')->where('orgno',$org)->orderBy('orgno')->get();

						if($sec4bc->isEmpty())
						{

						}
						else
						{
							foreach ($sec4bc as $k) 
							{
								$qn = $k->question;
								if($qn=='1')
								{
									$q1 = $k->score;
								}
								else if($qn=='2')
								{
									$q2 = $k->score;
									if($q1 >0)
									{
										$top1=$q2*100.0/$q1;
										$tround = round($top1,2);
										//echo $tround.'-';
										if($tround >=100)
										{
											$val5 += 1;
										}
										else
										{
											$val5 = 0;
										}
										//echo $val5.'-'.$org.'-';
									}
								}
								else if($qn=='3')
								{
									$q3 = $k->score;
									if($scors >0)
									{
										$top2 = $q3*100/$scors;
										$tround2 = round($top2,2);
										//echo $tround2.'-';
										if($tround2 >=100)
										{
											$val6 += 1;
										}
										else
										{
											$val6 = 0;
										}
										//echo $val6.'-'.$org.'-';
									}
								}
								else if($qn=='4')
								{
									$q4 = $k->score;
									if($q1 >0)
									{
										$top3 = $q4*100/$q1;
										$tround3 = round($top3,2);
										//echo $tround3.'-';
										if($tround3 >=80)
										{
											$val7 += 1;
										}
										else
										{
											$val7 = 0;
										}
										//echo $val7.'-'.$org.'-';
									}
								}
								else if($qn=='5')
								{
									$q5 = $k->score;
									if($q1 >0)
									{
										$top4 = $q5*100/$q1;
										$tround5 = round($top4,2);
										//echo $tround5.'-';
										if($tround5 >=80)
										{
											$val8 += 1;
										}
										else
										{
											$val8 = 0;
										}
										//echo $val8.'-'.$org.'/';
									}
								}

							}
						}
				    }
				}
				$totalvaluem2 =  $val5+$val6+$val7+$val8;
				//$tom2 = $totalvaluem2/$toVO;
				//echo $totalvaluem2;
				$allvalue= $totalvaluem1+$totalvaluem2;
	            $totl = round($allvalue,2);
	            //echo $totl;
	            if($totl >='6')
	            {
	            	$p = 12;
	            } 
	            else if($totl >='5' and $totl < 6)
	            {
	            	$p = 8;
	            }
	            else if($totl >='4' and $totl < 5)
	            {
	            	$p=4;
	            }
	            else
	            {
	            	$p=0;
	            }
	            //echo $status;
	            $question_point = 12;
				//$datacheck = DB::select( DB::raw("select * from mnwv2.cal_section_point where event_id='$eventid' and branchcode='$brcode' and section='$secid' and sub_sec_id='$sub_sec_id'"));
				
				$datacheck = DB::table('mnwv2.cal_section_point')->where('branchcode',$brcode)->where('event_id',$eventid)->where('section',$secid)->where('sub_sec_id',$sub_sec_id)->get();

				if($datacheck->isEmpty())
				{

			        $sec4_insert4 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
				}
				else
				{
					
					$id = $datacheck[0]->id;
					 $sec4_insert4 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
				}
			}
		}
		else if((($sub_sec_id=='6') or ($sub_sec_id=='7')) or (($sub_sec_id=='8') or ($sub_sec_id=='9')) or ($sub_sec_id=='10'))
		{
			//$sec4_survey6 = DB::select( DB::raw("select score,orgmemno from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));

			$sec4_survey6 =DB::table('mnwv2.survey_data')->select('score', 'orgmemno')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec4_survey6->isEmpty())
			{
				$menno =0;
				$score =0;
				foreach($sec4_survey6 as $row)
				{
					$sc = $row->score;
					$score +=$sc;
					$menno +=1;
					
				}
				//echo $score;
				//echo $menno."-".$score."*".$sub_sec_id."/";
			//	$score = $sec4_survey6[0]->score;
				
				if($menno == $score)
				{
					$p =12;
				}
				else
				{
					$p=0;
				}
				$question_point = 12;
			    $sec4_insert4 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='11')
		{
			//$sec4_survey11 = DB::select( DB::raw("select * from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));

			$sec4_survey11 =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();

			if(!$sec4_survey11->isEmpty())
			{
				$FinalMis=0;
				$Process =0;
				foreach ($sec4_survey11 as $r) 
				{
					$q1 = $r->question;
					if($q1=='1')
					{
						$FinalMis +=1;
					}
					else if($q1=='2')
					{
						$Process +=1;
					}
				}
				if($FinalMis >='5' and $Process >='4')
				{
					$p =12;
				}
				else if($FinalMis >='5' and $Process =='3')
				{
					$p =8;
				}
				else if($FinalMis >='5' and $Process =='2')
				{
					$p = 4;
				}
				else
				{
					$p =0;
				}
				$question_point = 12;
			    $sec4_insert4 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
	    }	
	}
}
function SectionFive($eventid,$secid,$question,$sub_sec_id,$orgno,$monitorno,$brcode)
{
	$sec5 =DB::table('mnwv2.cal_section_point')->where('branchcode',$brcode)->where('event_id',$eventid)->where('section',$secid)->where('sub_sec_id',$sub_sec_id)->get();
	if($sec5->isEmpty())
	{
		if($sub_sec_id=='1')
		{
			$val =0;
			//$sec5_survey1 = DB::select( DB::raw("select sum(score) as score from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));

			$sec5_survey1 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec5_survey1->isEmpty())
			{
				$val = $sec5_survey1[0]->score;
			}
			if($val =='6')
			{
				$p=6;
			}
			else
			{
				$p=0;
			}
			$question_point = 6;

			$sec5_insert = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);

		}
		else if($sub_sec_id=='2')
		{
			//$sec5_survey2 = DB::select( DB::raw("select * from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));

			$sec5_survey2 =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec5_survey2->isEmpty())
			{
				$ques1 =0;
				$ques2=0;
				$tscore=0;
				foreach ($sec5_survey2 as $r) 
				{
					$q1 = $r->question;
					if($q1=='1')
					{
						$ques1 =  $r->score;
					}
					else if($q1 =='2')
					{
						$ques2 =  $r->score;
					}

				}
				if($ques2 > 0)
				{
					$tscore = ($ques2*100)/$ques1;
				}
				if($tscore >='80')
				{
					$p =6;
				}
				else if($tscore >='60' and $tscore <='79')
				{
					$p = 4;
				}
				else if($tscore >='50' and $tscore <='59')
				{
					$p =2;
				}
				else
				{
					$p=0;
				}
				$question_point = 6;

			    $sec5_insert2 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='3')
		{
			$val =0;
			//$sec5_survey3 = DB::select( DB::raw("select sum(score) as score from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));

			$sec5_survey3 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec5_survey3->isEmpty())
			{
				$val = $sec5_survey3[0]->score;
			}
			if($val =='6')
			{
				$p =6;
			}
			else
			{
				$p=0;
			}
			$question_point = 6;

			$sec5_insert2 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
		}
		else if(($sub_sec_id=='4') or ($sub_sec_id=='5'))
		{
			$score =0;
			//$sec5_survey4 = DB::select( DB::raw("select sum(score) as score from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));

			$sec5_survey4 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();

			if(!$sec5_survey4->isEmpty())
			{
				if($sub_sec_id=='5')
				{
					$score = $sec5_survey4[0]->score;
					if($score >='4')
					{
						$p =6;
					}
					else if($score =='3')
					{
						$p = 4;
					}
					else if($score =='2')
					{
						$p=2;
					}
					else
					{
						$p = 0;
					}
					$question_point = 6;
				}
				else if($sub_sec_id=='4')
				{
					$score = $sec5_survey4[0]->score;
					if($score >='4')
					{
						$p =9;
					}
					else if($score =='3')
					{
						$p = 6;
					}
					else if($score =='2')
					{
						$p=3;
					}
					else
					{
						$p = 0;
					}
					$question_point = 9;
				}
			    $sec5_insert4 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}

		}
		else if((($sub_sec_id=='6') or ($sub_sec_id=='7')) or (($sub_sec_id=='8') or ($sub_sec_id=='9')) or (($sub_sec_id=='10') or ($sub_sec_id=='11')) or (($sub_sec_id=='12') or ($sub_sec_id=='13')) or (($sub_sec_id=='14') or ($sub_sec_id=='17')) or ($sub_sec_id=='18'))
		{
			$score =0;
			$p =0;
			//$sec5_survey6 = DB::select( DB::raw("select sum(score) as score,question from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id' group by question"));

			$sec5_survey6 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,question')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('question')->get();
			if(!$sec5_survey6->isEmpty())
			{
				$score =  $sec5_survey6[0]->score;
				$question = $sec5_survey6[0]->question;
				if($sub_sec_id=='6')
				{
					if($question=='1')
					{
						if($score >='6')
						{
							$p =6;
						}
						else
						{
							$p =0;
						}
					}
				}
				else
				{
					if($score >='6')
					{
						$p =6;
					}
					else
					{
						$p =0;
					}
				}
				$question_point = 6;
				$sec5_insert6 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if(($sub_sec_id=='15') or ($sub_sec_id=='16'))
		{
			$score =0;
			$question_point =0;
			//$sec5_survey15 = DB::select( DB::raw("select sum(score) as score from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));

			$sec5_survey15 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec5_survey15->isEmpty())
			{
				if($sub_sec_id=='15')
				{
					$score =  $sec5_survey15[0]->score;
					if($score =='9')
					{
						$p =9;
					}
					else
					{
						$p =0;
					}
					$question_point = 9;
				}
				else if($sub_sec_id=='16')
				{
					$score =  $sec5_survey15[0]->score;
					if($score =='12')
					{
						$p =12;
					}
					else
					{
						$p =0;
					}
					$question_point = 12;
				}
				$sec5_insert6 = DB::table('mnwv2.cal_section_point')->insert(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
	}
	else
	{
		$id = $sec5[0]->id;
		if($sub_sec_id=='1')
		{
			$val =0;
			//$sec5_survey1 = DB::select( DB::raw("select sum(score) as score from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));

			$sec5_survey1 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();

			if(!$sec5_survey1->isEmpty())
			{
				$val = $sec5_survey1[0]->score;
			}
			if($val =='6')
			{
				$p=6;
			}
			else
			{
				$p=0;
			}
			$question_point = 6;
			$sec5_insert = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);

		}
		else if($sub_sec_id=='2')
		{
			//$sec5_survey2 = DB::select( DB::raw("select * from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));

			$sec5_survey2 =DB::table('mnwv2.survey_data')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();

			if(!$sec5_survey2->isEmpty())
			{
				$ques1 =0;
				$ques2=0;
				$tscore=0;
				foreach ($sec5_survey2 as $r) 
				{
					$q1 = $r->question;
					if($q1=='1')
					{
						$ques1 =  $r->score;
					}
					else if($q1 =='2')
					{
						$ques2 =  $r->score;
					}

				}
				if($ques2 > 0)
				{
					$tscore = ($ques2*100)/$ques1;
				}
				if($tscore >='80')
				{
					$p =6;
				}
				else if($tscore >='60' and $tscore <='79')
				{
					$p = 4;
				}
				else if($tscore >='50' and $tscore <='59')
				{
					$p =2;
				}
				else
				{
					$p=0;
				}
				$question_point = 6;
			    $sec5_insert2 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if($sub_sec_id=='3')
		{
			$val =0;
			//$sec5_survey3 = DB::select( DB::raw("select sum(score) as score from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));
			
			$sec5_survey3 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec5_survey3->isEmpty())
			{
				$val = $sec5_survey3[0]->score;
			}
			if($val =='6')
			{
				$p =6;
			}
			else
			{
				$p=0;
			}
			$question_point = 6;
			$sec5_insert2 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
		}
		else if(($sub_sec_id=='4') or ($sub_sec_id=='5'))
		{
			$score =0;
			//$sec5_survey4 = DB::select( DB::raw("select sum(score) as score from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));

			$sec5_survey4 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec5_survey4->isEmpty())
			{
				if($sub_sec_id=='5')
				{
					$score = $sec5_survey4[0]->score;
					if($score >='4')
					{
						$p =6;
					}
					else if($score =='3')
					{
						$p = 4;
					}
					else if($score =='2')
					{
						$p=2;
					}
					else
					{
						$p = 0;
					}
					$question_point = 6;
				}
				else if($sub_sec_id=='4')
				{
					$score = $sec5_survey4[0]->score;
					if($score >='4')
					{
						$p =9;
					}
					else if($score =='3')
					{
						$p = 6;
					}
					else if($score =='2')
					{
						$p=3;
					}
					else
					{
						$p = 0;
					}
					$question_point = 9;
				}
			    $sec5_insert4 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}

		}
		else if((($sub_sec_id=='6') or ($sub_sec_id=='7')) or (($sub_sec_id=='8') or ($sub_sec_id=='9')) or (($sub_sec_id=='10') or ($sub_sec_id=='11')) or (($sub_sec_id=='12') or ($sub_sec_id=='13')) or (($sub_sec_id=='14') or ($sub_sec_id=='17')) or ($sub_sec_id=='18'))
		{
			$score =0;
			//$sec5_survey6 = DB::select( DB::raw("select sum(score) as score,question from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id' group by question"));

			$sec5_survey6 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score,question')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->groupBy('question')->get();

			if(!$sec5_survey6->isEmpty())
			{
				$p =0;
				$score =  $sec5_survey6[0]->score;
				$question = $sec5_survey6[0]->question;
				if($sub_sec_id=='6')
				{
					if($question=='1')
					{
						if($score >='6')
						{
							$p =6;
						}
						else
						{
							$p =0;
						}
					}
				
				}
				else
				{
					if($score >='6')
					{
						$p =6;
					}
					else
					{
						$p =0;
					}
				}
				$question_point = 6;
				$sec5_insert6 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
		else if(($sub_sec_id=='15') or ($sub_sec_id=='16'))
		{
			$score =0;
			$question_point =0;
			//$sec5_survey15 = DB::select( DB::raw("select sum(score) as score from mnwv2.survey_data where event_id='$eventid' and sec_no='$secid' and sub_sec_id='$sub_sec_id'"));

			$sec5_survey15 =DB::table('mnwv2.survey_data')->selectRaw('sum(score) as score')->where('event_id',$eventid)->where('sec_no',$secid)->where('sub_sec_id',$sub_sec_id)->get();
			if(!$sec5_survey15->isEmpty())
			{
				if($sub_sec_id=='15')
				{
					$score =  $sec5_survey15[0]->score;
					if($score =='9')
					{
						$p =9;
					}
					else
					{
						$p =0;
					}
					$question_point = 9;
				}
				else if($sub_sec_id=='16')
				{
					$score =  $sec5_survey15[0]->score;
					if($score =='12')
					{
						$p =12;
					}
					else
					{
						$p =0;
					}
					$question_point = 12;
				}
				$sec5_insert6 = DB::table('mnwv2.cal_section_point')->where('id',$id)->update(['branchcode' =>$brcode,'event_id'=>$eventid,'section'=>$secid,'point'=>$p,'qno'=>$question,'sub_sec_id'=>$sub_sec_id,'question_point'=>$question_point,'sub_id'=>$sub_sec_id]);
			}
		}
	}
}
?>