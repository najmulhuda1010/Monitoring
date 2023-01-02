<?php 
$username = Session::get('username');
if($username=='')
{
  
  ?>
  <script>
    window.location.href = 'Logout';
  </script>
  
  <?php 
  
}
?>
@extends('backend.layouts.master')

@section('title','Branch Report')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
      <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Branch Report</h5>
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
      <?php
        if($rollid!='2' and $rollid!='3' and $rollid!='4'){          
      ?>
      
        <div class="col-md-12">
        @if (Session::has('message'))
          <div class="alert alert-danger" role="alert">
            {{ Session::get('message') }}
          </div>
          @endif
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
                <option value="<?php echo $divisions[0]->division_id; ?>"><?php echo $divisions[0]->division_name; ?></option>
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
                 <!--<option>select</option>-->
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
                    <select class="form-control" name="region" id="region_id">
                        <option value="">select</option>
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
                    <select class="form-control" name="area" id="area_id">
                        <option value="">select</option>
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
                    <select class="form-control" name="branch" id="branch_id">
                        <option value="">select</option>
                        <?php 
                        if($brnchcode !='')
                        {
                        $branch = DB::select( DB::raw("select  branch_name,branch_id from branch  where branch_id= '$brnchcode' and program_id='1' group by branch_name,branch_id order by branch_id"));
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
                </div>
            </form>
            </div>
            <div class="row mt-7">
                <div class="col-md-12">
                    <form method="GET" target="_blank">
                        <label for="example-search-input" class="control-label">Branch Search</label>
                        <div class="form-group row">
                            <div class="col-8">
                             <input class="form-control" type="text" list="browsers" name="brnch" required/>
                             <datalist id="browsers">
                                <?php
                                //die();
                                if($rollid=='17' )
                                {
                                  $branch = DB::select(DB::raw("select branch_code,branch_name from mnwv2.cluster where c_associate_id ='$userpin' group by branch_code,branch_name"));
                                }
                                else if($rollid=='18')
                                {
                                  $branch = DB::select(DB::raw("select branch_code,branch_name from mnwv2.cluster where z_associate_id ='$userpin' group by branch_code,branch_name"));
                                }
                                else
                                {
                                  $branch = DB::select(DB::raw("select branch_id,branch_name from branch group by branch_id,branch_name"));
                                } 
                                  
                                if(!empty($branch))
                                {
                                  foreach($branch as $row)
                                  {
                                    if($rollid=='17' or $rollid=='18')
                                    {
                                      ?>
                                      <option value="<?php echo $row->branch_code; ?>"><?php echo $row->branch_name."-".$row->branch_code; ?></option>
                                     <?php
                                    }
                                    else
                                    {
                                      ?>
                                                  <option value="<?php echo $row->branch_id; ?>"><?php echo $row->branch_name."-".$row->branch_id; ?></option>
                                              <?php
                                    }
                                      
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
            </div>
            </form>
            <!--end::Form-->
            <?php } ?>
            <?php 
      if($brnchcode !='')
      {
        ?>
        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" class="table table-bordered">
                <tr class="brac-color-pink">
                  <th>SL</th>
                  <th>Monitoring Period</th>
                  <th>Result</th>
                </tr>
                <tbody>
                    <?php
                    $id =1;
                    $g ='';
                    $m='';
                    $p='';
                      foreach ($br as $row) 
                      {
                       // var_dump($row);
                         $score =0;
                         $g ='';
                         $m='';
                         $p='';
                         $evnetid= $row->id;
                         $score = $row->score;
                         $year = $row->year;
                         $quarter = $row->quarterly;
                       
                         if($score >=85)
                         {
                          $g ="Good";
                         }
                         else if($score >=70 and $score <=84)
                         {
                           $m = "Modarate";
                         }
                         else if($score < 70)
                         {
                          $p ='Poor';
                         }
                         else
                         {
                           $p="Poor";
                         }
                         ?>
                          <tr>
                            <td><?php echo $id++; ?></td>
                            <td><a style="color: #3699FF" href="GlobalReport?event=<?php echo $evnetid; ?>&area=<?php echo $area; ?>&branch=<?php echo $brnchcode; ?>&region=<?php echo $reg; ?>&division=<?php echo $div; ?>"><?php echo $row->datestart." to ".$row->dateend; ?></a></td>
                            <td><?php if($g){
                                echo "Good";
                             } if($m){
                               echo "Moderate";
                             } if($p){
                               echo "Need Improvment";
                               } ?></td>
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
      if($eventid !='')
      {
        $cycle ='';
        $brnch = DB::table('mnwv2.monitorevents')->where('branchcode',$brnchcode)->where('id',$eventid)->get();
        //$brnch1 = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnch' order by id DESC limit 1"));
        if(!empty($brnch))
        {
          $cycle= $brnch[0]->datestart." to ".$brnch[0]->dateend;
        }
        ?>

        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <div class="card-header">
              <h3 class="card-title">Monitoring Period: <?php echo $cycle; ?> </h3>
            </div><!-- /.box-header -->
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" class="table">
                <tr class="brac-color-pink">
                  <th>Section</th>
                  <th width="60%">Section Name</th>
                  <th width="20%">Achievement %</th>
                </tr>
              </table>
              <?php
            $sp =0;
            $qpnt =0;
            $tscore=0;
            // $brnch = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnch' order by id DESC limit 1"));
              if(!empty($brnch))
              {
                
                for ($i=1; $i <= 5 ; $i++) 
                {
                  $sp =0;
                  $qpnt =0; 
                  foreach ($brnch as $row) 
                  {
                    $dst = $row->datestart;
                    $dend = $row->dateend;
                    $evnetid = $row->id;
                    $section = DB::select( DB::raw("select * from mnwv2.cal_section_point where event_id='$evnetid' and section='$i'"));
                    if(!empty($section))
                    {
                      foreach ($section as $row) 
                      {
                        $sp +=$row->point;
                        $qpnt +=$row->question_point; 
                      }
                      $tscore =0;
                      if($sp !=0)
                      {
                        $tscore = round($sp/$qpnt*100,2);
                      }
                    }
                  }
                  $name ='';
                  $secname = DB::select( DB::raw("select * from mnwv2.def_sections where sec_no='$i'"));
                  if(empty($secname))
                  {
                    
                  }
                  else{
                    $name = $secname[0]->sec_name;
                  }
                  ?>
                  <table style="text-align: center;font-size:13" class="table" cellspacing="0" width="100%">
                  <tr>
                      <td><button id="<?php echo $i; ?>" class="btn btn-light showdiv" onClick="getDiv(<?php echo $i; ?>);" >+</button><span class="ml-5"><?php echo "Section- ".$i; ?></span></td>
                      <td width="60%"><?php echo $name;  ?></td>
                      <td width="20%"><?php echo $tscore." %"; ?></td>
                  </tr>
                  </table>
                  <table style="text-align: center;font-size:13" id=<?php echo "dv".$i; ?> class="table" cellspacing="0" width="100%">
                    <thead>
                        <tr class="brac-color-pink">
                            <th style=" ">Section Number</th>
                            <th style=" ">Details</th>
                            <th style=" ">Achievement %</th>
                          </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sp =0;
                      $qpnt=0;
                      $secname ='';
                      $sectiondetails = DB::select( DB::raw(" select * from mnwv2.cal_section_point where event_id='$evnetid' and section='$i' order by sub_id ASC"));
                      if(!empty($sectiondetails))
                      {
                        foreach ($sectiondetails as $row) 
                        {
						    $sp =$row->point;
						    $qpnt =$row->question_point;
						    $tscore =0;
						    if($sp !=0)
						    {
							  $tscore = round($sp/$qpnt*100,2);
						    }
						    $sub_id = $row->sub_id;
						    if($i=='1')
						    {
							   $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$i' and qno='$sub_id'"));
						    }
						    else
						    {
							  $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$i' and sub_sec_no='$sub_id' and qno=0"));
						    }
                           
							if(empty($secname))
							{
								  
							}
							else{
								$name = $secname[0]->qdesc;
							}
							  ?>
							  <tr>
								<td><?php echo $i.".".$sub_id; ?></td>
								<td><?php echo $name;  ?></td>
								<td><?php echo $tscore." %"; ?></td>
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
      else
      {
        //dd("Huda");

        $cycle ='';
        $currentDate = date('Y-m-d');
        $brnch2 = DB::table('mnwv2.monitorevents')->where('branchcode',$brnchcode)->orderBy('id', 'desc')->limit(2)->get();
        if(!$brnch2->isEmpty())
        {
          $limit =0;
          $offset = 0;
          foreach($brnch2 as $row)
          {
            $datestart = $row->datestart;
            $dateend = $row->dateend;
            //echo $datestart."<=".$currentDate."-".$dateend.">=".$currentDate;
            //if($currentDate >='$datestart' and $dateend >='$currentDate')
            if($datestart <=$currentDate and $dateend >=$currentDate)
            {
              $offset ++;
            }
            else
            {
              $limit ++;
              
              //$br = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnch' order by id DESC limit $limit"));
              $brnch1 = DB::table('mnwv2.monitorevents')->where('branchcode',$brnchcode)->orderBy('id', 'desc')->offset($offset)->limit(1)->get();
              
            }

          }
        }
        //$brnch1 = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnch' order by id DESC limit 1"));
        if(!empty($brnch1))
        {
          $cycle= $brnch1[0]->datestart." to ".$brnch1[0]->dateend;
        }
        ?>
        <div class="col-md-12">
            <div class="card card-custom gutter-b">
              <!--begin::Form-->
              <div class="card-header">
                <h3 class="card-title">Monitoring Period: <?php echo $cycle; ?> </h3>
              </div><!-- /.box-header -->
              <div class="card-body table-responsive">
                <table style="text-align: center;font-size:13" class="table">
                  <tr class="brac-color-pink">
                    <th>Section</th>
                    <th width="60%">Section Name</th>
                    <th width="20%">Achievement %</th>
                  </tr>
                </table>
            <?php
            $sp =0;
            $qpnt =0;
            $tscore=0;
            $currentDate = date('Y-m-d');
            $brnch1 = DB::table('mnwv2.monitorevents')->where('branchcode',$brnchcode)->orderBy('id', 'desc')->limit(2)->get();
            if(!$brnch1->isEmpty())
            {
              $limit =0;
              $offset = 0;
              foreach($brnch1 as $row)
              {
                $datestart = $row->datestart;
                $dateend = $row->dateend;
                //echo $datestart."<=".$currentDate."-".$dateend.">=".$currentDate;
                //if($currentDate >='$datestart' and $dateend >='$currentDate')
                if($datestart <=$currentDate and $dateend >=$currentDate)
                {
                  $offset ++;
                }
                else
                {
                  //$br = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnch' order by id DESC limit $limit"));
                  $brnch = DB::table('mnwv2.monitorevents')->where('branchcode',$brnchcode)->orderBy('id', 'desc')->offset($offset)->limit(1)->get();
                  
                }

              }
            
            }
            
            // $brnch = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnch' order by id DESC limit 1"));
              if(!empty($brnch))
              {
                
                for ($i=1; $i <= 5 ; $i++) 
                {
                  $sp =0;
                  $qpnt =0; 
                  foreach ($brnch as $row) 
                  {
                    $dst = $row->datestart;
                    $dend = $row->dateend;
                    $evnetid = $row->id;
                    $section = DB::select( DB::raw("select * from mnwv2.cal_section_point where event_id='$evnetid' and section='$i'"));
                    if(!empty($section))
                    {
                      foreach ($section as $row) 
                      {
                        $sp +=$row->point;
                        $qpnt +=$row->question_point; 
                      }
                      $tscore =0;
                      if($sp !=0)
                      {
                        $tscore = round($sp/$qpnt*100,2);
                      }
                    }
                  }
                  $name ='';
                  $secname = DB::select( DB::raw("select * from mnwv2.def_sections where sec_no='$i'"));
                  if(empty($secname))
                  {
                    
                  }
                  else{
                    $name = $secname[0]->sec_name;
                  }
                  ?>
                  <table style="text-align: center;font-size:13" class="table" cellspacing="0" width="100%">
                  <tr>
                      <td><button id="<?php echo $i; ?>" class="btn btn-light showdiv" onClick="getDiv(<?php echo $i; ?>);" >+</button><span class="ml-5"><?php echo "Section- ".$i; ?></span></td>
                      <td width="60%"><?php echo $name;  ?></td>
                      <td width="20%"><?php echo $tscore." %"; ?></td>
                  </tr>
                  </table>
                  <table style="text-align: center;font-size:13" id=<?php echo "dv".$i; ?> class="table" cellspacing="0" width="100%">
                    <thead>
                        <tr  class="brac-color-pink">
                            <th style=" ">Section Number</th>
                            <th style=" ">Details</th>
                            <th style=" ">Achievement %</th>
                          </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sp =0;
                      $qpnt=0;
                      $secname ='';
                      $sectiondetails = DB::select( DB::raw(" select * from mnwv2.cal_section_point where event_id='$evnetid' and section='$i' order by sub_id ASC"));
                      if(!empty($sectiondetails))
                      {
                        foreach ($sectiondetails as $row) 
                        {
                          $sp =$row->point;
                          $qpnt =$row->question_point;
                          $tscore =0;
                          if($sp !=0)
                          {
                            $tscore = round($sp/$qpnt*100,2);
                          }
                          $sub_id = $row->sub_id;
						  if($i=='1')
						  {
						   $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$i' and qno='$sub_id'"));
						  }
						  else
						  {
						      $secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$i' and sub_sec_no='$sub_id' and qno=0"));
						  }
                          //$secname = DB::select( DB::raw("select * from mnwv2.def_questions where sec_no='$i' and qno='$sub_id'"));
                            if(empty($secname))
                            {
                              
                            }
                            else{
                              $name = $secname[0]->qdesc;
                            }
                          ?>
                          <tr>
                            <td><?php echo $i.".".$sub_id; ?></td>
                            <td><?php echo $name;  ?></td>
                            <td><?php echo $tscore." %"; ?></td>
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
    ?>
          </div>
          
          <!--end::Advance Table Widget 4-->
        </div>
        </div>
        
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
<!-- </div> -->
    
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
         alert('Failed to retrieve Area.');
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