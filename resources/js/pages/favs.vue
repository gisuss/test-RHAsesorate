<template>
    <v-container class="py-6 px-4">
        <v-card
            flat
            rounded="lg"
            class="pa-4"
        >
            <v-card-title class="mb-4">
                <v-row>
                    <v-col>Favorites Quotes</v-col>
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
                    <v-col v-for="quote in quotes" :key="quote.id" cols="12" sm="6" md="4">
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
    </v-container>
</template>

<script>
    import { ref } from 'vue'

    export default {
        name: "FavsPage",
        data() {
            return {
                quotes: [],
                quotesAPI: [],
            };
        },
        created() {
            this.getDataFromApi(this.$store.getters.getUserId);
        },
        methods: {
            getDataFromApi(id) {
                axios.get(`/api/quotes/favs/${id}`, {
					headers: {
						'Authorization': `Bearer ${this.$store.getters.getToken}`,
						'Content-Type': 'application/json',
						'Accept': 'application/json',
					}
				})
				.then(response => {
					// console.log(response);
                    if (response.status == 200) {
                        let index = 0;
                        this.quotesAPI = response.data.data.quotes;
                        this.quotesAPI.forEach(element => {
                            // console.log(element[0]);
                            this.getQuote(element[0],index);
                            index++;
                        });
                    }
				}).catch(err => {
                    errors.value = err.response.data.message
				});
            },
            async getQuote(id, index) {
                let url = `https://dummyjson.com/quotes/${id}`;

                const response = await fetch(url);
                if (response.ok) {
                    const fetchData = await response.json();
                    this.quotes[index] = fetchData;
                }else{
                    alert("Error HTTP " + response.status);
                }
            },
            toTrash(id) {
                axios.post(`/api/quotes/delete/${id}`, {}, {
					headers: {
						'Authorization': `Bearer ${this.$store.getters.getToken}`,
						'Content-Type': 'application/json',
						'Accept': 'application/json',
					}
				})
				.then(response => {
					// console.log(response);
                    if (response.status == 200) {
                        this.getDataFromApi(this.$store.getters.getUserId);
                        alert("Quote deleted.");
                    }
				}).catch(err => {
                    errors.value = err.response.data.message
				});
            },
        },
        setup() {
            let errors = ref([]);

            return{
                errors
            }
        }
    };
</script>

<style scoped>
.scroll-quote::-webkit-scrollbar {
    width: 8px;     /* Tamaño del scroll en vertical */
    height: 8px;    /* Tamaño del scroll en horizontal */
    display: none;  /* Ocultar scroll */
    overflow-y: scroll;
}
</style>
