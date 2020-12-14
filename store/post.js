export const state = () => ({});

export const getters = {};

export const mutations = {};

export const actions = {
  // ======= АДМИНКА
  async fetchAdmin ({commit}) {
    commit('clearError', null, {root: true});

    try {
      return await this.$axios.$get('/allPosts');
    }
    catch (error) {
      commit('setError', error, {root: true});
      throw error;
    }
  },
  async remove ({commit}, id) {
    commit('clearError', null, {root: true});

    try {
      await this.$axios.$delete(`/deletePost/${id}`);
    }
    catch (error) {
      commit('setError', error, {root: true});
      throw error;
    }
  },
  async fetchAdminById ({commit}, id) {
    try {
      return await this.$axios.$get(`/getPostId/${id}`);
    }
    catch (error) {
      throw error;
    }
  },
  async update ({commit}, {id, text}) {
    commit('clearError', null, {root: true});

    try {
      return await this.$axios.$put('/updatePost', {
        id,
        text,
      });
    }
    catch (error) {
      commit('setError', error, {root: true});
      throw error;
    }
  },
  async create ({commit}, {title, text, image}) {
    commit('clearError', null, {root: true});

    try {
      const fd = new FormData();
      fd.append('title', title);
      fd.append('text', text);
      fd.append('image', image, image.name);

      const res = await this.$axios.post('/addPost', fd);
      console.log(res);
    }
    catch (error) {
      commit('setError', error, {root: true});
      throw error;
    }
  },

  // ======= КЛИЕНТ
  async fetch ({commit}) {
    try {
      return await this.$axios.$get('/getAllPostsClient');
    }
    catch (error) {
      throw error;
    }
  },
  async fetchById ({commit}, id) {
    commit('clearError', null, {root: true});

    try {
      return await this.$axios.$get(`/getPostClientById/${id}`);
    }
    catch (error) {
      commit('setError', error, {root: true});
      throw error;
    }
  },
  async addView ({commit}, {id, views}) {
    commit('clearError', null, {root: true});

    try {
      await this.$axios.$put(`/updateView`, {
        id: id,
        view: ++views,
      });
    }
    catch (error) {
      commit('setError', error, {root: true});
      throw error;
    }
  },
};
