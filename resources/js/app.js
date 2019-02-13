
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from 'vue';

// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(Loading);
const app = new Vue({
    el: '#app',
    data: function () {
        return {
            ordersList: [],
            fecha_init:'',
            fecha_end:''
        }
    },
    methods: {
        cargarOrdenes() {
            event.preventDefault();
            var app = this;
            let loader = app.$loading.show({
                // Optional parameters
                container: app.fullPage ? null : app.$refs.formContainer,
                canCancel: true,
                onCancel: app.onCancel,
            });
            axios.get('http://127.0.0.1:8000/api/orders/?fecha_init='+app.fecha_init+'&fecha_end='+app.fecha_end+'')
                  .then(function (resp) {
                      app.ordersList = resp.data;
                      loader.hide()
                  })
                  .catch(function (resp) {
                      alert("Could not delete company");
                      loader.hide()
                  });
              
        }
    }
});
