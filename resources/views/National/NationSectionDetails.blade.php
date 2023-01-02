@extends('mainpage')

@section('title','Table')


@section('content')

  <div class="row">
    <div class="panel panel-default">
      <div class="header">
        <h3><i>Section Wise</i></h3>
        <br />
      </div>
      <?php
        $brcode1='';
       $brnchname='';
       $findbranch = DB::select(DB::raw("select * from mnwv2.monitorevents where branchcode ='$brcode' and year='$year' and quarterly='$quarter'"));
       if(!empty($findbranch))
       {
          $brcode1 = $findbranch[0]->branchcode;
          $eventid = $findbranch[0]->id;
          $brname = DB::select(DB::raw("select * from branch where branch_id='$brcode1'"));
          if(!empty($brname))
          {
            $brnchname = $brname[0]->branch_name;
          }
       }
       $sectioname = DB::select(DB::raw("select * from mnwv2.def_sections where sec_no='$sec'"));
       if(!empty($sectioname))
       {
          $secname =  $sectioname[0]->sec_name;
       }
       else
       {
        $secname ='';
       }
      ?>
      <div id="rcorners">
      <div class="row">
       Sec-<?php echo $sec.":".$secname; ?>
       <br />
       Branch Name:-<?php echo $brnchname."(".$brcode1.")";  ?>
       <br><br>
      <table style="text-align: center;font-size:13" class="table table-hover" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">SL</th>
            <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Details</th>
            <th style="background-color:#BFBFBF; color:black; border: 1px solid white;">Achievement %</th>
          </tr>
        </thead>
        <tbody>
        <?php 
        $name ='';
        $p=0;
        $qp =0;
        $detailsdata = DB::select(DB::raw("select * from mnwv2.cal_section_point where event_id='$eventid' and section='$sec' order by sub_id ASC"));
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
		  if($sec=='1')
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
              <td><?php echo $sec.".".$row->sub_id;?></td>
              <td><?php echo $name;?></td>
              <td><?php echo $tscore."%";?></td>
            </tr>
          <?php
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
