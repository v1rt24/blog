<template>
  <div class="commentForm">
    <h4>Добавить комментарий</h4>

    <form class="col s12" @submit.prevent="commentHandler">
      <div class="row">
        <div class="input-field col s12">
          <input
            id="name"
            type="text"
            v-model="name"
            :class="{invalid: $v.name.$dirty && !$v.name.required}"
          >
          <label for="name">Имя</label>
          <span
            class="error"
            v-if="$v.name.$dirty && !$v.name.required"
          >
            Введите имя
          </span>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <textarea
            id="textarea1"
            class="materialize-textarea"
            v-model="text"
            :class="{invalid: ($v.text.$dirty && !$v.text.required) || ($v.text.$dirty && !$v.text.minLength)}"
          ></textarea>
          <label for="textarea1">Сообщение</label>
          <span
            class="error"
            v-if="$v.text.$dirty && !$v.text.required"
          >
            Введите сообщение
          </span>
          <span
            class="error"
            v-if="$v.text.$dirty && !$v.text.minLength"
          >
            Минимальное количество символов {{ $v.text.$params.minLength.min }} <br>
            Вы ввели {{ text.length }}
          </span>
        </div>
      </div>
      <button class="btn waves-effect waves-light" :class="{disabled: loading}" type="submit" name="action">Отправить
        <i class="material-icons right" v-if="!loading">send</i>
        <i class="material-icons right loadingAnimate" v-if="loading">cached</i>
      </button>
    </form>
  </div>
</template>

<script>
import { required, minLength } from 'vuelidate/lib/validators';

export default {
  name: 'ComponentForm',
  props: {
    postId: {
      type: String,
      required: true,
    },
  },
  data: () => ({
    loading: false,
    name: '',
    text: '',
  }),
  validations: {
    name: {
      required,
    },
    text: {
      required,
      minLength: minLength(10),
    },
  },
  methods: {
    async commentHandler () {
      if (this.$v.$invalid) {
        this.$v.$touch();
        return false;
      }

      this.loading = true;

      const dataForm = {
        id: this.postId,
        name: this.name,
        comment: this.text,
      };

      try {
        this.loading = false;
        const res = await this.$store.dispatch('comment/create', dataForm);
        this.name = this.text = '';
        this.$message(res.message);
        this.$emit('created', dataForm);
      }
      catch (error) {
        this.loading = false;
        console.log(error);
      }
    },
  },
};
</script>

<style scoped>
.commentForm {
  margin-top: 50px;
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
