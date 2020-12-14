<template>
  <div class="error404">
    <h1>Страница не найдена</h1>
    <NuxtLink to="/" class="waves-effect waves-light btn">На главную</NuxtLink>
  </div>
</template>

<script>
export default {
  name: 'error',
};
</script>

<style scoped lang="scss">
.error404 {
  text-align: center;
  min-height: calc(100vh - 200px);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;

  & h1 {
    color: red;
  }
}
</style>
