<template>
  <div class="wrapperAdmin">
    <aside class="aside">
      <Aside/>
    </aside>
    <main class="content">
      <Nuxt/>
    </main>
  </div>
</template>

<script>
import Aside from '@/components/admin/Aside';

export default {
  name: 'admin',
  computed: {
    error () {
      return this.$store.getters.error;
    },
  },
  components: {Aside},
  watch: {
    error (val) {
      if (val) {
        this.$error(val.response.data.message);
      }
    },
  },
};
</script>

<style scoped>
.wrapperAdmin {
  display: flex;
  width: 100%;
  height: 100vh;
}

.aside {
  width: 300px;
  box-shadow: 0 0 4px 0px #cecece;
  overflow: auto;
}

.content {
  width: calc(100% - 300px);
  padding: 0 30px;
}
</style>
