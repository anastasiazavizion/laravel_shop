import axios from "axios";

const state = {
    cartItems: [],
};

const getters = {
    cartItems: state => state.cartItems,
    cartItemsProductIds: state => state.cartItems.map(a => a.id),
    countCartItems: state => state.cartItems.reduce((accumulator, current) => accumulator + current.amount, 0),
    totalPrice: state => state.cartItems.reduce((accumulator, current) => accumulator + current.amount, 0),
    cartTotalPrice: state => state.cartItems.reduce((accumulator, current) => accumulator + (current.amount * current.final_price), 0).toFixed(2),

};

const mutations = {
    setCartItems(state, value) {
        state.cartItems = value;
    },
    addToCart(state, value) {
        state.cartItems.push(value);
    },

     updateProductAmount(state, data) {
       state.cartItems[data.index].amount = data.amount;
    },

     removeFromCart(state, product) {
         state.cartItems = state.cartItems.filter(item => item.id !== product.id);
     },

    clearCart(state) {
        state.cartItems = [];
    },

};

const actions = {
    async addToCart({commit, state, rootGetters}, product) {
        let index = state.cartItems.findIndex(item => item.id === product.id);
        if (index !== -1) {
            commit('updateProductAmount', {index:index, amount:state.cartItems[index].amount + 1});
        } else {
            product.amount = 1;
            commit('addToCart', product);
        }

        if(rootGetters['auth/authenticated']){
            await axios.post('/cart', { product });
        }

    },

    async removeFromCart({commit, state, rootGetters}, product) {

        commit('removeFromCart', product)
        if (rootGetters['auth/authenticated']) {
            await axios.delete('/cart',{data:{
                product:product
                }});
        }
    },

    async updateCount({commit, state, rootGetters}, data) {
        let indexValue = state.cartItems.findIndex(item => item.id === data.id); //find element by product id
        if(indexValue !== -1){
            commit('updateProductAmount', {index:indexValue, amount:data.amount});
            if (rootGetters['auth/authenticated']) {
                await axios.put('/cart/count/' + data.id, data);
            }
        }
    },

    async getCartItemsForUser({commit, state}) {
        try {
            const response = await axios.get('/cart/get');
            commit('setCartItems', response.data.data);
        } catch (error) {
            commit('setCartItems', []);
        }
    },

    async setExistingCartItemsForUser({commit, state}) {
        try {
            const response = await axios.put('/cart/user', state.cartItems);
        } catch (error) {
            console.log(error);
        }
    },

    async updateCart({commit, state}, payload) {
        try {
            commit('setCartItems', payload);
        } catch (error) {
            commit('setCartItems', []);
        }
    },

    async clearCart({commit}) {
        commit('clearCart', []);
    }

};
export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
