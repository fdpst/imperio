<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Estadisticas Servicios</v-toolbar-title>
        </v-toolbar>
        <div class="background my-container">
            <v-row class="px-0">
                <v-col class="col-md-6">
                    <div id="chart" class="py-2 my-2" style="background-color: white; border-radius:30px;">
                        <apexchart width="650" height="370" type="pie" :options="chartOptions" :series="formattedData"></apexchart>
                    </div>
                </v-col>       
                    <v-col class="col-md-6 py-0 mt-4">
                        <v-data-table :headers="headers2" :items="categoData" item-key="id" 
                        :items-per-page="8" class="elevation-1">
                            <!-- Total -->
                            <template v-slot:item.TotalVentaCategoria="{ item }"> 
                                <span>{{item.TotalVentaCategoria | fixed_n}}</span> €
                            </template>
                            <template slot="body.append">
                                <tr>
                                    <th style="text-align: left;"><strong>Totales Categoria</strong></th>
                                    <th style="text-align: center;"><strong>{{ sumFields('CantidadCategoria')}} Uds</strong></th>
                                    <th style="text-align: center;"><strong>{{ sumFields('TotalVentaCategoria') | fixed_n}} €</strong></th>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-col>
            </v-row>
            <div>
                <v-col class="col-md-12 py-0 mt-4">
                    <v-data-table :headers="headers" :items="serviceData" item-key="id" 
                    :items-per-page="8" class="elevation-1 pa-0 ma-0 mt-4">
                    <!-- Total -->
                    <template v-slot:item.TotalVentaServicio="{ item }"> 
                        <span>{{item.TotalVentaServicio | fixed_n}}</span> € 
                    </template>        
                    <template slot="body.append">
                        <tr >
                            <th style="text-align: start;"><strong>Totales Productos</strong></th>
                            <th style="text-align: center;"><strong>{{ sumField('CantidadProducto') }} Uds</strong></th>
                            <th style="text-align: center;"><strong>{{ sumField('TotalVentaServicio') | fixed_n}} €</strong></th>
                        </tr>
                    </template>
                    </v-data-table>
                </v-col>
            </div>
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
    },
    
    data() {
        return {       
            serviceData: [],  
            categoData: [],  
            label: [],  
            rango: 
            {
                desde: moment().startOf('year').format('Y-MM-DD'),
                hasta: moment().endOf('year').format('Y-MM-DD'),
            },

            headers: 
            [
                { text: 'Producto', align: 'left', value: 'NombreProducto', sortable: false },
                { text: 'Productos Totales', align: 'center', value: 'CantidadProducto', sortable: true },
                { text: 'Total € Productos', align: 'center', value: 'TotalVentaServicio', sortable: true }
            ],
            headers2: 
            [
                { text: 'Categoria', align: 'left', value: 'NombreCategoria', sortable: false },
                { text: 'Cantidad', align: 'center', value: 'CantidadCategoria', sortable: true },
                { text: 'Total Categoria', align: 'center', value: 'TotalVentaCategoria', sortable: true },
            ],
        }
    },

    mounted() { 
        this.getServiceData();
        this.getCategoData();
    },

    methods: {
        getCategorias() {
            axios.get('api/getcategoriaswithstock').then(res => {
                this.categorias = res.data
            }, err => {
                this.$toast.error('Error cargando categorias')
            })
        },

        getServiceData() {
            axios.get(`api/getserviciodata/${this.rango.desde}/${this.rango.hasta}`)
            .then(res => {
                this.serviceData = res.data;
            }, err => {
                this.$toast.error('Error al obtener Datos')
            })
        },

        getCategoData() {
            axios.get(`api/getcategoservdata/${this.rango.desde}/${this.rango.hasta}`)
            .then(res => {
                this.categoData = res.data;
            }, err => {
                this.$toast.error('Error al obtener Datos')
            })
        },

        sumField(key) {
            // suma totales por columnas
            return this.serviceData.reduce((a, b) => a + (b[key] || 0), 0);
        },

        sumFields(key) {
            // suma totales por columnas
            return this.categoData.reduce((a, b) => a + (b[key] || 0), 0);
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
                title: { text: "ESTADISTICA SERVICIOS", align: "center" },
                colors: ['#FF0000','#800000','#F39C12','#808000','#2ECC71','#008000',
                        '#3498DB','#008080','#0000FF','#000080','#FF00FF','#800080'],
                labels: this.label,
                legend: { offsetX: -40, offsetY: 50 },
                plotOptions: { pie: { customScale: 0.9 } },
            }
        },

        formattedData() {
            this.label = this.categoData.map(d => d.NombreCategoria);
            return this.categoData.map(d => d.TotalVentaCategoria);
        },
    }
}
</script>