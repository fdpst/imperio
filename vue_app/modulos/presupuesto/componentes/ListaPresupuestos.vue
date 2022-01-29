<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Presupuestos</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">        
            <div class="background my-container">
                <loader v-if="isloading"></loader>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field v-model="search" label="Busqueda"></v-text-field>
                    </v-col>
                </v-row>
                <v-data-table :headers="headers" :search="search" :items-per-page="10" :items="presupuestos" item-key="id" class="elevation-4">
                    <template v-slot:item.url="{ item }">
                        <a target="_blank" :href="`archivos/presupuestos/${item.url_presupuesto}`">
                            <v-icon medium color="orange" class="mr-2">mdi-cloud-download</v-icon>
                        </a>
                    </template>
                    <template v-slot:item.cliente="{ item }">
                        <span v-if="item.cliente">{{item.cliente.nombre}}</span>
                        <span v-else>N/A</span>
                    </template>
                    <template v-slot:item.action="{item}">
                        <router-link :to="{path: `/editar-factura?id=${item.id}&&tipo=presupuesto`}" class="action-buttons">
                            <v-icon small class="mr-2">mdi-pencil</v-icon>
                        </router-link>
                        <v-icon @click="deletePresupuesto(item)" small color="red" class="mr-2">mdi-delete</v-icon>
                    </template>
                </v-data-table>
            </div>
        </v-sheet>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                search: '',
                presupuestos: [],
                headers: [{
                        text: 'Fecha',
                        value: 'created_at'
                    },
                    {
                        text: 'IVA',
                        value: 'iva'
                    },
                    {
                        text: 'Precio',
                        value: 'total'
                    },
                    {
                        text: 'Cliente',
                        value: 'cliente'
                    },
                    {
                        text: 'Presupuesto',
                        value: 'url'
                    },
                    {
                        text: 'Generar factura',
                        value: 'action'
                    },
                ],
            }
        },
        created() {
            this.getPresupuestos()
        },
        methods: {
            getPresupuestos() {
                axios.get('api/getpresupuestos').then(res => {
                    this.presupuestos = res.data
                }, res => {
                    this.$toast.error('Error al obtener Datos')
                })
            },
            deletePresupuesto(item) {
                axios.get(`api/deletepresupuesto/${item.id}`).then(res => {
                    this.presupuestos.splice(this.presupuestos.indexOf(item), 1)
                }, res => {
                    this.$toast.error('Error al obtener Datos')
                })
            }
        },
        computed: {
            isloading() {
                return this.$store.getters.getloading
            },
        }
    }
</script>