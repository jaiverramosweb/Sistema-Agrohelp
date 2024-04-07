<template>

  <div class="login-box" id="login_id" >

    <Head title="¿Olvidaste tu contraseña?" />
  
    <div class="card card-outline card-primary">
        
      <div class="card-header text-center">
          <a href="/" class="h1"><b>Admin</b>LTE</a>
          {{ fullName }}
      </div>
      
      <div class="card-body">
        <p class="login-box-msg">¿Olvidaste tu contraseña? Ningún problema. Simplemente háganos saber su dirección de correo electrónico y le enviaremos un enlace de restablecimiento de contraseña que le permitirá elegir una nueva..</p>
        <div v-if="status" class="mb-4 font-medium text-sm text-success">
          Hemos enviado por correo electrónico su enlace de restablecimiento de contraseña
        </div>
        <form @submit.prevent="submit">
          <div class="input-group mb-3">
              <input type="text" class="form-control" id="email" v-model="form.email" required autofocus autocomplete="username">
              <div class="input-group-append">
                  <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                  </div>
              </div>
          </div>
          <div class="row">
              <InputError class="mt-2" :message="form.errors.email" />
          </div>
          <div class="row">
              <div class="col-12">
                  <button type="submit" class="btn btn-primary btn-block" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                      Solicitar nueva contraseña
                  </button>
              </div>
          </div>
        </form>
        <p class="mt-3 mb-1">
            <Link href="/login" >
                Login
            </Link>
        </p>
      </div>

    </div>
  
  </div>

</template>



<script setup>

    import { Head, useForm , Link } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import GuestLayout from '@/Layouts/GuestLayout.vue';

    import { ref , onMounted } from 'vue'

    const loader = ref(true)

    onMounted(() => {

      var element = document.getElementById("body_id");
      element.classList.add("hold-transition"); 
      element.classList.add("login-page"); 
      var element = document.getElementById("login_id");
      element.style.margin = "100px"; 
      element.style.width = "360px"; 
        
      document.body.classList.add('login-page');
      setTimeout(() => {
        document.getElementById("body_auth").removeAttribute("style");
        setTimeout(() => {
          loader.value = false;
        }, 111);
      }, 1111);

    });

    defineProps({
        status: String,
    });

    const form = useForm({
        email: '',
    });

    const submit = () => {
        form.post(route('password.email'));
    };

</script>
