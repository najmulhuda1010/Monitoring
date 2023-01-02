@extends('backend.layouts.master')

@section('title','Edit Upcoming Event')

@section('content')

  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
      <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">
          <!--begin::Page Title-->
          <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Update Event</h5>
        </div>
        <!--end::Info-->
      </div>
    </div>
    <div class="d-flex flex-column-fluid">
      <!--begin::Container-->
      <div class="container">
        <!--begin::Card-->
        <div class="card card-custom">
          {{-- <div class="card-header flex-wrap py-5">
            <div class="card-title">
              <h3 class="card-label">Form </h3>
            </div>
          </div> --}}
          <div class="card-body">
            <!--begin: Datatable-->
            <div class="row">  
              <div class="col-md-8 col-xs-12 col-sm-12 offset-md-2">   
                @if (Session::has('success'))
                <div class="alert alert-success" role="success">
                  {{ Session::get('success') }}
                </div>
                @endif
                <form id="UserEditStore" action="StoreUpcoming" method="POST">
                <input type="hidden" class="form-control" name="id" value="<?php echo $edit[0]->id; ?>">
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Branch Code</label>
                    <input type="text" class="form-control"name="branch_code" value="<?php echo $edit[0]->branchcode; ?>" disabled="">
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleInputPassword1">Branch Name</label>
                    <?php 
				     $brcode ='';
				     $brcode = $edit[0]->branchcode;
					 $brsubst = substr($brcode,0,1);
					 if($brsubst=='0')
					 {
						 $brcode = substr($brcode,1,3);
					 }
					
					 $brname = DB::table('branch')->where('branch_id',$brcode)->where('program_id',1)->get();
					 if(!$brname->isEmpty())
					 {
						 $branchname = $brname[0]->branch_name;
					 }
					 else
					 {
						 $branchname ='';
					 }
				   ?>
                    <input type="text" class="form-control uname" name="branch_name" value="<?php echo $branchname; ?>" disabled="">
                  </div>
                  
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Date Start</label>
                              <input type="date" class="form-control" name="datestart" value="<?php echo $edit[0]->datestart; ?>">
                            </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Date End</label>
                            <input type="date" class="form-control" name="dateend" value="<?php echo $edit[0]->dateend; ?>">
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">M1 Code</label>
                              <select class="form-control" name="monitor1_code" id="monitor1_code" data-dependent="name">
                                <option value="<?php echo $edit[0]->monitor1_code; ?>"><?php echo $edit[0]->monitor1_code; ?></option>
                                <?php
                                $m2all = DB::table('mnwv2.user')->get();
                                if(!$m2all->isEmpty())
                                {
                                  foreach($m2all as $row)
                                  {
                                    ?>
                                    <option value="<?php echo $row->user_pin; ?>"><?php echo $row->user_pin; ?></option>
                                    <?php
                                  }
                                }
                                ?>
                                </select>
                            </div>
                      </div>
                      <?php
                            $m1code = $edit[0]->monitor1_code;
                            $m1nm=DB::table('mnwv2.user')->where('user_pin',$m1code)->get();
                            if($m1nm->isEmpty())
                            {
                                $m1name ='';
                            }
                            else
                            {
                                
                                $m1name = $m1nm[0]->name;
                            }
                        ?>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">M1 Name</label>
                            <input type="text" class="form-control" name="name1" value="<?php echo $m1name; ?>" disabled>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">M2 Code</label>
                              <select class="form-control"name="monitor2_code" id="monitor2_code" data-dependent="name">
                                <option value="<?php echo $edit[0]->monitor2_code; ?>"><?php echo $edit[0]->monitor2_code; ?></option>
                                <?php
                                $m2all = DB::table('mnwv2.user')->get();
                                if(!$m2all->isEmpty())
                                {
                                    foreach($m2all as $row)
                                    {
                                        ?>
                                        <option value="<?php echo $row->user_pin; ?>"><?php echo $row->user_pin; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select> 
                            </div>
                      </div>
                      <?php
                        $m2code = $edit[0]->monitor2_code;
                        $m2nm=DB::table('mnwv2.user')->where('user_pin',$m2code)->get();
                        if($m2nm->isEmpty())
                        {
                            $m2name ='';
                        }
                        else
                        {
                            
                        $m2name = $m2nm[0]->name;
                        }
                    ?>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">M2 Name</label>
                            <input type="text" class="form-control" name="name1" value="<?php echo $m1name; ?>" disabled>
                            </div>
                      </div>
                  </div>
                </div><!-- /.box-body -->

                <div class="form-group">
                  <center><button type="submit" class="btn btn-block btn-secondary">Update</button></center>
                </div>
              </form>

              </div>
              </div>
            <!--end: Datatable-->
          </div>
        </div>
        <!--end::Card-->
      </div>
      <!--end::Container-->
    </div>
  </div>
@endsection