<?php

namespace App\Http\Controllers\keller;

use App\Http\Controllers\Controller;
use App\Mail\CorreoPrueba;
use App\Mail\Test;
use Illuminate\Http\Request;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PruebasController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
      //
      if ( !hasPermissionModule( 'pruebas' , 'read' , 'pruebas' ) ) {  return to_route('dashboard');  }

      return Inertia::render('Keller/Pruebas/PruebasJohann', [
          'canLogin' => Route::has('login'),
          'canRegister' => Route::has('register'),
          'laravelVersion' => Application::VERSION,
          'phpVersion' => PHP_VERSION,
      ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
      //
  }

  function test( Request $request )
  {
      // $data = $request->user()->id;
      $data = ModulesController::userModules();

      // $data = hasPermissionModule( "pruebas" , 'update' , true ) ;

      dd( $data );

      // return $data;
  }


  function enviarCorreo( $correo )
  {
    if ($correo != '' )
    {

      // dd($correo);
        try {

            // $resultado = Mail::to( ['jramirez@wolke.com.co'] )->send( new Test() );

            $data = [
                "email" => "jramirez@wolke.com.co",
                "name" => "Test NAME",
                "dob" => "12/12/1990"
            ];

            $correo = Mail::send( 'emails.orders.shipped' , $data , function ($message) use ($data) {
                $message->from('pruebas@profesordev.com', 'System Manager');
                $message->to( $data['email'] );
            });

        } catch (\Throwable $exception) {
            Log::error( $exception );
            dd($exception);
        }



    }else{
      dd( 'enviarCorreo' , $correo);
    }

    // dd( 'enviarCorreo 7777' , $correo);

    
    return $correo;
  }






  function correoPrueba()
  {

    $data = [
        "order_id" => 1 ,
        "order" => 1,
    ];

    
    $test = Mail::to( "johann.devfull@gmail.com" )->send( new CorreoPrueba( $data ));
    
    dd( $test , $data );
    return;

    return $test ;
  }


}
