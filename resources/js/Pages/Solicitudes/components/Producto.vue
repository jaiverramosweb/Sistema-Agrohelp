<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
const props = defineProps(['producto', 'interes', 'monto_solicitar', 'tiempo_pagar', 'estado', 'solicitud_id', 'tipo', 'mora', 'capital'])
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

onMounted(() => {
    producto.value = props.producto
    monto_solicitar.value = props.monto_solicitar
    tiempo_pagar.value = props.tiempo_pagar
    tasa.value = props.interes
    mora.value = props.mora
    estado.value = props.estado
    tipo.value = props.tipo
    solicitudId.value = props.solicitud_id
    capital.value = props.capital
    // console.log('estado', props.estado)
    metodoFrances()

    getAmortizacionAll()
})

const producto = ref('')

const estado = ref('')
const tipo = ref('')
const periodo = ref('bimestral')
const solicitudId = ref(0)

const pago_interes = ref(0)
const numero_cuota = ref(0)
const pago_cuota = ref(0)
const pago_capital = ref(0)
const saldo_pendiente_p = ref(0)

const metodo_pago = ref(0)

const dataPagar = ref('')
const valor_pagar = ref('')

const dataAmortizacion = ref([])
const metodosPago = ref([])

const tasa = ref('')
const mora = ref('')
const capital = ref('')
const monto_solicitar = ref('')
const tiempo_pagar = ref('')
const tablaAmortizacion = ref([])

const tablaPagos = ref([])

const metodoFrances = () => {

    let tipoCuotras = 1

    if (tipo.value == 'Trimestral') {
        tipoCuotras = 3
    }
    if (tipo.value == 'Semestral') {
        tipoCuotras = 6
    }

    // Parámetros
    const r_mensual = tasa.value / 12 / 100; // Tasa de interés mensual
    const capital_trimestral = monto_solicitar.value / (tiempo_pagar.value / tipoCuotras); // Pago de capital trimestral
    let saldo_pendiente = monto_solicitar.value;

    // Array para almacenar los pagos
    tablaAmortizacion.value = [];
    const fecha_inicial = new Date(); // Fecha actual

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

const metodoFrances2 = () => {
    const tasaMensual = tasa.value / 100 / 12;
    let cuotasPorAno = 12;
    if (periodo.value === 'bimestral') cuotasPorAno = 6;
    else if (periodo.value === 'trimestral') cuotasPorAno = 4;
    else if (periodo.value === 'cuatrimestral') cuotasPorAno = 3;
    else if (periodo.value === 'semestral') cuotasPorAno = 2;
    else if (periodo.value === 'anual') cuotasPorAno = 1;

    const cuota = (monto_solicitar.value * tasaMensual) / (1 - Math.pow(1 + tasaMensual, -tiempo_pagar.value * cuotasPorAno));
    let saldoPendiente = monto_solicitar.value;
    tablaAmortizacion.value = [];
    let fecha = new Date();
    for (let i = 1; i <= tiempo_pagar.value * cuotasPorAno; i++) {
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
        if (i % cuotasPorAno === 0) {
            fecha.setMonth(fecha.getMonth() + 1);
        }
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

const savePreaprobado = () => {
    axios.get(`/save-preaprovado/${solicitudId.value}`).then(({ data }) => {
        // console.log(data)
        estado.value = 'Preaprobado'
    })
}

const cambiarEstado = (state) => {
    axios.put(`/update-estado-solicitud/${solicitudId.value}`, { state }).then(({ data }) => {
        // console.log(data)
        estado.value = state
    })
}

const aprobado = () => {
    axios.put(`/solicitud-aprobada/${solicitudId.value}`, {
        state: 'Aprobado',
        tasa: tasa.value,
        mora: mora.value,
        tipo: tipo.value,
        monto_solicitar: monto_solicitar.value,
        tiempo_pagar: tiempo_pagar.value,
        tablaAmortizacion: tablaAmortizacion.value
    }).then(({ data }) => {
        Swal.fire({
            icon: 'success',
            title: 'Aprobado'
        })
        location.reload();
    })
}

const mostrarModal = () => {
    $("#modalModificar").modal("show");
}

const modificarValores = () => {
    axios.put(`/update-valores-solicitud/${solicitudId.value}`, {
        tasa: tasa.value,
        monto_solicitar: monto_solicitar.value,
        tiempo_pagar: tiempo_pagar.value,
    }).then(({ data }) => {
        // console.log(data)
        // estado.value = 'No aprobado'
        metodoFrances()
        $("#modalModificar").modal("hide");
    })
}

const getAmortizacionAll = () => {
    axios.get(`/amortizacion-all/${solicitudId.value}`).then(({ data }) => {
        // console.log(data)
        const info = data.map(d => {
            return {
                ...d,
                cuota: parseFloat(d.cuota).toFixed(2),
                interes: parseFloat(d.interes).toFixed(2),
                amortizacion: parseFloat(d.amortizacion).toFixed(2),
                saldo_pendiente: parseFloat(d.saldo_pendiente).toFixed(2)
            }
        })

        dataAmortizacion.value = info
    })
}

const modalPago = (item, num) => {
    getMetodoPago()

    dataPagar.value = item

    valor_pagar.value = item.cuota
    numero_cuota.value = num
    pago_interes.value = item.interes
    pago_cuota.value = item.cuota
    pago_capital.value = item.amortizacion
    saldo_pendiente_p.value = item.saldo_pendiente

    $("#modalPago").modal("show");
}

const getMetodoPago = () => {
    axios.get('/get-metodo-pago').then(({ data }) => {
        // console.log(data)
        metodosPago.value = data
    })
}

const calcularPago = () => {
    const valor = valor_pagar.value

    const id_cuota = dataPagar.value.id
    const cuota = parseFloat(pago_cuota.value)
    const interes = parseFloat(pago_interes.value)
    const capital = parseFloat(pago_capital.value)
    const saldo_pendiente = parseFloat(saldo_pendiente_p.value)


    let cuotas = []


    if (valor == cuota) {
        const p = {
            id: id_cuota,
            numero: numero_cuota.value,
            interes: interes,
            cuota: 0,
            amortizacion: capital,
            saldo_pagar: 0,
            saldo_pendiente: saldo_pendiente
        }
        cuotas.push(p)
    }

    if (valor < cuota) {
        let saldo = valor
        let inte = interes
        let cuot = cuota
        let capi = capital

        if (interes < saldo) {
            saldo = valor - interes
            inte = 0

            if (saldo > 0) {
                capi = capi - saldo
                cuot = cuot - valor
                saldo = 0
            }

        } else {
            inte = interes - valor
            saldo = 0
        }

        const p = {
            id: id_cuota,
            numero: numero_cuota.value,
            interes: interes,
            cuota: parseFloat(cuot).toFixed(2),
            amortizacion: capital,
            saldo_pagar: parseFloat(saldo_pendiente - valor).toFixed(2),
            saldo_pendiente: saldo_pendiente
        }

        cuotas.push(p)

    }

    if (valor > cuota) {

        let saldo = 0

        const p = {
            id: id_cuota,
            numero: numero_cuota.value,
            interes: interes,
            cuota: 0,
            amortizacion: capital,
            saldo_pagar: 0,
            saldo_pendiente: saldo_pendiente
        }

        cuotas.push(p)

        saldo = valor - cuota

        let idBuscar = id_cuota + 1

        const nueva = dataAmortizacion.value.filter(d => d.id == idBuscar)[0]

        if (nueva) {

            console.log('saldo', saldo)

            let inte2 = parseFloat(nueva.interes)
            let cuot2 = parseFloat(nueva.cuota)
            let amor2 = parseFloat(nueva.amortizacion)

            if (inte2 < saldo) {
                console.log('saldo mayor al interes')
                const saldo2 = saldo - inte2
                inte2 = 0

                amor2 = amor2 - saldo2
                cuot2 = cuot2 - saldo
                saldo = 0


            } else {
                console.log('saldo menos al interes')
                inte2 = nueva.interes - saldo
                cuot2 = cuot2 - inte2
            }

            const p2 = {
                id: nueva.id,
                numero: numero_cuota.value + 1,
                interes2: parseFloat(nueva.interes).toFixed(2),
                interes: interes,
                cuota: parseFloat(cuot2).toFixed(2),
                amortizacion: capital,
                saldo_pagar: parseFloat(saldo_pendiente - cuot2).toFixed(2),
                saldo_pendiente: saldo_pendiente
            }

            cuotas.push(p2)

            console.log('cuota inteeres', p2)

        }

    }

    console.log('cuotas a actualizar', cuotas)

    tablaPagos.value = cuotas
}

const pagarCuota = () => {
    axios.put(`/realizar-pago/${solicitudId.value}`, {
        pagos: valor_pagar.value,
        tabla_pagos: tablaPagos.value,
        metodo_pago: metodo_pago.value

    }).then(({ data }) => {
        // console.log(data)
        valor_pagar.value = ''
        metodo_pago.value = 0
        tablaPagos.value = []
        getAmortizacionAll()
        Swal.fire({
            icon: 'success',
            title: 'Salgo agregado'
        })
        $("#modalPago").modal("hide");
    })
}

const formatDate = (date) => {
    let dateString = date.substring(0, 10);
    return dateString
}

const formatearMoneda = (numero) => {
    const num = parseFloat(numero)
    return '$ ' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

</script>

<template>

    <div v-if="dataAmortizacion.length == 0" class="row">

        <div class="col-3">
            <b>Tipo de crédito</b>
            <p>{{ producto.nombre }}</p>
        </div>
        <div class="col-3">
            <b>Tasa de interés</b>
            <p>{{ tasa }}%</p>
        </div>
        <div class="col-3">
            <b>Tipo de pago</b>
            <p>{{ producto.cobro_intereses }}</p>
        </div>
        <div class="col-3">
            <b>Monto solicitado</b>
            <p>{{ formatearMoneda(monto_solicitar) }}</p>
        </div>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th scope="col">cuotas</th>
                    <th scope="col">Mes</th>
                    <th scope="col">Cuota</th>
                    <th scope="col">Interés</th>
                    <th scope="col">Valor Capital</th>
                    <th scope="col">Saldo Pendiente</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(fila, i) in tablaAmortizacion" :key="fila.fecha">
                    <td scope="row" class="text-center">{{ i + 1 }}</td>
                    <td scope="row">{{ formatDate(fila.fecha) }}</td>
                    <td>{{ formatearMoneda(fila.cuota) }}</td>
                    <td>{{ formatearMoneda(fila.interes) }}</td>
                    <td>{{ formatearMoneda(fila.amortizacion) }}</td>
                    <td>{{ formatearMoneda(fila.saldoPendiente) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="col-12">
            <button v-if="estado == 'En estudio'" @click="savePreaprobado"
                class="btn btn-success float-right">Preaprobado</button>

            <button v-if="estado == 'Preaprobado'" @click="aprobado()"
                class="btn btn-success float-right">Aprobado</button>

            <button v-if="estado == 'Preaprobado'" @click="mostrarModal"
                class="btn btn-warning float-right mr-4">Modificar
                registro</button>


            <button v-if="estado == 'En estudio'" @click="cambiarEstado('No aprobado')" class="btn btn-danger">No
                aprobado</button>

            <button v-if="estado == 'Preaprobado'" @click="cambiarEstado('Condiciones no aceptadas')"
                class="btn btn-danger">Condiciones no aceptadas</button>
        </div>

    </div>

    <div v-else class="row">

        <div class="col-3">
            <b>Tipo de crédito solicitado</b>
            <p>{{ producto.nombre }}</p>
        </div>
        <div class="col-3">
            <b>Tasa de interés</b>
            <p>{{ tasa }}%</p>
        </div>

        <div class="col-3">
            <b>Tipo de pago</b>
            <p>{{ producto.cobro_intereses }}</p>
        </div>

        <div class="col-3">
            <b>Monto solicitado</b>
            <p>{{ formatearMoneda(monto_solicitar) }}</p>
        </div>

        <div class="col-3">
            <b>Capital</b>
            <p>{{ formatearMoneda(capital) }}</p>
        </div>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th scope="col">Nro. Cuotas</th>
                    <th scope="col">Mes</th>
                    <th scope="col">Cuota</th>
                    <th scope="col">Interés</th>
                    <th scope="col">Valor Capital</th>
                    <th scope="col">Saldo Pendiente</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(fila, i) in dataAmortizacion" :key="fila.id">
                    <td scope="row" class="text-center">{{ i + 1 }}</td>
                    <td scope="row">{{ formatDate(fila.fecha) }}</td>
                    <td>{{ formatearMoneda(fila.cuota) }}</td>
                    <td>{{ formatearMoneda(fila.interes) }}</td>
                    <td>{{ formatearMoneda(fila.amortizacion) }}</td>
                    <td>{{ formatearMoneda(fila.saldo_pendiente) }}</td>
                    <td>
                        <span v-if="!fila.estado" class="badge badge-yellow p-2">
                            Pendiente
                        </span>
                        <span v-else class="badge badge-green p-2">
                            Pagado
                        </span>
                    </td>
                    <td>
                        <button v-if="!fila.estado" class="btn btn-outline-success"
                            @click="modalPago(fila, i + 1)">Pagar</button>
                        <button v-else class="btn btn-outline-danger">
                            <i class="far fa-file-pdf"></i>

                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="col-12">
            <button v-if="estado == 'En estudio'" @click="savePreaprobado"
                class="btn btn-success float-right">Preaprobado</button>

            <button v-if="estado == 'Preaprobado'" @click="aprobado()"
                class="btn btn-success float-right">Aprobado</button>

            <button v-if="estado == 'Preaprobado'" @click="mostrarModal"
                class="btn btn-warning float-right mr-4">Modificar
                registro</button>


            <button v-if="estado == 'En estudio'" @click="cambiarEstado('No aprobado')" class="btn btn-danger">No
                aprobado</button>

            <button v-if="estado == 'Preaprobado'" @click="cambiarEstado('Condiciones no aceptadas')"
                class="btn btn-danger">Condiciones no aceptadas</button>
        </div>

    </div>


    <!-- Modal  -->
    <div class="modal fade" id="modalModificar" data-backdrop="static" tabindex="-1"
        aria-labelledby="modalModificarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- <div class="modal-dialog modal-xl"> -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalModificarLabel">Modificar registros</h5>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="tasa">Tasa de interés</label>
                            <input v-model="tasa" type="number" class="form-control" id="tasa" aria-describedby="tasa"
                                autocomplete="off">
                        </div>

                        <div class="form-group col-12">
                            <label for="monto_solicitar">Monto solicitado</label>
                            <input v-model="monto_solicitar" type="number" class="form-control" id="monto_solicitar"
                                aria-describedby="monto_solicitar" autocomplete="off">
                        </div>

                        <div class="form-group col-12">
                            <label for="tiempo_pagar">Tiempo de pago</label>
                            <input v-model="tiempo_pagar" type="number" class="form-control" id="tiempo_pagar"
                                aria-describedby="tiempo_pagar" autocomplete="off">
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                    <button type="button" class="btn btn-primary" @click="modificarValores">Modificar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pago -->
    <div class="modal fade" id="modalPago" data-backdrop="static" tabindex="-1" aria-labelledby="modalPagoLabel"
        aria-hidden="true">
        <!-- <div class="modal-dialog"> -->
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPagoLabel">Registrar pago</h5>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="tasa">Cuota</label>
                            <p>{{ formatearMoneda(pago_cuota) }}</p>
                        </div>

                        <div class="form-group col-4">
                            <label for="monto_solicitar">Interés</label>
                            <p>{{ formatearMoneda(pago_interes) }}</p>
                        </div>

                        <div class="form-group col-4">
                            <label for="tiempo_pagar">Valor Capital</label>
                            <p>{{ formatearMoneda(pago_capital) }}</p>
                        </div>

                        <div class="form-group col-4">
                            <label for="tiempo_pagar">Metodo de pago</label>
                            <select class="form-control" v-model="metodo_pago">
                                <option value="0">Seleccione</option>
                                <option v-for="metodo in metodosPago" :key="metodo.id" :value="metodo.id">{{ metodo.name
                                    }}</option>
                            </select>
                        </div>

                        <div class="form-group col-4">
                            <label for="tiempo_pagar">Monto a pagar</label>
                            <input v-model="valor_pagar" type="number" class="form-control" id="tiempo_pagar"
                                aria-describedby="tiempo_pagar" autocomplete="off">
                        </div>

                        <div class="col-4" style="margin-top: 33px;">
                            <button @click="calcularPago" class="btn btn-success float-right">Generar Pago</button>
                        </div>

                        <div v-if="tablaPagos.length > 0" class="col-12">
                            <table class="table table-bordered mt-4">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Nro. cuota</th>
                                        <th scope="col">Cuota</th>
                                        <th scope="col">Interés</th>
                                        <th scope="col">Valor Capital</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center" v-for="(fila, i) in tablaPagos" :key="i">
                                        <td scope="row">{{ fila.numero }}</td>
                                        <td>{{ fila.cuota }}</td>
                                        <td>{{ fila.interes }}</td>
                                        <td>{{ fila.amortizacion }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                    <button v-if="tablaPagos.length > 0" type="button" class="btn btn-primary"
                        @click="pagarCuota">Pagar</button>
                </div>
            </div>
        </div>
    </div>
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