<template>
  <AuthenticatedLayout title="Usuarios">

    <div class='col-md-12'>

      <div class="card">

        <div class="card-header">
          <h3 class="card-title" v-if='id == 0'>
            <i class="fas fa-user-plus"></i>
            Crear usuario
          </h3>
          <h3 class="card-title" v-else>
            <i class="fas fa-user-plus"></i>
            Editar usuario
          </h3>
          <div class="card-tools">
            <button @click='return_index()' class='btn btn-xs bg-gray'>
              <i class='fas fa-reply'></i> Regresar
            </button>
          </div>
          <br>
          Todos los campos con (<span class="text-danger"> * </span>) son obligatorios, para un registro correcto.
        </div>

        <div class="card-body">

          <form id='form' @submit.prevent="">

            <div class='row'>

              <div :class="scf.fields['static']['nombre'].class">
                <b> Primer nombre <span class="text-danger">*</span> </b>
                <div class="input-group mb-3 input-group-sm" id="div_nombre">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                  </div>
                  <input type="text" id='nombre' required v-model='element.nombre' class="form-control"
                    placeholder="Primer nombre ">
                </div>
              </div>

              <div class='col-md-6 col-xs-12 col-sm-6'>
                <b>Segundo nombre </b>
                <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                  </div>
                  <input type="text" maxlength="250" v-model='element.segundo_nombre' id='segundo_nombre'
                    class="form-control" placeholder="Segundo nombre ">
                </div>
              </div>

            </div>
            <div class='row'>

              <div class='col-md-6 col-xs-12 col-sm-6'>
                <b>Primer apellido <span class="text-danger">*</span></b>
                <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                  </div>
                  <input type="text" required maxlength="250" v-model='element.apellido' id='apellido'
                    class="form-control" placeholder="Primer apellido ">

                </div>
              </div>

              <div class='col-md-6 col-xs-12 col-sm-6'>
                <b>Segundo apellido </b>
                <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                  </div>
                  <input type="text" maxlength="250" v-model='element.segundo_apellido' id='segundo_apellido'
                    class="form-control" placeholder="Segundo apellido">

                </div>
              </div>

            </div>
            <div class='row'>


              <div class='col-md-4 col-xs-12 col-sm-6'>
                <b>Correo electrónico <span class="text-danger">*</span></b>
                <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  </div>
                  <input type="email" required maxlength="250" id='email' v-model='element.email' class='form-control'
                    placeholder="Correo electrónico" :disabled="id == 0 ? false : true">
                </div>
              </div>

              <div class='col-md-4 col-xs-12 col-sm-6'>
                <b>Rol usuario <span class="text-danger">*</span></b>
                <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  </div>
                  <select class='form-control' id="genero" v-model="element.role_id">
                    <option value="" disabled>Seleccionar una opción</option>
                    <option v-for=" ( item, i ) in roles " :value="item.id" :key="i">
                      {{ item.name }}
                    </option>
                  </select>
                </div>
              </div>


              <div class='col-md-4 col-xs-12 col-sm-6'>
                <b>Género</b>
                <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                  </div>
                  <select class='form-control' id="genero" v-model="element.genero">
                    <option value="" disabled>Seleccionar una opción</option>
                    <option :value="1">Masculino</option>
                    <option :value="2">Femenino</option>
                  </select>
                </div>
              </div>

            </div>
            <div class='row'>

              <div class='col-md-6 col-xs-12 col-sm-6'>
                <b>Tipo de identificación </b>
                <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                  </div>
                  <select class='form-control' id="tipo_documento" v-model="element.tipo_documento">
                    <option value="" disabled>Seleccionar una opción</option>
                    <option value="05">Cédula</option>
                    <option value="06">Pasaporte</option>
                    <option value="04">RUC</option>
                  </select>
                </div>
              </div>

              <div class='col-md-6 col-xs-12 col-sm-6'>
                <b>Número de identificación </b>
                <div class="input-group mb-3 input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                  </div>
                  <input type="text" maxlength="250" id='documento' v-model='element.documento' class='form-control'
                    placeholder="Número de identificación">
                </div>
              </div>

            </div>
            <div class='row'>

              <div class='col-md-6 col-xs-12 col-sm-6'>
                <b>Fecha de nacimiento </b>
                <b-input-group class="mb-3 input-group-sm">
                  <input type="date" id="fecha_nacimiento" class="form-control" @change="calcularEdad()"
                    v-model="element.fecha_nacimiento">
                </b-input-group>
              </div>

              <div class='col-md-6 col-xs-12 col-sm-6'>
                <b>Edad </b>
                <div class="input-group input-group-sm input mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar-week"></i></span>
                  </div>
                  <input type="text" maxlength="250" id='edad' class='form-control' v-model='element.edad'
                    placeholder="Edad" disabled>

                </div>
              </div>

            </div>
            <div class='row'>

              <div class='col-md-6 col-xs-12 col-sm-6'>
                <b>Ciudad de residencia </b>
                <div class="input-group input-group-sm input mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map"></i></span>
                  </div>
                  <input type="text" maxlength="250" id='ciudad' class='form-control' v-model='element.ciudad'
                    placeholder="Ciudad de residencia">

                </div>
              </div>

              <div class='col-md-6 col-xs-12 col-sm-6'>
                <b>Dirección o sector de residencia </b>
                <div class="input-group input-group-sm input mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                  </div>
                  <input type="text" maxlength="250" id='address' class='form-control' v-model='element.direccion'
                    placeholder="Dirección o sector de residencia">
                  <span id="validate-error" class="error invalid-feedback error-address">
                    Este campo es obligatorio.
                  </span>
                </div>
              </div>

            </div>
            <div class='row'>

              <div class='col-md-6 col-xs-12 col-sm-6'>
                <b> Celular <span class="text-danger">*</span> </b>
                <div class="input-group input-group-sm input mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                  </div>
                  <input type="text" maxlength="250" id='telefono' class='form-control' v-model='element.telefono'
                    placeholder="Dirección o sector de residencia">
                </div>
              </div>

              <div class='col-md-6 col-xs-12 col-sm-6'>
                <b>Otro teléfono </b>
                <div class="input-group input-group-sm input mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                  </div>
                  <input type="text" maxlength="250" id='telefono_dos' class='form-control'
                    v-model='element.telefono_dos' placeholder="Dirección o sector de residencia">
                </div>
              </div>

            </div>


            <fieldset class="bordesito" style='margin-top:20px;'>

              <legend class="bordesito">
                Contacto de emergencia
              </legend>

              <div class='row'>

                <div class='col-md-6 col-xs-12 col-sm-6'>
                  <b>Nombres </b>
                  <div class="input-group input-group-sm input mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" maxlength="250" id='nombre_responsable' class='form-control'
                      v-model='element.nombre_responsable' placeholder="Nombre y apellido">
                  </div>
                </div>

                <div class='col-md-6 col-xs-12 col-sm-6'>
                  <b>Apellido </b>
                  <div class="input-group input-group-sm input mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" maxlength="250" id='nombre_responsable' class='form-control'
                      v-model='element.apellidos_responsable' placeholder="Nombre y apellido">
                  </div>
                </div>

                <div class='col-md-6 col-xs-12 col-sm-6'>
                  <b>Celular </b>
                  <div class="input-group input-group-sm input mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" maxlength="250" id='address' class='form-control'
                      v-model='element.telefonotelefono_responsable_dos' placeholder="Dirección o sector de residencia">
                  </div>
                </div>

                <div class='col-md-6 col-xs-12 col-sm-6'>
                  <b>Parentesco </b>
                  <div class="input-group input-group-sm input mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
                    </div>
                    <input type="text" maxlength="250" id='parentesco_responsable' class='form-control'
                      v-model='element.parentesco_responsable' placeholder="Parentesco">
                  </div>
                </div>

              </div>

            </fieldset>

          </form>

          <div class='row'>

            <div class='col-md-12 col-xs-12 col-sm-12'>
              <center>
                <h5 :style='{ "display": sending ? "block" : "none" }'><i class='fa fa-spinner fa-spin'></i>
                  ((Enviando))...</h5>
              </center>
            </div>

            <div class='col-md-12 col-xs-12 col-sm-12' style="text-align: center;">

              <button :class="'btn btn-sm  btn-flat   bg-success'" v-if='id == 0' id='btn_save' @click='store();'>
                <i class="fa fa-save"></i> Guardar
              </button>

              <button :class="'btn btn-sm  btn-flat bg-warning'" v-else id='btn_save' @click='update();'>
                <i class="fa fa-save"></i> Actualizar
              </button>

            </div>

          </div>

        </div>

        <div class="card-footer">
          <!-- {{labels.frase_footer_add}} -->
        </div>

      </div>

    </div>

  </AuthenticatedLayout>
</template>

<script>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

import errors_ from '../../../scripts/keller_validate.js';

import CustomFields from '@/Komponents/SectionCustomFields.vue';

export default {
  props: ['custom', 'roles', 'user', 'scf'],
  components: {
    AuthenticatedLayout,
    Swal,
    errors_,

    CustomFields
  },
  data() {

    const now = new Date()
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate())
    const maxDate = new Date(today)

    return {

      id: 0,

      sending: false,

      element: {
        id: 0,
        role_id: 0,
        nombre: "",
        segundo_nombre: "",
        apellido: "",
        segundo_apellido: "",
        email: "",

        tipo_documento: "",
        documento: "",

        ciudad: "",
        direccion: "",
        telefono: "",
        telefono_dos: "",

        fecha_nacimiento: "",

        nombre_responsable: "",
        apellidos_responsable: "",
        telefono_responsable: "",
        parentesco_responsable: "",

        edad: "",
        ocupacion: "",
        tipo_sangre: '',
        genero: '',

      },

      isLoading: false,
      selectedService: [],
      services: [],

      errors_temp: {}
    }

  },
  mounted() {

    if (typeof this.user !== "undefined") {
      this.element = this.user;
      this.id = this.user.id;
    }
    else {
      // alert("Please select")
    }

  },
  methods: {
    dataCustom(data) {
      this.element.scf = data;
    },
    parseJson(data) {
      return data ? JSON.parse(data) : [];
    },
    return_index: function () {
      window.history.back();
    },

    getUser() {
      axios.get('./patients/' + this.id)
        .then((resp) => {

          console.log('./patients/', resp.data);

          var user = resp.data.data.patient;

          this.element = user;
          this.selectedService = {}
          this.selectedService.name = user.name_allied;
          this.selectedService.id = user.fk_allied_company_id;

        })
        .catch(function (error) {
          console.log(error);
        });

    },

    store() {
      $(".error").css("display", "none");
      $("input").removeClass("is-invalid");
      $("select").removeClass("is-invalid");

      var errores = 0;
      var form = $("#form")[0];

      for (var i = 0; i < form.elements.length; i++) {
        var element = $(form.elements[i]);
        var attr = $(form.elements[i]).attr("required");
        var _id = $(form.elements[i]).attr("id");

        if (typeof attr !== typeof undefined && attr !== false) {
          if (element.val() == "" || element.val() == null) {
            $(".error-" + _id).css("display", "block");
            element.addClass("is-invalid");
            errores++;
          }
        }
      }

      if (errores == 0) {

        $("#btn_save").attr("disabled");
        this.sending = true;
        this.user__perfiles_id = 5;

        this.element.company = this.selectedService.id;

        axios.post('/users', this.element)
          .then((response) => {
            this.sending = false;
            var data = response.data;
            Swal.fire({
              title: 'Recurso almacenado',
              text: 'El recurso se a creado correctamente.',
              icon: 'success',
              confirmButtonText: 'Ok',
            }).then((result) => {
              window.history.back();
            });
          })
          .catch((error) => {


            let errors = error.response.data.errors
            errors_(errors, this.errors_temp);
            this.errors_temp = errors;
            console.log('------------------>>>>>', error);

            Swal.fire({
              title: 'Error',
              text: 'Se ha generado un error al intentar almacenar el recurso',
              icon: 'error',
              confirmButtonText: 'Ok'
            }).then((result) => {
              //this.$router.push({name: "index"});
            })

            $("#btn_save").removeAttr("disabled");
            this.sending = false;
          });

      }

    },
    update() {
      $(".error").css("display", "none");
      $("input").removeClass("is-invalid");
      $("select").removeClass("is-invalid");
      var errores = 0;
      var form = $("#form")[0];

      for (var i = 0; i < form.elements.length; i++) {
        var element = $(form.elements[i]);
        var attr = $(form.elements[i]).attr("required");
        var _id = $(form.elements[i]).attr("id");
        if (typeof attr !== typeof undefined && attr !== false) {
          if (element.val() == "") {
            $(".error-" + _id).css("display", "block");
            element.addClass("is-invalid");
            errores++;
          }
        }
      }

      if (errores == 0) {
        $("#btn_save").attr("disabled");
        this.sending = true;

        axios.put('/users/' + this.element.id, this.element)
          .then((response) => {

            $("#btn_save").removeAttr("disabled");
            this.sending = false;
            var data = response.data;
            Swal.fire({
              title: 'Recurso actualizado',
              text: 'El recurso actualizado correctamente.',
              icon: 'success',
              confirmButtonText: 'Ok',
            }).then((result) => {
              window.history.back();
            });

          })
          .catch(function (error) {
            console.log(error);
            $("#btn_save").removeAttr("disabled");
            this.sending = false;
          });

      }

    },


    calcularEdad() {

      this.element.edad = this.element.fecha_nacimiento == NaN ? '' : this.element.fecha_nacimiento;
      let fecha = this.element.fecha_nacimiento;
      var hoy = new Date();
      var cumpleanos = new Date(fecha);
      var edad = hoy.getFullYear() - cumpleanos.getFullYear();
      var m = hoy.getMonth() - cumpleanos.getMonth();

      if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
      }

      this.element.edad = edad

    },


    limitText(count) {
      return `and ${count} other services`
    },
    asyncFindService(query) {

      // this.isLoading = true
      axios.post('./allied/search-all', { search: query })
        .then((resp) => {
          // console.log('./services/search' ,resp.data.data);
          this.services = resp.data.data
          // this.isLoading = false
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    clearAll() {
      this.selectedService = []
    },
    toAssign(item) {
      this.plan_seleted = true;
      this.plan_ = item;
    },







  }
}

</script>
