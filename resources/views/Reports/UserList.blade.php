
@extends('backend.layouts.master')

@section('title','User List')

@section('style')
<style>
  .pagination{
    float: right;
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
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">User List Report</h5>
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
              <input type="search" id="myInput" class="form-control mt-5" placeholder="search name here">
            </div><!-- /.box-header -->
            <!--begin::Form-->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12 table-responsive">
                    <table style="text-align: center;font-size:13" id ="myTable" class="table table-bordered">
                        <thead>
                          <tr class="brac-color-pink">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Username</th>
                            <th>User Pin</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $mname='';
                            $mname2='';
                            $m2 ='';
                            $m1 ='';
                            $id=1;
                            foreach($userlsit as $row)
                            {
                              ?>
                                <tr>
                                    <td><?php echo $id; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->email; ?></td>
                                    <td><?php echo $row->phone; ?></td>
                                    <td><?php echo $row->username; ?></td>
                                    <td><?php echo $row->user_pin; ?></td>
                                    <td>
                                        <form action="{{ route('deletecreation',$row->id )}}" method="post" style="display:inline;" onsubmit="if(confirm('Delete? are you sure?')){return ture } else {return false };">

                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                          <input type="hidden" name="_method" value="delete">
                                          <a class="btn btn-light" href="UserEdit?id=<?php echo $row->id; ?>">Edit</a>
                
                                          <button type="submit" class="btn btn-danger">Delete </button>
                                         </form>
                                    </td>
                                </tr>
                              <?php
                              $id++;
                            }
                
                           ?>
                          
                        </tbody>
                      </table>
                      
                </div>
                <nav aria-label="Page navigation example" class="table-responsive justify-content-center">
                    {{$userlsit->links("pagination::bootstrap-4")}}
                </nav>
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
 
    $(document).ready(function(){
        $('#myInput').keyup(function() {
            var datas = this.value;
            if(datas !='')
            {
                $.ajax({
                     type: 'POST',
                     url: '/mnwv2/UserSearch',cache: false,
                     dataType: 'json',
                     data: { id: datas },
                     success: function (data) {
                         //alert("huda");
                          var len = data.length;
                          $("tbody").empty();
                          for(var i = 0; i < len; i++)
                           {
                             //var option = "<option value='"+data[i].area_id+"'>"+data[i].area_id+"-"+data[i].area_name+"</option>";
                              var trHTML =
                                               '<tr><td>'+ data[i].id +'</td><td>' + data[i].name + '</td><td>' +  data[i].email + '</td><td>' + data[i].phone + '</td><td>'+ data[i].username + '</td><td>'+data[i].user_pin+'</td><td><a class="btn btn-primary" href="UserEdit?id='+data[i].id+'">Edit</a><a class="btn btn-danger" href="">Delete</a></td></tr>';
                             $("tbody").append(trHTML); 
                           }
                     },
                     error: function (ex) {
                       alert('Failed to retrieve Area.');
                     }
                    
                });
            }
            else
            {
                //alert("huda");
                var datas ='';
                $.ajax({
                     type: 'POST',
                     url: '/mnwv2/UserSearch',cache: false,
                     dataType: 'json',
                     data: { id: datas },
                     success: function (data) {
                          //alert("huda");
                          var datalength = data.data;
                          var name = datalength[1].name;
                          //alert(name);
                          var len = datalength.length;
                          $("tbody").empty();
                          var id=1;
                          for(var i = 0; i < len; i++)
                           {
                             //var option = "<option value='"+data[i].area_id+"'>"+data[i].area_id+"-"+data[i].area_name+"</option>";
                              var trHTML =
                                               '<tr><td>'+ id +'</td><td>' + datalength[i].name + '</td><td>' +  datalength[i].email + '</td><td>' + datalength[i].phone + '</td><td>'+ datalength[i].username + '</td><td>'+datalength[i].user_pin+'</td><td><a class="btn btn-primary" href="UserEdit?id='+data[i].id+'">Edit</a><a class="btn btn-danger" href="">Delete</a></td></tr>';
                             $("tbody").append(trHTML);
                             id++;
                           }
                     },
                     error: function (ex) {
                       alert('Failed to retrieve Area.');
                     }
                    
                });
            }
       });
        
    });
   </script>
@endsection