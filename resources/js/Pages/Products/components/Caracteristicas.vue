<script setup>
import { onMounted, reactive, ref, computed, watch } from 'vue';

import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'
import axios from 'axios';

const props = defineProps(['permissions'])

onMounted(() => {
    activeMenu('productos', 'productos')
    paginationCar()
    getProducts()
    getGarantias()
    getDocuentacion()
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

const dataCaracteristicas = ref('');
const dataProducts = ref('');
const dataGarantias = ref('');
const dataDocumentacion = ref('');

const id = ref(0);
const productos_id = ref(0);
const nombre = ref('');
const interes = ref('');
const mora = ref('');
const codigo = ref('');
const monto_minimo = ref('');
const monto_maximo = ref('');
const tiempo_minimo = ref('');
const tiempo_maximo = ref('');

const tipo_amortizacion = ref('Francés');
const cobro_intereses = ref('');
const periodicidad = ref('');
const terminos_condiciones = ref('');

const garantia = ref('');
const garantias = ref([]);

const documento = ref('');
const documentos = ref([]);


const getProducts = () => {
    axios.get('/productos-all').then(({ data }) => {
        dataProducts.value = data.data
    })
}

const getGarantias = () => {
    axios.get('/get-garantias').then(({ data }) => {
        dataGarantias.value = data.data
    })
}

const getDocuentacion = () => {
    axios.get('/get-documentacion').then(({ data }) => {
        dataDocumentacion.value = data.data
    })
}

const onGarantias = () => {
    garantias.value.push(garantia.value)
    garantia.value = ''
}

const deleteGar = (id) => {
    garantias.value = garantias.value.filter(gar => gar.id != id)
}

const onDocumentos = () => {
    documentos.value.push(documento.value)
    documento.value = ''
}

const deleteDoc = (id) => {
    documentos.value = documentos.value.filter(doc => doc.id != id)
}

const save = () => {
    if (productos_id.value.length == 0) return
    if (nombre.value.length == 0) return
    if (interes.value.length == 0) return
    if (mora.value.length == 0) return
    if (codigo.value.length == 0) return
    // if (monto_minimo.value.length == 0) return
    if (monto_maximo.value.length == 0) return
    // if (tiempo_minimo.value.length == 0) return
    if (tiempo_maximo.value.length == 0) return
    if (terminos_condiciones.value.length == 0) return



    axios.post('/caracteristica', {
        productos_id: productos_id.value,
        nombre: nombre.value,
        interes: interes.value,
        mora: mora.value,
        codigo: codigo.value,
        // monto_minimo: monto_minimo.value,
        monto_maximo: monto_maximo.value,
        // tiempo_minimo: tiempo_minimo.value,
        tiempo_maximo: tiempo_maximo.value,
        tipo_amortizacion: tipo_amortizacion.value,
        cobro_intereses: cobro_intereses.value,
        periodicidad: periodicidad.value,
        terminos_condiciones: terminos_condiciones.value,

        garantias: garantias.value,
        documentos: documentos.value

    }).then(res => {
        Swal.fire({
            icon: 'success',
            title: 'Registro creado con exito'
        })
        clear()
        paginationCar()
        $("#modalCatacteristica").modal("hide");
    })
}

const editItem = (item) => {

    id.value = item.id
    productos_id.value = item.productos_id
    nombre.value = item.nombre
    interes.value = item.interes
    mora.value = item.mora
    codigo.value = item.codigo
    // monto_minimo.value = item.monto_minimo
    monto_maximo.value = item.monto_maximo
    // tiempo_minimo.value = item.tiempo_minimo
    tiempo_maximo.value = item.tiempo_maximo
    tipo_amortizacion.value = item.tipo_amortizacion
    terminos_condiciones.value = item.terminos_condiciones
    cobro_intereses.value = item.cobro_intereses
    periodicidad.value = item.periodicidad


    $("#modalCatacteristica").modal("show");
}

const update = () => {
    axios.put(`/caracteristica/${id.value}`, {
        productos_id: productos_id.value,
        nombre: nombre.value,
        interes: interes.value,
        mora: mora.value,
        codigo: codigo.value,
        monto_minimo: monto_minimo.value,
        monto_maximo: monto_maximo.value,
        tiempo_minimo: tiempo_minimo.value,
        tiempo_maximo: tiempo_maximo.value,
        tipo_amortizacion: tipo_amortizacion.value,
        terminos_condiciones: terminos_condiciones.value,
        cobro_intereses: cobro_intereses.value,
        periodicidad: periodicidad.value

    }).then(res => {
        Swal.fire({
            icon: 'success',
            title: 'Registro Actualizado con exito'
        })
        clear()
        paginationCar()
        $("#modalCatacteristica").modal("hide");
    })
}

const deleteItem = (id) => {
    Swal.fire({
        title: 'Estas seguro de eliminarlo?',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/caracteristica/${id}`).then(res => {
                paginationCar()
                Swal.fire('Eliminado!', '', 'success')
            })
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })
}

const clear = () => {
    id.value = 0
    productos_id.value = ''
    nombre.value = ''
    interes.value = ''
    mora.value = ''
    codigo.value = ''
    monto_minimo.value = ''
    monto_maximo.value = ''
    tiempo_minimo.value = ''
    tiempo_maximo.value = ''
    tipo_amortizacion.value = ''
    cobro_intereses.value = ''
    terminos_condiciones.value = ''
    periodicidad.value = ''
    garantias.value = [];
    documentos.value = [];
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
                    <b>Listado de Caracteristicas Registradas</b>
                    <button class="btn btn-success float-right" data-toggle="modal"
                        data-target="#modalCatacteristica">Agregar</button>
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
                                        Línea de crédito
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

                                <tr v-show='dataCaracteristicas.length == 0'>
                                    <td colspan="6">
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
    <div class="modal fade" id="modalCatacteristica" data-backdrop="static" tabindex="-1"
        aria-labelledby="modalCatacteristicaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- <div class="modal-dialog modal-lg"> -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="id == 0" class="modal-title" id="modalCatacteristicaLabel">+ Nuevo Caracteristica</h5>
                    <h5 v-else class="modal-title" id="modalCatacteristicaLabel">+ Actualizar Caracteristica</h5>

                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="form-group col-12" has-validation>
                            <label for="productos_id">Producto<span class="text-danger">
                                    *</span></label>
                            <select id="inputState" class="form-control" v-model="productos_id">
                                <option value="0" selected>Seleccione...</option>
                                <option v-for="producto in dataProducts" :key="producto.id" :value="producto.id">{{
                        producto.nombre }}</option>
                            </select>
                            <div v-if="productos_id == 0" class="invalid-feedback d-block">El
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

                        <!-- <div class="form-group col-3" has-validation>
                            <label for="interes">Interes<span class="text-danger">
                                    *</span></label>
                            <input v-model="interes" type="text" class="form-control" id="interes"
                                aria-describedby="interes" autocomplete="off">
                            <div v-if="interes == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div> -->

                        <!-- <div class="form-group col-3" has-validation>
                            <label for="mora">Mora<span class="text-danger">
                                    *</span></label>
                            <input v-model="mora" type="text" class="form-control" id="mora" aria-describedby="mora"
                                autocomplete="off">
                            <div v-if="mora == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div> -->



                        <!-- <div class="form-group col-4" has-validation>
                            <label for="tiempo_minimo">Monto minimo<span class="text-danger">
                                    *</span></label>
                            <input v-model="monto_minimo" type="text" class="form-control" id="monto_minimo"
                                aria-describedby="monto_minimo" autocomplete="off">
                            <div v-if="monto_minimo == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div> -->

                        <!-- <div class="form-group col-3" has-validation>
                            <label for="monto_maximo">Monto Maximo<span class="text-danger">
                                    *</span></label>
                            <input v-model="monto_maximo" type="text" class="form-control" id="monto_maximo"
                                aria-describedby="monto_maximo" autocomplete="off">
                            <div v-if="monto_maximo == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div> -->
                        <!-- 
                        <div class="form-group col-4" has-validation>
                            <label for="tiempo_minimo">Tiempo minimo<span class="text-danger">
                                    *</span></label>
                            <input v-model="tiempo_minimo" type="number" class="form-control" id="tiempo_minimo"
                                aria-describedby="tiempo_minimo" autocomplete="off">
                            <div v-if="tiempo_minimo == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div> -->

                        <!-- <div class="form-group col-3" has-validation>
                            <label for="tiempo_maximo">Tiempo Maximo<span class="text-danger">
                                    *</span></label>
                            <input v-model="tiempo_maximo" type="number" class="form-control" id="tiempo_maximo"
                                aria-describedby="tiempo_maximo" autocomplete="off">
                            <div v-if="tiempo_maximo == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div> -->

                        <!-- <div class="form-group col-3" has-validation>
                            <label for="nombre">Periocidad de pagos<span class="text-danger">
                                    *</span></label>
                            <select id="inputState" class="form-control" v-model="cobro_intereses">
                                <option value="" selected>Seleccione...</option>
                                <option value="Mensual">Mensual</option>
                                <option value="Trimestral">Trimestral</option>
                                <option value="Semestral">Semestral</option>

                            </select>
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div> -->

                        <!-- <div v-if="cobro_intereses == 'Periodico'" class="form-group col-4" has-validation>
                            <label for="nombre">Periodicidad permitida<span class="text-danger">
                                    *</span></label>
                            <select id="inputState" class="form-control" v-model="periodicidad">
                                <option value="" selected>Seleccione...</option>
                                <option value="Bimestral">Bimestral</option>
                                <option value="Trimestral">Trimestral</option>
                                <option value="Cuatrimestral">Cuatrimestral</option>
                                <option value="Semestral">Semestral</option>
                                <option value="Anual">Anual</option>

                            </select>
                            <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                campo es
                                requerido
                            </div>
                        </div> -->

                        <!-- <div class="col-12">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">términos y condiciones </label>
                                <textarea v-model="terminos_condiciones" class="form-control"
                                    id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </div> -->


                        <!-- <div class="col-12">
                            <label for="monto_maximo">Agregar Garantias<span class="text-danger">
                                    *</span></label>
                            <select id="inputState" class="form-control" @change="onGarantias" v-model="garantia">
                                <option value="" selected>Seleccione...</option>
                                <option v-for="garantia in dataGarantias" :key="garantia.id" :value="garantia">
                                    {{ garantia.nombre }}</option>
                            </select>

                            <div v-for="garan in garantias" :key="garantia.id">
                                <div class="row">
                                    <div class="col-10 mt-2 ml-2">
                                        {{ garan.nombre }}
                                    </div>
                                    <div class="col-1 mt-2">
                                        <button @click="deleteGar(garan.id)" class="btn btn-sm btn-danger">X</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <label for="monto_maximo">Agregar Documentación<span class="text-danger">
                                    *</span></label>
                            <select id="inputState" class="form-control" @change="onDocumentos" v-model="documento">
                                <option value="" selected>Seleccione...</option>
                                <option v-for="documento in dataDocumentacion" :key="documento.id" :value="documento">
                                    {{ documento.nombre }}</option>
                            </select>

                            <div v-for="doc in documentos" :key="doc.id">
                                <div class="row">
                                    <div class="col-10 mt-2 ml-2">
                                        {{ doc.nombre }}
                                    </div>
                                    <div class="col-1 mt-2">
                                        <button @click="deleteDoc(doc.id)" class="btn btn-sm btn-danger">X</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->

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