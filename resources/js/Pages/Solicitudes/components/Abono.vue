<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
const props = defineProps(['credito'])
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

onMounted(() => {
    capital.value = props.credito.valor
    tasa.value = props.credito.tasa_interes
    getCredito()
    getAbonos()
})

const capital = ref('')
const tipo = ref(0)
const monto = ref(0)

const tasa = ref(0)

const metodo_pago = ref(0)
const metodosPago = ref([])
const ListPago = ref([])
const ListCreditos = ref([])
const tablaAmortizacion = ref([])

const abono = () => {
    getMetodoPago()
    $('#modalAbono').modal('show');
}

const getMetodoPago = () => {
    axios.get('/get-metodo-pago').then(({ data }) => {
        metodosPago.value = data
    })
}

const getCredito = () => {
    axios.get(`/get-creditos/${props.credito.id}`).then(({data}) => {
        ListCreditos.value = data
    })
}

const generarPago = () => {

    if(tipo.value == 'Capital'){
        if(props.credito.cobro_intereses == 'Mensual'){
            amortizacionMensual()
        } else {
            amortizacionVariable()
        }
    
        if(tablaAmortizacion.value.length > 0){
            // console.log(tablaAmortizacion.value)
            pagarAbono()
        }
    }

}

const amortizacionMensual = () => {
    const r_mensual = tasa.value / 100;
    const tiempo_pagar = ListCreditos.value.length;
    const [dia, mes, año] = ListCreditos.value[0].fecha.split('/');
    const newMes = (mes - 1)
    let mesCuota = ListCreditos.value[0].cuota_numero
    const fecha_inicial = new Date(`${newMes.toString()}/${dia}/${año}`);

    const pago = capital.value - monto.value

    // Calcular la tasa efectiva para el período seleccionado
    const r_periodica = Math.pow(1 + r_mensual, 1) - 1;

    // Calcular la cuota periódica ajustada para la periodicidad
    const n_periodos = Math.ceil(tiempo_pagar / 1);
    const cuota_periodica = pago * r_periodica / (1 - Math.pow(1 + r_periodica, -n_periodos));

    tablaAmortizacion.value = [];
    let saldo_pendiente = parseFloat(pago);


    for (let mes = 1; mes <= tiempo_pagar; mes++) {
        let pago_interes = saldo_pendiente * r_mensual;
        let pago_principal = 0;
        let cuota_actual = 0;

        // Realizar el pago de capital solo en los meses correspondientes a la periodicidad seleccionada
        if (mes % 1 === 0 || mes === tiempo_pagar) {
            cuota_actual = cuota_periodica;
            pago_principal = cuota_actual - pago_interes;
            saldo_pendiente -= pago_principal;

            // Ajustar el saldo pendiente al final para corregir pequeños errores de redondeo
            if (mes === tiempo_pagar && Math.abs(saldo_pendiente) < 1) {
                saldo_pendiente = 0;
            }
        } else {
            cuota_actual = pago_interes;
        }

        let fecha_pago = new Date(fecha_inicial);
        fecha_pago.setMonth(fecha_inicial.getMonth() + mes);

        tablaAmortizacion.value.push({
            mes: mesCuota,
            fecha: fecha_pago.toLocaleDateString(),
            cuota: cuota_actual.toFixed(2),
            amortizacion: pago_principal.toFixed(2),
            interes: pago_interes.toFixed(2),
            saldoPendiente: saldo_pendiente.toFixed(2)
        });

        mesCuota += 1
    }
}

const amortizacionVariable = () => {

let tipoCuotras = 1
let taza_interes = 0

if (props.credito.cobro_intereses == 'Trimestral') {
    tipoCuotras = 3
}
if (props.credito.cobro_intereses == 'Semestral') {
    tipoCuotras = 6
}

if(tipo_interes.value == 'ibr'){
    taza_interes = interes_mas.value + tasa.value
} else {
    taza_interes =  tasa.value
}

const tiempo_pagar = ListCreditos.value.length
const pago = capital.value - monto.value

// monto_aprobar.value = monto_solicitar.value * 0.7

// Parámetros
const r_mensual = taza_interes / 100; // Tasa de interés mensual
const capital = pago / (tiempo_pagar / tipoCuotras); // Pago de capital trimestral
const fecha_inicial = ListCreditos.value[0].fecha; // Fecha actual
let saldo_pendiente = pago;

// Array para almacenar los pagos
tablaAmortizacion.value = [];

for (let i = 0; i < tiempo_pagar; i++) {
    let pago_interes = saldo_pendiente * r_mensual;
    let pago_capital = 0;

    // Si es el último mes del trimestre, se paga el capital
    if ((i + 1) % tipoCuotras === 0) {
        pago_capital = capital;
    }

    let cuota = pago_interes + pago_capital;
    // const cuota = (r_mensual * monto.value) / (1- Math.pow((1 + r_mensual), -tiempo))
    saldo_pendiente -= pago_capital;

    // Generar la fecha del pago
    let fecha_pago = new Date(fecha_inicial);
    fecha_pago.setMonth(fecha_inicial.getMonth() + i);

    // Añadir al array de amortización
    tablaAmortizacion.value.push({
        mes:i + 1,
        fecha: fecha_pago.toLocaleDateString(),
        cuota: cuota.toFixed(2),
        interes: pago_interes.toFixed(2),
        amortizacion: pago_capital.toFixed(2),
        saldoPendiente: saldo_pendiente.toFixed(2)
    });
}

}

const pagarAbono = () => {
    axios.post('/pagar-abono', {
        id: props.credito.id,
        capital: capital.value - monto.value,
        tipo: tipo.value,
        monto: monto.value,
        metodo_pago_id: metodo_pago.value,
        tablaAmortizacion: tablaAmortizacion.value,
    }).then(({data}) => {
        Swal.fire({
            icon: 'success',
            title: 'Abonado con exito'
        })
        getAbonos()
    })
}

const getAbonos = () => {
    axios.get(`/get-abonos/${props.credito.id}`).then(({data}) => {
        ListPago.value = data
    })
}

const descargar = (id) => {
    let url = '/download-abono/' + id;
    window.open(url, '_blank');
}

const formatearMoneda = (numero) => {
    const num = parseFloat(numero)
    return '$ ' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

const formatDate = (date) => {
    let dateString = date.substring(0, 10);
    return dateString
}
</script>

<template>
    <div class="row">
        <div class="col-12">
            <b>Capital: {{ formatearMoneda(capital) }}</b>
            <div class="float-right">
                <button @click="abono" class="btn btn-success">+ Agregar</button>
            </div>
        </div>

        <div class="col-12">
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Metodo pago</th>
                        <th>Fecha</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="ListPago.length == 0">
                        <td colspan="5" class="text-center">
                            No existen registros
                        </td>
                    </tr>
                    <tr v-else v-for="(pago, i) in ListPago" :key="pago.id">
                        <td>{{ i + 1 }}</td>
                        <td>{{ pago.tipo }}</td>
                        <td>{{ pago.name }}</td>
                        <td>{{ formatearMoneda(pago.monto) }}</td>
                        <td>{{ formatDate(pago.created_at) }}</td>
                        <td>
                            <button @click="descargar(pago.id)" class="btn btn-outline-danger">
                                <i class="far fa-file-pdf"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal recibo -->
    <div class="modal fade" id="modalAbono" data-backdrop="static" tabindex="-1"
        aria-labelledby="modalAbonoLabel" aria-hidden="true">
        <!-- <div class="modal-dialog"> -->
            <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAbonoLabel">Agregar abono</h5>

                </div>
                <div class="modal-body">
                   <div class="row">
                        <div class="form-group col-3">
                            <label for="tasa">Tipo de abono</label>
                            <select id="inputState" class="form-control" v-model="tipo">
                                <option value="" selected>Seleccione...</option>
                                <option value="Capital">Capital</option>
                                <option value="Tiempo">Redicción de tiempo</option>
                                <option value="Total">Pago total</option>
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="tasa">Monto</label>
                            <input v-model="monto" type="number" class="form-control" id="tasa" aria-describedby="tasa"
                                autocomplete="off">
                        </div>
                        <div class="form-group col-3">
                            <label for="tasa">Metodo de pago</label>
                            <select class="form-control" v-model="metodo_pago">
                                <option value="0">Seleccione</option>
                                <option v-for="metodo in metodosPago" :key="metodo.id" :value="metodo.id">{{ metodo.name
                                    }}</option>
                            </select>
                        </div>
                   </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button @click="generarPago" type="button" class="btn btn-success">Pagar</button>
                </div>
            </div>
        </div>
    </div>

</template>