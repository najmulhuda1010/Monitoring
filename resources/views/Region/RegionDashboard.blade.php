<?php 
$username = Session::get('username');
if($username=='')
{
  
  ?>
  <script>
    window.location.href = 'logout';
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

@section('title','Region Dashboard')

@section('content')
<?php
      $calculation=1;
      $dataload1="true";
      //echo $dataload1;
      $dataload1 = $dataload;
      if($dataload1 =="true")
      {
        //echo "Test";
        if($calculation==1)
        {

        }
        $mont = date('m');
        $yar = date('Y');
        $completestatus = DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$a_id'"));
        if(!empty($completestatus))
        {
          foreach($completestatus as $r)
          {
            $month  = $r->month;
            $eid = $r->id;
            $brc = $r->branchcode;
            $year = $r->year;
            $checkstatus = DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$a_id' and id='$eid' and areacompletestatus=1"));
            if(empty($checkstatus))
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
					  if(($month >='01' and $month <='03') and $yar == $year)
					  {
						  $updateareacompletestatus = DB::table('mnwv2.monitorevents')->where('id',$eid)->where('branchcode',$brc)->update(['areacompletestatus'=>1]);
					  }
					
				  }
				} 
            }
          }
        }
      }
      $divisionname=""; 
      $regionname="";
      $areaname="";
      $region_id=0;
      $div_id =0;
      $area_id=0;
      $divisionname = $regiondata[0]->division_name;
      $regionname=$regiondata[0]->region_name;
      $region_id = $regiondata[0]->region_id;
      $div_id = $regiondata[0]->division_id;
      ?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Region Dashboard</h5>
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
            <form action="GlobalData" method="GET">
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <p class="font-size-h4">Division : <?php echo $divisionname; ?></p>
                  </div>
                  <div class="col-md-3">
                    <p class="font-size-h4">Region : <?php echo $regionname; ?></p>
                  </div>
            </div>
            </div>
            </form>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
        <br>
        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" class="table table-bordered">
                <tr class="brac-color-pink">
                  <th>Monitoring Event</th>
                  <th>Monitoring Period</th>
                  <th>Result</th>
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
             //$checkdata= DB::select(DB::raw("select area_id, year,quarterly from mnw.monitorevents where area_id='$a_id' group by area_id,year,quarterly order by year DESC, quarterly DESC OFFSET 0 LIMIT 3"));
             $checkdataPrevious= DB::select(DB::raw("select year,quarterly from mnwv2.monitorevents where region_id='$a_id' and areacompletestatus =1 group by year,quarterly  order by year DESC, quarterly DESC LIMIT 2"));
             $checkdataCurrent= DB::select(DB::raw("select year,quarterly from mnwv2.monitorevents where region_id='$a_id' and areacompletestatus =0 group by year,quarterly  order by year DESC, quarterly DESC LIMIT 1"));
             
             if(!empty($checkdataCurrent))
             {
               foreach($checkdataCurrent as $row)
               {
                 $year = $row->year;
                 $quarter = $row->quarterly;
                 //echo $quarter;
                 $m='';
                 $p='';
                 $g='';
                 foreach($regiondata as $rw)
                 {
                   $brcode = $rw->branch_id;
                   //echo $brcode."/";
                   $cnt= strlen($brcode);
                   if($cnt == 3)
                   {
                     $brcode='0'.$brcode;
                   }
                   $checkbrnch= DB::select(DB::raw("select * from mnwv2.monitorevents where branchcode='$brcode' and year='$year' and quarterly = '$quarter' and region_id='$a_id'"));
                   if(!empty($checkbrnch))
                   {
                     $myear = $checkbrnch[0]->year;
                     //echo $myear;
                     $month = $checkbrnch[0]->month;
                   //  echo $month."/".$cmonth;
                     if($month <='03')
                     {
                       
                      if(($mnth >='01' and $mnth <='03') and ($myear==$cyear))
                      {
                        $period = $myear.","."JAN"." to ".$myear.","."MAR";
                                  
                                  // if($checkbrnch[0]->score==null){
                                    $ongoing=1;
                                  // }
                                  $score =$checkbrnch[0]->score;
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
                        
                        $period = $myear.","."APR"." to ".$myear.","."JUN";
                                  
                                  // if($checkbrnch[0]->score==null){
                                    $ongoing=1;
                                  // }
                                  $score =$checkbrnch[0]->score;
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
                        $period = $myear.","."JUL"." to ".$myear.","."SEP";
                                  // if($checkbrnch[0]->score==null){
                                    $ongoing=1;
                                  // }
                                  $score =$checkbrnch[0]->score;
        
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
                        $period = $myear.","."OCT"." to ".$myear.","."DEC";
                                  // if($checkbrnch[0]->score==null){
                                    $ongoing=1;
                                  // }
                                  $score =$checkbrnch[0]->score;
        
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
                 //echo $score."/";
                 //die();
                 if($score !=0 or $score==null)
                  {
                    if($score!=null){
                      if($ct !=0)
                      {
                        $totalscore = round($score/$ct,2);
                      }
                      else{
                        $totalscore =0;
                      }
                    }
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
                    }elseif($ongoing==1){
                      $current='current';
                    }
                   //echo $g."/".$m."*".$p;
                   ?>
                  <tr>
                    <td>
                    <a style="color: #3699FF" class="btn" href="RDashboard?event=<?php echo $year."-".$quarter."-".$a_id; ?>"><?php echo $year."-".$quarter; ?></a></td>
                  
                    <td style="color: black; "><?php echo $period; ?></td>
                    <td style="color: black;"><?php if($g){
                        echo "Good";
                    } if($m){
                    echo "Moderate";
                    } if($p){
                    echo "Need Improvement";
                    } if($ongoing==1){
                      echo "Ongoing";
                    }?></td>
                  </tr>
                 <?php
                 }
                 
                 //echo $score."/".$ct."-".$year."*".$quarter;
                 //die();
               }
             }
             if(!empty($checkdataPrevious))
             {
               foreach($checkdataPrevious as $row)
               {
                 $year = $row->year;
                 $quarter = $row->quarterly;
                 //echo $quarter;
                 $m='';
                 $p='';
                 $g='';
                 foreach($regiondata as $rw)
                 {
                   $brcode = $rw->branch_id;
                   //echo $brcode."/";
                   $cnt= strlen($brcode);
                   if($cnt == 3)
                   {
                     $brcode='0'.$brcode;
                   }
                   $checkbrnch= DB::select(DB::raw("select * from mnwv2.monitorevents where branchcode='$brcode' and year='$year' and quarterly = '$quarter' and region_id='$a_id'"));
                   if(!empty($checkbrnch))
                   {
                     $myear = $checkbrnch[0]->year;
                     //echo $myear;
                     $month = $checkbrnch[0]->month;
                   //  echo $month."/".$cmonth;
                     if($month <='03')
                     {
                       
                      if(($mnth >='01' and $mnth <='03') and ($myear==$cyear))
                      {
                        
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
                 //echo $score."/";
                 //die();
                    if($score!=null){
                      if($ct !=0)
                      {
                        $totalscore = round($score/$ct,2);
                      }
                      else{
                        $totalscore =0;
                      }
                    }
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
                    <a style="color: #3699FF" class="btn" href="RDashboard?event=<?php echo $year."-".$quarter."-".$a_id; ?>"><?php echo $year."-".$quarter; ?></a></td>
                  
                    <td style="color: black; "><?php echo $period; ?></td>
                    <td style="color: black;"><?php if($g){
                        echo "Good";
                    } if($m){
                    echo "Moderate";
                    } if($p){
                    echo "Need Improvement";
                    }?></td>
                  </tr>
                 <?php
                 
                 //echo $score."/".$ct."-".$year."*".$quarter;
                 //die();
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
          $evyear ='';
          $evquarter ='';
          $totalscore3=0;$totalscore2=0;$totalscore4=0;
          $ct2=0;$ct1=0;$ct3=0;$ct4=0;
          $evyear = $eventyear;
          $evquarter = $eventquarter;
          //$year ='';
          //$quarter ='';
          if($evyear !='' and $evquarter !='')
          {
        $quarter ='';
            $year  ='';
            $y = date('Y');
            $mon = date('m');
            $checkLast= DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$a_id' and areacompletestatus =1 order by id DESC LIMIT 1"));
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
              <h3 class="card-title">Monitoring Event: <?php echo $evyear."-".$evquarter; ?> </h3>
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
                  $cycle = $evyear."-".$evquarter;
                    $cyear = date('Y');       
                   //$mnth =date('m');
                   $sectionpoint =0;
                   $question_point=0;
                   $data = array();
                   $exp = explode('-',$cycle);
                   $evyear = $exp[0];
                   $quarter = $exp[1];
                   $areas = DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$a_id' and year='$evyear' and quarterly='$evquarter'"));
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
                      <table style="text-align: center;font-size:13" style="font-size: 13;" class="table table-striped  dt-responsive nowrap" cellspacing="0" width="100%">
                        <?php
                        if($totalscore !=0)
                        {
                        ?>
                          <tr  style="height:20px; color:black;">
                            <td nowrap="nowrap" style="color: black;"><button id="<?php echo $i; ?>" class="btn btn-light showdiv" onClick="getDiv(<?php echo $i; ?>);" >+</button>
                                <a style="color: black;"><?php echo "Section: ".$i; ?></a></td>
                            <td width="60%" ><?php echo $name; ?></td>
                            <td width="20%" style="" ><?php echo $totalscore."%"; ?></td>
                          </tr>
                        <?php
                        }
                        ?>
                       </table>
                       <table style="text-align: center;font-size:13" style="font-size: 13;" id="<?php echo "dv".$i; ?>" class="table  dt-responsive nowrap" cellspacing="0" width="100%"> 
                        <thead>
                              <tr class="brac-color-pink">
                                <th width="50%" style="text-align:center;">Area Name</th>
                                <th width="50%" style="">Achievement %</th>
                              </tr>
                        </thead>
                          <tbody>
                            <?php
                            $areadata = DB::select(DB::raw("select area_id from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and region_id='$a_id' group by area_id"));
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
                              <td width="10%" style="color: black; text-align:center"><button class="btn btn-light" onClick="sectionBranchDiv(<?php echo $i.",".$areaid.",".$year.",'".$quar."'"; ?>)"><?php echo $area_name; ?></button></td>
                              <td width="10%" ><?php echo $score."%"; ?></td>
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
                  $checkLast= DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$a_id' and areacompletestatus =1 order by id DESC LIMIT 1"));
                  if(!empty($checkLast))
                  {

                    $mnths = $checkLast[0]->month;

              if($mon >='01' and $mon <='03')
              {
                if($mnths >='01' and $mnths <='03')
                {
                  
                }
                else
                {
                  $year = $checkLast[0]->year;
                            $quarter = $checkLast[0]->quarterly;
                }
              }
              else if($mon >='04' and $mon <='06')
              {
                if($mnths >='04' and $mnths <='06')
                {
                  
                }
                else
                {
                  $year = $checkLast[0]->year;
                            $quarter = $checkLast[0]->quarterly;
                }
              }
              else if($mon >='07' and $mon <='09')
              {
                if($mnths >='07' and $mnths <='09')
                {
                  
                }
                else
                {
                  $year = $checkLast[0]->year;
                            $quarter = $checkLast[0]->quarterly;
                }
              }
              else if($mon >='10' and $mon <='12')
              {
                if($mnths >='10' and $mnths <='12')
                {
                  
                }
                else
                {
                  $year = $checkLast[0]->year;
                            $quarter = $checkLast[0]->quarterly;
                }
              }
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
                  $cycle = $year."-".$quarter;
                    $cyear = date('Y');       
                   //$mnth =date('m');
                   $sectionpoint =0;
                   $question_point=0;
                   $data = array();
                   $exp = explode('-',$cycle);
                   $evyear = $exp[0];
                   $quarter = $exp[1];
                   $areas = DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$a_id' and year='$evyear' and quarterly='$quarter'"));
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
                      <table style="text-align: center;font-size:13" style="font-size: 13;" class="table table-striped  dt-responsive nowrap" cellspacing="0" width="100%">
                        <?php
                        if($totalscore !=0)
                        {
                        ?>
                          <tr  style="height:20px; color:black;">
                            <td nowrap="nowrap" style="color: black;"><button class="btn btn-light" id="<?php echo $i; ?>" class="btn btn-light showdiv" onClick="getDiv(<?php echo $i; ?>);" >+</button>
                                <a style="color: black;"><?php echo "Section: ".$i; ?></a></td>
                            <td width="60%" ><?php echo $name; ?></td>
                            <td width="20%" style="" ><?php echo $totalscore."%"; ?></td>
                          </tr>
                        <?php
                        }
                        ?>
                       </table>
                       <table style="text-align: center;font-size:13" style="font-size: 13;" id="<?php echo "dv".$i; ?>" class="table dt-responsive nowrap" cellspacing="0" width="100%"> 
                        <thead>
                              <tr class="brac-color-pink">
                                <th width="50%" style=" text-align:center;">Area Name</th>
                                <th width="50%" style="">Achievement %</th>
                              </tr>
                        </thead>
                          <tbody>
                            <?php
                            $areadata = DB::select(DB::raw("select area_id from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and region_id='$a_id' group by area_id"));
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
                              <td width="10%" style="color: black; text-align:center"><button class="btn btn-light" onClick="sectionBranchDiv(<?php echo $i.",".$areaid.",".$year.",'".$quar."'"; ?>)"><?php echo $area_name; ?></button></td>
                              <td width="10%" ><?php echo $score."%"; ?></td>
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