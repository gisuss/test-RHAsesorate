<template>
    <v-layout class="rounded rounded-sm">
        <v-navigation-drawer expand-on-hover rail >
            <v-list>
                <v-list-item class="text-decoration-none" prepend-icon="$home" :to="{name :'Home' }" title="Home" subtitle="RH Asesorate"></v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list density="compact" nav>
                <v-list-item class="text-decoration-none" v-if="$store.getters.getToken == 0" prepend-icon="$login" :to="{name : 'Login' }" title="Login"></v-list-item>
                <v-list-item class="text-decoration-none" v-if="$store.getters.getToken == 0" prepend-icon="$register" :to="{name : 'Register' }" title="Register"></v-list-item>
                <v-list-item class="text-decoration-none" v-if="$store.getters.getToken != 0" prepend-icon="$dashboard" :to="{name : 'Dashboard' }" title="Dashboard"></v-list-item>
                <v-list-item class="text-decoration-none" v-if="$store.getters.getToken != 0 && $store.getters.getRole == 'Admin'" prepend-icon="$users" :to="{name : 'Users' }" title="Users"></v-list-item>
                <v-list-item class="text-decoration-none" v-if="$store.getters.getToken != 0" prepend-icon="$account" :to="{name : 'Profile' }" title="Profile"></v-list-item>
                <v-list-item class="text-decoration-none" v-if="$store.getters.getToken != 0" prepend-icon="$star" :to="{name : 'Favs' }" title="Favs"></v-list-item>
                <v-list-item class="text-decoration-none" v-if="$store.getters.getToken != 0" prepend-icon="$logout" title="Logout" @click="logout"></v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app full-height="true">
            <v-main class="d-flex justify-center" >
                <v-btn style="top: 20px; right: 20px; z-index: 10;" active variant="elevated" position="fixed" icon elevation="20" @click="toggleTheme"><v-icon icon="$moon" /></v-btn>
                <router-view></router-view>
            </v-main>
        </v-app>
    </v-layout>
</template>

<script>
    import { useRouter } from "vue-router"
    import { useStore } from 'vuex'
    import { useTheme } from 'vuetify'

    export default {
        setup() {
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
                    if(res.data.success) {
                        store.dispatch('removeToken');
                        store.dispatch('removeUserId');
                        store.dispatch('removeRole');
                        router.push({name:'Home'});
                    }else{
                        error.value = res.data.message;
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
                theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark'
            }

            return {
                logout,
                toggleTheme,
                downloadFile
            }
        }
    }
</script>
