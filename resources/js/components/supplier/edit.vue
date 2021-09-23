<template>
   <div>
   <div class="p-3">
    
    <router-link to="/All-Supplier"  class="mb-3 btn btn-outline-success">View Supplier</router-link>
        </div>
   <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Edit Supplier</h1>
                  </div>
                  <form @submit.prevent="update" enctype="multipart/form-data">
                    <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-6">
                     <label> Name</label>
                      <input type="text" class="form-control" id="name" placeholder="Enter Your Name" v-model="form.name">
                       <small class="text-danger" v-if="errors.name" >{{ errors.name[0] }}</small>
                    </div>
                    <div class="col-md-6">
                     <label> Email</label>
                      <input type="text" class="form-control" id="email" placeholder="Enter Your Email" v-model="form.email">
                       <small class="text-danger" v-if="errors.email" >{{ errors.email[0] }}</small>
                    </div>
                    </div>
                      
                    </div>
     <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-6">
                     <label> Shop Name</label>
                      <input type="text" class="form-control" id="shop_name" placeholder="Enter Shop Name" v-model="form.shop_name">
                       <small class="text-danger" v-if="errors.shop_name" >{{ errors.shop_name[0] }}</small>
                    </div>
                    <div class="col-md-6">
                     <label> Phone</label>
                      <input type="number" class="form-control" id="phone" placeholder="Enter Your Phone No" v-model="form.phone">
                       <small class="text-danger" v-if="errors.phone" >{{ errors.phone[0] }}</small>
                    </div>
                    </div>
                      
                    </div>
                 
                  <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-6">
                     <label> Address</label>
                      <input type="text" class="form-control" id="address" placeholder="Enter Your Address" v-model="form.address">
                       <small class="text-danger" v-if="errors.address" >{{ errors.address[0] }}</small>
                    </div>
                    </div>
                  </div>
                    <div class="form-group">
                    <div class="form-row">
                    <div class="col-md-6">
                   
                      <input type="file" class="custom-file-input" @change="onChange" accept="image/*">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                       <small class="text-danger" v-if="errors.photo" >{{ errors.photo[0] }}</small>
                    </div>
                    <div class="col-md-6">
                    <img :src="form.newimage" style="height: 50px; width: 50px" />
                    </div>
                    </div>
                      
                    </div>
                   
                    
                    <div class="form-group">
                    <input type="hidden" v-model="form.id" />
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
      this.id =  this.$route.params.supplier_id
       axios.get('/api/supplier/'+this.id)
       .then(response=>{
            this.form = response.data;
            
            
       })
       .catch(error=>{

       })
    },
data(){
    return {
        form:{
            email:null,
            name:null,
            shop_name:null,
            photo:null,
            phone:null,
            address:null,
            newimage:null,
            id:null
 
            
        },
        id:null,
        errors:{},
        info:null
    }
  },
methods:{
    onChange(e) {
      const image = e.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e =>{
                    this.form.newimage = e.target.result;
                    console.log(this.form.newimage);
                };
    },
      update()
      {
        axios.patch('/api/supplier/'+this.id,this.form)
        .then(resp=>{
        
        Notification.success();
          this.$router.push({name: 'All-Supplier'})
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