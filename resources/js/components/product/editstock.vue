<template>
   <div>
   <div class="p-3">
    
    <router-link to="/Stock"  class="mb-3 btn btn-outline-primary">View Stock</router-link>
        </div>
   <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Update Stock</h1>
                  </div>
                  <form @submit.prevent="update" enctype="multipart/form-data">
                    <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-12">
                     <label>Category Name</label>
                      <input type="text" class="form-control" id="qty"  v-model="form.qty">
                       <small class="text-danger" v-if="errors.qty" >{{ errors.qty[0] }}</small>
                    </div>
                    
                    </div>
                      
                    </div>
                
                
                      
                   
                    
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                   
                  </form>
                 
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   </div>
</template>
<script>
import index from './index.vue'
  
  export default {
  components: { index },
   created()
    {
      if(!User.loggedIn())
      {
        this.$router.push({name: '/'}) 
      }
      else
      {

      }
      this.id =  this.$route.params.product_id
       axios.get('/api/product/'+this.id)
       .then(response=>{
            this.form = response.data;
        
       })
       .catch(error=>{

       })
    },
data(){
    return {
        form:{
            qty:null,
        },
        id:null,
        errors:{},
        info:null
    }
  },
methods:{
    
    
      update()
      {
        axios.post('/api/stockupdate/'+this.id,this.form)
        .then(resp=>{
        
        Notification.success();
          this.$router.push({name: 'Stock'})
        })
        .catch(error=>{
          this.errors = error.response.data.errors;
         Notification.warning();
        })
      }

  }
}
</script>
<style>

</style>