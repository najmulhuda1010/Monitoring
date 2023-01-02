@extends('mainpage')

@section('title','Table')


@section('content')
  <?php session_start(); ?>
  <div class="row">
    <div class="panel panel-default">
       <div class="header">
        <h3><i>Export Excel</i></h3>
        <br />
       </div>
       @if(Session::has('message'))
          <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <?php 
          if (isset($_SESSION['alert'])) {
          ?>
            <p class="alert alert-warning"><b>{{ $_SESSION['alert'] }}</b></p>
          <?php  
              // print $_SESSION['alert'];
              unset($_SESSION['alert']);
          }
        ?>
       <div id="rcorners">
        <form method="get">
			<div class="row">
			<div class="column">
			<div class="division">Division Name</div>
			  <div class="brone">
				<select name="division" id="divs">
				  <?php
				   $div ='';
				   $reg ='';
				   $area='';
				   $quarter1 ='';
				   if(isset($_GET['division']))
				   {
					   $div = $_GET['division'];
					   $division1 = DB::select(DB::raw("select division_id,division_name from branch where program_id=1 group by division_id,division_name order by division_id ASC"));
				   }
				   if(isset($_GET['region']))
				   {
					   $reg = $_GET['region'];
					   $resionall = DB::select(DB::raw("select region_id,region_name from branch where division_id='$div' and program_id=1 group by region_id,region_name order by region_id ASC"));
				   }
				   if(isset($_GET['area']))
				   {
					   $area = $_GET['area'];
					   $areaall = DB::select(DB::raw("select area_id,area_name from branch where region_id='$reg' and program_id=1 group by area_id,area_name order by area_id ASC"));
					   $Quarter = DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('area_id',$area)->GROUPBY('year','quarterly')->get();
					   var_dump($Quarter);
					 
				   }
				   if(isset($_GET['quarter']))
				   {
					   $quarter1 = $_GET['quarter'];
				   }
				  if($div !='')
				  {
					  $division = DB::select(DB::raw("select * from branch where division_id='$div'"));
					  if(!empty($division))
					  {
						  $division_name =  $division[0]->division_name;
					  }
					?>
						<option value="<?php echo $div; ?>"><?php echo $div."-".$division_name; ?></option>
					<?php
					foreach($division1 as $row)
					{
						$division_name =  $row->division_name;
						$division_id = $row->division_id;
						?>
						   <option value="<?php echo $division_id; ?>"><?php echo $division_id."-".$division_name; ?></option>
						<?php
					}
				  }
				  else
				  {
					?>
					 <option>select</option>
					  <?php
					  foreach ($db as $row) 
					  {
						$division_name =  $row->division_name;
						$division_id = $row->division_id;
						?>
						
							<option value="<?php echo $division_id; ?>"><?php echo $division_id."-".$division_name; ?></option>
						
						<?php
					  }
					
				  }
				  ?>
				 </select>
			  </div>
			</div>
			<div class="column">
			<div class="region">Region Name</div>
			  <div class="brone">
				<select name="region" id="region_id">
				 <?php 
				  if($reg !='')
				  {
					  $region = DB::select(DB::raw("select * from branch where region_id='$reg' and program_id=1"));
					  if(!empty($region))
					  {
						  $region_name =  $region[0]->region_name;
					  }
					?>
						<option value="<?php echo $reg; ?>"><?php echo $reg."-".$region_name; ?></option>
					<?php
					foreach($resionall as $row)
					{
						$region_id = $row->region_id;
						$region_name = $row->region_name;
						?>
						<option value="<?php echo $region_id; ?>"><?php echo $region_id."-".$region_name; ?></option>
						<?php
					}
				  }
				 ?>
				</select>
			  </div>
			</div>
			<div class="column">
			<div class="area">Area Name</div>
			  <div class="brone">
				<select name="area" id="area_id">
				<?php 
				  if($area !='')
				  {
					  $area1 = DB::select(DB::raw("select * from branch where area_id='$area' and program_id=1"));
					  if(!empty($area1))
					  {
						  $area_name =  $area1[0]->area_name;
					  }
					?>
						<option value="<?php echo $area; ?>"><?php echo $area."-".$area_name; ?></option>
					<?php
					foreach($areaall as $row)
					{
						$area_id = $row->area_id;
						$area_name = $row->area_name;
						?>
						<option value="<?php echo $area_id; ?>"><?php echo $area_id."-".$area_name; ?></option>
						<?php
					}
				  }
				 ?>
				</select>
			  </div>
			</div>
			<div class="column">
			<div class="area">Quarter</div>
			  <div class="brone">
				<select name="quarter" id="quarter" onchange="this.form.submit()">
				<?php
				  if($quarter1 !='')
				  {
					  ?>
					     <option value="<?php echo $quarter1; ?>"><?php echo $quarter1; ?></option>
					  <?php
					  foreach($Quarter as $row)
					  {
						  ?>
						   <option value="<?php echo $row->year."-".$row->quarterly; ?>"><?php echo $row->year."-".$row->quarterly; ?></option>
						  <?php
					  }
				  }
				 ?>
				</select>
			  </div>
			</div>
		  </div>
        </form>
         <button id="btn">Excel Export</button>
		   <br/>
          <?php
          $year ='';
          $quarterly ='';
          $results= [];
          $data = [];
          $branchs = [];
		      $results= [];
          $data = [];
          $sum = [];
          $sum_question = [];
          $total_sum = [];
          $branchs = [];
          $branchs_total = [];
          $total_percent=[];
          $weightage=[];
          $final_weightage=[];
          $total_sum_question=0;
          $araa =$a_id;
          $tqpoint =0;
          $tqpoint1 =0;
          $tqpoint2 =0;
          $tqpoint3 =0;
          $tqpoint4 =0;
          $qpoint =0;
          $qpoint1 =0;
          $qpoint2 =0;
          $qpoint3 =0;
          $qpoint4 =0;
          if(isset($_GET['quarter']))
          {
            $quarter = $_GET['quarter'];
            $exp = explode("-",$quarter);
            $year = $exp[0];
            $quarterly = $exp[1];
			      $query=DB::select(DB::raw("SELECT * FROM mnwv2.monitorevents WHERE area_id='$area' and  year='$year' and quarterly='$quarterly'"));
            foreach ($query as $row) 
            {
             $results[] = $row->id;
            }
            $brnch = DB::select(DB::raw("SELECT DISTINCT branchcode FROM mnwv2.cal_section_point WHERE event_id IN(SELECT id FROM mnwv2.monitorevents WHERE area_id='$area' and  year='$year' and quarterly='$quarterly') order by branchcode asc"));
            foreach ($brnch as $r) 
            {
              $branchs[] = $r->branchcode;
            } 
            if(empty($branchs)){
              $_SESSION['alert'] = "No branch Found!";
              header( "Location: http://scm.brac.net/mnwv2/Export" );
              exit ;
            }
            $sectionsdata = DB::select(DB::raw("SELECT CONCAT(section,'.', sub_id) AS si,string_agg
                    (DISTINCT CONCAT( branchcode, ':', point), ',')  as  brands, section, sub_id, question_point as fullmark,event_id FROM mnwv2.cal_section_point WHERE event_id IN(SELECT id FROM mnwv2.monitorevents WHERE area_id='$area' and  year='$year' and quarterly='$quarterly') GROUP BY section,sub_id,question_point,branchcode,si,event_id"));
                    // dd($sectionsdata);
            foreach ($sectionsdata as $rw) 
            {
				
              $sub_id=$rw->sub_id;
              $data[$rw->si]['fullmark'] = $rw->fullmark;
              $data[$rw->si]['section'] = $rw->section;
              $tmp = explode(",", $rw->brands);
              //var_dump($tmp);

              foreach ($tmp as $key => $value) 
              {
                $tmp2 = explode(":", $value);
                $tmp0 = $tmp2[0];
                $tmp1 = $tmp2[1];
                $data[$rw->si]['branchs'][$tmp0] = $tmp1;
              }


                $tmp1 = explode(".", $rw->si);
                $section = $tmp1[0];
                $qestion = $tmp1[1];
                $tmp2 = explode(":", $rw->brands);
                $branch = $tmp2[0];
                $point = $tmp2[1];
                $event_id=$rw->event_id;
				if($section =='1')
				{
					$qname = DB::table('mnwv2.def_questions')->where('sec_no',$section)->where('qno',$qestion)->get();
				}
				else
				{
					$qname = DB::table('mnwv2.def_questions')->where('sec_no',$section)->where('sub_sec_no',$qestion)->where('qno',0)->get();
				}
                 
		         if($qname->isEmpty())
				 {
					 //echo "Huda";
					  $data[$rw->si]['questions']='';
				 }
				 else
				 {
					 $data[$rw->si]['questions']=$qname[0]->qdesc;
				 }
				//dd($qname->qdesc);
               // $data[$rw->si]['questions']=$qname->qdesc;
               // dd($data);
				//var_dump($data);
                if($section==1){
                    $sum_data=DB::select(DB::raw("SELECT sum(point) FROM mnwv2.cal_section_point where event_id='$event_id' and section='1'"));
                    $sum_question_data=DB::select(DB::raw("SELECT sum(question_point) as qponit FROM mnwv2.cal_section_point where event_id='$event_id' and section='1'"));
                    $qpoint = $sum_question_data[0]->qponit;
                    if($tqpoint < $qpoint)
                    {
                      $tqpoint = $qpoint;
                    }
                    $sum[$section][$branch]=$sum_data[0]->sum;
                    //$sum_question[$section]=$sum_question_data[0]->sum;
                    $sum_question[$section]=$tqpoint;
                    $percent[$section][$branch]=Round(($sum_data[0]->sum*100)/$qpoint,2);
                    $weightage[$branch][$section]=ROUND(5*($sum_data[0]->sum/$qpoint));
					
                    /* $sum_question_data=DB::select(DB::raw("SELECT sum(question_point) FROM mnwv2.cal_section_point where event_id='$event_id' and section='1'"));

                    $sum[$section][$branch]=$sum_data[0]->sum;
                    $sum_question[$section]=$sum_question_data[0]->sum;
                    $percent[$section][$branch]=Round($sum_data[0]->sum/$sum_question_data[0]->sum*100,2);
                    $total_sum_question+=$sum_question_data[0]->sum;
                    $weightage[$branch][$section]=ROUND(5*($sum_data[0]->sum/$sum_question_data[0]->sum)); */
                  // dd($sum_question);
                    }elseif($section==2){
                        $sum_data=DB::select(DB::raw("SELECT sum(point) FROM mnwv2.cal_section_point where event_id='$event_id' and section='2'"));
                        $sum_question_data=DB::select(DB::raw("SELECT sum(question_point) as qponit FROM mnwv2.cal_section_point where event_id='$event_id' and section='2'"));
                        $qpoint = $sum_question_data[0]->qponit;
                        if($tqpoint1 < $qpoint)
                        {
                          $tqpoint1 = $qpoint;
                        }
                        $sum[$section][$branch]=$sum_data[0]->sum;
                        //$sum_question[$section]=$sum_question_data[0]->sum;
                        $sum_question[$section]=$tqpoint1;
                        $percent[$section][$branch]=Round(($sum_data[0]->sum*100)/$qpoint,2);
                        $weightage[$branch][$section]=ROUND(10*($sum_data[0]->sum/$qpoint));
                        /* $sum_question_data=DB::select(DB::raw("SELECT sum(question_point) FROM mnwv2.cal_section_point where event_id='$event_id' and section='2'"));

                        $sum[$section][$branch]=$sum_data[0]->sum;
                        $sum_question[$section]=$sum_question_data[0]->sum;
                        $percent[$section][$branch]=Round($sum_data[0]->sum/$sum_question_data[0]->sum*100,2);
                        $weightage[$branch][$section]=ROUND(10*($sum_data[0]->sum/$sum_question_data[0]->sum)); */
                    }elseif($section==3){
                        $sum_data=DB::select(DB::raw("SELECT sum(point) FROM mnwv2.cal_section_point where event_id='$event_id' and section='3'"));
                        $sum_question_data=DB::select(DB::raw("SELECT sum(question_point) as qponit FROM mnwv2.cal_section_point where event_id='$event_id' and section='3'"));
                        $qpoint = $sum_question_data[0]->qponit;
                        if($tqpoint2 < $qpoint)
                        {
                          $tqpoint2 = $qpoint;
                        }
                        $sum[$section][$branch]=$sum_data[0]->sum;
                        //$sum_question[$section]=$sum_question_data[0]->sum;
                        $sum_question[$section]=$tqpoint2;
                        $percent[$section][$branch]=Round(($sum_data[0]->sum*100)/$qpoint,2);
                        $weightage[$branch][$section]=ROUND(30*($sum_data[0]->sum/$qpoint));
                        /* $sum_question_data=DB::select(DB::raw("SELECT sum(question_point) FROM mnwv2.cal_section_point where event_id='$event_id' and section='3'"));

                        $sum[$section][$branch]=$sum_data[0]->sum;
                        $sum_question[$section]=$sum_question_data[0]->sum;
                        $percent[$section][$branch]=Round($sum_data[0]->sum/$sum_question_data[0]->sum*100,2);
                        $weightage[$branch][$section]=ROUND(30*($sum_data[0]->sum/$sum_question_data[0]->sum)); */

                    }elseif($section==4){
                        $sum_data=DB::select(DB::raw("SELECT sum(point) FROM mnwv2.cal_section_point where event_id='$event_id' and section='4'"));
                        $sum_question_data=DB::select(DB::raw("SELECT sum(question_point) as qponit FROM mnwv2.cal_section_point where event_id='$event_id' and section='4'"));
                        $qpoint = $sum_question_data[0]->qponit;
                        if($tqpoint3 < $qpoint)
                        {
                          $tqpoint3 = $qpoint;
                        }
                        $sum[$section][$branch]=$sum_data[0]->sum;
                        //$sum_question[$section]=$sum_question_data[0]->sum;
                        $sum_question[$section]=$tqpoint3;
                        $percent[$section][$branch]=Round(($sum_data[0]->sum*100)/$qpoint,2);
                        $weightage[$branch][$section]=ROUND(35*($sum_data[0]->sum/$qpoint));
                        /* $sum_question_data=DB::select(DB::raw("SELECT sum(question_point) FROM mnwv2.cal_section_point where event_id='$event_id' and section='4'"));

                        $sum[$section][$branch]=$sum_data[0]->sum;
                        $sum_question[$section]=$sum_question_data[0]->sum;
                        $percent[$section][$branch]=Round($sum_data[0]->sum/$sum_question_data[0]->sum*100,2);
                        $weightage[$branch][$section]=ROUND(35*($sum_data[0]->sum/$sum_question_data[0]->sum)); */

                    }elseif($section==5){
                        $sum_data=DB::select(DB::raw("SELECT sum(point) FROM mnwv2.cal_section_point where event_id='$event_id' and section='5'"));
                        $sum_question_data=DB::select(DB::raw("SELECT sum(question_point) as qponit FROM mnwv2.cal_section_point where event_id='$event_id' and section='5'"));
                        $qpoint = $sum_question_data[0]->qponit;
                        if($tqpoint4 < $qpoint)
                        {
                          $tqpoint4 = $qpoint;
                        }
                        $sum[$section][$branch]=$sum_data[0]->sum;
                        //$sum_question[$section]=$sum_question_data[0]->sum;
                        $sum_question[$section]=$tqpoint4;
                        // $percent[$section][$branch]=Round($sum_data[0]->sum/$qpoint*100,2);
                        $percent[$section][$branch]=Round(($sum_data[0]->sum*100)/$qpoint,2);
                        $weightage[$branch][$section]=ROUND(20*($sum_data[0]->sum/$qpoint));

                        // dd($percent);
                        
                    }


                    $total=DB::select(DB::raw("SELECT sum(question_point) as question_point,sum(point) as point FROM mnwv2.cal_section_point where event_id='$event_id'"));
                    $total_percent[$branch]=Round(($total[0]->point*100)/$total[0]->question_point,2);
              /*$data[$values['si']]['fullmark'] = $values['fullmark'];
              $data[$values['si']]['section'] = $values['section'];     
              $tmp = explode(",", $values['brands']);
              foreach ($tmp as $key => $value) {
                  $tmp2 = explode(":", $value);
                  $data[$values['si']]['branchs'][$tmp2[0]] = $tmp2[1];
              }*/
			  //echo $sub_id."/".$section."-";
            }
			//dd($data);
			//die;
            $total_sum_question=array_sum($sum_question);
            foreach ($branchs as $brn) 
            {
              $total=DB::select(DB::raw("SELECT sum(point) FROM mnwv2.cal_section_point where branchcode='$brn'"));
              $branchs_total[$brn]=$total[0]->sum;
              // $total_percent[$brn]=Round($total[0]->sum/$total_sum_question*100,2);
            }
            $total_wieght=0;
            foreach ($weightage as $key=>$branch) 
            {
              // dd($key);
              foreach ($branch as $weight) {
                $total_wieght+=$weight;
              }
              $final_weightage[$key]=$total_wieght;
              $total_wieght=0;
            }
            if(!empty($sum)){
              ksort($sum[1]);
              ksort($sum[2]);
              ksort($sum[3]);
              ksort($sum[4]);
              ksort($sum[5]);
            }
            if(!empty($percent)){
              ksort($percent[1]);
              ksort($percent[2]);
              ksort($percent[3]);
              ksort($percent[4]);
              ksort($percent[5]);
            }
            // dd($branchs_total);
                    // dd($final_weightage);
            // echo "<pre>";  
            // var_dump($section);
          //   var_dump($sum);
            // die();
          ?>
          <table style="text-align: center;font-size:13" id="tblReport" style="width: 100%; display:none;">
               <thead class="noExl">
                <tr align="center">
                    <td></td>
                    <td></td>
                    <td>BRAC Microfinance</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr align="center">
                  <td></td>
                  <td></td>
                  <td>Dabi Monitoring Unit</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                   <td></td>
                   <td></td>
                   <td>Branch Wise Monitoring New Way Score</td>
                   <td></td>
                   <td></td>
                   <td></td>
                </tr>
				<?php
                  $aname ='';
                  $rname='';
                 $dname='';
                 $area = DB::table('branch')->where('area_id',$area)->get();
                 if(!$area->isEmpty())
                 {
                  $aname = $area[0]->area_name;
                  $rname = $area[0]->region_name;
                  $dname = $area[0]->division_name;
                 } 
                ?>
                <tr>
                    <td>Area: <?php echo $aname; ?></td>
                    <td>Region: <?php echo $rname; ?></td>
                    <td>Division: <?php echo $dname; ?></td>
                </tr>
                <tr>
                    <td>Quarter: <?php echo $quarter; ?> </td>
                </tr>
                
                <tr>
                    <th>SI</th>
                    <th>Full Marks</th>
                    <th>Section & Indicator Name</th>
                    <?php 
                    foreach ($branchs as $branch) {
                      $brcode =$branch[0];
                      if($brcode=='0')
                      {
                        $br = substr($branch,1,3);
                      }
                      else
                      {
                        $br = $branch;
                      }
                      $brname = DB::table('branch')->where('branch_id',$br)->get();
                       if($brname->isEmpty($brname))
                       {
                         $name = '';
                       }
                       else
                       {
                         $name = $brname[0]->branch_name;
                       }
                        echo "<th>$name<br>$branch</th>";
                    }?>
                </tr>
                </thead>
                <tbody>
                  {{-- Section 1 --}}
                    <?php 
                    $flg =0;
                    //var_dump($data);
					          $check =0;
                    foreach ($data as $si  => $info)
                    {
                       $explode = explode(".", $si);
                       $section = $explode[0];
                       $sub_id = $explode[1];
          					   if($section =='1')
          					   {
                          $qname = DB::table('mnwv2.def_questions')->where('sec_no',$section)->where('qno',$sub_id)->get();
                          
                          ?>
                          <tr>
                            <td><?php echo $si; ?></td>
                            <td><?php echo $info['fullmark']; ?></td>
                            <td><?php echo $info['questions']; ?></td>
                             <?php
                             foreach ($branchs as $brn) 
                             {
                              if(isset($info['branchs'][$brn]))
                              {
                                ?>
                                <td><?php echo $info['branchs'][$brn]; ?></td>
                                <?php
                              }
                              else
                              {
                                ?>
                                <td></td>
                                <?php
                              }
                             }
                             ?>
                          </tr>

                          <?php
          					   }
          					  //  else
          					  //  {
          						//     $qname = DB::table('mnwv2.def_questions')->where('sec_no',$section)->where('sub_sec_no',$sub_id)->where('qno',0)->get();
          					  //  }
                        
                         ?>
                      <?php
                       }

                       if($qname->isEmpty())
                       {
                        $qnme = '';
                       }
                       else
                       {
                        $qnme = $qname[0]->qdesc;
                       }
                      ?>
                      <?php
                    
                    ?>
                    <tr style="color: red;">
                      <td>Section Total</td>
                      <td><?php //echo $sum_question[1]; ?></td>
                      <td></td>
                       <?php
                        foreach ($sum[1] as $total) 
                        {
                          
                          ?>
                          <td><?php echo $total; ?></td>
                          <?php
                       }
                       ?>
                    </tr>
                    <tr style="color: blue">
                      <td>Section Percentage</td>
                      <td></td>
                      <td></td>
                       <?php
                        foreach ($percent[1] as $total) 
                        {
                          
                          ?>
                          <td><?php echo $total; ?></td>
                          <?php
                       }
                       ?>
                    </tr>
                    {{-- send of section 1 --}}
                    {{-- section 2 --}}
                    <?php 
                    $flg =0;
                    //var_dump($data);
					          $check =0;
                    foreach ($data as $si  => $info)
                    {
                       $explode = explode(".", $si);
                       $section = $explode[0];
                       $sub_id = $explode[1];
          					   if($section =='2')
          					   {
                          $qname = DB::table('mnwv2.def_questions')->where('sec_no',$section)->where('qno',$sub_id)->get();
                          ?>
                          <tr>
                            <td><?php echo $si; ?></td>
                            <td><?php echo $info['fullmark']; ?></td>
                            <td><?php echo $info['questions']; ?></td>
                             <?php
                             foreach ($branchs as $brn) 
                             {
                              if(isset($info['branchs'][$brn]))
                              {
                                ?>
                                <td><?php echo $info['branchs'][$brn]; ?></td>
                                <?php
                              }
                              else
                              {
                                ?>
                                <td></td>
                                <?php
                              }
                             }
                             ?>
                          </tr>

                          <?php
          					   }
          					  //  else
          					  //  {
          						//     $qname = DB::table('mnwv2.def_questions')->where('sec_no',$section)->where('sub_sec_no',$sub_id)->where('qno',0)->get();
          					  //  }
                        
                         ?>
                      <?php
                       }
                       ?>
                       <tr style="color: red">
                        <td>Section Total</td>
                        <td><?php //echo $sum_question[2]; ?></td>
                        <td></td>
                         <?php
                          foreach ($sum[2] as $total) 
                          {
                            
                            ?>
                            <td><?php echo $total; ?></td>
                            <?php
                         }
                         ?>
                      </tr>
                      <tr style="color: blue">
                          <td>Section Percentage</td>
                          <td></td>
                          <td></td>
                           <?php
                            foreach ($percent[2] as $total) 
                            {
                              
                              ?>
                              <td><?php echo $total; ?></td>
                              <?php
                           }
                           ?>
                        </tr>
                      {{-- end of section 2 --}}
                      {{-- section 3 --}}
                      <?php 
                    $flg =0;
                    //var_dump($data);
					          $check =0;
                    foreach ($data as $si  => $info)
                    {
                       $explode = explode(".", $si);
                       $section = $explode[0];
                       $sub_id = $explode[1];
          					   if($section =='3')
          					   {
                          $qname = DB::table('mnwv2.def_questions')->where('sec_no',$section)->where('qno',$sub_id)->get();
                          ?>
                          <tr>
                            <td><?php echo $si; ?></td>
                            <td><?php echo $info['fullmark']; ?></td>
                            <td><?php echo $info['questions']; ?></td>
                             <?php
                             foreach ($branchs as $brn) 
                             {
                              if(isset($info['branchs'][$brn]))
                              {
                                ?>
                                <td><?php echo $info['branchs'][$brn]; ?></td>
                                <?php
                              }
                              else
                              {
                                ?>
                                <td></td>
                                <?php
                              }
                             }
                             ?>
                          </tr>

                          <?php
          					   }
          					  //  else
          					  //  {
          						//     $qname = DB::table('mnwv2.def_questions')->where('sec_no',$section)->where('sub_sec_no',$sub_id)->where('qno',0)->get();
          					  //  }
                        
                         ?>
                      <?php
                       }
                       ?>
                       <tr style="color: red">
                          <td>Section Total</td>
                          <td><?php //echo $sum_question[3]; ?></td>
                          <td></td>
                           <?php
                            foreach ($sum[3] as $total) 
                            {
                              
                              ?>
                              <td><?php echo $total; ?></td>
                              <?php
                           }
                           ?>
                        </tr>
                        <tr style="color: blue">
                            <td>Section Percentage</td>
                            <td></td>
                            <td></td>
                             <?php
                              foreach ($percent[3] as $total) 
                              {
                                
                                ?>
                                <td><?php echo $total; ?></td>
                                <?php
                             }
                             ?>
                          </tr>
                        {{-- end of section 3 --}}
                        {{-- section 4 --}}
                        <?php 
                    $flg =0;
                    //var_dump($data);
					          $check =0;
                    foreach ($data as $si  => $info)
                    {
                       $explode = explode(".", $si);
                       $section = $explode[0];
                       $sub_id = $explode[1];
          					   if($section =='4')
          					   {
                          $qname = DB::table('mnwv2.def_questions')->where('sec_no',$section)->where('qno',$sub_id)->get();
                          ?>
                          <tr>
                            <td><?php echo $si; ?></td>
                            <td><?php echo $info['fullmark']; ?></td>
                            <td><?php echo $info['questions']; ?></td>
                             <?php
                             foreach ($branchs as $brn) 
                             {
                              if(isset($info['branchs'][$brn]))
                              {
                                ?>
                                <td><?php echo $info['branchs'][$brn]; ?></td>
                                <?php
                              }
                              else
                              {
                                ?>
                                <td></td>
                                <?php
                              }
                             }
                             ?>
                          </tr>

                          <?php
          					   }
          					  //  else
          					  //  {
          						//     $qname = DB::table('mnwv2.def_questions')->where('sec_no',$section)->where('sub_sec_no',$sub_id)->where('qno',0)->get();
          					  //  }
                        
                         ?>
                      <?php
                       }
                       ?>
                       <tr style="color: red">
                          <td>Section Total</td>
                          <td>
                            <?php //echo $sum_question[4]; ?>
                          </td>
                          <td></td>
                           <?php
                            foreach ($sum[4] as $total) 
                            {
                              
                              ?>
                              <td><?php echo $total; ?></td>
                              <?php
                           }
                           ?>
                        </tr>
                        <tr style="color: blue">
                            <td>Section Percentage</td>
                            <td></td>
                            <td></td>
                             <?php
                              foreach ($percent[4] as $total) 
                              {
                                
                                ?>
                                <td><?php echo $total; ?></td>
                                <?php
                             }
                             ?>
                          </tr>
                        {{-- end of section 4 --}}
                        {{-- section 5 --}}
                        <?php 
                        $flg =0;
                        //var_dump($data);
                        $check =0;
                        foreach ($data as $si  => $info)
                        {
                           $explode = explode(".", $si);
                           $section = $explode[0];
                           $sub_id = $explode[1];
                           if($section =='5')
                           {
                              $qname = DB::table('mnwv2.def_questions')->where('sec_no',$section)->where('qno',$sub_id)->get();
                              ?>
                              <tr>
                                <td><?php echo $si; ?></td>
                                <td><?php echo $info['fullmark']; ?></td>
                                <td><?php echo $info['questions']; ?></td>
                                 <?php
                                 foreach ($branchs as $brn) 
                                 {
                                  if(isset($info['branchs'][$brn]))
                                  {
                                    ?>
                                    <td><?php echo $info['branchs'][$brn]; ?></td>
                                    <?php
                                  }
                                  else
                                  {
                                    ?>
                                    <td></td>
                                    <?php
                                  }
                                 }
                                 ?>
                              </tr>
    
                              <?php
                           }
                          //  else
                          //  {
                          //     $qname = DB::table('mnwv2.def_questions')->where('sec_no',$section)->where('sub_sec_no',$sub_id)->where('qno',0)->get();
                          //  }
                            
                             ?>
                          <?php
                           }
                           ?>
                           <tr style="color: red">
                              <td>Section Total</td>
                              <td><?php //echo $sum_question[5]; ?></td>
                              <td></td>
                               <?php
                                foreach ($sum[5] as $total) 
                                {
                                  
                                  ?>
                                  <td><?php echo $total; ?></td>
                                  <?php
                               }
                               ?>
                            </tr>
                            <tr style="color: blue">
                                <td>Section Percentage</td>
                                <td></td>
                                <td></td>
                                 <?php
                                  foreach ($percent[5] as $total) 
                                  {
                                    
                                    ?>
                                    <td><?php echo $total; ?></td>
                                    <?php
                                 }
                                 ?>
                            </tr>
                            {{-- send of section 5 --}}
                            {{-- Tatal section --}}
                            <tr style="color: green">
                              <td></td>
                              <td>
                                {{-- {{ $total_sum_question }} --}}
                              </td>
                              <td align="center">Total</td>
                              <?php
                                foreach ($branchs_total as $total) 
                                {
                                  
                                  ?>
                                  <td><?php echo $total; ?></td>
                                  <?php } ?>
                            </tr>
                            <tr style="color: green">
                              <td></td>
                              <th align="center" scope="row">Total Percentage</th>
                              <td></td>
                              <?php
                                foreach ($total_percent as $total) 
                                {
                                  
                                  ?>
                                  <td><?php echo $total; ?></td>
                                  <?php
                              }
                              ?>
                            </tr>
                            <tr style="color: green">
                              <td></td>
                              <th align="center" scope="row">Final weightage score</th>
                              <td></td>
                              <?php
                                foreach ($final_weightage as $total) 
                                {
                                  
                                  ?>
                                  <td><?php echo $total; ?></td>
                                  <?php
                              }
                              ?>
                            </tr>
                            <tr style="color: green">
                              <td></td>
                              <th align="center" scope="row">Branch Rating</th>
                              <td></td>
                              <?php
                              foreach ($final_weightage as $total) 
                              {
                                if($total>='85'){
                                  $g='G';
                                }elseif($total>='70' && $total<'85'){
                                  $g='M';
                                }elseif($total<'70'){
                                  $g='P';
                                }else{
                                  $g='';
                                }
                                ?>

                                <td><?php echo $g; ?></td>
                                <?php
                            }
                            ?>
                            </tr>
                 </tbody>
            </table>
			
			<?php 
		  }
		  ?>
       </div>
    </div>
 </div>
 <script>       
   $('#divs').on('change', function() {
    var division_id= this.value;
    //alert(division_id);
    if(division_id !='')
    {  
      $.ajax({
      type: 'POST',
      url: '/mnwv2/mnwv2/RegionData',cache: false,
      dataType: 'json',
      data: { id: division_id },
      success: function (data) {
        
        //var d = data[0].region_id;
        //console.log(d);
        var len = data.length;
        $("#region_id").empty();
        $("#area_id").empty();
        $("#branch_id").empty();
        
        var option2 = "<option value=''>select</option>";
        $("#region_id").append(option2);
        for(var i = 0; i < len; i++)
        {
          var option = "<option value='"+data[i].region_id+"'>"+data[i].region_id+"-"+data[i].region_name+"</option>"; 

          $("#region_id").append(option); 
        }
        
      },
      error: function (ex) {
        alert('Failed to retrieve Area.');
      }
    });
      
      return;
    }
  });
  $('#region_id').on('change', function() {
    var region_id= this.value;
    //alert(region_id);
    if(region_id !='')
    {  
      $.ajax({
      type: 'POST',
      url: '/mnwv2/mnwv2/AreaData',cache: false,
      dataType: 'json',
      data: { id: region_id },
      success: function (data) {
        
        //var d = data[0].region_id;
        //console.log(d);
        var len = data.length;
        $("#area_id").empty();$("#branch_id").empty();
        
        var option2 = "<option value=''>select</option>";
        $("#area_id").append(option2);
        for(var i = 0; i < len; i++)
        {
          var option = "<option value='"+data[i].area_id+"'>"+data[i].area_id+"-"+data[i].area_name+"</option>"; 

          $("#area_id").append(option); 
        }
        
      },
      error: function (ex) {
        alert('Failed to retrieve Area.');
      }
    });
      
      return;
    }
  }); 
  $('#area_id').on('change', function() {
    var area_id= this.value;
    //alert(area_id);
    if(area_id !='')
    {  
      $.ajax({
      type: 'POST',
      url: '/mnwv2/mnwv2/quarter',cache: false,
      dataType: 'json',
      data: { id: area_id },
      success: function (data) {
        
        //var d = data[0].region_id;
        //console.log(d);
        var len = data.length;
        $("#quarter").empty();
        
        var option2 = "<option value=''>select</option>";
        $("#quarter").append(option2);
        for(var i = 0; i < len; i++)
        {
          var option = "<option value='"+data[i].year+"-"+data[i].quarterly+"'>"+data[i].year+"-"+data[i].quarterly+"</option>"; 

          $("#quarter").append(option); 
        }
        
      },
      error: function (ex) {
        alert('Failed to retrieve Area.');
      }
    });
      
      return;
    }
  });
  
</script>
@endsection
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
   
         $("#btn").click (function () {
          //alert("Click");
            $("#tblReport").table2excel({ 
                 exclude: ".noExl",
                name: "Results",
                filename: "<?php echo date('Y-m-d'); ?>_Export",
                fileext: ".xls",
                 });
        });
});
    /*$('#btn').click(function(){
      alert("Click");
       $('table').table2excel({
        exclude: ".noExl",
        name: "Export In Excel",
        filename: "myExcelFile.xls",
        fileext: ".xls",
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true

       });

    });*/
 </script>
<script>
  $(document).ready(function(){
     $("#dv1").hide();
     $("#dv2").hide();
     $("#dv3").hide();
     $("#dv4").hide();
     $("#dv5").hide();
  });
     function getDiv(judu){
     var button_text = $('#' + judu).text();
    if(button_text == '+')
    {
      for (var i = 1; i < 6; i++)
      {
        if(judu == i)
        {
          $("#dv" + judu).show();
          $('#' + judu).html('-');
 
        }
        else
        {
          $("#dv" + i).hide();       
          $('#' + i).html('+');
        }
      }
      
    }
    else
    {
      $('#dv' + judu).hide();
      $('#' + judu).html('+');
    }
   }

</script>
