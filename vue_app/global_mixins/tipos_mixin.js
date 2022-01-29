export const tipos_mixin = {
  data(){
    return {
      tipos:[]
    }
  },
  created(){
    axios.get('api/app/gettipos').then(res =>{
      this.tipos = res.data
    }, res => {

    })
  }
}
