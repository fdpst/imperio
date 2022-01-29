<template>
    <v-container>
        <v-toolbar color="red lighten-2" dark class="mx-auto">
            <v-toolbar-title>Tipos IVA</v-toolbar-title>
        </v-toolbar>
        <loader v-if="isloading"></loader>
        <v-sheet shaped class="mx-4 my-4 pa-4 col-4">
            <v-row dense align="center">
                <v-col cols="12" md="12">
                    <v-text-field v-model="iva.iva" label="IVA (%)"></v-text-field>
                </v-col>
                <v-col cols="12" md="12">
                    <v-btn @click="saveIva" small class="white--text" color="light-blue">guardar</v-btn>
                </v-col>
            </v-row>

            <v-row dense>
                <v-col cols="12" md="12">
                    <v-data-table :headers="headers" :items-per-page="10" :items="ivas" item-key="id" class="elevation-4">
                        <template v-slot:item.action="{ item }">
                            <v-icon @click="setIva(item)" small class="mr-2">mdi-pencil</v-icon>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-sheet>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                iva: {
                    iva: 0
                },
                ivas: [],
                headers: [{
                        text: 'IVA',
                        align: 'left',
                        value: 'iva',
                    },
                    {
                        text: 'Acciones',
                        value: 'action',
                        sortable: false
                    },
                ],
            }
        },
        created() {
            this.getIvas()
        },
        methods: {
            getIvas() {
                axios.get('api/getivas').then(res => {
                    this.ivas = res.data
                }, res => {
                    this.$toast.error('Error consultando iva')
                })
            },
            saveIva() {
                axios.post('api/saveiva', this.iva).then(res => {
                    this.ivas.splice(this.ivas.indexOf(res.data), 1)
                    this.ivas.push(res.data)
                    this.iva = {
                        iva: ''
                    }
                }, res => {
                    this.$toast.error('Error guardando iva')
                })
            },
            setIva(iva) {
                console.log(iva);
                this.iva = iva
            }
        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            }
        }
    }
</script>