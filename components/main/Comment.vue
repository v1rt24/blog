<template>
  <div class="comment">
    <div class="comment__header">
      <span class="comment__user">{{ comment.name }}</span>
      <small class="comment__time">
        <span class="material-icons">history_toggle_off</span>
        {{ comment.date | dataFilter('datetime') }}
      </small>
    </div>

    <div class="comment__text">{{ comment.comment }}</div>
  </div>
</template>

<script>
export default {
  name: 'Comment',
  props: {
    comment: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped lang="scss">
.comment {
  padding: 20px;
  border-radius: 4px;
  box-shadow: 0 0 10px 0 rgba(0, 0, 0, .3);
  margin-bottom: 1rem;

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: .5rem;
  }

  &__user {
    font-size: 12px;
  }

  &__time {
    display: flex;
    align-items: center;

    & span {
      font-size: 14px;
      margin-right: 5px;
    }
  }

  &__text {
    white-space: pre-line;
  }
}
</style>
