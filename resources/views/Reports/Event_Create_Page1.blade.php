@extends('mainpage')

@section('title','Form')


@section('content')

 <form id="form_signup" method="POST" action="Store">
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
        <h3><i>Monitor Event Creation:</i></h3>
        <br />
      </div>
      <div class="row">
      <div class="">
        <label for="fname">Event Cycle:</label>
      </div> 
      <div class="">
          <select name="cycle" class="form-control">
          <?php
          $date = date('Y');
          $d = $date+1;
            for ($i=1; $i <3; $i++) 
            {
              ?>
                <option><?php echo $date."-Cycle-".$i; ?></option>
              <?php
              }
               for ($j=1; $j <3; $j++) { 
            ?>
                <option><?php echo $d."-Cycle-".$j; ?></option>
              <?php
              
              }
            ?>
        </select>
      </div> 
    </div><!--end row-->
    <div class="row">
      <div class="">
        <label for="lname">Branch Code:</label>
      </div> 
      <div class="">
        <input type="text" name="branchcode" class="form-control" list="branch" required>
          <datalist id="branch">
          <option value="">select branch code</option>
          <?php 
           foreach($data as $row)
           {
             $brcode =$row->branch_id;
             $t = strlen($brcode);
             if($t=='1')
             {
               $brcode = '000'.$brcode;
             }
             else if($t=='2')
             {
              $brcode = '00'.$brcode; 
             }
             else if($t=='3')
             {
               $brcode = '0'.$brcode; 
             }
             else
             {
               $brcode = $brcode; 
             }
             ?>
              <option value="<?php echo $brcode; ?>"><?php echo $brcode; ?></option>
              <?php
           }
          ?>
          
          </datalist>
      </div> 
    </div><!--end row-->
    <div class="row">
      <div class="">
        <label for="uname">Date Start:</label>
      </div> 
      <div class="">
       <input type="text" class="form-control uname" id="uname" name="datestart" placeholder="Enter Your Date" required data-parsley-error-message="Please Enter Date">
      </div> 
    </div><!--end row-->
    <div class="row">
      <div class="">
        <label for="date">Date End</label>
      </div> 
      <div class="">
       <input type="text" class="form-control email" id="date" name="dateend" placeholder="Enter Your Date" data-parsley-type="email" required data-parsley-error-message="Please Enter Date">
      </div> 
    </div><!--end row-->
    <div class="row">
      <div class="">
        <label for="pword">Monitor 1:</label>
      </div> 
      <div class="">
        <input type="text" name="monitor1" class="form-control" list="monitor1" required>
          <datalist id="monitor1">
          <option value="">Select M1 Code</option>
             @foreach($datas as $rows)
                      <option value="{{$rows->user_pin}}">{{$rows->user_pin}}</option>
             @endforeach
          
          </datalist>
      </div> 
    </div><!--end row-->
    <div class="row">
      <div class="">
        <label for="cpword">Monitor 2:</label>
      </div> 
      <div class="">
        <input type="text" name="monitor2" class="form-control" list="monitor2" required>
          <datalist id="monitor2">
          <option value="">Select M2 Code</option>
         @foreach($datas as $rows)
                    <option value="{{$rows->user_pin}}">{{$rows->user_pin}}</option>
           @endforeach
          
          </datalist>
      </div> 
    </div><!--end row-->
    <div class="row">
      
       <input type="submit" class="submit" name="submit" value="submit">
      
    </div><!--end row-->
    </form>
    <form action="Excel" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="">
         <label for="cpword">Upload Excel File</label>
        </div> 
        <div class="">
         <input type="file" class="file" id="file" name="excel_file" required="">
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


