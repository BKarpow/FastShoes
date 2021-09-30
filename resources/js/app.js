/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import '@popperjs/core';
import * as bootstrap from 'bootstrap';

require('./bootstrap');


window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('product-app', require('./components/ProductApp/Index.vue').default);
Vue.component('product-images', require('./components/ProductFull/ImagesSlider.vue').default);
Vue.component('product-order', require('./components/ProductFull/OrderApp.vue').default);  
Vue.component('prompt', require('./components/Prompt.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 window.tooltipList = [];

 window.setTooltips = () => {
   var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
   window.tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
     return new bootstrap.Tooltip(tooltipTriggerEl,  {trigger: 'hover'});
   })
 }

const app = new Vue({
    el: '#app',
});


/**
 * Tooltips from Bootstrap
 * 
 */


window.hideTooltips = () => {
  window.tooltipList.forEach(item => {
    item.hide();
  });
}

setTooltips();

 
