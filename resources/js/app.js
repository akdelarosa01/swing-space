require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
	{
		path: '/admin/dashboard',
		component: require('./components/super_admin/Dashboard.vue'),
	},
	{
		path: '/admin/modulle',
		component: require('./components/super_admin/Module.vue'),
	},
];

const router = new VueRouter({
	routes
});

// Vue.component('module-form', require('./components/super_admin/Module.vue'));

const app = new Vue({
    el: '#vue_app',
    router
});
