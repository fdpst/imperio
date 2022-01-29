<template>
    <v-container>

        <v-row>

            <v-col v-for="item in items" :key="item.path" cols="12" md="3">
                <v-card :color="item.color" :to="{path: item.path}" class="mx-auto justify-center">
                    <v-card-title class="justify-center">
                        <span class="title font-weight-light white--text text-uppercase text-center 1rem body-1" v-html="item.titulo"></span>
                    </v-card-title>
                    <v-card-text class="headline font-weight-bold justify-center text-center">
                        <v-icon color="white" large center justify-center class="justify-center">{{item.icon}}</v-icon>
                    </v-card-text>
                </v-card>
            </v-col>

        </v-row>

    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                items: [{
                        path: 'lista-facturas',
                        color: 'success',
                        titulo: 'Contabilidad <br> tickets - facturas',
                        icon: 'mdi-file-account',
                    },
                    {
                        path: 'lista-tickets',
                        color: 'red',
                        titulo: 'listado <br> tickets',
                        icon: 'mdi-cash-register'
                    },
                    {
                        path: 'lista-facturas-emitidas',
                        color: 'cyan',
                        titulo: 'facturas <br> recibidas',
                        icon: 'mdi-clipboard-outline'
                    },
                    {
                        path: 'lista-ingresos',
                        color: 'purple',
                        titulo: 'lista <br> ingresos',
                        icon: 'mdi-clipboard-arrow-down-outline'
                    },
                    // {
                    //     path: 'estadistica-ventas',
                    //     color: 'orange',
                    //     titulo: 'Estadisticas <br> Ventas',
                    //     icon: 'mdi-chart-line'
                    // },
                    // {
                    //     path: 'estadistica-productos',
                    //     color: 'orange',
                    //     titulo: 'Estadisticas <br> Productos',
                    //     icon: 'mdi-chart-line'
                    // },
                    // {
                    //     path: 'estadistica-servicios',
                    //     color: 'orange',
                    //     titulo: 'Estadisticas <br> Servicios',
                    //     icon: 'mdi-chart-line'
                    // }
                ]
            }
        }
    }
</script>