/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.config.devtools = true;
// Vue.config.debug = true;
// Vue.config.productionTip = true;
// Vue.config.silent = false;

Vue.component('add-sale-component', require('./components/SaleAddComponent.vue').default);
Vue.component('chart-bar-component', require('./components/ChartBarComponent.vue').default);
Vue.component('chart-line-component', require('./components/ChartLineComponent.vue').default);
Vue.component('chart', require('./Chart.vue').default);

Vue.component('barcodes', require('./Barcodes.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// console.log('Hello');
const app = new Vue({
    el: '#app',
});
