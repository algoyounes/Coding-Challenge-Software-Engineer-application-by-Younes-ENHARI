/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Router from 'vue-router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'




Vue.use(Router)
// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)


const routes = [
    { path: '/category', name: 'category_list', component: require('./components/Category/ListComponent.vue').default },
    { path: '/category/add', name: 'product_add', component: require('./components/category/FormComponent.vue').default },
    { path: '/category/edit/:id', name: 'product_edit', component: require('./components/category/FormComponent.vue').default, props: true },
]

const router = new Router({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router
});
