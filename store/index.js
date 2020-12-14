export const state = () => ({
  error: null,
});

export const getters = {
  error: state => state.error,
};

export const mutations = {
  setError (state, error) {
    state.error = error;
  },
  clearError (state) {
    state.error = null;
  },
};

export const actions = {
  async nuxtServerInit ({commit, dispatch, getters}, {$cookies, $axios}) {
    const token = $cookies.get('nuxt-auth');

    if (token) {
      try {
        await dispatch('auth/loadCookie', token);
      }
      catch (error) {
        commit('auth/deleteCookie');
        // throw error;
      }
    }
  },
};
