<template>
    <v-row class="fill-height">
        <v-col>
            <v-row class="mb-5" align="center">
                <v-col cols="12" md="4">
                    <v-btn class="mr-2" :class="tipo.value == calendar_type ? 'green white--text' : ''" 
                        v-for="tipo in calendar_types" :key="tipo.value" @click="calendar_type = tipo.value">{{tipo.text}}
                    </v-btn>
                </v-col>
                <v-col cols="12" md="3">
                    <v-select :items="tiendas" v-model="tienda" item-text="nombre" item-value="id" dense outlined hide-details></v-select>
                </v-col>
                <v-col cols="12" md="5">
                    <v-btn outlined class="mr-4" color="grey darken-2" @click="setToday">Hoy</v-btn>
                    <v-btn fab text small color="grey darken-2" @click="prev"><v-icon small>mdi-chevron-left</v-icon></v-btn>
                    <v-btn fab text small color="grey darken-2" @click="next"><v-icon small>mdi-chevron-right</v-icon></v-btn>
                    <template v-if="$refs.calendar">{{ $refs.calendar.title }}</template>
                </v-col>
            </v-row>
            <v-col cols="12">
                <v-slider color="green" min="20" max="48" v-model="slider" :thumb-size="24" thumb-label="always"></v-slider>
            </v-col>
            <loader v-if="isloading"></loader>
            <div class="calendar-not-responsive-container">
                <div v-bind:class="{ 'calendar-not-responsive' : hascalendar_type() }">
                    <v-sheet :height="calendar_type == 'month' ? 600 : null">
                        <v-calendar :weekdays="weekdays" :events="events_for_category" @click:date="clickOnDateMonth" @click:more="clickOnMoreMonth" 
                            :interval-height="slider" event-overlap-mode="column" :interval-count="interval_count" :first-time="first_time" 
                            category-show-all interval-minutes="15" ref="calendar" v-model="focus" color="green" :type="calendar_type" 
                            :event-color="getEventColor" @click:event="clickOnEvent" @click:time-category="clickOnCategoryTime" :categories="empleados"
                            @change="getDate"
                        >
                            <template v-slot:event="{event}">
                                <b>{{ event.name }}</b>
                                <ul class="mt-1" style="padding-left: 15px;">
                                    <li v-for="servicio in event.lista_nombre_servicios">{{servicio}}</li>
                                </ul>
                            </template>
                            <template v-slot:day="{date}">
                                <div v-for="event, index in map_events[date]" v-if="index < 1 && !event.horario && !event.dia_libre" 
                                    data-date="date" class="v-event v-event-start v-event-end white--text" 
                                    v-bind:style="[month_event_style, {backgroundColor: event.color, borderColor: event.color}]">
                                    <div style="padding: 0 12px 0 13px;">
                                        <b v-html="event.name" style="text-transform:capitalize;"></b>
                                    </div>
                                </div>
                                <div v-if="map_events[date] && (map_events[date]).length > 2" data-date="date" class="v-event-more pl-1" style="height: 20px; margin-bottom: 1px;">
                                    {{ (map_events[date]).length - 2 }} más
                                </div>
                            </template>
                            <!--<template v-slot:day-body="{ date, timeToY, minutesToPixels }">
                                <div class="v-event-timed-container">
                                    <div v-for="event in map_events[date]" class="v-event-timed white--text" :style="{ top:timeToY(event.start.substring(11, 20)) + 'px', height: minutesToPixels(event.tiempo_real) + 'px' }"
                                      style="left: 0%; width: 100%; background-color: rgb(100, 211, 71); border-color: rgb(100, 211, 71);">
                                        {{timeToY(120)}}
                                    </div>
                                </div>
                            </template>-->
                        </v-calendar>
                    </v-sheet>
                </div>
            </div>
        </v-col>
        <evento-component :horas_select="horas_select" v-on:eliminar_cita="eliminarCita" v-on:save_cita="saveCita" 
            v-on:close_dialog="closeDialog" :tipo="tipo" :empleado="empleado" :servicios="servicios" :day="day" 
            :start="start" :dialog="dialog" :events="events_for_empleado_selected" :clientes="clientes">
        </evento-component>
        <day-component v-on:close_day_dialog="day_dialog = false" :day_dialog="day_dialog" :eventos_del_dia="eventos_del_dia"></day-component>
    </v-row>
</template>

<script>
    /*mixins*/
    import { month_mixin } from '../mixins/month_mixin'
    import { category_mixin } from '../mixins/category_mixin'
    import { calendar_basic_mixin } from '../mixins/calendar_basic_mixin'
    import { dias_ocupados_mixin } from '../mixins/dias_ocupados_mixin'
    /*componentes*/
    import eventoComponent from './eventoComponent'
    import dayComponent from './dayComponent'
    export default {
        mixins: [month_mixin, category_mixin, calendar_basic_mixin, dias_ocupados_mixin],
        components: {
            eventoComponent,
            dayComponent
        },
        data: () => ({
            tienda: null,
            tiendas: [],
            month_event_style: {
                height: '20px',
                width: '95%',
                marginBottom: '1px'
            },
            is_request_success: false,
            slider: 90,
            calendar_type: 'category',
            calendar_types: [{
                    value: 'category',
                    text: 'Empleados'
                },
                {
                    value: 'week',
                    text: 'Semana'
                },
                {
                    value: 'month',
                    text: 'Mes'
                }
            ],
            dialog: false,
            day_dialog: false,
            is_event_select: false,
            focus: '',
            events: [],
            eventos_del_dia: [],
            tipo: null,
            start: null,
            day: null,
            empleado: null,
            servicios: [],
            empleados: [],
            clientes: [],
            horas_disponibles: [],
            weekday: null,
            weekdays: [1, 2, 3, 4, 5, 6, 0],
            interval_count: 0,
            first_time: '00:00',
            first_start_time: null,
            horas_select: [],
            month: null,
            end_month: null,
            calendar_day: null,
            n_empleados: [],
            current_date: null
        }),
        watch: {
            'interval_count'(n) {
                let start = this.first_start_time
                if (n > 0) {
                    this.horas_select = _.range(n).map(x => {
                        let i = x * 15
                        return start.clone().add(i, 'minutes').format('HH:mm')
                    })
                }
            },
            'month'(n) {
                this.getEventsByMonth(n, this.end_month, this.tienda)
            },
            'n_empleados'(n) {
                this.addEvents(n, this.month)
            },
            'weekday'(n) {
                //this.disabledHours(n)
            },
            'current_date'(n) {
                this.disabledHours(this.weekday)
            },
            'tienda'(n) {
                this.getData(this.$route.query.tipo, n)
                this.getEventsByMonth(this.month, this.end_month, n)
            }
        },
        mounted() {
            this.$refs.calendar.checkChange()
            this.tipo = this.$route.query.tipo
            this.getTiendas()
        },
        methods: {
            getTiendas() {
                axios.get(`api/app/gettiendas`).then(res => {
                    this.tiendas = res.data
                }, res => {
                    this.$toast.error('Error consultando tiendas')
                })
            },
            getData(nombre_tipo, tienda_id) {
                axios.get(`api/app/getdata/${nombre_tipo}/${tienda_id}`).then(res => {
                    this.empleados = res.data.empleados.map(x => x.nombre)
                    this.n_empleados = res.data.empleados
                    this.clientes = res.data.clientes
                    this.servicios = res.data.servicios
                    this.horas_disponibles = res.data.horas_disponibles
                    this.setIntervals()
                    this.disabledHours(this.weekday)
                }, res => {
                    this.$toast.error('Algo ha salido mal')
                })
            },
            getEventsByMonth(month, end_month, tienda_id) { 
                this.is_request_success = false
                axios.get(`api/app/geteventsbymonth/${this.$route.query.tipo}/${tienda_id}/${month}/${end_month}`).then(res => {
                    this.events.filter(element => element.horario == false)
                    this.events.push(...res.data)
                    this.is_request_success = true
                    this.addEvents(this.n_empleados, month)
                }, res => {
                    this.is_request_success = false
                    this.$toast.error('No se han encontrado eventos')
                })
            },
            comprobarExisteDia(lista_fechas, lista_horario, dia_semana) {
                let existe_dia = lista_fechas.filter(element => element.fecha == this.current_date)
                let n_lista = []
                if (existe_dia.length > 0) {
                    n_lista = lista_horario.filter(x => x.dia != moment(this.current_date).weekday())
                    existe_dia.forEach(horario => {
                        n_lista.push({
                            dia: moment(horario.fecha).weekday(),
                            entrada: horario.entrada,
                            salida: horario.salida
                        })
                    })
                    return n_lista
                }
                return lista_horario
            },
            disabledHours(dia_semana) {
                if (this.n_empleados.length == 0 && this.tienda_id != null && this.calendar_type == 'category') {
                    setTimeout(x => {
                        this.disabledHours(dia_semana)
                    }, 2000)
                    return null
                }
                this.events = this.events.filter(event => event.horario != true)
                this.n_empleados.forEach(empleado => {
                    let nuevo_horario = this.comprobarExisteDia(empleado.fecha, empleado.horario, dia_semana)
                    let numero_de_turnos = nuevo_horario.filter(x => x.dia == dia_semana)
                    //let numero_de_turnos = empleado.horario.filter(x => x.dia == dia_semana)
                    let numero_intervalos = numero_de_turnos.length
                    if (numero_intervalos == 0) {
                        return null
                    }
                    let primer_turno = this.createCustomEvent('00:00', numero_de_turnos[0].entrada, empleado.nombre)
                    let segundo_turno = this.createCustomEvent(numero_de_turnos[numero_intervalos - 1].salida, '23:50', empleado.nombre)
                    this.addCustomEvent(primer_turno)
                    this.addCustomEvent(segundo_turno)
                    if (numero_intervalos == 2) {
                        let turno_intermedio = this.createCustomEvent(numero_de_turnos[0].salida, numero_de_turnos[1].entrada, empleado.nombre)
                        this.addCustomEvent(turno_intermedio)
                    }
                })
            },
            createCustomEvent(entrada, salida, nombre_empleado) {
                return {
                    id: new Date().getUTCMilliseconds(),
                    start: `${this.current_date} ${entrada}:00`,
                    end: `${this.current_date} ${salida}:00`,
                    timed: true,
                    category: nombre_empleado,
                    color: '#243856b8',
                    name: 'Horario',
                    horario: true
                }
            },
            addCustomEvent(evento) {
                this.events.push(evento)
            },
            getDate(data) {
                this.current_date = data.start.date
                this.month = data.start.month
                this.end_month = data.end.month
                this.calendar_day = data.start.month
                this.weekday = data.start.weekday
                if (this.horas_disponibles.length > 0) {
                    this.setIntervals()
                }
            },
            saveCita(data) {
                data.app_tienda_id = this.tienda
                axios.post(`api/app/savecita`, data).then(res => {
                    if (data.id != null) {
                        this.deleteFromList(data.id)
                    }
                    this.events.push(res.data)
                    this.resetFields()
                    this.$emit('reset_form');
                }, res => {
                    if (res.response.status == 301) {
                        return this.$toast.warn('hora no disponible')
                    }
                    if (res.response.status == 422) {
                        return this.$toast.warn('Debe completar los campos')
                    }
                    this.$toast.error('algo ha salido mal')

                    this.dialog = false
                })
            },
            eliminarCita(evento_id) {
                axios.get(`api/app/eliminarcita/${evento_id}`).then(res => {
                    this.deleteFromList(evento_id)
                    this.resetFields()
                    this.$emit('reset_form');
                }, res => {
                    this.$toast.error('algo ha salido mal')
                    this.$emit('reset_form');
                    this.dialog = false
                })
            },
            deleteFromList(id) {
                let index = this.events.findIndex(x => x.id == id)
                this.events.splice(index, 1);
            },
            setIntervals() {
                let find_item = this.horas_disponibles.find(x => x.dia == this.weekday)
                let hoy = moment().format('YYYY-MM-DD')
                let start = moment(`${hoy} ${find_item.start}`, 'YYYY-MM-DD HH:mm')
                this.first_start_time = start
                let end = moment(`${hoy} ${find_item.end}`, 'YYYY-MM-DD HH:mm')
                let diff = end.diff(start, 'minutes')
                let numero_intervalos = Math.trunc(diff / 15)
                this.first_time = find_item.start
                this.interval_count = numero_intervalos
            },
            /*function para obtener los minutos de 15 en 15
            ejemplo: al hacer click en el calendario a las 16:22
            retornara 16:15*/
            getTimeForEvent(event) {
                let minute = event.minute
                let hour = this.minTwoDigits(event.hour)
                let interval = Math.trunc(minute / 15)
                let digitos = this.minTwoDigits(interval * 15)
                let t = `${hour}:${digitos}`
                return t;
            },
            minTwoDigits(n) {
                return (n < 10 ? '0' : '') + n;
            },
            closeDialog() {
                this.dialog = false
                this.evento = {} 
                this.empleado = null
            },
            hascalendar_type() {
                return this.calendar_type == 'category' || this.calendar_type == 'week'
            },
            resetFields() {
                this.start = null
                this.day = null
                this.empleado = null
                this.dialog = false
            },
            noDiasLibres(array) {
                if (array) {
                    return array.filter(x => !x.dia_libre || !x.horario)
                }
                return 0;
            }
        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
            map_events: function() {
                const map = {}
                this.events.forEach(e => {
                    let fecha = e.start.substring(0, 10);
                    if (e.app_usuario_id) {
                        (map[fecha] = map[fecha] || []).push(e);
                    }
                })
                return map
            },
            events_for_category: function() {
                if (this.calendar_type == 'month') {
                    return []
                }
                if (this.calendar_type == 'category') {
                    return this.events
                }
                if (this.calendar_type == 'week') {
                    return this.events.filter(event => event.app_usuario_id)
                }
            },
            events_for_empleado_selected() {
                if (this.empleado) {
                    return this.events.filter(event => {
                        return this.day == event.start.substring(0, 10) && event.category == this.empleado
                    })
                }
                return []
            }
        }
    }
</script>

<style>
    .v-calendar .v-event-timed-container {
        margin-right: 2px !important;
    }
    .calendar-not-responsive-container {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
    }
    .calendar-not-responsive {
        width: 100%;
    }
    @media(max-width:900px) {
        .calendar-not-responsive {
            width: 800px;
        }
    }
</style>