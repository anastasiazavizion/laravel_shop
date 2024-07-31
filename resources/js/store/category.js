import axios from 'axios';

const state = {
    categories: [],
    category:null,
};

const getters = {
    categories: state => state.categories,
    categoriesIds: state => state.categories.map(a => a.id),
    category: state => state.category,
};

const mutations = {
    setCategories (state, value) {
        state.categories = value;
    } ,
    setCategory (state, value) {
        state.category = value;
    }
};

const actions = {

    async getAll({ commit }) {
        try {
            const response = await axios.get('/user/categories');
            commit('setCategories', response.data);
        } catch (error) {
            commit('setCategories', []);
        }
    },

    async getCategory({ commit}, payload) {
        try {
            const response = await axios.get('/user/categories/'+payload.id);
            commit('setCategory', response.data);
        } catch (error) {
            commit('setCategory', []);
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
