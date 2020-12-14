<template>
  <ul>
    <li class="asideLink">
      <NuxtLink to="/admin" exact-active-class="active">
        <span class="material-icons">trending_up</span>
        Аналитика
      </NuxtLink>
    </li>

    <li class="asideLink">
      <NuxtLink to="/admin/create" exact-active-class="active">
        <span class="material-icons">queue_play_next</span>
        Создать
      </NuxtLink>
    </li>

    <li class="asideLink">
      <NuxtLink to="/admin/list" exact-active-class="active">
        <span class="material-icons">wysiwyg</span>
        Записи
      </NuxtLink>
    </li>

    <li class="asideLink">
      <NuxtLink to="/admin/user" exact-active-class="active">
        <span class="material-icons">group</span>
        Пользователи
      </NuxtLink>
    </li>

    <li class="asideLink">
      <NuxtLink to="/admin/logout" exact-active-class="active">
        <span class="material-icons">input</span>
        Выйти
      </NuxtLink>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'Aside',
};
</script>

<style lang="scss">
.asideLink {
  & a {
    color: black;
    font-weight: 600;
    display: flex;
    align-items: center;
    padding: 10px 15px 10px 30px;
    transition: .3s;

    &:hover, &.active {
      color: white;
      background-color: #aeaeae;
    }

    & span {
      margin-right: 10px;
    }
  }
}
</style>
