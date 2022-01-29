<template>
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Vacaciones</v-toolbar-title>
        </v-toolbar>
        <loader v-if="isloading"></loader>
        <v-sheet shaped class="mx-4 my-4 pa-4 col-3">
            <v-row dense align="center">
                <v-col cols="12" md="12">
                    <v-select v-model="empleado" return-object item-text="nombre" :items="empleados" label="Empleado"></v-select>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols=12 md="12">
                    <template v-if="empleado">
                        <v-date-picker first-day-of-week="1" v-model="empleado.lista_vacaciones" 
                        multiple style="height:400px;" class="elevation-2"></v-date-picker>
                    </template>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols=12 md="12">
                    <v-btn @click="saveEmpleado" :disabled="isloading" color="success" class="white--text">Guardar</v-btn>
                </v-col>
            </v-row>
        </v-sheet>
    </v-container>
</template>

<script>
    import {
        empleados_mixin
    } from '../../../mixins/empleados_mixin'

    export default {
        mixins: [empleados_mixin],
        data() {
            return {
                empleado: {
                    lista_vacaciones: []
                },
            }
        },
        methods: {
            saveEmpleado() {
                axios.post('api/saveempleado', this.empleado).then(res => {
                    this.$toast.sucs('Vacaciones guardadas')
                }, res => {
                    this.$toast.error('Error guardando vacaciones')
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