<template lang="pug">
div( aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;")
  .toast(role='alert' ref="toast" aria-live='assertive' aria-atomic='true' style="position: absolute; top: 0; right: 0;")
    .toast-header
      img.rounded.mr-2(src='' alt='...')
      strong.mr-auto Bootstrap
      small.text-muted 2 seconds ago
      button.ml-2.mb-1.close(type='button' data-dismiss='toast' aria-label='Close')
        span(aria-hidden='true') &times;
    .toast-body
      | Heads up, toasts will stack automatically

</template>

<script>
  export default {
    name: "Toast",
    data() {
      return {
        show: false
      }
    },
    methods: {
      show() {
        this.show = true
        $(this.$refs.toast).toast("show");
      },
      hide() {
        $(this.$el).toast("hide");
      }
    },
    mounted() {
      $('.toast').toast()
    }
  }
</script>

<style scoped>

</style>
