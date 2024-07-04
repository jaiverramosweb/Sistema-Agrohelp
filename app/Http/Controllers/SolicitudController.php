<?php

namespace App\Http\Controllers;

use App\Models\Amortization;
use App\Models\CaracteristicasDocumentacion;
use App\Models\CaracteristicasProducto;
use App\Models\Client;
use App\Models\FacturaPago;
use App\Models\IngresoEgresoCredito;
use App\Models\LineaCredito;
use App\Models\PagoAmortizacion;
use App\Models\PatrimonioCredito;
use App\Models\Producto;
use App\Models\ReferenciaCredito;
use App\Models\SolicitudDocumentos;
use App\Models\SolServicio;
use App\Models\TarjetasCredito;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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
            ])
                ->join("clients", "sol_servicios.clientes_id", "clients.id")
                ->orderBy($order_field, $order_type);

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
        // $solicitud->producto = CaracteristicasProducto::find($solicitud->producto_id);
        $solicitud->linea = LineaCredito::where('clientes_id', $solicitud->clientes_id)->first();
        $solicitud->parimonio = PatrimonioCredito::where('clientes_id', $solicitud->clientes_id)->first();
        $solicitud->ingreso = IngresoEgresoCredito::where('clientes_id', $solicitud->clientes_id)->first();
        $solicitud->creditos = TarjetasCredito::where('clientes_id', $solicitud->clientes_id)->first();
        $solicitud->referencias = ReferenciaCredito::where('clientes_id', $solicitud->clientes_id)->first();

        $cliente = Client::find($solicitud->clientes_id);

        return Inertia::render('Solicitudes/Detalle', [
            // 'permissions' => $permissions,
            'solicitud' => $solicitud,
            'cliente' => $cliente,
        ]);
    }

    public function primeraSolicitud(Request $request)
    {
        $sol = new SolServicio();
        $sol->clientes_id     = $request->client_id;
        $sol->producto_id     = 0;
        $sol->linea_id        = isset($request->linea_id) ? $request->linea_id : 0;
        $sol->monto           = $request->monto_solicitar;
        $sol->tiempo          = $request->tiempo_pagar;
        $sol->tasa_interes    = $request->ineteres;
        $sol->tipo_interes    = $request->tipo_interes;
        $sol->interes_mas    = isset($request->interes_mas) ? $request->interes_mas : 0;
        $sol->tasa_mora       = 0;
        $sol->cobro_intereses = $request->cobro_intereses;
        $sol->save();

        return response()->json($sol, 201);
    }

    public function editarSolicitud($id)
    {
        $sol = SolServicio::find($id);
        $cliente = Client::find($sol->clientes_id);

        $documentos = CaracteristicasDocumentacion::select([
            'documentacions.nombre'
        ])->where('caracteristicas_productos_id', $sol->producto_id)
            ->join('documentacions', 'caracteristicas_documentacions.documentacions_id', 'documentacions.id')
            ->get();

        $sol->referencias = ReferenciaCredito::where('sol_servicios_id', $sol->id)->first();
        $sol->linea = LineaCredito::where('sol_servicios_id', $sol->id)->first();
        $sol->parimonio = PatrimonioCredito::where('sol_servicios_id', $sol->id)->first();
        $sol->ingreso = IngresoEgresoCredito::where('sol_servicios_id', $sol->id)->first();
        $sol->creditos = TarjetasCredito::where('sol_servicios_id', $sol->id)->first();


        return Inertia::render('Clients/PrimeraSolicitud', [
            'cliente' => $cliente,
            'monto' => $sol->monto,
            'tiempo' => $sol->tiempo,
            'documentos'    => $documentos,
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

        $sol->numero                = isset($request->numero) ? $request->numero :  $sol->numero;
        $sol->valor                 = isset($request->valor) ? $request->valor :  $sol->valor;
        $sol->tiempo_financiacion   = isset($request->tiempo_financiacion) ? $request->tiempo_financiacion :  $sol->tiempo_financiacion;

        $sol->ciudad_solicitud      = isset($request->ciudad_solicitud) ? $request->ciudad_solicitud :  '';

        $sol->direccion_pers        = isset($request->direccion_pers) ? $request->direccion_pers :  $sol->direccion_pers;
        $sol->telefono              = isset($request->telefono) ? $request->telefono :  $sol->telefono;

        $sol->edad                  = isset($request->edad) ? $request->edad :  $sol->edad;

        $sol->tipo_cliente          = isset($request->tipo_cliente) ? $request->tipo_cliente :  $sol->tipo_cliente;
        $sol->tipo_declarante       = isset($request->tipo_declarante) ? $request->tipo_declarante :  $sol->tipo_declarante;
        $sol->profesion             = isset($request->profesion) ? $request->profesion :  $sol->profesion;
        $sol->empresa_donde_labora  = isset($request->empresa_donde_labora) ? $request->empresa_donde_labora :  $sol->empresa_donde_labora;
        $sol->indicador             = isset($request->indicador) ? $request->indicador :  $sol->indicador;
        $sol->nombre_negocio        = isset($request->nombre_negocio) ? $request->nombre_negocio :  $sol->nombre_negocio;
        $sol->nombre_conyuge        = isset($request->nombre_conyuge) ? $request->nombre_conyuge :  $sol->nombre_conyuge;
        $sol->empresa_conyuge       = isset($request->empresa_conyuge) ? $request->empresa_conyuge :  $sol->empresa_conyuge;
        $sol->indicador_autorizacion = isset($request->indicador_autorizacion) ? $request->indicador_autorizacion :  $sol->indicador_autorizacion;
        $sol->telefono_comercial    = isset($request->telefono_comercial) ? $request->telefono_comercial :  $sol->telefono_comercial;
        $sol->direccion_judicial    = isset($request->direccion_judicial) ? $request->direccion_judicial :  $sol->direccion_judicial;
        $sol->telefono_judicial     = isset($request->telefono_judicial) ? $request->telefono_judicial :  $sol->telefono_judicial;
        $sol->representante         = isset($request->representante) ? $request->representante :  $sol->representante;
        $sol->representante_doc     = isset($request->representante_doc) ? $request->representante_doc :  $sol->representante_doc;
        $sol->autorretenedor        = isset($request->autorretenedor) ? $request->autorretenedor :  $sol->autorretenedor;
        $sol->persona_pago          = isset($request->persona_pago) ? $request->persona_pago :  $sol->persona_pago;
        $sol->direccion_pago        = isset($request->direccion_pago) ? $request->direccion_pago :  $sol->direccion_pago;
        $sol->telefono_pago         = isset($request->telefono_pago) ? $request->telefono_pago :  $sol->telefono_pago;
        $sol->dia_pago              = isset($request->dia_pago) ? $request->dia_pago :  $sol->dia_pago;
        $sol->hora_pago             = isset($request->hora_pago) ? $request->hora_pago :  $sol->hora_pago;
        $sol->comentatio_pago       = isset($request->comentatio_pago) ? $request->comentatio_pago :  $sol->comentatio_pago;
        $sol->estado_civil          = isset($request->estado_civil) ? $request->estado_civil :  $sol->estado_civil;
        $sol->direccion_recidencia  = isset($request->direccion_recidencia) ? $request->direccion_recidencia :  $sol->direccion_recidencia;
        $sol->telefono_recidencia   = isset($request->telefono_recidencia) ? $request->telefono_recidencia :  $sol->telefono_recidencia;
        $sol->ciudad_recidencia     = isset($request->ciudad_recidencia) ? $request->ciudad_recidencia :  $sol->ciudad_recidencia;
        $sol->empresa               = isset($request->empresa) ? $request->empresa :  $sol->empresa;
        $sol->empresa_direccion     = isset($request->empresa_direccion) ? $request->empresa_direccion :  $sol->empresa_direccion;
        $sol->empresa_telefono      = isset($request->empresa_telefono) ? $request->empresa_telefono :  $sol->empresa_telefono;
        $sol->cargo_actual          = isset($request->cargo_actual) ? $request->cargo_actual :  $sol->cargo_actual;
        $sol->antoguedad_empresa    = isset($request->antoguedad_empresa) ? $request->antoguedad_empresa :  $sol->antoguedad_empresa;
        $sol->personas_cargo        = isset($request->personas_cargo) ? $request->personas_cargo :  $sol->personas_cargo;
        $sol->vivienda              = isset($request->vivienda) ? $request->vivienda :  $sol->vivienda;
        $sol->independiente         = isset($request->independiente) ? $request->independiente :  $sol->independiente;
        $sol->camara_comercio       = isset($request->camara_comercio) ? $request->camara_comercio :  $sol->camara_comercio;
        $sol->ocupacion_conyuge     = isset($request->ocupacion_conyuge) ? $request->ocupacion_conyuge :  $sol->ocupacion_conyuge;

        $sol->save();


        $lineaVeri = LineaCredito::where('sol_servicios_id', $sol->id)->first();

        if (!$lineaVeri) {
            $linea = new LineaCredito();
            $linea->sol_servicios_id      = $sol->id;
            $linea->save();
        } else {

            $linea = LineaCredito::where('sol_servicios_id', $sol->id)->first();
            $linea->tipo_credito          = isset($request->tipo_credito) ? $request->tipo_credito :  $linea->tipo_credito;
            $linea->oficina_credito       = isset($request->oficina_credito) ? $request->oficina_credito :  $linea->oficina_credito;
            $linea->vendedor_credito      = isset($request->vendedor_credito) ? $request->vendedor_credito :  $linea->vendedor_credito;
            $linea->monto_solicitado_credito = isset($request->monto_solicitado_credito) ? $request->monto_solicitado_credito :  $linea->monto_solicitado_credito;
            $linea->forma_pago_credito    = isset($request->forma_pago_credito) ? $request->forma_pago_credito :  $linea->forma_pago_credito;

            $linea->save();
        }

        $parimonioVeri = PatrimonioCredito::where('sol_servicios_id', $sol->id)->first();

        if (!$parimonioVeri) {
            $parimonio = new PatrimonioCredito();
            $parimonio->sol_servicios_id      = $sol->id;
            $parimonio->save();
        } else {
            $parimonio = PatrimonioCredito::where('sol_servicios_id', $sol->id)->first();
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
        }

        $ingresoVeri = IngresoEgresoCredito::where('sol_servicios_id', $sol->id)->first();

        if (!$ingresoVeri) {
            $ingreso = new IngresoEgresoCredito();
            $ingreso->sol_servicios_id      = $sol->id;
            $ingreso->save();
        } else {
            $ingreso = IngresoEgresoCredito::where('sol_servicios_id', $sol->id)->first();
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
        }

        $creditosVeri = TarjetasCredito::where('sol_servicios_id', $sol->id)->first();

        if (!$creditosVeri) {
            $creditos = new TarjetasCredito();
            $creditos->sol_servicios_id      = $sol->id;
            $creditos->save();
        } else {
            $creditos = TarjetasCredito::where('sol_servicios_id', $sol->id)->first();
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
        }

        return response()->json([
            'status'    => true,
            'data'      => $sol
        ]);
    }

    public function saveReferencias(Request $request)
    {
        // return $request->all();

        $referencias = ReferenciaCredito::where('sol_servicios_id', $request->id)->first();

        $referencias->banco                 = isset($request->banco) ? $request->banco :  $referencias->banco;
        $referencias->sucursal              = isset($request->sucursal) ? $request->sucursal :  $referencias->sucursal;
        $referencias->banco_numero          = isset($request->banco_numero) ? $request->banco_numero :  $referencias->banco_numero;
        $referencias->banco_dos             = isset($request->banco_dos) ? $request->banco_dos :  $referencias->banco_dos;
        $referencias->sucursal_dos          = isset($request->sucursal_dos) ? $request->sucursal_dos :  $referencias->sucursal_dos;
        $referencias->banco_numero_dos      = isset($request->banco_numero_dos) ? $request->banco_numero_dos :  $referencias->banco_numero_dos;
        $referencias->nombre_comercal       = isset($request->nombre_comercal) ? $request->nombre_comercal :  $referencias->nombre_comercal;
        $referencias->direccion_comercal    = isset($request->direccion_comercal) ? $request->direccion_comercal :  $referencias->direccion_comercal;
        $referencias->telefono_comercal     = isset($request->telefono_comercal) ? $request->telefono_comercal :  $referencias->telefono_comercal;
        $referencias->nombre_comercal_dos   = isset($request->nombre_comercal_dos) ? $request->nombre_comercal_dos :  $referencias->nombre_comercal_dos;
        $referencias->direccion_comercal_dos = isset($request->direccion_comercal_dos) ? $request->direccion_comercal_dos :  $referencias->direccion_comercal_dos;
        $referencias->telefono_comercal_dos = isset($request->telefono_comercal_dos) ? $request->telefono_comercal_dos :  $referencias->telefono_comercal_dos;
        $referencias->nombre_familiar       = isset($request->nombre_familiar) ? $request->nombre_familiar :  $referencias->nombre_familiar;
        $referencias->direccion_familiar    = isset($request->direccion_familiar) ? $request->direccion_familiar :  $referencias->direccion_familiar;
        $referencias->telefono_familiar     = isset($request->telefono_familiar) ? $request->telefono_familiar :  $referencias->telefono_familiar;
        $referencias->nombre_familiar_dos   = isset($request->nombre_familiar_dos) ? $request->nombre_familiar_dos :  $referencias->nombre_familiar_dos;
        $referencias->direccion_familiar_dos = isset($request->direccion_familiar_dos) ? $request->direccion_familiar_dos :  $referencias->direccion_familiar_dos;
        $referencias->telefono_familiar_dos = isset($request->telefono_familiar_dos) ? $request->telefono_familiar_dos :  $referencias->telefono_familiar_dos;

        $referencias->save();

        return response()->json([
            'status'    => true,
            'data'      => $referencias
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

    public function uploadFile(Request $request)
    {
        $archivos = $request->file('documents');
        $results = array();

        foreach ($archivos as $archivo) {
            // dd('archivo', $archivo);

            $imagen         = $archivo;
            $nombreimagen   = Carbon::now()->format('dmYhis') . "." . trim($imagen->getClientOriginalName());
            $ruta           = public_path("assets/images/");
            $imagen->move($ruta, $nombreimagen);
            $urlImg = "/assets/images/" . $nombreimagen;

            $document = SolicitudDocumentos::create([
                'solicitud_id'  => $request->solicitud_id,
                'name'          => $imagen->getClientOriginalName(),
                'path'          => $urlImg
            ]);

            $results[] = $document;
        }

        return $results;
    }

    public function getFiles($id)
    {
        $documents = SolicitudDocumentos::where('solicitud_id', $id)->get();
        return response()->json([
            'status'    => true,
            'data'      => $documents
        ]);
    }

    public function downloadFile($id)
    {
        $doc = SolicitudDocumentos::find($id);
        $rutaArchivo = public_path($doc->path);
        // return response()->download($rutaArchivo, 'documento');
        return response()->download($rutaArchivo, $doc->nombre);
    }

    public function deleteFile($id)
    {
        SolicitudDocumentos::find($id)->delete();
        return response()->json([
            'status' => true,
            'msg'    => 'Recurso borrado correctamente.'
        ]);
    }

    public function verAmortizacion($id)
    {
        $credito = SolServicio::find($id);
        return Inertia::render('Clients/VerCreditos', [
            'credito' => $credito
        ]);
    }

    public function verAprobado($id)
    {
        $amortization = Amortization::where('sol_servicios_id', $id)->get();

        return Inertia::render('Clients/VerAprobado', [
            'data' => $amortization,
        ]);
    }

    public function savePreaprovado($id)
    {
        $solicitud = SolServicio::find($id);
        $solicitud->estado_solicitud = 'Preaprobado';
        $solicitud->save();

        // EnviarEmail

        return response()->json($solicitud, 200);
    }

    public function updateEstadoSolicitud(Request $request, $id)
    {
        $solicitud = SolServicio::find($id);
        $solicitud->estado_solicitud = $request->estado;
        $solicitud->save();

        return response()->json($solicitud, 200);
    }

    public function updateValoresSolicitud(Request $request, $id)
    {
        $solicitud = SolServicio::find($id);
        $solicitud->monto           = $request->monto_solicitar;
        $solicitud->tiempo          = $request->tiempo_pagar;
        $solicitud->tasa_interes    = $request->tasa;
        $solicitud->save();

        return response()->json($solicitud, 200);
    }

    public function downloadSolicitud($id)
    {
        $sol = SolServicio::find($id);

        // dd($sol);
        $sol->cliente = Client::find($sol->clientes_id);
        $sol->referencias = ReferenciaCredito::where('sol_servicios_id', $sol->id)->first();
        $sol->linea = LineaCredito::where('sol_servicios_id', $sol->id)->first();
        $sol->parimonio = PatrimonioCredito::where('sol_servicios_id', $sol->id)->first();
        $sol->ingreso = IngresoEgresoCredito::where('sol_servicios_id', $sol->id)->first();
        $sol->creditos = TarjetasCredito::where('sol_servicios_id', $sol->id)->first();

        // return PDF::loadView('pdf.solicitud')->stream('archivo.pdf');
        // $pdf = Pdf::loadView('pdf.solicitud', compact('sol'));
        // return $pdf->stream('archivo.pdf');

        return view('pdf.solicitud', ['data' => $sol]);
        // return view('pdf.solicitud');
    }

    public function downloadPre($id)
    {
        $sol = SolServicio::select('id', 'producto_id', 'clientes_id', 'tiempo', 'monto', 'tasa_interes')->find($id);
        $sol->cliente = Client::find($sol->clientes_id);

        // return view('pdf.preaprobado', compact('sol'));
        return PDF::loadView('pdf.preaprobado', compact('sol'))->stream('archivo.pdf');
    }

    public function solicitudAprobada(Request $request, $id)
    {
        // return $id;

        // dd($request->tablaAmortizacion);

        $solicitud = SolServicio::find($id);
        $solicitud->estado_solicitud = $request->state;
        $solicitud->valor            = floatval($request->monto_solicitar);
        $solicitud->save();

        $mora = floatval($request->mora);

        $tasa = floatval($request->tasa);

        $montoSolicitar = floatval($request->monto_solicitar);
        $tiempoPagar = intval($request->tiempo_pagar);

        foreach ($request->tablaAmortizacion as $value) {
            $amortization = new Amortization();
            $amortization->sol_servicios_id = $id;
            $amortization->fecha = $value['fecha'];
            $amortization->cuota_numero = $value['mes'];
            $amortization->cuota = $value['cuota'];
            $amortization->interes = $value['interes'];
            $amortization->interes2 = $value['interes'];
            $amortization->amortizacion = $value['amortizacion'];
            $amortization->amortizacion2 = $value['amortizacion'];
            $amortization->saldo_pendiente =  $value['saldoPendiente'];
            $amortization->tasa = $tasa;
            $amortization->mora = $mora;
            $amortization->monto_solicitado = $montoSolicitar;
            $amortization->tiempo_pagar = $tiempoPagar;
            $amortization->save();
        }


        return response()->json(['message' => 'Tabla de amortización calculada y almacenada correctamente'], 200);
    }

    public function AmortizacionAll($id)
    {
        $amortization = Amortization::where('sol_servicios_id', $id)->get();
        return response()->json($amortization, 200);
    }

    public function realizarPago(Request $request)
    {
        // $amortization = Amortization::where('sol_servicios_id', $id)->get();

        // $factura = FacturaPago::create([
        //     'pago' => $request->pagos,
        //     'fecha_pagar' => $request->fecha_pagar
        // ]);

        $credito = Amortization::where('sol_servicios_id', $request->id)->first();

        $factura = FacturaPago::create([
            'pago'              => $request->pagos,
            'fecha_pagar'       => $request->fecha_pagar,
            'sol_servicios_id'  =>  $credito->sol_servicios_id,
            'metodo_pago_id'    =>  $request->metodo_pago,
            'banco_id'          =>  $request->banco_id,
            'descripcion_pago'  => isset($request->descripcion_pago) ? $request->descripcion_pago : ''
        ]);

        foreach ($request->tabla_pagos as $value) {
            $cuota = strval($value['cuota']);
            $amortization = Amortization::find($value['id']);
            // dd($amortization);
            $amortization->cuota                = $cuota;
            $amortization->interes              = strval($value['interes']);
            $amortization->interes2             = strval($value['interes2']);
            $amortization->interes_pagado       = strval($value['interes_pagado']);
            $amortization->amortizacion         = strval($value['amortizacion']);
            $amortization->amortizacion2        = strval($value['amortizacion2']);
            $amortization->mora                 = strval($value['mora']);
            $amortization->mora_pagado          = strval($value['mora2']);
            $amortization->amortizacion_pagado  = strval($value['amortizacion_pagado']);
            $amortization->saldo_pendiente      = strval($value['saldo_pagar']);
            $amortization->estado               = $cuota == 0 ? true : false;
            $amortization->save();

            PagoAmortizacion::create([
                'amortizations_id' => $amortization->id,
                'factura_pagos_id' => $factura->id,
                'metodo_pago_id'   => $request->metodo_pago,
                'descripcion_pago' => isset($request->descripcion_pago) ? $request->descripcion_pago : ''
            ]);

            $solicitud = SolServicio::find($amortization->sol_servicios_id);
            $solicitud->valor = strval($value['saldo_pendiente']);
            $solicitud->save();
        }

        return response()->json($factura, 200);
    }
}
