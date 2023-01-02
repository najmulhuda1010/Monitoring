
@extends('backend.layouts.master')

@section('title','Cluster Report')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Cluster Report</h5>
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
            <div class="card-body">
                    
              <div class="row">
                <div class="col-md-12 gutter-b float-right">
                    <a href="ClusterAdd" class="btn btn-secondary">Add Cluster</a>
                    <a href="ClusterAddAccId" class="btn btn-secondary">Add Associate Id</a>
                </div>
                <div class="col-md-12">
                  <table style="text-align: center;font-size:13" style="font-size:13" class="table table-bordered" id="data-table">
                    <thead>
                        <tr class="brac-color-pink">
                          <th>Cluster Id</th>
                          <th>Cluster Name</th>
                          <th>Branch Code</th>
                          <th>Branch Name</th>
                          <th>Area Name</th>
                          <th>Region Name</th>
                          <th>Division Name</th>
                          <th>Zonal Code</th>
                          <th>Zonal Name</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>  
                </div>
            </div>
            </div>
            <!--end::Form-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
        <br>
        
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
    $(function () {
       var table = $('#data-table').DataTable({
       processing: true,
       serverSide: true,
       responsive: true,
       ajax: "{{ url('ClusterLoad') }}",
       columns: [
           {data: 'cluster_id', name: 'cluster_id',searchable: false },
           {data: 'cluster_name', name: 'cluster_name'},
           {data: 'branch_code', name: 'branch_code'},
           {data: 'branch_name', name: 'branch_name',searchable: false},
           {data: 'area_name', name: 'area_name',searchable: false},
           {data: 'region_name', name: 'region_name',searchable: false},
           {data: 'division_name', name: 'division_name',searchable: false},
           {data: 'zonal_code', name: 'zonal_code',searchable: false},
           {data: 'zonal_name', name: 'zonal_name',searchable: false},
           ]
        });
   });
   
   </script> 
@endsection