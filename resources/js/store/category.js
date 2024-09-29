import axios from 'axios';

const state = {
    categories: [],
};

const getters = {
    categories: state => state.categories,
    categoriesIds: state => state.categories.map(a => a.id),
};

const mutations = {
    setCategories (state, value) {
        state.categories = value;
    }
};

const actions = {

    async getAll({ commit }, payload) {
        try {
            const response = await axios.get(route('v1.categories.index'), {params:payload});
            commit('setCategories', response.data);
        } catch (error) {
            commit('setCategories', []);
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
