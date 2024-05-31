<script setup>
import LayoutCLient from '@/Layouts/LayoutClient.vue';
import { onMounted, ref } from 'vue';

const props = defineProps(['monto', 'tiempo', 'taza', 'tipo'])

onMounted(() => {

    monto_solicitar.value = props.monto
    tiempo_pagar.value = props.tiempo
    tasa.value = props.taza
    tipo.value = props.tipo

    metodoFrances()
})


const tasa = ref('')
const tipo = ref('')
const monto_solicitar = ref('')
const tiempo_pagar = ref('')
const tablaAmortizacion = ref([])

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
                            Amortización solicitada
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