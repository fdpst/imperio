<template>
    <div class="background my-container">

        <v-custom-title text="Empleados App"></v-custom-title>
        <br>
        <v-btn rounded depressed color="blue" dark to="guardar-empleado-app">nuevo</v-btn>

        <loader v-if="isloading"></loader>

        <v-row class="mt-3">
            <v-col cols="12" md="4">
                <v-text-field prepend-icon="mdi-account-search" filled v-model="search" label="Busqueda"></v-text-field>
            </v-col>
        </v-row>

        <v-data-table :headers="headers" :search="search"  :items="empleados" item-key="id" class="elevation-1">

            <template v-slot:item.action="{ item }">

                <router-link :to="{ path: `/guardar-empleado-app?id=${item.id}` }" class="action-buttons">
                    <v-icon color="blue" small class="mr-2">
                        mdi-pencil
                    </v-icon>
                </router-link>

            </template>

        </v-data-table>

    </div>

</template>

<script>
    export default {
        data() {
            return {
                search: '',
                empleados: [],
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
                        text: 'Tipo',
                        value: 'tipo'
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
            this.getEmpleados()
        },
        methods: {
            getEmpleados() {
                axios.get('api/app/getempleados').then(res => {
                    this.empleados = res.data
                }, err => {
                    //this.$toast.error('Algo ha salido mal')
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