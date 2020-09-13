<template lang="pug">
  nav(aria-label='...' v-if="getPages > 1")
    ul.pagination.pagination-md
      li.page-item( @click="changePage(index)" v-for="(page, index) in getPages" aria-current='page')
        span.page-link(:class="{'bg-purple': index === currentPageIndex}" style='border-color: #6f42c1')
          | {{ index + 1 }}
          span.sr-only (current)
</template>

<script>
export default {
  props: {
    total: {
      type: Number,
      required: true
    },
    perPage: {
      type: Number,
      required: true
    },
    action: {
      type: Function,
      default: function (page) {
      }
    }
  },
  data() {
    return {
      count: 0,
      pages: 0,
      currentPageIndex: 0
    };
  },
  methods: {
    changePage(index) {
      this.currentPageIndex = index;
      this.$emit("onChangePage", index + 1);
    }
  },
  computed: {
    getPages() {

      this.count = this.total
      this.pages = Math.ceil(this.count / this.perPage);

      return this.pages;
    }
  },
  mounted() {
  }
};
</script>

<style scoped>
.page-link {
  color: #6f42c1;
  cursor: pointer;
}
</style>
