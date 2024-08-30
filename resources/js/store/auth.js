import axios from 'axios';

const state = {
    authenticated: false,
    user: {},
    errors: null,
};

const getters = {
    authenticated: state => state.authenticated,
    user: state => state.user,
    errors: state => state.errors,
};

const mutations = {
    SET_AUTHENTICATED (state, value) {
        state.authenticated = value;
    },
    SET_USER (state, value) {
        state.user = value;
    },
    setErrors (state, value) {
        state.errors = value;
    },
};

const actions = {
    async register({ commit, dispatch}, payload) {
        try {
            await axios.post(route('v1.register'), payload);
            await dispatch('login',payload)
            commit('setErrors',null);
        } catch (error) {
            commit('setErrors',error.response.data.errors);
        }
    },

    async login({ commit}, payload) {
        try {
            await axios.post(route('v1.login'), payload);
            const response = await axios.get(route('v1.user'));
            const { user, permissions } = response.data;
            window.Laravel.jsPermissions = JSON.parse(permissions);
            commit('SET_USER', user);
            commit('SET_AUTHENTICATED', true);
            commit('setErrors',null);
        } catch (error) {
            commit('setErrors',error.response.data.errors);
            commit('SET_USER', {});
            commit('SET_AUTHENTICATED', false);
        }
    },
    async logout({commit}) {
        try{
            await axios.post(route('v1.logout'));
            commit('SET_USER', {});
            commit('SET_AUTHENTICATED', false);
            commit('setErrors',null);
        }catch(error){
            commit('setErrors',error.response.data.errors);
        }
    },
    async clearErrors({commit}) {
        commit('setErrors',null);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
