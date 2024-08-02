import axios from 'axios';

const state = {
    products: [],
    product:null,
    links:[],
    errors:[]
};

const getters = {
    products: state => state.products,
    product: state => state.product,
    links: state => state.links,
    productCategoriesIds: state => state.product.categories.map(a=>a.id),
};

const mutations = {
    setProducts (state, value) {
        state.products = value;
    } ,
    setLinks(state, value) {
        state.links = value;
    } ,
    setProduct (state, value) {
        state.product = value;
    }
};

const actions = {
    async getAll({ commit }, payload) {
        try {
            const response = await axios.get((payload && payload.url) ?? '/user/products', {params:payload});
            commit('setProducts', response.data.data);
            commit('setLinks', response.data.meta.links);
        } catch (error) {
            console.log(error);
            commit('setProducts', []);
        }
    },

    async getProduct({ commit}, payload) {
        try {
            const response = await axios.get('/user/products/'+payload.id);
            commit('setProduct', response.data.product);
        } catch (error) {
            commit('setProduct', []);
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
