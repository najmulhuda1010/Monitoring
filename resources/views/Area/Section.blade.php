@extends('mainpage')

@section('title','Table')


@section('content')

  <div class="row">
    <div class="panel panel-default">
      <div class="header">
        <h3><i>Section Wise Data:</i></h3>
        <br />
      </div>
      <div id="rcorners">
          <table style="text-align: center;font-size:13" class="table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
             <thead>
              
              <tr style="height:35px">
                <th width="10%"style="background-color:#BFBFBF; color:black; border: 1px solid white;">Section</th>
                <th width="40%"style="background-color:#BFBFBF; color:black; border: 1px solid white;">Section Name</th>
                <th width="15%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">Area Name</th>
                <th width="10%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">Branch Code</th>
                <th width="15%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">Branch Name</th>
                <th width="10%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">Achievment%</th>
              </tr>
              
            
             </thead>
             <tbody>
           <?php
           $name=''; 
           $month = date('m');
           $cyear = date('Y');
           $sec=0;
           $sp=0;
           $qsp=0;
           $ct=0;
           $flg=1;
           $c =0;
              $areadata = DB::select(DB::raw("select * from mnwv2.monitorevents where year='$evyear' and quarterly='$quat' and area_id='$a_id'"));
            // var_dump($areadata);
            $d = count($areadata);
            $c = round($d/2);
            
            $sec = $sect;
          
            foreach($areadata as $row)
            {
               $sp =0;
               $qsp=0;
               $brcode = $row->branchcode;
               //echo $brcode."/";
               $cnt = strlen($brcode);
               if($cnt ==3)
               {
                 $brcode = '0'.$brcode;
               }
               $mnth = $row->month;
                //echo $mnth;
              $year = $row->year;
              $quar= $row->quarterly;
              $event_id = $row->id;
              //echo $event_id."/";
              $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$event_id' and section='$sec'"));
              
              if(!empty($data))
              {
                $sp +=$data[0]->sp;
                $qsp +=$data[0]->qsp;
              }
              $score =0;
              if($sp !=0)
              {
                $score =round(($sp*100)/$qsp);
              }
              //echo $event_id."-".$sp."/".$score."*";
              //die();
              $ct++;
              $name ='';
              $arean='';
              $brname ='';
              $branchname = DB::select( DB::raw("select * from branch where branch_id='$brcode'"));
              if(!empty($branchname))
              {
                $brname = $branchname[0]->branch_name;
              }
              $areaname = DB::select( DB::raw("select * from branch where area_id='$a_id'"));
              if(!empty($areaname))
              {
                $arean = $areaname[0]->area_name;
              }
              $secname = DB::select( DB::raw("select * from mnwv2.def_sections where sec_no='$sec'"));
               if(empty($secname))
               {
                
               }
              else{
                $name = $secname[0]->sec_name;
              }
              ?>
               <table style="text-align: center;font-size:13" class="table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <tr style="height:35px;color:black;">
                 
                <td width="10%"align="center"><?php
                  if($flg !=0)
                  {
                    if($ct==$c)
                    {
                       echo "Section: ".$sec;
                       $flg =0;
                    }
                    
                     
                  }
                   
                ?></td>
                <td width="40%" align="center">
                <?php   
                  if($ct==$c)
                  {
                     echo $name;
                     $flg =0;
                  }
                ?></td>
                <td width="15%"align="center">
                <?php
                
                    if($ct==$c)
                  {
                     echo $arean;
                     $flg =0;
                  }
                ?>
                </td>
                   
                <td width="10%" style="color: black;"><button id="<?php echo $ct; ?>" class="showdiv" onClick="getDiv(<?php echo $ct; ?>);" >+</button>
                    <a style="color: black;"><?php echo $brcode; ?></a></td>
                <td width="15%" align="center"><?php echo $brname; ?></td>
                <td width="10%" align="center"><?php echo $score."%"; ?></td>
                </tr>
                </table>
               <table style="text-align: center;font-size:13" id="<?php echo "dv".$ct; ?>" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                  <th>Section Number</th>
                  <th>Details</th>
                  <th>Achievment%</th>
                </thead>
                <tbody>
                  <?php 
                    $subsectiondata = DB::select( DB::raw("select * from mnwv2.cal_section_point  where event_id='$event_id' and section='$sec' order by sub_sec_id ASC"));
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
                              <td><?php echo $row->section.".".$row->qno;  ?></td>
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
                              <td><?php echo $row->section.".".$subid;  ?></td>
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
                              <td><?php echo $row->section.".".$subid;  ?></td>
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
                              <td><?php echo $row->section.".".$subid;  ?></td>
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
                              <td><?php echo $row->section.".".$subid;  ?></td>
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
                </tbody>
               </table>
              <?php
              
            }
            //echo $ct;
           ?>
           <input type="hidden" id="ct" value="<?php echo $ct; ?>">
          </tbody>
        </table>
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