<template>
    <v-list two-line style="min-height: 12vh;">
        <template v-for="item in items">

            <v-list-item>
                <v-list-item-avatar class="mr-0 pr-0">
                    <v-img id="avatar" class="pt-0 pb-1 col-sm-2 col-md-2 col-lg-2 col-xl-2" :src="item.imagen_url"></v-img>
                </v-list-item-avatar>
                <v-col class="pt-4 pb-1 pl-1 pr-1 mt-4 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                    <v-icon id="trashbtn" small medium color="red" @click="setItem(item)">mdi-delete</v-icon>
                </v-col>

                <v-list-item-content class="grey--text text--darken-2">
                    <v-list-item-title id="itemname" class="font-weight-light mt-0 pt-0 mb-2col-sm-12 col-md-12 col-lg-12 col-xl-12" v-html="item.nombre"></v-list-item-title>

                        <v-row class="rowdetail">
                            <v-col class="pt-0 pb-1 px-0 col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                <h5 id="h5number" class="mt-3 pt-0 justify-center text-center">{{item.numero}}</h5>
                            </v-col>
                            <v-col class="pt-2 pb-1 px-0 mx-1col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <v-icon id="minusbtn" small medium color="red" @click="reduceItem(item)" style="font-size: 26px;">mdi-minus-box-outline mdi-2x</v-icon>
                                    <v-icon id="plusbtn" class="ml-2" color="green" @click="addItem(item)" style="font-size: 26px;">mdi-plus-box-outline</v-icon>                                
                            </v-col>
                            <v-col class="pt-0 pb-1 px-0 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                <h5 id="h5txt" class="mt-3 pt-0 ml-4" >{{item.precio}}
                                    <v-icon id="currency" class="black--text" style="font-size: 14px;">mdi-currency-eur</v-icon>
                                </h5>
                            </v-col>
                            <v-col class="pt-0 pb-1 px-0 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                <h5 id="h5txt" class="font-weight-bold mt-3" >{{item.precio * item.numero}}
                                    <v-icon id="currency" class="black--text" style="font-size: 14px;">mdi-currency-eur</v-icon>
                                </h5>
                            </v-col>                            
                        </v-row>

                </v-list-item-content>
                
            </v-list-item>
            <v-divider></v-divider>

        </template>
        <confirm-dialog :confirm_dialog="confirm_dialog" :tipo="'item'"  :texto="'¿Desea eliminar este item?'"
                        @confirmar_item="deleteItem" @close_dialog="confirm_dialog = false">
        </confirm-dialog>
    </v-list>
</template>

<script>
    export default {
        props: ['items'],  

        data() {
            return {
                confirm_dialog: false
            }
        },

        methods: {

            setItem(item) {
                this.item = item
                this.confirm_dialog = true
            },

            deleteItem() {
                this.item.cantidad = this.item.numero + this.item.cantidad
                this.item.numero = 0           
                this.confirm_dialog = false       
                this.$emit('delete_item', this.item)
            },

             addItem(item) {
                if (item.cantidad >0) {
                  item.numero = item.numero + 1  
                  item.cantidad --
                }                 
            },
             reduceItem(item) {
                if(item.numero == 1){
                    this.item = item
                    this.confirm_dialog = true           
                }
                else {
                    item.numero = item.numero - 1
                    item.cantidad = item.cantidad + 1     
                }                    
            },
        }
    }
</script>

<style>
    
@media (min-width:1265px) and (max-width:1919px){  

    div#avatar{
        height: 20px !important;
        margin: 0px !important;
    }

    div#itemname{
        font-size: 12px !important;
    }

    button#minusbtn{
        font-size: 12px !important;
        margin-top: -20px !important;
        padding: 0px !important;
    }

    button#plusbtn{
        font-size: 12px !important;
        margin-top: -20px !important;
        padding: 0px !important;
    }

    button#trashbtn{
        font-size: 12px !important;
        margin-top: -20px !important;
        margin-left: -5px !important;
        padding: 0px !important;
    }

    h5#h5txt{
        margin-top: 15px !important;
        font-size: 11px !important;
        margin: 0px !important;
        margin-left: -15px !important;
    }

    h5#h5number{
        margin-top: 15px !important;
        font-size: 11px !important;
        margin: 0px !important;
    }

    i#currency{
        font-size: 10px !important;
        margin: 0px !important;
    }    
}

</style>