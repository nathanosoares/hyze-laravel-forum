<template>
    <transition name="dialog" v-if="!logged">
        <div class="dialog-mask d-flex align-items-center justify-content-center">
            <div class="dialog-wrapper">
                <div class="dialog-container">
                    <div class="dialog-header">
                        Você precisa estar logado.
                    </div>

                    <div class="dialog-body mt-4">
                        <a :href="cancelUrl" class="btn btn-sm btn-custom-secondary mr-3">
                            Cancelar
                        </a>

                        <a :href="route('auth.redirect', 'twitter')" class="btn btn-custom-primary">
                            <i class="fab fa-twitter font-weight-light"></i> Entrar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "LoginModal",
        props: {
            cancelUrl: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                url: null,
                logged: false
            }
        },
        mounted() {
            this.logged = !!this.$user;
        }
    }
</script>

<style scoped>
    .dialog-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(12, 21, 35, .75);
        transition: opacity .3s ease;
    }

    .dialog-container {
        /*width: 400px;*/
        margin: 0 auto;
        padding: 20px 30px;
        background-color: #0f1b29;
        border-radius: 2px;
        border: 1px solid #a17f3c;
        transition: all .3s ease;
    }

    .dialog-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .dialog-body {
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="dialog" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the dialog transition by editing
     * these styles.
     */

    .dialog-enter {
        opacity: 0;
    }

    .dialog-leave-active {
        opacity: 0;
    }

    .dialog-enter .dialog-container,
    .dialog-leave-active .dialog-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>