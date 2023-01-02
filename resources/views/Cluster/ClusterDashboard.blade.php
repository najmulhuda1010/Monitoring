<?php 
$username = Session::get('username');
//$userpin = Session::get('user_pin');
if($username=='')
{
  
  ?>
  <script>
    window.location.href = 'logout';
  </script>
  
  <?php 
  
}
?>
@extends('backend.layouts.master')

@section('title','Claster Dashboard')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
      <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Cluster Dashboard</h5>
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
            <?php
      $month ='';
      $cyear = date('Y');
      $cmnth = date('m');
      $i=0;
      $ct =0;
      $truncate = DB::select(DB::raw("truncate mnwv2.cluster_temp RESTART IDENTITY"));
      $Cluster = DB::select(DB::raw("select year,month from mnwv2.monitorevents where year <= '$cyear' group by year,month order by year DESC, month DESC  limit 6"));
      //dd($Cluster);
      foreach ($Cluster as $row) 
      {
        $ct =0;
        $mon = $row->month;
        $year = $row->year;
        //echo $mon;
         $i++;
        if($mon == $cmnth && $year==$cyear)
        {
           continue;
        }
        $getdata = DB::select(DB::raw("select * from mnwv2.monitorevents where year ='$year' and month='$mon'"));
        if(!empty($getdata))
        {
          $sp =0;
          $qsp =0;
          foreach ($getdata as $row) 
          {
            $sp =0;
            $qsp =0;
           // $cluster = 1;
            $eventid= $row->id;
            $brcode = $row->branchcode;
            $tcnt = strlen($brcode);
            if($tcnt=='03')
            {
              $brcode = '0'.$brcode;
            }
			$sql = DB::select(DB::raw("select * from mnwv2.cluster"));
			if(!empty($sql))
			{
				foreach($sql as $r)
				{
					$brcode1 = $r->branch_code;
					$id =$r->id;
					$tcnt = strlen($brcode1);
					if($tcnt=='03')
					{
					  $brcode2 = '0'.$brcode1;
					  $clusterupdate = DB::select(DB::raw("update mnwv2.cluster set branch_code='$brcode2' where id='$id'"));
            //dd($clusterupdate);
					}
				}
				
				 
			}
            $clustersearch = DB::select(DB::raw("select * from mnwv2.cluster where c_associate_id='$userpin' and branch_code='$brcode'"));
            if(!empty($clustersearch))
            {
                $cluster = $clustersearch[0]->cluster_id;
                $getpointcluster = DB::select(DB::raw("select sum(point) p, sum(question_point) q from mnwv2.cal_section_point where event_id='$eventid' and (section='4' and (sub_id=5 or sub_id=6 or sub_id=8 or sub_id=9 or sub_id=10 or sub_id=11)) or event_id='$eventid' and (section='5' and (sub_id=3 or sub_id=4 or sub_id=5 or sub_id=16)) or event_id='$eventid' and (section='2' and sub_id=3 )"));
                if(!empty($getpointcluster))
                {
                    $sp = $getpointcluster[0]->p;
                    $qsp = $getpointcluster[0]->q;
                }
                $totalscore =0;
                if($sp !=0)
                {
                  $totalscore = round($sp/$qsp*100,2);
                }
                $datainsert = DB::select(DB::raw("insert into mnwv2.cluster_temp(cluster_id,branch_code,month,year,score,c_associate_id) VALUES('$cluster','$brcode','$mon','$year','$totalscore','$userpin')"));
                $ct++;
            }    
          }  
        }
      }
     $clustername = DB::select(DB::raw("select * from mnwv2.cluster where c_associate_id='$userpin'"));
     if(!empty($clustername))
     {
       $clustername=  $clustername[0]->cluster_name;
     }
     else
     {
        $clustername= 'No Cluster Name Found';
     }
      ?>
            <div class="card-body table-responsive">
              <p class="card-title">Monthwise lowest scoring branch list (10%)</p>
              <p class="card-title">Cluster Name : <?php echo $clustername; ?></p>
              <table style="text-align: center;font-size:13" class="table table-bordered">
                <tr class="brac-color-pink">
                  <th>Month</th>
                  <th>Branch Code</th>
                </tr>
                <tbody>
                    <?php
                    $totallimit =0;
                    $getlimit = DB::select(DB::raw("select year,month from mnwv2.cluster_temp where c_associate_id='$userpin' group by year,month order by year,month ASC"));
                     if(!empty($getlimit))
                     {
                      foreach ($getlimit as $row) 
                      {
                        $cnt =0;
                        $flg =0;
                        $month = $row->month;
                        $year = $row->year;
                        $getcount = DB::select(DB::raw("select count(*) as cnt from mnwv2.cluster_temp  where c_associate_id='$userpin' and year='$year' and month='$month'"));
                         if(!empty($getcount))
                         {
                           $cnt = $getcount[0]->cnt;
                           $totallimit =0;
                           if($cnt !=0)
                           {
                            $totallimit =round($cnt/10);
                           }
                         }
                        //echo $totallimit."/";
                        $getdata = DB::select(DB::raw("select *  from mnwv2.cluster_temp where c_associate_id='$userpin' and year='$year' and month='$month' order by CAST(score as float) ASC limit '$totallimit'"));
        
                        if(!empty($getdata))
                        {
                          foreach ($getdata as $row) 
                          {
                            $brnc = $row->branch_code;
                            $brc = substr($brnc,0,1);
                            if($brc ==0)
                            {
                                $brcod = substr($brnc,1,3);
                                //echo $brcod;
                                $brname = DB::select(DB::raw("select * from branch where branch_id='$brcod'"));
                                if(!empty($brname))
                                {
                                    $branchname = $brname[0]->branch_name;
                                }
                                else
                                {
                                    $branchname ='';
                                }
                            }
                            else
                            {
                                $brname = DB::select(DB::raw("select * from branch where branch_id='$brnc'"));
                                if(!empty($brname))
                                {
                                    $branchname = $brname[0]->branch_name;
                                }
                                else
                                {
                                    $branchname ='';
                                }
                            }
                            $mn = $row->month;
                            $yr = $row->year;
                             ?>
                             <tr>
                              <?php
                               if($flg=='0')
                               {
                                ?>
                                 <td rowspan="<?php echo $totallimit; ?>"><?php echo $yr."-".$mn; ?></td>
                                <?php
                                $flg =1;
                               }
                              ?>
                              <td><?php echo $branchname."(".$row->branch_code.")"; ?></td>
                             </tr>
                             <?php
                          }
                        }
                      }
                     }
                    ?>
                   </tbody>
                </tr>
              </table>
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