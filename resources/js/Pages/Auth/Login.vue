<template>

  <Head title="Inicio de sesión" />

  <div class="loginId ">

    <div class="">

      <div class="preloader flex-column justify-content-center align-items-center" v-if="loader">
        <img class="animation__shake"
          src="https://play-lh.googleusercontent.com/IL5kcim7yAHkP1WtooLFdTDgDujb0ZcW65m4160WY86PM896U_x1hAAfpQ28Mgrsb_8"
          alt="AdminLTELogo" height="60" width="60">
      </div>

      <div class="row">

        <div class="col-md-6 d-none d-sm-none d-md-block">
          <img class="img_resposive"
            src="https://infonegocios.info/content/images/2022/07/21/124804/conversions/mirada-agro-2021-campo-maquinaria-agricola-medium-size.jpg">
        </div>
        <div class="col-12 col-md-6">

          <div class="contenedor">

            <div class="card card-outline card-success w-card">

              <div class="card-header text-center text-green-600">
                <b>Agro</b>HELP
              </div>


              <div class="card-body">
                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                  {{ status }}
                </div>

                <p class="login-box-msg">Inicio de sesión</p>

                <form @submit.prevent="submit">

                  <div class="input-group mb-3">

                    <input id="email" type="email" class="form-control" placeholder="Email" v-model="form.email"
                      required autofocus>

                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>

                  </div>
                  <InputError class="mt-2" :message="form.errors.email" />

                  <div class="input-group mb-3">

                    <input id="password" type="password" class="form-control" placeholder="Password"
                      v-model="form.password" required>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>

                  </div>
                  <InputError class="mt-2" :message="form.errors.password" />

                  <div class="row">

                    <div class="col-7">
                      <div class="icheck-primary">
                        <input type="checkbox" id="remember" name="remember" v-model="form.remember">
                        <label for="remember">
                          recuerdame
                        </label>
                      </div>
                    </div>

                    <div class="col-5">
                      <button type="submit" class="btn btn-success btn-block" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Ingresar
                      </button>
                    </div>

                    <div class="col-7">
                      <div class="icheck-primary">
                        <Link :href="route('register')"
                          class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Aun no te has registrado?
                        </Link>
                      </div>
                    </div>

                  </div>

                </form>

                <!-- <p class="mb-1">
                  <Link v-if="canResetPassword" :href="route('password.request')">
                  Forgot your password?
                  </Link>
                </p> -->

              </div>

            </div>
          </div>
        </div>
      </div>
    </div>




  </div>

</template>

<script setup>

import InputError from '@/Components/InputError.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const loader = ref(true);

onMounted(() => {
  // var element = document.getElementById("body_id");
  // element.classList.add("hold-transition");
  // element.classList.add("login-page");
  // var element = document.getElementById("login_id");
  // element.style.margin = "100px";
  // element.style.width = "360px";
  // element.removeAttribute("style");
  setTimeout(() => {
    loader.value = false;
  }, 3000);
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};

</script>

<style scoped>
.img_resposive {
  height: 100vh;
  width: 100%;
}

.contenedor {
  width: 90%;
  margin-top: 30%;
}

.w-card {
  width: 70%;
  left: 20%;
}
</style>