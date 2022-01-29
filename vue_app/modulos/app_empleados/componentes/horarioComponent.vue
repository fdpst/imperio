<template>
    <v-container>        
<v-row>
<v-col cols="12" md="10" >
        <v-row dense align="center">
            <v-col cols="12" md="2">
                <v-select label="Tiendas" :items="tiendas" item-text="nombre" item-value="id" v-model="horario.app_tienda_id"></v-select>
            </v-col>
            <v-col cols="12" md="2">
                <v-menu ref="menu" v-model="menu" :close-on-content-click="false" :return-value.sync="horario.fechas" transition="scale-transition" offset-y min-width="auto">
                    <template v-slot:activator="{ on, attrs }">
                        <v-combobox v-model="horario.fechas" multiple chips small-chips label="Fecha" prepend-icon="mdi-calendar" v-bind="attrs" v-on="on"></v-combobox>
                    </template>
                    <v-date-picker color="green" first-day-of-week="1" v-model="horario.fechas" multiple no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn text color="red" @click="menu = false"><strong>Cancelar</strong></v-btn>
                        <v-btn text color="success" @click="$refs.menu.save(horario.fechas)"><strong>OK</strong></v-btn>
                    </v-date-picker>
                </v-menu>
            </v-col>
            <v-col cols="12" md="1">
                <v-text-field v-model="horario.entrada" label="Entrada" required v-mask="'##:##'"></v-text-field>
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
                <v-btn @click="guardarHorario" depressed rounded color="success" class="white--text">guardar</v-btn>
            </v-col>
        </v-row>
</v-col>
</v-row>
        <v-row dense align="center">
            <v-col cols="12" md=8>
                <v-data-table :headers="headers" :items="local_fechas" disable-pagination hide-default-footer item-key="id" class="elevation-1" 
                    :sort-by="['app_tienda_id', 'fecha']" :sort-desc="[true, false]" multi-sort>
                    <template v-slot:item.app_tienda_id="{item}"> {{item.app_tienda_id, tiendas | gettienda}} </template>
                    <template v-slot:item.action="{ item }">
                        <v-icon small color="blue" @click="setHorario(item)">mdi-pencil</v-icon>
                        <v-icon small color="red" @click="deleteHorario(item)">mdi-trash-can</v-icon>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        props: ['empleado_id', 'fechas', 'tiendas'],
        data() {
            return {
                local_fechas: [],
                allowed_minutes: [0, 15, 30, 45],
                menu: false,
                menu2: false,
                menu3: false,
                horario: {
                    id:null,
                    app_tienda_id: null,
                    fechas: [],
                    entrada: "00:00",
                    salida: "00:00",
                    entrada2: '00:00',
                    salida2: '00:00'
                },
                headers:
                [
                    {text: 'Tienda',align: 'left',value: 'app_tienda_id',sortable: false},
                    {text: 'Fecha',align: 'left',value: 'fecha',sortable: false},
                    {text: 'Entrada',value: 'entrada',sortable: false},
                    {text: 'Salida',value: 'salida',sortable: false},
                    {text: 'Acciones',value: 'action',sortable: false}
                ],
            }
        },
        watch: {
            'fechas': {
                immediate: true,
                handler(n) {
                    this.local_fechas = JSON.parse(JSON.stringify(n))
                }
            },
        },        
        methods: {
            guardarHorario() {
                axios.post(`api/app/add-horario/${this.empleado_id}`, this.horario).then(res => {
                    this.local_fechas = res.data
                    this.$toast.sucs('Fecha guardada')
                    this.resetForm()
                }, res => {
                    this.$toast.error('Algo ha salido mal')
                })
            },
            deleteHorario(item) {
                axios.get(`api/app/delete-horario/${item.id}`).then(res => {
                    let i = this.local_fechas.findIndex(x => x.id == item.id)
                    this.local_fechas.splice(i, 1)
                    this.$toast.sucs('Fecha Eliminada')
                }, res => {
                    this.$toast.error('Algo ha salido mal')
                })
            },
            setHorario(item) {
                this.horario = item
                this.horario.fechas = [item.fecha]
                this.horario.entrada2="00:00"
                this.horario.salida2="00:00"
            },
            resetForm() {
                this.horario = {
                    id:null,
                    app_tienda_id: null,
                    fechas: [],
                    entrada: "00:00",
                    salida: "00:00",
                    entrada2: '00:00',
                    salida2: '00:00'
                }
            },                        
        },
        filters: {
            gettienda(val, tiendas) {
                let nombre = "";
                tiendas.forEach(element => {
                    if (element.id == val){
                        nombre =  element.nombre;
                    }
                });
                return nombre;
            }
        }        
    }
</script>