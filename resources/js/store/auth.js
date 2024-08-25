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
    async login({ commit}, payload) {
        try {
            await axios.post(route('v1.login'), payload);
            const response = await axios.get(route('v1.user'));
            const { user, permissions } = response.data;
            commit('SET_USER', user);
            commit('SET_AUTHENTICATED', true);
            window.Laravel.jsPermissions = JSON.parse(permissions);
        } catch (error) {
            console.log(error);
            commit('SET_USER', {});
            commit('SET_AUTHENTICATED', false);
        }
    },
    async logout({commit}) {
        try{
            await axios.post(route('v1.logout'));
            commit('SET_USER', {});
            commit('SET_AUTHENTICATED', false);
        }catch(error){
            console.log(error);
        }
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
