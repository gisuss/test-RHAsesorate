<template>
    <!-- src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg" -->
    <div class="py-6 px-4">
        <v-img
            class="mx-auto my-6"
            max-width="228"
            :src = "this.$store.getters.getTheme == 'dark' ? src_dark : src_light"
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
            min-width="400"
            rounded="lg"
        >
            <div class="text-subtitle-1 text-medium-emphasis">First Name</div>

            <v-text-field
                density="compact"
                placeholder="John"
                prepend-inner-icon="$account"
                variant="outlined"
                v-model.trim="form.name"
                :rules="[rules.required]"
            ></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis">Last Name</div>

            <v-text-field
                density="compact"
                placeholder="Doe"
                prepend-inner-icon="$account"
                variant="outlined"
                v-model.trim="form.lastname"
                :rules="[rules.required]"
                class="mt-2"
            ></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis">E-mail</div>

            <v-text-field
                density="compact"
                placeholder="johndoe@example.com"
                prepend-inner-icon="$email"
                variant="outlined"
                v-model.trim="form.email"
                :rules="[rules.email, rules.required]"
                class="mt-2"
            ></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis">Role</div>

            <v-combobox
                v-model.trim="form.role"
                :items="roles"
                density="compact"
                variant="outlined"
                clearable
                :rules="[rules.required]"
                class="mt-2"
            ></v-combobox>

            <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">Password</div>

            <v-text-field
                :append-inner-icon="visible1 ? '$eyeOff' : '$eye'"
                :type="visible1 ? 'text' : 'password'"
                density="compact"
                placeholder="Enter your password"
                prepend-inner-icon="$password"
                variant="outlined"
                @click:append-inner="visible1 = !visible1"
                v-model.trim="form.password"
                :rules="[rules.required, rules.counter]"
                class="mt-2"
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
                v-model.trim="form.confirm_password"
                :rules="[rules.required, rules.counter]"
                class="mt-2"
            ></v-text-field>

            <v-card
                class="mt-4 mb-12"
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
    import imageDark from "../../../public/vuetify_dark.svg"
    import imageLight from "../../../public/vuetify_light.svg"

    export default {
        setup() {
            const router = useRouter();

            let rules = {
				required: value => !!value || 'Field required.',
				counter: value => value.length <= 16 || 'Maximum 16 characters.',
				email: value => {
					const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
					return pattern.test(value) || 'Invalid e-mail.'
				},
			};
            let src_dark = imageDark;
            let src_light = imageLight;
            let form = reactive({
                name: '',
                lastname: '',
                email: '',
                password: '',
                role: '',
                confirm_password: ''
            });
            let roles = ['Admin', 'Client'];
            let errors = ref([]);
            let visible1 = ref(false);
            let visible2 = ref(false);

            const register = async() => {
                await axios.post('/api/auth/register',form).then(res => {
                    // console.log(res);
                    if(res.status == 200) {
                        router.push({name:'Login'});
                    }
                }).catch(e=>{
                    errors.value = e.response.data.errors;
                })
            }

            return {
                form,
                register,
                errors,
                roles,
                visible1,
                visible2,
                rules,
                src_dark,
                src_light,
            }
        }
    }
</script>