<template>
    <v-list dense nav>

        <v-list-item :to="{path: '/'}">
            <v-list-item-icon>
                <v-icon color="black">mdi-home</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
                <v-list-item-title class="black--text">Inicio</v-list-item-title>
            </v-list-item-content>
        </v-list-item>

        <template v-if="$route.path !== '/'">

            <v-list-item v-for="item in items" :key="item.path" :to="{path: item.path}">
                <v-list-item-icon>
                    <v-icon color="black">{{item.icon}}</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title class="black--text" v-html="item.text"></v-list-item-title>
                </v-list-item-content>
            </v-list-item>

        </template>


    </v-list>
</template>

<script>
    export default {
        data() {
            return {
                items: [
                     {
                        path: '/citas-peluqueria?tipo=peluqueria',
                        icon: 'mdi-calendar-check',
                        text: 'Calendario',                        
                    },
                    {
                        path: '/prueba-factura',
                        icon: 'mdi-cash-register',
                        text: 'POS',
                    },
                    {
                        path: '/lista-clientes',
                        icon: 'mdi-account-group',
                        text: 'Clientes',
                    },
                    
                    {
                        path: '/lista-servicios',
                        icon: 'mdi-file-document-box-outline',
                        text: 'Servicios',
                        
                    },
                    /*{
                        path: '/lista-servicios',
                        icon: 'mdi-cube-outline',
                        text: 'Servicios',
                    },*/
                    {
                        path: '/lista-stock',
                        icon: 'mdi-cube-outline',
                        text: 'Productos',
                    },
                    {
                        path: '/lista-categoria',
                        icon: 'mdi-cube-scan',
                        text: 'Categorias',
                    },
                     {
                        path: '/tipo-iva',
                        icon: 'mdi-percent',
                        text: 'IVA',
                    },
                   
                    
                    {
                        path: '/lista-tiendas-app',
                        icon: 'mdi-store',
                        text: 'Tiendas',
                    },
                    {
                        path: '/lista-empleados-app',
                        icon: 'mdi-account',
                        text: 'Empleados',
                    },
                    /*{
                        path: '/lista-empleados',
                        icon: 'mdi-account-box',
                        text: 'Empleados',
                    },*/
                    {
                        path: '/vacaciones-empleado',
                        icon: 'mdi-calendar-today',
                        text: 'Vacaciones',
                    },
                                     
                    {
                        path: '/lista-empresas',
                        icon: 'mdi-clipboard-account',
                        text: 'Empresas',
                    },
                     {
                        path: '/lista-albaranes',
                        icon: 'mdi-clipboard-text-outline',
                        text: 'Albaranes',
                    },
                   {
                        path: '/lista-presupuestos',
                        icon: 'mdi-file-document-outline',
                        text: 'Presupuestos',
                    },
                    {
                        path: '/contabilidad',
                        icon: 'mdi-cash-multiple',
                        text: 'Contabilidad',
                    },
                    {
                        path: '/estadisticas',
                        icon: 'mdi-chart-line-stacked',
                        text: 'Estadísticas',
                    },
                    {
                        path: '/informacion-legal',
                        icon: 'mdi-information-outline',
                        text: 'Info. Empresa',
                    },
                ]
            }
        }
    }
</script>
<style media="screen">
    .v-list-item--active {
        background-color: #59fee2 !important;
    }
</style>
