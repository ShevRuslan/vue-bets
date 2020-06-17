import Vuex from "vuex";
import Vue from "vue";
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        response: []
    },
    getters: {
        getMatches(state) {
            return state.response;
        }
    },
    mutations: {
        setResponse(state, payload) {
            state.response = payload;
        }
    },
    actions: {
        setResponse({ commit }, response) {
            commit("setResponse", response);
        }
    }
});
export default store;
