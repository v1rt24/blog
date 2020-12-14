<template>
  <div>
    <h1>Создать запись</h1>

    <form class="col s12" ref="forma" @submit.prevent="createPostHandler">
      <div class="row">
        <div class="input-field col s12">
          <input
            id="title"
            type="text"
            v-model="title"
            :class="{invalid: $v.title.$dirty && !$v.title.required}"
          >
          <label for="title">Заголовок</label>
          <span
            class="error"
            v-if="$v.title.$dirty && !$v.title.required"
          >
            Введите заголовок
          </span>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
              <textarea
                id="text"
                class="materialize-textarea"
                v-model="text"
                :class="{invalid: $v.text.$dirty && !$v.text.required}"
              ></textarea>
          <label for="text">Текст в формате .md или .html</label>
          <span
            class="error"
            v-if="$v.text.$dirty && !$v.text.required"
          >
            Введите текст
          </span>
        </div>
      </div>

      <div class="file-field input-field">
        <div class="btn">
          <span>Файл</span>
          <input type="file" accept="image/jpeg,image/png" @change="imageHandler">
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text">
        </div>

        <span
          class="error"
          v-if="$v.image.$dirty && !$v.image.required"
        >
        Выберете изображение
      </span>
      </div>

      <div class="formFooter">
        <!-- Предпросмотр в модальном окне -->
        <ModalCreatePost
          title="Предпросмотр записи"
          name-button="Предпросмотр"
        >
          <div v-html="$md.render(text)"></div>
        </ModalCreatePost>
        <!-- /Предпросмотр в модальном окне -->

        <button class="btn waves-effect waves-light" :class="{disabled: loading}" type="submit">Создать
          <i class="material-icons right" v-if="!loading">send</i>
          <i class="material-icons right loadingAnimate" v-if="loading">cached</i>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators';
import ModalCreatePost from '@/components/ModalCreatePost';

export default {
  name: 'create',
  layout: 'admin',
  middleware: ['admin.auth'],
  head: {
    title: `Создать запись | ${process.env.appName}`,
  },
  data: () => ({
    loading: false,
    title: '',
    text: '',
    image: null,
  }),
  validations: {
    title: {
      required,
    },
    text: {
      required,
    },
    image: {
      required,
    },
  },
  methods: {
    async createPostHandler () {
      if (this.$v.$invalid) {
        this.$v.$touch();
        return false;
      }

      this.loading = true;

      const formData = {
        title: this.title,
        text: this.text,
        image: this.image,
      };

      try {
        await this.$store.dispatch('post/create', formData);
        this.title = this.text = '';
        this.image = null;
        this.$refs.forma.reset();
        this.$v.$reset();
        this.$message('Запись создана');
        this.loading = false;
      }
      catch (error) {
        this.loading = false;
        console.log(error);
      }
    },
    imageHandler (event) {
      this.image = event.target.files[0];
    },
  },
  components: {ModalCreatePost},
};
</script>

<style scoped lang="scss">
.formFooter {
  display: flex;

  & button {
    margin-left: 10px;
  }
}
</style>
