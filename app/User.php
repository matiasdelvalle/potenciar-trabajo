<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function assignRole($role){
        $this->roles()->save(
            Role::whereName($role)->firstOrFail()
        );
    }

    public function hasRole($role){
        if(is_string($role)){
            return $this->roles->contains('name', $role);
        }
        return !!$role->intersect($this->roles)->count();
    }    

    public function subsecretarias(){
        return $this->belongsToMany('App\SubsecretariasEntes', 'subsecretaria_user', 'user_id', 'subsecretaria_id');
    }

    public function assignSubsecretaria($linea){
        $this->subsecretarias()->save(
            Lineas::whereName($linea)->firstOrFail()
        );
    }

    public function hasSubsecretaria($subsecretaria){
        if(is_string($subsecretaria)){
            return $this->subsecretarias->contains('nombre', $subsecretaria);
        }
        return !!$linea->intersect($this->subsecretaria)->count();
    }

    public function actividades(){
        return $this->hasMany(Actividades::class, 'user_id', 'id');
    }

    public function estado(){
        return $this->hasOne(EstadoRegistros::class, 'estado_registro_id', 'estado_registro_id');
    }

    public function funcion(){
        return $this->hasOne(Funcion::class, 'funcion_id', 'funcion');
    }    


}
