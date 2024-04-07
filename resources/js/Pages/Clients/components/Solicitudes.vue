<script setup>
import { onMounted, reactive, ref, computed, watch } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

onMounted(() => {
    paginationCar()
    getProducts()
})


// Pagination 

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

const order_cell = ref('id')
const order_type = ref('ASC')
const show = ref(25)
const offset = ref(3)
const search = ref('')
const pagination = ref('')
const setTimeoutSearch = ref('')

const paginationCar = (page) => {

    axios.post('/caracteristicas-pagination', {
        "page": page,
        "show": show.value,
        "search": search.value,
        "order_field": order_cell.value,
        "order_type": order_type.value
    })
        .then((response) => {
            let res = response.data;
            dataCaracteristicas.value = res.data.data;
            pagination.value = res.pagination;
        })
        .catch((error) => {
            console.log("error peticion", error);
        });
}

const changePage = (page) => {
    pagination.value.current_page = page;
    paginationCar(page);
}

const asyncFind = () => {
    clearTimeout(setTimeoutSearch.value);
    setTimeoutSearch.value = setTimeout(() => {
        if (search.value != "") {
            paginationCar();
        }
    }, 700);
}

// Fin 

const dataProducts = ref('')
const dataCaracteristicas = ref('')

const id = ref(0)
const producto_id = ref(0)
const caracteristica_id = ref(0)

const caracteristica = ref('')


const getProducts = () => {
    axios.get('/productos-all').then(({ data }) => {
        dataProducts.value = data.data
    })
}

watch(producto_id, () => {
    axios.get(`/caracteristicas/${producto_id.value}`).then(({ data }) => {
        dataCaracteristicas.value = data.data
    })
})

watch(caracteristica_id, () => {
    axios.get(`/get-caracteristicas/${caracteristica_id.value}`).then(({ data }) => {
        console.log(data)
        caracteristica.value = data.data
    })
})

</script>

<template>
    <div class='row'>

        <div class="col-12 mb-4">
            <b>Lista de solicitudes</b>
            <button class="btn btn-success float-right" data-toggle="modal"
                data-target="#modalSolicitudes">Solicitar</button>
        </div>

        <!-- FILTRO -->
        <div class='col-md-6 col-sm-6 col-xs-12'>
            <b>Mostrar </b>
            <select id="entries" @change='paginationCar()' v-model="show">
                <option :value="10">10</option>
                <option :value="25">25</option>
                <option :value="50">50</option>
                <option :value="100">100</option>
            </select>
            <b> registros</b>
        </div>

        <!-- BUSCADOR -->
        <div class='col-md-6 col-sm-6 col-xs-12'>

            <div class="pull-right">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <!-- <input type="text" maxlength="250" id='search' @change='asyncFind()' class='form-control' placeholder="Buscar" v-model="search"> -->
                    <input type="text" maxlength="250" id='search' @keyup='asyncFind()' class='form-control'
                        placeholder="Buscar" v-model="search">
                </div>
            </div>

        </div>

        <!-- TABLA -->
        <div class='col-12'>
            <div class='table-responsive'>
                <table class='table table-bordered table-striped table-hover table-title'>

                    <thead style='background-color: black; color: white'>

                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Producto
                            </th>
                            <th>
                                Nombre
                            </th>
                            <th>
                                Código
                            </th>
                            <th>
                                Interes
                            </th>

                            <th class="border text-center">
                                <i class='fa fa-cogs '></i>
                            </th>
                        </tr>

                    </thead>

                    <!-- <tbody>
                        <tr v-for=" ( item_data, i ) in dataCaracteristicas " :key='i'>

                            <td>
                                {{ i + 1 }}
                            </td>
                            <td>
                                {{ item_data.producto }}
                            </td>
                            <td>
                                {{ item_data.nombre }}
                            </td>
                            <td>
                                {{ item_data.codigo }}
                            </td>
                            <td>
                                {{ item_data.interes }}
                            </td>

                            <td>
                                <div class='d-flex flex-row justify-content-center'>

                                    <Link class="btn mr-1 btn-xs bg-info btn-round" data-toggle="tooltip" title="Editar"
                                        @click='editItem(item_data)'>
                                    <i class="fas fa-edit"></i>
                                    </Link>

                                    <button class="btn mr-1 btn-xs bg-danger btn-round" data-toggle="tooltip"
                                        title="Eliminar" @click='deleteItem(item_data.id)'>
                                        <i class='fas fa-trash'></i>
                                    </button>

                                </div>
                            </td>

                        </tr>

                        <tr v-show='dataCaracteristicas.length == 0'>
                            <td colspan="5">
                                <center>No existen registros</center>
                            </td>
                        </tr>

                    </tbody> -->

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
                <li style='cursor:pointer' class="page-item" v-if="pagination.current_page < pagination.last_page">
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


    <!-- Modal -->
    <div class="modal fade" id="modalSolicitudes" data-backdrop="static" tabindex="-1"
        aria-labelledby="modalSolicitudesLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- <div class="modal-dialog modal-xl"> -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="id == 0" class="modal-title" id="modalSolicitudesLabel">+ Nuevo Solicitud</h5>
                    <h5 v-else class="modal-title" id="modalSolicitudesLabel">+ Actualizar Solicitud</h5>

                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="form-group col-12" has-validation>
                            <label for="producto_id">Producto<span class="text-danger">
                                    *</span></label>
                            <select id="inputState" class="form-control" v-model="producto_id">
                                <option value="0" selected>Seleccione...</option>
                                <option v-for="producto in dataProducts" :key="producto.id" :value="producto.id">{{
                producto.nombre }}</option>
                            </select>
                            <div v-if="producto_id == 0" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>

                        </div>

                        <div v-if="producto_id != 0" class="form-group col-12" has-validation>
                            <label for="caracteristica_id">Caracteristica<span class="text-danger">
                                    *</span></label>
                            <select id="caracteristica_id" class="form-control" v-model="caracteristica_id">
                                <option value="0" selected>Seleccione...</option>
                                <option v-for="carac in dataCaracteristicas" :key="carac.id" :value="carac.id">{{
                carac.nombre }}</option>
                            </select>
                            <div v-if="caracteristica_id == 0" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>

                        </div>

                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <b>Tasa de interes:</b> {{ caracteristica.interes }} %
                                </div>
                                <div class="col-6">
                                    <b>Tasa de mora:</b> {{ caracteristica.mora }} %
                                </div>
                            </div>

                        </div>


                        <div class="form-group col-6" has-validation>
                            <label for="nombre">Valor a solicitar<span class="text-danger">
                                    *</span></label>
                            <input v-model="nombre" type="text" class="form-control" id="nombre"
                                aria-describedby="nombre" autocomplete="off">
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>

                        <div class="form-group col-6" has-validation>
                            <label for="nombre">Tiempo financiación<span class="text-danger">
                                    *</span></label>
                            <input v-model="nombre" type="text" class="form-control" id="nombre"
                                aria-describedby="nombre" autocomplete="off">
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>

                        <div class="form-group col-6" has-validation>
                            <label for="nombre">Ciudad Solicitud<span class="text-danger">
                                    *</span></label>
                            <input v-model="nombre" type="text" class="form-control" id="nombre"
                                aria-describedby="nombre" autocomplete="off">
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>

                        <div class="form-group col-6" has-validation>
                            <label for="nombre">Tipo decclarante<span class="text-danger">
                                    *</span></label>
                            <input v-model="nombre" type="text" class="form-control" id="nombre"
                                aria-describedby="nombre" autocomplete="off">
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>

                        <div class="form-group col-6" has-validation>
                            <label for="nombre">Profesión<span class="text-danger">
                                    *</span></label>
                            <input v-model="nombre" type="text" class="form-control" id="nombre"
                                aria-describedby="nombre" autocomplete="off">
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>

                        <div class="form-group col-6" has-validation>
                            <label for="nombre">Empresa donde labora<span class="text-danger">
                                    *</span></label>
                            <input v-model="nombre" type="text" class="form-control" id="nombre"
                                aria-describedby="nombre" autocomplete="off">
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>

                        <div class="form-group col-6" has-validation>
                            <label for="nombre">Independiente?<span class="text-danger">
                                    *</span></label>
                            <input v-model="nombre" type="text" class="form-control" id="nombre"
                                aria-describedby="nombre" autocomplete="off">
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>

                        <div class="form-group col-6" has-validation>
                            <label for="nombre">Nombre del negocio<span class="text-danger">
                                    *</span></label>
                            <input v-model="nombre" type="text" class="form-control" id="nombre"
                                aria-describedby="nombre" autocomplete="off">
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>

                        <div class="form-group col-6" has-validation>
                            <label for="nombre">Nombre del conyuge<span class="text-danger">
                                    *</span></label>
                            <input v-model="nombre" type="text" class="form-control" id="nombre"
                                aria-describedby="nombre" autocomplete="off">
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>

                        <div class="form-group col-6" has-validation>
                            <label for="nombre">Ocupación del conyuge<span class="text-danger">
                                    *</span></label>
                            <input v-model="nombre" type="text" class="form-control" id="nombre"
                                aria-describedby="nombre" autocomplete="off">
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>

                        <div class="form-group col-6" has-validation>
                            <label for="nombre">Empresa del conyuge<span class="text-danger">
                                    *</span></label>
                            <input v-model="nombre" type="text" class="form-control" id="nombre"
                                aria-describedby="nombre" autocomplete="off">
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>


                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" @click="clear" class="btn btn-secondary"
                        data-dismiss="modal">Cancelar</button>
                    <button v-if="id == 0" @click="save" type="button" class="btn btn-primary">Solicitar</button>
                    <button v-else @click="update" type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</template>