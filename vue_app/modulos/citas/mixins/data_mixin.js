export const data_mixin = {
  data(){
    return {
      tienda: 1,

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
      axios.get(`api/app/getdata/${nombre_tipo}/${tienda_id}`).then(res => {
        this.empleados = res.data.empleados
        this.servicios = res.data.servicios
        this.clientes = res.data.clientes
        this.agregarCitas(this.dia_actual)
        this.overlay = false;
        
      }, res => {

      })
    }

  }
}
