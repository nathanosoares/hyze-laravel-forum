import Vue from 'vue';
import Vuex from 'vuex';
import threads from './modules/threads';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        threads
    },
    strict: debug
});