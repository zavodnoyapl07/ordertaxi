<template>
	<div class="order_form">
		<form>
			<div class="form-group">
				<label for="fullName">Your full name</label>
				<span class="form-error">{{ errors.first('clientName') }}</span>
				<input
						v-validate="{ required: true, min: 3, max: 100}"
						v-model="order.clientName"
						name="clientName"
						type="text"
						class="form-control"
						id="fullName"
						placeholder="Full Name"
				>
			</div>
			<div class="form-group">
				<label for="airflightNumber">Your phone number</label>
				<span class="form-error">{{ errors.first('phone') }}</span>
				<input
						v-validate="{ required: true, regex: /^(07\d{8,12}|447\d{7,11})$/ }"
						v-model="order.phone"
						name="phone"
						type="text"
						class="form-control"
						id="phone"
						placeholder="Phone number"
				>
			</div>
			<div class="form-group">
				<label for="airflightNumber">Your air flight Number</label>
				<span class="form-error">{{ errors.first('airflightNumber') }}</span>
				<input
						v-validate="{ required: true, regex: /^[a-z\d]{2}[a-z]?\d{1,4}[a-z]?$/i }"
						v-model="order.airflightNumber"
						name="airflightNumber"
						type="text"
						class="form-control"
						id="airflightNumber"
						placeholder="Full Air Flight Number"
				>
			</div>
			<div class="form-group">
				<label for="airport">Airport</label>
				<span class="form-error">{{ errors.first('airport') }}</span>
				<select
						v-validate="{ required: true }"
						v-model="order.airport"
						@change="changeAirport"
						name="airport"
						id="airport"
						class="form-control form-control-lg"
				>
					<option v-for="airport in airports" v-bind:key="airport.id" :value="airport.id">
						{{airport.name}}
					</option>
				</select>
			</div>
			<div class="form-group" v-if="terminals.length > 0">
				<label for="terminal">Terminal</label>
				<span class="form-error">{{ errors.first('terminal') }}</span>
				<select
						v-validate="{ required: true }"
						v-model="order.terminal"
						name="terminal"
						id="terminal"
						class="form-control form-control-lg"
				>
					<option v-for="terminal in terminals" v-bind:key="terminal.id" :value="terminal.id">
						{{terminal.name}}
					</option>
				</select>
			</div>

			<button @click="send" class="btn btn-primary">Submit</button>
		</form>
		<b-modal ref="result-modal" hide-footer :title="popupMessage.title">
			<div class="d-block text-center">
				<h3>{{popupMessage.message}}</h3>
			</div>
		</b-modal>
	</div>
</template>
<script>
	import axios from 'axios'

	export default {
		name: "OrderForm",
		data: () => {
			return {
				airports: [],
				terminals: [],
				order: {
					phone: null,
					clientName: null,
					airflightNumber: null,
					airport: null,
					terminal: null,
				},
				popupMessage: {
					title: '',
					message: '',
				}
			}
		},
		mounted: function () {
			axios.get('/api/airports').then(res => {
				this.airports = res.data
			})
		},

		methods: {
			changeAirport: function(e) {
				this.order.terminal = null
				this.terminals = []
				for (let airport of this.airports) {
					if (parseInt(airport.id) === parseInt(e.target.value)) {
						this.terminals = airport.terminals
						break;
					}
				}
			},
			send: function (e) {
				e.preventDefault()
				this.$validator.validate().then(result => {
					if (!result) {
						return
					}
					axios.post('/api/send_order', JSON.stringify(this.order)).then((res) => {
						if (res.data.success) {
							this.popupMessage.title = 'Success'
							this.popupMessage.message = `Your order id #${res.data.data.id}`
						} else {
							this.popupMessage.title = 'Failure'
							this.popupMessage.message = `Something wrong`
						}
						this.$refs['result-modal'].show()
					})
				})
			}
		}
	}
</script>
<style scoped>
</style>