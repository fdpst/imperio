<template>
    <v-dialog @click:outside="closeDialog" v-model="descuento_dialog" width="250">

        <v-card>
            <v-card-title class="headline primary white--text" dark primary-title>
                Descuento
            </v-card-title>


            <v-card-text class="px-3 py-3">
                <v-row dense>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="descuento" label="Descuento (%)"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="8">
                        <v-btn @click="aplicarDescuento" class="white--text" color="light-blue">Aplicar descuento</v-btn>
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
    export default {
        props: ['descuento_dialog'],

        data() {
            return {
                descuento: 0
            }
        },

        methods: {

            aplicarDescuento() {
                this.$emit('aplicar_descuento', this.descuento)
            },

            closeDialog() {
                this.$emit('close_descuento_dialog')
            }
        },

    }
</script>