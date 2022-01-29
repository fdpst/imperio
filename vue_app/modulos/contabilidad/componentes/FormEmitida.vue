<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Crear Factura</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">        
            <div class="background my-container">
                <loader v-if="isloading"></loader>
                <v-row>
                    <v-col cols="12" md="10">
                        <!-- <v-btn :to="{path: 'lista-facturas-emitidas'}" class="mb-4 white--text" color="blue">
                            <v-icon left>mdi-arrow-left</v-icon> volver
                        </v-btn> -->
                        <v-card class="mx-auto">
                            <v-container fluid>
                                <v-row>
                                    <v-col cols="12" md="4">
                                        <v-text-field v-model="factura.cliente" label="Cliente"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="3">
                                        <v-text-field v-model="factura.numero_factura" label="Nro. factura"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="2">
                                        <v-text-field prefix="€" v-model="factura.total" label="Total"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row dense>
                                    <v-col cols="12" md="4">
                                        <file-component @file_has_changed="fileHasChanged"></file-component>
                                    </v-col>
                                    <v-col cols="12" md="12">
                                        <v-btn @click="crearFactura" class="white--text" color="blue">guardar</v-btn>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>
                    </v-col>
                </v-row>
            </div>
        </v-sheet>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                factura: {
                    cliente: null,
                    numero_factura: null,
                    total: 0,
                    url: null,
                }
            }
        },

        methods: {
            crearFactura() {
                axios.post('api/createfactura', this.factura).then(res => {
                    this.$router.push('/lista-facturas-emitidas')
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },

            fileHasChanged(base_image) {
                this.factura.url = base_image
            }
        },
        filters: {
            desc(val) {
                return `${val} %`
            },
            currency(val) {
                return `${val} €`
            },
            decimales(val) {
                return val.toFixed(2)
            }
        },
        computed: {
            isloading() {
                return this.$store.getters.getloading
            },
        }
    }
</script>