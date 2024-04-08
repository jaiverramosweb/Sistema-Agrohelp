<script setup>
import LayoutCLient from '@/Layouts/LayoutClient.vue';
import { onMounted, reactive, ref, computed, watch } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

import Solicitudes from './components/Solicitudes.vue'

const props = defineProps(['cliente', 'info'])

onMounted(() => {
    infoUser.value = props.cliente
    infoCliente.value = props.info
    // if (props.info.tipo_documento) creado.value = true
    if (props.info.tipo_documento) {
        getCaracteristicas()
    }
})

const infoUser = ref('')
const infoCliente = ref('')

const id = ref(0)
const tipo_identificacion = ref('')
const documento = ref('')
const nombre = ref('')
const segundo_nombre = ref('')
const apellido = ref('')
const segundo_apellido = ref('')

const productos = ref([])

const creado = ref(false)

const getCaracteristicas = () => {
    axios.get('/get-product-caract').then(({ data }) => {
        console.log('data', data)
        productos.value = data
    })
}

const simulador = () => {
    $("#modalSimulador").modal("show");
}

const save = () => {

    if (tipo_identificacion.value.length == 0) return
    if (documento.value.length == 0) return
    if (nombre.value.length == 0) return

    axios.post('/clients', {
        email: infoUser.value.email,
        tipo_documento: tipo_documento.value,
        documento: documento.value,
        nombre: nombre.value,
        segundo_nombre: segundo_nombre.value,
        apellido: apellido.value,
        segundo_apellido: segundo_apellido.value,

    }).then(({ data }) => {
        infoCliente.value = data.data
        Swal.fire({
            icon: 'success',
            title: 'Registro creado con exito'
        })

        // creado.value = false
    })
}


</script>

<template>
    <LayoutCLient>
        <div class="row">

            <div v-if="creado == false && !infoCliente.tipo_documento" class="col-lg-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Información del cliente
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-4" has-validation>
                                <label for="tipo_identificacion">Tipo de Identificación <span class="text-danger">
                                        *</span></label>
                                <select id="inputState" class="form-control" v-model="tipo_identificacion">
                                    <option value="" selected>Seleccione...</option>
                                    <option value="CC">CC</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                    <option value="NIT">NIT</option>
                                </select>
                                <div v-if="tipo_identificacion == ''" class="invalid-feedback d-block">El
                                    campo es
                                    requerido
                                </div>

                            </div>

                            <div class="form-group col-4" has-validation>
                                <label for="documento">Numero de Identificación <span class="text-danger">
                                        *</span></label>
                                <input v-model="documento" type="text" class="form-control" id="documento"
                                    aria-describedby="documento" autocomplete="off">
                                <div v-if="documento == ''" class="invalid-feedback d-block">El
                                    campo es
                                    requerido
                                </div>
                            </div>

                            <div class="form-group col-4" has-validation>
                                <label for="nombre">Nombre <span class="text-danger">
                                        *</span></label>
                                <input v-model="nombre" type="text" class="form-control" id="nombre"
                                    aria-describedby="nombre" autocomplete="off">
                                <div v-if="nombre == ''" class="invalid-feedback d-block">El campo es
                                    requerido
                                </div>
                            </div>

                            <div v-if="tipo_identificacion != 'NIT'" class="form-group col-4">
                                <label for="segundo_nombre">Segundo Nombre <span class="text-danger">
                                        *</span></label>
                                <input v-model="segundo_nombre" type="text" class="form-control" id="segundo_nombre"
                                    aria-describedby="segundo_nombre" autocomplete="off">
                            </div>

                            <div v-if="tipo_identificacion != 'NIT'" class="form-group col-4">
                                <label for="apellido">Primer Apellido <span class="text-danger">*</span></label>
                                <input v-model="apellido" type="text" class="form-control" id="apellido"
                                    aria-describedby="apellido" autocomplete="off">

                            </div>

                            <div v-if="tipo_identificacion != 'NIT'" class="form-group col-4">
                                <label for="segundo_apellido">Segundo Apellido <span
                                        class="text-danger">*</span></label>
                                <input v-model="segundo_apellido" type="text" class="form-control" id="segundo_apellido"
                                    aria-describedby="segundo_apellido" autocomplete="off">
                            </div>

                        </div>
                    </div>

                    <div class="card-footer"
                        v-if="tipo_identificacion.length > 0 && documento.length > 0 && nombre.length > 0">
                        <div class="row">
                            <div class="col-12 mt-4">
                                <button class="btn btn-success float-right" @click="save"> Guardar </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div v-if="infoCliente.tipo_documento" class="col-lg-12 mt-4">
                <div class="row">
                    <div v-for="product in productos" :key="product.id" class="m-2 col-12 col-md-4 ">

                        <div class="card card-widget widget-user">

                            <div class="widget-user-header bg-info">
                                <h3 class="widget-user-username">{{ product.producto }}</h3>
                                <h5 class="widget-user-desc">{{ product.nombre }}</h5>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">M. Minimo</h5>
                                            <span class="description-text">$ {{ product.monto_minimo }}</span>
                                        </div>

                                        <div class="description-block">
                                            <h5 class="description-header">T. Minimo</h5>
                                            <span class="description-text">{{ product.tiempo_minimo }}</span>
                                        </div>

                                    </div>

                                    <div class="col-sm-6 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">M. Maximo</h5>
                                            <span class="description-text">$ {{ product.monto_maximo }}</span>
                                        </div>

                                        <div class="description-block">
                                            <h5 class="description-header">T. Maximo</h5>
                                            <span class="description-text">{{ product.tiempo_maximo }}</span>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="row">

                                    <div class="form-group col-7">
                                        <label for="monto_solicitar">Monto a solicitar <span
                                                class="text-danger">*</span></label>
                                        <input v-model="monto_solicitar" type="text" class="form-control"
                                            id="monto_solicitar" aria-describedby="monto_solicitar" autocomplete="off">
                                    </div>

                                    <div class="form-group col-5">
                                        <label for="tiempo_pagar">Tiempo<span class="text-danger">*</span></label>
                                        <input v-model="tiempo_pagar" type="number" class="form-control"
                                            id="tiempo_pagar" aria-describedby="tiempo_pagar" autocomplete="off">
                                    </div>

                                    <div class="col-12">
                                        <button @click="simulador" class="btn btn-block btn-success">Simular</button>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalSimulador" data-backdrop="static" tabindex="-1"
                aria-labelledby="modalSimuladorLabel" aria-hidden="true">
                <!-- <div class="modal-dialog"> -->
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalSimuladorLabel">Simulador Valor a solicitar $5,000,000</h5>

                        </div>
                        <div class="modal-body">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Mes</th>
                                        <th scope="col">Cuota</th>
                                        <th scope="col">Intereses</th>
                                        <th scope="col">Abono Capital</th>
                                        <th scope="col">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>$475,124</td>
                                        <td>$104,000</td>
                                        <td>$371,124</td>
                                        <td>$4,628,876</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>$475,124</td>
                                        <td>$96,281</td>
                                        <td>$378,843</td>
                                        <td>$4,250,033</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>$475,124</td>
                                        <td>$88,401</td>
                                        <td>$386,723</td>
                                        <td>$3,863,310</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>$475,124</td>
                                        <td>$80,357</td>
                                        <td>$394,767 </td>
                                        <td>$3,468,543</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>$475,124</td>
                                        <td>$72,146</td>
                                        <td>$402,978</td>
                                        <td>$3,065,565</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>$475,124</td>
                                        <td>$63,764</td>
                                        <td>$411,360</td>
                                        <td>$2,654,205</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">7</th>
                                        <td>$475,124</td>
                                        <td>$55,207</td>
                                        <td>$419,917</td>
                                        <td>$2,234,288</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">8</th>
                                        <td>$475,124</td>
                                        <td>$46,473</td>
                                        <td>$428,651</td>
                                        <td>$1,805,637</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">9</th>
                                        <td>$475,124</td>
                                        <td>$37,557</td>
                                        <td>$437,567</td>
                                        <td>$1,368,070</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">10</th>
                                        <td>$475,124</td>
                                        <td>$28,456</td>
                                        <td>$446,668 </td>
                                        <td>$921,402</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">11</th>
                                        <td>$475,124</td>
                                        <td>$19,165</td>
                                        <td>$455,959 </td>
                                        <td>$465,443</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">12</th>
                                        <td>$475,124</td>
                                        <td>$19,165</td>
                                        <td>$9,681</td>
                                        <td>$0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary">Solicitar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="creado == true" class="col-lg-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Solicitudes
                    </div>

                    <div class="card-body">
                        <Solicitudes />
                    </div>
                </div>
            </div>


        </div>
    </LayoutCLient>
</template>
