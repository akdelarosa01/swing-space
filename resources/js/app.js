require('./bootstrap');

window.Vue = require('vue');

import axios from 'axios';

window.axios.defaults.headers.common = {
	'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content'),
	'X-Requested-With': 'XMLHttpRequest'
};

import { Form, HasError, AlertError } from 'vform';

window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
	{
		path: '/dashboard',
		component: require('./components/super_admin/Dashboard.vue'),
	},
	{
		path: '/module',
		component: require('./components/super_admin/Module.vue'),
	},
];



const router = new VueRouter({
	mode: 'history',
	routes,
	linkActiveClass: 'active'
});

// Vue.component('module-form', require('./components/super_admin/Module.vue'));

const app = new Vue({
    el: '#vue_app',
    router
});
