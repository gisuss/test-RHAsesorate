<template>
    <div class="py-6 px-4">
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
            min-width="400"
            rounded="lg"
        >
            <div class="text-subtitle-1 text-medium-emphasis">First Name</div>

            <v-text-field
                density="compact"
                placeholder="John"
                prepend-inner-icon="$account"
                variant="outlined"
                v-model="form.name"
                :rules="[rules.required]"
            ></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis">Last Name</div>

            <v-text-field
                density="compact"
                placeholder="Doe"
                prepend-inner-icon="$account"
                variant="outlined"
                v-model="form.lastname"
                :rules="[rules.required]"
                class="mt-2"
            ></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis">E-mail</div>

            <v-text-field
                density="compact"
                placeholder="johndoe@example.com"
                prepend-inner-icon="$email"
                variant="outlined"
                v-model="form.email"
                :rules="[rules.required]"
                class="mt-2"
            ></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis">Role</div>

            <v-combobox
                v-model="form.role"
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
                v-model="form.password"
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
                v-model="form.confirm_password"
                :rules="[rules.required, rules.counter]"
                class="mt-2"
            ></v-text-field>

            <!-- <v-card
                class="mb-12"
                color="surface-variant"
                variant="tonal"
            >
                <v-card-text class="text-medium-emphasis text-caption">
                    We've been waiting for you! Join our growing community and create an account to get personalized recommendations.
                </v-card-text>
            </v-card> -->

            <v-btn
                block
                class="mb-8"
                color="blue"
                size="large"
                variant="tonal"
                @click="updateUsr"
            >
                Update
            </v-btn>

            
            <v-btn
                class="text-blue text-decoration-none"
                size="large"
                color="blue"
                :to="{name : 'Dashboard' }"
                variant="tonal"
                block
            >
                Go to dashboard <v-icon icon="$chevron_right"></v-icon>
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
            roles: ['Admin', 'Client'],
            user: [],
        }),
        mounted() {
			this.getData(this.$store.getters.getUserId)
		},
        methods: {
            getData( id ) {
				axios.get(`/api/user/show/${id}`, {
					headers: {
						'Authorization': `Bearer ${this.$store.getters.getToken}`,
						'Content-Type': 'application/json',
						'Accept': 'application/json',
					}
				})
				.then(response => {
                    // console.log(response);
                    this.form.name = response.data.data.name;
                    this.form.lastname = response.data.data.lastname;
                    this.form.email = response.data.data.email;
                    this.form.role = response.data.data.role;
				}).catch(err => {
					errors.value = err.response.data.message
				});
			},
        },
        setup() {
            const router = useRouter()
            const store = useStore()

            let rules = {
				required: value => !!value || 'Field required.',
				counter: value => value.length <= 16 || 'Maximum 16 characters.',
				email: value => {
					const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
					return pattern.test(value) || 'Invalid e-mail.'
				},
			};
            let form = reactive({
                name: '',
                lastname: '',
                email: '',
                role: '',
                password: null,
                confirm_password: null,
            });
            let visible1 = ref(false);
            let visible2 = ref(false);
            let errors = ref([])

            const updateUsr = async() => {
                await axios.post(`/api/user/update/${store.getters.getUserId}`, form,
                {
                    headers: {
                        'Authorization': `Bearer ${store.getters.getToken}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                }).then(res=>{
                    // console.log(res);
                    if(res.status == 200) {
                        if (form.role != store.getters.getRole) {
                            store.dispatch('setRole', form.role);
                        }
                        alert("Profile updated.");
                        router.push({name:'Dashboard'});
                    }
                }).catch(e=>{
                    errors.value = e.response.data.errors
                })
            }
            return{
                form,
                updateUsr,
                errors,
                rules,
                visible1,
                visible2
            }
        }
    }
</script>