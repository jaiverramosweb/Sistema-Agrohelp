<script setup>
import LayoutCLient from '@/Layouts/LayoutClient.vue';
import { onMounted, ref, computed } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

import FilesComponent from './components/FilesComponent.vue'
import IngresoEgreso from './components/IngresoEgreso.vue'
import Creditos from './components/Creditos.vue'
import Patrimonio from './components/Patrimonio.vue'
import LineaCredito from './components/LineaCredito.vue'
import Referencias from './components/Referencias.vue'


const props = defineProps(['cliente', 'producto', 'documentos'])

onMounted(() => {
    tipo_documento.value = props.cliente.tipo_documento
    documento.value = props.cliente.documento
    nombre.value = props.cliente.nombre
    email.value = props.cliente.email
    producto.value = props.producto
    estadoSolicitud.value = props.producto.estado_solicitud
    documentos.value = props.documentos

    console.log('Documentos', props.documentos)
    rellenar(props.producto)
})

const mostrar = ref(false)
const mostrar_dos = ref(false)
const mostrar_vehoculo = ref(false)

const infoUser = ref('')
const infoCliente = ref('')

const estadoSolicitud = ref('')


const direcciones = ref([])
const genero = ref('')
const tipo_persona = ref('')
const fecha_nacimiento = ref('')

const producto = ref('')

const documentos = ref([])

const id = ref(0)
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

const url_img = ref([])
const url_img_dos = ref([])

const doc_id = ref(0)

const rellenar = (item) => {

    direccion_pers.value = item.direccion_pers
    telefono.value = item.telefono
    estado_civil.value = item.estado_civil
    edad.value = item.edad
    domicilio.value = item.domicilio
    direccion_comercial.value = item.direccion_comercial
    telefono_comercial.value = item.telefono_comercial
    direccion_judicial.value = item.direccion_judicial
    telefono_judicial.value = item.telefono_judicial
    representante.value = item.representante
    representante_doc.value = item.representante_doc
    tipo_cliente.value = item.tipo_cliente
    autorretenedor.value = item.autorretenedor
    persona_pago.value = item.persona_pago
    direccion_pago.value = item.direccion_pago
    telefono_pago.value = item.telefono_pago
    dia_pago.value = item.dia_pago
    hora_pago.value = item.hora_pago
    comentatio_pago.value = item.comentatio_pago
    direccion_recidencia.value = item.direccion_recidencia
    telefono_recidencia.value = item.telefono_recidencia
    ciudad_recidencia.value = item.ciudad_recidencia
    empresa_direccion.value = item.empresa_direccion
    empresa_telefono.value = item.empresa_telefono
    cargo_actual.value = item.cargo_actual
    antoguedad_empresa.value = item.antoguedad_empresa
    personas_cargo.value = item.personas_cargo
    vivienda.value = item.vivienda
    camara_comercio.value = item.camara_comercio
    profesion.value = item.profesion
    empresa.value = item.empresa
    nombre_negocio.value = item.nombre_negocio
    nombre_conyuge.value = item.nombre_conyuge
    independiente.value = item.independiente
    ocupacion_conyuge.value = item.ocupacion_conyuge
    empresa_conyuge.value = item.empresa_conyuge

}

const return_index = () => {
    window.history.back();
}

const saveCredito = () => {

    // if (tipo_documento.value.length == 0) return
    // if (documento.value.length == 0) return
    // if (nombre.value.length == 0) return


    let form = new FormData()

    form.append('id', producto.value.id)

    form.append('edad', edad.value)
    form.append('domicilio', domicilio.value)
    form.append('direccion_pers', direccion_pers.value)
    form.append('telefono', telefono.value)
    form.append('direccion_comercial', direccion_comercial.value)
    form.append('telefono_comercial', telefono_comercial.value)
    form.append('direccion_judicial', direccion_judicial.value)
    form.append('telefono_judicial', telefono_judicial.value)
    form.append('representante', representante.value)
    form.append('representante_doc', representante_doc.value)
    form.append('tipo_cliente', tipo_cliente.value)
    form.append('autorretenedor', autorretenedor.value)
    form.append('persona_pago', persona_pago.value)
    form.append('direccion_pago', direccion_pago.value)
    form.append('telefono_pago', telefono_pago.value)
    form.append('dia_pago', dia_pago.value)
    form.append('hora_pago', hora_pago.value)
    form.append('comentatio_pago', comentatio_pago.value)
    form.append('estado_civil', estado_civil.value)
    form.append('direccion_recidencia', direccion_recidencia.value)
    form.append('telefono_recidencia', telefono_recidencia.value)
    form.append('ciudad_recidencia', ciudad_recidencia.value)
    form.append('empresa_direccion', empresa_direccion.value)
    form.append('empresa_telefono', empresa_telefono.value)
    form.append('cargo_actual', cargo_actual.value)
    form.append('antoguedad_empresa', antoguedad_empresa.value)
    form.append('personas_cargo', personas_cargo.value)
    form.append('vivienda', vivienda.value)
    form.append('camara_comercio', camara_comercio.value)
    form.append('tipo_direccion', tipo_direccion.value)
    form.append('direccion', direccion.value)
    form.append('ciudad', ciudad.value)
    form.append('departamento', departamento.value)
    form.append('nombre_conyuge', nombre_conyuge.value)
    form.append('independiente', independiente.value)
    form.append('ocupacion_conyuge', ocupacion_conyuge.value)
    form.append('empresa_conyuge', empresa_conyuge.value)
    form.append('ciudad_solicitud', ciudad_solicitud.value)
    form.append('tipo_declarante', tipo_declarante.value)
    form.append('profesion', profesion.value)
    form.append('empresa', empresa.value)
    form.append('nombre_negocio', nombre_negocio.value)

    console.log(form)

    axios.post('/primera-solicitud', form).then(({ data }) => {
        console.log(data)
    })
}

const updateStateSolicitud = (valor) => {
    axios.put('/update-solicitud/' + producto.value.id, { accion: valor }).then(({ data }) => {
        Swal.fire({
            icon: 'success',
            title: 'Solicitud realizada'
        })

        setTimeout(() => {
            location.replace('/inicio');
        }, 1000);

    })
}

const mostrarUno = () => {
    mostrar.value = true
}

const mostrarDos = () => {
    mostrar_dos.value = true
}

const mostrarVeliculo = () => {
    mostrar_vehoculo.value = true
}

const descargarFormato = () => {
    let url = '/download-solicitud/' + producto.value.id;
    window.open(url, '_blank');
}

</script>

<template>
    <LayoutCLient>
        <div class="row">

            <div class="col-lg-12 mt-4">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-plus"></i>
                            Informacion necesaria para la solicitud
                        </h3>
                        <div class="card-tools">
                            <button @click='return_index()' class='btn btn-xs bg-gray'>
                                <i class='fas fa-reply'></i> Regresar
                            </button>
                        </div>
                        <br>
                        Todos los campos con (<span class="text-danger"> * </span>) son obligatorios, para un registro
                        correcto.
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <fieldset class="bordesito">
                                <legend v-if="tipo_documento == 'NIT'" class="bordesito">Persona juridica</legend>
                                <legend v-else class="bordesito">Persona natural</legend>
                                <div class="row">

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-12">
                                        <label v-if="tipo_documento == 'NIT'">Nombre o Razón social <span
                                                class="text-danger">
                                                *</span></label>

                                        <label v-else>Nombres y Apellidos: <span class="text-danger">
                                                *</span></label>
                                        <input v-model="nombre" type="text" class="form-control" id="documento"
                                            aria-describedby="documento" autocomplete="off">
                                        <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="tipo_documento">Tipo de Identificación <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="tipo_documento">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="CC">CC</option>
                                            <option value="NIT">NIT</option>
                                        </select>

                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Nit <span class="text-danger">
                                                *</span></label>
                                        <input v-model="documento" type="text" class="form-control" id="documento"
                                            aria-describedby="documento" autocomplete="off">
                                        <div v-if="documento == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="documento">Cédula No <span class="text-danger">
                                                *</span></label>
                                        <input v-model="documento" type="text" class="form-control" id="documento"
                                            aria-describedby="documento" autocomplete="off">
                                        <div v-if="documento == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Edad <span class="text-danger">
                                                *</span></label>
                                        <input v-model="edad" type="text" class="form-control" id="edad"
                                            aria-describedby="edad" autocomplete="off" @change="saveCredito">
                                        <div v-if="edad == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Estado Civil <span class="text-danger">
                                                *</span></label>
                                        <!-- <input v-model="estado_civil" type="text" class="form-control" id="estado_civil"
                                            aria-describedby="estado_civil" autocomplete="off" @change="saveCredito" /> -->

                                        <select id="inputState" class="form-control" v-model="estado_civil"
                                            @change="saveCredito">
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
                                            aria-describedby="documento" autocomplete="off" @change="saveCredito">
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
                                            @change="saveCredito">
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
                                            @change="saveCredito">
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
                                            @change="saveCredito">
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
                                            @change="saveCredito">
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
                                            autocomplete="off" @change="saveCredito">
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
                                            autocomplete="off" @change="saveCredito">
                                        <div v-if="telefono_recidencia == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-6">
                                        <label for="edad">Cuidad y Dept. <span class="text-danger">
                                                *</span></label>
                                        <input v-model="ciudad_recidencia" type="text" class="form-control"
                                            id="ciudad_recidencia" aria-describedby="ciudad_recidencia"
                                            autocomplete="off" @change="saveCredito">
                                        <div v-if="ciudad_recidencia == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="documento">Correo electrónico <span class="text-danger">
                                                *</span></label>
                                        <input v-model="email" type="email" class="form-control" id="telefono_judicial"
                                            aria-describedby="email" autocomplete="off" @change="saveCredito">
                                        <div v-if="email == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-8">
                                        <label for="documento">Dirección <span class="text-danger">
                                                *</span></label>
                                        <input v-model="direccion_pers" type="text" class="form-control"
                                            id="telefono_judicial" aria-describedby="direccion_pers" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="direccion_pers == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="documento">Teléfono <span class="text-danger">
                                                *</span></label>
                                        <input v-model="telefono" type="text" class="form-control" id="telefono"
                                            aria-describedby="documento" autocomplete="off" @change="saveCredito">
                                        <div v-if="telefono == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Profesión <span class="text-danger">
                                                *</span></label>
                                        <input v-model="profesion" type="text" class="form-control" id="profesion"
                                            aria-describedby="profesion" autocomplete="off" @change="saveCredito">
                                        <div v-if="profesion == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Empresa donde trabaja<span class="text-danger">
                                                *</span></label>
                                        <input v-model="empresa" type="text" class="form-control" id="empresa"
                                            aria-describedby="empresa" autocomplete="off" @change="saveCredito">
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
                                            autocomplete="off" @change="saveCredito">
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
                                            @change="saveCredito">
                                        <div v-if="empresa_telefono == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Cargo Actual<span class="text-danger">
                                                *</span></label>
                                        <input v-model="cargo_actual" type="text" class="form-control" id="cargo_actual"
                                            aria-describedby="cargo_actual" autocomplete="off" @change="saveCredito">
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
                                            autocomplete="off" @change="saveCredito">
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
                                            @change="saveCredito">
                                        <div v-if="personas_cargo == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Vivienda<span class="text-danger">
                                                *</span></label>
                                        <input v-model="vivienda" type="text" class="form-control" id="vivienda"
                                            aria-describedby="vivienda" autocomplete="off" @change="saveCredito">
                                        <div v-if="vivienda == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="documento">Es independiente? <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="independiente"
                                            @change="saveCredito">
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
                                            @change="saveCredito">
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
                                            @change="saveCredito">
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
                                            @change="saveCredito">
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
                                            autocomplete="off" @change="saveCredito">
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
                                            @change="saveCredito">
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
                                            @change="saveCredito">
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
                                            autocomplete="off" @change="saveCredito">
                                        <div v-if="representante_doc == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Tipo de Cliente <span class="text-danger">
                                                *</span></label>
                                        <input v-model="tipo_cliente" type="text" class="form-control" id="tipo_cliente"
                                            aria-describedby="tipo_cliente" autocomplete="off" @change="saveCredito">
                                        <div v-if="tipo_cliente == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Que tipo de Declarante es? <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="tipo_declarante"
                                            @change="saveCredito">
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
                                            @change="saveCredito">
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
                                            aria-describedby="persona_pago" autocomplete="off" @change="saveCredito">
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
                                            @change="saveCredito">
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
                                            @change="saveCredito">
                                        <div v-if="direccion_pago == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-6">
                                        <label for="dia_pago">Dia de Pago</label>
                                        <input v-model="dia_pago" type="text" class="form-control" id="dia_pago"
                                            aria-describedby="dia_pago" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-6">
                                        <label for="hora_pago">Horario de Pago</label>
                                        <input v-model="hora_pago" type="text" class="form-control" id="hora_pago"
                                            aria-describedby="hora_pago" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-12">
                                        <label for="comentatio_pago">Comentario Adicional</label>
                                        <input v-model="comentatio_pago" type="text" class="form-control"
                                            id="comentatio_pago" aria-describedby="comentatio_pago" autocomplete="off"
                                            @change="saveCredito">
                                    </div>


                                </div>

                            </fieldset>


                            <Referencias v-if="producto.referencias" :solicitud_id="producto.id"
                                :items="producto.referencias" />

                            <LineaCredito v-if="producto.linea" :solicitud_id="producto.id" :items="producto.linea"
                                :monto="producto.monto" />

                            <Patrimonio v-if="producto.parimonio" :solicitud_id="producto.id"
                                :items="producto.parimonio" />

                            <IngresoEgreso v-if="producto.ingreso" :solicitud_id="producto.id"
                                :items="producto.ingreso" />

                            <Creditos v-if="producto.creditos" :solicitud_id="producto.id" :items="producto.creditos" />

                            <fieldset class="bordesito col-12">
                                <legend class="bordesito">Documentos requeridos</legend>

                                <div class="row">
                                    <div class="table-responsive col-12">
                                        <table class="table  table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col" class="align-middle">#</th>
                                                    <th scope="col" class="align-middle">DOCUMENTACIÓN
                                                        REQUERIDA</th>
                                                </tr>


                                            </thead>
                                            <tbody>

                                                <tr v-for="(doc, i) in documentos" :key="doc.id">
                                                    <td class="text-center"> {{ i + 1 }} </td>
                                                    <td> {{ doc.nombre }} </td>

                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset v-if="producto" class="bordesito col-12">
                                <legend class="bordesito">Cargue los archivos solicitados aqui</legend>

                                <FilesComponent :solicitud_id="producto.id" />

                            </fieldset>

                            <div class='row'>
                                <div class="col-12">
                                    <button @click="descargarFormato" class="btn btn-danger float-left">Descargar
                                        formato de solicitud</button>
                                </div>
                            </div>

                            <!-- <fieldset class="bordesito">
                                <legend class="bordesito">Autorización</legend>
                                <div class="row">
                                    <div>
                                        <p class="text-justify">
                                            Autorizo con carácter permanente y de manera irrevocable a AGRO HELP S.A.S.
                                            para obtener, consultar y reportar en las centrales de información de la
                                            asociación Bancaria de Colombia,
                                            Datacredito, Cifin y/o de cualquier fuente y base de datos, la información y
                                            referencia relativas a mi documento de identificación, comportamiento
                                            crediticio, a mi comportamiento comercial y al
                                            producto de toda clase de operaciones que efectúe o haya efectuado con
                                            entidades del sector financiero y otros sectores. y que en general sirva de
                                            referencia para determinar hasta que AGRO
                                            HELP S.A.S. o las centrales de información lo consideren necesario.
                                        </p>
                                    </div>
                                </div>
                            </fieldset> -->

                            <!-- <fieldset class="bordesito col-12">
                                <legend class="bordesito">Firma del solicitante</legend>

                                <div class="row">
                                    <div class="col-6">
                                        <b> Subir firma digital<span class="text-danger">*</span> </b>
                                        <div class="input-group input-group-sm input mb-3">
                                            <input type="file" @change="select_file($event)" class="form-control-file"
                                                id="image_1">
                                        </div>
                                    </div>

                                    <div v-if="url_img != []" class="col-6">
                                        <div id="preview" class="card card-primary card-outline">
                                            <div class="card-body box-profile" style="padding:0px">
                                                <div class="text-center mt-2 mb-3">
                                                    <img :src="url_img"
                                                        class="profile-user-img img-fluid img-circle mb-3" id="img">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </fieldset> -->

                            <!-- <fieldset class="bordesito col-12">
                                <legend class="bordesito">Declaración de origen de fondos</legend>

                                <div class="row">

                                    <div class="col-12">
                                        <p class="text-justify">
                                            En cumplimiento de las normas legales contempladas en el Estatuto Orgánico
                                            del Sistema Financiero y demás normas concordantes, declaro a AGRO HELP
                                            S.A.S. <br />
                                            1. Que los fondos con los cuales cubriré mis obligaciones presentes y
                                            futuras con AGRO HELP S.A.S, provienen de las siguientes fuentes y
                                            corresponden a actividades licitas.<br />
                                            2. Que no admitiré que terceros efectúen depósitos o pagos a AGRO HELP
                                            S.A.S, en mi nombre con fondos provenientes o destinados a realizar
                                            actividades licitas.<br />
                                            Declaro que la información suministrada en esta solicitud es válida, al
                                            igual que las autorizaciones otorgadas en esta solicitud. En constancia de
                                            haber leído, entendido y aceptado esta Información, firmo el presente
                                            documento.
                                        </p>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <b> Subir firma digital<span class="text-danger">*</span> </b>
                                        <div class="input-group input-group-sm input mb-3">
                                            <input type="file" @change="select_file_dos($event)"
                                                class="form-control-file" id="image_1">
                                        </div>
                                    </div>

                                    <div v-if="url_img_dos != []" class="col-6 mt-2">
                                        <div id="preview_dos" class="card card-primary card-outline">
                                            <div class="card-body box-profile" style="padding:0px">
                                                <div class="text-center mt-2 mb-3">
                                                    <img :src="url_img_dos"
                                                        class="profile-user-img img-fluid img-circle mb-3" id="img_dos">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </fieldset> -->



                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 mt-4">
                                <button class="btn btn-success float-right" @click="updateStateSolicitud('En estudio')">
                                    Solicitar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </LayoutCLient>
</template>


<style scoped>
fieldset.bordesito {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow: 0px 0px 0px 0px #000;
    box-shadow: 0px 0px 0px 0px #000;
}

legend.bordesito {
    width: inherit;
    /* Or auto */
    padding: 0 10px;
    /* To give a bit of padding on the left and right */
    border-bottom: none;
}
</style>

<!-- En Tramite -->