@extends('backend.layouts.master')

@section('title','Monitor Survey_data Upload')

@section('content')
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
      <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">
          <!--begin::Page Title-->
          <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Monitor Survey_data Creation</h5>
        </div>
        <!--end::Info-->
      </div>
    </div>
    <div class="d-flex flex-column-fluid">
      <!--begin::Container-->
      <div class="container">
        <!--begin::Card-->
        <div class="card card-custom">
          <div class="card-body">
            <!--begin: Datatable-->
            <div class="row">  
              <div class="col-md-8 col-xs-12 col-sm-12 offset-md-2">   
                @if (Session::has('success'))
                <div class="alert alert-success" role="success">
                  {{ Session::get('success') }}
                </div>
                @endif
              <form action="SurveyExcelStore" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                        <input type="file" class="file" id="file" name="excel_file" required="">

                          <div class="custom-file">
                            <label class="custom-file-label" for="customFile">Upload Survey_data Excel</label>
                          </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                          <a class="btn btn-block btn-primary" href="http://scm.brac.net/mnwv2/css/sample/user_sample.xlsx">Sample Xlsx File</a>
                        </div>
                    </div> -->
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