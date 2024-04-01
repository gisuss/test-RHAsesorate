<template>
    <v-container class="py-6 px-4">
        <v-card
            flat
            rounded="lg"
            class="pa-4"
        >
            <v-card-title class="mb-4">
                <v-row>
                    <v-col>User Favorites Quotes</v-col>
                    <v-spacer></v-spacer>
                    <v-col class="d-flex justify-end">
                        <v-btn
                            class="text-blue text-decoration-none"
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
                <v-row>
                    <v-col v-for="quote in quotes" :key="quote.id" cols="12" sm="12" md="6" lg="4" xl="2">
                        <v-card rounded="lg" hover min-width="200px" height="270" variant="tonal" class="pa-2">
                            <v-card-title>
                                <v-row>
                                    <v-col>Quote #{{ quote.id }}</v-col>
                                    <v-spacer></v-spacer>
                                    <v-col class="d-flex justify-end">
                                        <v-btn @click="toTrash(quote.id)" size="small" color="red" variant="text" icon="$trash"></v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-title>
                            <v-card-text class="scroll-quote">
                                <h2>{{ quote.author }}</h2>
                                <p>{{ quote.quote }}</p>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
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
    import { useRoute } from 'vue-router';
    export default {
        data() {
            return {
                quotes: [],
                quotesAPI: [],
                snackbar: false,
                title: null,
                color: null,
                user_id: null
            };
        },
        created() {
            const route = useRoute();
            this.user_id = Number(route.params.id);
            this.getDataFromApi(this.user_id);
        },
        methods: {
            getDataFromApi(id) {
                axios.get(`/api/quotes/fav/${id}`, {
					headers: {
						'Authorization': `Bearer ${this.$store.getters.getToken}`,
						'Content-Type': 'application/json',
						'Accept': 'application/json',
					}
				})
				.then(response => {
					// console.log(response);
                    if (response.data.success) {
                        this.quotes = response.data.data;
                    }else{
                        this.title = response.data.data.message;
                        this.color = 'red-darken-4';
                        this.snackbar = true;
                    }
				}).catch(err => {
                    this.title = err.message;
                    this.color = 'red-darken-4';
                    this.snackbar = true;
				});
            },
            toTrash(id) {
                let fd = {
                    user_id: this.user_id,
                    quote_id: id
                };

                axios.post(`/api/quotes/to-trash`, fd, {
					headers: {
						'Authorization': `Bearer ${this.$store.getters.getToken}`,
						'Content-Type': 'application/json',
						'Accept': 'application/json',
					}
				})
				.then(response => {
                    if (response.data.success) {
                        this.getDataFromApi(this.user_id);
                        this.title = response.data.message;
                        this.color = 'teal-darken-4';
                        this.snackbar = true;
                    }else{
                        this.title = response.data.message;
                        this.color = 'red-darken-4';
                        this.snackbar = true;
                    }
				}).catch(err => {
                    this.title = err.message;
                    this.color = 'red-darken-4';
                    this.snackbar = true;
				});
            },
        },
    };
</script>

<style scoped>
</style>
