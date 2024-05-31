<script setup>
import LayoutCLient from '@/Layouts/LayoutClient.vue';
import { onMounted, ref } from 'vue';

const props = defineProps(['data'])

onMounted(() => {
    tablaAmortizacion.value = props.data
    console.log('data', props.data)

    const info = props.data.map(d => {
        return {
            ...d,
            cuota: parseFloat(d.cuota).toFixed(2),
            interes: parseFloat(d.interes).toFixed(2),
            amortizacion: parseFloat(d.amortizacion).toFixed(2),
            saldo_pendiente: parseFloat(d.saldo_pendiente).toFixed(2)
        }
    })

    tablaAmortizacion.value = info
})

const tablaAmortizacion = ref([])

const return_index = () => {
    window.history.back();
}

const formatDate = (date) => {
    let dateString = date.substring(0, 10);
    return dateString
}

const formatearMoneda = (numero) => {
    const num = parseFloat(numero)
    return '$ ' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

const descargar = (id) => {

}

</script>

<template>
    <LayoutCLient>
        <div class="row">

            <div class="col-lg-12 mt-4">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">
                            Amortización solicitada
                        </h3>
                        <div class="card-tools">
                            <button @click='return_index()' class='btn btn-xs bg-gray'>
                                <i class='fas fa-reply'></i> Regresar
                            </button>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="row">

                            <table class="table table-bordered mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col">cuotas</th>
                                        <th scope="col">Mes</th>
                                        <th scope="col">Cuota</th>
                                        <th scope="col">Interés</th>
                                        <th scope="col">Valor Capital</th>
                                        <th scope="col">Saldo Pendiente</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Descargar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(fila, i) in tablaAmortizacion" :key="fila.fecha">
                                        <td scope="row">{{ i + 1 }}</td>
                                        <td scope="row">{{ formatDate(fila.fecha) }}</td>
                                        <td>{{ formatearMoneda(fila.cuota) }}</td>
                                        <td>{{ formatearMoneda(fila.interes) }}</td>
                                        <td>{{ formatearMoneda(fila.amortizacion) }}</td>
                                        <td>{{ formatearMoneda(fila.saldo_pendiente) }}</td>
                                        <td>
                                            <span v-if="!fila.estado" class="badge badge-yellow p-2">
                                                Pendiente
                                            </span>
                                            <span v-else class="badge badge-green p-2">
                                                Pagado
                                            </span>
                                        </td>
                                        <td>
                                            <button v-if="fila.estado"
                                                class="btn mr-1 btn-xs btn-outline-danger btn-round"
                                                data-toggle="tooltip" title="Ver" @click="descargar(fila.id)">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </LayoutCLient>
</template>

<style scoped>
.badge-yellow {
    background-color: white;
    border: 2px solid rgb(233, 233, 29);
}

.badge-green {
    background-color: white;
    border: 2px solid rgb(18, 183, 18);
}

.badge-red {
    background-color: white;
    border: 2px solid rgb(231, 64, 64);
}

.badge-blue {
    background-color: white;
    border: 2px solid rgb(71, 71, 243);
}
</style>