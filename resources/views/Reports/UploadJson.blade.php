@extends('mainpage')

@section('title','Monitor Event Creation')


@section('content')

  <div class="container">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
      <?php if(Session::has('success'))
      {
        ?>
         <div class="success">
        <div class="alert alert-success">
        {{Session::get('success')}}
        </div>
         </div>
      <?php
    
      } 
     ?>
      <div class="header">
        <h3><i>Monitor Backup Data Insertion:</i></h3>
        <br />
      </div>
    <form action="BackupJsonStore" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="">
         <label for="cpword">Upload Backup Json</label>
        </div> 
        <div class="">
         <input type="file" class="file" id="file" name="json_file" required="">
        </div> 
      </div><!--end row-->
      <div class="row">
         <input type="submit" class="submit" name="submit" value="submit">
      </div><!--end row-->
	  
     </form>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
    
  </div><!--end container-->
          
@endsection