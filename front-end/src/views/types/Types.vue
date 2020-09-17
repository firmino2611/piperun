<template lang="pug">
layout
  card(title="Tipos cadastrados", :show-footer="true", :padding="true")
    .row
      .col-md-3
        card(:padding="true", :show-header="false", :show-footer="true")
          p Adicionar
          .p-1.border.border-black(
            :contentEditable="true",
            @input="onInput($event)"
          )
          span(slot="footer")
            i.fa.fa-save.text-primary.float-right(
              v-if="type !== '' && isEdit === 0",
              @click="save()"
            )
      .col-md-3(v-for="(type, index) in types", :key="index")
        card(:padding="true", :show-header="false", :show-footer="true")
          .p-1(
            :contentEditable="isEdit === type.id",
            :class="{ 'border-danger border': isEdit === type.id }",
            @input="onInput($event, type)"
          ) {{ type.name }}
          span(slot="footer")
            i.fa.fa-trash.text-danger(@click="remove(type)")
            i.fa.fa-edit.text-green(
              @click="isEdit = isEdit === 0 ? type.id : 0"
            )
            i.fa.fa-save.text-primary.float-right(
              v-if="isEdit === type.id",
              @click="updateType(type)"
            )

      
</template>

<script>
import Layout from "./../../components/template/Layout";
import Card from "./../../components/generics/card/Card";
import ButtonFloat from "./../../components/generics/buttons/ButtonFloat";

import Type from "./../../models/Type";
export default {
  name: "Types",
  components: { Layout, Card, ButtonFloat },
  data() {
    return {
      type: "",
      types: [],
      isEdit: 0,
    };
  },
  methods: {
    // Cria um novo tipo
    save() {
      Type.create({ name: this.type }).then((resp) => {
        console.log(resp);
        this.load();
        this.type = "";
        this.$toast.success("Tipo cadastrado com sucesso!");
      });
    },
    // Exclui um tipo cadastrado
    remove(type) {
      Type.delete(type).then((resp) => {
        console.log(resp);
        if (resp.data.success) {
          this.isEdit = 0;
          this.load();
          this.$toast.success("Tipo excluido com sucesso!");
        } else {
          this.$toast.info("Você não pode excluir o item pois ele está em uso");
        }
      });
    },
    // Atualiza um tipo
    updateType(type) {
      Type.update(type).then((resp) => {
        this.isEdit = 0;
        this.$toast.success("Tipo atualizado com sucesso!");
      });
    },
    // Recupera o valor que foi alterado no campo
    // de edição do nome do item
    onInput(e, type) {
      if (type) type.name = e.target.innerText;
      else this.type = e.target.innerText;
    },
    // Recupera o tipos cadastrados pelo usuário
    async load() {
      this.types = (await Type.list()).data.data;
    },
  },
  async mounted() {
    this.load();
  },
};
</script>

<style scoped>
i {
  cursor: pointer;
}
</style>