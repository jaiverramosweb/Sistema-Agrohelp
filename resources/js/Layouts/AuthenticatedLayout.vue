<template>

  <div class="wrapper">

    <Head :title="title" />

    <Navigation/>

    <Aside/>

    <div class="content-wrapper">
      
      <div class="content-header">
        <div class="container-fluid">

          <slot name="header" />

        </div>
      </div>
      
      <div class="content">
        <div class="container-fluid">

          <slot />

        </div>
      </div>

    </div>
    
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>
    
    <footer class="main-footer">
      
      <div class="float-right d-none d-sm-inline">
        keller V-4.0
      </div>
      
      <strong>Copyright &copy; 2015 - 2024  <a href="https://www.wolke.com.co/">WOLKE SAS</a>.</strong> Todos los derechos reservados.

    </footer>

  </div>
  
</template>

<script setup>

  import { ref , onMounted } from 'vue';
  import { Head } from '@inertiajs/vue3';

  import Navigation from './Components/Navigation.vue';
  import Aside from './Components/AsideMenu.vue';

  onMounted( () => {

    if ( document.querySelector("#body_id.login-page") ) {
      $("#body_id").removeClass("login-page");
    }


  
    document.addEventListener( 'load' , closeOnEscape ) 
    
  });

  const closeOnEscape = (e) => {
    
    alert( "Close" );

  };

  const showingNavigationDropdown = ref(false);

  defineProps({
    title: {
      type: String,
    },
  });



</script>
