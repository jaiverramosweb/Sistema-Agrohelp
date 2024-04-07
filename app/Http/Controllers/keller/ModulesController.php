<?php

namespace App\Http\Controllers\keller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ModulesController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    if ( !hasPermissionModule( 'modules' , 'read' , 'config' ) ) {  return to_route('dashboard');  }
    $permissions = permissionModule( 'modules' , '' , true );

    return Inertia::render('Keller/Config/Modules/Modules' , [
      'permissions' => $permissions
    ]);
  }

  /**
   * Display a listing of the resource.
  */
  public function list()
  {


    $modules = DB::table('modules')
    ->orderBy( 'id' , 'asc' )
    ->get();

    foreach ( $modules as $key )
    {
      $mod = DB::table('modules')
      ->where( 'route' , $key->module_group )
      ->first();

      if ( $mod )
      {
        $key->main_module = $mod->name;
      }else{
        $key->main_module = 'NN';
      }

    }
    
    return $modules;
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
    // dd($request->all());

    $data = [ 

      "group" => $request->group,
      "jerarquia" => $request->jerarquia,
      "module_permissions" => $request->module_permissions,
      "module_group" => $request->module_group == '' ? '0' : $request->module_group ,
      "name" => $request->name,
      "icon" => $request->icon,
      "route" => $request->route,

    ];
    $result = DB::table('modules')->where( 'id' , $id )
    ->update($data);
    
    return response()->json([
      'msg'   => 'Recurso actualizado correctamente.',
      'state' => 'ok',
      'data'  => $result,
    ]);

  }

  /**
   * Update the specified resource in storage.
   */
  public function change( string $id )
  {

    $modulo = DB::table('modules')->find( $id );

    if ( $modulo )
    {
      $val = $modulo->active ? false : true;
      $result = DB::table('modules')->where( 'id' , $id )
      ->update([
        'active' => $val ,
      ]);
    }else{

      return response()->json([
        'msg'   => 'Error.',
        'state' => 'error',
        'data'  => $modulo,
      ]);
    }

    return response()->json([
      'msg'   => 'Recurso actualizado correctamente.',
      'state' => 'ok',
      'data'  => $result,
    ]);
  }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      //
    }




    static function userModules()
    {
      $modules = DB::table('modules')
      ->where( 'module_group' , '=' , '0' )
      ->orderBy( 'jerarquia' , 'ASC' )
      ->get();

      $permisos = PermissionsController::permissionsRole(  Auth::user()->role_id  );
      $modules_user = array();

      foreach ( $modules as $key )
      {
        $test = self::validatePermission( $permisos , 'module' , $key->module_permissions );
        
        if ( $test->read == true && $key->active )
        {
          if ( $key->group )
          {
              $sub_modules = DB::table('modules')
              ->where( 'module_group' , '=' , $key->route )
              ->orderBy( 'jerarquia' , 'ASC' )
              ->get();
              
              $sub_modules_user = array();
              foreach ( $sub_modules as $key_ )
              {
                $sub_ = self::validatePermission( $permisos , 'module' , $key_->module_permissions );
                if ( $sub_->read == true && $key_->active )
                { 
                  $sub_modules_user[] = $key_;
                }
              }

              $key->items = $sub_modules_user;
          }

          $modules_user[] = $key;
        }
          
      }
      
      return $modules_user;
    }

    static function validatePermission( $array , $key , $word )
    {
      $obj = new \stdClass();
      $found_key = array_search( $word , array_column( $array->toArray() , $key ) );
      if ( $found_key === false )
      {
          $obj->read = false;
          $obj->test = $word;
          return $obj;
      }
      $obj = $array[ $found_key ];
      return $obj;
    }
}
