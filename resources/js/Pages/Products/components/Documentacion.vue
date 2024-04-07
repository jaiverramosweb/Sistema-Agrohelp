<script setup>
import { onMounted, reactive, ref, computed, watch } from 'vue';

import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'
import axios from 'axios';

const props = defineProps(['permissions'])

onMounted(() => {
    activeMenu('productos', 'productos')
    paginationDoc()
    getCaracteristica()
})

const activeMenu = (menu, submenu) => {
    $(".menu_" + menu).addClass('menu-is-opening menu-open')
    $("#menu_" + menu).addClass('active')
    $("#sub_menu_" + submenu).addClass('active')
}

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

const paginationDoc = (page) => {

    axios.post('/documentacion-pagination', {
        "page": page,
        "show": show.value,
        "search": search.value,
        "order_field": order_cell.value,
        "order_type": order_type.value
    })
        .then((response) => {
            let res = response.data;
            dataDocumentos.value = res.data.data;
            pagination.value = res.pagination;
        })
        .catch((error) => {
            console.log("error peticion", error);
        });
}

const changePage = (page) => {
    pagination.value.current_page = page;
    paginationDoc(page);
}

const asyncFind = () => {
    clearTimeout(setTimeoutSearch.value);
    setTimeoutSearch.value = setTimeout(() => {
        if (search.value != "") {
            paginationDoc();
        }
    }, 700);
}

// Fin 

const dataDocumentos = ref('');
const dataCaracte = ref('');

const id = ref(0);
const caracteristicas_productos_id = ref(0);
const tipo = ref('');
const nombre = ref('');
const codigo = ref('');
const indicador = ref('');


const getCaracteristica = () => {
    axios.get('/caracteristicas').then(({ data }) => {
        dataCaracte.value = data.data
    })
}

const save = () => {
    if (caracteristicas_productos_id.value.length == 0) return
    if (tipo.value.length == 0) return
    if (nombre.value.length == 0) return
    if (codigo.value.length == 0) return

    axios.post('/documentacion', {
        caracteristicas_productos_id: caracteristicas_productos_id.value,
        tipo: tipo.value,
        nombre: nombre.value,
        codigo: codigo.value
    }).then(res => {
        Swal.fire({
            icon: 'success',
            title: 'Registro creado con exito'
        })
        clear()
        paginationDoc()
        $("#modalDocumentacion").modal("hide");
    })
}

const editItem = (item) => {
    id.value = item.id
    caracteristicas_productos_id.value = item.caracteristicas_productos_id
    tipo.value = item.tipo
    nombre.value = item.nombre
    codigo.value = item.codigo

    $("#modalDocumentacion").modal("show");
}

const update = () => {
    axios.put(`/documentacion/${id.value}`, {
        caracteristicas_productos_id: caracteristicas_productos_id.value,
        tipo: tipo.value,
        nombre: nombre.value,
        codigo: codigo.value
    }).then(res => {
        Swal.fire({
            icon: 'success',
            title: 'Registro Actualizado con exito'
        })
        clear()
        paginationDoc()
        $("#modalDocumentacion").modal("hide");
    })
}

const deleteItem = (id) => {
    Swal.fire({
        title: 'Estas seguro de eliminarlo?',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/documentacion/${id}`).then(res => {
                paginationDoc()
                Swal.fire('Eliminado!', '', 'success')
            })
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })
}

const clear = () => {
    id.value = 0
    caracteristicas_productos_id.value = ''
    tipo.value = ''
    nombre.value = ''
    codigo.value = ''
}


const loader = ref(false);
const isLouding = () => {
    loader.value = true
}

</script>

<template>
    <div>

        <div class="card-body">

            <div class='row'>

                <div class="col-12 mb-4">
                    <b>Listado de Documentación Registradas</b>
                    <button class="btn btn-success float-right" data-toggle="modal"
                        data-target="#modalDocumentacion">Agregar</button>
                </div>

                <!-- FILTRO -->
                <div class='col-md-6 col-sm-6 col-xs-12'>
                    <b>Mostrar </b>
                    <select id="entries" @change='paginationDoc()' v-model="show">
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
                                        Caracteristica
                                    </th>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Código
                                    </th>

                                    <th class="border text-center">
                                        <i class='fa fa-cogs '></i>
                                    </th>
                                </tr>

                            </thead>

                            <tbody>
                                <tr v-for=" ( item_data, i ) in dataDocumentos " :key='i'>

                                    <td>
                                        {{ i + 1 }}
                                    </td>
                                    <td>
                                        {{ item_data.caracteristica }}
                                    </td>
                                    <td>
                                        {{ item_data.nombre }}
                                    </td>
                                    <td>
                                        {{ item_data.codigo }}
                                    </td>

                                    <td>
                                        <div class='d-flex flex-row justify-content-center'>

                                            <Link class="btn mr-1 btn-xs bg-info btn-round" data-toggle="tooltip"
                                                title="Editar" @click='editItem(item_data)' v-if="permissions.update">
                                            <i class="fas fa-edit"></i>
                                            </Link>

                                            <button class="btn mr-1 btn-xs bg-danger btn-round" data-toggle="tooltip"
                                                title="Eliminar" @click='deleteItem(item_data.id)'
                                                v-if="permissions.delete">
                                                <i class='fas fa-trash'></i>
                                            </button>

                                        </div>
                                    </td>

                                </tr>

                                <tr v-show='dataDocumentos.length == 0'>
                                    <td colspan="5">
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
    <div class="modal fade" id="modalDocumentacion" data-backdrop="static" tabindex="-1"
        aria-labelledby="modalDocumentacionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- <div class="modal-dialog modal-xl"> -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="id == 0" class="modal-title" id="modalDocumentacionLabel">+ Nuevo Garantia</h5>
                    <h5 v-else class="modal-title" id="modalDocumentacionLabel">+ Actualizar Garantia</h5>

                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="form-group col-12" has-validation>
                            <label for="caracteristicas_productos_id">Caracteristica<span class="text-danger">
                                    *</span></label>
                            <select id="inputState" class="form-control" v-model="caracteristicas_productos_id">
                                <option value="0" selected>Seleccione...</option>
                                <option v-for="Cara in dataCaracte" :key="Cara.id" :value="Cara.id">{{
                        Cara.nombre }}</option>
                            </select>
                            <div v-if="caracteristicas_productos_id == 0" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>

                        </div>

                        <div class="form-group col-12" has-validation>
                            <label for="tipo">Tipo<span class="text-danger">
                                    *</span></label>
                            <input v-model="tipo" type="text" class="form-control" id="tipo" aria-describedby="tipo"
                                autocomplete="off">
                            <div v-if="tipo == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>

                        <div class="form-group col-12" has-validation>
                            <label for="nombre">Nombre<span class="text-danger">
                                    *</span></label>
                            <input v-model="nombre" type="text" class="form-control" id="nombre"
                                aria-describedby="nombre" autocomplete="off">
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div>

                        <div class="form-group col-12" has-validation>
                            <label for="codigo">Código<span class="text-danger">
                                    *</span></label>
                            <input v-model="codigo" type="text" class="form-control" id="codigo"
                                aria-describedby="codigo" autocomplete="off">
                            <div v-if="codigo == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
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
</template>