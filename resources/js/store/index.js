import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import auth from './auth.js';
import category_admin from './admin/category.js';
import product_admin from './admin/product.js';

import category from './category.js';
import product from './product.js';


const store = createStore({
    modules: {
        auth,
        category_admin,
        product_admin,
        category,
        product
    },
    plugins: [createPersistedState()]
});

export default store;
