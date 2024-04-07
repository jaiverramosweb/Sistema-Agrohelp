<?php

namespace App\Http\Controllers\keller;

use App\Http\Controllers\Controller;
use App\Models\Keller\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
  public $search_;

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    if (!hasPermissionModule('users', 'read', 'users')) {
      return to_route('dashboard');
    }
    $permissions = permissionModule('users', '', true);
    $users = $this->pagination($request);
    return Inertia::render('Keller/Users/Users', [
      'permissions' => $permissions,
      'users' => $users,
    ]);
  }

  public function pagination(Request $request)
  {

    $entries = $request->show;

    $search         = $request->search      == "" ?  "" : $request->search;
    $order_type     = $request->order_type  == "" ? "DESC" : $request->order_type;
    $order_field    = $request->order_field == "" ? "users.id" : $request->order_field;

    if ($search == "") {
      $h = User::select(
        "users.id",
        "users.email",
        "roles.name",

      )
        ->join("roles", "users.role_id", "=", "roles.id");

      $user_auth = Auth::user();
      if ($user_auth->role_id != 1) {
        $h->where('roles.id', '<>', 1);
      }


      $h->orderBy($order_field, $order_type);
      $show = $h->paginate($request->show);
    } else {

      $h =  User::select(
        "users.id",
        "users.email",
        "roles.name",
      )
        ->join("roles", "users.role_id", "=", "roles.id")
        ->orderBy($order_field, $order_type);

      $this->search_ = $search;

      $h->where(function ($query) {

        $campos = [
          "users.nombre",
          "users.apellido",
          "users.tipo_documento",
          "users.documento",
          "users.email",
          "roles.name"
        ];

        for ($i = 0; $i < count($campos); $i++) {
          $query->orWhere($campos[$i], "ilike", "%" . $this->search_ . "%");
        }
      });

      $show = $h->paginate($entries);
    }




    return [
      'pagination' => [
        'total'         => $show->total(),
        'current_page'  => $show->currentPage(),
        'per_page'      => $show->perPage(),
        'last_page'     => $show->lastPage(),
        'from'          => $show->firstItem(),
        'to'            => $show->lastPage()
      ],
      'data' => $show,
    ];
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    if (!hasPermissionModule('users', 'create', 'users')) {
      return to_route('dashboard');
    }

    $roles = Role::all()
      ->where('id', '<>', 1);
    $custom_fields = CustomFieldsController::customFields('users');

    // dd( $custom_fields);

    return Inertia::render('Keller/Users/UserForm', [
      'roles' => $roles,
      'scf' => $custom_fields,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'email'        => ['required'],
      'password'     => ['required'],
    ]);

    $user = new User;
    $user->email      =  $request->email;
    $user->password   =  Hash::make($request->password);
    $user->role_id    =  5;
    $user->save();

    return response()->json([
      'msg'   => 'Recurso creado correctamente.',
      'state' => 'ok',
      'data'  => $user
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $user = User::find($id);
    $custom_fields = CustomFieldsController::customFields('users');

    return Inertia::render('Keller/Users/UserDetails', [
      'user' => $user,
      'scf' => $custom_fields,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    // dd(hasPermissionModule( 'users', 'update', 'users'));
    if (!hasPermissionModule('users', 'update', 'users')) {
      return to_route('dashboard');
    }

    $user = User::find($id);

    $roles = Role::all()
      ->where('id', '<>', 1);

    $custom_fields = CustomFieldsController::customFields('users');

    return Inertia::render('Keller/Users/UserForm', [
      'user' => $user,
      'roles' => $roles,
      'scf' => $custom_fields,
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {

    if (!hasPermissionModule('users', 'update', 'users')) {
      return to_route('dashboard');
    }

    $request->validate([
      'nombre'        => ['required', 'max:100'],
      'documento'     => ['required', 'max:260'],
    ]);

    $data = $request->all();

    if (isset($data['scf'])) {
      # code...
      $data['campos_personalizados'] = json_encode($data['scf']);
    }


    $user = User::find($id)
      ->update($data);

    return response()->json([
      'msg'   => 'Recurso actualizado correctamente.',
      'state' => 'ok',
      'data'  => $user
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    if (!hasPermissionModule('users', 'delete', 'users')) {
      return response()->json([
        'msg'   => 'Sin permisos.',
        'state' => 'error',
        'data'  => []
      ]);
    }

    $role = User::find($id);
    $role->delete();

    return response()->json([
      'msg'   => 'Recurso borrado correctamente.',
      'state' => 'ok',
      'data'  => $role
    ]);
  }
}
