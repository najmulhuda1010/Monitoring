@extends('backend.layouts.master')

@section('title','Remarks')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
      <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Remarks</h5>
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
            <div class="card-header">
              <h3 class="card-title">Monitoring Period: <?php echo $datestart." to ".$dateend; ?></h3>
              <?php 
                $br = substr($branch,0,1);
                if($br =='0')
                {
                    $brn = substr($branch,1);
                    $brname = DB::select(DB::raw("select * from branch where branch_id='$brn'"));
                    if(!empty($brname))
                    {
                        $branchname = $brname[0]->branch_name;
                    }
                    else
                    {
                        $branchname ='';
                    }
                }
                else
                {
                    $brname = DB::select(DB::raw("select * from branch where branch_id='$branch'"));
                    if(!empty($brname))
                    {
                        $branchname = $brname[0]->branch_name;
                    }
                    else
                    {
                        $branchname ='';
                    }
                }
            ?>
              <h4 class="card-title">Branchname : <?php echo $branch."(".$branchname.")"; ?> </h4>
            </div><!-- /.box-header -->
            <!--begin::Form-->
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" class="table table-bordered">
                <tr class="brac-color-pink">
                  <th>Section/SubSection</th>
                  <th>Remarks</th>
                </tr>
                <tbody>
                    <?php
                    foreach($remarks as $row)
                    {
                        $sec = $row->sec_no;
                        //$menno = $row->orgmemno;
                        $question =  $row->question;
                        $sub_id =  $row->sub_id;
                        $event_id = $row->event_id;
                        if($sec=='1')
                        {
                            $sub_id =  $row->question;
                            $group = DB::select( DB::raw("select * from mnwv2.survey_data where event_id='$event_id' and sec_no='$sec' and question=$sub_id and remarks !=''"));
                            $cnt = count($group);
                        }
                        else
                        {
                            $sub_id = $row->sub_id;
                            $group = DB::select( DB::raw("select * from mnwv2.survey_data where event_id='$event_id' and sec_no='$sec' and sub_id=$sub_id and remarks !=''"));
                            $cnt =count($group);
                        }
                        
                        if(!empty($group))
                        {
                            ?>
                            <tr>
                             <td rowspan="<?php echo $cnt; ?>"><?php echo $sec.":".$sub_id; ?></td>
                             
                            <?php
                            foreach($group as $r)
                            {
                                ?>
                                
            
                                       <td><?php echo $r->orgmemno."-".$r->remarks; ?></td>
                                    </tr>
                                <?php
                            }
                            ?>
                            
                            <?php
                        }
                    }
                    ?>
                    </tbody>
              </table>
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

@endsection