<script setup>
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted } from 'vue';

onMounted(() => {
    getClient()
})

const getClient = () => {
    // axios.get('/info-cliente').then(res => {
    //     console.log(res.data)
    // })
}
</script>

<template>
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="#" class="navbar-brand">
                <img src="https://play-lh.googleusercontent.com/IL5kcim7yAHkP1WtooLFdTDgDujb0ZcW65m4160WY86PM896U_x1hAAfpQ28Mgrsb_8"
                    alt="Sufondos Logo" class="elevation-1" style="opacity: .8" width="160" height="80">
                <!-- <img src="/assets/admin-lte/dist/img/sufondos.png" alt="Sufondos Logo" class="elevation-1"
                    style="opacity: .8" width="160" height="80"> -->
                <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->
            </a>
            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/inicio" class="nav-link">Inicio</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="/pqr" class="nav-link">PQR</a>
                    </li> -->

                </ul>

            </div>

            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

                <li class="nav-item">
                    <Link :href="route('logout')" method="post" class="nav-link">
                    <i class="fas fa-sign-out-alt icon-nav"></i>
                    </Link>
                </li>

            </ul>
        </div>
    </nav>
</template>