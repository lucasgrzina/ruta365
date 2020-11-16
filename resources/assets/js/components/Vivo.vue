<template>
    <div>
            <div class="row content-title">
                <div class="col-md-12 text-center">
                    <!--div class="line line--left"></div-->
                    <button type="button" class="btn btn-primary" @click="verVideo('ingles')">Audio Original Ingles</button>
                    <button type="button" class="btn btn-primary" @click="verVideo('esp')">Audio Español</button>                    

                    <!--div class="line line--right"></div-->
                </div>
            </div>
            <div class="row content-encuesta" v-if="videoSeleccionado">
                <div class="col-sm-12 text-center">
                    <button type="button" 
                            class="btn btn-primary" 
                            @click="encuestaDisponible()"
                    >
                        <span>Encuesta</span>
                    </button>                    
                </div>

            </div>
            <div class="row content-vimeo">
                <div class="col-md-12" v-if="videoSeleccionado">
                    <span style="color:#fff;text-align:center;width:100%;margin-top: 20px;display: block;"><i class="fa fa-volume-up" aria-hidden="true"></i>Por favor, activar el sonido del reproductor</span>
                    <div class="contenedor_vimeo" v-if="videoSeleccionado === 'ingles'">
                        <iframe src="https://player.vimeo.com/video/445700607" frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                    </div>                    
                    <div class="contenedor_vimeo" v-else>
                        <iframe src="https://player.vimeo.com/video/445700271" frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                    </div>                    
                </div>
                <div class="col-md-12" v-else>
                    <span style="color: rgb(16, 33, 63);
    text-align: center;
    width: 100%;
    margin-top: 20px;
    display: block;
    padding: 20px;
    background: #e09b3f;
    border: 2px solid #fff;">
                        <i class="fa fa-arrow-up" aria-hidden="true"></i> 
                        Para ver el evento, seleccione en los botones de arriba la opción de audio</span>
                </div>                
            </div>
            <div class="row content-vimeo-chat" v-if="videoSeleccionado">
                <div class="col-sm-9 form-container">
                    <input type="text" class="form-control" id="pregunta" name="pregunta" placeholder="Escriba su pregunta aquí" v-model="form.pregunta">
                </div>
                <div class="col-sm-3 text-center">
                    <button type="button" 
                            class="btn btn-primary" 
                            @click="enviarPregunta()"
                            :disabled="!form.pregunta"
                    >
                        <i v-if="enviando" class="fa fa-spinner fa-spin fa-fw"></i> 
                        <span v-if="!enviando">ENVIAR</span>
                    </button>                    
                </div>
            </div>

            <i class="fa fa-spinner fa-spin fa-fw" style="opacity:0;"></i>
            
            <div v-if="showModal">
                <transition name="modal">
                    <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-container">

                        <div class="modal-header" style="color: #fff;padding: 0px 0px 10px;">
                            <slot name="header">
                            Encuesta de satisfacción
                            </slot>
                        </div>

                        <div class="modal-body">
                            <div class="container-encuesta">
                                <div class="row" v-for="(item,index) in encuesta.preguntas" :key="index">
                                    <div class="col-12">
                                        <h5>{{item.key}}) {{item.tit}}</h5>
                                        <p>{{item.preg}}</p>
                                    </div>
                                    <div class="col-12">
                                        <template v-if="item.tipo === 'C'">
                                            <template v-for="subitem in encuesta.opciones">
                                            <div class="form-check-inline" :key="subitem.key">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" :name="'p_'+item.key+'_r_'+subitem.key" :value="subitem.key" v-model="encuesta.form['resp_' + item.key]"> {{subitem.texto}}
                                                </label>
                                            </div>
                                            <br :key="subitem.key">
                                            </template>
                                            
                                        </template>
                                        <template v-else>
                                            <textarea class="form-control" :name="'p_'+item.key" v-model="encuesta.form['resp_' + item.key]"></textarea>
                                        </template>
                                    </div>
                                </div>

                                <div class="text-right">

                                </div>
                                <i class="fa fa-spinner fa-spin fa-fw" style="opacity:0;"></i>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <slot name="footer">
                            <button type="button" 
                                    class="btn btn-primary" 
                                    @click="enviarEncuesta()">
                                <i v-if="encuesta.enviando" class="fa fa-spinner fa-spin fa-fw"></i> 
                                <span> {{ encuesta.enviando ? 'Enviando' : 'Enviar' }} </span>
                            </button>                            
                            <button type="button" class="btn btn-primary" @click="mostrarModal(false)">
                                Cerrar
                            </button>
                            </slot>
                        </div>
                        </div>
                    </div>
                    </div>
                </transition>
            </div>   

            <div class="row content-certificado" v-if="videoSeleccionado">
                <div class="col-12 text-center">
                    <button 
                            v-if="registrado && registrado.certificado"
                            type="button" 
                            class="btn btn-primary" 
                            @click="certificadoDisponible()"
                    >
                        <span>Certificado</span>
                    </button>                    
                    <a :href="urlSitioPpal" 
                            class="btn btn-primary" 
                    >
                        <span>Volver</span>
                    </a>                    

                </div>

            </div>

    </div>
</template>

<script>
    
    export default {
        props : {
            urlEnviar: {
                type: String,
                required:true
            },
            urlEnviarEncuesta: {
                type: String,
                required:true
            },            
            urlEncuestaDisponible: {
                type: String,
                required:true
            },
            urlEncuesta: {
                type: String,
                required:true
            },
            registrado: {
                type: Object,
                required: true
            },
            urlSitioPpal: {
                type: String,
                required:true
            },   
            urlEnviarSalidaUsuario: {
                type: String,
                required:true
            }         

        },
        data () {
            return {
                videoSeleccionado: null,
                form: {
                    pregunta: null
                },
                encuesta: {
                    preguntas: [
                        {key: 1,tit: 'El contenido del programa es relevante para mi consultorio', preg: '', tipo: 'C'},
                        {key: 2,tit: 'Los oradores y contenido son interesantes', preg: '', tipo: 'C'},
                        {key: 3,tit: 'Logística y experiencia del evento: calidad audiovisual y de la transmisión son buenas y sin interrupciones', preg: '', tipo: 'C'},
                        {key: 4,tit: 'Probablemente participaré en las ofertas visuales futuras de Abbott Nutrición', preg: '', tipo: 'C'},
                        {key: 5,tit: 'Probablemente recomendaré este webinario a mis colegas', preg: '', tipo: 'C'},
                        {key: 6,tit: '¿Qué temas son de mayor interés para usted relacionados con la nutrición?', preg: '', tipo: 'T'},
                        {key: 7,tit: '¿Cuál es el aprendizaje más importante en este programa que pudiera traducirse a su consultorio clínico?', preg: '', tipo: 'T'},
                        {key: 8,tit: '¿Alguna sugerencia para hacer este webinar más efectivo?', preg: '', tipo: 'T'},
                    ],
                    opciones: [
                        {key: 5, texto: 'Totalmente de acuerdo'},
                        {key: 4, texto: 'De acuerdo'},
                        {key: 3, texto: 'Ni en desacuerdo ni de acuerdo'},
                        {key: 2, texto: 'En desacuerdo'},
                        {key: 1, texto: 'Totalmente en desacuerdo'},
                    ],
                    form: {
                        resp_1: null,
                        resp_2: null,
                        resp_3: null,
                        resp_4: null,
                        resp_5: null,
                        resp_6: null,
                        resp_7: null,
                        resp_8: null,
                    },
                    enviando: false,
                    errors: [],
                },
                showModal: false,
                enviando: false,
                enviandoEncuesta: false
            }
        },
        mounted () {
            var vm = this;

            window.addEventListener('beforeunload', function (e) {
                vm.enviarSalidaUsuario().then(response => {
                    e.preventDefault(); // If you prevent default behavior in Mozilla Firefox prompt will always be shown
                    e.returnValue = '';
                }, error => {
                    e.preventDefault(); // If you prevent default behavior in Mozilla Firefox prompt will always be shown
                    // Chrome requires returnValue to be set
                    e.returnValue = '';
                    
                });                    
            });            
        
        },
        methods: {
            verVideo (video) {
                this.videoSeleccionado = video;
            },
            enviarPregunta: function () {
                let vm = this
                if (vm.form.pregunta && !vm.enviando) {
                    vm.enviando = true;
                    axios.post(vm.urlEnviar, vm.form)
                        .then(response => {
                            vm.enviando = false;
                            vm.form.pregunta = null;
                        }, error => {
                            vm.enviando = false;
                            alert(error.message);
                        });                    
                }
            },
            encuestaDisponible: function() {
                let vm = this
                if (!vm.enviandoEncuesta) {
                    vm.enviandoEncuesta = true;
                    axios.get(vm.urlEncuestaDisponible)
                        .then(response => {
                            vm.enviandoEncuesta = false;
                            //document.location = vm.urlEncuesta;
                            vm.mostrarModal(true);
                        }, error => {
                            vm.enviandoEncuesta = false;
                            alert('La encuesta no se encuentra disponible por el momento.');
                        });                    
                }
            },
            enviarEncuesta: function () {
                let vm = this

                if (!vm.encuesta.form.resp_1 || !vm.encuesta.form.resp_2 || !vm.encuesta.form.resp_3 || !vm.encuesta.form.resp_4 || !vm.encuesta.form.resp_5 || !vm.encuesta.form.resp_6 || !vm.encuesta.form.resp_7 || !vm.encuesta.form.resp_8) {
                    alert('Debe responder todas las preguntas');
                    return false;
                }

                if (!vm.encuesta.enviando) {
                    vm.encuesta.enviando = true;
                    axios.post(vm.urlEnviarEncuesta, vm.encuesta.form)
                        .then(response => {
                            vm.encuesta.enviando = false;
                            vm.encuesta.form = {
                                resp_1: null,
                                resp_2: null,
                                resp_3: null,
                                resp_4: null,
                                resp_5: null,
                                resp_6: null,
                                resp_7: null,
                                resp_8: null,
                            };
                            alert('Gracias por responder la encuesta');
                            vm.mostrarModal(false);
                            // vm.form.pregunta = null;
                        }, error => {
                            vm.encuesta.enviando = false;
                            
                            alert(error.message);
                        });                    
                }
            },
            mostrarModal: function(valor) {
                this.showModal = valor;
            },
            certificadoDisponible: function() {
                let vm = this
                if (!vm.enviandoEncuesta) {
                    vm.enviandoEncuesta = true;
                    axios.get(vm.urlEncuestaDisponible)
                        .then(response => {
                            vm.enviandoEncuesta = false;
                            document.location = vm.registrado.certificado;
                            //vm.mostrarModal(true);
                        }, error => {
                            vm.enviandoEncuesta = false;
                            alert('El certificado no se encuentra disponible por el momento.');
                        });                    
                }
            },
            enviarSalidaUsuario: function() {
                let vm = this
                return axios.post(vm.urlEnviarSalidaUsuario.replace('_ID_',vm.registrado.id),{});
            }
        }
    }
</script>
<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
    width: 90%;
    max-width: 630px;
    margin: 0px auto;
    padding: 10px;
    background-color: #061422;
    border-radius: 2px;
    box-shadow: 0 2px 8px #e7a249;
    transition: all 0.3s ease;
    border: 1px solid #9E9E9E;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 0;
  padding: 0;
  max-height: 500px;
  overflow-y: auto;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
.modal-footer {
    justify-content: center;
    padding: 0;
    background: #061422;
    border-top-color: #061422;    
}

</style>