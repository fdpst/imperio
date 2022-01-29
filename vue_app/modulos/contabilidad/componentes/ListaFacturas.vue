<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Estadisticas Ventas Anuales Tickets - Facturas</v-toolbar-title>
        </v-toolbar>
        <div class="background my-container">
            <iframe @load="onLoadIframe" style="display:none;" id="i_print" name="i_print" ref="i_frame" width="500" height="500"></iframe>
            <v-row>
                <v-col class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                <v-sheet shaped>
                        <v-subheader class="pa-0 ma-0 ml-3"><b>Busqueda</b></v-subheader>
                        <v-row>                           
                            <!-- Busqueda -->
                            <v-col class="pt-0 pb-0">                
                                <v-text-field v-model="search" class="ml-3"></v-text-field>
                            </v-col>                        
                            <!-- Fecha Desde -->
                            <v-col class="pt-0 pb-0"> 
                                <v-menu ref="desde" v-model="desde" :close-on-content-click="false" 
                                    transition="scale-transition" offset-y min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="rango.desde" label="Desde" 
                                            append-icon="mdi-calendar" readonly v-bind="attrs" v-on="on">
                                        </v-text-field>
                                    </template>
                                    <v-date-picker v-model="rango.desde" no-title scrollable style="height:410px;">
                                        <v-btn text color="red" @click="desde = false"><strong>Cancelar</strong></v-btn>
                                        <v-btn text color="success" @click="$refs.desde.save(rango.desde)"><strong>OK</strong></v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-col>                        
                            <!-- Fecha Hasta -->
                            <v-col class="pt-0 pb-0"> 
                                <v-menu ref="hasta" v-model="hasta" :close-on-content-click="false"
                                    transition="scale-transition" offset-y min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="rango.hasta" label="Hasta"
                                            append-icon="mdi-calendar" readonly v-bind="attrs" v-on="on">
                                        </v-text-field>
                                    </template>
                                    <v-date-picker v-model="rango.hasta" no-title scrollable style="height:410px;">
                                        <v-btn text color="red" @click="hasta = false"><strong>Cancelar</strong></v-btn>
                                        <v-btn text color="success" @click="$refs.hasta.save(rango.hasta)"><strong>OK</strong></v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-col>
                            <!-- Boton buscar rango mes actual y limpiar Rango -->
                            <v-col class="pt-0 pb-0"> 
                                <v-btn-toggle style="background-color: transparent !important;">
                                    <v-btn @click="buscarRango()" title="BUSCAR">
                                        <v-icon class="black--text">mdi-magnify</v-icon>
                                    </v-btn>
                                    <v-btn @click="clean" title="MES ACTUAL">
                                        <v-icon class="purple--text">mdi-recycle</v-icon>
                                    </v-btn>
                                </v-btn-toggle>
                            </v-col>
                        </v-row>
                    </v-sheet>
                </v-col>
                
                <v-col class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-1">
                <!-- FILTRAR Facturas Tickets -->
                    <v-sheet shaped width="145" class="ml-6">
                        <v-col class="pt-0 pb-0 ml-2"> 
                            <v-subheader class="pa-0 ma-0 ml-3"><b>Filtros</b></v-subheader>
                            <v-btn-toggle class="ml-1 mb-3" style="background-color: transparent !important;">
                                <v-btn @click="getFacturas()" raised title="FACTURAS">
                                    <v-icon class="orange--text">mdi-file-account</v-icon>
                                </v-btn>           
                                <v-btn @click="getTickets()" raised title="TICKETS">
                                    <v-icon class="blue--text">mdi-cash-register</v-icon>
                                </v-btn>
                            </v-btn-toggle>
                        </v-col>
                    </v-sheet>
                </v-col>

                <v-col class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-1 offset-xs-1 offset-sm-1">
                <!-- Exportar PDF - EXCEL -->
                    <v-sheet shaped width="190" class="ml-1">
                        <v-col class="pt-0 pb-0 ml-2"> 
                            <v-subheader class="pa-0 ma-0 ml-3"><b>Exportar</b></v-subheader>
                            <v-btn-toggle class="ml-1 mb-3" style="background-color: transparent !important;">
                                <v-btn @click="generaInforme()" raised title="PFD">
                                    <v-icon class="red--text">mdi-file-pdf</v-icon>
                                </v-btn>           
                                <v-btn raised title="EXCEL">
                                    <v-icon class="green--text">mdi-file-excel</v-icon>
                                </v-btn>           
                                <v-btn raised title="ZIP">
                                    <v-icon class="purple--text">mdi-floppy</v-icon>
                                </v-btn>
                            </v-btn-toggle>
                        </v-col>
                    </v-sheet>
                </v-col>
                
                <!-- Total -->
                <v-col class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-1 offset-xs-1 offset-sm-1">
                    <v-col class="pt-0 pb-0 ml-2">
                        <v-sheet color="green accent-2" shaped class="py-2 px-4 mb-2 mt-3" width="145">
                            <v-text-field prefix="€" :value="total | fixed_n" label="Total" readonly class="font-weight-bold"></v-text-field>
                        </v-sheet>
                    </v-col>
                </v-col>
            </v-row>

            <v-data-table class="elevation-1 mt-4 col-12"
                :headers="headers" :search="search" :items-per-page="20" :items="indexedItems" item-key="id">
                <!-- Total iva --> 
                <template v-slot:item.iva="{ item }"> 
                    <span>{{item.iva | fixed_n}}</span> €
                </template>
                <!-- Total precio -->
                <template v-slot:item.precio="{ item }"> 
                    <span>{{item.precio | fixed_n}}</span> €
                </template>
                <!-- Url ticket o factura PDF o ambos -->
                <template v-slot:item.url="{ item }" > 
                    <div v-if="item.url_factura && !item.url_ticket">
                        <a target="_blank" :href="`archivos/facturas/${item.url_factura}`">
                        <v-icon medium color="orange" class="mr-2">
                            mdi-file-account
                        </v-icon>
                    </a>
                    </div>
                    <div v-else-if="item.url_ticket && !item.url_factura" >
                        <a target="_blank" :href="`archivos/tickets/${item.url_ticket}`">
                            <v-icon medium color="blue" class="mr-2">
                                mdi-cash-register
                            </v-icon>
                        </a>
                    </div>
                    <div v-else>
                        <a target="_blank" :href="`archivos/facturas/${item.url_factura}`">
                            <v-icon medium color="orange" class="mr-2">
                                mdi-file-account
                            </v-icon>
                        </a>
                        <a target="_blank" :href="`archivos/tickets/${item.url_ticket}`">
                            <v-icon medium color="blue" class="mr-2">
                                mdi-cash-register
                            </v-icon>
                        </a>
                    </div>
                </template>
                <!-- Id cliente -->
                <template v-slot:item.cliente="{ item }"> 
                    <span v-if="item.cliente_id">{{item.cliente.nombre}}</span>
                </template>
                <!-- Convierte ticket a factura  -->
                <template v-slot:item.generar_factura="{ item }">
                    <!-- Existe cliente -->
                    <template v-if="item.cliente">
                        <v-icon v-if="!item.nro_factura" @click="generarFactura(item)" medium color="success" class="mr-2">
                            mdi-clipboard-arrow-up-outline
                        </v-icon>
                    </template>
                    <!-- NO Existe cliente -->
                    <template v-if="item.cliente == null && !item.url_factura">
                        <v-icon medium color="primary" @click="selectCliente(item)" class="mr-2">
                            mdi-account-circle
                        </v-icon>
                    </template>
                </template>
                <!-- Editar y Eliminar  --> 
                <template v-slot:item.position="{item}"> 
                    <router-link :to="{ path: `/editar-factura?id=${item.id}` }" class="action-buttons" v-if="item.position == 0 && item.nro_f">
                        <v-icon small class="mr-2">
                            mdi-pencil
                        </v-icon>
                    </router-link>
                    <v-icon small @click="setItem(item)" v-if="item.position == 0" medium color="red" class="mr-2">
                        mdi-delete
                    </v-icon>
                </template> 
            </v-data-table>

            <confirm-dialog 
                :confirm_dialog="confirm_dialog" :tipo="tipo" :texto="texto" 
                @eliminar="eliminar" @close_dialog="confirm_dialog = false">
            </confirm-dialog>

            <cliente-component 
                @seleccionar_cliente="seleccionarCliente" 
                @close_dialog="dialog = false" :dialog="dialog">
            </cliente-component>
        </div>
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
                data: null,
                tipo: '',
                texto:'',
                lista: [],
                search: '', 
                facturas: [],
                desde: false,
                hasta: false,
                dialog: false,
                confirm_dialog: false,
                rango: 
                {
                    desde: moment().startOf('month').format('Y-MM-DD'),
                    hasta: moment().endOf('month').format('Y-MM-DD'),
                },
                headers: 
                [
                    { text: 'Nro Ticket', align: 'center', value: 'nro_t', sortable: false },
                    { text: 'Nro Factura', align: 'center', value: 'nro_f', sortable: false },
                    { text: 'Fecha', value: 'created_at', align: 'center', sortable: false },
                    { text: 'IVA', value: 'iva', align: 'center', sortable: false },
                    { text: 'TOTAL', value: 'total', align: 'center', sortable: false },
                    { text: 'PDF Factura / Ticket', value: 'url', align: 'center', sortable: false },
                    { text: 'Cliente', value: 'cliente', align: 'center', sortable: false },
                    { text: 'Crear factura', value: 'generar_factura', align: 'center', sortable: false },
                    { text: 'Acciones', value: 'position', align: 'center', sortable: false }
                ],
            }
        },

        mounted() {
            this.buscarRango();
        },

        methods: {

            onLoadIframe(data) {
                if (this.data) {
                    let i = document.getElementById("i_print")
                    i.contentWindow.print()
                }                
            },

            generaInforme() {
                let data = this.lista;
                axios.post(`api/generar-informe/${this.rango.desde}/${this.rango.hasta}`, data).then(res => {
                    this.data = res.data;
                    this.$toast.sucs('Informe Generado')
                    const i_frame = this.$refs.i_frame
                    i_frame.src = `archivos/reportes/${res.data}`
                }, 
                res => {
                    this.$toast.error('Error generando informe')
                })

            },

            buscarRango() {
                if (this.rango.desde == null || this.rango.hasta == null) {
                    this.$toast.warn('Formato de fecha es incorrecto')
                    return null
                }
                axios.get(`api/getFacturasfechas?desde=${this.rango.desde}&hasta=${this.rango.hasta}`)
                .then(res => {
                    this.facturas = res.data;
                    this.lista = [];
                    this.facturas.forEach(fac => {
                        this.lista.push(fac)
                    });
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },

            getFacturas() {
                this.lista = [];
                    this.facturas.forEach(fac => {
                        this.lista.push(fac)
                    });
                if (this.facturas) {
                    this.facturas.forEach(element => {
                        if ( element.cliente_id == null ) {
                            this.lista.splice( (this.lista.indexOf(element)) ,1)
                        }
                    });
                }
                else
                {
                    this.$toast.error('Error al obtener Facturas')
                }                    
            },
            
            getTickets() {
                this.lista = [];
                    this.facturas.forEach(fac => {
                        this.lista.push(fac)
                    });
                if (this.facturas) {
                    this.facturas.forEach(element => {
                        if ( element.cliente_id) {
                            this.lista.splice( (this.lista.indexOf(element)) ,1)
                        }
                    });
                }
                else
                {
                    this.$toast.error('Error al obtener Tickets')
                }                      
            },

            eliminar(){
                if (this.tipo == 'contabilidadFactura') {
                    this.eliminarFactura();
                }
                else
                {
                    this.deleteTicket();
                }
            },

            eliminarFactura() {
                axios.get(`api/deletefactura/${this.factura.id}`).then(res => {
                    this.$toast.sucs('Factura borrada')

                    this.facturas.splice(this.facturas.indexOf(this.factura),1)

                    this.confirm_dialog = false
                    this.buscarRango();
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },

            deleteTicket() {
                axios.get(`api/deleteticket/${this.factura.id}`).then(res => {
                    this.$toast.sucs('Ticket eliminado')

                    this.facturas.splice(this.facturas.indexOf(this.factura),1)
                    this.confirm_dialog = false
                    this.buscarRango();
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },

            clean(){
                this.rango.desde = moment().startOf('month').format('Y-MM-DD');
                this.rango.hasta = moment().endOf('month').format('Y-MM-DD');
                this.buscarRango();
            },

            generarFactura(item) {
                axios.post(`api/generar-factura/${item.nro_ticket.id}/${this.factura.cliente.id}`).then(res => {
                    let found_index = this.facturas.findIndex(x => x.id == item.id);
                    this.$set(this.facturas, found_index, res.data.ticket)
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },

            selectCliente(item) {
                this.dialog = true
                this.factura = item
            },

            seleccionarCliente(data) {
                this.dialog = false
                this.factura.cliente = data
            },

            setItem(item) {
                if (item.nro_f) {
                    this.tipo = 'contabilidadFactura';
                    this.texto = '¿Desea eliminar esta factura?';                    
                }
                else
                {
                    this.tipo = 'contabilidadTicket';
                    this.texto = '¿Desea eliminar este ticket?';
                }
                this.factura = item
                this.confirm_dialog = true
            }
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

            total: function() {
                return this.lista.reduce((acc, x) => {
                    console.log(this.lista)
                    return acc + parseFloat(x.total)
                }, 0)
            },

            indexedItems() {
                return this.lista.map((item, index) => ({
                    position: index,
                    ...item
                }))
            }
        }
    }
</script>

<style>
    .v-input {
        font-weight: 700;
    }
    
    td{ 
        padding-top: 5px !important;
        height: 30px !important;
    }

</style>