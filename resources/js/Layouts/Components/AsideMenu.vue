<template>

  <aside class="main-sidebar sidebar-white elevation-4" style="background-color:white;">


    <div style="border-bottom: 1px solid rgb(159, 151, 151); padding: 5px;">
      <a href="/dashboard">
        <img src="/assets/images/agrohelp.png" alt="CGR Logo" style="width: 60%; margin-left: 20%;">
      </a>
    </div>

    <div class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="info">

          <!-- <Link :href="route('profile.edit')" class="d-block" style="color: black">
            {{ $page.props.auth.user.nombre+' '+ $page.props.auth.user.apellido }}
            <br>
            <small>{{ $page.props.auth.role.name }}</small>
          </Link> -->

          {{ $page.props.auth.user.nombre + ' ' + $page.props.auth.user.apellido }}
          <br>
          <small>{{ $page.props.auth.role.name }}</small>

        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
          data-accordion="false">

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
              <Link :id="'menu_' + item.module_permissions" :href="item.route" class="nav-link">
              <i class="nav-icon" :class="item.icon"></i>
              <p>
                {{ item.name }}
              </p>
              </Link>
            </li>

            <li :id="'menu_aside_' + item.id" :class="'menu_' + item.module_permissions" style="margin-top:8px;"
              class="nav-item" v-if="item.group">

              <a :id="'menu_' + item.module_permissions" href="#" class="nav-link" @click=" menuColpse(item.id)">
                <i class="nav-icon " :class="item.icon"></i>
                <p>
                  {{ item.name }}
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">

                <template v-for=" ( sub_item, i ) in item.items " :key="i">
                  <li class="nav-item">
                    <Link :id="'sub_menu_' + sub_item.module_permissions" :href="sub_item.route" class="nav-link">
                    <i class="nav-icon" :class="sub_item.icon"></i>
                    <p>
                      {{ sub_item.name }}
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

<style>
.nav-link.active.keller {
  color: #1a1919;
  border-right: 5px solid #334b65;
  background: #e6e6e6 !important;
}
</style>