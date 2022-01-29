<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Lista Ingresos</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">        
            <div class="background my-container">
                <loader v-if="isloading"></loader>
                <v-data-table :headers="headers" :items-per-page="10" :items="ingresos" item-key="id" class="elevation-4">
                    <template v-slot:item.total="{ item }">
                        {{item.total | currency }}
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
                ingresos: [],
                headers: [{
                        text: 'Código',
                        align: 'left',
                        value: 'codigo',
                    },
                    {
                        text: 'Concepto',
                        value: 'concepto'
                    },
                    {
                        text: 'Total',
                        value: 'total'
                    }
                ],
            }
        },
        mounted() {
            this.getIngresos()
        },
        methods: {
            getIngresos() {
                axios.get('api/getingresos').then(res => {
                    this.ingresos = res.data
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },
            /*deleteFactura(factura) {
                axios.get(`api/deletefacturaemitida/${factura.id}`).then(res => {
                    this.$toast.sucs('Factura eliminada')
                    this.facturas.splice(this.facturas.indexOf(factura), 1)
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            }*/
        },
        filters: {
            currency(val) {
                return `${val} €`
            },
        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
        }
    }
</script>