import axios from "axios";

const state = {
    user: [],
};

const getters = {
    user: state => state.user
};

const mutations = {
    setUser (state, value) {
        state.user = value;
    }
};

const actions = {

    async getUser({ commit }) {
        try {
            const response = await axios.get('/user');
            const { user } = response.data;
            commit('setUser', user);
        } catch (error) {
            commit('setUser', null);
        }
    },

};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
