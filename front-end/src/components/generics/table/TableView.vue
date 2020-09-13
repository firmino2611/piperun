<template lang="pug">
div
  .row
    .form-group.col-md-4.offset-md-8
      input.form-control(type='text' v-model="search" @keyDown="onSearch" placeholder="Pesquisar")
  div.scrol-custom
    table.table.table-hover.text-nowrap.table-responsiv
      thead
        slot(name='header')
          tr
            th(v-for='head in setup.header' :key='head')
              span(v-if="head !== 'check'") {{ head }}
              .custom-control.custom-checkbox(v-else='')
                input#checkAll.custom-control-input(type='checkbox' @change.stop="$emit('checkAll', $event.target.checked)")
                label.custom-control-label(for='checkAll')
      tbody
        slot
        tr(v-if='onSearch.length === 0 && !setup.loading')
          td.text-bold(:colspan='setup.header.length' align='center') {{ setup.message }}
        tr(v-if='setup.loading')
          td.text-bold(:colspan='setup.header.length' align='center')
            span.spinner-border.spinner-border-sm.text-primary(role='status')
              span.sr-only Loading...

  pagination(:items="data" @onChangePage="test")

</template>

<script>
import _ from "lodash";

import Pagination from "../../../components/generics/pagination/Pagination";

export default {
  components: { Pagination },
  props: {
    setup: {
      type: Object,
      default: () => {
        return {
          // Dados a serem utilizados nas consultas e filtragem,
          // usar apenas em casos de dados sincronos
          items: {
            type: Array,
            default: () => []
          },
          // Define o cabeçalho simples para tabela
          header: {
            type: Array,
            default: () => []
          },
          // Função assincrona que recupera os dados que serão
          // usados para consutlas e filtrgem
          asyncData: {
            type: Function,
            default: () => {}
          },
          // Define se deverá ser mostrado o loading de carregamento
          loading: {
            type: Boolean,
            default: true
          },
          // Mensagem a ser utilizada quando nenhum dados for enviado
          message: {
            type: String,
            default: "Nenhuma dado cadastrada"
          },
          // Nome do campo a ser usado na consulta.
          // * Sempre será levado em consideração que a lista
          // * de dados enviado conterá objetos
          searchBy: {
            type: String,
            default: ""
          }
        };
      }
    }
  },
  data() {
    return {
      search: "",
      data: this.setup.items ? this.setup.items : []
    };
  },
  methods: {
    test(page) {},

    // Atualiza os dados da tabela consultando
    // novamente a função assincrona enviada como parametro
    async updateData() {
      this.data = await this.setup.asyncData();
    }
  },

  computed: {
    // Processa a lista de dados e retorna apenas os
    // itens correspondentes a consulta
    onSearch() {
      let result = _.filter(this.data, s => {
        if (s)
          return s[this.setup.searchBy]
            .toLowerCase()
            .includes(this.search.toLowerCase());
      });
      this.$emit("onSearch", result);
      return result;
    }
  },
  mounted() {
    console.log({ setup: this.setup });
    // Verifica se foi enviado dados assincronos

    if (!this.data.length) {
      if (this.setup.asyncData)
        this.setup.asyncData()
          .then(_ => {
            this.data = _;
          }).catch(() => {});
      // this.data = await this.setup.asyncData();
    }
  }
};
</script>

<style scoped>
tr {
  cursor: pointer;
}
tr td {
  padding: 10px 10px;
}
</style>
