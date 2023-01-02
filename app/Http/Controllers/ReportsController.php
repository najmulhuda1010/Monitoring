<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use View;
use Illuminate\Support\Facades\Input;
use PHPExcel; 
use PHPExcel_IOFactory;
use Maatwebsite\Excel\Facades\Excel;
set_time_limit(60);
use Log;
class ReportsController extends Controller
{
	public function Ongoing_Reports(Request $request)
	{
		$var = Date('Y-m-d');
		$rollid =$request->session()->get('roll');
		$userpin =$request->session()->get('user_pin');
		if($rollid=='17')
		{
			$users = DB::select(DB::raw("select m.changeroll,m.branchcode,(select branch_name from branch where branch_id= cast(m.branchcode AS INT) and program_id=1),m.id eventid,m.datestart,m.dateend,m.monitor1_code,(select name m1 from mnwv2.user where cast(user_pin as INT)=m.monitor1_code),m.monitor2_code,(select name m2 from mnwv2.user where cast(user_pin as INT)=m.monitor2_code) from mnwv2.monitorevents m where m.branchcode in (select branch_code from mnwv2.cluster where c_associate_id='$userpin') and datestart <='$var' and dateend >='$var'"));
		    return datatables($users)->addColumn('action', function ($users) {
                if($users->changeroll=='0'){
					return '<a href="EidtUpcoming?id='.$users->eventid.'" class="btn btn-light">Edit</a>';
				}else{
					return '<a href="EidtUpcoming?id='.$users->eventid.'" class="btn btn-light disabled">Edit</a>';
				}
            })->toJson();
		}
		else if($rollid=='18')
		{
			$users = DB::select(DB::raw("select m.changeroll,m.branchcode,(select branch_name from branch where branch_id= cast(m.branchcode AS INT) and program_id=1),m.id eventid,m.datestart,m.dateend,m.monitor1_code,(select name m1 from mnwv2.user where cast(user_pin as INT)=m.monitor1_code),m.monitor2_code,(select name m2 from mnwv2.user where cast(user_pin as INT)=m.monitor2_code) from mnwv2.monitorevents m where m.branchcode in (select branch_code from mnwv2.cluster where z_associate_id='$userpin') and datestart <='$var' and dateend >='$var'"));
		    return datatables($users)->addColumn('action', function ($users) {
                if($users->changeroll=='0'){
					return '<a href="EidtUpcoming?id='.$users->eventid.'" class="btn btn-light">Edit</a>';
				}else{
					return '<a href="EidtUpcoming?id='.$users->eventid.'" class="btn btn-light disabled">Edit</a>';
				}
            })->toJson();
		}
		else
		{
			$users = DB::select(DB::raw("select m.changeroll,m.branchcode,(select branch_name from branch where branch_id= cast(m.branchcode AS INT) and program_id=1),m.id eventid,m.datestart,m.dateend,m.monitor1_code,(select name m1 from mnwv2.user where cast(user_pin as INT)=m.monitor1_code),m.monitor2_code,(select name m2 from mnwv2.user where cast(user_pin as INT)=m.monitor2_code) from mnwv2.monitorevents m where datestart <='$var' and dateend >='$var'"));
		    return datatables($users)->addColumn('action', function ($users) {
				if($users->changeroll=='0'){
					return '<a href="EidtUpcoming?id='.$users->eventid.'" class="btn btn-light">Edit</a>';
				}else{
					return '<a href="EidtUpcoming?id='.$users->eventid.'" class="btn btn-light disabled">Edit</a>';
				}
                
            })->toJson();
		}
		
	}
	public function OngoingReportView(Request $request)
	{
		return view('Reports/Ongoing');
	}
	public function CloseEvents_Reports(Request $request)
	{
		$var = Date('Y-m-d');
		$rollid =$request->session()->get('roll');
		$userpin =$request->session()->get('user_pin');
		if($rollid=='17')
		{
			$users = DB::select(DB::raw("select m.branchcode,(select branch_name from branch where branch_id= cast(m.branchcode AS INT) and program_id=1),m.id eventid,m.datestart,m.dateend,m.monitor1_code,(select name m1 from mnwv2.user where cast(user_pin as INT)=m.monitor1_code),m.monitor2_code,(select name m2 from mnwv2.user where cast(user_pin as INT)=m.monitor2_code) from mnwv2.monitorevents m where branchcode in (select branch_code from mnwv2.cluster where c_associate_id='$userpin') and dateend < '$var'"));
		    return datatables($users)->addColumn('action', function ($users) {
                return '<a href="#Ongoing/edit/'.$users->eventid.'" class="btn btn-light">Edit</a>';
            })->toJson();
		}
		else if($rollid=='18')
		{
			$users = DB::select(DB::raw("select m.branchcode,(select branch_name from branch where branch_id= cast(m.branchcode AS INT) and program_id=1),m.id eventid,m.datestart,m.dateend,m.monitor1_code,(select name m1 from mnwv2.user where cast(user_pin as INT)=m.monitor1_code),m.monitor2_code,(select name m2 from mnwv2.user where cast(user_pin as INT)=m.monitor2_code) from mnwv2.monitorevents m where branchcode in (select branch_code from mnwv2.cluster where z_associate_id='$userpin') and dateend < '$var'"));
		    return datatables($users)->addColumn('action', function ($users) {
                return '<a href="#Ongoing/edit/'.$users->eventid.'" class="btn btn-light">Edit</a>';
            })->toJson();
		}
		else
		{
			$users = DB::select(DB::raw("select m.branchcode,(select branch_name from branch where branch_id= cast(m.branchcode AS INT) and program_id=1),m.id eventid,m.datestart,m.dateend,m.monitor1_code,(select name m1 from mnwv2.user where cast(user_pin as INT)=m.monitor1_code),m.monitor2_code,(select name m2 from mnwv2.user where cast(user_pin as INT)=m.monitor2_code) from mnwv2.monitorevents m where dateend < '$var'"));
		    return datatables($users)->addColumn('action', function ($users) {
                return '<a href="#Ongoing/edit/'.$users->eventid.'" class="btn btn-light">Edit</a>';
            })->toJson();
		}
		
	}
	public function ClosedReportView(Request $request)
	{
		return view('Reports/Closed');
	}
	public function UpcomingReportView(Request $request)
	{
		return view('Reports/Upcoming');
	}
	public function UpcomingEvents_Reports(Request $request)
	{
		$var = Date('Y-m-d');
		$rollid =$request->session()->get('roll');
		$userpin =$request->session()->get('user_pin');
		if($rollid=='17')
		{
			$users = DB::select(DB::raw("select m.branchcode,(select branch_name from branch where branch_id= cast(m.branchcode AS INT) and program_id=1),m.id eventid,m.datestart,m.dateend,m.monitor1_code,(select name m1 from mnwv2.user where cast(user_pin as INT)=m.monitor1_code),m.monitor2_code,(select name m2 from mnwv2.user where cast(user_pin as INT)=m.monitor2_code) from mnwv2.monitorevents m where branchcode in (select branch_code from mnwv2.cluster where c_associate_id='$userpin') and datestart > '$var'"));
		    return datatables($users)->addColumn('action', function ($users) {
                return '<a href="EidtUpcoming?id='.$users->eventid.'" class="btn btn-light">Edit</a> | <a href="#delete-'.$users->eventid.'" class="btn btn-danger"><i class="glyphicon glyphicon-delete"></i>Delete</a>';
            })->toJson();
		}
		else if($rollid=='18')
		{
			$users = DB::select(DB::raw("select m.branchcode,(select branch_name from branch where branch_id= cast(m.branchcode AS INT) and program_id=1),m.id eventid,m.datestart,m.dateend,m.monitor1_code,(select name m1 from mnwv2.user where cast(user_pin as INT)=m.monitor1_code),m.monitor2_code,(select name m2 from mnwv2.user where cast(user_pin as INT)=m.monitor2_code) from mnwv2.monitorevents m where branchcode in (select branch_code from mnwv2.cluster where z_associate_id='$userpin') and datestart > '$var'"));
		    return datatables($users)->addColumn('action', function ($users) {
                return '<a href="EidtUpcoming?id='.$users->eventid.'" class="btn btn-light">Edit</a> | <a href="#delete-'.$users->eventid.'" class="btn btn-danger"><i class="glyphicon glyphicon-delete"></i>Delete</a>';
            })->toJson();
		}
		else
		{
			$users = DB::select(DB::raw("select m.branchcode,(select branch_name from branch where branch_id= cast(m.branchcode AS INT) and program_id=1),m.id eventid,m.datestart,m.dateend,m.monitor1_code,(select name m1 from mnwv2.user where cast(user_pin as INT)=m.monitor1_code),m.monitor2_code,(select name m2 from mnwv2.user where cast(user_pin as INT)=m.monitor2_code) from mnwv2.monitorevents m where datestart > '$var'"));
		    return datatables($users)->addColumn('action', function ($users) {
                return '<a href="EidtUpcoming?id='.$users->eventid.'" class="btn btn-light">Edit</a> | <a href="#delete-'.$users->eventid.'" class="btn btn-danger"><i class="glyphicon glyphicon-delete"></i>Delete</a>';
            })->toJson();
		}
		
	}

}