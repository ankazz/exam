
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');
//window.vuex = require('vuex');
//window.vSelect  = require('vue-select');
import vSelect from 'vue-select'

//подключаем Vuex
import Vuex from 'vuex'
import StoreData from './store'
Vue.use(Vuex)
const store = new Vuex.Store(StoreData);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('users', require('./components/users/index.vue'));
Vue.component('users-edit', require('./components/users/edit.vue'));

Vue.component('job', require('./components/Job.vue'));
Vue.component('tms', require('./components/Tms.vue'));
Vue.component('edizm', require('./components/Edizm.vue'));
Vue.component('service', require('./components/service.vue'));
Vue.component('task', require('./components/task.vue'));
Vue.component('ttms', require('./components/ttms.vue'));

const app = new Vue({
    el: '#app',
    store,
    data: {
    }
});
