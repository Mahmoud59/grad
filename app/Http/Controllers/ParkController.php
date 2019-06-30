<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Park;
use App\ParkReserve;
use DB;
use Carbon;
class ParkController extends Controller
{
    public function inquiry($user_id)
    {
    	$mytime = Carbon\Carbon::now();
    	$reserve = ParkReserve::where('to','<=', $mytime)->get();
    	//return $reserve;
    	
    	foreach ($reserve as $value) 
    	{
    		$park = Park::find($value->park_id);
    		$park->available = $park->available +1;
    		$park->save();
    	}
    	$reserve = ParkReserve::where('to','<=', $mytime)->delete();




    	$user_id = $user_id;
    	$check = ParkReserve::with('user','park')->where('user_id' , $user_id)->first();
    	if($check)
    	{
    		return response()->json([
                'status_code' => 201,
                'success' => true,
                'message' => 'Reserve',
                'error' => null,
                'data'  => $check
            ]);
    	}
    	return response()->json([
                'status_code' => 500,
                'success' => false,
                'message' => 'User Haven\'t reserve',
                'error' => null,
                'data' => null
            ]);
    }

    public function nearest($user_id)
    {
    	$user_id = $user_id;
    	$check = User::find($user_id);

    	$latitude = $check->latitude;
    	$longitude = $check->longitude;
    	
        $place = DB::table("parks")
            ->select("parks.id","parks.name","parks.size","parks.available"
                ,DB::raw("6371 * acos(cos(radians(" . $latitude . ")) 
                * cos(radians(parks.latitude)) 
                * cos(radians(parks.longitude) - radians(" . $longitude . ")) 
                + sin(radians(" .$latitude. ")) 
                * sin(radians(parks.latitude))) AS distance"))
                //->groupBy("parks.id")
                ->having('distance', '>', 0)
                ->orderBy('distance','asc')->first();




	    return response()->json([
                'status_code' => 200,
                'success' => true,
                'message' => 'Nearest parking from user',
                'error' => null,
                'data' => $place
            ]);   
    }

    public function reserve($park_id,$user_id,$from,$to)
    {
    	$park = Park::find($park_id);
    	if($park->available > 0)
	    {
	    	$reserve = new ParkReserve;
	    	$reserve->from = $from;
	    	$reserve->to = $to;
	    	$reserve->user_id = $user_id;
	    	$reserve->park_id = $park_id;

	    	$reserve->save();

	    	$park->available = $park->available -1 ;
	    	$park->save();

    		return response()->json([
                'status_code' => 201,
                'success' => true,
                'message' => 'Done , Park Reserved',
                'error' => null,
                'data' => null,
            ]);  
    	}
    	return response()->json([
                'status_code' => 500,
                'success' => true,
                'message' => 'Sorry! All Place Reserved',
                'error' => null,
                'data' => null,
            ]);  
    }
}	
