
@extends('backend.layouts.master')

@section('title','Division Wise Acheivement')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Division Wise Acheivement</h5>
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
            <?php
            $secname = DB::select( DB::raw("select * from mnwv2.def_sections where sec_no='$sec'"));
             if(empty($secname))
             {
              
             }
            else{
              $name = $secname[0]->sec_name;
            }
            ?>
            <div class="card-header">
              <h3 class="card-title">Section <?php echo $sec." :    ". $name;  ?></h3>
            </div><!-- /.box-header -->
            <!--begin::Form-->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <table style="font-size:13" class="table">
                    <tr class="brac-color-pink">
                      <th width="50%">Division Name</th>
                      <th width="50%">Achievement %</th>
                    </tr>
                  </table>  
                  <?php
      $ct =0;
      $division = DB::select(DB::raw("select division_id from mnwv2.monitorevents where year='$year' and quarterly='$quarter' group by division_id"));
      foreach ($division as $row) 
      {
        $sp =0;
        $qsp=0;
        $div_id = $row->division_id;
		if($div_id ==NULL)
		{
			continue;
		}
        $data = DB::select(DB::raw("select * from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and division_id='$div_id'"));
        foreach ($data as $row) 
        {
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
        }
        $ct++;
        $score =0;
        if($sp !=0)
        {
          $score =round(($sp*100)/$qsp);
        }
        $divisionname = DB::select( DB::raw("select * from branch where division_id='$div_id'"));
        if(empty($divisionname))
        {
          
        }
        else
        {
          $divisionname = $divisionname[0]->division_name;
        }
        ?>
        <table style="font-size:13" class="table" cellspacing="0" width="100%">
           <tr>
            <td width="50%"><button id="<?php echo $ct; ?>" class="btn btn-light showdiv" onClick="getDiv(<?php echo $ct; ?>);" >+</button><span class="ml-5"><?php echo $divisionname; ?></span></td>
            <td width="50%"><?php echo $score." %"; ?></td>
          </tr>
        </table>
        <table style="text-align: center;font-size:13" id ="<?php echo "dv".$ct; ?>" class="table" cellspacing="0" width="100%">
          <thead>
                 <tr class="brac-color-pink">
                  <th style="text-align: center;">Region Name</th>
                  <th style=" ">Achievement %</th>
                </tr>
           </thead>
           <tbody>
            <?php
            $region = DB::select(DB::raw("select region_id from mnwv2.monitorevents where division_id='$div_id' and year='$year' and quarterly='$quar' group by region_id order by region_id ASC"));
            foreach($region as $row)
            {
               $sp =0;
               $qsp=0;
               $region_id = $row->region_id;
               $dataget = DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$region_id' and year='$year' and quarterly='$quar'"));
               foreach ($dataget as $row) 
               {
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
               }
              $score =0;
              if($sp !=0)
              {
                $score =round(($sp*100)/$qsp);
              }
              $regionname = DB::select( DB::raw("select * from branch where region_id='$region_id'"));
              if(empty($regionname))
              {
                
              }
              else
              {
                $regionname = $regionname[0]->region_name;
              }
               ?>
              <tr>
                <td width="50%" style="text-align: center"><a class="btn btn-light" target="_blank" href="AreaWise?area=<?php echo $sec.",".$region_id.",".$year.",".$quar; ?>"><?php echo $regionname; ?></a></td>
                <td width="50%"><?php echo $score." %"; ?></td>
            </tr>
            <?php
          } ?>
           </tbody>
        </table>
      <?php
	  $ct++;
      }
      ?>
	  <input type="hidden" id="ct" value="<?php echo $ct; ?>">
                </div>
            </div>
            </div>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
        <br>
        
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
		var loopVariable = document.getElementById("ct").value;
		for( var i = 1; i <= loopVariable; i++)
		{
			$("#dv" + i).hide();
		}
	});
     function getDiv(judu){
		 var loopVariable = document.getElementById("ct").value;
		 var button_text = $('#' + judu).text();
		if(button_text == '+')
		{
			for (var i = 1; i <= loopVariable; i++)
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