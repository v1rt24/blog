<template>
  <article class="post col s12 m6 l4">
    <div class="card">
      <div class="card-image waves-effect waves-block waves-light">
        <img class="activator" :src="post.imageUrl"
             :alt="post.title">
      </div>
      <div class="card-content">
        <small class="card__dataReliz">
          <span class="material-icons">history_toggle_off</span>
          {{ post.date | dataFilter('datetime') }}
        </small>
        <span class="card-title activator grey-text text-darken-4">
          {{ post.title }}
          <i class="material-icons right">more_vert</i>
        </span>
        <div class="card__bottom">
          <NuxtLink :to="`/post/${post.id}`">Читать</NuxtLink>
          <div><span class="material-icons">comment</span> {{ post.comments }}</div>
        </div>
      </div>
      <div class="card-reveal">
        <span class="card-title grey-text text-darken-4">{{ post.title }}<i
          class="material-icons right">close</i></span>
        <p>{{ post.text }}</p>
      </div>
    </div>
  </article>
</template>

<script>
export default {
  name: 'Post',
  props: {
    post: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped lang="scss">
.card {
  transition: .3s;

  &:hover {
    transform: translateY(-5px);
  }

  &__dataReliz {
    display: flex;
    align-items: center;
    margin-bottom: 20px;

    & span {
      margin-right: 3px;
    }
  }

  &__bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;

    & > a {
      transition: .3s;

      &:hover {
        color: #ee6e73;
      }
    }

    & > div {
      display: flex;
      align-items: center;
    }
  }
}
</style>
