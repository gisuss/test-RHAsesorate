import { createStore } from 'vuex'

const store = createStore({


    state: {
        //define variables
        token : localStorage.getItem('token') || 0,
        user_id : localStorage.getItem('user_id') || 0,
    },

    mutations:{
        // update variable value
        UPDATE_TOKEN(state,payload){
            state.token = payload
        },
        UPDATE_USER_ID(state,payload){
            state.user_id = payload
        }
    },

    actions:{
        // action to be performed
        setToken(context,payload){
            localStorage.setItem('token',payload)
            context.commit('UPDATE_TOKEN',payload)
        },
        removeToken(context){
            localStorage.removeItem('token');
            context.commit('UPDATE_TOKEN', 0);
        },
        setUserId(context,payload){
            localStorage.setItem('user_id',payload)
            context.commit('UPDATE_USER_ID',payload)
        },
        removeUserId(context){
            localStorage.removeItem('user_id');
            context.commit('UPDATE_USER_ID', 0);
        },
    },

    getters:{
        // get state variable value
        getToken: function(state){
            return state.token
        },
        getUserId: function(state){
            return state.user_id
        }
    }

})

export default store;