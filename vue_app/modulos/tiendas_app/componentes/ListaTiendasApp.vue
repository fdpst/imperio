<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Tiendas</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">        
            <div class="background my-container">
                <loader v-if="isloading"></loader>
                <form-tienda-app :tienda="tienda" v-on:clearTienda="clearTienda" v-on:pushTienda="pushTienda">
                </form-tienda-app>
                <v-data-table :headers="headers" :search="search" :items-per-page="10" :items="tiendas" item-key="id" class="elevation-4">
                    <template v-slot:item.action="{ item }">
                        <v-icon small color="blue" @click="setTienda(item)" class="mr-2">mdi-pencil</v-icon>
                        <v-icon small color="red" @click="deleteTienda(item)">mdi-delete</v-icon>
                    </template>
                </v-data-table>
            </div>
        </v-sheet>
    </v-container>
</template>

<script>
    import formTiendaApp from './formTiendaApp.vue'
    export default {
        components: {
            formTiendaApp
        },

        data() {
            return {
                search: '',

                tienda: {
                    id: null,
                    nombre: ''
                },

                tiendas: [],

                headers: [{
                        text: 'Nombre',
                        align: 'left',
                        value: 'nombre',
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
            this.getTiendas()
        },
        methods: {
            getTiendas() {
                axios.get('api/gettiendas').then(res => {
                    this.tiendas = res.data
                }, err => {
                    this.$toast.error('Algo ha salido mal')
                })
            },

            setTienda(tienda) {
                this.tienda = tienda
            },

            deleteTienda(tienda) {
                axios.get(`api/deletetienda/${tienda.id}`).then(res => {
                    this.tiendas.splice(this.tiendas.indexOf(tienda), 1);
                }, res => {

                })
            },

            pushTienda(data) {
                if (data.was_created) {
                    this.tiendas.push(data.tienda)
                }
                this.clearTienda();
            },

            clearTienda() {
                this.tienda = {
                    id: null,
                    nombre: '',
                }
            }
        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
        }
    }
</script>