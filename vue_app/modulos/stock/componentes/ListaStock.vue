<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Productos</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">        
            <div class="background my-container">
                <v-btn color="blue" dark class="mb-4" :to="{ path: `/crear-producto` }">nuevo</v-btn>
                <loader v-if="isloading"></loader>
                <v-data-table :headers="headers" :search="search" :items-per-page="15" :items="indexedItems" item-key="id" class="elevation-1">
                    <template v-slot:item.preciopvd="{item}">
                        {{item.preciopvd}} €
                    </template>
                    <template v-slot:item.cantidad="{item}">
                        <v-chip class="pa-2 mb-1" :color="getColor(item.cantidad)" dark > {{item.cantidad}} </v-chip>
                    </template>
                    <template v-slot:item.precio="{item}">
                        {{item.precio}} €
                    </template>
                    <template v-slot:item.action="{item}">
                        <!-- Ruta para editar producto -->
                        <router-link :to="{ path: `/editar-producto?id=${item.id}` }">
                            <v-icon small class="mr-2">mdi-pencil</v-icon>
                        </router-link>
                        <!-- END Ruta para editar producto -->
                        <v-icon small color="red" @click="deleteStock(item)">mdi-delete</v-icon>
                    </template>
                </v-data-table>
            </div>
        </v-sheet>
    </v-container>
</template>

<script>
    import formStock from './formStock.vue'
    export default {
        components: {
            formStock
        },
        data() {
            return {
                search: '',
                stock: {
                    cantidad: 0,
                    precio: 0
                },
                categorias: [],
                ivas: [],
                stocks: [],
                headers: [{
                        text: 'Nombre',
                        align: 'left',
                        value: 'nombre',
                    },
                    {
                        text: 'Código',
                        value: 'codigo',
                    },
                    {
                        text: 'PVD',
                        value: 'preciopvd'
                    },
                    {
                        text: 'PVP',
                        value: 'precio'
                    },
                    {
                        text: 'Stock',
                        value: 'cantidad'
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
            this.getStocks()
            this.getCategorias()
            this.getIvas()
        },
        methods: {
            getCategorias() {
                axios.get('api/getcategorias').then(res => {
                    this.categorias = res.data
                }, err => {
                    this.$toast.error('Error al obtener Datos CATEGORIAS')
                })
            },

            getIvas() {
                axios.get('api/getivas').then(res => {
                    this.ivas = res.data
                }, err => {
                    this.$toast.error('Error al obtener Datos IVA')
                })
            },

            getStocks() {
                axios.get('api/getstocks').then(res => {
                    this.stocks = res.data
                }, err => {
                    this.$toast.error('Error al obtener Datos STOCK')
                })
            },

            setStock(stock) {
                this.stock = stock
            },

            deleteStock(stock) {
                axios.get(`api/deletestock/${stock.id}`).then(res => {
                    this.stocks.splice(this.stocks.indexOf(stock), 1);
                }, res => {

                })
            },

            pushStock(data) {
                if (data.was_created) {
                    this.stocks.push(data.stock)
                }
                this.clearStock();
            },

            clearStock() {
                this.stock = {
                    id: null,
                    nombre: '',
                    codigo: '',
                    precio: '',
                    cantidad: 0
                }
            },
            
            getColor (cantidad) {
                if (cantidad <= 10) return 'red'
                else if (cantidad > 10 && cantidad <= 50 ) return 'orange'
                else return 'green'
            },
        },
        computed: {
        isloading: function() {
            return this.$store.getters.getloading
        },
        
        indexedItems() {
                return this.stocks.map((item, index) => ({
                    position: index,
                    ...item
                }))
            }
        }
    }
</script>