<script setup>
import { onMounted, ref } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

const props = defineProps(['client', 'direcciones'])

onMounted(() => {
    id.value = props.client.id
    id.value = props.client.users_id
    nombre.value = props.client.nombre

    tipo_identificacion.value = props.client.tipo_documento
    numero_identificacion.value = props.client.documento
    email.value = props.client.email
    estado_persona.value = props.client.estado_persona
    indicador_persona.value = props.client.indicador_persona


})


const id = ref(0)
const users_id = ref(0)
const nombre = ref('')
const tipo_identificacion = ref('')
const numero_identificacion = ref('')
const email = ref('')
const estado_persona = ref('')
const indicador_persona = ref('')


const restore = () => {
    Swal.fire({
        title: 'Estas seguro de restaurar?',
        showCancelButton: true,
        confirmButtonText: 'Restaurar',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post('/clients-pasword-update', {
                id: users_id.value
            }).then(({data}) =>{
                console.log(data)
                Swal.fire('Restaurado!', '', 'success')
            })

        } else if (result.isDenied) {
            Swal.fire('No se pudo restaurar', '', 'info')
        }
    })
    
}
</script>

<template>
    <div class="row">

        <div class="col-4">
            <label for="tipo_identificacion">Primer Nombre</label>
            <p>{{ nombre }}</p>
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
            <label for="tipo_identificacion">Correo electrónico </label>
            <p>{{ email }}</p>
        </div>

        <div class="col-12 mb-4">
            <label for="tipo_identificacion">Restrableser Contraseña</label>
            <p class="text-warning">Esta opción restablese la contraseña y coloca el numero de identificación
                de la persona..</p>
            <button @click="restore" class="btn btn-warning">Restaurar</button>
        </div>

        <!-- 
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

        </div> -->


    </div>
</template>