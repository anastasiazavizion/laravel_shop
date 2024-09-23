import axios from 'axios';

const state = {
    reviews : null
};

const getters = {
    reviews: state => state.reviews
};

const mutations = {
    setReviews (state, value) {
        state.reviews = value;
    }
};

const actions = {

    async addReview({ commit}, payload) {
        try {
            const response = await axios.post(route('v1.reviews.store',{ product: payload.id }), payload);
        } catch (error) {
        }
    },
    async getReviews({ commit}, product) {
        try {
            const response = await axios.get(route('v1.reviews.index',{ product: product }));
            console.log(response.data);
            commit('setReviews', response.data);
        } catch (error) {
            console.log(error);
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
