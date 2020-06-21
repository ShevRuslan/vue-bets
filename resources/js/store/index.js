import Vuex from "vuex";
import Vue from "vue";
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        response: [],
        history: null,
        lineChamps: null,
        currentLineChamps: null,
    },
    getters: {
        getMatches(state) {
            return state.response;
        },
        getHistory(state) {
            return state.history
        },
        getLineChamps(state) {
            return state.lineChamps;
        },
        getCurrentLineChamps(state) {
            return state.currentLineChamps;
        }
    },
    mutations: {
        setResponse(state, payload) {
            state.response = payload;
        },
        setHistory(state, payload) {
            state.history = payload;
        },
        setLineChamps(state, payload) {
            state.lineChamps = payload;
        },
        setCurrentLineChamps(state, payload) {
            state.currentLineChamps = payload;
        }
    },
    actions: {
        setResponse({ commit }, response) {
            commit("setResponse", response);
        },
        setLineChamps({ commit }, champs) {
            commit("setLineChamps", champs);
        }
    }
});
export default store;
