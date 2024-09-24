import axios from "axios";

const state = {
    order:null,
    orders:null,
    links:null,
    allOrdersAmount:0,
};
const getters = {
    order: state => state.order,
    orders: state => state.orders,
    links: state => state.links,
    allOrdersAmount: state => state.allOrdersAmount,
};

const mutations = {
    setOrder (state, value) {
        state.order = value;
    },
    setOrders (state, value) {
        state.orders = value;
    },
    setLinks(state, value) {
        state.links = value;
    },
    setAllOrdersAmount(state, value) {
        state.allOrdersAmount = value;
    }
};

const actions = {
    async getOrderByVendorId({ commit}, id) {
        try {
            const response = await axios.get(route('v1.orderByVendorId'), {params:{id:id}});
            commit('setOrder', response.data);
        } catch (error) {
            commit('setOrder',null);
        }
    },

    async getOrders({ commit}, payload) {
        try {
            const params = payload ? {
                params: {
                    user_id: payload.user_id
                }
            } : [];
            const response = await axios.get((payload && payload.url) ?? route('v1.orders.index'), params);
            commit('setOrders', response.data.data);
            commit('setLinks', response.data.meta.links);
        } catch (error) {
            commit('setOrders',null);
            commit('setLinks',null);
        }
    },

    async getOrder({ commit}, payload) {
        try {
            const response = await axios.get(route('v1.orders.show', payload.id));
            commit('setOrder', response.data);
        } catch (error) {
            console.log(error);
            commit('setOrder',null);
        }
    },

    async allOrdersAmount({ commit}) {
        try {
            const response = await axios.get(route('v1.admin.allOrdersAmount'));
            commit('setAllOrdersAmount', response.data);
        } catch (error) {
            console.log(error);
            commit('setAllOrdersAmount',null);
        }
    },

    //TODO move to admin
    async deleteOrder({ commit}, payload) {
        try {
            const response = await axios.delete(route('v1.orders.destroy', payload.id));
        } catch (error) {
        }
    },

    async deleteOrderByVendorOrderId({ commit}, payload) {
        try {
            const response = await axios.delete(route('v1.orders.destroy', payload.id), {params:{id:payload.id}});
        } catch (error) {
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
