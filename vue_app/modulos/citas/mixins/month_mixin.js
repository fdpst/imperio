export const month_mixin = {
  methods:{
    clickOnDateMonth(data) {
        this.focus = data.date
        this.calendar_type = 'category'
    },
    clickOnMoreMonth(data) {
        this.eventos_del_dia = this.events.filter(x => {
            return moment(x.start).format('YYYY-MM-DD') == data.date
        })
        this.day_dialog = true
    }
  }
}
