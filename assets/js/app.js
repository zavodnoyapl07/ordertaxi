
require('../css/app.css');

import Vue from 'vue';
import OrderForm from './components/OrderForm'
import VeeValidate from 'vee-validate'
import { ModalPlugin } from 'bootstrap-vue'

Vue.use(ModalPlugin)

Vue.use(VeeValidate, {
	events: '',
})

const app =  new Vue({
	el: '#app',
	render: h => h(OrderForm)
});
