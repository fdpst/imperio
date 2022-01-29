<template>
    <v-container>

        <loader v-if="isloading"></loader>

        <v-card class="mx-auto">

            <v-toolbar color="grey darken-4" dark>
                <v-toolbar-title>Nuevo Albaran</v-toolbar-title>
            </v-toolbar>

            <v-container fluid>

                <v-row>
                    <v-col cols="12" md="3">
                        <v-text-field v-model="recibo.numero_recibo" label="Nro. Albaran" required></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-text-field v-model="recibo.proveedor" label="Proveedor" required></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">

                        <v-menu v-model="menu2" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px">
                            <template v-slot:activator="{ on }">
                                <v-text-field v-model="recibo.fecha" label="fecha" readonly v-on="on"></v-text-field>
                            </template>
                            <v-date-picker v-model="recibo.fecha" @input="menu2 = false" style="height:450px;"></v-date-picker>
                        </v-menu>

                    </v-col>
                    <v-col cols="12" md="2">
                        <v-text-field disabled prefix="€" v-model="total" label="Monto" required></v-text-field>
                    </v-col>
                </v-row>

            </v-container>
        </v-card>

        <v-row>

            <v-col cols=12>
                <v-row align-center>
                    <v-col cols="12" md="3">
                        <v-autocomplete v-model="stock_selected" @change="selectChange" return-object :items="filter_stocks" item-text="nombre" item-value="id" label="Productos"></v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-text-field type="number" step="2" v-model="stock_recibo.cantidad" label="Cantidad"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-text-field type="number" step="2" v-model="stock_recibo.precio" prefix="€" label="Precio"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-btn style="margin-top: 13px;" @click="addStockRecibo" color="light-blue" class="white--text">añadir</v-btn>
                    </v-col>
                </v-row>
            </v-col>

            <v-col cols="12">
                <v-data-table :headers="headers" disable-pagination hide-default-footer :items="recibo.recibo_stock" item-key="id" class="elevation-1">

                    <template v-slot:item.action="{ item }">
                        <v-icon small color="red" @click="deleteStock(item)">
                            mdi-delete
                        </v-icon>
                    </template>

                </v-data-table>
            </v-col>

            <v-col cols="12">
                <v-btn @click="saveRecibo" color="light-blue" class="white--text">guardar</v-btn>
            </v-col>

        </v-row>

    </v-container>
</template>

<script>
    import {
        stock_mixin
    } from '../../../mixins/stock_mixin'
    export default {
        mixins: [stock_mixin],
        data() {
            return {
                menu2: false,
                stock_selected: null,
                stocks_ids: [],
                recibo: {
                    id: null,
                    numero_recibo: '',
                    proveedor: '',
                    detalle: '',
                    fecha: new Date().toISOString().substr(0, 10),
                    monto: this.total,
                    recibo_stock: []
                },
                stock_recibo: {
                    stock: {
                        id: '',
                        nombre: '',
                        codigo: '',
                    },
                    cantidad: 0,
                    precio: 0
                },
                headers: [{
                        text: 'Nombre',
                        align: 'left',
                        value: 'stock.nombre',
                    },
                    {
                        text: 'Código',
                        value: 'stock.codigo',
                    },
                    {
                        text: 'Cantidad',
                        value: 'cantidad',
                        width: '20%'
                    },
                    {
                        text: 'Precio',
                        value: 'precio',
                    },
                    {
                        text: 'Acciones',
                        value: 'action',
                        sortable: false
                    },
                ],
            }
        },
        watch: {
            'recibo.recibo_stock'(n) {
                this.stocks_ids = n.map(x => x.stock.id)
            }
        },
        created() {
            if (this.$route.query.id) {
                this.getRecibo(this.$route.query.id)
            }
        },
        methods: {
            getRecibo(recibo_id) {
                axios.get(`api/getrecibo/${recibo_id}`).then(res => {
                    this.recibo = res.data
                }, res => {
                    this.$toast.error('error consultando albaran')
                })
            },
            saveRecibo() {
                this.recibo.monto = this.total
                axios.post('api/saverecibo', this.recibo).then(res => {
                    this.$toast.sucs('albaran guardado')
                    this.$router.push('lista-albaranes')
                }, res => {
                    this.$toast.error('error guardando albaran')
                })
            },
            deleteFromDatabase(item) {
                axios.post(`api/deleterecibostock`, item).then(res => {
                    console.log(res.data)
                    this.splitFrom(this.stocks_ids, item.stock_id)
                    this.splitFrom(this.recibo.recibo_stock, item)
                    this.$toast.sucs('producto eliminado')
                }, res => {
                    this.$toast.error('error eliminando producto')
                })
            },
            selectChange(item) {
                this.stock_recibo = {
                    stock: {
                        id: item.id,
                        nombre: item.nombre,
                        codigo: item.codigo,
                    },
                    cantidad: 0
                }

                /*this.stocks_ids.push(item.id)
                this.recibo.recibo_stock.push(stock_recibo)*/
            },
            addStockRecibo() {
                this.stocks_ids.push(this.stock_recibo.stock.id)
                this.recibo.recibo_stock.push(this.stock_recibo)
                this.resetObject()
            },
            resetObject() {
                this.stock_recibo = {
                    stock: {
                        id: '',
                        nombre: '',
                        codigo: '',
                    },
                    cantidad: 0
                }
            },
            deleteStock(item) {
                if (item.id) {
                    return this.deleteFromDatabase(item)
                }
                this.splitFrom(this.stocks_ids, item.id)
                this.splitFrom(this.recibo.recibo_stock, item)
                this.stock_selected = null
            },
            splitFrom(lista, item) {
                lista.splice(lista.indexOf(item), 1)
            }
        },
        computed: {
            isloading() {
                return this.$store.getters.getloading
            },
            filter_stocks: function() {
                return this.stocks.filter(element => {
                    return !this.stocks_ids.includes(element.id)
                })
            },
            total: function() {
                return this.recibo.recibo_stock.reduce((acc, element) => {
                    return Number.parseFloat(acc) + Number.parseFloat(element.precio)
                }, 0)
            }
        }
    }
</script>