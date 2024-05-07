<script setup>
import { onMounted, ref } from 'vue';
const props = defineProps(['referencias'])

onMounted(() => {
    referencias.value = props.referencias
    // console.log('Referencia', props.referencias)
})

const referencias = ref('')

</script>

<template>
    <div class="row">
        <h5 class="col-12">BANCARIA</h5>

        <div class="col-4">
            <b>Banco</b>
            <p>{{ referencias.banco }}</p>
        </div>
        <div class="col-4">
            <b>Sucursal</b>
            <p>{{ referencias.sucursal }}</p>
        </div>
        <div class="col-4">
            <b>Cta. Cte. No.</b>
            <p>{{ referencias.banco_numero }}</p>
        </div>

        <div class="col-4">
            <b>Banco</b>
            <p>{{ referencias.banco_numero }}</p>
        </div>
        <div class="col-4">
            <b>Sucursal</b>
            <p>{{ referencias.sucursal_dos }}</p>
        </div>
        <div class="col-4">
            <b>Cta. Cte. No.</b>
            <p>{{ referencias.banco_numero_dos }}</p>
        </div>

        <h5 class="col-12 mt-4">COMERCIAL</h5>

        <div class="col-4">
            <b>Nombre</b>
            <p>{{ referencias.nombre_comercal }}</p>
        </div>
        <div class="col-4">
            <b>Dirección y Ciudad</b>
            <p>{{ referencias.direccion_comercal }}</p>
        </div>
        <div class="col-4">
            <b>Teléfono</b>
            <p>{{ referencias.telefono_comercal }}</p>
        </div>

        <div class="col-4">
            <b>Nombre</b>
            <p>{{ referencias.nombre_comercal_dos }}</p>
        </div>
        <div class="col-4">
            <b>Dirección y Ciudad</b>
            <p>{{ referencias.direccion_comercal_dos }}</p>
        </div>
        <div class="col-4">
            <b>Teléfono</b>
            <p>{{ referencias.telefono_comercal_dos }}</p>
        </div>

        <h5 class="col-12 mt-4">FAMILIAR</h5>

        <div class="col-4">
            <b>Nombre</b>
            <p>{{ referencias.nombre_familiar }}</p>
        </div>
        <div class="col-4">
            <b>Dirección y Ciudad</b>
            <p>{{ referencias.direccion_familiar }}</p>
        </div>
        <div class="col-4">
            <b>Teléfono</b>
            <p>{{ referencias.telefono_familiar }}</p>
        </div>

        <div class="col-4">
            <b>Nombre</b>
            <p>{{ referencias.nombre_familiar_dos }}</p>
        </div>
        <div class="col-4">
            <b>Dirección y Ciudad</b>
            <p>{{ referencias.direccion_familiar_dos }}</p>
        </div>
        <div class="col-4">
            <b>Teléfono</b>
            <p>{{ referencias.telefono_familiar_dos }}</p>
        </div>

    </div>
</template>