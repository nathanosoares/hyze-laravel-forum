require('./bootstrap');

window.Vue = require('vue');

import VueClipboard from 'vue-clipboard2';
import VueSimplemde from 'vue-simplemde';
// import Gate from './Gate';
// import previewRender from './parsedown';
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

Vue.prototype.$user = window.user;
// Vue.prototype.$gate = new Gate(Vue.prototype.$user);
Vue.prototype.$simplemde = {
    configs: {
        spellChecker: false,
        status: false,
        // previewRender
    }
};

Vue.component('admin-forums-view', require('./views/ForumsView.vue'));

const app = new Vue({
    el: '#app'
});

