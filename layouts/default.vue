<template>
  <div>
    <header>
      <Navigation/>
    </header>
    <main class="container">
      <Nuxt/>
    </main>
    <footer></footer>
  </div>
</template>

<style>

</style>
<script>
import Navigation from '~/components/main/Navigation';

export default {
  components: {Navigation},
};
</script>
