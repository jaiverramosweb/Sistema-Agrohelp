<script setup>
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

const props = defineProps(['usuario_id'])

onMounted(() => {
    usuario_id.value = props.usuario_id
    
    if(props.usuario_id != 0){
        getInfoRef()
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

const banco = ref('')
const sucursal = ref('')
const banco_numero = ref('')
const banco_dos = ref('')
const sucursal_dos = ref('')
const banco_numero_dos = ref('')

const nombre_comercal = ref('')
const direccion_comercal = ref('')
const telefono_comercal = ref('')
const nombre_comercal_dos = ref('')
const direccion_comercal_dos = ref('')
const telefono_comercal_dos = ref('')

const nombre_familiar = ref('')
const direccion_familiar = ref('')
const telefono_familiar = ref('')
const nombre_familiar_dos = ref('')
const direccion_familiar_dos = ref('')
const telefono_familiar_dos = ref('')

const saveCredito = () => {

    console.log(usuario_id.value)

    axios.put(`/save-clients-ref/${props.usuario_id}`, {
        'banco': banco.value,
        'sucursal': sucursal.value,
        'banco_numero': banco_numero.value,
        'banco_dos': banco_dos.value,
        'sucursal_dos': sucursal_dos.value,
        'banco_numero_dos': banco_numero_dos.value,
        'nombre_comercal': nombre_comercal.value,
        'direccion_comercal': direccion_comercal.value,
        'telefono_comercal': telefono_comercal.value,
        'nombre_comercal_dos': nombre_comercal_dos.value,
        'direccion_comercal_dos': direccion_comercal_dos.value,
        'telefono_comercal_dos': telefono_comercal_dos.value,
        'nombre_familiar': nombre_familiar.value,
        'direccion_familiar': direccion_familiar.value,
        'telefono_familiar': telefono_familiar.value,
        'nombre_familiar_dos': nombre_familiar_dos.value,
        'direccion_familiar_dos': direccion_familiar_dos.value,
        'telefono_familiar_dos': telefono_familiar_dos.value
    }).then(({ data }) => {
        console.log(data)
        id.value = data.id
        Toast.fire({
            icon: 'success',
            title: 'Registro creado con exito'
        })
    })
}

const getInfoRef = () => {
    axios.get(`/info-client-ref/${props.usuario_id}`).then(({ data }) => {
        banco.value = data.banco
        sucursal.value = data.sucursal
        banco_numero.value = data.banco_numero
        banco_dos.value = data.banco_dos
        sucursal_dos.value = data.sucursal_dos
        banco_numero_dos.value = data.banco_numero_dos
        nombre_comercal.value = data.nombre_comercal
        direccion_comercal.value = data.direccion_comercal
        telefono_comercal.value = data.telefono_comercal
        nombre_comercal_dos.value = data.nombre_comercal_dos
        direccion_comercal_dos.value = data.direccion_comercal_dos
        telefono_comercal_dos.value = data.telefono_comercal_dos
        nombre_familiar.value = data.nombre_familiar
        direccion_familiar.value = data.direccion_familiar
        telefono_familiar.value = data.telefono_familiar
        nombre_familiar_dos.value = data.nombre_familiar_dos
        direccion_familiar_dos.value = data.direccion_familiar_dos
        telefono_familiar_dos.value = data.telefono_familiar_dos
    })
}

</script>

<template>
    <fieldset class="bordesito">
        <legend class="bordesito">Referencias</legend>
        <div class="row">

            <h4 class="col-12">BANCARIA</h4>

            <div class="form-group col-4">
                <label for="hora_pago">Banco</label>
                <input v-model="banco" type="text" class="form-control" id="banco" aria-describedby="banco"
                    autocomplete="off">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Sucursal</label>
                <input v-model="sucursal" type="text" class="form-control" id="sucursal" aria-describedby="sucursal"
                    autocomplete="off">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Cta. Cte. No.</label>
                <input v-model="banco_numero" type="text" class="form-control" id="banco_numero"
                    aria-describedby="banco_numero" autocomplete="off">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Banco</label>
                <input v-model="banco_dos" type="text" class="form-control" id="banco_dos" aria-describedby="banco_dos"
                    autocomplete="off">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Sucursal</label>
                <input v-model="sucursal_dos" type="text" class="form-control" id="sucursal_dos"
                    aria-describedby="sucursal_dos" autocomplete="off">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Cta. Cte. No.</label>
                <input v-model="banco_numero_dos" type="text" class="form-control" id="banco_numero_dos"
                    aria-describedby="banco_numero_dos" autocomplete="off">
            </div>

            <h4 class="col-12 mt-4">COMERCIAL</h4>

            <div class="form-group col-4">
                <label for="hora_pago">Nombre</label>
                <input v-model="nombre_comercal" type="text" class="form-control" id="nombre_comercal"
                    aria-describedby="nombre_comercal" autocomplete="off">
            </div>

            <div class="form-group col-5">
                <label for="hora_pago">Dirección y Ciudad</label>
                <input v-model="direccion_comercal" type="text" class="form-control" id="direccion_comercal"
                    aria-describedby="direccion_comercal" autocomplete="off">
            </div>

            <div class="form-group col-3">
                <label for="hora_pago">Teléfono</label>
                <input v-model="telefono_comercal" type="text" class="form-control" id="telefono_comercal"
                    aria-describedby="telefono_comercal" autocomplete="off">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Nombre</label>
                <input v-model="nombre_comercal_dos" type="text" class="form-control" id="nombre_comercal_dos"
                    aria-describedby="nombre_comercal" autocomplete="off">
            </div>

            <div class="form-group col-5">
                <label for="hora_pago">Dirección y Ciudad</label>
                <input v-model="direccion_comercal_dos" type="text" class="form-control" id="direccion_comercal_dos"
                    aria-describedby="direccion_comercal_dos" autocomplete="off">
            </div>

            <div class="form-group col-3">
                <label for="hora_pago">Teléfono</label>
                <input v-model="telefono_comercal_dos" type="text" class="form-control" id="telefono_comercal_dos"
                    aria-describedby="telefono_comercal_dos" autocomplete="off">
            </div>

            <h4 class="col-12 mt-4">FAMILIAR</h4>

            <div class="form-group col-4">
                <label for="hora_pago">Nombre</label>
                <input v-model="nombre_familiar" type="text" class="form-control" id="nombre_familiar"
                    aria-describedby="nombre_familiar" autocomplete="off">
            </div>

            <div class="form-group col-5">
                <label for="hora_pago">Dirección y Ciudad</label>
                <input v-model="direccion_familiar" type="text" class="form-control" id="direccion_familiar"
                    aria-describedby="direccion_familiar" autocomplete="off">
            </div>

            <div class="form-group col-3">
                <label for="hora_pago">Teléfono</label>
                <input v-model="telefono_familiar" type="text" class="form-control" id="telefono_familiar"
                    aria-describedby="telefono_familiar" autocomplete="off">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Nombre</label>
                <input v-model="nombre_familiar_dos" type="text" class="form-control" id="nombre_familiar_dos"
                    aria-describedby="nombre_familiar" autocomplete="off">
            </div>

            <div class="form-group col-5">
                <label for="hora_pago">Dirección y Ciudad</label>
                <input v-model="direccion_familiar_dos" type="text" class="form-control" id="direccion_familiar_dos"
                    aria-describedby="direccion_familiar_dos" autocomplete="off">
            </div>

            <div class="form-group col-3">
                <label for="hora_pago">Teléfono</label>
                <input v-model="telefono_familiar_dos" type="text" class="form-control" id="telefono_familiar_dos"
                    aria-describedby="telefono_familiar_dos" autocomplete="off">
            </div>

            <div class="col-12">
                <button @click="saveCredito" class="btn btn-success float-right">Guardar</button>
            </div>

        </div>
    </fieldset>
</template>