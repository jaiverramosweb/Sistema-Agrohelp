<template>
    
  <div class="login-box"  v-if=" !loader ">
    
    <Head title="Reset Password" />
  
    <div class="card card-outline card-primary">
        
        <div class="card-header text-center">
        
          <a href="/" class="h1">
              <img src="/assets/backoffice/dist/img/vite.svg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3 border border-black" style="opacity: .8;margin-top: -6px;margin-right: 6px;">
              <b>
              {{$page.props.appName}}
              </b>  
          </a>

        </div>

        <div class="card-body">

          <form id="login_form" @submit.prevent="submit">
              
              <div class="input-group mb-3">
                <input type="text" name="email" class="form-control" v-model="form.email" placeholder="Correo electrónico o Nombre de usuario" required disabled>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                    </div>
                </div>
                <InputError class="mt-2" :message="form.errors.email" />
              </div>
              
              <div class="input-group">
                <input :type="show_pass ? 'text' : 'password' " name="password" class="form-control" v-model="form.password" placeholder="Contraseña" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
              </div>

              <div class="row mb-3">
              
                <div class="col-2">
                    <i class="fas fa-eye-slash" @click="showPass(1)" v-if="!show_pass" ></i>
                    <i class="fas fa-eye" @click="showPass(1)" v-else></i>
                </div>

              </div>

              <div class="input-group">
                <input :type="show_pass_two ? 'text' : 'password' " name="password" class="form-control" v-model="form.password_confirmation" placeholder="Contraseña" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
              </div>

              <div class="row mb-3">
              
                <div class="col-2">
                    <i class="fas fa-eye-slash" @click="showPass(2)" v-if="!show_pass_two" ></i>
                    <i class="fas fa-eye" @click="showPass(2)" v-else></i>
                </div>

              </div>
              
              <div class="row">
              
                <div class="col-12 col-sm-4 ">
                    <button type="submit" class="btn btn-primary btn-block" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                      Recuperar contraseña
                    </button>
                </div>
              
              </div>

          </form>

          <p class="mb-1">
              <Link href="/forgot-password" >
              Olvidé mi contraseña
              </Link>
          </p>
          <p class="mb-0">
              <Link href="/register" >
              Registrar una nueva membresía
              </Link>
          </p>

        </div>
        
    </div>

  </div>

</template>


<script setup>

  import { Head, useForm , Link } from '@inertiajs/vue3';
  import InputError from '@/Components/InputError.vue';

  import { ref , onMounted } from 'vue'

  const loader = ref(true);
  const show_pass = ref(false);
  const show_pass_two = ref(false);

  onMounted(() => {
    
    document.body.classList.add('login-page');
    setTimeout(() => {
      document.getElementById("body_id").removeAttribute("style");
      setTimeout(() => {
        loader.value = false;
      }, 111);
    }, 1111);

  });

  const props = defineProps({
    email: {
      type: String,
      required: true,
    },
    token: {
      type: String,
      required: true,
    },
  });

  const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
  });

  const submit = () => {
    form.post( route('password.store') , {
      onFinish: () => form.reset('password', 'password_confirmation'),
    });
  };

  const showPass = ( val ) => {

    if ( val == 1 ) {
      show_pass.value = show_pass.value ? false : true;
    }
    if ( val == 2 ) {
      show_pass_two.value = show_pass_two.value ? false : true;
    }

  };

</script>
