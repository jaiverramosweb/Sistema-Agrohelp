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
const terminos = ref('')
const tablaAmortizacion = ref([])
const product_id = ref(0)
const tipoAmortizacion = ref('')

const getCaracteristicas = () => {
    axios.get('/get-product-caract').then(({ data }) => {
        productos.value = data
    })
}

const simuladorMonto = (producto) => {

    console.log(producto)

    tasa.value = producto.interes
    terminos.value = producto.terminos_condiciones
    product_id.value = producto.id
    tipoAmortizacion.value = producto.cobro_intereses
    // tipoAmortizacion.value = 'Inglés'

    console.log(producto)

    $("#modalMontoSimulador").modal("show");
}

const simulador = () => {
    $("#modalMontoSimulador").modal("hide");

    metodoFrances()

    setInterval(() => {
        $("#modalSimulador").modal("show");
    }, 1000);

}

// const metodoFrances = () => {

//     const tasaMensual = tasa.value / 100 / 12;
//     const cuota = (monto_solicitar.value * tasaMensual) / (1 - Math.pow(1 + tasaMensual, - tiempo_pagar.value));
//     let saldoPendiente = monto_solicitar.value;
//     tablaAmortizacion.value = [];
//     let fecha = new Date();
//     for (let i = 1; i <= tiempo_pagar.value; i++) {
//         const interes = saldoPendiente * tasaMensual;
//         const amortizacion = cuota - interes;
//         saldoPendiente -= amortizacion;
//         tablaAmortizacion.value.push({
//             fecha: fecha.toLocaleDateString(),
//             cuota: cuota.toFixed(2),
//             interes: interes.toFixed(2),
//             amortizacion: amortizacion.toFixed(2),
//             saldoPendiente: saldoPendiente.toFixed(2)
//         });
//         fecha.setMonth(fecha.getMonth() + 1);
//     }
// }

function metodoFrances() {

    let tipoCuotras = 1

    if (tipoAmortizacion.value == 'Trimestral') {
        tipoCuotras = 3
    }
    if (tipoAmortizacion.value == 'Semestral') {
        tipoCuotras = 6
    }

    // Parámetros
    const r_mensual = tasa.value / 12 / 100; // Tasa de interés mensual
    const capital_trimestral = monto_solicitar.value / (tiempo_pagar.value / tipoCuotras); // Pago de capital trimestral
    const fecha_inicial = new Date(); // Fecha actual
    let saldo_pendiente = monto_solicitar.value;

    // Array para almacenar los pagos
    tablaAmortizacion.value = [];

    for (let i = 0; i < tiempo_pagar.value; i++) {
        let pago_interes = saldo_pendiente * r_mensual;
        let pago_capital = 0;

        // Si es el último mes del trimestre, se paga el capital
        if ((i + 1) % tipoCuotras === 0) {
            pago_capital = capital_trimestral;
        }

        let cuota = pago_interes + pago_capital;
        saldo_pendiente -= pago_capital;

        // Generar la fecha del pago
        let fecha_pago = new Date(fecha_inicial);
        fecha_pago.setMonth(fecha_inicial.getMonth() + i);

        // Añadir al array de amortización
        tablaAmortizacion.value.push({
            fecha: fecha_pago.toLocaleDateString(),
            cuota: cuota.toFixed(2),
            interes: pago_interes.toFixed(2),
            amortizacion: pago_capital.toFixed(2),
            saldoPendiente: saldo_pendiente.toFixed(2)
        });
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

const formatearMoneda = (numero) => {
    const num = parseFloat(numero)
    return '$ ' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
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

            <div v-if="creado == false && !infoCliente" class="col-lg-12 mt-4">
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
                                <label for="nombre">Nombre y Apellidos<span class="text-danger">
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

            <div v-if="infoCliente" class="col-lg-12 mt-4">
                <div class="row">
                    <div v-for="product in productos" :key="product.id" class="m-2 col-12 col-md-3 ">

                        <div class="card card-widget widget-user">

                            <div class="bg-secondary text-center p-2">
                                <h3 class="widget-user-username">{{ product.producto }} {{ product.nombre }}
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-12 mb-4 text-center">
                                        <span class="h4">Monto hasta</span> <br>
                                        <span class="description-text h5">{{ formatearMoneda(product.monto_maximo)
                                            }}</span> <br>
                                        <span>O segun cuerdos</span>
                                    </div>

                                    <div class="col-12  text-center">
                                        <span class="h4">Tiempo hasta</span> <br>
                                        <span class="description-text h5">{{ product.tiempo_maximo }} meses</span> <br>
                                        <span>O segun cuerdos</span>
                                    </div>

                                    <div class="col-12 mt-3">
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

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Mes</th>
                                            <th scope="col">Valor Capital</th>
                                            <th scope="col">Interés</th>
                                            <th scope="col">Cuota</th>
                                            <th scope="col">Saldo Pendiente</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="fila in tablaAmortizacion" :key="fila.fecha">
                                            <td scope="row">{{ fila.fecha }}</td>
                                            <td>{{ formatearMoneda(fila.amortizacion) }}</td>
                                            <td>{{ formatearMoneda(fila.interes) }}</td>
                                            <td>{{ formatearMoneda(fila.cuota) }}</td>
                                            <td>{{ formatearMoneda(fila.saldoPendiente) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <span class="mt-4">
                                <h5>Terminos y condiciones</h5>
                                <p>
                                    {{ terminos }}
                                </p>
                            </span>
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

<style scoped>
.badge-yellow {
    background-color: white;
    border: 2px solid rgb(233, 233, 29);
}

.badge-green {
    background-color: white;
    border: 2px solid rgb(18, 183, 18);
}

.badge-red {
    background-color: white;
    border: 2px solid rgb(231, 64, 64);
}

.badge-blue {
    background-color: white;
    border: 2px solid rgb(71, 71, 243);
}
</style>
