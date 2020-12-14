<template>
  <div class="post">
    <nav>
      <div class="nav-wrapper">
        <div class="col s12">
          <NuxtLink to="/admin/list" class="breadcrumb">Записи</NuxtLink>
          <a href="#" @click.prevent class="breadcrumb">{{ post.title }}</a>
        </div>
      </div>
    </nav>

    <form class="col s12" @submit.prevent="postHandler">
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

      <div class="post__data">
        <small>
          <div class="TdSpan">
            <span class="material-icons">visibility</span>
            {{ post.views }}
          </div>
        </small>

        <small>
          <div class="TdSpan">
            <span class="material-icons">schedule</span>
            {{ new Date(post.date) | dataFilter('datetime') }}
          </div>
        </small>
      </div>

      <button class="btn waves-effect waves-light" :class="{disabled: loading}" type="submit">Обновить
        <i class="material-icons right" v-if="!loading">send</i>
        <i class="material-icons right loadingAnimate" v-if="loading">cached</i>
      </button>
    </form>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators';

export default {
  name: 'id',
  layout: 'admin',
  middleware: ['admin.auth'],
  head () {
    return {
      title: `${this.post.title} | ${process.env.appName}`,
    };
  },
  validate ({params: {id}}) {
    return Boolean(id);
  },
  async asyncData ({store, params: {id}, error}) {
    try {
      const post = await store.dispatch('post/fetchAdminById', id);
      return {post};
    }
    catch (err) {
      console.log(err);
      error(err);
    }
  },
  data: () => ({
    loading: false,
    text: 'qsqsqs',
  }),
  validations: {
    text: {
      required,
    },
  },
  methods: {
    async postHandler () {
      if (this.$v.$invalid) {
        this.$v.$touch();
        return false;
      }

      this.loading = true;

      const formData = {
        id: this.post.id,
        text: this.text,
      };

      try {
        await this.$store.dispatch('post/update', formData);
        this.$message('Запись обновлена');
        this.loading = false;
      }
      catch (error) {
        this.loading = false;
        console.log(error);
      }
    },
  },
  mounted () {
    this.$nextTick(() => {
      this.text = this.post.text;
      M.updateTextFields();
    });
  },
};
</script>

<style scoped lang="scss">
.post {
  margin: 10px 0 50px 0;

  & .nav-wrapper {
    padding: 0 20px;
  }

  & form {
    margin-top: 30px;
  }

  &__data {
    display: flex;

    & small {
      margin-right: 20px;

      & .TdSpan {
        display: flex;
        align-items: center;
        margin-bottom: 20px;

        & span {
          font-size: 18px;
          margin-right: 10px;
        }
      }
    }
  }
}
</style>
