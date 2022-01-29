<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Listado Tickets</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">        
            <div class="background my-container">
                <loader v-if="isloading"></loader>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field v-model="search" label="Busqueda"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-text-field prefix="€" disabled v-model="total" label="Total"></v-text-field>
                    </v-col>
                </v-row>
                <v-data-table :headers="headers" :search="search" :items-per-page="20" :items="facturas" item-key="id" class="elevation-4">
                    <template v-slot:item.iva="{ item }">
                        {{ item.iva | fixed_n }}
                    </template>
                    <template v-slot:item.url="{ item }">
                        <a target="_blank" :href="`archivos/tickets/${item.url_ticket}`">
                            <v-icon medium color="orange" class="mr-2">mdi-cloud-download</v-icon>
                        </a>
                    </template>
                    <template v-slot:item.cliente="{ item }">
                        <span v-if="item.cliente">{{item.cliente.nombre}}</span>
                        <span v-else>N/A</span>
                    </template>
                    <template v-slot:item.generar_factura="{ item }">
                        <template v-if="item.cliente">
                            <v-icon v-if="!item.nro_factura" @click="generarFactura(item)" medium color="success" class="mr-2">
                                mdi-clipboard-arrow-up-outline
                            </v-icon>
                            <a v-else target="_blank" :href="`archivos/facturas/${item.url_factura}`">
                                <v-icon medium color="success" class="mr-2">mdi-cloud-download</v-icon>
                            </a>
                        </template>
                        <template v-if="item.cliente == null">
                            <v-icon medium color="primary" @click="selectCliente(item)" class="mr-2">
                                mdi-account-circle
                            </v-icon>
                        </template>
                    </template>
                    <template v-slot:item.action="{ item }">
                        <v-icon @click="deleteTicket(item)" medium color="red" class="mr-2">
                            mdi-delete
                        </v-icon>
                    </template>
                </v-data-table>
                <cliente-component @seleccionar_cliente="seleccionarCliente" @close_dialog="dialog = false" :dialog="dialog"></cliente-component>
            </div>
        </v-sheet>
    </v-container>
</template>

</template>

<script>
    import clienteComponent from '../../factura/componentes/clienteComponent'

    export default {
        components: {
            clienteComponent,
        },

        data() {
            return {
                dialog: false,
                search: '',
                facturas: [],
                factura: {
                    cliente: {
                        id: null
                    },
                },
                headers: [{
                        text: 'Nro Ticket',
                        align: 'left',
                        value: 'nro_t',
                    },
                    {
                        text: 'Fecha',
                        value: 'created_at'
                    },
                    {
                        text: 'IVA',
                        value: 'iva'
                    },
                    {
                        text: 'Precio',
                        value: 'total'
                    },
                    {
                        text: 'Cliente',
                        value: 'cliente',
                    },
                    {
                        text: 'Ticket',
                        value: 'url'
                    },
                    {
                        text: 'Crear factura',
                        value: 'generar_factura'
                    },
                    {
                        text: '',
                        value: 'action'
                    },
                ],
            }
        },

        mounted() {
            this.getFacturas()
        },

        methods: {
            getFacturas() {
                axios.get('api/gettickets').then(res => {
                    this.facturas = res.data
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },

            generarFactura(item) {
                axios.post(`api/generar-factura/${item.nro_ticket.id}/${this.factura.cliente.id}`).then(res => {
                    let found_index = this.facturas.findIndex(x => x.id == item.id);
                    this.$set(this.facturas, found_index, res.data.ticket)
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },

            deleteTicket(factura) {
                axios.get(`api/deleteticket/${factura.id}`).then(res => {
                    this.$toast.sucs('Factura eliminada')
                    this.facturas.splice(this.facturas.indexOf(factura), 1)
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },

            selectCliente(item) {
                this.dialog = true
                this.factura = item
            },

            seleccionarCliente(data) {
                this.dialog = false
                this.factura.cliente = data
            }
        },

        filters: {
            fixed_n(val) {
                return parseFloat(val).toFixed(2)
            }
        },

        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },

            total: function() {
                return this.facturas.reduce((acc, x) => {
                    return acc + parseFloat(x.total)
                }, 0)
            }
        }
    }
</script>