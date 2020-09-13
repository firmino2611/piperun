<template>
  <ol class="breadcrumb float-sm-right">
    <li v-for="item in items" :key="item" class="breadcrumb-item" :class="{active : active == item}">
      <a v-if="active != item" href="#">{{ item }}</a>
      <span v-else>{{ item }}</span>
    </li>
    <!-- <li class="breadcrumb-item active">Starter Page</li> -->
  </ol>
</template>

<script>
export default {
    props: ['items', 'active']
}
</script>