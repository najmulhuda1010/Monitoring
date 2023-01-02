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

@section('title','Cluster Creation')
@section('style')
<style>
.scrollbar {
    background-color: #F5F5F5;
    height: 300px;
    border-radius: 0.42rem;
    margin-top: 5px;
    overflow-y: scroll;
    padding: 10px 0px 0px 10px;
}
.form-check-inline {
    width: 38px;
    margin-bottom: 10px;
}
</style>
@endsection
@section('content')
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
      <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">
          <!--begin::Page Title-->
          <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Cluster Creation</h5>
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
                @if (Session::has('error'))
                <div class="alert alert-danger" role="success">
                  {{ Session::get('error') }}
                </div>
                @endif
                <form id="form_signup" method="POST" action="ClusterAdd">
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Zonal Code</label>
                    <input type="text" class="form-control lname" name="zonalcode" placeholder="Zonal Name" required data-parsley-error-message="Please Enter Cluster Code" list="zonals">
                    <datalist id="zonals">
                        <?php
                         $zonalsql = DB::select(DB::raw("select * from mnwv2.zonal"));
                         foreach($zonalsql as $row)
                         {
                            ?>
                            <option value="<?php echo $row->zonal_code; ?>"><?php echo $row->zonal_code."-".$row->zonal_name; ?></option>
                            <?php
                         }
                 ?>
                </datalist>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Cluster Name</label>
                    <input type="text" class="form-control lname" name="clustername" placeholder="Cluster Name" required data-parsley-error-message="Please Enter Cluster Code" list="cluster_name">
                    <datalist id="cluster_name">
                    <?php
                            $cluster_names = DB::table('mnwv2.cluster')->select('cluster_name')->groupBy('cluster_name')->get();
                            foreach($cluster_names as $row)
                            {
                                ?>
                        <option value="{{ $row->cluster_name }}">
                        <?php } ?>
                        </datalist>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Cluster Code</label>
                    <input type="text" class="form-control lname" name="clusterid" placeholder="Cluster Code" required data-parsley-error-message="Please Enter Cluster Code" list="cluster_id">
                    <datalist id="cluster_id">
                        <?php
                        $cluster_ids = DB::table('mnwv2.cluster')->select('cluster_id')->groupBy('cluster_id')->orderBy('cluster_id')->get();
                        foreach($cluster_ids as $row)
                        {
                        ?>
                        <option value="{{ $row->cluster_id }}">
                        <?php } ?>
                    </datalist>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Branch Code</label>
                    <div class="scrollbar">
                        <?php
                        $branchsql = DB::select(DB::raw("select * from branch where program_id='1' order by branch_id"));
                        foreach($branchsql as $row)
                        {
                            ?>
                              
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name = "branch[]" id="inlineCheckbox3" value="<?php echo $row->branch_id; ?>">
                                <label class="form-check-label" for="inlineCheckbox3"><?php echo " ".$row->branch_id; ?></label>
                              </div>
                            <?php
                        }
                        ?>
                          
                        </div> 
                  </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                  <center><button type="submit" class="btn btn-secondary btn-block">Submit</button></center>
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