<template>
  <div>
    <h1>Аналитика записей</h1>
  </div>
</template>

<script>
export default {
  name: 'indexAdmin',
  layout: 'admin',
  middleware: ['admin.auth'],
  head: {
    title: `Аналитика | ${process.env.appName}`,
  },
};
</script>

<style scoped>

</style>
