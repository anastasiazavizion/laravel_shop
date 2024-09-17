import axios from 'axios';

const state = {
    ordersAmountByProducts: [],
    ordersAmountByCities: [],
    ordersAmountByStatuses: [],
    ordersAmountByCategories: [],
    ordersTotal: 0
};

const getters = {
    ordersAmountByProducts: state => state.ordersAmountByProducts,
    ordersAmountByCities: state => state.ordersAmountByCities,
    ordersAmountByStatuses: state => state.ordersAmountByStatuses,
    ordersAmountByCategories: state => state.ordersAmountByCategories,
    ordersTotal: state => state.ordersTotal,
};

const mutations = {
    setOrdersAmountByProducts (state, value) {
        state.ordersAmountByProducts = value;
    },
    setOrdersAmountByCities (state, value) {
        state.ordersAmountByCities = value;
    },
    setOrdersAmountByStatuses (state, value) {
        state.ordersAmountByStatuses = value;
    },
    setOrdersTotal (state, value) {
        state.ordersTotal = value;
    },
    setOrdersAmountByCategories (state, value) {
        state.ordersAmountByCategories = value;
    }
};

const actions = {

    async ordersAmountByProducts({ commit}, payload) {
        try {
            const response = await axios.get(route('v1.admin.ordersAmountByProducts'));
            commit('setOrdersAmountByProducts', response.data);
        } catch (error) {
            commit('setOrdersAmountByProducts', []);
        }
    },

    async ordersAmountByCities({ commit}, payload) {
        try {
            const response = await axios.get(route('v1.admin.ordersAmountByCities'));
            commit('setOrdersAmountByCities', response.data);
        } catch (error) {
            commit('setOrdersAmountByCities', []);
        }
    },

    async ordersAmountByStatuses({ commit}, payload) {
        try {
            const response = await axios.get(route('v1.admin.ordersAmountByStatuses'));
            commit('setOrdersAmountByStatuses', response.data);
        } catch (error) {
            commit('setOrdersAmountByStatuses', []);
        }
    },
    async ordersAmountByCategories({ commit}, payload) {
        try {
            const response = await axios.get(route('v1.admin.ordersAmountByCategories'));
            commit('setOrdersAmountByCategories', response.data);
        } catch (error) {
            commit('setOrdersAmountByCategories', []);
        }
    },
    async ordersTotal({ commit}, payload) {
        try {
            const response = await axios.get(route('v1.admin.ordersTotal'));
            commit('setOrdersTotal', response.data);
        } catch (error) {
            commit('setOrdersTotal', []);
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
