<?php

App::setLocale('es');

Route::get('/', 'App\HomeController@index')->name('index');




Route::get('/loginEmpresa', 'App\HomeController@loginEmpresa')->name('loginEmpresa');
//Route::get('/actualizar', 'App\HomeController@actualizar')->name('actualizar');
Route::get('/filtro_distritos/{id}', 'App\HomeController@filtro_distritos')->name('filtro_distritos');
Route::get('/offline_alumno/{id}', 'App\LoginAlumnoController@offline');

Route::get('/buscar_reniec/{data}', 'App\LoginEmpresaController@consultar_reniec')->name('buscar_reniec');
Route::get('/buscar_sunat/{data}', 'App\LoginEmpresaController@consultar_sunat')->name('buscar_sunat');

Route::group(['middleware' => 'auth:alumnos'], function () {
    Route::group(['prefix' => 'alumno'], function () {

        Route::get('/avisos', 'App\AvisoController@avisos')->name('alumno.avisos');
        Route::get('/{empresa}/informacion', 'App\AvisoController@empresa_informacion')->name('alumno.empresa_informacion');
        Route::get('/{empresa}/aviso/{slug}', 'App\AvisoController@informacion')->name('alumno.informacion');
        Route::post('/aviso/postular', 'App\AvisoController@postular')->name('alumno.postular');

        //Route::group(['middleware' => 'alumno'], function () {});

        Route::get('/perfil', 'App\AlumnoController@index')->name('alumno.perfil');
        Route::post('/perfil', 'App\AlumnoController@store')->name('alumno.store');

        Route::get('/perfil/validacion', 'App\AlumnoController@perfil_validacion')->name('alumno.perfil_validacion');

        Route::get('/perfil/educaciones', 'App\AlumnoController@educaciones')->name('alumno.perfil.educaciones');
        Route::get('/perfil/partialViewEducacion/{id}', 'App\AlumnoController@educacion')->name('alumno.perfil.educacion');
        Route::post('/perfil/educacion', 'App\AlumnoController@educacion_store')->name('alumno.perfil.educacion_store');
        Route::post('/perfil/educacion/delete', 'App\AlumnoController@educacion_delete')->name('alumno.perfil.educacion_delete');

        Route::get('/perfil/experiencias', 'App\AlumnoController@experiencias')->name('alumno.perfil.experiencias');
        Route::get('/perfil/partialViewExperienciaLaboral/{id}', 'App\AlumnoController@experiencia_laboral')->name('alumno.perfil.experiencia_laboral');
        Route::post('/perfil/experiencia', 'App\AlumnoController@experiencia_store')->name('alumno.perfil.experiencia_store');
        Route::post('/perfil/experiencia/delete', 'App\AlumnoController@experiencia_delete')->name('alumno.perfil.experiencia_delete');

        Route::get('/perfil/referencias', 'App\AlumnoController@referencias')->name('alumno.perfil.referencias');
        Route::get('/perfil/partialViewReferenciaLaboral/{id}', 'App\AlumnoController@referencia_laboral')->name('alumno.perfil.referencia_laboral');
        Route::post('/perfil/referencia', 'App\AlumnoController@referencia_store')->name('alumno.perfil.referencia_store');
        Route::post('/perfil/referencia/delete', 'App\AlumnoController@referencia_delete')->name('alumno.perfil.referencia_delete');

        Route::get('/perfil/habilidades', 'App\AlumnoController@habilidades')->name('alumno.perfil.habilidades');
        Route::get('/perfil/partialViewHabilidad/{id}', 'App\AlumnoController@habilidad')->name('alumno.perfil.habilidad');
        Route::get('/perfil/partialViewHabilidadProfesional/{id}', 'App\AlumnoController@habilidad_profesional')->name('alumno.perfil.habilidad_profesional');
        Route::post('/perfil/habilidad', 'App\AlumnoController@habilidad_store')->name('alumno.perfil.habilidad_store');
    });
});


Route::post('empresa/login', 'App\LoginEmpresaController@login')->name('empresa.login.post');
Route::post('empresa/logout', 'App\LoginEmpresaController@logout')->name('empresa.logout');

Route::get('empresa/registrar', 'App\HomeController@crear_empresa')->name('empresa.crear_empresa');
Route::post('empresa/registrar', 'App\HomeController@registrar_empresa')->name('empresa.registrar_empresa.post');

Route::post('alumno/login', 'App\LoginAlumnoController@login')->name('alumno.login.post');
Route::post('alumno/logout', 'App\LoginAlumnoController@logout')->name('alumno.logout');


Route::get('alumno/registrar', 'App\HomeController@crear_alumno')->name('alumno.crear_alumno');
Route::post('alumno/registrar', 'App\HomeController@registrar_alumno')->name('alumno.registrar_alumno.post');

/* ADMINISTRADOR */
Route::get('/home/notification', 'Auth\EmpresaController@notification')->name('auth.home.notification');

Route::group(['prefix' => 'auth', 'middleware' => 'auth:web'], function () {
    Route::get('/home', 'Auth\HomeController@index')->name('auth.index');

    Route::group(['prefix' => 'inicio'], function () {
        Route::get('/', 'Auth\InicioController@index')->name('auth.inicio');
        Route::get('/listSeguimiento', 'Auth\InicioController@listSeguimiento')->name('auth.inicio.listSeguimiento');

    });


    Route::group(['prefix' => 'empresa'], function () {
        Route::get('/', 'Auth\EmpresaController@index')->name('auth.empresa');
        Route::get('/list_all', 'Auth\EmpresaController@list')->name('auth.empresa.list');
        Route::get('/partialView/{id}', 'Auth\EmpresaController@partialView')->name('auth.empresa.create');
        Route::post('/update', 'Auth\EmpresaController@update')->name('auth.empresa.update');
        Route::post('/update_data', 'Auth\EmpresaController@updateData')->name('auth.empresa.update_data');
        Route::post('/delete', 'Auth\EmpresaController@delete')->name('auth.empresa.delete');
    });


    /* Programa Controladores */
    Route::group(['prefix' => 'programa'], function () {      
         Route::get('/', 'Auth\ProgramaController@index')->name('auth.programa');
         Route::post('/store', 'Auth\ProgramaController@store')->name('auth.programa.store');
         Route::get('/list_all', 'Auth\ProgramaController@listAll')->name('auth.programas.listAll');
         Route::post('/updateData', 'Auth\ProgramaController@updateData')->name('auth.programa.updateData');
         Route::get('/partialView/{id}', 'Auth\ProgramaController@partialView')->name('auth.programa.create');
         Route::post('/delete', 'Auth\ProgramaController@delete')->name('auth.programas.delete');
         /* Participantes */
         Route::get('/partialViewParticipantes/{id}', 'Auth\ProgramaController@partialViewParticipantes')->name('auth.programa.partialViewParticipantes');
         Route::post('/storeParticipantes', 'Auth\ProgramaController@storeParticipantes')->name('auth.programa.storeParticipantes');
         Route::get('/mostrarParticipantes', 'Auth\ProgramaController@mostrarParticipantes')->name('auth.programa.mostrarParticipantes');
         Route::post('/deletepar', 'Auth\ProgramaController@deletepar')->name('auth.programas.deletepar');
         Route::get('/partialViewpar/{id}', 'Auth\ProgramaController@partialViewpar')->name('auth.programa.create');
         Route::post('/updateParticipanteInscrito', 'Auth\ProgramaController@updateParticipanteInscrito')->name('auth.programa.updateParticipanteInscrito');

    });



    Route::group(['prefix' => 'area'], function () {
        Route::get('/', 'Auth\AreaController@index')->name('auth.area');
        Route::get('/list_all', 'Auth\AreaController@list_all')->name('auth.area.list_all');
        Route::get('/partialView/{id}', 'Auth\AreaController@partialView')->name('auth.area.create');
        Route::post('/store', 'Auth\AreaController@store')->name('auth.area.store');
        Route::post('/delete', 'Auth\AreaController@delete')->name('auth.area.delete');
    });

    // SECTION USUARIO

    Route::group(['prefix' => 'usuarios'], function () {
        Route::get('/', 'Auth\UsuariosController@index')->name('auth.usuarios');
        Route::get('/list_all', 'Auth\UsuariosController@list_all')->name('auth.usuarios.list_all');
        Route::post('/store', 'Auth\UsuariosController@store')->name('auth.usuarios.store');
        Route::post('/delete', 'Auth\UsuariosController@delete')->name('auth.usuarios.delete');
        Route::get('/partialView/{id}', 'Auth\UsuariosController@partialView')->name('auth.usuarios.create');
    });

    // END SECTION USUARIO

    Route::group(['prefix' => 'principal'], function () {
        Route::get('/', 'Auth\PrincipalController@index')->name('auth.principal');

    });

    Route::group(['prefix' => 'error'], function () {
        Route::get('/', 'Auth\ErrorController@index')->name('auth.error');

    });



    Route::group(['prefix' => 'asistencia'], function () {
        Route::get('', 'Auth\AsistenciaController@index')->name('auth.asistencia');
        Route::get('listado', 'Auth\AsistenciaController@verlistado')->name('auth.asistencia.listado');
        Route::post('/asistentesPorCelula', 'Auth\AsistenciaController@asistentesPorCelula')->name('auth.asistentes.asistentesPorCelula');


        Route::get('/list_all', 'Auth\AsistenciaController@list_all')->name('auth.asistencia.list_all');
        Route::post('/delete', 'Auth\AsistenciaController@delete')->name('auth.asistencia.delete');
        Route::post('/store', 'Auth\AsistenciaController@store')->name('auth.asistencia.store');  
        Route::get('/partialView/{id}', 'Auth\AsistenciaController@partialView')->name('auth.asistencia.create');
        Route::post('/storeAsistencia', 'Auth\AsistenciaController@storeAsistencia')->name('auth.asistencia.storeAsistencia');
    });



    Route::group(['prefix' => 'empleado'], function () {
        Route::get('', 'Auth\EmpleadoController@index')->name('auth.empleado');
        Route::post('/store', 'Auth\EmpleadoController@store')->name('auth.empleado.store');
        Route::get('/list_all', 'Auth\EmpleadoController@list_all')->name('auth.empleado.list_all');  
        Route::post('/delete', 'Auth\EmpleadoController@delete')->name('auth.empleado.delete');
        Route::get('/partialView/{id}', 'Auth\EmpleadoController@partialView')->name('auth.empleado.create');
        Route::get('/get/{id}', 'Auth\EmpleadoController@get')->name('auth.empleado.get'); // Nueva ruta para obtener un empleado por ID
        Route::post('/update', 'Auth\EmpleadoController@update')->name('auth.empleado.update');
        Route::get('/generate-carnet', 'Auth\EmpleadoController@generateCarnet')->name('auth.empleado.generateCarnet');
        Route::get('/partialViewCarnet/{id}', 'Auth\EmpleadoController@partialViewCarnet')->name('auth.empleado.create');

    });
    

    Route::group(['prefix' => 'cargo'], function () {
        Route::get('', 'Auth\CargoController@index')->name('auth.cargo');
        Route::get('/list_all', 'Auth\CargoController@list_all')->name('auth.cargo.list_all');  
        Route::post('/delete', 'Auth\CargoController@delete')->name('auth.cargo.delete');
        Route::post('/store', 'Auth\CargoController@store')->name('auth.cargo.store');
        Route::get('/partialView/{id}', 'Auth\CargoController@partialView')->name('auth.cargo.create');
        Route::post('/update', 'Auth\CargoController@update')->name('auth.cargo.update');
    });


    Route::group(['prefix' => 'extras'], function () {
        Route::get('/', 'Auth\ExtrasController@index')->name('auth.extras');
        Route::get('/list_all', 'Auth\ExtrasController@list_all')->name('auth.extras.list_all');
        Route::get('/partialView/{id}', 'Auth\ExtrasController@partialView')->name('auth.extras.create');
        Route::post('/delete', 'Auth\ExtrasController@delete')->name('auth.extras.delete');
        Route::post('/update', 'Auth\ExtrasController@update')->name('auth.extras.update');
        Route::get('/partialViewAgregar/{id}', 'Auth\ExtrasController@partialViewAgregar')->name('auth.extras.create');
        Route::post('/store', 'Auth\ExtrasController@store')->name('auth.extras.store');
    });
    

});



//Página principal registrar opiniones
Route::post('/home/store', 'App\HomeController@store')->name('home.store');


Route::group(['prefix' => 'auth'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
    Route::post('login', 'Auth\LoginController@login')->name('auth.login.post');
    Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

    Route::get('/changePassword/partialView', 'Auth\LoginController@partialView_change_password')->name('auth.login.partialView_change_password');
    Route::post('/changePassword', 'Auth\LoginController@change_password')->name('auth.login.change_password');

    /*Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');*/
});

Route::get('publicar_oferta', 'Auth\LoginController@view_publicar_oferta');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');