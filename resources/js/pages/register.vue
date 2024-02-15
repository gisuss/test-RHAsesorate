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
            v-if="errors"
        >
            <v-card-text class="text-medium-emphasis text-caption text-center">
                <p class="text-danger" v-for="error in errors" :key="error">
                    <span v-for="err in error" :key="err">{{ err }}</span>
                </p>
            </v-card-text>
        </v-card>

        <v-card
            class="mx-auto pa-12 pb-8"
            elevation="8"
            max-width="448"
            rounded="lg"
        >
            <div class="text-subtitle-1 text-medium-emphasis">First Name</div>

            <v-text-field
                density="compact"
                placeholder="John"
                prepend-inner-icon="$account"
                variant="outlined"
                v-model="form.name"
            ></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis">Last Name</div>

            <v-text-field
                density="compact"
                placeholder="Doe"
                prepend-inner-icon="$account"
                variant="outlined"
                v-model="form.lastname"
            ></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis">E-mail</div>

            <v-text-field
                density="compact"
                placeholder="johndoe@example.com"
                prepend-inner-icon="$email"
                variant="outlined"
                v-model="form.email"
            ></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis">Role</div>

            <v-autocomplete
                v-model="form.role"
                :items="roles"
                density="compact"
                variant="outlined"
                clearable
                chips
            ></v-autocomplete>

            <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">Password</div>

            <v-text-field
                :append-inner-icon="visible1 ? '$eyeOff' : '$eye'"
                :type="visible1 ? 'text' : 'password'"
                density="compact"
                placeholder="Enter your password"
                prepend-inner-icon="$password"
                variant="outlined"
                @click:append-inner="visible1 = !visible1"
                v-model="form.password"
            ></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">Confirm Password</div>

            <v-text-field
                :append-inner-icon="visible2 ? '$eyeOff' : '$eye'"
                :type="visible2 ? 'text' : 'password'"
                density="compact"
                placeholder="Re enter your password"
                prepend-inner-icon="$password"
                variant="outlined"
                @click:append-inner="visible2 = !visible2"
                v-model="form.confirm_password"
            ></v-text-field>

            <v-card
                class="mb-12"
                color="surface-variant"
                variant="tonal"
            >
                <v-card-text class="text-medium-emphasis text-caption">
                    We've been waiting for you! Join our growing community and create an account to get personalized recommendations.
                </v-card-text>
            </v-card>

            <v-btn
                block
                class="mb-8"
                color="blue"
                size="large"
                variant="tonal"
                @click="register"
            >
                Submit
            </v-btn>

            
            <v-btn
                class="text-blue text-decoration-none"
                size="large"
                color="blue"
                :to="{name : 'Login' }"
                variant="tonal"
                block
            >
                Already have account? <v-icon icon="$chevron_right"></v-icon>
            </v-btn>
        </v-card>
    </div>
</template>

<script>
    import { reactive,ref } from 'vue'
    import { useRouter } from "vue-router"
    import { useStore } from 'vuex'

    export default {
        data: () => ({
            visible1: false,
            visible2: false,
            roles: ['Admin', 'Client'],
        }),
        setup() {
            const router = useRouter()
            const store = useStore()

            let form = reactive({
                name: '',
                lastname: '',
                email: '',
                password: '',
                role: '',
                confirm_password: '',
            });
            let errors = ref([])

            const register = async() =>{
                await axios.post('/api/auth/register',form).then(res=>{
                    if(res.data.success) {
                        store.dispatch('setToken',res.data.data.token)
                        router.push({name:'Dashboard'})
                    }
                }).catch(e=>{
                    errors.value = e.response.data.errors
                })
            }
            return{
                form,
                register,
                errors
            }
        }
    }
</script>