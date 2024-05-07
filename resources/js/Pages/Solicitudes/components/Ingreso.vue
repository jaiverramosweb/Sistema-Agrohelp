<script setup>
import { onMounted, ref } from 'vue';
const props = defineProps(['ingreso'])

onMounted(() => {
    ingreso.value = props.ingreso
})

const ingreso = ref('')

</script>

<template>
    <div class="row">

        <h4 class="col-12">INGRESOS</h4>

        <div class="col-4">
            <b>Salario</b>
            <p>{{ ingreso.salario }}</p>
        </div>
        <div class="col-4">
            <b>Honorarios promedio</b>
            <p>{{ ingreso.honorarios }}</p>
        </div>
        <div class="col-4">
            <b>Otros ingresos</b>
            <p>{{ ingreso.otros_ingresos }}</p>
        </div>
        <div class="col-8">
            <b>Describe</b>
            <p>{{ ingreso.otros_ingresos_describe }}</p>
        </div>
        <div class="col-4">
            <b>Total</b>
            <p>{{ ingreso.total_ingresos }}</p>
        </div>

        <h4 class="col-12 mt-4">EGRESOS</h4>

        <div class="col-4">
            <b>Alquiler</b>
            <p>{{ ingreso.alquiler }}</p>
        </div>
        <div class="col-4">
            <b>Amortización crédotos vigentes</b>
            <p>{{ ingreso.amortizacion }}</p>
        </div>
        <div class="col-4">
            <b>Amortización hipoteca</b>
            <p>{{ ingreso.amortizacion_hipoteca }}</p>
        </div>
        <div class="col-4">
            <b>Pago mensual tarjetas de crédito</b>
            <p>{{ ingreso.pago_tarjetas }}</p>
        </div>
        <div class="col-4">
            <b>Otros gastos familiares</b>
            <p>{{ ingreso.otros_gastos }}</p>
        </div>
        <div class="col-4">
            <b>Total</b>
            <p>{{ ingreso.total_egresos }}</p>
        </div>

    </div>
</template>