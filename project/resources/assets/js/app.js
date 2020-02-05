import VueSweetalert2 from 'vue-sweetalert2';

require('./bootstrap')
require('./commons')

window.Vue = require('vue')
require('@/components');

const app = new Vue({
  el: '#app',
})

Vue.use(VueSweetalert2);