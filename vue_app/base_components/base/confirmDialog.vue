<template>
    <v-dialog  persistent v-model="confirm_dialog" width="750">
    <!-- <v-dialog @click:outside="closeDialog" v-model="confirm_dialog" width="750"> -->

        <v-card>
            <v-card-title class="headline primary white--text" dark primary-title>
                Confirmación
            </v-card-title>

            <v-card-text class="px-3 py-3">
                <v-row>
                    <v-col cols="12">
                        <p class="font-weight-light grey--text text--darken-1">{{texto}}</p>
                    </v-col>
                </v-row>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" text @click="confirmarDelete">eliminar</v-btn>
                <v-btn color="primary" text @click="closeDialog">cerrar</v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>

</template>

<script>
    export default {
        props: ['confirm_dialog', 'texto', 'tipo', 'items'],

        methods: {

            confirmarDelete() {
                // alert(this.tipo)

                switch (this.tipo) {
                    case 'item':
                        this.$emit('confirmar_item')
                        break;

                    case 'factura':
                        this.$emit('confirmar_factura')
                        break;

                    case 'ticket':
                        this.$emit('confirmar_ticket')
                        break; 

                    case 'contabilidadFactura':
                        this.$emit('eliminar')
                        break;

                    case 'contabilidadTicket':
                        this.$emit('eliminar')
                        break;  

                    // case 'presupuesto':
                    //     this.$emit('confirmar_presupuesto')
                    //     break;  

                    default:
                        break;
                }             
            },

            closeDialog() {
                this.$emit('close_dialog')
            }
        }
    }
</script>