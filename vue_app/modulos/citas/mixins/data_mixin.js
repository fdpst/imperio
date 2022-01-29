export const data_mixin = {
  data(){
    return {
      tienda: 8,

      tiendas:[],

      empleados: [],

      servicios:[],

      clientes:[]
    }
  },
  methods:{
    getTiendas() {
        axios.get(`api/app/gettiendas`).then(res => {
            this.tiendas = res.data
                        
        }, res => {
            this.$toast.error('Error consultando tiendas')
        })
    },

    getData(nombre_tipo, tienda_id){
      console.log("GETDATA")
      console.log(nombre_tipo)
      console.log(tienda_id)
      axios.get(`api/app/getdata/${nombre_tipo}/${tienda_id}`).then(res => {
        this.empleados = res.data.empleados
        console.log("EMPLEADOS")
        console.log(this.empleados)
        this.servicios = res.data.servicios
        console.log("SERVICIOS")
      console.log(this.servicios)
        this.clientes = res.data.clientes
        console.log("CLIENTES")
      console.log(this.clientes)
        this.agregarCitas(this.dia_actual)
        this.overlay = false;
        
      }, res => {

      })
    }

  }
}
