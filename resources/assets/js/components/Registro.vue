<template>
    <div>
        <div class="row content-big-title" v-if="paso === 1">
            <div class="col-md-12">
                <div class="line line--left"></div>
                <a class="btn btn-primary" @click="mostrarDisc()">Registrarse para<br> ingresar al evento</a>
                <div class="line line--right"></div>
            </div>
        </div>  
        <template  v-else-if="paso === 2">
            <div class="row content-title" style="margin-bottom: 10px;">
                <div class="col-md-12">
                    <div class="line line--left"></div>
                    <h1>Registro</h1>
                    <div class="line line--right"></div>
                </div>
            </div>
            <div class="row">
                    <div class="col-md-12">
                        <div class="modal-disc">
                            <p class="modal-disc-texto">
                                En cumplimiento de las políticas corporativas de Abbott, le informamos que este evento es exclusivo para profesionales de la salud. En caso de que esta invitación no esté acorde con su área de especialización/conocimiento y/o desarrollo profesional o, en caso de que usted sea un empleado del gobierno y su participación contravenga alguna ley, reglamento o norma interna de su institución y no cuente con las respectivas autorizaciones, le solicitamos nos informe a la brevedad posible.
                                <br><br>
                                La información y/o datos brindados para el registro al evento serán utilizados únicamente durante su participación en el evento y envío de información relacionada al evento. Todos los datos serán manejados de acuerdo a nuestros procedimientos de manejo de datos y no podrán ser compartidos y/o utilizados para fines diferentes a su participación en este evento.                        
                            </p>
                            <a class="modal-disc-btn" @click="mostrarForm()" @blur="mostrarBlur(false)" @focus="mostrarBlur(true)">
                                <i class="fa fa-circle lnk-visible-blur"></i><i class="fa fa-dot-circle lnk-visible-noblur"></i> ACEPTO PROCEDER CON EL REGISTRO
                            </a>
                        </div>
                    </div>

            </div>

        </template>
        <template v-else>      
            <div class="row content-title">
                <div class="col-md-12">
                    <div class="line line--left"></div>
                    <h1>Registro</h1>
                    <div class="line line--right"></div>
                </div>
            </div>
            
            <form class="form-container" id="frm-registro">
                <div class="form-group row">
                    <div class="col-md-5">
                        <label for="name">Nombre</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="" v-model="form.nombre">
                    </div>
                    <div class="col-md-12">
                        <small id="nameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <label for="name">Apellido</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="" v-model="form.apellido">
                    </div>
                    <div class="col-md-12">
                        <small id="nameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <label for="name">Especialidad</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="" v-model="form.especialidad">
                    </div>
                    <div class="col-md-12">
                        <small id="nameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-5">
                        <label for="name">Pais</label>
                    </div>
                    <div class="col-md-7">
                        <select id="country" name="country" v-model="form.pais" class="form-control">
                            <option :value="null">Seleccione</option>
                            <option v-for="(item,index) in info.countries" :value="item" :key="index">{{item}}</option>
                        </select>
                        <!--input type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="" v-model="form.pais"-->
                    </div>
                    <div class="col-md-12">
                        <small id="nameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                </div>
    
                <div class="form-group row">
                    <div class="col-md-5">
                        <label for="exampleInputEmail1">Mail</label>
                    </div>
                    <div class="col-md-7">
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" v-model="form.email">
                    </div>
                    <div class="col-md-12">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                </div>
    

                <button type="button" 
                        class="btn btn-primary" 
                        @click="registrar()">
                    <i v-if="guardando" class="fa fa-spinner fa-spin fa-fw"></i> 
                    <span> {{ guardando ? 'ENVIANDO' : 'ENVIAR' }} </span>
                </button>
            </form>      
        </template>  
    </div>
</template>

<script>
    export default {
        props : {
            urlRegistrar: {
                type: String,
                required:true
            }
        },
        data () {
            return {
                paso: 1,
                lnk_blur: false,
                info: {
                    countries: ['Costa Rica','El Salvador','Guatemala','Honduras','Nicaragua','Panamá','República Dominicana','Otro']
                },
                form: {
                    nombre: null,
                    apellido: null,
                    especialidad: null,
                    pais: null,
                    email: null
                },
                guardando: false,
                errors: [],
            }
        },
        mounted () {
            console.debug('Registro mounted');
        },
        methods: {
            mostrarBlur: function (val) {
                console.debug('mostrar blur');
                this.lnk_blur = val;
            },
            mostrarDisc () {
                this.paso = 2;
            },            
            mostrarForm () {
                this.paso = 3;
            },
            checkForm: function (e) {

                this.errors = [];

                if (!this.form.nombre || !this.form.apellido || !this.form.especialidad || !this.form.pais || !this.form.email ) {
                    alert('Todos los campos son obligatorios');
                    return false;
                }

                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                                
                if (!re.test(this.form.email)) {
                    alert('El formato del email es incorrecto.');
                    return false;
                }
                return true;
                
            },            
            registrar () {

                let vm = this
                if (this.guardando) {
                    return false;
                }
                if (this.checkForm()) {
                    this.guardando = true;

                    grecaptcha.ready(function() {
                        grecaptcha.execute('6Leb2qYZAAAAALa7WyEDFhvJUYlYQH4Z_CJ-U-ie', {action: 'submit'}).then(function(token) {
                            // Add your logic to submit to your backend server here.
                            if (token) {
                                axios.post(vm.urlRegistrar, vm.form)
                                    .then(response => {
                                        console.debug(response);
                                        vm.guardando = false;
                                        location.reload();
                                    }, error => {
                                        vm.guardando = false;
                                        alert(error.message);
                                    });

                            }

                        });
                    });
                }
                
            }
        }
    }
</script>
<style scoped>
</style>