import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import auth from './auth.js';
import category from './category.js';
import product from './product.js';

const store = createStore({
    modules: {
        auth,
        category,
        product,
    },
    plugins: [createPersistedState()]
});

export default store;
