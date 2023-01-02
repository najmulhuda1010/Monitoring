<?php 
$username = Session::get('username');
if($username=='')
{

  ?>
  <script>
    window.location.href = 'Logout';
  </script>
  
  <?php 
  
}
$calculation=1;
$dataload1="true";
$dataload1 = $dataload;
if($dataload1 =="true")
{
  if($calculation==1)
  {
    ?>
    @extends('DataProcessing/DataProcessing')
    <script type="text/javascript">
      //window.location = "BRDashboard?dataload=false;"
      //alert("test");
    </script>
    
    <?php
    $speed=0;
  }
}
if(isset($_GET['dataload']))
{
  $calculation = $_GET['dataload'];
  if($calculation=="false")
  {
    $calculation=0;
  }
}

?>
@extends('backend.layouts.master')

@section('title','National Dashboard')

@section('content')
<?php
    $calculation=1;
    $dataload1="true";
		  //echo $dataload1;
    $dataload1 = $dataload;
    if($dataload1 =="true")
    {
     
         $mont = date('m');
         $yar = date('Y');
    			//$completestatus = DB::select(DB::raw("select * from mnwv2.monitorevents"));
         $completestatus = DB::table('mnwv2.monitorevents')->where('areacompletestatus',0)->get();
         if(!$completestatus->isEmpty())
         {
           foreach($completestatus as $r)
           {
                $month  = $r->month;
                $eid = $r->id;
                $brc = $r->branchcode;
                $year = $r->year;
        				//$checkstatus = DB::select(DB::raw("select * from mnwv2.monitorevents where id='$eid' and areacompletestatus=1"));
                $checkstatus = DB::table('mnwv2.monitorevents')->where('id',$eid)->where('areacompletestatus',1)->get();
                if($checkstatus->isEmpty())
                {
                 if($mont >='01' and $mont <='03')
                 {
                   if(($month >='01' and $month <='03') and $yar == $year)
                   {

                   }
                   else
                   {
                    $updateareacompletestatus = DB::table('mnwv2.monitorevents')->where('id',$eid)->where('branchcode',$brc)->update(['areacompletestatus'=>1]);
                  }
                }
                else if($mont >='04' and $mont <='06')
                {
                 if(($month >='04' and $month <='06') and $yar == $year)
                 {

                 }
                 else
                 {
					 //dd("huda");
                   if($month < '04')
                   {
                    $updateareacompletestatus = DB::table('mnwv2.monitorevents')->where('id',$eid)->where('branchcode',$brc)->update(['areacompletestatus'=>1]);
                  }

                }
              }
              else if($mont >= '07' and $mont <='09')
              {
               if(($month >='07' and $month <='09')  and $yar == $year)
               {

               }
               else
               {
                if($month < '07')
                {
                 $updateareacompletestatus = DB::table('mnwv2.monitorevents')->where('id',$eid)->where('branchcode',$brc)->update(['areacompletestatus'=>1]);
                }

             }
           }
           else if($mont >='10' and $mont <='12')
           {
             if(($month >='10' and $month <='12') and $yar == $year)
             {

             }
             else
             {
				 
        	   if($month < '10')
			   {
				   $updateareacompletestatus = DB::table('mnwv2.monitorevents')->where('id',$eid)->where('branchcode',$brc)->update(['areacompletestatus'=>1]);
			   }
              /*if(($month >='01' and $month <='03') and $yar == $year)
              {
               $updateareacompletestatus = DB::table('mnwv2.monitorevents')->where('id',$eid)->where('branchcode',$brc)->update(['areacompletestatus'=>1]);
              }*/

           }
         }  
       }
      }
    }
  }
  ?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">National Dashboard</h5>
      </div>
      <!--end::Info-->
    </div>
  </div>
  <!--end::Subheader-->
  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
      <!--begin::Dashboard-->
      <!--begin::Row-->
      <div class="row">
        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" class="table table-bordered">
                <tr class="brac-color-pink">
                  <th width="50%">Monitoring Event</th>
                  <th width="50%">Result</th>
                </tr>
                <?php

      $month=0;
      $mnth=date('m');
      $cmonth = date('m');
      $cyear = date('Y');
      $totalscore =0;
      $g='';$m='';$p='';
      $ct=0;
      $score =0;
      $year ='';
      $quarter ='';
      $m='';
      $mn='';

               //$checkdata= DB::select(DB::raw("select year,quarterly from mnwv2.monitorevents where areacompletestatus =1 group by year,quarterly  order by year DESC, quarterly DESC LIMIT 2"));
      $checkdata = DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('areacompletestatus',1)->groupBy('year','quarterly')->orderBy('year','DESC')->orderBy('quarterly','DESC')->limit(2)->get();
      if(!$checkdata->isEmpty())
      {
        foreach($checkdata as $row)
        {
         $year = $row->year;
         $quarter = $row->quarterly;
               //echo $quarter;
         $m='';
         $p='';
         $g='';
         //$branchscore = DB::select(DB::raw("select * from mnwv2.monitorevents"));
         $branchscore = DB::table('mnwv2.monitorevents')->get();
         if(!$branchscore->isEmpty())
         {
          foreach($branchscore as $rw)
          {
            $brcode = $rw->branchcode;
      					   //echo $brcode."/";
            $cnt= strlen($brcode);
            if($cnt == 3)
            {
             $brcode='0'.$brcode;
           }
          // $checkbrnch= DB::select(DB::raw("select * from mnwv2.monitorevents where branchcode='$brcode' and year='$year' and quarterly = '$quarter'"));
           $checkbrnch = DB::table('mnwv2.monitorevents')->where('branchcode',$brcode)->where('year',$year)->where('quarterly',$quarter)->get();
           if(!$checkbrnch->isEmpty())
           {
             $myear = $checkbrnch[0]->year;
        						 //echo $myear;
             $month = $checkbrnch[0]->month;
        					   //  echo $month."/".$cmonth;
             if($month <='03')
             {

                if(($mnth >='01' and $mnth <='03') and ($myear==$cyear))
                {

          							 // echo $mnth;
                }
                else
                {

                 $period = $myear.","."JAN"." to ".$myear.","."MAR";
                 $score +=$checkbrnch[0]->score;
                 $ct +=1;
                }
              }
             else if($month >='04' and $month <='06')
             {
               if(($mnth >='04' and $mnth <='06') and ($year==$cyear))
               {


               }
               else
               {
                 $period = $myear.","."APR"." to ".$myear.","."JUN";
                 $score +=$checkbrnch[0]->score;
                 $ct +=1;
               }
             }
             else if($month >='07' and $month <='09')
             {
               if(($mnth >='07' and $mnth <='09') and ($myear==$cyear))
               {


               }
               else
               {
          							//if()
                 $period = $myear.","."JUL"." to ".$myear.","."SEP";
                 $score +=$checkbrnch[0]->score;
                 $ct +=1;
               }
             }
             else if($month >='10' and $month <='12')
             {
               if(($mnth >='10' and $mnth <='12') and ($myear==$cyear))
               {


               }
               else
               {

                 $period = $myear.","."OCT"." to ".$myear.","."DEC";
                 $score +=$checkbrnch[0]->score;
                 $ct +=1;
               }
             }
            }
      					//echo $brcode."/";
          } 
        }
       if($score !=0)
       {
         $totalscore = round($score/$ct,2);
         if($totalscore >=85)
         {
           $g = 'Good';
         }
         else if($totalscore >=70 and $totalscore < 85)
         {
           $m ='Modarate';
         }    
         else if($totalscore >=0.1 and $totalscore < 70)
         {
           $p = 'Need Improvement';
         }
                       //echo $g."/".$m."*".$p;
         ?>
         <tr>
           <td width="50%"><a style="color: #3699FF" href="NationalDashboard?event=<?php echo $year.",".$quarter; ?>"><?php echo $year."-".$quarter; ?></a></td>
           <td width="50%"><?php if($g){
            echo "Good";
         } if($m){
           echo "Moderate";
         } if($p){
           echo "Need Improvement";
           } ?></td>
         </tr>
         <?php
       }
      }
    }
  ?>
              </table>
            </div>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
        <?php
        $y ='';
        $q ='';
        if($eventyear !='' and $eventquarter !='')
        {
          $cycle ='';
        /*$cycl = DB::select( DB::raw("select year,quarterly from mnwv2.monitorevents group by year, quarterly order by year DESC, quarterly DESC LIMIT 1"));
        if(!empty($cycl))
        {
          $y =$cycl[0]->year;
          $q= $cycl[0]->quarterly;
         
        }*/
        $y =$eventyear;
        $q= $eventquarter;
        $cycle= $eventyear."-".$eventquarter;
        ?>

        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <div class="card-header">
              <h3 class="card-title">Monitoring Event: <?php echo $cycle; ?></h3>
            </div><!-- /.box-header -->
            <?php
            $cl =0;
            //$month = DB::select(DB::raw("select month from mnwv2.monitorevents where year='$y' and quarterly='$q' group by month order by month ASC"));
            $month = DB::table('mnwv2.monitorevents')->select('month')->where('year',$y)->where('quarterly',$q)->groupBy('month')->orderBy('month','ASC')->get();
            if(!$month->isEmpty())
            {
                foreach ($month as $rw) 
                {
                $cl++;
                }
            }
            ?>
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" class="table table-bordered">
                <thead>
                  <tr  class="brac-color-pink">
                    <th rowspan="2" width="15%" style="vertical-align: middle;text-align: center;">Section</th>
                    <th rowspan="2" width="20%" style="vertical-align: middle;">Section Name</th>
                    <th colspan="<?php echo $cl; ?>" width="20%" style="text-align: center">Month wise achievement %</th>
                    <th rowspan="2" width="15%" style="vertical-align: middle;">Quarterly achievement %</th>
                  </tr>
                  <tr class="brac-color-pink">
                    <?php 
                    foreach ($month as $row) 
                    {
                    $mon = $row->month;
                        //echo $mon;
                    if($mon =='01'){$j = "JAN";} else if($mon =='02'){$j="FEB";}else if($mon=='03'){$j="MAR";}else if($mon =='04'){$j="APR";}else if($mon=='05'){$j="MAY";}else if($mon =='06'){$j="JUN";}else if($mon=='07'){$j="JUL";}else if($mon=='08'){$j="AUG";}else if($mon=='09'){$j="SEP";}else if($mon=='10'){$j="OCT";}else if($mon=='11'){$j="NOV";}else if($mon =='12'){$j="DEC";}else{$j='0';}
                    ?>
                    <th width="10%" style="text-align: center"><?php echo $j; ?></th>
                    <?php
                    }
                    ?>
                  </tr>
                 </thead>
                 <tbody>
                        <?php
                        $mnthh1=0;
                        $mnthh2=0;
                        $mnthh=0;
                        $monthscore1 =0;
                        $monthscore2 =0;
                        $monthscore3 =0;
                        $monthscore4 =0;
                        $totalscore =0;
                        $sectionpoint =0;
                        $question_point=0;
                        for($i=1; $i<=5; $i++)
                        {
                        $c =0;
                        //$month = DB::select(DB::raw("select month from mnwv2.monitorevents where year='$y' and quarterly='$q' group by month order by month ASC"));
                        $month = DB::table('mnwv2.monitorevents')->select('month')->where('year',$y)->where('quarterly',$q)->groupBy('month')->orderBy('month','ASC')->get();
                        if(!$month->isEmpty())
                        {
                            $c=0;
                                //$mntt = $month[0]->month;
                            foreach ($month as $row) 
                            {
                            $sectionpoint1 =0;
                            $question_point1 =0;
                            $mn = $row->month;
                            $getmonth = DB::select(DB::raw("select * from mnwv2.monitorevents where  year='$y' and quarterly='$q' and month='$mn' and score !='0'"));
                            if(!empty($getmonth))
                            {
                                foreach ($getmonth as $r) 
                                {
                                $event_id = $r->id;
                                $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$event_id' and section='$i'"));
                                if(!empty($data))
                                {
                                    $sectionpoint1 += $data[0]->sp;
                                    $question_point1 += $data[0]->qsp;
                                }
                                }

                                if($c =='0')
                                {
                                if($sectionpoint1 !=0)
                                {
                                    $monthscore1 = round((($sectionpoint1/$question_point1)*100),2);
                                    $mnthh =$mn;  
                                }


                                }
                                else if($c=='1')
                                {
                                if($sectionpoint1 !=0)
                                {
                                    $monthscore2 = round((($sectionpoint1/$question_point1)*100),2);
                                    $mnthh1 =$mn;
                                }
                                }
                                else if($c=='2')
                                {
                                if($sectionpoint1 !=0)
                                {
                                    $monthscore3 = round((($sectionpoint1/$question_point1)*100),2);
                                    $mnthh2 =$mn;
                                }

                                }

                            }

                            $c++;
                            }
                                //echo $mn;

                        }
                        //$alldata = DB::select(DB::raw("select * from mnwv2.monitorevents where year='$y' and quarterly='$q' and score !='0'"));
                        $alldata = DB::table('mnwv2.monitorevents')->where('year',$y)->where('quarterly',$q)->where('score','!=',0)->get();
                        $sectionpoint =0;
                        $question_point=0;
                        if(!$alldata->isEmpty())
                        {
                        foreach($alldata as $r)
                        {
                            $mnth = $r->month;
                                    //echo $mnth;
                            $year = $r->year;
                            $quar= $r->quarterly;
                            $event_id = $r->id;
                            $div_id = $r->division_id;
                            $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$event_id' and section='$i'"));
                            if(!empty($data))
                            {
                            $sectionpoint += $data[0]->sp;
                            $question_point += $data[0]->qsp;
                            }                 
                        }
                                // echo $sectionpoint."/".$question_point."*";
                                //die();

                        if($sectionpoint !=0)
                        {
                        $totalscore = round((($sectionpoint/$question_point)*100),2); 
                        }
                        $secname = DB::select( DB::raw("select * from mnw.def_sections where sec_no='$i'"));
                        if(empty($secname))
                        {

                        }
                        else
                        {
                        $name = $secname[0]->sec_name;
                        }

                        if($totalscore !=0)
                        {
                                    //echo $mntt;
                        ?>
                        <tr  style="height:20px;">
                            <td style="text-align:center;"><a class="btn btn-light" target="_blank" href="DivisionWiseAc?division=<?php echo $i.",".$y.",".$q.",".$div_id; ?>"><?php echo "Section: ".$i; ?></a></td>
                            <td width="50%" ><?php echo $name; ?></td>
                            <?php
                            if($monthscore1 !=0)
                            {
                                        //echo "Huda";
                            ?>
                            <td style="text-align:center;"><a target="_blank" href="monthDivisionWise?month=<?php echo $i.",".$mnthh.",".$y.",".$q.",".$div_id; ?>"><button class="btn btn-light"><?php echo $monthscore1."%"; ?></button></a></td>
                            <?php
                            }
                            if($monthscore2 !=0)
                            {
                                        //echo "Huda";
                            ?>
                            <td style="text-align:center;"><a target="_blank" href="monthDivisionWise?month=<?php echo $i.",".$mnthh1.",".$y.",".$q.",".$div_id; ?>"><button class="btn btn-light"><?php echo $monthscore2."%"; ?></button></a></td>
                            <?php
                            }
                            if($monthscore3 !=0)
                            {
                                        //echo "Huda";
                            ?>
                            <td style="text-align:center;"><a target="_blank" href="monthDivisionWise?month=<?php echo $i.",".$mnthh2.",".$y.",".$q.",".$div_id; ?>"><button class="btn btn-light"><?php echo $monthscore3."%"; ?></button></a></td>
                            <?php
                            }					
                            ?>
                            <td width="30%" ><?php echo $totalscore."%"; ?></td>
                        </tr>
                        <?php
                        }
                    }  
                    }
                    ?>
                </tbody>
              </table>
            </div>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <div class="card-header">
              <h3 class="card-title">Branch Count</h3>
            </div><!-- /.box-header -->
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                 <tr class="brac-color-pink">
                   <th rowspan="3" style="vertical-align: middle;">Monitoring Event</th>
                   <th rowspan="3" style="vertical-align: middle;">Division Total Br No</th>
                   <th colspan="2" style="text-align: center">Total branch monitored</th>
                   <th colspan="6" style="text-align: center">Rating wise branch no</th>
                 </tr>
                 <tr  class="brac-color-pink">
                   <th rowspan="2" style="vertical-align: middle;">No</th>
                   <th rowspan="2" style="vertical-align: middle;">% (of all branch)</th>
                   <th colspan="2" style="text-align: center">Good</th>
                   <th colspan="2" style="text-align: center">Moderate</th>
                   <th colspan="2" style="text-align: center">Need Improvement</th>
                 </tr>
                 <tr  class="brac-color-pink">
                   <th>No</th>
                   <th>%</th>
                   <th>No</th>
                   <th>%</th>
                   <th>No</th>
                   <th>%</th>
                 </tr>
               </thead>
               <tbody>
                <?php
                $good =0;
                $moderate =0;
                $poor=0;
                $monitorpercent ='';
                $cntdivision = DB::select( DB::raw("select count(*) as cnt from branch where program_id=1"));
                if(!empty($cntdivision))
                {
                  $divcount =  $cntdivision[0]->cnt;
                } 
                //$quarterlist = DB::select( DB::raw("select year,quarterly from mnwv2.monitorevents group by year,quarterly order by year,quarterly DESC Limit 4"));
                $quarterlist =DB::table('mnwv2.monitorevents')->select('year','quarterly')->groupBy('year','quarterly')->orderBy('year','DESC')->orderBy('quarterly','DESC')->get();
                if(!$quarterlist->isEmpty())
                {
                  foreach ($quarterlist as $row) 
                  {
                    $good =0;$moderate =0;$poor=0;$g =0;$m=0;$p=0;$brcnt=0;$score =0;$ct =0;$tscore =0;
                    $years = $row->year;
                    $quarter = $row->quarterly;
                    $monitoredbranch = DB::select( DB::raw("select count(*) as brcount from mnwv2.monitorevents where year='$years' and quarterly='$quarter' and score !='0'"));
                    if(!empty($monitoredbranch))
                    {
                      $brcnt = $monitoredbranch[0]->brcount;
                    }
                    else
                    {
                      $brcnt='';
                    }
                    $monitorpercent = round($brcnt/$divcount*100,2);
            
                    //$goodmodaratepoor = DB::select( DB::raw("select * from mnwv2.monitorevents where year='$years' and quarterly='$quarter' and score !='0'"));
                    $goodmodaratepoor = DB::table('mnwv2.monitorevents')->where('year',$years)->where('quarterly',$quarter)->where('score','!=',0)->get();
                    if(!$goodmodaratepoor->isEmpty())
                    {
                      foreach ($goodmodaratepoor as $rw) 
                      {
                        $score = $rw->score;
                        if($score >= '85')
                        {
                          $g +=1;
                        }
                        else if($score >=70 and $score < 85)
                        {
                          $m +=1;
                        }
                        else if($score < 70)
                        {
                          $p +=1;
                        }
                                  //$ct++;
                      }
                                /*if($ct !=0)
                                {
                                  $tscore = round($score/$ct,2);
                                }
                               // echo $score."/";
                                if($tscore >='85')
                                {
                                  $g +=1;
                                }
                                else if($tscore >='70' and $tscore <='84')
                                {
                                  $m +=1;
                                }
                                else if($tscore < 70)
                                {
                                  $p +=1;
                                }
                                else
                                {
                                  $g =0;
                                  $m=0;
                                  $p=0;
                                }*/
                              }
                              if($g !=0)
                              {
                                $good = round($g/$brcnt*100,2);
                              }
                              if($m !=0)
                              {
                               $moderate = round($m/$brcnt*100,2);
                             }
                             if($p !=0)
                             {
                               $poor = round($p/$brcnt*100,2);
                             }
            
                             ?>
                             <tr>
                              <td ><?php echo $years."-".$quarter; ?></td>
                              <td ><?php echo $divcount; ?></td>
                              <td ><?php echo $brcnt; ?></td>
                              <td ><?php echo $monitorpercent." %"; ?></td>
                              <td ><?php echo $g; ?></td>
                              <td ><?php echo $good." %"; ?></td>
                              <td ><?php echo $m; ?></td>
                              <td ><?php echo $moderate." %"; ?></td>
                              <td ><?php echo $p; ?></td>
                              <td ><?php echo $poor." %"; ?></td>
                            </tr>
                            <?php
                          }
                        }
                        ?>
                      </tbody>
              </table>
              <?php
      }
      else
      {
        $y='';
        $q='';
        $cycle ='';
        //$cycl = DB::select( DB::raw("select year,quarterly from mnwv2.monitorevents where areacompletestatus=1 group by year, quarterly order by year DESC, quarterly DESC LIMIT 1"));
        $cycl =DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('areacompletestatus',1)->groupBy('year','quarterly')->orderBy('year','DESC')->orderBy('quarterly','DESC')->limit(1)->get();
        if(!$cycl->isEmpty())
        {
          $y =$cycl[0]->year;
          $q= $cycl[0]->quarterly;
          $cycle= $cycl[0]->year."-".$cycl[0]->quarterly;
        }
        ?>
       <div class="col-md-12">
        <div class="card card-custom gutter-b">
          <!--begin::Form-->
          <div class="card-header">
            <h3 class="card-title">Monitoring Event: <?php echo $cycle; ?></h3>
          </div><!-- /.box-header -->
       <?php
       $cl =0;
       //$month = DB::select(DB::raw("select month from mnwv2.monitorevents where year='$y' and quarterly='$q' group by month order by month ASC"));
       $month = DB::table('mnwv2.monitorevents')->select('month')->where('year',$y)->where('quarterly',$q)->groupBy('month')->orderBy('month','ASC')->get();
       if(!$month->isEmpty())
       {
        foreach ($month as $rw) 
        {
          $cl++;
        }
      }
      ?>
      <div class="card-body table-responsive">
        <table style="text-align: center;font-size:13" class="table table-bordered">
          <thead>
            <tr  class="brac-color-pink">
              <th rowspan="2" width="15%" style="vertical-align: middle;text-align: center;">Section</th>
              <th rowspan="2" width="20%" style="vertical-align: middle;">Section Name</th>
              <th colspan="<?php echo $cl; ?>" width="20%" style="text-align: center">Month wise achievement %</th>
              <th rowspan="2" width="15%" style="vertical-align: middle;">Quarterly achievement %</th>
            </tr>
            <tr class="brac-color-pink">
            <?php 
            foreach ($month as $row) 
            {
              $mon = $row->month;
              if($mon =='01'){$j = "JAN";} else if($mon =='02'){$j="FEB";}else if($mon=='03'){$j="MAR";}else if($mon =='04'){$j="APR";}else if($mon=='05'){$j="MAY";}else if($mon =='06'){$j="JUN";}else if($mon=='07'){$j="JUL";}else if($mon=='08'){$j="AUG";}else if($mon=='09'){$j="SEP";}else if($mon=='10'){$j="OCT";}else if($mon=='11'){$j="NOV";}else if($mon =='12'){$j="DEC";}else{$j='0';}
              ?>
              <th width="10%" style="text-align: center"><?php echo $j; ?></th>
              <?php
            }
            ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $mnthh1=0;
          $mnthh2=0;
          $mnthh=0;
          $monthscore1 =0;
          $monthscore2 =0;
          $monthscore3 =0;
          $monthscore4 =0;
          $totalscore =0;
          $sectionpoint =0;
          $question_point=0;
          for($i=1; $i<=5; $i++)
          {
           $c =0;
           //$month = DB::select(DB::raw("select month from mnwv2.monitorevents where year='$y' and quarterly='$q' group by month order by month ASC"));
           $month = DB::table('mnwv2.monitorevents')->select('month')->where('year',$y)->where('quarterly',$q)->groupBy('month')->orderBy('month','ASC')->get();
           if(!empty($month))
           {
            $c=0;
                  //$mntt = $month[0]->month;
            foreach ($month as $row) 
            {
              $sectionpoint1 =0;
              $question_point1 =0;
              $mn = $row->month;
              //$getmonth = DB::select(DB::raw("select * from mnwv2.monitorevents where  year='$y' and quarterly='$q' and month='$mn' and score !='0'"));
              $getmonth = DB::table('mnwv2.monitorevents')->where('year',$y)->where('quarterly',$q)->where('month',$mn)->where('score','!=',0)->get();
              if(!empty($getmonth))
              {
                foreach ($getmonth as $r) 
                {
                  $event_id = $r->id;
                  $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$event_id' and section='$i'"));
                  if(!empty($data))
                  {
                    $sectionpoint1 += $data[0]->sp;
                    $question_point1 += $data[0]->qsp;
                  }
                }

                if($c =='0')
                {
                  if($sectionpoint1 !=0)
                  {
                    $monthscore1 = round((($sectionpoint1/$question_point1)*100),2);
                    $mnthh =$mn;  
                  }


                }
                else if($c=='1')
                {
                  if($sectionpoint1 !=0)
                  {
                    $monthscore2 = round((($sectionpoint1/$question_point1)*100),2);
                    $mnthh1 =$mn;
                  }
                }
                else if($c=='2')
                {
                  if($sectionpoint1 !=0)
                  {
                    $monthscore3 = round((($sectionpoint1/$question_point1)*100),2);
                    $mnthh2 =$mn;
                  }

                }

              }

              $c++;
            }
                  //echo $mn;

          }
  			 //echo $y."/".$q;
         // $alldata = DB::select(DB::raw("select * from mnwv2.monitorevents where year='$y' and quarterly='$q' and score !='0'"));
         $alldata = DB::table('mnwv2.monitorevents')->where('year',$y)->where('quarterly',$q)->where('score','!=',0)->get();
          $sectionpoint =0;
          $question_point=0;
          if(!$alldata->isEmpty())
          {
           foreach($alldata as $r)
           {
            $mnth = $r->month;
                    //echo $mnth;
            $year = $r->year;
            $quar= $r->quarterly;
            $event_id = $r->id;
            $div_id = $r->division_id;
            $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$event_id' and section='$i'"));
            if(!empty($data))
            {
              $sectionpoint += $data[0]->sp;
              $question_point += $data[0]->qsp;
            }                 
          }
                // echo $sectionpoint."/".$question_point."*";
                 //die();

          if($sectionpoint !=0)
          {
           $totalscore = round((($sectionpoint/$question_point)*100),2); 
         }
         $secname = DB::select( DB::raw("select * from mnw.def_sections where sec_no='$i'"));
         if(empty($secname))
         {

         }
         else
         {
           $name = $secname[0]->sec_name;
         }

         if($totalscore !=0)
         {
                    //echo $mntt;
          ?>
          <tr  style="height:20px;">
            <td style="text-align:center;"><a class="btn btn-light" target="_blank" href="DivisionWiseAc?division=<?php echo $i.",".$y.",".$q.",".$div_id; ?>"><?php echo "Section: ".$i; ?></a></td>
            <td width="50%" ><?php echo $name; ?></td>
            <?php
            if($monthscore1 !=0)
            {
              ?>
              <td style="text-align:center;"><a target="_blank" href="monthDivisionWise?month=<?php echo $i.",".$mnthh.",".$y.",".$q.",".$div_id; ?>"><button class="btn btn-light"><?php echo $monthscore1."%"; ?></button></a></td>
              <?php
            }
            if($monthscore2 !=0)
            {
              ?>
              <td style="text-align:center;"><a target="_blank" href="monthDivisionWise?month=<?php echo $i.",".$mnthh1.",".$y.",".$q.",".$div_id; ?>"><button class="btn btn-light"><?php echo $monthscore2."%"; ?></button></a></td>
              <?php
            }
            if($monthscore3 !=0)
            {
              ?>
              <td style="text-align:center;"><a target="_blank" href="monthDivisionWise?month=<?php echo $i.",".$mnthh2.",".$y.",".$q.",".$div_id; ?>"><button class="btn btn-light"><?php echo $monthscore3."%"; ?></button></a></td>
              <?php
            } 
            ?>

            <td width="30%" ><?php echo $totalscore."%"; ?></td>
          </tr>
          <?php
        }
      }  
    }
    ?>
  </tbody>
</table>
</div>
<!--end::Form-->
</div>
<!--end::Advance Table Widget 4-->
</div>
<div class="col-md-12">
<div class="card card-custom gutter-b">
<!--begin::Form-->
<div class="card-header">
<h3 class="card-title">Branch Count</h3>
</div><!-- /.box-header -->
<div class="card-body table-responsive">
<table style="text-align: center;font-size:13" class="table table-bordered" width="100%" cellspacing="0">
  <thead>
    <tr class="brac-color-pink">
    <th rowspan="3" style="vertical-align: middle;">Monitoring Event</th>
    <th rowspan="3" style="vertical-align: middle;">Division Total Br No</th>
    <th colspan="2" style="text-align: center">Total branch monitored</th>
    <th colspan="6" style="text-align: center">Rating wise branch no</th>
    </tr>
    <tr  class="brac-color-pink">
    <th rowspan="2" style="vertical-align: middle;">No</th>
    <th rowspan="2" style="vertical-align: middle;">% (of all branch)</th>
    <th colspan="2" style="text-align: center">Good</th>
    <th colspan="2" style="text-align: center">Moderate</th>
    <th colspan="2" style="text-align: center">Need Improvement</th>
    </tr>
   <tr  class="brac-color-pink">
     <th>No</th>
     <th>%</th>
     <th>No</th>
     <th>%</th>
     <th>No</th>
     <th>%</th>
   </tr>
 </thead>
 <tbody>
    <?php
    $months = date('m');
    $good =0;
    $moderate =0;
    $poor=0;
    $monitorpercent ='';
    $cntdivision = DB::select( DB::raw("select count(*) as cnt from branch where program_id=1"));
    if(!empty($cntdivision))
    {
      $divcount =  $cntdivision[0]->cnt;
    }
    if($months >='01' and $months <='03')
    {

    }
    else if($months >='06' and $months <='06')
    {

    }
  			//else 
    //$quarterlist = DB::select( DB::raw("select year,quarterly from mnwv2.monitorevents where areacompletestatus=1 group by year,quarterly order by year,quarterly DESC Limit 3"));
    $quarterlist = DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('areacompletestatus',1)->groupBy('year','quarterly')->orderBy('year','DESC')->orderBy('quarterly','DESC')->limit(3)->get();
    if(!$quarterlist->isEmpty())
    {
      foreach ($quarterlist as $row) 
      {
        $good =0;$moderate =0;$poor=0;$g =0;$m=0;$p=0;$brcnt=0;$score =0;$ct =0;$tscore =0;
        $years = $row->year;
  				//echo $years;
        $quarter = $row->quarterly;
        $monitoredbranch = DB::select( DB::raw("select count(*) as brcount from mnwv2.monitorevents where year='$years' and quarterly='$quarter' and score !='0'"));
        if(!empty($monitoredbranch))
        {
          $brcnt = $monitoredbranch[0]->brcount;
        }
        else
        {
          $brcnt='';
        }
        $monitorpercent = round($brcnt/$divcount*100,2);
        $goodmodaratepoor = DB::select( DB::raw("select * from mnwv2.monitorevents where year='$years' and quarterly='$quarter' and score !='0'"));
        if(!empty($goodmodaratepoor))
        {
          foreach ($goodmodaratepoor as $rw) 
          {
            $score = $rw->score;
            if($score >= '85')
            {
              $g +=1;
            }
            else if($score >=70 and $score < 85)
            {
              $m +=1;
            }
            else if($score < 70)
            {
              $p +=1;
            }
                      //$ct++;
          }
                    /*if($ct !=0)
                    {
                      $tscore = round($score/$ct,2);
                    }
                   // echo $score."/";
                    if($tscore >='85')
                    {
                      $g +=1;
                    }
                    else if($tscore >='70' and $tscore <='84')
                    {
                      $m +=1;
                    }
                    else if($tscore < 70)
                    {
                      $p +=1;
                    }
                    else
                    {
                      $g =0;
                      $m=0;
                      $p=0;
                    }*/
                  }
                  if($g !=0)
                  {
                   $good = round($g/$brcnt*100,2);
                 }
                 if($m !=0)
                 {
                  $moderate = round($m/$brcnt*100,2);
                }
                if($p !=0)
                {
                 $poor = round($p/$brcnt*100,2);
               }



               ?>
               <tr>
                <td ><?php echo $years."-".$quarter; ?></td>
                <td ><?php echo $divcount; ?></td>
                <td ><?php echo $brcnt; ?></td>
                <td ><?php echo $monitorpercent." %"; ?></td>
                <td ><?php echo $g; ?></td>
                <td ><?php echo $good." %"; ?></td>
                <td ><?php echo $m; ?></td>
                <td ><?php echo $moderate." %"; ?></td>
                <td ><?php echo $p; ?></td>
                <td ><?php echo $poor." %"; ?></td>
              </tr>
              <?php
            }
          }
          ?>
        </tbody>
      </table>
      <?php
    }
    ?>
            </div>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
      </div>
      <!--end::Row-->
      <!--begin::Row-->
      
      <!--end::Row-->
      <!--end::Dashboard-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Entry-->
</div>
    
@endsection

@section('script')

@endsection