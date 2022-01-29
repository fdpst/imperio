<template>

    <v-container>

        <loader v-if="isloading"></loader>

        <v-card class="mx-auto">

            <v-toolbar flat color="light-blue lighten-2" dark>
                <v-toolbar-title v-html="$route.query.tipo ? 'Crear Factura' : 'Editar Factura'"></v-toolbar-title>
            </v-toolbar>

            <v-container fluid>
                <v-row dense>
                    <v-col v-if="!$route.query.tipo" cols="12" md="2">
                        <v-text-field disabled label="Nro Factura" v-model="factura.nro_f"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-text-field disabled label="Neto" v-model="factura.total_sin_descuento"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-text-field disabled v-model="factura.descuento"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-text-field type="number" min="1" max="99" label="Descuento (%)" v-model="factura.porcentaje_descuento"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-text-field disabled label="IVA" v-model="factura.iva"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-text-field disabled label="Total" v-model="factura.total"></v-text-field>
                    </v-col>
                </v-row>

                <v-row dense>

                    <v-col cols="12" md="2">
                        <v-text-field disabled label="IVA" :value="total_productos.total_iva | fixed_n"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-text-field disabled label="Total" :value="total_productos.total | fixed_n"></v-text-field>
                    </v-col>

                </v-row>

                <v-divider></v-divider>

                <v-row align="center">

                    <v-col cols="12" md="2">
                        <v-text-field disabled label="CIF" v-model="factura.cliente.dni"></v-text-field>
                    </v-col>

                    <v-col cols="12" md="3">
                        <v-text-field disabled label="Nombre" v-model="factura.cliente.nombre"></v-text-field>
                    </v-col>

                    <v-col cols="12" md="5">
                        <v-text-field disabled label="Direccion" v-model="factura.cliente.direccion"></v-text-field>
                    </v-col>

                    <v-col cols="12" md="1">
                        <v-btn small color="warning" @click="dialog = true">
                            <v-icon>mdi-account-circle</v-icon>
                        </v-btn>
                    </v-col>

                </v-row>

                <v-row dense>
                    <v-col cols="12">
                        <v-btn v-if="!$route.query.tipo" :disabled="isloading || factura.cliente_id == null" @click="editarFactura" class="white--text" color="success">
                            guardar
                        </v-btn>
                        <v-btn v-if="!$route.query.tipo" :disabled="isloading || factura.cliente_id == null" @click="volver" class="white--text" color="primary">
                            volver
                        </v-btn>

                        <v-btn v-if="$route.query.tipo" :disabled="isloading" @click="editarFactura" class="white--text" color="primary">
                            crear factura
                        </v-btn>

                        <v-btn v-if="nombre_archivo" :disabled="isloading" target="_blank" :href="`archivos/facturas/${nombre_archivo}`" class="white--text" color="warning">
                            Imprimir
                        </v-btn>

                    </v-col>

                </v-row>

            </v-container>

        </v-card>

        <v-card class="mx-auto mt-8">
            <v-container fluid>

                <v-row dense>
                    <v-col cols="12" md="2">
                        <v-select v-model="categoria" :items="categorias" return-object item-text="nombre" label="Categoria"></v-select>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-select @change="setProducto" :items="categoria.stock" return-object item-text="nombre" label="Productos"></v-select>
                    </v-col>
                    <v-col cols="12" md="1">
                        <v-text-field disabled label="Total" :value="total_productos.total | fixed_n"></v-text-field>
                    </v-col>
                </v-row>


                <v-data-table :headers="headers" disable-pagination hide-default-footer :items="factura.productos" item-key="id">

                    <template v-slot:item.descripcion="{ item }">
                        <span v-bind:class="{ new: !item.id }">{{item.descripcion}}</span>
                    </template>

                    <template v-slot:item.cantidad="{ item }">
                        <v-text-field type="number" step="1" v-model="item.cantidad"></v-text-field>
                    </template>

                    <template v-slot:item.action="{ item }">

                        <v-icon @click="eliminarProducto(item)" medium color="red" class="mr-2">
                            mdi-delete
                        </v-icon>

                    </template>

                </v-data-table>

            </v-container>
        </v-card>

        <cliente-component @seleccionar_cliente="seleccionarCliente" @close_dialog="dialog = false" :dialog="dialog"></cliente-component>

    </v-container>

</template>

<script>
    import clienteComponent from '../../factura/componentes/clienteComponent'

    export default {
        components: {
            clienteComponent,
        },
        data() {
            return {
                dialog: false,
                confirm_dialog: false,
                factura: {
                    cliente: {},
                    productos: []
                },
                categorias: [],
                categoria: {
                    stock: []
                },
                nombre_archivo: null,
                headers: [{
                        text: 'Descripción',
                        align: 'left',
                        value: 'descripcion',
                    },
                    {
                        text: 'Precio',
                        value: 'precio_unitario',
                    },
                    {
                        text: 'Cantidad',
                        value: 'cantidad',
                        width: '10'
                    },
                    {
                        text: '',
                        value: 'action',
                        sortable: false
                    },
                ],
            }
        },

        created() {
            this.getCategorias()
            this.$route.query.id ? this.getFactura(this.$route.query.id) : null
        },

        methods: {
            getFactura(factura_id) {
                axios.get(`api/getfacturabyid/${factura_id}`).then(res => {
                    this.factura = res.data
                    this.factura.productos = this.factura.productos.map(x => {
                        return {
                            precio_unitario: x.total / x.cantidad,
                            ...x
                        }
                    })
                }, res => {
                    this.$toast.error('Error obteniendo factura')
                })
            },

            setTotales() {
                this.nombre_archivo = null
                this.factura.total_sin_descuento = parseFloat(this.total_productos.total_sin_descuento).toFixed(2)
                this.factura.sub_total = parseFloat(this.total_productos.sub_total).toFixed(2)
                this.factura.iva = parseFloat(this.total_productos.total_iva).toFixed(2)
                this.factura.total = parseFloat(this.total_productos.total).toFixed(2)
                let descuento = parseFloat(this.total_productos.total_sin_descuento) - parseFloat(this.total_productos.total)
                this.factura.descuento = parseFloat(descuento).toFixed(2)
            },

            editarFactura() {
                this.setTotales()
                axios.post(`api/editar-factura/${this.factura.id}`, this.factura).then(res => {
                    this.$toast.sucs('Factura guardada con exito')
                    this.nombre_archivo = res.data
                }, res => {
                    this.$toast.error('Error editando factura')
                })
            },

            volver(){
                this.$router.push('/lista-facturas')
            },

            /*crearFactura() {
                axios.post(`api/crear-factura/${this.factura.id}`, this.factura).then(res => {
                    this.$toast.sucs('Factura guardada con exito')
                    this.nombre_archivo = res.data
                }, res => {
                    this.$toast.error('Error editando factura')
                })
            },*/

            eliminarProducto(producto) {
                this.factura.productos.splice(this.factura.productos.indexOf(producto), 1)
            },
            getCategorias() {
                axios.get('api/getcategoriaswithstock').then(res => {
                    this.categorias = res.data
                }, res => {
                    this.$toast.error('Error cargando categorias')
                })
            },
            seleccionarCliente(cliente) {
                this.factura.cliente = cliente
                this.factura.cliente_id = cliente.id
                this.dialog = false
            },
            setProducto(producto) {
                let producto_object = {
                    precio_unitario: producto.precio,
                    venta_id: this.factura.id,
                    producto_id: producto.id,
                    descripcion: producto.nombre,
                    cantidad: 1,
                    total: 0,
                    tipo_iva: producto.tipo_iva,
                }

                let item = this.factura.productos.find(x => x.producto_id == producto_object.producto_id)

                if (!item) {
                    this.factura.productos.unshift(producto_object)
                } else {
                    this.$toast.warn('Producto ya esta agregado')
                }
            }
        },

        filters: {
            fixed_n(val) {
                return val.toFixed(2)
            }
        },

        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },

            total_productos() {
                return this.factura.productos.reduce((acc, element) => {

                    let total_item = element.precio_unitario * element.cantidad

                    let precio = (this.factura.porcentaje_descuento > 0) ? total_item - (total_item * this.factura.porcentaje_descuento / 100) : total_item

                    let i = (element.tipo_iva / 100) + 1

                    let iva = precio - (precio / i)

                    let sub_total = precio / i;

                    return {
                        total_sin_descuento: acc.total_sin_descuento + total_item,
                        sub_total: acc.sub_total + sub_total,
                        total_iva: acc.total_iva + iva,
                        total: acc.total + precio
                    }
                }, {
                    total_sin_descuento: 0,
                    sub_total: 0,
                    total_iva: 0,
                    total: 0
                })
            }
        }
    }
</script>

<style media="screen">
    .new {
        color: #51b757;
        font-weight: 700 !important;
    }
</style>