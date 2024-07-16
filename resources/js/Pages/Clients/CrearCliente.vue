<script setup>
import { onMounted, ref } from 'vue';
import LayoutCLient from '@/Layouts/LayoutClient.vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'
import axios from 'axios';
import UserReferencia from '../Keller/Clients/components/UserReferencia.vue';
import UserCredito from '../Keller/Clients/components/UserCredito.vue';
import UserPatrimonio from '../Keller/Clients/components/UserPatrimonio.vue';
import UserIngreso from '../Keller/Clients/components/UserIngreso.vue';
import UserTarjeta from '../Keller/Clients/components/UserTarjeta.vue';

const props = defineProps(['cliente'])

onMounted(() => {
    infoUser.value = props.cliente
    getInfo(props.cliente)
    console.log(props.cliente)
})

const infoUser = ref('')

const usuario_id = ref(0)

const tipo_documento = ref('')
const documento = ref('')
const nombre = ref('')
const email = ref('')

const edad = ref('')
const domicilio = ref('')
const direccion_pers = ref('')
const telefono = ref('')
const direccion_comercial = ref('')
const telefono_comercial = ref('')
const direccion_judicial = ref('')
const telefono_judicial = ref('')
const representante = ref('')
const representante_doc = ref('')
const tipo_cliente = ref('')
const autorretenedor = ref('')
const persona_pago = ref('')
const direccion_pago = ref('')
const telefono_pago = ref('')
const dia_pago = ref('')
const hora_pago = ref('')
const comentatio_pago = ref('')
const estado_civil = ref('')
const direccion_recidencia = ref('')
const telefono_recidencia = ref('')
const ciudad_recidencia = ref('')
const empresa = ref('')
const empresa_direccion = ref('')
const empresa_telefono = ref('')
const cargo_actual = ref('')
const antoguedad_empresa = ref('')
const personas_cargo = ref('')
const vivienda = ref('')
const camara_comercio = ref('')
const profesion = ref('')
const nombre_negocio = ref('')
const tipo_direccion = ref('')
const direccion = ref('')
const ciudad = ref('')
const departamento = ref('')
const ciudad_solicitud = ref('')
const tipo_declarante = ref('')
const independiente = ref('')
const nombre_conyuge = ref('')
const ocupacion_conyuge = ref('')
const empresa_conyuge = ref('')

const getInfo = (data) => {
    usuario_id.value = data.id
    tipo_documento.value = data.tipo_documento
    documento.value = data.documento
    nombre.value = data.nombre
    email.value = data.email
    edad.value = data.edad
    domicilio.value = data.domicilio
    direccion_pers.value = data.direccion_pers
    telefono.value = data.telefono
    direccion_comercial.value = data.direccion_comercial
    telefono_comercial.value = data.telefono_comercial
    direccion_judicial.value = data.direccion_judicial
    telefono_judicial.value = data.telefono_judicial
    representante.value = data.representante
    representante_doc.value = data.representante_doc
    tipo_cliente.value = data.tipo_cliente
    autorretenedor.value = data.autorretenedor
    persona_pago.value = data.persona_pago
    direccion_pago.value = data.direccion_pago
    telefono_pago.value = data.telefono_pago
    dia_pago.value = data.dia_pago
    hora_pago.value = data.hora_pago
    comentatio_pago.value = data.comentatio_pago
    estado_civil.value = data.estado_civil
    direccion_recidencia.value = data.direccion_recidencia
    telefono_recidencia.value = data.telefono_recidencia
    ciudad_recidencia.value = data.ciudad_recidencia
    empresa.value = data.empresa
    empresa_direccion.value = data.empresa_direccion
    empresa_telefono.value = data.empresa_telefono
    cargo_actual.value = data.cargo_actual
    antoguedad_empresa.value = data.antoguedad_empresa
    personas_cargo.value = data.personas_cargo
    vivienda.value = data.vivienda
    camara_comercio.value = data.camara_comercio
    profesion.value = data.profesion
    nombre_negocio.value = data.nombre_negocio
    tipo_direccion.value = data.tipo_direccion
    direccion.value = data.direccion
    ciudad.value = data.ciudad
    departamento.value = data.departamento
    ciudad_solicitud.value = data.ciudad_solicitud
    tipo_declarante.value = data.tipo_declarante
    independiente.value = data.independiente
    nombre_conyuge.value = data.nombre_conyuge
    ocupacion_conyuge.value = data.ocupacion_conyuge
    empresa_conyuge.value = data.empresa_conyuge
}



</script>

<template>
    <LayoutCLient>
        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab">Información
                                    Personal</a>
                            </li>
                            <li v-if="usuario_id != 0" class="nav-item"><a class="nav-link" href="#referencia"
                                    data-toggle="tab">Referencias</a>
                            </li>
                            <li v-if="usuario_id != 0" class="nav-item"><a class="nav-link" href="#linea" data-toggle="tab">Linea de
                                    crédito</a>
                            </li>
                            <li v-if="usuario_id != 0" class="nav-item"><a class="nav-link" href="#patrimonio" data-toggle="tab">Patrimonio</a>
                            </li>
                            <li v-if="usuario_id != 0" class="nav-item"><a class="nav-link" href="#ingresos" data-toggle="tab">Ingresos y
                                    Egresos</a>
                            </li>
                            <li v-if="usuario_id != 0" class="nav-item"><a class="nav-link" href="#tarjeta" data-toggle="tab">Tarjetas y
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

                                    <!-- <div class="form-group col-4">
                                        <label for="tipo_documento">Tipo de Identificación <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="tipo_documento">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="CC">CC</option>
                                            <option value="NIT">NIT</option>
                                        </select>

                                    </div> -->


                                    <div class="form-group col-4">
                                        <label v-if="tipo_documento == 'NIT'" for="documento">Nit <span class="text-danger">
                                                *</span></label>
                                        <label v-else for="documento">Cédula No <span class="text-danger">
                                            *</span></label>

                                        <input v-model="documento" type="text" class="form-control" id="documento"
                                            aria-describedby="documento" autocomplete="off">
                                        <div v-if="documento == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label v-if="tipo_documento == 'NIT'">Nombre o Razón social <span
                                                class="text-danger">
                                                *</span></label>

                                        <label v-else >Nombres y Apellidos: <span class="text-danger">
                                                *</span></label>
                                        <input v-model="nombre" type="text" class="form-control" id="documento"
                                            aria-describedby="documento" autocomplete="off">
                                        <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="documento">Correo electrónico <span class="text-danger">
                                                *</span></label>
                                        <input v-model="email" type="email" class="form-control" id="telefono_judicial"
                                            aria-describedby="email" autocomplete="off" >
                                        <div v-if="email == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <!-- <div class="form-group col-6">
                                        <label for="documento">Contraseña <span class="text-danger">
                                                *</span></label>
                                        <input v-model="password" type="password" class="form-control" id="telefono_judicial"
                                            aria-describedby="password" autocomplete="off" >
                                        <div v-if="password == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div> -->

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Edad <span class="text-danger">
                                                *</span></label>
                                        <input v-model="edad" type="text" class="form-control" id="edad"
                                            aria-describedby="edad" autocomplete="off" >
                                        <div v-if="edad == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="estado_civil">Estado Civil <span class="text-danger">
                                                *</span></label>
                                        <!-- <input v-model="estado_civil" type="text" class="form-control" id="estado_civil"
                                            aria-describedby="estado_civil" autocomplete="off"  /> -->

                                        <select id="inputState" class="form-control" v-model="estado_civil"
                                            >
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Soltero">Soltero</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Unión libre">Unión libre</option>
                                            <option value="Divorciado / Separado">Divorciado / Separado</option>
                                            <option value="Viudo">Viudo</option>
                                        </select>

                                        <div v-if="estado_civil == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Domicilio <span class="text-danger">
                                                *</span></label>
                                        <input v-model="domicilio" type="text" class="form-control" id="domicilio"
                                            aria-describedby="documento" autocomplete="off" >
                                        <div v-if="domicilio == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-8">
                                        <label for="documento">Dirección comercial <span class="text-danger">
                                                *</span></label>
                                        <input v-model="direccion_comercial" type="text" class="form-control"
                                            id="direccion_comercial" aria-describedby="documento" autocomplete="off"
                                            >
                                        <div v-if="direccion_comercial == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Teléfono <span class="text-danger">
                                                *</span></label>
                                        <input v-model="telefono_comercial" type="text" class="form-control"
                                            id="telefono_comercial" aria-describedby="documento" autocomplete="off"
                                            >
                                        <div v-if="telefono_comercial == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-8">
                                        <label for="documento">Dirección Judicial <span class="text-danger">
                                                *</span></label>
                                        <input v-model="direccion_judicial" type="text" class="form-control"
                                            id="direccion_judicial" aria-describedby="documento" autocomplete="off"
                                            >
                                        <div v-if="direccion_judicial == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Teléfono <span class="text-danger">
                                                *</span></label>
                                        <input v-model="telefono_judicial" type="text" class="form-control"
                                            id="telefono_judicial" aria-describedby="documento" autocomplete="off"
                                            >
                                        <div v-if="telefono_judicial == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Dirección de Residencia <span class="text-danger">
                                                *</span></label>
                                        <input v-model="direccion_recidencia" type="text" class="form-control"
                                            id="direccion_recidencia" aria-describedby="direccion_recidencia"
                                            autocomplete="off" >
                                        <div v-if="direccion_recidencia == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Teléfono <span class="text-danger">
                                                *</span></label>
                                        <input v-model="telefono_recidencia" type="text" class="form-control"
                                            id="telefono_recidencia" aria-describedby="telefono_recidencia"
                                            autocomplete="off" >
                                        <div v-if="telefono_recidencia == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-8">
                                        <label for="edad">Cuidad y Dept. <span class="text-danger">
                                                *</span></label>
                                        <input v-model="ciudad_recidencia" type="text" class="form-control"
                                            id="ciudad_recidencia" aria-describedby="ciudad_recidencia"
                                            autocomplete="off" >
                                        <div v-if="ciudad_recidencia == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-8">
                                        <label for="documento">Dirección <span class="text-danger">
                                                *</span></label>
                                        <input v-model="direccion_pers" type="text" class="form-control"
                                            id="telefono_judicial" aria-describedby="direccion_pers" autocomplete="off"
                                            >
                                        <div v-if="direccion_pers == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="documento">Teléfono <span class="text-danger">
                                                *</span></label>
                                        <input v-model="telefono" type="text" class="form-control" id="telefono"
                                            aria-describedby="documento" autocomplete="off" >
                                        <div v-if="telefono == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Profesión <span class="text-danger">
                                                *</span></label>
                                        <input v-model="profesion" type="text" class="form-control" id="profesion"
                                            aria-describedby="profesion" autocomplete="off" >
                                        <div v-if="profesion == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Empresa donde trabaja<span class="text-danger">
                                                *</span></label>
                                        <input v-model="empresa" type="text" class="form-control" id="empresa"
                                            aria-describedby="empresa" autocomplete="off" >
                                        <div v-if="empresa == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Dirección y ciudada<span class="text-danger">
                                                *</span></label>
                                        <input v-model="empresa_direccion" type="text" class="form-control"
                                            id="empresa_direccion" aria-describedby="empresa_direccion"
                                            autocomplete="off" >
                                        <div v-if="empresa_direccion == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Teléfono<span class="text-danger">
                                                *</span></label>
                                        <input v-model="empresa_telefono" type="text" class="form-control"
                                            id="empresa_telefono" aria-describedby="empresa_telefono" autocomplete="off"
                                            >
                                        <div v-if="empresa_telefono == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Cargo Actual<span class="text-danger">
                                                *</span></label>
                                        <input v-model="cargo_actual" type="text" class="form-control" id="cargo_actual"
                                            aria-describedby="cargo_actual" autocomplete="off" >
                                        <div v-if="cargo_actual == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Antigüedad de la Empresa<span class="text-danger">
                                                *</span></label>
                                        <input v-model="antoguedad_empresa" type="text" class="form-control"
                                            id="antoguedad_empresa" aria-describedby="antoguedad_empresa"
                                            autocomplete="off" >
                                        <div v-if="antoguedad_empresa == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">No. Personas a Cargo<span class="text-danger">
                                                *</span></label>
                                        <input v-model="personas_cargo" type="text" class="form-control"
                                            id="personas_cargo" aria-describedby="personas_cargo" autocomplete="off"
                                            >
                                        <div v-if="personas_cargo == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Vivienda<span class="text-danger">
                                                *</span></label>
                                        <input v-model="vivienda" type="text" class="form-control" id="vivienda"
                                            aria-describedby="vivienda" autocomplete="off" >
                                        <div v-if="vivienda == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="documento">Es independiente? <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="independiente"
                                            >
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="documento">Tiene Negocio Registrado en Cámara? <span
                                                class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="camara_comercio"
                                            >
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Nombre del Negocio Registrado<span class="text-danger">
                                                *</span></label>
                                        <input v-model="nombre_negocio" type="text" class="form-control"
                                            id="nombre_negocio" aria-describedby="nombre_negocio" autocomplete="off"
                                            >
                                        <div v-if="nombre_negocio == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Nombre del Cónyuge<span class="text-danger">
                                                *</span></label>
                                        <input v-model="nombre_conyuge" type="text" class="form-control"
                                            id="nombre_conyuge" aria-describedby="nombre_conyuge" autocomplete="off"
                                            >
                                        <div v-if="nombre_conyuge == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Ocupación<span class="text-danger">
                                                *</span></label>
                                        <input v-model="ocupacion_conyuge" type="text" class="form-control"
                                            id="ocupacion_conyuge" aria-describedby="ocupacion_conyuge"
                                            autocomplete="off" >
                                        <div v-if="ocupacion_conyuge == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Empresa<span class="text-danger">
                                                *</span></label>
                                        <input v-model="empresa_conyuge" type="text" class="form-control"
                                            id="empresa_conyuge" aria-describedby="empresa_conyuge" autocomplete="off"
                                            >
                                        <div v-if="empresa_conyuge == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Representante Legal <span class="text-danger">
                                                *</span></label>
                                        <input v-model="representante" type="text" class="form-control"
                                            id="representante" aria-describedby="documento" autocomplete="off"
                                            >
                                        <div v-if="representante == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Cédula No. <span class="text-danger">
                                                *</span></label>
                                        <input v-model="representante_doc" type="text" class="form-control"
                                            id="representante_doc" aria-describedby="representante_doc"
                                            autocomplete="off" >
                                        <div v-if="representante_doc == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Tipo de Cliente <span class="text-danger">
                                                *</span></label>
                                        <input v-model="tipo_cliente" type="text" class="form-control" id="tipo_cliente"
                                            aria-describedby="tipo_cliente" autocomplete="off" >
                                        <div v-if="tipo_cliente == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Que tipo de Declarante es? <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="tipo_declarante"
                                            >
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Empresa Estatal">Empresa Estatal</option>
                                            <option value="Régimen Común">Régimen Común</option>
                                            <!-- <option value="Régimen Simplificado">Régimen Simplificado</option> -->
                                            <option value="No Responsable de IVA">No Responsable de IVA</option>
                                            <option value="Gran Contribuyente">Gran Contribuyente</option>
                                        </select>
                                    </div>


                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Autorretenedor <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="autorretenedor"
                                            >
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>


                                    <hr class="col-11">

                                    <h4 class="col-12">Pago en</h4>


                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-12">
                                        <label for="documento">Persona que autoriza los Pagos <span class="text-danger">
                                                *</span></label>
                                        <input v-model="persona_pago" type="text" class="form-control" id="persona_pago"
                                            aria-describedby="persona_pago" autocomplete="off" >
                                        <div v-if="persona_pago == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-8">
                                        <label for="documento">Dirección y ciudad donde se realizarán los pagos<span
                                                class="text-danger">
                                                *</span></label>
                                        <input v-model="direccion_pago" type="text" class="form-control"
                                            id="direccion_pago" aria-describedby="direccion_pago" autocomplete="off"
                                            >
                                        <div v-if="direccion_pago == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="documento">Teléfono<span class="text-danger">
                                                *</span></label>
                                        <input v-model="telefono_pago" type="text" class="form-control"
                                            id="direccion_pago" aria-describedby="direccion_pago" autocomplete="off"
                                            >
                                        <div v-if="direccion_pago == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-6">
                                        <label for="dia_pago">Dia de Pago</label>
                                        <input v-model="dia_pago" type="text" class="form-control" id="dia_pago"
                                            aria-describedby="dia_pago" autocomplete="off" >
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-6">
                                        <label for="hora_pago">Horario de Pago</label>
                                        <input v-model="hora_pago" type="text" class="form-control" id="hora_pago"
                                            aria-describedby="hora_pago" autocomplete="off" >
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-12">
                                        <label for="comentatio_pago">Comentario Adicional</label>
                                        <input v-model="comentatio_pago" type="text" class="form-control"
                                            id="comentatio_pago" aria-describedby="comentatio_pago" autocomplete="off"
                                            >
                                    </div>

                                    <div  v-if="usuario_id == 0" class="col-12">
                                        <button @click="saveInfoClient" class="btn btn-success float-right">Guardar</button>
                                    </div>

                                    <div  v-if="usuario_id != 0" class="col-12">
                                        <button @click="saveInfoClientUpdate" class="btn btn-success float-right">Guardar</button>
                                    </div>

                                </div>
                            </div>

                            <div v-if="usuario_id != 0" class="tab-pane" id="referencia">
                                <UserReferencia :usuario_id="usuario_id" />
                            </div>

                            <div v-if="usuario_id != 0" class="tab-pane" id="linea">
                                <UserCredito :usuario_id="usuario_id" />
                            </div>

                            <div v-if="usuario_id != 0" class="tab-pane" id="patrimonio">
                                <UserPatrimonio :usuario_id="usuario_id" />
                            </div>

                            <div v-if="usuario_id != 0" class="tab-pane" id="ingresos">
                                <UserIngreso :usuario_id="usuario_id" />
                            </div>

                            <div v-if="usuario_id != 0" class="tab-pane" id="tarjeta">
                                <UserTarjeta :usuario_id="usuario_id" />
                            </div>

                        </div>

                    </div>

                </div>

            </div>

</div>
    </LayoutCLient>
</template>