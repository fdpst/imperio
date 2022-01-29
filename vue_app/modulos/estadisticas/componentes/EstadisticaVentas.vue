<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Estadisticas Ventas</v-toolbar-title>
        </v-toolbar>
        <div class="background my-container">
            <v-row class="mb-2" style="margin: 0 auto; background-color: white; border-radius:30px;" >
                <v-col>
                    <div id="chart" class="ml-4">
                        <apexchart height="300" width="99%" type="line" :options="chartOptions" :series="formattedData"/> 
                    </div>
                </v-col>            
            </v-row>
            <v-data-table :headers="headers" disable-pagination hide-default-footer 
            :items="ventasTotalesData" item-key="id" class="elevation-1 pa-0 mb-0">
                <!-- Total productos -->
                <template v-slot:item.TotalVentaP="{ item }"> 
                    <span>{{item.TotalVentaP | fixed_n}}</span> €
                </template>
                <!-- Total servicios -->
                <template v-slot:item.TotalVentaS="{ item }"> 
                    <span>{{item.TotalVentaS | fixed_n}}</span> €
                </template>
                <!-- Total -->
                <template v-slot:item.Total="{ item }"> 
                    <span>{{item.Total | fixed_n}}</span> €
                </template>        
                <template slot="body.append">
                    <tr>
                        <th style="text-align: start;"><strong>Totales Año</strong></th>
                        <th style="text-align: center;"><strong>{{ sumField('NumP') }} Uds</strong></th>
                        <th style="text-align: center;"><strong>{{ sumField('TotalVentaP') | fixed_n}} €</strong></th>
                        <th style="text-align: center;"><strong>{{ sumField('NumS') }} Uds</strong></th>
                        <th style="text-align: center;"><strong>{{ sumField('TotalVentaS') | fixed_n}} €</strong></th>
                        <th style="text-align: center;"><strong>{{ sumField('TotalArticulos') }} Uds</strong></th>
                        <th style="text-align: center;"><strong>{{ sumField('Total') | fixed_n}} €</strong></th>
                    </tr>
                </template>
            </v-data-table>
        </div>
    </v-container>
</template>

<script>
import VueApexCharts from 'vue-apexcharts';
    export default {
        components: {
            apexchart: VueApexCharts,
        },

        props: {
            chartData: { type: Array, default: () => [] },
            animations: { type: Boolean, default: true }
        },

        data() {
            return {        
                ventasTotalesData: [],     
                rango: 
                {
                    desde: moment().startOf('year').format('Y-MM-DD'),
                    hasta: moment().endOf('year').format('Y-MM-DD'),
                },

                headers: 
                [
                    { text: 'Mes', align: 'left', value: 'Mes', sortable: false },
                    { text: 'Productos Totales', align: 'center', value: 'NumP', sortable: false },
                    { text: 'Total € Productos', align: 'center', value: 'TotalVentaP', sortable: false },
                    { text: 'Servicios Totales', align: 'center', value: 'NumS', sortable: false },
                    { text: 'Total € Servicios', align: 'center', value: 'TotalVentaS', sortable: false },
                    { text: 'Articulos Totales', align: 'center', value: 'TotalArticulos', sortable: false },
                    { text: 'TOTAL Mes', align: 'center', value: 'Total', sortable: false },
                ],
            }
        },
        created() { 
            this.ventasTotales();
        },

        methods: {
            getCategorias() {
                axios.get('api/getcategoriaswithstock').then(res => {
                    this.categorias = res.data
                }, err => {
                    this.$toast.error('Error cargando categorias')
                })
            },

            ventasTotales() {
                axios.get(`api/getventadata/${this.rango.desde}/${this.rango.hasta}`)
                .then(res => {
                    this.ventasTotalesData = res.data;   
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },

            sumField(key) {
                // suma totales por columnas
                return this.ventasTotalesData.reduce((a, b) => a + (b[key] || 0), 0);
            },

        },

        filters: {
            fixed_n(n) {
                return parseFloat(n).toFixed(2)
            }
        },

        computed: {

            chartOptions() {
                return {
                    title: { text: "ESTADISTICA VENTAS", align: "center" },
                    chart: { animations: { enabled: this.animations }, zoom: { autoScaleYaxis: false } },
                    yaxis: { tooltip: { enabled: false }, labels: { formatter: val => val } },
                    markers: ['#000000'],
                    colors: ['#9900ff', '#f44336', '#01b301'],
                    stroke: { width: [4, 4, 0], curve: 'smooth' },
					labels: ['Enero', 'Febrero', 'Marzo', 'Abril','Mayo', 'Junio', 'Julio',
                             'Agosto','Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    plotOptions: { bar: { borderRadius: 10, columnWidth: '40%', borderColor: '#20a020'} },
                    fill: { opacity: [1, 1, 0.4] }
                }
            },

            formattedData() {
                const totalPseries = this.ventasTotalesData.map(d => d.TotalVentaP);
                const totalSseries = this.ventasTotalesData.map(d => d.TotalVentaS);
                const total = this.ventasTotalesData.map(d => d.Total);
                return [
                    { name: "TotalProductos", type: "line", data: totalPseries },
                    { name: "TotalServicios", type: "line", data: totalSseries },
                    { name: "Total", type: "bar", data: total },
                ];
            },
        }
    }

</script>

<style >
    tr{ 
        padding-top: 10px !important;
        padding-bottom: 10px !important;
        height: 33px !important;
    }
</style>