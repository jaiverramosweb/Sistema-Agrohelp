<template>

  <aside class="main-sidebar elevation-4" style="background-color: #487045;">
    <!-- <aside class="main-sidebar sidebar-dark-primary elevation-4"> -->

    <!-- Brand Logo -->
    <!-- <Link :href="route('dashboard')" class="brand-link">
      <img src="/assets/admin-lte/dist/img/wolke.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">ller v3</span>
    </Link> -->

    <div style="border-bottom: 1px solid rgb(159, 151, 151); padding: 5px;">
      <a href="/dashboard">
        <img
          src="https://play-lh.googleusercontent.com/IL5kcim7yAHkP1WtooLFdTDgDujb0ZcW65m4160WY86PM896U_x1hAAfpQ28Mgrsb_8"
          alt="Kellerv4 Logo" style="width: 40%; margin-left: 25%;" class="brand-image img-circle elevation-3">
        <!-- <img src="/assets/admin-lte/dist/img/wolke.png" alt="Kellerv4 Logo" style="width: 60%; margin-left: 20%;"> -->
      </a>
    </div>

    <div class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-2 mb-2 d-flex">

        <div class="info">

          <Link :href="route('profile.edit')" class="d-block" style="color: white;">
          {{ $page.props.auth.user.nombre + ' ' + $page.props.auth.user.apellido }}
          <br>
          <small v-if="$page.props.auth.role">{{ $page.props.auth.role.name }}</small>
          </Link>
        </div>
      </div>



      <hr align="left" noshade="noshade" size="2" width="100%" />


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <Link :href="route('dashboard')" class="nav-link menu_inicio">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Inicio
            </p>
            </Link>
          </li>

          <template v-for=" ( item, i ) in $page.props.auth.modules " :key="i">

            <li :id="'menu_aside_' + item.id" class="nav-item" style="margin-top:5px;"
              v-if="item.module_group == '0' && !item.group">
              <Link :id="'menu_' + item.module_permissions" :href="item.route" class="nav-link menu_inicio">
              <i class="nav-icon" :class="item.icon"></i>
              <p>
                {{ item.name }}
              </p>
              </Link>
            </li>

            <li :id="'menu_aside_' + item.id" :class="'menu_' + item.module_permissions" style="margin-top:8px;"
              class="nav-item" v-if="item.group">

              <a :id="'menu_' + item.module_permissions" href="#" class="nav-link menu_inicio"
                @click=" menuColpse(item.id)">
                <i class="nav-icon " :class="item.icon"></i>
                <p>
                  {{ item.name }}
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview" style="background: #134D0D;border-radius: 3px;padding: 1px;">

                <template v-for=" ( sub_item, i ) in item.items " :key="i">
                  <li class="nav-item">
                    <Link :id="'sub_menu_' + sub_item.module_permissions" :href="sub_item.route"
                      class="nav-link menu_inicio">
                    <i class="nav-icon" :class="sub_item.icon"></i>
                    <p>
                      {{ sub_item.name }}
                      <!-- <span class="right badge badge-danger">Nuevo</span> -->
                    </p>
                    </Link>
                  </li>
                </template>

              </ul>

            </li>

          </template>


        </ul>
      </nav>

    </div>

  </aside>

</template>

<script setup>

import { Link } from '@inertiajs/vue3';


const menuColpse = (menu) => {
  let test = $("#menu_aside_" + menu).hasClass("menu-open");
  if (test) {
    $("#menu_aside_" + menu).removeClass("menu-is-opening menu-open")
  } else {
    $("#menu_aside_" + menu).addClass("menu-is-opening");
    setTimeout(() => {
      $("#menu_aside_" + menu).addClass("menu-open");
    }, 111);
  }
}

</script>

<style scoped>
.menu_inicio:hover {
  background: #9EC49A;
}

/* .active {
  background: #9EC49A !important;
} */
</style>