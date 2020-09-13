<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><strong>{{ title }}</strong></h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <!-- <breadcrumb :items="itens" :active="itens[0]" /> -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
</template>

<script>
import Breadcrumb from "../../../components/generics/header/Breadcrumb";

export default {
  components: {
    Breadcrumb
  },
  props: ['title', 'itens']
};
</script>
