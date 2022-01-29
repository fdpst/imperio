<template>
    <div class="">

        <v-row align="center">

            <v-col cols="12" md="4">
                <v-autocomplete v-model="stock_selected" return-object :items="filter_stocks" item-text="nombre" item-value="id" label="Productos"></v-autocomplete>
            </v-col>

            <v-col cols="12" md="2">
                <v-text-field v-model="stock_selected.qty" label="Cantidad"></v-text-field>
            </v-col>

            <v-col cols="12" md="3">
                <v-btn @click="addToEvent" class="white--text" color="success">agregar</v-btn>
            </v-col>

        </v-row>

        <v-row>
            <v-col cols="12">
                <v-data-table :headers="headers" disable-pagination hide-default-footer :items="event_stock" item-key="id" class="elevation-1">
                    <template v-slot:item.cantidad="{ item }">
                        <v-text-field v-model="item.cantidad"></v-text-field>
                    </template>
                    <template v-slot:item.action="{ item }">
                        <v-icon small color="red" @click="deleteStock(item)">
                            mdi-delete
                        </v-icon>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>

    </div>

</template>

<script>
    export default {
        props: ['evento'],

        data() {
            return {
                stock_selected: {
                    qty: 0,
                },

                event_stock: [],

                headers: [{
                        text: 'Nombre',
                        align: 'left',
                        value: 'stock.nombre',
                        sortable: false
                    },
                    {
                        text: 'Cantidad',
                        value: 'cantidad',
                        width: '20%',
                        sortable: false
                    },
                    {
                        text: 'Acciones',
                        value: 'action',
                        sortable: false
                    },
                ]
            }
        },

        watch: {
            'evento': {
                immediate: true,
                handler(n) {
                    if (n.event_stock) {
                        this.event_stock = n.event_stock
                    } else {
                        this.event_stock = []
                    }
                }
            }
        },

        methods: {
            addToEvent() {
                if (!this.stock_selected.id) {
                    return null
                }

                this.event_stock.push({
                    stock_id: this.stock_selected.id,
                    stock: {
                        nombre: this.stock_selected.nombre
                    },
                    cantidad: this.stock_selected.qty
                })

                this.stock_selected = {
                    qty: 0,
                }
            },
        },

        computed: {
            filter_stocks: function() {
                return this.stock.filter(element => {
                    return !this.event_stock.some(x => x.stock_id == element.id)
                })
            }

        }
    }
</script>