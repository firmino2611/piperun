<template>
  <table class="table table-hover text-nowrap table-responsive-lg">
    <thead>
      <slot name="header" />
      <tr>
        <th v-for="head in header" :key="head">{{ head }}</th>
      </tr>
    </thead>
    <tbody>
      <slot></slot>

      <tr v-if="empty && !loading">
        <td class="text-bold" :colspan="header.length" align="center">{{ message }}</td>
      </tr>
      <tr v-if="loading">
        <!-- <td v-if="empty" class="text-bold" colspan="4" align="center">{{ message }}</td> -->

        <td class="text-bold" :colspan="header.length" align="center">
          <span class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="sr-only">Loading...</span>
          </span>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: {
    empty: {
      type: Boolean,
      default: true,
    },

    header: {
      type: Array,
      default: [],
    },

    loading: {
      type: Boolean,
      default: true,
    },

    message: {
      type: String,
      default: "Nenhuma empresa cadastrada",
    },
  },
};
</script>
