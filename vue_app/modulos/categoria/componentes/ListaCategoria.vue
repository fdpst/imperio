<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Categorias</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">        
            <div class="background my-container">
                <loader v-if="isloading"></loader>
                <form-categoria :categoria="categoria" v-on:clearCategoria="clearCategoria" v-on:pushCategoria="pushCategoria"></form-categoria>
                <v-data-table :headers="headers" :search="search" :items-per-page="10" :items="categorias" item-key="id" class="elevation-4">
                    <template v-slot:item.action="{ item }">
                        <v-icon small @click="setCategoria(item)" class="mr-2">mdi-pencil</v-icon>
                        <v-icon small color="red" @click="deleteStock(item)">mdi-delete</v-icon>
                    </template>
                </v-data-table>
            </div>
        </v-sheet>
    </v-container>
</template>
<script>
    import formCategoria from './formCategoria.vue'

    export default {
        components: {
            formCategoria
        },
        data() {
            return {
                search: '',
                categoria: {
                    nombre: '',
                    orden: 1,
                    imagen_url: null
                },
                categorias: [],
                headers: [{
                        text: 'Nombre',
                        align: 'left',
                        value: 'nombre',
                    },
                    {
                        text: '% Categoria',
                        value: 'cat_profit'
                    },
                    {
                        text: 'Orden',
                        value: 'orden'
                    },
                    {
                        text: 'Acciones',
                        value: 'action',
                        sortable: false
                    },
                ],
            }
        },
        mounted() {
            this.getCategorias()
        },
        methods: {
            getCategorias() {
                axios.get('api/getcategorias').then(res => {
                    this.categorias = res.data
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },

            setCategoria(categoria) {
                this.categoria = categoria
            },

            deleteStock(stock) {
                /*  axios.get(`api/deletestock/${stock.id}`).then(res => {
                      this.stocks.splice(this.stocks.indexOf(stock), 1);
                  }, res => {

                  })*/
            },

            pushCategoria(data) {
                if (data.was_created) {
                    this.categorias.push(data.categoria)
                }
                this.clearCategoria();
            },

            clearCategoria() {
                this.categoria = {
                    id: null,
                    nombre: '',
                    orden: 1,
                    imagen_url: null
                }
            },
        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
        }
    }
</script>