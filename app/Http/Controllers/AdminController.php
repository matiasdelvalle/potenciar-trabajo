<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Redirect;
use Response;

class AdminController extends Controller
{
    //

    public function init(Request $request){
        return view('admin.layout.app');
    }

    public function logout(Request $request){
        Auth::logout();
        return Redirect::to("/");
    }    

    public function index(){
        return Redirect::to('acreditaciones'); 
    }

    public function download($file){
        $f = public_path("files/".$file);
        return Response::download($f);
    }
}
