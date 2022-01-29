<template>
    <div :class="[type == 'week' ? 'week' : 'day', {'hide-column' : !horario}]" class="empleado-column">
        <div class="empleado-nombre">
            <v-chip :color="empleado.color" :to="{ path: `/guardar-empleado-app?id=${empleado.id}` }" small class="white--text">
             {{empleado.nombre}} </v-chip>
        </div>
        <!-- horario libre del empleado seccion claro-->
        <div @click="openForm()" v-for="(intervalo, i) in intervalos" class="empleado-row" 
            :style="{ height: interval_height + 'px'}" :ref="`${empleado.nombre}_${dia_actual}_${intervalo}`" 
            v-if="horario && empleadoHorario(`${empleado.nombre}_${dia_actual}_${intervalo}`)"> 
            {{intervalo}}
        </div>
        <!-- horario trabajable del empleado seccion oscura-->
        <div v-else :style="{ height: interval_height + 'px'}" class="empleado-row disabled-row">{{intervalo}} </div> 
        <!-- seccion de la cita de la mascota del color del empleado que tiene el servicio asignado -->
        <div @click="setCita(cita)" v-for="cita in local_citas" :key="cita.id" :style="[timeToY(cita)]" class="cita-element">
             <v-icon v-if="!cita.confirmada" small color="white">mdi-alert-circle</v-icon>
            <i style="text-transform:capitalize;">{{cita.usuario}} - {{cita.telefono}}</i>
        </div>      
    </div>    
</template>

<script>
    import {EventBus} from '../handlers/eventbus';
    export default {
        props: ['intervalos', 'empleado', 'citas', 'horario', 'dia_actual', 'interval_height', 'fechas', 'type', 'app_tienda_id'],
        data() {
            return {
                local_citas: [],
                local_intervalos: {}
            }
        },
        watch: {
            'citas': {
                immediate: true,
                handler(n) {
                    this.$nextTick(function() {
                        this.local_citas = n
                    })
                }
            },
            'horario': {
                immediate: true,
                handler(n) {
                    n ? this.agregarHorarioPorEmpleado(n, this.dia_actual) : null
                }
            },
            'fechas': {
                /*immediate: true,
                handler(n) {
                    n ? this.sobreEscribirHorario(n, this.dia_actual) : null
                }*/
            },
            'dia_actual': {
                handler(n) {                    
                    this.horario ? this.agregarHorarioPorEmpleado(this.horario, n) : null
                }
            },
            'app_tienda_id':{
                inmediate:true,
                handler(n) {    
                    this.local_intervalos={}
                }
            }
        },
        methods: {

            // crearIntervalos(n, dia_actual) {         
            //     let intervalos = n.forEach(habitual => {
            //             // Comprobamos los intervalos de horario de los trabajadores para verificar 
            //             // su horario habitual, horario especifico y sus vacaciones
            //             // inicializamos las variable de entrada y salida
            //             let start = '';
            //             let end = '';
            //             // Comprobamos si el empleado tiene un horario especifico ( variable fecha del array en crearIntervalos(n, dia_actual)) 
            //             // si no tiene horario especifico asignamos la entrada y salida de este dia actual ( habitual )
            //             // y verificamos que el id del horario del empleado sea de la tienda seleccionada
            //                 if (this.empleado.fecha.length == 0) 
            //                 {
            //                     start = moment(`${dia_actual} ${habitual.entrada}`, 'YYYY-MM-DD HH:mm')
            //                     end = moment(`${dia_actual} ${habitual.salida}`, 'YYYY-MM-DD HH:mm')
            //                 }
            //                 // si tiene horario especifico asignamos la entrada y salida de este dia actual ( especifico ) 
            //                 else
            //                 {
            //                     // para evitar la entrada en todos los dias especificos y que muestre de manera erroneo el horario
            //                     //  creamos una variable flag para marcar la entrada
            //                     let diapintado = false;
            //                     //  recorremos el horario especifico y asignamos la entrada y salida de este dia especifico
            //                     this.empleado.fecha.forEach(especifico => {
            //                         // Seteamos en variables la fecha especifica del dia recorrido y la fecha actual para realizar la comprobacion
            //                         let fecha = moment(`${especifico.fecha}`, 'YYYY-MM-DD HH:mm');
            //                         let actual = moment(`${dia_actual}`, 'YYYY-MM-DD HH:mm');
            //                         // Verificamos que sean iguales para asignar la entrada y salida
            //                         if (this.app_tienda_id == especifico.app_tienda_id)
            //                         {
            //                             if (JSON.stringify(fecha) == JSON.stringify(actual))
            //                             {
            //                                 start = moment(`${dia_actual} ${especifico.entrada}`, 'YYYY-MM-DD HH:mm')
            //                                 end = moment(`${dia_actual} ${especifico.salida}`, 'YYYY-MM-DD HH:mm')
            //                                 // Si los dias coinciden marcamos el flag como true para no realice mas comprobaciones y marque mal el horario
            //                                 diapintado = true;
            //                             }
            //                             else
            //                             {                     
            //                                 // Si los dias no coinciden marcamos el flag y el horario como habitual
            //                                 if (diapintado == false) {
            //                                     start = moment(`${dia_actual} ${habitual.entrada}`, 'YYYY-MM-DD HH:mm')
            //                                     end = moment(`${dia_actual} ${habitual.salida}`, 'YYYY-MM-DD HH:mm')
            //                                 }                                   
            //                             }
            //                         }
            //                         else
            //                         {
            //                         // En caso de que trabaje en otra localizacion diferente a la habitual marcara el dia como no habil
            //                             if (JSON.stringify(fecha) == JSON.stringify(actual) && diapintado == false) {
            //                                 let hora = '00:00';
            //                                 start = moment(`${dia_actual} ${hora}`, 'YYYY-MM-DD HH:mm');
            //                                 end = moment(`${dia_actual} ${hora}`, 'YYYY-MM-DD HH:mm');
            //                                 diapintado = true;
            //                             }
            //                         }
            //                     })
            //                 }

            //                 // Comprobamos si el empleado tiene vacaciones ( variable fecha del array en crearIntervalos(n, dia_actual)) 
            //                 // si no tiene vacaciones asignamos la entrada y salida de este dia actual ( habitual )
            //                 if (this.empleado.vacaciones.length == 0) 
            //                 {
            //                     start = moment(`${dia_actual} ${habitual.entrada}`, 'YYYY-MM-DD HH:mm')
            //                     end = moment(`${dia_actual} ${habitual.salida}`, 'YYYY-MM-DD HH:mm')
            //                 }
            //                 // si tiene vacaciones asignamos la entrada y salida de este dia actual ( vacaciones ) 
            //                 else
            //                 {
            //                     // para evitar la entrada en todos los dias de vacaciones y que muestre de manera erroneo el horario
            //                     //  creamos una variable flag para marcar la entrada
            //                     let diavacaciones = false;
            //                     //  recorremos el horario vacaciones y asignamos la entrada y salida de este dia vacaciones
            //                     this.empleado.vacaciones.forEach(vacaciones => {
            //                         // Seteamos en variables la fecha especifica del dia recorrido y la fecha actual para realizar la comprobacion
            //                         let fechavacaciones = moment(`${vacaciones.fecha}`, 'YYYY-MM-DD HH:mm');
            //                         let actual = moment(`${dia_actual}`, 'YYYY-MM-DD HH:mm');
            //                         // Verificamos que sean iguales para asignar la entrada y salida
            //                         if (JSON.stringify(fechavacaciones) == JSON.stringify(actual))
            //                         {
            //                             let hora = '00:00';
            //                             start = moment(`${dia_actual} ${hora}`, 'YYYY-MM-DD HH:mm')
            //                             end = moment(`${dia_actual} ${hora}`, 'YYYY-MM-DD HH:mm')
            //                             // Si los dias coinciden marcamos el flag como true para no realice mas comprobaciones y marque mal el horario
            //                             diavacaciones = true;
            //                         }
            //                     })
            //                 }  
            //             // Despues de asignar la entrada y salida diaria del trabajador en cualquiera de los horarios 
            //             // horario habitual, horario especifico y/o vacaciones asignamos cada seccion de 30 minutos al empleado para citas
            //             let diff = end.diff(start, 'minutes')
            //             let intervalos = _.range((diff / 30))
            //             intervalos.forEach((element, index) => {
            //                 let n = start.clone().add(index * 30, 'minutes').format('YYYY-MM-DD_HH:mm')
            //                 let ref = `${this.empleado.nombre}_${n}`;
            //                 (this.local_intervalos[ref] = this.local_intervalos[ref] || []).push(ref)
            //             })
            //     })
            // },

            crearIntervalos(n, dia_actual) {
                 let intervalos = n.forEach(element => {
                    let start = moment(`${dia_actual} ${element.entrada}`, 'YYYY-MM-DD HH:mm')
                    let end = moment(`${dia_actual} ${element.salida}`, 'YYYY-MM-DD HH:mm')
                    let diff = end.diff(start, 'minutes')
                    let intervalos = _.range((diff / 30))
                    intervalos.forEach((element, index) => {
                        let n = start.clone().add(index * 30, 'minutes').format('YYYY-MM-DD_HH:mm')
                        let ref = `${this.empleado.nombre}_${n}`;
                        (this.local_intervalos[ref] = this.local_intervalos[ref] || []).push(ref)
                    })
                })
            },
            sobreEscribirHorario(n, dia_actual) {
                this.local_intervalos = {}
                this.crearIntervalos(n, dia_actual)
            },
            agregarHorarioPorEmpleado(n, dia_actual) {
                let fecha_revision = moment('2021-11-15', 'YYYY-MM-DD')
                
                if (this.fechas && this.fechas.length > 0) {
                    this.local_intervalos = {}
                    return this.crearIntervalos(this.fechas, dia_actual)
                }
                this.crearIntervalos(n, dia_actual)
            },
            empleadoHorario(ref) {
                return this.local_intervalos[ref]
            },
            openForm() {
                EventBus.$emit('open_form', {
                    app_empleado_id: this.empleado.id,
                    fecha: this.dia_actual
                })
            },
            setCita(cita) {
                EventBus.$emit('set_cita', cita)
            },
            timeToY(cita) {
                let ref_date = `${cita.start.substring(0, 10)}_${cita.start.substring(11)}`
                let ref_name = `${this.empleado.nombre}_${ref_date}`
                if (this.$refs[ref_name] !== undefined && this.$refs[ref_name][0]) {
                    return {
                        display: 'block',
                        top: `${this.$refs[ref_name][0].offsetTop}px`,
                        height: `${(cita.duracion / 30) * this.interval_height}px`,
                        backgroundColor: cita.color
                    }
                }
                return {
                    display: 'none'
                }
            },
            minutesToPixels(duracion) {
                return (duracion / 30) * this.interval_height
            },
            getcolor() {
                return `#${(Math.random()*0xFFFFFF<<0).toString(16)}`
            }
        }
    }
</script>

<style media="screen">
    .hide-column {
        display: none !important;
    }
    .empleado-nombre {
        width: 100%;
        padding: 0.1rem;
        text-align: center;
        text-transform: uppercase;
        font-size: 4px;
    }
    .empleado-column {
        min-height: 100vh;
        position: relative;
    }
    .week {
        /*width: 100px;*/
        width: inherit;
    }
    .day {
        width: inherit;
    }
    .empleado-row {
        border-right: #e0e0e0 1px solid;
        border-bottom: #e0e0e0 1px solid;
        height: 40px;
        width: auto;
        font-size: 12px;
    }
    .empleado-row1 {
        border-right: #e0e0e0 1px solid;
        border-bottom: #e0e0e0 1px solid;
        height: 90px;
        width: 292px;
        font-size: 19px;
    }
    .disabled-row {
        background-color: #485772;
        color: #ffffff !important;
    }
    .cita-element {
        position: absolute;
        left: 0px;
        width: 99%;
        background-color: #1e5dbf;
        border-radius: 8px;
        border: solid 1px #fff;
        padding: 3px;
        color: #fff;
        font-size: 12px;
    }
</style>