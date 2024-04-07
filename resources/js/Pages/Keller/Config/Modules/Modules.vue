<template>

  <AuthenticatedLayout title="Modulos">
      
    <template #header>
      <div class="row mb-2">
      
        <div class="col-sm-6">
            <h1 class="m-0"> Modulos</h1>
        </div>
        
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                
              <li class="breadcrumb-item">
                <Link :href="'/dashboard'" >
                  Inicio
                </Link>
              </li>

              <li class="breadcrumb-item active">Modulos</li>

            </ol>
        </div>
        
      </div>
    </template>

    <div class="row">

      <div class="col-lg-12">

        <div class="card">

            <div class="card-header">
              
              <h3 class="card-title">Lista de roles</h3>

            </div>
            
            <div class="card-body">

              <table class="table table-bordered" >
                
                <thead>
                  
                  <tr>
                    <th style="width: 10px">#</th>
                    <th style="width: 10px">Icono</th>
                    <th>Modulo</th>
                    <th>Permiso</th>
                    <th style="width:15%">Estado</th>
                    <th style="width: 174px ;">Acciones</th>
                  </tr>

                </thead>
                
                <tbody v-if="!validate_.loading">
                  
                  <tr v-for=" ( item , i ) in roles_ " :key="i" >

                    <td> {{ item.id }}</td>
                    <td style="text-align: center;"> 
                      <i :class="item.icon" ></i>
                    </td>
                    <td> {{ item.name }} </td>
                    <td> {{ item.module_permissions }} </td>
                    <td style="text-align: center;"> 
                      <div class="form-group" style="text-align: center;" v-if=" item.module_group == '0' ">
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" :id="item.id" :checked="item.active" :disabled="validate_.loading_" @change="changeState( item.id )">
                          <label class="custom-control-label" :for="item.id"></label>
                        </div>
                      </div>
                      <span class="badge badge-danger" v-if=" item.module_group != '0' "> SUB</span> 
                      <span class="badge badge-info" v-if=" item.module_group != '0' "> {{item.main_module }} </span> 
                    </td>
                    <td >
                      
                      <Link :href=" '/permissions/roles/'+item.id " class="btn btn-sm btn-outline-info mr-1">
                        <i class="fa fa-list"></i>
                      </Link>

                      <button type="button" class="btn btn-sm btn-outline-primary mr-1" @click="show( item )">
                        <i class="fa fa-eye"></i>
                      </button>

                      <button type="button" class="btn btn-sm btn-outline-warning mr-1" @click="edit( item )">
                        <i class="fa fa-edit"></i>
                      </button>

                    </td>

                  </tr>

                </tbody>

              </table>

            </div>

            <div class="overlay dark " v-if="validate_.loading">
              <div class="spinner-border m-5 text-light" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>
            
            <div class="card-footer clearfix">
              <ul class="pagination pagination-sm m-0 float-right">
                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
              </ul>
            </div>
            
        </div>

      </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_rol" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel" v-if=" validate_.create ">Modal crear</h5>
            <h5 class="modal-title" id="staticBackdropLabel" v-if=" validate_.edit ">Modal editar</h5>
            <h5 class="modal-title" id="staticBackdropLabel" v-if=" validate_.view ">Modal ver</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

            <form @submit.prevent="" class="row" style="margin-bottom: 15px;">

              <div class="form-group col-6" id="div_name">
                <label for="name"> Modulo </label>
                <input type="text" class="form-control" id="name_name"  placeholder="Nombre rol" v-model="data_.form.name" :disabled="validate_.view">
              </div>

              <div class="form-group col-6" id="div_name">
                <label for="name"> Jerarquia </label>
                <input type="text" class="form-control" id="name_jerarquia"  placeholder="Nombre rol" v-model="data_.form.jerarquia" :disabled="validate_.view">
              </div>
            
              <div class="form-group col-6" id="div_name">
                <label for="name"> Icon </label>
                <input type="text" class="form-control" id="name_icon"  placeholder="Nombre rol" v-model="data_.form.icon" :disabled="validate_.view">
              </div>
              
              <div class="form-group col-6" id="div_name">
                <label for="name"> Permisos </label>
                <input type="text" class="form-control" id="name_class"  placeholder="Nombre rol" v-model="data_.form.module_permissions" :disabled="validate_.view">
              </div>

              <div class="form-group col-6" id="div_name">
                <label for="name"> Es grupo </label>
                <select name="type" class="form-control" id="type" v-model="data_.form.group" :disabled="validate_.view" >
                  <option value=""> Seleccionar una opción </option>
                  <option :value="true"> Si </option>
                  <option :value="false"> No </option>
                </select>
              </div>

              

              <div class="form-group col-6" id="div_name">
                <label for="name" v-if="data_.form.group"> Nombre grupo </label>
                <label for="name" v-else> Grupo </label>
                <input type="text" class="form-control" id="name"  placeholder="Nombre rol" v-model="data_.form.route" :disabled="validate_.view" v-if="data_.form.group">
                <input type="text" class="form-control" id="name"  placeholder="Nombre rol" v-model="data_.form.module_permissions" :disabled="validate_.view" v-else>
              </div>

              <div class="form-group col-12" id="div_name" v-if="!data_.form.group">
                <label for="name" v-if="data_.form.group"> Nombre grupo </label>
                <label for="name" v-else> Ruta </label>
                <input type="text" class="form-control" id="name"  placeholder="Nombre rol" v-model="data_.form.route" :disabled="validate_.view" >
              </div>


              <div class="container" style="background:currentColor;margin-butom: 16px;">

                <div class="row justify-content-md-center">
                  <div class="form-group"  id="div_description" style="margin-top: 16px;" >

                    <a id="menu_pruebas" class="btn btn-primary" style="width: 233px;">
                      <i class="nav-icon pr-2" :class="data_.form.icon"></i>
                      <b> {{ data_.form.name == '' ? "Titulo de prueba" : data_.form.name }}   </b>
                      <i class="right fas fa-angle-left" style="margin-top: 4px;right: 30%;position: absolute;"></i>
                    </a>

                  </div>
                </div>

              </div>


            </form>

            <button type="button" class="btn btn-primary" v-if=" validate_.create" @click="store()">Crear</button>
            <button type="button" class="btn btn-warning" v-if=" validate_.edit " @click="update()">Actualizar</button>
            <button type="button" class="btn btn-info" v-if=" validate_.view " @click="edit(data_.form)">Editar</button>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>

</template>

<style lang="css">

  input[type="checkbox" i] {
      background-color: red !important;
      cursor: default;
      appearance: auto;
      box-sizing: border-box;
      margin: 3px 3px 3px 4px;
      padding: initial;
      border: initial;
  }

</style>

<script setup>

  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { useForm } from '@inertiajs/vue3'
  import { Link } from '@inertiajs/vue3';
  import { reactive , ref , onMounted } from 'vue'
  import errors_ from '@/scripts/keller_validate.js';

  import Swal from 'sweetalert2'
  

  let data_ = reactive({
    form: {
      name: '',
      description:''
    } ,
  });

  const validate_ = reactive({
    edit: false,
    create: false,
    view: false,
    view: false,
    loading: true,
    loading_: false,
  });
  let errors_temp = reactive( {} );
  let roles_ = reactive( [] );

  onMounted(() => {
    get();
    activeMenu( 'config ' , 'modules' );
  });

  function activeMenu( menu , sub )
  {
    $( ".menu_"+ menu ).addClass( 'menu-is-opening menu-open')
    $( "#menu_"+ menu).addClass( 'active')
    $(  "#sub_menu_"+ sub).addClass( 'active')
  }
  
  function create() {
    validate_.create  = true;
    validate_.edit    = false;
    validate_.view    = false;
    $("#modal_rol").modal("show");
  }
  function edit( item ) {
    validate_.edit    = true;
    validate_.create  = false;
    validate_.view    = false;
    
    data_.form = Object.assign( {} , item ) ;
    
    $("#modal_rol").modal("show");
  }
  function show( item ) {
    validate_.view    = true;
    validate_.create  = false;
    validate_.edit    = false;
    data_.form = Object.assign( {} , item ) ;
    $("#modal_rol").modal("show");
  }
 
  function get() {
    
    validate_.loading = true;

    axios.get( '/modules' )
    .then(function ( response ) {
      roles_ = response.data;
      validate_.loading = false;
    })
    .catch(function (response) {
      let errors = response.response.data.errors
      errors_( errors , errors_temp );
      errors_temp = errors;
    });

  }
  function store() {
    axios.post( '/permissions/roles' , data_.form )
    .then(function ( response ) {

      $("#modal_rol").modal("hide");

      Swal.fire(
        '¡Buen trabajo!',
        'Recurso creado correctamente!',
        'success'
      );
      get();

    })
    .catch(function (response) {
      let errors = response.response.data.errors
      errors_( errors , errors_temp );
      errors_temp = errors;
    });
    return;
  }
  function update() {
    axios.put( '/modules/'+data_.form.id  , data_.form )
    .then(function ( response ) {
      get();
      $("#modal_rol").modal("hide");
      validate_.loading_ = false;
      Swal.fire(
        '¡Buen trabajo!',
        'Recurso actualizado correctamente!',
        'success'
      );
    })
    .catch(function (response) {
      let errors = response.response.data.errors
      errors_( errors , errors_temp );
      errors_temp = errors;
    });
    return;
  }
  function changeState( id ){
    
    let Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    validate_.loading_ = true;

    axios.put( '/modules/'+id+'/change'  )
    .then(function ( response ) {
      Toast.fire({
        icon: 'success',
        title: 'Actualizado.'
      });
      setTimeout(() => {
        validate_.loading_ = false;
      }, 111 );
    })
    .catch(function (response) {
      let errors = response.response.data.errors
      errors_( errors , errors_temp );
      errors_temp = errors;
    });
  }
  function destroy( id ) {

    Swal.fire({
      title: '¿Está seguro?',
      text: "¡No podrás revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Sí, bórralo!'
    }).then((result) => {
      if (result.isConfirmed)
      {

        axios.delete( '/permissions/roles/'+id )
        .then(function (response) {
          get()
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          );
        })
        .catch(function (error) {
          console.log(error);
        });
        
      }
    });

    return;
  }

</script>
