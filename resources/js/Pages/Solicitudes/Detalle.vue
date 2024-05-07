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

const props = defineProps(['solicitud', 'cliente'])

onMounted(() => {
    activeMenu('solicitudes', 'solicitudes')

    cliente.value = props.cliente
    solicitud.value = props.solicitud

    console.log(props.solicitud)

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


const updateStateSolicitud = (valor) => {
    axios.put('/update-solicitud/' + producto.value.id, { accion: valor }).then(({ data }) => {
        Swal.fire({
            icon: 'success',
            title: 'Solicitud realizada'
        })
    })
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
                    <h4>Resumen de solicitudes</h4>
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
                                    vigentes</a></li>
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
                                        <p>{{ solicitud.direccion_pers }}</p>
                                    </div>
                                    <div class="col-4">
                                        <b>Teléfono</b>
                                        <p>{{ solicitud.telefono }}</p>
                                    </div>

                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Edad</b>
                                        <p>{{ solicitud.edad }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Estado Civil</b>
                                        <p>{{ solicitud.estado_civil }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Dirección de Residencia</b>
                                        <p>{{ solicitud.direccion_recidencia }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Teléfono</b>
                                        <p>{{ solicitud.telefono_recidencia }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Cuidad y Dept.</b>
                                        <p>{{ solicitud.ciudad_recidencia }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Profesión</b>
                                        <p>{{ solicitud.profesion }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Empresa donde trabaja</b>
                                        <p>{{ solicitud.empresa }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Teléfono</b>
                                        <p>{{ solicitud.empresa_telefono }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Cargo Actual</b>
                                        <p>{{ solicitud.cargo_actual }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Antigüedad de la Empresa</b>
                                        <p>{{ solicitud.antoguedad_empresa }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>No. Personas a Cargo</b>
                                        <p>{{ solicitud.personas_cargo }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Vivienda</b>
                                        <p>{{ solicitud.vivienda }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Es independiente?</b>
                                        <p>{{ solicitud.independiente }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Tiene Negocio Registrado en Cámara?</b>
                                        <p>{{ solicitud.camara_comercio }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Nombre del Negocio Registrado</b>
                                        <p>{{ solicitud.nombre_negocio }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Nombre del Cónyuge</b>
                                        <p>{{ solicitud.nombre_conyuge }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Ocupación</b>
                                        <p>{{ solicitud.ocupacion_conyuge }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'CC'" class="col-4">
                                        <b>Empresa</b>
                                        <p>{{ solicitud.empresa_conyuge }}</p>
                                    </div>



                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Domicilio</b>
                                        <p>{{ solicitud.domicilio }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Dirección comercial</b>
                                        <p>{{ solicitud.direccion_comercial }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Teléfono</b>
                                        <p>{{ solicitud.telefono_comercial }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Dirección Judicial</b>
                                        <p>{{ solicitud.direccion_judicial }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Teléfono</b>
                                        <p>{{ solicitud.telefono_judicial }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Representante Legal</b>
                                        <p>{{ solicitud.representante }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Cédula No.</b>
                                        <p>{{ solicitud.representante_doc }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Tipo de Cliente</b>
                                        <p>{{ solicitud.tipo_cliente }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Que tipo de Declarante es?</b>
                                        <p>{{ solicitud.tipo_declarante }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Autorretenedor</b>
                                        <p>{{ solicitud.autorretenedor }}</p>
                                    </div>

                                    <h4 class="col-12 mt-2 mb-2">Pago en</h4>

                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Persona que autoriza los Pagos</b>
                                        <p>{{ solicitud.persona_pago }}</p>
                                    </div>

                                    <div class="col-8">
                                        <b>Dirección y ciudad donde se realizarán los pagos</b>
                                        <p>{{ solicitud.direccion_pago }}</p>
                                    </div>

                                    <div class="col-4">
                                        <b>Teléfono</b>
                                        <p>{{ solicitud.telefono_pago }}</p>
                                    </div>

                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Dia de Pago</b>
                                        <p>{{ solicitud.dia_pago }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Horario de Pago</b>
                                        <p>{{ solicitud.hora_pago }}</p>
                                    </div>
                                    <div v-if="cliente.tipo_documento == 'NIT'" class="col-4">
                                        <b>Comentario Adicional</b>
                                        <p>{{ solicitud.comentatio_pago }}</p>
                                    </div>

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

                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-success float-right ml-4"
                            @click="updateStateSolicitud('Aceptado')">Aceptar</button>
                        <button class="btn btn-danger float-right"
                            @click="updateStateSolicitud('Denegado')">Denegar</button>
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