<script setup>
import LayoutCLient from '@/Layouts/LayoutClient.vue';
import { onMounted, ref } from 'vue';

const props = defineProps(['credito'])

onMounted(() => {

    console.log(props.credito)

    monto_solicitar.value = props.credito.monto
    tiempo_pagar.value = props.credito.tiempo
    tasa.value = props.credito.tasa_interes
    interes_mas.value = props.credito.interes_mas
    tipo_interes.value = props.credito.cobro_intereses
    tipo.value = props.credito.tipo_interes

    metodoFrances()
})


const tasa = ref('')
const interes_mas = ref(0)
const tipo = ref('')
const monto_solicitar = ref('')
const tiempo_pagar = ref('')
const tipo_interes = ref('')
const tablaAmortizacion = ref([])

const metodoFrances = () => {
    if(tipo.value == 'Mensual'){
        amortizacionMensual()
    } else {
        amortizacionVariable()
    }
}

const amortizacionMensual = () => {
    const r_mensual = tasa.value / 100;
    const fecha_inicial = new Date();

    // Calcular la tasa efectiva para el período seleccionado
    const r_periodica = Math.pow(1 + r_mensual, 1) - 1;

    // Calcular la cuota periódica ajustada para la periodicidad
    const n_periodos = Math.ceil(tiempo_pagar.value / 1);
    const cuota_periodica = monto_solicitar.value * r_periodica / (1 - Math.pow(1 + r_periodica, -n_periodos));

    tablaAmortizacion.value = [];
    let saldo_pendiente = parseFloat(monto_solicitar.value);

    for (let mes = 1; mes <= tiempo_pagar.value; mes++) {
        let pago_interes = saldo_pendiente * r_mensual;
        let pago_principal = 0;
        let cuota_actual = 0;

        // Realizar el pago de capital solo en los meses correspondientes a la periodicidad seleccionada
        if (mes % 1 === 0 || mes === tiempo_pagar.value) {
            cuota_actual = cuota_periodica;
            pago_principal = cuota_actual - pago_interes;
            saldo_pendiente -= pago_principal;

            // Ajustar el saldo pendiente al final para corregir pequeños errores de redondeo
            if (mes === tiempo_pagar.value && Math.abs(saldo_pendiente) < 1) {
                saldo_pendiente = 0;
            }
        } else {
            cuota_actual = pago_interes;
        }

        let fecha_pago = new Date(fecha_inicial);
        fecha_pago.setMonth(fecha_inicial.getMonth() + mes);

        tablaAmortizacion.value.push({
            mes: mes,
            fecha: fecha_pago.toLocaleDateString(),
            cuota: cuota_actual.toFixed(2),
            amortizacion: pago_principal.toFixed(2),
            interes: pago_interes.toFixed(2),
            saldoPendiente: saldo_pendiente.toFixed(2)
        });
    }
}

const amortizacionVariable = () => {

let tipoCuotras = 1
let taza_interes = 0

if (tipo.value == 'Trimestral') {
    tipoCuotras = 3
}
if (tipo.value == 'Semestral') {
    tipoCuotras = 6
}

if(tipo_interes.value == 'IPC'){
    taza_interes = interes_mas.value + tasa.value
} else {
    taza_interes =  tasa.value
}

// monto_aprobar.value = monto_solicitar.value * 0.7

// Parámetros
const r_mensual = taza_interes / 100; // Tasa de interés mensual
const capital = monto_solicitar.value / (tiempo_pagar.value / tipoCuotras); // Pago de capital trimestral
const fecha_inicial = new Date(); // Fecha actual
let saldo_pendiente = monto_solicitar.value;

// Array para almacenar los pagos
tablaAmortizacion.value = [];

for (let i = 0; i < tiempo_pagar.value; i++) {
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

const return_index = () => {
    window.history.back();
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
    <LayoutCLient>
        <div class="row">

            <div class="col-lg-12 mt-4">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">
                            Amortización solicitada {{ formatearMoneda(monto_solicitar) }}
                        </h3>
                        <div class="card-tools">
                            <button @click='return_index()' class='btn btn-xs bg-gray'>
                                <i class='fas fa-reply'></i> Regresar
                            </button>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="row">

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
                                    <!-- <tr>
                                    <th scope="row">1</th>
                                    <td>$475,124</td>
                                    <td>$104,000</td>
                                    <td>$371,124</td>
                                    <td>$4,628,876</td>
                                </tr> -->
                                    <tr v-for="(fila, i) in tablaAmortizacion" :key="fila.fecha">
                                        <td scope="row">{{ i + 1 }}</td>
                                        <td scope="row">{{ formatDate(fila.fecha) }}</td>
                                        <td>{{ formatearMoneda(fila.cuota) }}</td>
                                        <td>{{ formatearMoneda(fila.interes) }}</td>
                                        <td>{{ formatearMoneda(fila.amortizacion) }}</td>
                                        <td>{{ formatearMoneda(fila.saldoPendiente) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </LayoutCLient>
</template>