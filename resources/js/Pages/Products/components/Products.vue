<script setup>
import { onMounted, reactive, ref, computed, watch } from 'vue';

import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

const props = defineProps(['permissions'])

onMounted(() => {
    activeMenu('productos', 'productos')
    paginationPro()
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

const paginationPro = (page) => {

    axios.post('/products-pagination', {
        "page": page,
        "show": show.value,
        "search": search.value,
        "order_field": order_cell.value,
        "order_type": order_type.value
    })
        .then((response) => {
            let res = response.data;
            dataProducts.value = res.data.data;
            pagination.value = res.pagination;
        })
        .catch((error) => {
            console.log("error peticion", error);
        });
}

const changePage = (page) => {
    pagination.value.current_page = page;
    paginationPro(page);
}

const asyncFind = () => {
    clearTimeout(setTimeoutSearch.value);
    setTimeoutSearch.value = setTimeout(() => {
        if (search.value != "") {
            paginationPro();
        }
    }, 700);
}

// Fin 

const dataProducts = ref('');

const id = ref(0);
const tipo_producto = ref('null');
const nombre = ref('');
const descripcion = ref('');
const codigo = ref('');

const save = () => {
    if (nombre.value.length == 0) return
    if (codigo.value.length == 0) return

    axios.post('/producto', {
        tipo_producto: tipo_producto.value,
        nombre: nombre.value,
        descripcion: descripcion.value,
        codigo: codigo.value
    }).then(res => {
        Swal.fire({
            icon: 'success',
            title: 'Registro creado con exito'
        })
        clear()
        paginationPro()
        $("#modalProduct").modal("hide");
    })
}

const editItem = (item) => {

    id.value = item.id
    tipo_producto.value = item.tipo_producto
    nombre.value = item.nombre
    descripcion.value = item.descripcion
    codigo.value = item.codigo

    $("#modalProduct").modal("show");
}

const update = () => {
    axios.put(`/producto/${id.value}`, {
        tipo_producto: tipo_producto.value,
        nombre: nombre.value,
        descripcion: descripcion.value,
        codigo: codigo.value
    }).then(res => {
        Swal.fire({
            icon: 'success',
            title: 'Registro Actualizado con exito'
        })
        clear()
        paginationPro()
        $("#modalProduct").modal("hide");
    })
}

const deleteItem = (id) => {
    Swal.fire({
        title: 'Estas seguro de eliminarlo?',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/producto/${id}`).then(res => {
                paginationPro()
                Swal.fire('Eliminado!', '', 'success')
            })
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })
}

const clear = () => {
    id.value = 0
    nombre.value = ''
    descripcion.value = ''
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
                    <b>Listado de Productos Registrados</b>
                    <button class="btn btn-success float-right" data-toggle="modal"
                        data-target="#modalProduct">Agregar</button>
                </div>

                <!-- FILTRO -->
                <div class='col-md-6 col-sm-6 col-xs-12'>
                    <b>Mostrar </b>
                    <select id="entries" @change='paginationPro()' v-model="show">
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
                                        Nombre
                                    </th>
                                    <th>
                                        estado
                                    </th>

                                    <th class="border text-center">
                                        <i class='fa fa-cogs '></i>
                                    </th>
                                </tr>

                            </thead>

                            <tbody>
                                <tr v-for=" ( item_data, i ) in dataProducts " :key='i'>

                                    <td>
                                        {{ i + 1 }}
                                    </td>
                                    <td>
                                        {{ item_data.nombre }}
                                    </td>
                                    <td>
                                        {{ item_data.estado }}
                                    </td>

                                    <td>
                                        <div class='d-flex flex-row justify-content-center'>

                                            <Link class="btn mr-1 btn-sm btn-outline-info btn-round"
                                                data-toggle="tooltip" title="Editar" @click='editItem(item_data)'
                                                v-if="permissions.update">
                                            <i class="fas fa-edit"></i>
                                            </Link>

                                            <button class="btn mr-1 btn-sm btn-outline-danger btn-round"
                                                data-toggle="tooltip" title="Eliminar" @click='deleteItem(item_data.id)'
                                                v-if="permissions.delete">
                                                <i class='fas fa-trash'></i>
                                            </button>

                                        </div>
                                    </td>

                                </tr>

                                <tr v-show='dataProducts.length == 0'>
                                    <td colspan="4">
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
    <div class="modal fade" id="modalProduct" data-backdrop="static" tabindex="-1" aria-labelledby="modalProductLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <!-- <div class="modal-dialog modal-xl"> -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="id == 0" class="modal-title" id="modalProductLabel">+ Nuevo Producto</h5>
                    <h5 v-else class="modal-title" id="modalProductLabel">+ Actualizar Producto</h5>

                </div>
                <div class="modal-body">

                    <div class="row">
                        <!-- 
                        <div class="form-group col-12" has-validation>
                            <label for="tipo_producto">Tipo Producto<span class="text-danger">
                                    *</span></label>
                            <select id="inputState" class="form-control" v-model="tipo_producto">
                                <option value="" selected>Seleccione...</option>
                                <option value="Procuto uno">Procuto uno</option>
                                <option value="Poducto dos">Poducto dos</option>
                            </select>
                            <div v-if="tipo_producto == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>

                        </div> -->

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
                            <label for="descripcion">Descripción </label>
                            <input v-model="descripcion" type="text" class="form-control" id="descripcion"
                                aria-describedby="descripcion" autocomplete="off">
                        </div>

                        <div class="form-group col-12" has-validation>
                            <label for="codigo">Código <span class="text-danger">
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