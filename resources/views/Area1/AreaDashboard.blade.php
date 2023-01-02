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
    @extends('DataProcessing/AreaDataProcessing')
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
@extends('mainpage')

@section('title','Table')


@section('content')

  <div class="row">
    <div class="panel panel-default">
      <div class="header">
        <h3><i>Area Dashboard:</i></h3>
        <br />
      </div>
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
        $completestatus = DB::select(DB::raw("select * from mnwv2.monitorevents where area_id='$a_id'"));
        if(!empty($completestatus))
        {
          foreach($completestatus as $r)
          {
            $month  = $r->month;
            $eid = $r->id;
            $brc = $r->branchcode;
            $year = $r->year;
            $checkstatus = DB::select(DB::raw("select * from mnwv2.monitorevents where area_id='$a_id' and id='$eid' and areacompletestatus=1"));
            if(empty($checkstatus))
            {
              if($mont >='01' and $mont <='03')
              {
                if($mont==$month and $yar == $year)
                {
                  
                }
                else
                {
                  $updateareacompletestatus = DB::table('mnwv2.monitorevents')->where('id',$eid)->where('branchcode',$brc)->update(['areacompletestatus'=>1]);
                }
              }
              else if($mont >='04' and $mont <='06')
              {
                if($mont==$month and $yar == $year)
                {
                  
                }
                else
                {
                  $updateareacompletestatus = DB::table('mnwv2.monitorevents')->where('id',$eid)->where('branchcode',$brc)->update(['areacompletestatus'=>1]);
                }
              }
              else if($mont >='07' and $mont <='09')
              {
                if($mont==$month and $yar == $year)
                {
                  
                }
                else
                {
                  $updateareacompletestatus = DB::table('mnwv2.monitorevents')->where('id',$eid)->where('branchcode',$brc)->update(['areacompletestatus'=>1]);
                }
              }
              else if($mont >='10' and $mont <='12')
              {
                if($mont==$month and $yar == $year)
                {
                  
                }
                else
                {
                  $updateareacompletestatus = DB::table('mnwv2.monitorevents')->where('id',$eid)->where('branchcode',$brc)->update(['areacompletestatus'=>1]);
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
        $divisionname = $areadata[0]->division_name;
        $regionname=$areadata[0]->region_name;
        $areaname=$areadata[0]->area_name;
        $region_id = $areadata[0]->region_id;
        $div_id = $areadata[0]->division_id;
        $area_id = $areadata[0]->area_id;
      ?>
      <div id="rcorners">
        <div class="row">
          <form action="GlobalData" method="GET">
              <div class="column">
              <div class="division">Division Name</div>
              <div class="brone">
                <select name="division" class="options">
                  <option value="<?php echo $div_id; ?>"><?php echo $divisionname; ?></option>
                </select>
              </div>
              </div>
              <div class="column">
              <div class="region">Region Name</div>
              <div class="brone">
                <select name="region" class="options">
                  <option value="<?php echo $region_id;?>"><?php echo $regionname; ?></option>
                  
                </select>
              </div>
              </div>
              <div class="column">
              <div class="area">Area Name</div>
              <div class="brone">
                <select name="area_id" class="options"  onchange="this.form.submit()">
                  <option value="<?php echo $area_id; ?>"><?php echo $areaname; ?></option>
                  <?php if(isset($_GET['area_id']))
                   {
                    $rig= $_GET['region'];
                    $region = DB::select( DB::raw("select area_id,area_name from branch where region_id='$rig' and program_id='1' group by area_id,area_name order by area_name ASC"));
                     
                     foreach($region as $row)
                     {
                       ?>
                         <option value="<?php echo $row->area_id; ?>"><?php echo $row->area_name; ?></option>
                       <?php
                     }
                   }
                   ?>
                </select>
              </div>
              </div>
            </form>
          </div>
      <br />
       <table style="text-align: center;font-size:13" class="table table-hover" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Monitoring Event</th>
            <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Monitoring Period</th>
            <th style="background-color:#92D050; color:black; border: 1px solid white;">Good</th>
            <th style="background-color:#D7E4BC; color:black; border: 1px solid white;">Modarate</th>
            <th style="background-color:#FAC090; color:black; border: 1px solid white;">Poor</th>
          </tr>
        </thead>
        <tbody>
          <?php
		      
              $cmonth = date('m');
			  $mnth = date('m');
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
                 $checkdata= DB::select(DB::raw("select year,quarterly from mnwv2.monitorevents where area_id='$a_id' and areacompletestatus =1 group by year,quarterly  order by year DESC, quarterly DESC LIMIT 2"));
                 
                 if(!empty($checkdata))
                 {
                   foreach($checkdata as $row)
                   {
                     $year = $row->year;
                     $quarter = $row->quarterly;
                     $m='';
                     $p='';
                     $g='';
                     foreach($areadata as $rw)
                     {
                       $brcode = $rw->branch_id;
                       $cnt= strlen($brcode);
                       if($cnt == 3)
                       {
                         $brcode='0'.$brcode;
                       }
                       $checkbrnch= DB::select(DB::raw("select * from mnwv2.monitorevents where branchcode='$brcode' and year='$year' and quarterly = '$quarter' and area_id='$a_id'"));
                       if(!empty($checkbrnch))
                       {
                         $myear = $checkbrnch[0]->year;
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
                     //echo $score."/";
                     //die();
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
                         $p = 'Poor';
                       }
                       //echo $g."/".$m."*".$p;
                       ?>
                      <tr>
                        <td>
                        <a style="color: black;" class="btn btn-danger" href="HomeDashboardA?event=<?php echo $year."-".$quarter."-".$a_id; ?>"><?php echo $year."-".$quarter; ?></a></td>
                      
                        <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger"><?php echo $period; ?></a></td>
                        <td style="color: black; text-align: center;"><?php if($g){
                          ?>
                          <input type="checkbox" checked>
                          <?php
                        } ?></td>
                        <td style="color: black; text-align: center;"><?php if($m){
                          ?>
                          <input type="checkbox" checked>
                          <?php
                        } ?></td>
                        <td style="color: black; text-align: center;"><?php if($p){
                          ?>
                          <input type="checkbox" checked>
                          <?php
                        } ?></td>
                      </tr>
                     <?php
                     }
                     
                     //echo $score."/".$ct."-".$year."*".$quarter;
                     //die();
                   }
                 }
              ?>
        </tbody>
      </table>
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
          
          ?>
          <div id="cycle">
          <div class="cycle">
          Monitoring Event: <?php echo $evyear."-".$evquarter; ?>
          </div>
        </div>
        <br />
         <table style="text-align: center;font-size:13" class="table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
           <thead>
          <tr style="height:25px;">
            <th  width="8%" style="background-color:#BFBFBF; color:black; border: 1px solid white; text-align: center;">Section</th>
            <th width="50%" style="background-color:#BFBFBF; color:black; border: 1px solid white; text-align: center;">Section Name</th>
            <th width="30%" style="background-color:#BFBFBF; color:black; border: 1px solid white; text-align: center;">Achievement %</th>  
          </tr>
           </thead>
          <tbody>
          <?php
            $cyear = date('Y');       
          $sectionpoint =0;
          $question_point=0;
          $year = 0;
           $areas = DB::select(DB::raw("select * from mnw.monitorevents where area_id='$a_id' and year='$evyear' and quarterly='$evquarter'"));
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
                
                if($month < 4)
                {
                  //echo $mnth; 
                  if(($mnth >='1' and $mnth <='3') and $year == $cyear)
                  {
                    
                    
                  }
                  else
                  {
                    $year1 = $r->year;
                    $quar = $year1."-".$quar;
                    $event_id = $r->id;
                    $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnw.cal_section_point where event_id='$event_id' and section='$i'"));
                    $totalscore1 += $r->score;
                    $ct1 +=1;
                  }
                }
                if($month >=4 and $month < 7)
                {
                  
                  if(($mnth >='4' and $mnth <='6') and $year=='$cyear')
                  {
                    

                  }
                  else
                  {
                    $year1 = $r->year;
                    $quar = $year1."-".$quar;
                    $event_id = $r->id;
                    //echo $event_id."/";
                    $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnw.cal_section_point where event_id='$event_id' and section='$i'"));
                    $totalscore2 += $r->score;
                    $ct2 +=1;
                  }
                }
                if($month >=7 and $month < 10)
                {
                  
                  if(($mnth >='7' and $mnth <='9') and $year=='$cyear')
                  {
                    

                  }
                  else
                  {
                    $year1 = $r->year;
                    $quar = $year1."-".$quar;
                    $event_id = $r->id;
                    $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnw.cal_section_point where event_id='$event_id' and section='$i'"));
                    $totalscore3 += $r->score;
                    $ct3 +=1;
                  }
                }
                if($month >= 10 and $month <=12)
                {
                  if(($mnth >='10' and $mnth <='12') and $year=='$cyear')
                  {
                    

                  }
                  else
                  {
                    $year1 = $r->year;
                    $quar = $year1."-".$quar;
                    $event_id = $r->id;
                    $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnw.cal_section_point where event_id='$event_id' and section='$i'"));
                    $totalscore4 += $r->score;
                    $ct4 +=1;
                  }
                }
                if(!empty($data))
                {
                  $sectionpoint += $data[0]->sp;
                  $question_point += $data[0]->qsp;
                }
                 
               }
               if($sectionpoint !=0)
               {
                 $totalscore = round((($sectionpoint/$question_point)*100),2); 
               }
             $secname = DB::select( DB::raw("select * from mnw.def_sections where sec_no='$i'"));
             if(empty($secname))
             {
              
             }
            else{
              $name = $secname[0]->sec_name;
            }
            if($i==1)
            {
              if($totalscore !=0)
              {
              ?>
                <tr  style="height:20px; color:black;">
                  <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$evyear.",".$quarter.",".$mnth.",".$a_id; ?>"><?php echo "Section: ".$i; ?></a></td>
                  <td width="50%" ><?php echo $name; ?></td>
                  <td width="30%" style="text-align: center;" ><?php echo $totalscore."%"; ?></td>
                </tr>
              <?php
              }
            }
            if($i==2)
            {
              if($totalscore !=0)
              {
              ?>
                <tr  style="height:20px; color:black;">
            
                  <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$evyear.",".$quarter.",".$mnth.",".$a_id; ?>"><?php echo "Section: ".$i; ?></a></td>
                  <td width="50%"><?php echo $name; ?></td>
                  <td width="30%" style="text-align: center;" ><?php echo $totalscore."%"; ?></td>
                </tr>
              <?php
              }
            }
            if($i==3)
            {
              if($totalscore !=0)
              {
              ?>
                <tr  style="height:20px; color:black;">
                  
                  
                  <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$evyear.",".$quarter.",".$mnth.",".$a_id; ?>"><?php echo "Section: ".$i; ?></a></td>
                  <td width="50%"><?php echo $name; ?></td>
                  <td width="30%" style="text-align: center;"><?php echo $totalscore."%"; ?></td>
                </tr>
              <?php
              }
            }
            if($i==4)
            {
              if($totalscore !=0)
              {
              ?>
                <tr  style="height:20px; color:black;">
                  
                  
                  <td style="color: black;text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$evyear.",".$quarter.",".$mnth.",".$a_id; ?>"><?php echo "Section: ".$i; ?></a></td>
                  <td width="50%"><?php echo $name; ?></td>
                  <td width="30%" style="text-align: center;"><?php echo $totalscore."%"; ?></td>
                </tr>
              <?php
              }
            }
            if($i==5)
            {
              if($totalscore !=0)
              {
              ?>
                <tr  style="height:20px; color:black;">
                   <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$evyear.",".$quarter.",".$mnth.",".$a_id; ?>"><?php echo "Section: ".$i; ?></a></td>
                  <td width="50%"><?php echo $name; ?></td>
                  <td width="30%" style="text-align: center;"><?php echo $totalscore."%"; ?></td>
                </tr>
              <?php
              }
            }
             }
           }
          ?>
          </tbody>
        </table>
        <?php
        }
        else
        {
          
          $quarter ='';
          $year  ='';
          $y = date('Y');
          $mon = date('m');
          $checkLast= DB::select(DB::raw("select * from mnw.monitorevents where area_id='$a_id' and areacompletestatus =1 order by id DESC LIMIT 1"));
          if(!empty($checkLast))
          {
            
            $year = $checkLast[0]->year;
            $quarter = $checkLast[0]->quarterly;
          }
          ?>
          <div id="cycle">
            <div class="cycle">
                Monitoring Event: <?php echo $year."-".$quarter; ?>
            </div>
        </div>
        <br />
                    <table style="text-align: center;font-size:13" class="table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
           <thead>
          <tr style="height:25px;">
            <th  width="8%" style="background-color:#BFBFBF; color:black; border: 1px solid white; text-align: center;">Section</th>
            <th width="50%" style="background-color:#BFBFBF; color:black; border: 1px solid white; text-align: center;">Section Name</th>
            <th width="30%" style="background-color:#BFBFBF; color:black; border: 1px solid white; text-align: center;">Achievement %</th>
            
          </tr>
           </thead>
          <tbody>
          <?php
          $cycle = $year."-".$quarter;
            $cyear = date('Y');       
           //$mnth =date('m');
           $sectionpoint =0;
           $question_point=0;
           $data = array();
           $exp = explode('-',$cycle);
           $evyear = $exp[0];
           $quarter = $exp[1];
           $areas = DB::select(DB::raw("select * from mnw.monitorevents where area_id='$a_id' and year='$evyear' and quarterly='$quarter'"));
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
                
                if($month < 4)
                {
                  //echo $mnth; 
                  if(($mnth >='1' and $mnth <='3') and $year == $cyear)
                  {
                    
                    
                  }
                  else
                  {
                    $year1 = $r->year;
                    $quar = $year1."-".$quar;
                    $event_id = $r->id;
                    $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnw.cal_section_point where event_id='$event_id' and section='$i'"));
                    $totalscore1 += $r->score;
                    $ct1 +=1;
                  }
                }
                if($month >=4 and $month < 7)
                {
                  
                  if(($mnth >='4' and $mnth <='6') and $year=='$cyear')
                  {
                    

                  }
                  else
                  {
                    $year1 = $r->year;
                    $quar = $year1."-".$quar;
                    $event_id = $r->id;
                    //echo $event_id."/";
                    $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnw.cal_section_point where event_id='$event_id' and section='$i'"));
                    $totalscore2 += $r->score;
                    $ct2 +=1;
                  }
                }
                if($month >=7 and $month < 10)
                {
                  
                  if(($mnth >='7' and $mnth <='9') and $year=='$cyear')
                  {
                    

                  }
                  else
                  {
                    $year1 = $r->year;
                    $quar = $year1."-".$quar;
                    $event_id = $r->id;
                    $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnw.cal_section_point where event_id='$event_id' and section='$i'"));
                    $totalscore3 += $r->score;
                    $ct3 +=1;
                  }
                }
                if($month >= 10 and $month <=12)
                {
                  if(($mnth >='10' and $mnth <='12') and $year=='$cyear')
                  {
                    

                  }
                  else
                  {
                    $year1 = $r->year;
                    $quar = $year1."-".$quar;
                    $event_id = $r->id;
                    //echo $event_id."/";
                    $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnw.cal_section_point where event_id='$event_id' and section='$i'"));
                    $totalscore4 += $r->score;
                    $ct4 +=1;
                    //echo "huda";
                  }
                }
                if(!empty($data))
                {
                  $sectionpoint += $data[0]->sp;
                  $question_point += $data[0]->qsp;
                }
                // 
                 
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
            else{
              $name = $secname[0]->sec_name;
            }
            if($i==1)
            {
              if($totalscore !=0)
              {
              ?>
                <tr  style="height:20px; color:black;">
                  <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$evyear.",".$quarter.",".$mnth.",".$a_id; ?>"><?php echo "Section: ".$i; ?></a></td>
                  <td width="50%" ><?php echo $name; ?></td>
                  <td width="30%" style="text-align: center;" ><?php echo $totalscore."%"; ?></td>
                </tr>
              <?php
              }
            }
            if($i==2)
            {
              if($totalscore !=0)
              {
              ?>
                <tr  style="height:20px; color:black;">
            
                  <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$evyear.",".$quarter.",".$mnth.",".$a_id; ?>"><?php echo "Section: ".$i; ?></a></td>
                  <td width="50%"><?php echo $name; ?></td>
                  <td width="30%" style="text-align: center;" ><?php echo $totalscore."%"; ?></td>
                </tr>
              <?php
              }
            }
            if($i==3)
            {
              if($totalscore !=0)
              {
              ?>
                <tr  style="height:20px; color:black;">
                  
                  
                  <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$evyear.",".$quarter.",".$mnth.",".$a_id; ?>"><?php echo "Section: ".$i; ?></a></td>
                  <td width="50%"><?php echo $name; ?></td>
                  <td width="30%" style="text-align: center;"><?php echo $totalscore."%"; ?></td>
                </tr>
              <?php
              }
            }
            if($i==4)
            {
              if($totalscore !=0)
              {
              ?>
                <tr  style="height:20px; color:black;">
                  
                  
                  <td style="color: black;text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$evyear.",".$quarter.",".$mnth.",".$a_id; ?>"><?php echo "Section: ".$i; ?></a></td>
                  <td width="50%"><?php echo $name; ?></td>
                  <td width="30%" style="text-align: center;"><?php echo $totalscore."%"; ?></td>
                </tr>
              <?php
              }
            }
            if($i==5)
            {
              if($totalscore !=0)
              {
              ?>
                <tr  style="height:20px; color:black;">
                   <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$evyear.",".$quarter.",".$mnth.",".$a_id; ?>"><?php echo "Section: ".$i; ?></a></td>
                  <td width="50%"><?php echo $name; ?></td>
                  <td width="30%" style="text-align: center;"><?php echo $totalscore."%"; ?></td>
                </tr>
              <?php
              }
            }
             }
           }
           
          ?>
          </tbody>
        </table>
        <?php
        }
        ?>
    </div>
    </div>
 </div>
@endsection
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script>
  $(document).ready(function(){
     $("#dv1").hide();
     $("#dv2").hide();
     $("#dv3").hide();
     $("#dv4").hide();
     $("#dv5").hide();
  });
     function getDiv(judu){
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
