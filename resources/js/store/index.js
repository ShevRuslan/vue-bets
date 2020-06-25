import Vuex from "vuex";
import Vue from "vue";
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        response: [],//ответ для страницы ПОИСК
        history: null,// история поиска
        lineChamps: null,//чемпионаты из линии
        currentLineChamps: null,//текущий чемпионат из линии
        countLineMatches: 10,//количество матчей для получение в модалке
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
        },
        getCountLineMatches(state) {
            return state.countLineMatches;
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
        },
        setCountLineMatches(state, payload) {
            state.countLineMatches = payload;
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
