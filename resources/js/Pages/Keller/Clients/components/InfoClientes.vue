<script setup>
import { onMounted, ref } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'
import FilesComponent from '@/Pages/Clients/components/FilesComponent.vue';
import Linea from '@/Pages/Solicitudes/components/Linea.vue';
import Referencias from '@/Pages/Solicitudes/components/Referencias.vue';
import Patrimonio from '@/Pages/Solicitudes/components/Patrimonio.vue';
import Ingreso from '@/Pages/Solicitudes/components/Ingreso.vue';
import Credito from '@/Pages/Solicitudes/components/Credito.vue';
import Producto from '@/Pages/Solicitudes/components/Producto.vue';

const props = defineProps([
    'cliente'
])

onMounted(() => {})


</script>

<template>
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
                        vigentes</a>
                </li>
                
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
                        <FilesComponent :solicitud_id="solicitud.id" />
                    </div>
                </div>

                <div v-if="cliente.referencias" class="tab-pane" id="referencia">
                    <Referencias :referencias="cliente.referencias" />
                </div>

                <div v-if="cliente.linea" class="tab-pane" id="linea">
                    <Linea :linea="cliente.linea" />
                </div>

                <div v-if="cliente.parimonio" class="tab-pane" id="patrimonio">
                    <Patrimonio :patrimonio="cliente.parimonio" />
                </div>

                <div v-if="cliente.ingreso" class="tab-pane" id="ingresos">
                    <Ingreso :ingreso="cliente.ingreso" />
                </div>

                <div v-if="cliente.creditos" class="tab-pane" id="tarjeta">
                    <Credito :creditos="cliente.creditos" />
                </div>

            </div>

        </div>

    </div>

</div>

</div>
</template>