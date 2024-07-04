<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'
import axios from 'axios';

const props = defineProps(['permissions', 'pago'])

onMounted(() => {
    activeMenu('pago', 'lista')
    dataPagos.value = props.pago.data.data
    console.log(props.pago.data.data)
})

const activeMenu = (menu, submenu) => {
    $(".menu_" + menu).addClass('menu-is-opening menu-open')
    $("#menu_" + menu).addClass('active')
    $("#sub_menu_" + submenu).addClass('active')
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

const dataPagos = ref('')
const items = ref(0)
const infoCredito = ref(0)


const loader = ref(false)

const verPago = (item) => {
    items.value = item
    axios.get(`/info-pago/${item.id}`).then(({data}) => {
        infoCredito.value = data
        $("#modalPagos").modal("show")
    })
}

const descargar = (id) => {
    let url = '/download-pago/' + id;
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
    <AuthenticatedLayout title="Intereses">

        <div class="preloader flex-column justify-content-center align-items-center" v-if="loader">
            <img class="animation__shake" src="/assets/img/CGRLogo.png" alt="AdminLTELogo" height="100" width="200">
        </div>

        <div class="row">
            <div class="col-sm-6"></div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Inicio</a></li>
                    <li class="breadcrumb-item active">Pagos</li>
                    <li class="breadcrumb-item active">Listado</li>
                </ol>
            </div>

            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12 mb-4">
                                <b>Listado de pagos registrados</b>
                                <!-- <button class="btn btn-success float-right">
                                    Crear pago
                                </button> -->
                                <Link 
                                    v-if="permissions.create" 
                                    type="button" 
                                    class="btn btn-success float-right" 
                                    :href="route('pagos.index')"
                                >
                                Crear pago
                                </Link>
                            </div>

                            <div class='col-12'>
                                <div class='table-responsive'>
                                    <table class='table table-bordered table-striped table-hover table-title'>

                                        <thead style='background-color: black; color: white'>

                                            <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>
                                                    Cliente
                                                </th>
                                                <th>
                                                    Fecha
                                                </th>
                                                <th>
                                                    Monto
                                                </th>

                                                <th class="border text-center">
                                                    <i class='fa fa-cogs '></i>
                                                </th>
                                            </tr>

                                        </thead>

                                        <tbody>
                                            <tr v-for=" ( item_data, i ) in dataPagos " :key='i'>

                                                <td>
                                                    {{ i + 1 }}
                                                </td>
                                                <td>
                                                    {{ item_data.nombre_cliente }}
                                                </td>
                                                <td>
                                                    {{ formatDate(item_data.created_at) }}
                                                </td>
                                                <td>
                                                    {{ formatearMoneda(item_data.pago) }}
                                                </td>
                                                <td>
                                                    <div class='d-flex flex-row justify-content-center'>

                                                        <!-- <Link class="btn mr-1 btn-sm btn-outline-info btn-round"
                                                            data-toggle="tooltip" title="Editar"
                                                            @click='editItem(item_data)' v-if="permissions.update">
                                                        <i class="fas fa-edit"></i>
                                                        </Link> -->

                                                        <button class="btn mr-1 btn-sm btn-outline-warning btn-round"
                                                            data-toggle="tooltip" title="Ver"
                                                            @click="verPago(item_data)"
                                                            v-if="permissions.read">
                                                            <i class="far fa-eye"></i>
                                                        </button>

                                                    </div>
                                                </td>

                                            </tr>

                                            <tr v-show='dataPagos.length == 0'>
                                                <td colspan="4">
                                                    <center>No existen registros</center>
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalPagos" data-backdrop="static" tabindex="-1"
                                aria-labelledby="modalPagosLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <!-- <div class="modal-dialog modal-xl"> -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalPagosLabel">Información del pago de {{ items.nombre_cliente }}</h5>

                                        </div>
                                        <div class="modal-body">

                                            <div v-for="comp in infoCredito" :key="comp.id">
                                                <div class="row">
                                                    <div class="col-6 mt-2"> <b>Credito: {{ comp.credito.nombre }}</b></div>
                                                    <div class="col-6 mt-2"> <b>Monto: {{ formatearMoneda(comp.pago) }}</b></div>
                                                    <!-- <div class="col-4 mt-2"><b>Fecha: {{ formatDate(comp.created_at) }}</b> </div> -->
                                                    <!-- <div class="col-2">
                                                        <button @click="descargar(comp.id)" class="btn btn-outline-danger">
                                                            <i class="far fa-file-pdf"></i>
                                                        </button>
                                                    </div> -->
                                                </div>
                                            </div>

                                        </div>


                                        <div class="modal-footer">
                                            <button type="button" @click="clear" class="btn btn-secondary"
                                                data-dismiss="modal">Cancelar</button>
                                            <button @click="descargar(items.id)" class="btn btn-outline-danger">
                                                <i class="far fa-file-pdf"></i> Descargar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
    
</template>