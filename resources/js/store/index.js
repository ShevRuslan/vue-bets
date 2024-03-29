import Vuex from 'vuex';
import Vue from 'vue';
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        response: [], //ответ для страницы ПОИСК
        rivalsMatch: [], //матчи с общими соперниками для страницы ПОИСК
        history: null, // история поиска
        lineChamps: null, //чемпионаты из линии
        currentLineChamps: null, //текущий чемпионат из линии
        countLineMatches: 10, //количество матчей для получение в модалке,
        countRivalsMatches: 10,
        loadingLine: false
    },
    getters: {
        getMatches(state) {
            return state.response;
        },
        getHistory(state) {
            return state.history;
        },
        getLineChamps(state) {
            return state.lineChamps;
        },
        getCurrentLineChamps(state) {
            return state.currentLineChamps;
        },
        getCountLineMatches(state) {
            return state.countLineMatches;
        },
        getCountRivalsMatch(state) {
            return state.countRivalsMatches;
        },
        getRivalsMatch(state) {
            return state.rivalsMatch;
        },
        getLoading(state) {
            return state.loadingLine;
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
        },
        setCountRivalsMatches(state, payload) {
            state.countRivalsMatches = payload;
        },
        setRivalsMatch(state, payload) {
            state.rivalsMatch = payload;
        },
        setLoading(state, payload) {
            state.loadingLine = payload;
        },
    },
    actions: {
        setResponse({ commit }, response) {
            commit('setResponse', response);
        },
        setLineChamps({ commit }, champs) {
            commit('setLineChamps', champs);
        },
        setRivalsMatch({ commit }, response) {
            commit('setRivalsMatch', response);
        }
    }
});
export default store;
