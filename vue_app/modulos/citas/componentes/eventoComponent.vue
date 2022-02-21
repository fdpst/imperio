<template>
    <v-container>
        <v-overlay v-if="overlay">
            <v-progress-circular indeterminate size="220" color="green" width="10">
                <v-col>
                    <!--<v-icon class="white--text">mdi-paw</v-icon>-->
                    <strong style="color:white !important;"> Cargando datos</strong>
                </v-col>
            </v-progress-circular>
        </v-overlay>
        <v-dialog persistent v-model="dialogobuscar" width="600">
            <!-- Buscar Cita Mascota -->
            <template>
                <v-card>
                    <v-card-title class="headline green white--text" dark primary-title>Buscar Cita Cliente</v-card-title>
                    <v-card-text class="px-3 py-3">
                        <loader v-if="isloading"></loader>
                            <v-row>
                                <v-autocomplete label="Cliente" v-model="evento.app_usuario_id" 
                                    :items="clientes" :item-text="getItemText" item-value="id" class="col-6">
                                </v-autocomplete>
                                <!--<v-autocomplete label="Mascota" v-model="mascota" :items="mascotas" 
                                    item-text="nombre" item-value="id" return-object class="col-6">
                                </v-autocomplete>-->
                            </v-row> 
                                <strong><p class="ml-4 my-0 pa-0">Citas cliente</p> </strong>
                            <v-row class="mb-4">  
                                <v-col v-if="citacli.id ==null" align="center" justify="center" class="mt-2 mb-0">
                                    <strong><p >No Existen citas para el cliente seleccionado</p></strong>
                                </v-col>
                                <v-row id="buscarcita" v-if="citacli.id !=null" justify="space-around" class="cita mt-2 mb-4">
                                    <v-col id="buscar" @click="citaPet(citacli)" align="center" justify="center" class="cita-element mb-4">
                                      <v-row justify="center"> 
                                         <i>Fecha: {{citacli.start}} - {{citacli.tienda}}</i>
                                      </v-row>
                                      <v-row justify="center">
                                        <i>Servicio: {{citacli.servicios}} - Empleado: {{citacli.empleado}}</i>
                                      </v-row>
                                        
                                    </v-col>
                                </v-row>
                            </v-row>
                    </v-card-text>
                    <v-row align="center" justify="center" class="pa-4 ma-4">
                        <v-btn small md="3" @click="busqueda(evento.app_usuario_id)" rounded depressed color="success" class="white--text mx-1 mt-4 mb-0">Buscar</v-btn>
                        <v-btn small md="3" @click="cierrabusqueda()" rounded depressed color="red" class="white--text mx-1 mt-4 mb-0">Cerrar</v-btn>
                    </v-row>
                </v-card>
            </template>
        </v-dialog> 
        <!-- Guardar / Editar Cita -->
        <v-dialog @keydown.esc="closeDialog" persistent @click:outside="closeDialog" v-model="dialog" >
            <v-card>
                <v-card-title class="headline green white--text" dark primary-title>Guardar / Editar Cita</v-card-title>
                <v-card-text class="px-3 py-3">
                    <loader v-if="isloading"></loader>
                    <v-card outlined class="pl-5" >
                        <v-card-title>Datos Cliente</v-card-title>
                        <v-row dense class="pa-1 ma-1">
                            <v-col cols="12" md="2" class="px-2 pt-0 mt-0"><!-- Empleado -->                   
                                <v-autocomplete label="Empleado" v-model="evento.app_empleado_id" :items="local_empleados" 
                                    @change="buscarDisponible()" item-text="nombre" item-value="id">
                                </v-autocomplete>
                            </v-col>                             
                            <v-col cols="12" md="6" class="px-2 pt-0 mt-0">                                
                                <v-row><!--debe empezar agregar el modal CLIENTE-->
                                    <v-autocomplete v-if="!usuario.telefono" label="Cliente" v-model="usuario" :items="clientes"  :hint="``" persistent-hint :item-text="getItemText" return-object item-value="id" class="col-10"></v-autocomplete>
                                    <v-autocomplete v-else label="Cliente" v-model="usuario" :items="clientes"  :hint="`${usuario.telefono}`" persistent-hint :item-text="getItemText" return-object item-value="id" class="col-10"></v-autocomplete>
                                    <div class="text-center pa-0 mt-3 ma-0" >
                                        <v-dialog v-model="dialogo" width="900">
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn x-small class="mr-1 mt-4" color="success" rounded depressed dark v-bind="attrs" v-on="on" @click="editCostumer('nuevo')"><v-icon dark>mdi-plus</v-icon></v-btn>
                                                <v-btn :disabled="!evento.app_usuario_id" x-small class="mt-4 mr-1" color="green" rounded depressed dark v-bind="attrs" v-on="on" @click="editCostumer('editar')"><v-icon dark>mdi-account-edit</v-icon></v-btn>
                                            </template>
                                            <v-card>
                                                <v-card-title class="text-h5 green white--text">Agregar Nuevo cliente</v-card-title>
                                                <v-card-text>
                                                    <v-container class="mb-0">
                                                        <loader v-if="isloading"></loader>
                                                        <v-row>
                                                            <v-col>
                                                                <v-row dense>
                                                                    <v-col cols="12" md="6">
                                                                        <v-text-field filled v-model="usuarioEdit.nombre" label="Nombre" required></v-text-field>
                                                                    </v-col>
                                                                    <v-col cols="12" md="6">
                                                                        <v-text-field filled v-model="usuarioEdit.apellidos" label="Apellidos" required></v-text-field>
                                                                    </v-col>
                                                                </v-row>
                                                                <v-row dense>
                                                                    <v-col cols="12" md="6">
                                                                        <v-text-field filled v-model="usuarioEdit.email" label="Email" required></v-text-field>
                                                                    </v-col>
                                                                    <v-col cols="12" md="6">
                                                                        <v-text-field filled v-model="usuarioEdit.telefono" label="teléfono" required></v-text-field>
                                                                    </v-col>
                                                                </v-row>
                                                                <!--<v-row dense>
                                                                    <v-col cols="12" md="6">
                                                                        <v-text-field filled v-model="usuarioEdit.codigo" label="Código" required></v-text-field>
                                                                    </v-col>
                                                                </v-row>-->
                                                                <v-row dense>
                                                                    <v-col cols="12" md="12">
                                                                        <v-textarea filled v-model="usuarioEdit.observaciones" label="Observaciones"></v-textarea>
                                                                    </v-col>
                                                                </v-row>
                                                                <v-row dense>
                                                                    <v-col cols="12">
                                                                        <v-btn @click="saveUsuario" :disabled="isloading" rounded depressed color="success" class="white--text">Guardar</v-btn>
                                                                        <v-btn @click="dialogo = false" :disabled="isloading" rounded depressed color="danger" dark class="red">Salir</v-btn>
                                                                    </v-col>
                                                                </v-row>
                                                            </v-col>    
                                                        </v-row>
                                                    </v-container>
                                                </v-card-text>
                                            </v-card>
                                        </v-dialog>
                                    </div>                            
                                </v-row>
                                <!--final debe empezar agregar el modal CLIENTE-->
                            </v-col> 
                            <v-col cols="12" md="2" class="px-2 pt-0 mt-0">    
                                <v-text-field v-model="evento.precio" label="Precio" required type="number"></v-text-field>
                            </v-col>                
                            <!--<v-col cols="12" md="4" class="px-2 mt-2">                                 
                                <v-row> <!--debe empezar agregar el modal MASCOTA-->
                                   <!-- <v-autocomplete v-if="!mascota.raza" label="Mascota" v-model="mascota" :items="mascotas" item-text="nombre" item-value="id"
                                        return-object class="col-8" :hint="``" persistent-hint>
                                    </v-autocomplete> 
                                    <v-autocomplete v-else label="Mascota" v-model="mascota" :items="mascotas" item-text="nombre" item-value="id"
                                        return-object class="col-8" :hint="`${mascota.raza}`" persistent-hint>
                                    </v-autocomplete>
                                    <div class="text-center pa-0 mt-3 ma-0">
                                        <v-dialog v-model="dialogogomascota" width="750">
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn x-small class="mr-1 mt-4" color="success" rounded depressed dark v-bind="attrs" v-on="on"  @click="editPet('nuevo')"><v-icon dark>mdi-plus</v-icon></v-btn>
                                                <v-btn :disabled="!mascota.id" x-small class="mt-4 mr-1" color="purple" rounded depressed dark v-bind="attrs" v-on="on"  @click="editPet('editar')"><v-icon dark>mdi-pencil</v-icon></v-btn>
                                            </template>
                                            <v-card>
                                                <v-card-title class="text-h5 purple white--text">Agregar Nueva Mascota</v-card-title>
                                                <v-card-text>
                                                    <v-container class="mb-0">
                                                        <loader v-if="isloading"></loader>
                                                        <v-row>
                                                            <v-col>
                                                            <v-row dense>
                                                                    <v-col cols="12" md="6">
                                                                        <v-text-field v-model="local_mascota.nombre" label="Nombre" required></v-text-field>
                                                                    </v-col>
                                                                    <v-col cols="12" md="6">
                                                                        <v-text-field v-model="local_mascota.raza" label="Raza" required></v-text-field>
                                                                    </v-col>
                                                                    <v-col cols="12" md="4">
                                                                        <v-select label="Tamaño" v-model="tamanyo_selec" :items="tipos_tamanyo" item-value="id" item-text="nombre" 
                                                                                return-object :hint="`${tamanyo_selec.peso}`" persistent-hint></v-select>
                                                                    </v-col>
                                                                    <v-col cols="12" md="4">
                                                                        <v-select label="Tipo Pelo" v-model="local_mascota.pelo" :items="tipos_pelo" item-value="id" item-text="nombre"></v-select>
                                                                    </v-col>
                                                                    <v-col cols="12" md="4">
                                                                        <v-select label="Tipo" v-model="local_mascota.seccion_id" :items="secciones" item-value="id" item-text="nombre"></v-select>
                                                                    </v-col>                                                                    
                                                                    <v-col cols="12" md="12"> 
                                                                        <v-textarea outlined height="50px" v-model="local_mascota.observaciones" label="Observaciones Mascota"></v-textarea>
                                                                    </v-col>    
                                                                </v-row>
                                                                <v-row dense>
                                                                    <v-col cols="12">
                                                                        <v-btn :loading="isloading" rounded depressed color="success" dark @click="guardarMascota">guardar</v-btn>
                                                                        <v-btn @click="dialogogomascota = false" :disabled="isloading" rounded depressed color="danger" dark class="red">Salir</v-btn>
                                                                    </v-col>
                                                                </v-row>
                                                            </v-col>    
                                                        </v-row>
                                                    </v-container>
                                                </v-card-text>
                                            </v-card>
                                        </v-dialog>
                                    </div>
                                </v-row>
                                <!--final debe empezar agregar el modal MASCOTA-->
                            <!--</v-col>-->
                        </v-row>
                        <v-row dense class="pr-4 ma-1"> 
                             <!--<v-textarea outlined height="50px" v-model="mascota.usuario.observaciones" label="Observaciones Usuario"></v-textarea>-->
                            <v-textarea outlined height="50px" v-model="usuario.observaciones" label="Observaciones Usuario"></v-textarea>
                        </v-row>
                        <!--<v-row dense class="pr-4 ma-1"> 
                            <v-textarea outlined height="50px" v-model="mascota.observaciones" label="Observaciones Mascota"></v-textarea>
                        </v-row>-->
                    </v-card>
                    <v-card outlined class="pl-5" style="margin-top: 2px;">
                        <v-card-title>Datos Servicios</v-card-title>
                        <v-row dense class="pa-0 ma-1"> 
                            <!-- Servicios -->
                            <v-col cols="12" md="12" class="px-3 mb-0">                            
                                <v-autocomplete label="Servicios" v-model="evento.servicios" return-object :items="servicios"
                                        item-text="nombre" item-value="id" :menu-props="{ maxHeight: '300' }" multiple @change="buscarDisponible()">
                                    <template v-slot:selection="{ item, index }">
                                        <v-chip-group>
                                            <v-chip color="orange" class="white--text" small v-if="index === 0"> <span>{{ item.nombre }}</span> </v-chip>
                                            <v-chip color="orange" class="white--text" small v-if="index === 1"> <span>{{ item.nombre }}</span> </v-chip>
                                            <v-chip color="orange" class="white--text" small v-if="index === 2"> <span>{{ item.nombre }}</span> </v-chip>
                                            <v-chip color="orange" class="white--text" small v-if="index === 3"> <span>{{ item.nombre }}</span> </v-chip>
                                            <v-chip color="orange" class="white--text" small v-if="index === 4"> <span>{{ item.nombre }}</span> </v-chip>
                                            <v-chip color="orange" class="white--text" small v-if="index === 5"> <span>{{ item.nombre }}</span> </v-chip>
                                            <v-chip color="orange" class="white--text" small v-if="index === 6"> <span>{{ item.nombre }}</span> </v-chip>
                                            <v-chip color="orange" class="white--text" small v-if="index === 7"> <span>{{ item.nombre }}</span> </v-chip>
                                        </v-chip-group>
                                    </template>
                                </v-autocomplete>
                            </v-col>
                        </v-row>
                            <!-- Historial de mascota -->
                            <strong><p class="ml-4 my-0 pa-0" v-if="mascota.historial.length > 0">Historial</p></strong>
                        <v-row>
                            <v-row justify="space-around" class="ma-0 pa-0">
                                <v-col id="historial" class="pa-0 mx-0 my-1" v-for="(item, i) in historial" :key="i" cols="7">
                                    <v-btn depressed elevation="2"  @click="asignarServicio(item)"
                                        small block outlined :color="isSelect(item)">{{item.abreviacion}}
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-row>
                    </v-card>
                    <!-- Servicio de Recogida -->
                    <!--<v-card outlined class="pl-5" v-show="evento.recogida" style="margin-top: 2px;">
                        <v-card-title>Datos Servicio Recogida</v-card-title>
                        <v-row>
                            <v-col cols="12" md="5">
                                <v-autocomplete  v-model="evento.direccion_recogida" :items="direccion_recogida" label="Dirección Recogida" item-text="direccion" item-value="id"></v-autocomplete>
                            </v-col>
                            <v-col cols="12" md="5">
                                <v-autocomplete  v-model="evento.direccion_entrega" :items="direccion_entrega" label="Dirección Entrega"  item-text="direccion" item-value="id"></v-autocomplete>
                            </v-col>
                            <v-col cols="12" md="2">
                                <!-- hacemos if para cambiar el color -->
                                <!--<v-btn-toggle v-model="evento.pago" color= "purple" rounded class="ml-3">
                                    <v-btn v-if="evento.pago ==0" color="purple" small elevation="3"> <v-icon>mdi-currency-eur</v-icon>  </v-btn>
                                    <v-btn v-else small elevation="3"> <v-icon>mdi-currency-eur</v-icon>  </v-btn>
                                    
                                    <v-btn v-if="evento.pago ==1" color="purple" small elevation="3"><v-icon>mdi-credit-card</v-icon></v-btn>
                                    <v-btn v-else small elevation="3"><v-icon>mdi-credit-card</v-icon></v-btn>
                                </v-btn-toggle>
                            </v-col>
                        </v-row>
                    </v-card>-->                    
                    <!-- Botones de evento cerrar, eliminar, confirmar -->
                    <v-row>
                        <v-col cols="12" md="5" style="margin-top: 10px;">
                            <v-btn class="white--text" rounded  @click="closeDialog" outlined color="red accent-2">cerrar</v-btn>
                            <v-btn v-if="evento.id" rounded depressed class="white--text" @click="dialogocancelar=true" color="red accent-2">eliminar</v-btn>
                            <v-btn v-if="evento.id" class="white--text" rounded @click="confirmarCita" outlined :color="evento.confirmada ? 'grey' : 'green'">{{ evento.confirmada ? 'Desconfirmar' : 'Confirmar' }}</v-btn>
                        </v-col>                        
                        <!--<v-col cols="12" md="3">
                            <v-switch v-model="evento.recogida" label="Servicio de recogida" color="purple" style=""></v-switch>
                        </v-col>  -->                      
                    </v-row>
                    <v-row>
                        <!-- Calendario y boton buscar disponible -->
                        <v-col cols="12" md="6" class="my-1 py-1">
                            <v-date-picker  class="my-0 py-0 ml-4 " color="blue-grey lighten-1" v-model="evento.fecha" @change="buscarDisponible()"></v-date-picker>
                            <v-row>
                                <!--<v-btn class="white--text mt-4 mb-0" @click="buscarDisponible" rounded outlined color="green" style="margin-left:20px;">Buscar Disponible</v-btn>-->
                                <!--<v-switch v-model="filtrohoras" label="Filtrar 30 minutos" color="purple" style="margin-left:60px;"></v-switch>-->
                            </v-row>
                        </v-col>
                        <!-- DIV Seccion citas disponibles empleado y dialogos-->
                        <v-col cols="12" md="5">
                            <div style="font-size: 12px !important; margin-top: 10px !important; margin-bottom: 10px !important;">
                                <strong>INICIO: </strong> {{this.evento.start}}
                                <strong class="ml-2">FIN: </strong> {{this.evento.end}}
                                <strong class="ml-2">DURACION: </strong> {{this.evento.duracion}}
                            </div>
                            <v-row dense v-for="(empleado, i) in local_horario" :key="empleado.app_empleado_id">
                                <v-col cols="12">
                                    <v-chip v-if ="empleado.horario.length>0" small color="green" outlined><v-icon left>mdi-account-clock</v-icon>{{empleado.nombre_empleado}}</v-chip>
                                </v-col>
                                <v-col v-for="(item, i) in empleado.horario" :key="i" cols="12" md="3">                                    
                                    <v-btn elevation="2" @click="asignarDatos(item, empleado.app_empleado_id)" rounded
                                        small block :color="isSelect2(item, empleado.app_empleado_id)">{{item}}
                                    </v-btn>                                    
                                </v-col>
                            </v-row>
                            <v-btn @click="asignarCita(dataItem , dataIdemp)" small block dark rounded color="red" class="mt-2">Guardar - Modificar cita</v-btn>
                            <!-- Dialogo de causas de eliminar cita -->
                            <v-container>
                                <v-dialog persistent v-model="dialogocancelar" width="400">
                                    <template>
                                        <v-card>
                                            <v-card-title class="text-h5 green white--text">Eliminar cita</v-card-title>
                                            <v-col cols="12" class="py-2">
                                                <v-card-text class="mt-0 mb-0 pb-3"> <h3>Para eliminar la cita debe indicar un motivo</h3> </v-card-text>
                                                <v-btn-toggle v-model="toggle_exclusive" color="red accent-4" rounded class="ml-3">
                                                    <v-btn small elevation="3"><strong> No asiste </strong></v-btn>
                                                    <v-btn small elevation="3"><strong> Cancela cliente </strong></v-btn>
                                                    <v-btn small elevation="3"><strong> Erronea </strong></v-btn>
                                                </v-btn-toggle>
                                                <v-col cols="12" class="text-center mb-0 pb-0" >
                                                    <div v-if="toggle_exclusive == 0"><h6> No asiste </h6></div>
                                                    <div v-else-if="toggle_exclusive == 1"><h6> Cancela cliente </h6></div>
                                                    <div v-else-if="toggle_exclusive == 2"><h6> Erronea </h6></div>
                                                </v-col>
                                            </v-col>
                                            <v-col>                                    
                                                <v-row align="center" justify="center">
                                                    <v-btn small v-if="toggle_exclusive != null" md="3" @click="eliminarCita(toggle_exclusive)" rounded depressed color="danger" 
                                                        class="white--text red mt-0 ml-4 mb-4">Eliminar</v-btn>
                                                    <v-btn small md="3" @click="cierraeliminar()" rounded depressed color="success" 
                                                        class="white--text mt-0 mx-2 mb-4">Cancelar</v-btn>
                                                </v-row>
                                            </v-col>
                                        </v-card>
                                    </template>                            
                                </v-dialog> 
                            </v-container>
                            <!-- END Dialogo de causas de eliminar cita -->
                            <!-- Dialogo de aviso de faltan datos en cita -->
                            <v-container>
                                <v-dialog persistent v-model="dialogocita" width="280">
                                    <template>
                                        <v-card>
                                            <v-card-title class="text-h5 green white--text">Datos Necesarios</v-card-title>
                                            <v-col cols="12" class="ma-0 pb-0">
                                                <v-card-text class="ma-0 pa-0 ml-2"> <h4>Asigne dia en calendario y servicios</h4><h4>Para consultar las citas disponibles</h4> </v-card-text>                                        
                                            </v-col>
                                            <v-col>                                    
                                                <v-row align="center" justify="center" class="pa-0 ma-0">
                                                    <v-btn small md="3" @click="cierraobligacita()" rounded depressed color="success" class="white--text ma-0">Continuar</v-btn>
                                                </v-row>
                                            </v-col>
                                        </v-card>
                                    </template>                            
                                </v-dialog> 
                            </v-container>  
                            <!-- END Dialogo de aviso de faltan datos en cita -->  
                        </v-col>   
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-container>
</template> 

<script>
    import { EventBus } from '../handlers/eventbus'
    export default {
        props: ['empleados', 'clientes', 'servicios', 'tipo', 'app_tienda_id'],
        data() {
            return {
                tipos_tamanyo: [],
                tipos_pelo: [],
                tamanyo_selec:{
                    id: null,
                    nombre: null,
                    peso: ""
                },
                editar: 'editar',
                nuevo: 'nuevo',
                direccion_recogida:[],
                direccion_entrega:[],
                filtrohoras: false,
                dialogo:false,
                dialogocita:false,
                dialogobuscar: false,
                dialogocancelar:false,
                dialogogomascota:false,
                toggle_exclusive: null,
                usuario: {
                    id: '',
                    nombre: '',
                    apellidos: '',
                    email: '',
                    telefono: '',
                    codigo: '',
                    observaciones: '',
                    avatar: null,
                    password: null,
                    direccion:[]
                },
                usuarioEdit: {
                    id: '',
                    nombre: '',
                    apellidos: '',
                    email: '',
                    telefono: '',
                    adoptar: 0,
                    donar: 0,
                    codigo: '',
                    observaciones: '',
                    avatar: null,
                    password: null,
                    direccion:'',
                    profesion:'',
                    consulta:'',
                    antecedentes:'',
                    tratamiento:''
                },
                local_mascota: {    
                    id: '',
                    app_usuario_id: '',
                    nombre: '',
                    Fecha_Nacimiento: '',
                    raza: '',
                    sexo: '',
                    tamanyo: '',
                    pelo:'',
                    peso: '',
                    color: '',
                    Adoptable: '',
                    seccion_id: '',
                    imagen: null,
                    observaciones: '',
                    codigo: '',
                    imagen_path: null
                },
                secciones: [],                
                dialog: false,                
                horas: [],
                mascotas: [],
                mascota: {
                    historial: [],
                    usuario: {
                        observaciones: ''
                    },
                },
                app_usuario_id: null,
                local_empleados: [],
                local_horario: [],
                evento: {
                    id: null,
                    app_empleado_id: null,
                    app_usuario_id: null,
                    app_tienda_id: this.app_tienda_id ,
                    app_mascota_id: null,
                    tipo_id: 1,
                    color: null,
                    start: null,
                    end: null,
                    duracion: null,
                    servicios: [],
                    fecha: null,
                    observacionesMascota: '',
                    observacionesUsuario: '',
                    confirmada:1,
                    recogida:0,
                    direccion_recogida:null,
                    direccion_entrega:null,
                    pago:0,
                    precio:'',                    
                    intervalo:null,
                    fechainicial:null,                    
                    unicoelemento:false,
                },
                citapet: {
                    id: null,
                    mascota: null,
                    tamanyo: null,
                    pelo: null,
                    raza: null,
                    tipo: null,
                    tienda: null,
                    servicios: null,
                    start: null,
                    start_format: null
                },
                citacli: {
                    id: null,
                    tipo:null,
                    empleado:'',
                    tienda: null,
                    servicios: null,
                    start: null,
                    start_format: null
                },
                dataItem: [],
                dataIdemp: '',
                editable: false,
                IdEmpleadoCita: '',
                nuevo: true,
                idEmpFormulario: '',
                evento_nuevo: true,
                mascotaEdit: [],
                overlay: false, 
            }
        },
        watch: {
            'evento.servicios'(n) {
                if (n) {
                    this.evento.duracion = n.reduce((acc, x) => {
                        return acc + x.duracion
                    }, 0)
                }
            },
            'evento.app_usuario_id'(n) {                
                if(this.evento_nuevo == true){
                   // this.getMascotas(n, true)
                    //this.getDirecciones(n)
                }else{
                    this.evento_nuevo = true
                }
            },
            'mascota'(n) {
                this.evento.app_mascota_id = n ? n.id : null
            },
            'usuario'(n) {
                this.evento.app_usuario_id = n ? n.id : null
            },
            'empleados'(n) {
                this.local_empleados = JSON.parse(JSON.stringify(n))
                this.local_empleados.unshift({ id: null,nombre: ''})
            },
        },  
        created() {
            //this.obtenerTiposPelo();
            //this.obtenerTiposTamanyo();
            //this.getSecciones();
            this.$parent.$on('open_dialog', () => { this.dialog = true; });
            this.$parent.$on('abrirbusqueda', () => { this.dialogobuscar = true });
            EventBus.$on('open_form', this.openForm);
            EventBus.$on('set_cita', cita => {
                this.evento_nuevo = false;
                this.dialog = true;
                this.evento = Object.assign({}, cita);
                this.evento.fecha = cita.start.substring(0, 10);
                this.evento.app_tienda_id = this.app_tienda_id;
                this.getMascotas(cita.app_usuario_id, false);
                this.setUsuario(cita.app_usuario_id);
                this.IdEmpleadoCita = this.evento.app_empleado_id;  
                this.idEmpFormulario = this.evento.app_empleado_id; 
                this.buscarDisponible();
            });
        },
        methods: { 
            /*obtenerTiposPelo(){
                axios.get('api/app/get-tipos-pelo').then(res => {
                    this.tipos_pelo = res.data
                }, err => {
                    this.$toast.error('Error consultando Tipos de pelo')
                })
            },*/
            /*obtenerTiposTamanyo(){
                axios.get('api/app/get-tipos-tamanyos').then(res => {
                    this.tipos_tamanyo = res.data
                }, err => {
                    this.$toast.error('Error consultando tipos de tamaños')
                })
            },*/
            setUsuario(id_usuario){
                this.clientes.forEach(element => {
                    if (element.id == id_usuario){
                        this.usuario = element;
                    }
                });
            },
            editCostumer(tipo){ // Abre formulario con datos o no segun sea el boton pulsado nuevo o esitar usuario
                if (tipo == 'editar') {
                    this.usuarioEdit = Object.assign({}, this.usuario);
                }
                if (tipo == 'nuevo') {
                    this.usuarioEdit = {
                        id: '',
                        nombre: '',
                        apellidos: '',
                        email: '',
                        telefono: '',
                        adoptar: 0,
                        donar: 0,
                        codigo: '',
                        observaciones: '',
                        avatar: null,
                        password: null,
                        direccion:'',
                        profesion:'',
                        consulta:'',
                        antecedentes:'',
                        tratamiento:''
                    }
                    //this.usuario = [];
                }
            },
            editPet(tipo){ // Abre formulario con datos o no segun sea el boton pulsado nueva o editar mascota
                if (this.evento.app_mascota_id != null && tipo == 'editar') {
                    this.getPetEdit(this.evento.app_mascota_id);
                }
                if (this.evento.app_mascota_id != null && tipo == 'nuevo') {
                    this.tamanyo_selec={
                        id: null,
                        nombre: null,
                        peso: ""
                    };
                    this.local_mascota = {
                        id: '',
                        app_usuario_id: '',
                        nombre: '',
                        Fecha_Nacimiento: '',
                        raza: '',
                        sexo: '',
                        tamanyo: '',
                        pelo: '',
                        peso: '',
                        color: '',
                        Adoptable: '',
                        seccion_id: '',
                        imagen: null,
                        observaciones: '',
                        codigo: '',
                        imagen_path: null
                    };   
                }             
            },
            getUsuarioEdit(usuario_id) { // Obtiene el usuario a editar
                axios.get(`api/app/getusuario/${usuario_id}`).then(res => {
                    //this.usuarioEdit = res.data;
                    this.usuario = res.data; //this.usuarioEdit;
                    //this.evento.observacionesUsuario = this.usuario.observaciones;
                    //this.usuarioEdit.id = this.app_usuario_id;
                }, res => {
                    this.$toast.error('Algo ha salido mal');
                })
            },   
            getPetEdit(mascota_id){ // Obtiene la mascota a editar
                this.local_mascota = Object.assign({}, this.mascota);   
                this.tipos_tamanyo.forEach(tamanyo => {
                    if (tamanyo.id == this.local_mascota.tamanyo){
                        this.tamanyo_selec = tamanyo;
                    }
                });
            },  
            getDirecciones(id_usuario){ // Obtiene direcciones de usuario
                this.clientes.forEach(element => {
                    if (element.id == id_usuario){
                        this.direccion_recogida = element.direccion 
                        this.direccion_entrega = element.direccion
                    }
                });
            },
            getItemText(item) { // Concatena nombre y apellidos para busqueda
                return `${item.nombre}`;
            },      
            openForm(data) { // Abre formulario pinchando en hora vacia
                this.dialog = true             
                this.evento.fecha = data.fecha
                this.evento.app_tienda_id = this.app_tienda_id                
                this.evento.app_empleado_id = data.app_empleado_id
                this.evento.intervalo = data.intervalo;
                this.evento.fechainicial = data.fecha;
            },
            saveUsuario() { // crea nuevo usuario desde cita
                //this.usuario.id = this.evento.app_usuario_id;
                axios.post(`api/app/saveusuario`, this.usuarioEdit).then(res => {
                    //this.props= ['empleados', 'clientes', 'servicios', 'isloading'] 
                    this.resetClientes();
                    this.usuario = res.data
                    //this.evento.app_usuario_id = res.data.id;
                    //this.app_usuario_id = res.data.id;
                    this.$toast.sucs('Usuario Almacenado Correctamente');
                    this.dialogo=false;
                }, res => {
                    this.$toast.error('Error: '+res.response.data.mensaje)                   
                })                    
            }, 
            guardarMascota() { // crea nueva mascota desde cita
                if(this.evento.app_usuario_id=='') return ;
                this.local_mascota.tamanyo = this.tamanyo_selec.id;
                let usuario_id=this.evento.app_usuario_id;
                this.local_mascota.app_usuario_id = usuario_id;
                axios.post(`api/app/save-mascota-from-user/${usuario_id}`, this.local_mascota).then(res => {
                    this.evento.app_mascota_id = res.data.id
                    this.getMascotas(usuario_id, false) 
                    this.dialogogomascota = false;
                    this.$toast.sucs('Mascota Almacenada Correctamente')
                    this.resetMascota()
                }, res => {
                    this.$toast.error('Error guardando mascota')
                })
            },
            resetClientes(){ // Recarga el listado de clientes al almacenar uno nuevo
                this.$emit('resetClientes');
            },            
            /*getSecciones() {  // Obtiene Tipo de animal
                axios.get(`api/get-secciones`).then(res => {
                    this.secciones = res.data
                })
            },*/
            isSelect(item) {  // Color segun servicio seleccionado o no             
                let index = this.evento.servicios.findIndex(x => x.id == item.id)
                return index > -1 ? 'orange' : 'green darken-1'
            },
            isSelect2(item, empleadoId) {  // Color de horario seleccionado   
            let itemhora = '';
                if (this.evento.start != null) {
                    itemhora = this.evento.start.substring(11,16); 
                }                                 
                if (item == itemhora && this.dataItem == '' && this.IdEmpleadoCita == empleadoId 
                    || this.dataItem == item && this.IdEmpleadoCita == empleadoId ) 
                {
                    this.dataItem = item;
                    this.editable = true;
                    return 'green lighten-4';
                }
                    return 'grey lighten-3';
            },
            asignarServicio(item) { // Evento de seleccion de servicio
                let index = this.evento.servicios.findIndex(x => x.id == item.id)
                if (index == -1) {
                    this.evento.servicios.push(item)
                }
                else
                {
                    this.evento.servicios.splice(index, 1)
                }
                this.buscarDisponible();
            },
            confirmarCita() { // boton de cita confirmada o sin confirmar
                axios.get(`api/app/confirmar-cita/${this.evento.id}`).then(res => {
                    this.evento.confirmada = res.data.confirmada
                    this.$toast.sucs('Estado actualizado')
                    this.$store.dispatch('getNotificaciones')
                }, res => {
                    this.$toast.warn('Error cambiando estado')
                })
            },
            buscarDisponible() { // Evento boton busca disponible
                if (this.evento.fecha ==null){
                    this.evento.fecha = moment().format('YYYY-MM-DD')
                }                
                let data = { 
                    id: this.evento.id,
                    fecha: this.evento.fecha,
                    tienda_id: this.app_tienda_id,
                    tipo: this.tipo,
                    empleado_id: this.evento.app_empleado_id,
                }
                if 
                (   this.evento.servicios.length >= 0 && data.fecha == null && data.empleado_id == null && this.nuevo == false || // Formulario vacio boton nuevo directo
                    this.evento.servicios.length  > 0 && data.fecha == null && data.empleado_id == null && this.nuevo == false || // Con empleado sin fecha                    
                    this.evento.servicios.length == 0 && data.fecha == null && data.empleado_id != null && this.nuevo == false || // Sin empleado sin fecha 
                    this.evento.servicios.length == 0 && data.fecha != null && data.empleado_id != null && this.nuevo == true // pinchando en dia de trabajador no tiene servicio
                ) 
                {
                    this.dialogocita = true;
                }
                else 
                {                    
                    axios.post(`api/app/buscar-horario-disponible`, data).then(res => {
                        
                        let thisdata = res.data;
                        /*for(let i = 0 ; i < res.data[0].diferencia.length; i++){
                           let diferencia = thisdata[0].diferencia[i];
                           if(diferencia == this.evento.intervalo){
                               let diferencias = [diferencia];
                               thisdata[0].diferencia = diferencias;
                               break;
                           }
                        }*/
                        this.horas = this.filtrarHoras(thisdata);
                        if(this.unicoelemento)
                         this.asignarDatos(this.local_horario[0].horario[0],this.local_horario[0].app_empleado_id);
                        this.$toast.sucs('consulta realizada');

                    }, res => {})
                }
            },
            filtrarHoras(lista_empleados) { // busca horas de trabajo utilizable por empleado
                this.local_horario = lista_empleados.map(element => {
                    return {
                        app_empleado_id: element.app_empleado_id,
                        nombre_empleado: element.nombre_empleado,
                        horario: this.filtrar_90_minutos(element.diferencia, this.evento.duracion)
                    }
                })
            },
            filtrar_90_minutos(lista_horas, duracion) { // saca listado de horario disponible por empleado
                let lista = []
                this.unicoelemento = false;
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

                     if (encaja&&!this.unicoelemento) {
                            if(element == this.evento.intervalo && this.evento.fechainicial == this.evento.fecha){
                                lista = [];
                                this.unicoelemento = true;
                            }
                            lista.push(element)
                           
                        }
                
                })
                
                return lista
            },
            asignarCita(item, app_empleado_id) { // asigna los datos al pinchar en la hora (item) disponible para el empleado asignarDatos(item, empleado.app_empleado_id)                
                if (!this.editable) {
                    this.evento.app_empleado_id = app_empleado_id
                }
                this.evento.start = `${this.evento.fecha} ${item}`
                this.evento.end = moment(this.evento.start).clone().add(this.evento.duracion, 'minutes').format('YYYY-MM-DD HH:mm')
                this.evento.tipo = this.tipo              
                this.saveCita();
            },
            asignarDatos(item, empleado) { // Boton guardar cuando se selecciona la hora de la cita
                this.dataItem = item;
                this.dataIdemp = empleado;
                this.IdEmpleadoCita = empleado;
                this.evento.app_empleado_id = empleado;
                this.editable = false
            },   
            saveCita() { // graba cita con datos recibidos del metodo anterior asignarCita()
                //le paso las observaciones a evento para actualizarlo en el controller y grabamos la cita
                this.evento.observaciones = this.mascota.observaciones;
                this.evento.observacionesUsuario = this.usuario.observaciones;   

                axios.post(`api/app/savecita`, this.evento).then(res => {
                    let fecha = this.evento.fecha
                    this.$toast.sucs('cita guardada con exito')
                    this.$emit('cita_guardada', res.data)
                    this.closeDialog()
                    this.$store.dispatch('getNotificaciones') 

                    axios.get(`api/app/geteventsbymonth/${fecha}`).then(res => {
                        this.citas = res.data
                    }, res => {})

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
            getMascotas(usuario_id, reseteo_mascota) {  // Obtiene usuario id, mascota id , historial y evento  
                if(reseteo_mascota){
                    this.mascota = {historial: [],usuario: {observaciones: ''}};
                }
                axios.get(`api/app/get-mascotas-by-user/${usuario_id}`).then(res => {
                    this.mascotas = res.data;                    
                    if (this.evento.app_mascota_id != null) {                         
                        let i = this.mascotas.findIndex(x => x.id == this.evento.app_mascota_id);
                        this.mascota = this.mascotas[i];
                    }
                }, res => {})
            },
            closeDialog() {  // Cierra formulario y resetea formulario
                this.filtrohoras= true;
                this.resetForm();
                //this.dialog = false;
            },
            resetMascota() { // resetea campos de inserccion de mascota
                this.tamanyo_selec={
                    id: null,
                    nombre: null,
                    peso: ""
                }
                this.local_mascota = {
                    id: '',
                    app_usuario_id: '',
                    nombre: '',
                    Fecha_Nacimiento: '',
                    raza: '',
                    sexo: '',
                    tamanyo: '',
                    pelo:'',
                    peso: '',
                    color: '',
                    Adoptable: '',
                    seccion_id: '',
                    imagen: null,
                    observaciones: '',
                    codigo: '',
                    imagen_path: null
                }
            },           
            resetUsuario() { // resetea campos de inserccion de usuario
                this.usuario = {
                    id: null,
                    nombre: null,
                    apellidos: null,
                    email: null,
                    telefono: null,
                    codigo: null,
                    observaciones: ''
                }
            },    
            resetForm() { // resetea campos de formularios
                this.horas = []
                this.local_horario = []
                this.mascota = {
                    historial: [],
                    usuario: {
                        observaciones: ''
                    },
                }
                this.mascotas=[]
                this.dialog = false;
                this.evento = {
                    app_empleado_id: null,
                    app_usuario_id: null,
                    app_mascota_id: null,
                    app_tienda_id: this.app_tienda_id ,
                    color: null,
                    start: null,
                    end: null,
                    duracion: null,
                    servicios: [],
                    fecha: null,
                    observaciones: '',
                    confirmada: 1,
                    recogida:false,
                    observacionesMascota: '',
                    observacionesUsuario: '',
                    direccion_recogida:null,
                    direccion_entrega:null,
                    pago:0,
                    precio:''
                }
                
                this.editable = false;
                this.IdEmpleadoCita = this.idEmpFormulario;
                this.dataItem = '';
                this.evento_nuevo = true;
                this.tamanyo_selec={
                    id: null,
                    nombre: null,
                    peso: ""
                }
                this.resetUsuario()
            },    
            eliminarCita(toggle_exclusive) { // Elimina cita en pantalla
                axios.get(`api/app/eliminarcita/${this.evento.id}/${toggle_exclusive}`).then(res => {
                    this.$emit('eliminar_cita', this.evento,toggle_exclusive);
                    this.closeDialog()
                }, res => {
                    this.$toast.error('algo ha salido mal')
                })
                this.toggle_exclusive = null;
            },        
            cierraeliminar() {  // Cierra formulario y resetea formulario
                this.toggle_exclusive = null;
                this.dialogocancelar = false;
            },         
            cierraobligacita() {  // Cierra aviso obligado de cita
                this.dialogocita = false;
            },             	                  
            cierrabusqueda() {  // Cierra busqueda
                this.resetForm();                
                this.citapet = {};
                this.citacli = {};
                this.dialogobuscar = false;
            },                   
            abrirbusqueda() {  // Abre busqueda
                this.citapet = {}; 
                this.citacli = {};
                this.dialogobuscar = true;
            },                  
            busqueda(id) {  // Busqueda
                this.citacli = {};
                
                axios.get(`api/app/getcitasbyuser/${id}`).then(res => {
                    res.data.cita.forEach(cita => {
                        this.citacli = cita;
                    });
                }, err => { }) 
            },            
            citaPet(citacli) {
                let base_url = citacli.tipo == 'peluqueria' ? 'citas-peluqueria?tipo=peluqueria' : 'citas-clinica?tipo=clinica'
                this.$router.push(`${base_url}&fecha=${citacli.start_format}&tienda=${citacli.tienda}`).catch(() => {});
                this.cierrabusqueda();
            },
        },
        computed: {
            filtrar_horas_reales() {
                return []
            },
            evento_horario() {
                return []
            },
            historial() {
                if (this.mascota.historial.length > 0) {
                    return this.mascota.historial.map(x => x.servicio)
                }
                return null
            },
            isloading() {
                return this.$store.getters.getloading
            }
        }
    }
</script>

<style media="screen">
    .cita-element {
        background-color: #1e5dbf;
        border-radius: 8px;
        font-size: 10px !important; 
        padding: 3px;
        color: #fff;        
        overflow: hidden;
    }
        div#buscar.cita-element i{
        color: #fff;
        font-size: 15px !important; 
        text-transform: uppercase !important;
    }

    .cita :hover{
        cursor: pointer;
    }    
</style>