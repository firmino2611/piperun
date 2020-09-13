<template>
  <button
    :disabled="enable"
    @click.stop="action()"
    type="button"
    class="btn btn-block" :class="{'btn-primary': theme == 'primary', 'btn-success': theme == 'success'}"
  >
    <span v-if="loading" class="spinner-border spinner-border-sm text-light" role="status">
      <span class="sr-only">Loading...</span>
    </span>
    <slot></slot>
  </button>
</template>

<script>
  export default {
    props: {
      theme: {
        type: String,
        default: 'primary'
      },
      enable: {
        type: Boolean,
        default: false
      },
      action: {
        type: Function,
        default: function () {
        }
      },
      loading: {
        type: Boolean,
        default: false
      }
    },

    data() {
      return {
        isLoading: false
      }
    }
  }
</script>
