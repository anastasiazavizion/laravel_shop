const state = {
    reviews : null,
    errors:[]
};

const getters = {
    reviews: state => state.reviews,
    errors: state => state.errors,
};

const mutations = {
    setReviews (state, value) {
        state.reviews = value;
    },
    setErrors (state, value) {
        state.errors = value;
    }
};

const actions = {

    async addReview({ commit}, payload) {
        try {
            await axios.post(route('v1.reviews.store',{ product: payload.id }), payload);
            commit('setErrors',[]);
        } catch (error) {
            if(error.response.status === 422){
                commit('setErrors', error.response.data.errors);
            }
        }
    },
    async getReviews({ commit}, product) {
        try {
            const response = await axios.get(route('v1.reviews.index',{ product: product }));
            commit('setReviews', response.data);
        } catch (error) {
            commit('setReviews', null);
        }
    },

    async clearErrors({ commit}) {
        commit('setErrors',[]);
    },
};
export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
