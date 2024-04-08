<script setup>
import { onMounted, reactive, ref, computed, watch } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'


const infoCliente = ref('')

const id = ref(0)
const tipo_identificacion = ref('')
const numero_identificacion = ref('')
const nombre = ref('')
const segundo_nombre = ref('')
const apellido = ref('')
const segundo_apellido = ref('')
const genero = ref('')
const tipo_persona = ref('')
const fecha_nacimiento = ref('')


const tipo_direccion = ref('')
const direccion = ref('')
const ciudad = ref('')
const departamento = ref('')

const direcciones = ref([])

const creado = ref(false)


const agregarDirecciones = () => {
    const direc = {
        tipo_direccion: tipo_direccion.value,
        direccion: direccion.value,
        ciudad: ciudad.value,
        departamento: departamento.value
    }

    direcciones.value.push(direc)

    tipo_direccion.value = ''
    direccion.value = ''
    ciudad.value = ''
    departamento.value = ''
}


</script>

<template>
    <div class="card">
        <div class="card-header">
            Información del cliente
        </div>

        <div class="card-body">
            <div class="row">

                <div class="form-group col-4" has-validation>
                    <label for="tipo_identificacion">Tipo de Identificación <span class="text-danger">
                            *</span></label>
                    <select id="inputState" class="form-control" v-model="tipo_identificacion">
                        <option value="" selected>Seleccione...</option>
                        <option value="CC">CC</option>
                        <option value="Pasaporte">Pasaporte</option>
                    </select>
                    <div v-if="tipo_identificacion == ''" class="invalid-feedback d-block">El
                        campo es
                        requerido
                    </div>

                </div>

                <div class="form-group col-4" has-validation>
                    <label for="numero_identificacion">Numero de Identificación <span class="text-danger">
                            *</span></label>
                    <input v-model="numero_identificacion" type="text" class="form-control" id="numero_identificacion"
                        aria-describedby="numero_identificacion" autocomplete="off">
                    <div v-if="numero_identificacion == ''" class="invalid-feedback d-block">El
                        campo es
                        requerido
                    </div>
                </div>

                <div class="form-group col-4" has-validation>
                    <label for="nombre">Primer Nombre <span class="text-danger">
                            *</span></label>
                    <input v-model="nombre" type="text" class="form-control" id="nombre" aria-describedby="nombre"
                        autocomplete="off">
                    <div v-if="nombre == ''" class="invalid-feedback d-block">El campo es
                        requerido
                    </div>
                </div>

                <div class="form-group col-4" has-validation>
                    <label for="segundo_nombre">Segundo Nombre <span class="text-danger">
                            *</span></label>
                    <input v-model="segundo_nombre" type="text" class="form-control" id="segundo_nombre"
                        aria-describedby="segundo_nombre" autocomplete="off">
                    <div v-if="segundo_nombre == ''" class="invalid-feedback d-block">El campo
                        es
                        requerido
                    </div>
                </div>

                <div class="form-group col-4" has-validation>
                    <label for="apellido">Primer Apellido <span class="text-danger">*</span></label>
                    <input v-model="apellido" type="text" class="form-control" id="apellido" aria-describedby="apellido"
                        autocomplete="off">
                    <div v-if="apellido == ''" class="invalid-feedback d-block">El campo es
                        requerido
                    </div>
                </div>

                <div class="form-group col-4" has-validation>
                    <label for="segundo_apellido">Segundo Apellido <span class="text-danger">*</span></label>
                    <input v-model="segundo_apellido" type="text" class="form-control" id="segundo_apellido"
                        aria-describedby="segundo_apellido" autocomplete="off">
                    <div v-if="segundo_apellido == ''" class="invalid-feedback d-block">El campo
                        es
                        requerido
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="inputState">Genero <span class="text-danger">*</span></label>
                    <select id="inputState" class="form-control" v-model="genero">
                        <option value="" selected>Seleccione...</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>

                    <div v-if="genero == ''" class="invalid-feedback d-block">El
                        campo es
                        requerido
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="inputState">Tipo de Persona <span class="text-danger">*</span></label>
                    <select id="inputState" class="form-control" v-model="tipo_persona">
                        <option value="" selected>Seleccione...</option>
                        <option value="Tipo uno">Tipo uno</option>
                        <option value="Tipo dos">Tipo dos</option>
                    </select>

                    <div v-if="tipo_persona == ''" class="invalid-feedback d-block">El
                        campo es
                        requerido
                    </div>
                </div>

                <div class="form-group col-4" has-validation>
                    <label for="fecha_nacimiento">Fecha de Nacimiento <span class="text-danger">*</span></label>
                    <input v-model="fecha_nacimiento" type="date" class="form-control" id="fecha_nacimiento"
                        aria-describedby="fecha_nacimiento" autocomplete="off">
                    <div v-if="fecha_nacimiento == ''" class="invalid-feedback d-block">El campo
                        es
                        requerido
                    </div>
                </div>

                <hr>
                <h4 class="col-12">Direcciones</h4>
                <hr>

                <div class="form-group col-md-3">
                    <label for="tipo_direccion">Tipo Dirección</label>
                    <select id="tipo_direccion" class="form-control" v-model="tipo_direccion">
                        <option value="" selected>Seleccione...</option>
                        <option value="Tipo uno">Tipo uno</option>
                        <option value="Tipo dos">Tipo dos</option>
                    </select>
                </div>

                <div class="form-group col-3" has-validation>
                    <label for="direccion">Dirección</label>
                    <input v-model="direccion" type="text" class="form-control" id="direccion"
                        aria-describedby="direccion" autocomplete="off">
                </div>

                <div class="form-group col-3" has-validation>
                    <label for="ciudad">Ciudad</label>
                    <input v-model="ciudad" type="text" class="form-control" id="ciudad" aria-describedby="ciudad"
                        autocomplete="off">
                </div>

                <div class="form-group col-3" has-validation>
                    <label for="departamento">Departamento</label>
                    <input v-model="departamento" type="text" class="form-control" id="departamento"
                        aria-describedby="departamento" autocomplete="off">
                </div>

                <div class="col-12">
                    <button class="btn btn-success float-right" @click="agregarDirecciones">Agregar</button>
                </div>

                <div v-if="direcciones.length > 0" class="col-12 mt-4">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tipo Dirección</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">Departamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(direc, index) in direcciones" :key="index">
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ direc.tipo_direccion }}</td>
                                <td>{{ direc.direccion }}</td>
                                <td>{{ direc.ciudad }}</td>
                                <td>{{ direc.departamento }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>




            </div>
        </div>

        <div class="card-footer"
            v-if="tipo_identificacion.length > 0 && numero_identificacion.length > 0 && nombre.length > 0 && segundo_nombre.length > 0 && apellido.length > 0 && segundo_apellido.length > 0 && genero.length > 0 && tipo_persona.length > 0 && fecha_nacimiento.length > 0 && direcciones.length > 0">
            <div class="row">
                <div class="col-12 mt-4">
                    <button class="btn btn-success float-right" @click="save"> Guardar </button>
                </div>
            </div>
        </div>
    </div>
</template>