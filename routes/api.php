<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {


    return $request->user();
});

Route::post('/don-pago/{accion?}', function ( Request $request , $accion ) {

    $data = [
        'status'    => 'ok',
        'message'   => 'Peticion API con exito.',
        'action'    => $accion,
        'data'      => $request->all(),
        'response'  => 200
    ];
    
    return json_encode( $data );

 });

 Route::post('/don-pago/{accion?}/{accion2?}', function ( Request $request , $accion, $accion2 ) {

    $data =  [
        'email' => fake()->unique()->safeEmail(),
        
        'name1' => explode(" ", fake()->name() )[1],
        'name2' => explode(" ", fake()->name() )[1],
        'lastname1' => explode(" ", fake()->name() )[1],
        'lastname2' => explode(" ", fake()->name() )[1],
        
        'tipo_doc' => 1,
        'documento' => Str::random(10),
        
        'msg' => Str::random(10),
        'inicio_vig' => now(),
        'fin_vig' => now(),
        'valor_poliza' => rand(100000, 1000000),

        'plates' => $request->placa,
        'dpto' => fake()->state(),
        'mcp' => fake()->city(),
        'address' => fake()->address(),
        'total_pagar' => 0,

    ];

    $data['total_pagar'] = $data['valor_poliza'];

    $data = [
        'status'    => 'ok',
        'message'   => 'Peticion API con exito.',
        'action'    => $accion,
        'data'      => $data,
        'response'  => 200
    ];
    
    return json_encode( $data );

 });
