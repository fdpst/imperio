export const empleados_mixin = {
  data(){
    return {
      empleados: []
    }
  },

  created(){
    axios.get(`api/getempleados`).then(res => {
      this.empleados = res.data
    }, res => {
      this.$toast.error('Error consultando empleados')
    })
  }
}
