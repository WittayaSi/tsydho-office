var app = new Vue({
  el: '#detailModal',
  data: {
    message: 'Hello Vue!'
  },
  created: ()=>{
  	console.log('created')
  	axios.get('/customer-api/get-all-cars').then((res)=>{
  		console.log(res.data)

  	}).catch()
  },
  methods: {
  	onClickAddEvent: () => {
  		console.log('onClickAddEvent')
  	}
  }
})