<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Facturas Recibidas</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">        
            <div class="background my-container">
                <v-btn color="blue" dark to="emitir-factura" class="mb-4">nuevo</v-btn>
                <loader v-if="isloading"></loader>
                <v-row>
                    <v-col cols="12">
                    </v-col>
                </v-row>
                <v-data-table :headers="headers" :items-per-page="10" :items="facturas" item-key="id" class="elevation-4">
                    <template v-slot:item.url="{ item }">
                        <a target="_blank" :href="`archivos/facturas_recibidas/${item.url}`">
                            <v-icon medium color="orange" class="mr-2">mdi-cloud-download</v-icon>
                        </a>
                    </template>
                    <template v-slot:item.action="{ item }">
                        <v-icon small color="red" @click="deleteFactura(item)">mdi-delete</v-icon>
                    </template>
                </v-data-table>
            </div>
        </v-sheet>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                facturas: [],
                headers: [{
                        text: 'Cliente',
                        align: 'left',
                        value: 'cliente',
                    },
                    {
                        text: 'Nro. Factura',
                        align: 'center',
                        value: 'numero_factura'
                    },
                    {
                        text: 'Total',
                        value: 'total'
                    },
                    {
                        text: 'Archivo',
                        value: 'url'
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
            this.getFacturas()
        },
        methods: {
            getFacturas() {
                axios.get('api/getfacturasemitidas').then(res => {
                    this.facturas = res.data
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },
            deleteFactura(factura) {
                axios.get(`api/deletefacturaemitida/${factura.id}`).then(res => {
                    this.$toast.sucs('Factura eliminada')
                    this.facturas.splice(this.facturas.indexOf(factura), 1)
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            }
        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
        }
    }
</script>