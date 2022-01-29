export const dias_ocupados_mixin = {
  methods:{

    addEvent(dia, nombre_empleado){  
      this.events.push({
          id: new Date().getUTCMilliseconds(),
          start: `${dia} 01:00:00`,
          end: `${dia} 23:00:00`,
          timed: true,
          category: nombre_empleado,
          color: '#f91717',
          name: 'No disponible',
          dia_libre: true
      })
    },

    addEvents(lista_empleados, mes){
      if(lista_empleados.length == 0){
        return null
      }
      /*recorrer lista de empleados*/
      lista_empleados.forEach(empleado => {
         /*
         combinar dias libres y vacaciones en un arreglo
         el array resultante tendra las fechas en formato "yyyy-mm-dd"
         ejemplo: 2020-11-11
         */

         let libres_and_vacaciones = _.union(empleado.lista_libres, empleado.lista_vacaciones)

         if (libres_and_vacaciones.length == 0) {
            return null;
         }

         /*filtrar los dias encontrados por mes*/
         let filter_by_month = libres_and_vacaciones.filter(x => x.substring(5,7) == mes)

         if (filter_by_month == 0) {
            return null;
         }

         /*añadir una cita falsa por cada dia encontrado*/
         filter_by_month.forEach(x => this.addEvent(x, empleado.nombre))

      })
    }
  }
}
