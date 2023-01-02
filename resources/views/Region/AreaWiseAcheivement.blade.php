@extends('mainpage')

@section('title','Table')


@section('content')

  <div class="row">
    <div class="panel panel-default">
      <div class="header">
        <h3><i>Area Wise Acheivement</i></h3>
        <br />
      </div>
      <?php
      $secname = DB::select( DB::raw("select * from mnwv2.def_sections where sec_no='$section'"));
       if(empty($secname))
       {
        
       }
      else{
        $name = $secname[0]->sec_name;
      }
      ?>
      Section : <?php echo $section.":- ". $name;  ?>
      <br><br>
      <table style="text-align: center;font-size:13" class="table table-hover" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">SL</th>
            <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Area Name</th>
            <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Achievement %</th>
          </tr>
        </thead>
        <tbody>
        <?php 
        $areaname ='';
        $p=0;
        $qp =0;
        $id = 1;
        $area = DB::select(DB::raw("select area_id from mnwv2.monitorevents where region_id='$rid' and year='$year' and quarterly='$quarter' and month='$month' group by area_id order by area_id ASC"));
        foreach ($area as $row) 
        {
          $areaid =  $row->area_id;
          $totalscore =0;
          $totalspoint=0;
          $totalsectp =0;
          $eventid = DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$rid' and year='$year' and quarterly='$quarter' and month='$month' and area_id='$areaid'"));
          if(!empty($eventid))
          {
            foreach ($eventid as $r) 
            {
              $eventid = $r->id;
              $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$eventid' and section='$section'"));
                $totalspoint += $data[0]->qsp;
                $totalsectp += $data[0]->sp;
            }
          }
          if($totalspoint !=0)
          {
            $totalscore = round(($totalsectp/$totalspoint)*100); 
          }
          $areaname = DB::select( DB::raw("select * from branch where area_id='$areaid '"));
          if(empty($areaname))
          {
            
          }
          else
          {
            $areaname = $areaname[0]->area_name;
          }
          ?>
          <tr>
            <td><?php echo $id; ?></td>
            <td><a style="color:#a94442;" href="branchwise?areaid=<?php echo $section.",".$areaid.",".$year.",".$quarter ?>"><?php echo $areaname."(".$areaid.")"; ?></a></td>
            <td><?php echo $totalscore." %"; ?></td>
          </tr>
          <?php
          $id++;
        }
        ?>
        </tbody>
      </table>
      </div>
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
