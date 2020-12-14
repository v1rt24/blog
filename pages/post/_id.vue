<template>
  <article class="post">
    <header class="post__header">
      <div class="post__title">
        <h1>{{ post.title }}</h1>
        <NuxtLink to="/">
          <span class="material-icons">undo</span>
        </NuxtLink>
      </div>
      <div class="post__info">
        <small class="card__dataReliz">
          <span class="material-icons">history_toggle_off</span>
          {{ post.date | dataFilter('datetime') }}
        </small>
        <small>
          <span class="material-icons">visibility</span>
          {{ post.views }}
        </small>
      </div>
      <div class="post__image">
        <img class="activator" :src="post.imageUrl"
             :alt="post.title">
      </div>
    </header>
    <main class="post__content">
      {{ post.text }}
    </main>
    <footer>
      <ComponentForm
        v-if="canAddComment"
        :post-id="post.id"
        @created="createdCommentHandler"
      />

      <div class="comments" v-if="comments.length">
        <Comment
          v-for="comment of comments"
          :key="comment.id"
          :comment="comment"
        />
      </div>

      <div class="noComments" v-else>
        <hr>
        Комментариев пока нет. Будьте первым!
      </div>
    </footer>
  </article>
</template>

<script>
import Comment from '@/components/main/Comment';
import ComponentForm from '@/components/main/ComponentForm';

export default {
  name: 'id_post',
  async asyncData ({store, params, error}) {
    try {
      const postCom = await store.dispatch('post/fetchById', params.id);
      const {post, comments} = postCom;
      await store.dispatch('post/addView', post); // для увеличения просмотра статьи
      return {post, comments};
    }
    catch (err) {
      console.log(err);
      error(err);
    }
  },
  validate ({params}) {
    return Boolean(params.id);
  },
  head () {
    return {
      title: `${this.post.id} | ${process.env.appName}`,
      meta: [
        {hid: `postd-${this.post.title}`, name: 'description', content: `${this.post.title}`},
        {hid: `postk-${this.post.title}`, name: 'keywords', content: 'Рота'},
      ],
    };
  },
  data: () => ({
    canAddComment: true,
  }),
  methods: {
    createdCommentHandler (comment) {
      this.canAddComment = false;
      this.comments.unshift(comment);
      console.log(comment);
    },
  },
  components: {ComponentForm, Comment},
};
</script>

<style scoped lang="scss">
.post {
  &__title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 50px;

    & a {
      color: black;
    }
  }

  &__info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
  }

  & small {
    display: flex;
    align-items: center;

    & span {
      margin-right: 5px;
    }
  }

  .comments {
    margin: 60px 0;
  }

  .noComments {
    text-align: center;
    padding: 30px 0;
  }
}
</style>
