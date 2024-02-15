<template>
    <div class="py-4">
        <v-img
            class="mx-auto my-6"
            max-width="228"
            src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
        ></v-img>

        <v-card
            class="mb-12 pa-4"
            color="surface-variant"
            variant="tonal"
            v-if="error"
        >
            <v-card-text class="text-medium-emphasis text-caption text-center">
                <p class="text-danger">{{ error }}</p>
            </v-card-text>
        </v-card>

        <v-card
            class="mx-auto pa-12 pb-8"
            elevation="8"
            max-width="448"
            rounded="lg"
        >
            <div class="text-subtitle-1 text-medium-emphasis">E-mail or Username</div>

            <v-text-field
                density="compact"
                placeholder="Email address"
                prepend-inner-icon="$email"
                variant="outlined"
                v-model="form.email_username"
            ></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                Password
            </div>

            <v-text-field
                :append-inner-icon="visible ? '$eyeOff' : '$eye'"
                :type="visible ? 'text' : 'password'"
                density="compact"
                placeholder="Enter your password"
                prepend-inner-icon="$password"
                variant="outlined"
                @click:append-inner="visible = !visible"
                v-model="form.password"
            ></v-text-field>

            <v-card
                class="mb-12"
                color="surface-variant"
                variant="tonal"
            >
                <v-card-text class="text-medium-emphasis text-caption">
                    Welcome back to your home away from home! Sign in to relax and unwind in your own space.
                </v-card-text>
            </v-card>

            <v-btn
                block
                class="mb-8"
                color="blue"
                size="large"
                variant="tonal"
                @click="login"
            >
                Log In
            </v-btn>

            
            <v-btn
                class="text-blue text-decoration-none"
                size="large"
                color="blue"
                :to="{name : 'Register' }"
                variant="tonal"
                block
            >
                Sign up now <v-icon icon="$chevron_right"></v-icon>
            </v-btn>
        </v-card>
    </div>
</template>

<script>
    import { reactive,ref } from 'vue'
    import { useRouter } from "vue-router"
    import { useStore } from 'vuex'

    export default{
        data: () => ({
            visible: false,
        }),
        setup() {
            const router = useRouter()
            const store = useStore()

            let form = reactive({
                email_username: '',
                password: ''
            });
            let error = ref('');

            const login = async() => {
                await axios.post('/api/auth/login', form).then(res => {
                    if(res.data.success) {
                        store.dispatch('setToken',res.data.token);
                        store.dispatch('setUserId',res.data.user_id);
                        router.push({name:'Dashboard'});
                    }else{
                        error.value = res.data.message;
                    }
                });
            }

            return{
                form,
                login,
                error
            }
        }
    }
</script>