const state = {
    order:null,
};
const getters = {
    order: state => state.order,
};

const mutations = {
    setOrder (state, value) {
        state.order = value;
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
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
