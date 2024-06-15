<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    tipo: '',
    documento: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <!-- <GuestLayout> -->

    <Head title="Registrar" />

    <div class="">

        <div class="preloader flex-column justify-content-center align-items-center" v-if="loader">
            <img class="animation__shake"
                src="https://infonegocios.info/content/images/2022/07/21/124804/conversions/mirada-agro-2021-campo-maquinaria-agricola-medium-size.jpg"
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

                            <p class="login-box-msg">Registro de usuario</p>

                            <form @submit.prevent="submit">

                                <!-- <div class="mt-4">
                                    <InputLabel for="email" value="Email" />

                                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"
                                        required autocomplete="username" />

                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div> -->
                                <div class="input-group mb-3">

                                    <!-- <input id="name" type="text" class="form-control" placeholder="Nombre completo"
                                        v-model="form.tipo" required autofocus> -->
                                    <select name="" id="" class="form-control" v-model="form.tipo">
                                        <option value="">Seleccione tipo de documento</option>
                                        <option value="CC">CC</option>
                                        <option value="NIT">NIT</option>
                                    </select>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>

                                </div>

                                <div class="input-group mb-3">

                                    <input id="name" type="text" class="form-control" placeholder="Numero de documento"
                                        v-model="form.documento" required>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>

                                </div>

                                <div class="input-group mb-3">

                                    <input id="name" type="text" class="form-control" placeholder="Nombre completo"
                                        v-model="form.name" required>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>

                                </div>

                                <div class="input-group mb-3">

                                    <input id="email" type="email" class="form-control" placeholder="Correo Electronico"
                                        v-model="form.email" required>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>

                                </div>
                                <InputError class="mt-2" :message="form.errors.email" />

                                <div class="input-group mb-3">
                                    <input id="password" type="password" class="form-control" placeholder="Contraseña"
                                        v-model="form.password" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <InputError class="mt-2" :message="form.errors.password" />

                                <!-- <div class="mt-4">
                                    <InputLabel for="password" value="Password" />

                                    <TextInput id="password" type="password" class="mt-1 block w-full"
                                        v-model="form.password" required autocomplete="new-password" />

                                    <InputError class="mt-2" :message="form.errors.password" />
                                </div> -->

                                <!-- <div class="mt-4">
                                    <InputLabel for="password_confirmation" value="Confirm Password" />

                                    <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                                        v-model="form.password_confirmation" required autocomplete="new-password" />

                                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                                </div> -->

                                <div class="input-group mb-3">
                                    <input id="password_confirmation" type="password" class="form-control"
                                        placeholder="Verificar Contraseña" v-model="form.password_confirmation"
                                        required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <InputError class="mt-2" :message="form.errors.password_confirmation" />

                                <div class="flex items-center justify-end mt-4">
                                    <button type="submit" class="btn btn-success btn-block"
                                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Registrar
                                    </button>

                                    <Link :href="route('login')"
                                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Ya estas registrado?
                                    </Link>

                                    <!-- <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Registrar
                                    </PrimaryButton> -->


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

    <!-- </GuestLayout> -->
</template>

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
