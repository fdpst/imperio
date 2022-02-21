<template>

    <div :class="[type == 'week' ? 'week' : 'day', {'hide-column' : !horario}]" class="empleado-column">
        
        <div class="empleado-nombre">
            <v-chip :color="empleado.color" :to="{ path: `/guardar-empleado-app?id=${empleado.id}` }" small class="white--text">
             {{empleado.nombre}} </v-chip>
        </div>
        <!-- horario libre del empleado seccion claro-->
       

        <div @click="openForm(intervalo)" v-for="(intervalo, i) in intervalos" class="empleado-row" 
            :style="{ height: interval_height + 'px'}" :ref="`${empleado.nombre}_${dia_actual}_${intervalo}`" 
            v-if="horario && empleadoHorario(`${empleado.nombre}_${dia_actual}_${intervalo}`)"> 
            {{intervalo}}
            <div ></div>
        </div>
        
        <!-- horario trabajable del empleado seccion oscura-->
        <div v-else :style="{ height: interval_height + 'px', 'display':'none'}" class="empleado-row disabled-row">{{intervalo}} </div> 
          <div :style="{'position': 'absolute', 'min-width':'100%', 'top':interval_height + 'px'}">
           <draggable v-model="local_citas" :group="'dia_actual'" @start="StartDrag" @end="EndingDrag" :move="checkMove">
             
        <!-- seccion de la cita de la mascota del color del empleado que tiene el servicio asignado -->
        <div v-for="cita in local_citas" :key="cita.id"  :style="[timeToY(cita)]" class="cita-element-2" >
            <div v-if="cita.id >= 0" :style="[HeighttoY(cita)]" @click="setCita(cita)">
                <v-icon   v-if="!cita.confirmada" small color="white">mdi-alert-circle</v-icon>
                <i style="text-transform:capitalize;">{{cita.usuario}} - {{cita.telefono}}</i>
            </div>  
            <div v-else style="min-height:100%;min-width:100%"  @click="openForm(cita.intervalo)"></div>
            
        </div>
    
              </draggable>
                  </div>
             
       
            
    </div>    
</template>

<script>
 import draggable from 'vuedraggable'
    import {EventBus} from '../handlers/eventbus';
    export default {
         components: {
            draggable,
        },
        props: ['intervalos', 'empleado', 'citas', 'horario', 'dia_actual', 'interval_height', 'fechas', 'type', 'app_tienda_id','tipo'],
        data() {
            return {
                myArray: [
  {
    "name": "vue.draggable",
    "order": 1
  },
  {
    "name": "draggable",
    "order": 2
  },
  {
    "name": "component",
    "order": 3
  },
  {
    "name": "for",
    "order": 4
  },
  {
    "name": "vue.js 2.0",
    "order": 5
  },
  {
    "name": "based",
    "order": 6
  },
  {
    "name": "on",
    "order": 7
  },
  {
    "name": "Sortablejs",
    "order": 8
  }
],              indexes :[],
                local_citas: [],
                local_intervalos: {}
            }
        },
        watch: {
            'citas': {
                immediate: true,
                handler(n) {
                    this.$nextTick(function() {
                        let resultado = [];
                        let index = 0; 
                        for(let i = 0; i < this.intervalos.length; i ++){
                            
                            if(n.length > 0 ){
                                
                                for(let y = 0 ; y < n.length ; y++){
                                    let fecha = n[y].start.substring(11);
                                    if(!(this.horario && this.empleadoHorario(`${this.empleado.nombre}_${this.dia_actual}_${this.intervalos[i]}`))){
                                        resultado[i] = {'id':-1,'intervalo':this.intervalos[i],'locked':true,'par':-1,'dia':this.dia_actual};
                                        break;
                                    }
                                    if(fecha == this.intervalos[i]){
                                        resultado[i] = n[y];
                                        let diferencia = Math.round(resultado[i].duracion / 15) -1;
                                        resultado[i].intervalo = this.intervalos[i];
                                        console.log(diferencia);
                                        
                                        for(let q = i+1 ; q<=i+diferencia;q++){
                                            resultado[q] = {'id':-1,'intervalo':this.intervalos[q],'locked':true,'par':resultado[i].id,'dia':this.dia_actual};
                                        }
                                        i+= diferencia;
                                        break;
                                    }
                                    else{
                                        resultado[i] = {'id':-1,'intervalo':this.intervalos[i],'locked':false,'dia':this.dia_actual};
                                    }
                                }
                                index++;
                                  
                            }else{
                                resultado[i] = {'id':-1,'intervalo':this.intervalos[i],'dia':this.dia_actual};
                            if(!(this.horario && this.empleadoHorario(`${this.empleado.nombre}_${this.dia_actual}_${this.intervalos[i]}`))){
                                        resultado[i] = {'id':-1,'intervalo':this.intervalos[i],'locked':true,'par':-1,'dia':this.dia_actual};
                                        
                                    }
                            }
                          
                          
                        }
                        console.log("intervalos")
                        console.log(this.intervalos);
                        
                        console.log(resultado);
                        this.local_citas = resultado;
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
            checkMove: function(evt){
                console.log(evt);
                let target = evt.relatedContext.index;
                let from = evt.draggedContext.index;
                this.indexes = [];
                let list = evt.relatedContext.list;
                if(list[target].id >=0) {return false};
                if(this.local_citas[from].id <0) return false;
             
                let tiles = Math.round(this.local_citas[from].duracion/15);
                for(let i = target ; i<(target+tiles);i++){
                    if(list[i].locked)  {
                        if(list[i].par <0) return false;
                        if(list[i].par != this.local_citas[from].id ){
                            console.log('este: '+i);
                            console.log(list[target]);
                            return false;
                        }
                    }
                    if(list[i].id >=0 &list[i].id != this.local_citas[from].id){
                        
                        return false;
                    } 
                }
                this.indexes =[target,from,list];
                
                return false;
                
            },
            StartDrag:function(evt){
                
            },
            EndingDrag: function(evt){
                if(this.indexes.length >0){
                    let target = this.indexes[0];
                    let from = this.indexes[1];
                    let elemento1 =  this.local_citas[from];
                    let elemento2 = this.indexes[2][target];
                    //this.local_citas[from] = elemento2;
                    //this.local_citas[target] = elemento1;
                    
                    
                    this.getDiferentElement(elemento1,elemento2);
                }
                
                
            },
            getDiferentElement(elemento1,elemento2){
                let elementosDiferente ;
               
                elementosDiferente =elemento1;
                elementosDiferente.start =elemento2.dia+" "+elemento2.intervalo;
                elementosDiferente.end =  moment(elementosDiferente.start).clone().add(elementosDiferente.duracion, 'minutes').format('YYYY-MM-DD HH:mm')
                elementosDiferente.app_tienda_id = this.app_tienda_id;
                elementosDiferente.tipo = this.tipo;
         
                console.log("cita");
                
                this.saveCita(elementosDiferente);
            
                /*
                for(let i = 0 ; i < this.local_citas.length ; i++){
                    if(this.local_citas[i].id >=0){
                       
                            let fecha1 = this.local_citas[i].start.substring(11);
                            if(target.inte != fecha1){
                                elementosDiferentes[index] =this.local_citas[i];
                                elementosDiferentes[index].start =this.local_citas[i].start.substring(0, 11)+target.intervalo;
                                elementosDiferentes[index].end =  moment(this.local_citas[i].start).clone().add(this.local_citas[i].duracion, 'minutes').format('YYYY-MM-DD HH:mm')
                                elementosDiferentes[index].app_tienda_id = this.app_tienda_id;
                                elementosDiferentes[index].tipo = this.tipo;

                                
                                console.log("cita");
                                console.log(this.local_citas[i]);
                                this.saveCita(elementosDiferentes[index]);
                                index++;
                            }
                        
                    }
                }*/
                console.log(this.local_citas);
                console.log(elementosDiferentes);
            },
            saveCita(cita) { // graba cita con datos recibidos del metodo anterior asignarCita()
                //le paso las observaciones a evento para actualizarlo en el controller y grabamos la cita
              

                axios.post(`api/app/savecita`, cita).then(res => {
                  
                    this.$toast.sucs('cita guardada con exito')
                    this.$emit('cita_guardada', res.data)
                    
                    this.$store.dispatch('getNotificaciones') 

                    /*axios.get(`api/app/geteventsbymonth/${fecha}`).then(res => {
                        this.citas = res.data
                    }, res => {})*/

                }, res => {
                    if (res.response.status == 301) {
                        return this.$toast.warn(res.response.data.message)
                    }
                    if (res.response.status == 422) {
                        return this.$toast.warn('Debe completar los campos')
                    }
                    this.$toast.error('algo ha salido mal')
                })
            },
           
            crearIntervalos(n, dia_actual) {
                 let intervalos = n.forEach(element => {
                    let start = moment(`${dia_actual} ${element.entrada}`, 'YYYY-MM-DD HH:mm')
                    let end = moment(`${dia_actual} ${element.salida}`, 'YYYY-MM-DD HH:mm')
                    let diff = end.diff(start, 'minutes')
                    let intervalos = _.range((diff / 15))
                    intervalos.forEach((element, index) => {
                        let n = start.clone().add(index * 15, 'minutes').format('YYYY-MM-DD_HH:mm')
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
            openForm(intervalo) {
                EventBus.$emit('open_form', {
                    app_empleado_id: this.empleado.id,
                    fecha: this.dia_actual,
                    intervalo: intervalo
                })
            },
            setCita(cita) {
                EventBus.$emit('set_cita', cita)
            },
            timeToY(cita) {
                console.log(cita.id);
                   if(cita.locked & cita.par ==-1){
                     return {
                         display:'none',
                        height: `0px`,
                        backgroundColor:'transparent',
                        overflow:'hidden'
                    }
                }
                if(cita.id == -1){
                    return this.timeToYEmpty(cita);
                }
                let ref_date = `${cita.start.substring(0, 10)}_${cita.start.substring(11)}`
                let ref_name = `${this.empleado.nombre}_${ref_date}`
                if (this.$refs[ref_name] !== undefined && this.$refs[ref_name][0]) {
                    return {
                        display: 'block',
                        top: `${this.$refs[ref_name][0].offsetTop}px`,
                        height: `${ this.interval_height}px`,
                        backgroundColor:'transparent',
                        overflow:'visible'
                    }
                }
                return {
                    display: 'none'
                }
            },
            HeighttoY(cita){
                    return {
                        padding:"3px",
                        display: 'block',
                        height: `${Math.round(cita.duracion / 15) * this.interval_height}px`,
                        backgroundColor: cita.color,
                        'min-width':'100%',
                        'border-radius': '8px',
                        'border': 'solid 1px #fff',
                        'pointer-events':'none'
                    }
            },
            timeToYEmpty(cita) {
                
                    return {
                        display: 'block',
                        backgroundColor: 'transparent',
                        height: `${this.interval_height}px`,
                        outline: 'none',
                        border: 'none'
                    }
            },
            TimeToTop(cita){
                let ref_date = `${this.dia_actual}_${cita.intervalo}`
                let ref_name = `${this.empleado.nombre}_${ref_date}`
                if (this.$refs[ref_name] !== undefined && this.$refs[ref_name][0]) {
                    return {
                       
                        top: `${this.$refs[ref_name][0].offsetTop}px`,
                      
                        backgroundColor: "red"
                    }
                }
                return {
                    display: 'none'
                }
            },
            minutesToPixels(duracion) {
                return (duracion / 15) * this.interval_height
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
   .cita-element-2 {
        
        left: 0px;
        width: 99%;
        background-color: #1e5dbf;
        
        padding: 0px;
        color: #fff;
        font-size: 12px;
    }
</style>