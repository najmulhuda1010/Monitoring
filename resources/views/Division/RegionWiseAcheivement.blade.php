@extends('mainpage')

@section('title','Table')


@section('content')

  <div class="row">
    <div class="panel panel-default">
      <div class="header">
        <h3><i>Region Wise Acheivement</i></h3>
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
            <th width="5%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">SL</th>
            <th width="50%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">Region Name</th>
            <th width="45%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">Achievement %</th>
          </tr>
        </thead>
        <tbody>
      </table>
        <?php
        $ct =0; 
        $regionname ='';
        $p=0;
        $qp =0;
        $id = 1;
        $area = DB::select(DB::raw("select region_id from mnwv2.monitorevents where division_id='$did' and year='$year' and quarterly='$quarter' and month='$month' group by region_id order by region_id ASC"));
        foreach ($area as $row) 
        {
          $regionid =  $row->region_id;
          $totalscore =0;
          $totalspoint=0;
          $totalsectp =0;
          $eventid = DB::select(DB::raw("select * from mnwv2.monitorevents where division_id='$did' and year='$year' and quarterly='$quarter' and month='$month' and region_id='$regionid'"));
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
          $regionname = DB::select( DB::raw("select * from branch where region_id='$regionid'"));
          if(empty($regionname))
          {
            
          }
          else
          {
            $regionname = $regionname[0]->region_name;
          }
          $ct++;
          ?>
          <table style="text-align: center;font-size:13" class="table table-hover" cellspacing="0" width="100%">
          <tr>
            <td width="5%"><?php echo $id; ?></td>
            <td width="50%"><button id="<?php echo $ct; ?>" class="showdiv" onClick="getDiv(<?php echo $ct; ?>);" >+</button><a><?php echo $regionname."(".$regionid.")";?></a></td>
            <td width="45%"><?php echo $totalscore." %"; ?></td>
          </tr>
        </table>
        <table style="text-align: center;font-size:13" id="<?php echo "dv".$ct; ?>" class="table table-hover" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th width="5%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">SL</th>
            <th width="50%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">Area Name</th>
            <th width="45%" style="background-color:#BFBFBF; color:black; border: 1px solid white;">Achievement %</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $evenid =0;
           $areawise = DB::select(DB::raw("select area_id from mnwv2.monitorevents where region_id='$regionid' and year='$year' and quarterly='$quarter' and month='$month' group by area_id order by area_id ASC"));
           if(!empty($areawise))
           {
            foreach ($areawise as $row) 
             {
                $areaid = $row->area_id;
                $totalscore =0;
                $totalspoint=0;
                $totalsectp =0;
                $eventid = DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$regionid' and year='$year' and quarterly='$quarter' and month='$month' and area_id='$areaid'"));
                if(!empty($eventid))
                {
                  foreach ($eventid as $r) 
                  {
                    $evenid = $r->id;
                    $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$evenid' and section='$section'"));
                      $totalspoint += $data[0]->qsp;
                      $totalsectp += $data[0]->sp;
                  }
                }
                if($totalspoint !=0)
                {
                  $totalscore = round(($totalsectp/$totalspoint)*100); 
                }
                $areaname = DB::select( DB::raw("select * from branch where area_id='$areaid'"));
                if(empty($areaname))
                {
                  
                }
                else
                {
                  $areaname = $areaname[0]->area_name;
                }
                ?>
                <tr>
                  <td width="5%"><?php echo $id; ?></td>
                  <td width="50%"><a style="color:#a94442;" href="branchwise?areaid=<?php echo $section.",".$areaid.",".$year.",".$quarter ?>"><?php echo $areaname."(".$areaid.")";?></a></td>
                  <td width="45%"><?php echo $totalscore." %"; ?></td>
                </tr>
                <?php
             }
           }
           
          ?>
        </tbody>
      </table>
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
