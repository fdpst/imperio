export const calendar_basic_mixin = {
  data(){
    return {
      type: 'week',
      calendar_types: [{
              value: 'week',
              text: 'Semana'
          },
      ],
    }
  },

  watch: {
    '$route':{
      immediate: true,
      handler(n) {
        if(n.query.fecha) {          
          this.tienda = n.query.tienda
          this.dia_actual = n.query.fecha
          this.setWeekDay(n.query.fecha)
          this.type = 'day'
        }
      }
    }
  },

  methods:{
    setWeekDay(n){
      let fecha = moment(n)
      this.weekday = {
            numero_dia: fecha.format('DD'),
            nombre_dia: fecha.format('dddd'),
            full_date: fecha.format('YYYY-MM-DD')
        }
    },
    setToday() {
      this.dia_actual = moment().format('YYYY-MM-DD').substring(0, 10)
    },
    prev() {
      let add_day = moment(this.dia_actual).weekday() == 1 ? 2 : 1
      let add = this.type == 'week' ? 7 : add_day
      this.dia_actual = moment(this.dia_actual).subtract(add, 'days').format('YYYY-MM-DD')
    },
    next() {
      let add_day = moment(this.dia_actual).weekday() == 6 ? 2 : 1
      let add = this.type == 'week' ? 7 : add_day
      this.dia_actual = moment(this.dia_actual).add(add, 'days').format('YYYY-MM-DD')
    }
  }
}
