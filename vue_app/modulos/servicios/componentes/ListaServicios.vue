<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Servicios</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">        
            <div class="background my-container">
                <v-btn color="blue" dark class="mb-4" :to="{ path: `/crear-servicio` }">nuevo</v-btn>
                <loader v-if="isloading"></loader>
                <!-- <form-servicio :tipos="tipos" :servicio="servicio" v-on:clearServicio="clearServicio" 
                v-on:pushServicio="pushServicio" @get_servicios="getServicios">
            </form-servicio> -->
                <v-data-table :headers="headers" :search="search" :items-per-page="18" :items="servicios" item-key="id" class="elevation-1">
                    <template v-slot:item.precio="{item}">
                        {{item.precio}} €
                    </template>
                    <template v-slot:item.duracion="{item}">
                        {{item.duracion}} Min.
                    </template>
                    <template v-slot:item.action="{ item }">
                    <!-- <v-icon small color="blue" @click="setServicio(item)" class="mr-2">
                        mdi-pencil
                    </v-icon> -->
                    <!-- Ruta para editar servicio -->
                    <router-link :to="{ path: `/editar-servicio?id=${item.id}` }">
                        <v-icon small class="mr-2"> mdi-pencil </v-icon>
                    </router-link>
                    <!-- END Ruta para editar servicio -->
                    <v-icon small color="red" @click="deleteServicio(item)"> mdi-delete </v-icon>
                    </template>
                </v-data-table>
            </div>
        </v-sheet>
    </v-container>
</template>

<script>
    import {
        tipos_mixin
    } from '../../../mixins/tipos_mixin'

    import formServicio from './formServicio.vue'

    export default {

        mixins: [tipos_mixin],

        components: {
            formServicio
        },

        data() {
            return {
                search: '',
                servicio: {
                    tipo: {
                        id: null
                    }
                },
                servicios: [],
                headers: [{
                        text: 'Nombre',
                        align: 'left',
                        value: 'nombre',
                    },
                    {
                        text: 'Precio',
                        value: 'precio'
                    },
                    {
                        text: 'Duración',
                        value: 'duracion'
                    },
                    /*{
                        text: 'Tipo',
                        value: 'tipo.nombre'
                    },*/
                    {
                        text: 'Acciones',
                        value: 'action',
                        sortable: false
                    },
                ],
            }
        },
        mounted() {
            this.getServicios()
        },
        methods: {
            getServicios() {
                axios.get('api/getservicios').then(res => {
                    this.servicios = res.data
                }, err => {
                    this.$toast.error('Algo ha salido mal')
                })
            },

            setServicio(servicio) {
                this.servicio = servicio
            },

            deleteServicio(servicio) {
                axios.get(`api/deleteservicio/${servicio.id}`).then(res => {
                    this.servicios.splice(this.servicios.indexOf(servicio), 1);
                    this.$toast.sucs('Servicio BORRADO correctamente');
                }, res => {

                })
            },

            pushServicio(data) {
                if (data.was_created) {
                    this.servicios.push(data.servicio)
                }
                this.clearServicio();
            },

            clearServicio() {
                this.servicio = {
                    id: null,
                    nombre: '',
                    precio: '',
                    duracion: ''
                }
            }
        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
        }
    }
</script>