<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('home');
});*/

Route::group(['middleware' => 'guest'], function () {
    //Route::get('/home', 'HomeController@index');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/', 'RedireccionController');
    Route::resource('/home', 'RedireccionController');

    Route::group(['middleware' => 'rol:administrador'], function () {
        Route::get('administrador/form_crear_usuario', 'AdministradorController@form_crear_usuario')->name('administrador.form_crear_usuario');
        Route::post('administrador/crear_usuario', 'AdministradorController@crear_usuario')->name('administrador.crear_usuario');
        Route::get('administrador/editar_usuario/{id}', 'AdministradorController@form_editar_usuario')->name('administrador.form_editar_usuario');
        Route::post('administrador/editar_usuario', 'AdministradorController@editar_usuario')->name('administrador.editar_usuario');
        Route::post('administrador/deshabilitar_usuario', 'AdministradorController@deshabilitar_usuario')->name('administrador.deshabilitar_usuario');
        Route::post('administrador/habilitar_usuario', 'AdministradorController@habilitar_usuario')->name('administrador.habilitar_usuario');

        Route::get('administrador/form_crear_producto', 'AdministradorController@form_crear_producto')->name('administrador.form_crear_producto');
        Route::post('administrador/crear_producto', 'AdministradorController@crear_producto')->name('administrador.crear_producto');
        Route::get('administrador/editar_producto/{id}', 'AdministradorController@form_editar_producto')->name('administrador.form_editar_producto');
        Route::post('administrador/editar_producto', 'AdministradorController@editar_producto')->name('administrador.editar_producto');
        Route::post('administrador/deshabilitar_producto', 'AdministradorController@deshabilitar_producto')->name('administrador.deshabilitar_producto');
        Route::post('administrador/habilitar_producto', 'AdministradorController@habilitar_producto')->name('administrador.habilitar_producto');

        Route::get('administrador/form_crear_plano', 'AdministradorController@form_crear_plano')->name('administrador.form_crear_plano');
        Route::post('administrador/crear_plano', 'AdministradorController@crear_plano')->name('administrador.crear_plano');
        Route::get('administrador/editar_plano/{id}', 'AdministradorController@form_editar_plano')->name('administrador.form_editar_plano');
        Route::post('administrador/editar_plano', 'AdministradorController@editar_plano')->name('administrador.editar_plano');
        Route::post('administrador/deshabilitar_plano', 'AdministradorController@deshabilitar_plano')->name('administrador.deshabilitar_plano');
        Route::post('administrador/habilitar_plano', 'AdministradorController@habilitar_plano')->name('administrador.habilitar_plano');

        Route::resource('administrador', 'AdministradorController');
    });

    Route::group(['middleware' => 'rol:director_comercial'], function () {

        Route::post('director_comercial/asignar_tecnico', 'DirectorComercialController@asignar_tecnico')->name('director_comercial.asignar_tecnico');
        Route::post('director_comercial/asignar_oferta', 'DirectorComercialController@asignar_oferta')->name('director_comercial.asignar_oferta');
        Route::post('director_comercial/añadir_cliente', 'DirectorComercialController@añadir_cliente')->name('director_comercial.añadir_cliente');
        Route::get('director_comercial/informe_comercial/{id}', 'DirectorComercialController@informe_comercial')->name('director_comercial.informe_comercial');
        Route::get('director_comercial/informes', 'DirectorComercialController@informes')->name('director_comercial.informes');
        Route::post('director_comercial/informe_cliente', 'DirectorComercialController@informe_cliente')->name('director_comercial.informe_cliente');
        Route::get('director_comercial/informe_todos_comerciales', 'DirectorComercialController@informe_todos_comerciales')->name('director_comercial.informe_todos_comerciales');
        Route::get('director_comercial/ver_informe/{id}', 'DirectorComercialController@ver_informe')->name('director_comercial.ver_informe');
        Route::get('director_comercial/informe_todos_clientes', 'DirectorComercialController@informe_todos_clientes')->name('director_comercial.informe_todos_clientes');


        Route::resource('director_comercial', 'DirectorComercialController');
    });

    Route::group(['middleware' => 'rol:cliente'], function () {

        Route::resource('cliente', 'ClienteController');
        Route::get('/cliente/cambiar_estado/{id}', 'ClienteController@cambiar_estado')->name('cliente.cambiar_estado');
        Route::get('/cliente/edit/{id}', 'ClienteController@edit')->name('cliente.edit');
        Route::post('/cliente/editar', 'ClienteController@editar')->name('cliente.editar');
        Route::post('/cliente/destroy', 'ClienteController@destroy')->name('cliente.destroy');
        Route::post('/cliente/completar_registro', 'ClienteController@completar_registro')->name('cliente.completar_registro');
        Route::post('/cliente/pedir_presupuesto', 'ClienteController@pedir_presupuesto')->name('cliente.pedir_presupuesto');
        Route::post('/cliente/comprar', 'ClienteController@comprar')->name('cliente.comprar');
        Route::post('/cliente/rechazar', 'ClienteController@rechazar')->name('cliente.rechazar');
        Route::get('/cliente/mensajes/{id}', 'ClienteController@mensajes')->name('cliente.mensajes');
        Route::post('/cliente/enviar_mensaje', 'ClienteController@enviar_mensaje')->name('cliente.enviar_mensaje');

        Route::get('/movil', 'ClienteController@movil')->name('movil');
        Route::get('/ver_proyecto/{id}', 'ClienteController@ver_proyecto')->name('ver_proyecto');
        Route::get('/mensajes_movil/{id}', 'ClienteController@mensajes_movil')->name('mensajes_movil');
        Route::post('/enviar_mensaje_movil', 'ClienteController@enviar_mensaje_movil')->name('enviar_mensaje_movil');


    });

    Route::group(['middleware' => 'rol:comercial'], function () {

        Route::post('comercial/asignar_tecnico', 'ComercialController@asignar_tecnico')->name('comercial.asignar_tecnico');
        Route::post('comercial/asignar_oferta', 'ComercialController@asignar_oferta')->name('comercial.asignar_oferta');
        Route::get('comercial/mensajes/{id}', 'ComercialController@mensajes')->name('comercial.mensajes');
        Route::post('comercial/enviar_mensaje', 'ComercialController@enviar_mensaje')->name('comercial.enviar_mensaje');
        Route::post('comercial/enviar_presupuesto', 'ComercialController@enviar_presupuesto')->name('comercial.enviar_presupuesto');

        Route::resource('comercial', 'ComercialController');
    });

    Route::group(['middleware' => 'rol:tecnico'], function () {

        Route::get('tecnico/proyecto/{id}', 'TecnicoController@edit')->name('tecnico.proyecto');
        Route::post('tecnico/cambiar_estado', 'TecnicoController@cambiar_estado')->name('tecnico.cambiar_estado');
        Route::get('tecnico/mensajes/{id}', 'TecnicoController@mensajes')->name('tecnico.mensajes');
        Route::post('tecnico/enviar_mensaje', 'TecnicoController@enviar_mensaje')->name('tecnico.enviar_mensaje');

        Route::resource('tecnico', 'TecnicoController');
    });
});

Auth::routes();
