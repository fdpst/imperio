export const category_mixin = {
  methods:{
    clickOnCategoryTime(category) {
        this.start = this.getTimeForEvent(category)
        this.day = category.date
        this.empleado = category.category
        this.dialog = true
    },
    clickOnEvent(evento) {
        if (this.calendar_type == 'category') {
            this.$emit('click_on_evento', evento.event)
        }
    }
  }
}
