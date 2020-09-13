<template lang="pug">
  button(
    @click.stop="action()"
    type="button"
    class="btn"
    :class="themeClass"
    style="border-radius: 30px; padding: 15px 20px; position:fixed; bottom: 75px; right: 25px")
    i.fa(:class="icon")
</template>

<script>
  export default {
    name: "ButtonFloat",
    props: {
      theme: {
        type: String,
        default: 'primary'
      },
      icon: {
        type: String,
        default: 'fa-plus'
      },
      enable: {
        type: Boolean,
        default: false
      },
      action: {
        type: Function,
        default: function () {}
      },
      loading: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        themeClass: [`btn-${this.theme}`]

      }
    },
  }
</script>

<style scoped>

</style>
