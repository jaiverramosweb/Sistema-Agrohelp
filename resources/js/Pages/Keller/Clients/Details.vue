<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, reactive, ref, computed, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

import InfoCliente from './components/InfoClientes.vue';
import InfoCreditos from './components/InfoCreditos.vue';


const props = defineProps(['permissions', 'client', 'direcciones'])

onMounted(() => {
  activeMenu('clients', 'clients')
})

const loader = ref(false);


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

const tags = ref('perfil')


// Metodos Requeridos para iniciar modulo
const activeMenu = (menu, submenu) => {
  $(".menu_" + menu).addClass('menu-is-opening menu-open')
  $("#menu_" + menu).addClass('active')
  $("#sub_menu_" + submenu).addClass('active')
}


// Modulos a crear

const clear = () => {
  id.value = 0
  company.value = ''
  nif.value = ''
  phone.value = ''
  web.value = ''
  location.value = ''
  province.value = ''
  postal_code.value = ''
}

const update = () => {
  axios.put(`/clients/${id.value}`, {
    company: company.value,
    nif: nif.value,
    phone: phone.value,
    web: web.value,
    location: location.value,
    province: province.value,
    postal_code: postal_code.value,

  }).then(res => {
    $('#modalClient').modal('hide')
    Toast.fire({
      icon: 'success',
      title: 'Registro actualizado con éxito'
    })
  })
}

const deleteItem = (id) => {
  Swal.fire({
    title: 'Estas seguro de eliminarlo?',
    showCancelButton: true,
    confirmButtonText: 'Eliminar',
  }).then((result) => {
    if (result.isConfirmed) {
      axios.delete(`/clients/${id}`).then(res => {
        paginationList()
        Swal.fire('Eliminado!', '', 'success')
      })
    } else if (result.isDenied) {
      Swal.fire('Changes are not saved', '', 'info')
    }
  })
}

const isLouding = () => {
  loader.value = true
}

const transforDate = (date) => {
  let fecha = new Date(date);

  let fechaFormateada = fecha.toISOString().slice(0, 10);

  let horaFormateada = fecha.toISOString().slice(11, 16);

  let resultado = fechaFormateada + ", " + horaFormateada;

  return resultado;
}

const tagsCambiar = (tag) => {
  tags.value = tag
}

</script>


<template>
  <AuthenticatedLayout title="Cliente">

    <div class='col-md-12'>

      <div class="row">

        <div class="col-md-3">

          <div class="card card-primary card-outline">
            <div class="card-body box-profile">

              <ul class="list-group list-group-unbordered mb-3">

                <li class="list-group-item">
                  <a class="nav-link active" @click="tagsCambiar('perfil')" data-toggle="tab">Información</a>
                </li>

                <li class="list-group-item">
                  <a class="nav-link" @click="tagsCambiar('creditos')" data-toggle="tab">Creditos</a>
                </li>

                <!-- <li class="list-group-item">
                  <a class="nav-link" href="#timeline" data-toggle="tab">Notas</a>
                </li>

                <li class="list-group-item">
                  <a class="nav-link" href="#timeline" data-toggle="tab">Informe</a>
                </li>

                <li class="list-group-item">
                  <a class="nav-link" href="#timeline" data-toggle="tab">Facturas</a>
                </li>

                <li class="list-group-item">
                  <a class="nav-link" href="#timeline" data-toggle="tab">Pagos</a>
                </li>

                <li class="list-group-item">
                  <a class="nav-link" href="#timeline" data-toggle="tab">Propuestas</a>
                </li>

                <li class="list-group-item">
                  <a class="nav-link" href="#timeline" data-toggle="tab">Notas créditos</a>
                </li>

                <li class="list-group-item">
                  <a class="nav-link" href="#timeline" data-toggle="tab">Presupuestos</a>
                </li>

                <li class="list-group-item">
                  <a class="nav-link" href="#timeline" data-toggle="tab">Suscripciones</a>
                </li>

                <li class="list-group-item">
                  <a class="nav-link" href="#timeline" data-toggle="tab">Gastos</a>
                </li>

                <li class="list-group-item">
                  <a class="nav-link" href="#timeline" data-toggle="tab">Contratos</a>
                </li>

                <li class="list-group-item">
                  <a class="nav-link" href="#timeline" data-toggle="tab">Proyectos</a>
                </li> -->

              </ul>

              <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
            </div>
            <!-- /.card-body -->
          </div>

        </div>

        <div class="col-md-9 tab-pane" v-if="tags == 'perfil'">
          <div class="card">
            <div class="card-header p-2">
              <!-- <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#user" data-toggle="tab">perfil</a></li>
              </ul> -->

              <h4 class="ml-2">
                Información del cliente
              </h4>

            </div>

            <div class="card-body">

              <div class="tab-content">

                <div class="active tab-pane" id="user">
                  <InfoCliente :client="client" :direcciones="direcciones" />
                </div>

              </div>

            </div>

          </div>

        </div>

        <div class="col-md-9 tab-pane" v-if="tags == 'creditos'">
          <div class="card">
            <div class="card-header p-2">

              <h4 class="ml-2">
                Información del los creditos
              </h4>

            </div>

            <div class="card-body">

              <div class="tab-content">

                <div class="active tab-pane" id="user">
                  <InfoCreditos :clientId="client.id" />
                </div>

              </div>

            </div>

          </div>
          <!-- /.card -->
        </div>

      </div>

    </div>

  </AuthenticatedLayout>
</template>