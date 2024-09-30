import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import auth from './auth.js';
import category_admin from './admin/category.js';
import product_admin from './admin/product.js';

import category from './category.js';
import product from './product.js';
import cart from './cart.js';
import order from './order.js';
import user from './user.js';
import review from './review.js';
import admin_charts from './admin/charts.js';
import admin_users from './admin/user.js';
import admin_orders from './admin/order.js';
import map from './admin/map.js';

const store = createStore({
    modules: {
        auth,
        category_admin,
        product_admin,
        category,
        product,
        cart,
        order,
        user,
        review,
        admin_charts,
        admin_users,
        admin_orders,
        map,
    },
    plugins: [createPersistedState()]
});

export default store;
