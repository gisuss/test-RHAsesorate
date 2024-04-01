<template>
    <v-container class="py-6 px-4">
        <v-card
            flat
            rounded="lg"
            class="pa-4"
        >
            <v-card-title>Dashboard</v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col>
                            <v-text-field
                                v-model="limit"
                                dense flat
                                type="number"
                                min="1"
                                label="Quantity"
                                variant="outlined"
                                @change="getQuote"></v-text-field>
                        </v-col>
                        <v-col class="d-flex justify-end align-center">
                            <v-btn 
                                class="text-blue text-decoration-none"
                                color="blue"
                                variant="tonal"
                                rounded="lg"
                                :disabled="disabledBtn"
                                prepend-icon="$reload"
                                @click="randomQuotes(2000, 'disabledBtn')"
                            >Reload</v-btn>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col v-for="quote in quotes" :key="quote.id" cols="12" sm="12" md="6" lg="4" xl="2">
                            <v-card rounded="lg" hover min-width="150px" height="270" variant="tonal" class="pa-2">
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
                                    <h3>{{ quote.author }}</h3>
                                    <p>{{ quote.quote }}</p>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
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
    import { ref } from 'vue'
    import { useStore } from 'vuex';
    
    export default {
        name: "DashboardPage",
        data() {
            return {
                quotes: [],
                snackbar: false,
                disabledBtn: false,
                limit: ref(this.$store.getters.getQuantity),
                title: null,
                color: null,
            };
        },
        created() {
            this.getQuote();
        },
        methods: {
            async getQuote() {
                this.$store.dispatch('setQuantity', this.limit);
                axios.get(`api/quotes/random/${this.limit}`, {
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
                    }
				}).catch(err => {
                    this.title = err.message;
                    this.color = 'red-darken-4';
                    this.snackbar = true;
				});
            },
            randomQuotes(timeOutBtn, btn) {
                this[btn] = true;

                this.getQuote();

                setTimeout(() => this[btn] = false, timeOutBtn);
            },
            toFav(id) {
                let fd = {
                    user_id: this.$store.getters.getUserId,
                    quote_id: id
                };

                axios.post('/api/quotes/to-fav', fd, {
					headers: {
						'Authorization': `Bearer ${this.$store.getters.getToken}`,
						'Content-Type': 'application/json',
						'Accept': 'application/json',
					}
				})
				.then(response => {
					// console.log(response);
                    if (response.data.success) {
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
        },
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
