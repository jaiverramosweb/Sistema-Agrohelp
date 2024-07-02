<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref, computed, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

onMounted(() => {
    activeMenu('pago', 'facturar')
    getClient()
    getMora()
    getMetodoPago()
})

// Metodos Requeridos para iniciar modulo
const activeMenu = (menu, submenu) => {
    $(".menu_" + menu).addClass('menu-is-opening menu-open')
    $("#menu_" + menu).addClass('active')
    $("#sub_menu_" + submenu).addClass('active')
}

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

const dataClient = ref([])
const dataCredit = ref([])
const dataList = ref([])
const metodosPago = ref([])
const client_id = ref(0)
const credit_id = ref(0)
const metodo_pago = ref(0)

const capital = ref(0)
const tasa = ref(0)
const fecha_pagar = ref('')
const ineteresMora = ref('')
const ineteresMoraPagar = ref(0)
const descripcion_pago = ref('')

const dataPagar = ref([])
const tabla_pagos = ref([])
const tabla_amor = ref([])

const tipo_pago = ref('Mensual')

const newTotal = ref(0)

const getMora = () => {
    axios.get('/get-mora').then(({data}) => {
        ineteresMora.value = data.valor
    })
}

const getMetodoPago = () => {
    axios.get('/get-metodo-pago').then(({ data }) => {
        metodosPago.value = data
    })
}

const getClient = () => {
    axios.get('/get-clients').then(({data}) => {
        dataClient.value = data
    })
}

const getCreditos = () => {
    axios.get(`/get-credito-pay/${client_id.value}`).then(({data}) => {
        dataCredit.value = data
    })
}

const getListCredit = () => {
    axios.get(`/get-creditos/${credit_id.value}`).then(({data}) => {

        const info = data.map(d => {

            const mora = calcularMora(d.cuota, d.fecha)

            const cuota = d.cuota + mora
                
            return {
                ...d,
                cuota: parseFloat(cuota).toFixed(2),
                cuotaPagar: 0,
                interes: parseFloat(d.interes).toFixed(2),
                interes2: 0,
                interes_pagado: d.interes,
                mora: parseFloat(mora).toFixed(2),
                mora2: 0,
                amortizacion: parseFloat(d.amortizacion).toFixed(2),
                amortizacion2: 0,
                amortizacion_pagado: d.amortizacion,
                saldo_pendiente: parseFloat(d.saldo_pendiente).toFixed(2),
                saldo_pagar: 0
            }


            })

        dataList.value = info
        if(dataList.value.length > 0){
            if(tipo_pago.value == 'Mensual') $('#modalSolicitud').modal('show')            
            // if(tipo_pago.value == 'Capital') amortizacionMensual()           
        }
    })
}

const addPagar = (item) => {
    newTotal.value += parseInt(item.cuotaPagar) 

    tabla_pagos.value.push(item)
    console.log(tabla_pagos.value)
}

const formatearMoneda = (numero) => {
    const num = parseFloat(numero)
    return '$ ' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

const formatDate = (date) => {
    let dateString = date.substring(0, 10);
    return dateString
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


    if(diasRetraso > 0){
        // Convertir la tasa mensual a tasa diaria
        const tasaInteresMensual = ineteresMora.value /100
        const tasaInteresDiaria = tasaInteresMensual / 30;
        
        // Calcular el interés de mora
        const interesMora = montoVencido * tasaInteresDiaria * diasRetraso;
        ineteresMoraPagar.value = interesMora
        return interesMora
        
    } else {
        return 0;
    }

}

const calcularNuevoPago = () => {
    let num = 0
    let newData = []

    dataPagar.value.forEach(element => {

        const valor = valor_pagar.value

        const id_cuota = element.id
        const cuota = parseFloat(element.cuota)
        const interes = parseFloat(element.interes)
        const mora = parseFloat(element.mora)
        const capital = parseFloat(element.amortizacion)
        const saldo_pendiente = parseFloat(element.saldo_pendiente)

        if(valor == cuota){
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
            newData.push(p)
        }

        if (valor < cuota) {
            let saldo = valor
            let inte = interes
            let mor = mora
            let cuot = cuota
            let capi = capital

            if(mora > 0) {
                if (mora < saldo) {
                    saldo = valor - mora
                    mor = 0
                }

                if (interes < saldo) {     
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
            } else {
                capi = capi - saldo
                cuot = cuot - valor
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

            newData.push(p)

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

            newData.push(p)

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

                newData.push(p2)

            }

        }

        num += parseInt(element.cuotaPagar)
    });
    console.log('entro')
    tabla_pagos.value = newData
    newTotal.value = num
}

const generarPago = () => {

    if(dataList.value.length > 0){
        if(tipo_pago.value == 'Capital'){
            amortizacionMensual()
            if(tabla_amor.value.length > 0){
                pagarAbono()
            }
        }
        
        if(tipo_pago.value == 'Reducción de plazo') {
            abonoReduccionPlazo()
        
            if(tabla_amor.value.length > 0){
                pagarAbono()
            }
        }
    }


}

const amortizacionMensual = () => {
    console.log('amortizacionMensual', dataList.value[0].cuota_numero)

    const r_mensual = tasa.value / 100;
    const tiempo_pagar = dataList.value.length;
    let mesCuota = dataList.value[0].cuota_numero
    const [dia, mes, año] = dataList.value[0].fecha.split('/');
    const newMes = (mes - 1)
    const fecha_inicial = new Date(`${newMes.toString()}/${dia}/${año}`);

    const pago = capital.value - newTotal.value

    // Calcular la tasa efectiva para el período seleccionado
    const r_periodica = Math.pow(1 + r_mensual, 1) - 1;

    // Calcular la cuota periódica ajustada para la periodicidad
    const n_periodos = Math.ceil(tiempo_pagar / 1);
    const cuota_periodica = pago * r_periodica / (1 - Math.pow(1 + r_periodica, -n_periodos));

    tabla_amor.value = [];
    let saldo_pendiente = parseFloat(pago);


    for (let mes = 1; mes <= tiempo_pagar; mes++) {
        let pago_interes = saldo_pendiente * r_mensual;
        let pago_principal = 0;
        let cuota_actual = 0;

        // Realizar el pago de capital solo en los meses correspondientes a la periodicidad seleccionada
        if (mes % 1 === 0 || mes === tiempo_pagar) {
            cuota_actual = cuota_periodica;
            pago_principal = cuota_actual - pago_interes;
            saldo_pendiente -= pago_principal;

            // Ajustar el saldo pendiente al final para corregir pequeños errores de redondeo
            if (mes === tiempo_pagar && Math.abs(saldo_pendiente) < 1) {
                saldo_pendiente = 0;
            }
        } else {
            cuota_actual = pago_interes;
        }

        let fecha_pago = new Date(fecha_inicial);
        fecha_pago.setMonth(fecha_inicial.getMonth() + mes);

        tabla_amor.value.push({
            mes: mesCuota,
            fecha: fecha_pago.toLocaleDateString(),
            cuota: cuota_actual.toFixed(2),
            amortizacion: pago_principal.toFixed(2),
            interes: pago_interes.toFixed(2),
            saldoPendiente: saldo_pendiente.toFixed(2)
        });

        mesCuota += 1
    }
}

const abonoReduccionPlazo = () => {
    // Obtener el último saldo pendiente
    // const saldoPendienteInicial = ListCreditos.value[0].saldo_pendiente
    const cuotaMensual = dataList.value[0].cuota; // Suponiendo que la cuota es constante
    const tasaInteresMensual = tasa.value / 100;

     // Calcular el nuevo saldo pendiente después del abono a capital
     const nuevoSaldoPendiente = capital.value - monto.value;
    //  const nuevoSaldoPendiente = saldoPendienteInicial - monto.value;

    let saldo = nuevoSaldoPendiente;
    let mesesRestantes = dataList.value[0].cuota_numero;
    const nuevoDatosPrestamo = [];

    const [dia, mes, año] = dataList.value[0].fecha.split('/');
    const newMes = (mes - 1)
    const fecha_inicial = new Date(`${newMes.toString()}/${dia}/${año}`);

    tabla_amor.value = [];

    let aumento = 1

    while (saldo > 0) {
        const interesMensual = saldo * tasaInteresMensual;
        const abonoPrincipal = cuotaMensual - interesMensual;
        saldo -= abonoPrincipal;

        let fecha_pago = new Date(fecha_inicial);
        fecha_pago.setMonth(fecha_inicial.getMonth() + aumento);
        
        tabla_amor.value.push({
            mes: mesesRestantes,
            cuota: cuotaMensual.toFixed(2),
            fecha: fecha_pago.toLocaleDateString(),
            interes: interesMensual.toFixed(2),
            amortizacion: abonoPrincipal.toFixed(2),
            saldoPendiente: saldo > 0 ? saldo.toFixed(2) : 0,
            });

        mesesRestantes++;
        aumento++;
    }
}

const savePago = () => {
    if(tipo_pago.value == 'Mensual') pagarCuota()
    // if(tipo_pago.value == 'Capital') pagarAbono()
}

const pagarCuota = () => {
    // console.log(tabla_pagos.value)
    axios.post(`/realizar-pago`, {
        id: credit_id.value,
        pagos: newTotal.value,
        tabla_pagos: tabla_pagos.value,
        metodo_pago: metodo_pago.value,
        descripcion_pago: descripcion_pago.value,
        fecha_pagar: fecha_pagar.value
    }).then(({ data }) => {
        // console.log(data)
        newTotal.value = 0
        tabla_pagos.value = []
        descripcion_pago.value = ''
        Toast.fire({
            icon: 'success',
            title: 'Pago realizado con exito'
        })
    })
}

const pagarAbono = () => {
    console.log('pagarAbono',tabla_amor.value)
    axios.post('/pagar-abono', {
        id: credit_id.value,
        capital: capital.value - newTotal.value,
        tipo: tipo_pago.value,
        monto: newTotal.value,
        metodo_pago: metodo_pago.value,
        tablaAmortizacion: tabla_amor.value,
        // descripcion_pago: descripcion_pago.value,
        fecha_pagar: fecha_pagar.value
    }).then(({data}) => {
        Toast.fire({
            icon: 'success',
            title: 'Pago realizado con exito'
        })
    })
}


watch(client_id, () =>{
    getCreditos()
})

watch(credit_id, () =>{
    if(tipo_pago.value == 'Mensual') getListCredit()
    
    if(tipo_pago.value == 'Capital' || tipo_pago.value == 'Reducción de plazo') {
        getListCredit()
        const credit = dataCredit.value.filter(c => c.id == credit_id.value)
        console.log(credit)
        tasa.value = credit[0].tasa_interes
        capital.value = credit[0].valor

        // console.log('interes ',credit[0].tasa_interes)
        // console.log('capital ',credit[0].valor)
    }
})

// watch(dataPagar, () =>{
//     let num = 0
//     dataPagar.value.forEach(element => {
//         num += element.cuotaPagar
//     });
//     console.log('entro')
//     newTotal.value = num
// })


</script>

<template>
    <AuthenticatedLayout title="Pagos">

        <div class="preloader flex-column justify-content-center align-items-center" v-if="loader">
            <img class="animation__shake" src="/assets/img/CGRLogo.png" alt="AdminLTELogo" height="100" width="200">
        </div>

        <template #header>
            <div class="row mb-2">

                <div class="col-sm-6">
                    <!-- <button v-if="permissions.create" type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#modalClient">
                        + Nuevo Cliente
                    </button> -->

                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Inicio</a></li>
                        <li class="breadcrumb-item active">Pagar</li>
                        <li class="breadcrumb-item active">Generar pago</li>
                    </ol>
                </div>

            </div>
        </template>

        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Generar Pago</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-3">
                                <label for="tiempo_pagar">Fecha a pagar</label>
                                <input v-model="fecha_pagar" type="date" class="form-control" id="tiempo_pagar"
                                    aria-describedby="tiempo_pagar" autocomplete="off">
                            </div>

                            <div class="form-group col-3">
                                <label for="tiempo_pagar">Metodo de pago</label>
                                <select class="form-control" v-model="metodo_pago">
                                    <option value="0">Seleccione</option>
                                    <option v-for="metodo in metodosPago" :key="metodo.id" :value="metodo.id">{{ metodo.name
                                        }}</option>
                                </select>
                            </div>

                            <div class="form-group col-3" has-validation>
                                <label for="monto">Tipo de pago</label>
                                <select id="inputState" class="form-control" v-model="tipo_pago">
                                    <option value="" selected>Seleccione...</option>
                                    <option value="Mensual">Pago mensual</option>
                                    <option value="Capital">Abono Capital</option>
                                    <option value="Reducción de plazo">Abono Reducción de plazo</option>
                                    <option value="Total">Pago total</option>
                                </select>
                            </div>

                            <div class="form-group col-3" has-validation>
                                <label for="monto">Cliente</label>
                                <select id="inputState" class="form-control" v-model="client_id">
                                    <option value="0" selected>Seleccione...</option>
                                    <option v-for="client in dataClient" :key="client.id" :value="client.id">{{ client.nombre }} - {{ client.documento }}</option>
                                </select>
                            </div>

                            <div class="form-group col-3" has-validation>
                                <label for="monto">Credito</label>
                                <select id="inputState" class="form-control" v-model="credit_id">
                                    <option value="0" selected>Seleccione...</option>
                                    <option v-for="credit in dataCredit" :key="credit.id" :value="credit.id">{{ credit.nombre_linea }} - {{ credit.valor }}</option>
                                </select>
                            </div>

                            <div v-if="tipo_pago !== 'Mensual'" class="form-group col-3">
                                <label for="tasa">Monto</label>
                                <input v-model="newTotal" type="number" class="form-control" id="tasa" aria-describedby="tasa"
                                    autocomplete="off">
                            </div>

                            <div v-if="tipo_pago !== 'Mensual'" class="form-group col-6">
                                <button class="btn btn-info mt-4 float-right" @click="generarPago">Pagar</button>
                            </div>

                        </div>



                    </div>

                </div>
            </div>

            <div v-if="tabla_pagos.length > 0" class="col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Pagos a realizar</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Crédito</th>
                                                <th scope="col">Nro. Cuotas</th>
                                                <th scope="col">Cuota</th>
                                                <th scope="col">Interés</th>
                                                <th scope="col">Interés Mora</th>
                                                <th scope="col">Valor Capital</th>
                                                <th scope="col">Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(pagar, i) in tabla_pagos" :key="pagar.id">
                                                <td scope="row" class="text-center">Algo</td>
                                                <td scope="row" class="text-center">{{ pagar.cuota_numero }}</td>
                                                <td>{{ formatearMoneda(pagar.cuota) }}</td>
                                                <td>{{ formatearMoneda(pagar.interes2) }}</td>
                                                <td>{{ formatearMoneda(pagar.mora2) }}</td>
                                                <td>{{ formatearMoneda(pagar.amortizacion2) }}</td>
                                                <td>
                                                    <div class="form-group">
                                                        <input v-model="tabla_pagos[i].cuotaPagar" @change="calcularNuevoPago" type="number" class="form-control" id="tiempo_pagar"
                                                            aria-describedby="tiempo_pagar" autocomplete="off">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div>
                                        <div class="row">
                                            <div class="col-12 mt-2">
                                                <label for="">Descripción del pago</label>
                                                <textarea class="form-control" v-model="descripcion_pago" name="descripcion_pago" id="descripcion_pago" rows="5"></textarea>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <div class="float-right">
                                                    <b>Total a pagar: {{ formatearMoneda(newTotal) }}</b>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-info mt-4 float-right" @click="savePago">Pagar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>



                    </div>

                </div>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="modalSolicitud" data-backdrop="static" tabindex="-1"
            aria-labelledby="modalSolicitudLabel" aria-hidden="true">
            <!-- <div class="modal-dialog"> -->
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSolicitudLabel">Listado de pago</h5>

                    </div>
                    <div class="modal-body">

                        <div class="row">
                                
                            <div v-if="dataList.length > 0" class="form-group col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nro. Cuotas</th>
                                                <th scope="col">Mes</th>
                                                <th scope="col">Cuota</th>
                                                <th scope="col">Interés</th>
                                                <th scope="col">Interés Mora</th>
                                                <th scope="col">Valor Capital</th>
                                                <th scope="col">Saldo Pendiente</th>
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(fila) in dataList" :key="fila.id">
                                                <td scope="row" class="text-center">{{ fila.cuota_numero }}</td>
                                                <td scope="row">{{ formatDate(fila.fecha) }}</td>
                                                <td>{{ formatearMoneda(fila.cuota) }}</td>
                                                <td>{{ formatearMoneda(fila.interes) }}</td>
                                                <td>{{ formatearMoneda(fila.mora) }}</td>
                                                <td>{{ formatearMoneda(fila.amortizacion) }}</td>
                                                <td>{{ formatearMoneda(fila.saldo_pendiente) }}</td>
                                                <td>
                                                    <button v-if="!dataPagar.includes(fila)" @click="addPagar(fila)" class="btn btn-outline-success">Agregar</button>
                                                    <button v-else @click="addPagar(fila)" class="btn btn-outline-warning">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <!-- <button v-if="!dataPagar.includes(fila)" @click="addPagar(fila)" class="btn btn-outline-info">Agregar</button> -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <!-- <button v-if="tablaAmortizacion.length > 0" @click="solicitarCredit" type="button" class="btn btn-primary">Solicitar</button> -->
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>