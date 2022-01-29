<template>
<v-container>
    <loader v-if="isloading"></loader>
    <v-sheet shaped class="mx-4 my-4 pa-4">
        <v-row>
            <v-col cols="12">
                <v-toolbar color="red lighten-2" dark>
                    <v-toolbar-title>Datos cliente</v-toolbar-title>
                </v-toolbar>
                <v-form class="mt-3">
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="cliente.nombre" label="Nombre" required></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="cliente.dni" label="DNI/CIF" required></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="cliente.telefono" label="Teléfono" required></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <v-text-field v-model="cliente.email" label="Email" required></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field v-model="cliente.direccion" label="Dirección" required></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="cliente.codigo_postal" label="Código postal" required></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="cliente.localidad" label="Localidad" required></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-autocomplete v-model="cliente.provincia_id" :items="provincias" item-text="nombre" item-value="id" label="Provincia"></v-autocomplete>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-btn @click="saveCliente" :disabled="isloading" color="success" class="white--text">Guardar</v-btn>
                            <v-btn v-if="cliente.id" @click="deleteCliente" :disabled="isloading" color="red" class="white--text">Eliminar</v-btn>
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
                        <v-toolbar-title>Historial</v-toolbar-title>
                    </v-toolbar>
                    <!--  <v-container fluid>
                        <v-row dense>
                            <v-list two-line subheader>
                                <v-list-item v-for="cita in cliente.cita" :key="cita.id">
                                    <v-list-item-content>
                                        <v-list-item-subtitle class="font-weight-bold">Detalles Cita</v-list-item-subtitle>
                                        <v-list-item-subtitle>Empleado : {{cita.empleado.nombre}}</v-list-item-subtitle>
                                        <v-list-item-subtitle>Fecha: {{cita.fecha | format_date}}</v-list-item-subtitle>
                                        <v-list-item-subtitle>Precio: {{ cita.precio }} - Pagado: {{cita.pagado}}</v-list-item-subtitle>
                                        <v-list-item-subtitle class="font-weight-bold">Servicios</v-list-item-subtitle>
                                        <template v-for="agenda in cita.agenda">
                                            <v-list-item-subtitle>{{agenda.servicio.nombre}}</v-list-item-subtitle>
                                        </template>
                                        <v-list-item-subtitle class="font-weight-bold">Stock</v-list-item-subtitle>
                                        <template v-for="stock in cita.cita_stock">
                                            <v-list-item-subtitle>Producto: {{stock.stock.nombre}} - Cantidad: {{stock.cantidad}}</v-list-item-subtitle>
                                        </template>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-row>
                    </v-container>-->
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
                menu: false,
                cliente: {
                    id: '',
                    nombre: '',
                    email: '',
                    telefono: '',
                    direccion: '',
                    dni: '',
                    provincia_id: null,
                    codigo_postal: '',

                }
            }
        },
        watch: {
            menu(val) {
                val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
            },
        },
        created() {
            if (this.$route.query.id) {
                this.getCliente(this.$route.query.id)
            }
        },
        methods: {
            getCliente(cliente_id) {
                axios.get(`api/getcliente/${cliente_id}`).then(res => {
                    this.cliente = res.data
                }, res => {

                })
            },
            saveCliente() {
                axios.post('api/savecliente', this.cliente).then(res => {
                    this.$router.push('lista-clientes')
                }, res => {

                })
            },
            deleteCliente() {
                axios.get(`api/deletecliente/${this.cliente.id}`).then(res => {
                    this.$router.push('lista-clientes')
                }, res => {

                })
            },
            save(date) {
                this.$refs.menu.save(date)
            },
        },
        filters: {
            format_date(fecha) {
                return moment(fecha).format('DD-MM-YYYY')
            }
        },
        computed: {
            computedDateFormattedMomentjs() {
                return this.cliente.fecha_nacimiento ? moment(this.cliente.fecha_nacimiento, 'YYYY-MM-DD').format('DD-MM-YYYY') : ''
            },
            isloading() {
                return this.$store.getters.getloading
            },
            provincias() {
                return this.$store.getters.getprovincias
            }
        }
    }
</script>