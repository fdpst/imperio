<template>
    <v-container>

        <loader v-if="isloading"></loader>

        <v-row>
            <v-col cols="12" md=4>

                <v-form>

                    <v-row>
                        <v-col cols="12">
                            <v-textarea v-model="informacion.informacion_legal" label="Información empresa" required></v-textarea>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <v-btn @click="saveInformacion" :disabled="isloading" color="success" class="white--text">Guardar</v-btn>
                        </v-col>
                    </v-row>

                </v-form>

            </v-col>

        </v-row>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                informacion: {
                    id: null,
                    informacion_legal: ''
                }
            }
        },
        created() {
            this.getInformacion()
        },
        methods: {
            getInformacion() {
                axios.get('api/getinformacion').then(res => {
                    this.informacion = res.data
                }, res => {
                    this.$toast.error('Error al obtener Datos')
                })
            },
            saveInformacion() {
                axios.post('api/saveinformacion', this.informacion).then(res => {
                    this.$toast.sucs('Información actualizada')
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