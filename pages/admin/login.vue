<template>
  <div class="login">
    <h3>Авторизация</h3>

    <form class="col s12" @submit.prevent="loginHandler">
      <div class="row">
        <div class="input-field col s12">
          <input
            id="name"
            type="text"
            v-model="login"
            :class="{invalid: $v.login.$dirty && !$v.login.required}"
          >
          <label for="name">Логин</label>
          <span
            class="error"
            v-if="$v.login.$dirty && !$v.login.required"
          >
            Введите логин
          </span>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <input
            id="password"
            type="password"
            v-model="password"
            :class="{invalid: $v.password.$dirty && !$v.password.required}"
          >
          <label for="password">Пароль</label>
          <span
            class="error"
            v-if="$v.password.$dirty && !$v.password.required"
          >
            Введите пароль
          </span>
        </div>
      </div>

      <button class="btn waves-effect waves-light" :class="{disabled: loading}" type="submit">Отправить
        <i class="material-icons right" v-if="!loading">send</i>
        <i class="material-icons right loadingAnimate" v-if="loading">cached</i>
      </button>
    </form>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators';

export default {
  name: 'login',
  layout: 'empty',
  head: {
    title: `Вход | ${process.env.appName}`,
  },
  data: () => ({
    loading: false,
    login: '',
    password: '',
  }),
  validations: {
    login: {
      required,
    },
    password: {
      required,
    },
  },
  methods: {
    async loginHandler () {
      if (this.$v.$invalid) {
        this.$v.$touch();
        return false;
      }

      this.loading = true;

      const formData = {
        login: this.login,
        password: this.password,
      };

      try {
        await this.$store.dispatch('auth/login', formData);
        this.$router.push('/admin');

        console.log(this.$cookies.keys());

        this.$message(`Здравствуйте ${this.login}`);
      }
      catch (error) {
        this.loading = false;
        // console.log(error.response.data.message);
      }
    },
  },
  mounted () {
    const {message} = this.$route.query;

    switch (message) {
      case 'login':
        this.$message('Авторизуйтесь');
        break;
      case 'logout':
        this.$message('Вы вышли из системы');
        break;
    }
  },
};
</script>

<style scoped lang="scss">
h3 {
  font-size: max(2em, min(3em, calc(calc(100vw / 75) * 4)));
  text-align: center;
}
</style>
