<script setup>
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

const props = defineProps(['usuario_id'])

onMounted(() => {
    usuario_id.value = props.usuario_id
    
    if(props.usuario_id != 0){
        getInfoIngre()
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

const salario = ref('')
const honorarios = ref('')
const otros_ingresos = ref('')
const otros_ingresos_describe = ref('')
const total_ingresos = ref('')

const alquiler = ref('')
const amortizacion = ref('')
const amortizacion_hipoteca = ref('')
const pago_tarjetas = ref('')
const otros_gastos = ref('')
const total_egresos = ref('')

const salario_data = ref(0)
const honorarios_data = ref(0)
const otros_ingresos_data = ref(0)
const total_ingresos_data = ref(0)

const alquiler_data = ref(0)
const amortizacion_data = ref(0)
const amortizacion_hipoteca_data = ref(0)
const pago_tarjetas_data = ref(0)
const otros_gastos_data = ref(0)
const total_egresos_data = ref(0)



const saveCredito = () => {

    axios.put(`/save-clients-ingre/${props.usuario_id}`, {
        'salario': salario.value,
        'honorarios': honorarios.value,
        'otros_ingresos': otros_ingresos.value,
        'otros_ingresos_describe': otros_ingresos_describe.value,
        'total_ingresos': total_ingresos.value,
        'alquiler': alquiler.value,
        'amortizacion': amortizacion.value,
        'amortizacion_hipoteca': amortizacion_hipoteca.value,
        'pago_tarjetas': pago_tarjetas.value,
        'otros_gastos': otros_gastos.value,
        'total_egresos': total_egresos.value,
        'salario_data': salario_data.value,
        'honorarios_data': honorarios_data.value,
        'otros_ingresos_data': otros_ingresos_data.value,
        'total_ingresos_data': total_ingresos_data.value,
        'alquiler_data': alquiler_data.value,
        'amortizacion_data': amortizacion_data.value,
        'amortizacion_hipoteca_data': amortizacion_hipoteca_data.value,
        'pago_tarjetas_data': pago_tarjetas_data.value,
        'otros_gastos_data': otros_gastos_data.value,
        'total_egresos_data': total_egresos_data.value,
    }).then(({ data }) => {
        id.value = data.id
        Toast.fire({
            icon: 'success',
            title: 'Registro creado con exito'
        })
    })
}

const getInfoIngre = () => {
    axios.get(`/info-client-ingre/${props.usuario_id}`).then(({ data }) => {
        salario.value = data.salario
        honorarios.value = data.honorarios
        otros_ingresos.value = data.otros_ingresos
        otros_ingresos_describe.value = data.otros_ingresos_describe
        total_ingresos.value = data.total_ingresos
        alquiler.value = data.alquiler
        amortizacion.value = data.amortizacion
        amortizacion_hipoteca.value = data.amortizacion_hipoteca
        pago_tarjetas.value = data.pago_tarjetas
        otros_gastos.value = data.otros_gastos
        total_egresos.value = data.total_egresos
        salario_data.value = data.salario_data
        honorarios_data.value = data.honorarios_data
        otros_ingresos_data.value = data.otros_ingresos_data
        total_ingresos_data.value = data.total_ingresos_data
        alquiler_data.value = data.alquiler_data
        amortizacion_data.value = data.amortizacion_data
        amortizacion_hipoteca_data.value = data.amortizacion_hipoteca_data
        pago_tarjetas_data.value = data.pago_tarjetas_data
        otros_gastos_data.value = data.otros_gastos_data
        total_egresos_data.value = data.total_egresos_data
    })
}

const formatInput = (valor, input) => {
    let cleanValue = valor.replace(/[^\d.,]/g, '');
    let parts = cleanValue.split('.');

    parts[0] = parts[0].replace(/\./g, '');
    parts[0] = parts[0].replace(/,/g, '');

    cleanValue = parts.join('.');

    let formattedValue = cleanValue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if (parts.length > 1) {
        formattedValue = formattedValue + '.' + parts[1];
    }

    formattedValue = '$' + formattedValue;

    if (input == 'salario') {
        salario.value = formattedValue
        const numericString = formattedValue.replace(/[^\d.-]/g, '');
        salario_data.value = parseFloat(numericString)
    }

    if (input == 'honorarios') {
        honorarios.value = formattedValue
        const numericString = formattedValue.replace(/[^\d.-]/g, '');
        honorarios_data.value = parseFloat(numericString)
    }

    if (input == 'otros_ingresos') {
        otros_ingresos.value = formattedValue
        const numericString = formattedValue.replace(/[^\d.-]/g, '');
        otros_ingresos_data.value = parseFloat(numericString)
    }

    let total_ingresos = salario_data.value + honorarios_data.value + otros_ingresos_data.value
    updateIngreso(total_ingresos)

    if (input == 'alquiler') {
        alquiler.value = formattedValue
        const numericString = formattedValue.replace(/[^\d.-]/g, '');
        alquiler_data.value = parseFloat(numericString)
    }

    if (input == 'amortizacion') {
        amortizacion.value = formattedValue
        const numericString = formattedValue.replace(/[^\d.-]/g, '');
        amortizacion_data.value = parseFloat(numericString)
    }

    if (input == 'amortizacion_hipoteca') {
        amortizacion_hipoteca.value = formattedValue
        const numericString = formattedValue.replace(/[^\d.-]/g, '');
        amortizacion_hipoteca_data.value = parseFloat(numericString)
    }

    if (input == 'pago_tarjetas') {
        pago_tarjetas.value = formattedValue
        const numericString = formattedValue.replace(/[^\d.-]/g, '');
        pago_tarjetas_data.value = parseFloat(numericString)
    }

    if (input == 'otros_gastos') {
        otros_gastos.value = formattedValue
        const numericString = formattedValue.replace(/[^\d.-]/g, '');
        otros_gastos_data.value = parseFloat(numericString)
    }

    let total_egresos = alquiler_data.value + amortizacion_data.value + amortizacion_hipoteca_data.value + pago_tarjetas_data.value + otros_gastos_data.value
    updateEgresos(total_egresos)

}

const updateIngreso = (valor) => {
    total_ingresos_data.value = valor

    let formattedValue = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 0,
    }).format(valor);

    total_ingresos.value = formattedValue;
}

const updateEgresos = (valor) => {
    total_egresos_data.value = valor

    let formattedValue = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 0,
    }).format(valor);

    total_egresos.value = formattedValue;
}

</script>

<template>
    <fieldset class="bordesito">
        <legend class="bordesito">Ingresos y Egresos</legend>
        <div class="row">

            <p class="text-warning ml-2">
                La información solicitada a continuación debe ser diligenciada para solicitudes
                de crédito personales (personas naturales)
            </p>

            <h4 class="col-12">INGRESOS</h4>

            <div class="form-group col-4">
                <label for="salario">Salario</label>
                <input v-model="salario" type="text" class="form-control" id="salario" aria-describedby="salario"
                    autocomplete="off" @input="formatInput(salario, 'salario')">
            </div>
            <div class="form-group col-4">
                <label for="honorarios">Honorarios promedio</label>
                <input v-model="honorarios" type="text" class="form-control" id="honorarios"
                    aria-describedby="honorarios" autocomplete="off"
                    @input="formatInput(honorarios, 'honorarios')">
            </div>
            <div class="form-group col-4">
                <label for="otros_ingresos">Otros ingresos</label>
                <input v-model="otros_ingresos" type="text" class="form-control" id="otros_ingresos"
                    aria-describedby="otros_ingresos" autocomplete="off"
                    @input="formatInput(otros_ingresos, 'otros_ingresos')">
            </div>
            <div class="form-group col-8">
                <label for="otros_ingresos_describe">Describe</label>
                <input v-model="otros_ingresos_describe" type="text" class="form-control" id="otros_ingresos_describe"
                    aria-describedby="otros_ingresos_describe" autocomplete="off">
            </div>
            <div class="form-group col-4">
                <label for="total_ingresos">Total</label>
                <input v-model="total_ingresos" type="text" class="form-control" id="total_ingresos"
                    aria-describedby="total_ingresos" autocomplete="off" disabled>
            </div>

            <h4 class="col-12 mt-4">EGRESOS</h4>

            <div class="form-group col-4">
                <label for="alquiler">Alquiler</label>
                <input v-model="alquiler" type="text" class="form-control" id="alquiler" aria-describedby="alquiler"
                    autocomplete="off" @input="formatInput(alquiler, 'alquiler')">
            </div>

            <div class="form-group col-4">
                <label for="amortizacion">Amortización crédotos vigentes</label>
                <input v-model="amortizacion" type="text" class="form-control" id="amortizacion"
                    aria-describedby="amortizacion" autocomplete="off"
                    @input="formatInput(amortizacion, 'amortizacion')">
            </div>

            <div class="form-group col-4">
                <label for="amortizacion_hipoteca">Amortización hipoteca</label>
                <input v-model="amortizacion_hipoteca" type="text" class="form-control" id="amortizacion_hipoteca"
                    aria-describedby="amortizacion_hipoteca" autocomplete="off"
                    @input="formatInput(amortizacion_hipoteca, 'amortizacion_hipoteca')">
            </div>

            <div class="form-group col-4">
                <label for="pago_tarjetas">Pago mensual tarjetas de crédito</label>
                <input v-model="pago_tarjetas" type="text" class="form-control" id="pago_tarjetas"
                    aria-describedby="pago_tarjetas" autocomplete="off"
                    @input="formatInput(pago_tarjetas, 'pago_tarjetas')">
            </div>

            <div class="form-group col-4">
                <label for="otros_gastos">Otros gastos familiares</label>
                <input v-model="otros_gastos" type="text" class="form-control" id="otros_gastos"
                    aria-describedby="otros_gastos" autocomplete="off"
                    @input="formatInput(otros_gastos, 'otros_gastos')">
            </div>

            <div class="form-group col-4">
                <label for="total_egresos">Total</label>
                <input v-model="total_egresos" type="text" class="form-control" id="total_egresos"
                    aria-describedby="total_egresos" autocomplete="off" disabled>
            </div>

            <div class="col-12">
                <button @click="saveCredito" class="btn btn-success float-right">Guardar</button>
            </div>

        </div>

    </fieldset>
</template>