<script setup>
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['clientId'])

onMounted(() => {
    id.value = props.clientId
    infoCredito(props.clientId)
})

const id = ref(0)

const dataClient = ref([])

const order_cell = ref('id')
const order_type = ref('ASC')
const show = ref(25)
const offset = ref(3)
const search = ref('')
const pagination = ref('')
const setTimeoutSearch = ref('')

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

    axios.post('/creditos-pagination', {
        "page": page,
        "show": show.value,
        "search": search.value,
        "order_field": order_cell.value,
        "order_type": order_type.value
    })
        .then((response) => {
            let res = response.data;
            dataClient.value = res.data.data;
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


const infoCredito = (id) => {
    console.log(id)
    axios.post(`/get-info-credito`, { id: id }).then(({ data }) => {
        console.log(data.data.data)
        dataClient.value = data.data.data
        pagination.value = data.pagination;
    })
}

const transforDate = (date) => {
    let fecha = new Date(date);

    let fechaFormateada = fecha.toISOString().slice(0, 10);
    let horaFormateada = fecha.toISOString().slice(11, 16);
    let resultado = fechaFormateada + ", " + horaFormateada;

    return resultado;
}


</script>

<template>
    <div class='row'>

        <!-- FILTRO -->
        <div class='col-md-6 col-sm-6 col-xs-12'>
            <b>Mostrar </b>
            <select id="entries" @change='paginationList()' v-model="show">
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
                                Nombre del producto
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

                        <tr v-for=" ( item_data, i ) in dataClient " :key='i'>

                            <td>
                                {{ item_data.nombre_producto }} {{ item_data.nombre_caract }}
                            </td>
                            <td>
                                {{ item_data.monto }}
                            </td>
                            <td>
                                {{ item_data.tiempo }}
                            </td>
                            <td class=" text-center">
                                <span v-if="item_data.estado_solicitud == 'En Tramite'" class="badge badge-warning p-2">
                                    {{ item_data.estado_solicitud }}
                                </span>
                                <span v-if="item_data.estado_solicitud == 'Solicitado'" class="badge badge-info p-2">
                                    {{ item_data.estado_solicitud }}
                                </span>
                                <span v-if="item_data.estado_solicitud == 'Aceptado'" class="badge badge-success p-2">
                                    {{ item_data.estado_solicitud }}
                                </span>
                                <span v-if="item_data.estado_solicitud == 'Denegado'" class="badge badge-danger p-2">
                                    {{ item_data.estado_solicitud }}
                                </span>
                            </td>
                            <td>
                                {{ transforDate(item_data.created_at) }}
                            </td>

                            <td>
                                <div class='d-flex flex-row justify-content-center'>

                                    <Link :href="route('solicitud.show', { id: item_data.id })"
                                        class="btn mr-1 btn-xs bg-info btn-round" data-toggle="tooltip"
                                        title="Ver detalle">
                                    <i class='fas fa-eye'></i>
                                    </Link>


                                </div>
                            </td>

                        </tr>

                        <tr v-show='dataClient.length == 0'>
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

</template>