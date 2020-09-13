<template>
  <div v-show="activeBackDrop" class="modal scrol-custom fade" :id="id" aria-modal="true" :data-backdrop="activeBackDrop ? 'static' : true" :data-keyboard="!activeBackDrop" style="display: none; border-radius: 0px">
    <div class="modal-dialog modal-dialog-scrollable"
         :class="{'modal-sm': size === 'small', 'modal-lg': size === 'large', 'modal-xl': size === 'extra-large'}">
      <div class="modal-content" style="border-radius: 15px">
        <div class="modal-header" style="padding: 5px 15px">
          <h4 class="modal-title" style="font-size: 14pt; font-weight: bold">{{ title }}</h4>
<!--          <button class="close btn" data-dismiss="modal" aria-label="Close">-->
<!--            <i aria-hidden="true" class="fa fa-edit" style="color: red; font-size: 1px"></i>-->
<!--          </button>-->
          <button type="button" class="close" @click="hide()">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body scrol-custom">
          <slot></slot>
        </div>
        <div v-if="showFooter" class="modal-footer justify-content-between">
          <slot name="actions"/>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</template>

<script>
  export default {
    props: {
      activeBackDrop: {
        type: Boolean,
        default: false
      },
      id: {
        type: Number
      },
      title: {
        type: String,
        default: "Title modal"
      },
      size: {
        type: String,
        default: ""
      },
      showFooter: {
        type: Boolean,
        default: true
      }
    },
    methods: {
      show() {
        $(this.$el).modal("show");
      },
      hide() {
        $(this.$el).modal("hide");
      }
    }
  };
</script>
