import axios from 'axios';

const state = {
    products: [],
    product:null,
    errors:[]
};

const getters = {
    products: state => state.products,
    product: state => state.product,
    productCategoriesIds: state => state.product.categories.map(a=>a.id),
    errors: state => state.errors,
};

const mutations = {
    setProducts (state, value) {
        state.products = value;
    } ,
    setProduct (state, value) {
        state.product = value;
    },
    setErrors (state, value) {
        state.errors = value;
    }
};

const actions = {

    async getAll({ commit }) {
        try {
            const response = await axios.get('/admin/data/products');
            commit('setProducts', response.data);
        } catch (error) {
            commit('setProducts', []);
        }
    },

    async getProduct({ commit}, payload) {
        try {
            const response = await axios.get('/admin/data/products/'+payload.id);
            commit('setProduct', response.data);
        } catch (error) {
            commit('setProduct', []);
        }
    },

    async updateProduct({ commit }, { id, data }) {
        commit('setErrors', []);
        data.append('_method', 'put');
        try {
            const response = await axios.post('/admin/data/products/'+id, data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
        } catch (error) {
            if(error.response.status === 422){
                commit('setErrors', error.response.data.errors);
            }else{
                commit('setErrors', [{'other':'Some other errors'}]);
            }
        }
    },

    async createProduct({ commit }, data) {
        commit('setErrors', []);
        try {
            const response = await axios.post('/admin/data/products/', data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
        } catch (error) {
            if(error.response.status === 422){
                console.log(error.response.data.errors);
                commit('setErrors', error.response.data.errors);
            }else{
                commit('setErrors', [{'other':'Some other errors'}]);
            }
        }
    },

    async deleteProduct({ commit}, payload) {
        try {
            const response = await axios.delete('/admin/data/products/'+payload.id);
        } catch (error) {
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
