<script setup>
import { onMounted, ref } from 'vue';
const props = defineProps(['creditos'])

onMounted(() => {
    creditos.value = props.creditos
    // console.log('Referencia', props.linea)
})

const creditos = ref('')

</script>

<template>
    <div class="row">
        <h4 class="col-12">CREDITO VIGENTE</h4>

        <div class="col-3">
            <b>Acreedor</b>
            <p>{{ creditos.acreedor }}</p>
        </div>
        <div class="col-3">
            <b>Telefono</b>
            <p>{{ creditos.acreedor_telefono }}</p>
        </div>
        <div class="col-3">
            <b>Valor prestamo</b>
            <p>{{ creditos.acreedor_valor }}</p>
        </div>
        <div class="col-3">
            <b>Saldo</b>
            <p>{{ creditos.acreedor_saldo }}</p>
        </div>

        <div class="col-3">
            <b>Acreedor</b>
            <p>{{ creditos.acreedor_dos }}</p>
        </div>
        <div class="col-3">
            <b>Telefono</b>
            <p>{{ creditos.acreedor_telefono_dos }}</p>
        </div>
        <div class="col-3">
            <b>Valor prestamo</b>
            <p>{{ creditos.acreedor_valor_dos }}</p>
        </div>
        <div class="col-3">
            <b>Saldo</b>
            <p>{{ creditos.acreedor_saldo_dos }}</p>
        </div>

        <hr class="col-11" />

        <h4 class="col-12">TARJETA DE CREDITO</h4>

        <div class="col-3">
            <b>Nombre - Banco</b>
            <p>{{ creditos.banco_tarjeta }}</p>
        </div>
        <div class="col-3">
            <b>Antoguedad</b>
            <p>{{ creditos.banco_antoguedad }}</p>
        </div>
        <div class="col-3">
            <b>Número</b>
            <p>{{ creditos.banco_numero_antoguedad }}</p>
        </div>
        <div class="col-3">
            <b>Cupo máximo</b>
            <p>{{ creditos.banco_cupo }}</p>
        </div>

        <div class="col-3">
            <b>Nombre - Banco</b>
            <p>{{ creditos.banco_tarjeta_dos }}</p>
        </div>
        <div class="col-3">
            <b>Antoguedad</b>
            <p>{{ creditos.banco_antoguedad_dos }}</p>
        </div>
        <div class="col-3">
            <b>Número</b>
            <p>{{ creditos.banco_numero_antoguedad_dos }}</p>
        </div>
        <div class="col-3">
            <b>Cupo máximo</b>
            <p>{{ creditos.banco_cupo_dos }}</p>
        </div>

    </div>
</template>

<style scoped>
hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}
</style>