<template>
  <div class="emptyLayout">
    <div class="container">
      <div class="row">
        <div class="col s12 m6 offset-m3">
          <Nuxt/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'empty',
  computed: {
    error () {
      return this.$store.getters.error;
    },
  },
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
.emptyLayout {
  height: 100vh;
  display: flex;
  align-items: center;
}
</style>
