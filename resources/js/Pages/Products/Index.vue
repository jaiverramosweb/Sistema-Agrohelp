<script setup>
import { onMounted, reactive, ref, computed, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css';

import Productos from './components/Products.vue';
import Caracteristicas from './components/Caracteristicas.vue'
import Garantias from './components/Garantias.vue';
import Documentacion from './components/Documentacion.vue';

const props = defineProps(['permissions'])

onMounted(() => {
    activeMenu('productos', 'productos')
})

const activeMenu = (menu, submenu) => {
    $(".menu_" + menu).addClass('menu-is-opening menu-open')
    $("#menu_" + menu).addClass('active')
    $("#sub_menu_" + submenu).addClass('active')
}


const loader = ref(false);


const isLouding = () => {
    loader.value = true
}

</script>

<template>
    <AuthenticatedLayout title="Productos">

        <div class="preloader flex-column justify-content-center align-items-center" v-if="loader">
            <img class="animation__shake" src="/assets/img/CGRLogo.png" alt="AdminLTELogo" height="100" width="200">
        </div>

        <template #header>
            <div class="row mb-2">

                <div class="col-sm-6">
                    <!-- <button v-if="permissions.create" type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#modalClient">
                        + Nuevo Producto
                    </button> -->
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Inicio</a></li>
                        <li class="breadcrumb-item active">Productos</li>
                    </ol>
                </div>

                <div class="row mt-4">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header p-2">

                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#producto"
                                            data-toggle="tab">Productos</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#caracteristicas"
                                            data-toggle="tab">Caracteristicas</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#garantias"
                                            data-toggle="tab">Garantias</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#documentacion"
                                            data-toggle="tab">Documentación</a>
                                    </li>
                                </ul>
                            </div>


                            <div class="card-body">
                                <div class="tab-content">

                                    <!-- Productos  -->
                                    <div class="active tab-pane" id="producto">
                                        <Productos :permissions="permissions" />
                                    </div>

                                    <!-- /.Caracteristicas -->
                                    <div class="tab-pane" id="caracteristicas">
                                        <Caracteristicas :permissions="permissions" />
                                    </div>

                                    <!-- /.Garantias-->
                                    <div class="tab-pane" id="garantias">
                                        <Garantias :permissions="permissions" />
                                    </div>

                                    <!-- /.Documentación-->
                                    <div class="tab-pane" id="documentacion">
                                        <Documentacion :permissions="permissions" />
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </template>


    </AuthenticatedLayout>
</template>