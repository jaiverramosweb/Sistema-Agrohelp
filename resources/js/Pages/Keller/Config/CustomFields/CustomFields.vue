<template>

  <AuthenticatedLayout title="Campos personalizados">
      
    <template #header>
      <div class="row mb-2">
      
        <div class="col-sm-6">
            <h1 class="m-0"> Campos personalizados</h1>
        </div>
        
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item">
                <Link :href="route('permissions.index')" >
                  Configuraciones
                </Link>
              </li>

              <li class="breadcrumb-item active">Campos personalizados</li>

            </ol>
        </div>
        
      </div>
    </template>

    <div class="row">

      <div class="col-lg-12">

        <div class="card">

            <div class="card-header">
              
              <h3 class="card-title">Lista de campos personalizados</h3>

              <div class="card-tools">
                <button class=" btn btn-sm btn-primary" @click="create()">
                  <i class='fas fa-plus'></i> 
                  Crear rol
                </button>
              </div>

            </div>
            
            <div class="card-body">

              <table class="table table-bordered" >
                
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th style="width: 10px">Icono</th>
                    <th>Título</th>
                    <th>Nombre rol</th>
                    <th>Tipo campo</th>
                    <th>Formulario</th>
                    <th style="width: 174px ;">Acciones</th>
                  </tr>
                </thead>
                
                <tbody v-if="!validate_.loading">
                  
                  <tr v-for=" ( item , i ) in list_ " :key="i" >

                    <td> {{ item.id }}</td>
                    <td style="text-align: center;"> <i :class="item.icon"></i></td>
                    <td> {{ item.title }} </td>
                    <td> {{ item.name }} </td>
                    <td> {{ item.type_field }} </td>
                    <td> {{ item.form_name }} </td>
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

                      <button type="button" class="btn btn-sm btn-outline-danger mr-1" @click="destroy( item.id )">
                        <i class="fa fa-trash"></i>
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
    <div class="modal fade" id="modal_elemnt" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
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

            <form @submit.prevent="" >

              <div class="row" >

                <div class="form-group col-6" id="div_name">
                  <label for="name"> jerarquia </label>
                  <input type="text" class="form-control" id="name_jerarquia"  placeholder="Nombre rol" v-model="element_.form.jerarquia" :disabled="validate_.view">
                </div>
                <div class="form-group col-6" id="div_name">
                  <label for="name"> title </label>
                  <input type="text" class="form-control" id="name_title"  placeholder="Nombre rol" v-model="element_.form.title" :disabled="validate_.view">
                </div>
                <div class="form-group col-6" id="div_name">
                  <label for="name"> id_input </label>
                  <input type="text" class="form-control" id="name_id_input"  placeholder="Nombre rol" v-model="element_.form.id_input" :disabled="validate_.view">
                </div>
                <div class="form-group col-6" id="div_name">
                  <label for="name"> name </label>
                  <input type="text" class="form-control" id="name_name"  placeholder="Nombre rol" v-model="element_.form.name" :disabled="validate_.view">
                </div>
                
                <div class="form-group col-6" id="div_name">
                  <label for="name"> type </label>
                  <input type="text" class="form-control" id="name_type"  placeholder="Nombre rol" v-model="element_.form.type" :disabled="validate_.view">
                </div>
                <div class="form-group col-6" id="div_name">
                  <label for="name"> class </label>
                  <input type="text" class="form-control" id="name_class"  placeholder="Nombre rol" v-model="element_.form.class" :disabled="validate_.view">
                </div>
                <div class="form-group col-6" id="div_name">
                  <label for="name"> icon </label>
                  <input type="text" class="form-control" id="name_icon"  placeholder="Nombre rol" v-model="element_.form.icon" :disabled="validate_.view">
                </div>

                <div class="form-group col-6" id="div_name">
                  <label for="name"> Formularios </label>
                  <select class='form-control'   id="genero" v-model="element_.form.fk_form_id" :disabled="element_.form.type_field == 'static' " >
                    <option value="" disabled >Seleccionar una opción</option>
                    <option  v-for=" ( item , i ) in forms " :value="item.id" :key="i">
                      {{ item.name }}
                    </option>
                  </select>
                </div>

             

                <div class="container">

                  <div class="row justify-content-md-center">
                    <div class="form-group iscf" :class="element_.form.class" id="div_description"  >

                      <label for="description" > 
                        <b> {{ element_.form.title == '' ? "Titulo de prueba" : element_.form.title }}  <span class="text-danger">*</span>  </b>
                      </label>
                      
                      <div class="input-group mb-3 input-group-sm" id="div_nombre">

                        <div class="input-group-prepend">
                          <span class="input-group-text"><i :class="element_.form.icon"></i></span>
                        </div>
                        <input :type="text" class="form-control"  placeholder="Nombre rol"  :disabled="validate_.view">
                      
                      </div>

                    </div>
                  </div>

                </div>


              </div>


              <button type="button" class="btn btn-primary" v-if=" validate_.create" @click="store()">Crear</button>
              <button type="button" class="btn btn-warning" v-if=" validate_.edit " @click="update()">Actualizar</button>
              <button type="button" class="btn btn-info" v-if=" validate_.view " @click="edit(element_.form)">Editar</button>

            </form>

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
  .iscf{
    background: royalblue;
    border-radius: 4px;
    margin: 10px;
    padding: 17px;
  }
</style>

<script setup>

  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { useForm } from '@inertiajs/vue3'
  import { Link } from '@inertiajs/vue3';
  import { reactive , ref , onMounted } from 'vue'
  import errors_ from '@/scripts/keller_validate.js';

  import Swal from 'sweetalert2'
  
  const props = defineProps( [ 'role' , 'permissions' , 'role_permissions' , 'forms' ] );

  let element_ = reactive({
    form: {
      name: '',
      description:''
    } ,
  });

  const pag_ = reactive({
    show: false,
    search: "",
    order_cell: "id",
    order_type: "ASC",
  });
  let pagination = reactive({
    total: 0,
    current_page: 0,
    per_page: 0,
    last_page: 0,
    from: 0,
    to: 0,
  });
  const validate_ = reactive({
    edit: false,
    create: false,
    view: false,
    view: false,
    loading: true,
  });
  let errors_temp = reactive( {} );
  let list_ = reactive( [] );

  onMounted(() => {
    get();
    activeMenu( 'config' , 'custom_fields' );
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
    element_.form = {}
    $("#modal_elemnt").modal("show");
  }
  function edit( item ) {
    validate_.edit    = true;
    validate_.create  = false;
    validate_.view    = false;
    
    element_.form = Object.assign( {} , item ) ;
    
    $("#modal_elemnt").modal("show");
  }
  function show( item ) {
    validate_.view    = true;
    validate_.create  = false;
    validate_.edit    = false;
    element_.form = Object.assign( {} , item ) ;
    $("#modal_elemnt").modal("show");
  }

  function get(page) {
    
    validate_.loading = true;

    let pay_load = { 
      "page": page,
      "show": pag_.show,
      "search": pag_.search,
      "order_field": pag_.order_cell,
      "order_type": pag_.order_type
    };

    axios.post( '/custom-fields/pagination' , pay_load )
    .then(function ( response ) {
      
      list_ = response.data.data.data;
      pagination = response.data.pagination;
      validate_.loading = false;

    })
    .catch(function (response) {
      
    });

  }
  function store() {

    axios.post( '/custom-fields' , element_.form )
    .then(function ( response ) {

      $("#modal_elemnt").modal("hide");

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

    axios.put( '/custom-fields/'+element_.form.id  , element_.form )
    .then(function ( response ) {
      get();
      
      $("#modal_elemnt").modal("hide");

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
