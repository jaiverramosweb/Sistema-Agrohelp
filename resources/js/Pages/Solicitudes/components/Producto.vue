<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
const props = defineProps(['producto', 'interes', 'monto_solicitar', 'tiempo_pagar', 'estado', 'solicitud_id', 'tipo', 'mora', 'capital'])
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

onMounted(() => {
    producto.value = props.producto
    monto_solicitar.value = props.monto_solicitar
    tiempo_pagar.value = props.tiempo_pagar
    tasa.value = props.interes
    mora.value = props.mora
    estado.value = props.estado
    tipo.value = props.tipo
    solicitudId.value = props.solicitud_id
    capital.value = props.capital
    // console.log('producto', props.producto)
    metodoFrances()
    getMora()
})

const producto = ref('')

const estado = ref('')
const tipo = ref('')
const periodo = ref('bimestral')
const solicitudId = ref(0)

const pago_interes = ref(0)
const numero_cuota = ref(0)
const pago_cuota = ref(0)
const pago_capital = ref(0)
const saldo_pendiente_p = ref(0)

const metodo_pago = ref(0)

const dataPagar = ref('')
const valor_pagar = ref('')

const dataAmortizacion = ref([])
const metodosPago = ref([])

const tasa = ref('')
const mora = ref('')
const ineteresMora = ref('')
const ineteresMoraPagar = ref(0)
const capital = ref('')
const monto_solicitar = ref('')
const tiempo_pagar = ref('')
const tablaAmortizacion = ref([])
const tipo_interes = ref('')
const descripcion_pago = ref('')
const tablaPagos = ref([])
const comprobantes = ref([])
const fecha_inicio = ref('')

const fecha_pagar = ref('')

const getMora = () => {
    axios.get('/get-mora').then(({data}) => {
        ineteresMora.value = data
        getAmortizacionAll()
    })
}

const metodoFrances = () => {

    if(tipo.value == 'Mensual'){
        amortizacionMensual()
    } else {
        amortizacionVariable()
    }
}

const aprobado = () => {
    $("#modalFechaAceptar").modal("show");
    
}

const aprobadoSave = () => {

    const [año, mes, dia] = fecha_inicio.value.split('-');
    const newMes = (mes)
    const fecha_inicial = new Date(`${newMes.toString()}/${dia}/${año}`);

    let aumento = 1

    for (let index = 0; index < tablaAmortizacion.value.length; index++) {
        let fecha_pago = new Date(fecha_inicial);
        fecha_pago.setMonth(fecha_inicial.getMonth() + aumento);

        tablaAmortizacion.value[index].fecha =  fecha_pago.toLocaleDateString();
        aumento++
    }

    setTimeout(() => {        
        axios.put(`/solicitud-aprobada/${solicitudId.value}`, {
            state: 'Aprobado',
            tasa: tasa.value,
            mora: mora.value,
            tipo: tipo.value,
            monto_solicitar: monto_solicitar.value,
            tiempo_pagar: tiempo_pagar.value,
            tablaAmortizacion: tablaAmortizacion.value
        }).then(({ data }) => {
            Swal.fire({
                icon: 'success',
                title: 'Aprobado'
            })
            location.reload();
        })
    }, 1000);

}

const savePreaprobado = () => {
    axios.get(`/save-preaprovado/${solicitudId.value}`).then(({ data }) => {
        // console.log(data)
        estado.value = 'Preaprobado'
    })
}

const cambiarEstado = (state) => {
    axios.put(`/update-estado-solicitud/${solicitudId.value}`, { state }).then(({ data }) => {
        // console.log(data)
        estado.value = state
    })
}


const amortizacionVariable = () => {

let tipoCuotras = 1
let taza_interes = 0

if (tipo.value == 'Trimestral') {
    tipoCuotras = 3
}
if (tipo.value == 'Semestral') {
    tipoCuotras = 6
}

if(tipo_interes.value == 'IPC'){
    taza_interes = interes_mas.value + tasa.value
} else {
    taza_interes =  tasa.value
}

// monto_aprobar.value = monto_solicitar.value * 0.7

// Parámetros
const r_mensual = taza_interes / 100; // Tasa de interés mensual
const capital = monto_solicitar.value / (tiempo_pagar.value / tipoCuotras); // Pago de capital trimestral
const fecha_inicial = new Date(); // Fecha actual
let saldo_pendiente = monto_solicitar.value;

// Array para almacenar los pagos
tablaAmortizacion.value = [];

for (let i = 0; i < tiempo_pagar.value; i++) {
    let pago_interes = saldo_pendiente * r_mensual;
    let pago_capital = 0;

    // Si es el último mes del trimestre, se paga el capital
    if ((i + 1) % tipoCuotras === 0) {
        pago_capital = capital;
    }

    let cuota = pago_interes + pago_capital;
    // const cuota = (r_mensual * monto.value) / (1- Math.pow((1 + r_mensual), -tiempo))
    saldo_pendiente -= pago_capital;

    // Generar la fecha del pago
    let fecha_pago = new Date(fecha_inicial);
    fecha_pago.setMonth(fecha_inicial.getMonth() + i);

    // Añadir al array de amortización
    tablaAmortizacion.value.push({
        mes:i + 1,
        fecha: fecha_pago.toLocaleDateString(),
        cuota: cuota.toFixed(2),
        interes: pago_interes.toFixed(2),
        amortizacion: pago_capital.toFixed(2),
        saldoPendiente: saldo_pendiente.toFixed(2)
    });
}

}

const amortizacionMensual = () => {
    const r_mensual = tasa.value / 100;
    const fecha_inicial = new Date();

    // Calcular la tasa efectiva para el período seleccionado
    const r_periodica = Math.pow(1 + r_mensual, 1) - 1;

    // Calcular la cuota periódica ajustada para la periodicidad
    const n_periodos = Math.ceil(tiempo_pagar.value / 1);
    const cuota_periodica = monto_solicitar.value * r_periodica / (1 - Math.pow(1 + r_periodica, -n_periodos));

    tablaAmortizacion.value = [];
    let saldo_pendiente = parseFloat(monto_solicitar.value);

    for (let mes = 1; mes <= tiempo_pagar.value; mes++) {
        let pago_interes = saldo_pendiente * r_mensual;
        let pago_principal = 0;
        let cuota_actual = 0;

        // Realizar el pago de capital solo en los meses correspondientes a la periodicidad seleccionada
        if (mes % 1 === 0 || mes === tiempo_pagar.value) {
            cuota_actual = cuota_periodica;
            pago_principal = cuota_actual - pago_interes;
            saldo_pendiente -= pago_principal;

            // Ajustar el saldo pendiente al final para corregir pequeños errores de redondeo
            if (mes === tiempo_pagar.value && Math.abs(saldo_pendiente) < 1) {
                saldo_pendiente = 0;
            }
        } else {
            cuota_actual = pago_interes;
        }

        let fecha_pago = new Date(fecha_inicial);
        fecha_pago.setMonth(fecha_inicial.getMonth() + mes);

        tablaAmortizacion.value.push({
            mes: mes,
            fecha: fecha_pago.toLocaleDateString(),
            cuota: cuota_actual.toFixed(2),
            amortizacion: pago_principal.toFixed(2),
            interes: pago_interes.toFixed(2),
            saldoPendiente: saldo_pendiente.toFixed(2)
        });
    }
}

const mostrarModal = () => {
    $("#modalModificar").modal("show");
}

const modificarValores = () => {
    axios.put(`/update-valores-solicitud/${solicitudId.value}`, {
        tasa: tasa.value,
        monto_solicitar: monto_solicitar.value,
        tiempo_pagar: tiempo_pagar.value,
    }).then(({ data }) => {
        // console.log(data)
        // estado.value = 'No aprobado'
        metodoFrances()
        $("#modalModificar").modal("hide");
    })
}

const getAmortizacionAll = () => {
    axios.get(`/amortizacion-all/${solicitudId.value}`).then(({ data }) => {

        console.log('data Amor', data)
        console.log('mora', ineteresMora.value)

        if(ineteresMora.value){
            
                    const info = data.map(d => {
            
                        const mora = calcularMora(d.cuota, d.fecha)
            
                        const cuota = d.cuota + mora
                            
                        return {
                            ...d,
                            cuota: parseFloat(cuota).toFixed(2),
                            interes: parseFloat(d.interes).toFixed(2),
                            mora: parseFloat(mora).toFixed(2),
                            amortizacion: parseFloat(d.amortizacion).toFixed(2),
                            saldo_pendiente: parseFloat(d.saldo_pendiente).toFixed(2)
                        }
            
            
                    })
            
                    dataAmortizacion.value = info

        }
    })
}

const modalPago = (item, num) => {
    getMetodoPago()

    dataPagar.value = item

    valor_pagar.value = item.cuota
    numero_cuota.value = num
    pago_interes.value = item.interes
    pago_cuota.value = item.cuota
    pago_capital.value = item.amortizacion
    saldo_pendiente_p.value = item.saldo_pendiente

    $("#modalPago").modal("show");
}

const getMetodoPago = () => {
    axios.get('/get-metodo-pago').then(({ data }) => {
        metodosPago.value = data
    })
}

const calcularPago = () => {
    const valor = valor_pagar.value

    const id_cuota = dataPagar.value.id
    const cuota = parseFloat(pago_cuota.value)
    const interes = parseFloat(pago_interes.value)
    const moraData = parseFloat(ineteresMoraPagar.value)
    const mora = parseFloat(ineteresMoraPagar.value)
    const capital = parseFloat(pago_capital.value)
    const saldo_pendiente = parseFloat(saldo_pendiente_p.value)


    let cuotas = []


    if (valor == cuota) {
        const p = {
            id: id_cuota,
            numero: numero_cuota.value,
            interes: interes,
            interes2: 0,
            interes_pagado: interes,
            cuota: 0,
            amortizacion: capital,
            amortizacion2: 0,
            amortizacion_pagado: capital,
            saldo_pagar: 0,
            mora: mora,
            mora2: 0,
            saldo_pendiente: saldo_pendiente
        }
        cuotas.push(p)
    }

    if (valor < cuota) {
        let saldo = valor
        let inte = interes
        let mor = mora
        let cuot = cuota
        let capi = capital

        if (interes < saldo) {
            saldo = valor - mora
            mor = 0

            saldo = valor - interes
            inte = 0
            

            if (saldo > 0) {
                capi = capi - saldo
                cuot = cuot - valor
                saldo = 0
            }

        } else {
            mor = mora - valor
            inte = interes - mor
            saldo = 0
        }

        const p = {
            id: id_cuota,
            numero: numero_cuota.value,
            interes: interes,
            interes2: inte,
            mora: mora,
            mora2: mor,
            interes_pagado: inte,
            cuota: parseFloat(cuot).toFixed(2),
            amortizacion: capital,
            amortizacion2: capi,
            amortizacion_pagado: capi,
            saldo_pagar: parseFloat(saldo_pendiente - valor).toFixed(2),
            saldo_pendiente: saldo_pendiente
        }

        cuotas.push(p)

    }

    if (valor > cuota) {

        let saldo = 0

        const p = {
            id: id_cuota,
            numero: numero_cuota.value,
            interes: interes,
            interes_pagado: interes,
            interes2: 0,
            mora: mora,
            mora2: 0,
            cuota: 0,
            amortizacion: capital,
            amortizacion_pagado: capital,
            amortizacion2: 0,
            saldo_pagar: 0,
            saldo_pendiente: saldo_pendiente
        }

        cuotas.push(p)

        saldo = valor - cuota

        let idBuscar = id_cuota + 1

        const nueva = dataAmortizacion.value.filter(d => d.id == idBuscar)[0]

        if (nueva) {

            const mora2 = calcularMora(nueva.cuota, nueva.fecha)

            let inte2 = parseFloat(nueva.interes)
            let cuot2 = parseFloat(nueva.cuota)
            let amor2 = parseFloat(nueva.amortizacion)
            const mor = 0

            if (inte2 < saldo) {
                const newSaldo = saldo - mora2
                const saldo2 = newSaldo - inte2                
                inte2 = 0

                amor2 = amor2 - saldo2
                cuot2 = cuot2 - saldo
                saldo = 0


            } else {

                if(saldo > mora2){
                    const newSaldo = saldo - mora2
                    inte2 = nueva.interes - newSaldo
                    cuot2 = cuot2 - inte2
                } else {
                    mor = mora2 - saldo
                    cuot2 = cuot2 - mor
                }
            }

            const p2 = {
                id: nueva.id,
                numero: numero_cuota.value + 1,
                interes2: parseFloat(inte2).toFixed(2),
                interes_pagado: parseFloat(inte2).toFixed(2),
                interes: parseFloat(nueva.interes).toFixed(2),
                mora: parseFloat(mora2).toFixed(2),
                mora2: parseFloat(mor).toFixed(2),
                cuota: parseFloat(cuot2).toFixed(2),
                amortizacion: parseFloat(nueva.amortizacion).toFixed(2),
                amortizacion2: parseFloat(amor2).toFixed(2),
                amortizacion_pagado: parseFloat(amor2).toFixed(2),
                saldo_pagar: parseFloat(saldo_pendiente - cuot2).toFixed(2),
                saldo_pendiente: saldo_pendiente
            }

            cuotas.push(p2)

        }

    }

    tablaPagos.value = cuotas
}

const pagarCuota = () => {
    axios.put(`/realizar-pago/${solicitudId.value}`, {
        pagos: valor_pagar.value,
        tabla_pagos: tablaPagos.value,
        metodo_pago: metodo_pago.value,
        descripcion_pago: descripcion_pago.value,
        fecha_pagar: fecha_pagar.value
    }).then(({ data }) => {
        // console.log(data)
        valor_pagar.value = ''
        metodo_pago.value = 0
        tablaPagos.value = []
        descripcion_pago.value = ''
        getAmortizacionAll()
        Swal.fire({
            icon: 'success',
            title: 'Saldo agregado'
        })
        $("#modalPago").modal("hide");
    })
}

const comprobante = (id) => {
    axios.get(`/comprobante/${id}`).then(({data}) => {
        comprobantes.value = data
        $("#modalComprobante").modal("show");        
    })
}

const updateStateSolicitud = (valor) => {
    axios.put('/update-solicitud/' + solicitudId.value, { accion: valor }).then(({ data }) => {
        estado.value = 'En estudio'
        Swal.fire({
            icon: 'success',
            title: 'Solicitud realizada'
        })
    })
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
    let url = '/download-compro/' + id;
    window.open(url, '_blank');
}

const calcularMora = (montoVencido, fecha) => {

    // Dividir la fecha de vencimiento en partes
    const fechap = '13/5/2024'
    const partes = fecha.split('/');

    const dia = parseInt(partes[0], 10);
    const mes = parseInt(partes[1], 10) - 1; // Los meses en JavaScript son 0-indexados
    const ano = parseInt(partes[2], 10);
    
    // Crear un objeto Date para la fecha de vencimiento
    const fechaVenc = new Date(ano, mes, dia);
    
    // Obtener la fecha actual
    const fechaActual = new Date();
    
    // Calcular la diferencia en milisegundos
    const diferenciaMilisegundos = fechaActual - fechaVenc;
    
    // Convertir la diferencia de milisegundos a días
    const milisegundosPorDia = 1000 * 60 * 60 * 24;
    const diasRetraso = Math.floor(diferenciaMilisegundos / milisegundosPorDia);


    const result = ineteresMora.value.find(item => {
        const itemDate = new Date(item.fecha);
        return itemDate.getMonth() + 1 === mes && itemDate.getFullYear() === ano;
    });

    if(result != undefined){

        if(diasRetraso > 0){
            // Convertir la tasa mensual a tasa diaria
            const tasaInteresMensual = result.valor /100
            const tasaInteresDiaria = tasaInteresMensual / 30;
            
            // Calcular el interés de mora
            const interesMora = montoVencido * tasaInteresDiaria * diasRetraso;
            ineteresMoraPagar.value = interesMora
            return interesMora
            
        } else {
            return 0;
        }
    } else {
        return 0;
    }


}


</script>

<template>

    <div v-if="dataAmortizacion.length == 0" class="row">

        <div class="col-3">
            <b>Tasa de interés</b>
            <p>{{ tasa }}%</p>
        </div>
        <div class="col-3">
            <b>Periocidad de pagos</b>
            <p>{{ tipo }}</p>
        </div>
        <div class="col-3">
            <b>Monto solicitado</b>
            <p>{{ formatearMoneda(monto_solicitar) }}</p>
        </div>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th scope="col">cuotas</th>
                    <th scope="col">Mes</th>
                    <th scope="col">Cuota</th>
                    <th scope="col">Interés</th>
                    <th scope="col">Valor Capital</th>
                    <th scope="col">Saldo Pendiente</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(fila, i) in tablaAmortizacion" :key="fila.fecha">
                    <td scope="row" class="text-center">{{ i + 1 }}</td>
                    <td scope="row">{{ formatDate(fila.fecha) }}</td>
                    <td>{{ formatearMoneda(fila.cuota) }}</td>
                    <td>{{ formatearMoneda(fila.interes) }}</td>
                    <td>{{ formatearMoneda(fila.amortizacion) }}</td>
                    <td>{{ formatearMoneda(fila.saldoPendiente) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="col-12">
            <button  v-if="estado == 'En tramite'"  @click="updateStateSolicitud('En estudio')"
                class="btn btn-success float-right">Solicitar</button>

            <button v-if="estado == 'En estudio'" @click="savePreaprobado"
                class="btn btn-success float-right">Preaprobado</button>

            <button v-if="estado == 'Preaprobado'" @click="aprobado()"
                class="btn btn-success float-right">Aprobado</button>

            <button v-if="estado == 'Preaprobado'" @click="mostrarModal"
                class="btn btn-warning float-right mr-4">Modificar
                registro</button>

            <button v-if="estado == 'En estudio'" @click="mostrarModal"
                class="btn btn-warning float-right mr-4">Modificar
                registro</button>


            <button v-if="estado == 'En estudio'" @click="cambiarEstado('No aprobado')" class="btn btn-danger">No
                aprobado</button>

            <button v-if="estado == 'Preaprobado'" @click="cambiarEstado('Condiciones no aceptadas')"
                class="btn btn-danger">Condiciones no aceptadas</button>
        </div>

    </div>

    <div v-else class="row">

        <div class="col-3">
            <b>Tasa de interés</b>
            <p>{{ tasa }}%</p>
        </div>

        <div class="col-3">
            <b>Tipo de pago</b>
            <p>{{ tipo }}</p>
        </div>

        <div class="col-3">
            <b>Monto solicitado</b>
            <p>{{ formatearMoneda(monto_solicitar) }}</p>
        </div>

        <div class="col-3">
            <b>Capital</b>
            <p>{{ formatearMoneda(capital) }}</p>
        </div>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th scope="col">Nro. Cuotas</th>
                    <th scope="col">Mes</th>
                    <th scope="col">Cuota</th>
                    <th scope="col">Interés</th>
                    <th scope="col">Interés Mora</th>
                    <th scope="col">Valor Capital</th>
                    <th scope="col">Saldo Pendiente</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(fila, i) in dataAmortizacion" :key="fila.id">
                    <td scope="row" class="text-center">{{ i + 1 }}</td>
                    <td scope="row">{{ formatDate(fila.fecha) }}</td>
                    <td>{{ formatearMoneda(fila.cuota) }}</td>
                    <td>{{ formatearMoneda(fila.interes) }}</td>
                    <td>{{ formatearMoneda(fila.mora) }}</td>
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
                        <!-- <button v-if="!fila.estado" class="btn btn-outline-success"
                            @click="modalPago(fila, i + 1)">Pagar</button> -->

                        <button @click="comprobante(fila.id)" v-if="fila.estado" class="btn btn-outline-danger">
                            <i class="far fa-file-pdf"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="col-12">
            <button  v-if="estado == 'En tramite'"  @click="updateStateSolicitud('En estudio')"
                class="btn btn-success float-right">Solicitar</button>

            <button v-if="estado == 'En estudio'" @click="savePreaprobado"
                class="btn btn-success float-right">Preaprobado</button>

            <button v-if="estado == 'Preaprobado'" @click="aprobado()"
                class="btn btn-success float-right">Aprobado</button>

            <button v-if="estado == 'Preaprobado'" @click="mostrarModal"
                class="btn btn-warning float-right mr-4">Modificar
                registro</button>

            <button v-if="estado == 'En estudio'" @click="mostrarModal"
                class="btn btn-warning float-right mr-4">Modificar
                registro</button>


            <button v-if="estado == 'En estudio'" @click="cambiarEstado('No aprobado')" class="btn btn-danger">No
                aprobado</button>

            <button v-if="estado == 'Preaprobado'" @click="cambiarEstado('Condiciones no aceptadas')"
                class="btn btn-danger">Condiciones no aceptadas</button>
        </div>

    </div>


    <!-- Modal  -->
    <div class="modal fade" id="modalModificar" data-backdrop="static" tabindex="-1"
        aria-labelledby="modalModificarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- <div class="modal-dialog modal-xl"> -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalModificarLabel">Modificar registros</h5>

                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-12">
                            <label for="inputState">Periocidad de pagos <span class="text-danger">*</span></label>
                            <select id="inputState" class="form-control" v-model="tipo">
                                <option value="" selected>Seleccione...</option>
                                <option value="Mensual">Mensual</option>
                                <option value="Trimestral">Trimestral</option>
                                <option value="Semestral">Semestral</option>
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <label for="tasa">Tasa de interés</label>
                            <input v-model="tasa" type="number" class="form-control" id="tasa" aria-describedby="tasa"
                                autocomplete="off">
                        </div>

                        <div class="form-group col-12">
                            <label for="monto_solicitar">Monto solicitado</label>
                            <input v-model="monto_solicitar" type="number" class="form-control" id="monto_solicitar"
                                aria-describedby="monto_solicitar" autocomplete="off">
                        </div>

                        <div class="form-group col-12">
                            <label for="tiempo_pagar">Tiempo de pago</label>
                            <input v-model="tiempo_pagar" type="number" class="form-control" id="tiempo_pagar"
                                aria-describedby="tiempo_pagar" autocomplete="off">
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                    <button type="button" class="btn btn-primary" @click="modificarValores">Modificar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pago -->
    <div class="modal fade" id="modalPago" data-backdrop="static" tabindex="-1" aria-labelledby="modalPagoLabel"
        aria-hidden="true">
        <!-- <div class="modal-dialog"> -->
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPagoLabel">Registrar pago</h5>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="tasa">Cuota</label>
                            <p>{{ formatearMoneda(pago_cuota) }}</p>
                        </div>

                        <div class="form-group col-3">
                            <label for="monto_solicitar">Interés</label>
                            <p>{{ formatearMoneda(pago_interes) }}</p>
                        </div>

                        <div class="form-group col-3">
                            <label for="monto_solicitar">Interés mora</label>
                            <p>{{ formatearMoneda(ineteresMoraPagar) }}</p>
                        </div>

                        <div class="form-group col-3">
                            <label for="tiempo_pagar">Valor Capital</label>
                            <p>{{ formatearMoneda(pago_capital) }}</p>
                        </div>

                        <div class="form-group col-4">
                            <label for="tiempo_pagar">Metodo de pago</label>
                            <select class="form-control" v-model="metodo_pago">
                                <option value="0">Seleccione</option>
                                <option v-for="metodo in metodosPago" :key="metodo.id" :value="metodo.id">{{ metodo.name
                                    }}</option>
                            </select>
                        </div>

                        <div class="form-group col-4">
                            <label for="tiempo_pagar">Monto a pagar</label>
                            <input v-model="valor_pagar" type="number" class="form-control" id="tiempo_pagar"
                                aria-describedby="tiempo_pagar" autocomplete="off">
                        </div>

                        <div class="form-group col-2">
                            <label for="tiempo_pagar">Fecha a pagar</label>
                            <input v-model="fecha_pagar" type="date" class="form-control" id="tiempo_pagar"
                                aria-describedby="tiempo_pagar" autocomplete="off">
                        </div>

                        <div class="col-2" style="margin-top: 33px;">
                            <button @click="calcularPago" class="btn btn-success float-right">Generar Pago</button>
                        </div>

                        <div v-if="tablaPagos.length > 0" class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered mt-4">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col">Nro. cuota</th>
                                            <th scope="col">Cuota</th>
                                            <th scope="col">Interés</th>
                                            <th scope="col">Interés pagado</th>
                                            <th scope="col">Interés mora</th>
                                            <th scope="col">Interés mora pagado</th>
                                            <th scope="col">Valor Capital</th>
                                            <th scope="col">Valor Capital pagado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-if="tablaPagos.length > 0">
                                            <tr class="text-center" v-for="(fila, i) in tablaPagos" :key="i">
                                                <td scope="row">{{ fila.numero }}</td>
                                                <td>
                                                    <input style="width: 110px;" type="text" v-model="tablaPagos[i].cuota">
                                                </td>
                                                <td>
                                                    <div style="width: 110px;">{{ formatearMoneda(fila.interes) }}</div> 
                                                </td>
                                                <td>
                                                    <input style="width: 110px;" type="text" v-model="tablaPagos[i].interes2">
                                                </td>
                                                <td>
                                                    <div style="width: 110px;">{{ formatearMoneda(fila.mora) }}</div>
                                                </td>
                                                <td>
                                                    <input style="width: 110px;" type="text" v-model="tablaPagos[i].mora2">
                                                </td>
                                                <td>
                                                    <div style="width: 110px;">{{ formatearMoneda(fila.amortizacion) }}</div>
                                                </td>
                                                <td>
                                                    <input style="width: 110px;" type="text" v-model="tablaPagos[i].amortizacion2">
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div v-if="tablaPagos.length > 0" class="col-12">
                            <label for="">Descripción del pago</label>
                            <textarea class="form-control" v-model="descripcion_pago" name="descripcion_pago" id="descripcion_pago" rows="5"></textarea>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                    <button v-if="tablaPagos.length > 0" type="button" class="btn btn-primary"
                        @click="pagarCuota">Pagar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal recibo -->
    <div class="modal fade" id="modalComprobante" data-backdrop="static" tabindex="-1"
        aria-labelledby="modalComprobanteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- <div class="modal-dialog modal-xl"> -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalComprobanteLabel">Recibo de pagos</h5>

                </div>
                <div class="modal-body">
                    <div v-for="comp in comprobantes" :key="comp.id">
                        <div class="row">
                            <div class="col-6 mt-2"> <b>Monto pagado: {{ formatearMoneda(comp.pago) }}</b></div>
                            <div class="col-4 mt-2"><b>Fecha: {{ formatDate(comp.created_at) }}</b> </div>
                            <div class="col-2">
                                <button @click="descargar(comp.id)" class="btn btn-outline-danger">
                                    <i class="far fa-file-pdf"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal recibo -->
    <div class="modal fade" id="modalFechaAceptar" data-backdrop="static" tabindex="-1"
        aria-labelledby="modalFechaAceptarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- <div class="modal-dialog modal-xl"> -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFechaAceptarLabel">Recibo de pagos</h5>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="fecha_inicio">Fecha de inicio de cobro</label>
                            <input v-model="fecha_inicio" type="date" class="form-control" id="fecha_inicio" aria-describedby="fecha_inicio"
                                autocomplete="off">
                        </div>
                    </div>                   
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button @click="aprobadoSave" type="button" class="btn btn-success">Aprobar</button>
                </div>
            </div>
        </div>
    </div>

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