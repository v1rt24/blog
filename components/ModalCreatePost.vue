<template>
  <div>
    <a class="waves-effect waves-light btn modal-trigger" href="#modal1">{{ nameButton }}</a>

    <!-- Modal -->
    <div id="modal1" class="modal modal-fixed-footer" ref="modal">
      <div class="modal-content">
        <h4 v-if="title">{{ title }}</h4>
        <slot></slot>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Закрыть</a>
      </div>
    </div>
  </div>
</template>

<script>
let instances = null;

export default {
  name: 'ModalCreatePost',
  props: {
    title: {
      type: String,
      default: '',
    },
    nameButton: {
      type: String,
      default: 'Кнопка',
    },
  },
  mounted () {
    instances = M.Modal.init(this.$refs.modal);
  },
  destroyed () {
    if (instances && instances.destroy) {
      instances.destroy();
    }
  },
};
</script>

<style scoped>

</style>
