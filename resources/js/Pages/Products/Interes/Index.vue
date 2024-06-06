<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'
import axios from 'axios';

const props = defineProps(['permissions', 'interes'])

onMounted(() => {
    activeMenu('config', 'intereses')
    dataIntereses.value = props.interes.data.data
    // pagination.value = props.interes.pagination

    console.log(props.interes)
})

const activeMenu = (menu, submenu) => {
    $(".menu_" + menu).addClass('menu-is-opening menu-open')
    $("#menu_" + menu).addClass('active')
    $("#sub_menu_" + submenu).addClass('active')
}

const dataIntereses = ref('')

const id = ref(0)
const name = ref('')
const valor = ref(0.0)

const loader = ref(false)

const getIntereses = () => {
    axios.get('/get-intereses').then(({data}) => {
        dataIntereses.value = data
    })
}

const editItem = (item) => {
    id.value = item.id
    name.value = item.name
    valor.value = item.valor

    $("#modalIntereses").modal("show");
}

const update = () => {
    axios.put(`/intereses/${id.value}`, {
        valor: valor.value
    }).then(res => {
        Swal.fire({
            icon: 'success',
            title: 'Registro Actualizado con exito'
        })
        clear()
        getIntereses()
        $("#modalIntereses").modal("hide");
    })
}

const clear = () => {
    id.value = 0
    name.value = ''
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
                                <!-- <button class="btn btn-success float-right" data-toggle="modal" data-target="#modalDocumentacion">
                                    Agregar
                                </button> -->
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
                                            <tr v-for=" ( item_data, i ) in dataIntereses " :key='i'>

                                                <td>
                                                    {{ i + 1 }}
                                                </td>
                                                <td>
                                                    {{ item_data.name }}
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

                                            <tr v-show='dataIntereses.length == 0'>
                                                <td colspan="4">
                                                    <center>No existen registros</center>
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalIntereses" data-backdrop="static" tabindex="-1"
                                aria-labelledby="modalInteresesLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <!-- <div class="modal-dialog modal-xl"> -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 v-if="id == 0" class="modal-title" id="modalInteresesLabel">+ Nuevo Documentación</h5>
                                            <h5 v-else class="modal-title" id="modalInteresesLabel">+ Actualizar Intereses</h5>

                                        </div>
                                        <div class="modal-body">

                                            <div class="row">

                                                <div class="form-group col-12" has-validation>
                                                    <label for="nombre">Nombre<span class="text-danger">
                                                            *</span></label>
                                                    <input v-model="name" type="text" class="form-control" id="nombre"
                                                        aria-describedby="nombre" autocomplete="off" disabled>
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