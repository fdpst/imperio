<template>
    <v-dialog @click:outside="closeDialog" v-model="dialog" width="750">

        <v-card>
            <v-card-title class="headline primary white--text" dark primary-title>
                Seleccionar Cliente
            </v-card-title>

            <mini-loader v-if="isloading"></mini-loader>

            <v-card-text class="px-3 py-3">
                <v-row>
                    <v-col cols="12" md="3">
                        <v-text-field v-model="dni" label="DNI / CIF"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field v-model="cliente.nombre" label="Nombre" :disabled="cliente.id != null"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="5">
                        <v-text-field v-model="cliente.direccion" label="Dirección" :disabled="cliente.id != null"></v-text-field>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12" md="3">
                        <v-btn @click="seleccionarCliente" v-if="cliente.id != null" class="white--text" color="light-blue">Aceptar</v-btn>
                        <v-btn @click="saveCliente" v-else class="white--text" color="primary">Guardar</v-btn>
                    </v-col>
                </v-row>

            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" text @click="closeDialog">cerrar</v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>

</template>

<script>
    import debounce from 'lodash/debounce'
    export default {
        props: ['dialog'],
        data() {
            return {
                dni: null,
                cliente: {
                    id: null,
                    dni: null,
                    nombre: null
                }
            }
        },
        watch: {
            dni(n) {
                if (n != '') {
                    this.debouncedQuery(n)
                }
            },
        },
        methods: {
            debouncedQuery: debounce(function(n) {
                this.getCliente(n);
            }, 750),

            getCliente(n) {
                axios.get(`api/getclientebydni/${n}`).then(res => {
                    this.cliente = res.data
                }, res => {
                    this.$toast.error('Error consultando cliente')
                })
            },

            saveCliente() {
                this.cliente.dni = this.dni
                axios.post('api/savecliente', this.cliente).then(res => {
                    this.cliente = res.data
                }, res => {
                    this.$toast.error('Error guardando cliente')
                })
            },

            seleccionarCliente() {
                this.$emit('seleccionar_cliente', this.cliente)
            },

            closeDialog() {
                this.$emit('close_dialog')
            }
        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
        }
    }
</script>

<style scope>
    .v-application p {
        margin-bottom: 5px;
    }
</style>