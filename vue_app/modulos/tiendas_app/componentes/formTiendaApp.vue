<template>
    <v-card class="mx-auto elevation-4">
        <v-container fluid class="mb-4">
            <v-row>
                <v-col cols="12" md="3">
                    <v-text-field v-model="tienda.nombre" label="Nombre" required></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-btn class="white--text" color="success" @click="saveTienda">guardar</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</template>

<script>
    export default {
        props: ['tienda'],

        methods: {
            saveTienda() {
                axios.post('api/savetienda', this.tienda).then(res => {
                    this.$emit('pushTienda', res.data)
                }, res => {
                    this.$toast.error('Algo ha salido mal')
                })
            },
        }
    }
</script>