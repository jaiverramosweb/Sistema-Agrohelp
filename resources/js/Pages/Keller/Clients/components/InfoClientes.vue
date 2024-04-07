<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps(['client', 'direcciones'])

onMounted(() => {
    id.value = props.client.id
    nombre.value = props.client.nombre
    segundo_nombre.value = props.client.segundo_nombre
    apellido.value = props.client.apellido
    segundo_apellido.value = props.client.segundo_apellido
    tipo_identificacion.value = props.client.tipo_documento
    numero_identificacion.value = props.client.documento
    email.value = props.client.email
    genero.value = props.client.genero
    tipo_persona.value = props.client.tipo_persona
    fecha_nacimiento.value = props.client.fecha_nacimiento
    estado_persona.value = props.client.estado_persona
    indicador_persona.value = props.client.indicador_persona

    direcciones.value = props.direcciones
})


const id = ref(0)
const nombre = ref('')
const segundo_nombre = ref('')
const apellido = ref('')
const segundo_apellido = ref('')
const tipo_identificacion = ref('')
const numero_identificacion = ref('')
const email = ref('')
const genero = ref('')
const tipo_persona = ref('')
const fecha_nacimiento = ref('')
const estado_persona = ref('')
const indicador_persona = ref('')

const direcciones = ref('')
</script>

<template>
    <div class="row">

        <div class="col-4">
            <label for="tipo_identificacion">Primer Nombre</label>
            <p>{{ nombre }}</p>
        </div>

        <div class="col-4">
            <label for="tipo_identificacion">Segundo Nombre </label>
            <p>{{ segundo_nombre }}</p>
        </div>

        <div class="col-4">
            <label for="tipo_identificacion">Primer Apellido </label>
            <p>{{ apellido }}</p>
        </div>

        <div class="col-4">
            <label for="tipo_identificacion">Segundo Apellido </label>
            <p>{{ segundo_apellido }}</p>
        </div>

        <div class="col-4">
            <label for="tipo_identificacion">Tipo de Identificación </label>
            <p>{{ tipo_identificacion }}</p>
        </div>

        <div class="col-4">
            <label for="tipo_identificacion">Numero de Identificación </label>
            <p>{{ numero_identificacion }}</p>
        </div>

        <div class="col-3">
            <label for="tipo_identificacion">Genero </label>
            <p>{{ genero }}</p>
        </div>

        <div class="col-3">
            <label for="tipo_identificacion">Tipo de Persona </label>
            <p>{{ tipo_persona }}</p>
        </div>

        <div class="col-3">
            <label for="tipo_identificacion">Fecha de Nacimiento </label>
            <p>{{ fecha_nacimiento }}</p>
        </div>

        <div class="col-3">
            <label for="tipo_identificacion">Correo electrónico </label>
            <p>{{ email }}</p>
        </div>

        <div class="col-12 mb-4">
            <label for="tipo_identificacion">Restrableser Contraseña</label>
            <p class="text-warning">Esta opción restablese la contraseña y coloca el numero de identificación
                de la persona..</p>
            <button class="btn btn-warning">Restaurar</button>
        </div>






        <hr>
        <h4 class="col-12">Direcciones</h4>
        <hr>

        <div class="col-12 mt-4">
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
</template>