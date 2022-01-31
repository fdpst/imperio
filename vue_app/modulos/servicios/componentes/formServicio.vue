<template>
    <v-container>
        <loader v-if="isloading"></loader>
        <v-sheet shaped class="mx-4 my-4 pa-4">
            <v-row>
                <v-col cols="12">
                    <v-toolbar color="red lighten-2" dark class="mb-4" >
                        <v-toolbar-title>Crear Servicio</v-toolbar-title>
                    </v-toolbar>
                    <v-card ref="form" class="mx-auto mb-4">
                        <v-container fluid :servicio="servicio">
                            <v-row class="ml-4">
                                <v-col cols="12" md="5">
                                    <v-text-field v-model="servicio.nombre" label="Nombre" required></v-text-field>
                                </v-col>
                                <v-col cols="12" md="2">
                                    <v-text-field v-model="servicio.precio" label="Precio" required></v-text-field>
                                </v-col>
                                <v-col cols="12" md="2">
                                    <v-text-field v-model="servicio.duracion" label="Duración en minutos" required></v-text-field>
                                </v-col>
                                <v-col cols="12" md="2">
                                    <v-text-field disabled v-model="horas" label="Horas" required></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12">
                                    <v-btn :disabled="!is_multiple" class="white--text ma-4" color="success" @click="saveServicio">guardar</v-btn>
                                    <v-btn class="white--text my-3 mr-0" color="red" @click="cancelSave">cancelar</v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-col>
            </v-row>
        </v-sheet>
    </v-container>
</template>

<script>
    import formServicio from '../componentes/formServicio';

    export default {
        components: {
            formServicio
        },

        data() {
            return {
                is_multiple: false,
                number_to: 15,
                lista_duracion: [15, 30, 45, 60, 75, 90, 105, 120],
                servicio: { "nombre":'',"precio":0,"duracion":0 },
                servicionombre: null,
                servicioprecio: null,
                servicioduracion: null
            }
        },

        created(){ 
            this.getServicios()
            this.$route.query.id ? this.getItem(this.$route.query.id) : null
        },

        computed: {
            form() {
                return {
                    servicionombre: this.servicio.nombre,
                    servicioprecio: this.servicio.precio,
                    servicioduracion: this.servicio.duracion
                };
            },

            isloading: function() {
                return this.$store.getters.getloading
            },
            
            horas() {
                if (this.servicio.duracion) {
                    return moment.utc(moment.duration(this.servicio.duracion, "minutes").asMilliseconds()).format("HH:mm")
                }
            }
        },

        watch: {
            servicionombre() {
                this.errorMessages = "";
            },
            servicioprecio() {
                this.errorMessages = "";
            },
            servicioduracion() {
                this.errorMessages = "";
            },

            'servicio.duracion'(n) {
                this.is_multiple = (n % this.number_to == 0)
            },
        },

        methods: {
            getItem(id) {
                axios.get(`api/getServicio/${id}`).then(res => {
                    this.servicio = res.data
                }, res => {
                    this.$toast.error('Error obteniendo datos del Servicio')
                })
            },

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
            },

            saveServicio() {
                axios.post('api/saveservicio', this.servicio).then(res => {
                    this.$emit('pushServicio', res.data)  
                    this.$toast.sucs('Servicio Almacenado correctamente');
                    this.$router.push('lista-servicios')                
                }, res => {
                    this.$emit('get_servicios');
                    this.$toast.error('Error almacenando Servicio');
                })    
            },

            cancelSave() {
                this.$router.push('lista-servicios')
            },
        },
    }
</script>