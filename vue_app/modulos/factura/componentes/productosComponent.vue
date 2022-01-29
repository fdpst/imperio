<template>
    <v-card>
        <v-card-text class="mt-5 px-3 py-3">

            <v-row align="center">
                <v-col cols="12" md="3">
                    <v-text-field ref="search" v-model="producto_query.nombre_producto" label="Buscar"></v-text-field>
                </v-col>
                <v-col cols="12" md="1">
                    <v-text-field ref="cantidad" v-on:keyup.enter="agregarProducto" :disabled="current_items.length != 1" v-model="producto_query.cantidad_producto" label="Cantidad"></v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                    <v-btn @click="agregarProducto" :disabled="current_items.length != 1" color="primary" class="white--text">agregar</v-btn>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="10" class="pt-0">

                    <v-data-table @current-items="currentItems" :headers="headers" :search="producto_query.nombre_producto" disable-pagination hide-default-footer :items="filter_productos" item-key="id" class="elevation-1">
                        <template v-slot:item.action="{ item }">
                            <v-icon color="success" @click="setProductoName(item)" small class="mr-2">
                                mdi-check
                            </v-icon>
                        </template>
                    </v-data-table>

                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="10" class="pt-3">
                    <v-data-table :headers="items_headers" disable-pagination hide-default-footer :items="factura_items" item-key="id" class="elevation-1"></v-data-table>
                </v-col>
            </v-row>

        </v-card-text>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                producto_query: {
                    nombre_producto: '',
                    cantidad_producto: 1,
                },
                current_items: [],
                productos: [],
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
                        text: 'Precio',
                        value: 'precio'
                    },
                    {
                        text: '',
                        value: 'action'
                    }
                ],
                items_headers: [{
                        text: 'Descripción',
                        align: 'left',
                        value: 'nombre',
                    },
                    {
                        text: 'Precio Unit',
                        value: 'precio'
                    },
                    {
                        text: 'Cantidad',
                        value: 'cantidad'
                    },
                    {
                        text: 'Total.',
                        value: 'total'
                    },
                ],
                factura_items: []
            }
        },
        created() {
            this.getProductos()
        },
        methods: {
            getProductos() {
                axios.get(`api/getstocks`).then(res => {
                    this.productos = res.data
                }, res => {
                    this.$toast.error('Error consultando cliente')
                })
            },

            currentItems(n) {
                this.current_items = n
            },

            setProductoName(item) {
                this.producto_query.nombre_producto = item.nombre
                this.$nextTick(() => this.$refs.cantidad.focus())
            },

            agregarProducto() {
                this.current_items[0].cantidad = this.producto_query.cantidad_producto

                this.current_items[0].total = this.current_items[0].precio * this.producto_query.cantidad_producto

                this.factura_items.push(JSON.parse(JSON.stringify(this.current_items[0])))

                this.producto_query = {
                    nombre_producto: '',
                    cantidad_producto: 1,
                }

                this.$nextTick(() => this.$refs.search.focus())
            }
        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
            filter_productos: function() {
                if (!this.producto_query.nombre_producto) {
                    return []
                }
                return this.productos
                /*return this.productos.filter(x => {
                    return x.nombre.toLowerCase().includes(this.producto_query.nombre_producto.toLowerCase())
                })*/
            }
        }
    }
</script>