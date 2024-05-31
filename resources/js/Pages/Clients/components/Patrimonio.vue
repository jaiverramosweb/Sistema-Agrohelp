<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps(['solicitud_id', 'items'])

onMounted(() => {

    solicitud_id.value = props.solicitud_id
    items.value = props.items

    descripcion_bien.value = props.items.descripcion_bien
    ciudad_bien.value = props.items.ciudad_bien
    hipoteca_bien.value = props.items.hipoteca_bien
    avaluo_comercial_bien.value = props.items.avaluo_comercial_bien
    avaluo_catastral_bien.value = props.items.avaluo_catastral_bien
    cedula_catastral_bien.value = props.items.cedula_catastral_bien
    matricula_bien.value = props.items.matricula_bien
    escritura_bien.value = props.items.escritura_bien
    notaria_bien.value = props.items.notaria_bien
    fecha_bien.value = props.items.fecha_bien
    ciudad_parimonio_bien.value = props.items.ciudad_parimonio_bien
    descripcion_bien_dos.value = props.items.descripcion_bien_dos
    ciudad_bien_dos.value = props.items.ciudad_bien_dos
    hipoteca_bien_dos.value = props.items.hipoteca_bien_dos
    avaluo_comercial_bien_dos.value = props.items.avaluo_comercial_bien_dos
    avaluo_catastral_bien_dos.value = props.items.avaluo_catastral_bien_dos
    cedula_catastral_bien_dos.value = props.items.cedula_catastral_bien_dos
    matricula_bien_dos.value = props.items.matricula_bien_dos
    escritura_bien_dos.value = props.items.escritura_bien_dos
    notaria_bien_dos.value = props.items.notaria_bien_dos
    fecha_bien_dos.value = props.items.fecha_bien_dos
    ciudad_parimonio_bien_dos.value = props.items.ciudad_parimonio_bien_dos
    descripcion_bien_tres.value = props.items.descripcion_bien_tres
    ciudad_bien_tres.value = props.items.ciudad_bien_tres
    hipoteca_bien_tres.value = props.items.hipoteca_bien_tres
    avaluo_comercial_bien_tres.value = props.items.avaluo_comercial_bien_tres
    avaluo_catastral_bien_tres.value = props.items.avaluo_catastral_bien_tres
    cedula_catastral_bien_tres.value = props.items.cedula_catastral_bien_tres
    matricula_bien_tres.value = props.items.matricula_bien_tres
    escritura_bien_tres.value = props.items.escritura_bien_tres
    notaria_bien_tres.value = props.items.notaria_bien_tres
    fecha_bien_tres.value = props.items.fecha_bien_tres
    ciudad_parimonio_bien_tres.value = props.items.ciudad_parimonio_bien_tres
    marca_vehiculo.value = props.items.marca_vehiculo
    clase_vehiculo.value = props.items.clase_vehiculo
    modelo_vehiculo.value = props.items.modelo_vehiculo
    placa_vehiculo.value = props.items.placa_vehiculo
    valor_vehiculo.value = props.items.valor_vehiculo
    hipoteca_vehiculo.value = props.items.hipoteca_vehiculo
    marca_vehiculo_dos.value = props.items.marca_vehiculo_dos
    clase_vehiculo_dos.value = props.items.clase_vehiculo_dos
    modelo_vehiculo_dos.value = props.items.modelo_vehiculo_dos
    placa_vehiculo_dos.value = props.items.placa_vehiculo_dos
    valor_vehiculo_dos.value = props.items.valor_vehiculo_dos
    hipoteca_vehiculo_dos.value = props.items.hipoteca_vehiculo_dos
})

const mostrar = ref(false)
const mostrar_dos = ref(false)
const mostrar_vehoculo = ref(false)

const solicitud_id = ref(0)
const items = ref({})

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

    let form = new FormData()

    form.append('id', solicitud_id.value)

    form.append('descripcion_bien', descripcion_bien.value)
    form.append('ciudad_bien', ciudad_bien.value)
    form.append('hipoteca_bien', hipoteca_bien.value)
    form.append('avaluo_comercial_bien', avaluo_comercial_bien.value)
    form.append('avaluo_catastral_bien', avaluo_catastral_bien.value)
    form.append('cedula_catastral_bien', cedula_catastral_bien.value)
    form.append('matricula_bien', matricula_bien.value)
    form.append('escritura_bien', escritura_bien.value)
    form.append('notaria_bien', notaria_bien.value)
    form.append('fecha_bien', fecha_bien.value)
    form.append('ciudad_parimonio_bien', ciudad_parimonio_bien.value)
    form.append('descripcion_bien_dos', descripcion_bien_dos.value)
    form.append('ciudad_bien_dos', ciudad_bien_dos.value)
    form.append('hipoteca_bien_dos', hipoteca_bien_dos.value)
    form.append('avaluo_comercial_bien_dos', avaluo_comercial_bien_dos.value)
    form.append('avaluo_catastral_bien_dos', avaluo_catastral_bien_dos.value)
    form.append('cedula_catastral_bien_dos', cedula_catastral_bien_dos.value)
    form.append('matricula_bien_dos', matricula_bien_dos.value)
    form.append('escritura_bien_dos', escritura_bien_dos.value)
    form.append('notaria_bien_dos', notaria_bien_dos.value)
    form.append('fecha_bien_dos', fecha_bien_dos.value)
    form.append('ciudad_parimonio_bien_dos', ciudad_parimonio_bien_dos.value)
    form.append('descripcion_bien_tres', descripcion_bien_tres.value)
    form.append('ciudad_bien_tres', ciudad_bien_tres.value)
    form.append('hipoteca_bien_tres', hipoteca_bien_tres.value)
    form.append('avaluo_comercial_bien_tres', avaluo_comercial_bien_tres.value)
    form.append('avaluo_catastral_bien_tres', avaluo_catastral_bien_tres.value)
    form.append('cedula_catastral_bien_tres', cedula_catastral_bien_tres.value)
    form.append('matricula_bien_tres', matricula_bien_tres.value)
    form.append('escritura_bien_tres', escritura_bien_tres.value)
    form.append('notaria_bien_tres', notaria_bien_tres.value)
    form.append('fecha_bien_tres', fecha_bien_tres.value)
    form.append('ciudad_parimonio_bien_tres', ciudad_parimonio_bien_tres.value)
    form.append('marca_vehiculo', marca_vehiculo.value)
    form.append('clase_vehiculo', clase_vehiculo.value)
    form.append('modelo_vehiculo', modelo_vehiculo.value)
    form.append('placa_vehiculo', placa_vehiculo.value)
    form.append('valor_vehiculo', valor_vehiculo.value)
    form.append('hipoteca_vehiculo', hipoteca_vehiculo.value)
    form.append('marca_vehiculo_dos', marca_vehiculo_dos.value)
    form.append('clase_vehiculo_dos', clase_vehiculo_dos.value)
    form.append('modelo_vehiculo_dos', modelo_vehiculo_dos.value)
    form.append('placa_vehiculo_dos', placa_vehiculo_dos.value)
    form.append('valor_vehiculo_dos', valor_vehiculo_dos.value)
    form.append('hipoteca_vehiculo_dos', hipoteca_vehiculo_dos.value)

    axios.post('/primera-solicitud', form).then(({ data }) => {
        // console.log(data)
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

</script>

<template>
    <fieldset class="bordesito">
        <legend class="bordesito">Patrimonio</legend>
        <div class="row">
            <h4 class="col-12">BIENES INMUEBLES</h4>

            <div class="form-group col-4">
                <label for="descripcion_bien">Descripción</label>
                <input v-model="descripcion_bien" type="text" class="form-control" id="descripcion_bien"
                    aria-describedby="descripcion_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="ciudad_bien">Ciudad</label>
                <input v-model="ciudad_bien" type="text" class="form-control" id="ciudad_bien"
                    aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="documento">Hipoteca <span class="text-danger">
                        *</span></label>
                <select id="inputState" class="form-control" v-model="hipoteca_bien" @change="saveCredito">
                    <option value="" selected>Seleccione...</option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                </select>
            </div>

            <div class="form-group col-4">
                <label for="avaluo_comercial_bien">Avaluo comercial</label>
                <input v-model="avaluo_comercial_bien" type="text" class="form-control" id="avaluo_comercial_bien"
                    aria-describedby="avaluo_comercial_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="avaluo_catastral_bien">Avaluo catastral</label>
                <input v-model="avaluo_catastral_bien" type="text" class="form-control" id="avaluo_catastral_bien"
                    aria-describedby="avaluo_catastral_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="cedula_catastral_bien">Cédula catastral No.</label>
                <input v-model="cedula_catastral_bien" type="text" class="form-control" id="cedula_catastral_bien"
                    aria-describedby="cedula_catastral_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="matricula_bien">Matricula inmobiliarial No.</label>
                <input v-model="matricula_bien" type="text" class="form-control" id="matricula_bien"
                    aria-describedby="matricula_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="escritura_bien">Escribura pública No.</label>
                <input v-model="escritura_bien" type="text" class="form-control" id="escritura_bien"
                    aria-describedby="escritura_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="notaria_bien">Notaria</label>
                <input v-model="notaria_bien" type="text" class="form-control" id="notaria_bien"
                    aria-describedby="notaria_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="fecha_bien">Fecha</label>
                <input v-model="fecha_bien" type="date" class="form-control" id="fecha_bien"
                    aria-describedby="fecha_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="ciudad_parimonio_bien">Ciudad</label>
                <input v-model="ciudad_parimonio_bien" type="text" class="form-control" id="ciudad_parimonio_bien"
                    aria-describedby="ciudad_parimonio_bien" autocomplete="off" @change="saveCredito">
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
                        aria-describedby="descripcion_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_bien">Ciudad</label>
                    <input v-model="ciudad_bien_dos" type="text" class="form-control" id="ciudad_bien"
                        aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="documento">Hipoteca <span class="text-danger">
                            *</span></label>
                    <select id="inputState" class="form-control" v-model="hipoteca_bien_dos" @change="saveCredito">
                        <option value="" selected>Seleccione...</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="form-group col-4">
                    <label for="avaluo_comercial_bien">Avaluo comercial</label>
                    <input v-model="avaluo_comercial_bien_dos" type="text" class="form-control"
                        id="avaluo_comercial_bien" aria-describedby="avaluo_comercial_bien" autocomplete="off"
                        @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="avaluo_catastral_bien">Avaluo catastral</label>
                    <input v-model="avaluo_catastral_bien_dos" type="text" class="form-control"
                        id="avaluo_catastral_bien" aria-describedby="avaluo_catastral_bien" autocomplete="off"
                        @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="cedula_catastral_bien">Cédula catastral No.</label>
                    <input v-model="cedula_catastral_bien_dos" type="text" class="form-control"
                        id="cedula_catastral_bien" aria-describedby="cedula_catastral_bien" autocomplete="off"
                        @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="matricula_bien">Matricula inmobiliarial No.</label>
                    <input v-model="matricula_bien_dos" type="text" class="form-control" id="matricula_bien"
                        aria-describedby="matricula_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="escritura_bien">Escribura pública No.</label>
                    <input v-model="escritura_bien_dos" type="text" class="form-control" id="escritura_bien"
                        aria-describedby="escritura_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="notaria_bien">Notaria</label>
                    <input v-model="notaria_bien_dos" type="text" class="form-control" id="notaria_bien"
                        aria-describedby="notaria_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="fecha_bien">Fecha</label>
                    <input v-model="fecha_bien_dos" type="date" class="form-control" id="fecha_bien"
                        aria-describedby="fecha_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_parimonio_bien">Ciudad</label>
                    <input v-model="ciudad_parimonio_bien_dos" type="text" class="form-control"
                        id="ciudad_parimonio_bien" aria-describedby="ciudad_parimonio_bien" autocomplete="off"
                        @change="saveCredito">
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
                        aria-describedby="descripcion_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_bien">Ciudad</label>
                    <input v-model="ciudad_bien_tres" type="text" class="form-control" id="ciudad_bien"
                        aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="documento">Hipoteca <span class="text-danger">
                            *</span></label>
                    <select id="inputState" class="form-control" v-model="hipoteca_bien_tres" @change="saveCredito">
                        <option value="" selected>Seleccione...</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="form-group col-4">
                    <label for="avaluo_comercial_bien">Avaluo comercial</label>
                    <input v-model="avaluo_comercial_bien_tres" type="text" class="form-control"
                        id="avaluo_comercial_bien" aria-describedby="avaluo_comercial_bien" autocomplete="off"
                        @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="avaluo_catastral_bien">Avaluo catastral</label>
                    <input v-model="avaluo_catastral_bien_tres" type="text" class="form-control"
                        id="avaluo_catastral_bien" aria-describedby="avaluo_catastral_bien" autocomplete="off"
                        @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="cedula_catastral_bien">Cédula catastral No.</label>
                    <input v-model="cedula_catastral_bien_tres" type="text" class="form-control"
                        id="cedula_catastral_bien" aria-describedby="cedula_catastral_bien" autocomplete="off"
                        @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="matricula_bien">Matricula inmobiliarial No.</label>
                    <input v-model="matricula_bien_tres" type="text" class="form-control" id="matricula_bien"
                        aria-describedby="matricula_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="escritura_bien">Escribura pública No.</label>
                    <input v-model="escritura_bien_tres" type="text" class="form-control" id="escritura_bien"
                        aria-describedby="escritura_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="notaria_bien">Notaria</label>
                    <input v-model="notaria_bien_tres" type="text" class="form-control" id="notaria_bien"
                        aria-describedby="notaria_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="fecha_bien">Fecha</label>
                    <input v-model="fecha_bien_tres" type="date" class="form-control" id="fecha_bien"
                        aria-describedby="fecha_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_parimonio_bien">Ciudad</label>
                    <input v-model="ciudad_parimonio_bien_tres" type="text" class="form-control"
                        id="ciudad_parimonio_bien" aria-describedby="ciudad_parimonio_bien" autocomplete="off"
                        @change="saveCredito">
                </div>

            </div>

            <hr class=" col-11" />
            <h4 class="col-12">VEHICULOS</h4>

            <div class="form-group col-4">
                <label for="ciudad_bien">Marca</label>
                <input v-model="marca_vehiculo" type="text" class="form-control" id="ciudad_bien"
                    aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="ciudad_bien">Clase</label>
                <input v-model="clase_vehiculo" type="text" class="form-control" id="ciudad_bien"
                    aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="ciudad_bien">Modelo</label>
                <input v-model="modelo_vehiculo" type="text" class="form-control" id="ciudad_bien"
                    aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="ciudad_bien">Placa</label>
                <input v-model="placa_vehiculo" type="text" class="form-control" id="ciudad_bien"
                    aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="ciudad_bien">Valor comercial</label>
                <input v-model="valor_vehiculo" type="text" class="form-control" id="ciudad_bien"
                    aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="documento">Pigmentado <span class="text-danger">
                        *</span></label>
                <select id="inputState" class="form-control" v-model="hipoteca_vehiculo" @change="saveCredito">
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
                        aria-describedby="marca_vehiculo" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_bien">Clase</label>
                    <input v-model="clase_vehiculo_dos" type="text" class="form-control" id="ciudad_bien"
                        aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_bien">Modelo</label>
                    <input v-model="modelo_vehiculo_dos" type="text" class="form-control" id="ciudad_bien"
                        aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_bien">Placa</label>
                    <input v-model="placa_vehiculo_dos" type="text" class="form-control" id="ciudad_bien"
                        aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="ciudad_bien">Valor comercial</label>
                    <input v-model="valor_vehiculo_dos" type="text" class="form-control" id="ciudad_bien"
                        aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
                </div>

                <div class="form-group col-4">
                    <label for="documento">Pigmentado <span class="text-danger">
                            *</span></label>
                    <select id="inputState" class="form-control" v-model="hipoteca_vehiculo_dos" @change="saveCredito">
                        <option value="" selected>Seleccione...</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
                </div>
            </div>
        </div>
    </fieldset>
</template>