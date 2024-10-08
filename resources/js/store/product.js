import axios from 'axios';

const state = {
    products: [],
    product: null,
    links: [],
    wishes_links: [],
    errors: [],
    wishes: []
};

const getters = {
    products: state => state.products,
    product: state => state.product,
    wishes: state => state.wishes,
    links: state => state.links,
    wishes_links: state => state.wishes_links,
    productCategoriesIds: state => state.product.categories.map(a => a.id),
};

const mutations = {
    setProducts(state, value) {
        state.products = value;
    },
    setLinks(state, value) {
        state.links = value;
    },

    setWishesLinks(state, value) {
        state.wishes_links = value;
    },
    setProduct(state, value) {
        state.product = value;
    },

    setWishes(state, value) {
        state.wishes = value;
    }
};

const actions = {
    async getAll({commit}, payload) {
        try {
            const params = payload ? {
                params: {
                    search: payload.filters ? payload.filters.search : '',
                    categoryName: payload.filters ? payload.filters.categoryName : '',
                    categories: payload.filters ? payload.filters.categories : [],
                    ids: payload.ids
                }
            } : [];
            const response = await axios.get((payload && payload.url) ?? route('v1.products.index'), params);
            commit('setProducts', response.data.data);
            commit('setLinks', response.data.meta.links);
        } catch (error) {
            console.log(error);
            commit('setProducts', []);
        }
    },

    async getProduct({commit}, payload) {
        try {
            const response = await axios.get(route('v1.products.show', payload.id));
            commit('setProduct', response.data);
        } catch (error) {
            commit('setProduct', []);
        }
    },

    async addToWishList({commit}, payload) {
        try {
            const response = await axios.post(route('v1.wishlist.wishlist.add', payload.product), {type: payload.type});

        } catch (error) {

        }
    },

    async removeFromWishList({commit}, payload) {
        try {
            const response = await axios.delete(route('v1.wishlist.wishlist.remove', payload.product), {
                params: {type: payload.type}
            });

        } catch (error) {

        }
    },

    async wishes({commit}, payload) {
        try {
            const response = await axios.get((payload && payload.url) ?? route('v1.wishlist.wishlist.all'), {params: payload});
            commit('setWishes', response.data.data);
            commit('setWishesLinks', response.data.meta.links);
        } catch (error) {
            commit('setWishes', []);
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
