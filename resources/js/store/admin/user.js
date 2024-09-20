import axios from 'axios';

const state = {
    allUsersAmount:0,
};

const getters = {
    allUsersAmount: state => state.allUsersAmount
};

const mutations = {
    setAllUsersAmount (state, value) {
        state.allUsersAmount = value;
    },
};

const actions = {

    async allUsersAmount({ commit}) {
        try {
            const response = await axios.get(route('v1.admin.allUsersAmount'));
            commit('setAllUsersAmount', response.data);
        } catch (error) {
            commit('setAllUsersAmount',null);
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
