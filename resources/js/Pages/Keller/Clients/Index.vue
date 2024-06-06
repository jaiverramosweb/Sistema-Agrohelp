<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, reactive, ref, computed, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'



const props = defineProps(['permissions', 'clients'])

onMounted(() => {
    activeMenu('clients', 'clients')

    dataClients.value = props.clients.data.data
    pagination.value = props.clients.pagination

})

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


const dataClients = ref('')

const id = ref(0)
const tipo_identificacion = ref('')
const documento = ref('')
const nombre = ref('')
const email = ref('')
const password = ref('')
const id_user_sap = ref('')
const id_prove_sap = ref('')

const view = ref(false)


// Metodos Requeridos para iniciar modulo
const activeMenu = (menu, submenu) => {
    $(".menu_" + menu).addClass('menu-is-opening menu-open')
    $("#menu_" + menu).addClass('active')
    $("#sub_menu_" + submenu).addClass('active')
}

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
            dataClients.value = res.data.data;
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


// Modulos a crear


const save = () => {
    if (tipo_identificacion.value.length == 0) return
    if (documento.value.length == 0) return
    if (nombre.value.length == 0) return


    axios.post('/clients', {
        email: email.value,
        password: password.value,
        tipo_documento: tipo_identificacion.value,
        documento: documento.value,
        nombre: nombre.value,
        id_user_sap: id_user_sap.value,
        id_prove_sap: id_prove_sap.value

    }).then(res => {
        Toast.fire({
            icon: 'success',
            title: 'Registro creado con exito'
        })
        clear()
        paginationList()

        $("#modalClient").modal("hide");
    })
}

const viewPass = () => {
    if(view.value == true){
        view.value = false
    } else {
        view.value = true
    }
}

const clear = () => {
    id.value = 0
    email.value = ''
    password.value = ''
    tipo_identificacion.value = ''
    documento.value = ''
    nombre.value = ''
    id_user_sap.value = ''
    id_prove_sap.value = ''
}

const edit = (item) =>{
    id.value = item.id
    email.value = item.email
    tipo_identificacion.value = item.tipo_documento
    documento.value = item.documento
    nombre.value = item.nombre
    id_user_sap.value = item.id_user_sap
    id_prove_sap.value = item.id_prove_sap

    $("#modalClient").modal("show");
}

const updated = () => {
    axios.put(`/clients/${id.value}`, {
        email: email.value,
        tipo_documento: tipo_identificacion.value,
        documento: documento.value,
        nombre: nombre.value,
        id_user_sap: id_user_sap.value,
        id_prove_sap: id_prove_sap.value

    }).then(res => {
        Toast.fire({
            icon: 'success',
            title: 'Registro actualizado con exito'
        })
        clear()
        paginationList()

        $("#modalClient").modal("hide");
    })
}
 
const deleteItem = (id) => {
    Swal.fire({
        title: 'Estas seguro de eliminarlo?',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/clients/${id}`).then(res => {
                paginationList()
                Swal.fire('Eliminado!', '', 'success')
            })
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })
}

const isLouding = () => {
    loader.value = true
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

    <AuthenticatedLayout title="Clientes">

        <div class="preloader flex-column justify-content-center align-items-center" v-if="loader">
            <img class="animation__shake" src="/assets/img/CGRLogo.png" alt="AdminLTELogo" height="100" width="200">
        </div>


        <template #header>
            <div class="row mb-2">

                <div class="col-sm-6">
                    <button v-if="permissions.create" type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#modalClient">
                        + Nuevo Cliente
                    </button>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Inicio</a></li>
                        <li class="breadcrumb-item active">Clientes</li>
                    </ol>
                </div>

            </div>
        </template>

        <div class="row">

            <div class="col-lg-12">

                <div class="card">

                    <div class="card-header">

                        <h3 class="card-title">Resumen de clientes</h3>

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
                                        <input type="text" maxlength="250" id='search' @keyup='asyncFind()'
                                            class='form-control' placeholder="Buscar" v-model="search">
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
                                                    Nombre y Apellido
                                                </th>
                                                <th>
                                                    Numero de Identificación
                                                </th>
                                                <th>
                                                    Fecha creación
                                                </th>

                                                <th class="border text-center">
                                                    <i class='fa fa-cogs '></i>
                                                </th>
                                            </tr>

                                        </thead>

                                        <tbody>

                                            <tr v-for=" ( item_data, i ) in dataClients " :key='i'>

                                                <td>
                                                    {{ item_data.nombre }} {{ item_data.apellido }}
                                                </td>
                                                <td>
                                                    {{ item_data.documento }}
                                                </td>
                                                <td>
                                                    {{ transforDate(item_data.created_at) }}
                                                </td>

                                                <td>
                                                    <div class='d-flex flex-row justify-content-center'>

                                                        <!-- <button :class="'btn mr-1 btn-xs bg-info btn-round'" @click="showItem( item_data )" v-if="permissions.read">
                                                            <i class='fas fa-eye'></i>
                                                        </button> -->

                                                        <button 
                                                            @click="edit(item_data)" 
                                                            class="btn mr-1 btn-xs btn-outline-warning  btn-round" data-toggle="tooltip" title="Editar"  v-if="permissions.update">
                                                            <i class="fas fa-user-edit"></i>
                                                        </button>

                                                        <Link class="btn mr-1 btn-sm btn-outline-info btn-round"
                                                            data-toggle="tooltip" title="Info"
                                                            :href="route('client.show', { client: item_data.id })"
                                                            @click="isLouding" v-if="permissions.read">
                                                        <i class='fas fa-eye'></i>
                                                        </Link>

                                                        <!-- <Link :href="route('info.sensor',{id: item_data.serial} )" @click="isLouding" class="btn mr-1 btn-xs bg-info btn-round" data-toggle="tooltip" title="Ir a piezometro">
                                                            <i class='fas fa-eye'></i>
                                                        </Link> -->

                                                        <!-- <button class="btn mr-1 btn-xs bg-danger btn-round"
                                                            data-toggle="tooltip" title="Eliminar"
                                                            @click='deleteItem(item_data.id)' v-if="permissions.delete">
                                                            <i class='fas fa-trash'></i>
                                                        </button> -->

                                                    </div>
                                                </td>

                                            </tr>

                                            <tr v-show='dataClients.length == 0'>
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
                <div class="modal fade" id="modalClient" data-backdrop="static" tabindex="-1"
                    aria-labelledby="modalClientLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <!-- <div class="modal-dialog modal-xl"> -->
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

                                    <div class="form-group col-6" has-validation>
                                        <label for="tipo_identificacion">Tipo de Identificación <span
                                                class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="tipo_identificacion">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="CC">CC</option>
                                            <option value="NIT">NIT</option>
                                        </select>
                                        <div v-if="tipo_identificacion == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-6" has-validation>
                                        <label for="documento">Numero de Identificación <span
                                                class="text-danger">
                                                *</span></label>
                                        <input type="number" class="form-control" v-model="documento">
                                        <div v-if="documento == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-12" has-validation>
                                        <label for="nombre">Nombre completo <span
                                                class="text-danger">
                                                *</span></label>
                                        <input type="text" class="form-control" v-model="nombre">
                                        <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-6" has-validation>
                                        <label for="id_user_sap">ID Cliente SAP</label>
                                        <input type="text" class="form-control" v-model="id_user_sap">
                                    </div>

                                    <div class="form-group col-6" has-validation>
                                        <label for="id_prove_sap">ID Proveedor SAP</label>
                                        <input type="text" class="form-control" v-model="id_prove_sap">
                                    </div>

                                    <div class="form-group col-12" has-validation>
                                        <label for="nombre">Correo electrónico <span
                                                class="text-danger">
                                                *</span></label>
                                        <input type="email" class="form-control" v-model="email">
                                        <div v-if="email == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div  v-if="id == 0" class="form-group col-12" has-validation>
                                        <label for="nombre">Contraseña <span
                                                class="text-danger">
                                                *</span></label>
                                        <div class="input-group col-12 is-invalid" has-validation>
                                            <input :type="view == false ? 'password' : 'text'" class="form-control" v-model="password">
                                            <div class="input-group-append">
                                                <button @click="viewPass" class="btn btn-outline-secondary" type="button">
                                                    <i v-if="view == false" class="far fa-eye"></i>
                                                    <i v-else class="far fa-eye-slash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div v-if="password == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    


                                </div>
                            </div>




                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button v-if="id == 0" @click="save" type="button" class="btn btn-primary">Guardar</button>
                                <button v-else @click="updated" type="button" class="btn btn-primary">Actualizar</button>
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
</style>