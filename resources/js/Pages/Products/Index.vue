<script setup>
import { onMounted, reactive, ref, computed, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css';

import Productos from './components/Products.vue';
import Caracteristicas from './components/Caracteristicas.vue'

const props = defineProps(['permissions'])

onMounted(() => {
    activeMenu('productos', 'productos')
})

const activeMenu = (menu, submenu) => {
    $(".menu_" + menu).addClass('menu-is-opening menu-open')
    $("#menu_" + menu).addClass('active')
    $("#sub_menu_" + submenu).addClass('active')
}

const tag = ref('producto')


const loader = ref(false);

const isTag = (item) => {
    tag.value = item
}


const isLouding = () => {
    loader.value = true
}

</script>

<template>
    <AuthenticatedLayout title="Linea de credito">

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
                        <div class="card" style="width: 100%;">
                            <div class="card-header p-2">

                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#producto" @click="isTag('producto')"
                                            data-toggle="tab">Líneas de Crédito</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#caracteristicas" @click="isTag('caracteristicas')"
                                            data-toggle="tab">Parametrización</a>
                                    </li>
                                </ul>
                            </div>


                            <div class="card-body">
                                <div class="tab-content">

                                    <!-- Productos  -->
                                    <div v-if="tag == 'producto'" class="active tab-pane" id="producto">
                                        <Productos :permissions="permissions" />
                                    </div>

                                    <!-- /.Caracteristicas -->
                                    <div v-if="tag == 'caracteristicas'" class="tab-pane" id="caracteristicas">
                                        <Caracteristicas :permissions="permissions" />
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