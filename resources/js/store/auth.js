import axios from 'axios';

const state = {
    authenticated: false,
    user: {},
    errors: [],
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
            dispatch('clearErrors');
        } catch (error) {
            commit('setErrors',error.response.data.errors);
        }
    },

    async login({ commit, dispatch}, payload) {
        try {
            await axios.post(route('v1.login'), payload);
            dispatch('userInfo');
            dispatch('clearErrors');
        } catch (error) {
            if(error.response.status === 403){
                commit('setErrors',{auth:true});
            }else{
                commit('setErrors',error.response.data.errors);
            }
            commit('setUser', {});
            commit('setAuthenticated', false);
        }
    },

    async userInfo({ commit,dispatch}) {
        try {
            const response = await axios.get(route('v1.user'));
            const { user, permissions } = response.data;
            window.Laravel.jsPermissions = JSON.parse(permissions);
            commit('setUser', user);
            commit('setAuthenticated', true);
            dispatch('clearErrors');
        } catch (error) {
            commit('setErrors',error.response.data.errors);
            commit('setUser', {});
            commit('setAuthenticated', false);
        }
    },

    async logout({commit, dispatch}) {
        try{
            await axios.post(route('v1.logout'));
            commit('setUser', {});
            commit('setAuthenticated', false);
            dispatch('clearErrors');
        }catch(error){
            commit('setErrors',error.response.data.errors);
        }
    },

    async clearErrors({commit}) {
        commit('setErrors',[]);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
