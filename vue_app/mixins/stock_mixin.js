export const stock_mixin = {
  data(){
    return {
      stocks: [],
    }
  },
  created(){
    axios.get('api/getstocks').then(res =>{
      this.stocks = res.data
    }, res => {

    })
  }
}
