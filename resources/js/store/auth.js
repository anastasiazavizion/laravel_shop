import axios from 'axios';

const state = {
    authenticated: false,
    user: {},
};

const getters = {
    authenticated: state => state.authenticated,
    user: state => state.user,
};

const mutations = {
    SET_AUTHENTICATED (state, value) {
        state.authenticated = value;
    },
    SET_USER (state, value) {
        state.user = value;
    },
};

const actions = {
    async login({ commit}) {
        try {
            const response = await axios.get('/user');
            const { user, permissions } = response.data;
            commit('SET_USER', user);
            commit('SET_AUTHENTICATED', true);
            window.Laravel.jsPermissions = JSON.parse(permissions);
        } catch (error) {
            commit('SET_USER', {});
            commit('SET_AUTHENTICATED', false);
        }
    },
    logout({ commit }) {
        commit('SET_USER', {});
        commit('SET_AUTHENTICATED', false);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
