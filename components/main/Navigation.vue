<template>
  <div>
    <nav class="navButton">
      <div class="nav-wrapper">
        <NuxtLink to="/" class="brand-logo">Logo</NuxtLink>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li><a href="sass.html">Sass</a></li>
          <li><a href="badges.html">Components</a></li>
          <li><a href="collapsible.html">Javascript</a></li>
          <li><a href="mobile.html">Mobile</a></li>
        </ul>
      </div>
    </nav>

    <div ref="sidenav" class="sidenav" id="mobile-demo">
      <ul>
        <li><a href="sass.html">Sass</a></li>
        <li><a href="badges.html">Components</a></li>
        <li><a href="collapsible.html">Javascript</a></li>
        <li><a href="mobile.html">Mobile</a></li>
      </ul>
    </div>
  </div>
</template>

<script>
let sidenav = null;

export default {
  name: 'Navigation',
  mounted () {
    sidenav = M.Sidenav.init(this.$refs.sidenav);
  },
  destroyed () {
    if (sidenav && sidenav.destroy) {
      sidenav.destroy();
    }
  },
};
</script>

<style scoped lang="scss">
nav.navButton {
  margin-bottom: 50px;

  & .nav-wrapper {
    padding: 0 15px;

    & .sidenav-trigger {
      color: black;
    }
  }
}
</style>
