<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Albaranes</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">        
            <div class="background my-container">
                <loader v-if="isloading"></loader>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field v-model="search" label="Busqueda"></v-text-field>
                    </v-col>
                </v-row>
                <v-data-table :headers="headers" :search="search" :items-per-page="10" :items="recibos" item-key="id" class="elevation-4">
                    <template v-slot:item.monto="{ item }">{{item.monto}} €</template>
                    <template v-slot:item.action="{ item }">
                        <router-link :to="{ path: `/guardar-albaran?id=${item.id}` }" class="action-buttons">
                            <v-icon small class="mr-2">mdi-pencil</v-icon>
                        </router-link>
                        <v-icon small color="red" @click="deleteRecibo(item)">mdi-delete</v-icon>
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
                recibos: [],
                headers: [{
                        text: 'Nro. Albaran',
                        align: 'left',
                        value: 'numero_recibo',
                    },
                    {
                        text: 'Proveedor',
                        value: 'proveedor'
                    },
                    {
                        text: 'Fecha',
                        value: 'fecha'
                    },
                    {
                        text: 'Precio',
                        value: 'monto'
                    },
                    {
                        text: 'Acciones',
                        value: 'action',
                        sortable: false
                    },
                ],
            }
        },
        mounted() {
            this.getRecibos()
        },
        methods: {
            getRecibos() {
                axios.get('api/getrecibos').then(res => {
                    this.recibos = res.data
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },
            deleteRecibo(recibo) {
                axios.get(`api/deleterecibo/${recibo.id}`).then(res => {
                    this.recibos.splice(this.recibos.indexOf(recibo), 1)
                }, res => {
                    this.$toast.error('Error al obtener Datos')
                })
            }
        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
        }
    }
</script>