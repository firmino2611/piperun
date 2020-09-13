<template lang="pug">
.card(style="border-radius: 20px" )
  .card-header(v-if='showHeader')
    //Todo: criar campo de pesquisa
    h3.card-title.text-bold {{ title }}
    .card-tools(style='')
      slot(name='tools')
  // /.card-header
  .card-body(:class="{'p-0': !padding, 'p-3': padding}")
    slot
  .card-footer(v-if='showFooter')
    slot(name='footer')
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: ''
    },
    padding: {
      type: Boolean,
      default: false
    },
    showHeader: {
      type: Boolean,
      default: true
    },
    showFooter: {
      type: Boolean,
      default: false
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
