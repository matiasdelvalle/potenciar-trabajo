<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }
    
    public function permissions(){
    	return $this->belongsToMany(Permission::class);
    }
	
    public function givePermissionTo(Permission $permission){
    	return $this->permissions()->save($permission);
    }

    public function hasPermission($permission){
        if(is_string($permission)){
            return $this->permissions->contains('name', $permission);
        }
        return !!$permission->intersect($this->permissions)->count();
    }

}
