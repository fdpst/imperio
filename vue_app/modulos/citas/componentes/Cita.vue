<template>
    <div class="">        
        <v-overlay v-if="overlay">
            <v-progress-circular indeterminate size="220" color="green" width="10">
                <v-col>
                    <!--<v-icon class="white--text">mdi-paw</v-icon>-->
                    <strong style="color:white !important;"> Cargando datos</strong>
                </v-col>
            </v-progress-circular>
        </v-overlay>
        <v-row>
            <v-col cols="12" md="3">
                <v-autocomplete :items="tiendas" v-model="tienda" item-text="nombre" item-value="id" dense outlined hide-details label="Tienda"></v-autocomplete>
            </v-col>
            <v-col v-if="tienda" cols="12" md="3">
                <v-btn rounded depressed class="mr-2" :class="tipo.value == type ? 'pink white--text' : ''" 
                    v-for="tipo in calendar_types" :key="tipo.value" @click="semana()">{{tipo.text}}
                </v-btn>
                <v-btn @click="$emit('open_dialog')" rounded depressed color="green" class="white--text mr-2">Nuevo</v-btn>
                <v-btn v-if="tienda" @click="$emit('abrirbusqueda')" rounded depressed color="blue" class="white--text mr-2">Buscar cita</v-btn>
            </v-col>
            <v-col v-if="tienda" cols="12" md="5">
                <v-btn outlined class="mr-4" color="grey darken-2" @click="setToday">Hoy</v-btn>
                <v-btn fab text small color="grey darken-2" @click="prev"><v-icon small>mdi-chevron-left</v-icon></v-btn>
                <v-btn fab text small color="grey darken-2" @click="next"><v-icon small>mdi-chevron-right</v-icon></v-btn>
            </v-col>
        </v-row>
        <v-col v-if="tienda" cols="12">
            <div ref="false_scroll" class="false_scroll" v-on:scroll.pasive="falseScrollFunction">
                <div class="false_scroll_container"></div>
            </div>
        </v-col>
        <v-col v-if="tienda" cols="12">
            <div ref="calnedar_wrap" v-on:scroll.pasive="scrollFunction" class="calendar-wrapper">
                <div class="dia-container" :class="{'full-width' : type == 'day'}">
                    <div v-for="(weekday, i) in set_week_days" class="dia-component" :class="{'full-width' : type == 'day'}">
                        <div class="dia-header">
                            <span> {{weekday.nombre_dia}}</span>
                            <v-btn id="diabtn" @click="selectDay(weekday)" :class="{'green white--text' : weekday.full_date == current_day_inmutable}">
                                {{weekday.numero_dia}}
                            </v-btn>
                        </div>
                        <div class="cita-container mt-2">
                            <empleado-component v-for="empleado in empleados" :intervalos="intervalos" :key="empleado.id" :app_tienda_id="tienda"
                                :empleado="empleado" :citas="getCitas(empleado, weekday.full_date)" :horario="getHorario(empleado, weekday.full_date)"
                                :fechas="getFechas(empleado, weekday.full_date)" :dia_actual="weekday.full_date" :interval_height="slider" :type="type">
                            </empleado-component>
                        </div>
                    </div>
                </div>
            </div>
        </v-col>
        <v-col cols="12" md="3">
            <evento-component :tipo="tipo" :app_tienda_id="tienda" :isloading="isloading" v-on:eliminar_cita="deleteCita" :abrirbusqueda="abrirbusqueda()"
                v-on:cita_guardada="agregarCita" :empleados="empleados" :clientes="clientes" :servicios="servicios" v-on:resetClientes="resetClientes">
            </evento-component>
        </v-col>
        </div>
</template>

<script>
    import { data_mixin } from '../mixins/data_mixin'
    import { calendar_basic_mixin } from '../mixins/calendar_basic_mixin'
    import empleadoComponent from './empleadoComponent'
    import eventoComponent from './eventoComponent'
    import ToggleSwitch from 'vuejs-toggle-switch'
    export default {
        components: {
            empleadoComponent,
            eventoComponent
        },
        mixins: [data_mixin, calendar_basic_mixin],
        data() {
            return {
                tipo: null,
                scroll_value: 0,
                slider: 26,
                dia_actual: moment().format('YYYY-MM-DD').substring(0, 10),
                current_day_inmutable: moment().format('YYYY-MM-DD').substring(0, 10),
                entrada: '08:00',
                salida: '21:30',
                intervalos: [],
                citas: [],
                dialogo:'',
                overlay: false, 
            }
        },
        watch: {
            'dia_actual'(n) {
                let base_url = this.$route.query.tipo == 'peluqueria' ? 'citas-peluqueria?tipo=peluqueria' : 'citas-clinica?tipo=clinica'
                this.$router.push(`${base_url}`).catch(() => {});

                this.agregarCitas(n)
                this.setWeekDay(n)

            },
            'tienda': {
                immediate: true,
                handler(n) {
                    this.tienda = parseInt(this.tienda)
                    if(this.tienda){
                        this.overlay = true
                    }
                    n ? this.getData(this.$route.query.tipo, n) : null
                }
            }
        },
        created() {
            this.overlay = false,
            this.calcularIntervalos()
            this.getTiendas()
            this.tipo = this.$route.query.tipo
            
        },
        methods: {
            semana(){
                //Ponemos el calendario en modo semana y seteamos la url
                this.type = "week";
                /*let base_url = this.$route.query.tipo == 'peluqueria' ? 'citas-peluqueria?tipo=peluqueria' : 'citas-clinica?tipo=clinica'
                this.$router.push(`${base_url}`).catch(() => {});*/
            },
            scrollFunction(e) {
                this.$refs.false_scroll.scrollLeft = e.target.scrollLeft
            },
            falseScrollFunction(e) {
                this.$refs.calendar_wrap.scrollLeft = e.target.scrollLeft
            },
            getCitas(empleado, dia) {               
                return this.map_citas[`${empleado.nombre}_${dia}`];
            },            
            getHorario(empleado, dia) {  
                        
                let horario_especial = undefined   
                let actual = moment(`${dia}`, 'YYYY-MM-DD');
                let fecha_revision = moment('2021-11-15', 'YYYY-MM-DD') 
                // Comprobamos si el empleado tiene un horario especifico ( variable fecha del array en crearIntervalos(n, dia_actual)) 
                // si no tiene horario especifico asignamos la entrada y salida de este dia actual ( habitual )
                // y verificamos que el id del horario del empleado sea de la tienda seleccionada
                if (empleado.fecha.length == 0) 
                {
                    horario_especial = this.map_horario[`${empleado.id}_${moment(dia).weekday()}`];
                }
                // si tiene horario especifico asignamos la entrada y salida de este dia actual ( especifico ) 
                else
                {
                    let horarioHabitual = [];
                    let horarioEspecifico = [];
                    let horarioLibre = [];
                    let diaEspecifico = false;
                    let diaHabitual = false;
                    let diaLibre = false;

                    horario_especial = undefined;
                    // para evitar la entrada en todos los dias especificos y que muestre de manera erroneo el horario
                    //  creamos una variable flag para marcar la entrada
                    let diapintado = false;  
                    //  recorremos el horario especifico y asignamos la entrada y salida de este dia especifico
                    empleado.fecha.forEach(especifico => {    
                        
                        // Seteamos en variables la fecha especifica del dia recorrido y la fecha actual para realizar la comprobacion
                        let fecha = moment(`${especifico.fecha}`, 'YYYY-MM-DD');
                        
                        // Verificamos que sean iguales para asignar la entrada y salida
                        if (this.tienda == especifico.app_tienda_id)
                        {
                            if (JSON.stringify(fecha) == JSON.stringify(actual))
                            {
                                //si es undefine inicializo el array
                                if (horarioEspecifico == undefined /*|| diapintado == false*/){
                                    horarioEspecifico=[]
                                }
                                //Añadimos en horario especifico
                                horarioEspecifico.push({
                                    app_empleado_id: empleado.id,
                                    app_tienda_id: especifico.app_tienda_id,
                                    dia: moment(dia).weekday(),
                                    entrada: especifico.entrada,
                                    salida: especifico.salida                                    
                                }) 
                                                           
                                // Si los dias coinciden marcamos el flag como true para no realice mas comprobaciones y marque mal el horario
                                //Indicamos diaEspecifico a true para confirmar que se existe horario específico
                                //diapintado = true;
                                diaEspecifico = true;
                            }
                            else
                            {                     
                                // Si los dias no coinciden marcamos el flag y el horario como habitual
                               // if (diapintado == false) {
                                    //diapintado = true;
                                    //diaHabitual = true
                                    //añadimos a horario habitual e indicamos a true el diahabitual
                                    diaHabitual = true
                                    horarioHabitual = this.map_horario[`${empleado.id}_${moment(dia).weekday()}`];
                                //}                                   
                            }

                            
                        }
                        else
                        {                            
                            if (JSON.stringify(fecha) == JSON.stringify(actual)) {
                                horarioLibre = undefined
                                //diapintado = true;
                                diaLibre = true;
                            }
                        }
                    })
                    //comprobamos si el día actual es específico o habitual y dependiendo de esto se lo asignamos a horario_especial para devolverlo
                    if (diaEspecifico) {
                        horario_especial = horarioEspecifico;
                    }else if (diaLibre){
                        horario_especial = horarioLibre;
                    }else if (diaHabitual){
                        horario_especial = horarioHabitual;
                    }

                }
                
                // Comprobamos si el empleado tiene vacaciones ( variable fecha del array en crearIntervalos(n, dia_actual)) 
                // si no tiene vacaciones asignamos la entrada y salida de este dia actual ( habitual )
                if (empleado.vacaciones.length > 0) 
                {
                    // para evitar la entrada en todos los dias de vacaciones y que muestre de manera erroneo el horario
                    //  creamos una variable flag para marcar la entrada
                    let diavacaciones = false;
                    //  recorremos el horario vacaciones y asignamos la entrada y salida de este dia vacaciones
                    empleado.vacaciones.forEach(vacaciones => {
                        // Seteamos en variables la fecha especifica del dia recorrido y la fecha actual para realizar la comprobacion
                        let fechavacaciones = moment(`${vacaciones.fecha}`, 'YYYY-MM-DD HH:mm');
                        let actual = moment(`${dia}`, 'YYYY-MM-DD HH:mm');
                        // Verificamos que sean iguales para asignar la entrada y salida
                        if (JSON.stringify(fechavacaciones) == JSON.stringify(actual))
                        {
                            horario_especial = undefined;                             
                            // Si los dias coinciden marcamos el flag como true para no realice mas comprobaciones y marque mal el horario
                            diavacaciones = true;                            
                        }
                    })
                }
                
                return horario_especial;
            },            
            getFechas(empleado, dia) {
                return this.map_fecha[`${empleado.id}_${dia}`];
            },
            selectDay(weekday) {
                this.weekday = weekday
                this.dia_actual = weekday.full_date
                this.type = 'day'
            },
            agregarCitas(dia_actual) { // Lista las citas de la semana actual
                axios.get(`api/app/geteventsbymonth/${dia_actual}`).then(res => {
                    this.citas = res.data
                })
            },
            agregarCita(cita) {
                let start_of_week = this.week_days[0].full_date
                let end_of_week = this.week_days[this.week_days.length - 1].full_date
                let is_beetween = moment(cita.start.substring(0, 10)).isBetween(start_of_week, end_of_week, undefined, '[]')
                this.deleteCita(cita)
                if (is_beetween) {
                    this.citas.push(cita)
                }                
                this.agregarCitas(this.dia_actual);
            },
            deleteCita(cita) {
                let index = this.citas.findIndex(element => element.id == cita.id)
                if (index > -1) {
                    this.citas.splice(index, 1)
                }
            },
            calcularIntervalos() {
                let start = moment(`2021-03-26 ${this.entrada}`, 'YYYY-MM-DD HH:mm')
                let end = moment(`2021-03-26 ${this.salida}`, 'YYYY-MM-DD HH:mm')
                let diff = end.diff(start, 'minutes')
                let intervalos = _.range(diff / 30)
                this.intervalos = intervalos.map((element, index) => {
                    return start.clone().add(index * 30, 'minutes').format('HH:mm')
                })
            },  
            resetClientes(){
                this.overlay = true;
                axios.get('api/app/getusuarios').then(res => {
                    this.clientes = res.data;
                    this.overlay = false;

                    this.dialogo=false
                }, res => {
                    this.$toast.error('Error obteniendo Usuarios')
                })           
            },                  
            abrirbusqueda() {  // Abre busqueda
                this.dialogobuscar = true;
            }, 
        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
            month: function() {
                return moment(this.dia_actual).format('MMMM')
            },
            map_citas: function() {
                const map = {}
                this.citas.forEach(x => {
                    let fecha = x.start.substring(0, 10);
                    let ref = `${x.empleado}_${fecha}`;
                    (map[ref] = map[ref] || []).push(x)
                })
                return map
            },
            map_horario: function() {
                let horarios = this.empleados.flatMap(empleado => empleado.horario)
                const map = {}
                horarios.forEach(x => {
                    let ref = `${x.app_empleado_id}_${x.dia}`;
                    (map[ref] = map[ref] || []).push(x)
                })
                return map
            },
            map_fecha: function() {
                let fechas = this.empleados.flatMap(empleado => empleado.fecha)
                const map = {}
                fechas.forEach(x => {
                    let ref = `${x.app_empleado_id}_${x.fecha}`;
                    (map[ref] = map[ref] || []).push(x)
                })
                return map
            },
            week_days: function() {
                let current_date = moment(this.dia_actual)
                var week_start = current_date.clone().startOf('isoweek')
                let range_dates = _.range(7).map(x => {
                    let fecha = moment(week_start).add(x, 'days')
                    return {
                        numero_dia: fecha.format('DD'),
                        nombre_dia: fecha.format('dddd'),
                        full_date: fecha.format('YYYY-MM-DD')
                    }
                })
                return range_dates
            },
            set_week_days: function() {
                if (this.weekday && this.type == 'day') {
                    let i = this.week_days.findIndex(x => x.full_date == this.weekday.full_date)
                    return [this.week_days[i]]
                } else {
                    return this.week_days
                }
            }
        }
    }
</script>

<style media="screen">
    .dia-header {
        padding: 1px 1rem;
        text-align: center;
        border-left: #e0e0e0 0.5px solid;
        border-bottom: #e0e0e0 0.5px solid;
        border-top: #e0e0e0 0.5px solid;
    }
    .full-width {
        width: 100% !important;
    }
    .dia-header span {
        display: block;
    }
    .dia-container {
        display: flex;
    }
    .dia-component {
        min-width: 132px;
    }
    .cita-container {
        display: flex;
        width: 100%;
    }
    .calendar-wrapper {
        overflow: hidden;
        overflow-x: auto;
        overflow-y: scroll;
        display: flex;
    }
    .false_scroll {
        height: 20px;
        overflow-x: auto;
    }
    .false_scroll_container {
        width: 3500px !important;
        height: 10px;
        overflow-x: auto;
        display: flex;
    }
    @media (min-width:1900px) { 
        .empleado-row{
            height: 26px !important;
            width: 100% !important;
            padding-left: 5px;
            margin-right: 3px;
            font-size: 12px !important;
        }
        .empleado-column {
            width: inherit;
            min-height: auto;
            position: relative !important;
        }
        .cita-element{
            width: 99%;
            padding-left: 5px;
            margin-right: 2px;
            font-size: 12px !important;
            overflow: hidden !important;
        }
        .dia-header{
            height: 60px !important;
        }
        button#diabtn.v-btn{
            height: 50% !important;
        }
        #historial span {
            font-size: 9px !important;
        }
    }
</style>