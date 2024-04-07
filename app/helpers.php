<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

  function perfil()
  {
    $user__perfiles_id = Illuminate\Support\Facades\Session::get('user__perfiles_id');

    $perfil = Illuminate\Support\Facades\DB::select("SELECT * FROM user__perfiles WHERE id = $user__perfiles_id")[0]->perfil;

    return $perfil;
  }



  function hasPermissionModule( $module = "" , $type = "read" , $mod = "" )
  {
    $module_ = DB::table('modules')
    ->where( 'module_group' , '0' )
    ->where( 'module_permissions' , $mod )
    ->get();
    $mod = count($module_) > 0 ? $module_[0]->active : false;

    // dd($module_);

    if ( $mod )
    {
      $type = "role_permission.".$type; 
  
      $permission = DB::table('role_permission')
        ->select( 'role_permission.*', 'permissions.name',  'permissions.module',  )
        ->where( $type , '=' , true )
        ->where( 'fk_role_id' , '=' , Auth::user()->role_id )
        ->where( 'permissions.module', $module )
        ->join( 'permissions' , 'role_permission.fk_permission_id' , 'permissions.id' );
  
      $permission = $permission->get();

      
      if ( count( $permission ) === 0 )
      {
        return false;
      }
      
      // dd($permission);
      return true;
    }

    // dd('entre aqui');

    return false;
  }

  function permissionModule( $module = "" )
  {
    
    $permission = DB::table('role_permission')
    ->select( 'role_permission.read' , 'role_permission.create' , 'role_permission.update' , 'role_permission.delete' )
    ->where( 'fk_role_id' , '=' , Auth::user()->role_id )
    ->where( 'permissions.module' , '=' , $module )
    ->join( 'permissions' , 'role_permission.fk_permission_id' , 'permissions.id' );

    $permission = $permission->get();
    
    if ( count($permission) )
    {
      return $permission[0];
    }
    
    return [
      "read" => false,
      "create" => false,
      "update" => false,
      "detele" => false,
    ];
    
  }

  function validateSession()
  {
    $usuario = User::find(auth()->user()->id);
    $session = $usuario->session;
    $actual  = Session::get('session');

    if($actual == $session)
    {
      $show = array("type" => "success", "session" => $session, "actual" =>$actual);
    }
    else
    {
      Auth::logout();
      Session::flush();
      $show = array("type" => "error", "session" => $session, "actual" =>$actual);
    }

    return $show;
  }

?>