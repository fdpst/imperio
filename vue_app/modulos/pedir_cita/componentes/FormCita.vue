<template>    
  <v-container grid-list-xs class="mx-auto container-responsive" fluid>
    <v-toolbar color="red lighten-2" dark class="mx-auto">
        <v-toolbar-title>Pedir Cita</v-toolbar-title>
    </v-toolbar>
    <v-sheet shaped class="ma-md-4 pa-md-4 sheel-responsive">        
      <div class="background my-container container-responsive">
        <loader v-if="isloading"></loader>
        <v-row>
          <v-col cols="12" md=12>
            <v-form>
              <v-stepper v-model="e1">
                <v-stepper-header>
                  <div class="mx-auto my-auto text-center" v-if="e1 == 1">
                    <h4
                    class="mx-auto my-auto text-xs-body-1"
                    >
                      LISTADO TIENDAS Y SERVICIOS
                    </h4>
                  </div>
                  <v-row v-if="e1 == 2" align="center" justify="space-between" class="mx-2">
                    <v-col cols="auto" class="container-responsive">
                      <v-btn
                        icon
                        color="red lighten-2"
                        @click="e1=1"
                      >
                        <v-icon>mdi-chevron-left</v-icon>
                      </v-btn>
                    </v-col>
                    <v-col cols="auto" class="container-responsive">
                      <h4>
                        FECHA - HORA - EMPLEADO
                      </h4>
                    </v-col>
                    <v-col cols="auto" class="container-responsive">
                      <v-btn
                        icon
                        small
                        @click="e1=1"
                      >
                        <v-icon small>mdi-close</v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>
                  <v-row v-if="e1 == 3" align="center" justify="space-between" class="mx-2">
                    <v-col cols="auto" class="container-responsive">
                      <v-btn
                        icon
                        color="red lighten-2"
                        @click="e1=2"
                      >
                        <v-icon>mdi-chevron-left</v-icon>
                      </v-btn>
                    </v-col>
                    <v-col cols="auto" class="container-responsive">
                      <h4>
                        SUS DATOS PARA LA CITA
                      </h4>
                    </v-col>
                    <v-col cols="auto" class="container-responsive">
                      <v-btn
                        icon
                        small
                        @click="e1=1"
                      >
                        <v-icon small>mdi-close</v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-stepper-header>

                <v-stepper-items>
                  <v-stepper-content step="1" class="pa-1">
                    <cita-servicios 
                      ref="citaServicios" 
                      :servicios="servicios" 
                      :tiendas="tiendas"
                      @selectServicios="selectServicios" 
                      @getData="getData"
                    ></cita-servicios>
                    <v-divider></v-divider>
                    <div class="mt-2 mx-4 d-flex justify-space-between align-center">
                      <div>
                        <!--<p class="text-caption"> Total:</p>
                        <h4 class="red--text text--lighten-2 text-h5">{{total.toFixed(2)}} <v-icon class="red--text text--lighten-2">mdi-currency-eur</v-icon></h4>-->
                      </div>
                      <v-btn
                        :disabled="total <= 0"
                        color="red lighten-2"
                        dark
                        @click="tapFecha()"
                      >
                        <v-icon dark>
                          mdi-arrow-right
                        </v-icon>
                      </v-btn>
                    </div>
                  </v-stepper-content>

                  <v-stepper-content step="2" class="pa-1">
                    <cita-fecha 
                    ref="citaFecha"
                    :empleados="n_empleados" 
                    :duracion="duracion"
                    @tapCliente="tapCliente" 
                    :tienda="tienda"
                    ></cita-fecha>
                  </v-stepper-content>

                  <v-stepper-content step="3" class="pa-1">
                    <form-cliente ref="formCliente" :formData="formData" @clearFormulario="clearFormulario"></form-cliente>
                  </v-stepper-content>
                </v-stepper-items>
              </v-stepper>
            </v-form>
          </v-col>
        </v-row>
      </div>
    </v-sheet>
  </v-container>
</template>

<script>
import CitaServicios from '../componentes/servicios'
import CitaFecha from '../componentes/fecha'
import FormCliente from '../componentes/formCliente'
  export default {
    components:
    {
      CitaServicios,
      CitaFecha,
      FormCliente
    },
    data() {
      return {
        e1: 1,
        total:0,
        empleado: {
          id: '',
          nombre: '',
          email: '',
          telefono: '',
          is_active: true,
          lista_vacaciones: [],
        },
        servicios: [],
        empleados: [],
        clientes: [],
        horas_disponibles: [],
        n_empleados: [],
        duracion:0,
        formData:{},
        tiendas: [],
        tienda:null
      }
    },
    created() {
      if (this.$route.query.id) {
        this.getEmpleado(this.$route.query.id)
      }
    },
    mounted()
    {
      //this.getData();
      this.getTiendas();
    },
    methods: {
      sendData(){
      
      },
      getEmpleado(empleado_id) {
        axios.get(`api/getempleado/${empleado_id}`).then(res => {
          this.empleado = res.data
        }, res => {

        })
      },
      getTiendas() {
        axios.get(`api/app/gettiendascita`).then(res => {
            this.tiendas = res.data
                        
        }, res => {
            this.$toast.error('Error consultando tiendas')
        })
      },
      tapFecha(){
        this.formData.servicios = this.$refs.citaServicios.radioGroup;
        this.formData.duracion = this.duracion;
        this.formData.pago = 0;
        this.formData.confirmada = 1;
        this.formData.precio = this.total;
        this.formData.recogida = 0;
        this.formData.tipo = "peluqueria";
        this.formData.tipo_id = 1;
        this.formData.app_tienda_id = this.$refs.citaServicios.tienda;
        this.tienda = this.$refs.citaServicios.tienda;
        this.formData.color = null;
        this.formData.direccion_entrega = null;
        this.formData.direccion_recogida = null;
        this.formData.recogida = false;
        this.formData.observacionesMascota = "";
        this.formData.observacionesUsuario = "";

        this.e1 = 2;
        this.$refs.citaFecha.buscarDisponible();
      },
      tapCliente(){
        this.e1 = 3
        this.formData.fecha = this.$refs.citaFecha.fecha;
        this.formData.app_empleado_id = this.$refs.citaFecha.empleadoId;
        this.formData.start = `${this.formData.fecha} ${this.$refs.citaFecha.horario}`
        this.formData.end = moment(this.formData.start).clone().add(this.formData.duracion, 'minutes').format('YYYY-MM-DD HH:mm')
      },
      selectServicios()
      {
        this.total = 0;
        this.duracion = 0;
        this.tienda = this.$refs.citaServicios.tienda;
        //console.log(this.$refs.citaServicios)
        this.$refs.citaServicios.radioGroup.forEach((element) => {
          //console.log(element)
          this.total = this.total + element.precio;
          this.duracion = this.duracion + element.duracion;
        })
      },
      clearFormulario()
      {
        this.e1 =  1;
        this.total = 0;
        this.duracion = 0;
        this.formData = {};
        this.$refs.citaFecha.fecha = null;
        this.$refs.citaFecha.nextTab = true;
        this.$refs.citaServicios.radioGroup = [];
      },
      getData(tienda) {
        this.servicios = [];
        this.tienda = this.$refs.citaServicios.tienda;
        axios.get(`api/app/getdata/peluqueria/${tienda}`).then(res => {
          this.empleados = res.data.empleados.map(x => x.nombre)
          this.n_empleados = res.data.empleados
          this.clientes = res.data.clientes
          this.servicios = res.data.servicios
          this.horas_disponibles = res.data.horas_disponibles
          console.log("EMPLEADOS")
          //console.log(this.n_empleados)
        }, res => {
            this.$toast.error('Algo ha salido mal')
        })
    },
      saveEmpleado() {
        axios.post('api/saveempleado', this.empleado).then(res => {
          this.$router.push('lista-empleados')
        }, res => {

        })
      },
      deleteEmpleado() {
        axios.get(`api/deleteempleado/${this.empleado.id}`).then(res => {
          this.$router.push('lista-empleados')
        }, res => {

        })
      }
    },
    computed: {
      isloading() {
        return this.$store.getters.getloading
      },

    }
  }
</script>
<style>

@media (max-width: 600px) {
  .container-responsive {
    padding: 0px !important;
  }
  .sheel-responsive
  {
    padding: 0px !important;
    margin: 0px !important;
    border-radius: 0px 0 !important
  }
}

</style>