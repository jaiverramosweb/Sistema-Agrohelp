<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps(['solicitud_id', 'items'])

onMounted(() => {

    solicitud_id.value = props.solicitud_id
    items.value = props.items

    banco.value = props.items.banco
    sucursal.value = props.items.sucursal
    banco_numero.value = props.items.banco_numero
    banco_dos.value = props.items.banco_dos
    sucursal_dos.value = props.items.sucursal_dos
    banco_numero_dos.value = props.items.banco_numero_dos

    nombre_comercal.value = props.items.nombre_comercal
    direccion_comercal.value = props.items.direccion_comercal
    telefono_comercal.value = props.items.telefono_comercal
    nombre_comercal_dos.value = props.items.nombre_comercal_dos
    direccion_comercal_dos.value = props.items.direccion_comercal_dos
    telefono_comercal_dos.value = props.items.telefono_comercal_dos

    nombre_familiar.value = props.items.nombre_familiar
    direccion_familiar.value = props.items.direccion_familiar
    telefono_familiar.value = props.items.telefono_familiar
    nombre_familiar_dos.value = props.items.nombre_familiar_dos
    direccion_familiar_dos.value = props.items.direccion_familiar_dos
    telefono_familiar_dos.value = props.items.telefono_familiar_dos
})

const solicitud_id = ref(0)
const items = ref({})

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

    let form = new FormData()

    form.append('id', solicitud_id.value)

    form.append('banco', banco.value)
    form.append('sucursal', sucursal.value)
    form.append('banco_numero', banco_numero.value)
    form.append('banco_dos', banco_dos.value)
    form.append('sucursal_dos', sucursal_dos.value)
    form.append('banco_numero_dos', banco_numero_dos.value)

    form.append('nombre_comercal', nombre_comercal.value)
    form.append('direccion_comercal', direccion_comercal.value)
    form.append('telefono_comercal', telefono_comercal.value)
    form.append('nombre_comercal_dos', nombre_comercal_dos.value)
    form.append('direccion_comercal_dos', direccion_comercal_dos.value)
    form.append('telefono_comercal_dos', telefono_comercal_dos.value)

    form.append('nombre_familiar', nombre_familiar.value)
    form.append('direccion_familiar', direccion_familiar.value)
    form.append('telefono_familiar', telefono_familiar.value)
    form.append('nombre_familiar_dos', nombre_familiar_dos.value)
    form.append('direccion_familiar_dos', direccion_familiar_dos.value)
    form.append('telefono_familiar_dos', telefono_familiar_dos.value)

    axios.post('/save-referencias', form).then(({ data }) => {
        console.log(data)
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
                    autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Sucursal</label>
                <input v-model="sucursal" type="text" class="form-control" id="sucursal" aria-describedby="sucursal"
                    autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Cta. Cte. No.</label>
                <input v-model="banco_numero" type="text" class="form-control" id="banco_numero"
                    aria-describedby="banco_numero" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Banco</label>
                <input v-model="banco_dos" type="text" class="form-control" id="banco_dos" aria-describedby="banco_dos"
                    autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Sucursal</label>
                <input v-model="sucursal_dos" type="text" class="form-control" id="sucursal_dos"
                    aria-describedby="sucursal_dos" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Cta. Cte. No.</label>
                <input v-model="banco_numero_dos" type="text" class="form-control" id="banco_numero_dos"
                    aria-describedby="banco_numero_dos" autocomplete="off" @change="saveCredito">
            </div>

            <h4 class="col-12 mt-4">COMERCIAL</h4>

            <div class="form-group col-4">
                <label for="hora_pago">Nombre</label>
                <input v-model="nombre_comercal" type="text" class="form-control" id="nombre_comercal"
                    aria-describedby="nombre_comercal" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-5">
                <label for="hora_pago">Dirección y Ciudad</label>
                <input v-model="direccion_comercal" type="text" class="form-control" id="direccion_comercal"
                    aria-describedby="direccion_comercal" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-3">
                <label for="hora_pago">Teléfono</label>
                <input v-model="telefono_comercal" type="text" class="form-control" id="telefono_comercal"
                    aria-describedby="telefono_comercal" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Nombre</label>
                <input v-model="nombre_comercal_dos" type="text" class="form-control" id="nombre_comercal_dos"
                    aria-describedby="nombre_comercal" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-5">
                <label for="hora_pago">Dirección y Ciudad</label>
                <input v-model="direccion_comercal_dos" type="text" class="form-control" id="direccion_comercal_dos"
                    aria-describedby="direccion_comercal_dos" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-3">
                <label for="hora_pago">Teléfono</label>
                <input v-model="telefono_comercal_dos" type="text" class="form-control" id="telefono_comercal_dos"
                    aria-describedby="telefono_comercal_dos" autocomplete="off" @change="saveCredito">
            </div>

            <h4 class="col-12 mt-4">FAMILIAR</h4>

            <div class="form-group col-4">
                <label for="hora_pago">Nombre</label>
                <input v-model="nombre_familiar" type="text" class="form-control" id="nombre_familiar"
                    aria-describedby="nombre_familiar" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-5">
                <label for="hora_pago">Dirección y Ciudad</label>
                <input v-model="direccion_familiar" type="text" class="form-control" id="direccion_familiar"
                    aria-describedby="direccion_familiar" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-3">
                <label for="hora_pago">Teléfono</label>
                <input v-model="telefono_familiar" type="text" class="form-control" id="telefono_familiar"
                    aria-describedby="telefono_familiar" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-4">
                <label for="hora_pago">Nombre</label>
                <input v-model="nombre_familiar_dos" type="text" class="form-control" id="nombre_familiar_dos"
                    aria-describedby="nombre_familiar" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-5">
                <label for="hora_pago">Dirección y Ciudad</label>
                <input v-model="direccion_familiar_dos" type="text" class="form-control" id="direccion_familiar_dos"
                    aria-describedby="direccion_familiar_dos" autocomplete="off" @change="saveCredito">
            </div>

            <div class="form-group col-3">
                <label for="hora_pago">Teléfono</label>
                <input v-model="telefono_familiar_dos" type="text" class="form-control" id="telefono_familiar_dos"
                    aria-describedby="telefono_familiar_dos" autocomplete="off" @change="saveCredito">
            </div>

        </div>
    </fieldset>
</template>