<template>
  <div>
    <span class="material-icons delete" @click="modalIn" v-tooltip="'Удалить'">delete_outline</span>

    <!-- Modal Structure -->
    <div class="modal bottom-sheet" ref="modal">
      <div class="modal-content">
        <h4>Удалить запись?</h4>
        <div>
          <a class="modal-close waves-effect waves-light btn" @click="del">Да</a>
          <a class="modal-close waves-effect waves-light btn red lighten-1">Нет</a>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Закрыть</a>
      </div>
    </div>
  </div>
</template>

<script>
let instanceModal = null;

export default {
  name: 'ModalConfirm',
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  methods: {
    modalIn () {
      instanceModal = M.Modal.init(this.$refs.modal, {
        onCloseEnd () {
          if (instanceModal && instanceModal.destroy) {
            instanceModal.destroy();
          }
        },
      });
      instanceModal.open();
    },
    del () {
      this.$emit('del', this.id);
    },
  },
};
</script>

<style scoped>
.modal-content {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.delete {
  color: red;
  cursor: pointer;
  margin: 0 5px;
}
</style>
