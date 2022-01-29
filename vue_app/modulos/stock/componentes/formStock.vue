<template>
    <v-card class="mx-auto">

        <v-toolbar flat color="light-blue lighten-2" dark>
            <v-toolbar-title>Guardar / Editar | Lista Stock</v-toolbar-title>
        </v-toolbar>

        <v-container fluid>

            <v-row>

                <v-col cols="12" md="4">
                    <v-text-field v-model="stock.nombre" label="Nombre" required></v-text-field>
                </v-col>

                <v-col cols="12" md="2">
                    <v-text-field v-model="stock.codigo" label="Código" required></v-text-field>
                </v-col>

                <v-col cols="12" md="2">
                    <v-text-field v-model="stock.precio" label="Precio por unidad / kg" required></v-text-field>
                </v-col>

                <v-col cols="12" md="2">
                    <v-text-field :disabled="stock.id != null" type="number" step="2" v-model="stock.cantidad" label="Cantidad" required></v-text-field>
                </v-col>

                <v-col cols="12" md="4">
                    <file-component @file_has_changed="fileHasChanged"></file-component>
                </v-col>

                <v-col cols="12" md="2">
                    <v-select label="categoria" :items="categorias" v-model="stock.categoria_id" item-value="id" item-text="nombre"></v-select>
                </v-col>
                <v-col cols="12" md="1">
                    <v-select label="IVA" :items="ivas" v-model="stock.iva_id" item-value="id" item-text="iva"></v-select>
                </v-col>

            </v-row>

            <v-row>
                <v-col cols="12">
                    <v-btn class="white--text" color="success" @click="saveStock">guardar</v-btn>
                    <v-btn color="orange" class="white--text" to="guardar-albaran">añadir albaran</v-btn>
                </v-col>
            </v-row>

        </v-container>
    </v-card>
</template>

<script>
    export default {
        props: ['stock', 'categorias', 'ivas'],

        methods: {
            saveStock() {
                console.log(this.stock);
                axios.post('api/savestock', this.stock).then(res => {
                    this.$emit('pushStock', res.data)
                }, res => {

                })
            },

            clearStock() {
                this.$emit('clearStock')
            },

            fileHasChanged(base_image) {
                this.stock.imagen_url = base_image
            }
        },
    }
</script>