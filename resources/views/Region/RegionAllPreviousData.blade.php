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
?>
@extends('backend.layouts.master')

@section('title','Region Previous View')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Region Previous View</h5>
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
              <table style="text-align: center;font-size:13" style="font-size: 13;" class="table table-bordered">
                <tr class="brac-color-pink">
                  <th>Monitoring Event</th>
                  <th>Monitoring Period</th>
                  <th>Result</th>
                </tr>
                <tbody>
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
                        if($yr !='' and $q=='')
                        {
                          if(!$allgroup->isEmpty())
                          {
           
                            foreach ($allgroup as $raw) 
                            {
                               $yer = $raw->year;
                               $quartr = $raw->quarterly;
           
                               $alldata = DB::table('mnwv2.monitorevents')->where('year',$yer)->where('region_id',$asid)->where('quarterly',$quartr)->orderBy('year','desc')->orderBy('quarterly','desc')->get();
                              if(!empty($alldata))
                              {
                                foreach($alldata as $row)
                                {
                                  $year = $row->year;
                                  $quarter = $row->quarterly;
                                  $month = $row->month;
                                  //echo $quarter;
                                  $mn ='';
                                  $m='';
                                  $p='';
                                  $g='';
                                  if($month <='03')
                                  {
                                    
                                   if(($mnth >='01' and $mnth <='03') and ($year==$cyear))
                                   {
                                     
                                      // echo $mnth;
                                   }
                                   else
                                   {
                                     
                                     $period = $year.","."JAN"." to ".$year.","."MAR";
                                     $score +=$row->score;
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
                                     $period = $year.","."APR"." to ".$year.","."JUN";
                                     $score +=$row->score;
                                            $ct +=1;
                                   }
                                  }
                                  else if($month >='07' and $month <='09')
                                  {
                                     if(($mnth >='07' and $mnth <='09') and ($year==$cyear))
                                   {
                                       
                                   }
                                   else
                                   {
                                     //if()
                                     $period = $year.","."JUL"." to ".$year.","."SEP";
                                     $score +=$row->score;
                                            $ct +=1;
                                   }
                                  }
                                  else if($month >='10' and $month <='12')
                                  {
                                     if(($mnth >='10' and $mnth <='12') and ($year==$cyear))
                                     {
                                       
                       
                                     }
                                     else
                                     {
                                     
                                       $period = $year.","."OCT"." to ".$year.","."DEC";
                                       $score +=$row->score;
                                              $ct +=1;
                                     }
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
                                   <td>
                                   <a style="color: #3699FF"  href="RDashboard?event=<?php echo $year."-".$quarter."-".$asid; ?>"><?php echo $year."-".$quarter; ?></a></td>
                                 
                                   <td ><?php echo $period; ?></td>
                                   <td><?php if($g){
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
                              
                           } 
                        }
                        else
                        {
                         if(!empty($alldata))
                          {
                            foreach($alldata as $row)
                            {
                              $year = $row->year;
                              $quarter = $row->quarterly;
                              $month = $row->month;
                              //echo $quarter;
                              $mn ='';
                              $m='';
                              $p='';
                              $g='';
                              if($month <='03')
                              {
                                
                               if(($mnth >='01' and $mnth <='03') and ($year==$cyear))
                               {
                                 
                                  // echo $mnth;
                               }
                               else
                               {
                                 
                                 $period = $year.","."JAN"." to ".$year.","."MAR";
                                 $score +=$row->score;
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
                                 $period = $year.","."APR"." to ".$year.","."JUN";
                                 $score +=$row->score;
                                        $ct +=1;
                               }
                              }
                              else if($month >='07' and $month <='09')
                              {
                                 if(($mnth >='07' and $mnth <='09') and ($year==$cyear))
                               {
                                 
                 
                               }
                               else
                               {
                                 //if()
                                 $period = $year.","."JUL"." to ".$year.","."SEP";
                                 $score +=$row->score;
                                        $ct +=1;
                               }
                              }
                              else if($month >='10' and $month <='12')
                              {
                                 if(($mnth >='10' and $mnth <='12') and ($year==$cyear))
                                 {
                                   
                   
                                 }
                                 else
                                 {
                                 
                                   $period = $year.","."OCT"." to ".$year.","."DEC";
                                   $score +=$row->score;
                                          $ct +=1;
                                 }
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
                               <td>
                               <a style="color: #3699FF" href="RDashboard?event=<?php echo $year."-".$quarter."-".$asid; ?>"><?php echo $year."-".$quarter; ?></a></td>
                             
                               <td><?php echo $period; ?></td>
                               <td><?php if($g){
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
                   </tbody>
              </table>
            </div>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>

        <?php
        $evyear ='';
        $evquarter ='';
        $totalscore3=0;$totalscore2=0;$totalscore4=0;
        $ct2=0;$ct1=0;$ct3=0;$ct4=0;
        //$year ='';
        //$quarter ='';
        if($yr !='' and $q !='')
        {
          $quarter ='';
          $year  ='';
          $y = date('Y');
          $mon = date('m');
          $checkLast= DB::select(DB::raw("select year,quarterly from mnwv2.monitorevents where region_id='$asid' and areacompletestatus =1 and year='$yr' and quarterly='$q' group by year,quarterly"));
          if(!empty($checkLast))
          {
            
            $year = $checkLast[0]->year;
            $quarter = $checkLast[0]->quarterly;
          }
          ?>

        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <div class="card-header">
              <h3 class="card-title">Monitoring Event: <?php echo $year."-".$quarter; ?> </h3>
            </div><!-- /.box-header -->
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" style="font-size: 13;" class="table">
                <tr class="brac-color-pink">
                  <th>Section</th>
                  <th width="60%">Section Name</th>
                  <th width="20%">Achievement %</th>
                </tr>
              </table>
              <?php
          $totalscore =0;
          $cyear = date('Y');       
           //$mnth =date('m');
           $sectionpoint =0;
           $question_point=0;
           $data = array();
           $areas = DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$asid' and year='$yr' and quarterly='$q' and areacompletestatus =1"));
           if(!empty($areas))
           {
             for($i=1; $i <=5; $i++)
             {
               $sectionpoint =0;
               $question_point=0;
               foreach($areas as $r)
               {
                  $mnth = $r->month;
                  //echo $mnth;
                  $year = $r->year;
                  $quar= $r->quarterly;
                  $event_id = $r->id;
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
               ?>
              <table style="text-align: center;font-size:13;" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <?php
                if($totalscore !=0)
                {
                ?>
                  <tr  style="height:20px; color:black;">
                    <td nowrap="nowrap"><button id="<?php echo $i; ?>" class="btn btn-light showdiv" onClick="getDiv(<?php echo $i; ?>);" >+</button>
                        <a style="color: black;"><?php echo "Section: ".$i; ?></a></td>
                    <td width="60%" ><?php echo $name; ?></td>
                    <td width="20%" ><?php echo $totalscore."%"; ?></td>
                  </tr>
                <?php
                }
                ?>
               </table>
               <table style="text-align: center;font-size:13" id="<?php echo "dv".$i; ?>" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%"> 
                <thead>
                      <tr class="brac-color-pink">
                        <th style="text-align:center;">Area Name</th>
                        <th style="">Achievement %</th>
                      </tr>
                </thead>
                  <tbody>
                    <?php
                    $areadata = DB::select(DB::raw("select area_id from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and region_id='$asid' group by area_id"));
                    // var_dump($areadata);
                    $d = count($areadata);
                    $c = round($d/2);
                    
                   // $sec = $sect;
                  
                    foreach($areadata as $r)
                    {
                       $sp =0;
                       $qsp=0;
                       $areaid  =  $r->area_id;
                       $rdata = DB::select(DB::raw("select * from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and area_id='$areaid'"));
                       foreach ($rdata as $row) 
                       {
                    $eventid = $row->id;
                    $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$eventid' and section='$i'"));
                    if(!empty($data))
                    {
                      $sp +=$data[0]->sp;
                      $qsp +=$data[0]->qsp;
                    }
                       }
                      $score =0;
                      if($sp !=0)
                      {
                        $score =round((($sp*100)/$qsp),2);
                      }
                      //echo $event_id."-".$sp."/".$score."*";
                      //die();
                      $ct++;
                      $name ='';
                      $arean='';
                      $brname ='';
                      $areaname = DB::select( DB::raw("select * from branch where area_id='$areaid'"));
                      if(!empty($areaname))
                      {
                        $area_name = $areaname[0]->area_name;
                        $aid = $areaname[0]->area_id;
                        //echo $brname;
                      }
                      ?>
                    <tr>
                      <td style="color: black; text-align:center"><button class="btn btn-light" onClick="sectionBranchDiv(<?php echo $i.",".$areaid.",".$year.",'".$quar."'"; ?>)"><?php echo $area_name; ?></button></td>
                      <td><?php echo $score."%"; ?></td>
                   </tr>
                    <?php
                    } 
                    ?>
                    <?php
                    foreach($areadata as $r)
                      {
                        $aid=$r->area_id;
                    ?>
                    <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $aid."_".$i."_1"  }}" class="table  branchDiv1" style="display: none" cellspacing="0" width="100%">
                      <thead> 
                        <tr class="brac-color-pink">
                          <th width="50%" style="text-align:center;">Branch Name</th>
                          <th width="50%" style="">Achievement %</th>
                        </tr>
                      </thead>
                      <tbody>
                    </table>
                    <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $aid."_".$i."_2"  }}" class="table  branchDiv2" style="display: none" cellspacing="0" width="100%">
                      <tbody>
                        
                      </tbody>
                    </table>
                  <?php } ?>
                  <?php
                          foreach($areadata as $r)
                            {
                               $sp =0;
                               $qsp=0;
                               $areaid  =  $r->area_id;
                               $rdata = DB::select(DB::raw("select * from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and area_id='$areaid'"));
                               foreach ($rdata as $row) 
                               {
                                $event_id = $row->id;
                                ?>
                                <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $event_id."_".$i."_1"  }}" class="sectionView1" style="display: none">
                                  <th>Branch Name:- <span id="{{ $event_id."_".$i."_branchname"  }}"></span> </th>
                                </table> 
                                  <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $event_id."_".$i."_2"  }}" style="display: none" class="table  dt-responsive nowrap sectionView2" cellspacing="0" width="100%"> 
                                      <thead>
                                              <tr class="brac-color-pink">
                                              <th style="">SL</th>
                                              <th style=" width: 60%;">Details</th>
                                              <th style=" width: 20%;">Achievement %</th>
                                              </tr>
                                      </thead>
                                          <tbody>
                                              
                                          </tbody> 
                                      </table>
                                <?php
                               }
                            } 
                          ?>
                  </tbody> 
                </table> 
               <?php
            }
          }
        }
        else
        {
          $quarter ='';
          $year  ='';
          $y = date('Y');
          $mon = date('m');
          $checkLast= DB::select(DB::raw("select year,quarterly from mnwv2.monitorevents where region_id='$asid' and areacompletestatus =1 and year='$yr' group by year,quarterly order by year,quarterly desc limit 1"));
          if(!empty($checkLast))
          {
            
            $year = $checkLast[0]->year;
            $quarter = $checkLast[0]->quarterly;
          }
          ?>
         <div class="col-md-12">
            <div class="card card-custom gutter-b">
              <!--begin::Form-->
              <div class="card-header">
                <h3 class="card-title">Monitoring Event: <?php echo $year."-".$quarter; ?> </h3>
              </div><!-- /.box-header -->
              <div class="card-body table-responsive">
                <table style="text-align: center;font-size:13" style="font-size: 13;" class="table">
                  <tr class="brac-color-pink">
                    <th>Section</th>
                    <th width="60%">Section Name</th>
                    <th width="20%">Achievement %</th>
                  </tr>
                </table>
     
          <?php
          $totalscore =0;
          $cyear = date('Y');       
           //$mnth =date('m');
           $sectionpoint =0;
           $question_point=0;
           $data = array();
           $areas = DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$asid' and year='$year' and quarterly='$quarter' and areacompletestatus =1"));
           if(!empty($areas))
           {
             for($i=1; $i <=5; $i++)
             {
               $sectionpoint =0;
               $question_point=0;
               foreach($areas as $r)
               {
                  $mnth = $r->month;
                  //echo $mnth;
                  $year = $r->year;
                  $quar= $r->quarterly;
                  $event_id = $r->id;
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
               ?>
              <table style="text-align: center;font-size:13" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <?php
                if($totalscore !=0)
                {
                ?>
                  <tr  style="height:20px; color:black;">
                    <td nowrap="nowrap"><button id="<?php echo $i; ?>" class="btn btn-light showdiv" onClick="getDiv(<?php echo $i; ?>);" >+</button>
                        <a style="color: black;"><?php echo "Section: ".$i; ?></a></td>
                    <td width="60%" ><?php echo $name; ?></td>
                    <td width="20%" ><?php echo $totalscore."%"; ?></td>
                  </tr>
                <?php
                }
                ?>
               </table>
               <table style="text-align: center;font-size:13" id="<?php echo "dv".$i; ?>" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%"> 
                <thead>
                      <tr class="brac-color-pink">
                        <th style="text-align:center;">Area Name</th>
                        <th style="">Achievement %</th>
                      </tr>
                </thead>
                  <tbody>
                    <?php
                    $areadata = DB::select(DB::raw("select area_id from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and region_id='$asid' group by area_id"));
                    // var_dump($areadata);
                    $d = count($areadata);
                    $c = round($d/2);
                    
                   // $sec = $sect;
                  
                    foreach($areadata as $r)
                    {
                       $sp =0;
                       $qsp=0;
                       $areaid  =  $r->area_id;
                       $rdata = DB::select(DB::raw("select * from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and area_id='$areaid'"));
                       foreach ($rdata as $row) 
                       {
                    $eventid = $row->id;
                    $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$eventid' and section='$i'"));
                    if(!empty($data))
                    {
                      $sp +=$data[0]->sp;
                      $qsp +=$data[0]->qsp;
                    }
                       }
                      $score =0;
                      if($sp !=0)
                      {
                        $score =round((($sp*100)/$qsp),2);
                      }
                      //echo $event_id."-".$sp."/".$score."*";
                      //die();
                      $ct++;
                      $name ='';
                      $arean='';
                      $brname ='';
                      $areaname = DB::select( DB::raw("select * from branch where area_id='$areaid'"));
                      if(!empty($areaname))
                      {
                        $area_name = $areaname[0]->area_name;
                        $aid = $areaname[0]->area_id;
                        //echo $brname;
                      }
                      ?>
                    <tr>
                      <td style="color: black; text-align:center"><button class="btn btn-light" onClick="sectionBranchDiv(<?php echo $i.",".$areaid.",".$year.",'".$quar."'"; ?>)"><?php echo $area_name; ?></button></td>
                      <td ><?php echo $score."%"; ?></td>
                   </tr>
                    <?php
                    } 
                    ?>
                    <?php
                    foreach($areadata as $r)
                      {
                        $aid=$r->area_id;
                    ?>
                    <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $aid."_".$i."_1"  }}" class="table  branchDiv1" style="display: none" cellspacing="0" width="100%">
                      <thead> 
                        <tr class="brac-color-pink">
                          <th width="50%" style="text-align:center;">Branch Name</th>
                          <th width="50%" style="">Achievement %</th>
                        </tr>
                      </thead>
                      <tbody>
                    </table>
                    <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $aid."_".$i."_2"  }}" class="table  branchDiv2" style="display: none" cellspacing="0" width="100%">
                      <tbody>
                        
                      </tbody>
                    </table>
                  <?php } ?>
                  <?php
                          foreach($areadata as $r)
                            {
                               $sp =0;
                               $qsp=0;
                               $areaid  =  $r->area_id;
                               $rdata = DB::select(DB::raw("select * from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and area_id='$areaid'"));
                               foreach ($rdata as $row) 
                               {
                                $event_id = $row->id;
                                ?>
                                <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $event_id."_".$i."_1"  }}" class="sectionView1" style="display: none">
                                  <th>Branch Name:- <span id="{{ $event_id."_".$i."_branchname"  }}"></span> </th>
                                </table> 
                                  <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $event_id."_".$i."_2"  }}" style="display: none" class="table  dt-responsive nowrap sectionView2" cellspacing="0" width="100%"> 
                                      <thead>
                                              <tr class="brac-color-pink">
                                              <th style="">SL</th>
                                              <th style=" width: 60%;">Details</th>
                                              <th style=" width: 20%;">Achievement %</th>
                                              </tr>
                                      </thead>
                                          <tbody>
                                              
                                          </tbody> 
                                      </table>
                                <?php
                               }
                            } 
                          ?>
                  </tbody> 
                </table> 
               <?php
            }
           }
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
<script>
  $(document).ready(function(){
     $("#dv1").hide();
     $("#dv2").hide();
     $("#dv3").hide();
     $("#dv4").hide();
     $("#dv5").hide();
     $(".sectionView1").hide(); 
       $(".sectionView2").hide(); 
       $(".branchDiv1").hide(); 
    $(".branchDiv2").hide(); 
  });
  function sectionBranchDiv(serial,area,year,quarter){
    $(".branchDiv1").hide(); 
    $(".branchDiv2").hide(); 
    $("#" +area+"_"+serial+"_1").show(); 
    $("#" +area+"_"+serial+"_2").show(); 
    $("#" +area+"_"+serial+"_2 tbody").empty();
    $.ajax({
            type: 'GET',
            url: '/mnwv2/branchwise?areaid='+serial+','+area+','+year+','+quarter,
            dataType: 'json',
            success: function (data) {
              // console.log(data.eventid[0]);
                $("#"+area+"_"+serial+"_2 tbody").empty();
                // console.log(data.serials.length);
                if(data.eventid.length==0){
                    $("#"+area+"_"+serial+"_2 tbody").append('<tr><td colspan="2" align="center">No data available</td></tr>')
                }else{
                    for(var i=0; i<data.eventid.length; i++){
                        var serial    =data.serial
                        var year    =data.year
                        var quarter    =data.quarter
                        var eventid =data.eventid[i]
                        var branchname   =data.branchname[i]
                        var score      =data.score[i]
                        
                        var div='<tr><td width="50%" style="color:black;text-align:center"><button class="btn btn-light" onClick="sectionDiv('
                        div += eventid + ","+ serial
                        div += ')"'
                        div += ')">'
                        div += branchname
                        div += '</button></td><td width="50%">'
                        div += score+'%'
                        div += '</td></tr>'

                        $("#"+area+"_"+serial+"_2 tbody").append(div)
                    }
                }
            },
            error: function (ex) {
                alert('Failed to retrieve Period.');
            }
        });
  }



  function sectionDiv(event,serial){
        $(".sectionView1").hide(); 
        $(".sectionView2").hide(); 
        $("#" +event+"_"+serial+"_1").show(); 
        $("#" +event+"_"+serial+"_2").show(); 
        $.ajax({
            type: 'GET',
            url: '/mnwv2/SectionDetails?section='+serial+','+event,
            dataType: 'json',
            success: function (data) {
                $("#" +event+"_"+serial+"_2 tbody").empty();
                console.log(data.serials.length);
                $("#" +event+"_"+serial+"_branchname").text(data.branchname); 
                if(data.serials.length==0){
                    $("#"+event+"_"+serial+"_2 tbody").append('<tr><td colspan="3" align="center">No data available</td></tr>')
                }else{
                    for(var i=0; i<data.serials.length; i++){
                        var section    =data.serials[i].section
                        var subsection =data.serials[i].sub_id
                        var question   =data.questions[i]
                        var score      =data.scores[i]
                        
                        var div="<tr><td>"
                        div += section + "."
                        div += subsection
                        div += "</td><td>"
                        div += question
                        div += "</td><td>"
                        div += score
                        div += "%</td></tr>"

                        $("#"+event+"_"+serial+"_2 tbody").append(div)
                    }
                }
            },
            error: function (ex) {
                alert('Failed to retrieve Period.');
            }
        });
    }
     function getDiv(judu){
      $(".sectionView1").hide(); 
       $(".sectionView2").hide(); 
       $(".branchDiv1").hide(); 
    $(".branchDiv2").hide(); 
     var button_text = $('#' + judu).text();
    if(button_text == '+')
    {
      for (var i = 1; i < 6; i++)
      {
        if(judu == i)
        {
          $("#dv" + judu).show();
          $('#' + judu).html('-');
 
        }
        else
        {
          $("#dv" + i).hide();       
          $('#' + i).html('+');
        }
      }
      
    }
    else
    {
      $('#dv' + judu).hide();
      $('#' + judu).html('+');
    }
   }

</script>
@endsection