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
    setAuthenticated (state, value) {
        state.authenticated = value;
    },
    setUser (state, value) {
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

    async login({ commit, dispatch}, payload) {
        try {
            await axios.post(route('v1.login'), payload);
            dispatch('userInfo');
        } catch (error) {
            commit('setErrors',error.response.data.errors);
            commit('setUser', {});
            commit('setAuthenticated', false);
        }
    },

    async userInfo({ commit}) {
        try {
            const response = await axios.get(route('v1.user'));
            const { user, permissions } = response.data;
            window.Laravel.jsPermissions = JSON.parse(permissions);
            commit('setUser', user);
            commit('setAuthenticated', true);
            commit('setErrors',null);
        } catch (error) {
            commit('setErrors',error.response.data.errors);
            commit('setUser', {});
            commit('setAuthenticated', false);
        }
    },

    async logout({commit}) {
        try{
            await axios.post(route('v1.logout'));
            commit('setUser', {});
            commit('setAuthenticated', false);
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
