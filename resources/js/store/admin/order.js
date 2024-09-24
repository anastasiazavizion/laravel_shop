import axios from "axios";

const state = {

};

const getters = {

};

const mutations = {

};

const actions = {

    async deleteOrder({ commit}, payload) {
        try {
            const response = await axios.delete(route('v1.admin.orders.destroy', payload.id));
        } catch (error) {
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
