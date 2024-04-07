<?php

namespace App\Http\Controllers\keller;

use App\Http\Controllers\Controller;
use App\Models\Keller\CustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CustomFieldsController extends Controller
{
  public $search_;

  /**
   * Display a listing of the resource.
   */
  public function index( Request $request )
  {
    if ( !hasPermissionModule( 'custom_fields' , 'read' , 'config' ) ) {  return to_route('dashboard');  }
    $permissions = permissionModule( 'custom_fields' );
    $custom_fields = $this->pagination( $request );

    $forms = DB::table('form_entities')
    ->get();
    
    return Inertia::render('Keller/Config/CustomFields/CustomFields', [
      'permissions' => $permissions,
      'custom_fields' => $custom_fields,
      'forms' => $forms,
    ]);
  }

  public function pagination(Request $request)
  {

    $entries = $request->show;
    
    $search         = $request->search      == "" ?  "" : $request->search;
    $order_type     = $request->order_type  == "" ? "DESC" :$request->order_type;
    $order_field    = $request->order_field == "" ? "custom_fields.id" : $request->order_field;

    if( $search == "" )
    {
      $h = CustomField::select( 'custom_fields.*', 'form_entities.name as form_name' )
      ->orderBy( $order_field , $order_type )
      ->join( 'form_entities' , 'custom_fields.fk_form_id' , 'form_entities.id' );
      $show = $h->paginate( $request->show );
    }
    else
    {

      $h =  CustomField::select( 'custom_fields.*', 'form_entities.name as form_name' )
      ->orderBy( $order_field , $order_type )
      ->join( 'form_entities' , 'custom_fields.fk_form_id' , 'form_entities.id' );

      $this->search_ = $search;
      $h->where( function( $query ){
        
        $campos = [
          "custom_fields.nombre",
          "custom_fields.apellido",
          "custom_fields.tipo_documento",
          "custom_fields.documento",
          "custom_fields.email", 
          "roles.name"
        ];
        
        for($i=0; $i <count($campos) ; $i++)
        {
          $query->orWhere( $campos[$i] , "ilike", "%".$this->search_."%" );
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
      //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
    $request->validate([
      'name'        => ['required', 'max:100'],
      // 'description' => ['required', 'max:260'],
    ]);

    $data = $request->all();
    $data[ 'type_field' ] = 'dynamic';

    $field = CustomField::create( $data );

    return response()->json([
      'msg'   => 'Recurso creado correctamente.',
      'state' => 'ok',
      'data'  => $field
    ]);
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
    $request->validate([
      'name'        => ['required', 'max:100'],
      // 'description' => ['required', 'max:260'],
    ]);

    $data = $request->all();

    $field = CustomField::find( $id )
    ->update( $data );

    return response()->json([
      'msg'   => 'Recurso actualizado correctamente.',
      'state' => 'ok',
      'data'  => $field
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
      //
  }





  static function customFields( $form )
  {
    $form = DB::table('form_entities')
    ->where( 'key' , $form  )
    ->select('id')
    ->first();
    $form_id = $form ? $form->id : 0;

    $fields_statics = DB::table('custom_fields')
    ->where( 'fk_form_id' , $form_id )
    ->where( 'type_field' , 'static' )
    ->orderBy( 'jerarquia' , "asc")
    ->get();
    
    $fields_statics_ = array();
    foreach ( $fields_statics as $key )
    {
      $fields_statics_[ $key->name ] = $key;
    }

    $fields_dynamics = DB::table('custom_fields')
    ->where( 'fk_form_id' , $form_id )
    ->where( 'type_field' , '=' , 'dynamic' )
    ->orderBy( 'jerarquia' , "asc")
    ->get();
    $fields_dynamics_ = array();
    foreach ( $fields_dynamics as $key )
    {
      $fields_dynamics_[ $key->name ] = $key;
    }

    $data = [
      "title" => "Campos personalizados",
      "fields" => [
        "static"  => $fields_statics_,
        "dynamic" => $fields_dynamics
      ]
    ];

    return $data;
  }

  function ordenarArrayAsociativo($array, $elemento)
  {
    uasort( $array , function( $a , $b ) use ($elemento)
    {
      return $a[$elemento] - $b[$elemento];
    });
    
    return $array;
  }

}
