@extends('backend.layouts.master')

@section('title','Section Details')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
      <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Section Details</h5>
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
            $sectioname = DB::select(DB::raw("select * from mnwv2.def_sections where sec_no='$sec'"));
            if(!empty($sectioname))
            {
               $secname =  $sectioname[0]->sec_name;
            }
            else
            {
             $secname ='';
            }
            $subsectioname = DB::select(DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and sub_sec_no='$subsec'"));
            if(!empty($subsectioname))
            {
               $subsecname =  $subsectioname[0]->qdesc;
            }
            else
            {
             $subsecname ='';
            }
           ?>
            <!--begin::Form-->
            <div class="card-body">
              <p >Section <?php echo $sec." : ".$secname; ?>  </p>
              <p >Sub Section : <?php echo $subsecname;  ?> </p>
              <div class=" table-responsive">
              <?php
	   if(((($sec=='3' and $subsec=='1') or ($sec=='3' and $subsec=='2')) or (($sec=='3' and $subsec=='6') or ($sec=='3' and $subsec=='9'))) or ((($sec=='4' and $subsec=='1') or ($sec=='5' and $subsec=='1')) or ($sec=='5' and $subsec=='2') or ($sec=='5' and (($subsec=='11') or ($subsec=='12') or ($subsec=='13') or ($subsec=='14') or ($subsec=='15') or ($subsec=='16') or ($subsec=='17') or ($subsec=='18')))))
	   {
			   ?>
			   <table style="text-align: center;font-size:13" style="font-size: 13" class="table" cellspacing="0" width="100%">
					
						  <tr class="brac-color-pink">
							<th>SL</th>
							<th>Question</th>
							<th>Answer</th>
							<th>Percent</th>
						  </tr>
					
					<tbody>
					  <?php 
						$name ='';
						$p=0;
						$qp =0;
						$id = 1;
						$memname ='';
						$q1 =0;
						$q2 =0;
						$tscore =0;
						$survey_datas  = DB::select(DB::raw("select * from mnwv2.survey_data where event_id ='$event' and sec_no='$sec' and sub_id='$subsec' order by sub_id ASC"));
						foreach($survey_datas as $rw)
						{
							$question = $rw->question;
							//$score =$row->score;
							if($question =='1')
							{
								$q1  = $rw->score;
							}
							if($question =='2')
							{
								$q2 = $rw->score;
							}
							
						}
						if($q1 >0)
						{
							$tscore = round($q2*100/$q1,2);
						}
						if($sec=='5' and ($subsec=='1') or ($subsec=='11') or ($subsec=='12') or ($subsec=='13') or ($subsec=='14') or ($subsec=='15') or ($subsec=='16') or ($subsec=='17') or ($subsec=='18'))
						{
							if($q1 > 0)
							{
								$tscore = 100;
							}
							else
							{
								$tscore =0;
							}
						}
						$ac =0;
						foreach ($survey_datas as $row) 
						{
							//var_dump($survey_data);
						   $org = $row->orgno;
						   $orgmemno = $row->orgmemno;
						   $sec_no = $row->sec_no;
						   $question = $row->question;
						   $event= $row->event_id;
						   $sub_id = $row->sub_id;
						   $score =$row->score;
						   $subsectioname = DB::select(DB::raw("select * from mnwv2.def_questions where sec_no='$sec' and sub_sec_no='$sub_id' and qno='$question'"));
						   if(!empty($subsectioname))
						   {
							  $subsecname =  $subsectioname[0]->qdesc;
						   }
						  ?>
							<tr>
							   <td><?php echo $id; ?></td>
							   <td><?php echo $subsecname; ?></td>
							   <td><?php echo $row->score;?></td>
							    <?php
								 if((($sec =='3' and $sub_id=='2') or ($sec=='3' and $sub_id=='9')) or ($sec=='4' and $sub_id=='1'))
								 {  
							          ?>
							         <td><?php
										 if($row->answer =='0')
										  {
											echo "Yes";
										  }
										  else if($row->answer =='1')
										  {
											echo "No";
										  }
										  ?>
									 </td>
									<?php
								 }
								 else
								 {
									 ?>
									 <td rowspan="2"><?php
									 if($ac ==0)
									 {
										 echo $tscore;
										 $ac++;
									 }
									 ?>
									 </td>
									 <?php
								 }
							     
							   ?></td>
							</tr>
						  <?php
						  $id++;
						}
						?>
					</tbody>
				</table>
				<?php
		   
	   }
	   else if(($sec=='2') or ($sec=='3' and $subsec=='3') or ($sec=='4'))
	   {
		   ?>
		<table style="text-align: center;font-size:13" style="font-size: 13" class="table" cellspacing="0" width="100%">
        
          <tr class="brac-color-pink">
            <th>SL</th>
            <th>Vo Code</th>
			<?php 
			if($sec=='4' and $subsec=='2')
			{
				?>
				<th>VO Name</th>
				<th>Marks</th>
				<th>Answer</th>
				<?php
			}
			else if(((($sec=='2') or ($sec=='3' and $subsec=='3')) or (($sec=='4' and $subsec=='3') or ($sec=='4' and $subsec=='4'))) or (($sec=='4' and $subsec=='5') or ($sec=='4' and $subsec=='11')))
			{
				?>
					<th>Member No</th>
					<th>Member Name</th>
					<th>Question</th>
					<th>Marks</th>
					<th>Answer</th>
				<?php
			}
			else
			{
			?>
				<th>Member No</th>
				<th>Member Name</th>
				<th>Marks</th>
				<th>Answer</th>
			<?php
			}
			?>
          </tr>
        
        <tbody>
        <?php 
        $name ='';
        $p=0;
        $qp =0;
        $id = 1;
        $memname ='';
        foreach ($survey_data as $row) 
        {
			//var_dump($survey_data);
           $org = $row->orgno;
           $orgmemno = $row->orgmemno;
		   $sec_no = $row->sec_no;
		   $question = $row->question;
		   $event= $row->event_id;
		   $sub_id = $row->sub_id;
		   //echo $event."/".$org."/".$orgmemno."/".$sec_no."*".$question."--";
           $membername = DB::select(DB::raw("select * from mnwv2.respondents where event_id='$event' and orgno='$org' and orgmemno='$orgmemno'"));
           if(!empty($membername))
           {
              $memname = $membername[0]->MemberName;
           }
          ?>
            <tr>
              <td><?php echo $id; ?></td>
              <td><?php echo $row->orgno;?></td>
			  <?php
				if($sec=='4' and $subsec=='2')
				{
					?>
					  <td><?php echo $memname;?></td>
					  <td><?php echo $row->score;?></td>
					  <td><?php
					  if($sec_no =='1')
					  {
						  if($question=='2' or $question=='4')
						  {
							  if($row->answer =='0')
							  {
								echo "Full Match";
							  }
							  else if($row->answer =='1')
							  {
								echo "Partial Match";
							  }
							  else if($row->answer =='2')
							  {
								echo "No Match";
							  }
						  }
						  else
						  {
							  if($row->answer =='0')
							  {
								echo "Yes";
							  }
							  else if($row->answer =='1')
							  {
								echo "No";
							  }
						  }
						   
					  }
					  else
					  {
						  if($row->answer =='0')
						  {
							echo "Yes";
						  }
						  else if($row->answer =='1')
						  {
							echo "No";
						  }
						  else
						  {
							  echo $row->score;
						  }
					  }
					  
					  ?></td>
					<?php
				}
				else if(((($sec=='2') or ($sec=='3' and $subsec=='3')) or (($sec=='4' and $subsec=='3') or ($sec=='4' and $subsec=='4'))) or (($sec=='4' and $subsec=='5') or ($sec=='4' and $subsec=='11')))
				{
				   $qquery = DB::select(DB::raw("select * from mnwv2.def_questions where sec_no='$sec_no' and sub_sec_no ='$sub_id' and qno='$question'"));
				   if(!empty($qquery))
				   {
					  $qname = $qquery[0]->qdesc;
				   }
				   else
				   {
					   $qname ='';
				   }
					 ?>
					  <td><?php echo $row->orgmemno;?></td>
					  <td><?php echo $memname;?></td>
					  <td><?php echo $qname;?></td>
					  <td><?php echo $row->score;?></td>
					  <td><?php
					  if($sec=='4' and $subsec=='11')
					  {
						  if($row->answer =='0')
						  {
							echo "Yes";
						  }
						  else if($row->answer =='1')
						  {
							echo "No";
						  }
						  else
						  {
							  echo $row->score;
						  }
					  }
					  else if($sec=='4' and $subsec=='5')
					  {
						  echo $row->answer;
					  }
					  else
					  {
						
						  if($row->answer =='0')
						  {
							echo "Yes";
						  }
						  else if($row->answer =='1')
						  {
							echo "No";
						  }
						  else
						  {
							  echo $row->score;
						  }
					  }
					  
              
                     ?></td>
					<?php
				}
				else
				{
			  ?>
              <td><?php echo $row->orgmemno;?></td>
              <td><?php echo $memname;?></td>
              <td><?php echo $row->score;?></td>
              <td><?php
			  if($sec_no =='1')
			  {
				  if($question=='2' or $question=='4')
				  {
					  if($row->answer =='0')
					  {
						echo "Full Match";
					  }
					  else if($row->answer =='1')
					  {
						echo "Partial Match";
					  }
					  else if($row->answer =='2')
					  {
						echo "No Match";
					  }
				  }
				  else
				  {
					  if($row->answer =='0')
					  {
						echo "Yes";
					  }
					  else if($row->answer =='1')
					  {
						echo "No";
					  }
				  }
				   
			  }
			  else
			  {
				  if($row->answer =='0')
				  {
					echo "Yes";
				  }
				  else if($row->answer =='1')
				  {
					echo "No";
				  }
				  else
				  {
					  echo $row->score;
				  }
			  }
              
              ?></td>
            </tr>
          <?php
			}
          $id++;
		  
        }
        ?>
        </tbody>
      </table>
	    <?php
	   }
	   else
	   {
	   ?>
      <table style="text-align: center;font-size:13" style="font-size: 13" class="table" cellspacing="0" width="100%">
        
          <tr class="brac-color-pink">
            <th>SL</th>
            <th>Vo Code</th>
			<?php 
			if((($sec=='4' and $subsec=='2') or ($sec=='4' and $subsec=='3')) or (($sec=='4' and $subsec=='4') or ($sec=='4' and $subsec=='5')))
			{
				?>
				<th>VO Name</th>
				<th>Marks</th>
				<th>Answer</th>
				<?php
			}
			else
			{
			?>
				<th>Member No</th>
				<th>Member Name</th>
				<th>Marks</th>
				<th>Answer</th>
			<?php
			}
			?>
          </tr>
        
        <tbody>
        <?php 
        $name ='';
        $p=0;
        $qp =0;
        $id = 1;
        $memname ='';
        foreach ($survey_data as $row) 
        {
			//var_dump($survey_data);
           $org = $row->orgno;
           $orgmemno = $row->orgmemno;
		   $sec_no = $row->sec_no;
		   $question = $row->question;
		   $event= $row->event_id;
		   $sub_id = $row->sub_id;
		  // echo $event."/".$org."/".$orgmemno."/".$sec_no."*";
           $membername = DB::select(DB::raw("select * from mnwv2.respondents where event_id='$event' and orgno='$org' and orgmemno='$orgmemno'"));
           if(!empty($membername))
           {
              $memname = $membername[0]->MemberName;
           }
          ?>
            <tr>
              <td><?php echo $id; ?></td>
              <td><?php echo $row->orgno;?></td>
			  <?php
				if((($sec=='4' and $subsec=='2') or ($sec=='4' and $subsec=='3')) or (($sec=='4' and $subsec=='4') or ($sec=='4' and $subsec=='5')))
				{
					?>
					  <td><?php echo $memname;?></td>
					  <td><?php echo $row->score;?></td>
					  <td><?php
					  if($sec_no =='1')
					  {
						  if($question=='2' or $question=='4')
						  {
							  if($row->answer =='0')
							  {
								echo "Full Match";
							  }
							  else if($row->answer =='1')
							  {
								echo "Partial Match";
							  }
							  else if($row->answer =='2')
							  {
								echo "No Match";
							  }
						  }
						  else
						  {
							  if($row->answer =='0')
							  {
								echo "Yes";
							  }
							  else if($row->answer =='1')
							  {
								echo "No";
							  }
						  }
						   
					  }
					  else
					  {
						  if($row->answer =='0')
						  {
							echo "Yes";
						  }
						  else if($row->answer =='1')
						  {
							echo "No";
						  }
						  else
						  {
							  echo $row->score;
						  }
					  }
					  
					  ?></td>
					<?php
				}
				else
				{
			  ?>
              <td><?php echo $row->orgmemno;?></td>
              <td><?php echo $memname;?></td>
              <td><?php echo $row->score;?></td>
              <td><?php
			  if($sec_no =='1')
			  {
				  if($question=='2' or $question=='4')
				  {
					  if($row->answer =='0')
					  {
						echo "Full Match";
					  }
					  else if($row->answer =='1')
					  {
						echo "Partial Match";
					  }
					  else if($row->answer =='2')
					  {
						echo "No Match";
					  }
				  }
				  else
				  {
					  if($row->answer =='0')
					  {
						echo "Yes";
					  }
					  else if($row->answer =='1')
					  {
						echo "No";
					  }
				  }
				   
			  }
			  else
			  {
				  if($row->answer =='0')
				  {
					echo "Yes";
				  }
				  else if($row->answer =='1')
				  {
					echo "No";
				  }
				  else
				  {
					  echo $row->score;
				  }
			  }
              
              ?></td>
            </tr>
          <?php
			}
          $id++;
		  
        }
        ?>
        </tbody>
      </table>
	  <?php   
	   }
	   ?>
            </div>
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