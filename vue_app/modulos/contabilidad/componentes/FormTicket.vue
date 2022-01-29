<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Crear factura</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">  
            <loader v-if="isloading"></loader>
            <v-card class="mx-auto">
                <!-- <v-toolbar flat color="light-blue lighten-2" dark>
                    <v-toolbar-title>Crear factura</v-toolbar-title>
                </v-toolbar> -->
                <v-container fluid>
                    <v-row align="center">
                        <v-col cols="12" md="2">
                            <v-text-field disabled label="CIF" v-model="cliente.dni"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="3">
                            <v-text-field disabled label="Nombre" v-model="cliente.nombre"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="5">
                            <v-text-field disabled label="Direccion" v-model="cliente.direccion"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="1">
                            <v-btn small color="warning" @click="dialog = true">
                                <v-icon>mdi-account-circle</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>

            </v-card>
            <v-card class="mx-auto mt-8">
                <v-container fluid>
                    <v-data-table :headers="headers" disable-pagination hide-default-footer :items="tickets" item-key="id">
                        <template v-slot:item.descripcion="{ item }">
                            <span v-bind:class="{ new: !item.id }">{{item.descripcion}}</span>
                        </template>
                        <template v-slot:item.cantidad="{ item }">
                            <v-text-field type="number" step="1" v-model="item.cantidad"></v-text-field>
                        </template>
                        <template v-slot:item.action="{ item }">
                            <v-checkbox v-model="selected" label="" :value="item.id"></v-checkbox>
                        </template>
                    </v-data-table>
                </v-container>
            </v-card>
            <br>
            <v-btn @click="crearFactura" class="white--text" color="success">guardar</v-btn>
            <v-btn v-if="nombre_archivo" :disabled="isloading" target="_blank" :href="`archivos/facturas/${nombre_archivo}`" class="white--text" color="warning">
                Imprimir
            </v-btn>
            <cliente-component @seleccionar_cliente="seleccionarCliente" @close_dialog="dialog = false" :dialog="dialog"></cliente-component>
        </v-sheet>
    </v-container>
</template>

<script>
    import clienteComponent from '../../factura/componentes/clienteComponent'

    export default {
        components: {
            clienteComponent
        },
        data() {
            return {
                dialog: false,
                nombre_archivo: null,
                cliente: {
                    id: null,
                },
                tickets: [],
                selected: [],
                headers: [{
                        text: 'Nro Ticket',
                        align: 'left',
                        value: 'nro_t',
                    },
                    {
                        text: 'Total (EUR)',
                        value: 'total',
                    },
                    {
                        text: 'Fecha',
                        value: 'created_at',
                    },
                    {
                        text: '',
                        value: 'action',
                        sortable: false
                    },
                ],
            }
        },

        watch: {
            'cliente.id'(n) {
                this.getTicketsFromCiente(n);
            }
        },

        created() {

        },

        methods: {
            crearFactura() {
                axios.post(`api/createfacturafromtickets`, this.selected).then(res => {
                    this.nombre_archivo = res.data
                }, res => {
                    this.$toast.error('Error generando factura')
                })
            },
            getTicketsFromCiente(cliente_id) {
                axios.get(`api/getticketsfromcliente/${cliente_id}`).then(res => {
                    this.tickets = res.data
                }, res => {
                    this.$toast.error('Error consultando tickets')
                })
            },
            seleccionarCliente(cliente) {
                this.cliente = cliente
                this.dialog = false
            },
        },

        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
        }
    }
</script>