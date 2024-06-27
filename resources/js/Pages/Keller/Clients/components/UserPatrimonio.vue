<script setup>
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

const props = defineProps(['usuario_id'])

onMounted(() => {
    usuario_id.value = props.usuario_id
    
    if(props.usuario_id != 0){
        getInfoPatri()
    }
})

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

const usuario_id = ref(0)

const id = ref(0)

const descripcion_bien = ref('')
const ciudad_bien = ref('')
const hipoteca_bien = ref('')
const avaluo_comercial_bien = ref('')
const avaluo_catastral_bien = ref('')
const cedula_catastral_bien = ref('')
const matricula_bien = ref('')
const escritura_bien = ref('')
const notaria_bien = ref('')
const fecha_bien = ref('')
const ciudad_parimonio_bien = ref('')
const descripcion_bien_dos = ref('')
const ciudad_bien_dos = ref('')
const hipoteca_bien_dos = ref('')
const avaluo_comercial_bien_dos = ref('')
const avaluo_catastral_bien_dos = ref('')
const cedula_catastral_bien_dos = ref('')
const matricula_bien_dos = ref('')
const escritura_bien_dos = ref('')
const notaria_bien_dos = ref('')
const fecha_bien_dos = ref('')
const ciudad_parimonio_bien_dos = ref('')
const descripcion_bien_tres = ref('')
const ciudad_bien_tres = ref('')
const hipoteca_bien_tres = ref('')
const avaluo_comercial_bien_tres = ref('')
const avaluo_catastral_bien_tres = ref('')
const cedula_catastral_bien_tres = ref('')
const matricula_bien_tres = ref('')
const escritura_bien_tres = ref('')
const notaria_bien_tres = ref('')
const fecha_bien_tres = ref('')
const ciudad_parimonio_bien_tres = ref('')
const marca_vehiculo = ref('')
const clase_vehiculo = ref('')
const modelo_vehiculo = ref('')
const placa_vehiculo = ref('')
const valor_vehiculo = ref('')
const hipoteca_vehiculo = ref('')
const marca_vehiculo_dos = ref('')

const clase_vehiculo_dos = ref('')
const modelo_vehiculo_dos = ref('')
const placa_vehiculo_dos = ref('')
const valor_vehiculo_dos = ref('')
const hipoteca_vehiculo_dos = ref('')

const saveCredito = () => {

axios.put(`/save-clients-patri/${props.usuario_id}`, {
    'descripcion_bien': descripcion_bien.value,
    'ciudad_bien': ciudad_bien.value,
    'hipoteca_bien': hipoteca_bien.value,
    'avaluo_comercial_bien': avaluo_comercial_bien.value,
    'avaluo_catastral_bien': avaluo_catastral_bien.value,
    'cedula_catastral_bien': cedula_catastral_bien.value,
    'matricula_bien': matricula_bien.value,
    'escritura_bien': escritura_bien.value,
    'notaria_bien': notaria_bien.value,
    'fecha_bien': fecha_bien.value,
    'ciudad_parimonio_bien': ciudad_parimonio_bien.value,
    'descripcion_bien_dos': descripcion_bien_dos.value,
    'ciudad_bien_dos': ciudad_bien_dos.value,
    'hipoteca_bien_dos': hipoteca_bien_dos.value,
    'avaluo_comercial_bien_dos': avaluo_comercial_bien_dos.value,
    'avaluo_catastral_bien_dos': avaluo_catastral_bien_dos.value,
    'cedula_catastral_bien_dos': cedula_catastral_bien_dos.value,
    'matricula_bien_dos': matricula_bien_dos.value,
    'escritura_bien_dos': escritura_bien_dos.value,
    'notaria_bien_dos': notaria_bien_dos.value,
    'fecha_bien_dos': fecha_bien_dos.value,
    'ciudad_parimonio_bien_dos': ciudad_parimonio_bien_dos.value,
    'descripcion_bien_tres': descripcion_bien_tres.value,
    'ciudad_bien_tres': ciudad_bien_tres.value,
    'hipoteca_bien_tres': hipoteca_bien_tres.value,
    'avaluo_comercial_bien_tres': avaluo_comercial_bien_tres.value,
    'avaluo_catastral_bien_tres': avaluo_catastral_bien_tres.value,
    'cedula_catastral_bien_tres': cedula_catastral_bien_tres.value,
    'matricula_bien_tres': matricula_bien_tres.value,
    'escritura_bien_tres': escritura_bien_tres.value,
    'notaria_bien_tres': notaria_bien_tres.value,
    'fecha_bien_tres': fecha_bien_tres.value,
    'ciudad_parimonio_bien_tres': ciudad_parimonio_bien_tres.value,
    'marca_vehiculo': marca_vehiculo.value,
    'clase_vehiculo': clase_vehiculo.value,
    'modelo_vehiculo': modelo_vehiculo.value,
    'placa_vehiculo': placa_vehiculo.value,
    'valor_vehiculo': valor_vehiculo.value,
    'hipoteca_vehiculo': hipoteca_vehiculo.value,
    'marca_vehiculo_dos': marca_vehiculo_dos.value,
    'clase_vehiculo_dos': clase_vehiculo_dos.value,
    'modelo_vehiculo_dos': modelo_vehiculo_dos.value,
    'placa_vehiculo_dos': placa_vehiculo_dos.value,
    'valor_vehiculo_dos': valor_vehiculo_dos.value,
    'hipoteca_vehiculo_dos': hipoteca_vehiculo_dos.value,
}).then(({ data }) => {
    id.value = data.id
    Toast.fire({
        icon: 'success',
        title: 'Registro creado con exito'
    })
})
}

const getInfoPatri = () => {
    axios.get(`/info-client-patri/${props.usuario_id}`).then(({ data }) => {
        descripcion_bien.value = data.descripcion_bien
        ciudad_bien.value = data.ciudad_bien
        hipoteca_bien.value = data.hipoteca_bien
        avaluo_comercial_bien.value = data.avaluo_comercial_bien
        avaluo_catastral_bien.value = data.avaluo_catastral_bien
        cedula_catastral_bien.value = data.cedula_catastral_bien
        matricula_bien.value = data.matricula_bien
        escritura_bien.value = data.escritura_bien
        notaria_bien.value = data.notaria_bien
        fecha_bien.value = data.fecha_bien
        ciudad_parimonio_bien.value = data.ciudad_parimonio_bien
        descripcion_bien_dos.value = data.descripcion_bien_dos
        ciudad_bien_dos.value = data.ciudad_bien_dos
        hipoteca_bien_dos.value = data.hipoteca_bien_dos
        avaluo_comercial_bien_dos.value = data.avaluo_comercial_bien_dos
        avaluo_catastral_bien_dos.value = data.avaluo_catastral_bien_dos
        cedula_catastral_bien_dos.value = data.cedula_catastral_bien_dos
        matricula_bien_dos.value = data.matricula_bien_dos
        escritura_bien_dos.value = data.escritura_bien_dos
        notaria_bien_dos.value = data.notaria_bien_dos
        fecha_bien_dos.value = data.fecha_bien_dos
        ciudad_parimonio_bien_dos.value = data.ciudad_parimonio_bien_dos
        descripcion_bien_tres.value = data.descripcion_bien_tres
        ciudad_bien_tres.value = data.ciudad_bien_tres
        hipoteca_bien_tres.value = data.hipoteca_bien_tres
        avaluo_comercial_bien_tres.value = data.avaluo_comercial_bien_tres
        avaluo_catastral_bien_tres.value = data.avaluo_catastral_bien_tres
        cedula_catastral_bien_tres.value = data.cedula_catastral_bien_tres
        matricula_bien_tres.value = data.matricula_bien_tres
        escritura_bien_tres.value = data.escritura_bien_tres
        notaria_bien_tres.value = data.notaria_bien_tres
        fecha_bien_tres.value = data.fecha_bien_tres
        ciudad_parimonio_bien_tres.value = data.ciudad_parimonio_bien_tres
        marca_vehiculo.value = data.marca_vehiculo
        clase_vehiculo.value = data.clase_vehiculo
        modelo_vehiculo.value = data.modelo_vehiculo
        placa_vehiculo.value = data.placa_vehiculo
        valor_vehiculo.value = data.valor_vehiculo
        hipoteca_vehiculo.value = data.hipoteca_vehiculo
        marca_vehiculo_dos.value = data.marca_vehiculo_dos
        clase_vehiculo_dos.value = data.clase_vehiculo_dos
        modelo_vehiculo_dos.value = data.modelo_vehiculo_dos
        placa_vehiculo_dos.value = data.placa_vehiculo_dos
        valor_vehiculo_dos.value = data.valor_vehiculo_dos
        hipoteca_vehiculo_dos.value = data.hipoteca_vehiculo_dos

    })
}

</script>

<template>
    <fieldset class="bordesito">
        <legend class="bordesito">Patrimonio</legend>
        <div class="row">
            <h4 class="col-12">BIENES INMUEBLES</h4>

            <div class="form-group col-4">
                <label for="descripcion_bien">Descripción</label>
                <input v-model="descripcion_bien" type="text" class="form-control" id="descripcion_bien"
                    aria-describedby="descripcion_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="ciudad_bien">Ciudad</label>
                <input v-model="ciudad_bien" type="text" class="form-control" id="ciudad_bien"
                    aria-describedby="ciudad_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="documento">Hipoteca <span class="text-danger">
                        *</span></label>
                <select id="inputState" class="form-control" v-model="hipoteca_bien" >
                    <option value="" selected>Seleccione...</option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                </select>
            </div>

            <div class="form-group col-4">
                <label for="avaluo_comercial_bien">Avaluo comercial</label>
                <input v-model="avaluo_comercial_bien" type="text" class="form-control" id="avaluo_comercial_bien"
                    aria-describedby="avaluo_comercial_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="avaluo_catastral_bien">Avaluo catastral</label>
                <input v-model="avaluo_catastral_bien" type="text" class="form-control" id="avaluo_catastral_bien"
                    aria-describedby="avaluo_catastral_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="cedula_catastral_bien">Cédula catastral No.</label>
                <input v-model="cedula_catastral_bien" type="text" class="form-control" id="cedula_catastral_bien"
                    aria-describedby="cedula_catastral_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="matricula_bien">Matricula inmobiliarial No.</label>
                <input v-model="matricula_bien" type="text" class="form-control" id="matricula_bien"
                    aria-describedby="matricula_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="escritura_bien">Escribura pública No.</label>
                <input v-model="escritura_bien" type="text" class="form-control" id="escritura_bien"
                    aria-describedby="escritura_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="notaria_bien">Notaria</label>
                <input v-model="notaria_bien" type="text" class="form-control" id="notaria_bien"
                    aria-describedby="notaria_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="fecha_bien">Fecha</label>
                <input v-model="fecha_bien" type="date" class="form-control" id="fecha_bien"
                    aria-describedby="fecha_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="ciudad_parimonio_bien">Ciudad</label>
                <input v-model="ciudad_parimonio_bien" type="text" class="form-control" id="ciudad_parimonio_bien"
                    aria-describedby="ciudad_parimonio_bien" autocomplete="off" >
            </div>

            <div v-if="!mostrar" class="form-group col-4">
                <button @click="mostrarUno" class="btn btn-info float-right mt-4">Agregar
                    Otro</button>
            </div>

            <div v-if="mostrar" class="row">

                <hr class=" col-11" />

                <div class="form-group col-4">
                    <label for="descripcion_bien">Descripción</label>
                    <input v-model="descripcion_bien_dos" type="text" class="form-control" id="descripcion_bien"
                        aria-describedby="descripcion_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_bien">Ciudad</label>
                    <input v-model="ciudad_bien_dos" type="text" class="form-control" id="ciudad_bien"
                        aria-describedby="ciudad_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="documento">Hipoteca <span class="text-danger">
                            *</span></label>
                    <select id="inputState" class="form-control" v-model="hipoteca_bien_dos" >
                        <option value="" selected>Seleccione...</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="form-group col-4">
                    <label for="avaluo_comercial_bien">Avaluo comercial</label>
                    <input v-model="avaluo_comercial_bien_dos" type="text" class="form-control"
                        id="avaluo_comercial_bien" aria-describedby="avaluo_comercial_bien" autocomplete="off"
                        >
                </div>

                <div class="form-group col-4">
                    <label for="avaluo_catastral_bien">Avaluo catastral</label>
                    <input v-model="avaluo_catastral_bien_dos" type="text" class="form-control"
                        id="avaluo_catastral_bien" aria-describedby="avaluo_catastral_bien" autocomplete="off"
                        >
                </div>

                <div class="form-group col-4">
                    <label for="cedula_catastral_bien">Cédula catastral No.</label>
                    <input v-model="cedula_catastral_bien_dos" type="text" class="form-control"
                        id="cedula_catastral_bien" aria-describedby="cedula_catastral_bien" autocomplete="off"
                        >
                </div>

                <div class="form-group col-4">
                    <label for="matricula_bien">Matricula inmobiliarial No.</label>
                    <input v-model="matricula_bien_dos" type="text" class="form-control" id="matricula_bien"
                        aria-describedby="matricula_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="escritura_bien">Escribura pública No.</label>
                    <input v-model="escritura_bien_dos" type="text" class="form-control" id="escritura_bien"
                        aria-describedby="escritura_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="notaria_bien">Notaria</label>
                    <input v-model="notaria_bien_dos" type="text" class="form-control" id="notaria_bien"
                        aria-describedby="notaria_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="fecha_bien">Fecha</label>
                    <input v-model="fecha_bien_dos" type="date" class="form-control" id="fecha_bien"
                        aria-describedby="fecha_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_parimonio_bien">Ciudad</label>
                    <input v-model="ciudad_parimonio_bien_dos" type="text" class="form-control"
                        id="ciudad_parimonio_bien" aria-describedby="ciudad_parimonio_bien" autocomplete="off"
                        >
                </div>

                <div v-if="!mostrar_dos" class="form-group col-4">
                    <button @click="mostrarDos" class="btn btn-info float-right mt-4">Agregar
                        Otro</button>
                </div>

            </div>

            <div v-if="mostrar_dos" class="row">

                <hr class=" col-11" />

                <div class="form-group col-4">
                    <label for="descripcion_bien">Descripción</label>
                    <input v-model="descripcion_bien_tres" type="text" class="form-control" id="descripcion_bien"
                        aria-describedby="descripcion_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_bien">Ciudad</label>
                    <input v-model="ciudad_bien_tres" type="text" class="form-control" id="ciudad_bien"
                        aria-describedby="ciudad_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="documento">Hipoteca <span class="text-danger">
                            *</span></label>
                    <select id="inputState" class="form-control" v-model="hipoteca_bien_tres" >
                        <option value="" selected>Seleccione...</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="form-group col-4">
                    <label for="avaluo_comercial_bien">Avaluo comercial</label>
                    <input v-model="avaluo_comercial_bien_tres" type="text" class="form-control"
                        id="avaluo_comercial_bien" aria-describedby="avaluo_comercial_bien" autocomplete="off"
                        >
                </div>

                <div class="form-group col-4">
                    <label for="avaluo_catastral_bien">Avaluo catastral</label>
                    <input v-model="avaluo_catastral_bien_tres" type="text" class="form-control"
                        id="avaluo_catastral_bien" aria-describedby="avaluo_catastral_bien" autocomplete="off"
                        >
                </div>

                <div class="form-group col-4">
                    <label for="cedula_catastral_bien">Cédula catastral No.</label>
                    <input v-model="cedula_catastral_bien_tres" type="text" class="form-control"
                        id="cedula_catastral_bien" aria-describedby="cedula_catastral_bien" autocomplete="off"
                        >
                </div>

                <div class="form-group col-4">
                    <label for="matricula_bien">Matricula inmobiliarial No.</label>
                    <input v-model="matricula_bien_tres" type="text" class="form-control" id="matricula_bien"
                        aria-describedby="matricula_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="escritura_bien">Escribura pública No.</label>
                    <input v-model="escritura_bien_tres" type="text" class="form-control" id="escritura_bien"
                        aria-describedby="escritura_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="notaria_bien">Notaria</label>
                    <input v-model="notaria_bien_tres" type="text" class="form-control" id="notaria_bien"
                        aria-describedby="notaria_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="fecha_bien">Fecha</label>
                    <input v-model="fecha_bien_tres" type="date" class="form-control" id="fecha_bien"
                        aria-describedby="fecha_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_parimonio_bien">Ciudad</label>
                    <input v-model="ciudad_parimonio_bien_tres" type="text" class="form-control"
                        id="ciudad_parimonio_bien" aria-describedby="ciudad_parimonio_bien" autocomplete="off"
                        >
                </div>

            </div>

            <hr class=" col-11" />
            <h4 class="col-12">VEHICULOS</h4>

            <div class="form-group col-4">
                <label for="ciudad_bien">Marca</label>
                <input v-model="marca_vehiculo" type="text" class="form-control" id="ciudad_bien"
                    aria-describedby="ciudad_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="ciudad_bien">Clase</label>
                <input v-model="clase_vehiculo" type="text" class="form-control" id="ciudad_bien"
                    aria-describedby="ciudad_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="ciudad_bien">Modelo</label>
                <input v-model="modelo_vehiculo" type="text" class="form-control" id="ciudad_bien"
                    aria-describedby="ciudad_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="ciudad_bien">Placa</label>
                <input v-model="placa_vehiculo" type="text" class="form-control" id="ciudad_bien"
                    aria-describedby="ciudad_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="ciudad_bien">Valor comercial</label>
                <input v-model="valor_vehiculo" type="text" class="form-control" id="ciudad_bien"
                    aria-describedby="ciudad_bien" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="documento">Pigmentado <span class="text-danger">
                        *</span></label>
                <select id="inputState" class="form-control" v-model="hipoteca_vehiculo" >
                    <option value="" selected>Seleccione...</option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                </select>
            </div>

            <div v-if="!mostrar_vehoculo" class="form-group col-12">
                <button @click="mostrarVeliculo" class="btn btn-info float-right mt-4">Agregar
                    Otro</button>
            </div>

            <div v-if="mostrar_vehoculo" class="row">
                <hr class=" col-11" />

                <div class="form-group col-4">
                    <label for="marca_vehiculo">Marca</label>
                    <input v-model="marca_vehiculo_dos" type="text" class="form-control" id="marca_vehiculo"
                        aria-describedby="marca_vehiculo" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_bien">Clase</label>
                    <input v-model="clase_vehiculo_dos" type="text" class="form-control" id="ciudad_bien"
                        aria-describedby="ciudad_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_bien">Modelo</label>
                    <input v-model="modelo_vehiculo_dos" type="text" class="form-control" id="ciudad_bien"
                        aria-describedby="ciudad_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_bien">Placa</label>
                    <input v-model="placa_vehiculo_dos" type="text" class="form-control" id="ciudad_bien"
                        aria-describedby="ciudad_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_bien">Valor comercial</label>
                    <input v-model="valor_vehiculo_dos" type="text" class="form-control" id="ciudad_bien"
                        aria-describedby="ciudad_bien" autocomplete="off" >
                </div>

                <div class="form-group col-4">
                    <label for="documento">Pigmentado <span class="text-danger">
                            *</span></label>
                    <select id="inputState" class="form-control" v-model="hipoteca_vehiculo_dos" >
                        <option value="" selected>Seleccione...</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
                </div>


            </div>

            <div class="col-12">
                <button @click="saveCredito" class="btn btn-success float-right">Guardar</button>
            </div>
        </div>
    </fieldset>
</template>