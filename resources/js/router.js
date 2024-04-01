import { createWebHistory, createRouter } from 'vue-router';
import home from './pages/home.vue';
import login from './pages/login.vue';
import register from './pages/register.vue';
import dashboard from './pages/dashboard.vue';
import favs from './pages/favs.vue';
import userFavs from './pages/userFavs.vue';
import profile from './pages/profile.vue';
import users from './pages/users.vue';
import store from './store/index.js';

const routes = [
    {
        path : '/',
        name : 'Home',
        component : home
    },
    {
        path : '/login',
        name : 'Login',
        component : login,
        meta:{
            requiresAuth:false
        }
    },
    {
        path : '/register',
        name : 'Register',
        component : register,
        meta:{
            requiresAuth:false
        }
    },
    {
        path : '/dashboard',
        name : 'Dashboard',
        component : dashboard,
        meta:{
            requiresAuth:true
        }
    },
    {
        path : '/favs',
        name : 'Favs',
        component : favs,
        meta:{
            requiresAuth:true
        }
    },
    {
        path : '/user-favs/:id',
        name : 'UserFavs',
        component : userFavs,
        meta:{
            requiresAuth:true
        }
    },
    {
        path : '/profile',
        name : 'Profile',
        component : profile,
        meta:{
            requiresAuth:true
        }
    },
    {
        path : '/users',
        name : 'Users',
        component : users,
        meta:{
            requiresAuth:true
        }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});


router.beforeEach((to,from) =>{
    if(to.meta.requiresAuth && store.getters.getToken == 0){
        return { name : 'Login'}
    }
    if(to.meta.requiresAuth == false && store.getters.getToken != 0){
        return { name : 'Dashboard'}
    }
})

export default router;