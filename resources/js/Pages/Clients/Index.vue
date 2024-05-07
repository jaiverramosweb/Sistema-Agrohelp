<script setup>
import { onMounted, reactive, ref, computed, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import LayoutCLient from '@/Layouts/LayoutClient.vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

import Solicitudes from './components/Solicitudes.vue'
import axios from 'axios';

const props = defineProps(['cliente', 'info'])

onMounted(() => {
    infoUser.value = props.cliente
    infoCliente.value = props.info
    if (props.info) {
        if (props.info.tipo_documento) {
            getCaracteristicas()
            getSolicitudes()
        }
    }

})

const infoUser = ref('')
const infoCliente = ref('')

const mostrarSolicitud = ref(false)

const id = ref(0)
const tipo_identificacion = ref('')
const documento = ref('')
const nombre = ref('')


const productos = ref([])
const solicitudes = ref([])

const creado = ref(false)

const monto_solicitar = ref('')
const tiempo_pagar = ref('')
const tasa = ref('')
const tablaAmortizacion = ref([])
const product_id = ref(0)
const tipoAmortizacion = ref('')

const getCaracteristicas = () => {
    axios.get('/get-product-caract').then(({ data }) => {
        console.log('data', data)
        productos.value = data
    })
}

const getSolicitudes = () => {
    axios.get('/get-solicitud/' + infoCliente.value.id).then(({ data }) => {
        console.log('Solicitudes', data)
        solicitudes.value = data
    })
}

const simuladorMonto = (producto) => {

    tasa.value = producto.interes
    product_id.value = producto.id
    tipoAmortizacion.value = producto.tipo_amortizacion
    // tipoAmortizacion.value = 'Inglés'

    $("#modalMontoSimulador").modal("show");
}

const simulador = () => {
    $("#modalMontoSimulador").modal("hide");

    // periodisida de pago
    // si es 12 => Mes
    // si es 6 => Vi
    // si es 4 => Tre
    // si es 3 => cuati
    // si es 2 => semes
    // si es 1 => anual

    if (tipoAmortizacion.value == 'Francés') metodoFrances()
    if (tipoAmortizacion.value == 'Alemán') metodoAleman()
    if (tipoAmortizacion.value == 'Inglés') metodoIngles()


    setInterval(() => {
        $("#modalSimulador").modal("show");
    }, 1000);

}

const metodoFrances = () => {

    const tasaMensual = tasa.value / 100 / 12;
    const cuota = (monto_solicitar.value * tasaMensual) / (1 - Math.pow(1 + tasaMensual, - tiempo_pagar.value));
    let saldoPendiente = monto_solicitar.value;
    tablaAmortizacion.value = [];
    let fecha = new Date();
    for (let i = 1; i <= tiempo_pagar.value; i++) {
        const interes = saldoPendiente * tasaMensual;
        const amortizacion = cuota - interes;
        saldoPendiente -= amortizacion;
        tablaAmortizacion.value.push({
            fecha: fecha.toLocaleDateString(),
            cuota: cuota.toFixed(2),
            interes: interes.toFixed(2),
            amortizacion: amortizacion.toFixed(2),
            saldoPendiente: saldoPendiente.toFixed(2)
        });
        fecha.setMonth(fecha.getMonth() + 1);
    }
}

const metodoAleman = () => {
    const tasaMensual = tasa.value / 100 / 12;
    const cuotaTotal = monto_solicitar.value / tiempo_pagar.value;
    let saldoPendiente = monto_solicitar.value;
    tablaAmortizacion.value = [];
    let fecha = new Date();
    for (let i = 1; i <= tiempo_pagar.value; i++) {
        const interes = saldoPendiente * tasaMensual;
        const amortizacion = cuotaTotal;
        saldoPendiente -= amortizacion;
        tablaAmortizacion.value.push({
            mes: i,
            fecha: fecha.toLocaleDateString(),
            cuota: cuotaTotal.toFixed(2),
            interes: interes.toFixed(2),
            amortizacion: amortizacion.toFixed(2),
            saldoPendiente: saldoPendiente.toFixed(2)
        });
        fecha.setMonth(fecha.getMonth() + 1);
    }
}

const metodoIngles = () => {
    const tasaMensual = tasa.value / 100 / 12;
    const cuota = monto_solicitar.value * tasaMensual * Math.pow(1 + tasaMensual, tiempo_pagar.value) / (Math.pow(1 + tasaMensual, tiempo_pagar.value) - 1);
    let saldoPendiente = monto_solicitar.value;
    tablaAmortizacion.value = [];
    let fecha = new Date();
    for (let i = 1; i <= tiempo_pagar.value; i++) {
        const interes = saldoPendiente * tasaMensual;
        const amortizacion = cuota - interes;
        saldoPendiente -= amortizacion;
        tablaAmortizacion.value.push({
            mes: i,
            fecha: fecha.toLocaleDateString(),
            cuota: cuota.toFixed(2),
            interes: interes.toFixed(2),
            amortizacion: amortizacion.toFixed(2),
            saldoPendiente: saldoPendiente.toFixed(2)
        });
        fecha.setMonth(fecha.getMonth() + 1);
    }
}

const solicitarCredito = () => {
    $("#modalSimulador").modal("hide");
    window.location.href = `/primera-solicitud/${infoCliente.value.id}/${monto_solicitar.value}/${tiempo_pagar.value}/${product_id.value}`;
}

const editarCredito = (id) => {
    window.location.href = `/editar-solicitud/${id}`;
}

const crearSolicitud = () => {
    mostrarSolicitud.value = true
}

const limpiar = () => {
    monto_solicitar.value = ''
    tiempo_pagar.value = ''
    tasa.value = ''
    tablaAmortizacion.value = []

    $("#modalMontoSimulador").modal("hide");
    $("#modalSimulador").modal("hide");

    location.reload();
}

const save = () => {

    if (tipo_identificacion.value.length == 0) return
    if (documento.value.length == 0) return
    if (nombre.value.length == 0) return

    axios.post('/clients', {
        email: infoUser.value.email,
        tipo_documento: tipo_identificacion.value,
        documento: documento.value,
        nombre: nombre.value,

    }).then(({ data }) => {
        infoCliente.value = data.data
        Swal.fire({
            icon: 'success',
            title: 'Registro creado con exito'
        })
        setTimeout(() => {
            location.reload();
        }, 2000);
        // creado.value = false
    })
}

</script>

<template>
    <LayoutCLient>
        <div class="row">

            <div v-if="creado == false && !infoCliente.tipo_documento" class="col-lg-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Información del cliente
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-6" has-validation>
                                <label for="tipo_identificacion">Tipo de Identificación <span class="text-danger">
                                        *</span></label>
                                <select id="inputState" class="form-control" v-model="tipo_identificacion">
                                    <option value="" selected>Seleccione...</option>
                                    <option value="CC">CC</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                    <option value="NIT">NIT</option>
                                </select>
                                <div v-if="tipo_identificacion == ''" class="invalid-feedback d-block">El
                                    campo es
                                    requerido
                                </div>

                            </div>

                            <div class="form-group col-6" has-validation>
                                <label for="documento">Numero de Identificación <span class="text-danger">
                                        *</span></label>
                                <input v-model="documento" type="text" class="form-control" id="documento"
                                    aria-describedby="documento" autocomplete="off">
                                <div v-if="documento == ''" class="invalid-feedback d-block">El
                                    campo es
                                    requerido
                                </div>
                            </div>

                            <div class="form-group col-12" has-validation>
                                <label for="nombre">Nombre <span class="text-danger">
                                        *</span></label>
                                <input v-model="nombre" type="text" class="form-control" id="nombre"
                                    aria-describedby="nombre" autocomplete="off">
                                <div v-if="nombre == ''" class="invalid-feedback d-block">El campo es
                                    requerido
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 mt-4">
                                <button class="btn btn-success float-right" @click="save"> Guardar </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div v-if="infoCliente.tipo_documento && solicitudes.length < 1" class="col-lg-12 mt-4">
                <div class="row">
                    <div v-for="product in productos" :key="product.id" class="m-2 col-12 col-md-3 ">

                        <div class="card card-widget widget-user">

                            <div class="widget-user-header bg-info">
                                <h3 class="widget-user-username">{{ product.producto }}</h3>
                                <h5 class="widget-user-desc">{{ product.nombre }}</h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">M. Minimo</h5>
                                            <span class="description-text">$ {{ product.monto_minimo }}</span>
                                        </div>

                                        <div class="description-block">
                                            <h5 class="description-header">T. Minimo</h5>
                                            <span class="description-text">{{ product.tiempo_minimo }}</span>
                                        </div>

                                    </div>

                                    <div class="col-sm-6 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">M. Maximo</h5>
                                            <span class="description-text">$ {{ product.monto_maximo }}</span>
                                        </div>

                                        <div class="description-block">
                                            <h5 class="description-header">T. Maximo</h5>
                                            <span class="description-text">{{ product.tiempo_maximo }}</span>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12">
                                        <button @click="simuladorMonto(product.interes, product.id)"
                                            class="btn btn-block btn-success">Simular</button>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div v-if="solicitudes.length > 0 && mostrarSolicitud == false" class="col-lg-12 mt-4">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Lista de solictudes</h4>
                        <div class="card-tools">
                            <button class="btn btn-sm btn-primary" @click="crearSolicitud">
                                <i class="fas fa-plus"></i> Crear solicitud </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class='col-12'>
                                <div class='table-responsive'>
                                    <table class='table table-bordered table-striped table-hover table-title'>
                                        <thead style='background-color: black; color: white'>
                                            <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>
                                                    Nombre del producto
                                                </th>
                                                <th>
                                                    Monto solicitado
                                                </th>
                                                <th>
                                                    Tiempo en meses
                                                </th>
                                                <th>
                                                    Rstado solicitud
                                                </th>

                                                <th class="border text-center">
                                                    <i class='fa fa-cogs '></i>
                                                </th>
                                            </tr>

                                        </thead>

                                        <tbody>
                                            <tr v-for=" ( item_data, i ) in solicitudes " :key='i'>

                                                <td>
                                                    {{ i + 1 }}
                                                </td>
                                                <td>
                                                    {{ item_data.producto.nombre_producto }} {{
                item_data.producto.nombre }}
                                                </td>
                                                <td>
                                                    {{ item_data.monto }}
                                                </td>
                                                <td>
                                                    {{ item_data.tiempo }}
                                                </td>

                                                <td class=" text-center">
                                                    <span v-if="item_data.estado_solicitud == 'En Tramite'"
                                                        class="badge badge-warning p-2">
                                                        {{ item_data.estado_solicitud }}
                                                    </span>
                                                    <span v-if="item_data.estado_solicitud == 'Solicitado'"
                                                        class="badge badge-info p-2">
                                                        {{ item_data.estado_solicitud }}
                                                    </span>
                                                    <span v-if="item_data.estado_solicitud == 'Aceptado'"
                                                        class="badge badge-success p-2">
                                                        {{ item_data.estado_solicitud }}
                                                    </span>
                                                    <span v-if="item_data.estado_solicitud == 'Denegado'"
                                                        class="badge badge-danger p-2">
                                                        {{ item_data.estado_solicitud }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class='d-flex flex-row justify-content-center'>

                                                        <button class="btn mr-1 btn-xs bg-info btn-round"
                                                            data-toggle="tooltip" title="Ver"
                                                            @click="editarCredito(item_data.id)">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- <Link class="btn mr-1 btn-xs bg-info btn-round" data-toggle="tooltip"
                                                            title="Editar" @click='editItem(item_data)' v-if="permissions.update">
                                                        <i class="fas fa-edit"></i>
                                                        </Link> -->

                                                        <!-- <button class="btn mr-1 btn-xs bg-danger btn-round"
                                                            data-toggle="tooltip" title="Eliminar"
                                                            @click='deleteItem(item_data.id)' v-if="permissions.delete">
                                                            <i class='fas fa-trash'></i>
                                                        </button> -->

                                                    </div>
                                                </td>

                                            </tr>

                                            <tr v-show='solicitudes.length == 0'>
                                                <td colspan="6">
                                                    <center>No existen registros</center>
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>

            <div v-if="mostrarSolicitud" class="col-lg-12 mt-4">
                <div class="row">
                    <div v-for="product in productos" :key="product.id" class="m-2 col-12 col-md-3 ">

                        <div class="card card-widget widget-user">

                            <div class="widget-user-header bg-info">
                                <h3 class="widget-user-username">{{ product.producto }}</h3>
                                <h5 class="widget-user-desc">{{ product.nombre }}</h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">M. Minimo</h5>
                                            <span class="description-text">$ {{ product.monto_minimo }}</span>
                                        </div>

                                        <div class="description-block">
                                            <h5 class="description-header">T. Minimo</h5>
                                            <span class="description-text">{{ product.tiempo_minimo }}</span>
                                        </div>

                                    </div>

                                    <div class="col-sm-6 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">M. Maximo</h5>
                                            <span class="description-text">$ {{ product.monto_maximo }}</span>
                                        </div>

                                        <div class="description-block">
                                            <h5 class="description-header">T. Maximo</h5>
                                            <span class="description-text">{{ product.tiempo_maximo }}</span>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12">
                                        <button @click="simuladorMonto(product)"
                                            class="btn btn-block btn-success">Simular</button>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Modal Monto -->
            <div class="modal fade" id="modalMontoSimulador" data-backdrop="static" tabindex="-1"
                aria-labelledby="modalMontoSimuladorLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <!-- <div class="modal-dialog modal-xl"> -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalMontoSimuladorrLabel">Simulador</h5>

                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-7">
                                    <label for="monto_solicitar">Monto a solicitar <span
                                            class="text-danger">*</span></label>
                                    <input v-model="monto_solicitar" type="text" class="form-control"
                                        id="monto_solicitar" aria-describedby="monto_solicitar" autocomplete="off">
                                </div>

                                <div class="form-group col-5">
                                    <label for="tiempo_pagar">Tiempo mes<span class="text-danger">*</span></label>
                                    <input v-model="tiempo_pagar" type="number" class="form-control" id="tiempo_pagar"
                                        aria-describedby="tiempo_pagar" autocomplete="off">
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" @click="limpiar" class="btn btn-secondary"
                                data-dismiss="modal">Cancelar</button>

                            <button type="button" @click="simulador" class="btn btn-primary">Simular</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalSimulador" data-backdrop="static" tabindex="-1"
                aria-labelledby="modalSimuladorLabel" aria-hidden="true">
                <!-- <div class="modal-dialog"> -->
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalSimuladorLabel">Simulador Valor a solicitar $ {{
                monto_solicitar }}</h5>

                        </div>
                        <div class="modal-body">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Mes</th>
                                        <th scope="col">Cuota</th>
                                        <th scope="col">Interés</th>
                                        <th scope="col">Valor Capital</th>
                                        <th scope="col">Saldo Pendiente</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                        <th scope="row">1</th>
                                        <td>$475,124</td>
                                        <td>$104,000</td>
                                        <td>$371,124</td>
                                        <td>$4,628,876</td>
                                    </tr> -->
                                    <tr v-for="fila in tablaAmortizacion" :key="fila.fecha">
                                        <td scope="row">{{ fila.fecha }}</td>
                                        <td>{{ fila.cuota }}</td>
                                        <td>{{ fila.interes }}</td>
                                        <td>{{ fila.amortizacion }}</td>
                                        <td>{{ fila.saldoPendiente }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="modal-footer">
                            <button type="button" @click="limpiar" class="btn btn-secondary"
                                data-dismiss="modal">Cancelar</button>
                            <!-- <Link class="btn btn-primary"
                                :href="`/primera-solicitud/${infoCliente.id}/${monto_solicitar}/${tiempo_pagar}`">
                            Solicitar
                            </Link> -->
                            <button type="button" @click="solicitarCredito()" class="btn btn-primary">Solicitar</button>
                        </div>
                    </div>
                </div>
            </div>


            <div v-if="creado == true" class="col-lg-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Solicitudes
                    </div>

                    <div class="card-body">
                        <Solicitudes />
                    </div>
                </div>
            </div>


        </div>
    </LayoutCLient>
</template>
