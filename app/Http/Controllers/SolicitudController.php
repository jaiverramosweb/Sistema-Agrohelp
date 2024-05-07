<?php

namespace App\Http\Controllers;

use App\Models\CaracteristicasProducto;
use App\Models\Client;
use App\Models\IngresoEgresoCredito;
use App\Models\LineaCredito;
use App\Models\PatrimonioCredito;
use App\Models\Producto;
use App\Models\ReferenciaCredito;
use App\Models\SolServicio;
use App\Models\TarjetasCredito;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        if (!hasPermissionModule('solicitudes', 'read', 'solicitudes')) {
            // if (Auth::user()->role_id === 5 || Auth::user()->role_id === 6) {
            //   return to_route('client.dashboard');
            // }
            return to_route('dashboard');
        }

        $permissions = permissionModule('solicitudes', '', true);
        $solicitudes = $this->pagination($request);

        return Inertia::render('Solicitudes/Index', [
            'permissions' => $permissions,
            'solicitudes' => $solicitudes,
        ]);
    }

    public $search_;

    public function pagination(Request $request)
    {
        $entries = $request->show;

        $search         = $request->search      == "" ?  "" : $request->search;
        $order_type     = $request->order_type  == "" ? "DESC" : $request->order_type;
        $order_field    = $request->order_field == "" ? "sol_servicios.id" : $request->order_field;

        if ($search == "") {

            $h = SolServicio::select([
                'sol_servicios.id',
                'sol_servicios.clientes_id',
                'sol_servicios.producto_id',
                'sol_servicios.estado_solicitud',
                'sol_servicios.monto',
                'sol_servicios.tiempo',
                'sol_servicios.created_at',
                'clients.nombre',
                'caracteristicas_productos.nombre AS nombre_caract',
                'productos.nombre AS nombre_producto',
            ])
                ->join("clients", "sol_servicios.clientes_id", "clients.id")
                ->join("caracteristicas_productos", "sol_servicios.producto_id", "caracteristicas_productos.id")
                ->join("productos", "caracteristicas_productos.productos_id", "productos.id")
                ->orderBy($order_field, $order_type);

            // foreach ($h as $value) {
            //     $value->producto = CaracteristicasProducto::find($value->producto_id);

            //     if (isset($value->producto)) {
            //         $product = Producto::find($value->producto->productos_id);
            //         $value->producto->nombre_producto = $product->nombre;
            //     }
            // }

            //   $h = SolServicio::select(
            //     "solicitudes.*",
            //     "lineas_creditos.codigo AS linea_credito",
            //   )
            //     ->join("lineas_creditos", "solicitudes.linea_credito_id", "=", "lineas_creditos.id")
            //     ->join("users", "solicitudes.user_id", "=", "users.id")
            //     ->orderBy($order_field, $order_type);

            $show = $h->paginate($request->show);
        } else {

            $h = SolServicio::select([
                'sol_servicios.id',
                'sol_servicios.clientes_id',
                'sol_servicios.producto_id',
                'sol_servicios.estado_solicitud',
                'sol_servicios.monto',
                'sol_servicios.tiempo'
            ])
                ->join("clients", "sol_servicios.clientes_id", "clients.id")
                ->orderBy($order_field, $order_type);

            // $h =  SolServicio::select(
            //     "solicitudes.*",
            //     "lineas_creditos.codigo AS linea_credito",

            // )
            //     ->join("lineas_creditos", "solicitudes.linea_credito_id", "=", "lineas_creditos.id")
            //     ->join("users", "solicitudes.user_id", "=", "users.id")
            //     ->orderBy($order_field, $order_type);

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    "sol_servicios.estado_solicitud",
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

    public function show($id)
    {
        $solicitud = SolServicio::find($id);
        $solicitud->referencias = ReferenciaCredito::where('sol_servicios_id', $solicitud->id)->first();
        $solicitud->linea = LineaCredito::where('sol_servicios_id', $solicitud->id)->first();
        $solicitud->parimonio = PatrimonioCredito::where('sol_servicios_id', $solicitud->id)->first();
        $solicitud->ingreso = IngresoEgresoCredito::where('sol_servicios_id', $solicitud->id)->first();
        $solicitud->creditos = TarjetasCredito::where('sol_servicios_id', $solicitud->id)->first();

        $cliente = Client::find($solicitud->clientes_id);

        return Inertia::render('Solicitudes/Detalle', [
            // 'permissions' => $permissions,
            'solicitud' => $solicitud,
            'cliente' => $cliente,
        ]);
    }

    public function primeraSolicitud($client_id, $monto, $tiempo, $producto)
    {
        $cliente = Client::find($client_id);

        $sol = new SolServicio();
        $sol->clientes_id     = $client_id;
        $sol->producto_id     = $producto;
        $sol->monto           = $monto;
        $sol->tiempo          = $tiempo;
        $sol->save();

        return Inertia::render('Clients/PrimeraSolicitud', [
            'cliente' => $cliente,
            'producto' => $sol,
        ]);
    }

    public function editarSolicitud($id)
    {
        $sol = SolServicio::find($id);
        $cliente = Client::find($sol->clientes_id);

        $sol->referencias = ReferenciaCredito::where('sol_servicios_id', $sol->id)->first();
        $sol->linea = LineaCredito::where('sol_servicios_id', $sol->id)->first();
        $sol->parimonio = PatrimonioCredito::where('sol_servicios_id', $sol->id)->first();
        $sol->ingreso = IngresoEgresoCredito::where('sol_servicios_id', $sol->id)->first();
        $sol->creditos = TarjetasCredito::where('sol_servicios_id', $sol->id)->first();


        return Inertia::render('Clients/PrimeraSolicitud', [
            'cliente' => $cliente,
            'monto' => $sol->monto,
            'tiempo' => $sol->tiempo,
            'producto' => $sol,
        ]);
    }

    public function getSolicitud($id)
    {
        $sol = SolServicio::select(['id', 'clientes_id', 'producto_id', 'estado_solicitud', 'monto', 'tiempo'])->where('clientes_id', $id)->get();

        foreach ($sol as $value) {
            $value->producto = CaracteristicasProducto::find($value->producto_id);

            if (isset($value->producto)) {
                $product = Producto::find($value->producto->productos_id);
                $value->producto->nombre_producto = $product->nombre;
            }
        }


        return response()->json($sol, 200);
    }

    public function saveSolicitud(Request $request)
    {
        $sol = SolServicio::find($request->id);

        $sol->monto                 = $request->monto;
        $sol->tiempo                = $request->tiempo;
        $sol->numero                = $request->numero;
        $sol->valor                 = $request->valor;

        $sol->direccion_pers        = $request->direccion_pers;
        $sol->telefono              = $request->telefono;

        $sol->tiempo_financiacion   = $request->tiempo_financiacion;

        $sol->tasa_interes          = $request->tasa_interes;
        $sol->tasa_mora             = $request->tasa_mora;

        $sol->edad                  = $request->edad;

        $sol->ciudad_solicitud      = $request->ciudad_solicitud;
        $sol->tipo_cliente          = $request->tipo_cliente;
        $sol->tipo_declarante       = $request->tipo_declarante;
        $sol->profesion             = $request->profesion;
        $sol->empresa_donde_labora  = $request->empresa_donde_labora;
        $sol->indicador             = $request->indicador;
        $sol->nombre_negocio        = $request->nombre_negocio;
        $sol->nombre_conyuge        = $request->nombre_conyuge;
        $sol->empresa_conyuge       = $request->empresa_conyuge;
        $sol->indicador_autorizacion = $request->indicador_autorizacion;
        $sol->direccion_comercial   = $request->direccion_comercial;
        $sol->telefono_comercial    = $request->telefono_comercial;
        $sol->direccion_judicial    = $request->direccion_judicial;
        $sol->telefono_judicial     = $request->telefono_judicial;
        $sol->representante         = $request->representante;
        $sol->representante_doc     = $request->representante_doc;
        $sol->autorretenedor        = $request->autorretenedor;
        $sol->persona_pago          = $request->persona_pago;
        $sol->direccion_pago        = $request->direccion_pago;
        $sol->telefono_pago         = $request->telefono_pago;
        $sol->dia_pago              = $request->dia_pago;
        $sol->hora_pago             = $request->hora_pago;
        $sol->comentatio_pago       = $request->comentatio_pago;
        $sol->estado_civil          = $request->estado_civil;
        $sol->direccion_recidencia  = $request->direccion_recidencia;
        $sol->telefono_recidencia   = $request->telefono_recidencia;
        $sol->ciudad_recidencia     = $request->ciudad_recidencia;
        $sol->ciudad_recidencia     = $request->ciudad_recidencia;
        $sol->empresa               = $request->empresa;
        $sol->empresa_direccion     = $request->empresa_direccion;
        $sol->empresa_telefono      = $request->empresa_telefono;
        $sol->cargo_actual          = $request->cargo_actual;
        $sol->antoguedad_empresa    = $request->antoguedad_empresa;
        $sol->personas_cargo        = $request->personas_cargo;
        $sol->vivienda              = $request->vivienda;
        $sol->independiente         = $request->independiente;
        $sol->camara_comercio       = $request->camara_comercio;
        $sol->ocupacion_conyuge     = $request->ocupacion_conyuge;

        if ($request->file('url_img') !== null) {
            $imagen         = $request->file('url_img');
            $nombreimagen   = Carbon::now()->format('dmYhis') . "." . trim($imagen->getClientOriginalName());
            $ruta           = public_path("assets/images/");
            $imagen->move($ruta, $nombreimagen);
            $urlImg = "/assets/images/" . $nombreimagen;

            $sol->firma_solicitud = $urlImg;
        }

        if ($request->file('url_img_dos') !== null) {
            $imagen         = $request->file('url_img_dos');
            $nombreimagen   = Carbon::now()->format('dmYhis') . "." . trim($imagen->getClientOriginalName());
            $ruta           = public_path("assets/images/");
            $imagen->move($ruta, $nombreimagen);
            $urlImgDos = "/assets/images/" . $nombreimagen;

            $sol->firma_declaracion = $urlImgDos;
        }

        $sol->save();

        $referenciasVeri = ReferenciaCredito::where('sol_servicios_id', $sol->id)->first();

        if (!$referenciasVeri) {
            $referencias = new ReferenciaCredito();
            $referencias->sol_servicios_id      = $sol->id;
            $referencias->save();
        } else {
            $referencias = ReferenciaCredito::where('sol_servicios_id', $sol->id)->first();

            $referencias->banco                 = $request->banco;
            $referencias->sucursal              = $request->sucursal;
            $referencias->banco_numero          = $request->banco_numero;
            $referencias->banco_dos             = $request->banco_dos;
            $referencias->sucursal_dos          = $request->sucursal_dos;
            $referencias->banco_numero_dos      = $request->banco_numero_dos;
            $referencias->nombre_comercal       = $request->nombre_comercal;
            $referencias->direccion_comercal    = $request->direccion_comercal;
            $referencias->telefono_comercal     = $request->telefono_comercal;
            $referencias->nombre_comercal_dos   = $request->nombre_comercal_dos;
            $referencias->direccion_comercal_dos = $request->direccion_comercal_dos;
            $referencias->telefono_comercal_dos = $request->telefono_comercal_dos;
            $referencias->nombre_familiar       = $request->nombre_familiar;
            $referencias->direccion_familiar    = $request->direccion_familiar;
            $referencias->telefono_familiar     = $request->telefono_familiar;
            $referencias->nombre_familiar_dos   = $request->nombre_familiar_dos;
            $referencias->direccion_familiar_dos = $request->direccion_familiar_dos;
            $referencias->telefono_familiar_dos = $request->telefono_familiar_dos;

            $referencias->save();
        }


        $lineaVeri = LineaCredito::where('sol_servicios_id', $sol->id)->first();

        if (!$lineaVeri) {
            $linea = new LineaCredito();
            $linea->sol_servicios_id      = $sol->id;
            $linea->save();
        } else {

            $linea = LineaCredito::where('sol_servicios_id', $sol->id)->first();
            $linea->tipo_credito          = $request->tipo_credito;
            $linea->oficina_credito       = $request->oficina_credito;
            $linea->vendedor_credito      = $request->vendedor_credito;
            $linea->monto_solicitado_credito = $request->monto_solicitado_credito;
            $linea->forma_pago_credito    = $request->forma_pago_credito;

            $linea->save();
        }

        $parimonioVeri = PatrimonioCredito::where('sol_servicios_id', $sol->id)->first();

        if (!$parimonioVeri) {
            $parimonio = new PatrimonioCredito();
            $parimonio->sol_servicios_id      = $sol->id;
            $parimonio->save();
        } else {
            $parimonio = PatrimonioCredito::where('sol_servicios_id', $sol->id)->first();
            $parimonio->descripcion_bien      = $request->descripcion_bien;
            $parimonio->ciudad_bien           = $request->ciudad_bien;
            $parimonio->hipoteca_bien         = $request->hipoteca_bien;
            $parimonio->avaluo_comercial_bien = $request->avaluo_comercial_bien;
            $parimonio->avaluo_catastral_bien = $request->avaluo_catastral_bien;
            $parimonio->cedula_catastral_bien = $request->cedula_catastral_bien;
            $parimonio->matricula_bien        = $request->matricula_bien;
            $parimonio->escritura_bien        = $request->escritura_bien;
            $parimonio->notaria_bien          = $request->notaria_bien;
            $parimonio->fecha_bien            = $request->fecha_bien;
            $parimonio->ciudad_parimonio_bien = $request->ciudad_parimonio_bien;
            $parimonio->descripcion_bien_dos  = $request->descripcion_bien_dos;
            $parimonio->ciudad_bien_dos       = $request->ciudad_bien_dos;
            $parimonio->hipoteca_bien_dos     = $request->hipoteca_bien_dos;
            $parimonio->avaluo_comercial_bien_dos = $request->avaluo_comercial_bien_dos;
            $parimonio->avaluo_catastral_bien_dos = $request->avaluo_catastral_bien_dos;
            $parimonio->cedula_catastral_bien_dos = $request->cedula_catastral_bien_dos;
            $parimonio->matricula_bien_dos    = $request->matricula_bien_dos;
            $parimonio->escritura_bien_dos    = $request->escritura_bien_dos;
            $parimonio->notaria_bien_dos      = $request->notaria_bien_dos;
            $parimonio->fecha_bien_dos        = $request->fecha_bien_dos;
            $parimonio->ciudad_parimonio_bien_dos = $request->ciudad_parimonio_bien_dos;
            $parimonio->descripcion_bien_tres = $request->descripcion_bien_tres;
            $parimonio->ciudad_bien_tres      = $request->ciudad_bien_tres;
            $parimonio->hipoteca_bien_tres    = $request->hipoteca_bien_tres;
            $parimonio->avaluo_comercial_bien_tres = $request->avaluo_comercial_bien_tres;
            $parimonio->avaluo_catastral_bien_tres = $request->avaluo_catastral_bien_tres;
            $parimonio->cedula_catastral_bien_tres = $request->cedula_catastral_bien_tres;
            $parimonio->matricula_bien_tres   = $request->matricula_bien_tres;
            $parimonio->escritura_bien_tres   = $request->escritura_bien_tres;
            $parimonio->notaria_bien_tres     = $request->notaria_bien_tres;
            $parimonio->fecha_bien_tres       = $request->fecha_bien_tres;
            $parimonio->ciudad_parimonio_bien_tres = $request->ciudad_parimonio_bien_tres;
            $parimonio->marca_vehiculo        = $request->marca_vehiculo;
            $parimonio->clase_vehiculo        = $request->clase_vehiculo;
            $parimonio->modelo_vehiculo       = $request->modelo_vehiculo;
            $parimonio->placa_vehiculo        = $request->placa_vehiculo;
            $parimonio->valor_vehiculo        = $request->valor_vehiculo;
            $parimonio->hipoteca_vehiculo     = $request->hipoteca_vehiculo;
            $parimonio->marca_vehiculo_dos    = $request->marca_vehiculo_dos;
            $parimonio->clase_vehiculo_dos    = $request->clase_vehiculo_dos;
            $parimonio->modelo_vehiculo_dos   = $request->modelo_vehiculo_dos;
            $parimonio->placa_vehiculo_dos    = $request->placa_vehiculo_dos;
            $parimonio->valor_vehiculo_dos    = $request->valor_vehiculo_dos;
            $parimonio->hipoteca_vehiculo_dos = $request->hipoteca_vehiculo_dos;

            $parimonio->save();
        }

        $ingresoVeri = IngresoEgresoCredito::where('sol_servicios_id', $sol->id)->first();

        if (!$ingresoVeri) {
            $ingreso = new IngresoEgresoCredito();
            $ingreso->sol_servicios_id      = $sol->id;
            $ingreso->save();
        } else {
            $ingreso = IngresoEgresoCredito::where('sol_servicios_id', $sol->id)->first();
            $ingreso->salario               = $request->salario;
            $ingreso->honorarios            = $request->honorarios;
            $ingreso->otros_ingresos        = $request->otros_ingresos;
            $ingreso->otros_ingresos_describe = $request->otros_ingresos_describe;
            $ingreso->total_ingresos        = $request->total_ingresos;
            $ingreso->alquiler              = $request->alquiler;
            $ingreso->amortizacion          = $request->amortizacion;
            $ingreso->amortizacion_hipoteca = $request->amortizacion_hipoteca;
            $ingreso->pago_tarjetas         = $request->pago_tarjetas;
            $ingreso->otros_gastos          = $request->otros_gastos;
            $ingreso->total_egresos         = $request->total_egresos;

            $ingreso->save();
        }

        $creditosVeri = TarjetasCredito::where('sol_servicios_id', $sol->id)->first();

        if (!$creditosVeri) {
            $creditos = new TarjetasCredito();
            $creditos->sol_servicios_id      = $sol->id;
            $creditos->save();
        } else {
            $creditos = TarjetasCredito::where('sol_servicios_id', $sol->id)->first();
            $creditos->acreedor              = $request->acreedor;
            $creditos->acreedor_dos          = $request->acreedor_dos;
            $creditos->acreedor_telefono     = $request->acreedor_telefono;
            $creditos->acreedor_telefono_dos = $request->acreedor_telefono_dos;
            $creditos->acreedor_valor        = $request->acreedor_valor;
            $creditos->acreedor_valor_dos    = $request->acreedor_valor_dos;
            $creditos->acreedor_saldo        = $request->acreedor_saldo;
            $creditos->acreedor_saldo_dos    = $request->acreedor_saldo_dos;
            $creditos->banco_tarjeta         = $request->banco_tarjeta;
            $creditos->banco_tarjeta_dos     = $request->banco_tarjeta_dos;
            $creditos->banco_antoguedad      = $request->banco_antoguedad;
            $creditos->banco_antoguedad_dos  = $request->banco_antoguedad_dos;
            $creditos->banco_numero_antoguedad = $request->banco_numero_antoguedad;
            $creditos->banco_numero_antoguedad_dos = $request->banco_numero_antoguedad_dos;
            $creditos->banco_cupo            = $request->banco_cupo;
            $creditos->banco_cupo_dos        = $request->banco_cupo_dos;

            $creditos->save();
        }

        return response()->json([
            'status'    => true,
            'data'      => $sol
        ]);
    }

    public function updateStateSolicitud(Request $request, $id)
    {
        $sol = SolServicio::find($id);
        $sol->estado_solicitud = $request->accion;
        $sol->save();

        if ($request->accion == 'Aceptado') {
            $cliente = Client::find($sol->clientes_id);
            $cliente->role_id = 4;
            $cliente->save();

            $usuario = User::find($cliente->users_id);
            $usuario->role_id = 4;
            $usuario->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'actualizado'
        ]);
    }
}
