<?php

namespace App\Http\Controllers\keller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientSaveRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Direccion;
use App\Models\IngresoEgresoCredito;
use App\Models\LineaCredito;
use App\Models\PatrimonioCredito;
use App\Models\ReferenciaCredito;
use App\Models\TarjetasCredito;
use App\Models\User;
use Inertia\Inertia;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        if (!hasPermissionModule('clients', 'read', 'clients')) {
            return to_route('dashboard');
        }

        $permissions = permissionModule('clients', '', true);
        $clients = $this->pagination($request);

        return Inertia::render('Keller/Clients/Index', [
            'permissions' => $permissions,
            'clients' => $clients,
        ]);
    }

    public $search_;

    public function pagination(Request $request, $pag = 25)
    {
        $entries = $pag;

        if ($request->show) $entries =  $request->show;

        $search         = $request->search      == "" ?  "" : $request->search;
        // $order_type     = $request->order_type  == "" ? "DESC" :$request->order_type;
        $order_type     = $request->order_type  == "" ? "ASC" : $request->order_type;
        $order_field    = $request->order_field == "" ? "id" : $request->order_field;

        if ($search == "") {
            $h = Client::select("*",);

            $h->orderBy($order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = Client::select("*",);

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    "company"
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
            'data' => $show
        ];
    }

    public function create($id)
    {
        return Inertia::render('Keller/Clients/Create', [
            'id' => $id
        ]);
    }

    public function store(ClientSaveRequest $request)
    {

        $user = '';
        if (isset($request->password)) {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 5
            ]);
        } else {
            $user = auth()->user();
        }

        // dd($user);

        $client = new Client();
        $client->users_id           = $user->id;
        $client->id_user_sap        = isset($request->id_user_sap) ? $request->id_user_sap : '';
        $client->id_prove_sap       = isset($request->id_prove_sap) ? $request->id_prove_sap : '';
        $client->nombre             = $request->nombre;
        $client->apellido           = isset($request->apellido) ? $request->apellido : '';
        $client->tipo_documento     = $request->tipo_documento;
        $client->documento          = $request->documento;
        $client->email              = $request->email;
        $client->estado_persona     = 'Activo';
        $client->indicador_persona  = 'En espara';

        $client->ciudad_solicitud       = isset($request->ciudad_solicitud) ? $request->ciudad_solicitud : '';
        $client->tipo_cliente           = isset($request->tipo_cliente) ? $request->tipo_cliente : '';
        $client->tipo_declarante        = isset($request->tipo_declarante) ? $request->tipo_declarante : '';
        $client->profesion              = isset($request->profesion) ? $request->profesion : '';
        $client->empresa_donde_labora   = isset($request->empresa_donde_labora) ? $request->empresa_donde_labora : '';
        $client->indicador              = isset($request->indicador) ? $request->indicador : '';
        $client->nombre_negocio         = isset($request->nombre_negocio) ? $request->nombre_negocio : '';
        $client->nombre_conyuge         = isset($request->nombre_conyuge) ? $request->nombre_conyuge : '';
        $client->empresa_conyuge        = isset($request->empresa_conyuge) ? $request->empresa_conyuge : '';
        $client->indicador_autorizacion = isset($request->indicador_autorizacion) ? $request->indicador_autorizacion : '';
        $client->domicilio              = isset($request->domicilio) ? $request->domicilio : '';
        $client->direccion_comercial    = isset($request->direccion_comercial) ? $request->direccion_comercial : '';
        $client->telefono_comercial     = isset($request->telefono_comercial) ? $request->telefono_comercial : '';
        $client->direccion_judicial     = isset($request->direccion_judicial) ? $request->direccion_judicial : '';
        $client->telefono_judicial      = isset($request->telefono_judicial) ? $request->telefono_judicial : '';
        $client->representante          = isset($request->representante) ? $request->representante : '';
        $client->representante_doc      = isset($request->representante_doc) ? $request->representante_doc : '';
        $client->autorretenedor         = isset($request->autorretenedor) ? $request->autorretenedor : '';
        $client->persona_pago           = isset($request->persona_pago) ? $request->persona_pago : '';
        $client->direccion_pago         = isset($request->direccion_pago) ? $request->direccion_pago : '';
        $client->telefono_pago          = isset($request->telefono_pago) ? $request->telefono_pago : '';
        $client->dia_pago               = isset($request->dia_pago) ? $request->dia_pago : '';
        $client->hora_pago              = isset($request->hora_pago) ? $request->hora_pago : '';
        $client->comentatio_pago        = isset($request->comentatio_pago) ? $request->comentatio_pago : '';
        $client->estado_civil           = isset($request->estado_civil) ? $request->estado_civil : '';
        $client->direccion_recidencia   = isset($request->direccion_recidencia) ? $request->direccion_recidencia : '';
        $client->telefono_recidencia    = isset($request->telefono_recidencia) ? $request->telefono_recidencia : '';
        $client->ciudad_recidencia      = isset($request->ciudad_recidencia) ? $request->ciudad_recidencia : '';
        $client->empresa                = isset($request->empresa) ? $request->empresa : '';
        $client->empresa_direccion      = isset($request->empresa_direccion) ? $request->empresa_direccion : '';
        $client->empresa_telefono       = isset($request->empresa_telefono) ? $request->empresa_telefono : '';
        $client->cargo_actual           = isset($request->cargo_actual) ? $request->cargo_actual : '';
        $client->antoguedad_empresa     = isset($request->antoguedad_empresa) ? $request->antoguedad_empresa : '';
        $client->personas_cargo         = isset($request->personas_cargo) ? $request->personas_cargo : '';
        $client->vivienda               = isset($request->vivienda) ? $request->vivienda : '';
        $client->independiente          = isset($request->independiente) ? $request->independiente : '';
        $client->camara_comercio        = isset($request->camara_comercio) ? $request->camara_comercio : '';
        $client->ocupacion_conyuge      = isset($request->ocupacion_conyuge) ? $request->ocupacion_conyuge : '';

        $client->role_id            = 5;

        $client->save();

        $ref = new ReferenciaCredito();
        $ref->clientes_id = $client->id;
        $ref->save();

        $linea = new LineaCredito();
        $linea->clientes_id = $client->id;
        $linea->save();

        $parimonio = new PatrimonioCredito();
        $parimonio->clientes_id = $client->id;
        $parimonio->save();

        $ingreso = new IngresoEgresoCredito();
        $ingreso->clientes_id = $client->id;
        $ingreso->save();

        $creditos = new TarjetasCredito();
        $creditos->clientes_id = $client->id;
        $creditos->save();

        return response()->json([
            'client' => $client,
            'items' => $client,
        ], 201);
    }

    public function saveClienteRef(Request $request, $id)
    {
        $ref = ReferenciaCredito::where('clientes_id', $id)->first();

        $ref->banco                 = isset($request->banco) ? $request->banco :  $ref->banco;
        $ref->sucursal              = isset($request->sucursal) ? $request->sucursal :  $ref->sucursal;
        $ref->banco_numero          = isset($request->banco_numero) ? $request->banco_numero :  $ref->banco_numero;
        $ref->banco_dos             = isset($request->banco_dos) ? $request->banco_dos :  $ref->banco_dos;
        $ref->sucursal_dos          = isset($request->sucursal_dos) ? $request->sucursal_dos :  $ref->sucursal_dos;
        $ref->banco_numero_dos      = isset($request->banco_numero_dos) ? $request->banco_numero_dos :  $ref->banco_numero_dos;
        $ref->nombre_comercal       = isset($request->nombre_comercal) ? $request->nombre_comercal :  $ref->nombre_comercal;
        $ref->direccion_comercal    = isset($request->direccion_comercal) ? $request->direccion_comercal :  $ref->direccion_comercal;
        $ref->telefono_comercal     = isset($request->telefono_comercal) ? $request->telefono_comercal :  $ref->telefono_comercal;
        $ref->nombre_comercal_dos   = isset($request->nombre_comercal_dos) ? $request->nombre_comercal_dos :  $ref->nombre_comercal_dos;
        $ref->direccion_comercal_dos = isset($request->direccion_comercal_dos) ? $request->direccion_comercal_dos :  $ref->direccion_comercal_dos;
        $ref->telefono_comercal_dos = isset($request->telefono_comercal_dos) ? $request->telefono_comercal_dos :  $ref->telefono_comercal_dos;
        $ref->nombre_familiar       = isset($request->nombre_familiar) ? $request->nombre_familiar :  $ref->nombre_familiar;
        $ref->direccion_familiar    = isset($request->direccion_familiar) ? $request->direccion_familiar :  $ref->direccion_familiar;
        $ref->telefono_familiar     = isset($request->telefono_familiar) ? $request->telefono_familiar :  $ref->telefono_familiar;
        $ref->nombre_familiar_dos   = isset($request->nombre_familiar_dos) ? $request->nombre_familiar_dos :  $ref->nombre_familiar_dos;
        $ref->direccion_familiar_dos = isset($request->direccion_familiar_dos) ? $request->direccion_familiar_dos :  $ref->direccion_familiar_dos;
        $ref->telefono_familiar_dos = isset($request->telefono_familiar_dos) ? $request->telefono_familiar_dos :  $ref->telefono_familiar_dos;

        $ref->save();

        return response()->json($ref, 201);
    }

    public function saveClienteLinea(Request $request, $id)
    {
        $linea = LineaCredito::where('clientes_id', $id)->first();
        $linea->tipo_credito          = isset($request->tipo_credito) ? $request->tipo_credito :  $linea->tipo_credito;
        $linea->oficina_credito       = isset($request->oficina_credito) ? $request->oficina_credito :  $linea->oficina_credito;
        $linea->vendedor_credito      = isset($request->vendedor_credito) ? $request->vendedor_credito :  $linea->vendedor_credito;
        $linea->monto_solicitado_credito = isset($request->monto_solicitado_credito) ? $request->monto_solicitado_credito :  $linea->monto_solicitado_credito;
        $linea->forma_pago_credito    = isset($request->forma_pago_credito) ? $request->forma_pago_credito :  $linea->forma_pago_credito;

        $linea->save();

        return response()->json($linea, 201);
    }

    public function saveClientePatri(Request $request, $id)
    {
        $parimonio = PatrimonioCredito::where('clientes_id', $id)->first();

        $parimonio->descripcion_bien      = isset($request->descripcion_bien) ? $request->descripcion_bien :  $parimonio->descripcion_bien;
        $parimonio->ciudad_bien           = isset($request->ciudad_bien) ? $request->ciudad_bien :  $parimonio->ciudad_bien;
        $parimonio->hipoteca_bien         = isset($request->hipoteca_bien) ? $request->hipoteca_bien :  $parimonio->hipoteca_bien;
        $parimonio->avaluo_comercial_bien = isset($request->avaluo_comercial_bien) ? $request->avaluo_comercial_bien :  $parimonio->avaluo_comercial_bien;
        $parimonio->avaluo_catastral_bien = isset($request->avaluo_catastral_bien) ? $request->avaluo_catastral_bien :  $parimonio->avaluo_catastral_bien;
        $parimonio->cedula_catastral_bien = isset($request->cedula_catastral_bien) ? $request->cedula_catastral_bien :  $parimonio->cedula_catastral_bien;
        $parimonio->matricula_bien        = isset($request->matricula_bien) ? $request->matricula_bien :  $parimonio->matricula_bien;
        $parimonio->escritura_bien        = isset($request->escritura_bien) ? $request->escritura_bien :  $parimonio->escritura_bien;
        $parimonio->notaria_bien          = isset($request->notaria_bien) ? $request->notaria_bien :  $parimonio->notaria_bien;
        $parimonio->fecha_bien            = isset($request->fecha_bien) ? $request->fecha_bien :  $parimonio->fecha_bien;
        $parimonio->ciudad_parimonio_bien = isset($request->ciudad_parimonio_bien) ? $request->ciudad_parimonio_bien :  $parimonio->ciudad_parimonio_bien;
        $parimonio->descripcion_bien_dos  = isset($request->descripcion_bien_dos) ? $request->descripcion_bien_dos :  $parimonio->descripcion_bien_dos;
        $parimonio->ciudad_bien_dos       = isset($request->ciudad_bien_dos) ? $request->ciudad_bien_dos :  $parimonio->ciudad_bien_dos;
        $parimonio->hipoteca_bien_dos     = isset($request->hipoteca_bien_dos) ? $request->hipoteca_bien_dos :  $parimonio->hipoteca_bien_dos;
        $parimonio->avaluo_comercial_bien_dos = isset($request->avaluo_comercial_bien_dos) ? $request->avaluo_comercial_bien_dos :  $parimonio->avaluo_comercial_bien_dos;
        $parimonio->avaluo_catastral_bien_dos = isset($request->avaluo_catastral_bien_dos) ? $request->avaluo_catastral_bien_dos :  $parimonio->avaluo_catastral_bien_dos;
        $parimonio->cedula_catastral_bien_dos = isset($request->cedula_catastral_bien_dos) ? $request->cedula_catastral_bien_dos :  $parimonio->cedula_catastral_bien_dos;
        $parimonio->matricula_bien_dos    = isset($request->matricula_bien_dos) ? $request->matricula_bien_dos :  $parimonio->matricula_bien_dos;
        $parimonio->escritura_bien_dos    = isset($request->escritura_bien_dos) ? $request->escritura_bien_dos :  $parimonio->escritura_bien_dos;
        $parimonio->notaria_bien_dos      = isset($request->notaria_bien_dos) ? $request->notaria_bien_dos :  $parimonio->notaria_bien_dos;
        $parimonio->fecha_bien_dos        = isset($request->fecha_bien_dos) ? $request->fecha_bien_dos :  $parimonio->fecha_bien_dos;
        $parimonio->ciudad_parimonio_bien_dos = isset($request->ciudad_parimonio_bien_dos) ? $request->ciudad_parimonio_bien_dos :  $parimonio->ciudad_parimonio_bien_dos;
        $parimonio->descripcion_bien_tres = isset($request->descripcion_bien_tres) ? $request->descripcion_bien_tres :  $parimonio->descripcion_bien_tres;
        $parimonio->ciudad_bien_tres      = isset($request->ciudad_bien_tres) ? $request->ciudad_bien_tres :  $parimonio->ciudad_bien_tres;
        $parimonio->hipoteca_bien_tres    = isset($request->hipoteca_bien_tres) ? $request->hipoteca_bien_tres :  $parimonio->hipoteca_bien_tres;
        $parimonio->avaluo_comercial_bien_tres = isset($request->avaluo_comercial_bien_tres) ? $request->avaluo_comercial_bien_tres :  $parimonio->avaluo_comercial_bien_tres;
        $parimonio->avaluo_catastral_bien_tres = isset($request->avaluo_catastral_bien_tres) ? $request->avaluo_catastral_bien_tres :  $parimonio->avaluo_catastral_bien_tres;
        $parimonio->cedula_catastral_bien_tres = isset($request->cedula_catastral_bien_tres) ? $request->cedula_catastral_bien_tres :  $parimonio->cedula_catastral_bien_tres;
        $parimonio->matricula_bien_tres   = isset($request->matricula_bien_tres) ? $request->matricula_bien_tres :  $parimonio->matricula_bien_tres;
        $parimonio->escritura_bien_tres   = isset($request->escritura_bien_tres) ? $request->escritura_bien_tres :  $parimonio->escritura_bien_tres;
        $parimonio->notaria_bien_tres     = isset($request->notaria_bien_tres) ? $request->notaria_bien_tres :  $parimonio->notaria_bien_tres;
        $parimonio->fecha_bien_tres       = isset($request->fecha_bien_tres) ? $request->fecha_bien_tres :  $parimonio->fecha_bien_tres;
        $parimonio->ciudad_parimonio_bien_tres = isset($request->ciudad_parimonio_bien_tres) ? $request->ciudad_parimonio_bien_tres :  $parimonio->ciudad_parimonio_bien_tres;
        $parimonio->marca_vehiculo        = isset($request->marca_vehiculo) ? $request->marca_vehiculo :  $parimonio->marca_vehiculo;
        $parimonio->clase_vehiculo        = isset($request->clase_vehiculo) ? $request->clase_vehiculo :  $parimonio->clase_vehiculo;
        $parimonio->modelo_vehiculo       = isset($request->modelo_vehiculo) ? $request->modelo_vehiculo :  $parimonio->modelo_vehiculo;
        $parimonio->placa_vehiculo        = isset($request->placa_vehiculo) ? $request->placa_vehiculo :  $parimonio->placa_vehiculo;
        $parimonio->valor_vehiculo        = isset($request->valor_vehiculo) ? $request->valor_vehiculo :  $parimonio->valor_vehiculo;
        $parimonio->hipoteca_vehiculo     = isset($request->hipoteca_vehiculo) ? $request->hipoteca_vehiculo :  $parimonio->hipoteca_vehiculo;
        $parimonio->marca_vehiculo_dos    = isset($request->marca_vehiculo_dos) ? $request->marca_vehiculo_dos :  $parimonio->marca_vehiculo_dos;
        $parimonio->clase_vehiculo_dos    = isset($request->clase_vehiculo_dos) ? $request->clase_vehiculo_dos :  $parimonio->clase_vehiculo_dos;
        $parimonio->modelo_vehiculo_dos   = isset($request->modelo_vehiculo_dos) ? $request->modelo_vehiculo_dos :  $parimonio->modelo_vehiculo_dos;
        $parimonio->placa_vehiculo_dos    = isset($request->placa_vehiculo_dos) ? $request->placa_vehiculo_dos :  $parimonio->placa_vehiculo_dos;
        $parimonio->valor_vehiculo_dos    = isset($request->valor_vehiculo_dos) ? $request->valor_vehiculo_dos :  $parimonio->valor_vehiculo_dos;
        $parimonio->hipoteca_vehiculo_dos = isset($request->hipoteca_vehiculo_dos) ? $request->hipoteca_vehiculo_dos :  $parimonio->hipoteca_vehiculo_dos;

        $parimonio->save();

        return response()->json($parimonio, 201);
    }

    public function saveClienteIngre(Request $request, $id)
    {
        $ingreso = IngresoEgresoCredito::where('clientes_id', $id)->first();

        $ingreso->salario               = isset($request->salario) ? $request->salario :  $ingreso->salario;
        $ingreso->honorarios            = isset($request->honorarios) ? $request->honorarios :  $ingreso->honorarios;
        $ingreso->otros_ingresos        = isset($request->otros_ingresos) ? $request->otros_ingresos :  $ingreso->otros_ingresos;
        $ingreso->otros_ingresos_describe = isset($request->otros_ingresos_describe) ? $request->otros_ingresos_describe :  $ingreso->otros_ingresos_describe;
        $ingreso->total_ingresos        = isset($request->total_ingresos) ? $request->total_ingresos :  $ingreso->total_ingresos;
        $ingreso->alquiler              = isset($request->alquiler) ? $request->alquiler :  $ingreso->alquiler;
        $ingreso->amortizacion          = isset($request->amortizacion) ? $request->amortizacion :  $ingreso->amortizacion;
        $ingreso->amortizacion_hipoteca = isset($request->amortizacion_hipoteca) ? $request->amortizacion_hipoteca :  $ingreso->amortizacion_hipoteca;
        $ingreso->pago_tarjetas         = isset($request->pago_tarjetas) ? $request->pago_tarjetas :  $ingreso->pago_tarjetas;
        $ingreso->otros_gastos          = isset($request->otros_gastos) ? $request->otros_gastos :  $ingreso->otros_gastos;
        $ingreso->total_egresos         = isset($request->total_egresos) ? $request->total_egresos :  $ingreso->total_egresos;

        $ingreso->save();

        return response()->json($ingreso, 201);
    }

    public function saveClienteTarjeta(Request $request, $id)
    {
        $creditos = TarjetasCredito::where('clientes_id', $id)->first();

        $creditos->acreedor              = isset($request->acreedor) ? $request->acreedor :  $creditos->acreedor;
        $creditos->acreedor_dos          = isset($request->acreedor_dos) ? $request->acreedor_dos :  $creditos->acreedor_dos;
        $creditos->acreedor_telefono     = isset($request->acreedor_telefono) ? $request->acreedor_telefono :  $creditos->acreedor_telefono;
        $creditos->acreedor_telefono_dos = isset($request->acreedor_telefono_dos) ? $request->acreedor_telefono_dos :  $creditos->acreedor_telefono_dos;
        $creditos->acreedor_valor        = isset($request->acreedor_valor) ? $request->acreedor_valor :  $creditos->acreedor_valor;
        $creditos->acreedor_valor_dos    = isset($request->acreedor_valor_dos) ? $request->acreedor_valor_dos :  $creditos->acreedor_valor_dos;
        $creditos->acreedor_saldo        = isset($request->acreedor_saldo) ? $request->acreedor_saldo :  $creditos->acreedor_saldo;
        $creditos->acreedor_saldo_dos    = isset($request->acreedor_saldo_dos) ? $request->acreedor_saldo_dos :  $creditos->acreedor_saldo_dos;
        $creditos->banco_tarjeta         = isset($request->banco_tarjeta) ? $request->banco_tarjeta :  $creditos->banco_tarjeta;
        $creditos->banco_tarjeta_dos     = isset($request->banco_tarjeta_dos) ? $request->banco_tarjeta_dos :  $creditos->banco_tarjeta_dos;
        $creditos->banco_antoguedad      = isset($request->banco_antoguedad) ? $request->banco_antoguedad :  $creditos->banco_antoguedad;
        $creditos->banco_antoguedad_dos  = isset($request->banco_antoguedad_dos) ? $request->banco_antoguedad_dos :  $creditos->banco_antoguedad_dos;
        $creditos->banco_numero_antoguedad = isset($request->banco_numero_antoguedad) ? $request->banco_numero_antoguedad :  $creditos->banco_numero_antoguedad;
        $creditos->banco_numero_antoguedad_dos = isset($request->banco_numero_antoguedad_dos) ? $request->banco_numero_antoguedad_dos :  $creditos->banco_numero_antoguedad_dos;
        $creditos->banco_cupo            = isset($request->banco_cupo) ? $request->banco_cupo :  $creditos->banco_cupo;
        $creditos->banco_cupo_dos        = isset($request->banco_cupo_dos) ? $request->banco_cupo_dos :  $creditos->banco_cupo_dos;

        $creditos->save();

        return response()->json($creditos, 201);
    }

    public function show(Client $client)
    {
        if (!hasPermissionModule('clients', 'read', 'clients')) {
            return to_route('dashboard');
        }

        $permissions = permissionModule('clients', '', true);

        $direcciones = Direccion::where('clients_id', $client->id)->get();

        return Inertia::render('Keller/Clients/Details', [
            'permissions' => $permissions,
            'client' => $client,
            'direcciones' => $direcciones,
        ]);
    }

    public function getInfoClient($id)
    {
        $client = Client::find($id);
        return response()->json($client, 200);
    }

    public function getInfoClienteRef($id)
    {
        $ref = ReferenciaCredito::where('clientes_id', $id)->first();
        return response()->json($ref, 200);
    }

    public function getInfoClienteLinea($id)
    {
        $linea = LineaCredito::where('clientes_id', $id)->first();
        return response()->json($linea, 200);
    }

    public function getInfoClientePatri($id)
    {
        $parimonio = PatrimonioCredito::where('clientes_id', $id)->first();
        return response()->json($parimonio, 200);
    }

    public function getInfoClienteIngre($id)
    {
        $ingreso = IngresoEgresoCredito::where('clientes_id', $id)->first();
        return response()->json($ingreso, 200);
    }

    public function getInfoClienteTarjeta($id)
    {
        $creditos = TarjetasCredito::where('clientes_id', $id)->first();
        return response()->json($creditos, 200);
    }

    public function update(Request $request, Client $client)
    {
        if (!hasPermissionModule('clients', 'update', 'clients')) {
            return to_route('dashboard');
        }

        if (isset($request->password)) {
            $user = User::find($client->users_id)->update([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }

        $client->id_user_sap        = isset($request->id_user_sap) ? $request->id_user_sap : '';
        $client->id_prove_sap       = isset($request->id_prove_sap) ? $request->id_prove_sap : '';
        $client->nombre             = $request->nombre;
        $client->apellido           = isset($request->apellido) ? $request->apellido : '';
        $client->tipo_documento     = $request->tipo_documento;
        $client->documento          = $request->documento;
        $client->email              = $request->email;

        $client->ciudad_solicitud       = isset($request->ciudad_solicitud) ? $request->ciudad_solicitud : '';
        $client->tipo_cliente           = isset($request->tipo_cliente) ? $request->tipo_cliente : '';
        $client->tipo_declarante        = isset($request->tipo_declarante) ? $request->tipo_declarante : '';
        $client->profesion              = isset($request->profesion) ? $request->profesion : '';
        $client->empresa_donde_labora   = isset($request->empresa_donde_labora) ? $request->empresa_donde_labora : '';
        $client->indicador              = isset($request->indicador) ? $request->indicador : '';
        $client->nombre_negocio         = isset($request->nombre_negocio) ? $request->nombre_negocio : '';
        $client->nombre_conyuge         = isset($request->nombre_conyuge) ? $request->nombre_conyuge : '';
        $client->empresa_conyuge        = isset($request->empresa_conyuge) ? $request->empresa_conyuge : '';
        $client->indicador_autorizacion = isset($request->indicador_autorizacion) ? $request->indicador_autorizacion : '';
        $client->domicilio              = isset($request->domicilio) ? $request->domicilio : '';
        $client->direccion_comercial    = isset($request->direccion_comercial) ? $request->direccion_comercial : '';
        $client->telefono_comercial     = isset($request->telefono_comercial) ? $request->telefono_comercial : '';
        $client->direccion_judicial     = isset($request->direccion_judicial) ? $request->direccion_judicial : '';
        $client->telefono_judicial      = isset($request->telefono_judicial) ? $request->telefono_judicial : '';
        $client->representante          = isset($request->representante) ? $request->representante : '';
        $client->representante_doc      = isset($request->representante_doc) ? $request->representante_doc : '';
        $client->autorretenedor         = isset($request->autorretenedor) ? $request->autorretenedor : '';
        $client->persona_pago           = isset($request->persona_pago) ? $request->persona_pago : '';
        $client->direccion_pago         = isset($request->direccion_pago) ? $request->direccion_pago : '';
        $client->telefono_pago          = isset($request->telefono_pago) ? $request->telefono_pago : '';
        $client->dia_pago               = isset($request->dia_pago) ? $request->dia_pago : '';
        $client->hora_pago              = isset($request->hora_pago) ? $request->hora_pago : '';
        $client->comentatio_pago        = isset($request->comentatio_pago) ? $request->comentatio_pago : '';
        $client->estado_civil           = isset($request->estado_civil) ? $request->estado_civil : '';
        $client->direccion_recidencia   = isset($request->direccion_recidencia) ? $request->direccion_recidencia : '';
        $client->telefono_recidencia    = isset($request->telefono_recidencia) ? $request->telefono_recidencia : '';
        $client->ciudad_recidencia      = isset($request->ciudad_recidencia) ? $request->ciudad_recidencia : '';
        $client->empresa                = isset($request->empresa) ? $request->empresa : '';
        $client->empresa_direccion      = isset($request->empresa_direccion) ? $request->empresa_direccion : '';
        $client->empresa_telefono       = isset($request->empresa_telefono) ? $request->empresa_telefono : '';
        $client->cargo_actual           = isset($request->cargo_actual) ? $request->cargo_actual : '';
        $client->antoguedad_empresa     = isset($request->antoguedad_empresa) ? $request->antoguedad_empresa : '';
        $client->personas_cargo         = isset($request->personas_cargo) ? $request->personas_cargo : '';
        $client->vivienda               = isset($request->vivienda) ? $request->vivienda : '';
        $client->independiente          = isset($request->independiente) ? $request->independiente : '';
        $client->camara_comercio        = isset($request->camara_comercio) ? $request->camara_comercio : '';
        $client->ocupacion_conyuge      = isset($request->ocupacion_conyuge) ? $request->ocupacion_conyuge : '';

        $client->save();

        $client->save();

        return response()->json([
            "status"    => true,
            "data"      => $client
        ], 200);
    }

    public function destroy(Client $client)
    {
        if (!hasPermissionModule('clients', 'delete', 'clients')) {
            return response()->json([
                'msg'   => 'Sin permisos.',
                'state' => 'error',
                'data'  => []
            ]);
        }

        $client->delete();

        return response()->json([
            "status" => true,
            "msj"   => "Eliminado con exito"
        ]);
    }

    public function passwordUpdate(Request $request)
    {
        $client = Client::where('users_id', $request->id)->first();

        User::find($request->id)->update([
            'password' => Hash::make($client->documento),
        ]);

        return response()->json('Restaurado con exito', 200);
    }

    public function getClients()
    {
        $clients = Client::all('id', 'nombre', 'documento');
        return response()->json($clients, 200);
    }
}
