/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import "@popperjs/core";
import * as bootstrap from "bootstrap";
import CKEditor from "@ckeditor/ckeditor5-vue2";

require("./bootstrap");

window.Vue = require("vue").default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "sections",
    require("./components/Home/Section/Index.vue").default
);
Vue.component(
    "categories-app",
    require("./components/Home/Category/Index.vue").default
);
Vue.component(
    "products-app",
    require("./components/Home/Product/Index.vue").default
);
Vue.component(
    "count-orders",
    require("./components/Home/CountNewOrders.vue").default
);

Vue.use(CKEditor);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});

/**
 * Tooltips from Bootstrap
 *
 */

// Todo tooltip settings
window.setTooltip = () => {
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, { trigger: "hover" });
    });
};

setTooltip();
