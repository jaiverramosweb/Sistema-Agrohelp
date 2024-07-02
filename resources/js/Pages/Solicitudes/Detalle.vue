<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref, computed, watch } from 'vue';
// import { Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'
import Referencias from './components/Referencias.vue';
import Linea from './components/Linea.vue';
import Patrimonio from './components/Patrimonio.vue';
import Ingreso from './components/Ingreso.vue';
import Credito from './components/Credito.vue';
import Producto from './components/Producto.vue';
import Abono from './components/Abono.vue';
import FilesComponent from '../Clients/components/FilesComponent.vue';

const props = defineProps(['solicitud', 'cliente'])

onMounted(() => {
    activeMenu('solicitudes', 'solicitudes')

    cliente.value = props.cliente
    solicitud.value = props.solicitud
    getFiles();

    console.log('info credito', props.solicitud)

})


// Metodos Requeridos para iniciar modulo
const activeMenu = (menu, submenu) => {
    $(".menu_" + menu).addClass('menu-is-opening menu-open')
    $("#menu_" + menu).addClass('active')
    $("#sub_menu_" + submenu).addClass('active')
}

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

// FIN de metodos Requeridos para iniciar modulo

const cliente = ref('')
const solicitud = ref('')
const documents_list = ref([])


const updateStateSolicitud = (valor) => {
    axios.put('/update-solicitud/' + solicitud.value.id, { accion: valor }).then(({ data }) => {
        Swal.fire({
            icon: 'success',
            title: 'Solicitud realizada'
        })
    })
}

const getFiles = () => {
    axios.get(`/get-files/${solicitud.value.id}`).then(({ data }) => {
        console.log(data.data)
        documents_list.value = data.data
    })
}

const transforDate = (date) => {
    var fecha = new Date(date);

    var año = fecha.getFullYear();
    var mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
    var dia = fecha.getDate().toString().padStart(2, '0');

    var fechaFormateada = `${año}-${mes}-${dia}`;

    return fechaFormateada

}

const downloadFile = (id) => {
    let url = '/download-files/' + id;
    window.open(url, '_blank');
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
                    <h4>Resumen de la solicitud</h4>

                    <span v-if="solicitud.estado_solicitud == 'En tramite'" class="badge badge-wellow p-2">
                        {{ solicitud.estado_solicitud }}
                    </span>
                    <span v-if="solicitud.estado_solicitud == 'En estudio'" class="badge badge-wellow p-2">
                        {{ solicitud.estado_solicitud }}
                    </span>
                    <span v-if="solicitud.estado_solicitud == 'Preaprobado'" class="badge badge-blue p-2">
                        {{ solicitud.estado_solicitud }}
                    </span>
                    <span v-if="solicitud.estado_solicitud == 'Aprobado'" class="badge badge-green p-2">
                        {{ solicitud.estado_solicitud }}
                    </span>
                    <span v-if="solicitud.estado_solicitud == 'No aprobado'" class="badge badge-red p-2">
                        {{ solicitud.estado_solicitud }}
                    </span>
                    <span v-if="solicitud.estado_solicitud == 'Condiciones no aceptadas'" class="badge badge-red p-2">
                        {{ solicitud.estado_solicitud }}
                    </span>

                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Inicio</a></li>
                        <li class="breadcrumb-item active">Solicitudes</li>
                        <li class="breadcrumb-item active">Detalle</li>
                    </ol>
                </div>

            </div>
        </template>

        <div class="row">

            <div class="col-lg-12">

                <div class="card">

                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab">Información
                                    Personal</a></li>
                            <li class="nav-item"><a class="nav-link" href="#solicitud"
                                data-toggle="tab">Amortización</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#referencia"
                                    data-toggle="tab">Referencias</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#linea" data-toggle="tab">Linea de
                                    crédito</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#patrimonio" data-toggle="tab">Patrimonio</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#ingresos" data-toggle="tab">Ingresos y
                                    Egresos</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#tarjeta" data-toggle="tab">Tarjetas y
                                    créditos
                                    vigentes</a>
                            </li>

                            <!-- <li v-if="solicitud.estado_solicitud == 'Aprobado'" class="nav-item"><a class="nav-link" href="#abono" data-toggle="tab">Abonos a capital</a>
                            </li> -->
                            
                        </ul>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="tab-content">

                            <div class="active tab-pane" id="info">
                                <div class="row">
                                    <div class="col-4">
                                        <b v-if="cliente.tipo_documento == 'NIT'">Nombre o Razón social</b>
                                        <b v-else>Nombres y Apellidos</b>
                                        <br />
                                        <p>
                                            {{ cliente.nombre }}
                                        </p>
                                    </div>

                                    <div class="col-4">
                                        <b>Tipo de Identificación</b>
                                        <p>{{ cliente.tipo_documento }}</p>
                                    </div>
                                    <div class="col-4">
                                        <b>Numero</b>
                                        <p>{{ cliente.documento }}</p>
                                    </div>
                                    <div class="col-4">
                                        <b>Correo electrónico</b>
                                        <p>{{ cliente.email }}</p>
                                    </div>
                                    <div class="col-4">
                                        <b>Dirección</b>
                                        <p>{{ cliente.direccion_pers }}</p>
                                    </div>
                                    <div class="col-4">
                                        <b>Teléfono</b>
                                        <p>{{ cliente.telefono }}</p>
                                    </div>

                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Edad</b>
                                        <p>{{ cliente.edad }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Estado Civil</b>
                                        <p>{{ cliente.estado_civil }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Dirección de Residencia</b>
                                        <p>{{ cliente.direccion_recidencia }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Teléfono</b>
                                        <p>{{ cliente.telefono_recidencia }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Cuidad y Dept.</b>
                                        <p>{{ cliente.ciudad_recidencia }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Profesión</b>
                                        <p>{{ cliente.profesion }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Empresa donde trabaja</b>
                                        <p>{{ cliente.empresa }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Teléfono</b>
                                        <p>{{ cliente.empresa_telefono }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Cargo Actual</b>
                                        <p>{{ cliente.cargo_actual }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Antigüedad de la Empresa</b>
                                        <p>{{ cliente.antoguedad_empresa }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>No. Personas a Cargo</b>
                                        <p>{{ cliente.personas_cargo }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Vivienda</b>
                                        <p>{{ cliente.vivienda }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Es independiente?</b>
                                        <p>{{ cliente.independiente }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Tiene Negocio Registrado en Cámara?</b>
                                        <p>{{ cliente.camara_comercio }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Nombre del Negocio Registrado</b>
                                        <p>{{ cliente.nombre_negocio }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Nombre del Cónyuge</b>
                                        <p>{{ cliente.nombre_conyuge }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Ocupación</b>
                                        <p>{{ cliente.ocupacion_conyuge }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Empresa</b>
                                        <p>{{ cliente.empresa_conyuge }}</p>
                                    </div>



                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Domicilio</b>
                                        <p>{{ cliente.domicilio }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Dirección comercial</b>
                                        <p>{{ cliente.direccion_comercial }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Teléfono</b>
                                        <p>{{ cliente.telefono_comercial }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Dirección Judicial</b>
                                        <p>{{ cliente.direccion_judicial }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Teléfono</b>
                                        <p>{{ cliente.telefono_judicial }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Representante Legal</b>
                                        <p>{{ cliente.representante }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Cédula No.</b>
                                        <p>{{ cliente.representante_doc }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Tipo de Cliente</b>
                                        <p>{{ cliente.tipo_cliente }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Que tipo de Declarante es?</b>
                                        <p>{{ cliente.tipo_declarante }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Autorretenedor</b>
                                        <p>{{ cliente.autorretenedor }}</p>
                                    </div>

                                    <h4 class="col-12 mt-2 mb-2">Pago en</h4>

                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Persona que autoriza los Pagos</b>
                                        <p>{{ cliente.persona_pago }}</p>
                                    </div>

                                    <div class="col-8">
                                        <b>Dirección y ciudad donde se realizarán los pagos</b>
                                        <p>{{ cliente.direccion_pago }}</p>
                                    </div>

                                    <div class="col-4">
                                        <b>Teléfono</b>
                                        <p>{{ cliente.telefono_pago }}</p>
                                    </div>

                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Dia de Pago</b>
                                        <p>{{ cliente.dia_pago }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Horario de Pago</b>
                                        <p>{{ cliente.hora_pago }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Comentario Adicional</b>
                                        <p>{{ cliente.comentatio_pago }}</p>
                                    </div>

                                </div>

                                <div class="mt-4" v-if="solicitud">
                                    <!-- <div class="row">

                                        <div class='table-responsive'>

                                            <div class="col-12">

                                                <table class="table ">

                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col"># </th>
                                                            <th scope="col">Nombre </th>
                                                            <th scope="col">Fecha</th>
                                                            <th scope="col">Acciones</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr v-for=" ( item, i ) in documents_list " :key="i">
                                                            <td>{{ i + 1 }}</td>
                                                            <td>{{ item.name }}</td>
                                                            <td>{{ transforDate(item.created_at) }}</td>
                                                            <td>
                                                                <button class="btn mr-1 btn-xs bg-warning  btn-round"
                                                                    @click='downloadFile(item.id)'>
                                                                    <i class='fas fa-download'></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>

                                                </table>

                                            </div>

                                        </div>

                                    </div> -->

                                    <FilesComponent :solicitud_id="solicitud.id" />
                                </div>
                            </div>

                            <div v-if="solicitud.referencias" class="tab-pane" id="referencia">
                                <Referencias :referencias="solicitud.referencias" />
                            </div>

                            <div v-if="solicitud.linea" class="tab-pane" id="linea">
                                <Linea :linea="solicitud.linea" />
                            </div>

                            <div v-if="solicitud.parimonio" class="tab-pane" id="patrimonio">
                                <Patrimonio :patrimonio="solicitud.parimonio" />
                            </div>

                            <div v-if="solicitud.ingreso" class="tab-pane" id="ingresos">
                                <Ingreso :ingreso="solicitud.ingreso" />
                            </div>

                            <div v-if="solicitud.creditos" class="tab-pane" id="tarjeta">
                                <Credito :creditos="solicitud.creditos" />
                            </div>

                            <div v-if="solicitud.creditos" class="tab-pane" id="solicitud">
                                <Producto :producto="solicitud.producto" :interes="solicitud.tasa_interes"
                                    :monto_solicitar="solicitud.monto" :tiempo_pagar="solicitud.tiempo"
                                    :estado="solicitud.estado_solicitud" :solicitud_id="solicitud.id"
                                    :tipo="solicitud.cobro_intereses" :mora="solicitud.tasa_mora"
                                    :capital="solicitud.valor" />
                            </div>

                            <!-- <div v-if="solicitud.creditos" class="tab-pane" id="abono">
                                <Abono :credito="solicitud" />
                            </div> -->

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