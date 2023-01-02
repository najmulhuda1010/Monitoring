@extends('backend.layouts.master')

@section('title','User Creation')

@section('content')
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
      <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">
          <!--begin::Page Title-->
          <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Monitor User Creation</h5>
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
                <form id="form_signup" method="POST" action="UserCreateStore">
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Please Enter Your Name" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="text" class="form-control uname" id="email" name="email" placeholder="Please Enter Your Email" required data-parsley-error-message="Please Enter Email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Phone</label>
                    <input type="text" class="form-control phone" id="phone" name="phone" placeholder="Please Enter Your Phone" data-parsley-type="phone" required data-parsley-error-message="Please Enter Phone">
                  </div>
                  
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Username</label>
                              <input type="text" name="username" class="form-control" placeholder="Please Enter Your Username" required>
                            </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" name="password" class="form-control"  placeholder="Please Enter Your Password" required>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">User Pin</label>
                              <input type="number" min="0" name="userpin" class="form-control" placeholder="Please Enter Your User Pin" required>
                            </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Device Id</label>
                            <input type="text" name="deviceid" class="form-control" placeholder="Please Enter Your Device Id">
                            </div>
                      </div>
                  </div>
                </div><!-- /.box-body -->

                <div class="form-group">
                  <center><button type="submit" class="btn btn-block btn-secondary">Submit</button></center>
                </div>
              </form>
              <form action="UserExcel" method="POST" enctype="multipart/form-data">
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
                          <a class="btn btn-block btn-primary" href="http://scm.brac.net/mnwv2/css/sample/user_sample.xlsx">Sample Xlsx File</a>
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