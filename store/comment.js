export const actions = {
  async create ({commit}, {id, name, comment}) {
    commit('clearError', null, {root: true});

    try {
      const formData = new FormData();
      formData.append('id_post', id);
      formData.append('name', name);
      formData.append('comment', comment);

      return await this.$axios.$post('/createComment', formData);
    }
    catch (error) {
      commit('setError', error, {root: true});
      throw error;
    }
  },
};
