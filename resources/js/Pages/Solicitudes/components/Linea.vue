<script setup>
import { onMounted, ref } from 'vue';
const props = defineProps(['linea'])

onMounted(() => {
    linea.value = props.linea
    // console.log('Referencia', props.linea)
})

const linea = ref('')

</script>

<template>
    <div class="row">

        <div class="col-4">
            <b>Tipo linea crédito</b>
            <p>{{ linea.tipo_credito }}</p>
        </div>
        <div class="col-4">
            <b>Oficina</b>
            <p>{{ linea.oficina_credito }}</p>
        </div>
        <div class="col-4">
            <b>Vendedor</b>
            <p>{{ linea.vendedor_credito }}</p>
        </div>
        <div class="col-4">
            <b>Monto Solicitado</b>
            <p>{{ linea.monto_solicitado_credito }}</p>
        </div>
        <div class="col-4">
            <b>Forma de Pago</b>
            <p>{{ linea.forma_pago_credito }}</p>
        </div>

    </div>
</template>