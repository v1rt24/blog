<template>
  <div>Очищаем данные</div>
</template>

<script>
export default {
  name: 'logout',
  layout: 'admin',
  middleware: ['admin.auth'],
  beforeCreate () {
    this.$store.dispatch('auth/logout');
    this.$router.push('/admin/login?message=logout');
  },
};
</script>

<style scoped>

</style>
