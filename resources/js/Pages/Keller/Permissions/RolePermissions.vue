<template>

  <AuthenticatedLayout title="Pruebas Johann">
      
    <template #header>
      <div class="row mb-2">
      
        <div class="col-sm-6">
            <h1 class="m-0"> Rol - Permisos</h1>
        </div>
        
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item">
                <Link :href="route('permissions.index')" >
                  Roles
                </Link>
              </li>
              <li class="breadcrumb-item active">Permisos</li>

            </ol>
        </div>
        
      </div>
    </template>

    <div class="row">

      <div class="col-lg-12">

        <div class="card">

          <div class="card-header">
            
            <h3 class="card-title">Lista de permisos asignado a el rol: <b> {{ role.name }} </b> </h3>

          </div>
          
          <div class="card-body">

            <table class="table table-bordered" >
              
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Permiso</th>
                  <th>Ver</th>
                  <th>Crear</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
                  <th>Todos</th>
                </tr>
              </thead>
              
              <tbody v-if="!validate_.loading">
                
                <tr v-for=" ( item , i ) in table_.permissions " :key="i" >

                  <td> {{ item.id }}</td>
                  <td> {{ item.name }} </td>

                  <td>
                    <div class="form-check">
                      <input :id="'chk_view_'+item.module" class="form-check-input" type="checkbox" @click=" changeCheck( 'read' , item.module ) ">
                    </div>
                  </td>
                  <td> 
                    <div class="form-check">
                      <input :id="'chk_create_'+item.module" class="form-check-input" type="checkbox" @click=" changeCheck( 'create' , item.module ) ">
                    </div>
                  </td>
                  <td> 
                    <div class="form-check">
                      <input :id="'chk_edit_'+item.module" class="form-check-input" type="checkbox" @click=" changeCheck( 'update' , item.module ) ">
                    </div>  
                  </td>
                  <td> 
                    <div class="form-check">
                      <input :id="'chk_delete_'+item.module" class="form-check-input" type="checkbox" @click=" changeCheck( 'delete' , item.module ) ">
                    </div>
                  </td>
                  <td> 
                    <div class="form-check">
                      <input :id="'chk_all_'+item.module" class="form-check-input" type="checkbox" @click=" changeCheck( 'all' , item.module ) ">
                    </div>
                  </td>

                </tr>

                {{ checkear() }}

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

  </AuthenticatedLayout>

</template>

<script setup>

  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { useForm } from '@inertiajs/vue3'
  import { Link , router } from '@inertiajs/vue3';
  import { reactive , ref , onMounted } from 'vue'
  import InputError from '@/Components/InputError.vue';

  import cube from '../../../scripts/keller_validate.js';

  import Swal from 'sweetalert2'
  
  const props = defineProps( ['role' , 'permissions' , 'role_permissions' ] );

  const validate_ = reactive({
    edit: false,
    create: false,
    view: false,
    view: false,
    loading: true,
  });
  let errors_temp = reactive( {} );
  let table_ = reactive( {
    permissions:[]
  } );

  onMounted(() => {
    table_.permissions = props.permissions;
    role_permissions.value = props.role_permissions;
    validate_.loading = false;
  });
  

  const role_permissions = ref('')

  
 
  function get() {
    
    validate_.loading = true;

    axios.get( '/permissions/roles' )
    .then(function ( response ) {
      roles_ = response.data;
      validate_.loading = false;
    })
    .catch(function (response) {
      
    });

  }
  
  function changeCheck( crud , check ) {

    let payload = { field:crud , permissions: check};

    let Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    axios.put( '/permissions/roles/'+props.role.id+'/check'  , payload )
    .then( ( response ) => {
      console.log('permisos', response.data.data)
      role_permissions.value = response.data.data
      checkear()
      Toast.fire({
        icon: 'success',
        title: 'Permiso actualizado.'
      })

    })
    .catch(function (response) {

    });

    return;
  }

  function checkear(){
    
    setTimeout(() => {
      
      role_permissions.value.forEach(el => {

        $( "#chk_view_"+el.module ).prop( "checked" , el.read );
        $( "#chk_create_"+el.module ).prop( "checked" , el.create );
        $( "#chk_edit_"+el.module ).prop( "checked" , el.update );
        $( "#chk_delete_"+el.module ).prop( "checked" , el.delete );

        if( el.read && el.create && el.update && el.delete)
        {
          $( "#chk_all_"+el.module ).prop( "checked" , true );
        }else {
          $( "#chk_all_"+el.module ).prop( "checked" , false );
        }
        
      });
    }, 1000);

  }


</script>
