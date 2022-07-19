<?php

Auth::routes();
Route::get('/',      'AdminController@index');

Route::group(['middleware' => ['auth']], function(){

    Route::get('admin',                     'AdminController@init');
    Route::resource('usuarios',             'UsuariosController');
    Route::get('logs',                      'UsuariosController@online');
    Route::resource('roles',                'RoleController');
    Route::resource('permisos',                'PermisosController');
    Route::get('logout',                    'AdminController@logout');

    Route::group(array('prefix' => 'api/v1'), function(){
        /* Admin */
        Route::get('usuarios',                  'UsuariosController@api');
        Route::get('roles',                     'RoleController@api');        
        Route::get('online/usuarios',           'UsuariosController@apiOnline');
        Route::get('online/logs',               'LogController@api');
        Route::get('online/autoditoria',        'AuditoriaController@api');

    });
});
