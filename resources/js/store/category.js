import axios from 'axios';

const state = {
    categories: [],
    category:null,
    errors:[]
};

const getters = {
    categories: state => state.categories,
    categoriesIds: state => state.categories.map(a => a.id),
    category: state => state.category,
    errors: state => state.errors,
};

const mutations = {
    setCategories (state, value) {
        state.categories = value;
    } ,
    setCategory (state, value) {
        state.category = value;
    },
    setErrors (state, value) {
        state.errors = value;
    }
};

const actions = {

    async getAll({ commit }) {
        try {
            const response = await axios.get('/categories');
            commit('setCategories', response.data);
        } catch (error) {
            commit('setCategories', []);
        }
    },

    async getCategory({ commit}, payload) {
        try {
            const response = await axios.get('/categories/'+payload.id);
            commit('setCategory', response.data);
        } catch (error) {
            commit('setCategory', []);
        }
    },

    async updateCategory({ commit }, { id, data }) {
        commit('setErrors', []);
        try {
            const response = await axios.put('/categories/'+id, data);
        } catch (error) {
            if(error.response.status === 422){
                commit('setErrors', error.response.data.errors);
            }else{
                commit('setErrors', [{'other':'Some other errors'}]);
            }
        }
    },

    async createCategory({ commit }, data) {
        commit('setErrors', []);
        try {
            const response = await axios.post('/categories/', data);
        } catch (error) {
            if(error.response.status === 422){
                console.log(error.response.data.errors);
                commit('setErrors', error.response.data.errors);
            }else{
                commit('setErrors', [{'other':'Some other errors'}]);
            }
        }
    },



    async deleteCategory({ commit}, payload) {
        try {
            const response = await axios.delete('/categories/'+payload.id);
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
