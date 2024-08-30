import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import auth from './auth.js';
import category_admin from './admin/category.js';
import product_admin from './admin/product.js';
import order_admin from './admin/order.js';

import category from './category.js';
import product from './product.js';
import cart from './cart.js';
import order from './admin/order.js';
import user from './user.js';

const store = createStore({
    modules: {
        auth,
        category_admin,
        product_admin,
        order_admin,
        category,
        product,
        cart,
        order,
        user,
    },
    plugins: [createPersistedState()]
});

export default store;
