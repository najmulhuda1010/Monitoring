<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use View;
use Illuminate\Support\Facades\Input;
use PHPExcel; 
use PHPExcel_IOFactory;
use Maatwebsite\Excel\Facades\Excel;
set_time_limit(120);
use Log;
class ExportController extends Controller
{
	public function Export(Request $request)
	{
		$a_id =$request->session()->get('asid');
		$db = DB::select(DB::raw("select division_id,division_name from branch where program_id=1 group by division_id,division_name order by division_id ASC"));
		return view('Export/Export',compact('a_id','db'));
	}
	public function quarter(Request $request)
	{
		$areaid = Input::get('id');
		$Quarter = DB::table('mnwv2.monitorevents')->select('year','quarterly')->where('area_id',$areaid)->GROUPBY('year','quarterly')->get();
		if(!empty($Quarter))
		{
			echo json_encode($Quarter);
		}
	}
	public function period(Request $request)
	{
		$year = Input::get('year');
		$quarter = Input::get('quarter');
		$areaid = Input::get('area_id');
		if($areaid == ''){
			$periods=DB::table('mnwv2.monitorevents')->select('datestart','dateend')->where('year',$year)->where('quarterly',$quarter)->groupBy('datestart','dateend')->orderBy('datestart','DESC')->get();		
		}else{
			$periods=DB::table('mnwv2.monitorevents')->select('datestart','dateend')->where('area_id',$areaid)->where('year',$year)->where('quarterly',$quarter)->groupBy('datestart','dateend')->orderBy('datestart','DESC')->get();		
		}
		if(!empty($periods))
		{
			echo json_encode($periods);
		}
	}
}








