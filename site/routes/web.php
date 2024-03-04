<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\v1\ValidateController;
use App\Http\Controllers\EsdevenimentController;
use App\Http\Controllers\LlistatSessionsController;
use App\Http\Controllers\LlistatsEntradesController;
use App\Http\Controllers\CrearEsdevenimentController;
use App\Http\Controllers\EditarEsdevenimentController;
use App\Http\Controllers\DetallsEsdevenimentController;
use App\Http\Controllers\AdministrarEsdevenimentController;
use App\Http\Controllers\AdministrarEsdevenimentsController;
use App\Http\Controllers\ExportarEntradasController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cerca', [HomeController::class, 'cerca'])->name('cerca');
Route::post('/cerca', [HomeController::class, 'cerca'])->name('cerca');

Route::get('/resultados', [HomeController::class, 'cerca'])->name('resultados');

Route::get('/home/{compra}', [HomeController::class, 'msgTicket'])->name('Homes');

Route::get('/esdeveniment/{id}', [EsdevenimentController::class, 'show'])->name('mostrar-esdeveniment');

Route::get('/editarEsdeveniment/{id}', [EditarEsdevenimentController::class, 'editar'])->name('editar-esdeveniment');

Route::post('/login',[LoginController::class,'login'])->name(('login'));
Route::get('/login',[LoginController::class,'login'])->name(('login'));

Route::get('/taullerAdministracio',[LoginController::class,'login'])->name('taullerAdministracio')->middleware('check');

Route::post('/iniciarSesion', [LoginController::class,'iniciarSesion'])->name('iniciarSesion');

Route::get('/homePromotor', [LoginController::class, 'promotorPage'])->name('homePromotor')->middleware('check');
Route::post('/homePromotor', [LoginController::class, 'promotorPage'])->name('homePromotor')->middleware('check');


Route::post('/perfil', [LoginController::class,'iniciarSesion'])->name('perfil')->middleware('check');

Route::get('/session', [SessionController::class, 'SessionController'])->name('session');
Route::post('/session', [SessionController::class, 'SessionController'])->name('session');

Route::get('/crear-esdeveniment', [CrearEsdevenimentController::class, 'index'])->name('crear-esdeveniment')->middleware('check');
Route::post('/crear-esdeveniment.store', [CrearEsdevenimentController::class, 'store'])->name('crear-esdeveniment.store')->middleware('check');
Route::post('/verificar-carrer', [CrearEsdevenimentController::class, 'verificarCarrer'])->name('verficiar-carrer')->middleware('check');

Route::get('crear-recinte',[CrearEsdevenimentController::class, 'recintePage'])->name('crear-recinte')->middleware('check');
Route::get('recinte-nou',[CrearEsdevenimentController::class, 'crearRecinte'])->name('recinte-nou')->middleware('check');

Route::get('/administrar-esdeveniments', [AdministrarEsdevenimentsController::class, 'index'])->name('administrar-esdeveniments')->middleware('check');
Route::post('/administrar-esdeveniments', [AdministrarEsdevenimentsController::class, 'index'])->name('administrar-esdeveniments')->middleware('check');

Route::get('/recuperar',[PasswordController::class,'passwordPage'])->name('recuperar');
Route::post('/recuperar',[PasswordController::class,'passwordPage'])->name('recuperar');

Route::get('/recuperar-form',[PasswordController::class,'enviarCorreo'])->name('recuperar-form');
Route::post('/recuperar-form',[PasswordController::class,'enviarCorreo'])->name('recuperar-form');

Route::get('/cambiarPassword',[PasswordController::class, 'pagePassword'])->name('cambiarPassword');
Route::post('/cambiarPassword',[PasswordController::class, 'pagePassword'])->name('cambiarPassword');


Route::get('/peticionCambiar',[PasswordController::class, 'cambiarPassword'])->name('peticionCambiar');
Route::post('/peticionCambiar',[PasswordController::class, 'cambiarPassword'])->name('peticionCambiar');


Route::post('/confirmacio',[CompraController::class, 'compra'])->name('confirmacioCompra');
Route::post('/procesCompra',[CompraController::class, 'procesPagament'])->name('procesCompra');
Route::post('/redsys',[CompraController::class, 'redsysDades'])->name('redsys');
Route::post('/comprasGratis',[CompraController::class, 'entradasGratis'])->name('comprasGratis');
Route::get('/finCompra',[CompraController::class, 'finalDelPagament'])->name('finCompra');
Route::get('/compraAceptada',[CompraController::class, 'viewFinalCompra'])->name('compraAceptada');
Route::get('/errorCompra',[CompraController::class, 'errorCompra'])->name('errorCompra');


Route::get('/llistat-sessions', [LlistatSessionsController::class, 'index'])->name('llistat-sessions')->middleware('check');
Route::post('/llistat-sessions', [LlistatSessionsController::class, 'index'])->name('llistat-sessions')->middleware('check');

Route::get('/detalls-esdeveniment/{id}', [DetallsEsdevenimentController::class, 'show'])->name('detalls-esdeveniment')->middleware('check');
Route::get('/administrar-esdeveniment/{id}', [AdministrarEsdevenimentController::class, 'show'])->name('administrar-esdeveniment')->middleware('check');
Route::get('/llistats-entrades/{id}', [LlistatsEntradesController::class, 'show'])->name('llistats-entrades')->middleware('check');

Route::get('/añadirSession',[EditarEsdevenimentController::class,'newSessionPage'])->name('añadirSession')->middleware('check');
Route::post('/añadirSession',[EditarEsdevenimentController::class,'newSessionPage'])->name('añadirSession')->middleware('check');

Route::get('/crearOpinion', [OpinionController::class,'newOpinionPage'])->name('crearOpinion');
Route::post('/crearOpinion.store', [OpinionController::class,'store'])->name('crearOpinion.store');

Route::get('/editarSesion',[EditarEsdevenimentController::class,'updateSesionPage'])->name('editarSesion')->middleware('check');

Route::post('/cerrarSesion',[EditarEsdevenimentController::class,'cerrarSesion'])->name('cerrarSesion')->middleware('check');
Route::post('/abrirSesion',[EditarEsdevenimentController::class,'abrirSesion'])->name('abrirSesion')->middleware('check');

Route::post('/peticionSesion',[EditarEsdevenimentController::class,'newSesion'])->name('peticionSesion')->middleware('check');
Route::post('/cambiarSesion',[EditarEsdevenimentController::class,'updateSesion'])->name('cambiarSesion')->middleware('check');

Route::get('/local/{id}',[EsdevenimentController::class, 'local'])->name('detallesLocal');
Route::get('/exportar-entrades/{sessioId}', [ExportarEntradasController::class, 'exportarCSV'])->name('exportar-entrades')->middleware('check');
