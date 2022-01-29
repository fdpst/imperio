<template>
    <v-container>
        <v-custom-title text="Guardar / Editar Empleado"></v-custom-title>
        <loader v-if="isloading"></loader>
        <v-row>
            <v-col cols="12" md="4">
                <v-form>
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field filled v-model="empleado.nombre" label="Nombre" required></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field filled v-model="empleado.email" label="Email" required></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field filled v-model="empleado.telefono" label="teléfono" required></v-text-field>
                        </v-col>
                    </v-row>
                    <!--<v-row dense>
                        <v-col cols="12">
                            <v-autocomplete filled v-model="empleado.tipo_id" :items="tipos" item-text="nombre" item-value="id" label="Tipo Servicio"></v-autocomplete>
                        </v-col>
                    </v-row>-->
                    <v-row dense>
                        <v-col cols="12">
                            <v-color-picker mode="hexa" v-model="empleado.color"></v-color-picker>
                        </v-col>
                    </v-row>
                    <v-row dense>
                        <v-col cols="12">
                            <v-btn rounded depressed @click="saveEmpleado" :disabled="isloading" color="success" class="white--text">Guardar</v-btn>
                            <v-btn rounded depressed v-if="empleado.id" @click="dialog = true" :disabled="isloading" color="red" class="white--text">Eliminar</v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-col>
            <v-col cols="12" md=1></v-col>
            <v-col cols="12" md=6>
                <h3>Días libres</h3>
                <v-date-picker color="green" first-day-of-week="1" v-model="empleado.lista_libres" multiple></v-date-picker>
            </v-col>
        </v-row>
        <h3 class="mt-5">Horario Habitual</h3>
        <v-row v-if="empleado.id != null">
            <v-col cols="12" md="10" >
                <v-row dense align="center">
                    <v-col cols="12" md="2">
                        <v-select label="Tiendas" :items="tiendas" item-text="nombre" item-value="id" v-model="horario.app_tienda_id"></v-select>
                    </v-col>
                    <v-col cols="12" md="2">
                        <v-select label="Dia" :items="dias" item-text="text" prepend-icon="mdi-calendar" item-value="dia" v-model="horario.dia"></v-select>
                    </v-col>
                    <v-col cols="12" md="1">
                        <v-text-field  v-model="horario.entrada" label="Entrada" required v-mask="'##:##'">
                        </v-text-field>
                    </v-col>
                    <v-col cols="12" md="1">
                        <v-text-field v-model="horario.salida" label="Salida" required  v-mask="'##:##'"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="1">
                        <v-text-field :disabled="horario.entrada == '00:00' || horario.salida == '00:00'" v-model="horario.entrada2" label="Entrada 2"  v-mask="'##:##'"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="1">
                        <v-text-field :disabled="horario.entrada == '00:00' || horario.salida == '00:00'" v-model="horario.salida2" label="Salida 2"  v-mask="'##:##'"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3">
                         <v-btn @click="pushHorario" rounded depressed color="blue" class="white--text">agregar</v-btn>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md=8>
                <v-data-table sort-by="dia" :headers="headers" :items="empleado.horario" disable-pagination hide-default-footer item-key="id" class="elevation-1">
                    <template v-slot:item.dia="{item}">{{item.dia | getday}}</template>
                    <template v-slot:item.action="{ item }">
                        <v-icon small color="blue" @click="setHorario(item)">mdi-pencil</v-icon>
                        <v-icon small color="red" @click="deleteHorario(item)">mdi-trash-can</v-icon>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>

        <h3 class="mt-5">Horario para un día específico</h3>
        <horario-component v-if="empleado.id" :empleado_id="empleado.id" :fechas="empleado.fechas" :tiendas="tiendas"></horario-component>
        <v-dialog persistent v-model="dialog" max-width="290">
            <v-card>
                <v-card-title class="headline">Eliminar Empleado</v-card-title>
                <v-card-text><p>Se eliminaran todas las citas asociadas</p></v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn :loading="isloading" color="red" dark @click="deleteEmpleado">Eliminar</v-btn>
                    <v-btn color="red" outlined text @click="dialog = false">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    import horarioComponent from './horarioComponent'    
    export default {
        components: { horarioComponent },
        data() {
            return {
                tiendas: [],
                contador:1,
                mask: '##:##',
                dias:
                [
                    {dia: 1,text: 'Lunes'},
                    {dia: 2,text: 'Martes'},
                    {dia: 3,text: 'Miercoles'},
                    {dia: 4,text: 'Jueves'}, 
                    {dia: 5,text: 'Viernes'},
                    {dia: 6,text: 'Sabado'},
                    {dia: 0,text: 'Domingo'},
                ],
                headers:
                [
                    {text: 'Tienda',align: 'left',value: 'nombre_tienda'},
                    {text: 'Dia',align: 'left',value: 'dia'},
                    {text: 'Entrada',value: 'entrada'},
                    {text: 'Salida',value: 'salida'},
                    {text: 'Acciones',value: 'action',sortable: false},
                ],
                tipos: [],
                dialog: false,
                tipo_libre: 'L',
                color: {hex: '#000'},
                empleado: {
                    id: '',
                    nombre: '',
                    email: '',
                    telefono: '',
                    is_active: true,
                    color: '#000',
                    tipo_id: 1,
                    lista_libres: [],
                    lista_vacaciones: [],
                    horario: [],
                    tienda: [],
                    tipo_libre: 'L'
                },
                horario: {
                    id: `temp-${new Date().getTime()}`,
                    dia: null,
                    app_tienda_id: null,
                    entrada: '00:00',
                    salida: '00:00',
                    entrada2: '00:00',
                    salida2: '00:00'
                }
            }
        },
        watch: {
            'color.hex'(n) { this.empleado.color = n }            
        },
        created() {
            this.getTipos()
            this.getTiendas()
            if (this.$route.query.id) {this.getEmpleado(this.$route.query.id)}
        },
        methods: {
            getTipos() {
                axios.get(`api/app/gettipos`).then(res => {
                    this.tipos = res.data
                }, res => {
                    this.$toast.error('Algo ha salido mal')
                })
            },
            getTiendas() {
                axios.get(`api/app/gettiendas`).then(res => {
                    this.tiendas = res.data
                }, res => {
                    this.$toast.error('Algo ha salido mal')
                })
            },
            getEmpleado(empleado_id) {
                axios.get(`api/app/getempleado/${empleado_id}`).then(res => {
                    this.empleado = res.data.empleado
                    this.empleado.tipo_libre = 'L'
                }, res => {
                    this.$toast.error('Algo ha salido mal')
                })
            },
            saveEmpleado() {
                let tiendas_empleado = []
                this.tiendas.forEach(element => {
                    tiendas_empleado.push(element.id)    
                });
                this.empleado.tienda = tiendas_empleado;
                axios.post('api/app/saveempleado', this.empleado).then(res => {
                                        
                    this.$router.push('lista-empleados-app')
                }, res => {
                    this.$toast.error('Algo ha salido mal')

                })
            },
            deleteEmpleado() {
                axios.get(`api/app/deleteempleado/${this.empleado.id}`).then(res => {
                    this.dialog = false
                    this.$router.push('lista-empleados-app')
                }, res => {
                    this.$toast.error('Algo ha salido mal')
                })
            },
            pushHorario() {
                axios.post(`api/app/savehorario/${this.empleado.id}`, this.horario).then(res => {
                    let horario_guardado = res.data.horario
                    if (res.data.was_created) {
                        this.empleado.horario.push(horario_guardado)
                        // Actualizamos el segundo horario
                        if (res.data.was_created2) {
                            let horario_guardado2 = res.data.horario2
                            this.empleado.horario.push(horario_guardado2)
                        }
                        this.resetForm()
                        return null
                    }                    
                    let i = this.empleado.horario.findIndex(horario => horario.id == horario_guardado.id)
                    this.$set(this.empleado.horario, i, horario_guardado)
                    this.resetForm()
                }, res => {
                    this.$toast.error('Algo ha salido mal')
                })
            },            
            resetForm() {
                this.horario = {
                    id: `temp-${new Date().getTime()}`,
                    dia: null,
                    app_tienda_id: null,
                    entrada: '00:00',
                    salida: '00:00',
                    entrada2: '00:00',
                    salida2: '00:00'
                }
            },
            setHorario(item) {
                this.horario = item
                this.horario.entrada2="00:00"
                this.horario.salida2="00:00"
            },
            deleteHorario(item) {
                axios.post(`api/app/deletehorario/${item.id}`, ).then(res => {
                    let i = this.empleado.horario.findIndex(x => x.id == item.id)
                    this.empleado.horario.splice(i, 1)
                }, res => {
                    this.$toast.error('Algo ha salido mal')
                })
            }
        },
        filters: {
            getday(val) {
                switch (val) {
                    case 0:
                        return 'Domingo'
                        break;
                    case 1:
                        return 'Lunes'
                        break;
                    case 2:
                        return 'Martes'
                        break;
                    case 3:
                        return 'Miercoles'
                        break;
                    case 4:
                        return 'Jueves'
                        break;
                    case 5:
                        return 'Viernes'
                        break;
                    case 6:
                        return 'Sabado'
                        break;
                    default:
                        return 'N/A'
                }
            }
        },
        computed: {
            isloading() {
                return this.$store.getters.getloading
            },
            filter_days() {
                return this.empleado.horario.filter(element => {
                    return element.app_tienda_id == this.horario.app_tienda_id
                })
            }
        }
    }
</script>