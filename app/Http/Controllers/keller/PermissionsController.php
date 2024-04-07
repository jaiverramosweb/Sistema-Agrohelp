<?php

namespace App\Http\Controllers\keller;

use App\Http\Controllers\Controller;
use App\Models\Keller\Permission;
use App\Models\Keller\Role;
use App\Models\Keller\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PermissionsController extends Controller
{
  
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $user_auth = Auth::user();
    if ( $user_auth->role_id != 1 ){
      $roles = Role::where( 'id' , '<>' , 1 )
      ->get();
    } else {
      $roles = Role::all();
    }
    

    return Inertia::render('Keller/Permissions/Permissions', [
      'roles' => $roles,
    ]);
  }

  /**
   * Display a listing of the resource.
  */
  public function list()
  {

    $user_auth = Auth::user();
    if ( $user_auth->role_id != 1 ){
      $roles = Role::where( 'id' , '<>' , 1 )
      ->get();
    } else {
      $roles = Role::all();
    }
    return $roles;
  }

  /**
   * Almacena un rol creado
   */
  public function store(Request $request)
  {
    $role = Role::create($request->validate([
      'name'        => ['required', 'max:100'],
      'description' => ['required', 'max:260'],
    ]));

    return response()->json([
      'msg'   => 'Recurso creado correctamente.',
      'state' => 'ok',
      'data'  => $role
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $role = Role::find( $id );
    
    $role_permissions = RolePermission::where( 'fk_role_id' , $id )
    ->join( 'permissions' , 'role_permission.fk_permission_id' , 'permissions.id' )
    ->get();

    $permissions = Permission::all();

    return Inertia::render('Keller/Permissions/RolePermissions', [
      'role'              => $role,
      'permissions'       => $permissions,
      'role_permissions'  => $role_permissions,
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $role = Role::where( 'id' , '=', $id )
    ->update($request->validate([
      'name'        => ['required', 'max:100'],
      // 'description' => ['required', 'max:260'],
    ]));

    return response()->json([
      'msg'   => 'Recurso actualizado correctamente.',
      'state' => 'ok',
      'data'  => $role
    ]);
  }

  function changePermissions( Request $request, string $id )
  {

    $field = $request->field ;
    $permission_ = Permission::where( 'module' , $request->permissions )->get()[0];

    $permission = RolePermission::where( 'fk_role_id' , $id )
    ->where( 'fk_permission_id' , $permission_->id )
    ->first();

    // dd($permission->fk_role_id);

    if ( $permission )
    {

      RolePermission::where( 'fk_role_id' , $id )
      ->where( 'fk_permission_id' , $permission->id )
      ->get();

      
      $val = $permission[ $field ] ? false : true;

      // dd( $id , $permission_->id , $permission->id );

      if($field == 'all'){

        if($permission->create){
          $val = false;
        } else {
          $val = true;
        }
        
        $result = RolePermission::find( $permission->id  )
        ->update([
          "create" => $val ,
          "update" => $val ,
          "read" => $val ,
          "delete" => $val ,
        ]);
        
      }

      $result = RolePermission::find( $permission->id  )
      ->update([
        $field => $val ,
      ]);
    }else{

      RolePermission::create([
        'fk_role_id' => $id,
        'fk_permission_id' => $permission_->id,
        $field => true,
      ]);
      
    }

    $role_permissions = RolePermission::where( 'fk_role_id' , $permission->fk_role_id )
    ->join( 'permissions' , 'role_permission.fk_permission_id' , 'permissions.id' )
    ->get();

    return response()->json([
      'msg'   => 'Recurso permiso actualizado correctamente.',
      'state' => 'ok',
      'data'  => $role_permissions,
    ]);
    
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    
    $role = Role::find( $id );
    $role->delete();
    
    return response()->json([
      'msg'   => 'Recurso borrado correctamente.',
      'state' => 'ok',
      'data'  => $role
    ]);
  }




  static function permissionsRole( $role )
  {
    $permissions = DB::table('role_permission')
    ->select( 
      'role_permission.*',
      'permissions.name',
      'permissions.module',
    )
    ->where( 'fk_role_id' , '=' , $role )
    ->join( 'permissions' , 'role_permission.fk_permission_id' , 'permissions.id' )
    ->get();
    return $permissions;
  }

}
