<template>
    <div class="container pa-4">
        <div class="row justify-content-center">
            <v-card
                flat
                max-width="100%"
                rounded="8px"
                >
                <v-card-title>
                    <v-row>
                        <v-col>Ramdom Quotes</v-col>
                        <v-spacer></v-spacer>
                        <v-col class="d-flex justify-end">
                            <v-btn variant="tonal" rounded="lg" @click="randomQuotes">
                                <v-icon icon="$reload" class="mr-4"/>
                                Reload
                            </v-btn>
                        </v-col>
                    </v-row>
                    
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-row>
                            <v-col v-for="quote in quotes" :key="quote.id" cols="4">
                                <v-card rounded="lg" height="270" class="pa-2">
                                    <v-card-title>
                                        <v-row>
                                            <v-col>Quote #{{ quote.id }}</v-col>
                                            <v-spacer></v-spacer>
                                            <v-col class="d-flex justify-end">
                                                <v-btn @click="toFav(quote.id)" size="small" color="red" variant="text" icon="$heart"></v-btn>
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
                    </v-container>
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>

<script>
    import { ref } from 'vue'
    
    export default {
        name: "DashboardPage",
        data() {
            return {
                quotes: [],
            };
        },
        created() {
            this.getQuote();
        },
        methods: {
            async getQuote() {
                let url = 'https://dummyjson.com/quotes/random';

                for (let index = 0; index < 5; index++) {
                    const response = await fetch(url);
                    if (response.ok) {
                        const fetchData = await response.json();
                        this.quotes[index] = fetchData;
                    }else{
                        alert("Error HTTP " + response.status);
                    }
                }
            },
            randomQuotes() {
                this.getQuote();
            },
            toFav(id) {
                let fd = {
                    user_id: this.$store.getters.getUserId,
                    quote_id: id
                };

                // console.log(fd);

                axios.post('/api/quotes/store', fd, {
					headers: {
						'Authorization': `Bearer ${this.$store.getters.getToken}`,
						'Content-Type': 'application/json',
						'Accept': 'application/json',
					}
				})
				.then(response => {
					console.log(response);
                    if (response.status == 200) {
                        alert("Quote starred.")
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