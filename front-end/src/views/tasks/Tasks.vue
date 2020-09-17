<template lang="pug">
layout
  card(title="Grupos cadastrados", v-if="emailChecked", :show-footer="true")
    .row.m-2.mb-3
      .col-md-3
        label De
        datepicker(
          v-model="filter.start_at",
          :language="lang",
          :days="[6, 0]",
          @input="setend_at(filter)"
        )
      .col-md-3
        label Até
        datepicker(
          v-model="filter.end_at",
          :language="lang",
          :disabled-dates="disableEndDate",
          :days="[6, 0]"
        )
      .col-md-3
        button.btn.btn-info.float-left(
          style="margin-top: 30px",
          @click="getByFilter()"
        ) Filtrar
      .col-md-3(v-if="filterApply")
        button.btn.btn-default.float-left(
          style="margin-top: 30px",
          @click="cleanFilter()"
        ) Limpar filtro
    table-simple(
      :empty="tasks.length === 0",
      :loading="loading",
      message="Nenhuma atividade cadastrada",
      :header="['Concluido', 'Descrição', 'Tipo', 'Inicio', 'Prazo', 'Conclusão', 'Ações']"
    )
      tr(v-for="(g, index) in tasks", :key="index")
        td(width="10%")
          .icheck-success
            input(type="checkbox", :checked="g.status", disabled, :id="index")
            label(:for="index")
        td(width="30%") {{ g.description }}
        td
          label.badge.text-white(
            v-show="g.type !== null",
            :style="{ 'background-color': '#000' }"
          ) {{ g.type ? g.type.name : '' }}

        td {{ new Date(g.start_at).toLocaleDateString() }}
        td {{ new Date(g.end_at).toLocaleDateString() }}
        td 
          label.badge.badge-success {{ g.finish_at ? getOnlyDate(g.finish_at) : '' }}
        td(width="10%")
          button.btn.btn-success.btn-xs.mr-1(
            title="Concluir atividade",
            @click="conclude(g)"
          )
            i.fa.fa-check
          button.btn.btn-primary.btn-xs(
            @click="showModal(g)",
            title="Editar dados básicos"
          )
            i.fa.fa-edit
          button.btn.btn-danger.btn-xs.ml-1(@click="deleteTask(g.id)")
            i.fa.fa-trash
    div(slot="footer")
      pagination(:total="total", :perPage="perPage", @onChangePage="nextPage")

  modal-default(
    ref="modalEdit",
    :title="!isUpdate ? 'Criar nova atividade' : 'Editar dados da atividade'",
    :showFooter="true"
  )
    .row
      .col-md-12.form-group
        label Descrição
        input.form-control(v-model="task.description")
      .col-md-12.form-group
        label Responsável
        input.form-control(v-model="task.responsible")
      .col-md-12.form-group
        label Data ínicio
        datepicker(
          v-model="task.start_at",
          :language="lang",
          :disabled-dates="disableStartFDate",
          :days="[6, 0]",
          :disabled="task.status == 1 ? true : false",
          @input="setend_at(task)"
        )
      .col-md-12.form-group
        label Prazo de entrega
        datepicker(
          v-model="task.end_at",
          :language="lang",
          :disabled="task.status == 1 ? true : false",
          :disabled-dates="disableEndDate",
          :days="[6, 0]"
        )
      .col-md-12.form-group
        label Tipo:
        select.form-control(v-model="task.type")
          option(v-for="(t, index) in types", :key="index", :value="t.id") {{ t.name }}
      .col-md-12.form-group(v-if="!task.status")
        .icheck-info
          input#enable.form-control(type="checkbox", v-model="task.status")
          label(for="enable") Concluído

    span(slot="actions")
      button.btn.btn-primary.btn-xs(
        @click="saveOrUpdate()",
        :disabled="!verifyForm"
      ) {{ !isUpdate ? 'CRIAR' : 'ATUALIZAR' }}

  button-float(:action="showModal")
</template>

<script>
import Layout from "../../components/template/Layout";
import TableSimple from "../../components/generics/table/TableSimple";
import Card from "../../components/generics/card/Card";
import ModalDefault from "../../components/generics/modal/ModalDefault";
import Datepicker from "vuejs-datepicker";
import { ptBR } from "vuejs-datepicker/src/locale";
import { getOnlyDate } from "./../../helpers/utils";

import axios from "axios";
import Storage from "local-storage-firmino";
import Api from "../../services/Api";
import ButtonLoading from "../../components/generics/buttons/ButtonLoading";
import ButtonFloat from "../../components/generics/buttons/ButtonFloat";
import Pagination from "../../components/generics/pagination/Pagination";
import Task from "./../../models/Task";
import moment from "moment";
import Type from "./../../models/Type";

export default {
  name: "GroupList",
  components: {
    Pagination,
    ButtonFloat,
    ButtonLoading,
    Layout,
    TableSimple,
    Card,
    ModalDefault,
    Datepicker,
  },
  data() {
    return {
      getOnlyDate,
      filter: {
        start_at: moment().toDate(),
        end_at: moment().add(1, "days").toDate(),
      },
      disableStartFDate: {
        to: moment().subtract(1, "days").toDate(),
        days: [6, 0],
      },
      disableEndDate: {
        to: moment().add(1, "days").toDate(),
        days: [6, 0],
      },
      tasks: [],
      lang: ptBR,
      task: this.generateTaskDefault(),
      types: [],
      type: {
        name: "",
        color: "",
      },
      emailChecked: true,
      loading: true,
      isUpdate: false,
      total: 0,
      perPage: 0,
      pageCurrent: 1,
      filterApply: false,
    };
  },
  methods: {
    // Limpa os filtros de pesquisa
    cleanFilter() {
      this.filter = {
        start_at: moment().toDate(),
        end_at: moment().add(1, "days").toDate(),
      };
      this.filterApply = false;
      this.load(1);
    },
    // Recupera as atividades com base no filtro de data
    getByFilter() {
      this.filterApply = true;
      Task.filter(this.filter).then((resp) => {
        this.tasks = resp.data.data;
        this.total = resp.data.meta.total;
        this.perPage = resp.data.meta.per_page;
        this.loading = false;
      });
    },
    // Marca uma atividade como concluida
    conclude(task) {
      Task.check(task).then((resp) => {
        console.log({ check: resp });
        this.$toast.success("Atividade concluida");
        if (this.filterApply) this.getByFilter();
        else this.load();
      });
    },
    // Configura as datas que devem ser bloqueadas no
    // Datepicker de acordo com a data enviada.
    // [element] elemento para ser manipulada, deve ser
    // um objeto com os campos 'start_at' e 'end_at'
    setend_at(element) {
      this.disableEndDate.to = moment(element.start_at).add(1, "days").toDate();
      element.end_at = moment(element.start_at).add(1, "days").toDate();
    },
    // Gera um objeto padrão para a atividade
    generateTaskDefault() {
      return {
        description: "",
        status: false,
        responsible: "",
        type: "",
        start_at: moment().toDate(),
        end_at: moment().add(1, "days").toDate(),
      };
    },
    // Exclui uma atividade
    async deleteTask(id) {
      Task.delete(id).then((resp) => {
        this.$toast.success("Atividade excluida com sucesso!");
        if (this.filterApply) this.getByFilter();
        else this.load();
      });
    },
    // Cria ou atualiza uma atividade
    async saveOrUpdate() {
      // criar
      if (!this.isUpdate) {
        Task.create(this.task).then((resp) => {
          this.validateResponse(resp, {
            messageSuccess: "Atividade criada com sucesso!",
          });
        });
      } else {
        // atualizar
        Task.update(this.task).then((resp) => {
          console.log({ check: resp });

          this.validateResponse(resp, {
            messageSuccess: "Atividade atualizada com sucesso!",
          });
        });
      }
      if (this.filterApply) this.getByFilter();
      else this.load();
    },
    // Valida a resposta da requisição e mostra uma
    // mensagem de acordo com o valor enviado.
    // [resp] objeto de resposa da requisição
    // { messageSuccess } mensagem em caso de sucesso na requisição
    validateResponse(resp, { messageSuccess }) {
      console.log({ resp });
      if (resp.data.success) {
        this.$toast.success(messageSuccess);
        this.task = this.generateTaskDefault();
        this.$refs.modalEdit.hide();
      } else {
        console.log({ err: resp.data });
        this.$toast.error(resp.data.data.error);
      }
    },
    // Abre o modal para edição ou criação de atividade
    showModal(task) {
      this.$refs.modalEdit.show();
      if (task) {
        this.isUpdate = true;
        this.task = {
          ...task,
          start_at: moment(task.start_at).toDate(),
          end_at: moment(task.end_at).toDate(),
          type: task.type.id,
        };
      } else {
        this.task = this.generateTaskDefault();
        this.isUpdate = false;
      }
    },
    // Busca as todas as atividades do usuário.
    // Os dados são retornados paginados
    load() {
      Task.listPaginated(this.pageCurrent).then((resp) => {
        this.tasks = resp.data.data;
        this.total = resp.data.meta.total;
        this.perPage = resp.data.meta.per_page;
        this.loading = false;
      });
    },
    // Busca as atividades da próxima página.
    // [page] valor inteiro correspondente a página
    // que deseja acessar dos dados listados
    nextPage(page) {
      this.pageCurrent = page;

      if (this.filterApply) {
        Task.filter(this.filter, page).then((resp) => {
          this.tasks = resp.data.data;
          this.loading = false;
        });
      } else {
        Task.listPaginated(page).then((resp) => {
          this.tasks = resp.data.data;
          this.loading = false;
        });
      }
    },
  },
  computed: {
    // valida os campos obrigatórios do formulário
    verifyForm() {
      return (
        this.task.description !== "" &&
        this.task.responsible !== "" &&
        this.task.type !== ""
      );
    },
  },
  async mounted() {
    this.load();
    Type.list().then((resp) => {
      this.types = resp.data.data;
    });
  },
};
</script>

<style scoped>
</style>
