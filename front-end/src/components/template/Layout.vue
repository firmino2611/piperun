<template>
  <div id="app">
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#">
              <i class="fas fa-bars"></i>
            </a>
          </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
              <input
                class="form-control form-control-navbar"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </form>
          <li  class="nav-item dropdown">
            <router-link to="/" class="nav-link">
              <i class="fa fa-caret-down"></i> Oi, Lucas
            </router-link>
            <!-- <a class="nav-link d-none d-sm-block" data-toggle="dropdown" href="#">
              <i class="fa fa-caret-down"></i> Oi, {{ store.user.name }}
            </a> -->
          </li>
          <!-- Notifications Dropdown Menu -->
          <list-notification />
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a
          href="index3.html"
          class="brand-link"
          align="center"
          style="background: white; padding-top: 1px; padding-bottom: 1px;"
        >
          <img
            src="/static/img/brand/piperun.png"
            alt="Pipe Run"
            class="brand-text"
            height="53px"
            style="opacity: .8"
          />
          <!-- <span class="brand-text font-weight-light">Mobi Plus</span> -->
        </a>
    

        <!-- Sidebar -->
        <div class="sidebar">
          <navbar />
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <slot name="header" />
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
          <div class="container-fluid">
            <br>
            <slot></slot>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline"></div>
        <!-- Default to the left -->
        <strong>
          Copyright &copy; 2020
          <a href="https://adminlte.io">Mobi Plus Tecnologia</a>.
        </strong> Todos os direitos reservados
      </footer>
      <div @click="toogleSidebar()" id="sidebar-overlay"></div>
    </div>
  </div>
  <!-- ./wrapper -->
</template>

<script>
import ListNotification from "../../components/generics/notification/ListNotifications";
import Navbar from "../../components/generics/navbar/Navbar";
import store from "./../../store";

export default {
  components: {
    ListNotification,
    Navbar
  },
  data() {
    return {

    };
  },
  methods: {
    toogleSidebar() {
      $("body").removeClass("sidebar-open");
      $("body").addClass("sidebar-collapse");
    }
  },
  computed: {
    showFooterNavbar() {
      return $("body").hasClass("sidebar-collapse");
    }
  },

  mounted() {

  }
};
</script>

<style scoped>
.nav-header-custom {
  padding-left: 25px;
  padding-bottom: 20px;
  padding-top: 30px;
  font-weight: bold;
  font-size: 14pt;
}
</style>
