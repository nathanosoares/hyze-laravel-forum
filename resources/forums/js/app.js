/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueClipboard from 'vue-clipboard2';
import VueSimplemde from 'vue-simplemde';
import Gate from './Gate';
import previewRender from './parsedown';
import moment from 'moment-timezone';

Vue.use(VueClipboard);
Vue.use(VueSimplemde);

moment.tz.setDefault('America/Sao_Paulo');
moment.updateLocale('en', {
    relativeTime: {
        future: 'em %s',
        past: 'há %s',
        s: 'alguns segundos',
        ss: '%d segundos',
        m: "um minuto",
        mm: "%d minutos",
        h: "uma hora",
        hh: "%d horas",
        d: "um dia",
        dd: "%d dias",
        M: "um mês",
        MM: "%d meses",
        y: 'um ano',
        yy: '%d anos'
    }
});

Vue.mixin({
    methods: {
        route,
        moment
    }
});

import store from './store';

Vue.prototype.$user = window.user;
Vue.prototype.$gate = new Gate(Vue.prototype.$user);
Vue.prototype.$simplemde = {
    configs: {
        spellChecker: false,
        status: false,
        previewRender
    }
};

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('show-thread-view', require('@views/forums/ShowThread/Index'));
Vue.component('create-thread-view', require('@views/forums/CreateThread/Index'));
Vue.component('user-avatar', require('@components/UserAvatar'));
Vue.component('user-twitter-anchor', require('@components/UserTwitterAnchor'));
Vue.component('login-modal', require('@components/LoginModal/Index'));
Vue.component('author-card-normal', require('@components/forums/AuthorCard/Normal'));

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});

