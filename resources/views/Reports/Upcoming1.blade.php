@extends('mainpage')

@section('title','Table')


@section('content')

  <div class="row">
    <div class="panel panel-default">
      <div class="header">
        <h3><i>Ongoing Report:</i></h3>
        <br />
      </div>
     <table style="text-align: center;font-size:13" class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Branch Code</th>
            <th>Branch Name</th>
            <th>Event Id</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>M1 Code</th>
            <th>M1 Name</th>
            <th>M2 Code</th>
            <th>M2 Name</th>
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
            foreach($upcoming as $row)
            {
                 $br = $row->branchcode;
                 $stdate = $row->datestart;
                 $endate = $row->dateend;
                 $m1code = $row->monitor1_code;
                 $m2code = $row->monitor2_code;
                 $brname = DB::table('branch')->where('branch_id',$br)->get();
                 $br_name = $brname[0]->branch_name;
                 $m1 =$row->monitor1_code;
                 //echo $m1;
                 $name = DB::table('mnw.user')->where('user_pin',$m1)->get();
                 if($name->isEmpty())
                 {
                   
                 }
                 else
                 {
                    $mname = $name[0]->name;

                 }
                 $evid =DB::select( DB::raw("select  max(id) as id from mnw.monitorevents where monitor1_code='$m1'"));//DB::table('mnw.monitorevents')->where('monitor1_code',$m1)->get();
                 if(!empty($evid))
                 {
                    $eid = $evid[0]->id;
                 }
                
                 $m2 =$row->monitor2_code;
                // echo $m2;
                 $name2 = DB::table('mnw.user')->where('user_pin',$m2)->get();
                 if(!$name2->isEmpty())
                 {
                    $mname2 = $name2[0]->name;
                 }
                $evid =DB::select( DB::raw("select  max(id) as id from mnw.monitorevents where monitor2_code='$m2'"));
                 if(!empty($evid))
                 {
                    $eid = $evid[0]->id;
                 }
              ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $br; ?></td>
                    <td><?php echo $br_name; ?></td>
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $stdate; ?></td>
                    <td><?php echo $endate; ?></td>
                    <td><?php echo $m1; ?></td>
                    <td><?php echo $mname; ?></td>
                    <td><?php echo $m2; ?></td>
                    <td><?php echo $mname2; ?></td>
                    <td><a href="#">Edit</a>|<a href="">Delete</a></td>
                </tr>
              <?php
              $id++;
            }

           ?>
          
        </tbody>
      </table>
    </div>
 </div>
  <!--pagination-->

  <nav aria-label="Page navigation example" style="float: right" >
    <ul class="pagination ">
    <li class="page-item"> <a href="#" class="page-link">Previous</a> </li>
     <?php
      $limit = 2;
      $total =10;
      $ciling = ceil($total/$limit);
      for($i =1; $i <=$ciling; $i++)
      {
        ?>
        <li class="page-item"> <a href="" class="page-link"><?php echo $i; ?></a> </li>
        <?php
      }
     ?>
      <li class="page-item"> <a href="" class="page-link">Next</a> </li>
    </ul>
  
  </nav>
          
          <!--End pagination-->

@endsection

