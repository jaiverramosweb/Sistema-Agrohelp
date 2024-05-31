<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref, computed, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

const props = defineProps(['solicitudes', 'permissions',])

onMounted(() => {
    activeMenu('solicitudes', 'solicitudes')

    dataSolicitudes.value = props.solicitudes.data.data
    pagination.value = props.solicitudes.pagination

})


// Metodos Requeridos para iniciar modulo
const activeMenu = (menu, submenu) => {
    $(".menu_" + menu).addClass('menu-is-opening menu-open')
    $("#menu_" + menu).addClass('active')
    $("#sub_menu_" + submenu).addClass('active')
}

const isActived = computed(() => {
    return pagination.value.current_page;
});

const pagesNumber = computed(() => {
    if (!pagination.value.to) {
        return [];
    }

    let from = pagination.value.current_page - offset.value;
    if (from < 1) {
        from = 1;
    }
    let to = from + offset.value * 2;
    if (to >= pagination.value.last_page) {
        to = pagination.value.last_page;
    }
    const pagesArray = [];
    while (from <= to) {
        pagesArray.push(from);
        from++;
    }

    return pagesArray;
});


const loader = ref(false);

const order_cell = ref('id')
const order_type = ref('ASC')
const show = ref(25)
const offset = ref(3)
const search = ref('')
const pagination = ref('')
const setTimeoutSearch = ref('')

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

const orderTest = (val) => {
    let result;
    if (val == order_cell.value) {
        result = order_type.value == 'DESC' ? 3 : 2;
    } else {
        result = 1;
    }
    return result;
}

const filterColumn = (field_) => {
    if (field_ == order_cell.value) {
        order_type.value = order_type.value == 'DESC' ? 'ASC' : 'DESC';
    } else {
        order_cell.value = field_;
    }

    paginationList();
}

const fieldValue = (col, record) => {

    let result;

    Object.entries(record).map((el) => {

        if (el[0] == col.name) {
            result = "type_object" in col ? el[1][col.type_object.name] : el[1];
        }

    });

    return result;
}

const asyncFind = () => {
    clearTimeout(setTimeoutSearch.value);
    setTimeoutSearch.value = setTimeout(() => {
        if (search.value != "") {
            paginationList();
        }
    }, 700);
}

const paginationList = (page) => {

    axios.post('/clients-pagination', {
        "page": page,
        "show": show.value,
        "search": search.value,
        "order_field": order_cell.value,
        "order_type": order_type.value
    })
        .then((response) => {
            let res = response.data;
            dataSolicitudes.value = res.data.data;
            pagination.value = res.pagination;
        })
        .catch((error) => {
            console.log("error peticion", error);
        });
}

const changePage = (page) => {
    pagination.value.current_page = page;
    paginationList(page);
}
// FIN de metodos Requeridos para iniciar modulo

const dataSolicitudes = ref([])

const formatDate = (date) => {
    let dateString = date.substring(0, 10);
    return dateString
}

const formatearMoneda = (numero) => {
    const num = parseFloat(numero)
    return '$ ' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

</script>

<template>
    <AuthenticatedLayout title="Clientes">

        <div class="preloader flex-column justify-content-center align-items-center" v-if="loader">
            <img class="animation__shake" src="/assets/img/CGRLogo.png" alt="AdminLTELogo" height="100" width="200">
        </div>

        <template #header>
            <div class="row mb-2">

                <div class="col-sm-6">
                    <!-- <button v-if="permissions.create" type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#modalClient">
                        + Nuevo Cliente
                    </button> -->

                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Inicio</a></li>
                        <li class="breadcrumb-item active">Solicitudes</li>
                    </ol>
                </div>

            </div>
        </template>

        <div class="row">

            <div class="col-lg-12">

                <div class="card">

                    <div class="card-header">

                        <h3 class="card-title">Todas las solicitudes</h3>

                        <div class="card-tools">
                            <!-- <button v-if="permissions.create" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalClient">
                            Crear Piezómetro
                        </button> -->

                        </div>

                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class='row'>

                            <!-- FILTRO -->
                            <!-- <div class='col-md-6 col-sm-6 col-xs-12'>
                            <b>Mostrar </b>
                            <select id="entries" @change='paginationList()' v-model="show">
                                <option :value="10">10</option>
                                <option :value="25">25</option>
                                <option :value="50">50</option>
                                <option :value="100">100</option>
                            </select>
                            <b> registros</b>
                        </div> -->

                            <!-- BUSCADOR -->
                            <!-- <div class='col-md-6 col-sm-6 col-xs-12'>

                            <div class="pull-right">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" maxlength="250" id='search' @keyup='asyncFind()'
                                        class='form-control' placeholder="Buscar" v-model="search">
                                </div>
                            </div>

                        </div> -->

                            <!-- TABLA -->
                            <div class='col-12'>
                                <div class='table-responsive'>
                                    <table class='table table-bordered table-striped table-hover table-title'>

                                        <thead style='background-color: black; color: white'>

                                            <tr>
                                                <th>
                                                    Solicitante
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
                                                <th>
                                                    Fecha inicio solicitud
                                                </th>

                                                <th class="border text-center">
                                                    <i class='fa fa-cogs '></i>
                                                </th>
                                            </tr>

                                        </thead>

                                        <tbody>

                                            <tr v-for=" ( item_data, i ) in dataSolicitudes " :key='i'>

                                                <td>
                                                    {{ item_data.nombre }}
                                                </td>
                                                <td>
                                                    {{ item_data.nombre_producto }} {{ item_data.nombre_caract }}
                                                </td>
                                                <td>
                                                    {{ formatearMoneda(item_data.monto) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ item_data.tiempo }} meses
                                                </td>
                                                <td class=" text-center">
                                                    <span v-if="item_data.estado_solicitud == 'En tramite'"
                                                        class="badge badge-wellow p-2">
                                                        {{ item_data.estado_solicitud }}
                                                    </span>
                                                    <span v-if="item_data.estado_solicitud == 'En estudio'"
                                                        class="badge badge-wellow p-2">
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
                                                    <span
                                                        v-if="item_data.estado_solicitud == 'Condiciones no aceptadas'"
                                                        class="badge badge-red p-2">
                                                        {{ item_data.estado_solicitud }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ formatDate(item_data.created_at) }}
                                                </td>

                                                <td>
                                                    <div class='d-flex flex-row justify-content-center'>
                                                        <!-- <button :class="'btn mr-1 btn-xs bg-info btn-round'" @click="showItem( item_data )" v-if="permissions.read">
                                                            <i class='fas fa-eye'></i>
                                                        </button>

                                                        <Link class="btn mr-1 btn-xs bg-info btn-round"
                                                            data-toggle="tooltip" title="Info"
                                                            :href="route('client.show', { client: item_data.id })"
                                                            @click="isLouding" v-if="permissions.read">
                                                            <i class='fas fa-eye'></i>
                                                        </Link> -->

                                                        <Link :href="route('solicitud.show', { id: item_data.id })"
                                                            class="btn mr-1 btn-sm btn-outline-info btn-round"
                                                            data-toggle="tooltip" title="Ver detalle">
                                                        <i class='fas fa-eye'></i>
                                                        </Link>

                                                        <!-- <button @click="edit(item_data)" class="btn mr-1 btn-xs bg-warning  btn-round" data-toggle="tooltip" title="Editar"  v-if="permissions.update">
                                                        <i class='fas fa-edit'></i>
                                                    </button> -->

                                                        <!-- <button class="btn mr-1 btn-xs bg-danger btn-round"
                                                            data-toggle="tooltip" title="Eliminar"
                                                            @click='deleteItem(item_data.id)' v-if="permissions.delete">
                                                            <i class='fas fa-trash'></i>
                                                        </button> -->

                                                    </div>
                                                </td>

                                            </tr>

                                            <tr v-show='dataSolicitudes.length == 0'>
                                                <td colspan="7">
                                                    <center>No existen registros</center>
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>


                            <div class='col-md-8 col-sm-6 col-xs-12'>

                                <ul class="pagination pagination-sm m-0 float-right">

                                    <li style='cursor:pointer' class="page-item">
                                        <a class="page-link" @click.prevent="changePage(1)">
                                            Primero
                                        </a>
                                    </li>
                                    <li style='cursor:pointer' class="page-item" v-if="pagination.current_page > 1">
                                        <a @click.prevent="changePage(pagination.current_page - 1)" class="page-link">
                                            Anterior.
                                        </a>
                                    </li>
                                    <li class="paginate_button page-item" :key="page" v-for="( page ) in pagesNumber "
                                        :class="[page == isActived ? 'active' : '']">
                                        <a href="#" @click.prevent="changePage(page)" class="page-link">
                                            {{ page }}
                                        </a>
                                    </li>
                                    <li style='cursor:pointer' class="page-item"
                                        v-if="pagination.current_page < pagination.last_page">
                                        <a @click.prevent="changePage(pagination.current_page + 1)" class="page-link">
                                            Sig.
                                        </a>
                                    </li>
                                    <li style='cursor:pointer' class="page-item">
                                        <a class="page-link" @click.prevent="changePage(pagination.last_page)">
                                            Último
                                        </a>
                                    </li>
                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalClient" data-backdrop="static" tabindex="-1"
                    aria-labelledby="modalClientLabel" aria-hidden="true">
                    <!-- <div class="modal-dialog"> -->
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalClientLabel">+ Nuevo cliente</h5>

                            </div>
                            <div class="modal-body">

                                <div class="row">

                                    <!-- <div class="form-group col-md-3  has-validation">
                                    <label for="zonas_id">Zona</label>
                                    <select v-model="zonas_id" class="form-control" id="zonas_id">
                                        <option value="0" >Seleccione..</option>
                                        <option v-for="zona in zonas" :key="zona.id" :value="zona.id">{{ zona.name }}</option>
                                    </select>
                                    <div v-if="zonas_id.length == 0" class="invalid-feedback d-block">El campo es requerido</div>
                                </div> -->

                                    <div class="form-group col-4" has-validation>
                                        <label for="tipo_identificacion">Tipo de Identificación <span
                                                class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="tipo_identificacion">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="CC">CC</option>
                                            <option value="Pasaporte">Pasaporte</option>
                                        </select>
                                        <div v-if="tipo_identificacion == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>

                                    </div>

                                    <div class="form-group col-4" has-validation>
                                        <label for="numero_identificacion">Numero de Identificación <span
                                                class="text-danger">
                                                *</span></label>
                                        <input v-model="numero_identificacion" type="text" class="form-control"
                                            id="numero_identificacion" aria-describedby="numero_identificacion"
                                            autocomplete="off">
                                        <div v-if="numero_identificacion == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4" has-validation>
                                        <label for="nombre">Primer Nombre <span class="text-danger">
                                                *</span></label>
                                        <input v-model="nombre" type="text" class="form-control" id="nombre"
                                            aria-describedby="nombre" autocomplete="off">
                                        <div v-if="nombre == ''" class="invalid-feedback d-block">El campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4" has-validation>
                                        <label for="segundo_nombre">Segundo Nombre <span class="text-danger">
                                                *</span></label>
                                        <input v-model="segundo_nombre" type="text" class="form-control"
                                            id="segundo_nombre" aria-describedby="segundo_nombre" autocomplete="off">
                                        <div v-if="segundo_nombre == ''" class="invalid-feedback d-block">El campo
                                            es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4" has-validation>
                                        <label for="apellido">Primer Apellido <span class="text-danger">*</span></label>
                                        <input v-model="apellido" type="text" class="form-control" id="apellido"
                                            aria-describedby="apellido" autocomplete="off">
                                        <div v-if="apellido == ''" class="invalid-feedback d-block">El campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4" has-validation>
                                        <label for="segundo_apellido">Segundo Apellido <span
                                                class="text-danger">*</span></label>
                                        <input v-model="segundo_apellido" type="text" class="form-control"
                                            id="segundo_apellido" aria-describedby="segundo_apellido"
                                            autocomplete="off">
                                        <div v-if="segundo_apellido == ''" class="invalid-feedback d-block">El campo
                                            es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="inputState">Genero <span class="text-danger">*</span></label>
                                        <select id="inputState" class="form-control" v-model="genero">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="inputState">Tipo de Persona <span
                                                class="text-danger">*</span></label>
                                        <select id="inputState" class="form-control" v-model="tipo_persona">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Tipo uno">Tipo uno</option>
                                            <option value="Tipo dos">Tipo dos</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-4" has-validation>
                                        <label for="fecha_nacimiento">Fecha de Nacimiento <span
                                                class="text-danger">*</span></label>
                                        <input v-model="fecha_nacimiento" type="date" class="form-control"
                                            id="fecha_nacimiento" aria-describedby="fecha_nacimiento"
                                            autocomplete="off">
                                        <div v-if="fecha_nacimiento == ''" class="invalid-feedback d-block">El campo
                                            es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-6" has-validation>
                                        <label for="email">Correo electrónico<span class="text-danger">*</span></label>
                                        <input v-model="email" type="email" class="form-control" id="email"
                                            aria-describedby="email" autocomplete="off">
                                        <div v-if="email == ''" class="invalid-feedback d-block">El campo
                                            es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-6" has-validation>
                                        <label for="password">Contraseña<span class="text-danger">*</span></label>
                                        <input v-model="password" type="password" class="form-control" id="password"
                                            aria-describedby="password" autocomplete="off">
                                        <div v-if="password == ''" class="invalid-feedback d-block">El campo
                                            es
                                            requerido
                                        </div>
                                    </div>

                                    <hr>
                                    <h4 class="col-12">Direcciones</h4>
                                    <hr>

                                    <div class="form-group col-md-3">
                                        <label for="tipo_direccion">Tipo Dirección</label>
                                        <select id="tipo_direccion" class="form-control" v-model="tipo_direccion">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Tipo uno">Tipo uno</option>
                                            <option value="Tipo dos">Tipo dos</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-3" has-validation>
                                        <label for="direccion">Dirección</label>
                                        <input v-model="direccion" type="text" class="form-control" id="direccion"
                                            aria-describedby="direccion" autocomplete="off">
                                    </div>

                                    <div class="form-group col-3" has-validation>
                                        <label for="ciudad">Ciudad</label>
                                        <input v-model="ciudad" type="text" class="form-control" id="ciudad"
                                            aria-describedby="ciudad" autocomplete="off">
                                    </div>

                                    <div class="form-group col-3" has-validation>
                                        <label for="departamento">Departamento</label>
                                        <input v-model="departamento" type="text" class="form-control" id="departamento"
                                            aria-describedby="departamento" autocomplete="off">
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-success float-right"
                                            @click="agregarDirecciones">Agregar</button>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <table class="table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Tipo Dirección</th>
                                                    <th scope="col">Dirección</th>
                                                    <th scope="col">Ciudad</th>
                                                    <th scope="col">Departamento</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(direc, index) in direcciones" :key="index">
                                                    <th scope="row">{{ index }}</th>
                                                    <td>{{ direc.tipo_direccion }}</td>
                                                    <td>{{ direc.direccion }}</td>
                                                    <td>{{ direc.ciudad }}</td>
                                                    <td>{{ direc.departamento }}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>


                                </div>
                            </div>




                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button @click="save" type="button" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>


    </AuthenticatedLayout>
</template>

<style scoped>
hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.badge-wellow {
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