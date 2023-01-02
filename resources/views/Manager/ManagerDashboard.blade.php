<?php
$username = Session::get('username');
$rollid = Session::get('roll');
if($username=='')
{

  ?>
  <script>
    window.location.href = 'Logout';
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
  <!--@extends('DataProcessing/AdminDataProcessing')-->
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
@extends('backend.layouts.master')

@section('title','Manager Dashboard')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
      <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manager Dashboard</h5>
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
        @if ($rollid!='1' && $rollid!='2' && $rollid!='3' && $rollid!='4' )
        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <form target="_blank">
            <div class="card-body">
              <div class="row">
                <div class="col-md-2">
                <label class="control-label">Division</label>
                    <select class="form-control" name="division" id="divs" required>
                        <option value="">select</option>
                        <?php
                if($div !='')
                {
                  $divisions = DB::select( DB::raw("select  division_name,division_id from branch  where division_id= '$div' and program_id='1' group by division_name,division_id order by division_id"));
                  ?>
                  <option value="<?php echo $divisions[0]->division_id; ?>"><?php echo $divisions[0]->division_id."-".$divisions[0]->division_name; ?></option>
                  <?php
                  foreach ($division as $row) 
                  {
                    $division_name =  $row->division_name;
                    $division_id = $row->division_id;
                    ?>

                    <option value="<?php echo $division_id; ?>"><?php echo $division_name; ?></option>

                    <?php
                  }
                }
                else
                {
                  ?>
                  <option>select</option>
                  <?php
                  foreach ($division as $row) 
                  {
                    $division_name =  $row->division_name;
                    $division_id = $row->division_id;
                    ?>
                    
                    <option value="<?php echo $division_id; ?>"><?php echo $division_name; ?></option>
                    
                    <?php
                  }

                }
                ?>
                    </select>
                </div>
                <div class="col-md-2">
                <label class="control-label">Region</label>
                    <select class="form-control" name="region" id="region_id" required>
                        <option>select</option>
                        <?php 
                        if($reg !='')
                        {
                            $regions = DB::select( DB::raw("select  region_name,region_id from branch  where region_id= '$reg' and program_id='1' group by region_name,region_id order by region_id"));
                            $allregions = DB::select( DB::raw("select  region_name,region_id from branch  where division_id= '$div' and program_id='1' group by region_name,region_id order by region_id"));
                            ?>
                            <option value="<?php echo $regions[0]->region_id; ?>"><?php echo $regions[0]->region_name; ?></option>
                            <?php
                            foreach ($allregions as $row) 
                            {
                            ?>
                            <option value="<?php echo $row->region_id; ?>"><?php echo $row->region_name; ?></option>
                            <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                <label class="control-label">Area</label>
                    <select class="form-control" name="area" id="area_id" required>
                        <option>select</option>
                        <?php 
                        if($area !='')
                        {
                        $areas = DB::select( DB::raw("select  area_name,area_id from branch  where area_id= '$area' and program_id='1' group by area_name,area_id order by area_id"));
                        $allareas = DB::select( DB::raw("select  area_name,area_id from branch  where region_id= '$reg' and program_id='1' group by area_name,area_id order by area_id"));
                        ?>
                        <option value="<?php echo $areas[0]->area_id; ?>"><?php echo $areas[0]->area_name; ?></option>
                        <?php
                        foreach ($allareas as $row) 
                        {
                            ?>
                            <option value="<?php echo $row->area_id; ?>"><?php echo $row->area_name; ?></option>
                            <?php
                        }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                <label class="control-label">Branch</label>
                    <select class="form-control" name="branch" id="branch_id" required>
                        <option>select</option>
                        <?php 
                        if($brnch !='')
                        {
                        $branch = DB::select( DB::raw("select  branch_name,branch_id from branch  where branch_id= '$brnch' and program_id='1' group by branch_name,branch_id order by branch_id"));
                        $allbranch = DB::select( DB::raw("select  branch_name,branch_id from branch  where area_id= '$area' and program_id='1' group by branch_name,branch_id order by branch_id"));
                        ?>
                        <option value="<?php echo $branch[0]->branch_id; ?>"><?php echo $branch[0]->branch_name; ?></option>
                        <?php
                        foreach ($allbranch as $row) 
                        {
                        ?>
                        <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name; ?></option>
                        <?php
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-secondary" style="margin: 25px 0px 0px 25px;">Submit</button>
                </form>
                    <?php
                    $area ='';
                    $branch='';
                    if(isset($_GET['area']))
                    {
                    $area = $_GET['area'];
                    $branch = $_GET['branch'];
                    ?>
                        <a target="_blank" class="btn btn-secondary" style="margin: 25px 0px 0px 25px;" href="Remarks?area=<?php echo $area; ?>&branch=<?php echo $branch; ?>" class="btn btn-success">All Remarks</a>
        
                    <?php
                }
                ?>
                </div>
            </div>
            <div class="row mt-7">
              <div class="col-md-12">
                  <form action="BranchDashboard" method="GET" target="_blank">
                      <label for="example-search-input" class="control-label">Branch Search</label>
                      <div class="form-group row">
                          <div class="col-8">
                           <input class="form-control" type="text" list="browsers" name="branch" required/>
                           <datalist id="browsers">
                            <?php 
                            $userpin = Session::get('user_pin');
                            $branch = DB::select(DB::raw("select branch_id,branch_name from branch where program_id=1 group by branch_id,branch_name order by branch_id ASC"));
                            if($rollid =='17')
                            {
                               $branch =DB::select(DB::raw("select branch_name,branch_id from branch where branch_id in (select cast(branch_code as INT) from mnwv2.cluster where c_associate_id='$userpin') and program_id=1 group by branch_name,branch_id order by branch_id ASC"));
                            }
                            else if($rollid=='18')
                            {
                               $branch =DB::select(DB::raw("select branch_name,branch_id from branch where branch_id in (select cast(branch_code as INT) from mnwv2.cluster where z_associate_id='$userpin') and program_id=1 group by branch_name,branch_id order by branch_id ASC"));
                            }
                            if(!empty($branch))
                            {
                              foreach($branch as $row)
                              {
                                ?>
                                <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name."-".$row->branch_id; ?></option>
                                <?php
                              }
                          
                            }
                            ?>
                          </datalist>
                          </div>
                          <div class="col-3">
                              <button type="submit" class="btn btn-secondary" style="margin: 0px 0px 0px 25px;">Search</button>

                          </div>
                      </div>
                </form>
              </div>
          </div>
        @endif

            </div>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
        <br>
        <?php
        $brnc =0;
        if(isset($_GET['division']))
        {
        $div = $_GET['division'];
        }
        if(isset($_GET['region']))
        {
        $reg = $_GET['region'];
        }
        if(isset($_GET['area']))
        {
        $are = $_GET['area'];
        }
        if(isset($_GET['branch']))
        {
        $brnc = $_GET['branch'];
        } 
        if($brnch !='')
        {
        ?>
        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" style="font-size: 13" class="table table-bordered">
                <tr class="brac-color-pink">
                  <th>SL</th>
                  <th>Monitoring Period</th>
                  <th>Result</th>
                </tr>
                <tbody>
                    <?php
                    $id =1;
                    $g =0;
                    $m=0;
                    $p=0;
                    foreach ($br as $row) 
                    {
                      $g =0;
                      $m=0;
                      $p=0;
                      $evnetid= $row->id;
                      $score = $row->score;
                      $year = $row->year;
                      $quarter = $row->quarterly;
                      if($score >='85')
                      {

                        $g ="Good";
                      }
                      else if($score >='70' and $score <'85')
                      {
                        $m = "Modarate";
                      }
                      else if($score < 70)
                      {
                        $p ='Need Improvment';
                      }
                    ?>
                    <tr>
                      <td><?php echo $id++; ?></td>
                      <td><a style="color: #3699FF" href="ManagerDashboard?eventid=<?php echo $evnetid; ?>&division=<?php echo $div; ?>&region=<?php echo $reg; ?>&area=<?php echo $are; ?>&branch=<?php echo $brnc; ?>"> <?php echo $row->datestart." to ".$row->dateend; ?></a></td>
                      <td><?php 
                      if($g){
                        echo "Good";
                     } if($m){
                       echo "Moderate";

                     } if($p){
                       echo "Need Improvment";
                       }
                        ?></td>
                    </tr>
                    <?php

                  } 
                  ?>
                </tbody>
              </table>
            </div>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
        <?php
        if($evnt !='')
        {
          $cycle ='';
          $brnch1 = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnch' and id='$evnt' order by id DESC limit 1"));
          if(!empty($brnch1))
          {
           $cycle= $brnch1[0]->datestart." to ".$brnch1[0]->dateend;
          }
          ?>

        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <div class="card-header">
              <h3 class="card-title">Monitoring Event: <?php echo $cycle; ?> </h3>
            </div><!-- /.box-header -->
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" style="font-size: 13" class="table">
                <tr class="brac-color-pink">
                    <th nowrap="nowrap" width="15px">Section No</th>
                    <th width="45%">Section Name</th>
                    <th width="20%">Score</th>
                    <th width="20%">Status</th>
                </tr>
              </table>
              <?php 
  $brnch = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnch' and id='$evnt' order by id DESC limit 1"));
  if(!empty($brnch))
  {
   foreach ($brnch as $row) 
   {
     $dst = $row->datestart;
     $dend = $row->dateend;
     $evnetid = $row->id;
     $c_date = Date('Y-m-d');
     if($dst <= $c_date and $dend >=$c_date)
     {
       $stus ="Ongoining!";
     }
     else
     {
       $stus ="Complete!";
     }
     $sections = DB::select( DB::raw("select sec_no,score from mnwv2.cal_sections_score where event_id='$evnetid' group by sec_no,score order by sec_no ASC"));
     if(!empty($sections))
     {
      foreach ($sections as $row) 
      {
        $section = $row->sec_no;
        $score = round($row->score,2);
        $secname = DB::select( DB::raw("select * from mnw.def_sections where sec_no='$section'"));
        if(empty($secname))
        {
          $name ='';
        }
        else{
          $name = $secname[0]->sec_name;
        }
        ?>
        <table style="text-align: center;font-size:13" style="font-size: 13" class="table" cellspacing="0" width="100%">
         <tr>
          <td nowrap="nowrap" width="15%"><button id="<?php echo $section; ?>" class="btn btn-light showdiv" onClick="getDiv(<?php echo $section; ?>);" >+</button><span class="ml-3"><?php echo "Section: ".$section; ?></span></td>
          <td width="45%"><?php echo $name; ?></td>
          <td width="20%" ><?php echo $score; ?></td>
          <td width="20%" ><?php echo $stus; ?></td>
        </tr>
      </table>
      <table style="text-align: center;font-size:13" style="font-size: 13" id="<?php echo "dv".$section; ?>" class="table" cellspacing="0" width="100%">
        <thead>
          <tr class="brac-color-pink">
            <th width="10%" style=" text-align: center;">SL</th>
            <th style=" " width="50%">Details</th>
            <th style=" " width="20%">Score</th>
            <th style=" " width="20%">Achievement %</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $pnt =0;
          $qpnt =0;
          $totalsc =0;
          $alldata = DB::select( DB::raw("select sub_id,point,question_point,section from mnwv2.cal_section_point where section = '$section' and event_id='$evnetid' group by sub_id,point,question_point,section order by sub_id ASC"));
          if(!empty($alldata))
          {
            foreach ($alldata as $row) 
            {
              if($section=='1')
              {
                $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$section' and qno='$row->sub_id'"));
              }
              else
              {
                $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$section' and sub_sec_no='$row->sub_id' and qno='0'"));
              }
  
              if(empty($secname))
              {
  
              }
              else{
                $name = $secname[0]->qdesc;
              }
              $pnt = $row->point;
              $qpnt = $row->question_point;
              $totalsc =0;
              if($pnt !=0)
              {
                $totalsc = round(($pnt/$qpnt*100),2);
              }
              ?>
              <tr>
              <td style="text-align:center"><a class="btn btn-light" target="_blank" href="MSectionDetails?data=<?php echo $section.",".$row->sub_id.",".$evnetid; ?>"><?php echo $row->section.".".$row->sub_id; ?></a></td>
              <td><?php echo $name; ?></td>
              <td ><?php echo $row->point; ?></td>
              <td ><?php echo $totalsc; ?></td>
            </tr>
            <?php
           }
         }
       ?>
     </tbody>
   </table>
   <?php
  }
  }
  
  }
  }
}
else
{

  $cycle ='';
  $brnch1 = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnch' order by id DESC limit 1"));
  // dd($brnch);

  if(!empty($brnch1))
  {
  $cycle= $brnch1[0]->datestart." to ".$brnch1[0]->dateend;
  }
  ?>
  <div class="col-md-12">
    <div class="card card-custom gutter-b">
      <!--begin::Form-->
      <div class="card-header">
        <h3 class="card-title">Monitoring Event: <?php echo $cycle; ?> </h3>
      </div><!-- /.box-header -->
      <div class="card-body table-responsive">
        <table style="text-align: center;font-size:13" style="font-size: 13" class="table">
          <tr class="brac-color-pink">
              <th nowrap="nowrap" width="15%">Section No</th>
              <th width="45%">Section Name</th>
              <th width="10%">Score</th>
              <th width="10%">Status</th>
          </tr>
        </table>
  <?php 
  $brnch = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnch' order by id DESC limit 1"));
  if(!empty($brnch))
  {
  foreach ($brnch as $row) 
  {
    
    $dst = $row->datestart;
    $dend = $row->dateend;
    $evnetid = $row->id;
    $c_date = Date('Y-m-d');
    if($dst <= $c_date and $dend >=$c_date)
    {
      $stus ="Ongoining!";
    }
    else
    {
      $stus ="Complete!";
    }
    $sections = DB::select( DB::raw("select sec_no,score from mnwv2.cal_sections_score where event_id='$evnetid' group by sec_no,score order by sec_no ASC"));
    if(!empty($sections))
    {
  // dd($sections);

      foreach ($sections as $row) 
      {
        $section = $row->sec_no;
        $score = round($row->score,2);
        $secname = DB::select( DB::raw("select * from mnw.def_sections where sec_no='$section'"));
        if(empty($secname))
        {
          $name ='';
        }
        else{
          $name = $secname[0]->sec_name;
        }
        ?>
        <table style="text-align: center;font-size:13" style="font-size: 13" class="table" cellspacing="0" width="100%">
        <tr>
          <td nowrap="nowrap" width="15%"><button id="<?php echo $section; ?>" class="btn btn-light showdiv" onClick="getDiv(<?php echo $section; ?>);" >+</button><span class="ml-3"><?php echo "Section: ".$section; ?></span></td>
          <td width="45%"><?php echo $name; ?></td>
          <td width="20%" ><?php echo $score; ?></td>
          <td width="20%" ><?php echo $stus; ?></td>
        </tr>
      </table>
      <table style="text-align: center;font-size:13" style="font-size: 13" id="<?php echo "dv".$section; ?>" class="table" cellspacing="0" width="100%">
        <thead>
          <tr class="brac-color-pink">
            <th width="10%" style=" text-align: center;">SL</th>
            <th style=" " width="50%">Details</th>
            <th style=" " width="20%">Score</th>
            <th style=" " width="20%">Achievement %</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $pnt =0;
          $qpnt =0;
          $totalsc =0;
          $alldata = DB::select( DB::raw("select sub_id,point,question_point,section from mnwv2.cal_section_point where section = '$section' and event_id='$evnetid' group by sub_id,point,question_point,section order by sub_id ASC"));
          if(!empty($alldata))
          {
            foreach ($alldata as $row) 
            {
              if($section=='1')
              {
                $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$section' and qno='$row->sub_id'"));
              }
              else
              {
                $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$section' and sub_sec_no='$row->sub_id' and qno='0'"));
              }

              if(empty($secname))
              {

              }
              else{
                $name = $secname[0]->qdesc;
              }
              $pnt = $row->point;
              $qpnt = $row->question_point;
              $totalsc =0;
              if($pnt !=0)
              {
                $totalsc = round(($pnt/$qpnt*100),2);
              }
              ?>
              <tr>
              <td style="text-align:center"><a class="btn btn-light" target="_blank" href="MSectionDetails?data=<?php echo $section.",".$row->sub_id.",".$evnetid; ?>"><?php echo $row->section.".".$row->sub_id; ?></a></td>
              <td><?php echo $name; ?></td>
              <td ><?php echo $row->point; ?></td>
              <td ><?php echo $totalsc; ?></td>
            </tr>
            <?php
          }
        }
      ?>
    </tbody>
  </table>
  <?php
  }
  }

  }
  }
}

?>
<?php } ?>
            </div>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
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
    $('#divs').on('change', function() {
     var division_id= this.value;
       //alert(division_id);
       if(division_id !='')
       {  
         $.ajax({
           type: 'POST',
           url: '/mnwv2/RegionData',cache: false,
           dataType: 'json',
           data: { id: division_id },
           success: function (data) {
   
           //var d = data[0].region_id;
           //console.log(d);
           var len = data.length;
           $("#region_id").empty();
           $("#area_id").empty();
           $("#branch_id").empty();
           
           var option2 = "<option value=''>select</option>";
           $("#region_id").append(option2);
           for(var i = 0; i < len; i++)
           {
             var option = "<option value='"+data[i].region_id+"'>"+data[i].region_name+"</option>"; 
   
             $("#region_id").append(option); 
           }
           
         },
         error: function (ex) {
           alert('Failed to retrieve Region.');
         }
       });
         
         return;
       }
     });
    $('#region_id').on('change', function() {
     var region_id= this.value;
       //alert(region_id);
       if(region_id !='')
       {  
         $.ajax({
           type: 'POST',
           url: '/mnwv2/AreaData',cache: false,
           dataType: 'json',
           data: { id: region_id },
           success: function (data) {
   
           //var d = data[0].region_id;
           //console.log(d);
           var len = data.length;
           $("#area_id").empty();$("#branch_id").empty();
           
           var option2 = "<option value=''>select</option>";
           $("#area_id").append(option2);
           for(var i = 0; i < len; i++)
           {
             var option = "<option value='"+data[i].area_id+"'>"+data[i].area_name+"</option>"; 
   
             $("#area_id").append(option); 
           }
           
         },
         error: function (ex) {
           alert('Failed to retrieve Area.');
         }
       });
         
         return;
       }
     }); 
    $('#area_id').on('change', function() {
     var area_id= this.value;
       //alert(area_id);
       if(area_id !='')
       {  
         $.ajax({
           type: 'POST',
           url: '/mnwv2/BranchData',cache: false,
           dataType: 'json',
           data: { id: area_id },
           success: function (data) {
   
           //var d = data[0].region_id;
           //console.log(d);
           var len = data.length;
           $("#branch_id").empty();
           
           var option2 = "<option value=''>select</option>";
           $("#branch_id").append(option2);
           for(var i = 0; i < len; i++)
           {
             var option = "<option value='"+data[i].branch_id+"'>"+data[i].branch_name+"</option>"; 
   
             $("#branch_id").append(option); 
           }
           
         },
         error: function (ex) {
           alert('Failed to retrieve Area.');
         }
       });
         
         return;
       }
     }); 
   </script>
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
@endsection