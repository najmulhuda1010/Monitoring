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
    @extends('DataProcessing/BranchDataProcessing')
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
        <h3><i>Branch Dashboard:</i></h3>
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
        <div class="column">
        <div class="branch">Branch Name</div>
          <div class="brone">
            <select name="select">
              <option value="<?php echo $branch_name; ?>"><?php echo $branch_name; ?></option>
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
            <th style="background-color:#FAC090; color:black; border: 1px solid white;">Poor</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $eid = $ev;
          $id= 1;
             foreach ($br_monevents as $row) 
             {
                $g =0;
                $m=0;
                $p =0;
                $cycle = $row->event_cycle;
                if($cycle =='')
                {
                  $cycle="";
                }
                $score = $row->score;
                if($score >=85)
                {
                  $g = "Good";
                  
                }
                else if($score >=70 and $score < 85)
                {
                  $m = "Modarate";
                  
                }
                else if($score < 70)
                {
                  $p = "Poor"; 
                }
                ?>    

                  <tr>
                    <td>
                    <a style="color: black;" class="btn btn-danger" href="BranchDashboard?evid=<?php echo $row->id.","."true".",".$brcode; ?>"><?php echo $cycle; ?></a></td>
                    <td style="color: black;"><?php echo $row->datestart." to ".$row->dateend; ?></td>
                    <td style="color: black;"><?php if($g){
                      ?>
                      <input type="checkbox" checked>
                      <?php
                    } ?></td>
                    <td style="color: black;"><?php if($m){
                      ?>
                      <input type="checkbox" checked>
                      <?php
                    } ?></td>
                    <td style="color: black;"><?php if($p){
                      ?>
                      <input type="checkbox" checked>
                      <?php
                    } ?></td>
                  <tr>
                <?php 
                $id++;
             }
          ?>
        </tbody>
      </table>
      <?php
        if($lastevid !='')
        {
          //echo $lastevid;
          $br_cycle = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brcode' and  id='$lastevid'"));
          if(empty($br_cycle))
          {
            $cycle="Default";
          }
          else
          {
            $cycle = $br_cycle[0]->event_cycle;
            if($cycle =='')
            {
              $cycle="Default";
            }
            
          }
        }
        else if($ev !='')
        {
          $br_cycle = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brcode' and  id='$ev'"));
          if(empty($br_cycle))
          {
            $cycle="Default";
          }
          else
          {
            $cycle = $br_cycle[0]->event_cycle;
            if($cycle =='')
            {
              $cycle="Default";
            }
            
          }
        }
        else{
          $cycle="Default";
        }
        
        ?>
        <div id="cycle">
            <div class="cycle">
                 Monitoring Event: <?php echo $cycle; ?>
            </div>
        </div>
        <br />
        <table style="text-align: center;font-size:13" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
         <thead>
          
          <tr>
            <th width="20%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">Section</th>
            <th width="60%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">Section Name</th>
            <th width="20%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">Achievement %</th>
            
          </tr>
         </thead>
         <tbody>
       </table>
         <?php
         
             
           $totalscore =0;
           $totalpoint =0;
           $totalqpoint =0;
           $section=0;
           $name ='';
           //$eid ='';
           $falg=0;
            if($eid !='')
            {
             
             $datareadmnevents =DB::select(DB::raw("select section from mnwv2.cal_section_point where event_id='$eid' group by section 
order by section ASC"));
             if(!empty($datareadmnevents))
             {
               foreach($datareadmnevents as $row)
               {
                  $section = $row->section;
                $secname = DB::select( DB::raw("select * from mnwv2.def_sections where sec_no='$section'"));
                if(empty($secname))
                {
                  
                }
                else{
                  $name = $secname[0]->sec_name;
                }
                  $br_datareadmonievents = DB::select(DB::raw("select sum(point) as point, sum(question_point) as qpoint from mnwv2.cal_section_point where event_id='$eid' and section='$section'"));
                if(!empty($br_datareadmonievents))
                {
                  $totalpoint = $br_datareadmonievents[0]->point;
                  $totalqpoint = $br_datareadmonievents[0]->qpoint;
                  $totalscore = round((($totalpoint/$totalqpoint)*100));
                  
                  ?>
                  <table style="text-align: center;font-size:13" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <tr>
                        <td style="color: black;"><button id="<?php echo $section; ?>" class="showdiv" onClick="getDiv(<?php echo $section; ?>);" >+</button>
                        <a style="color: black;"><?php echo "Section: ".$section; ?></a></td>
                        <td width="60%" style="color: black;"><?php echo $name; ?></td>
                        <td width="20%" style="color: black;"><?php echo $totalscore."%"; ?></td>
                    </tr>
                  </table>
                  <table style="text-align: center;font-size:13" id="<?php echo "dv".$section; ?>" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      
                      <thead>
                        <tr>
                          <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Section Number</th>
                        
                          <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Details</th>
                          
                          <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Achievement %</th>
          
                        </tr>
                      </thead>
                      <?php 
                      $subsectiondata = DB::select( DB::raw("select * from mnwv2.cal_section_point  where event_id='$eid' and section='$section' order by sub_id ASC"));
                      if(empty($subsectiondata))
                      {
                        
                      }
                      else
                      {
                        foreach($subsectiondata as $row)
                        {
                            $qno = $row->qno;
                          $subid= $row->sub_sec_id;
                          $point = $row->point;
                          $qpoint = $row->question_point;
                          $scores = round(($point/$qpoint)*100,2);
                          ?>
                           <tbody>
                            <tr>
                              <?php 
                              $sec = $row->section;
                              $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and sub_sec_no='$subid'"));
                              if(empty($secname))
                              {
                                
                              }
                              else{
                                $name = $secname[0]->qdesc;
                              }
                              if($sec=='1')
                              {
                                if($point=='6')
                                {
                                  $percent = 100;
                                }
                                else if($point=='4')
                                {
                                  $percent = 60;
                                }
                                else if($point=='2')
                                {
                                  $percent = 40;
                                }
                                $id=1;
                                ?>
                                <td><?php echo $row->section.".".$row->sub_id;;  ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo  $scores."%"; ?></td>
                                <?php
                                $id++;
                              }
                              else if($sec=='2')
                              {
                                $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and sub_sec_no='$subid'"));
                                if(empty($secname))
                                {
                                  
                                }
                                else{
                                  $name = $secname[0]->qdesc;
                                }
                                if($point=='6')
                                {
                                  $percent = 100;
                                }
                                else if($point=='4')
                                {
                                  $percent = 60;
                                }
                                else if($point=='2')
                                {
                                  $percent = 40;
                                }
                                ?>
                                <td><?php echo $row->section.".".$row->sub_id;;  ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo  $scores."%"; ?></td>
                                <?php
                              }
                              else if($sec=='3')
                              {
                                $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and sub_sec_no='$subid'"));
                                if(empty($secname))
                                {
                                  
                                }
                                else{
                                  $name = $secname[0]->qdesc;
                                }
                                if($point=='6')
                                {
                                  $percent = 100;
                                }
                                else if($point=='4')
                                {
                                  $percent = 60;
                                }
                                else if($point=='2')
                                {
                                  $percent = 40;
                                }
                                ?>
                                <td><?php echo $row->section.".".$row->sub_id;;  ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo  $scores."%"; ?></td>
                                <?php
                              }
                              else if($sec=='4')
                              {
                                $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and sub_sec_no='$subid'"));
                                if(empty($secname))
                                {
                                  
                                }
                                else{
                                  $name = $secname[0]->qdesc;
                                }
                                if($point=='6')
                                {
                                  $percent = 100;
                                }
                                else if($point=='4')
                                {
                                  $percent = 60;
                                }
                                else if($point=='2')
                                {
                                  $percent = 40;
                                }
                                else
                                {
                                  $percent =0;
                                }
                                ?>
                                <td><?php echo $row->section.".".$row->sub_id;;  ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo  $scores."%"; ?></td>
                                <?php
                              }
                              else if($sec=='5')
                              {
                                $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and sub_sec_no='$subid'"));
                                if(empty($secname))
                                {
                                  
                                }
                                else{
                                  $name = $secname[0]->qdesc;
                                }
                                if($point=='6')
                                {
                                  $percent = 100;
                                }
                                else if($point=='4')
                                {
                                  $percent = 60;
                                }
                                else if($point=='2')
                                {
                                  $percent = 40;
                                }
                                else
                                {
                                  $percent =0;
                                }
                                ?>
                                <td><?php echo $row->section.".".$row->sub_id;  ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo  $scores."%"; ?></td>
                                <?php
                              }
                              ?>
                              
                            </tr>
                          </tbody>
                          <?php
                        }
                      }
                      
                      ?>
                    </table> 
                  <?php
                }
               }
             }
           }
           else
           {
             
             $eid1 = $lastevid;
             //echo $eid1;
//die();
             $datareadmnevents =DB::select(DB::raw("select section from mnwv2.cal_section_point where event_id='$eid1' group by section 
order by section ASC"));
             if(!empty($datareadmnevents))
             {
               foreach($datareadmnevents as $row)
               {
                  $section = $row->section;
                $secname = DB::select( DB::raw("select * from mnwv2.def_sections where sec_no='$section'"));
                if(empty($secname))
                {
                  
                }
                else{
                  $name = $secname[0]->sec_name;
                }
                  $br_datareadmonievents = DB::select(DB::raw("select sum(point) as point, sum(question_point) as qpoint from mnwv2.cal_section_point where event_id='$eid1' and section='$section'"));
                if(!empty($br_datareadmonievents))
                {
                  $totalpoint = $br_datareadmonievents[0]->point;
                  $totalqpoint = $br_datareadmonievents[0]->qpoint;
                  $totalscore = round((($totalpoint/$totalqpoint)*100));
                  
                  ?>
                    <table style="text-align: center;font-size:13" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <tr>
                        <td style="color: black;"><button id="<?php echo $section; ?>" class="showdiv" onClick="getDiv(<?php echo $section; ?>);" >+</button>
                        <a style="color: black;"><?php echo "Section: ".$section; ?></a></td>
                        <td width="60%" style="color: black;"><?php echo $name; ?></td>
                        <td width="20%" style="color: black;"><?php echo $totalscore."%"; ?></td>
                    </tr>
                  </table>
                  <table style="text-align: center;font-size:13" id="<?php echo "dv".$section; ?>" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      
                      <thead>
                        <tr>
                          <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Section Number</th>
                        
                          <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Details</th>
                          
                          <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Achievement %</th>
          
                        </tr>
                      </thead>
                      <?php 
                      $subsectiondata = DB::select( DB::raw("select * from mnwv2.cal_section_point  where event_id='$eid1' and section='$section' order by sub_id ASC"));
                      if(empty($subsectiondata))
                      {
                        
                      }
                      else
                      {
                        foreach($subsectiondata as $row)
                        {
                            $qno = $row->qno;
							$subid= $row->sub_sec_id;
							$point = $row->point;
							$qpoint = $row->question_point;
							$scores = round(($point/$qpoint)*100,2);
                          ?>
                           <tbody>
                            <tr>
                              <?php 
                              $sec = $row->section;
                              $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and qno='$qno'"));
                              if(empty($secname))
                              {
                                
                              }
                              else{
                                $name = $secname[0]->qdesc;
                              }
                              if($sec=='1')
                              {
                                if($point=='6')
                                {
                                  $percent = 100;
                                }
                                else if($point=='4')
                                {
                                  $percent = 60;
                                }
                                else if($point=='2')
                                {
                                  $percent = 40;
                                }
                                $id=1;
                                ?>
                                <td><?php echo $row->section.".".$row->sub_id;  ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo  $scores."%"; ?></td>
                                <?php
                                $id++;
                              }
                              else if($sec=='2')
                              {
                                $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and sub_sec_no='$subid'"));
                                if(empty($secname))
                                {
                                  
                                }
                                else{
                                  $name = $secname[0]->qdesc;
                                }
                                if($point=='6')
                                {
                                  $percent = 100;
                                }
                                else if($point=='4')
                                {
                                  $percent = 60;
                                }
                                else if($point=='2')
                                {
                                  $percent = 40;
                                }
                                ?>
                                <td><?php echo $row->section.".".$row->sub_id;  ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo  $scores."%"; ?></td>
                                <?php
                              }
                              else if($sec=='3')
                              {
                                $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and sub_sec_no='$subid'"));
                                if(empty($secname))
                                {
                                  
                                }
                                else{
                                  $name = $secname[0]->qdesc;
                                }
                                if($point=='6')
                                {
                                  $percent = 100;
                                }
                                else if($point=='4')
                                {
                                  $percent = 60;
                                }
                                else if($point=='2')
                                {
                                  $percent = 40;
                                }
                                ?>
                                <td><?php echo $row->section.".".$row->sub_id;  ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo  $scores."%"; ?></td>
                                <?php
                              }
                              else if($sec=='4')
                              {
                                $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and sub_sec_no='$subid'"));
                                if(empty($secname))
                                {
                                  
                                }
                                else{
                                  $name = $secname[0]->qdesc;
                                }
                                if($point=='6')
                                {
                                  $percent = 100;
                                }
                                else if($point=='4')
                                {
                                  $percent = 60;
                                }
                                else if($point=='2')
                                {
                                  $percent = 40;
                                }
                                else
                                {
                                  $percent =0;
                                }
                                ?>
                                <td><?php echo $row->section.".".$row->sub_id;  ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo  $scores."%"; ?></td>
                                <?php
                              }
                              else if($sec=='5')
                              {
                                $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and sub_sec_no='$subid'"));
                                if(empty($secname))
                                {
                                  
                                }
                                else{
                                  $name = $secname[0]->qdesc;
                                }
                                if($point=='6')
                                {
                                  $percent = 100;
                                }
                                else if($point=='4')
                                {
                                  $percent = 60;
                                }
                                else if($point=='2')
                                {
                                  $percent = 40;
                                }
                                else
                                {
                                  $percent =0;
                                }
                                ?>
                                <td><?php echo $row->section.".".$row->sub_id;  ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo  $scores."%"; ?></td>
                                <?php
                              }
                              ?>
                              
                            </tr>
                          </tbody>
                          <?php
                        }
                      }
                      
                      ?>
                    </table> 
                   <?php
                }
               }
             }
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
