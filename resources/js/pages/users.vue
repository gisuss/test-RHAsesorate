<template>
    <v-container class="py-6 px-4">
        <v-card
            flat
            rounded="lg"
            class="pa-4"
        >
            <v-card-title>
                <v-row>
                    <v-col>All users registered</v-col>
                    <v-spacer></v-spacer>
                    <v-col class="d-flex justify-end">
                        <v-btn
                            class="text-blue text-decoration-none"
                            color="blue"
                            variant="tonal"
                            :to="{name : 'Dashboard' }"
                        >
                            Go to dashboard <v-icon icon="$chevron_right"></v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-data-table
                    :headers="headers"
                    :items="items"
                    :items-per-page=15
                    no-data-text="No data."
                    class="pa-4"
                >
                    <!-- Acciones -->
                    <template v-slot:item.actions="{ item }">
                        <v-tooltip location="start" text="Show the user's quotes">
                            <template v-slot:activator="{ props }">
                                <router-link :to="{ name: 'UserFavs', params: { id: item.id }}">
                                    <v-btn 
                                        v-bind="props"
                                        size="x-small" icon="$eye" class="mr-2" >
                                    </v-btn>
                                </router-link>
                            </template>
                        </v-tooltip>
                        <v-tooltip location="bottom" text="Block user">
                            <template v-slot:activator="{ props }">
                                <v-btn
                                    v-if="item.active === 1" v-bind="props"
                                    :disabled="Number(item.id) == Number(userAuth)"
                                    size="x-small" icon="$block" 
                                    @click="blockUser(item.id)" >
                                </v-btn>
                                <v-btn 
                                    v-else
                                    :disabled="Number(item.id) == Number(userAuth)"
                                    v-bind="props" size="x-small" icon="$activate"
                                    @click="activateUser(item.id)" >
                                </v-btn>
                            </template>
                        </v-tooltip>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>

        <v-snackbar v-model="snackbar" vertical :color="color" elevation="24" >
            <div class="text-subtitle-1 pb-2">{{ title }}</div>

            <template v-slot:actions>
                <v-btn color="white" variant="text" @click="snackbar = false">Close</v-btn>
            </template>
        </v-snackbar>
    </v-container>
</template>
  
<script>
    import { useStore } from 'vuex'
	export default {
		data () {
			return {
                userAuth: null,
                snackbar: false,
                title: null,
                color: null,
				pagination: {},
				paginationData: null,
                items:[],
				headers: [
					{ title: 'Name', align: 'start', sortable: true, key: 'fullname' },
					{ title: 'E-mail', align: 'start', sortable: true, key: 'email' },
					{ title: 'Quotes starred', align: 'start', sortable: true, key: 'quotes' },
					{ title: 'Role', align: 'start', sortable: false, key: 'role', },
					{ title: 'Actions', align: 'start', sortable: false, key: 'actions', },
				],
			}
		},
		created() {
			this.getDataFromApi();
		},
		methods: {
            list() {
                return axios.get('/api/user/index',
                {
                    headers: {
                        'Authorization': `Bearer ${this.$store.getters.getToken}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                })
                .catch(err => {
                    console.log(err.response.data.message);
                });
            },
            async getDataFromApi () {
                this.userAuth = this.$store.getters.getUserId;
                const response = await this.list();
                // console.log( response );
                this.items = response.data.data;
            },
            blockUser(user_id) {
                axios.post(`/api/user/desactivate/${user_id}`, {}, {
					headers: {
						'Authorization': `Bearer ${this.$store.getters.getToken}`,
						'Content-Type': 'application/json',
						'Accept': 'application/json',
					}
				})
				.then(response => {
                    // console.log(response);
                    if (response.data.code === 200) {
                        this.getDataFromApi();
                        this.title = response.data.message;
                        this.color = 'teal-darken-4';
                    }else{
                        this.title = response.data.message;
                        this.color = 'red-darken-4';
                    }
                    this.snackbar = true;
				}).catch(err => {
                    this.title = err.message;
                    this.color = 'red-darken-4';
                    this.snackbar = true;
				});
            },
            activateUser(user_id) {
                axios.post(`/api/user/activate/${user_id}`, {}, {
					headers: {
						'Authorization': `Bearer ${this.$store.getters.getToken}`,
						'Content-Type': 'application/json',
						'Accept': 'application/json',
					}
				})
				.then(response => {
                    // console.log(response);
                    if (response.data.code === 200) {
                        this.getDataFromApi();
                        this.title = response.data.message;
                        this.color = 'teal-darken-4';
                    }else{
                        this.title = response.data.message;
                        this.color = 'red-darken-4';
                    }
                    this.snackbar = true;
				}).catch(err => {
                    this.title = err.message;
                    this.color = 'red-darken-4';
                    this.snackbar = true;
				});
            },
            showQuotes(user_id) {
                console.log('users: ' + Number(user_id), 'auth: ' + Number(this.userAuth));
                
                this.$router.push({
                    name: 'UserFavs',
                })
            }
		},
	}
</script>