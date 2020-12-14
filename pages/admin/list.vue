<template>
  <div class="list">
    <h1>Записи</h1>

    <div v-if="!posts.length" class="noPosts">
      Записей пока нет
    </div>

    <table class="tablePosts striped centered" v-else>
      <thead>
      <tr>
        <th>Название</th>
        <th>Дата</th>
        <th>Просмотры</th>
        <th>Комментарии</th>
        <th>Действия</th>
      </tr>
      </thead>

      <tbody>
      <tr
        v-for="post of posts"
        :key="post.id"
      >
        <td>{{ post.title }}</td>
        <td class="TdSpan">
          <span class="material-icons">schedule</span>
          {{ post.date | dataFilter('datetime') }}
        </td>
        <td>
          <div class="TdSpan">
            <span class="material-icons">visibility</span>
            {{ post.views }}
          </div>
        </td>
        <td>
          <div class="TdSpan">
            <span class="material-icons">mode_comment</span>
            {{ post.comments }}
          </div>
        </td>
        <td>
          <div class="TdSpan">
            <span class="material-icons edit" @click="open(post.id)" v-tooltip="'Редактировать'">edit</span>
            <ModalConfirm
              :id="post.id"
              @del="remove(post)"
            />
          </div>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import ModalConfirm from '@/components/ModalConfirm';

export default {
  name: 'list',
  layout: 'admin',
  middleware: ['admin.auth'],
  async asyncData ({store, error}) {
    try {
      let posts = await store.dispatch('post/fetchAdmin');
      return {posts};
    }
    catch (err) {
      console.log(err);
      error(err);
    }
  },
  head: {
    title: `Записи | ${process.env.appName}`,
  },
  methods: {
    open (id) {
      this.$router.push(`/admin/post/${id}`);
    },
    async remove (post) {
      try {
        await this.$store.dispatch('post/remove', post.id);
        this.posts.splice(this.posts.indexOf(post), 1);
        this.$message('Запись удалена');
      }
      catch (error) {
        console.log(error);
      }
    },
  },
  components: {ModalConfirm},
};
</script>

<style scoped lang="scss">
.noPosts {
  font-size: 20px;
}

.TdSpan {
  display: flex;
  justify-content: center;
  align-items: center;

  & span {
    font-size: 18px;
    margin-right: 10px;
  }
}

.edit {
  cursor: pointer;
  margin: 0 5px;
}
</style>
