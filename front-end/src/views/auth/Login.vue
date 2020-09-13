<template lang="pug">
.container
  .row.align-items-center
    .col-md-4.offset-4(style="margin-top: 20%")
      h4.text-center Faça login para acessar o sistema
      .callout.callout-danger(v-if="!isValid") Usuario invalído

      card(:padding="true", :showFooter="true")
        .form-group(:class="{ 'has-error': fieldInvalid.email }")
          label Email
          input.form-control(v-model="user.email", type="email")
        .form-group(:class="{ 'has-error': fieldInvalid.password }")
          label Senha
          input.form-control(v-model="user.password", type="password")

        div(slot="footer")
          button.btn.btn-primary.float-right(@click="login()") Entrar
</template>

<script>
import Layout from "./../../components/template/Layout";
import Card from "./../../components/generics/card/Card";
import Auth from "./../../services/Auth";
import Storage from 'local-storage-firmino'

export default {
  components: { Layout, Card },
  data() {
    return {
      user: { email: "", password: "" },
      isValid: true,
      fieldInvalid: { pass: false, email: false },
    };
  },
  methods: {
    login() {
      if (this.user.email === "" || this.user.password === "") {
        this.$toast.error("Campos obrigatórios");
        this.fieldInvalid.email = this.user.email === "" ? true : false;
        this.fieldInvalid.password =
          this.user.password === "" ? true : false;
      } else
        Auth.authentication(this.user, (response) => {
          console.log(response);
          if (response.status != 200) {
            this.isValid = false;
          } else {
            Storage.store('token-user', response.data.access_token)
            this.$router.push('/atividades')
          }
        });
    },
  },
};
</script>
