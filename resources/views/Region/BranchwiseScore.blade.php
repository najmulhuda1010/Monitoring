@extends('mainpage')

@section('title','Table')


@section('content')

  <div class="row">
    <div class="panel panel-default">
      <div class="header">
        <h3><i>Branch Wise Data:</i></h3>
        <br />
      </div>
      <div id="rcorners">
          <table style="text-align: center;font-size:13" class="table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
             <thead> 
                <tr style="height:35px">
                  <th width="50%"style="background-color:#BFBFBF; color:black; border: 1px solid white;">Branch Name</th>
                  <th width="50%"style="background-color:#BFBFBF; color:black; border: 1px solid white;">Achievement %</th>
                </tr>
             </thead>
             <tbody>
          </table>
           <?php
           $name=''; 
           $month = date('m');
           $cyear = date('Y');
           $sp=0;
           $qsp=0;
           $ct=0;
           $flg=1;
           $c =0;
            foreach($brancwisescore as $row)
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
              <table style="text-align: center;font-size:13" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <tr height="35px">
                <td width="50%"><button id="<?php echo $ct; ?>" class="showdiv" onClick="getDiv(<?php echo $ct; ?>);" >+</button><?php echo $brname."(".$brcode.")"; ?></td>
                <td width="50%" align="center"><?php echo $score."%"; ?></td>
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
                    $name ='';
                    $p=0;
                    $qp =0;
                    $detailsdata = DB::select(DB::raw("select * from mnwv2.cal_section_point where event_id='$event_id' and section='$sec' order by sub_id ASC"));
                    foreach ($detailsdata as $row) 
                    {

                      $subid= $row->sub_id;
                      $p = $row->point;
                      $qp = $row->question_point;
                      if($p !=0)
                      {
                        $tscore = round(($p/$qp*100),2);
                      }
                      else
                      {
                        $tscore=0;
                      }
                      //echo $sec;
					  if($sec =='1')
					  {
						   $questionname = DB::select(DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and qno='$subid'"));
					  }
					  else
					  {
						   $questionname = DB::select(DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and sub_sec_no='$subid' and qno='0'"));
					  }
                     
                      if(!empty($questionname))
                      {
                        $name = $questionname[0]->qdesc;
                      }
                      ?>
                        <tr>
                          <td style="text-align:center"><?php echo $sec.".".$row->sub_id;?></td>
                          <td><?php echo $name;?></td>
                          <td style="text-align:center"><?php echo $tscore."%";?></td>
                        </tr>
                      <?php
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