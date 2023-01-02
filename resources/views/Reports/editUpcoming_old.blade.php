@extends('mainpage')

@section('title','Update Ongoing')


@section('content')
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"></div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <div class="row">
       
       <div class="">
            <div class="header">
                <h3><i>Update Upcoming Events Report:</i></h3>
                <br />
            </div>
              <?php
                $mname='';
                $mname2='';
                $m2 ='';
                $m1 ='';
				?>
                 
            <form id='form' action="StoreUpcoming" method="POST">
               
                <div class="row">
                  <div class="">
                    <label>Branch Code:</label>
                  </div> 
                  <div class="">
				   <input type="text" class="form-control" id="branch_code" name="branch_code" value="<?php echo $edit[0]->branchcode; ?>" disabled="">
                   <!--<select class="form-control" id="branchcode" name="branchcode"> 
					<option value="<?php echo $edit[0]->branchcode; ?>"><?php echo $edit[0]->branchcode; ?></option>
                  </select>-->
                  </div> 
                </div><!--end row-->

                <div class="row">
                  <div class="">
                    <label>Branch Name:</label>
                  </div>
				   <?php 
				     $brcode ='';
				     $brcode = $edit[0]->branchcode;
					 $brsubst = substr($brcode,0,1);
					 if($brsubst=='0')
					 {
						 $brcode = substr($brcode,1,3);
					 }
					
					 $brname = DB::table('branch')->where('branch_id',$brcode)->where('program_id',1)->get();
					 if(!$brname->isEmpty())
					 {
						 $branchname = $brname[0]->branch_name;
					 }
					 else
					 {
						 $branchname ='';
					 }
				   ?>
                  <div class="">
                   <input type="text" class="form-control" id="branch_name" name="branch_name" value="<?php echo $branchname; ?>" disabled="">
                  </div> 
                </div><!--end row-->
                
                <div class="row">
                  <div class="">
                    <label>Event ID:</label>
                  </div> 
                  <div class="">
                   <input type="" class="form-control" id="eventid" name="eventid" value="<?php echo $edit[0]->id; ?>" disabled="">
                  </div> 
                </div><!--end row-->

                <div class="row">
                  <div class="">
                    <label for="date">Date Start</label>
                  </div> 
                  <div class="">
                   <input type="date" class="form-control" id="sdate" name="datestart" value="<?php echo $edit[0]->datestart; ?>">
                  </div> 
                </div><!--end row-->


                <div class="row">
                  <div class="">
                    <label for="date">Date End</label>
                  </div> 
                  <div class="">
                   <input type="date" class="form-control" id="edate" name="dateend" value="<?php echo $edit[0]->dateend; ?>">
                  </div> 
                </div><!--end row-->

                <div class="row">
                  <div class="">
                    <label>M1 Code:</label>
                  </div> 
                  <div class="">

                    <select class="form-control" name="monitor1_code" id="monitor1_code" data-dependent="name">
					   <option value="<?php echo $edit[0]->monitor1_code; ?>"><?php echo $edit[0]->monitor1_code; ?></option>
					   <?php
						$m2all = DB::table('mnwv2.user')->get();
						if(!$m2all->isEmpty())
						{
							foreach($m2all as $row)
							{
								?>
								<option value="<?php echo $row->user_pin; ?>"><?php echo $row->user_pin; ?></option>
								<?php
							}
						}
						?>
                    </select>
                     
                    
                  </div> 
                </div><!--end row-->
                
                <div class="row">
                  <?php
					$m1code = $edit[0]->monitor1_code;
					$m1nm=DB::table('mnwv2.user')->where('user_pin',$m1code)->get();
					if($m1nm->isEmpty())
					{
						$m1name ='';
					}
					else
					{
						
						$m1name = $m1nm[0]->name;
					}
				  ?>
                  <label>M1 Name:</label>
                  <div class="" id="name">
                    <input type="" class="form-control" id="names" name="name1" value="<?php echo $m1name; ?>" disabled>
                  </div> 
                 
                </div><!--end row-->

               <!--  <div class="row">
                  <div class="">
                    <label>M1 Name:</label>
                    <input type="" class="form-control email" id="name" name="name" value="{{$mname}}">
                  </div> 
            
                   <div id="name">
                    
                  </div>
                </div> --><!--end row-->

               

                <div class="row">
                  <div class="">
                    <label>M2 Code:</label>
                  </div> 
                  <div class="">
                    <select class="form-control"name="monitor2_code" id="monitor2_code" data-dependent="name">
                        <option value="<?php echo $edit[0]->monitor2_code; ?>"><?php echo $edit[0]->monitor2_code; ?></option>
						<?php
						$m2all = DB::table('mnwv2.user')->get();
						if(!$m2all->isEmpty())
						{
							foreach($m2all as $row)
							{
								?>
								<option value="<?php echo $row->user_pin; ?>"><?php echo $row->user_pin; ?></option>
								<?php
							}
						}
						?>
                    </select> 
                   
                     
                  </div> 
                </div><!--end row-->

                <div class="row">
                   <?php
					$m2code = $edit[0]->monitor2_code;
					$m2nm=DB::table('mnwv2.user')->where('user_pin',$m2code)->get();
					if($m2nm->isEmpty())
					{
						$m2name ='';
					}
					else
					{
						
					   $m2name = $m2nm[0]->name;
					}
				  ?>
                  <label>M2 Name:</label>
                  <div class="" id="names">
                    <input type="" class="form-control" id="names" name="name2" value="<?php echo $m2name; ?>" disabled>
                  </div> 
                 
                </div>
				<input type="hidden" name="id" value="<?php echo $edit[0]->id; ?>">
				<!--end row-->
                <!-- <div class="row">
                  
                  <label>M2 Name:</label>
                  <div class="" id="names">
                    {{$mname2}}
                  </div> 
                 
                </div> --><!--end row-->
                <button type="submit" class="submit">Update</button> 
               
            </form>
        </div> 
    </div>
</div>
<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"></div>
  <!--pagination-->

  <nav aria-label="Page navigation example" style="float: right" >

  </nav>
          
          <!--End pagination-->

@endsection
