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
            const response = await axios.get(route('v1.admin.categories.index'));
            commit('setCategories', response.data);
        } catch (error) {
            commit('setCategories', []);
        }
    },

    async getCategory({ commit}, payload) {
        try {
            const response = await axios.get(route('v1.admin.categories.show',payload.id));
            commit('setCategory', response.data);
        } catch (error) {
            commit('setCategory', []);
        }
    },

    async updateCategory({ commit }, { id, data }) {
        commit('setErrors', []);
        try {
            const response = await axios.put(route('v1.admin.categories.update',id), data);
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
            const response = await axios.post(route('v1.admin.categories.store'), data);
        } catch (error) {
            if(error.response.status === 422){
                commit('setErrors', error.response.data.errors);
            }else{
                commit('setErrors', [{'other':'Some other errors'}]);
            }
        }
    },

    async deleteCategory({ commit}, payload) {
        try {
            const response = await axios.delete(route('v1.admin.categories.destroy',payload.id));
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
