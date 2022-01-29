<template>
    <v-card class="mx-auto elevation-4">
        <v-container fluid class="mb-4">
            <v-row>
                <v-col cols="12" md="4">
                    <v-text-field v-model="categoria.nombre" label="Nombre" required></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                    <v-text-field v-model="categoria.cat_profit" label="% Categoria" required></v-text-field>
                </v-col>                
                <v-col cols="12" md="1">
                    <v-text-field v-model="categoria.orden" label="Orden" required></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <file-component @file_has_changed="fileHasChanged"></file-component>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-btn class="white--text" color="success" @click="saveCategoria">guardar</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</template>

<script>
    export default {
        props: ['categoria'],

        data() {
            return {

            }
        },

        methods: {
            saveCategoria() {
                axios.post('api/savecategoria', this.categoria).then(res => {
                    this.$emit('pushCategoria', res.data)
                }, res => {

                })
            },

            clearCategoria() {
                this.$emit('clearCategoria')
            },

            fileHasChanged(base_image) {
                this.categoria.imagen_url = base_image
            }
        },
    }
</script>