import { createStore } from 'vuex'

const store = createStore({
    state: {
        //define variables
        token : localStorage.getItem('token') || 0,
        user_id : localStorage.getItem('user_id') || 0,
        role : localStorage.getItem('role') || 'NO ROLE',
        theme : localStorage.getItem('theme') || 'dark',
    },

    mutations:{
        // update variable value
        UPDATE_TOKEN(state,payload){
            state.token = payload
        },
        UPDATE_USER_ID(state,payload){
            state.user_id = payload
        },
        UPDATE_ROLE(state,payload){
            state.role = payload
        },
        UPDATE_THEME(state,payload){
            state.theme = payload
        }
    },

    actions:{
        // action to be performed
        // TOKEN
        setToken(context,payload){
            localStorage.setItem('token',payload)
            context.commit('UPDATE_TOKEN',payload)
        },
        removeToken(context){
            localStorage.removeItem('token');
            context.commit('UPDATE_TOKEN', 0);
        },
        // USER ID
        setUserId(context,payload){
            localStorage.setItem('user_id',payload)
            context.commit('UPDATE_USER_ID',payload)
        },
        removeUserId(context){
            localStorage.removeItem('user_id');
            context.commit('UPDATE_USER_ID', 0);
        },
        // ROLE
        setRole(context,payload){
            localStorage.setItem('role',payload)
            context.commit('UPDATE_ROLE',payload)
        },
        removeRole(context){
            localStorage.removeItem('role');
            context.commit('UPDATE_ROLE', 'NO ROLE');
        },
        // THEME
        setTheme(context,payload){
            localStorage.setItem('theme',payload)
            context.commit('UPDATE_THEME',payload)
        },
        removeTheme(context){
            localStorage.removeItem('theme');
            context.commit('UPDATE_THEME', 'dark');
        },
    },

    getters:{
        // get state variable value
        getToken: function(state){
            return state.token
        },
        getUserId: function(state){
            return state.user_id
        },
        getRole: function(state){
            return state.role
        },
        getTheme: function(state){
            return state.theme
        }
    }
})

export default store;