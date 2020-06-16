import Vuex from 'vuex'
import Vue from 'vue'
Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
      response: null
  },
  mutations: {
      setResponse(state, payload) {
          console.log(payload);
          state.response = payload;
      }
  },
  actions: {
      setResponse({ commit }, response) {
          console.log(response);
          commit("setResponse", response);
      }
  }
});
export default store;