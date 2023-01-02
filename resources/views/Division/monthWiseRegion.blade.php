
@extends('backend.layouts.master')

@section('title','Month Wise Acheivement')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Month Wise Region Acheivement</h5>
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
            $secname = DB::select( DB::raw("select * from mnwv2.def_sections where sec_no='$section'"));
            if(empty($secname))
            {
                
            }
            else{
                $name = $secname[0]->sec_name;
            }

                $mon = $month;
                if($mon =='01'){$j = "JANUARY";} else if($mon =='02'){$j="FEBRUARY";}else if($mon=='03'){$j="MARCH";}else if($mon =='04'){$j="APRIL";}else if($mon=='05'){$j="MAY";}else if($mon =='06'){$j="JUNE";}else if($mon=='07'){$j="JULY";}else if($mon=='08'){$j="AUGUST";}else if($mon=='09'){$j="SEPTEMBER";}else if($mon=='10'){$j="OCTOBER";}else if($mon=='11'){$j="NOVEMEBER";}else if($mon =='12'){$j="DECEMBER";}else{$j='0';}
            ?>
            <div class="card-header">
              <h3 class="card-title">Section <?php echo $section.": ". $name."(".$j.")";  ?></h3>
            </div><!-- /.box-header -->
            <!--begin::Form-->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <table style="font-size:13" style="font-size:13" class="table">
                    <tr class="brac-color-pink">
                      <th width="50%">Region Name</th>
                      <th width="50%">Achievement %</th>
                    </tr>
                  </table>  
                  <?php 
        $ct =0;
		$cntt=0;
        $region = DB::select(DB::raw("select region_id from mnwv2.monitorevents where division_id='$division' and year='$year' and quarterly='$quarter' and month='$month' group by region_id order by region_id ASC"));
            foreach($region as $row)
            {
               $sp =0;
               $qsp=0;
               $region_id = $row->region_id;
               $dataget = DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$region_id' and year='$year' and quarterly='$quarter' and month='$month'"));
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
                  $data = DB::select(DB::raw("select sum(point) as sp, sum(question_point) as qsp from mnwv2.cal_section_point where event_id='$event_id' and section='$section'"));
                  
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
              $regionname = DB::select( DB::raw("select * from branch where region_id='$region_id'"));
              if(empty($regionname))
              {
                
              }
              else
              {
                $regionname = $regionname[0]->region_name;
              }
               ?>
                     <table style="font-size:13" class="table" cellspacing="0" width="100%">
                       <tr>
                        <td width="50%"><button id="<?php echo $ct; ?>" class="btn btn-light showdiv" onClick="getDiv(<?php echo $ct; ?>);" >+</button><span class="ml-5"><?php echo $regionname; ?></span></td>
                        <td width="50%"><?php echo $score." %"; ?></td>
                      </tr>
                    </table>
                     <table style="text-align: center;font-size:13" id="<?php echo "dv".$ct; ?>" class="table" cellspacing="0" width="100%">
                      <thead>
                           <tr class="brac-color-pink">
                            <th style="text-align: center;">Area Name</th>
                            <th style="">Achievement %</th>
                          </tr>
                     </thead>
                      <tbody>
                        <?php
              $area = DB::select(DB::raw("select area_id from mnwv2.monitorevents where region_id='$region_id' and year='$year' and quarterly='$quarter' group by area_id order by area_id ASC"));
              foreach ($area as $row) 
              {
                $areaid =  $row->area_id;
                $totalscore =0;
                $totalspoint=0;
                $totalsectp =0;
                $eventid = DB::select(DB::raw("select * from mnwv2.monitorevents where region_id='$region_id' and year='$year' and quarterly='$quarter' and area_id='$areaid' and month='$month'"));
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
                          <td width="10%" style="text-align:center;"><button class="btn btn-light" onClick="sectionBranchDiv(<?php echo $section.",".$areaid.",".$year.",'".$quar."',".$month; ?>)"><?php echo $areaname; ?></button></td>
                          <td width="10%"><?php echo $totalscore."%"; ?></td>
                       </tr>
                       <?php
                        }
                     ?>
                     <?php
                     foreach($area as $r)
                       {
                         $aid=$r->area_id;
                     ?>
                     <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $aid."_".$section."_1"  }}" class="table  branchDiv1" style="display: none" cellspacing="0" width="100%">
                       <thead> 
                         <tr class="brac-color-pink">
                           <th width="50%" style="text-align:center;">Branch Name</th>
                           <th width="50%" style="">Achievement %</th>
                         </tr>
                       </thead>
                       <tbody>
                     </table>
                     <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $aid."_".$section."_2"  }}" class="table  branchDiv2" style="display: none" cellspacing="0" width="100%">
                       <tbody>
                         
                       </tbody>
                     </table>
                   <?php } ?>
                     <?php
                     foreach($area as $r)
                       {
                          $sp =0;
                          $qsp=0;
                          $areaid  =  $r->area_id;
                          $rdata = DB::select(DB::raw("select * from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and area_id='$areaid'"));
                          foreach ($rdata as $row) 
                          {
                           $event_id = $row->id;
                           ?>
                           <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $event_id."_".$section."_1"  }}" class="sectionView1" style="display: none">
                             <th>Branch Name:- <span id="{{ $event_id."_".$section."_branchname"  }}"></span> </th>
                           </table> 
                             <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $event_id."_".$section."_2"  }}" style="display: none" class="table  dt-responsive nowrap sectionView2" cellspacing="0" width="100%"> 
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
                    $cntt++;
                  }
                  ?>
                  <input type="hidden" id="cntt" value="<?php echo $cntt; ?>">  
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
        $(".sectionView1").hide(); 
       $(".sectionView2").hide(); 
       $(".branchDiv1").hide(); 
    $(".branchDiv2").hide(); 
		var loopVariable = document.getElementById("cntt").value;
		for( var i = 1; i <= loopVariable; i++)
		{
			$("#dv" + i).hide();
		}
	});


    function sectionBranchDiv(serial,area,year,quarter,month){
    $(".branchDiv1").hide(); 
    $(".branchDiv2").hide(); 
    $("#" +area+"_"+serial+"_1").show(); 
    $("#" +area+"_"+serial+"_2").show(); 
    $("#" +area+"_"+serial+"_2 tbody").empty();
    $.ajax({
            type: 'GET',
            url: '/mnwv2/monthlybranchwise?areaid='+serial+','+area+','+year+','+quarter+','+month,
            dataType: 'json',
            success: function (data) {
              // console.log(data.eventid[0]);
                $("#"+area+"_"+serial+"_2 tbody").empty();
                // console.log(data.serials.length);
                if(data.eventid.length==0){
                    $(".sectionView1").hide(); 
                    $(".sectionView2").hide(); 
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
                        div += eventid + ","+ serial+","+month
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



  function sectionDiv(event,serial,month){
        $(".sectionView1").hide(); 
        $(".sectionView2").hide(); 
        $("#" +event+"_"+serial+"_1").show(); 
        $("#" +event+"_"+serial+"_2").show(); 
        $.ajax({
            type: 'GET',
            url: '/mnwv2/monthlySectionDetails?section='+serial+','+event+','+month,
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
		 var loopVariable = document.getElementById("cntt").value;
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