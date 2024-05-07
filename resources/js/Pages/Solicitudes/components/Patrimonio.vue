<script setup>
import { onMounted, ref } from 'vue';
const props = defineProps(['patrimonio'])

onMounted(() => {
    patrimonio.value = props.patrimonio
    // console.log('Referencia', props.linea)
})

const patrimonio = ref('')

</script>

<template>
    <div class="row">
        <h5 class="col-12">BIENES INMUEBLES</h5>

        <div class="col-4">
            <b>Descripción</b>
            <p>{{ patrimonio.descripcion_bien }}</p>
        </div>
        <div class="col-4">
            <b>Ciudad</b>
            <p>{{ patrimonio.ciudad_bien }}</p>
        </div>
        <div class="col-4">
            <b>Hipoteca</b>
            <p>{{ patrimonio.hipoteca_bien }}</p>
        </div>
        <div class="col-4">
            <b>Avaluo comercial</b>
            <p>{{ patrimonio.avaluo_comercial_bien }}</p>
        </div>
        <div class="col-4">
            <b>Avaluo catastral</b>
            <p>{{ patrimonio.avaluo_catastral_bien }}</p>
        </div>
        <div class="col-4">
            <b>Cédula catastral No.</b>
            <p>{{ patrimonio.cedula_catastral_bien }}</p>
        </div>
        <div class="col-4">
            <b>Matricula inmobiliarial No.</b>
            <p>{{ patrimonio.matricula_bien }}</p>
        </div>
        <div class="col-4">
            <b>Escribura pública No.</b>
            <p>{{ patrimonio.escritura_bien }}</p>
        </div>
        <div class="col-4">
            <b>Notaria</b>
            <p>{{ patrimonio.notaria_bien }}</p>
        </div>
        <div class="col-4">
            <b>Fecha</b>
            <p>{{ patrimonio.fecha_bien }}</p>
        </div>
        <div class="col-4">
            <b>Ciudad</b>
            <p>{{ patrimonio.ciudad_parimonio_bien }}</p>
        </div>

        <div v-if="patrimonio.descripcion_bien_dos" class="col-12">
            <div class="row">
                <h6 class="col-12">SEGUNDO BIENES INMUEBLES</h6>
                <div class="col-4">
                    <b>Descripción</b>
                    <p>{{ patrimonio.descripcion_bien_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Ciudad</b>
                    <p>{{ patrimonio.ciudad_bien_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Hipoteca</b>
                    <p>{{ patrimonio.hipoteca_bien_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Avaluo comercial</b>
                    <p>{{ patrimonio.avaluo_comercial_bien_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Avaluo catastral</b>
                    <p>{{ patrimonio.avaluo_catastral_bien_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Cédula catastral No.</b>
                    <p>{{ patrimonio.cedula_catastral_bien_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Matricula inmobiliarial No.</b>
                    <p>{{ patrimonio.matricula_bien_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Escribura pública No.</b>
                    <p>{{ patrimonio.escritura_bien_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Notaria</b>
                    <p>{{ patrimonio.notaria_bien_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Fecha</b>
                    <p>{{ patrimonio.fecha_bien_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Ciudad</b>
                    <p>{{ patrimonio.ciudad_parimonio_bien_dos }}</p>
                </div>
            </div>
        </div>

        <div v-if="patrimonio.descripcion_bien_tres" class="col-12">
            <div class="row">
                <h6 class="col-12">TRECER BIENES INMUEBLES</h6>
                <div class="col-4">
                    <b>Descripción</b>
                    <p>{{ patrimonio.descripcion_bien_tres }}</p>
                </div>
                <div class="col-4">
                    <b>Ciudad</b>
                    <p>{{ patrimonio.ciudad_bien_tres }}</p>
                </div>
                <div class="col-4">
                    <b>Hipoteca</b>
                    <p>{{ patrimonio.hipoteca_bien_tres }}</p>
                </div>
                <div class="col-4">
                    <b>Avaluo comercial</b>
                    <p>{{ patrimonio.avaluo_comercial_bien_tres }}</p>
                </div>
                <div class="col-4">
                    <b>Avaluo catastral</b>
                    <p>{{ patrimonio.avaluo_catastral_bien_tres }}</p>
                </div>
                <div class="col-4">
                    <b>Cédula catastral No.</b>
                    <p>{{ patrimonio.cedula_catastral_bien_tres }}</p>
                </div>
                <div class="col-4">
                    <b>Matricula inmobiliarial No.</b>
                    <p>{{ patrimonio.matricula_bien_tres }}</p>
                </div>
                <div class="col-4">
                    <b>Escribura pública No.</b>
                    <p>{{ patrimonio.escritura_bien_tres }}</p>
                </div>
                <div class="col-4">
                    <b>Notaria</b>
                    <p>{{ patrimonio.notaria_bien_tres }}</p>
                </div>
                <div class="col-4">
                    <b>Fecha</b>
                    <p>{{ patrimonio.fecha_bien_tres }}</p>
                </div>
                <div class="col-4">
                    <b>Ciudad</b>
                    <p>{{ patrimonio.ciudad_parimonio_bien_tres }}</p>
                </div>
            </div>
        </div>

        <hr class="col-11" />

        <h5 class="col-12">VEHICULOS</h5>

        <div class="col-4">
            <b>Marca</b>
            <p>{{ patrimonio.marca_vehiculo }}</p>
        </div>
        <div class="col-4">
            <b>Clase</b>
            <p>{{ patrimonio.clase_vehiculo }}</p>
        </div>
        <div class="col-4">
            <b>Modelo</b>
            <p>{{ patrimonio.modelo_vehiculo }}</p>
        </div>
        <div class="col-4">
            <b>Placa</b>
            <p>{{ patrimonio.placa_vehiculo }}</p>
        </div>
        <div class="col-4">
            <b>Valor comercial</b>
            <p>{{ patrimonio.valor_vehiculo }}</p>
        </div>
        <div class="col-4">
            <b>Pigmentado</b>
            <p>{{ patrimonio.hipoteca_vehiculo }}</p>
        </div>

        <div v-if="patrimonio.marca_vehiculo_dos" class="col-12">
            <h6 class="col-12">SEGUNDO VEHICULOS</h6>
            <div class="row">
                <div class="col-4">
                    <b>Marca</b>
                    <p>{{ patrimonio.marca_vehiculo_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Clase</b>
                    <p>{{ patrimonio.clase_vehiculo_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Modelo</b>
                    <p>{{ patrimonio.modelo_vehiculo_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Placa</b>
                    <p>{{ patrimonio.placa_vehiculo_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Valor comercial</b>
                    <p>{{ patrimonio.valor_vehiculo_dos }}</p>
                </div>
                <div class="col-4">
                    <b>Pigmentado</b>
                    <p>{{ patrimonio.hipoteca_vehiculo_dos }}</p>
                </div>
            </div>
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