<script setup>
import LayoutCLient from '@/Layouts/LayoutClient.vue';
import { onMounted, reactive, ref, computed, watch } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

const props = defineProps(['cliente', 'producto'])

onMounted(() => {
    tipo_documento.value = props.cliente.tipo_documento
    documento.value = props.cliente.documento
    nombre.value = props.cliente.nombre
    email.value = props.cliente.email
    producto.value = props.producto
    rellenar(props.producto)
})

const mostrar = ref(false)
const mostrar_dos = ref(false)
const mostrar_vehoculo = ref(false)

const infoUser = ref('')
const infoCliente = ref('')


const direcciones = ref([])
const genero = ref('')
const tipo_persona = ref('')
const fecha_nacimiento = ref('')

const producto = ref('')




const id = ref(0)
const tipo_documento = ref('')
const documento = ref('')
const nombre = ref('')
const email = ref('')

const edad = ref('')
const domicilio = ref('')
const direccion_pers = ref('')
const telefono = ref('')
const direccion_comercial = ref('')
const telefono_comercial = ref('')
const direccion_judicial = ref('')
const telefono_judicial = ref('')
const representante = ref('')
const representante_doc = ref('')
const tipo_cliente = ref('')
const autorretenedor = ref('')
const persona_pago = ref('')
const direccion_pago = ref('')
const telefono_pago = ref('')
const dia_pago = ref('')
const hora_pago = ref('')
const comentatio_pago = ref('')
const estado_civil = ref('')
const direccion_recidencia = ref('')
const telefono_recidencia = ref('')
const ciudad_recidencia = ref('')
const empresa = ref('')
const empresa_direccion = ref('')
const empresa_telefono = ref('')
const cargo_actual = ref('')
const antoguedad_empresa = ref('')
const personas_cargo = ref('')
const vivienda = ref('')
const camara_comercio = ref('')
const profesion = ref('')
const nombre_negocio = ref('')
const tipo_direccion = ref('')
const direccion = ref('')
const ciudad = ref('')
const departamento = ref('')
const ciudad_solicitud = ref('')
const tipo_declarante = ref('')
const independiente = ref('')
const nombre_conyuge = ref('')
const ocupacion_conyuge = ref('')
const empresa_conyuge = ref('')

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


const tipo_credito = ref('')
const oficina_credito = ref('')
const vendedor_credito = ref('')
const monto_solicitado_credito = ref('')
const forma_pago_credito = ref('')


const descripcion_bien = ref('')
const ciudad_bien = ref('')
const hipoteca_bien = ref('')
const avaluo_comercial_bien = ref('')
const avaluo_catastral_bien = ref('')
const cedula_catastral_bien = ref('')
const matricula_bien = ref('')
const escritura_bien = ref('')
const notaria_bien = ref('')
const fecha_bien = ref('')
const ciudad_parimonio_bien = ref('')
const descripcion_bien_dos = ref('')
const ciudad_bien_dos = ref('')
const hipoteca_bien_dos = ref('')
const avaluo_comercial_bien_dos = ref('')
const avaluo_catastral_bien_dos = ref('')
const cedula_catastral_bien_dos = ref('')
const matricula_bien_dos = ref('')
const escritura_bien_dos = ref('')
const notaria_bien_dos = ref('')
const fecha_bien_dos = ref('')
const ciudad_parimonio_bien_dos = ref('')
const descripcion_bien_tres = ref('')
const ciudad_bien_tres = ref('')
const hipoteca_bien_tres = ref('')
const avaluo_comercial_bien_tres = ref('')
const avaluo_catastral_bien_tres = ref('')
const cedula_catastral_bien_tres = ref('')
const matricula_bien_tres = ref('')
const escritura_bien_tres = ref('')
const notaria_bien_tres = ref('')
const fecha_bien_tres = ref('')
const ciudad_parimonio_bien_tres = ref('')
const marca_vehiculo = ref('')
const clase_vehiculo = ref('')
const modelo_vehiculo = ref('')
const placa_vehiculo = ref('')
const valor_vehiculo = ref('')
const hipoteca_vehiculo = ref('')
const marca_vehiculo_dos = ref('')
const clase_vehiculo_dos = ref('')
const modelo_vehiculo_dos = ref('')
const placa_vehiculo_dos = ref('')
const valor_vehiculo_dos = ref('')
const hipoteca_vehiculo_dos = ref('')

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

const url_img = ref([])
const url_img_dos = ref([])

const rellenar = (item) => {
    console.log(item)

    direccion_pers.value = item.direccion_pers
    telefono.value = item.telefono
    estado_civil.value = item.estado_civil
    edad.value = item.edad
    domicilio.value = item.domicilio
    direccion_comercial.value = item.direccion_comercial
    telefono_comercial.value = item.telefono_comercial
    direccion_judicial.value = item.direccion_judicial
    telefono_judicial.value = item.telefono_judicial
    representante.value = item.representante
    representante_doc.value = item.representante_doc
    tipo_cliente.value = item.tipo_cliente
    autorretenedor.value = item.autorretenedor
    persona_pago.value = item.persona_pago
    direccion_pago.value = item.direccion_pago
    telefono_pago.value = item.telefono_pago
    dia_pago.value = item.dia_pago
    hora_pago.value = item.hora_pago
    comentatio_pago.value = item.comentatio_pago
    direccion_recidencia.value = item.direccion_recidencia
    telefono_recidencia.value = item.telefono_recidencia
    ciudad_recidencia.value = item.ciudad_recidencia
    empresa_direccion.value = item.empresa_direccion
    empresa_telefono.value = item.empresa_telefono
    cargo_actual.value = item.cargo_actual
    antoguedad_empresa.value = item.antoguedad_empresa
    personas_cargo.value = item.personas_cargo
    vivienda.value = item.vivienda
    camara_comercio.value = item.camara_comercio
    profesion.value = item.profesion
    empresa.value = item.empresa
    nombre_negocio.value = item.nombre_negocio
    nombre_conyuge.value = item.nombre_conyuge
    independiente.value = item.independiente
    ocupacion_conyuge.value = item.ocupacion_conyuge
    empresa_conyuge.value = item.empresa_conyuge

    banco.value = item.referencias.banco == null ? '' : item.referencias.banco
    sucursal.value = item.referencias.sucursal == null ? '' : item.referencias.sucursal
    banco_numero.value = item.referencias.banco_numero == null ? '' : item.referencias.banco_numero
    banco_dos.value = item.referencias.banco_dos == null ? '' : item.referencias.banco_dos
    sucursal_dos.value = item.referencias.sucursal_dos == null ? '' : item.referencias.sucursal_dos
    banco_numero_dos.value = item.referencias.banco_numero_dos == null ? '' : item.referencias.banco_numero_dos
    nombre_comercal.value = item.referencias.nombre_comercal == null ? '' : item.referencias.nombre_comercal
    direccion_comercal.value = item.referencias.direccion_comercal == null ? '' : item.referencias.direccion_comercal
    telefono_comercal.value = item.referencias.telefono_comercal == null ? '' : item.referencias.telefono_comercal
    nombre_comercal_dos.value = item.referencias.nombre_comercal_dos == null ? '' : item.referencias.nombre_comercal_dos
    direccion_comercal_dos.value = item.referencias.direccion_comercal_dos == null ? '' : item.referencias.direccion_comercal_dos
    telefono_comercal_dos.value = item.referencias.telefono_comercal_dos == null ? '' : item.referencias.telefono_comercal_dos
    nombre_familiar.value = item.referencias.nombre_familiar == null ? '' : item.referencias.nombre_familiar
    direccion_familiar.value = item.referencias.direccion_familiar == null ? '' : item.referencias.direccion_familiar
    telefono_familiar.value = item.referencias.telefono_familiar == null ? '' : item.referencias.telefono_familiar
    nombre_familiar_dos.value = item.referencias.nombre_familiar_dos == null ? '' : item.referencias.nombre_familiar_dos
    direccion_familiar_dos.value = item.referencias.direccion_familiar_dos == null ? '' : item.referencias.direccion_familiar_dos
    telefono_familiar_dos.value = item.referencias.telefono_familiar_dos == null ? '' : item.referencias.telefono_familiar_dos

    tipo_credito.value = item.linea.tipo_credito == null ? '' : item.linea.tipo_credito
    oficina_credito.value = item.linea.oficina_credito == null ? '' : item.linea.oficina_credito
    vendedor_credito.value = item.linea.vendedor_credito == null ? '' : item.linea.vendedor_credito
    monto_solicitado_credito.value = item.linea.monto_solicitado_credito == null ? '' : item.linea.monto_solicitado_credito
    forma_pago_credito.value = item.linea.forma_pago_credito == null ? '' : item.linea.forma_pago_credito

    descripcion_bien.value = item.parimonio.descripcion_bien == null ? '' : item.parimonio.descripcion_bien
    ciudad_bien.value = item.parimonio.ciudad_bien == null ? '' : item.parimonio.ciudad_bien
    hipoteca_bien.value = item.parimonio.hipoteca_bien == null ? '' : item.parimonio.hipoteca_bien
    avaluo_comercial_bien.value = item.parimonio.avaluo_comercial_bien == null ? '' : item.parimonio.avaluo_comercial_bien
    avaluo_catastral_bien.value = item.parimonio.avaluo_catastral_bien == null ? '' : item.parimonio.avaluo_catastral_bien
    cedula_catastral_bien.value = item.parimonio.cedula_catastral_bien == null ? '' : item.parimonio.cedula_catastral_bien
    matricula_bien.value = item.parimonio.matricula_bien == null ? '' : item.parimonio.matricula_bien
    escritura_bien.value = item.parimonio.escritura_bien == null ? '' : item.parimonio.escritura_bien
    notaria_bien.value = item.parimonio.notaria_bien == null ? '' : item.parimonio.notaria_bien
    fecha_bien.value = item.parimonio.fecha_bien == null ? '' : item.parimonio.fecha_bien
    ciudad_parimonio_bien.value = item.parimonio.ciudad_parimonio_bien == null ? '' : item.parimonio.ciudad_parimonio_bien
    descripcion_bien_dos.value = item.parimonio.descripcion_bien_dos == null ? '' : item.parimonio.descripcion_bien_dos
    ciudad_bien_dos.value = item.parimonio.ciudad_bien_dos == null ? '' : item.parimonio.ciudad_bien_dos
    hipoteca_bien_dos.value = item.parimonio.hipoteca_bien_dos == null ? '' : item.parimonio.hipoteca_bien_dos
    avaluo_comercial_bien_dos.value = item.parimonio.avaluo_comercial_bien_dos == null ? '' : item.parimonio.avaluo_comercial_bien_dos
    avaluo_catastral_bien_dos.value = item.parimonio.avaluo_catastral_bien_dos == null ? '' : item.parimonio.avaluo_catastral_bien_dos
    cedula_catastral_bien_dos.value = item.parimonio.cedula_catastral_bien_dos == null ? '' : item.parimonio.cedula_catastral_bien_dos
    matricula_bien_dos.value = item.parimonio.matricula_bien_dos == null ? '' : item.parimonio.matricula_bien_dos
    escritura_bien_dos.value = item.parimonio.escritura_bien_dos == null ? '' : item.parimonio.escritura_bien_dos
    notaria_bien_dos.value = item.parimonio.notaria_bien_dos == null ? '' : item.parimonio.notaria_bien_dos
    fecha_bien_dos.value = item.parimonio.fecha_bien_dos == null ? '' : item.parimonio.fecha_bien_dos
    ciudad_parimonio_bien_dos.value = item.parimonio.ciudad_parimonio_bien_dos == null ? '' : item.parimonio.ciudad_parimonio_bien_dos
    descripcion_bien_tres.value = item.parimonio.descripcion_bien_tres == null ? '' : item.parimonio.descripcion_bien_tres
    ciudad_bien_tres.value = item.parimonio.ciudad_bien_tres == null ? '' : item.parimonio.ciudad_bien_tres
    hipoteca_bien_tres.value = item.parimonio.hipoteca_bien_tres == null ? '' : item.parimonio.hipoteca_bien_tres
    avaluo_comercial_bien_tres.value = item.parimonio.avaluo_comercial_bien_tres == null ? '' : item.parimonio.avaluo_comercial_bien_tres
    avaluo_catastral_bien_tres.value = item.parimonio.avaluo_catastral_bien_tres == null ? '' : item.parimonio.avaluo_catastral_bien_tres
    cedula_catastral_bien_tres.value = item.parimonio.cedula_catastral_bien_tres == null ? '' : item.parimonio.cedula_catastral_bien_tres
    matricula_bien_tres.value = item.parimonio.matricula_bien_tres == null ? '' : item.parimonio.matricula_bien_tres
    escritura_bien_tres.value = item.parimonio.escritura_bien_tres == null ? '' : item.parimonio.escritura_bien_tres
    notaria_bien_tres.value = item.parimonio.notaria_bien_tres == null ? '' : item.parimonio.notaria_bien_tres
    fecha_bien_tres.value = item.parimonio.fecha_bien_tres == null ? '' : item.parimonio.fecha_bien_tres
    ciudad_parimonio_bien_tres.value = item.parimonio.ciudad_parimonio_bien_tres == null ? '' : item.parimonio.ciudad_parimonio_bien_tres
    marca_vehiculo.value = item.parimonio.marca_vehiculo == null ? '' : item.parimonio.marca_vehiculo
    clase_vehiculo.value = item.parimonio.clase_vehiculo == null ? '' : item.parimonio.clase_vehiculo
    modelo_vehiculo.value = item.parimonio.modelo_vehiculo == null ? '' : item.parimonio.modelo_vehiculo
    placa_vehiculo.value = item.parimonio.placa_vehiculo == null ? '' : item.parimonio.placa_vehiculo
    valor_vehiculo.value = item.parimonio.valor_vehiculo == null ? '' : item.parimonio.valor_vehiculo
    hipoteca_vehiculo.value = item.parimonio.hipoteca_vehiculo == null ? '' : item.parimonio.hipoteca_vehiculo
    marca_vehiculo_dos.value = item.parimonio.marca_vehiculo_dos == null ? '' : item.parimonio.marca_vehiculo_dos
    clase_vehiculo_dos.value = item.parimonio.clase_vehiculo_dos == null ? '' : item.parimonio.clase_vehiculo_dos
    modelo_vehiculo_dos.value = item.parimonio.modelo_vehiculo_dos == null ? '' : item.parimonio.modelo_vehiculo_dos
    placa_vehiculo_dos.value = item.parimonio.placa_vehiculo_dos == null ? '' : item.parimonio.placa_vehiculo_dos
    valor_vehiculo_dos.value = item.parimonio.valor_vehiculo_dos == null ? '' : item.parimonio.valor_vehiculo_dos
    hipoteca_vehiculo_dos.value = item.parimonio.hipoteca_vehiculo_dos == null ? '' : item.parimonio.hipoteca_vehiculo_dos

    salario.value = item.ingreso.salario == null ? '' : item.ingreso.salario
    honorarios.value = item.ingreso.honorarios == null ? '' : item.ingreso.honorarios
    otros_ingresos.value = item.ingreso.otros_ingresos == null ? '' : item.ingreso.otros_ingresos
    otros_ingresos_describe.value = item.ingreso.otros_ingresos_describe == null ? '' : item.ingreso.otros_ingresos_describe
    total_ingresos.value = item.ingreso.total_ingresos == null ? '' : item.ingreso.total_ingresos
    alquiler.value = item.ingreso.alquiler == null ? '' : item.ingreso.alquiler
    amortizacion.value = item.ingreso.amortizacion == null ? '' : item.ingreso.amortizacion
    amortizacion_hipoteca.value = item.ingreso.amortizacion_hipoteca == null ? '' : item.ingreso.amortizacion_hipoteca
    pago_tarjetas.value = item.ingreso.pago_tarjetas == null ? '' : item.ingreso.pago_tarjetas
    otros_gastos.value = item.ingreso.otros_gastos == null ? '' : item.ingreso.otros_gastos
    total_egresos.value = item.ingreso.total_egresos == null ? '' : item.ingreso.total_egresos

    acreedor.value = item.creditos.acreedor == null ? '' : item.creditos.acreedor
    acreedor_dos.value = item.creditos.acreedor_dos == null ? '' : item.creditos.acreedor_dos
    acreedor_telefono.value = item.creditos.acreedor_telefono == null ? '' : item.creditos.acreedor_telefono
    acreedor_telefono_dos.value = item.creditos.acreedor_telefono_dos == null ? '' : item.creditos.acreedor_telefono_dos
    acreedor_valor.value = item.creditos.acreedor_valor == null ? '' : item.creditos.acreedor_valor
    acreedor_valor_dos.value = item.creditos.acreedor_valor_dos == null ? '' : item.creditos.acreedor_valor_dos
    acreedor_saldo.value = item.creditos.acreedor_saldo == null ? '' : item.creditos.acreedor_saldo
    acreedor_saldo_dos.value = item.creditos.acreedor_saldo_dos == null ? '' : item.creditos.acreedor_saldo_dos
    banco_tarjeta.value = item.creditos.banco_tarjeta == null ? '' : item.creditos.banco_tarjeta
    banco_tarjeta_dos.value = item.creditos.banco_tarjeta_dos == null ? '' : item.creditos.banco_tarjeta_dos
    banco_antoguedad.value = item.creditos.banco_antoguedad == null ? '' : item.creditos.banco_antoguedad
    banco_antoguedad_dos.value = item.creditos.banco_antoguedad_dos == null ? '' : item.creditos.banco_antoguedad_dos
    banco_numero_antoguedad.value = item.creditos.banco_numero_antoguedad == null ? '' : item.creditos.banco_numero_antoguedad
    banco_numero_antoguedad_dos.value = item.creditos.banco_numero_antoguedad_dos == null ? '' : item.creditos.banco_numero_antoguedad_dos
    banco_cupo.value = item.creditos.banco_cupo == null ? '' : item.creditos.banco_cupo
    banco_cupo_dos.value = item.creditos.banco_cupo_dos == null ? '' : item.creditos.banco_cupo_dos

}

const return_index = () => {
    window.history.back();
}

const select_file = (e) => {
    url_img.value = e.target.files[0]
    let reader = new FileReader()
    reader.readAsDataURL(url_img.value)
    reader.onload = () => {
        let preview = document.getElementById('preview');
        let image = document.getElementById('img');
        image.src = reader.result;
        preview.append(image);
    }
}

const select_file_dos = (e) => {
    url_img_dos.value = e.target.files[0]
    let reader = new FileReader()
    reader.readAsDataURL(url_img_dos.value)
    reader.onload = () => {
        let preview = document.getElementById('preview_dos');
        let image = document.getElementById('img_dos');
        image.src = reader.result;
        preview.append(image);
    }
}


const saveCredito = () => {

    if (tipo_documento.value.length == 0) return
    if (documento.value.length == 0) return
    if (nombre.value.length == 0) return


    let form = new FormData()

    form.append('id', producto.value.id)

    form.append('edad', edad.value)
    form.append('domicilio', domicilio.value)
    form.append('direccion_pers', direccion_pers.value)
    form.append('telefono', telefono.value)
    form.append('direccion_comercial', direccion_comercial.value)
    form.append('telefono_comercial', telefono_comercial.value)
    form.append('direccion_judicial', direccion_judicial.value)
    form.append('telefono_judicial', telefono_judicial.value)
    form.append('representante', representante.value)
    form.append('representante_doc', representante_doc.value)
    form.append('tipo_cliente', tipo_cliente.value)
    form.append('autorretenedor', autorretenedor.value)
    form.append('persona_pago', persona_pago.value)
    form.append('direccion_pago', direccion_pago.value)
    form.append('telefono_pago', telefono_pago.value)
    form.append('dia_pago', dia_pago.value)
    form.append('hora_pago', hora_pago.value)
    form.append('comentatio_pago', comentatio_pago.value)
    form.append('estado_civil', estado_civil.value)
    form.append('direccion_recidencia', direccion_recidencia.value)
    form.append('telefono_recidencia', telefono_recidencia.value)
    form.append('ciudad_recidencia', ciudad_recidencia.value)
    form.append('empresa_direccion', empresa_direccion.value)
    form.append('empresa_telefono', empresa_telefono.value)
    form.append('cargo_actual', cargo_actual.value)
    form.append('antoguedad_empresa', antoguedad_empresa.value)
    form.append('personas_cargo', personas_cargo.value)
    form.append('vivienda', vivienda.value)
    form.append('camara_comercio', camara_comercio.value)
    form.append('banco', banco.value)
    form.append('sucursal', sucursal.value)
    form.append('banco_numero', banco_numero.value)
    form.append('banco_dos', banco_dos.value)
    form.append('sucursal_dos', sucursal_dos.value)
    form.append('banco_numero_dos', banco_numero_dos.value)
    form.append('tipo_direccion', tipo_direccion.value)
    form.append('direccion', direccion.value)
    form.append('ciudad', ciudad.value)
    form.append('departamento', departamento.value)
    form.append('nombre_conyuge', nombre_conyuge.value)
    form.append('independiente', independiente.value)
    form.append('ocupacion_conyuge', ocupacion_conyuge.value)
    form.append('empresa_conyuge', empresa_conyuge.value)

    form.append('ciudad_solicitud', ciudad_solicitud.value)
    form.append('tipo_declarante', tipo_declarante.value)
    form.append('profesion', profesion.value)
    form.append('empresa', empresa.value)
    form.append('nombre_negocio', nombre_negocio.value)
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
    form.append('tipo_credito', tipo_credito.value)
    form.append('oficina_credito', oficina_credito.value)
    form.append('vendedor_credito', vendedor_credito.value)
    form.append('monto_solicitado_credito', monto_solicitado_credito.value)
    form.append('forma_pago_credito', forma_pago_credito.value)
    form.append('descripcion_bien', descripcion_bien.value)
    form.append('ciudad_bien', ciudad_bien.value)
    form.append('hipoteca_bien', hipoteca_bien.value)
    form.append('avaluo_comercial_bien', avaluo_comercial_bien.value)
    form.append('avaluo_catastral_bien', avaluo_catastral_bien.value)
    form.append('cedula_catastral_bien', cedula_catastral_bien.value)
    form.append('matricula_bien', matricula_bien.value)
    form.append('escritura_bien', escritura_bien.value)
    form.append('notaria_bien', notaria_bien.value)
    form.append('fecha_bien', fecha_bien.value)
    form.append('ciudad_parimonio_bien', ciudad_parimonio_bien.value)
    form.append('descripcion_bien_dos', descripcion_bien_dos.value)
    form.append('ciudad_bien_dos', ciudad_bien_dos.value)
    form.append('hipoteca_bien_dos', hipoteca_bien_dos.value)
    form.append('avaluo_comercial_bien_dos', avaluo_comercial_bien_dos.value)
    form.append('avaluo_catastral_bien_dos', avaluo_catastral_bien_dos.value)
    form.append('cedula_catastral_bien_dos', cedula_catastral_bien_dos.value)
    form.append('matricula_bien_dos', matricula_bien_dos.value)
    form.append('escritura_bien_dos', escritura_bien_dos.value)
    form.append('notaria_bien_dos', notaria_bien_dos.value)
    form.append('fecha_bien_dos', fecha_bien_dos.value)
    form.append('ciudad_parimonio_bien_dos', ciudad_parimonio_bien_dos.value)
    form.append('descripcion_bien_tres', descripcion_bien_tres.value)
    form.append('ciudad_bien_tres', ciudad_bien_tres.value)
    form.append('hipoteca_bien_tres', hipoteca_bien_tres.value)
    form.append('avaluo_comercial_bien_tres', avaluo_comercial_bien_tres.value)
    form.append('avaluo_catastral_bien_tres', avaluo_catastral_bien_tres.value)
    form.append('cedula_catastral_bien_tres', cedula_catastral_bien_tres.value)
    form.append('matricula_bien_tres', matricula_bien_tres.value)
    form.append('escritura_bien_tres', escritura_bien_tres.value)
    form.append('notaria_bien_tres', notaria_bien_tres.value)
    form.append('fecha_bien_tres', fecha_bien_tres.value)
    form.append('ciudad_parimonio_bien_tres', ciudad_parimonio_bien_tres.value)
    form.append('marca_vehiculo', marca_vehiculo.value)
    form.append('clase_vehiculo', clase_vehiculo.value)
    form.append('modelo_vehiculo', modelo_vehiculo.value)
    form.append('placa_vehiculo', placa_vehiculo.value)
    form.append('valor_vehiculo', valor_vehiculo.value)
    form.append('hipoteca_vehiculo', hipoteca_vehiculo.value)
    form.append('marca_vehiculo_dos', marca_vehiculo_dos.value)
    form.append('clase_vehiculo_dos', clase_vehiculo_dos.value)
    form.append('modelo_vehiculo_dos', modelo_vehiculo_dos.value)
    form.append('placa_vehiculo_dos', placa_vehiculo_dos.value)
    form.append('valor_vehiculo_dos', valor_vehiculo_dos.value)
    form.append('hipoteca_vehiculo_dos', hipoteca_vehiculo_dos.value)
    form.append('salario', salario.value)
    form.append('honorarios', honorarios.value)
    form.append('otros_ingresos', otros_ingresos.value)
    form.append('otros_ingresos_describe', otros_ingresos_describe.value)
    form.append('total_ingresos', total_ingresos.value)
    form.append('alquiler', alquiler.value)
    form.append('amortizacion', amortizacion.value)
    form.append('amortizacion_hipoteca', amortizacion_hipoteca.value)
    form.append('pago_tarjetas', pago_tarjetas.value)
    form.append('otros_gastos', otros_gastos.value)
    form.append('total_egresos', total_egresos.value)
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
    form.append('url_img', url_img.value)
    form.append('url_img_dos', url_img_dos.value)

    axios.post('/primera-solicitud', form).then(({ data }) => {

        // Swal.fire({
        //     icon: 'success',
        //     title: 'Registro creado con exito'
        // })

        // creado.value = false
    })
}

const updateStateSolicitud = (valor) => {
    axios.put('/update-solicitud/' + producto.value.id, { accion: valor }).then(({ data }) => {
        Swal.fire({
            icon: 'success',
            title: 'Solicitud realizada'
        })
    })
}

const mostrarUno = () => {
    mostrar.value = true
}

const mostrarDos = () => {
    mostrar_dos.value = true
}

const mostrarVeliculo = () => {
    mostrar_vehoculo.value = true
}

</script>

<template>
    <LayoutCLient>
        <div class="row">

            <div class="col-lg-12 mt-4">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-plus"></i>
                            Informacion necesaria para la solicitud
                        </h3>
                        <div class="card-tools">
                            <button @click='return_index()' class='btn btn-xs bg-gray'>
                                <i class='fas fa-reply'></i> Regresar
                            </button>
                        </div>
                        <br>
                        Todos los campos con (<span class="text-danger"> * </span>) son obligatorios, para un registro
                        correcto.
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <fieldset class="bordesito">
                                <legend v-if="tipo_documento == 'NIT'" class="bordesito">Persona juridica</legend>
                                <legend v-else class="bordesito">Persona natural</legend>
                                <div class="row">

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-12">
                                        <label v-if="tipo_documento == 'NIT'">Nombre o Razón social <span
                                                class="text-danger">
                                                *</span></label>

                                        <label v-else>Nombre o Razón social <span class="text-danger">
                                                *</span></label>
                                        <input v-model="nombre" type="text" class="form-control" id="documento"
                                            aria-describedby="documento" autocomplete="off">
                                        <div v-if="nombre == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="tipo_documento">Tipo de Identificación <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="tipo_documento">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="CC">CC</option>
                                            <option value="NIT">NIT</option>
                                        </select>

                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Nit <span class="text-danger">
                                                *</span></label>
                                        <input v-model="documento" type="text" class="form-control" id="documento"
                                            aria-describedby="documento" autocomplete="off">
                                        <div v-if="documento == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="documento">Cédula No <span class="text-danger">
                                                *</span></label>
                                        <input v-model="documento" type="text" class="form-control" id="documento"
                                            aria-describedby="documento" autocomplete="off">
                                        <div v-if="documento == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Edad <span class="text-danger">
                                                *</span></label>
                                        <input v-model="edad" type="text" class="form-control" id="edad"
                                            aria-describedby="edad" autocomplete="off">
                                        <div v-if="edad == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Estado Civil <span class="text-danger">
                                                *</span></label>
                                        <input v-model="estado_civil" type="text" class="form-control" id="estado_civil"
                                            aria-describedby="estado_civil" autocomplete="off" @change="saveCredito" />
                                        <div v-if="estado_civil == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Domicilio <span class="text-danger">
                                                *</span></label>
                                        <input v-model="domicilio" type="text" class="form-control" id="domicilio"
                                            aria-describedby="documento" autocomplete="off" @change="saveCredito">
                                        <div v-if="domicilio == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-8">
                                        <label for="documento">Dirección comercial <span class="text-danger">
                                                *</span></label>
                                        <input v-model="direccion_comercial" type="text" class="form-control"
                                            id="direccion_comercial" aria-describedby="documento" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="direccion_comercial == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Teléfono <span class="text-danger">
                                                *</span></label>
                                        <input v-model="telefono_comercial" type="text" class="form-control"
                                            id="telefono_comercial" aria-describedby="documento" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="telefono_comercial == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-8">
                                        <label for="documento">Dirección Judicial <span class="text-danger">
                                                *</span></label>
                                        <input v-model="direccion_judicial" type="text" class="form-control"
                                            id="direccion_judicial" aria-describedby="documento" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="direccion_judicial == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Teléfono <span class="text-danger">
                                                *</span></label>
                                        <input v-model="telefono_judicial" type="text" class="form-control"
                                            id="telefono_judicial" aria-describedby="documento" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="telefono_judicial == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Dirección de Residencia <span class="text-danger">
                                                *</span></label>
                                        <input v-model="direccion_recidencia" type="text" class="form-control"
                                            id="direccion_recidencia" aria-describedby="direccion_recidencia"
                                            autocomplete="off" @change="saveCredito">
                                        <div v-if="direccion_recidencia == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Teléfono <span class="text-danger">
                                                *</span></label>
                                        <input v-model="telefono_recidencia" type="text" class="form-control"
                                            id="telefono_recidencia" aria-describedby="telefono_recidencia"
                                            autocomplete="off" @change="saveCredito">
                                        <div v-if="telefono_recidencia == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-6">
                                        <label for="edad">Cuidad y Dept. <span class="text-danger">
                                                *</span></label>
                                        <input v-model="ciudad_recidencia" type="text" class="form-control"
                                            id="ciudad_recidencia" aria-describedby="ciudad_recidencia"
                                            autocomplete="off" @change="saveCredito">
                                        <div v-if="ciudad_recidencia == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="documento">Correo electrónico <span class="text-danger">
                                                *</span></label>
                                        <input v-model="email" type="email" class="form-control" id="telefono_judicial"
                                            aria-describedby="email" autocomplete="off" @change="saveCredito">
                                        <div v-if="email == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-8">
                                        <label for="documento">Dirección <span class="text-danger">
                                                *</span></label>
                                        <input v-model="direccion_pers" type="text" class="form-control"
                                            id="telefono_judicial" aria-describedby="direccion_pers" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="direccion_pers == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="documento">Teléfono <span class="text-danger">
                                                *</span></label>
                                        <input v-model="telefono" type="text" class="form-control" id="telefono"
                                            aria-describedby="documento" autocomplete="off" @change="saveCredito">
                                        <div v-if="telefono == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Profesión <span class="text-danger">
                                                *</span></label>
                                        <input v-model="profesion" type="text" class="form-control" id="profesion"
                                            aria-describedby="profesion" autocomplete="off" @change="saveCredito">
                                        <div v-if="profesion == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Empresa donde trabaja<span class="text-danger">
                                                *</span></label>
                                        <input v-model="empresa" type="text" class="form-control" id="empresa"
                                            aria-describedby="empresa" autocomplete="off" @change="saveCredito">
                                        <div v-if="empresa == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Dirección y ciudada<span class="text-danger">
                                                *</span></label>
                                        <input v-model="empresa_direccion" type="text" class="form-control"
                                            id="empresa_direccion" aria-describedby="empresa_direccion"
                                            autocomplete="off" @change="saveCredito">
                                        <div v-if="empresa_direccion == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Teléfono<span class="text-danger">
                                                *</span></label>
                                        <input v-model="empresa_telefono" type="text" class="form-control"
                                            id="empresa_telefono" aria-describedby="empresa_telefono" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="empresa_telefono == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Cargo Actual<span class="text-danger">
                                                *</span></label>
                                        <input v-model="cargo_actual" type="text" class="form-control" id="cargo_actual"
                                            aria-describedby="cargo_actual" autocomplete="off" @change="saveCredito">
                                        <div v-if="cargo_actual == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Antigüedad de la Empresa<span class="text-danger">
                                                *</span></label>
                                        <input v-model="antoguedad_empresa" type="text" class="form-control"
                                            id="antoguedad_empresa" aria-describedby="antoguedad_empresa"
                                            autocomplete="off" @change="saveCredito">
                                        <div v-if="antoguedad_empresa == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">No. Personas a Cargo<span class="text-danger">
                                                *</span></label>
                                        <input v-model="personas_cargo" type="text" class="form-control"
                                            id="personas_cargo" aria-describedby="personas_cargo" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="personas_cargo == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Vivienda<span class="text-danger">
                                                *</span></label>
                                        <input v-model="vivienda" type="text" class="form-control" id="vivienda"
                                            aria-describedby="vivienda" autocomplete="off" @change="saveCredito">
                                        <div v-if="vivienda == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="documento">Es independiente? <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="independiente"
                                            @change="saveCredito">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="documento">Tiene Negocio Registrado en Cámara? <span
                                                class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="camara_comercio"
                                            @change="saveCredito">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Nombre del Negocio Registrado<span class="text-danger">
                                                *</span></label>
                                        <input v-model="nombre_negocio" type="text" class="form-control"
                                            id="nombre_negocio" aria-describedby="nombre_negocio" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="nombre_negocio == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Nombre del Cónyuge<span class="text-danger">
                                                *</span></label>
                                        <input v-model="nombre_conyuge" type="text" class="form-control"
                                            id="nombre_conyuge" aria-describedby="nombre_conyuge" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="nombre_conyuge == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Ocupación<span class="text-danger">
                                                *</span></label>
                                        <input v-model="ocupacion_conyuge" type="text" class="form-control"
                                            id="ocupacion_conyuge" aria-describedby="ocupacion_conyuge"
                                            autocomplete="off" @change="saveCredito">
                                        <div v-if="ocupacion_conyuge == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'CC'" class="form-group col-4">
                                        <label for="edad">Empresa<span class="text-danger">
                                                *</span></label>
                                        <input v-model="empresa_conyuge" type="text" class="form-control"
                                            id="empresa_conyuge" aria-describedby="empresa_conyuge" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="empresa_conyuge == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Representante Legal <span class="text-danger">
                                                *</span></label>
                                        <input v-model="representante" type="text" class="form-control"
                                            id="representante" aria-describedby="documento" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="representante == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Cédula No. <span class="text-danger">
                                                *</span></label>
                                        <input v-model="representante_doc" type="text" class="form-control"
                                            id="representante_doc" aria-describedby="representante_doc"
                                            autocomplete="off" @change="saveCredito">
                                        <div v-if="representante_doc == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Tipo de Cliente <span class="text-danger">
                                                *</span></label>
                                        <input v-model="tipo_cliente" type="text" class="form-control" id="tipo_cliente"
                                            aria-describedby="tipo_cliente" autocomplete="off" @change="saveCredito">
                                        <div v-if="tipo_cliente == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Que tipo de Declarante es? <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="tipo_declarante"
                                            @change="saveCredito">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Empresa Estatal">Empresa Estatal</option>
                                            <option value="Régimen Común">Régimen Común</option>
                                            <option value="Régimen Simplificado">Régimen Simplificado</option>
                                            <option value="No Responsable de IVA">No Responsable de IVA</option>
                                            <option value="Gran Contribuyente">Gran Contribuyente</option>
                                        </select>
                                    </div>


                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-4">
                                        <label for="documento">Autorretenedor <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="autorretenedor"
                                            @change="saveCredito">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>


                                    <hr class="col-11">

                                    <h4 class="col-12">Pago en</h4>


                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-12">
                                        <label for="documento">Persona que autoriza los Pagos <span class="text-danger">
                                                *</span></label>
                                        <input v-model="persona_pago" type="text" class="form-control" id="persona_pago"
                                            aria-describedby="persona_pago" autocomplete="off" @change="saveCredito">
                                        <div v-if="persona_pago == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-8">
                                        <label for="documento">Dirección y ciudad donde se realizarán los pagos<span
                                                class="text-danger">
                                                *</span></label>
                                        <input v-model="direccion_pago" type="text" class="form-control"
                                            id="direccion_pago" aria-describedby="direccion_pago" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="direccion_pago == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="documento">Teléfono<span class="text-danger">
                                                *</span></label>
                                        <input v-model="telefono_pago" type="text" class="form-control"
                                            id="direccion_pago" aria-describedby="direccion_pago" autocomplete="off"
                                            @change="saveCredito">
                                        <div v-if="direccion_pago == ''" class="invalid-feedback d-block">El
                                            campo es
                                            requerido
                                        </div>
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-6">
                                        <label for="dia_pago">Dia de Pago</label>
                                        <input v-model="dia_pago" type="text" class="form-control" id="dia_pago"
                                            aria-describedby="dia_pago" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-6">
                                        <label for="hora_pago">Horario de Pago</label>
                                        <input v-model="hora_pago" type="text" class="form-control" id="hora_pago"
                                            aria-describedby="hora_pago" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div v-if="tipo_documento == 'NIT'" class="form-group col-12">
                                        <label for="comentatio_pago">Comentario Adicional</label>
                                        <input v-model="comentatio_pago" type="text" class="form-control"
                                            id="comentatio_pago" aria-describedby="comentatio_pago" autocomplete="off"
                                            @change="saveCredito">
                                    </div>


                                </div>

                            </fieldset>

                            <fieldset class="bordesito">
                                <legend class="bordesito">Referencias</legend>
                                <div class="row">

                                    <h4 class="col-12">BANCARIA</h4>

                                    <div class="form-group col-4">
                                        <label for="hora_pago">Banco</label>
                                        <input v-model="banco" type="text" class="form-control" id="banco"
                                            aria-describedby="banco" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="hora_pago">Sucursal</label>
                                        <input v-model="sucursal" type="text" class="form-control" id="sucursal"
                                            aria-describedby="sucursal" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="hora_pago">Cta. Cte. No.</label>
                                        <input v-model="banco_numero" type="text" class="form-control" id="banco_numero"
                                            aria-describedby="banco_numero" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="hora_pago">Banco</label>
                                        <input v-model="banco_dos" type="text" class="form-control" id="banco_dos"
                                            aria-describedby="banco_dos" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="hora_pago">Sucursal</label>
                                        <input v-model="sucursal_dos" type="text" class="form-control" id="sucursal_dos"
                                            aria-describedby="sucursal_dos" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="hora_pago">Cta. Cte. No.</label>
                                        <input v-model="banco_numero_dos" type="text" class="form-control"
                                            id="banco_numero_dos" aria-describedby="banco_numero_dos" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <h4 class="col-12 mt-4">COMERCIAL</h4>

                                    <div class="form-group col-4">
                                        <label for="hora_pago">Nombre</label>
                                        <input v-model="nombre_comercal" type="text" class="form-control"
                                            id="nombre_comercal" aria-describedby="nombre_comercal" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-5">
                                        <label for="hora_pago">Dirección y Ciudad</label>
                                        <input v-model="direccion_comercal" type="text" class="form-control"
                                            id="direccion_comercal" aria-describedby="direccion_comercal"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-3">
                                        <label for="hora_pago">Teléfono</label>
                                        <input v-model="telefono_comercal" type="text" class="form-control"
                                            id="telefono_comercal" aria-describedby="telefono_comercal"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="hora_pago">Nombre</label>
                                        <input v-model="nombre_comercal_dos" type="text" class="form-control"
                                            id="nombre_comercal_dos" aria-describedby="nombre_comercal"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-5">
                                        <label for="hora_pago">Dirección y Ciudad</label>
                                        <input v-model="direccion_comercal_dos" type="text" class="form-control"
                                            id="direccion_comercal_dos" aria-describedby="direccion_comercal_dos"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-3">
                                        <label for="hora_pago">Teléfono</label>
                                        <input v-model="telefono_comercal_dos" type="text" class="form-control"
                                            id="telefono_comercal_dos" aria-describedby="telefono_comercal_dos"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <h4 class="col-12 mt-4">FAMILIAR</h4>

                                    <div class="form-group col-4">
                                        <label for="hora_pago">Nombre</label>
                                        <input v-model="nombre_familiar" type="text" class="form-control"
                                            id="nombre_familiar" aria-describedby="nombre_familiar" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-5">
                                        <label for="hora_pago">Dirección y Ciudad</label>
                                        <input v-model="direccion_familiar" type="text" class="form-control"
                                            id="direccion_familiar" aria-describedby="direccion_familiar"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-3">
                                        <label for="hora_pago">Teléfono</label>
                                        <input v-model="telefono_familiar" type="text" class="form-control"
                                            id="telefono_familiar" aria-describedby="telefono_familiar"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="hora_pago">Nombre</label>
                                        <input v-model="nombre_familiar_dos" type="text" class="form-control"
                                            id="nombre_familiar_dos" aria-describedby="nombre_familiar"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-5">
                                        <label for="hora_pago">Dirección y Ciudad</label>
                                        <input v-model="direccion_familiar_dos" type="text" class="form-control"
                                            id="direccion_familiar_dos" aria-describedby="direccion_familiar_dos"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-3">
                                        <label for="hora_pago">Teléfono</label>
                                        <input v-model="telefono_familiar_dos" type="text" class="form-control"
                                            id="telefono_familiar_dos" aria-describedby="telefono_familiar_dos"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                </div>
                            </fieldset>

                            <fieldset class="bordesito" style="width: 100%;">
                                <legend class="bordesito">Linea de crédito</legend>
                                <div class="row">

                                    <div class="form-group col-4">
                                        <label for="documento">Tipo linea crédito <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="tipo_credito"
                                            @change="saveCredito">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Rotativo">Rotativo</option>
                                            <option value="Cupo">Cupo</option>
                                            <option value="Adquisición">Adquisición</option>
                                            <option value="Maquinaria">Maquinaria</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="oficina_credito">Oficina</label>
                                        <input v-model="oficina_credito" type="text" class="form-control"
                                            id="oficina_credito" aria-describedby="oficina_credito" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="oficina_credito">Vendedor</label>
                                        <input v-model="vendedor_credito" type="text" class="form-control"
                                            id="vendedor_credito" aria-describedby="vendedor_credito" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="oficina_credito">Monto Solicitado</label>
                                        <input v-model="monto_solicitado_credito" type="text" class="form-control"
                                            id="monto_solicitado_credito" aria-describedby="monto_solicitado_credito"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="oficina_credito">Forma de Pago</label>
                                        <input v-model="forma_pago_credito" type="text" class="form-control"
                                            id="forma_pago_credito" aria-describedby="forma_pago_credito"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                </div>
                            </fieldset>

                            <fieldset class="bordesito">
                                <legend class="bordesito">Patrimonio</legend>
                                <div class="row">
                                    <h4 class="col-12">BIENES INMUEBLES</h4>

                                    <div class="form-group col-4">
                                        <label for="descripcion_bien">Descripción</label>
                                        <input v-model="descripcion_bien" type="text" class="form-control"
                                            id="descripcion_bien" aria-describedby="descripcion_bien" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="ciudad_bien">Ciudad</label>
                                        <input v-model="ciudad_bien" type="text" class="form-control" id="ciudad_bien"
                                            aria-describedby="ciudad_bien" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="documento">Hipoteca <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="hipoteca_bien"
                                            @change="saveCredito">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="avaluo_comercial_bien">Avaluo comercial</label>
                                        <input v-model="avaluo_comercial_bien" type="text" class="form-control"
                                            id="avaluo_comercial_bien" aria-describedby="avaluo_comercial_bien"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="avaluo_catastral_bien">Avaluo catastral</label>
                                        <input v-model="avaluo_catastral_bien" type="text" class="form-control"
                                            id="avaluo_catastral_bien" aria-describedby="avaluo_catastral_bien"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="cedula_catastral_bien">Cédula catastral No.</label>
                                        <input v-model="cedula_catastral_bien" type="text" class="form-control"
                                            id="cedula_catastral_bien" aria-describedby="cedula_catastral_bien"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="matricula_bien">Matricula inmobiliarial No.</label>
                                        <input v-model="matricula_bien" type="text" class="form-control"
                                            id="matricula_bien" aria-describedby="matricula_bien" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="escritura_bien">Escribura pública No.</label>
                                        <input v-model="escritura_bien" type="text" class="form-control"
                                            id="escritura_bien" aria-describedby="escritura_bien" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="notaria_bien">Notaria</label>
                                        <input v-model="notaria_bien" type="text" class="form-control" id="notaria_bien"
                                            aria-describedby="notaria_bien" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="fecha_bien">Fecha</label>
                                        <input v-model="fecha_bien" type="date" class="form-control" id="fecha_bien"
                                            aria-describedby="fecha_bien" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="ciudad_parimonio_bien">Ciudad</label>
                                        <input v-model="ciudad_parimonio_bien" type="text" class="form-control"
                                            id="ciudad_parimonio_bien" aria-describedby="ciudad_parimonio_bien"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div v-if="!mostrar" class="form-group col-4">
                                        <button @click="mostrarUno" class="btn btn-info float-right mt-4">Agregar
                                            Otro</button>
                                    </div>

                                    <div v-if="mostrar" class="row">

                                        <hr class=" col-11" />

                                        <div class="form-group col-4">
                                            <label for="descripcion_bien">Descripción</label>
                                            <input v-model="descripcion_bien_dos" type="text" class="form-control"
                                                id="descripcion_bien" aria-describedby="descripcion_bien"
                                                autocomplete="off" @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="ciudad_bien">Ciudad</label>
                                            <input v-model="ciudad_bien_dos" type="text" class="form-control"
                                                id="ciudad_bien" aria-describedby="ciudad_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="documento">Hipoteca <span class="text-danger">
                                                    *</span></label>
                                            <select id="inputState" class="form-control" v-model="hipoteca_bien_dos"
                                                @change="saveCredito">
                                                <option value="" selected>Seleccione...</option>
                                                <option value="Si">Si</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="avaluo_comercial_bien">Avaluo comercial</label>
                                            <input v-model="avaluo_comercial_bien_dos" type="text" class="form-control"
                                                id="avaluo_comercial_bien" aria-describedby="avaluo_comercial_bien"
                                                autocomplete="off" @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="avaluo_catastral_bien">Avaluo catastral</label>
                                            <input v-model="avaluo_catastral_bien_dos" type="text" class="form-control"
                                                id="avaluo_catastral_bien" aria-describedby="avaluo_catastral_bien"
                                                autocomplete="off" @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="cedula_catastral_bien">Cédula catastral No.</label>
                                            <input v-model="cedula_catastral_bien_dos" type="text" class="form-control"
                                                id="cedula_catastral_bien" aria-describedby="cedula_catastral_bien"
                                                autocomplete="off" @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="matricula_bien">Matricula inmobiliarial No.</label>
                                            <input v-model="matricula_bien_dos" type="text" class="form-control"
                                                id="matricula_bien" aria-describedby="matricula_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="escritura_bien">Escribura pública No.</label>
                                            <input v-model="escritura_bien_dos" type="text" class="form-control"
                                                id="escritura_bien" aria-describedby="escritura_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="notaria_bien">Notaria</label>
                                            <input v-model="notaria_bien_dos" type="text" class="form-control"
                                                id="notaria_bien" aria-describedby="notaria_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="fecha_bien">Fecha</label>
                                            <input v-model="fecha_bien_dos" type="date" class="form-control"
                                                id="fecha_bien" aria-describedby="fecha_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="ciudad_parimonio_bien">Ciudad</label>
                                            <input v-model="ciudad_parimonio_bien_dos" type="text" class="form-control"
                                                id="ciudad_parimonio_bien" aria-describedby="ciudad_parimonio_bien"
                                                autocomplete="off" @change="saveCredito">
                                        </div>

                                        <div v-if="!mostrar_dos" class="form-group col-4">
                                            <button @click="mostrarDos" class="btn btn-info float-right mt-4">Agregar
                                                Otro</button>
                                        </div>

                                    </div>

                                    <div v-if="mostrar_dos" class="row">

                                        <hr class=" col-11" />

                                        <div class="form-group col-4">
                                            <label for="descripcion_bien">Descripción</label>
                                            <input v-model="descripcion_bien_tres" type="text" class="form-control"
                                                id="descripcion_bien" aria-describedby="descripcion_bien"
                                                autocomplete="off" @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="ciudad_bien">Ciudad</label>
                                            <input v-model="ciudad_bien_tres" type="text" class="form-control"
                                                id="ciudad_bien" aria-describedby="ciudad_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="documento">Hipoteca <span class="text-danger">
                                                    *</span></label>
                                            <select id="inputState" class="form-control" v-model="hipoteca_bien_tres"
                                                @change="saveCredito">
                                                <option value="" selected>Seleccione...</option>
                                                <option value="Si">Si</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="avaluo_comercial_bien">Avaluo comercial</label>
                                            <input v-model="avaluo_comercial_bien_tres" type="text" class="form-control"
                                                id="avaluo_comercial_bien" aria-describedby="avaluo_comercial_bien"
                                                autocomplete="off" @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="avaluo_catastral_bien">Avaluo catastral</label>
                                            <input v-model="avaluo_catastral_bien_tres" type="text" class="form-control"
                                                id="avaluo_catastral_bien" aria-describedby="avaluo_catastral_bien"
                                                autocomplete="off" @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="cedula_catastral_bien">Cédula catastral No.</label>
                                            <input v-model="cedula_catastral_bien_tres" type="text" class="form-control"
                                                id="cedula_catastral_bien" aria-describedby="cedula_catastral_bien"
                                                autocomplete="off" @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="matricula_bien">Matricula inmobiliarial No.</label>
                                            <input v-model="matricula_bien_tres" type="text" class="form-control"
                                                id="matricula_bien" aria-describedby="matricula_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="escritura_bien">Escribura pública No.</label>
                                            <input v-model="escritura_bien_tres" type="text" class="form-control"
                                                id="escritura_bien" aria-describedby="escritura_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="notaria_bien">Notaria</label>
                                            <input v-model="notaria_bien_tres" type="text" class="form-control"
                                                id="notaria_bien" aria-describedby="notaria_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="fecha_bien">Fecha</label>
                                            <input v-model="fecha_bien_tres" type="date" class="form-control"
                                                id="fecha_bien" aria-describedby="fecha_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="ciudad_parimonio_bien">Ciudad</label>
                                            <input v-model="ciudad_parimonio_bien_tres" type="text" class="form-control"
                                                id="ciudad_parimonio_bien" aria-describedby="ciudad_parimonio_bien"
                                                autocomplete="off" @change="saveCredito">
                                        </div>

                                    </div>

                                    <hr class=" col-11" />
                                    <h4 class="col-12">VEHICULOS</h4>

                                    <div class="form-group col-4">
                                        <label for="ciudad_bien">Marca</label>
                                        <input v-model="marca_vehiculo" type="text" class="form-control"
                                            id="ciudad_bien" aria-describedby="ciudad_bien" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="ciudad_bien">Clase</label>
                                        <input v-model="clase_vehiculo" type="text" class="form-control"
                                            id="ciudad_bien" aria-describedby="ciudad_bien" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="ciudad_bien">Modelo</label>
                                        <input v-model="modelo_vehiculo" type="text" class="form-control"
                                            id="ciudad_bien" aria-describedby="ciudad_bien" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="ciudad_bien">Placa</label>
                                        <input v-model="placa_vehiculo" type="text" class="form-control"
                                            id="ciudad_bien" aria-describedby="ciudad_bien" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="ciudad_bien">Valor comercial</label>
                                        <input v-model="valor_vehiculo" type="text" class="form-control"
                                            id="ciudad_bien" aria-describedby="ciudad_bien" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="documento">Pigmentado <span class="text-danger">
                                                *</span></label>
                                        <select id="inputState" class="form-control" v-model="hipoteca_vehiculo"
                                            @change="saveCredito">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>

                                    <div v-if="!mostrar_vehoculo" class="form-group col-12">
                                        <button @click="mostrarVeliculo" class="btn btn-info float-right mt-4">Agregar
                                            Otro</button>
                                    </div>

                                    <div v-if="mostrar_vehoculo" class="row">
                                        <hr class=" col-11" />

                                        <div class="form-group col-4">
                                            <label for="marca_vehiculo">Marca</label>
                                            <input v-model="marca_vehiculo_dos" type="text" class="form-control"
                                                id="marca_vehiculo" aria-describedby="marca_vehiculo" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="ciudad_bien">Clase</label>
                                            <input v-model="clase_vehiculo_dos" type="text" class="form-control"
                                                id="ciudad_bien" aria-describedby="ciudad_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="ciudad_bien">Modelo</label>
                                            <input v-model="modelo_vehiculo_dos" type="text" class="form-control"
                                                id="ciudad_bien" aria-describedby="ciudad_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="ciudad_bien">Placa</label>
                                            <input v-model="placa_vehiculo_dos" type="text" class="form-control"
                                                id="ciudad_bien" aria-describedby="ciudad_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="ciudad_bien">Valor comercial</label>
                                            <input v-model="valor_vehiculo_dos" type="text" class="form-control"
                                                id="ciudad_bien" aria-describedby="ciudad_bien" autocomplete="off"
                                                @change="saveCredito">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="documento">Pigmentado <span class="text-danger">
                                                    *</span></label>
                                            <select id="inputState" class="form-control" v-model="hipoteca_vehiculo_dos"
                                                @change="saveCredito">
                                                <option value="" selected>Seleccione...</option>
                                                <option value="Si">Si</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

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
                                        <input v-model="salario" type="text" class="form-control" id="salario"
                                            aria-describedby="salario" autocomplete="off" @change="saveCredito">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="honorarios">Honorarios promedio</label>
                                        <input v-model="honorarios" type="text" class="form-control" id="honorarios"
                                            aria-describedby="honorarios" autocomplete="off" @change="saveCredito">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="otros_ingresos">Otros ingresos</label>
                                        <input v-model="otros_ingresos" type="text" class="form-control"
                                            id="otros_ingresos" aria-describedby="otros_ingresos" autocomplete="off"
                                            @change="saveCredito">
                                    </div>
                                    <div class="form-group col-8">
                                        <label for="otros_ingresos_describe">Describe</label>
                                        <input v-model="otros_ingresos_describe" type="text" class="form-control"
                                            id="otros_ingresos_describe" aria-describedby="otros_ingresos_describe"
                                            autocomplete="off" @change="saveCredito">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="total_ingresos">Total</label>
                                        <input v-model="total_ingresos" type="text" class="form-control"
                                            id="total_ingresos" aria-describedby="total_ingresos" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <h4 class="col-12 mt-4">EGRESOS</h4>

                                    <div class="form-group col-4">
                                        <label for="alquiler">Alquiler</label>
                                        <input v-model="alquiler" type="text" class="form-control" id="alquiler"
                                            aria-describedby="alquiler" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="amortizacion">Amortización crédotos vigentes</label>
                                        <input v-model="amortizacion" type="text" class="form-control" id="amortizacion"
                                            aria-describedby="amortizacion" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="amortizacion_hipoteca">Amortización hipoteca</label>
                                        <input v-model="amortizacion_hipoteca" type="text" class="form-control"
                                            id="amortizacion_hipoteca" aria-describedby="amortizacion_hipoteca"
                                            autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="pago_tarjetas">Pago mensual tarjetas de crédito</label>
                                        <input v-model="pago_tarjetas" type="text" class="form-control"
                                            id="pago_tarjetas" aria-describedby="pago_tarjetas" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="otros_gastos">Otros gastos familiares</label>
                                        <input v-model="otros_gastos" type="text" class="form-control" id="otros_gastos"
                                            aria-describedby="otros_gastos" autocomplete="off" @change="saveCredito">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="total_egresos">Total</label>
                                        <input v-model="total_egresos" type="text" class="form-control"
                                            id="total_egresos" aria-describedby="total_egresos" autocomplete="off"
                                            @change="saveCredito">
                                    </div>

                                </div>

                            </fieldset>

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
                                        <input v-model="acreedor" type="text" class="form-control" id="acreedor"
                                            aria-describedby="acreedor" autocomplete="off" placeholder="acreedor uno"
                                            @change="saveCredito">

                                        <input v-model="acreedor_dos" type="text" class="form-control" id="acreedor_dos"
                                            aria-describedby="acreedor_dos" autocomplete="off"
                                            placeholder="acreedor dos" @change="saveCredito">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="acreedor_telefono">Telefono</label>
                                        <input v-model="acreedor_telefono" type="text" class="form-control"
                                            id="acreedor_telefono" aria-describedby="acreedor_telefono"
                                            autocomplete="off" placeholder="telefono uno" @change="saveCredito">

                                        <input v-model="acreedor_telefono_dos" type="text" class="form-control"
                                            id="acreedor_telefono_dos" aria-describedby="acreedor_telefono_dos"
                                            autocomplete="off" placeholder="telefono dos" @change="saveCredito">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="acreedor_valor">Valor prestamo</label>
                                        <input v-model="acreedor_valor" type="text" class="form-control"
                                            id="acreedor_valor" aria-describedby="acreedor_valor" autocomplete="off"
                                            placeholder="valor uno" @change="saveCredito">

                                        <input v-model="acreedor_valor_dos" type="text" class="form-control"
                                            id="acreedor_valor_dos" aria-describedby="acreedor_valor_dos"
                                            autocomplete="off" placeholder="valor dos" @change="saveCredito">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="acreedor_saldo">Saldo</label>
                                        <input v-model="acreedor_saldo" type="text" class="form-control"
                                            id="acreedor_saldo" aria-describedby="acreedor_saldo" autocomplete="off"
                                            placeholder="saldo uno" @change="saveCredito">

                                        <input v-model="acreedor_saldo_dos" type="text" class="form-control"
                                            id="acreedor_saldo_dos" aria-describedby="acreedor_saldo_dos"
                                            autocomplete="off" placeholder="saldo dos" @change="saveCredito">
                                    </div>


                                    <h4 class="col-12 mt-4">Tarjeta de crédito</h4>

                                    <div class="form-group col-3">
                                        <label for="salario">Nombre - Banco</label>
                                        <input v-model="banco_tarjeta" type="text" class="form-control"
                                            id="banco_tarjeta" aria-describedby="banco_tarjeta" autocomplete="off"
                                            placeholder="Nombre Banco" @change="saveCredito">

                                        <input v-model="banco_tarjeta_dos" type="text" class="form-control"
                                            id="acreedor_dos" aria-describedby="acreedor_dos" autocomplete="off"
                                            placeholder="Nombre Banco dos" @change="saveCredito">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="banco_telefono">Antoguedad</label>
                                        <input v-model="banco_antoguedad" type="text" class="form-control"
                                            id="banco_antoguedad" aria-describedby="banco_antoguedad" autocomplete="off"
                                            placeholder="Antoguedad" @change="saveCredito">

                                        <input v-model="banco_antoguedad_dos" type="text" class="form-control"
                                            id="banco_antoguedad_dos" aria-describedby="banco_antoguedad_dos"
                                            autocomplete="off" placeholder="Antoguedad dos" @change="saveCredito">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="acreedor_valor">Número</label>
                                        <input v-model="banco_numero_antoguedad" type="text" class="form-control"
                                            id="banco_numero" aria-describedby="banco_numero" autocomplete="off"
                                            placeholder="Número" @change="saveCredito">

                                        <input v-model="banco_numero_antoguedad_dos" type="text" class="form-control"
                                            id="banco_numero_dos" aria-describedby="banco_numero_dos" autocomplete="off"
                                            placeholder="Número dos" @change="saveCredito">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="banco_cupo">Cupo máximo</label>
                                        <input v-model="banco_cupo" type="text" class="form-control" id="banco_cupo"
                                            aria-describedby="banco_cupo" autocomplete="off" placeholder="Cupo máximo"
                                            @change="saveCredito">

                                        <input v-model="banco_cupo_dos" type="text" class="form-control"
                                            id="banco_cupo_dos" aria-describedby="banco_cupo_dos" autocomplete="off"
                                            placeholder="Cupo máximo dos" @change="saveCredito">
                                    </div>



                                </div>

                            </fieldset>

                            <fieldset class="bordesito col-12">
                                <legend class="bordesito">Documentos requeridos</legend>

                                <div class="row">
                                    <div class="table-responsive col-12">
                                        <table class="table  table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th rowspan="2" scope="col" class="align-middle">DOCUMENTACIÓN
                                                        REQUERIDA
                                                        PARA EL ESTUDIO
                                                        DEL CRÉDITO</th>
                                                    <th colspan="2" scope="col">PERSONA NATURAL</th>
                                                    <th rowspan="2" scope="col" class="align-middle">INDEPENDIENTE</th>
                                                </tr>

                                                <tr class="text-center">
                                                    <th scope="col">EMPLEADO</th>
                                                    <th scope="col">INDEPENDIENTE</th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td scope="row">FOTOCOPIA DE LA CÉDULA / PERSONA JURIDICA -
                                                        REPRESENTANTE LEGAL </td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                </tr>

                                                <tr>
                                                    <td scope="row">FOTOCOPIA DEL RUT</td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                </tr>

                                                <tr>
                                                    <td scope="row">CERTIFICADO LABORAL – CERTIFICACION DE INGRESOS</td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;"></td>
                                                </tr>

                                                <tr>
                                                    <td scope="row">DECLARACIÓN DE RENTA (TRES ÚLTIMOS AÑOS) </td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                </tr>

                                                <tr>
                                                    <td scope="row">CERTIFICADO DE INGRESOS YRETENCIONES (DOS ÚLTIMOS
                                                        AÑOS) </td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;"></td>
                                                </tr>

                                                <tr>
                                                    <td scope="row">CERTIFICADO DE CÁMARA Y COMERCIO (VIGENTE) NO MAYOR
                                                        A 30 DIAS </td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                </tr>

                                                <tr>
                                                    <td scope="row">BALANCE GENERAL Y ESTADO DE RESULTADOS DE LOS TRES
                                                        ÚLTIMOS PERIODOS CONTABLES (FIRMADOS POR ELCONTADOR)
                                                        ANEXO FOTOCOPIA DE LA TARJETA PROFESIONAL Y ANTECEDENTES
                                                        DISCIPLINARIOS. LOS EFF </td>
                                                    <td class="align-middle" style="text-align: center;"></td>
                                                    <td class="align-middle" style="text-align: center;">X</td>
                                                    <td class="align-middle" style="text-align: center;">X</td>
                                                </tr>

                                                <tr>
                                                    <td scope="row">CERTIFICADO DE TRADICIÓN Y LIBERTAD DE INMUEBLES
                                                    </td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                </tr>

                                                <tr>
                                                    <td scope="row">FOTOCOPIA TARJETA DE PROPIEDAD VEHICULOS </td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                </tr>

                                                <tr>
                                                    <td scope="row">EXTRACTOS BANCARIOS ÚLTIMOS 3 MESES </td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                    <td style="text-align: center;">X</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset class="bordesito">
                                <legend class="bordesito">Autorización</legend>
                                <div class="row">
                                    <div>
                                        <p class="text-justify">
                                            Autorizo con carácter permanente y de manera irrevocable a AGRO HELP S.A.S.
                                            para obtener, consultar y reportar en las centrales de información de la
                                            asociación Bancaria de Colombia,
                                            Datacredito, Cifin y/o de cualquier fuente y base de datos, la información y
                                            referencia relativas a mi documento de identificación, comportamiento
                                            crediticio, a mi comportamiento comercial y al
                                            producto de toda clase de operaciones que efectúe o haya efectuado con
                                            entidades del sector financiero y otros sectores. y que en general sirva de
                                            referencia para determinar hasta que AGRO
                                            HELP S.A.S. o las centrales de información lo consideren necesario.
                                        </p>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="bordesito col-12">
                                <legend class="bordesito">Firma del solicitante</legend>

                                <div class="row">
                                    <div class="col-6">
                                        <b> Subir firma digital<span class="text-danger">*</span> </b>
                                        <div class="input-group input-group-sm input mb-3">
                                            <input type="file" @change="select_file($event)" class="form-control-file"
                                                id="image_1">
                                        </div>
                                    </div>

                                    <div v-if="url_img != []" class="col-6">
                                        <div id="preview" class="card card-primary card-outline">
                                            <div class="card-body box-profile" style="padding:0px">
                                                <div class="text-center mt-2 mb-3">
                                                    <img :src="url_img"
                                                        class="profile-user-img img-fluid img-circle mb-3" id="img">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </fieldset>

                            <fieldset class="bordesito col-12">
                                <legend class="bordesito">Declaración de origen de fondos</legend>

                                <div class="row">

                                    <div class="col-12">
                                        <p class="text-justify">
                                            En cumplimiento de las normas legales contempladas en el Estatuto Orgánico
                                            del Sistema Financiero y demás normas concordantes, declaro a AGRO HELP
                                            S.A.S. <br />
                                            1. Que los fondos con los cuales cubriré mis obligaciones presentes y
                                            futuras con AGRO HELP S.A.S, provienen de las siguientes fuentes y
                                            corresponden a actividades licitas.<br />
                                            2. Que no admitiré que terceros efectúen depósitos o pagos a AGRO HELP
                                            S.A.S, en mi nombre con fondos provenientes o destinados a realizar
                                            actividades licitas.<br />
                                            Declaro que la información suministrada en esta solicitud es válida, al
                                            igual que las autorizaciones otorgadas en esta solicitud. En constancia de
                                            haber leído, entendido y aceptado esta Información, firmo el presente
                                            documento.
                                        </p>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <b> Subir firma digital<span class="text-danger">*</span> </b>
                                        <div class="input-group input-group-sm input mb-3">
                                            <input type="file" @change="select_file_dos($event)"
                                                class="form-control-file" id="image_1">
                                        </div>
                                    </div>

                                    <div v-if="url_img_dos != []" class="col-6 mt-2">
                                        <div id="preview_dos" class="card card-primary card-outline">
                                            <div class="card-body box-profile" style="padding:0px">
                                                <div class="text-center mt-2 mb-3">
                                                    <img :src="url_img_dos"
                                                        class="profile-user-img img-fluid img-circle mb-3" id="img_dos">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </fieldset>



                        </div>
                    </div>

                    <div class="card-footer"
                        v-if="tipo_documento.length > 0 && documento.length > 0 && nombre.length > 0">
                        <div class="row">
                            <div class="col-12 mt-4">
                                <button class="btn btn-success float-right" @click="updateStateSolicitud('Solicitado')">
                                    Solicitar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </LayoutCLient>
</template>


<style scoped>
fieldset.bordesito {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow: 0px 0px 0px 0px #000;
    box-shadow: 0px 0px 0px 0px #000;
}

legend.bordesito {
    width: inherit;
    /* Or auto */
    padding: 0 10px;
    /* To give a bit of padding on the left and right */
    border-bottom: none;
}
</style>