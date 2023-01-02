@extends('backend.layouts.master')

@section('title','Event Creation')

@section('content')
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
      <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">
          <!--begin::Page Title-->
          <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Monitor Event Creation</h5>
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
                <form id="form_signup" method="POST" action="Store">
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Event Cycle</label>
                    <select name="cycle" class="form-control">
                        <?php
                        $date = date('Y');
                        $d = $date+1;
                          for ($i=1; $i <3; $i++) 
                          {
                            ?>
                              <option><?php echo $date."-Cycle-".$i; ?></option>
                            <?php
                            }
                             for ($j=1; $j <3; $j++) { 
                          ?>
                              <option><?php echo $d."-Cycle-".$j; ?></option>
                            <?php
                            
                            }
                          ?>
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Branch Code</label>
                    <input type="text" name="branchcode" class="form-control" list="branch" required>
                        <datalist id="branch">
                        <option value="">select branch code</option>
                        <?php 
                        foreach($data as $row)
                        {
                            $brcode =$row->branch_id;
                            $t = strlen($brcode);
                            if($t=='1')
                            {
                            $brcode = '000'.$brcode;
                            }
                            else if($t=='2')
                            {
                            $brcode = '00'.$brcode; 
                            }
                            else if($t=='3')
                            {
                            $brcode = '0'.$brcode; 
                            }
                            else
                            {
                            $brcode = $brcode; 
                            }
                            ?>
                            <option value="<?php echo $brcode; ?>"><?php echo $brcode; ?></option>
                            <?php
                        }
                        ?>
                        
                        </datalist>
                  </div>
                  
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Date Start</label>
                              <input type="text" class="form-control uname" id="uname" name="datestart" placeholder="Enter Your Date" required data-parsley-error-message="Please Enter Date">
                            </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Date End</label>
                            <input type="text" class="form-control email" id="date" name="dateend" placeholder="Enter Your Date" data-parsley-type="email" required data-parsley-error-message="Please Enter Date">
                            </div>
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Monitor 1</label>
                    <input type="text" name="monitor1" class="form-control" list="monitor1" required>
                    <datalist id="monitor1">
                    <option value="">Select M1 Code</option>
                      @foreach($datas as $rows)
                                <option value="{{$rows->user_pin}}">{{$rows->user_pin}}</option>
                      @endforeach
                    
                    </datalist>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Monitor 2</label>
                    <input type="text" name="monitor2" class="form-control" list="monitor2" required>
                    <datalist id="monitor2">
                    <option value="">Select M2 Code</option>
                  @foreach($datas as $rows)
                              <option value="{{$rows->user_pin}}">{{$rows->user_pin}}</option>
                    @endforeach
                    
                    </datalist>
                  </div>
                </div><!-- /.box-body -->

                <div class="form-group">
                  <center><button type="submit" class="btn btn-block btn-secondary">Submit</button></center>
                </div>
              </form>
              <form action="Excel" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="excel_file" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose Excel file</label>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <a class="btn btn-block btn-primary" href="http://scm.brac.net/mnwv2/css/sample/event_sample.xlsx">Sample Xlsx File</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                  <center><button type="submit" class="btn btn-block btn-secondary">Submit</button></center>
                </div>
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