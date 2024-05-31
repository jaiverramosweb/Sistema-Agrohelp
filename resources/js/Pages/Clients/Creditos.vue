<script setup>
import { onMounted, ref } from 'vue';
import LayoutCLient from '@/Layouts/LayoutClient.vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

const props = defineProps(['info'])

onMounted(() => {
    solicitudes.value = props.info
    console.log(props.info)
})

const solicitudes = ref([])

const editarCredito = (id) => {
    window.location.href = `/editar-solicitud/${id}`;
}

const verAmortizacion = (monto, tiempo, taza, tipo) => {
    window.location.href = `/ver-amortizacion/${monto}/${tiempo}/${taza}/${tipo}`;
}

const verAprobado = (id) => {
    window.location.href = `/ver-aprobado/${id}`;
}

const descargarPre = (id) => {
    let url = '/download-pre/' + id;
    window.open(url, '_blank');
}

const crearSolicitud = () => {
    window.location.href = `/inicio`;
}

const formatearMoneda = (numero) => {
    const num = parseFloat(numero)
    return '$ ' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

</script>

<template>
    <LayoutCLient>
        <div class="row">
            <div class="card col-12 mt-4">
                <div class="card-header">
                    <h4 class="card-title">Lista de solictudes</h4>
                    <div class="card-tools">
                        <button class="btn btn-sm btn-primary" @click="crearSolicitud">
                            <i class="fas fa-plus"></i> Crear solicitud </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class='col-12'>
                            <div class='table-responsive'>
                                <table class='table table-bordered table-striped table-hover table-title'>
                                    <thead style='background-color: black; color: white'>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Línea de crédito
                                            </th>
                                            <th>
                                                Monto solicitado
                                            </th>
                                            <th>
                                                Tiempo en meses
                                            </th>
                                            <th>
                                                Estado solicitud
                                            </th>

                                            <th class="border text-center">
                                                <i class='fa fa-cogs '></i>
                                            </th>
                                        </tr>

                                    </thead>

                                    <tbody>
                                        <tr v-for=" ( item_data, i ) in solicitudes " :key='i' class="text-center">

                                            <td>
                                                {{ i + 1 }}
                                            </td>
                                            <td>
                                                {{ item_data.producto.nombre_producto }} {{
                            item_data.producto.nombre }}
                                            </td>
                                            <td>
                                                {{ formatearMoneda(item_data.monto) }}
                                            </td>
                                            <td>
                                                {{ item_data.tiempo }} meses
                                            </td>

                                            <td class=" text-center">
                                                <span v-if="item_data.estado_solicitud == 'En tramite'"
                                                    class="badge badge-yellow p-2">
                                                    {{ item_data.estado_solicitud }}
                                                </span>
                                                <span v-if="item_data.estado_solicitud == 'En estudio'"
                                                    class="badge badge-yellow p-2">
                                                    {{ item_data.estado_solicitud }}
                                                </span>
                                                <span v-if="item_data.estado_solicitud == 'Preaprobado'"
                                                    class="badge badge-blue p-2">
                                                    {{ item_data.estado_solicitud }}
                                                </span>
                                                <span v-if="item_data.estado_solicitud == 'Aprobado'"
                                                    class="badge badge-green p-2">
                                                    {{ item_data.estado_solicitud }}
                                                </span>
                                                <span v-if="item_data.estado_solicitud == 'No aprobado'"
                                                    class="badge badge-red p-2">
                                                    {{ item_data.estado_solicitud }}
                                                </span>
                                                <span v-if="item_data.estado_solicitud == 'Condiciones no aceptadas'"
                                                    class="badge badge-red p-2">
                                                    {{ item_data.estado_solicitud }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class='d-flex flex-row justify-content-center'>

                                                    <button v-if="item_data.estado_solicitud == 'En tramite'"
                                                        class="btn mr-1 btn-xs btn-outline-info btn-round"
                                                        data-toggle="tooltip" title="Ver"
                                                        @click="editarCredito(item_data.id)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <button v-if="item_data.estado_solicitud == 'Preaprobado'"
                                                        class="btn mr-1 btn-xs btn-outline-danger btn-round"
                                                        data-toggle="tooltip" title="Ver"
                                                        @click="descargarPre(item_data.id)">
                                                        <i class="fas fa-download"></i>
                                                    </button>

                                                    <button
                                                        v-if="item_data.estado_solicitud == 'En estudio' || item_data.estado_solicitud == 'Preaprobado'"
                                                        class="btn mr-1 btn-xs btn-outline-info btn-round"
                                                        data-toggle="tooltip" title="Ver"
                                                        @click="verAmortizacion(item_data.monto, item_data.tiempo, item_data.producto.interes, item_data.producto.cobro_intereses)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>

                                                    <button v-if="item_data.estado_solicitud == 'Aprobado'"
                                                        class="btn mr-1 btn-xs btn-outline-info btn-round"
                                                        data-toggle="tooltip" title="Ver"
                                                        @click="verAprobado(item_data.id)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>

                                                    <!-- <Link class="btn mr-1 btn-xs bg-info btn-round" data-toggle="tooltip"
                                                            title="Editar" @click='editItem(item_data)' v-if="permissions.update">
                                                        <i class="fas fa-edit"></i>
                                                        </Link> -->

                                                    <!-- <button class="btn mr-1 btn-xs bg-danger btn-round"
                                                            data-toggle="tooltip" title="Eliminar"
                                                            @click='deleteItem(item_data.id)' v-if="permissions.delete">
                                                            <i class='fas fa-trash'></i>
                                                        </button> -->

                                                </div>
                                            </td>

                                        </tr>

                                        <tr v-show='solicitudes.length == 0'>
                                            <td colspan="6">
                                                <center>No existen registros</center>
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>
                            </div>
                        </div>
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