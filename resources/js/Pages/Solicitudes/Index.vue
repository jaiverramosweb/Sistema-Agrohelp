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

const client_id = ref(0)
const monto = ref(50000000)
const tiempo = ref(0)
const tipo_interes = ref('')
const interes = ref(0)
const interes_mas = ref(0)
const tipo_amortizacion = ref('')

const dataIntereses = ref([])
const dataClient = ref([])
const dataSolicitudes = ref([])
const tablaAmortizacion = ref([])

const newCredit = () => {
    axios.get('/get-intereses').then(({data}) => {
        const d = data.filter(f => f.name !== 'Mora')
        dataIntereses.value = d
    })

    getClient()

    $('#modalSolicitud').modal('show')
}

const getClient = () => {
    axios.get('/get-clients').then(({data}) => {
        dataClient.value = data
    })
}

const formatDate = (date) => {
    let dateString = date.substring(0, 10);
    return dateString
}

const formatearMoneda = (numero) => {
    const num = parseFloat(numero)
    return '$ ' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

const amortizacion = () => {
    if(tipo_amortizacion.value == 'Mensual'){
        amortizacionMensual()
    } else {
        amortizacionVariable()
    }
}

const amortizacionVariable = () => {

    let tipoCuotras = 1
    let taza_interes = 0

    if (tipo_amortizacion.value == 'Trimestral') {
        tipoCuotras = 3
    }
    if (tipo_amortizacion.value == 'Semestral') {
        tipoCuotras = 6
    }

    if(tipo_interes.value == 'IPC'){
        taza_interes = interes_mas.value + interes.value
    } else {
        taza_interes =  interes.value
    }

    // monto_aprobar.value = monto_solicitar.value * 0.7

    // Parámetros
    const r_mensual = taza_interes / 100; // Tasa de interés mensual
    // const capital = monto.value / (tiempo.value / tipoCuotras); // Pago de capital trimestral
    const capital = monto.value / (tiempo.value / tipoCuotras); // Pago de capital trimestral
    const fecha_inicial = new Date(); // Fecha actual
    let saldo_pendiente = monto.value;

    // Array para almacenar los pagos
    tablaAmortizacion.value = [];

    for (let i = 0; i < tiempo.value; i++) {
        let pago_interes = saldo_pendiente * r_mensual;
        let pago_capital = 0;

        // Si es el último mes del trimestre, se paga el capital
        if ((i + 1) % tipoCuotras === 0) {
            pago_capital = capital;
        }

        let cuota = pago_interes + pago_capital;
        // const cuota = (r_mensual * monto.value) / (1- Math.pow((1 + r_mensual), -tiempo))
        saldo_pendiente -= pago_capital;

        // Generar la fecha del pago
        let fecha_pago = new Date(fecha_inicial);
        fecha_pago.setMonth(fecha_inicial.getMonth() + i);

        // Añadir al array de amortización
        tablaAmortizacion.value.push({
            mes:i + 1,
            fecha: fecha_pago.toLocaleDateString(),
            cuota: cuota.toFixed(2),
            interes: pago_interes.toFixed(2),
            amortizacion: pago_capital.toFixed(2),
            saldoPendiente: saldo_pendiente.toFixed(2)
        });
    }

}

// const amortizacion = () => {
//     const monto = 50000000
//     const tiempo = 12
//     const interes = 2.3 / 100;

//     const cuota = (interes * monto) / (1- Math.pow((1 + interes), -tiempo))

//     console.log(cuota)
// }

const amortizacionMensual = () => {
    const r_mensual = interes.value / 100;
    const fecha_inicial = new Date();

    // Calcular la tasa efectiva para el período seleccionado
    const r_periodica = Math.pow(1 + r_mensual, 1) - 1;

    // Calcular la cuota periódica ajustada para la periodicidad
    const n_periodos = Math.ceil(tiempo.value / 1);
    const cuota_periodica = monto.value * r_periodica / (1 - Math.pow(1 + r_periodica, -n_periodos));

    tablaAmortizacion.value = [];
    let saldo_pendiente = parseFloat(monto.value);

    for (let mes = 1; mes <= tiempo.value; mes++) {
        let pago_interes = saldo_pendiente * r_mensual;
        let pago_principal = 0;
        let cuota_actual = 0;

        // Realizar el pago de capital solo en los meses correspondientes a la periodicidad seleccionada
        if (mes % 1 === 0 || mes === tiempo.value) {
            cuota_actual = cuota_periodica;
            pago_principal = cuota_actual - pago_interes;
            saldo_pendiente -= pago_principal;

            // Ajustar el saldo pendiente al final para corregir pequeños errores de redondeo
            if (mes === tiempo.value && Math.abs(saldo_pendiente) < 1) {
                saldo_pendiente = 0;
            }
        } else {
            cuota_actual = pago_interes;
        }

        let fecha_pago = new Date(fecha_inicial);
        fecha_pago.setMonth(fecha_inicial.getMonth() + mes);

        tablaAmortizacion.value.push({
            mes: mes,
            fecha: fecha_pago.toLocaleDateString(),
            cuota: cuota_actual.toFixed(2),
            amortizacion: pago_principal.toFixed(2),
            interes: pago_interes.toFixed(2),
            saldoPendiente: saldo_pendiente.toFixed(2)
        });
    }
}


// const amortizacion = () => {

//     const r_mensual = interes.value / 100;
//     const cuota_mensual = monto.value * r_mensual * Math.pow(1 + r_mensual, tiempo.value) / (Math.pow(1 + r_mensual, tiempo.value) - 1);
//     const fecha_inicial = new Date();

//     tablaAmortizacion.value = [];
//     let saldo_pendiente = monto.value;

//     for (let mes = 1; mes <= tiempo.value; mes++) {
//         let pago_interes = saldo_pendiente * r_mensual;
//         let pago_principal = cuota_mensual - pago_interes;
//         saldo_pendiente -= pago_principal;

//         let fecha_pago = new Date(fecha_inicial);
//         fecha_pago.setMonth(fecha_inicial.getMonth() + mes);

//         tablaAmortizacion.value.push({
//             mes: mes,
//             fecha: fecha_pago.toLocaleDateString(),
//             cuota: cuota_mensual.toFixed(2),
//             amortizacion: pago_principal.toFixed(2),
//             interes: pago_interes.toFixed(2),
//             saldoPendiente: saldo_pendiente.toFixed(2)
//         });
//     }
// };

const solicitarCredit = () => {
    axios.post('/solicitud-inicial', {
        client_id: client_id.value,
        monto_solicitar: monto.value,
        tiempo_pagar: tiempo.value,
        ineteres: interes.value,
        tipo_interes: tipo_interes.value,      
        interes_mas: interes_mas.value,
        cobro_intereses: tipo_amortizacion.value
    }).then(({ data }) => {
        Swal.fire({
            icon: 'success',
            title: 'Registro creado con exito'
        })
        // paginationList()
        // $("#modalSolicitud").modal("hide");
        location.reload();
    })
}



watch(tipo_interes, () =>{
    if(tipo_interes.value == 'IPC'){
        const ipc = dataIntereses.value.filter(i => i.name == 'IPC')
        interes.value = 0
        interes_mas.value = ipc[0].valor
    } else {
        const otro = dataIntereses.value.filter(i => i.name == 'Corriente')
        interes.value = otro[0].valor
    }
})

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
                            <button v-if="permissions.create" type="button" class="btn btn-success" @click="newCredit">
                                Crear solicitud
                            </button>

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
                <div class="modal fade" id="modalSolicitud" data-backdrop="static" tabindex="-1"
                    aria-labelledby="modalSolicitudLabel" aria-hidden="true">
                    <!-- <div class="modal-dialog"> -->
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalSolicitudLabel">+ Nuevo solicitud</h5>

                            </div>
                            <div class="modal-body">

                                <div class="row">

                                    <div class="form-group col-2" has-validation>
                                        <label for="monto">Cliente <span
                                                class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="client_id">
                                            <option value="" selected>Seleccione...</option>
                                            <option v-for="client in dataClient" :key="client.id" :value="client.id">{{ client.nombre }}</option>
                                        </select>
                                    </div>
                                    

                                    <div class="form-group col-2" has-validation>
                                        <label for="monto">Monto a solicitar <span
                                                class="text-danger">
                                                *</span></label>
                                        <input v-model="monto" type="text" class="form-control"
                                            id="monto" aria-describedby="monto"
                                            autocomplete="off">
                                    </div>

                                    <div class="form-group col-1" has-validation>
                                        <label for="tiempo">Tiempo <span class="text-danger">
                                                *</span></label>
                                        <input v-model="tiempo" type="number" class="form-control" id="tiempo"
                                            aria-describedby="tiempo" autocomplete="off">
                                    </div>



                                    <div class="form-group col-2">
                                        <label for="inputState">Tipo de interes <span class="text-danger">*</span></label>
                                        <select id="inputState" class="form-control" v-model="tipo_interes">
                                            <option value="" selected>Seleccione...</option>
                                            <option v-for="int in dataIntereses" :key="int.id" :value="int.name">{{ int.name }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-2" has-validation>
                                        <label for="tiempo">interes <span class="text-danger">
                                                *</span></label>
                                        <input v-model="interes" type="text" class="form-control" id="tiempo"
                                            aria-describedby="tiempo" autocomplete="off">
                                    </div>

                                    <div class="form-group col-2">
                                        <label for="inputState">Periocidad de pagos <span class="text-danger">*</span></label>
                                        <select id="inputState" class="form-control" v-model="tipo_amortizacion">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Mensual">Mensual</option>
                                            <option value="Trimestral">Trimestral</option>
                                            <option value="Semestral">Semestral</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-1">
                                        <button @click="amortizacion" class="btn btn-info" style="margin-top: 32px;">Calcular</button>
                                    </div>
                                        
                                    <div v-if="tablaAmortizacion.length > 0" class="form-group col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Mes</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Cuota</th>
                                                        <th scope="col">Interés</th>
                                                        <th scope="col">Valor Capital</th>
                                                        <th scope="col">Saldo Pendiente</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="fila in tablaAmortizacion" :key="fila.fecha">
                                                        <td scope="row">{{ fila.mes }}</td>
                                                        <td scope="row">{{ fila.fecha }}</td>
                                                        <td>{{ formatearMoneda(fila.cuota) }}</td>
                                                        <td>{{ formatearMoneda(fila.interes) }}</td>
                                                        <td>{{ formatearMoneda(fila.amortizacion) }}</td>
                                                        <td>{{ formatearMoneda(fila.saldoPendiente) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button v-if="tablaAmortizacion.length > 0" @click="solicitarCredit" type="button" class="btn btn-primary">Solicitar</button>
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