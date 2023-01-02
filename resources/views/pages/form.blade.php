@extends('mainpage')

@section('title','Form')


@section('content')

 <form id="form_signup">
  <div class="container">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
      <div class="row">
      <div class="">
        <label for="fname">First Name</label>
      </div> 
      <div class="">
       <input type="text" class="form-control fname" id="fname" name="firstName" placeholder="Enter Your First Name" required data-parsley-error-message="Please Enter Your First Name">
      </div> 
    </div><!--end row-->
    <div class="row">
      <div class="">
        <label for="lname">Last Name</label>
      </div> 
      <div class="">
       <input type="text" class="form-control lname" id="lname" name="lastName" placeholder="Enter Your Last Name" required data-parsley-error-message="Please Enter Your Last Name">
      </div> 
    </div><!--end row-->
    <div class="row">
      <div class="">
        <label for="uname">User Name</label>
      </div> 
      <div class="">
       <input type="text" class="form-control uname" id="uname" name="userName" placeholder="Enter Your User Name" required data-parsley-error-message="Please Enter Your User Name">
      </div> 
    </div><!--end row-->
    <div class="row">
      <div class="">
        <label for="email">Email</label>
      </div> 
      <div class="">
       <input type="text" class="form-control email" id="email" name="eamil" placeholder="Enter Your Email" data-parsley-type="email" required data-parsley-error-message="Please Enter Your Email">
      </div> 
    </div><!--end row-->
    <div class="row">
      <div class="">
        <label for="pword">Password</label>
      </div> 
      <div class="">
       <input type="password" class="form-control pass" id="pword" name="password" placeholder="Enter your Password" data-parsley-length="[3,10]" required data-parsley-error-message="Please Enter Your Password">
      </div> 
    </div><!--end row-->
    <div class="row">
      <div class="">
        <label for="cpword">Confirm Password</label>
      </div> 
      <div class="">
       <input type="password" class="form-control cpass" id="cpword" name="cpassword" placeholder="Enter your Password Again" data-parsley-length="[3,10]" required data-parsley-error-message="Please Confirm Your Password">
      </div> 
    </div><!--end row-->
    <div class="row">
      
       <input type="submit" class="submit" name="submit" value="submit">
      
    </div><!--end row-->
    
    <div class="row">
      <div class="">
       <label for="cpword">Upload Your File</label>
      </div> 
      <div class="">
       <input type="file" class="file" id="file" name="file">
      </div> 
    </div><!--end row-->
    
     
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
    
  </div><!--end container-->

</form>
          
@endsection

