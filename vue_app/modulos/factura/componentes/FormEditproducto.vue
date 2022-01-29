<template>
    <v-container>
        <loader v-if="isloading"></loader>
        <v-sheet shaped class="mx-4 my-4 pa-4">
            <v-row>
                <v-col cols="12">
                    <v-toolbar color="red lighten-2" dark class="mb-4" >
                        <v-toolbar-title>Editar Producto</v-toolbar-title>
                    </v-toolbar>
                    <v-card ref="form" class="mx-auto">
                        <v-container :ivas="ivas" :categorias="categorias" :stock="stock">
                            <!-- Primera fila CODIGO NOMBRE STOCK -->
                            <v-row>
                                <v-col cols="12" md="3">
                                    <v-text-field label="Codigo" v-model="stock.codigo"> </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field label="Nombre" ref="stocknombre" v-model="stock.nombre"
                                        :rules="[() => !!stock.nombre || 'Este campo es obligatorio']"
                                        :error-messages="errorMessages" required>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="3">
                                    <v-text-field
                                        label="Stock" ref="stockcantidad" v-model="stock.cantidad"
                                        :rules="[() => !!stock.cantidad || 'Este campo es obligatorio']"
                                        :error-messages="errorMessages" required>
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <!-- END Primera fila CODIGO NOMBRE STOCK -->
                            <!-- Segunda fila CATEGORIA % CATEGORIA IVA % IVA IMAGEN -->
                            <v-row class="mt-4">
                                <v-col cols="12" md="3" class="mt-4">
                                    <v-select label="Categoria" ref="stockcategoria_id" v-model="stock.categoria_id"
                                        :rules="[() => !!stock.categoria_id || 'Este campo es obligatorio']"
                                        :error-messages="errorMessages" :items="categorias" item-value="id" item-text="nombre"
                                        @change="categoriaProfit()" required>
                                    </v-select>
                                </v-col>
                                <v-col cols="12" md="2" class="mt-4">
                                    <v-text-field
                                        label="% Categoria" v-model="catprofit" :items="categorias" disabled>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="2" class="mt-4">
                                    <v-select
                                        label="IVA" ref="stockiva_id" v-model="stock.iva_id"
                                        :rules="[() => !!stock.iva_id || 'Este campo es obligatorio']"
                                        :error-messages="errorMessages" :items="ivas" item-value="id" item-text="iva"
                                        @change="actualizar(ivas[stock.iva_id-1])" required>
                                    </v-select>
                                </v-col>
                                <v-col cols="12" md="2" class="mt-4">
                                    <v-text-field label="% IVA" v-model="stock.tipo_iva"></v-text-field>
                                </v-col>                    
                                <v-col cols="12" md="3" class="mb-0 mt-0">
                                    <v-card class="mx-0 px-1 pt-1">
                                        <v-img class="align-end" :src="stock.imagen_url" height="150px"></v-img>
                                    </v-card>
                                </v-col> 
                            </v-row>
                            <!-- END Segunda fila CATEGORIA % CATEGORIA IVA % IVA IMAGEN -->
                            <!-- Tercera fila PVD S/I PVD % ARTICULO PVP S/I PVP ARCHIVO -->
                            <v-row class="mt-0">
                                <v-col cols="12" md="2">
                                    <v-text-field label="PVD sin iva" v-model="stock.preciopvdsiva"
                                        @change="ivaIncrementPvd()">
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="2">
                                    <v-text-field label="PVD con iva" v-model="stock.preciopvd"
                                        @change="ivaDecrementPvd()">
                                    </v-text-field>
                                </v-col>
                            
                                <v-col cols="12" md="1">
                                    <v-text-field label="% Articulo" v-model="stock.art_profit"> </v-text-field>
                                </v-col>
                                <v-col cols="12" md="2">
                                    <v-text-field label="PVP sin iva" v-model="stock.preciosiva"
                                        @change="ivaIncrementPvp()">
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="2">
                                    <v-text-field label="PVP con iva" ref="stockprecio" v-model="stock.precio"
                                        :rules="[() => !!stock.precio || 'Este campo es obligatorio']"
                                        :error-messages="errorMessages" @change="ivaDecrementPvp()" required>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="3" >
                                    <file-component @file_has_changed="fileHasChanged" label=" Archivo Imagen Producto"></file-component>
                                </v-col>
                            </v-row>
                            <!-- END Tercera fila PVD S/I PVD % ARTICULO PVP S/I PVP ARCHIVO -->
                            <!-- Botones GUARDAR CANCELAR -->
                            <v-row justify='start' class="mt-0 pt-0">
                                <v-col cols="12" md="4">
                                    <v-btn class="white--text my-3 mr-4" color="success" @click="submit">guardar</v-btn>
                                    <v-btn class="white--text my-3 mr-0" color="red" @click="cancelSave">cancelar</v-btn>
                                </v-col>
                            </v-row>
                            <!-- END Botones GUARDAR CANCELAR -->
                        </v-container>
                    </v-card>
                </v-col>
            </v-row>
        </v-sheet>
    </v-container>
</template>

<script>
    import formStock from '../../stock/componentes/formStock'
    export default {
        components: {
            formStock
        },
        data() {
            return {
                stock: {}, 
                categorias: [],
                ivas: [],
                stocks: [],
                catprofit: 0,
                errorMessages: "",
                stocknombre: null,
                stockcantidad: null,
                stockcategoria_id: null,
                stockiva_id: null,
                stockprecio: null,
                formHasErrors: false
            }
        },
        created(){ 
            this.getStocks()
            this.$route.query.id ? this.getItem(this.$route.query.id) : null
        },

        computed: {
            form() {
                return {
                    stocknombre: this.stock.nombre,
                    stockcantidad: this.stock.cantidad,
                    stockcategoria_id: this.stock.categoria_id,
                    stockiva_id: this.stock.iva_id,
                    stockprecio: this.stock.precio,
                };
            },
        },

        watch: {
            stocknombre() {
                this.errorMessages = "";
            },
            stockcantidad() {
                this.errorMessages = "";
            },
            stockcategoria_id() {
                this.errorMessages = "";
            },
            stockiva_id() {
                this.errorMessages = "";
            },
            stockprecio() {
                this.errorMessages = "";
            },
        },

        methods: {
            getStocks() {
                axios.get('api/getstocks').then(res => {
                    this.stocks = res.data
                    this.getCategorias()
                }, err => {
                    this.$toast.error('Error al obtener Datos STOCK')
                })
            },

            getCategorias() {
                axios.get('api/getcategorias').then(res => {
                    this.categorias = res.data
                    // Tomamos el valor de % categorias
                    this.categorias.forEach(categoria => {
                    if (categoria.id == this.stock.categoria_id) {
                            this.catprofit = categoria.cat_profit
                    }   
                    this.getIvas()       
                });
                }, err => {
                    this.$toast.error('Error al obtener Datos CATEGORIAS')
                })
            },

            getIvas() {
                axios.get('api/getivas').then(res => {
                    this.ivas = res.data
                }, err => {
                    this.$toast.error('Error al obtener Datos IVA')
                })
            },

            getItem(id) {
                axios.get(`api/getstock/${id}`).then(res => {
                    this.stock = res.data
                }, res => {
                    this.$toast.error('Error obteniendo datos del Producto')
                })
            },

            fileHasChanged(base_image) {
                this.stock.imagen_url = base_image
            },

            saveItem() {
                
                axios.post('api/savestock', this.stock).then(res => {
                    console.log(res)
                }, res => {
                    this.$toast.error('Error almacenando Producto')
                })
                this.getStocks()
                this.$router.push('lista-stock')
            },

            cancelSave() {
                this.$router.push('lista-stock')
            },

            actualizar(iva){
                this.stock.tipo_iva = iva.iva;
                this.stock.iva_id = iva.id;
                this.ivaIncrementPvd();
            },

            categoriaProfit(){       
                this.categorias.forEach(categoria => {
                    if (categoria.id == this.stock.categoria_id) {
                            this.catprofit = categoria.cat_profit
                    }          
                });
                this.ivaIncrementPvd();
            },

            ivaIncrementPvd(){
                    let iva = parseInt(this.stock.tipo_iva)
                    let ivacalculo = ((iva/100)+1)
                if (this.stock.preciopvdsiva >= 0) {
                    this.stock.preciopvd = parseFloat( this.stock.preciopvdsiva * ivacalculo ).toFixed(2)
                    // Cambio en PVP Siva
                    // % categoria
                    let catprofit = parseInt(this.catprofit)
                    let catprofitcalculo = ((catprofit/100)+1)
                    this.stock.preciosiva = parseFloat( this.stock.preciopvdsiva * catprofitcalculo ).toFixed(2)
                    // % articulo
                    let artprofit = this.stock.art_profit
                    let artprofitcalculo = ((artprofit/100)+1)
                    this.stock.preciosiva = parseFloat( this.stock.preciosiva * artprofitcalculo ).toFixed(2)

                    this.ivaIncrementPvp()
                }
                else
                {
                    this.stock.preciopvd = parseFloat(0).toFixed(2)   
                    this.stock.preciopvdsiva = parseFloat(0).toFixed(2)   
                    this.stock.precio = parseFloat(0).toFixed(2)   
                    this.stock.preciosiva = parseFloat(0).toFixed(2)   
                }
            },

            ivaDecrementPvd(){
                let iva = parseInt(this.stock.tipo_iva)
                    let ivacalculo = ((iva/100)+1)
                if (this.stock.preciopvd >= 0) {
                    this.stock.preciopvdsiva = parseFloat( this.stock.preciopvd / ivacalculo ).toFixed(2)
                    // Cambio en PVP
                    // % categoria
                    let catprofit = parseInt(this.catprofit)
                    let catprofitcalculo = ((catprofit/100)+1)
                    this.stock.precio = parseFloat(  this.stock.preciopvd * catprofitcalculo ).toFixed(2)    
                    // % articulo
                    let artprofit = this.stock.art_profit
                    let artprofitcalculo = ((artprofit/100)+1)
                    this.stock.precio = parseFloat( this.stock.precio * artprofitcalculo ).toFixed(2)

                    this.ivaDecrementPvp()
                }
                else
                {
                    this.stock.preciopvd = parseFloat(0).toFixed(2)   
                    this.stock.preciopvdsiva = parseFloat(0).toFixed(2)   
                    this.stock.precio = parseFloat(0).toFixed(2)   
                    this.stock.preciosiva = parseFloat(0).toFixed(2)   
                }
            },

            ivaIncrementPvp(){
                    let iva = parseInt(this.stock.tipo_iva)
                    let ivacalculo = ((iva/100)+1)
                if (this.stock.preciosiva >= 0) {
                    this.stock.precio = parseFloat( this.stock.preciosiva * ivacalculo ).toFixed(2)
                }
                else
                {
                    this.stock.precio = parseFloat(0).toFixed(2)   
                    this.stock.preciosiva = parseFloat(0).toFixed(2)   
                }
            },

            ivaDecrementPvp(){
                let iva = parseInt(this.stock.tipo_iva)
                    let ivacalculo = ((iva/100)+1)
                if (this.stock.precio >= 0) {
                    this.stock.preciosiva = parseFloat( this.stock.precio / ivacalculo ).toFixed(2)
                }
                else
                {
                    this.stock.precio = parseFloat(0).toFixed(2)   
                    this.stock.preciosiva = parseFloat(0).toFixed(2)   
                }
                
                if (this.stock.preciopvdsiva == 0 || this.stock.preciopvd == 0) {
                    this.stock.preciopvd = 0;
                    this.stock.preciopvdsiva = 0;
                }
                else
                {
                    this.stock.art_profit = 0;
                    this.percentProfit()
                }                
            }, 
            
            percentProfit(){
                    // % IVA
                    // let iva = this.stock.tipo_iva
                    let ivacalculo = ((this.stock.tipo_iva/100)+1)
                    let siva = this.stock.precio / ivacalculo
                    // % categoria
                    // let catprofit = this.catprofit
                    let catprofitcalculo = ((this.catprofit/100)+1)
                    let sivascatego = siva / catprofitcalculo
                    // pvp sin % cat ni % iva
                    let result = sivascatego
                    // calculo % beneficio
                    let benefit =  result * 100 / this.stock.preciopvdsiva
                    this.stock.art_profit = parseFloat( benefit - 100 ).toFixed(2)
            },

            submit() {
            this.formHasErrors = false;
            Object.keys(this.form).forEach((f) => {
                if (!this.form[f]) this.formHasErrors = true;
                    this.$refs[f].validate(true);
                });
                if (!this.formHasErrors) {
                    this.saveItem()
                }
            },
        }
    }
</script>