<template>
  <router-view></router-view>
</template>

<script>

export default {
  data() {
    return {
      path: window.location.pathname
    };
  },
  mounted() {
    console.log(this.path)
  },
  watch: {
    $route(to, from, next) {
      this.path = to.fullPath;
    }
  }
};
</script>
