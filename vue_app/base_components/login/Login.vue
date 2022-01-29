<template>

    <v-app id="inspire">
        <v-content>
            <v-container class="fill-height" fluid>

                <v-row align="center" justify="center">
                    <v-col cols="12" md="4">

                        <img width="100%;" src="logo.png" alt="">

                        <v-card style="border-radius:0;" flat class="elevation-2">
                            <v-card-text>
                                <v-form>
                                    <v-text-field prepend-icon="mdi-account" v-model="user.email" label="Email" required></v-text-field>
                                    <v-text-field prepend-icon="mdi-key" v-model="user.password" label="Contraseña" required type="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :type="show1 ? 'text' : 'password'"
                                      @click:append="show1 = !show1"></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="isloading" @click="Login" color="light-blue lighten-2" class="white--text">Login</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>


</template>

<script>
    import auth from '../../auth/auth.js'
    export default {
        data() {
            return {
                show1: false,
                user: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            Login() {
                auth.signin(this.user)
            }
        },
        computed: {
            isloading: function() {
                return this.$store.getters.getloading
            },
        }
    }
</script>

<style>
    .cover-img {
        height: 100%
    }

    .back {
        background-color: #212121;
    }
</style>