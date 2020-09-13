<template lang="pug">
  .card.card-tabs(style="border-radius: 20px" )
    .card-header.p-0.pt-1(v-if='showHeader')
      slot(name="header")

    // /.card-header
    .card-body(:class="{'p-0': !padding, 'p-3': padding}")
      slot
</template>

<script>
  export default {
    props: {

      padding: {
        type: Boolean,
        default: false
      },
      showHeader: {
        type: Boolean,
        default: true
      }
    }
  }
</script>

<style scoped>
  .row i{
    padding-right: 10px;
    font-size: 20px;
  }
</style>
