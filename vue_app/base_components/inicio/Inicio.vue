<template>
    <v-container>
        <v-row color="grey lighten-4">
            <v-col v-for="item in items" :key="item.text" cols="12" md="4">
                <div class="my-card">
                    <v-card :to="{path: item.path}" class="mx-auto justify-center">

                        <v-card-title class="justify-center">
                            <span class="title font-weight-light grey--text text--darken-1 text-uppercase">{{item.text}}</span>
                        </v-card-title>

                        <v-card-text class="headline font-weight-bold justify-center text-center">
                            <v-icon color="light-blue lighten-2" large center justify-center class="justify-center">
                                {{item.icon}}
                            </v-icon>
                        </v-card-text>
                    </v-card>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                items: [{
                        path: '/prueba-factura',
                        icon: 'mdi-cash-register',
                        text: 'POS',
                    },
                    {
                        path: '/lista-presupuestos',
                        icon: 'mdi-file-document-outline',
                        text: 'Presupuestos',
                    },
                    {
                        path: '/lista-servicios',
                        icon: 'mdi-cube-outline',
                        text: 'Servicios',
                    },
                    {
                        path: '/lista-stock',
                        icon: 'mdi-cube-outline',
                        text: 'Stock',
                    },
                    {
                        path: '/citas-peluqueria?tipo=peluqueria',
                        icon: 'mdi-account',
                        text: 'Calendario',                        
                    },
                    {
                        path: '/lista-clientes',
                        icon: 'mdi-account-group',
                        text: 'Clientes',
                    },  
                    {
                        path: '/lista-tiendas-app',
                        icon: 'mdi-account',
                        text: 'tiendas app',
                    },                  
                    {
                        path: '/lista-empleados-app',
                        icon: 'mdi-account',
                        text: 'empleados app',
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
                        path: '/lista-albaranes',
                        icon: 'mdi-clipboard-text-outline',
                        text: 'Albaranes',
                    },
                    {
                        path: '/tipo-iva',
                        icon: 'mdi-percent',
                        text: 'IVA',
                    },
                    {
                        path: '/lista-categoria',
                        icon: 'mdi-cube-scan',
                        text: 'Categoria',
                    },
                    {
                        path: '/lista-empresas',
                        icon: 'mdi-store',
                        text: 'Empresas',
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
                        text: 'Información',
                    },
                ]
            }
        },
        methods: {

        }
    }
</script>

<style>
    .my-card {
        transition: all 0.5s;
    }

    .v-card {
        transition: all 0.5s;
    }

    .my-card:hover .v-card {
        background-color: #59fee2 !important;
    }

    .my-card:hover .v-card .v-card__text i {
        color: #000 !important;
    }

    .my-card:hover .v-card .v-card__title span {
        color: #000 !important;
        font-weight: bold !important;
    }

    .my-card .v-card .v-card__text i {
        color: #50e4cb !important;
    }

    .my-card .v-card .v-card__title span {
        color: #000 !important;
    }
</style>