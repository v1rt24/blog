<template>
  <div class="user">
    <h3>Создать пользователя</h3>

    <form class="col s12" @submit.prevent="userHandler">
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
            :class="{invalid: ($v.password.$dirty && !$v.password.required) || ($v.password.$dirty && !$v.password.minLength)}"
          >
          <label for="password">Пароль</label>
          <span
            class="error"
            v-if="$v.password.$dirty && !$v.password.required"
          >
            Введите пароль
          </span>
          <span
            class="error"
            v-if="$v.password.$dirty && !$v.password.minLength"
          >
            Пароль должен быть не менее {{ password.length }} символов <br>
            Вы ввели {{ $v.password.$params.minLength.min }}
          </span>
        </div>
      </div>

      <button class="btn waves-effect waves-light" :class="{disabled: loading}" type="submit">Создать
        <i class="material-icons right" v-if="!loading">send</i>
        <i class="material-icons right loadingAnimate" v-if="loading">cached</i>
      </button>
    </form>
  </div>
</template>

<script>
import { required, minLength } from 'vuelidate/lib/validators';

export default {
  name: 'user',
  layout: 'admin',
  middleware: ['admin.auth'],
  head: {
    title: `Создать пользователя | ${process.env.appName}`,
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
      minLength: minLength(6),
    },
  },
  methods: {
    async userHandler () {
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
        await this.$store.dispatch('auth/createUser', formData);

        this.$message(`Новый пользователь с логином ${this.login} добавлен`);

        this.login = this.password = '';
        this.$v.$reset();

        this.loading = false;
      }
      catch (error) {
        this.loading = false;
        console.log(error);
      }
    },
  },
};
</script>

<style scoped lang="scss">
.user {
  & form {
    max-width: 600px;
    margin: 0 auto;
  }
}

h3 {
  font-size: max(2em, min(3em, calc(calc(100vw / 75) * 4)));
  text-align: center;
}

.error {
  font-size: 12px;
  color: #F44336;
}

.loadingAnimate {
  transform: rotate(0deg);
  animation: loading 1s linear infinite;
}

@keyframes loading {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
