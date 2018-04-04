/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueSelect from "vue-select"
import Ckeditor from "vue-ckeditor2"


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component("select-prerequisites", require("./components/SelectPrerequisite"))
Vue.component("lesson-edit-form", require("./components/LessonEditForm"))
Vue.component("vue-select", VueSelect)
Vue.component("user-form", require("./components/UserForm"));
Vue.component("order-list", require("./components/OrderList"));
Vue.component("ckeditor", Ckeditor);
Vue.component("mc-form", require("./components/McForm"));
Vue.component("fill-in-blank-form", require("./components/FillInBlankForm"));
Vue.component("table-actions", require("./components/TableActions"));
Vue.component("timer", require("./components/Timer"));
Vue.component("test", require("./components/Frontend/Test/Test"));

const lms = new Vue({
                      el: '#app'
                    });
