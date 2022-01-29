<template>
    <v-container class="pa-0">
        <iframe @load="onLoadIframe" style="display:none;" id="i_print" name="i_print" ref="i_frame" width="500" height="500"></iframe>
        <div class="pos-container">
            <div class="products-container">
                <grid-menu v-if="menu"
                    @mostrar_menucategoria="mostrarMenucategoria"
                    @mostrar_barcode="mostrarBarcode">
                </grid-menu>
                <barcodescaner v-if="menuBarcode"
                    :items="items" 
                    @agregar_producto="agregarProducto"
                    @unselect_menu="unselectMenu"
                    @unselect_categoria="unselectCategoria">
                </barcodescaner>
                <grid-categorias v-if="menuCategoria" 
                    :categorias="categorias"
                    @categoria_selected="categoriaSelected"
                    @unselect_menu="unselectMenu">
                </grid-categorias>
                <grid-productos v-if="categoria_selected.id"
                    :categoria_selected="categoria_selected"
                    @agregar_producto="agregarProducto"
                    @unselect_categoria="unselectCategoria"
                    @mostrar_barcode="mostrarBarcode">
                </grid-productos>
            </div>
            <div class="list-container">
                <div class="lista-productos">
                    <cabecera-component :cliente="cliente"></cabecera-component>
                    <lista-productos @delete_item="deleteItem" :items="items" @clear_all="clearAll"></lista-productos>
                </div>
                <div class="info-sale pa-0">
                    <ticket-component 
                        @clear_all="clearAll" :cliente="cliente" :items="items" @crear_presupuesto="CrearPresupuesto"
                        @crear_factura="crearFactura" @ocultar_botones="ocultarBotones" :muestraBotones="muestraBotones"
                        @open_descuento="descuento_dialog = true" @open_cliente="dialog = true" :descuento="descuento" >
                    </ticket-component>
                    <cliente-component @seleccionar_cliente="seleccionarCliente" @close_dialog="dialog = false" :dialog="dialog"></cliente-component>
                    <descuento-component 
                        @aplicar_descuento="aplicarDescuento" @close_descuento_dialog="descuento_dialog = false" 
                        :descuento_dialog="descuento_dialog">
                    </descuento-component>
                </div>
            </div>
        </div>
    </v-container>
</template>

<script>
    import clienteComponent from './clienteComponent'
    import ticketComponent from './ticketComponent'
    import descuentoComponent from './descuentoComponent'
    import gridProductos from './gridProductos'
    import gridCategorias from './gridCategorias'
    import gridMenu from './gridMenu'
    import barcodescaner from './barcodescaner'
    import listaProductos from './listaProductos'
    import cabeceraComponent from './cabeceraComponent'
    
    export default {
        components: {
            clienteComponent,
            gridProductos,
            listaProductos,
            ticketComponent,
            descuentoComponent,
            gridCategorias,
            barcodescaner,
            gridMenu,
            cabeceraComponent
        },
        data() {
            return {
                dialog: false,
                descuento_dialog: false,
                cliente: {},
                productos: [],
                items: [],
                descuento: 0,
                url_factura: null,
                categorias: [],
                categoria_selected: {},
                menu: true,
                menuCategoria: false,
                menuBarcode: false,
                muestraBotones: false
            }
        },

        created() {
            this.getCategorias()
            this.getServicios()
        },

        methods: {
            getCategorias() {
                axios.get('api/getcategoriaswithstock').then(res => {
                    this.categorias = res.data
                }, err => {
                    this.$toast.error('Error cargando categorias')
                })
            },

            getServicios() {
                axios.get('api/getservicioswithstock').then(res => {
                    this.servicios = res.data
                }, err => {
                    this.$toast.error('Error cargando servicios')
                })
            },

            categoriaSelected(categoria) {
                this.categoria_selected = categoria
                this.menuCategoria = false
                this.menuBarcode = false
            },

            unselectCategoria() {
                this.categoria_selected = {}
                this.menuCategoria = true
                this.menuBarcode = false
            },

            unselectMenu() {
                this.categoria_selected = {}
                this.menuCategoria = false
                this.menuBarcode = false
                this.menu = true
            },

            seleccionarCliente(cliente) {
                this.cliente = cliente
                this.dialog = false
            },

            agregarProducto(producto) {
                let item = this.items.find(x => x.id == producto.id)
                if (!item) {
                    this.items.push(producto)
                }
            },

            aplicarDescuento(descuento) {
                this.descuento = descuento
                this.descuento_dialog = false
            },

            onLoadIframe(data) {
                if (this.url_factura) {
                    let i = document.getElementById("i_print")
                    i.contentWindow.print()
                    //Al terminar el proceso de creacion de factura limpiamos vista
                    this.clearAll()  
                }                
            },

            crearFactura(totales) {
                let data = {
                    totales: totales,
                    productos: this.items,
                    cliente: this.cliente
                }
                axios.post(`api/generar-ticket/${totales.tipo}`, data).then(res => {
                    this.url_factura = res.data
                    const i_frame = this.$refs.i_frame
                    let tipo = `${totales.tipo}s`
                    i_frame.src = `archivos/${tipo}/${res.data}`
                }, 
                res => {
                    this.$toast.error('Error generando ticket')
                })
            },

            CrearPresupuesto(totales) {
                let data = {
                    totales: totales,
                    productos: this.items,
                    cliente: this.cliente
                }
                axios.post(`api/guardar-presupuesto`, data).then(res => {
                    this.url_factura = res.data
                    const i_frame = this.$refs.i_frame
                    i_frame.src = `archivos/presupuestos/${res.data}`
                },
                res => {
                    this.$toast.error('Error generando ticket')
                })
            },

            clearAll() {
                this.items.forEach(item => {
                    item.numero = 0 
                    item.cantidad = item.numero + item.cantidad
                });
                this.cliente = {}
                this.descuento = 0
                this.productos = []
                this.items = []
                this.getCategorias()
            },

            deleteItem(item) {
                let i = this.items.indexOf(item)
                this.items.splice(i, 1)
                if( this.items.length == 0 ){
                    this.ocultarBotones(false)
                }
            },

            mostrarMenucategoria(vista) {
                this.menuCategoria = vista
                this.menu = false
            },

            mostrarBarcode(vista) {
                this.menuBarcode = vista
                this.menu = false
                this.menuCategoria = false
            },

            ocultarBotones(estado) {
                this.muestraBotones = estado
            },
        }
    }
</script>

<style media="screen">
@media (min-width:960px) and (max-width:1264px){
    .container {
        width: 98% !important;
        max-width: 98%;
    }
}

@media (min-width:1265px) and (max-width:2560px){

    html{
        background-color: #efeeee;
    }

    .container {
        width: 99% !important;
        max-width: 99%;
        max-height: 100%;
    }

    .pos-container {
        display: flex;
        height: 89vh;
        max-height: 89vh;
        border-radius: 7px;
    }

    .pos-container .products-container {
        width: 76%;
        border-radius: 7px;
        height: 100% !important;
        overflow-y: scroll;
    }

    .pos-container .list-container {
        width: 24%;
        background-color: #ffffff;
        border-radius: 7px;
        height: 100%;
    }

    .pos-container .list-container .lista-productos {
        height: 68%;
        overflow-y: scroll;
    }

    .info-sale {
        background-color: #536d7a;
        height: 32%;
    }
}
</style>