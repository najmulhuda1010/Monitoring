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
<?php
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

$divisionname=""; 
$regionname="";
$areaname="";
$division_name = $areadata[0]->division_name;
$region_name=$areadata[0]->region_name;
$area_name=$areadata[0]->area_name;
?>
  <div class="row">
    <div class="panel panel-default">
      <div class="header">
        <h3><i>Area Current Dashboard:</i></h3>
        <br />
      </div>
      <div id="rcorners">
        <div class="row">
          <div class="column">
          <div class="division">Division Name</div>
            <div class="brone">
              <select name="select">
                <option value="<?php echo $division_name; ?>"><?php echo $division_name; ?></option>
              </select>
            </div>
          </div>
          <div class="column">
          <div class="region">Region Name</div>
            <div class="brone">
              <select name="select">
                <option value="<?php echo $region_name; ?>"><?php echo $region_name; ?></option>
              </select>
            </div>
          </div>
          <div class="column">
          <div class="area">Area Name</div>
            <div class="brone">
              <select name="select">
                <option value="<?php echo $area_name; ?>"><?php echo $area_name; ?></option>
              </select>
            </div>
          </div>
        </div>
        <br />
       <table style="text-align: center;font-size:13" class="table table-hover" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Monitoring Event</th>
            <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Monitoring Period</th>
            <th style="background-color:#92D050; color:black; border: 1px solid white;">Good</th>
            <th style="background-color:#D7E4BC; color:black; border: 1px solid white;">Modarate</th>
            <th style="background-color:#FAC090; color:black; border: 1px solid white;">Need Improvement</th>
          </tr>
        </thead>
        <tbody>
          <?php
             $cmonth = date('m');
              //echo "test";
              if($cmonth >='01')
              {
                $startmonth = '01';
                $endmonth = '03';
                //echo $cmonth."/".$endmonth."*";
              }
              else if ($cmonth >='04')
              {
                $startmonth = '04';
                $endmonth = '06';
              }
              else if($cmonth >='07')
              {
                $startmonth = '07';
                $endmonth = '09';
              }
              else if($cmonth >='10')
              {
                $startmonth = '10';
                $endmonth = '12';
              }
              
              $cyear = date('Y');
              $totalscore =0;
              $g='';$m='';$p='';
                 $ct=0;
                 $score =0;
               $year='';
               $quarter='';
                 $checkdata= DB::select(DB::raw("select * from mnwv2.monitorevents where area_id='$a_id' and areacompletestatus =0 order by id DESC LIMIT 1"));
                 
                 if(!empty($checkdata))
                 {
                   foreach($checkdata as $row)
                   {
                     $year = $row->year;
                     $quarter = $row->quarterly;
                    
                     $cdata= DB::select(DB::raw("select * from mnwv2.monitorevents where area_id='$a_id' and year='$year' and quarterly='$quarter'"));
                     foreach($cdata as $row)
                     {
                       $score +=$row->score;
                       $ct +=1;
                       if($quarter=='1st')
                       {
                         $period = $year." JAN "." to ".$year." MAR ";
                       }
                       else if($quarter=='2nd')
                       {
                         $period = $year." APR "." to ".$year." JUN ";
                       }
                       else if($quarter=='3rd')
                       {
                         $period = $year." JUL "." to ".$year." OCT ";
                       }
                       else if($quarter=='4th')
                       {
                         $period = $year." NOV "." to ".$year." DEC ";
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
                         $p = 'Poor';
                       }
                       ?>
                      <tr>
                        <td style="text-align: center;">
                        <a style="color: black;" class="btn btn-danger" href="AreaCurrentDashboard?event=<?php echo $year."-".$quarter; ?>"><?php echo $year."-".$quarter; ?></a></td>
                        <td style="text-align: center;">
                        <a style="color: black;"><?php echo  $period; ?></a></td>
                      
                        <td style="color: black; text-align: center;"><?php if($g){
                          ?>
                          <input type="checkbox" checked>
                          <?php
                        } ?></td>
                        <td style="color: black; text-align: center;"><?php if($m){
                          ?>
                          <input type="checkbox " checked>
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
      <br />
      <div id="cycle">
        <div class="cycle">
        
            Monitoring Event: <?php if($year !=''){echo $year."-".$quarter;} ?>
        </div>
      </div>
      <br />
      <table style="text-align: center;font-size:13" class="table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
         <thead>
            <tr style="height:25px;">
                <th  width="8%" style="background-color:#BFBFBF; color:black; border: 1px solid white; text-align: center;">Month</th>
              <th  width="8%" style="background-color:#BFBFBF; color:black; border: 1px solid white; text-align: center;">Section</th>
              <th width="50%" style="background-color:#BFBFBF; color:black; border: 1px solid white; text-align: center;">Section Name</th>
              <th width="30%" style="background-color:#BFBFBF; color:black; border: 1px solid white; text-align: center;">Achievement %</th>
              
            </tr>
         </thead>
       <tbody>
       <?php
       $totalspoint =0;
       $totalsectp =0;
       $name='';
       //echo $year."/".$quarter."*".$a_id;
        $areas = DB::select(DB::raw("select year,quarterly,month from mnwv2.monitorevents where area_id='$a_id' and year='$year' and quarterly='$quarter' group by year,quarterly,month order by month ASC"));
      if(!empty($areas))
      {
        foreach($areas as $row)
        {
          $month =0;
          $totalspoint =0;
          $totalsectp =0;
          $month = $row->month;
          //echo $month;
          $quarter = $row->quarterly;
          $year = $row->year;
          for($i=1; $i<=5;$i++)
          {
            
            //echo $month."/";
            $totalspoint =0;
            $totalsectp =0;
            $totalscore =0;
            $monthwise = DB::select(DB::raw("select * from mnwv2.monitorevents where area_id='$a_id' and year='$year' and quarterly='$quarter' and month='$month'"));
            if(empty($monthwise))
            {
              
            }
            else
            {
              foreach($monthwise as $r)
              {
                $event_id = $r->id;
                //echo $event_id."/";
                $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$event_id' and section='$i'"));
                $totalspoint += $data[0]->qsp;
                $totalsectp += $data[0]->sp;
              }
              
            }

            if($totalspoint !=0)
            {
              $totalscore = round(($totalsectp/$totalspoint)*100); 
            }
            $secname = DB::select( DB::raw("select * from mnwv2.def_sections where sec_no='$i'"));
            if(empty($secname))
            {
              
            }
            else
            {
              $name = $secname[0]->sec_name;
            }
            if($i==1)
            {
              if($totalscore !=0)
              {
              ?>
                <tr  style="height:20px; color:black;">
                
                  <td rowspan= "5" ><?php echo $year."-".$month; ?></td>
                  <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$year.",".$quarter.",".$month; ?>"><?php echo "Section: ".$i; ?></a></td>
                  <td width="50%"><?php echo $name; ?></td>
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
            
                  <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$year.",".$quarter.",".$month; ?>"><?php echo "Section: ".$i; ?></a></td>
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
                  
                  
                  <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$year.",".$quarter.",".$month; ?>"><?php echo "Section: ".$i; ?></a></td>
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
                  
                  
                  <td style="color: black;text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$year.",".$quarter.",".$month; ?>"><?php echo "Section: ".$i; ?></a></td>
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
                   <td style="color: black; text-align: center;"><a style="color: black;" class="btn btn-danger" href="Section?section=<?php echo $i.",".$year.",".$quarter.",".$month; ?>"><?php echo "Section: ".$i; ?></a></td>
                  <td width="50%"><?php echo $name; ?></td>
                  <td width="30%" style="text-align: center;"><?php echo $totalscore."%"; ?></td>
                </tr>
              <?php
              }
            }
            
          }
        }
      }
      ?>
       </tbody>
    </table>  
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
