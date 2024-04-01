<template>
    <v-container class="py-6 px-4">
        <v-row align="center">
            <v-card
                flat
                width="100%"
                rounded="lg"
            >
                <v-card-title style="line-height: normal; text-wrap: pretty;" class="text-h4 text-md-3 text-lg-h2 text-center">Welcome to my RH Asesorate Test👋🏽</v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-row>
                            <v-col>
                                <p class="mb-4 text-h6 text-md-h5 text-lg-h4 text-center">Jesus Armando Romero Hernandez🇻🇪</p>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col class="d-flex justify-center">
                                <v-btn variant="tonal" elevation="20" @click="downloadFile"><v-icon icon="$download" class="mr-4" />Download CV</v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        setup() {
            function downloadFile() {
                axios.get('/api/download/CV-Gisuss-SPA-ENG_02-24.pdf', {
                    responseType: 'blob',
                }).then((response) => {
                    const file = new File([response.data], 'CV-Gisuss-SPA-ENG_02-24.pdf');
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(file);
                    link.download = 'CV-Gisuss-SPA-ENG_02-24.pdf';
                    link.click();
                });
            };

            return {
                downloadFile
            }
        }
    }
</script>

<style scoped>

</style>
