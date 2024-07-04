<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'
import axios from 'axios';

const props = defineProps(['permissions', 'mora'])

onMounted(() => {
    activeMenu('config', 'mora')
    dataMoras.value = props.mora.data.data
    // pagination.value = props.mora.pagination
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

const dataMoras = ref('')

const id = ref(0)
const fecha = ref('')
const valor = ref(0.0)

const loader = ref(false)

const getMora = () => {
    axios.get('/get-mora').then(({data}) => {
        dataMoras.value = data
    })
}

const save = () => {
    axios.post('/mora', {
        fecha: fecha.value,
        valor: valor.value,
    }).then(({data}) => {
        clear()
        getMora()
        $("#modalMora").modal("hide");

        Toast.fire({
            icon: 'success',
            title: 'Realizado con exito'
        })
    })
}

const editItem = (item) => {
    id.value = item.id
    fecha.value = item.fecha
    valor.value = item.valor

    $("#modalMora").modal("show");
}

const update = () => {
    axios.put(`/mora/${id.value}`, {
        fecha: fecha.value,
        valor: valor.value
    }).then(res => {
        Toast.fire({
            icon: 'success',
            title: 'Realizado con exito'
        })
        clear()
        getMora()
        $("#modalMora").modal("hide");
    })
}

const clear = () => {
    id.value = 0
    fecha.value = ''
    valor.value = 0.0
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
                    <li class="breadcrumb-item active">Configuraciones</li>
                    <li class="breadcrumb-item active">Intereses</li>
                </ol>
            </div>

            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12 mb-4">
                                <b>Listado de Intereses Registrados</b>
                                <button class="btn btn-success float-right" data-toggle="modal" data-target="#modalMora">
                                    Agregar
                                </button>
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
                                                    Nombre
                                                </th>
                                                <th>
                                                    Valor
                                                </th>

                                                <th class="border text-center">
                                                    <i class='fa fa-cogs '></i>
                                                </th>
                                            </tr>

                                        </thead>

                                        <tbody>
                                            <tr v-for=" ( item_data, i ) in dataMoras " :key='i'>

                                                <td>
                                                    {{ i + 1 }}
                                                </td>
                                                <td>
                                                    {{ item_data.fecha }}
                                                </td>
                                                <td>
                                                    {{ item_data.valor }}
                                                </td>

                                                <td>
                                                    <div class='d-flex flex-row justify-content-center'>

                                                        <Link class="btn mr-1 btn-sm btn-outline-info btn-round"
                                                            data-toggle="tooltip" title="Editar"
                                                            @click='editItem(item_data)' v-if="permissions.update">
                                                        <i class="fas fa-edit"></i>
                                                        </Link>

                                                        <!-- <button class="btn mr-1 btn-sm btn-outline-danger btn-round"
                                                            data-toggle="tooltip" title="Eliminar"
                                                            @click='deleteItem(item_data.id)' v-if="permissions.delete">
                                                            <i class='fas fa-trash'></i>
                                                        </button> -->

                                                    </div>
                                                </td>

                                            </tr>

                                            <tr v-show='dataMoras.length == 0'>
                                                <td colspan="4">
                                                    <center>No existen registros</center>
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalMora" data-backdrop="static" tabindex="-1"
                                aria-labelledby="modalMoraLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <!-- <div class="modal-dialog modal-xl"> -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 v-if="id == 0" class="modal-title" id="modalMoraLabel">+ Nuevo Documentación</h5>
                                            <h5 v-else class="modal-title" id="modalMoraLabel">+ Actualizar Intereses</h5>

                                        </div>
                                        <div class="modal-body">

                                            <div class="row">

                                                <div class="form-group col-12" has-validation>
                                                    <label for="nombre">Fecha<span class="text-danger">
                                                            *</span></label>
                                                    <input v-model="fecha" type="date" class="form-control" id="nombre"
                                                        aria-describedby="nombre" autocomplete="off">
                                                </div>

                                                <div class="form-group col-12" has-validation>
                                                    <label for="valor">Valor<span class="text-danger">
                                                            *</span></label>
                                                    <input v-model="valor" type="number" class="form-control" id="valor"
                                                        aria-describedby="valor" autocomplete="off">
                                                </div>

                                            </div>
                                        </div>


                                        <div class="modal-footer">
                                            <button type="button" @click="clear" class="btn btn-secondary"
                                                data-dismiss="modal">Cancelar</button>
                                            <button v-if="id == 0" @click="save" type="button" class="btn btn-primary">Crear</button>
                                            <button v-else @click="update" type="button" class="btn btn-primary">Actualizar</button>
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