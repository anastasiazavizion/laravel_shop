import axios from 'axios';

const state = {
    products: [],
    product:null,
    allProductsAmount:0,
    errors:[]
};

const getters = {
    products: state => state.products,
    allProductsAmount: state => state.allProductsAmount,
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
    setAllProductsAmount (state, value) {
        state.allProductsAmount = value;
    },
    setErrors (state, value) {
        state.errors = value;
    }
};

const actions = {

    async getAll({ commit }, payload) {
        try {
            const response = await axios.get(route('v1.admin.products.index'), {params:{sort:payload.sort}});
            commit('setProducts', response.data);
        } catch (error) {
            commit('setProducts', []);
        }
    },

    async getProduct({ commit}, payload) {
        try {
            const response = await axios.get(route('v1.admin.products.show',payload.id));
            commit('setProduct', response.data);
        } catch (error) {
            commit('setProduct', []);
        }
    },

    async updateProduct({ commit }, { id, data }) {
        commit('setErrors', []);
        data.append('_method', 'put');
        try {
            const response = await axios.post(route('v1.admin.products.update',id), data, {
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
            const response = await axios.post(route('v1.admin.products.store'), data, {
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

    async deleteProduct({ commit}, payload) {
        try {
            const response = await axios.delete(route('v1.admin.products.destroy', payload.id));
        } catch (error) {
        }
    },

    async allProductsAmount({ commit}) {
        try {
            const response = await axios.get(route('v1.admin.allProductsAmount'));
            commit('setAllProductsAmount', response.data);
        } catch (error) {
            console.log(error);
            commit('setAllProductsAmount',null);
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
