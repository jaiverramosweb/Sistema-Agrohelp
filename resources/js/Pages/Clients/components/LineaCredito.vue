<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps(['solicitud_id', 'items', 'monto'])

onMounted(() => {
    solicitud_id.value = props.solicitud_id
    items.value = props.items

    tipo_credito.value = props.items.tipo_credito
    monto_solicitado_credito.value = props.monto
    oficina_credito.value = props.items.oficina_credito
    vendedor_credito.value = props.items.vendedor_credito
    // monto_solicitado_credito.value = props.items.monto_solicitado_credito
    forma_pago_credito.value = props.items.forma_pago_credito

})

const solicitud_id = ref(0)
const items = ref({})

const tipo_credito = ref('')
const oficina_credito = ref('')
const vendedor_credito = ref('')
const monto_solicitado_credito = ref('')
const forma_pago_credito = ref('')

const saveCredito = () => {

    let form = new FormData()

    form.append('id', solicitud_id.value)

    form.append('tipo_credito', tipo_credito.value)
    form.append('oficina_credito', oficina_credito.value)
    form.append('vendedor_credito', vendedor_credito.value)
    form.append('monto_solicitado_credito', monto_solicitado_credito.value)
    form.append('forma_pago_credito', forma_pago_credito.value)

    axios.post('/primera-solicitud', form).then(({ data }) => {
        console.log(data)
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
                <select id="inputState" class="form-control" v-model="tipo_credito" @change="saveCredito">
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
                    aria-describedby="oficina_credito" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="oficina_credito">Vendedor</label>
                <input v-model="vendedor_credito" type="text" class="form-control" id="vendedor_credito"
                    aria-describedby="vendedor_credito" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="oficina_credito">Monto Solicitado</label>
                <input v-model="monto_solicitado_credito" type="text" class="form-control" id="monto_solicitado_credito"
                    aria-describedby="monto_solicitado_credito" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="oficina_credito">Forma de Pago</label>
                <input v-model="forma_pago_credito" type="text" class="form-control" id="forma_pago_credito"
                    aria-describedby="forma_pago_credito" autocomplete="off" @change="saveCredito">
            </div>

        </div>
    </fieldset>
</template>