<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cache;

use App\Http\Requests;
use App\Role;
use App\Permission;

class RoleController extends Controller
{
    //
    public function index(){
    	$roles = Role::withCount('permissions')->orderBy('permissions_count', 'desc')->paginate(20);
    	return view ('admin.grupos.index', $data = array('roles' => $roles));
    }

    public function create(){
        $d   = new Role;
        $permissions = Permission::all();
        return view('admin.grupos.show', compact('d', 'permissions'));
    }

    public function edit($id){
    	$d =  Role::whereId($id)->with('permissions')->first();
    	$permissions = Permission::orderby('id')->get();
    	return view('admin.grupos.show', compact('d', 'permissions'));
    }

    public function store(Request $request){
        $role           = new Role;
        $role->name     = $request->name;
        $role->label    = $request->label;
        $role->save();
        $role->permissions()->sync($request->permission ?: [], true);
        Cache::put('roles', Role::count(), 60);
        return \Redirect::to('roles');
    }

    public function update(Request $request){
        $role = Role::whereId($request->id)->first();        
        $role->name     = $request->name;
        $role->label    = $request->label;
        $role->save();
        $role->permissions()->sync($request->permission ?: [], true);
        return \Redirect::to('roles');
    }

    public function destroy($id){
        $role = Role::whereId($id)->delete();
        Cache::put('roles', Role::count(), 60);
        return \Redirect::to('roles');
    }

    public function api(Request $request){
        return $this->getData($request)->paginate(25);
    }

    public function getData(Request $request){

        $data = Role::with(['permissions'])
                ->when($request->usuario, function($query) use ($request) {
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
                ;

        return $data;
    }    

}
