<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Clientes</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">        
            <div class="background my-container">
                <v-btn color="blue" dark to="guardar-cliente">nuevo</v-btn>
                <loader v-if="isloading"></loader>
                <v-row>
                    <v-col cols="12" md="4">
                        <v-text-field v-model="search" label="Nombre"></v-text-field>
                    </v-col>
                </v-row>
                <v-data-table :headers="headers" :search="search" :items-per-page="10" :items="clientes" item-key="id" class="elevation-4">
                    <template v-slot:item.action="{ item }">
                        <router-link :to="{ path: `/guardar-cliente?id=${item.id}` }" class="action-buttons">
                            <v-icon small class="mr-2"> mdi-pencil</v-icon>
                        </router-link>
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
                clientes: [],
                headers: [{
                        text: 'Nombre',
                        align: 'left',
                        value: 'nombre',
                    },
                    {
                        text: 'Email',
                        value: 'email'
                    },
                    {
                        text: 'Teléfono',
                        value: 'telefono'
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
            this.getClientes()
        },
        methods: {
            getClientes() {
                axios.get('api/getclientes').then(res => {
                    this.clientes = res.data
                }, err => {
                    this.$toast.error('Error al obtener Datos')
                })
            },

        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
        }
    }
</script>