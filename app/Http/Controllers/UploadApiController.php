<?php

namespace App\Http\Controllers;
use Log;
use view;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Http\Requests;

class UploadApiController extends Controller
{
    public function uploadDatabase(Request $request)
	{
		// $apikey  ='1234';
        $token = input::get('token');
        $user_data=DB::table('mnwv2.user')->where('session_data','=',$token)->first();
        //dd($user_data);
    	if($user_data)
    	{
            $data =Input::get('jsondata');
            $filename =Input::get('fname');
            // dd($filename);
            // $data =$request->header('jsondata');
            $fn = '/var/www/mnwv2/jsonfile/database_backup/'.$filename.'.json';
            $i=1;
                
            while(file_exists($fn)){
                $fn='/var/www/mnwv2/jsonfile/database_backup/'.$filename.'('.$i.')'.'.json';
                $i++;
            }
            $de = json_decode($data);
            $fp = fopen($fn, 'w');
            fwrite($fp, json_encode($de));
            fclose($fp);


            if($de){
               $status = array("status"=>"success");
               $json2 = json_encode($status);
               echo $json2;
            }
        }else{
    		$arr = array("Error"=>"USER NOT MATCH");
    		echo json_encode($arr);
    	}
		 
         
    }     
}
