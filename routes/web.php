<?php

use App\Http\Controllers\CaracteristicasController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\CreditosController;
use App\Http\Controllers\DocumentacionController;
use App\Http\Controllers\GarantiaController;
use App\Http\Controllers\InteresController;
use App\Http\Controllers\keller\ClientsController;
use App\Http\Controllers\keller\CustomFieldsController;
use App\Http\Controllers\keller\ModulesController;
use App\Http\Controllers\keller\PermissionsController;
use App\Http\Controllers\keller\PruebasController;
use App\Http\Controllers\keller\UsersController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SolicitudController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return redirect('/login');
});

// Route::get('/dashboard', function () {
//     $user = Auth::user();
//     if ($user->role_id == 4) {
//         return to_route('dashboard');
//     }

//     if ($user->role_id == 5) {
//         return to_route('dashboard');
//     }

//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/inicio', [ClientAuthController::class, 'index'])->middleware(['auth', 'verified'])->name('client.inicio');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware('auth')->group(function () {

    Route::get('/inicio', [ClientAuthController::class, 'index'])->name('client.inicio');
    Route::get('/creditos', [ClientAuthController::class, 'creditos'])->name('client.creditos');
    Route::get('/dashboard', [ClientAuthController::class, 'dashboard'])->name('dashboard');

    Route::get('/pruebas-johann', [PruebasController::class, 'index'])->name('pruebas.johann');

    // Users    
    Route::get('/users',                            [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create',                     [UsersController::class, 'create'])->name('users.create');
    Route::get('/users/{id}/details',               [UsersController::class, 'show'])->name('users.details');
    Route::get('/users/{id}/edit',                  [UsersController::class, 'edit'])->name('users.edit');
    Route::post('/users',                           [UsersController::class, 'store'])->name('users.store');
    Route::put('/users/{id}',                       [UsersController::class, 'update'])->name('users.update');
    Route::post('/users/pagination',                [UsersController::class, 'pagination'])->name('users.pagination');
    Route::delete('/users/{id}',                    [UsersController::class, 'destroy'])->name('users.delete');
    //


    // Permisions   
    Route::get('/permisos',                         [PermissionsController::class, 'index'])->name('permissions.index');
    Route::post('/permissions/roles',               [PermissionsController::class, 'store'])->name('permissions.roles.store');
    Route::get('/permissions/roles',                [PermissionsController::class, 'list'])->name('permissions.roles.list');
    Route::get('/permissions/roles/{id}',           [PermissionsController::class, 'edit'])->name('roles.permissions');
    Route::put('/permissions/roles/{id}',           [PermissionsController::class, 'update'])->name('permissions.roles.update');
    Route::put('/permissions/roles/{id}/check',     [PermissionsController::class, 'changePermissions'])->name('permissions.roles.change');
    Route::delete('/permissions/roles/{id}',        [PermissionsController::class, 'destroy'])->name('permissions.roles.destroy');
    //


    // Custom  
    Route::get('/config/custom-fields',             [CustomFieldsController::class, 'index'])->name('custom_fields.index');
    Route::post('/custom-fields/pagination',        [CustomFieldsController::class, 'pagination'])->name('custom_fields.pagination');
    Route::post('/custom-fields',                   [CustomFieldsController::class, 'store'])->name('custom_fields.store');
    Route::put('/custom-fields/{id}',               [CustomFieldsController::class, 'update'])->name('custom_fields.update');
    //

    // Garantia 
    Route::get('/config/garantias',                 [GarantiaController::class, 'index'])->name('garantia.index');
    Route::get('/get-garantias',                    [GarantiaController::class, 'getGarantias'])->name('garantia.getGarantias');
    Route::post('/garantia-pagination',             [GarantiaController::class, 'pagination'])->name('garantia.pagination');
    Route::post('/garantia',                        [GarantiaController::class, 'save'])->name('garantia.save');
    Route::put('/garantia/{id}',                    [GarantiaController::class, 'update'])->name('garantia.update');
    Route::delete('/garantia/{id}',                 [GarantiaController::class, 'delete'])->name('garantia.delete');
    //

    // Documentacion 
    Route::get('/config/documentacion',             [DocumentacionController::class, 'index'])->name('documentacion.index');
    Route::get('/get-documentacion',                [DocumentacionController::class, 'getDocumentacion'])->name('documentacion.getDocumentacion');
    Route::post('/documentacion-pagination',        [DocumentacionController::class, 'pagination'])->name('documentacion.pagination');
    Route::post('/documentacion',                   [DocumentacionController::class, 'save'])->name('documentacion.save');
    Route::put('/documentacion/{id}',               [DocumentacionController::class, 'update'])->name('documentacion.update');
    Route::delete('/documentacion/{id}',            [DocumentacionController::class, 'delete'])->name('documentacion.delete');
    //

    // Intereses
    Route::get('/config/intereses',                 [InteresController::class, 'index'])->name('interes.index');
    Route::get('/get-intereses',                    [InteresController::class, 'getAll'])->name('interes.getAll');
    Route::post('/intereses-pagination',            [InteresController::class, 'pagination'])->name('interes.pagination');
    Route::put('/intereses/{id}',                   [InteresController::class, 'update'])->name('interes.update');
    //


    // Metodo Pago 
    Route::get('/config/metodo-pago',             [MetodoPagoController::class, 'index'])->name('metodoPago.index');
    Route::get('/get-metodo-pago',                [MetodoPagoController::class, 'getmetodoPago'])->name('metodoPago.getmetodoPago');
    Route::post('/metodo-pago-pagination',        [MetodoPagoController::class, 'pagination'])->name('metodoPago.pagination');
    Route::post('/metodo-pago',                   [MetodoPagoController::class, 'save'])->name('metodoPago.save');
    Route::put('/metodo-pago/{id}',               [MetodoPagoController::class, 'update'])->name('metodoPago.update');
    Route::delete('/metodo-pago/{id}',            [MetodoPagoController::class, 'delete'])->name('metodoPago.delete');
    //


    // Modules  
    Route::get('/config/modules',                   [ModulesController::class, 'index'])->name('modules.index');
    Route::get('/modules',                          [ModulesController::class, 'list'])->name('modules.list');
    Route::put('/modules/{id}/change',              [ModulesController::class, 'change'])->name('modules.change');
    Route::put('/modules/{id}',                     [ModulesController::class, 'update'])->name('modules.update');
    //


    // Clients
    Route::get('/clients',                          [ClientsController::class, 'index'])->name('clients.index');
    Route::get('/get-clients',                      [ClientsController::class, 'getClients'])->name('clients.getClients');
    Route::post('/clients-pagination',              [ClientsController::class, 'pagination'])->name('clients.pagination');
    Route::post('/clients',                         [ClientsController::class, 'store'])->name('clients.store');
    Route::post('/clients-pasword-update',          [ClientsController::class, 'passwordUpdate'])->name('clients.passwordUpdate');
    Route::get('/client/{client}',                  [ClientsController::class, 'show'])->name('client.show');
    Route::put('/clients/{client}',                 [ClientsController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}',              [ClientsController::class, 'destroy'])->name('clients.destroy');
    //

    // Productos 
    Route::get('/productos',                        [ProductController::class, 'index'])->name('products.index');
    Route::get('/productos-all',                    [ProductController::class, 'productos'])->name('products.productos');
    Route::post('/products-pagination',             [ProductController::class, 'pagination'])->name('products.pagination');
    Route::post('/producto',                        [ProductController::class, 'saveProduct'])->name('products.saveProduct');
    Route::put('/producto/{product}',               [ProductController::class, 'updateProduct'])->name('products.updateProduct');
    Route::delete('/producto/{product}',            [ProductController::class, 'deleteProduct'])->name('products.deleteProduct');
    //

    // Caracteristicas 
    Route::get('/caracteristicas',                  [CaracteristicasController::class, 'index'])->name('catacteristica.index');
    Route::get('/caracteristicas/{id}',             [CaracteristicasController::class, 'caracteristicas'])->name('catacteristica.selectProduct');
    Route::get('/get-caracteristicas/{id}',         [CaracteristicasController::class, 'getCaracteristica'])->name('catacteristica.getCaracteristica');
    Route::get('/get-product-caract',               [CaracteristicasController::class, 'getProductGarantias'])->name('garantia.getProductGarantias');
    Route::post('/caracteristicas-pagination',      [CaracteristicasController::class, 'pagination'])->name('catacteristica.pagination');
    Route::post('/caracteristica',                  [CaracteristicasController::class, 'saveCaracteristica'])->name('catacteristica.saveCaracteristica');
    Route::put('/caracteristica/{id}',              [CaracteristicasController::class, 'updateCaracteristica'])->name('catacteristica.updateCaracteristica');
    Route::delete('/caracteristica/{id}',           [CaracteristicasController::class, 'deletePCaracteristica'])->name('catacteristica.deletePCaracteristica');
    //


    // Solicitudes 
    Route::post('/solicitud-inicial',                       [SolicitudController::class, 'primeraSolicitud'])->name('solicitud.primeraSolicitud');

    Route::get('/editar-solicitud/{id}',                    [SolicitudController::class, 'editarSolicitud'])->name('solicitud.editarSolicitud');
    Route::get('/ver-amortizacion/{monto}/{tiempo}/{taza}/{tipo}', [SolicitudController::class, 'verAmortizacion'])->name('solicitud.verAmortizacion');
    Route::get('/ver-aprobado/{id}',                        [SolicitudController::class, 'verAprobado'])->name('solicitud.verAprobado');
    Route::get('/get-solicitud/{id}',                       [SolicitudController::class, 'getSolicitud'])->name('solicitud.getSolicitud');
    Route::put('/update-solicitud/{id}',                    [SolicitudController::class, 'updateStateSolicitud'])->name('solicitud.updateStateSolicitud');
    Route::post('/primera-solicitud',                       [SolicitudController::class, 'saveSolicitud'])->name('solicitud.saveSolicitud');

    Route::post('/save-referencias',                [SolicitudController::class, 'saveReferencias'])->name('solicitud.saveReferencias');

    Route::get('/solicitudes',                      [SolicitudController::class, 'index'])->name('solicitud.index');
    Route::get('/solicitudes-detalle/{id}',         [SolicitudController::class, 'show'])->name('solicitud.show');

    Route::post('/updload-files',                   [SolicitudController::class, 'uploadFile'])->name('solicitud.uploadFile');
    Route::get('/get-files/{id}',                   [SolicitudController::class, 'getFiles'])->name('solicitud.getFiles');
    Route::get('/download-files/{id}',              [SolicitudController::class, 'downloadFile'])->name('solicitud.downloadFile');
    Route::delete('/delete-file/{id}',              [SolicitudController::class, 'deleteFile'])->name('solicitud.deleteFile');


    Route::get('/save-preaprovado/{id}',            [SolicitudController::class, 'savePreaprovado'])->name('solicitud.savePreaprovado');
    Route::put('/update-estado-solicitud/{id}',     [SolicitudController::class, 'updateEstadoSolicitud'])->name('solicitud.updateEstadoSolicitud');
    Route::put('/update-valores-solicitud/{id}',    [SolicitudController::class, 'updateValoresSolicitud'])->name('solicitud.updateValoresSolicitud');
    Route::put('/solicitud-aprobada/{id}',          [SolicitudController::class, 'solicitudAprobada'])->name('solicitud.solicitudAprobada');
    Route::get('/amortizacion-all/{id}',            [SolicitudController::class, 'AmortizacionAll'])->name('solicitud.AmortizacionAll');
    Route::put('/realizar-pago/{id}',               [SolicitudController::class, 'realizarPago'])->name('solicitud.realizarPago');


    Route::get('/download-solicitud/{id}',          [SolicitudController::class, 'downloadSolicitud'])->name('solicitud.downloadSolicitud');
    Route::get('/download-pre/{id}',                [SolicitudController::class, 'downloadPre'])->name('solicitud.downloadPre');
    //

    // Creditos
    Route::post('/get-info-credito',                [CreditosController::class, 'show'])->name('credito.show');
    Route::post('/creditos-pagination',             [CreditosController::class, 'pagination'])->name('credito.pagination');
    Route::get('/comprobante/{id}',                 [CreditosController::class, 'getComprobante'])->name('credito.getComprobante');
    Route::get('/download-compro/{id}',             [CreditosController::class, 'downloadCompro'])->name('credito.downloadCompro');
    //

});


Route::get('/prueba', [PruebasController::class, 'test']);
Route::get('email/{correo}',          [PruebasController::class, 'enviarCorreo']);


Route::get('correo-prueba',          [PruebasController::class, 'correoPrueba']);

require __DIR__ . '/auth.php';
