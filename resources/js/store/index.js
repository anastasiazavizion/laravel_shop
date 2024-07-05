import { createStore } from 'vuex'
import axios from "axios";

import createPersistedState from 'vuex-persistedstate';

const store = createStore({
    namespaced: true,
    state:{
        authenticated:false,
        user:{}
    },
    getters:{
        authenticated(state){
            return state.authenticated
        },
        user(state){
            return state.user
        }
    },
    mutations:{
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },
        SET_USER (state, value) {
            state.user = value
        }
    },
    actions:{
        async login({ commit }) {
            try {
                const response = await axios.get('/api/user');
                const userData = response.data;
                commit('SET_USER', userData);
                commit('SET_AUTHENTICATED', true);
            } catch (error) {
                commit('SET_USER', {});
                commit('SET_AUTHENTICATED', false);
            }
        },
        logout({commit}){
            commit('SET_USER',{})
            commit('SET_AUTHENTICATED',false)
        }
    },
    plugins: [createPersistedState()] // Добавление плагина vuex-persistedstate
})
export default store;
