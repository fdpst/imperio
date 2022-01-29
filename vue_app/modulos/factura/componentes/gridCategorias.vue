<template>
    <v-container>
        <v-row>
            <v-col class="pa-0 ma-0">
                <v-btn @click="unselectMenu" color="light-blue" class="ma-3 pa.3 float-left white--text">menu principal</v-btn>
            </v-col>
        </v-row>

        <v-row color="grey lighten-4">
            <v-col v-for="categoria in categorias" :key="categoria.id" class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                <v-card @click="selectCategoria(categoria)" class="ml-1 mr-0 my-0 px-1 py-1">
                    <v-img class="align-end" :src="categoria.imagen_url" height="110px" style="height: 180px;"></v-img>
                    <v-card-text class="pa-2 grey--text text--darken-2">
                        <div class="font-weight-light text-truncate">{{categoria.nombre}}</div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {

        props: ['categorias'],

        methods: {
            selectCategoria(categoria) {
                this.$emit('categoria_selected', categoria)
            },

            unselectMenu() {
                this.$emit('unselect_menu')
            }
        },
    }
</script>