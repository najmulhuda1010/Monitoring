@extends('backend.layouts.master')

@section('title','Zonal Report')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
      <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Zonal Report</h5>
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
            {{-- <div class="card-header">
              <h4 class="card-title">Monitoring Event: asd </h4>
            </div> --}}
            <!--begin::Form-->
            <div class="card-body table-responsive">
              <p class="card-title"><a class="btn btn-secondary" href="ZonalAdd">Add Zonal</a></p>
              <table style="text-align: center;font-size:13" class="table">
                <tr class="brac-color-pink">
                    <th>#</th>
                    <th>Zonal Name</th>
                    <th>Zonal Code</th>
                </tr>
                <tbody>
                    <?php
                      $name='';
                      $id=1;
                      foreach($zonaldata as $row)
                      {
                           ?>
                           <tr>
                              <td><?php echo $id; ?></td>
                              <td><?php echo $row->zonal_name; ?></td>
                              <td><?php echo $row->zonal_code; ?></td>
                           </tr>
                           <?php
                      
                        $id++;
                      }
          
                     ?>
                    
                  </tbody>
              </table>
            </div>
            <div class="table-responsive">
                {{$zonaldata->links()}}
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