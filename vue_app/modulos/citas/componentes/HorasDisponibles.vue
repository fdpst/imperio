<template>
    <v-container>

        <pre>{{horas}}</pre>

        <pre>{{duracion}}</pre>

        <button @click="calcular">calcular</button>

        <pre>{{resultados}}</pre>

        <!--<v-row align="center">

            <v-col cols="12" md="3">
                <v-select v-model="query.tipo_id" :items="tipos" item-text="nombre" item-value="id" label="tipos"></v-select>
            </v-col>

            <v-col cols="12" md="3">
                <v-select v-model="query.empleado_id" :items="empleados" item-text="nombre" item-value="id" label="empleados"></v-select>
            </v-col>

            <v-col cols="12" md="3">
                <v-select v-model="query.tienda_id" :items="tiendas" item-text="nombre" item-value="id" label="tiendas"></v-select>
            </v-col>

            <v-col cols="12">
                <v-date-picker color="purple" v-model="query.fecha"></v-date-picker>
            </v-col>

            <v-col cols="12">
                <v-btn @click="buscarDisponible" class="white--text" color="purple">buscar hora disponible</v-btn>
            </v-col>

        </v-row>-->

        <!--  <v-row>

            <v-col cols="12">
                <p>prueba para asignar el tiempo de cita</p>
            </v-col>

            <v-col cols="12">
                <v-alert v-model="alert" close-text="Close Alert" color="deep-purple accent-4" dark dismissible>
                    el select de abajo ya debe estar cargado
                </v-alert>
            </v-col>

            <v-row>
                <v-col cols="12" md="5">
                    <v-row dense>
                        <v-col v-for="(item, i) in resultado.diferencia" :key="i" cols="12" md="3">
                            <v-btn @click="cita.start = item" block outlined :color="item >= '12:00' ? 'orange' : 'green'">{{item}}</v-btn>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>

            <v-row>

                <v-col cols="12" md="3">
                    <v-select v-model="cita.start" :items="resultado.diferencia" label="disponible"></v-select>
                </v-col>

                <v-col cols="12" md="3">
                    <v-text-field v-model="cita.duracion" label="prueba duracion"></v-text-field>
                </v-col>

                <v-col cols="12">
                    <v-btn @click="asignarCita" class="white--text" color="blue">Asignar la cita</v-btn>
                </v-col>

            </v-row>

            <v-col cols="12">
                <pre>{{cita}}</pre>
            </v-col>

            <v-col cols="12">
                <p>resultado de la busqueda</p>
                <pre>{{resultado.diferencia}}</pre>
            </v-col>
        </v-row>-->
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                horas: ['09:00', '09:15', '09:30', '09:45', '10:00'],
                duracion: 45,
                resultados: null,
                alert: false,
                empleados: [],
                tiendas: [],
                tipos: [],
                query: {
                    empleado_id: null,
                    tienda_id: null,
                    tipo_id: null,
                    fecha: null,
                },
                resultado: {
                    diferencia: []
                },

                cita: {
                    start: '',
                    duracion: 45,
                    intervalos: []
                }
            }
        },

        created() {
            this.getEmpleados()
            this.getTiendas()
            this.getTipos()
        },

        methods: {
            calcular() {
                let intervalos = (this.duracion / 15) + 1

                for (let i = 0; i < this.horas.length; i++) {
                    let start = moment(`2021-03-26 ${this.horas[i]}`, 'YYYY-MM-DD HH:mm')

                    for (let j = 0; j < intervalos; j++) {
                        let o = j * 15

                        let end = start.clone().add(o, 'minutes').format('HH:mm')

                        if (!this.horas.includes(end)) {
                            this.horas.splice(i, 1)
                            i--
                            break;
                        }
                    }
                }
            },
            asignarCita() {
                let intervalos = (this.cita.duracion / 15) + 1

                let start = moment(`${this.query.fecha} ${this.cita.start}`, 'YYYY-MM-DD HH:mm')

                let horarios = _.range(intervalos).map(x => {
                    let i = x * 15
                    return start.clone().add(i, 'minutes').format('HH:mm')
                })

                let encaja_en_horario = horarios.every(element => this.resultado.diferencia.includes(element))

                if (encaja_en_horario) {
                    this.$toast.sucs('se puede editar')
                } else {
                    this.$toast.warn('no se puede editar')
                }
            },

            buscarDisponible() {
                axios.post(`api/app/buscar-horario-disponible`, this.query).then(res => {
                    this.resultado = res.data
                    this.$toast.sucs('consulta realizada')
                    this.alert = true
                }, res => {})
            },

            getTiendas() {
                axios.get(`api/app/gettiendas`).then(res => {
                    this.tiendas = res.data
                }, res => {})
            },

            getTipos() {
                axios.get(`api/app/gettipos`).then(res => {
                    this.tipos = res.data
                }, res => {})
            },

            getEmpleados() {
                axios.get('api/app/getempleados').then(res => {
                    this.empleados = res.data
                }, err => {})
            }
        }
    }
</script>