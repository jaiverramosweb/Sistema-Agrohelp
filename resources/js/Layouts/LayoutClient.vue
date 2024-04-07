<script setup>
import { ref, onMounted } from 'vue';
import NavbarCient from './Components/NavbarClient.vue'

const loader = ref(true);

onMounted(() => {
    var element = document.getElementById("body_id");
    element.classList.remove("hold-transition");
    element.classList.remove("login-page");
    element.classList.remove("sidebar-mini");
    element.classList.add("layout-top-nav");

    setTimeout(() => {
        loader.value = false;
    }, 1000);
});


</script>

<template style="height: auto;">
    <div class="preloader flex-column justify-content-center align-items-center" v-if="loader">
        <img class="animation__shake" src="/assets/admin-lte/dist/img/sufondos.png" alt="AdminLTELogo" height="60"
            width="60">
    </div>

    <div class="wrapper">
        <NavbarCient />

        <div class="content-wrapper">

            <div class="content">
                <div class="container">

                    <slot />

                </div>
            </div>

        </div>



        <footer class="main-footer">

            <div class="float-right d-none d-sm-inline">
                keller V-4.0
            </div>

            <strong>Copyright &copy; 2015 - 2024 <a href="https://www.wolke.com.co/">WOLKE SAS</a>.</strong>
            Todos los derechos reservados.

        </footer>
    </div>
</template>