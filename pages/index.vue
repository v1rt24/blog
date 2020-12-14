<template>
  <div class="row">
    <Post
      v-for="post of posts"
      :key="post.id"
      :post="post"
    />
  </div>
</template>

<script>
import Post from '@/components/main/Post';

export default {
  head: {
    title: `Главная | ${process.env.appName}`,
    meta: [
      {hid: 'homepaged', name: 'description', content: 'Все статьи'},
      {hid: 'homepagek', name: 'keywords', content: 'статьи, описания, картинки'},
    ],
  },
  async asyncData ({store, error}) {
    try {
      const posts = await store.dispatch('post/fetch');
      return {posts};
    }
    catch (err) {
      console.log(err);
      error(err);
    }
  },
  components: {Post},
};
</script>

<style>

</style>
