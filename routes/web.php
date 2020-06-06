<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect("login");
});

Route::get('/login', "login_control@cargar");
Route::post('/login', "login_control@iniciar_sesion");
Route::get('/cerrar_sesion', "login_control@cerrar_sesion");

Route::get('/inicio', "inicio_cargar@cargar_todo");


Route::get('/consignacion', 'controlador_ventas@cargar_consignaciones');
Route::post('/consignacion', 'controlador_ventas@cargar_consignaciones_ver');

Route::get('/nueva_venta', "controlador_ventas@cargar_n_venta");

Route::post('/nueva_venta', "controlador_ventas@nueva_venta");

Route::get('/liquidar_venta', function () {
    return view('ProyectoFinal/liquidar_venta');
});

Route::post('/liquidar_venta',"controlador_ventas@liquidar_venta");

Route::post('/liquidar_venta/confirmar',"controlador_ventas@liquidar_venta_conf");

Route::get('/archivados', 'controlador_ventas@cargar_archivados');

Route::post('/archivados', 'controlador_ventas@archivar_venta');

Route::get('/convenios', "controlador_ventas@cargar_convenios");
Route::post('/convenios', "controlador_ventas@cargar_convenios_ver");
Route::post('/convenios/abonar', "controlador_ventas@abonar_convenio");
Route::post('/convenios/eliminar', "controlador_ventas@eliminar_convenio");


Route::get('/liquidacion', "controlador_ventas@cargar_liquidaciones_fin");

Route::post('/liquidacion', "controlador_ventas@cargar_liquidaciones_ver");

Route::get('/contado', 'controlador_ventas@cargar_ventas_contado');

Route::post('/contado', 'controlador_ventas@cargar_ventas_contado_ver');

Route::get('/vendedores', 'cargar_vendedores@cargar_vendedores');

Route::post('/vendedores', 'cargar_vendedores@guardar_vendedor');

Route::get('/vendedores/reporte', 'cargar_vendedores@descargar_vendedor');


Route::post('/vendedores/edicion','cargar_vendedores@editar_vendedor');

Route::post('/vendedores/eliminar','cargar_vendedores@borrar_vendedor');

Route::get('/articulos', 'control_articulos@cargar_articulos');

Route::post('/articulos','control_articulos@editar_articulo');

Route::get('/articulos/reporte','control_articulos@descargar_articulos');

Route::post('/registrar_articulo','control_articulos@subir_articulo');

Route::post('/registrar_articulo/acciones/', 'control_articulos@editar_categoria');

Route::get('/registrar_articulo', 'control_articulos@cargar_categorias');

Route::get('/inventario_art', 'control_articulos@cargar_inventario');



Route::get('/historial', "historial_control@cargar_historial");
Route::get('/historial/reporte', "historial_control@descargar_historial");
Route::get('/historial/eliminar', "historial_control@borrar_historial");

Route::get('/estadisticas',"control_estadisticas@cargar_stats");




Route::get('/edit_vend', 'editar_vend@id_vend');





