<template>
    <v-container class="py-6 px-4">
            <v-card
                flat
                rounded="lg"
            >
                <v-card-title>
                    <v-row>
                        <v-col>All users registered</v-col>
                        <v-spacer></v-spacer>
                        <v-col class="d-flex justify-end">
                            <v-btn
                                class="text-blue text-decoration-none"
                                size="large"
                                color="blue"
                                :to="{name : 'Dashboard' }"
                                variant="tonal"
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
                    ></v-data-table>
                </v-card-text>
            </v-card>
    </v-container>
</template>
  
<script>
	export default {
		data () {
			return {
				pagination: {},
				paginationData: null,
                items:[],
				headers: [
					{ title: 'Name', align: 'start', sortable: true, key: 'fullname' },
					{ title: 'E-mail', align: 'start', sortable: true, key: 'email' },
					{ title: 'Quotes starred', align: 'start', sortable: true, key: 'quotes' },
					{ title: 'Role', align: 'start', sortable: false, key: 'role', },
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
                const response = await this.list();
                // console.log( response );
                this.items = response.data.data;
                this.items.forEach( item => {
                    Object.assign( item, {
                        'actions': item.id,
                    })
                })
            },
		},
	}
</script>