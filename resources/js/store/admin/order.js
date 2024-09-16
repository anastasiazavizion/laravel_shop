const state = {
    order:null,
    orders:null,
    links:null,
};
const getters = {
    order: state => state.order,
    orders: state => state.orders,
    links: state => state.links,
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
            const response = await axios.get((payload && payload.url) ?? route('v1.admin.orders.index'));
            commit('setOrders', response.data.data);
            commit('setLinks', response.data.meta.links);
        } catch (error) {
            commit('setOrders',null);
            commit('setLinks',null);
        }
    },

    async getOrder({ commit}, payload) {
        try {
            const response = await axios.get(route('v1.admin.orders.show', payload.id));
            commit('setOrder', response.data);
        } catch (error) {
            commit('setOrder',null);
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
