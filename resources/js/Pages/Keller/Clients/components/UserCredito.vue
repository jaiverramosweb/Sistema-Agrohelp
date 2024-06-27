<script setup>
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

const props = defineProps(['usuario_id'])

onMounted(() => {
    usuario_id.value = props.usuario_id
    if(props.usuario_id != 0){
        getInfoLinea()
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

const tipo_credito = ref('')
const oficina_credito = ref('')
const vendedor_credito = ref('')
const monto_solicitado_credito = ref('')
const forma_pago_credito = ref('')

const saveCredito = () => {

    axios.put(`/save-clients-linea/${props.usuario_id}`, {
        'tipo_credito': tipo_credito.value,
        'oficina_credito': oficina_credito.value,
        'vendedor_credito': vendedor_credito.value,
        'monto_solicitado_credito': monto_solicitado_credito.value,
        'forma_pago_credito': forma_pago_credito.value
    }).then(({ data }) => {
        id.value = data.id
        Toast.fire({
            icon: 'success',
            title: 'Registro creado con exito'
        })
    })
}

const getInfoLinea = () => {
    axios.get(`/info-client-linea/${props.usuario_id}`).then(({ data }) => {
        tipo_credito.value = data.tipo_credito
        oficina_credito.value = data.oficina_credito
        vendedor_credito.value = data.vendedor_credito
        monto_solicitado_credito.value = data.monto_solicitado_credito
        forma_pago_credito.value = data.forma_pago_credito
    })
}

</script>

<template>
    <fieldset class="bordesito" style="width: 100%;">
        <legend class="bordesito">Linea de crédito</legend>
        <div class="row">

            <div class="form-group col-4">
                <label for="documento">Tipo linea crédito <span class="text-danger">
                        *</span></label>
                <select id="inputState" class="form-control" v-model="tipo_credito" >
                    <option value="" selected>Seleccione...</option>
                    <option value="Rotativo">Rotativo</option>
                    <option value="Cupo">Cupo</option>
                    <option value="Adquisición">Adquisición</option>
                    <option value="Maquinaria">Maquinaria</option>
                </select>
            </div>

            <div class="form-group col-4">
                <label for="oficina_credito">Oficina</label>
                <input v-model="oficina_credito" type="text" class="form-control" id="oficina_credito"
                    aria-describedby="oficina_credito" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="oficina_credito">Vendedor</label>
                <input v-model="vendedor_credito" type="text" class="form-control" id="vendedor_credito"
                    aria-describedby="vendedor_credito" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="oficina_credito">Monto Solicitado</label>
                <input v-model="monto_solicitado_credito" type="text" class="form-control" id="monto_solicitado_credito"
                    aria-describedby="monto_solicitado_credito" autocomplete="off" >
            </div>

            <div class="form-group col-4">
                <label for="oficina_credito">Forma de Pago</label>
                <input v-model="forma_pago_credito" type="text" class="form-control" id="forma_pago_credito"
                    aria-describedby="forma_pago_credito" autocomplete="off" >
            </div>

            <div class="col-12">
                <button @click="saveCredito" class="btn btn-success float-right">Guardar</button>
            </div>

        </div>
    </fieldset>
</template>