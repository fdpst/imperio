<template>
    <v-container>
        <v-row>
            <v-col class="pa-0 ma-3 col-xs-12 col-sm-6 col-md-8">
                <v-btn @click="unselectMenu" color="light-blue" class="ma-3 pa.3 float-left white--text">menu principal</v-btn>
                <v-btn @click="unselectCategoria" color="light-blue" class="ma-3 pa.3 float-left white--text">menu categoria</v-btn>
            </v-col>

            <v-col class="pa-0 ma-0">
                <!-- Seccion de codigo de barras -->
                <v-card class="md-4 pt-1 mb-2 mt-4 mr-3 float-right bg-success" 
                    justify="end" align="center" dense floating style="height: 48px; width: 175px;">
                    <v-text-field autofocus v-on:keyup.enter="verificaCodigo(producto)" flat solo class="ml-2" v-model="producto"
                    dense floating hide-details prepend-icon="mdi-barcode-scan" minlength="8" maxlength="13"
                    style="font-size: 15px !important;"></v-text-field>
                </v-card>
                <!-- END Seccion de codigo de barras -->
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {

        data() {
            return {
                producto: ''        
            }
        },

        mounted() {
            this.getStocks()
        },

        methods: {

            unselectMenu() {
                this.$emit('unselect_menu')
            },

            unselectCategoria() {
                this.$emit('unselect_categoria')
            },

            getStocks() {
                axios.get('api/getstocks').then(res => {
                    this.stocks = res.data
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },

            verificaCodigo(producto) {
                this.stocks.forEach(stock => {
                    if ((stock.codigo) == producto){
                        stock.numero = stock.numero + 1
                        stock.cantidad --
                        stock.total = stock.precio * stock.numero
                        let codigo = stock
                        this.$emit('agregar_producto', codigo)
                        this.resetInput()                 
                    }                        
                });
            },

            resetInput() {
                this.producto = "";
            },
        }
    }
</script>