<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use URL;
use Auth;
use Cache;
use Session;
use Redirect;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;

use App\User;
use App\Role;

class UsuariosController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    function index(){

        $usuarios       = User::with('roles')->get();
        $perfiles       = Role::orderby('id')->get();
        $estados        = [];
        $funciones      = [];
        $subsecretarias = [];
        return view('admin.usuarios.index', compact('usuarios', 'perfiles', 'subsecretarias', 'estados', 'funciones'));
    }

    function create(){

        $d              = new User;
        $roles          = Role::all();
        $subsecretarias = [];
        $funciones      = [];

        // return $d;

        return view('admin.usuarios.show', compact('d', 'roles', 'subsecretarias', 'funciones'));
    }

    public function store(Request $request){

        $this->validate($request, [
            'email'     => 'required|email|unique:users',
            'funcion'   => 'required',
            'nombre'    => 'required',
            'role'      => 'required|min:1',
        ]);

        $user               = new User;
        $user->name         = $request->nombre;
        $user->email        = $request->email;
        $user->telefono     = $request->telefono;
        $user->funcion      = $request->funcion;
        $user->password     = bcrypt( $request->password );
        $user->estado_registro_id = 1;
        $user->save();
        $user->roles()->sync($request->role ?: [], true);

        $json = User::where('id', $user->id)->with(['roles'])->first();
        $auditoria = AuditoriaController::store('i', 'usuarios', $user->id, $json);

        return Redirect::to('/usuarios')->with('message', 'El Usuario fue creado');
    }

    public function update(Request $request){

        $user = User::where('id', '=', $request->id)->first();
        $this->validate($request, [
            'email'     => 'required|email|unique:users,email,'.$user->id,
            'funcion'   => 'required',
        ]);

        $user = User::whereId($request->id)->first();        
        $user->name         = $request->nombre;
        $user->email        = $request->email;
        $user->telefono     = $request->telefono;
        $user->funcion      = $request->funcion;

        if($request->password != ""){
            $user->password = bcrypt($request->password);
        }
        $user->save();
        $user->roles()->sync($request->role             ?: [], true);
        
        $json = User::where('id', $user->id)->with(['roles'])->first();
        $auditoria = AuditoriaController::store('u', 'usuarios', $user->id, $json);
        return Redirect::to('/usuarios')->with('message', 'El Usuario fue actualizado');;
    }

    public function destroy($id){

        $d = User::where('id', $id)->first();
        $d->estado_registro_id = 3;
        $d->save();
        $auditoria = AuditoriaController::store('d', 'usuarios', $id, $d);
        return Redirect::to('/usuarios')->with('message', 'El programa fue Eliminado');;

    }

    public function edit($id){

        $d              = User::whereId($id)->with('roles')->first();
        $roles          = Role::all();
        $funciones      = Funcion::get();
        return view('admin.usuarios.show', compact('d', 'roles', 'funciones'));
    }

    public function api(Request $request){
        return $this->getData($request)->paginate(25);
    }

    public function getData(Request $request){

        $data = User::when($request->usuario, function($query) use ($request) {
                    return $query->where('id', $request->usuario);
                })
                ->when($request->mail, function($query) use ($request) {
                    return $query->where('id', $request->mail);
                })
                ->when($request->perfil, function($query) use ($request) {
                    return $query->whereHas('roles', function($q) use ($request) {
                        return $q->where('roles.id', $request->perfil);
                    });
                })
                ->when($request->funcion, function($query) use ($request) {
                    return $query->where('funcion', $request->funcion);
                })                
                ->with(['roles'])
                ;

        return $data;
    }    


    public function xls(Request $request){

        $data = $this->getData($request)->get();

        // return $data;

        Excel::create('usuarios', function($excel) use($data) {
            $excel->sheet('usuarios', function($sheet) use($data) {
                $arr = json_decode(json_encode($data), true);
                $letra='A';
                $sheet->setCellValue($letra.'1', 'Nombre'); $letra++;
                $sheet->setCellValue($letra.'1', 'E-mail'); $letra++;
                $sheet->setCellValue($letra.'1', 'Subsecretaria'); $letra++;

                $contador = 2;
                foreach($arr as $row){
                    $letra='A';
                    $sheet->setCellValue($letra.$contador, $row['name']); $letra++;
                    $sheet->setCellValue($letra.$contador, $row['email']); $letra++;
                    $sb = '';
                    foreach($row['subsecretarias'] as $sub){
                        $sb .= $sub['nombre'].' ';
                    }
                    $sheet->setCellValue($letra.$contador, $sb); $letra++;
                    $contador++;
                }
            });
        })->export('xls');
    }

    function online(Request $request){
        return view('admin.usuarios.online');
    }

    public function apiOnline(Request $request){
        $users = DB::table('users')->get(); 
        foreach ($users as $user) {
            if(Cache::has('user-is-online-' . $user->id) ){
                $data[] = array(
                    'id'   => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'url' => Cache::get('user-is-lastview-'.$user->id)
                );
            }
        }
        return $data;
    }

}
