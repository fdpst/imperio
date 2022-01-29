<template>    
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Nuevo empleado</v-toolbar-title>
        </v-toolbar>
        <v-sheet shaped class="mx-4 my-4 pa-4">        
            <div class="background my-container">
                <loader v-if="isloading"></loader>
                <v-row>
                    <v-col cols="12" md=4>
                        <v-form>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field v-model="empleado.nombre" label="Nombre" required></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field v-model="empleado.email" label="Email" required></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field v-model="empleado.telefono" label="teléfono" required></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12">
                                    <v-checkbox v-model="empleado.is_active" label="activo"></v-checkbox>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12">
                                    <v-btn @click="saveEmpleado" :disabled="isloading" color="success" class="white--text">Guardar</v-btn>
                                    <v-btn v-if="empleado.id" @click="deleteEmpleado" :disabled="isloading" color="red" class="white--text">Eliminar</v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-col>

                    <v-col cols="12" md=1></v-col>
                    <v-col cols="12" md=6>
                        <h3>Días libres</h3>
                        <v-date-picker first-day-of-week="1" v-model="empleado.lista_vacaciones" multiple style="height:450px;"></v-date-picker>
                    </v-col>
                </v-row>
            </div>
        </v-sheet>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                empleado: {
                    id: '',
                    nombre: '',
                    email: '',
                    telefono: '',
                    is_active: true,
                    lista_vacaciones: []
                },
            }
        },
        created() {
            if (this.$route.query.id) {
                this.getEmpleado(this.$route.query.id)
            }
        },
        methods: {
            getEmpleado(empleado_id) {
                axios.get(`api/getempleado/${empleado_id}`).then(res => {
                    this.empleado = res.data
                }, res => {

                })
            },
            saveEmpleado() {
                axios.post('api/saveempleado', this.empleado).then(res => {
                    this.$router.push('lista-empleados')
                }, res => {

                })
            },
            deleteEmpleado() {
                axios.get(`api/deleteempleado/${this.empleado.id}`).then(res => {
                    this.$router.push('lista-empleados')
                }, res => {

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