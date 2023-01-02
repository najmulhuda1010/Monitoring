
@extends('backend.layouts.master')

@section('title','Demo Dashboard')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Demo Dashboard</h5>
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
            <!--begin::Form-->
            <form>
            <div class="card-body">
              <div class="row">
                <div class="col-md-2">
                <label class="control-label">Division</label>
                    <select class="form-control">
                        <option>select</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
                <div class="col-md-2">
                <label class="control-label">Region</label>
                    <select class="form-control">
                        <option>select</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
                <div class="col-md-2">
                <label class="control-label">Area</label>
                    <select class="form-control">
                        <option>select</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
                <div class="col-md-2">
                <label class="control-label">Branch</label>
                    <select class="form-control">
                        <option>select</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-secondary" style="margin: 25px 0px 0px 25px;">Submit</button>
                </div>
            </div>
            </div>
            </form>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
        <br>
        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" class="table table-bordered">
                <tr class="brac-color-pink">
                  <th>Monitoring Event</th>
                  <th>Monitoring Period</th>
                  <th>Result</th>
                </tr>
                <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>11-7-2014</td>
                </tr>
                <tr>
                  <td>219</td>
                  <td>Alexander Pierce</td>
                  <td>11-7-2014</td>
                </tr>
              </table>
            </div>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <div class="card-header">
              <h3 class="card-title">Monitoring Event: 2020-Cycle-1 </h3>
            </div><!-- /.box-header -->
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" class="table table-bordered">
                <thead>
                  <tr  class="brac-color-pink">
                    <th rowspan="2" width="15%">Section</th>
                    <th rowspan="2" width="20%">Section Name</th>
                    <th colspan="3" width="20%">Month wise achievement %</th>
                    <th rowspan="2" width="15%">Quarterly achievement %</th>
                  </tr>
                  <tr class="brac-color-pink">
                    <th width="10%">JAN</th>
                    <th width="10%">FEB</th>
                    <th width="10%">MAR</th>
                  </tr>
                 </thead>
              </table>
            </div>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
        <div class="col-md-12">
          <div class="card card-custom gutter-b">
            <!--begin::Form-->
            <div class="card-header">
              <h3 class="card-title">Branch Count</h3>
            </div><!-- /.box-header -->
            <div class="card-body table-responsive">
              <table style="text-align: center;font-size:13" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                 <tr class="brac-color-pink">
                   <th rowspan="3">Monitoring Event</th>
                   <th rowspan="3">Division Total Br No</th>
                   <th colspan="2">Total branch monitored</th>
                   <th colspan="6">Rating wise branch no</th>
                 </tr>
                 <tr  class="brac-color-pink">
                   <th rowspan="2">No</th>
                   <th rowspan="2">% (of all branch)</th>
                   <th colspan="2">Good</th>
                   <th colspan="2">Moderate</th>
                   <th colspan="2">Poor</th>
                 </tr>
                 <tr  class="brac-color-pink">
                   <th>No</th>
                   <th>%</th>
                   <th>No</th>
                   <th>%</th>
                   <th>No</th>
                   <th>%</th>
                 </tr>
               </thead>
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