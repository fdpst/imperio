<template>
    <v-container>
        <loader v-if="isloading"></loader>
        <v-sheet shaped class="mx-4 my-4 pa-4">
            <v-row>
                <v-col cols="12">
                    <v-toolbar color="red lighten-2" dark>
                        <v-toolbar-title>Datos empresa</v-toolbar-title>
                    </v-toolbar>
                    <v-form class="mt-3">
                        <v-row>
                            <v-col cols="12" md="4">
                                <v-text-field v-model="empresa.nombre" label="Nombre" required></v-text-field>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field v-model="empresa.cif" label="CIF" required></v-text-field>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field v-model="empresa.telefono" label="Teléfono" required></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field v-model="empresa.direccion" label="Dirección" required></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-btn @click="saveEmpresa" :disabled="isloading" color="success" class="white--text">Guardar</v-btn>
                                <v-btn v-if="empresa.id" @click="deleteEmpresa" :disabled="isloading" color="red" class="white--text">Eliminar</v-btn>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-col>
            </v-row>
        </v-sheet>
        <v-sheet shaped class="mx-4 my-4 pa-4" style="min-height: 460px !important;">
            <v-row>
                <v-col cols="12">
                    <v-card class="mx-auto">
                        <v-toolbar color="red lighten-2" dark>
                            <v-toolbar-title>Historial Facturas</v-toolbar-title>
                        </v-toolbar>
                        <!-- <v-container fluid> -->
                            <!-- <v-row dense> -->
                                <!-- <v-list two-line subheader> -->
                                    <v-list-item v-for="factura in empresa.factura" :key="factura.id">
                                        <v-list-item-content>
                                            <v-list-item-title>Nro.Factura : <router-link :to="{ path: `/subir-factura?empresa_id=${empresa.id}&id=${factura.id}` }">{{factura.numero_factura}}</router-link>
                                            </v-list-item-title>
                                            <v-list-item-title>Monto : {{factura.monto}}€</v-list-item-title>
                                            <v-list-item-title>Fecha : {{factura.fecha}}</v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                <!-- </v-list> -->
                            <!-- </v-row> -->
                        <!-- </v-container> -->
                    </v-card>
                </v-col>
            </v-row>
        </v-sheet>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                empresa: {
                    id: '',
                    nombre: '',
                    cif: '',
                    telefono: '',
                    direccion: ''
                }
            }
        },

        created() {
            if (this.$route.query.id) {
                this.getEmpresa(this.$route.query.id)
            }
        },
        methods: {
            getEmpresa(empresa_id) {
                axios.get(`api/getempresa/${empresa_id}`).then(res => {
                    this.empresa = res.data
                }, res => {

                })
            },
            saveEmpresa() {
                axios.post('api/saveempresa', this.empresa).then(res => {
                    this.$router.push('lista-empresas')
                }, res => {
                    this.$toast.error('error guardando empresa')

                })
            },
            deleteEmpresa() {
                axios.get(`api/deleteempresa/${this.empresa.id}`).then(res => {
                    this.$router.push('lista-empresas')
                }, res => {
                    this.$toast.error('no se puede eliminar')

                })
            },

        },
        filters: {
            format_date(fecha) {
                return moment(fecha).format('DD-MM-YYYY')
            }
        },
        computed: {
            isloading() {
                return this.$store.getters.getloading
            }
        }
    }
</script>