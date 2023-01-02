<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use View;
use Datatable;
use Illuminate\Support\Facades\Input;
use PHPExcel; 
use PHPExcel_IOFactory;
use Maatwebsite\Excel\Facades\Excel;
set_time_limit(120);
use Log;
class NationalController extends Controller
{
	public function NationalView(Request $request)
	{
		$dataload =true;
		$eventyear ='';
		$eventquarter='';
		$data = Input::get('event');

		if($data !='')
		{
			$exp = explode(',',$data);
			$eventyear = $exp[0];
			$eventquarter = $exp[1];
			//$a_id = $exp[2]
		}
		$national = DB::select( DB::raw("select year,quarterly from mnwv2.monitorevents group by year, quarterly order by year DESC, quarterly DESC LIMIT 2"));
		//$national = DB::table('mnwv2.monitorevents')->select('year,quarterly')->groupBy('year','quarterly')->orderBy('year','DESC')->orderBy('quarterly','DESC')->limit(2)->get();

		return view('National/NationalDashboard',compact('national','dataload','eventyear','eventquarter'));	
	}
	public function DivisionWise(Request $request)
	{
		$div= Input::get('division');
		$exp = explode(",", $div);
		$sec = $exp[0];
		$year = $exp[1];
		$quarter = $exp[2];

		return view('National/DivisionWiseAcheivement',compact('sec','year','quarter'));
	}
	public function AreaWise(Request $request)
	{
		$area= Input::get('area');
		$exp = explode(",", $area);
		$sec = $exp[0];
		$reg = $exp[1];
		$year = $exp[2];
		$quarter = $exp[3];

		return view('National/AreaWiseAcheivement',compact('sec','year','quarter','reg'));
	}
	public function NationalSectionDetails(Request $request)
	{
		$section= Input::get('section');
		$exp = explode(",", $section);
		$sec = $exp[0];
		$brcode = $exp[1];
		$year = $exp[2];
		$quarter = $exp[3];
		return view('National/NationSectionDetails',compact('sec','year','quarter','brcode'));
	}
	public function MonthDivisionWise(Request $request)
	{
		$data = Input::get('month');
		if($data !='')
		{
			$exp =  explode(",", $data);
			$section = $exp[0];
			$month = $exp[1];
			$year = $exp[2];
			$quarter = $exp[3];
			$division = $exp[4];

		}
		return view('National/MonthWiseDivision',compact('division','quarter','year','month','section'));
	}
	public function MonthAreaWise(Request $request)
	{
		$data = Input::get('region');
		if($data !='')
		{
			$exp =  explode(",", $data);
			$section = $exp[0];
			$region = $exp[1];
			$year = $exp[2];
			$quarter = $exp[3];
			$month = $exp[4];
			

		}
		return view('National/MonthWiseArea',compact('region','quarter','year','month','section'));
	}
	public function GlobalReport(Request $request)
	{
		$dataload =true;
		$br ='';
		$brnchcode ='';
		$area ='';
		$div='';
		$reg='';
		$rollid='';
		$userpin='';
		$eventid ='';
		$brnch = '';
		$div = Input::get('division');
		$reg = Input::get('region');
		$area = Input::get('area');
		$brnchcode = Input::get('branch');
		$rollid =$request->session()->get('roll');
		$asid =$request->session()->get('asid');
		$userpin = $request->session()->get('user_pin');
	    $eventid = Input::get('event');
		$brnch = Input::get('brnch');

		if($rollid == '4' and $brnchcode==''){
			$exist=0;
			$branch_list = DB::table('branch')->select('branch_id')->where('division_id',$asid)->groupBy('branch_id')->orderBy('branch_id','ASC')->get()->toArray();
			foreach($branch_list as $row){
				$branch=$row->branch_id;
				if($branch == $brnch){
					$exist=1;
				}
			}
			if($exist==0){
				Session::flash('message', "Branch not assigned");
				return Redirect::back();
			}
		}
		if($rollid == '3' and $brnchcode==''){
			$exist=0;
			$branch_list = DB::table('branch')->select('branch_id')->where('region_id',$asid)->groupBy('branch_id')->orderBy('branch_id','ASC')->get()->toArray();
			foreach($branch_list as $row){
				$branch=$row->branch_id;
				if($branch == $brnch){
					$exist=1;
				}
			}
			if($exist==0){
				Session::flash('message', "Branch not assigned");
				return Redirect::back();
			}
		}
		if($rollid == '2' and $brnchcode==''){
			$exist=0;
			$branch_list = DB::table('branch')->select('branch_id')->where('area_id',$asid)->groupBy('branch_id')->orderBy('branch_id','ASC')->get()->toArray();
			foreach($branch_list as $row){
				$branch=$row->branch_id;
				if($branch == $brnch){
					$exist=1;
				}
			}
			if($exist==0){
				Session::flash('message', "Branch not assigned");
				return Redirect::back();
			}
		}
		if($rollid!='2' and $rollid!='3' and $rollid!='4' and $brnchcode==''){
			$exist=0;
			$branch_list = DB::table('branch')->select('branch_id')->groupBy('branch_id')->orderBy('branch_id','ASC')->get()->toArray();
			foreach($branch_list as $row){
				$branch=$row->branch_id;
				if($branch == $brnch){
					$exist=1;
				}
			}
			if($exist==0){
				Session::flash('message', "Branch not assigned");
				return Redirect::back();
			}
		}
		if($div !='' and $reg !='' and $area !='' and $brnchcode=='' and $brnch=='')
		{
           
           ?>
			 <script type="text/javascript">
			 	window.location.href="ADashboard?areaid=<?php echo $area; ?>";
			 </script>>
			<?php
		}
		else if ($div !='' and $reg !='' and $area =='' and $brnchcode=='' and $brnch=='') 
		{
			
			?>
			 <script type="text/javascript">
			 	window.location.href="RDashboard?regid=<?php echo $reg; ?>";
			 </script>>
			<?php
		}
		else if($div !=''and $reg =='' and $area =='' and $brnchcode=='' and $brnch=='')
		{
			?>
			 <script type="text/javascript">
			 	window.location.href="DDashboard?divid=<?php echo $div; ?>";
			 </script>>
			<?php
		}

		if($area !='' and $brnchcode !='' )
		{
			$cnt = strlen($brnchcode);
			if($cnt =='3')
			{
				$brnchcode ='0'.$brnchcode;
			}
			//$br = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnchcode' order by id DESC limit 2"));
			$br =  DB::table('mnwv2.monitorevents')->where('branchcode',$brnchcode)->orderBy('id', 'desc')->limit(2)->get();
		}
		else if($brnch !='')
		{
			$cnt = strlen($brnch);
			//dd($brnch);
			if($cnt =='3')
			{
				$brnchcode ='0'.$brnch;
			}
			else
			{
				$brnchcode =$brnch;
			}
			$getarea= DB::table('mnwv2.monitorevents')->where('branchcode',$brnchcode)->get();
			// dd($brnchcode);
			if(!$getarea->isEmpty())
			{
				$area = $getarea[0]->area_id;
				$reg = $getarea[0]->region_id;
				$div =$getarea[0]->division_id;
			}else{
				Session::flash('message', "No data available for branch");
				return Redirect::back();
			}
			$currentDate =date('Y-m-d');
			$brnch2 = DB::table('mnwv2.monitorevents')->where('branchcode',$brnchcode)->orderBy('id', 'desc')->limit(2)->get();
			if(!$brnch2->isEmpty())
			{
				$limit =0;
				$offset = 0;
				foreach($brnch2 as $row)
				{
					$datestart = $row->datestart;
					$dateend = $row->dateend;
					//echo $datestart."<=".$currentDate."-".$dateend.">=".$currentDate;
					//if($currentDate >='$datestart' and $dateend >='$currentDate')
					if($datestart <=$currentDate and $dateend >=$currentDate)
					{
						$offset ++;
					}
					else
					{
						$limit ++;
						
						//$br_monevents = DB::table('mnwv2.monitorevents')->where('branchcode',$brcode)->orderBy('id', 'desc')->limit(2)->get();
						$br = DB::table('mnwv2.monitorevents')->where('branchcode',$brnchcode)->orderBy('id', 'desc')->offset($offset)->limit(2)->get();
						
						//$offset ++;
						
					}
					

				}
				//dd($br);
			}
			//$br = DB::select( DB::raw("select * from mnwv2.monitorevents where branchcode='$brnchcode' order by id DESC limit 2"));
		}
		else
		{
			//$division = DB::select( DB::raw("select  division_name,division_id from branch  where program_id='1' group by division_name,division_id order by division_id"));
			$division = DB::table('branch')->select('division_name','division_id')->where('program_id',1)->groupBy('division_name','division_id')->orderBy('division_id','ASC')->get();
		}

		//$division = DB::select( DB::raw("select  division_name,division_id from branch  where program_id='1' group by division_name,division_id order by division_id"));
		$division = DB::table('branch')->select('division_name','division_id')->where('program_id',1)->groupBy('division_name','division_id')->orderBy('division_id','ASC')->get();
		if($rollid=='17')
		{

           $division = DB::select( DB::raw("select division_name,division_id from branch where branch_id in (select cast(branch_code as INT) from mnwv2.cluster where c_associate_id='$userpin') and program_id=1 group by division_id,division_name order by division_id ASC"));
		}
		else if($rollid=='18')
		{
			$division = DB::select( DB::raw("select division_name,division_id from branch where branch_id in (select cast(branch_code as INT) from mnwv2.cluster where z_associate_id='$userpin') and program_id=1 group by division_id,division_name order by division_id ASC"));

		}
		// dd('test');
		//var_dump($division);
		return view('National/GlobalReport', compact('dataload','div','area','reg','brnchcode','division','br','userpin','rollid','eventid'));
	}
	public function Zonal_Add(Request $request)
	{
		$dataload = true;
		return view('National/Zonal',compact('dataload'));
	}
	public function Zonal_Store(Request $request)
	{
		$name = Input::get('zonalname');
		$id = Input::get('zonalid');
		$checkZonal = DB::table('mnwv2.zonal')->where('zonal_code',$id)->get();
		if($checkZonal->isEmpty())
		{
			$sqldata = DB::table('mnwv2.zonal')->insert(['zonal_name'=>$name,'zonal_code'=>$id]);
			if($sqldata)
			{
				return redirect()->back()->with('success', 'Zonal Data Add Success!!');
			}
			else
			{
			   return redirect()->back()->with('error', 'Zonal Data Add Failed!!');
			}
			
		}
		else
		{
		   return redirect()->back()->with('error', 'Zonal Data Already Exists!!');
		}
		
	}
	public function Cluster_Add(Request $request)
	{
		$dataload = true;
		return view('National/Cluster',compact('dataload'));
	}
	public function Cluster_Store(Request $request)
	{
		$zonalcode = Input::get('zonalcode');
		$clustername = Input::get('clustername');
		$clusterid = Input::get('clusterid');
		$branch = Input::get('branch');
		//var_dump($branch);
		foreach($branch as $row)
		{
			$br_id = $row;
			//echo $br_id."/";
			$branchsql = DB::select(DB::raw("select * from branch where branch_id='$br_id' and program_id='1'"));
			foreach($branchsql as $r)
			{
				$brname = $r->branch_name;
				$area_name = $r->area_name;
				$region_name =  $r->region_name;
				$division_name = $r->division_name;
				$checkCluster = DB::table('mnwv2.cluster')->where('zonal_code',$zonalcode)->where('cluster_id',$clusterid)->where('branch_code',$br_id)->get();
				if($checkCluster->isEmpty())
				{
					$sqldata = DB::table('mnwv2.cluster')->insert(['cluster_id'=>$clusterid,'cluster_name'=>$clustername,'branch_name'=>$brname,'branch_code'=>$br_id,'area_name'=>$area_name,'region_name'=>$region_name,'division_name'=>$division_name,'zonal_code'=>$zonalcode]);
				}		
			}
			
		}
		if($sqldata)
		{
			return redirect()->back()->with('success', 'Cluster Data Add Success!!');
		}
		else
		{
		   return redirect()->back()->with('error', 'Cluster Data Add Failed!!');
		}
	}
	public function ClusterDash(Request $request)
	{
		$dataload = true;
		$zoneall =DB::select(DB::raw("select * from mnwv2.zonal"));
		if(empty($zoneall))
		{
			$zoneall  ='';
		}
		return view('National/ClusterDashboard',compact('zoneall','dataload'));
	}
	public function GetCluster(Request $request)
	{
		$zoneid=Input::get('id');
		$cluster =DB::select(DB::raw("select c_associate_id,cluster_id,cluster_name from mnwv2.cluster where z_associate_id='$zoneid' group by c_associate_id,cluster_id,cluster_name order by cluster_id ASC"));
		echo json_encode($cluster);
	}
	public function ZonalDash(Request $request)
	{
		$dataload = true;
		$zoneall =DB::select(DB::raw("select * from mnwv2.zonal"));
		if(empty($zoneall))
		{
			$zoneall  ='';
		}
		return view('National/ZonalDash',compact('zoneall','dataload'));
	}
	public function ClusterView(Request $request)
	{
		//$clusterdata = DB::select(DB::raw("select * from mnwv2.cluster order by cluster_id ASC"));
	    // $clusterdata =DB::table('mnwv2.cluster')->orderBy('cluster_id','ASC')->paginate(10);
		// return view('National/ClusterView',compact('clusterdata','dataload'));
		return view('National/ClusterView');
		// return datatables(DB::table('mnwv2.cluster')->orderBy('cluster_id','ASC'))->toJson();
	}
	public function ClusterViewLoad(Request $request)
	{
		//return datatables(DB::table('mnwv2.cluster')->orderBy('cluster_id','ASC'))->toJson();
		return datatables(DB::select(DB::raw("select cluster_id,cluster_name,branch_name,branch_code,area_name,region_name,division_name,zonal_code,(select zonal_name from mnwv2.zonal where mnwv2.zonal.zonal_code=  mnwv2.cluster.zonal_code) from mnwv2.cluster")))->toJson();
	}
	public function ZonalView(Request $request)
	{
		//$clusterdata = DB::select(DB::raw("select * from mnwv2.cluster order by cluster_id ASC"));
	    $zonaldata =DB::table('mnwv2.zonal')->paginate(10);
		return view('National/ZonalView',compact('zonaldata'));
	}
	public function ClusterViewSearch(Request $request)
	{
		$id =Input::get('id');
		//echo $id;
		if($id !='')
		{
			//$sql = DB::select(DB::raw("select * from mnwv2.cluster as c,zonal as z where c.zonal_code = z.zonal_code and cluster_id ='$id' or cluster_name LIKE '%$id%' or branch_name LIKE '%$id%' or branch_code LIKE '%$id%' or area_name LIKE '%$id%' or region_name LIKE '%$id%' or division_name LIKE '%$id%' or zonal_code='$id' order by cluster_id ASC"));
			//$sql = DB::select(DB::raw("select * from mnwv2.cluster c where c.branch_code LIKE '%$id%' or c.cluster_name LIKE '%$id%' order by cluster_id ASC"));
		    $sql = DB::select(DB::raw("select cluster_id,cluster_name,branch_name,branch_code,area_name,region_name,division_name,zonal_code,(select zonal_name from mnwv2.zonal where mnwv2.zonal.zonal_code=  mnwv2.cluster.zonal_code) from mnwv2.cluster where mnwv2.cluster.cluster_name LIKE '%$id%' or mnwv2.cluster.branch_code LIKE '%$id%' order by cluster_id ASC"));
			// echo json_encode($sql);
			return Datatables::of($sql)->make(true);
		}
		else
		{
			// $sql1 = DB::table('mnwv2.cluster')->paginate(10);
			// echo json_encode($sql1);
			return datatables(DB::table('mnwv2.cluster'))->toJson();
		}
	}


	//siam
	public function Cluster_Asc_Id_Add()
	{
		$clusters=DB::table('mnwv2.cluster')->select('cluster_id','cluster_name')->groupBy('cluster_id','cluster_name')->orderBy('cluster_id')->get();
		$zonal = DB::table('mnwv2.zonal')->select('zonal_code','zonal_name')->groupBy('zonal_code','zonal_name')->orderBy('zonal_code')->get();
		//dd($zonal);
		return view('National/addClusterAscId',compact('clusters','zonal'));
	}
	//siam
	public function Cluster_Asc_Id_Store(Request $request)
	{
		$data=$request->all();
		$cluster=$data['cluster'];
		$associate_id=$data['cassociate_id'];
		$cluster_ary=explode('-',$cluster);
		$cluster_id=$cluster_ary[0];
		$zonal = $data['zonal'];
		$zassociate_id=$data['zassociate_id'];
		$zonal_ary=explode('-',$zonal);
		$zonal_id=$zonal_ary[0];
		// dd($cluster_id);
		//var_dump($branch);
		
		DB::table('mnwv2.cluster')->where('cluster_id', $cluster_id)->update(['c_associate_id' => $associate_id,'z_associate_id' => $zassociate_id]);
		DB::table('mnwv2.zonal')->where('zonal_code', $zonal_id)->update(['z_associate_id' => $zassociate_id]);

		return redirect()->back()->with('success', 'Associate Id Added Successfully to cluster!!');
		
	}
	//siam
	public function Zonal_Asc_Id_Add()
	{
		$zonals=DB::table('mnwv2.zonal')->select('zonal_code','zonal_name')->groupBy('zonal_code','zonal_name')->orderBy('zonal_code')->get();
		// dd($clusters);
		return view('National/addZonalAscId',compact('zonals'));
	}
	//siam
	public function Zonal_Asc_Id_Store(Request $request)
	{
		$data=$request->all();
		$zonal=$data['zonal'];
		$associate_id=$data['associate_id'];
		$zonal_ary=explode('-',$zonal);
		$zonal_code=$zonal_ary[0];
		// dd($cluster_id);
		//var_dump($branch);
		
		DB::table('mnwv2.zonal')->where('zonal_code', $zonal_code)->update(['associate_id' => $associate_id]);

		return redirect()->back()->with('success', 'Associate Id Added Successfully to zonal!!');
		
	}
	public function NationalAllPreviousView(Request $request)
	{
		$national_id =$request->session()->get('asid');

		$allyear = DB::table('mnwv2.monitorevents')->select('year')->groupBy('year')->get();
		return view('National/NationalAllPreviousView',compact('allyear'));
	}
	public function NationalPreviousData(Request $request)
	{
		$year='';
		$quarter ='';
		$yr ='';
		$q='';
		$allgroup='';
		$alldata='';
		$asid =$request->session()->get('asid');

		$year = Input::get('year');

		$quarter = Input::get('quarter');

		if($year !='--select--' and $quarter=='')
		{
			$yr = $year;
			$alldata = DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('year',$year)->where('areacompletestatus',1)->groupBy('year','quarterly')->get();
			//dd($alldata);

		}
		else if($year !='--select--' and $quarter !='')
		{
			$exp = explode("-", $quarter);
			$yr=$exp[0];
			$q = $exp[1];
			$alldata = DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('year',$year)->where('quarterly',$q)->groupBy('year','quarterly')->where('areacompletestatus',1)->get();
			//dd($alldata);
		}
		return view('National/NationalAllPreviousData',compact('alldata','asid','yr','q','allgroup'));
	}

}