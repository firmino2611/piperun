<template>
  <nav class="mt-2">
    <ul
      class="nav nav-pills nav-sidebar flex-column"
      data-widget="treeview"
      role="menu"
      data-accordion="false"
    >
      <!-- Add icons to the links using the .nav-icon class
      with font-awesome or any other icon font library-->
      <li class="nav-header nav-header-custom">GERENCIAR</li>
      <li class="nav-item has-treeview menu-open" :class="{'active': path === '/atividades'}">
        <router-link to="/atividades" class="nav-link">
          <i class="nav-icon fas fa-list" />
          <p>Tarefas</p>
        </router-link>
      </li>
       <li class="nav-item has-treeview menu-open" :class="{'active': path === '/tipos'}">
        <router-link to="/tipos" class="nav-link">
          <i class="nav-icon fas fa-bookmark" />
          <p>Tipos</p>
        </router-link>
      </li>
     

      <li class="nav-item has-treeview menu-open">
        <a
          href="#!"
          class="nav-link" @click="logout()"
          >
          <i class="nav-icon fas fa-sign-out-alt"></i>
          <p>Sair</p>
        </a>
      </li>
    </ul>
  </nav>
</template>
<script>
import Storage from 'local-storage-firmino'

export default {
  data() {
    return {
      path: "",

    };
  },
  mounted() {
    this.path = window.location.pathname;
  },
  methods: {
    logout () { 
      Storage.delete('token-user')
      this.$router.push('/login')
    },

  },

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
.nav-item {
  font-weight: 300;
}
.nav-sidebar > .nav-item .nav-icon {
  margin-right: 15px;
}
.nav-sidebar .nav-header:not(:first-of-type) {
  padding: none;
}
</style>
