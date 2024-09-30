const state = {
    coordinates:[],
};

const getters = {
    coordinates: state => state.coordinates
};

const mutations = {
    setCoordinates (state, value) {
        state.coordinates = value;
    },
};

const actions = {

    async getCoordinates({ commit}) {
        try {
            const response = await axios.get(route('v1.admin.map.markers'));
            commit('setCoordinates', response.data);
        } catch (error) {
            commit('setCoordinates',null);
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
