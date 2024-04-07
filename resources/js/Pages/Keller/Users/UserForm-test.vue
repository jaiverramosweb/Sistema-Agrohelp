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
                    
                    <li class="breadcrumb-item">
                      <a href="#"></a>
                      <Link :href="route('users.index')" >
                        Usuarios
                      </Link>
                    </li>

                    <li class="breadcrumb-item active">Crear</li>
                </ol>
            </div>
            
        </div>
    </template>

    <div class="row">

      <div class="col-lg-12">

        <div class="card">
          
          <div class="card-header">
            
            <h3 class="card-title">Crear usuario</h3>

          </div>

          <div class="card-body">
            
            <form >

              <div class="row">
              
                <div class="form-group col-6">
                  <label for="exampleFormControlInput1">Email address</label>
                  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                </div>

                <div class="form-group col-6">
                  <label for="exampleFormControlSelect1">Example select</label>
                  <select class="form-control" id="exampleFormControlSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>

              </div>

              <div class="row">

                <div class="form-group col-6">
                  <label for="exampleFormControlSelect2">Example multiple select</label>
                  <select multiple class="form-control" id="exampleFormControlSelect2">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>

                <div class="form-group col-12">
                  <label for="exampleFormControlTextarea1">Example textarea</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>

              </div>

            </form>


          </div>
          
        </div>

      </div>
      
    </div>

  </AuthenticatedLayout>

</template>

<script setup>

  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Link } from '@inertiajs/vue3';


  defineProps({
    users: {
      type: Array,
    },
  });

</script>
