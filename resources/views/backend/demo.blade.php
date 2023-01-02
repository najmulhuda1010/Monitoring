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
                <div class="col-md-2">
                <label class="control-label">Branch</label>
                    <select class="form-control">
                        <option>select</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
                <div class="col-md-2">
                    
                </div>
            </div>
            <div class="row mt-7">
                <div class="col-12">
                  <button class="btn btn-secondary" >Submit</button>
                  <button type="submit" class="btn btn-secondary ml-5" >Excel Export</button>
                </div>
            </div>
            <div class="row mt-7">
                <div class="col-12">
                  <table style="text-align: center;font-size:13" class="table table-borderless" style="margin-bottom: 0;">
                    <tr style="text-align: center">
                      <th colspan="3">BRAC Microfinance</th>
                    </tr>
                    <tr style="text-align: center">
                      <th colspan="3">Dabi Monitoring Unit</th>
                    </tr>
                    <tr style="text-align: center">
                      <th colspan="3">Branch Wise Monitoring New Way Score</th>
                    </tr>
                    <tr>
                      <th>Area:</th>
                      <th>Region:</th>
                      <th>Division:</th>
                    </tr>
                    <tr>
                      <th>Quarter</th>
                      <th colspan="2">Period</th>
                    </tr>
                    <tr>
                  </table>
                  <div class="table-responsive">
                  <table style="text-align: center;font-size:13" class="table table-bordered">
                    <tr>
                      <th>SL</th>
                      <th>Full Marks</th>
                      <th>Section & Indicator Name</th>
                      <th>Durakuti</th>
                      <th>Durakuti</th>
                      <th>Durakuti</th>
                      <th>Durakuti</th>
                      <th>Durakuti</th>
                      <th>Durakuti</th>
                      <th>Durakuti</th>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>John</td>
                      <td> Doe</td>
                      <td> Doe</td>
                      <td> Doe</td>
                      <td> Doe</td>
                      <td> Doe</td>
                      <td> Doe</td>
                      <td> Doe</td>
                    </tr>
                  </table>
                  </div>
                </div>
            </div>
            </div>
            </form>
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