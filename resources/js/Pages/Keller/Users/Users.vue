<template>

  <AuthenticatedLayout title="Pruebas Johann">

    <template #header>
      <div class="row mb-2">

        <div class="col-sm-6">
          <h1 class="m-0">Usuarios</h1>
        </div>

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="#">Inicio</a></li>

            <li class="breadcrumb-item active">Usuarios</li>
          </ol>
        </div>

      </div>
    </template>

    <div class="row">

      <div class="col-lg-12">

        <div class="card">

          <div class="card-header">

            <h3 class="card-title">Lista de usuarios</h3>

            <div class="card-tools">
              <!-- <Link :href="route('users.create')" class="btn btn-sm btn-success" v-if="permissions.create">
              <i class='fas fa-plus'></i>
              Crear usuario
              </Link> -->

              <button v-if="permissions.create" type="button" class="btn btn-success" data-toggle="modal"
                data-target="#modalUsers">
                + Crear usuario
              </button>
            </div>

          </div>

          <!-- /.card-header -->
          <div class="card-body">

            <div class='row'>

              <!-- FILTRO -->
              <div class='col-md-4 col-sm-6 col-xs-12'>
                <b>Mostrar </b>
                <select id="entries" @change='getPagination()' v-model="show">
                  <option :value="5">5</option>
                  <option :value="10">10</option>
                  <option :value="15">15</option>
                  <option :value="20">20</option>
                  <option :value="25">25</option>
                  <option :value="30">30</option>
                  <option :value="50">50</option>
                </select>
                <b> registros</b>
              </div>

              <!-- BUSCADOR -->
              <div class='col-md-8 col-sm-6 col-xs-12'>

                <div class="pull-right">
                  <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <!-- <input type="text" maxlength="250" id='search' @change='asyncFind()' class='form-control' placeholder="Buscar" v-model="search"> -->
                    <input type="text" maxlength="250" id='search' @keyup='asyncFind()' class='form-control'
                      placeholder="Buscar" v-model="search">
                  </div>
                </div>

              </div>

              <!-- TABLA -->
              <div class='col-12'>
                <div class='table-responsive'>
                  <table class='table table-bordered table-striped table-hover table-title'>

                    <thead style='background-color: black; color: white'>

                      <tr>

                        <ThPagination :key="i" v-for="( item, i) in columns_" :order_="orderTest(item.field)"
                          :title_="item.title" :field_="item.field" v-on:filter-column="filterColumn" />

                        <th class="border text-center">
                          <i class='fa fa-cogs '></i>
                        </th>

                      </tr>

                    </thead>

                    <tbody>

                      <tr v-for=" ( item_data, i ) in data " :key='i'>

                        <td v-for=" ( col, i ) in columns_ " :key="i">

                          <template v-if="col.name != 'cantidad_descuento' &&
                col.name != 'state' &&
                col.name != 'name_file_'">
                            {{ fieldValue(col, item_data) }}
                          </template>

                          <template v-else>

                            <div style="border-radius:14px;" v-if="col.name == 'cantidad_descuento'">
                              <i class="fas fa-dollar-sign"
                                v-if="fieldValue({ name: 'tipo_cantidad' }, item_data) == 1"></i>
                              <i class="fas fa-percentage"
                                v-if="fieldValue({ name: 'tipo_cantidad' }, item_data) == 2"></i>

                              {{ fieldValue(col, item_data) }}
                            </div>

                            <template v-if="col.name == 'state'">
                              {{ fieldValue({ name: 'state' }, item_data) == 0 ? 'Pendiente' : 'Terminada' }} 888
                            </template>

                            <template v-if="col.name == 'name_file_'">

                              <button :class="'btn mr-1 btn-xs bg-info btn-round '" @click='preview(item_data)'
                                v-if="fieldValue(col, item_data) != 'Sin contrato'">
                                <i class='fas fa-eye pr-2'></i> Ver contrato
                              </button>

                              <span v-else>
                                Sin contrato
                              </span>


                            </template>

                          </template>

                        </td>

                        <td>
                          <div class='text-center  d-flex flex-row'>

                            <Link class="btn mr-1 btn-xs bg-info btn-round"
                              :href="'/users/' + item_data.id + '/details'" v-if="permissions.read">
                            <i class='fas fa-eye'></i>
                            </Link>

                            <Link class="btn mr-1 btn-xs bg-warning  btn-round"
                              :href="'/users/' + item_data.id + '/edit'" v-if="permissions.update">
                            <i class='fas fa-edit'></i>
                            </Link>

                            <button :class="'btn mr-1 btn-xs bg-danger btn-round'" @click='destroy(item_data.id)'
                              v-if="permissions.delete">
                              <i class='fas fa-trash'></i>
                            </button>

                          </div>
                        </td>

                      </tr>

                    </tbody>

                  </table>
                </div>
              </div>


              <div class='col-md-8 col-sm-6 col-xs-12'>

                <ul class="pagination pagination-sm m-0 float-right">

                  <li style='cursor:pointer' class="page-item">
                    <a class="page-link" @click.prevent="changePage(1)">
                      Primero
                    </a>
                  </li>
                  <li style='cursor:pointer' class="page-item" v-if="pagination.current_page > 1">
                    <a @click.prevent="changePage(pagination.current_page - 1)" class="page-link">
                      Anterior.
                    </a>
                  </li>
                  <li class="paginate_button page-item" :key="page" v-for="( page ) in pagesNumber "
                    v-bind:class="[page == isActived ? 'active' : '']">
                    <a href="#" @click.prevent="changePage(page)" class="page-link">
                      {{ page }}
                    </a>
                  </li>
                  <li style='cursor:pointer' class="page-item" v-if="pagination.current_page < pagination.last_page">
                    <a @click.prevent="changePage(pagination.current_page + 1)" class="page-link">
                      Sig.
                    </a>
                  </li>
                  <li style='cursor:pointer' class="page-item">
                    <a class="page-link" @click.prevent="changePage(pagination.last_page)">
                      Último
                    </a>
                  </li>
                </ul>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal_user" data-backdrop="static" data-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

            <form @submit.prevent="">

              <div class="form-group" id="div_name">
                <label for="name"> Nombres </label>
                <input type="text" class="form-control" id="name" placeholder="Nombre rol" v-model="element.nombres"
                  :disabled="true">
              </div>

              <div class="form-group" id="div_name">
                <label for="name"> Apellidos </label>
                <input type="text" class="form-control" id="name" placeholder="Nombre rol" v-model="element.apellidos"
                  :disabled="true">
              </div>


              <div class="form-group" id="div_description">
                <label for="description">Descripción rol</label>
                <textarea class="form-control" id="description" rows="3" v-model="element.description"
                  :disabled="true"></textarea>
              </div>

              <button type="button" class="btn btn-info" @click="edit(element)">Editar</button>

            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalUsers" data-backdrop="static" tabindex="-1" aria-labelledby="modalUsersLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <!-- <div class="modal-dialog modal-xl"> -->
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalClientLabel">+ Nuevo usuario</h5>

          </div>
          <div class="modal-body">
            <form>

              <div class="row">


                <div class="form-group col-12" has-validation>
                  <label for="email">Email <span class="text-danger"> * </span></label>
                  <input v-model="email" type="email" class="form-control" id="email" aria-describedby="email"
                    autocomplete="off" required>
                  <div v-if="email == ''" class="invalid-feedback d-block">El campo es
                    requerido
                  </div>
                </div>

                <div class="form-group col-12" has-validation>
                  <label for="password">Contraseña <span class="text-danger"> * </span></label>
                  <input v-model="password" type="password" class="form-control" id="password"
                    aria-describedby="password" autocomplete="off" required>
                  <div v-if="password == ''" class="invalid-feedback d-block">El campo es
                    requerido
                  </div>
                </div>


              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Canelar</button>
            <button @click="save" type="button" class="btn btn-primary">Guardar</button>
          </div>
        </div>
      </div>
    </div>


  </AuthenticatedLayout>

</template>

<script>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'
import ThPagination from '@/Komponents/ThPagination.vue';

export default {
  props: [
    'permissions',
    'users',
  ],
  components: {
    AuthenticatedLayout,
    ThPagination,
    Link
  },
  data() {
    return {

      data: [],

      setTimeoutSearch: '',

      search: "",
      order_cell: "id",
      order_type: "ASC",
      show: 15,
      offset: 3,
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0,
      },

      email: "",
      password: "",

      columns_: [
        {
          name: 'id',  // Name of the row.column 
          title: 'Nº',// Title for th table
          field: 'users.id' // column name for order sql by order_type
        },
        {
          name: 'email',
          title: 'Correo eléctronico',
          field: 'users.email' // column name for order sql
        },
      ],

      element: {

      }

    };
  },
  computed: {
    count() {
      var counted = 0;
      counted = this.pagination.from + parseInt(this.show) - 1;
      if (counted > this.pagination.total) {
        counted = this.pagination.total;
      }
      return counted;
    },
    isActived() {
      return this.pagination.current_page;
    },
    pagesNumber() {
      if (!this.pagination.to) {
        return [];
      }
      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    },
  },
  mounted() {
    this.data = this.users.data.data;
    this.pagination = this.users.pagination;
    this.activeMenu('users');
  },
  methods:
  {
    activeMenu(permission) {
      $(".menu_" + permission).addClass('menu-is-opening menu-open')
      $("#menu_" + permission).addClass('active')
      $("#sub_menu_" + permission).addClass('active')
    },

    fieldValue: function (col, record) {

      let result;

      Object.entries(record).map((el) => {

        if (el[0] == col.name) {
          result = "type_object" in col ? el[1][col.type_object.name] : el[1];
        }

      });

      return result;
    },

    orderTest: function (val) {
      let result;
      if (val == this.order_cell) {
        result = this.order_type == 'DESC' ? 3 : 2;
      } else {
        result = 1;
      }
      return result;
    },

    filterColumn: function (field_) {
      if (field_ == this.order_cell) {
        this.order_type = this.order_type == 'DESC' ? 'ASC' : 'DESC';
      } else {
        this.order_cell = field_;
      }

      this.getPagination();
    },

    asyncFind() {
      clearTimeout(this.setTimeoutSearch);
      this.setTimeoutSearch = setTimeout(() => {
        if (this.search != "") {
          this.getPagination();
        }
      }, 666);
    },

    changePage(page) {
      this.pagination.current_page = page;
      this.getPagination(page);
    },

    getPagination(page) {

      this.loading = true;

      axios
        .post('users/pagination', {
          "page": page,
          "show": this.show,
          "search": this.search,
          "order_field": this.order_cell,
          "order_type": this.order_type
        })
        .then((response) => {
          let res = response.data;
          this.data = res.data.data;
          this.pagination = res.pagination;
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
          console.log("error peticion");
        });
    },

    destroy(id) {

      Swal.fire({
        title: '¿Está seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, bórralo!'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete('/users/' + id)
            .then((resp) => {
              Swal.fire(
                'Deleted!',
                'El recurso ha sido borrado.',
                'success'
              );
              this.getPagination();
            })
            .catch(function (error) {
              console.log(error);
            });
        }
      });

    },

    showItem(item) {
      this.element = Object.assign({}, item);
      $("#modal_user").modal("show");
    },

    save() {
      let error = 0

      if (this.email.length == 0) error += 1;
      if (this.password.length == 0) error += 1;

      if (error == 0) {
        // alert('entro')
        axios.post(`/users`, {
          email: this.email,
          password: this.password
        }).then(res => {
          Swal.fire({
            title: 'Recurso almacenado',
            text: 'El recurso se a creado correctamente.',
            icon: 'success',
            confirmButtonText: 'Ok',
          }).then((result) => {
            // window.history.back();
            this.getPagination()
            $("#modalUsers").modal("hide");
          });
        })
      }

    },
  }
}
</script>

<!-- 

  <script setup>

    // import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    // import { Link } from '@inertiajs/vue3';


    // defineProps({
    //   users: {
    //     type: Array,
    //   },
    // });

  </script>

-->