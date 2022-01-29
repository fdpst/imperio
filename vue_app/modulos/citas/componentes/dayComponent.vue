<template>
    <v-dialog @keydown.esc="closeDayDialog" @click:outside="closeDayDialog" v-model="day_dialog" width="850">

        <v-card>
            <v-card-title class="headline grey darken-4 white--text" dark primary-title>
                Citas del dia
            </v-card-title>

            <v-card-text class="px-3 py-3">

                <v-row dense>
                    <ul>
                        <li v-for="evento in eventos_del_dia">
                            {{ evento.cliente.nombre }} - {{ evento.category }} - {{ evento.start | extract_hour }}
                        </li>
                    </ul>

                </v-row>

                <v-row>
                    <v-col cols="12">
                        <v-btn class="white--text" @click="closeDayDialog" color="red">Cerrar</v-btn>
                    </v-col>
                </v-row>

            </v-card-text>

        </v-card>

    </v-dialog>
</template>

<script>
    export default {
        props: ['day_dialog', 'eventos_del_dia'],

        methods: {
            closeDayDialog() {
                this.$emit('close_day_dialog')
            }
        },

        filters: {
            extract_hour(val) {
                return moment(val).format('HH:mm')
            }
        }
    }
</script>