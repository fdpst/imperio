<template>
    <v-container>
        <v-row>
            <v-col class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <v-card @click="selectCategorias()" class="mx-0 my-0 px-1 py-1">
                    <v-img class="align-end" height="110px" src="../../../../img/829.jpg" style="height: 180px;"></v-img>
                    <v-card-text class="pa-2 grey--text text--darken-2">
                        <div class="font-weight-light text-truncate">Categorias</div>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <v-card @click="selectBarcode()" class="mx-0 my-0 px-1 py-1">
                    <v-img class="align-end" height="110px" src="../../../../img/928.jpg" style="height: 180px;"></v-img>
                    <v-card-text class="pa-2 grey--text text--darken-2">
                        <div class="font-weight-light text-truncate">Codigo de Barras</div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {

        methods: {

            selectCategorias() {
                this.mostrarMenucategoria()
            },

            selectBarcode() {
                this.mostrarBarcode()
            },

            mostrarMenucategoria() {
                this.$emit('mostrar_menucategoria', true)
            },

            mostrarBarcode() {
                this.$emit('mostrar_barcode', true)
            }
        }
    }
</script>

