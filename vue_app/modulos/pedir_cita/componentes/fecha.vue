<template>
  <div style="width: 100% !important;">
    <v-row
      align="center"
    >
      <v-col cols="12" class="padding-responsive">
      <v-autocomplete
        v-model="empleado"
        :items="local_empleados"
        item-text="nombre"
        item-value="id"
        outlined
        chips
        color="red lighten-2"
        class="ma-4 mx-4 border-autocomplete"
        @change="buscarDisponible"
      >
        <template v-slot:selection="data">
          <div>
            <v-list-item>
              <v-list-item-avatar>
                <v-icon
                  class="rounded-circle grey lighten-4"
                >
                  mdi-account-multiple-outline
                </v-icon>
              </v-list-item-avatar>

              <v-list-item-content>
                <v-list-item-title >{{data.item.nombre}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </div>
        </template>
      </v-autocomplete>
      </v-col>
    </v-row>
    <v-container class="container-responsive mx-auto">
      <v-row class="mb-md-10 mb-2">
        <v-col cols="12">
          <div ref="calnedar_wrap" v-on:scroll.pasive="scrollFunction" class="calendar-wrapper">
            <div class="dia-container full-width text-center justify-center align-center">
              <div>
                <v-btn fab text small color="grey darken-2" class="" @click="prev"><v-icon small>mdi-arrow-left</v-icon></v-btn>
              </div>
              <div v-for="(weekday, i) in set_week_days" :key="i" class="dia-component full-width">
                <!-- <v-btn class="dia-header text-center" height="auto" @click="selectDay(weekday)" :class="{'red lighten-2 white--text' : weekday.full_date == current_day_inmutable}">-->

              <!-- // Deshabilita fecha si es anterior a dia actual para pedir citas -->
                  <v-btn class="dia-header text-center" height="auto" @click="selectDay(weekday)" :disabled="disabledFecha(weekday.full_date)" 
                        :class="{'red lighten-2 white--text' : weekday.full_date == current_day_inmutable}">
              <!-- // Deshabilita fecha si es anterior a dia actual para pedir citas -->

                  <span> {{selectDia(weekday.full_date)}}</span> 
                  <!-- <v-btn id="diabtn" @click="selectDay(weekday)" :class="{'green white--text' : weekday.full_date == current_day_inmutable}">
                  </v-btn> -->
                  <span class="text-md-h5 text-responsive-dia"> {{weekday.numero_dia}} </span>
                  <span>{{selectMes(weekday.full_date)}}</span>
                </v-btn>
              </div>
              <div>
                <v-btn fab text small color="grey darken-2" @click="next" class=""><v-icon small>mdi-arrow-right</v-icon></v-btn>
              </div>
            </div>
          </div>
        </v-col>
      </v-row>
      <v-divider></v-divider>
      <v-responsive
      class="overflow-y-auto"
      :max-height="height"
       >
      <v-row class="mt-2 mb-3" dense v-for="empleado in local_horario" :key="empleado.app_empleado_id">
        <v-col cols="12">
            <v-chip v-if ="empleado.horario.length>0" small color="green" outlined><v-icon left>mdi-account-clock</v-icon>{{empleado.nombre_empleado}}</v-chip>
        </v-col>
        <v-col v-for="(item, i) in empleado.horario" :key="i" cols="3">                                    
          <v-btn elevation="2" @click="asignarDatos(item, empleado.app_empleado_id)" rounded
            small block :color="isSelect2(item, empleado.app_empleado_id)">{{item}}
          </v-btn>                                    
        </v-col>
      </v-row>
      </v-responsive>
    </v-container>
    <v-divider></v-divider>
    <div class="mt-2 d-flex justify-end align-center">
      <v-col col="6">
        <v-btn
          color="red lighten-2"
          dark
          @click="$emit('pasoAtras')"
        >ATRÁS
          <!-- <v-icon small>Atrás</v-icon> -->
        </v-btn>
      </v-col>
      <v-col col="6">
      <v-btn
        color="red lighten-2"
        dark
        @click="$emit('tapCliente')"
        :disabled="nextTab"
      >CONTINUAR
      </v-btn>
      </v-col>
    </div>
  </div>
</template>

<script>
  import { calendar_basic_mixin } from '../../citas/mixins/calendar_basic_mixin'
  export default {
    mixins: [calendar_basic_mixin],
    props:['empleados', 'duracion', 'tienda'],
    data: () => ({
      empleado: null,
      dia_actual: moment().format('YYYY-MM-DD').substring(0, 10),
      current_day_inmutable: moment().format('YYYY-MM-DD').substring(0, 10),
      fecha : null,
      filtrohoras: false,
      local_horario: [],
      horario:null,
      empleadoId:null,
      nextTab:true,
      horas: [],
      local_empleados: [],
      height:(window.innerHeight*0.4).toFixed(),

    }),
    mounted()
    { 
      //this.buscarDisponible();
    },
    methods:
    {
      isSelect2(item, empleadoId) {  // Color de horario seleccionado                        
        if (item == this.horario  && this.empleadoId == empleadoId ) 
        {
            return 'green lighten-4';
        }
            return 'grey lighten-3';
      },

      // Deshabilita fecha si es anterior a dia actual para pedir citas
      disabledFecha(fecha)
      {
        var fechaActua = new Date(moment().format('YYYY-MM-DD'));
        var fechaCalendario = new Date(fecha);
        if(fechaActua <= fechaCalendario)
        {
          return false
        }
        return true
      },
      // Deshabilita fecha si es anterior a dia actual para pedir citas

      selectDay(valor){
        this.fecha = valor.full_date;
        this.current_day_inmutable = valor.full_date;
        this.buscarDisponible();
      },
      selectMes(fecha)
      {
        return moment(fecha).format('MMM').toUpperCase()
      },
      selectDia(fecha)
      {
        return moment(fecha).format('ddd').toUpperCase()
      },
      buscarDisponible() { // Evento boton busca disponible
        this.nextTab = true;
        if (this.fecha ==null){
            this.fecha = moment().format('YYYY-MM-DD')
        }                
        let data = { 
          id: null,
          fecha: this.fecha,
          tienda_id: this.tienda,
          tipo: 'peluqueria',
          empleado_id: this.empleado,
        }
        axios.post(`api/app/buscar-horario-disponible`, data).then(res => {
          this.horas = this.filtrarHoras(res.data);
          this.$toast.sucs('consulta realizada');
        }, res => {})
      },
      asignarDatos(item, empleado) { // Boton guardar cuando se selecciona la hora de la cita
            this.horario = item;
            this.empleadoId = empleado;
            this.nextTab = false;
      }, 
      filtrarHoras(lista_empleados) { // busca horas de trabajo utilizable por empleado
        this.local_horario = lista_empleados.map(element => {
          return {
            app_empleado_id: element.app_empleado_id,
            nombre_empleado: element.nombre_empleado,
            horario: this.filtrar_90_minutos(element.diferencia, this.duracion)
          }
        })
      },
      filtrar_90_minutos(lista_horas, duracion) { // saca listado de horario disponible por empleado
        let lista = []
        if (lista_horas){
          lista_horas.forEach((element, index, self_array) => {
      
              let start = moment(`2021-03-26 ${element}`, 'YYYY-MM-DD HH:mm')
              let num_inter = duracion/15;
              let intervalos = _.range((duracion / 15)).map(x => (x + 1) * 15)
              let intervalos_completos = [0, ...intervalos]
              let horas = intervalos_completos.map(x => {
                  return start.clone().add(x, 'minutes').format('HH:mm')
              })
              let eliminar_inicio = _.dropRight(horas, 1)
              let encaja = _.difference(eliminar_inicio, self_array).length === 0                                               
              if (encaja) {
                  lista.push(element)
              }
          })
        }
        return lista
      },
    },
    watch:
    {
      'empleados'(n) {
          this.local_empleados = JSON.parse(JSON.stringify(n))
          this.local_empleados.unshift({ id: null,nombre: 'Todos Los empleados'})
      },
    },
    computed: 
    {
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

<style>
.full-width {
    width: 100% !important;
}
.calendar-wrapper {
    display: flex;
}

.dia-header span {
    display: block;
}
.dia-header {
  padding: 8px !important;
  font-size: 0.7rem !important;
}
.dia-container {
    display: flex;
}
.dia-component {
    min-width: 120px;
}

@media (max-width: 1200px) {
  .dia-component{
    min-width: 0px !important;
  }
  .dia-header
  {
    min-width: 10px !important;
  font-size: 0.6rem !important;
  }
  .padding-responsive
  {
    padding-bottom: 0px !important;
  }
}
@media (max-width: 600px) {
  .dia-header
  {
    min-width: 10px !important;
  }
}
@media (max-width: 460px) {
  .dia-header
  {
    min-width: 10px !important;
    font-size: 0.5rem !important;
  }
  .text-responsive-dia
  {
    font-size: 1rem !important;

  }
}
@media (max-width: 390px) {
  .dia-header
  {
    padding: 4px !important;
    font-size: 0.5rem !important;
  }
}
</style>