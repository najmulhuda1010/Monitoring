
@extends('backend.layouts.master')

@section('title','Area Wise Acheivement')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Area Wise Acheivement</h5>
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
              <h3 class="card-title">Section <?php echo $sec." :  ". $name;  ?></h3>
            </div><!-- /.box-header -->
            <!--begin::Form-->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <table style="font-size:13" class="table">
                    <tr class="brac-color-pink">
                      <th width="50%">Area Name</th>
                      <th width="50%">Achievement %</th>
                    </tr>
                  </table>  
                  <?php
      $ct =0;
      $division = DB::select(DB::raw("select area_id from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and region_id='$reg' group by area_id"));
      foreach ($division as $row) 
      {
        $sp =0;
        $qsp=0;
        $area_id = $row->area_id;
        $data = DB::select(DB::raw("select * from mnwv2.monitorevents where year='$year' and quarterly='$quarter' and area_id='$area_id'"));
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
        $areaname = DB::select( DB::raw("select * from branch where area_id='$area_id'"));
        if(empty($areaname))
        {
          
        }
        else
        {
          $areaname = $areaname[0]->area_name;
        }
        ?>
        <table style="font-size:13" class="table" cellspacing="0" width="100%">
           <tr>
            <td width="50%"><button id="<?php echo $ct; ?>" class="btn btn-light showdiv" onClick="getDiv(<?php echo $ct; ?>);" >+</button><span class="ml-5"><?php echo $areaname; ?></span></td>
            <td width="50%"><?php echo $score." %"; ?></td>
          </tr>
        </table>
        <table style="text-align: center;font-size:13" id ="<?php echo "dv".$ct; ?>"class="table" cellspacing="0" width="100%">
          <thead>
                 <tr class="brac-color-pink">
                  <th style="text-align: center;">Branch Name</th>
                  <th style="">Achievement %</th>
                </tr>
           </thead>
           <tbody>
            <?php
            $branch = DB::select(DB::raw("select branchcode from mnwv2.monitorevents where area_id='$area_id' and year='$year' and quarterly='$quar' group by branchcode order by branchcode ASC"));
            foreach($branch as $row)
            {
               $sp =0;
               $qsp=0;
               $branch_id = $row->branchcode;
               $dataget = DB::select(DB::raw("select * from mnwv2.monitorevents where branchcode='$branch_id' and year='$year' and quarterly='$quar'"));
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
              $branchname = DB::select( DB::raw("select * from branch where branch_id='$branch_id'"));
              if(empty($branchname))
              {
                
              }
              else
              {
                $branchname = $branchname[0]->branch_name;
              }
               ?>
              <tr>
                <td width="50%" style="text-align: center"><button class="btn btn-light" onClick="sectionDiv(<?php echo $event_id; ?>,<?php echo $sec; ?>);"><?php echo $branchname; ?></button></td>
                <td width="50%"><?php echo $score." %"; ?></td>
            </tr>
            <?php
          } ?>
           <?php 
           foreach($branch as $row)
            {
               $sp =0;
               $qsp=0;
               $branch_id = $row->branchcode;
               $dataget = DB::select(DB::raw("select * from mnwv2.monitorevents where branchcode='$branch_id' and year='$year' and quarterly='$quar'"));
               foreach ($dataget as $row) 
               {
               $event_id=$row->id;
            ?>
            <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $event_id."_".$sec."_1"  }}" class="sectionView1" style="display: none">
            <th>Branch Name:- <span id="{{ $event_id."_".$sec."_branchname"  }}"></span> </th>
            </table> 
            <table style="text-align: center;font-size:13" style="font-size: 13;" id="{{ $event_id."_".$sec."_2"  }}" style="display: none" class="table dt-responsive nowrap sectionView2" cellspacing="0" width="100%"> 
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
            </tbody> 
            </table> 
        @php
        }}
        @endphp
      <?php
      }
      ?>
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
       $("#dv1").hide();
       $("#dv2").hide();
       $("#dv3").hide();
       $("#dv4").hide();
       $("#dv5").hide();
       $(".sectionView1").hide(); 
        $(".sectionView2").hide(); 
    });


    function sectionDiv(event,serial){
      $(".sectionView1").hide(); 
      $(".sectionView2").hide(); 
      $("#" +event+"_"+serial+"_1").show(); 
      $("#" +event+"_"+serial+"_2").show(); 
      $.ajax({
          type: 'GET',
          url: '/mnwv2/SectionDetails?section='+serial+','+event,
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
       var button_text = $('#' + judu).text();
      if(button_text == '+')
      {
        for (var i = 1; i < 100; i++)
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