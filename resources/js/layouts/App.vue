<template>    
    <v-app>
        <v-navigation-drawer v-model="drawer" mobile-breakpoint="sm">
            <v-list>
                <v-list-item class="text-decoration-none" prepend-icon="$home" :to="{name :'Home' }" title="Home" subtitle="RH Asesorate"></v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list density="compact" nav>
                <div v-if="$store.getters.getToken === 0">
                    <v-list-subheader title="AUTH"></v-list-subheader>
                    <v-list-item class="text-decoration-none" v-if="$store.getters.getToken === 0" prepend-icon="$login" :to="{name : 'Login' }" title="Login"></v-list-item>
                    <v-list-item class="text-decoration-none" v-if="$store.getters.getToken === 0" prepend-icon="$register" :to="{name : 'Register' }" title="Register"></v-list-item>
                </div>
                <div v-if="$store.getters.getToken != 0">
                    <v-list-subheader title="DASHBOARD"></v-list-subheader>
                    <v-list-item class="text-decoration-none" v-if="$store.getters.getToken != 0" prepend-icon="$dashboard" :to="{name : 'Dashboard' }" title="Dashboard"></v-list-item>
                    <v-list-item class="text-decoration-none" v-if="$store.getters.getToken != 0" prepend-icon="$account" :to="{name : 'Profile' }" title="Profile"></v-list-item>
                    <v-list-item class="text-decoration-none" v-if="$store.getters.getToken != 0" prepend-icon="$star" :to="{name : 'Favs' }" title="Favs"></v-list-item>
                </div>
                <div v-if="$store.getters.getToken != 0 && $store.getters.getRole == 'Admin'">
                    <v-divider></v-divider>
                    <v-list-subheader title="ADMIN"></v-list-subheader>
                    <v-list-item class="text-decoration-none" v-if="$store.getters.getToken != 0 && $store.getters.getRole == 'Admin'" prepend-icon="$users" :to="{name : 'Users' }" title="Users"></v-list-item>
                </div>

                <v-divider></v-divider>
                <v-list-subheader title="THEME"></v-list-subheader>
                <v-list-item v-if="$store.getters.getTheme == 'light'" class="text-decoration-none" prepend-icon="$moon" title="Theme" @click="toggleTheme"></v-list-item>
                <v-list-item v-else class="text-decoration-none" prepend-icon="$sun" title="Theme" @click="toggleTheme"></v-list-item>

                <div v-if="$store.getters.getToken != 0">
                    <v-divider></v-divider>
                    <v-list-subheader title="LOGOUT"></v-list-subheader>
                    <v-list-item class="text-decoration-none" v-if="$store.getters.getToken != 0" prepend-icon="$logout" title="Logout" @click="logout"></v-list-item>
                </div>
            </v-list>
        </v-navigation-drawer>

        <v-toolbar>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Test RH Asesorate</v-toolbar-title>
        </v-toolbar>

        <v-main >
            <router-view />
        </v-main>
    </v-app>
</template>

<script>
    import { ref } from 'vue'
    import { useRouter } from "vue-router"
    import { useStore } from 'vuex'
    import { useTheme } from 'vuetify'

    export default {
        setup() {
            const drawer = ref(true)
            const router = useRouter();
            const store = useStore();
            const theme = useTheme();

            const logout = async() => {
                await axios.post('/api/auth/logout',{},
                {
                    headers: {
                        'Authorization': `Bearer ${store.getters.getToken}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                }).then(res => {
                    // console.log(res);
                    if(res.data.success) {
                        store.dispatch('removeToken');
                        store.dispatch('removeUserId');
                        store.dispatch('removeRole');
                        store.dispatch('removeQuantity');
                        router.push({name:'Home'});
                    }else{
                        store.dispatch('removeToken');
                        store.dispatch('removeUserId');
                        store.dispatch('removeRole');
                        store.dispatch('removeQuantity');
                        router.push({name:'Home'});
                        // error.value = res.data.message;
                    }
                });
            };

            function downloadFile() {
                axios.get('/api/download/CV-Gisuss-SPA-ENG_02-24.pdf', {
                    responseType: 'blob',
                }).then((response) => {
                    const file = new File([response.data], 'CV-Gisuss-SPA-ENG_02-24.pdf');
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(file);
                    link.download = 'CV-Gisuss-SPA-ENG_02-24.pdf';
                    link.click();
                });
            };

            function toggleTheme() {
                theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark';
                store.dispatch('setTheme', theme.global.name.value);
            }

            return {
                logout,
                toggleTheme,
                downloadFile,
                drawer,
                toggleDrawer() {
                    store.commit('toggleDrawer')
                }
            }
        }
    }
</script>
