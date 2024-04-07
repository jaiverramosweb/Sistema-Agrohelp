

<template>

  <div class="card card-primary card-outline">
    
    <div class="card-header">
      <h3 class="card-title">Actualiza contraseña</h3>
    </div>

    <div class="card-body">
        
      <p>Asegúrese de que su cuenta esté usando una contraseña larga y aleatoria para mantenerse seguro.</p>

      <div class="row">

        <div class="col-12">
            
          <form class="row"  @submit.prevent="updatePassword">

            <div class="col-12 form-group">
              <label for="current_password">Contraseña actual</label>
              <div class="input-group">
                <input :type="showText(pass1)"  class="form-control" id="current_password" ref="currentPasswordInput" placeholder="Contraseña actual" v-model="form.current_password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="fas fa-eye-slash" @click="showPass(1)" v-if="!pass1" ></i>
                    <i class="fas fa-eye" @click="showPass(1)" v-else></i>
                  </div>
                </div>
              </div>
              <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

  

            <div class="col-6 form-group">
              <label for="password">Nueva contraseña</label>
              <div class="input-group">
                <input :type="showText(pass2)" class="form-control" id="password" ref="passwordInput" placeholder="Contraseña actual" v-model="form.password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="fas fa-eye-slash" @click="showPass(2)" v-if="!pass2" ></i>
                    <i class="fas fa-eye" @click="showPass(2)" v-else></i>
                  </div>
                </div>
              </div>
              <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="col-6 form-group">
              <label for="password_confirmation">Confirmar contraseña</label>
              <div class="input-group">
                <input :type="showText(pass3)" class="form-control" id="password_confirmation" ref="passwordInput" placeholder="Contraseña actual" v-model="form.password_confirmation">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="fas fa-eye-slash" @click="showPass(3)" v-if="!pass3" ></i>
                    <i class="fas fa-eye" @click="showPass(3)" v-else></i>
                  </div>
                </div>
              </div>
              <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <div class="card-footer">
              
              <div class="alert alert-success" role="alert" v-if="form.recentlySuccessful">
                ACTUALIZADO
              </div>
              <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Actulizar
              </button>

            </div>

          </form>

        </div>


      </div>

    </div>

  </div>

</template>

<script setup>
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';

    const passwordInput = ref(null);
    const currentPasswordInput = ref(null);

    const pass1 = ref(false);
    const pass2 = ref(false);
    const pass3 = ref(false);

    const form = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    const updatePassword = () => {
        form.put(route('password.update'), {
            errorBag: 'updatePassword',
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: () => {
                if (form.errors.password) {
                    form.reset('password', 'password_confirmation');
                    passwordInput.value.focus();
                }

                if (form.errors.current_password) {
                    form.reset('current_password');
                    currentPasswordInput.value.focus();
                }
            },
        });
    };

    const showPass = ( val ) => {

      if ( val == 1 ) {
        pass1.value = pass1.value ? false : true;
      }
      if ( val == 2 ) {
        pass2.value = pass2.value ? false : true;
      }
      if ( val == 3 ) {
        pass3.value = pass3.value ? false : true;
      }

    };
    
    const showText = ( val ) => {
      let value = val ? 'text' : 'password' ;
      return value;
    };

</script>