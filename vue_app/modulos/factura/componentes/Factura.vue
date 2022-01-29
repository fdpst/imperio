<template>
    <v-container>
        <v-card class="mx-auto">

            <v-toolbar color="light-blue lighten-2" flat dark>
                <v-toolbar-title>Emitir Factura</v-toolbar-title>
            </v-toolbar>

            <v-container fluid>
                <v-row dense>
                    <v-col cols="12" md="2">
                        <v-text-field v-model="cliente.dni" disabled outline label="DNI / CIF"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-text-field v-model="cliente.nombre" label="Nombre" outline disabled></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field v-model="cliente.direccion" label="Dirección" outline disabled></v-text-field>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12">
                        <v-btn @click="dialog = true" class="white--text" color="light-blue">Buscar Cliente</v-btn>
                    </v-col>
                </v-row>

            </v-container>
        </v-card>

        <cliente-component @seleccionar_cliente="seleccionarCliente" @close_dialog="dialog = false" :dialog="dialog"></cliente-component>

        <productos-component></productos-component>

    </v-container>
</template>

<script>
    import clienteComponent from './clienteComponent'
    import productosComponent from './productosComponent'

    export default {
        components: {
            clienteComponent,
            productosComponent
        },
        data() {
            return {
                dialog: true,
                cliente: {},
                productos: []
            }
        },
        methods: {
            seleccionarCliente(cliente) {
                this.cliente = cliente
                this.dialog = false
            }
        }
    }
</script>