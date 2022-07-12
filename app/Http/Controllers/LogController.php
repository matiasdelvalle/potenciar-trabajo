<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;
use Response;

class LogController extends Controller
{
    //
    public function index(Request $request){
    	$data = Carbon::now()->format('Y-m-d');
    	$logFile = file(storage_path().'/logs/laravel-'.$data.'.log');
    	$data = [];
  		foreach ($logFile as $line_num => $line) {
  			if(substr( $line, 0, 1 ) === "["){
  				$first = $line;
	     		$data[] = array(
	     			'fecha' 		=> substr($line,1,19),
	     			'tipo' 			=> substr($line,28,5),
	     			'first' 		=> substr($line,34,180),
	     		);
  			}
  		}
  		$data = array_reverse($data);
    	return view('admin.log.index', compact('data'));
    }


    public function api(Request $request){
        $date = Carbon::now()->format('Y-m-d');
        $data = [];
        if(file_exists(storage_path().'/logs/laravel-'.$date.'.log')){
            $logFile = file(storage_path().'/logs/laravel-'.$date.'.log');
            foreach ($logFile as $line_num => $line) {
                if(substr( $line, 0, 1 ) === "["){
                    $first = $line;
                    $data[] = array(
                        'fecha'         => substr($line,1,19),
                        'tipo'          => substr($line,28,5),
                        'first'         => substr($line,34,180),
                    );
                }
            }
        }

        $data = array_reverse($data);
        return Response::json($data);
    }
}
