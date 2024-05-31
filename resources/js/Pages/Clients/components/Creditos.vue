<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps(['solicitud_id', 'items'])

onMounted(() => {

    solicitud_id.value = props.solicitud_id
    items.value = props.items

    acreedor.value = props.items.acreedor
    acreedor_dos.value = props.items.acreedor_dos
    acreedor_telefono.value = props.items.acreedor_telefono
    acreedor_telefono_dos.value = props.items.acreedor_telefono_dos
    acreedor_valor.value = props.items.acreedor_valor
    acreedor_valor_dos.value = props.items.acreedor_valor_dos
    acreedor_saldo.value = props.items.acreedor_saldo
    acreedor_saldo_dos.value = props.items.acreedor_saldo_dos
    banco_tarjeta.value = props.items.banco_tarjeta
    banco_tarjeta_dos.value = props.items.banco_tarjeta_dos
    banco_antoguedad.value = props.items.banco_antoguedad
    banco_antoguedad_dos.value = props.items.banco_antoguedad_dos
    banco_numero_antoguedad.value = props.items.banco_numero_antoguedad
    banco_numero_antoguedad_dos.value = props.items.banco_numero_antoguedad_dos
    banco_cupo.value = props.items.banco_cupo
    banco_cupo_dos.value = props.items.banco_cupo_dos
})

const solicitud_id = ref(0)
const items = ref({})

const acreedor = ref('')
const acreedor_dos = ref('')
const acreedor_telefono = ref('')
const acreedor_telefono_dos = ref('')
const acreedor_valor = ref('')
const acreedor_valor_dos = ref('')
const acreedor_saldo = ref('')
const acreedor_saldo_dos = ref('')
const banco_tarjeta = ref('')
const banco_tarjeta_dos = ref('')
const banco_antoguedad = ref('')
const banco_antoguedad_dos = ref('')
const banco_numero_antoguedad = ref('')
const banco_numero_antoguedad_dos = ref('')
const banco_cupo = ref('')
const banco_cupo_dos = ref('')

const saveCredito = () => {

    let form = new FormData()

    form.append('id', solicitud_id.value)

    form.append('acreedor', acreedor.value)
    form.append('acreedor_dos', acreedor_dos.value)
    form.append('acreedor_telefono', acreedor_telefono.value)
    form.append('acreedor_telefono_dos', acreedor_telefono_dos.value)
    form.append('acreedor_valor', acreedor_valor.value)
    form.append('acreedor_valor_dos', acreedor_valor_dos.value)
    form.append('acreedor_saldo', acreedor_saldo.value)
    form.append('acreedor_saldo_dos', acreedor_saldo_dos.value)
    form.append('banco_tarjeta', banco_tarjeta.value)
    form.append('banco_tarjeta_dos', banco_tarjeta_dos.value)
    form.append('banco_antoguedad', banco_antoguedad.value)
    form.append('banco_antoguedad_dos', banco_antoguedad_dos.value)
    form.append('banco_numero_antoguedad', banco_numero_antoguedad.value)
    form.append('banco_numero_antoguedad_dos', banco_numero_antoguedad_dos.value)
    form.append('banco_cupo', banco_cupo.value)
    form.append('banco_cupo_dos', banco_cupo_dos.value)

    axios.post('/primera-solicitud', form).then(({ data }) => {
        console.log(data)
    })
}

</script>

<template>
    <fieldset class="bordesito">
        <legend class="bordesito">Tarjetas y créditos vigentes</legend>
        <div class="row">

            <p class="text-warning ml-2">
                En caso de tener prestamos vigentes favor llenar y en caso de tener tarjetas de
                crédito favor llenar
            </p>

            <h4 class="col-12">Crédito vigente</h4>

            <div class="form-group col-3">
                <label for="salario">Acreedor</label>
                <input v-model="acreedor" type="text" class="form-control" id="acreedor" aria-describedby="acreedor"
                    autocomplete="off" placeholder="acreedor uno" @change="saveCredito">

                <input v-model="acreedor_dos" type="text" class="form-control" id="acreedor_dos"
                    aria-describedby="acreedor_dos" autocomplete="off" placeholder="acreedor dos" @change="saveCredito">
            </div>
            <div class="form-group col-3">
                <label for="acreedor_telefono">Telefono</label>
                <input v-model="acreedor_telefono" type="text" class="form-control" id="acreedor_telefono"
                    aria-describedby="acreedor_telefono" autocomplete="off" placeholder="telefono uno"
                    @change="saveCredito">

                <input v-model="acreedor_telefono_dos" type="text" class="form-control" id="acreedor_telefono_dos"
                    aria-describedby="acreedor_telefono_dos" autocomplete="off" placeholder="telefono dos"
                    @change="saveCredito">
            </div>
            <div class="form-group col-3">
                <label for="acreedor_valor">Valor prestamo</label>
                <input v-model="acreedor_valor" type="text" class="form-control" id="acreedor_valor"
                    aria-describedby="acreedor_valor" autocomplete="off" placeholder="valor uno" @change="saveCredito">

                <input v-model="acreedor_valor_dos" type="text" class="form-control" id="acreedor_valor_dos"
                    aria-describedby="acreedor_valor_dos" autocomplete="off" placeholder="valor dos"
                    @change="saveCredito">
            </div>
            <div class="form-group col-3">
                <label for="acreedor_saldo">Saldo</label>
                <input v-model="acreedor_saldo" type="text" class="form-control" id="acreedor_saldo"
                    aria-describedby="acreedor_saldo" autocomplete="off" placeholder="saldo uno" @change="saveCredito">

                <input v-model="acreedor_saldo_dos" type="text" class="form-control" id="acreedor_saldo_dos"
                    aria-describedby="acreedor_saldo_dos" autocomplete="off" placeholder="saldo dos"
                    @change="saveCredito">
            </div>


            <h4 class="col-12 mt-4">Tarjeta de crédito</h4>

            <div class="form-group col-3">
                <label for="salario">Nombre - Banco</label>
                <input v-model="banco_tarjeta" type="text" class="form-control" id="banco_tarjeta"
                    aria-describedby="banco_tarjeta" autocomplete="off" placeholder="Nombre Banco"
                    @change="saveCredito">

                <input v-model="banco_tarjeta_dos" type="text" class="form-control" id="acreedor_dos"
                    aria-describedby="acreedor_dos" autocomplete="off" placeholder="Nombre Banco dos"
                    @change="saveCredito">
            </div>
            <div class="form-group col-3">
                <label for="banco_telefono">Antoguedad</label>
                <input v-model="banco_antoguedad" type="text" class="form-control" id="banco_antoguedad"
                    aria-describedby="banco_antoguedad" autocomplete="off" placeholder="Antoguedad"
                    @change="saveCredito">

                <input v-model="banco_antoguedad_dos" type="text" class="form-control" id="banco_antoguedad_dos"
                    aria-describedby="banco_antoguedad_dos" autocomplete="off" placeholder="Antoguedad dos"
                    @change="saveCredito">
            </div>
            <div class="form-group col-3">
                <label for="acreedor_valor">Número</label>
                <input v-model="banco_numero_antoguedad" type="text" class="form-control" id="banco_numero"
                    aria-describedby="banco_numero" autocomplete="off" placeholder="Número" @change="saveCredito">

                <input v-model="banco_numero_antoguedad_dos" type="text" class="form-control" id="banco_numero_dos"
                    aria-describedby="banco_numero_dos" autocomplete="off" placeholder="Número dos"
                    @change="saveCredito">
            </div>
            <div class="form-group col-3">
                <label for="banco_cupo">Cupo máximo</label>
                <input v-model="banco_cupo" type="text" class="form-control" id="banco_cupo"
                    aria-describedby="banco_cupo" autocomplete="off" placeholder="Cupo máximo" @change="saveCredito">

                <input v-model="banco_cupo_dos" type="text" class="form-control" id="banco_cupo_dos"
                    aria-describedby="banco_cupo_dos" autocomplete="off" placeholder="Cupo máximo dos"
                    @change="saveCredito">
            </div>



        </div>

    </fieldset>
</template>