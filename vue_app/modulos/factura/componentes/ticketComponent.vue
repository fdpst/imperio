<template>
    <v-card  color="blue-grey darken-1" dark>

        <v-col cols="12 totalDetail pa-1">
          <v-card color="grey lighten-3 justify-end ma-0 pa-0">
            <v-card-subtitle class="pa-1">
                <h3>Sub-total : <span>{{total_productos.sub_total | fixed_n }} <v-icon class="black--text">mdi-currency-eur</v-icon></span></h3>
                <h3>IVA : <span>{{total_productos.total_iva | fixed_n }} <v-icon class="black--text">mdi-currency-eur</v-icon></span></h3>
                <h3 v-if="descuento > 0">Dto. {{this.descuento}} % : 
                    <span>{{(total_productos.total_sin_descuento - total_productos.total) | fixed_n}} <v-icon class="black--text">mdi-currency-eur</v-icon></span> 
                </h3>
                <h3>Total : <span>{{total_productos.total | fixed_n }} <v-icon class="black--text">mdi-currency-eur</v-icon></span></h3>
            </v-card-subtitle>            
          </v-card>
        </v-col>
 
        <v-col cols="12">
            <v-card-text class="pb-0 pt-0 pl-3 pr-3 mt-0 mb-0"> 

                <v-container v-if="!cliente.id">
                    <v-row class="row-md-12 ma-0 pa-0 text-center">                        
                        <v-col title="CLIENTE" class="mb-2 pa-0 frame frameCostumer" @click="openCliente">
                            <p class="mt-2 mb-0"><v-icon>mdi-account-circle</v-icon></p>
                            <p class="mt-0 ml-1 mr-1">Cliente</p>
                        </v-col>
                        <v-col title="DESCUENTO" class="mb-2 pa-0 frame frameDiscount" @click="openDescuento">
                            <p class="mt-2 mb-0"><v-icon>mdi-percent</v-icon></p>
                            <p class="ml-1 mr-1 mt-0">Descuento</p>
                        </v-col>   
                        <v-col title="FACTURA" class="mb-2 pa-0 frame frameBill" @click="crearFactura('factura')" :disabled="!cliente.id"
                        style="background-color: #BDBDBD; pointer-events: none;">
                            <p class="mt-2 mb-0"><v-icon>mdi-file-document-outline</v-icon></p>
                            <p class="ml-1 mr-1 mt-0">Factura</p>
                        </v-col>
                        <v-col title="PRESUPUESTO" class="mb-2 pa-0 frame frameBudget" @click="crearFactura('presupuesto')" :disabled="!cliente.id"
                        style="background-color: #BDBDBD; pointer-events: none;">
                            <p class="mt-2 mb-0"><v-icon>mdi-calculator-variant</v-icon></p>
                            <p class="ml-1 mr-1 mt-0">Presupuesto</p>
                        </v-col>
                    </v-row>            
                </v-container>

                <v-container v-else>
                    <v-row class="row-md-12 ma-0 pa-0 text-center">                        
                        <v-col title="CLIENTE" class="mb-2 pa-0 frame frameCostumer" @click="openCliente">
                            <p class="mt-2 mb-0"><v-icon>mdi-account-circle</v-icon></p>
                            <p class="mt-0 ml-1 mr-1">Cliente</p>
                        </v-col>
                        <v-col title="DESCUENTO" class="mb-2 pa-0 frame frameDiscount" @click="openDescuento">
                            <p class="mt-2 mb-0"><v-icon>mdi-percent</v-icon></p>
                            <p class="ml-1 mr-1 mt-0">Descuento</p>
                        </v-col>   
                        <v-col title="FACTURA" class="mb-2 pa-0 frame frameBill" @click="crearFactura('factura')" :disabled="!cliente.id">
                            <p class="mt-2 mb-0"><v-icon>mdi-file-document-outline</v-icon></p>
                            <p class="ml-1 mr-1 mt-0">Factura</p>
                        </v-col>
                        <v-col title="PRESUPUESTO" class="mb-2 pa-0 frame frameBudget" @click="crearFactura('presupuesto')" :disabled="!cliente.id">
                            <p class="mt-2 mb-0"><v-icon>mdi-calculator-variant</v-icon></p>
                            <p class="ml-1 mr-1 mt-0">Presupuesto</p>
                        </v-col>
                    </v-row>            
                </v-container>
            
                <v-container v-if="!muestraBotones">                        
                    <v-btn @click="crearFactura('ticket')" small block color="light-blue lighten-1" title="EXCEL" class="white--text mb-2" disabled>
                        <v-icon class="mr-1">mdi-printer</v-icon> Imprimir Ticket
                    </v-btn>
                    <v-btn @click="opendialog" small block color="red" class="white--text mb-2"  disabled>
                        <v-icon class="mr-1">mdi-delete</v-icon> Eliminar Ticket
                    </v-btn>
                </v-container>

                <v-container v-else>                        
                    <v-btn @click="crearFactura('ticket')" small block color="light-blue lighten-1" class="white--text mb-2">
                        <v-icon class="mr-1">mdi-printer</v-icon> Imprimir Ticket
                    </v-btn>
                    <v-btn @click="opendialog" small block color="red" class="white--text mb-2">
                        <v-icon class="mr-1">mdi-delete</v-icon> Eliminar Ticket
                    </v-btn>
                </v-container>

            </v-card-text>
            <confirm-dialog 
                :confirm_dialog="confirm_dialog" :tipo="'ticket'" 
                :texto="'¿Desea eliminar el ticket actual y todos sus items?'" 
                @confirmar_ticket="cleanView" @close_dialog="confirm_dialog = false">
            </confirm-dialog>
        </v-col>

    </v-card>

</template>

<script>

    export default {
        
        props: ['descuento', 'items', 'item', 'cliente', 'muestraBotones'],

        data() {
            return {
                confirm_dialog: false
            }
        },

        methods: {

            openCliente() {
                this.$emit('open_cliente')
            },

            openDescuento() {
                this.$emit('open_descuento')
            },

            getTotales(tipo) {
                let iva = this.total_productos.total_iva
                return {
                    total_sin_descuento: this.total_productos.total_sin_descuento,
                    sub_total: parseFloat(this.total_productos.sub_total).toFixed(2),
                    iva: parseFloat(iva).toFixed(2),
                    descuento: parseFloat(this.total_productos.total_sin_descuento) - parseFloat(this.total_productos.total),
                    porcentaje_descuento: this.descuento,
                    total: parseFloat(this.total_productos.total),
                    tipo: tipo
                }
            },

            crearFactura(tipo) {
                if (tipo == 'presupuesto') {
                    this.items.forEach(item => {
                        item.cantidad = item.numero + item.cantidad
                    });
                }
                let totales = this.getTotales(tipo)
                this.$emit('crear_factura', totales)
                this.ocultaBotones()  
            },

            guardarPresupuesto() {
                let totales = this.getTotales('presupuesto')
                this.$emit('crear_presupuesto', totales)
            },

            opendialog() {
                this.confirm_dialog = true
            },

            cleanView(){
                this.items.forEach(item => {
                    item.cantidad = item.numero + item.cantidad
                    item.numero = 0 
                });
                this.confirm_dialog = false
                this.$emit('ocultar_botones', false)
                this.confirm_dialog = false
                this.$emit('clear_all')
            },

            ocultaBotones() {
                this.$emit('ocultar_botones', false)
                this.confirm_dialog = false
            },

        },

        filters: {
            fixed_n(n) {
                return parseFloat(n).toFixed(2)
            }
        },

        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },

            total_productos() {
                return this.items.reduce((acc, element) => {
                    let total_item = element.precio * element.numero
                    let precio = (this.descuento > 0) ? total_item - (total_item * this.descuento / 100) : total_item
                    let i = (element.tipo_iva / 100) + 1
                    let iva = precio - (precio / i)
                    let sub_total = precio / i;
                    this.$emit('ocultar_botones', true)

                    return {
                        total_sin_descuento: acc.total_sin_descuento + total_item,
                        sub_total: acc.sub_total + sub_total,
                        total_iva: acc.total_iva + iva,
                        total: acc.total + precio
                    }
                }, 
                {
                    total_sin_descuento: 0,
                    sub_total: 0,
                    total_iva: 0,
                    total: 0
                })
            }
        }
    }
</script>

<style >
    h3{ 
        color: black !important;
        text-align: end;
    }

    .totalDetail{
        padding: 0px !important;
    }

    .frame.frameCostumer {
        background-color: #29b6f6;
        border-radius: 10px;
        height: 67px;
        width: 80px;
        color: white;
        border: 2px solid #455A64;
    }

    .frame.frameDiscount {
        background-color: #29b6f6;
        border-radius: 10px;
        height: 67px;
        width: 80px;
        color: white;
        border: 2px solid #455A64;
    }

    .frame.frameBill {
        background-color: #29b6f6;
        border-radius: 10px;
        height: 67px;
        width: 80px;
        color: white;
        border: 2px solid #455A64;
    }

    .frame.frameBudget {
        background-color: #29b6f6;
        border-radius: 10px;
        height: 67px;
        width: 80px;
        font-size: 0.75em;
        color: white;
        border: 2px solid #455A64;
    }

    .frame:hover{
        border-radius: 20px;
        color: black;
        border: 2px solid #CFD8DC;
        cursor: pointer;
    }    

@media (min-width:1265px) and (max-width:1679px){

    .lista-productos{
        max-height: 57% !important;
    }

    .col.col-12{
        margin: 3px !important;
        padding: 3px !important;
    }

    .container{
        margin: 3px !important;
        padding: 3px !important;
    }

    .frame.frameCostumer {
        height: 45px !important;
        width: 30px !important;
        font-size: 0px !important;
    }

    .frame.frameDiscount {
        height: 45px !important;
        width: 30px !important;
        font-size: 0px !important;
    }

    .frame.frameBill {
        height: 45px !important;
        width: 30px !important;
        font-size: 0px !important;
    }

    .frame.frameBudget {
        height: 45px !important;
        width: 30px !important;
        font-size: 0px !important;
    } 
    
}

@media (min-width:500px) and (max-width:1264px){
    .frame.frameCostumer {
        height: 67px;
        width: 80px;
    }

    .frame.frameDiscount {
        height: 67px;
        width: 80px;
    }

    .frame.frameBill {
        height: 67px;
        width: 80px;
    }

    .frame.frameBudget {
        height: 67px;
        width: 80px;
        font-size: 12px !important;
    }    
}

</style>