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

    axios.put(`/save-clients-tarjeta/${props.usuario_id}`, {
        'acreedor': acreedor.value,
        'acreedor_dos': acreedor_dos.value,
        'acreedor_telefono': acreedor_telefono.value,
        'acreedor_telefono_dos': acreedor_telefono_dos.value,
        'acreedor_valor': acreedor_valor.value,
        'acreedor_valor_dos': acreedor_valor_dos.value,
        'acreedor_saldo': acreedor_saldo.value,
        'acreedor_saldo_dos': acreedor_saldo_dos.value,
        'banco_tarjeta': banco_tarjeta.value,
        'banco_tarjeta_dos': banco_tarjeta_dos.value,
        'banco_antoguedad': banco_antoguedad.value,
        'banco_antoguedad_dos': banco_antoguedad_dos.value,
        'banco_numero_antoguedad': banco_numero_antoguedad.value,
        'banco_numero_antoguedad_dos': banco_numero_antoguedad_dos.value,
        'banco_cupo': banco_cupo.value,
        'banco_cupo_dos': banco_cupo_dos.value
    }).then(({ data }) => {
        id.value = data.id
        Toast.fire({
            icon: 'success',
            title: 'Registro creado con exito'
        })
    })
}

const getInfoLinea = () => {
    axios.get(`/info-client-tarjeta/${props.usuario_id}`).then(({ data }) => {
        acreedor.value = data.acreedor
        acreedor_dos.value = data.acreedor_dos
        acreedor_telefono.value = data.acreedor_telefono
        acreedor_telefono_dos.value = data.acreedor_telefono_dos
        acreedor_valor.value = data.acreedor_valor
        acreedor_valor_dos.value = data.acreedor_valor_dos
        acreedor_saldo.value = data.acreedor_saldo
        acreedor_saldo_dos.value = data.acreedor_saldo_dos
        banco_tarjeta.value = data.banco_tarjeta
        banco_tarjeta_dos.value = data.banco_tarjeta_dos
        banco_antoguedad.value = data.banco_antoguedad
        banco_antoguedad_dos.value = data.banco_antoguedad_dos
        banco_numero_antoguedad.value = data.banco_numero_antoguedad
        banco_numero_antoguedad_dos.value = data.banco_numero_antoguedad_dos
        banco_cupo.value = data.banco_cupo
        banco_cupo_dos.value = data.banco_cupo_dos
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
                    autocomplete="off" placeholder="acreedor uno" >

                <input v-model="acreedor_dos" type="text" class="form-control" id="acreedor_dos"
                    aria-describedby="acreedor_dos" autocomplete="off" placeholder="acreedor dos" >
            </div>
            <div class="form-group col-3">
                <label for="acreedor_telefono">Telefono</label>
                <input v-model="acreedor_telefono" type="text" class="form-control" id="acreedor_telefono"
                    aria-describedby="acreedor_telefono" autocomplete="off" placeholder="telefono uno"
                    >

                <input v-model="acreedor_telefono_dos" type="text" class="form-control" id="acreedor_telefono_dos"
                    aria-describedby="acreedor_telefono_dos" autocomplete="off" placeholder="telefono dos"
                    >
            </div>
            <div class="form-group col-3">
                <label for="acreedor_valor">Valor prestamo</label>
                <input v-model="acreedor_valor" type="text" class="form-control" id="acreedor_valor"
                    aria-describedby="acreedor_valor" autocomplete="off" placeholder="valor uno" >

                <input v-model="acreedor_valor_dos" type="text" class="form-control" id="acreedor_valor_dos"
                    aria-describedby="acreedor_valor_dos" autocomplete="off" placeholder="valor dos"
                    >
            </div>
            <div class="form-group col-3">
                <label for="acreedor_saldo">Saldo</label>
                <input v-model="acreedor_saldo" type="text" class="form-control" id="acreedor_saldo"
                    aria-describedby="acreedor_saldo" autocomplete="off" placeholder="saldo uno" >

                <input v-model="acreedor_saldo_dos" type="text" class="form-control" id="acreedor_saldo_dos"
                    aria-describedby="acreedor_saldo_dos" autocomplete="off" placeholder="saldo dos"
                    >
            </div>


            <h4 class="col-12 mt-4">Tarjeta de crédito</h4>

            <div class="form-group col-3">
                <label for="salario">Nombre - Banco</label>
                <input v-model="banco_tarjeta" type="text" class="form-control" id="banco_tarjeta"
                    aria-describedby="banco_tarjeta" autocomplete="off" placeholder="Nombre Banco"
                    >

                <input v-model="banco_tarjeta_dos" type="text" class="form-control" id="acreedor_dos"
                    aria-describedby="acreedor_dos" autocomplete="off" placeholder="Nombre Banco dos"
                    >
            </div>
            <div class="form-group col-3">
                <label for="banco_telefono">Antoguedad</label>
                <input v-model="banco_antoguedad" type="text" class="form-control" id="banco_antoguedad"
                    aria-describedby="banco_antoguedad" autocomplete="off" placeholder="Antoguedad"
                    >

                <input v-model="banco_antoguedad_dos" type="text" class="form-control" id="banco_antoguedad_dos"
                    aria-describedby="banco_antoguedad_dos" autocomplete="off" placeholder="Antoguedad dos"
                    >
            </div>
            <div class="form-group col-3">
                <label for="acreedor_valor">Número</label>
                <input v-model="banco_numero_antoguedad" type="text" class="form-control" id="banco_numero"
                    aria-describedby="banco_numero" autocomplete="off" placeholder="Número" >

                <input v-model="banco_numero_antoguedad_dos" type="text" class="form-control" id="banco_numero_dos"
                    aria-describedby="banco_numero_dos" autocomplete="off" placeholder="Número dos"
                    >
            </div>
            <div class="form-group col-3">
                <label for="banco_cupo">Cupo máximo</label>
                <input v-model="banco_cupo" type="text" class="form-control" id="banco_cupo"
                    aria-describedby="banco_cupo" autocomplete="off" placeholder="Cupo máximo" >

                <input v-model="banco_cupo_dos" type="text" class="form-control" id="banco_cupo_dos"
                    aria-describedby="banco_cupo_dos" autocomplete="off" placeholder="Cupo máximo dos"
                    >
            </div>

            <div class="col-12">
                <button @click="saveCredito" class="btn btn-success float-right">Guardar</button>
            </div>

        </div>

    </fieldset>
</template>