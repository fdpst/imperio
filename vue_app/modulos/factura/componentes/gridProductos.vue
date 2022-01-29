<template>
    <v-container>
        <!-- Butons Back and scaner  -->
        <v-row>
            <v-col>
                <v-btn @click="unselectCategoria" color="light-blue" class="ma-3 pa.3 float-left white--text">menu categoria</v-btn>
                <v-btn @click="mostrarBarcode" color="light-blue" class="ma-3 pa.3 float-left white--text">menu escaner</v-btn>
                <v-flex >
                    <v-btn-toggle style="background-color: transparent !important;">
                        <v-btn @click="mostrar" class="mt-2 mb-3" 
                            style="background-color: transparent !important;border: none !important;">
                            <v-icon class="teal--text">mdi-format-list-checkbox</v-icon>
                        </v-btn>           
                        <v-btn @click="mostrar" class="mt-2 mb-3" 
                            style="background-color: transparent !important;border: none !important;">
                            <v-icon class="teal--text">mdi-card-outline</v-icon>
                        </v-btn>
                    </v-btn-toggle>
                </v-flex>
            </v-col>
            <!-- busqueda -->
            <v-col cols="12" md="5" class="mr-4 pr-4">
                <v-text-field v-model="search" label="Buscar Productos y/o Servicios"></v-text-field>
            </v-col>
            <!-- END busqueda -->
        </v-row>
        <!-- END Butons Back and scaner  -->

        <!-- List view format -->
        <v-col v-if="!this.lista" cols="12" class="mx-auto">
            <v-data-table :headers="headers" :search="search" disable-pagination hide-default-footer 
                :items="categoria_selected.stock" class="elevation-1 mt-4">
                <template v-slot:item.imagen_url="{ item }">
                    <img :src="item.imagen_url" style="width: 113px; height: 40px" class="mt-1"/>
                </template>
                <template v-slot:item.precio="{item}">
                    <strong>{{item.precio}}</strong> <v-icon small class="mb-1 black--text">mdi-currency-eur</v-icon>
                </template>
                <template v-slot:item.cantidad="{item}">
                    <v-chip v-show="categoria_selected.nombre !== 'Servicios'" class="pa-2 mb-1" 
                        :color="getColor(item.cantidad)" dark >{{item.cantidad}}
                    </v-chip>
                </template>
                <template v-slot:item.venta="{item}">
                    <v-icon small class="mb-1 green--text" @click="agregarProducto(item)">mdi-cart-plus</v-icon>
                </template>
            </v-data-table>
        </v-col>
        <!-- END List view format -->

        <!-- Card view format  -->
        <v-row v-if="this.lista">
            <v-row v-if="categoria_selected" color="grey lighten-4" style="max-width:99.5%;">
                <v-col v-for="item in filteredCards" :key="item.id"
                    class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <v-card @click="agregarProducto(item)" class="mx-0 my-0 px-1 pt-1">
                        <v-img class="align-end" height="113px" :src="item.imagen_url"></v-img>
                        <v-card-text class="pa-2 grey--text text--darken-2">
                            <div class="font-weight-light text-truncate mb-1">{{item.nombre}}</div>                                
                            <v-system-bar class="font-weight-bold transparent">
                                <div class="font-weight-bold col-md-6">{{item.precio}} <v-icon>mdi-currency-eur</v-icon> </div>
                                <v-chip class="pa-2 mb-1" :color="getColor(item.cantidad)" dark v-show="categoria_selected.nombre !== 'Servicios'">
                                    <div class="font-weight-bold col-md-6">
                                        <v-icon>mdi-cube-outline</v-icon> {{item.cantidad}}
                                    </div>
                                </v-chip>
                            </v-system-bar>
                        </v-card-text>
                    </v-card>
                </v-col> 
            </v-row>
        </v-row>
        
        <!-- END Card view format  -->
    </v-container>
</template>

<script>
    export default {
        props: ['categoria_selected'],
        
        data() {
            return {
                search: '',
                headers: [{
                        text: 'Imagen',
                        align: 'center',
                        value: 'imagen_url',
                    },
                    {
                        text: 'Nombre',
                        align: 'left',
                        value: 'nombre',
                    },
                    {
                        text: 'Código EAN',
                        value: 'codigo',
                    },
                    {
                        text: 'Precio Ud / Kg',
                        align: 'center',
                        value: 'precio',
                    },
                    {                        
                        align: 'center',
                        text: 'Stock / Venta',
                        value: 'cantidad',
                    },                    
                    {                        
                        align: 'center',
                        text: 'Añadir',
                        value: 'venta',
                    },
                ],
                lista: true                
            }
        },

        methods: {
            agregarProducto(producto) {
                if(producto.cantidad >0){                    
                    producto.cantidad --
                    producto.numero += 1
                    producto.total = producto.precio * producto.numero
                    this.$emit('agregar_producto', producto)
                }                
            },

            unselectCategoria() {
                this.$emit('unselect_categoria')
            },
            
            mostrarBarcode() {
                this.unselectCategoria()
                this.$emit('mostrar_barcode', true)
            },

            mostrar() {
                if (this.lista == true) this.lista = false
                else this.lista = true                                
            },

            getColor (cantidad) {
                if (cantidad <= 10) return 'red'
                else if (cantidad > 10 && cantidad <= 50 ) return 'orange'
                else return 'green'
            },
        },
        computed: {  
            filteredCards() {
            return this.categoria_selected.stock.filter(item => {
                return item.nombre.toLowerCase().includes(this.search.toLowerCase())
            })
            }
        }
    }
</script>