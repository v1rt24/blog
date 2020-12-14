export const state = () => ({
  token: null,
  user: null,
});

export const getters = {
  isAuthenticated: state => Boolean(state.token),
  user: state => state.user,
};

export const mutations = {
  setToken (state, token) {
    state.token = token;
  },
  clearToken (state) {
    state.token = null;
  },
  setCookie (state, token) {
    this.$cookies.set('nuxt-auth', token, {
      path: '/',
      maxAge: 60 * 60,
    });
  },
  deleteCookie () {
    this.$cookies.remove('nuxt-auth', {
      path: '/',
    });
  },
  setUser (state, user) {
    state.user = user;
  },
  clearUser (state) {
    state.user = null;
  },
};

export const actions = {
  async login ({commit}, {login, password}) {
    commit('clearError', null, {root: true});

    try {
      const formData = new FormData();
      formData.append('login', login);
      formData.append('password', password);

      const res = await this.$axios.$post('/usersAut', formData);

      commit('setToken', res.token);
      commit('setCookie', res.token);
      commit('setUser', res);
    }
    catch (error) {
      commit('setError', error, {root: true});
      throw error;
    }
  },
  logout ({dispatch}) {
    dispatch('deleteTokenBD');
  },
  async createUser ({commit}, {login, password}) {
    commit('clearError', null, {root: true});

    try {
      const formData = new FormData();
      formData.append('login', login);
      formData.append('password', password);

      await this.$axios.$post('/usersReg', formData);
    }
    catch (error) {
      commit('setError', error, {root: true});
      throw error;
    }
  },
  async loadCookie ({commit}, token) {
    try {
      const res = await this.$axios.$post('/getCookie', {token});
      commit('setToken', res.token);
      commit('setUser', res);
    }
    catch (error) {
      throw error;
    }
  },
  async watchCookie ({commit}, token) {
    try {
      const res = await this.$axios.$post('/getCookie', {token});
      if (!res.token) {
        commit('clearToken');
        commit('deleteCookie');
        throw new Error('Ошибка');
      }
    }
    catch (error) {
      throw error;
    }
  },
  async deleteTokenBD ({commit, getters}) {
    try {
      const user = getters.user;

      await this.$axios.$patch(`/deleteUserToken`, {
        id: user.id,
      });

      commit('clearToken');
      commit('deleteCookie');
      commit('clearUser');
    }
    catch (error) {
      throw error;
    }
  },
};
